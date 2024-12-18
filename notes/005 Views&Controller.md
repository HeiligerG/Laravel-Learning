# Laravel Views & Controller

## Einführung in Views und MVC

Laravel nutzt das MVC-Konzept (Model-View-Controller), um Logik und Design klar voneinander zu trennen. Die **Views** dienen der Darstellung der Daten (HTML, CSS, JavaScript), während Controller und Models die Geschäftslogik bzw. den Datenzugriff regeln. Dank **Blade**, dem Template-Engine von Laravel, wird das Arbeiten mit Views besonders komfortabel und übersichtlich.

## Views einbinden

Stellen wir uns vor, wir haben in `resources/views` eine Datei namens `jobs.blade.php` oder `jobs.php` erstellt, in der wir HTML-Code zur Darstellung von Jobs unterbringen. Die Einbindung in eine Route kann dann so aussehen:

```php
Route::get('/jobs', function () {
    return view('jobs');
})->name('jobs');
```

Aufruf unter `https://holyworkopia.test/jobs` zeigt den Inhalt der `jobs.blade.php` (oder `jobs.php`) an.

### Strukturierung in Unterordnern

Es ist sinnvoll, Views sinnvoll zu gliedern. Beispielsweise könnte man für Jobs einen eigenen Ordner in `resources/views/jobs` anlegen und darin eine `index.blade.php` ablegen. Dann kann man in der Route anstatt `view('jobs')` folgendes nutzen:

```php
Route::get('/jobs', function () {
    return view('jobs.index'); // Lädt resources/views/jobs/index.blade.php
})->name('jobs');
```

Aufruf: `https://holyworkopia.test/jobs` zeigt nun den Inhalt von `index.blade.php`.

Ähnlich für eine "Create"-Seite:

```php
Route::get('/jobs/create', function () {
    return view('jobs.create'); // Lädt resources/views/jobs/create.blade.php
})->name('jobs.create');
```

Hier würde `https://holyworkopia.test/jobs/create` dann die View `create.blade.php` anzeigen.

## Daten an Views übergeben

Um dynamische Daten an die View zu übergeben, ist es üblich, diese aus einem Model oder Controller zu holen. In einfachen Fällen oder zu Demonstrationszwecken kann man Daten auch direkt in der Route definieren.

```php
Route::get('/jobs', function () {
    $title = 'Available Jobs';
    return view('jobs.index', compact('title'));
})->name('jobs');
```

In der View `index.blade.php` kann man dann mit Blade-Syntax auf `$title` zugreifen:

```blade
<h1>{{ $title }}</h1>
```

### Arrays und Listen

Auch Arrays kann man leicht übergeben und in einer View darstellen:

```php
Route::get('/jobs', function () {
    $title = 'Available Jobs';
    $jobs = [
        'Web Developer',
        'Database Administrator',
        'Software Engineer',
        'System Analyst',
    ];
    return view('jobs.index', compact('title', 'jobs'));
})->name('jobs');
```

In der `jobs/index.blade.php` kann man dann alle Jobs ausgeben, z. B. mit einer Schleife:

```blade
<h1>{{ $title }}</h1>
<ul>
    @foreach ($jobs as $job)
        <li>{{ $job }}</li>
    @endforeach
</ul>
```

**Hinweis:** In Blade werden Variablen und Ausgaben automatisch escaped, um vor XSS-Angriffen zu schützen. Das heißt, wenn `$job` HTML-Code enthalten sollte, wird dieser sicher ausgegeben. Möchte man bewusst HTML zulassen, kann man `{!! $job !!}` nutzen. Grundsätzlich ist es aber sicherer, die Standard-Syntax `{{ $job }}` zu verwenden.

## Zusammenfassung

- **MVC & Views:** Trennung von Logik (Controller, Model) und Darstellung (View).
- **View Ordnerstruktur:** Sinnvolle Gliederung von Views in Unterordner wie `jobs/index.blade.php`.
- **Datenübergabe:** Mit `compact()` oder assoziativen Arrays können Werte an Views übergeben werden.
- **Blade-Template-Engine:** Erleichtert das Schreiben von Templates, beinhaltet bereits Sicherheitsmaßnahmen wie automatisches Escaping.