<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class logging extends Model
{
    use HasFactory;

    protected $fillable = [
        'change',
        'user_id',
        'file_id',
        'username'
    ];


}
