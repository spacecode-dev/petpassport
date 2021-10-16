<?php

namespace App\PetPassport\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\PetPassport\Services\FileManagerService;

class FilemanagerController extends Controller
{
    /**
     * @var mixed
     */
    protected $service;

    /**
     * @param FileManagerService $filemanagerService
     */
    public function __construct(FileManagerService $filemanagerService)
    {
        $this->service = $filemanagerService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function getData(Request $request)
    {
        return $this->service->ajaxGetFilesAndFolders($request);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createFolder(Request $request)
    {
        return $this->service->createFolderOnPath($request);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteFolder(Request $request)
    {
        return $this->service->deleteDirectory($request);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function upload(Request $request)
    {
        $uploadingFolder = $request->folder ?? false;
        return $this->service->uploadFile(
            $request->file,
            $request->current ?? '',
            $request->get('visibility'),
            $uploadingFolder,
            $request->get('rules') ? $this->getRules($request->get('rules')) : []
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function move(Request $request)
    {
        return $this->service->moveFile($request->old, $request->path);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getInfo(Request $request)
    {
        return $this->service->getFileInfo($request->file);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function removeFile(Request $request)
    {
        return $this->service->removeFile($request);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function renameFile(Request $request)
    {
        return $this->service->renameFile($request->get('file'), $request->get('name'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function rename(Request $request)
    {
        return $this->service->renameFile($request->get('path'), $request->get('name'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function folderUploadedEvent(Request $request)
    {
        return $this->service->folderUploadedEvent($request->path);
    }

//    /**
//     * @param $attribute
//     * @param NovaRequest $request
//     * @return bool
//     */
//    private function getFilemanagerFieldFilter($attribute, NovaRequest $request)
//    {
//        $fields = $request->newResource()->fields($request);
//        foreach ($fields as $field) {
//            if (isset($field->attribute) && $field->attribute == $attribute) {
//                if (isset($field->meta['filterBy'])) {
//                    return $field->meta['filterBy'];
//                }
//            }
//        }
//        return false;
//    }

    /**
     * Get rules in array way.
     * @param   string  $rules
     * @return  array
     */
    private function getRules($rules)
    {
        return json_decode($rules);
    }
}
