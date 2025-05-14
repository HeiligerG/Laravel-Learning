<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\LoginController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/users/{id}', [UserController::class, 'show']);
Route::get('/users/{id}/tweets', [UserController::class, 'tweets']);
Route::get('/me', [UserController::class, 'me'])->middleware('auth:sanctum');

Route::get('/tweets', [TweetController::class, 'tweets']);
Route::post('/tweets', [TweetController::class, 'store'])->middleware('auth:sanctum');

Route::post('/login', [LoginController::class, 'login']);
Route::get('/auth', [LoginController::class, 'checkAuth'])->middleware('auth:sanctum');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');