<?php

namespace App\PetPassport\Services;

use App\PetPassport\Models\Media\Photo;
use App\PetPassport\Models\User\User;
use Exception;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\PetPassport\Exceptions\FileRemoved;
use App\PetPassport\Exceptions\FileUploaded;
use App\PetPassport\Exceptions\FolderRemoved;
use App\PetPassport\Exceptions\FolderUploaded;
use App\PetPassport\Exceptions\InvalidConfig;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use InvalidArgumentException;
use League\Flysystem\FileNotFoundException;
use Validator;

class FileManagerService
{
    use GetFiles;

    /**
     * @var mixed
     */
    protected $storage;

    /**
     * @var mixed
     */
    protected $disk;

    /**
     * @var mixed
     */
    protected $currentPath;

    /**
     * @var mixed
     */
    protected $exceptFiles;

    /**
     * @var mixed
     */
    protected $exceptFolders;

    /**
     * @var mixed
     */
    protected $exceptExtensions;

    /**
     * @var AbstractNamingStrategy
     */
    protected $namingStrategy;

    /**
     * FileManagerService constructor.
     * @param Request $request
     * @throws InvalidConfig
     */
    public function __construct(Request $request)
    {
        $this->disk = config('petpassport.filemanager.disk');
        $this->exceptFiles = collect([]);
        $this->exceptFolders = collect([]);
        $this->exceptExtensions = collect([]);
        $this->globalFilter = null;
        try {
            $this->storage = Storage::disk($this->disk);
            $user = User::where('id', $request->get('userId'))->first();
            $this->storage = !$user ? Storage::disk($this->disk) : $user->getStorageInstance();
        } catch (InvalidArgumentException $e) {
            throw InvalidConfig::driverNotSupported();
        }
        $this->namingStrategy = app()->makeWith(
            DefaultNamingStrategy::class,
            ['storage' => $this->storage]
        );
    }

    /**
     * Get ajax request to load files and folders.
     * @param Request $request
     * @param bool $filter
     * @return JsonResponse
     * @throws Exception
     */
    public function ajaxGetFilesAndFolders(Request $request, $filter = false)
    {
        $userId = $request->get('userId');
        if (!$request->has('userId') || empty($userId)) {
            return response()->json(['errors' => 'Не удалось получить папки.'], 422);
        }
        $folder = $request->get('folder');
        $folder = $this->cleanSlashes($folder);
        $this->setRelativePath($folder);
        $order = $request->get('sort');
        if (!$order) {
            $order = config('petpassport.filemanager.order', 'mime');
        }
        $defaultFilter = config('petpassport.filemanager.filter', false);
        if ($filter != false) {
            $defaultFilter = $filter;
        }
        $files = $this->getFiles($folder, $order, $defaultFilter);
        $filters = $this->getAvailableFilters($files);
        $parent = (object)[];

        if ($files->count() > 0) {
            $folders = $files->filter(function ($file) {
                return $file->type == 'dir';
            });
            if ($folder !== '/') {
                $parent = $this->generateParent($folder);
            }
        }
        return response()->json([
            'files' => $files,
            'path' => $this->getPaths($folder),
            'filters' => $filters,
            'buttons' => $this->getButtons(),
            'parent' => $parent,
        ]);
    }

    /**
     *  Create a folder on current path.
     * @param Request $request
     * @return JsonResponse
     */
    public function createFolderOnPath($request)
    {
        $folder = $this->fixDirname($this->fixFilename($request->input('folder')));
        $path = "{$request->get('current')}/{$folder}";
        if ($this->storage->has($path)) {
            return response()->json(['errors' => 'Эта папка уже существует.'], 422);
        }
        $val = Validator::make(
            [
                'folder' => $folder,
            ],
            [
                'folder' => 'required|min:3|max:20'
            ],
            [
                'folder.required' => 'Поле название папки обязательно для заполнения.',
                'folder.min' => 'Название папки должно содержать не менее 3 символов.',
                'folder.max' => 'Название папки не может быть длиннее 20 символов.'
            ]
        );
        if ($val->fails()) {
            return response()->json(['errors' => $val->messages()->toArray()['folder'][0]], 422);
        }

        if ($this->storage->makeDirectory($path)) {
            return response()->json(['message' => 'Задача выполнена успешно.'], 200);
        } else {
            return response()->json(['errors' => 'Не удалось создать папку.'], 422);
        }
    }

