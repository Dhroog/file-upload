<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Jobs\loggingFile;
use App\Traits\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements \Illuminate\Contracts\Auth\MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable,MustVerifyEmail;


    protected $fillable = [
        'username',
        'email',
        'password',
        'email_verify_code',
        'email_verify_code_sent_at',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verify_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'email_verify_code_sent_at' => 'datetime',
    ];

    public function setPasswordAttribute($password){
        $this->attributes['password'] = Hash::make($password);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class,'group_users');
    }

    public function groupsOwner()
    {
        return $this->belongsToMany(Group::class,'group_users')
            ->wherePivot('is_owner',true);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function log(){
        return $this->hasMany(loggingFile::class)->orderByDesc('created_at');
    }
}
