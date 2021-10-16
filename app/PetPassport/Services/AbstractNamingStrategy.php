<?php

namespace App\PetPassport\Services;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;

abstract class AbstractNamingStrategy
{
    /**
     * @var Filesystem
     */
    protected $storage;

    /**
     * AbstractNamingStrategy constructor.
     * @param $storage
     */
    public function __construct(Filesystem $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param string $currentFolder
     * @param UploadedFile $file
     * @return string
     */
    abstract public function name(string $currentFolder, UploadedFile $file): string;
}
