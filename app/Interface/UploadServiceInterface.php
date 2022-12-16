<?php


namespace App\Interface;


use App\Entry\File;
use Illuminate\Http\UploadedFile;

interface UploadServiceInterface
{
    public function file(UploadedFile $file):File;
}
