<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/jobs', function () {
    return 'Available Jobs';
})->name('jobs');

Route::any('submit', function () {
    return 'Submitted';
});

Route::get('/test', function () {
    $url = route('jobs');
    return "<a href='$url'>Click Here</a>";
});

Route::get('/api/users', function () {
    return [
        'name' => 'John Doe',
        'email' => 'john@doe.com',
    ];
});
