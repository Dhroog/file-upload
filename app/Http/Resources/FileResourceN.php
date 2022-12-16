<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResourceN extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->check_in){
            return [
                'id' => $this->id,
                'name' => $this->name,
                'file_name' => $this->file_name,
                'check_in' => $this->check_in,
                'mime_type' => $this->mime_type,
                'size' => $this->size,
                'user' => User::find($this->log->first())->pluck('username')
            ];
        }
        return [
            'name' => $this->name,
            'file_name' => $this->file_name,
            'check_in' => $this->check_in,
            'mime_type' => $this->mime_type,
            'size' => $this->size,
        ];
    }
}
