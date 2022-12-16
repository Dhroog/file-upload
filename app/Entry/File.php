<?php


namespace App\Entry;


class File
{
    public  string $name;
    public  string $originalName;
    public  string $mime;
    public  string $path;
    public string $size;

    public function __construct($name,$originalName,$mime,$path,$size){
        $this->name = $name;
        $this->originalName = $originalName;
        $this->mime = $mime;
        $this->path = $path;
        $this->size = $size;
    }

public function toArray(): array
{
    return [
        'name' => $this->name,
        'file_name' => $this->originalName,
        'mime_type' => $this->mime,
        'path' => $this->path,
        'size' => $this->size,
    ];
}

}
