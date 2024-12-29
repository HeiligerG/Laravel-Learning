# Login- & Register-Controller

Wir werden ein benutzerdefiniertes Login-System mithilfe der von Laravel angebotenen Werkzeuge erstellen. Die benötigten Tabellen sind bereits vorhanden. Es gibt eine `users` Tabelle aus den Standard-Migrationsdateien, die mit Laravel geliefert werden. Außerdem ist ein `User` Modell bereits eingerichtet.

## Controller erstellen

Es gibt viele Möglichkeiten, die Authentifizierung strukturiert zu handhaben. Eine gängige Methode ist es, für jede Art der Authentifizierung einen eigenen Controller zu erstellen. Zum Beispiel könnte man einen `LoginController` und einen `RegisterController` haben. Dies hält den Code organisiert und wartbar.

Erstellen wir zwei neue Controller:

```bash
php artisan make:controller LoginController
php artisan make:controller RegisterController
```

Dies erstellt zwei neue Dateien im Verzeichnis `app/Http/Controllers`. Du findest sie unter `app/Http/Controllers/LoginController.php` und `app/Http/Controllers/RegisterController.php`.

## Routen erstellen

Als Nächstes müssen wir Routen für unsere neuen Controller erstellen. Öffne die Datei `routes/web.php`.

Importiere die Klassen `LoginController` und `RegisterController` am Anfang der Datei:

```php
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
```

Füge dann die folgenden Routen hinzu:

```php
Route::get('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
```

Die erste Route zeigt das Registrierungsformular an, die zweite verarbeitet die Registrierung. Die dritte Route zeigt das Login-Formular an und die vierte verarbeitet die Login-Daten.

### Routen benennen

Das Benennen von Routen ist nützlich, um URLs einfach zu generieren. Hier sind alle Routen mit Namen versehen, außer den Ressourcenrouten:

```php
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs/{id}/save', [JobController::class, 'save'])->name('jobs.save');
Route::resource('jobs', JobController::class);
Route::get('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
```

## RegisterController

Beginnen wir mit dem `RegisterController`. Füge die folgenden Importe hinzu:

```php
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
```

### `register` Methode

Die `register` Methode zeigt das Registrierungsformular an:

```php
// @desc  Zeige das Registrierungsformular
// @route GET /register
public function register(): View {
    return view('auth.register');
}
```

### `store` Methode

Die `store` Methode verarbeitet das Registrierungsformular:

```php
// @desc  Speichere neuen Benutzer
// @route POST /register
public function store(Request $request): RedirectResponse {
    // Validierung der eingehenden Daten
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Passwort hashen
    $validatedData['password'] = Hash::make($validatedData['password']);

    // Neuen Benutzer erstellen
    $user = User::create($validatedData);

    // Benutzer einloggen
    Auth::login($user);

    // Weiterleitung zur Startseite mit Erfolgsmeldung
    return redirect()->route('home')->with('success', 'Registrierung erfolgreich! Du bist jetzt eingeloggt.');
}
```

**Erklärung:**

- **Validierung:** Stellt sicher, dass alle erforderlichen Felder korrekt ausgefüllt sind.
- **Passwort hashen:** Sichert das Passwort durch Hashing.
- **Benutzer erstellen:** Speichert den neuen Benutzer in der Datenbank.
- **Benutzer einloggen:** Loggt den Benutzer automatisch nach der Registrierung ein.
- **Weiterleitung:** Leitet den Benutzer zur Startseite mit einer Erfolgsmeldung weiter.

### Registrierungsansicht erstellen

Erstelle das Registrierungsformular in `resources/views/auth/register.blade.php`:

```html
<x-layout>
  <div class="bg-white rounded-lg shadow-md w-full md:max-w-xl mx-auto mt-12 p-8 py-12">
    <h2 class="text-4xl text-center font-bold mb-4">Registrieren</h2>
    <form method="POST" action="{{ route('register.store') }}">
      @csrf
      <x-inputs.text id="name" name="name" placeholder="Vollständiger Name" />
      <x-inputs.text id="email" name="email" type="email" placeholder="E-Mail-Adresse" />
      <x-inputs.text id="password" name="password" type="password" placeholder="Passwort" />
      <x-inputs.text id="password_confirmation" name="password_confirmation" type="password" placeholder="Passwort bestätigen" />
      <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded focus:outline-none">
        Registrieren
      </button>
      <p class="mt-4 text-gray-500">
        Hast du bereits ein Konto?
        <a class="text-blue-900" href="{{ route('login') }}">Login</a>
      </p>
    </form>
  </div>
</x-layout>
```

