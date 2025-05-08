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


use App\Models\Bike;

# Nächste Aufgabe: hallo-velo
Route::prefix('hallo-velo')->group(function () {
    Route::get('/bikes', fn () => Bike::all());
    Route::get('/bikes/{id}', fn ($id) => Bike::find($id));
});
# Gearbeitet mit Modelen bzw. C:\Users\gggig\Laravel-Learning\ÜK-M295\A1-Einstieg\app\Models\Bike.php

use App\Http\Controllers\BookController;

# Nächste Aufgabe: Book'ler
Route::prefix('bookler')->group(function () {
    Route::get('/posts', [BookController::class, 'allPosts']);
    Route::get('/posts/{id}', [BookController::class, 'getByPost']);
    Route::get('/search/{search}', [BookController::class, 'searchPosts']);

    Route::prefix('book-finder')->group(function () {
        Route::get('/slug/{slug}', [BookController::class, 'getPostBySlug']);
        Route::get('/title/{title}', [BookController::class, 'getPostByTitle']);
        Route::get('/author/{author}', [BookController::class, 'getPostByAuthor']);
        Route::get('/year/{year}', [BookController::class, 'getPostByYear']);
        Route::get('/max-pages/{pages}', [BookController::class, 'getPostByMaxPages']);
    });

    Route::prefix('meta')->group(function () {
        Route::get('/count', [BookController::class, 'countPages']);
        Route::get('/avg-pages', [BookController::class, 'countAvgPages']);
    });

    Route::get('/dashboard', fn () => [
        'books'  => Book::count(),
        'pages'  => Book::sum('pages'),
        'oldest' => Book::min('year'),
        'newest' => Book::max('year'),
    ]);
});

use App\Http\Controllers\PostController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\TagController;

# Neue Aufgabe: RelationSheep
Route::prefix('relationsheep')->group(function () {
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/topics/{slug}/posts', [TopicController::class, 'postsBySlug']);
    Route::get('/tags/{tagSlug}/posts', [TagController::class, 'postsByTagSlug']);
});