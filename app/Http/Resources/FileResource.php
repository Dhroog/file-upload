<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'file_name' => $this->file_name,
            'check_in' => $this->check_in,
            'mime_type' => $this->mime_type,
            'path' =>  Storage::path($this->path),
            'size' => $this->size,
        ];
    }
}