    /**
     * Removes a directory.
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteDirectory($request)
    {
        $path = $request->get('current');
        if ($this->storage->deleteDirectory($path)) {
            //TODO Remove Photos
            //TODO Remove Videos
            event(new FolderRemoved($this->storage, $path));
            return response()->json(['message' => 'Задача выполнена успешно.'], 200);
        } else {
            return response()->json(['errors' => 'Не удалось удалить папку.'], 422);
        }
    }

    /**
     * Upload a file on current folder.
     * @param $file
     * @param $currentFolder
     * @param $visibility
     * @param bool $uploadingFolder
     * @param array $rules
     * @return JsonResponse
     */
    public function uploadFile($file, $currentFolder, $visibility, $uploadingFolder = false, array $rules = [])
    {
        $config = config('petpassport.filemanager.limits');

        // Extension
        $extension = pathinfo($file->getClientOriginalName())['extension'];
        foreach ($config['files'] as $type => $value) {
            if(in_array($extension, $value['extensions'])) {
                $fileType = $type;
            }
        }
        if(!isset($fileType)) {
            return response()->json(['errors' => 'Загрузка не удалась. Файлы с таким расширением загружать запрещено.'], 422);
        }

        // Size
        $maxSize = intval($config['files'][$fileType]['maxSize']);
        $size = intval(ceil($file->getClientSize() / 1024));
        if($size > $maxSize) {
            return response()->json(['errors' => 'Загрузка не удалась. Превышен лимит загружаемого файла. Максимально допустимый размер - ' . $this->formatBytes($maxSize, 1)], 422);
        }

        // Resolution
        $height = Image::make($file)->height();
        $maxHeight = $config['files'][$fileType]['resolution']['maxHeight'];
        if($height > $maxHeight) {
            return response()->json(['errors' => 'Загрузка не удалась. Превышена лимит загружаемого файла. Максимально допустимая высота - ' . $maxHeight . 'px'], 422);
        }
        $width = Image::make($file)->width();
        $maxWidth = $config['files'][$fileType]['resolution']['maxWidth'];
        if($width > $maxWidth) {
            return response()->json(['errors' => 'Загрузка не удалась. Превышена лимит загружаемого файла. Максимально допустимая ширина - ' . $maxWidth . 'px'], 422);
        }

        // Upload
        $fileName = $this->namingStrategy->name($currentFolder, $file);
        $newFile = $this->storage->putFileAs($currentFolder, $file, $fileName);
        if ($newFile) {
            $this->setVisibility($currentFolder, $fileName, $visibility);
            //TODO JOB
//            if (!$uploadingFolder) {
//                $this->checkJobs($this->storage, $currentFolder . $fileName);
//                event(new FileUploaded($this->storage, $currentFolder . $fileName));
//            }

            // Distribution
            $user = request()->user();
            if($fileType === 'image') {
                $photo = new Photo();
                $photo->section = 1;
                $photo->owner_id = $user->id;
                $photo->owner_type = 'profile';

                $tmpName = Str::random(32);
                $fold = $this->cleanSlashes($currentFolder) === '//' ? '/' : '/' . $this->cleanSlashes($currentFolder);
                foreach (['180', '360', '720', '1440', '2880'] as $res) {
                    $storagePath = "/users/user-{$user->id}{$fold}temp_{$tmpName}_{$res}.{$extension}";
                    Image::make($file)->resize(intval($res), null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(storage_path("app/public{$storagePath}"));
                    $photo->{'thumb_' . $res} = "/storage{$storagePath}";
                }
                $photo->original = "/storage/users/user-{$user->id}{$fold}{$fileName}";
                $photo->original_width = $width;
                $photo->original_height = $height;
                $photo->save();
            }
            //TODO fileType video

            return response()->json(['name' => $fileName], 200);
        } else {
            return response()->json(['errors' => 'Загрузка не удалась.'], 422);
        }
    }

    /**
     * Get info of file normalized.
     * @param $file
     * @return JsonResponse
     */
    public function getFileInfo($file)
    {
        $fullPath = $this->storage->path($file);
        try {
            $info = new NormalizeFile($this->storage, $fullPath, $file);
            return response()->json($info->toArray(), 200);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 404);
        }
    }

    /**
     * Get info of file as Array.
     * @param $file
     * @return JsonResponse|array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws FileNotFoundException
     */
    public function getFileInfoAsArray($file)
    {
        if (!$this->storage->exists($file)) {
            return [];
        }
        $fullPath = $this->storage->path($file);
        $info = new NormalizeFile($this->storage, $fullPath, $file);
        return $info->toArray();
    }

