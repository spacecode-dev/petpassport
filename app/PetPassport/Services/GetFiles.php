<?php

namespace App\PetPassport\Services;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait GetFiles
{
    use FileFunctions;

    /**
     * Cloud disks.
     *
     * @var array
     */
    protected $cloudDisks = [
        's3', 'google', 's3-cached',
    ];

    /**
     * @param $folder
     * @param $order
     * @param bool $filter
     * @return mixed
     * @throws Exception
     */
    public function getFiles($folder, $order, $filter = false)
    {
        $filesData = $this->storage->listContents($folder);
        $filesData = $this->normalizeFiles($filesData);
        $files = [];
        $cacheTime = config('petpassport.filemanager.cache', false);
        foreach ($filesData as $file) {
            if(!Str::startsWith($file['basename'], 'temp_')) {
                $id = $this->generateId($file);
                if ($cacheTime) {
                    $fileData = cache()->remember($id, $cacheTime, function () use ($file, $id) {
                        return $this->getFileData($file, $id);
                    });
                } else {
                    $fileData = $this->getFileData($file, $id);
                }
                $files[] = $fileData;
            }
        }
        $files = collect($files);
        if ($filter != false) {
            $files = $this->filterData($files, $filter);
        }
        return $this->orderData($files, $order, config('petpassport.filemanager.direction', 'asc'));
    }

    /**
     * @param $file
     * @param $id
     * @return bool|object
     */
    public function getFileData($file, $id)
    {
        if (!$this->isDot($file) && !$this->exceptExtensions->contains($file['extension']) && !$this->exceptFolders->contains($file['basename']) && !$this->exceptFiles->contains($file['basename']) && $this->accept($file)) {
            $fileInfo = [
                'id' => $id,
                'name' => trim($file['basename']),
                'path' => $this->cleanSlashes($file['path']),
                'type' => $file['type'],
                'mime' => $this->getFileType($file),
                'ext' => (isset($file['extension'])) ? $file['extension'] : false,
                'size' => ($file['size'] != 0) ? $file['size'] : 0,
                'size_human' => ($file['size'] != 0) ? $this->formatBytes($file['size'], 0) : 0,
                'thumb' => $this->getThumbFile($file),
                'asset' => $this->cleanSlashes($this->storage->url($file['path'])),
                'can' => true,
                'loading' => false,
            ];

            if (isset($file['timestamp'])) {
                $fileInfo['last_modification'] = $file['timestamp'];
                $fileInfo['date'] = $this->modificationDate($file['timestamp']);
            }
            if ($fileInfo['mime'] == 'image') {
                [$width, $height] = $this->getImageDimesions($file);
                if (!$width == false) {
                    $fileInfo['dimensions'] = $width . 'x' . $height;
                }
            }
            if ($fileInfo['type'] == 'dir') {
                if (!$this->checkShouldHideFolder($fileInfo['path'])) {
                    return false;
                }
            }
            return (object)$fileInfo;
        }
    }

    /**
     * Filter data by custom type.
     *
     * @param $files
     * @param $filter
     *
     * @return mixed
     */
    public function filterData($files, $filter)
    {
        $folders = $files->where('type', 'dir');
        $items = $files->where('type', 'file');
        $filters = config('petpassport.filemanager.filters', []);
        if (count($filters) > 0) {
            $filters = array_change_key_case($filters);
            if (isset($filters[$filter])) {
                $filteredExtensions = $filters[$filter];
                $filtered = $items->filter(function ($item) use ($filteredExtensions) {
                    if (in_array($item->ext, $filteredExtensions)) {
                        return $item;
                    }
                });
            }
        }
        return $folders->merge($filtered);
    }

