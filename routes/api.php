<?php

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

Route::middleware('auth:api')->group(function(){
    Route::get('/myposts',[\App\Http\Controllers\Api\PostController::class,'myposts']);
    Route::get('/authuser',[\App\Http\Controllers\Api\UserController::class,'authuser']);
    Route::post('/users/addfriend',[\App\Http\Controllers\Api\UserController::class,'addfriend']);
    Route::post('/users/acceptfriend',[\App\Http\Controllers\Api\UserController::class,'acceptfriend']);
    Route::post('/users/deletefriend',[\App\Http\Controllers\Api\UserController::class,'deletefriend']);
    Route::get('/users/{id}/posts',[\App\Http\Controllers\Api\PostController::class,'userposts']);
    Route::apiResource('posts',\App\Http\Controllers\Api\PostController::class);
    Route::apiResource('/users/{userid}/images',\App\Http\Controllers\UserImageController::class);
    Route::apiResource('users',\App\Http\Controllers\Api\UserController::class);
    Route::apiResource('likes',\App\Http\Controllers\LikeController::class);
    Route::apiResource('/posts/{post}/comments',\App\Http\Controllers\Api\CommentController::class);
});



