# Middleware Übersicht

Einer der wichtigsten Teile jeder Webanwendung ist das Middleware, in das wir bisher noch nicht wirklich eingetaucht sind.

Middleware ist eine Art Filter, der zwischen der HTTP-Anfrage vom Client und der Anwendung sitzt. Es überprüft und verarbeitet eingehende Anfragen, bevor sie den Controller erreichen, oder ausgehende Antworten, bevor sie an den Benutzer zurückgesendet werden.

Beispielsweise kannst du Middleware verwenden, um zu überprüfen, ob der Benutzer deiner Anwendung authentifiziert ist. Wenn der Benutzer nicht authentifiziert ist, leitet die Middleware den Benutzer zur Login-Seite weiter. Wir werden dies implementieren, aber bevor wir das tun, möchte ich ein einfaches benutzerdefiniertes Logging-Middleware erstellen.

Denke an Middleware als Türsteher deiner Anwendung. Es sitzt zwischen dem Benutzer und der Anwendung und entscheidet, ob der Benutzer Zugang zur Anwendung erhält.

## Globale vs. Routen-Middleware

Es gibt zwei Arten von Middleware: global und routenbasiert. Globale Middleware wird für jede Anfrage ausgeführt, während routenbasierte Middleware für eine spezifische Route ausgeführt wird. In dieser Lektion zeige ich dir beide Methoden.

## Middleware erstellen

Erstellen wir ein einfaches Logging-Middleware, das die Anfragemethode und die URI in die Logdatei protokolliert.

Um ein Middleware zu erstellen, können wir den Befehl `make:middleware` verwenden:

```bash
php artisan make:middleware LogRequest
```

Dieser Befehl erstellt eine neue Middleware-Klasse im Verzeichnis `app/Http/Middleware`. Die Klasse hat eine Methode namens `handle`. Diese Methode wird aufgerufen, wenn das Middleware ausgeführt wird. Standardmäßig gibt sie `$next($request)` zurück, was bedeutet, dass die Anfrage an das nächste Middleware in der Kette weitergeleitet wird.

Als Nächstes öffnen wir die Datei `app/Http/Middleware/LogRequest.php` und fügen vorerst eine einfache Ausgabe hinzu:

```php
public function handle(Request $request, Closure $next): Response
{
    print('Von der LogRequest Middleware');
    return $next($request);
}
```

## Globale Middleware registrieren

Um das Middleware global für alle Routen zu registrieren, müssen wir es dem `$middleware` Array in der Datei `app/Http/Kernel.php` hinzufügen. Öffne diese Datei und importiere das Middleware:

```php
use App\Http\Middleware\LogRequest;
```

Dann füge es zum `$middleware` Array hinzu:

```php
protected $middleware = [
    // Andere Middleware...
    LogRequest::class,
];
```

Jetzt wird das Middleware für jede Anfrage ausgeführt. Wenn du eine Route besuchst, siehst du die Ausgabe `Von der LogRequest Middleware`.

## Anfragen protokollieren

Statt zu drucken, lassen wir uns das `Log` Fassade verwenden, um die Anfragemethode und die URI in die Logdatei zu schreiben. Öffne die Datei `app/Http/Middleware/LogRequest.php` und ersetze die `handle` Methode mit folgendem Code:

```php
public function handle(Request $request, Closure $next): Response
{
    Log::info("{$request->method()} - {$request->fullUrl()}");
    return $next($request);
}
```

Nun werden deine Anfragen in der Datei `storage/logs/laravel.log` protokolliert. Öffne diese Datei und gehe zum Ende der Datei. Du solltest etwas Ähnliches sehen wie:

```
[2024-08-19 11:15:38] local.INFO: GET - http://127.0.0.1:8000
[2024-08-19 11:15:41] local.INFO: GET - http://127.0.0.1:8000/jobs
[2024-08-19 11:16:01] local.INFO: GET - http://127.0.0.1:8000/jobs/1
```

Später werden wir mehr über Logging lernen und wie man einen Artisan-Befehl erstellt, um die Logdatei zu löschen.

## Middleware zu Routen zuweisen

Dies ist globale Middleware. Nehmen wir an, du möchtest, dass diese nur auf eine spezifische Route angewendet wird. Du kannst das tun, indem du das Middleware zur Route hinzufügst.

Zuerst entferne oder kommentiere die folgende Zeile in der Datei `app/Http/Kernel.php`:

```php
protected $middleware = [
    // Andere Middleware...
    // LogRequest::class,
];
```

Öffne nun die Datei `routes/web.php` und füge den folgenden Import hinzu:

```php
use App\Http\Middleware\LogRequest;
```

Dann füge das Middleware zur Home-Route hinzu:

```php
Route::get('/', [HomeController::class, 'index'])->name('home')->middleware(LogRequest::class);
```

Jetzt wird das Logging nur für die Home-Route ausgeführt. Dies ist zwar etwas unnötig, zeigt aber, wie Middleware verwendet wird.

Gehe zurück zu der Home-Route und entferne das Middleware, falls du es nicht mehr benötigst. Du kannst das `LogRequest` Middleware auch löschen, wenn du möchtest.

# Auth Middleware & Routen schützen

In Laravel kannst du Routen schützen, indem du das `auth` Middleware verwendest. Wie wir in der letzten Lektion gesehen haben, ist Middleware eine Methode, um HTTP-Anfragen, die in deine Anwendung eintreten, zu filtern.