    /**
     * Order files and folders.
     * @param $files
     * @param $order
     * @param string $direction
     * @return mixed
     */
    public function orderData($files, $order, $direction = 'asc')
    {
        $folders = $files->where('type', 'dir');
        $items = $files->where('type', 'file');
        if ($order == 'size') {
            $folders = $folders->sortByDesc($order);
            $items = $items->sortByDesc($order);
        } else {
            if ($direction == 'asc') {
                $folders = $folders->sortBy('name')->sortBy(function ($item) use ($order) {
                    return mb_strtolower($item->{$order});
                })->values();
                $items = $items->sortBy('name')->sortBy(function ($item) use ($order) {
                    return mb_strtolower($item->{$order});
                })->values();
            } else {
                $folders = $folders->sortByDesc(function ($item) use ($order) {
                    return mb_strtolower($item->{$order});
                })->values();
                $items = $items->sortByDesc(function ($item) use ($order) {
                    return mb_strtolower($item->{$order});
                })->values();
            }
        }
        return $folders->merge($items);
    }

    /**
     * Generates an id based on file.
     * @param array $file
     * @return  string
     */
    public function generateId($file)
    {
        if (isset($file['timestamp'])) {
            return md5($this->disk . '_' . trim($file['basename']) . $file['timestamp']);
        }
        return md5($this->disk . '_' . trim($file['basename']));
    }

    /**
     * Set Relative Path.
     * @param $folder
     */
    public function setRelativePath($folder)
    {
        $defaultPath = $this->storage->getDriver()->getAdapter()->getPathPrefix();
        $publicPath = str_replace($defaultPath, '', $folder);
        if ($folder !== '/') {
            $this->currentPath = $this->getAppend() . '/' . $publicPath;
        } else {
            $this->currentPath = $this->getAppend() . $publicPath;
        }
    }

    /**
     * Get Append to url.
     * @return mixed|string
     */
    public function getAppend()
    {
        if (in_array(config('petpassport.filemanager.disk'), $this->cloudDisks)) {
            return '';
        }
        return '/storage';
    }

    /**
     * @param $file
     * @return bool|string
     */
    public function getFileType($file)
    {
        if ($file['type'] == 'dir') {
            return 'dir';
        }
        $mime = $this->storage->getMimetype($file['path']);
        $extension = $file['extension'];
        if (Str::contains($mime, 'directory')) {
            return 'dir';
        }
        if (Str::contains($mime, 'image') || $extension == 'svg') {
            return 'image';
        }
        if (Str::contains($mime, 'pdf')) {
            return 'pdf';
        }
        if (Str::contains($mime, 'audio')) {
            return 'audio';
        }
        if (Str::contains($mime, 'video')) {
            return 'video';
        }
        if (Str::contains($mime, 'zip')) {
            return 'file';
        }
        if (Str::contains($mime, 'rar')) {
            return 'file';
        }
        if (Str::contains($mime, 'octet-stream')) {
            return 'file';
        }
        if (Str::contains($mime, 'excel')) {
            return 'text';
        }
        if (Str::contains($mime, 'word')) {
            return 'text';
        }
        if (Str::contains($mime, 'css')) {
            return 'text';
        }
        if (Str::contains($mime, 'javascript')) {
            return 'text';
        }
        if (Str::contains($mime, 'plain')) {
            return 'text';
        }
        if (Str::contains($mime, 'rtf')) {
            return 'text';
        }
        if (Str::contains($mime, 'text')) {
            return 'text';
        }
        return false;
    }

    /**
     * Return the Type of file.
     * @param $file
     * @param bool $folder
     * @return bool|string
     */
    public function getThumb($file, $folder = false)
    {
        if ($file['type'] === 'dir') {
            return false;
        }
        $mime = $this->storage->getMimetype($file['path']);
        $extension = $file['extension'];
        if (Str::contains($mime, 'directory')) {
            return false;
        }
        if (Str::contains($mime, 'image') || $extension === 'svg') {
            if (method_exists($this->storage, 'put')) {
                return $this->storage->url($file['path']);
            }
            return $folder . '/' . $file['basename'];
        }
        $fileType = new FileTypesImages();
        return $fileType->getImage($mime);
    }