**Hinweis:** Der Name `password_confirmation` muss so benannt sein, um Laravels eingebautes Validierungsregel für Passwortbestätigung zu nutzen.

## LoginController

Bearbeite den `LoginController` und füge die folgenden Importe hinzu:

```php
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
```

### `login` Methode

Die `login` Methode zeigt das Login-Formular an:

```php
// @desc  Zeige das Login-Formular
// @route GET /login
public function login(): View {
    return view('auth.login');
}
```

### `authenticate` Methode

Die `authenticate` Methode verarbeitet das Login-Formular:

```php
// @desc  Benutzer einloggen
// @route POST /login
public function authenticate(Request $request): RedirectResponse {
    // Validierung der Anfragedaten
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    // Versuch, den Benutzer einzuloggen
    if (Auth::attempt($credentials)) {
        // Session regenerieren, um Fixierungsangriffe zu verhindern
        $request->session()->regenerate();

        // Weiterleitung zur vorgesehenen Route oder zur Startseite mit Erfolgsmeldung
        return redirect()->intended(route('home'))->with('success', 'Du bist jetzt eingeloggt!');
    }

    // Bei Fehlschlag: Zurückleiten mit Fehlermeldung
    return back()->withErrors([
        'email' => 'Die bereitgestellten Anmeldeinformationen stimmen nicht mit unseren Aufzeichnungen überein.',
    ])->onlyInput('email');
}
```

**Erklärung:**

- **Validierung:** Stellt sicher, dass die E-Mail und das Passwort korrekt eingegeben wurden.
- **Authentifizierung:** Überprüft die Anmeldeinformationen und loggt den Benutzer ein, wenn sie korrekt sind.
- **Session regenerieren:** Sichert die Session gegen Fixierungsangriffe.
- **Weiterleitung:** Leitet den Benutzer zur vorgesehenen Seite oder zur Startseite mit einer Erfolgsmeldung weiter.
- **Fehlermeldung:** Bei ungültigen Anmeldeinformationen wird eine Fehlermeldung angezeigt.

### Login-Ansicht erstellen

Erstelle das Login-Formular in `resources/views/auth/login.blade.php`:

```html
<x-layout>
  <div class="bg-white rounded-lg shadow-md w-full md:max-w-xl mx-auto mt-12 p-8 py-12">
    <h2 class="text-4xl text-center font-bold mb-4">Login</h2>
    <form method="POST" action="{{ route('login.authenticate') }}">
      @csrf
      <x-inputs.text id="email" name="email" type="email" placeholder="E-Mail-Adresse" />
      <x-inputs.text id="password" name="password" type="password" placeholder="Passwort" />
      <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded focus:outline-none">
        Login
      </button>
      <p class="mt-4 text-gray-500">
        Hast du noch kein Konto?
        <a class="text-blue-900" href="{{ route('register') }}">Registrieren</a>
      </p>
    </form>
  </div>
</x-layout>
```

## Benutzer abmelden & `@auth` Direktive

Jetzt, da wir eingeloggt sind, brauchen wir eine Möglichkeit, sich abzumelden. Außerdem möchten wir Links basierend auf dem Authentifizierungsstatus des Benutzers anzeigen oder ausblenden. Wir können dazu die `@auth` Direktive verwenden.

### Logout-Route

Füge eine neue Route zur Datei `routes/web.php` hinzu:

```php
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
```

### `logout` Methode

Füge die `logout` Methode zur `LoginController` Klasse hinzu:

```php
public function logout(Request $request): RedirectResponse
{
    Auth::logout(); // Benutzer ausloggen

    $request->session()->invalidate(); // Session ungültig machen
    $request->session()->regenerateToken(); // CSRF-Token regenerieren

    return redirect('/')->with('success', 'Du wurdest erfolgreich ausgeloggt.');
}
```

### Logout-Button & `@auth` Direktive

Füge einen Logout-Button zur Layout-Datei hinzu. Öffne die Datei `resources/views/components/header.blade.php` und ersetze den gesamten Code mit folgendem:

