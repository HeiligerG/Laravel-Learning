# Type Hinting & Blade Layouts in Laravel

## Type Hinting in Controllern

**Was ist Type Hinting?**  
Type Hinting bedeutet, in PHP (und somit auch in Laravel) den erwarteten Typ von Parametern oder Rückgabewerten anzugeben. Dies erhöht die Lesbarkeit, Wartbarkeit und Fehlersicherheit des Codes, da frühzeitig sichergestellt wird, dass Funktionen mit den korrekten Datentypen arbeiten.

**Vorteile:**  
- Bessere IDE-Unterstützung (Autocomplete, Fehlermeldungen).
- Klare Dokumentation des erwarteten Rückgabe- oder Parameter-Typs.
- Verbesserte Wartbarkeit und Lesbarkeit.

**Beispiel:**  
```php
use Illuminate\Http\Request;
use Illuminate\View\View;

public function create() : View
{
    return view('jobs.create');
}

public function store(Request $request) : string
{
    return 'Store';
}
```

Hier geben wir explizit an, dass `create()` ein `View`-Objekt zurückgibt und `store()` einen String. Typen wie `View`, `Request`, `Response`, `JsonResponse`, `RedirectResponse` usw. können importiert und verwendet werden.

**Gängige Typen in Laravel:**
- `Illuminate\Http\Request`
- `Illuminate\Http\Response`
- `Illuminate\Http\JsonResponse`
- `Illuminate\Http\RedirectResponse`
- `Illuminate\View\View`
- `Illuminate\Support\Collection`

**Fazit:** Type Hinting ist optional, aber Best Practice für sauberen, robusten Code.

---

## Blade Layouts

Oft wiederholen sich HTML-Elemente auf jeder Seite (z. B. Header, Footer, Navigation). Laravel’s Blade-Templating-Engine bietet Layouts und Sections, um wiederholenden Code auszulagern und einfach wiederzuverwenden.

### Grundprinzip

- **Layout-View:** Eine Hauptvorlage, die allgemeine Strukturen wie `header`, `footer`, `nav` usw. enthält.
- **Kind-Views:** Seiten, die den Layout erben und nur ihren spezifischen Inhalt einfügen.

### Beispiel: Layout-View (z. B. `resources/views/layout.blade.php`)

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Holyworkopia | Find and list jobs')</title>
</head>
<body>
    @include('partials.navbar')

    <h1>Welcome to Holyworkopia</h1>
    <main class="container mx-auto p-4 mt-4">
        @yield('content')
    </main>
</body>
</html>
```

**Erklärung:**
- `@yield('content')` markiert einen Platzhalter, an dem der spezifische Inhalt von Unter-Views eingefügt wird.
- `@yield('title', 'Holyworkopia | Find and list jobs')` definiert einen Standardwert für den Titel. Wenn in der Kind-View kein Titel definiert wird, wird dieser Standard-Titel verwendet.
- `@include('partials.navbar')` bindet eine Partial-View ein.

### Kind-View (z. B. `resources/views/jobs/create.blade.php`)

```blade
@extends('layout')

@section('title')
    Create New Job
@endsection

@section('content')
<h1>Create New Job</h1>
<form action="/jobs" method="POST">
    @csrf
    <input type="text" name="title" placeholder="title">
    <input type="text" name="description" placeholder="description">
    <button type="submit">Submit</button>
</form>
@endsection
```

**Erklärung:**
- `@extends('layout')` bestimmt, dass diese View das `layout.blade.php`-Layout verwendet.
- `@section('title')` überschreibt den Standard-Titel.
- `@section('content')` füllt den Content-Platzhalter aus dem Layout.

### Partials

Partials sind kleine, wiederverwendbare Views, die zum Beispiel Navigationselemente, Footer oder Sidebar enthalten. Man legt sie z. B. in `resources/views/partials/navbar.blade.php` ab und bindet sie bei Bedarf ein:

```blade
@include('partials.navbar')
```

**Beispiel für eine Partial: `partials/navbar.blade.php`**

```blade
<nav class="bg-gray-800 text-white p-4">
    <a href="/">Home</a>
    <a href="/jobs">Jobs</a>
</nav>
```

Nun wird die Navbar in jedem Template, in dem `@include('partials.navbar')` steht, angezeigt.

---

## Zusammenfassung

- **Type Hinting in Controllern:** Erhöht Lesbarkeit und Wartbarkeit; empfiehlt sich für gute Code-Qualität.
- **Blade Layouts:** Ermöglichen die Verwendung einer zentralen Hauptvorlage mit `@extends` und `@yield`-Direktiven, um redundanten Code zu vermeiden.
- **Sections & Yields:** Steuern, welcher Inhalt in den Hauptlayout-Platzhalter eingefügt wird.
- **Partials:** Vereinfachen das Einbinden wiederverwendbarer Code-Schnipsel (z. B. Navbar, Footer).

Diese Techniken sparen Zeit, erhöhen die Übersichtlichkeit und führen zu besser wartbarem, sauberem Code.