<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodItemController;
use App\Http\Controllers\GroceryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pages/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [FoodItemController::class, 'index'])->name('dashboard');
    Route::get('/add-grocery', [GroceryController::class, 'index'])->name('addGrocery');
    Route::post('/food-items', [FoodItemController::class, 'store'])->name('foodItems.store');
    Route::delete('/food-items/{foodItem}', [FoodItemController::class, 'destroy'])->name('foodItems.destroy');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::post('/locations', [LocationController::class, 'store'])->name('locations.store');
});

require __DIR__.'/auth.php';
