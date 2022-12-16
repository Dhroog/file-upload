<?php

namespace App\Models;

use App\Jobs\loggingFile;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'file_name',
        'check_in',
        'mime_type',
        'path',
        'size',
        'user_id'
    ];
/*
    protected function path(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Storage::path($value),
        );
    }
*/
    public function users(){
        return $this->belongsTo(User::class);
    }

    public function groups(){
        return $this->belongsToMany(Group::class,'file_groups');
    }

    public function log(){
        return $this->hasMany(logging::class,'file_id')
            ->orderByDesc('created_at');
    }


}
