<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('responder')->group(function () {

# String Hallo Welt zurückgeben
Route::get('/hi', function () {
    return "Hallo Welt";
});

# Zufälliger Zahlen zwischen 1 und 10 zurückgeben
Route::get('/number', function () {
    return random_int(1, 10);
});

# Redirect zu einer Seite
Route::get('/www', function () {
    return redirect('https://laravel.com/docs/10.x/routing#redirect-routes');
});

# Favicon zurückgeben/downloaden
Route::get('/favicon', function () {
    return response()->download(public_path('favicon.ico'));
});

# Name ausgeben von einem Parameter
Route::get('/hi/{name}', function ($name) {
    return $name;
});

# Wetterinformationen anzeigen
Route::get('/weather', function () {
    return response()->json([
        'city' => 'Luzern',
        'temperature' => 20,
        'wind' => 10,
        'rain' => 0,
    ]);
});

# Fehlermeldung anzeigen
Route::get('/error', function () {
    return response()->json(['error' => 'Nicht authorisiert!'], 401);
});

# Multiplication anzeigen von 2 Zahlen
Route::get('/multiply/{number1}/{number2}', function ($number1, $number2) {
    return response()->json([
        'result' => $number1 * $number2
    ]);
})->where(['number1' => '[0-9]+', 'number2' => '[0-9]+']);
# Bessere Lösung: ->whereNumbers($number1, $number2);
});

# Nächste Aufgabe: hallo-velo
use App\Models\Bike;

Route::prefix('hallo-velo')->group(function () {
    Route::get('/bikes', fn () => Bike::all());
    Route::get('/bikes/{id}', fn ($id) => Bike::find($id));
});

# Nächste Aufgabe: Book'ler
use App\Http\Controllers\BookController;
use App\Http\Controllers\PostController;

Route::prefix('bookler')->group(function () {
    Route::get('/posts', [PostController::class, 'allPosts']);
    Route::get('/posts/{id}', [PostController::class, 'getByPost']);
    Route::get('/search/{search}', [PostController::class, 'searchByPosts']);

    Route::prefix('book-finder')->group(function () {
        Route::get('/slug/{slug}', [PostController::class, 'getPostBySlug']);
        Route::get('/title/{title}', [PostController::class, 'getPostByTitle']);
        Route::get('/author/{author}', [PostController::class, 'getPostByAuthor']);
        Route::get('/year/{year}', [PostController::class, 'getPostByYear']);
        Route::get('/max-pages/{pages}', [PostController::class, 'getPostByMaxPages']);
    });

    Route::prefix('meta')->group(function () {
        Route::get('/count', [PostController::class, 'countPages']);
        Route::get('/avg-pages', [PostController::class, 'countAvgPages']);
    });

    Route::get('/dashboard', fn () => [
        'books'  => Book::count(),
        'pages'  => Book::sum('pages'),
        'oldest' => Book::min('year'),
        'newest' => Book::max('year'),
    ]);
});

# Neue Aufgabe: RelationSheep
use App\Http\Controllers\TopicController;
use App\Http\Controllers\TagController;

Route::prefix('relationsheep')->group(function () {
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/topics/{slug}/posts', [TopicController::class, 'postsBySlug']);
    Route::get('/tags/{tagSlug}/posts', [TagController::class, 'postsByTagSlug']);
});

# Nächste Aufgabe: Ackerer
use App\Http\Controllers\PlantController;
use App\Http\Controllers\AreaController;

Route::prefix('ackerer')->group(function () {
    Route::get('/plants/{slug}', [PlantController::class, 'getBySlug']);
    Route::get('/areas', [AreaController::class, 'getAreas']);
});


