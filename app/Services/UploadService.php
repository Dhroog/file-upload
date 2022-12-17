<?php


namespace App\Services;


use App\Entry\File;
use App\Interface\UploadServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadService implements UploadServiceInterface
{
    public function file(UploadedFile $file): File
    {
        $name = $file->hashName();

        //$path = Storage::putFile("public/Files/{$name}", $file,'public');
        $path = Storage::putFile("public/Files/{$name}", $file,'public');

        return new File(
            name: "{$name}",
            originalName: $file->getClientOriginalName(),
            mime: $file->getClientOriginalExtension(),
            path: $path,
            size: $file->getSize(),
        );
    }
}
