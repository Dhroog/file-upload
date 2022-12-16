<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function users(){
        return $this->belongsToMany(User::class,'group_users');
    }

    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class,'file_groups');
    }
}
