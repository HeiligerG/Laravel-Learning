# Dashboard Controller und Ansicht

Die Dashboard-Seite wird ein Formular mit dem Namen und der E-Mail-Adresse des Benutzers enthalten. Der Benutzer kann seinen Namen und seine E-Mail-Adresse über dieses Formular aktualisieren, indem er es an die Profil-Controller-Methode sendet, die wir bald aktualisieren werden. Außerdem wird es die Job-Listings des Benutzers und alle Bewerber-Einreichungen zu diesen Job-Listings enthalten.

## Dashboard Controller

Erstellen wir einen neuen Controller für das Dashboard:

```bash
php artisan make:controller DashboardController
```

Füge dem Controller eine `index` Methode hinzu:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        // Den authentifizierten Benutzer abrufen
        $user = Auth::user();

        // Alle Job-Listings für den authentifizierten Benutzer abrufen
        $jobs = Job::where('user_id', $user->id)->get();

        return view('dashboard', compact('user', 'jobs'));
    }
}
```

Wir holen den Benutzer und alle Job-Listings für den authentifizierten Benutzer. Anschließend übergeben wir den Benutzer und die Job-Listings an die Ansicht.

## Dashboard Route

Fügen wir unsere Route hinzu. Öffne die Datei `routes/web.php` und füge den folgenden Import hinzu:

```php
use App\Http\Controllers\DashboardController;
```

Füge die Route hinzu und wende das `auth` Middleware an:

```php
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
```

## Profile Ansicht

Erstelle eine neue Ansicht im Verzeichnis `resources/views/dashboard` namens `index.blade.php`. Füge den folgenden Inhalt hinzu:

```html
<x-layout> Dashboard </x-layout>
```

Stelle sicher, dass die Seite angezeigt wird, wenn du zu `/dashboard` gehst. Es sollte bereits einen Link zur Dashboard-Seite in der Navigationsleiste geben.

In der nächsten Lektion werden wir das Formular zum Aktualisieren des Namens und der E-Mail-Adresse des Benutzers hinzufügen.

# Dashboard Benutzer-Job-Listings

Nun möchten wir, dass die Job-Listings des Benutzers auf seiner Dashboard-Seite angezeigt werden. Wir haben bereits alles vorbereitet. Im Controller übergeben wir die Job-Listings an die Ansicht.

Füge Folgendes zur Dashboard-Ansicht hinzu:

```html
<div class="bg-white p-8 rounded-lg shadow-md w-full">
  <h3 class="text-3xl text-center font-bold mb-4">Meine Job Listings</h3>
  @forelse ($jobs as $job)
  <div
    class="flex justify-between items-center border-b-2 border-gray-200 py-2"
  >
    <div>
      <h3 class="text-xl font-semibold">{{ $job->title }}</h3>
      <p class="text-gray-700">{{ $job->job_type }}</p>
    </div>
   <div class="flex space-x-4">
      <a
        href="{{ route('jobs.edit', $job->id) }}"
        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm"
        >Edit</a
      >
      <form
        method="POST"
        action="{{ route('jobs.destroy', $job->id) }}"
        onsubmit="return confirm('Bist du sicher, dass du diesen Job löschen möchtest?');"
      >
        @csrf
        @method('DELETE')
        <button
          type="submit"
          class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm"
        >
          Delete
        </button>
      </form>
    </div>
  </div>
  @empty
  <p class="text-gray-700">Du hast keine Job Listings.</p>
  @endforelse
</div>
```

## Delete-Weiterleitung kontrollieren

Derzeit werden die Jobs korrekt angezeigt und du kannst sie mit den Buttons bearbeiten und löschen. Allerdings wirst du beim Löschen eines Jobs von der Dashboard-Seite zur Startseite weitergeleitet. Das möchte ich nicht. Ich möchte auf der Dashboard-Seite bleiben, wenn wir von dieser Seite aus löschen.

Zuerst müssen wir der Löschformular-Aktion einen Query-String hinzufügen. Öffne die Datei `resources/views/dashboard/index.blade.php` und füge Folgendes zum Löschformular hinzu:

```php
<form method="POST" action="{{ route('jobs.destroy', $job->id) }}?from=dashboard" onsubmit="return confirm('Bist du sicher, dass du diesen Job löschen möchtest?');">
```

Wir haben `?from=dashboard` am Ende der Route hinzugefügt. Dies fügt einen Query-String zur URL hinzu, wenn das Formular abgesendet wird.

Öffne die Datei `app/Http/Controllers/JobController.php` und bearbeite die `destroy` Methode, indem du diese Zeile direkt über der vorhandenen Weiterleitung hinzufügst:

```php
 // Überprüfen, ob die Anfrage von der Dashboard-Seite kam
if (request()->query('from') === 'dashboard') {
    return redirect()->route('dashboard.index')->with('success', 'Job Listing erfolgreich gelöscht!');
}
```

Nun wirst du beim Löschen eines Jobs von der Dashboard-Seite auf dieser Seite bleiben.

Du kannst `php artisan db:seed` ausführen, um die Listings zurückzubekommen, wenn du sie gelöscht hast.