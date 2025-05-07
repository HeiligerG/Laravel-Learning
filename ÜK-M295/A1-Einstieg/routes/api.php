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