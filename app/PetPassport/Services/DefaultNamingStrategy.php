<?php

namespace App\PetPassport\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class DefaultNamingStrategy extends AbstractNamingStrategy
{
    /**
     * @param string $currentFolder
     * @param UploadedFile $file
     * @return string
     */
    public function name(string $currentFolder, UploadedFile $file): string
    {
        $filename = $file->getClientOriginalName();
        while ($this->storage->has($currentFolder . '/' . $filename)) {
            $filename = sprintf(
                '%s_%s.%s',
                pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                Str::random(7),
                $file->getClientOriginalExtension()
            );
        }
        return $filename;
    }

    /**
     * @param string $currentFolder
     * @param UploadedFile $file
     * @param string $res
     * @return string
     */
    public function tmpName(string $currentFolder, UploadedFile $file, $res): string
    {
        $filename = $file->getClientOriginalName();
        while ($this->storage->has($currentFolder . '/' . $filename)) {
            $filename = sprintf(
                '%s_%s.%s',
                pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                $res,
                $file->getClientOriginalExtension()
            );
        }
        return $filename;
    }
}
