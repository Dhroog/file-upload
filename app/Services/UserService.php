<?php


namespace App\Services;


use App\Http\Resources\UserResource;
use App\Models\User;

class UserService extends BaseService
{
    public function GetUsers()
    {
        $users = User::all();
        return $users;
        //return $this->normalizeList($users,UserResource::class);
    }

}
