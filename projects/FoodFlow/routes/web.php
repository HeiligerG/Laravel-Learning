<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodItemController;
use App\Http\Controllers\GroceryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CategoryController;

Route::resource('food-items', FoodItemController::class)
    ->except(['index']) // Wenn Index anders implementiert ist
    ->names('foodItems');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard/index', function () {
    return view('dashboard.index');
})->middleware(['auth', 'verified'])->name('index');

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
    Route::get('food-items/{foodItem}/edit', [FoodItemController::class, 'edit'])->name('foodItems.edit');
    Route::patch('/food-items/{foodItem}', [FoodItemController::class, 'update'])->name('foodItems.update');
});

require __DIR__.'/auth.php';