    /**
     * Get image dimensions for files.
     * @param $file
     * @return array|bool|false
     */
    public function getImageDimesions($file)
    {
        if ($this->disk == 'public') {
            return getimagesize($this->storage->path($file['path']));
        }
        if (in_array(config('petpassport.filemanager.disk'), $this->cloudDisks)) {
            return false;
        }
        return false;
    }

//    /**
//     * Get image dimensions from cloud.
//     * @param $file
//     * @return array|bool
//     */
//    public function getImageDimesionsFromCloud($file)
//    {
//        try {
//            $client = new Client();
//            $response = $client->get($this->storage->url($file['path']), ['stream' => true]);
//            $image = imagecreatefromstring($response->getBody()->getContents());
//            $dims = [imagesx($image), imagesy($image)];
//            imagedestroy($image);
//            return $dims;
//        } catch (Exception $e) {
//            return false;
//        }
//    }

    /**
     * @param $file
     * @return mixed
     */
    public function getThumbFile($file)
    {
        return $this->cleanSlashes($this->getThumb($file, $this->currentPath));
    }

    /**
     * @param $files
     * @return mixed
     */
    public function normalizeFiles($files)
    {
        foreach ($files as $key => $file) {
            if (!isset($file['extension'])) {
                $files[$key]['extension'] = null;
            }
            if (!isset($file['size'])) {
                $files[$key]['size'] = null;
            }
        }
        return $files;
    }

    /**
     * @param $file
     * @return bool
     */
    public function accept($file)
    {
        return '.' !== substr($file['basename'], 0, 1);
    }

    /**
     * Check if file is Dot.
     * @param string $file
     * @return  bool
     */
    public function isDot($file)
    {
        if (Str::startsWith($file['basename'], '.')) {
            return true;
        }
        return false;
    }

    /**
     * @param $folder
     * @return array
     */
    public function generateParent($folder)
    {
        $paths = collect(explode('/', $folder))->filter();
        $paths->pop();
        if ($paths) {
            $folderPath = $paths->implode('/');
            if ($folderPath == $folder || strlen($folderPath) === 0) {
                $folderPath = '/';
            }
            return [
                'id' => 'folder_back',
                'name' => 'Наверх',
                'path' => $this->cleanSlashes($folderPath),
                'type' => 'dir',
                'mime' => 'dir',
                'ext' => false,
                'size' => 0,
                'size_human' => 0,
                'thumb' => '',
                'asset' => $this->cleanSlashes($this->storage->url($folderPath)),
                'can' => true,
                'loading' => false,
                'last_modification' => false,
                'date' => false,
            ];
        }
    }

    /**
     * @param $currentFolder
     * @return Collection
     */
    public function getPaths($currentFolder)
    {
        $defaultPath = $this->cleanSlashes($this->storage->getDriver()->getAdapter()->getPathPrefix());
        $currentPath = $this->cleanSlashes($this->storage->path($currentFolder));
        $paths = $currentPath;
        if ($defaultPath !== '/') {
            $paths = str_replace($defaultPath, '', $currentPath);
        }
        $paths = collect(explode('/', $paths))->filter();
        $goodPaths = collect([]);
        foreach ($paths as $path) {
            $goodPaths->push(['name' => $path, 'path' => $this->recursivePaths($path, $paths)]);
        }
        return $goodPaths->reverse();
    }

    /**
     * @param $name
     * @param $pathCollection
     * @return string
     */
    public function recursivePaths($name, $pathCollection)
    {
        return Str::before($pathCollection->implode('/'), $name) . $name;
    }

    /**
     * @param $time
     * @return bool|string
     */
    public function modificationDate($time)
    {
        try {
            return Carbon::createFromTimestamp($time)->format('Y-m-d H:i:s');
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Hide folders with .hide file.
     * @param $path
     * @return bool
     */
    private function checkShouldHideFolder($path)
    {
        $filesData = $this->storage->listContents($path);
        $key = array_search('.hide', array_column($filesData, 'basename'));
        if ($key === false) {
            return true;
        }
        return false;
    }
}
