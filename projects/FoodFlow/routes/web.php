<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodItemController;
use App\Http\Controllers\GroceryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommunityController;
use App\Http\Middleware\NoCommunityMiddleware;
use App\Http\Controllers\PatchNoteController;
//use Illuminate\Http\Request;

Route::resource('food-items', FoodItemController::class)
    ->except(['index'])
    ->names('foodItems');

Route::get('/', function () {
    return view('welcome');
});

//Route::post('/api/check-admin-password', function(Request $request) {
//    return response()->json([
//        'success' => $request->password === config('app.admin_password')
//    ]);
//});

Route::get('/dashboard/index', function () {
    return view('dashboard.index');
})->middleware(['auth', 'verified'])->name('index');

Route::middleware(['auth', NoCommunityMiddleware::class])->group(function () {
    Route::get('/join-community', [CommunityController::class, 'joinForm'])
        ->name('community.join-form');

    Route::post('/join-community', [CommunityController::class, 'join'])
        ->name('community.join');

    Route::get('/create-community', [CommunityController::class, 'createForm'])
        ->name('community.create-form');

    Route::post('/create-community', [CommunityController::class, 'store'])
        ->name('community.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/patch-notes', [PatchNoteController::class, 'show'])->name('patch-notes.show');
    Route::post('/patch-notes/mark-seen', [PatchNoteController::class, 'markAsSeen'])->name('patch-notes.mark-seen');

    Route::get('/dashboard', [FoodItemController::class, 'index'])->name('dashboard');
    Route::get('/add-grocery', [GroceryController::class, 'index'])->name('addGrocery');
    Route::post('/food-items', [FoodItemController::class, 'store'])->name('foodItems.store');
    Route::delete('/food-items/{foodItem}', [FoodItemController::class, 'destroy'])->name('foodItems.destroy');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::post('/locations', [LocationController::class, 'store'])->name('locations.store');
    Route::get('food-items/{foodItem}/edit', [FoodItemController::class, 'edit'])->name('foodItems.edit');
    Route::patch('/food-items/{foodItem}', [FoodItemController::class, 'update'])->name('foodItems.update');
    Route::post('/community/switch', [CommunityController::class, 'switch'])->name('community.switch');
});

require __DIR__.'/auth.php';
