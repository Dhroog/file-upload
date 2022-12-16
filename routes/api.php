<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\GroupController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

route::middleware('auth:sanctum')->group(function (){
    route::apiResource('group', GroupController::class);
    route::apiResource('file', FileController::class);
    Route::get('/addFileToGroup/{file}/{group}',[FileController::class,'addFileToGroup']);
    Route::post('/check-in-file',[FileController::class,'checkIn']);
    Route::get('/addUserToGroup/{group}/{user}',[GroupController::class,'addUserToGroup']);
    Route::get('/deleteUserFromGroup/{group}/{user}',[GroupController::class,'deleteUserFromGroup']);

    Route::get('/FileHistory/{file}',[FileController::class,'FileHistory']);
});




require __DIR__.'/auth.php';

