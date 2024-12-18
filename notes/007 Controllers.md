# Laravel Controllers

## Übersicht & Aufgaben von Controllern

Controller in Laravel dienen dazu, **Benutzereingaben zu verarbeiten, die geeigneten Daten abzufragen und anschließend eine passende View darzustellen**. Sie sind das Bindeglied zwischen Routen (URL-Endpunkten), Models (Daten) und Views (Darstellung).

Vorteile von Controllern:

- Saubere Trennung von Logik und Darstellung.
- Höhere Sicherheit und bessere Lesbarkeit.
- Einfache Wiederverwendbarkeit von Logik.

## Erstellen eines Controllers

Controllers werden standardmäßig im Verzeichnis `app/Http/Controllers` angelegt. Du kannst sie manuell erstellen oder den Laravel Artisan-Befehl verwenden:

```bash
php artisan make:controller JobController
```

### Namenskonventionen

Bei der Benennung von Controllern ist es empfehlenswert, den Best Practices zu folgen, z. B. `JobController`, `HomeController`. Weitere Infos:  
[Laravel Best Practices - Naming Conventions](https://github.com/alexeymezenin/laravel-best-practices#follow-laravel-naming-conventions)

## Routen zu Controllern leiten

Statt Logik direkt in den Routendefinitionen in `routes/web.php` zu schreiben, kann man die Anfragen an Controller-Methoden delegieren:

```php
use App\Http\Controllers\JobController;

// Liste aller Jobs
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');

// Anzeige einer Create-Form
Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
```

### Beispielhafte Controller-Methoden

```php
// Im JobController

public function index() {
    $title = 'Available Jobs';
    $jobs = [
        'Web Developer',
        'Database Administrator',
        'Software Engineer',
        'System Analyst',
    ];
    return view('jobs.index', compact('title', 'jobs'));
}

public function create() {
    return view('jobs.create');
}
```

In diesem Beispiel wird die Logik nicht mehr direkt in der Route definiert, sondern ist in den Controller ausgelagert. Das erhöht Übersichtlichkeit und Sicherheit.

## Home Controller Beispiel

Man kann z. B. eine Startseite über einen HomeController verwalten:

```php
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);
```

Im `HomeController`:

```php
public function index() {
    // Logik für die Startseite, z.B. Daten laden und an View übergeben
    return view('home.index');
}
```

## Dynamische Parameter

Man kann auch dynamische Parameter verwenden, um z. B. einen bestimmten Job anzuzeigen:

```php
Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');
```

Im Controller:

```php
public function show(string $id) {
    return "Showing Job $id";
}
```

**Wichtig:** Legt man eine Route mit Parameter fest, sollte sie nach den statischen Routen definiert werden, um unerwünschte Überschneidungen zu vermeiden.

## POST-Requests mit CSRF-Schutz

Zum Erstellen neuer Einträge verwendet man meist POST-Anfragen. Beispiel:

### Route

```php
Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
```

### Controller

```php
use Illuminate\Http\Request;

public function store(Request $request) {
    $title = $request->input('title');
    $description = $request->input('description');
    return "Title: $title, Description: $description";
}
```

### View (Formular)

```blade
<form action="/jobs" method="POST">
    @csrf
    <input type="text" name="title" placeholder="title">
    <input type="text" name="description" placeholder="description">
    <button type="submit">Submit</button>
</form>
```

**Hinweis:**  
Ohne `@csrf` wirft Laravel einen 419-Fehler, da Laravel standardmäßig Cross-Site-Request-Forgery (CSRF) Schutz einsetzt. Das `@csrf`-Tag fügt ein unsichtbares Token ein, welches sicherstellt, dass Anfragen tatsächlich von dieser Seite stammen.

## Zusammenfassung

- Controller trennen Logik von der Anzeige.
- Artisan-Befehl: `php artisan make:controller NameController`.
- Routen leiten per `[Controller::class, 'methode']` an Controller.
- CSRF-Token per `@csrf` in Formularen.
- Dynamische Parameter in der Route erlauben Controller den Zugriff auf spezifische Daten (z. B. Job-ID).

Diese Vorgehensweise macht den Code modular, wartbar und sicher.