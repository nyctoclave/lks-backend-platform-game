<?php

use App\Http\Controllers\AdminController;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/v1/auth/signup', [AuthController::class, 'signup']);
Route::post('/v1/auth/signin', [AuthController::class, 'signIn']);
Route::post('/v1/auth/signout', [AuthController::class, 'signOut'])->middleware('auth:sanctum');

// route khusus admin

Route::middleware('admin')->group(function (){
   Route::get('/v1/admin', [AdminController::class, 'index']);
   Route::post('/v1/users', [UserController::class, 'store']);
   Route::get('/v1/users', [UserController::class, 'index']);
   Route::put('/v1/users/{id}', [UserController::class, 'update']);
   Route::delete('/v1/users/{id}', [UserController::class, 'destroy']);
   Route::get('/v1/games', [GameController::class, 'index'] );
   Route::post('/v1/games', [GameController::class, 'store']);
   Route::get('/v1/games/{slug}', [GameController::class, 'show']);
   
});

// Route::middleware('user')->group(function (){

// });