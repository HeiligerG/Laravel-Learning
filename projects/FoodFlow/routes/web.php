<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodItemController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [FoodItemController::class, 'index'])->name('dashboard');
    Route::post('/food-items', [FoodItemController::class, 'store'])->name('foodItems.store');
    Route::delete('/food-items/{foodItem}', [FoodItemController::class, 'destroy'])->name('foodItems.destroy');
    Route::post('/categories', [FoodItemController::class, 'addCategory'])->name('categories.add');
    Route::post('/locations', [FoodItemController::class, 'addLocation'])->name('locations.add');
});

require __DIR__.'/auth.php';
