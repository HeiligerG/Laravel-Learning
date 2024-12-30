# Profile Controller & Benutzerinformationen aktualisieren

Wir müssen ein Formular auf der Dashboard-Seite hinzufügen, das die Informationen des Benutzers anzeigt, und ermöglichen, diese Informationen zu aktualisieren. Ich werde einen separaten Controller dafür erstellen, da dies mehr mit dem Benutzer "Profil" zu tun hat.

## Formular zur Dashboard-Ansicht hinzufügen

Öffne die Datei `resources/views/dashboard/index.blade.php`. Ich möchte, dass das Profilformular und die Job-Listings nebeneinander angezeigt werden. Füge dazu am Anfang nach dem öffnenden `<x-layout>` folgendes hinzu:

```html
<section class="flex flex-col md:flex-row gap-6">
```

Am Ende schließe es direkt über dem schließenden `</x-layout>`. Ich werde auch die untere Banner-Komponente auf dem Dashboard anzeigen:

```html
</section>
<x-bottom-banner />
</x-layout>
```

Nun müssen wir folgendes über das Job-Listings-Div hinzufügen:

```html
<div class="bg-white p-8 rounded-lg shadow-md w-full md:w-1/2">
  <h3 class="text-3xl text-center font-bold mb-4">Profilinformationen</h3>
  <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-4">
      <label class="block text-gray-700" for="name">Name</label>
      <input id="name" type="text" name="name" value="{{ $user->name }}"
        class="w-full px-4 py-2 border rounded focus:outline-none" />
    </div>
    <div class="mb-4">
      <label class="block text-gray-700" for="email">Email</label>
      <input id="email" type="text" name="email" value="{{ $user->email }}"
        class="w-full px-4 py-2 border rounded focus:outline-none" />
    </div>
    <div class="mb-4">
      <label class="block text-gray-700" for="avatar">Profil-Avatar</label>
      <input id="avatar" type="file" name="avatar" class="w-full px-4 py-2 border rounded focus:outline-none" />
    </div>
    <button type="submit"
      class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none">Speichern</button>
  </form>
</div>
```

## Profile Controller

Erstellen wir einen neuen Profil-Controller:

```bash
php artisan make:controller ProfileController
```

Öffne den Controller und füge den Import für das Benutzer-Modell hinzu:

```php
use App\Models\User;
```

Füge nun die `update` Methode zum `ProfileController` hinzu:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Aktualisiert die Profilinformationen des Benutzers.
     */
    public function update(Request $request): RedirectResponse
    {
        // Den authentifizierten Benutzer abrufen
        $user = Auth::user();

        // Validierung der eingehenden Daten
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Benutzerinformationen aktualisieren
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        // Avatar bearbeiten, falls hochgeladen
        if ($request->hasFile('avatar')) {
            // Alten Avatar löschen, falls vorhanden
            if ($user->avatar) {
                Storage::delete('public/' . $user->avatar);
            }

            // Neuen Avatar speichern
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();

        // Zurück zur Dashboard-Seite mit Erfolgsmeldung
        return redirect()->route('dashboard')->with('success', 'Profil erfolgreich aktualisiert!');
    }
}
```

**Erklärung:**

- **Validierung:** Stellt sicher, dass der Name und die E-Mail korrekt eingegeben wurden und dass die E-Mail eindeutig ist, außer für den aktuellen Benutzer. Der Avatar ist optional und muss ein gültiges Bildformat haben.
- **Avatar-Verarbeitung:** Wenn ein neuer Avatar hochgeladen wird, wird der alte gelöscht (falls vorhanden) und der neue Avatar gespeichert.
- **Speichern der Änderungen:** Aktualisiert die Benutzerinformationen und speichert sie in der Datenbank.
- **Weiterleitung:** Leitet den Benutzer zurück zum Dashboard mit einer Erfolgsmeldung.

## Update Route hinzufügen

Du musst die Update-Route erstellen. Öffne die Datei `routes/web.php` und füge den folgenden Import hinzu:

```php
use App\Http\Controllers\ProfileController;
```

Füge nun die Route hinzu:

```php
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
```

## Avatar Migration

Wir müssen eine neue Spalte zur `users` Tabelle hinzufügen, um den Avatar zu speichern. Erstelle eine neue Migration dafür:

```bash
php artisan make:migration add_avatar_to_users_table --table=users
```

Öffne die erstellte Migrationsdatei und füge folgenden Code in die `up` Methode ein:

```php
Schema::table('users', function (Blueprint $table) {
    $table->string('avatar')->nullable()->after('email');
});
```

Füge folgenden Code in die `down` Methode ein:

```php
Schema::table('users', function (Blueprint $table) {
    $table->dropColumn('avatar');
});
```

Führe die Migration aus:

```bash
php artisan migrate
```

## Benutzer-Modell aktualisieren

Öffne die Datei `app/Models/User.php` und füge das neue Feld zur `$fillable` Eigenschaft hinzu:

```php
protected $fillable = [
    'name',
    'email',
    'password',
    'avatar',
];
```

## Avatar-Vorschau hinzufügen

Füge eine Vorschau des Avatars zur Profilseite hinzu. Füge folgendes direkt unter dem `h3` Tag am Anfang der Seite hinzu:

```html
@if($user->avatar)
<div class="mt-2 flex justify-center">
  <img
    src="{{ asset('storage/' . $user->avatar) }}"
    alt="Avatar"
    class="w-32 h-32 object-cover rounded-full"
  />
