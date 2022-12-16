<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        User::create($request->validated())
        ->sendEmailVerificationNotification(true);
        return $this->Response('Sent email verification code');
    }
}
