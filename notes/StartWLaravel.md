```markdown
# Grundlagen der Laravel-Projektstruktur, MVC und Routing

Im Folgenden findest du eine Übersicht über die typische Laravel-Projektstruktur sowie eine kurze Einführung in das MVC-Konzept und die grundlegende Handhabung von Routen.

## Projektstruktur

- **composer.json**  
  Enthält alle PHP-Abhängigkeiten (Dependencies), Autoload-Einstellungen, Skripte usw. für das Backend.

- **package.json**  
  Enthält alle JavaScript- bzw. Node.js-Abhängigkeiten für das Frontend. Ermöglicht das Ausführen von `npm`-Befehlen.

- **.env**  
  Globale Umgebungsvariablen (z. B. für Datenbankverbindung, API-Keys usw.).

- **app/**  
  Enthält die MVC-Struktur (Models, Controllers, Views).  
  *Hinweis:* In Laravel liegen die Views allerdings standardmäßig im Verzeichnis `resources/views`.

- **config/**  
  Hier befinden sich Konfigurationsdateien für verschiedene Komponenten (Datenbank, Mail, Services usw.).

- **bootstrap/**  
  Enthält die Bootstrap-Dateien zur Initialisierung des Frameworks.

- **database/**  
  Beinhaltet Migrationen, Factories, Seeders und ggf. Datenbank-Backups.

- **public/**  
  Öffentlich zugänglicher Ordner (z. B. für Bilder, CSS/JS-Dateien nach der Kompilierung).

- **resources/**  
  Enthält unkompilierte Assets wie SCSS, JavaScript, Bilder und die Laravel-Views (`resources/views`).

- **routes/**  
  Enthält die Routing-Dateien (z. B. `web.php`, `api.php`). Hier werden Endpunkte definiert.

- **storage/**  
  Dient zur Ablage von Logs, gecachten Views, hochgeladenen Dateien usw.

- **tests/**  
  Enthält Unit-Tests und andere Arten von Tests.

- **vendor/**  
  Hier liegen alle von Composer installierten Abhängigkeiten (Dependencies).

## MVC-Grundlagen

- **Model**  
  Verantwortlich für die Datenverarbeitung. Es kommuniziert mit der Datenbank, verarbeitet Anfragen vom Controller und stellt Daten für die Views bereit.

- **View**  
  Verantwortlich für die Darstellung der Daten. Sie empfängt Daten vom Model (über den Controller) und rendert diese für den Endnutzer.

- **Controller**  
  Verantwortlich für das Entgegennehmen und Verarbeiten von Nutzeranfragen (HTTP-Requests). Der Controller ruft Modelle auf, bereitet Daten auf und übergibt sie an die Views oder leitet zu anderen Routen weiter.

## Routing-Grundlagen

Ein "Route"-Eintrag verbindet einen bestimmten Endpunkt (z. B. `/`, `/jobs`, `/submit`) mit einer Aktion, in der Regel einer Funktion oder einem Controller-Methodenaufruf.

### Beispiel einer einfachen Route

```php
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
```

- `Route` ist eine Klasse, die Routen verwaltet.
- `get` behandelt einen GET-Request.
- `'/'` ist der Pfad für die Startseite.
- Die Closure (`function () { ... }`) gibt als Rückgabewert die `welcome`-View aus.

### Unterschiedliche Response-Typen

Man kann anstelle einer View auch einfache Datentypen oder Strings zurückgeben:

```php
Route::get('/jobs', function () {
    return 'Available Jobs';
})->name('jobs');
```

Diese Route gibt einen einfachen String zurück. Erreichbar ist die Seite unter `https://holyworkopia.test/jobs`.

### Benannte Routen

Das `->name('jobs')` am Ende der Route weist der Route einen Namen zu. So kann man beispielsweise intern Links dynamisch erzeugen:

```php
Route::get('/test', function () {
    $url = route('jobs');
    return "<a href='$url'>Click Here</a>";
});
```

Hier wird bei `https://holyworkopia.test/test` ein Link ausgegeben, der auf die Route `/jobs` verweist.

### POST-Route

```php
Route::post('/submit', function () {
    return 'Submitted';
});
```

Eine POST-Route wird üblicherweise verwendet, um Daten zu verarbeiten (z. B. Formulardaten senden, E-Mails verschicken, Daten in die Datenbank schreiben).

**Wichtig:** Laravel bietet einen CSRF-Schutz für POST-Anfragen. Wenn man ohne gültigen CSRF-Token anfragt, wird die Anfrage blockiert. Über die Middleware-Konfiguration in `bootstrap/app.php` kann man bestimmte Routen vom CSRF-Schutz ausnehmen:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->validateCsrfTokens(except: [
        '/submit'
    ]);
});
```

### Mehrere Methoden für eine Route

Man kann `Route::match()` verwenden, um mehrere HTTP-Methoden für dieselbe Route zu erlauben:

```php
Route::match(['get', 'post'], '/submit', function () {
    return 'Submitted';
});
```

Mit `Route::any()` kann man sogar alle Methoden freigeben:

```php
Route::any('/submit', function () {
    return 'Submitted';
});
```

### JSON-Responses

Man kann einfach JSON-Daten zurückgeben:

```php
Route::get('/api/users', function () {
    return [
        'name' => 'John Doe',
        'email' => 'john@doe.com',
    ];
});
```

### Alle Routen auflisten

Mit dem Artisan-Kommando kann man alle definierten Routen anzeigen:

```bash
php artisan route:list
```

Beispielhafte Ausgabe:

```
  GET|HEAD  /             ...
  GET|HEAD  api/users     ...
  GET|HEAD  jobs          ... jobs
  GET|HEAD  storage/{path}...
  ANY       submit         ...
  GET|HEAD  test           ...
  GET|HEAD  up             ...
```