</div>
@endif
```

## Avatar in der Navigationsleiste anzeigen

Wir möchten den Avatar des Benutzers in der Navigationsleiste anzeigen. Falls der Benutzer keinen Avatar hat, soll ein Standard-Avatar angezeigt werden.

Es gibt ein Bild im Download für diese Lektion namens `default-avatar.png`. Du kannst dieses Bild als Standard-Avatar verwenden. Benenne das Bild in `default-avatar.png` um und platziere es im Verzeichnis `/storage/app/public/avatars/`.

### Header-Komponente aktualisieren

Öffne die Datei `resources/views/components/header.blade.php` und füge folgendes direkt unter dem "Create Job" Link hinzu. Es wird direkt vor dem `@else` sein, das aus der `@auth` Direktive stammt:

```html
<!-- Benutzer-Avatar -->
<div class="flex items-center space-x-3">
  @if(Auth::user()->avatar)
  <img
    src="{{ asset('storage/' . Auth::user()->avatar) }}"
    alt="{{ Auth::user()->name }}"
    class="w-10 h-10 rounded-full"
  />
  @else
  <img
    src="{{ asset('storage/avatars/default-avatar.png') }}"
    alt="{{ Auth::user()->name }}"
    class="w-10 h-10 rounded-full"
  />
  @endif
</div>
```

### Navigationsleiste neu anordnen

Wir werden die Navigationsleiste etwas umgestalten. Der Avatar wird zum Link zum Dashboard und der Logout-Link wird ans Ende verschoben.

Hier ist die finale Version der Datei `resources/views/components/header.blade.php`:

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
      <x-button-link url="/jobs/create" type="button" icon="edit">Job erstellen</x-button-link>

      <!-- Benutzer-Avatar -->
      <div class="flex items-center space-x-3">
        <a href="{{ route('dashboard') }}">
          @if(Auth::user()->avatar)
          <img
            src="{{ asset('storage/' . Auth::user()->avatar) }}"
            alt="{{ Auth::user()->name }}"
            class="w-10 h-10 rounded-full"
          />
          @else
          <img
            src="{{ asset('storage/avatars/default-avatar.png') }}"
            alt="{{ Auth::user()->name }}"
            class="w-10 h-10 rounded-full"
          />
          @endif
        </a>
      </div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-white">
          <i class="fa fa-sign-out"></i> Logout
        </button>
      </form>
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

- **Avatar-Anzeige:** Zeigt den Avatar des Benutzers in der Navigationsleiste an. Wenn kein Avatar vorhanden ist, wird ein Standard-Avatar angezeigt.
- **Neuanordnung der Links:** Der Avatar fungiert als Link zum Dashboard und der Logout-Button ist am Ende platziert.
- **Responsive Design:** Die Navigationsleiste bleibt responsiv und passt sich mobilen Geräten an.

## Zusammenfassung

- **Dashboard Controller erstellen:** Ein neuer Controller zur Verwaltung der Dashboard-Ansicht.
- **Route hinzufügen:** Eine geschützte Route für das Dashboard mit `auth` Middleware.
- **Profilformular hinzufügen:** Ein Formular zur Aktualisierung von Name, E-Mail und Avatar des Benutzers.
- **Profile Controller erstellen:** Ein Controller zur Verarbeitung der Aktualisierungen des Benutzerprofils.
- **Migration für Avatar:** Eine neue Spalte zur Speicherung des Avatars in der `users` Tabelle.
- **Benutzer-Modell aktualisieren:** Das Modell so erweitern, dass der Avatar massenweise zuweisbar ist.
- **Avatar-Vorschau und Anzeige:** Eine Vorschau des Avatars auf der Profilseite und in der Navigationsleiste hinzufügen.
- **Navigationsleiste neu gestalten:** Den Avatar als Link zum Dashboard und den Logout-Button am Ende platzieren.