```html
<header class="bg-blue-900 text-white p-4" x-data="{ open: false }">
  <div class="container mx-auto flex justify-between items-center">
    <h1 class="text-3xl font-semibold">
      <a href="{{ route('home') }}">Workopia</a>
    </h1>
    <nav class="hidden md:flex items-center space-x-4">
      <x-nav-link url="/" :active="request()->is('/')">Home</x-nav-link>
      <x-nav-link url="/jobs" :active="request()->is('jobs')">Alle Jobs</x-nav-link>
      @auth
      <x-nav-link url="/jobs/saved" :active="request()->is('jobs/saved')">Gespeicherte Jobs</x-nav-link>
      <x-nav-link url="/dashboard" :active="request()->is('dashboard')" icon="gauge">Dashboard</x-nav-link>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-white">
          <i class="fa fa-sign-out"></i> Logout
        </button>
      </form>
      <x-button-link url="/jobs/create" type="button" icon="edit">Job erstellen</x-button-link>
      @else
      <x-nav-link url="/login" :active="request()->is('login')">Login</x-nav-link>
      <x-nav-link url="/register" :active="request()->is('register')">Registrieren</x-nav-link>
      @endauth
    </nav>
    <button @click="open = !open" class="text-white md:hidden flex items-center">
      <i class="fa fa-bars text-2xl"></i>
    </button>
  </div>
  <!-- Mobile Menu -->
  <nav x-show="open" @click.away="open = false" class="md:hidden bg-blue-900 text-white mt-5 pb-4 space-y-2">
    <x-mobile-nav-link url="/" :active="request()->is('/')">Home</x-mobile-nav-link>
    <x-mobile-nav-link url="/jobs" :active="request()->is('jobs')">Alle Jobs</x-mobile-nav-link>
    @auth
    <x-mobile-nav-link url="/jobs/saved" :active="request()->is('jobs/saved')">Gespeicherte Jobs</x-mobile-nav-link>
    <x-mobile-nav-link url="/dashboard" :active="request()->is('dashboard')" icon="gauge">Dashboard</x-mobile-nav-link>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="text-white">
        <i class="fa fa-sign-out"></i> Logout
      </button>
    </form>
    <div class="py-2">
      <x-button-link url="/jobs/create" type="button" icon="edit">Job erstellen</x-button-link>
    </div>
    @else
    <x-mobile-nav-link url="/login" :active="request()->is('login')">Login</x-mobile-nav-link>
    <x-mobile-nav-link url="/register" :active="request()->is('register')">Registrieren</x-mobile-nav-link>
    @endauth
  </nav>
</header>
```

**Erklärung:**

- **`@auth` Direktive:** Zeigt bestimmte Links nur an, wenn der Benutzer eingeloggt ist.
- **Logout-Formular:** Ein Formular, das den Benutzer abmeldet, indem es eine POST-Anfrage an die Logout-Route sendet.
- **Responsive Design:** Ein Hamburger-Menü für mobile Geräte, das die Navigation ein- und ausblendet.

## Benutzer authentifizieren nach Registrierung

Eine weitere Sache, die wir hinzufügen möchten, ist das automatische Einloggen des Benutzers direkt nach der Registrierung.

Öffne die `RegisterController` Klasse und füge die folgende Importzeile hinzu:

```php
use Illuminate\Support\Facades\Auth;
```

Füge dann in der `store` Methode die folgende Zeile direkt vor der Weiterleitung hinzu:

```php
Auth::login($user);
```

Jetzt wird der Benutzer automatisch nach der Registrierung eingeloggt.

## Zusammenfassung

- **Controller erstellen:** `LoginController` und `RegisterController` für die Handhabung von Login und Registrierung.
- **Routen definieren:** Routen für Anzeigen und Verarbeiten der Formulare festlegen und benennen.
- **Registrierungsprozess:** Validierung, Passwort-Hashing, Benutzererstellung und automatisches Einloggen.
- **Login-Prozess:** Validierung der Anmeldeinformationen, Authentifizierung und Session-Management.
- **Abmelden:** Möglichkeit, sich abzumelden und die Session zu invalidieren.
- **`@auth` Direktive:** Anzeige von Links basierend auf dem Authentifizierungsstatus.
- **Sicherheitsmaßnahmen:** Verwendung von CSRF-Tokens und Session-Regeneration zur Sicherung der Anwendung.

Durch diese Schritte haben wir ein grundlegendes, benutzerdefiniertes Authentifizierungssystem in Laravel aufgebaut, das sicher und wartbar ist. In den nächsten Schritten können wir weitere Authentifizierungsfunktionen hinzufügen und die Benutzererfahrung weiter verbessern.