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
    Route::get('/admin/group-files',[GroupController::class,'GetAllGroup'])->middleware('can:Admin');
    Route::get('/GetUsers',[\App\Http\Controllers\UserController::class,'GetUsers']);
});

route::get('/load-balance',function (){
    return response()->json([
        'message' => 'this from laravel instance_22222'
    ],200);
});


require __DIR__.'/auth.php';
/*
  ProxyPreserveHost On

	ProxyPass /laravel1 http://localhost:8000/
	ProxyPassReverse /laravel1 http://localhost:8000/

	ProxyPass /laravel2 http://localhost:8001/
	ProxyPassReverse /laravel2 http://localhost:8001/

	ServerName localhost
 */