    /**
     * Remove a file from storage.
     * @param Request $request
     * @return  JsonResponse
     */
    public function removeFile($request)
    {
        $file = $request->get('file');
        if ($this->storage->delete($file)) {
            event(new FileRemoved($this->storage, $file));
            //TODO remove Photo
            //TODO remove Video
            return response()->json(['message' => 'Задача выполнена успешно.'], 200);
        } else {
            return response()->json(['errors' => 'Не удалось удалить файл.'], 422);
        }
    }

    /**
     * @param $file
     * @param $newName
     * @return JsonResponse
     */
    public function renameFile($file, $newName)
    {
        //TODO Rename Photo
        //TODO Rename Video
        $path = str_replace(basename($file), '', $file);
        if(basename($file) === $newName) {
            return response()->json(['errors' => 'Существующий файл и файл переименования имеют одинаковые название.'], 422);
        }
        if ($this->storage->has($path . $newName)) {
            return response()->json(['errors' => 'Этот файл уже существует.'], 422);
        }
        try {
            if ($this->storage->move($file, $path . $newName)) {
                return response()->json(['message' => 'Задача выполнена успешно.'], 200);
            } else {
                return response()->json(['errors' => 'Не удалось переименовать файл.'], 422);
            }
        } catch (Exception $e) {
            return response()->json(['errors' => 'Не удалось переименовать файл.'], 422);
        }
    }

//    /**
//     * Move file.
//     *
//     * @param string $oldPath
//     * @param string $newPath
//     * @return JsonResponse
//     */
//    public function moveFile($oldPath, $newPath)
//    {
//        if ($this->storage->move($oldPath, $newPath)) {
//            return response()->json(['success' => true]);
//        }
//        return response()->json(false);
//    }

//    /**
//     * Folder uploaded event.
//     *
//     * @param string $path
//     *
//     * @return JsonResponse
//     */
//    public function folderUploadedEvent($path)
//    {
//        event(new FolderUploaded($this->storage, $path));
//        return response()->json(['success' => true]);
//    }

//    /**
//     * @param $folder
//     * @return bool
//     */
//    private function folderExists($folder)
//    {
//        $directories = $this->storage->directories(dirname($folder));
//        $directories = collect($directories)->map(function ($folder) {
//            return basename($folder);
//        });
//        return in_array(basename($folder), $directories->toArray());
//    }

    /**
     * Set visibility to public.
     *
     * @param $folder
     * @param $file
     * @param $visibility
     */
    private function setVisibility($folder, $file, $visibility)
    {
        if ($folder != '/') {
            $folder .= '/';
        }
        $this->storage->setVisibility($folder . $file, $visibility);
    }

    /**
     * @param $files
     * @return array
     */
    private function getAvailableFilters($files)
    {
        $filters = config('petpassport.filemanager.filters', []);
        if (count($filters) > 0) {
            return collect($filters)->filter(function ($extensions) use ($files) {
                foreach ($files as $file) {
                    if (in_array($file->ext, $extensions)) {
                        return true;
                    }
                }
                return false;
            })->toArray();
        }
        return [];
    }

    private function getButtons()
    {
        return config('petpassport.filemanager.buttons', [
            'create_folder' => true,
            'upload_button' => true,
            'select_multiple' => true,
            'upload_drag' => true,
            'rename_folder' => true,
            'delete_folder' => true,
            'rename_file' => true,
            'delete_file' => true,
        ]);
    }

    /**
     * @param $storage
     * @param $filePath
     */
    private function checkJobs($storage, $filePath)
    {
        $ext = pathinfo($filePath, PATHINFO_EXTENSION);
        $availableJobs = collect(config('petpassport.filemanager.jobs', []));
        if (count($availableJobs)) {
            $filters = config('petpassport.filemanager.filters', []);
            $filters = array_change_key_case($filters);
            $find = collect($filters)->filter(function ($extensions, $key) use ($ext) {
                if (in_array($ext, $extensions)) {
                    return true;
                }
            });
            $filterFind = array_key_first($find->toArray());
            if ($jobClass = $availableJobs->get($filterFind)) {
                $job = new $jobClass($storage, $filePath);
                if ($customQueue = config('petpassport.filemanager.queue_name')) {
                    $job->onQueue($customQueue);
                }
                app(Dispatcher::class)->dispatch($job);
            }
        }
    }
}