## Manuelle Überprüfung der Benutzer-Authentifizierung

Du kannst immer noch manuell überprüfen, ob ein Benutzer authentifiziert ist, indem du das `Auth` Fassade verwendest. Angenommen, du möchtest, dass Benutzer die Route `/jobs/create` nicht besuchen können, es sei denn, sie sind eingeloggt. Derzeit wird der Button zwar nicht angezeigt, aber sie können die Route trotzdem als Gast besuchen.

Um die Route manuell zu schützen, kannst du in den `JobsController` die `create` Methode bearbeiten und folgendes hinzufügen:

Füge den Import hinzu:

```php
use Illuminate\Support\Facades\Auth;
```

Dann füge das Folgende zur `create` Methode hinzu. Ergänze auch `View | RedirectResponse` zur Methodensignatur.

```php
public function create(): View | RedirectResponse
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    return view('jobs.create');
}
```

Nun, wenn du versuchst, die Route `/jobs/create` zu besuchen, wirst du zur Login-Seite weitergeleitet.

Dies ist in Ordnung, aber was ist, wenn du mehrere Routen schützen möchtest? Du könntest den Code in jede Methode kopieren und einfügen, aber das ist nicht sehr DRY (Don't Repeat Yourself). Stattdessen kannst du Middleware verwenden. Entferne den gerade hinzugefügten Code.

## Middleware verwenden

Laravel verfügt über ein eingebautes Middleware zur Überprüfung, ob ein Benutzer authentifiziert ist. Es heißt `auth`. Du kannst dieses Middleware verwenden, um Routen zu schützen.

Um das `auth` Middleware zu verwenden, kannst du es zur Routendefinition in der Datei `web.php` hinzufügen.

Angenommen, wir möchten, dass nur eingeloggte Benutzer Zugriff auf die Startseite haben, würden wir folgendes zur Datei `web.php` hinzufügen:

```php
Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');
```

Ganz einfach, oder? Allerdings verwenden wir Ressourcenseiten für Jobs. Wir möchten das `auth` Middleware nur auf die `create`, `store`, `edit`, `destroy` und `update` Routen anwenden. Um dies zu tun, kannst du die `only` Methode verwenden:

```php
// Middleware nur auf spezifische Aktionen anwenden
Route::resource('jobs', JobController::class)->middleware('auth')->only(['create', 'edit', 'destroy']);
```

Jetzt erhältst du einen Fehler wie `jobs.show ist nicht definiert`. Dies liegt daran, dass wir Ressourcenseiten verwenden. Um dies zu beheben, kannst du die `except` Methode verwenden. Füge dies direkt unter dem vorherigen Code hinzu:

```php
// Die restlichen Ressourcenseiten ohne Middleware definieren
Route::resource('jobs', JobController::class)->except(['create', 'edit', 'destroy']);
```

Nun kannst du die Route `/jobs/create` besuchen und wirst zur Login-Seite weitergeleitet.

Als nächstes werden wir das `guest` Middleware sowie Middleware-Gruppen betrachten.

# Guest Middleware & Gruppen

Nachdem wir Routen wie `/jobs/create` und `/jobs/edit/:id` geschützt haben, möchten wir jetzt das `guest` Middleware verwenden, um sicherzustellen, dass nur Gäste oder nicht eingeloggte Benutzer auf Routen wie `/login` und `/register` zugreifen können.

Öffne die Datei `routes/web.php` und füge folgendes zum Login-Route hinzu:

```php
Route::get('/login', [LoginController::class, 'login'])->name('login')->middleware('guest');
```

Dies ist in Ordnung und wir können es auch zum Register-Route hinzufügen. Allerdings können wir eine `group` verwenden, um das Middleware auf mehrere Routen anzuwenden.

```php
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
});
```

Dies ist etwas sauberer. Nun können nur Gäste auf die Login- und Register-Routen zugreifen. Wenn ein eingeloggt Benutzer versucht, auf diese Routen zuzugreifen, wird er zur Startseite weitergeleitet.

## Zusammenfassung

- **Middleware erstellen und registrieren:** Erstellen von benutzerdefinierten Middleware und deren globale oder routenbasierte Registrierung.
- **Logging-Middleware:** Protokollieren von Anfragedaten mithilfe des `Log` Facades.
- **Authentifizierungsschutz:** Verwenden des eingebauten `auth` Middleware, um Routen zu schützen und sicherzustellen, dass nur authentifizierte Benutzer auf bestimmte Routen zugreifen können.
- **Gastenschutz:** Verwenden des `guest` Middleware, um sicherzustellen, dass nur nicht eingeloggte Benutzer auf Authentifizierungsrouten wie Login und Registrierung zugreifen können.
- **Middleware-Gruppen:** Gruppieren von Routen und Anwenden von Middleware auf die Gruppe, um den Code sauberer und wartbarer zu gestalten.
- **Sicherheitsmaßnahmen:** Nutzung von Middleware zur Implementierung von Sicherheitsfunktionen wie Authentifizierung und Zugriffskontrolle.

Durch das Verständnis und die korrekte Nutzung von Middleware kannst du den Zugriff auf verschiedene Teile deiner Laravel-Anwendung effektiv steuern und zusätzliche Sicherheitsmaßnahmen implementieren.