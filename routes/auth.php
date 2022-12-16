<?php

use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResendCodeVerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest','request.logging'])->group(function (){
    Route::post('/register',[RegisterController::class,'__invoke']);
    Route::post('/login',[LoginController::class,'__invoke']);
    Route::post('password/email',  ForgetPasswordController::class);
    Route::post('password/reset', ResetPasswordController::class);
});

Route::middleware(['auth:sanctum','request.logging'])->group(function (){
    Route::get('/resendCodeVerification',[ResendCodeVerificationController::class,'__invoke']);
    Route::post('/verifyEmail', [VerifyEmailController::class,'__invoke'])
        ->middleware(['throttle:6,1']);
    Route::get('/logout', [LogoutController::class,'__invoke']);

});
