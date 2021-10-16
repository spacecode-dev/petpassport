<?php

namespace App\PetPassport\Exceptions;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Queue\SerializesModels;

class FolderUploaded
{
    use SerializesModels;

    /**
     * @var mixed
     */
    public $storage;

    /**
     * @var mixed
     */
    public $folderPath;

    /**
     * Create a new event instance.
     *
     * @param FilesystemAdapter $storage
     * @param string $folderPath
     */
    public function __construct(FilesystemAdapter $storage, string $folderPath)
    {
        $this->storage = $storage;
        $this->folderPath = $folderPath;
    }
}
