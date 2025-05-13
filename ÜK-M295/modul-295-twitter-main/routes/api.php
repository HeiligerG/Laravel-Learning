<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\TweetController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/users/{id}', [UserController::class, 'show']);
Route::get('/users/{id}/tweets', [UserController::class, 'tweets']);

Route::get('/tweets', [TweetController::class, 'tweets']);
