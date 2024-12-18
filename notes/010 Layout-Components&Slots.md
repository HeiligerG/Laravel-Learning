# Blade Components in Laravel

Components sind eine moderne und flexible Methode, um wiederverwendbare UI-Bausteine in Laravel-Apps zu erstellen. Sie bieten eine saubere Trennung von Logik und Darstellung und vereinfachen das Einbinden von wiederkehrenden Layout-Elementen.

## Vorteile von Components

- **Wiederverwendbare UI-Bausteine:** Einmal definieren, überall nutzen.
- **Sauberer Code:** Keine langen `@yield`- und `@section`-Blöcke notwendig.
- **Klare Struktur:** Komponenten liegen in `resources/views/components` und ihre Logik in `app/View/Components`.

## Erstellen einer Component

Mit Artisan kann man einfach eine neue Component erstellen:

```bash
php artisan make:component Header
```

Dieser Befehl erzeugt zwei Dateien:

1. `app/View/Components/Header.php`: Enthält die Logik der Komponente.
2. `resources/views/components/header.blade.php`: Die View, in der das HTML der Komponente definiert wird.

### Einbinden einer Component

Hat man z. B. eine `header.blade.php` mit einem simplen Header, kann man diesen im Layout einbinden, indem man den Komponententag `<x-header />` verwendet:

```blade
<!-- layout.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <x-header />
</head>
<body>
    {{ $slot }}
</body>
</html>
```

> **Hinweis:** `$slot` ist eine Variable, mit der man in Components den Inhalt aus dem umschließenden Tag einfügt.

## Layout-Components & Slots

Layouts lassen sich auch als Components abbilden. So kann man statt `@extends('layout')` einfach `<x-layout>` nutzen und Inhalte über `$slot` einfügen.

### Beispiel: Layout Component erstellen

```bash
php artisan make:component Layout
```

Erstellt:
- `app/View/Components/Layout.php`
- `resources/views/components/layout.blade.php`

In der `layout.blade.php` könnte etwa stehen:

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Holyworkopia | Find and list jobs' }}</title>
</head>
<body>
    <x-header />
    {{ $slot }}
</body>
</html>
```

**Erklärung:**
- `{{ $slot }}` ist ein Platzhalter für den Inhalt, den man zwischen `<x-layout>` und `</x-layout>` schreibt.
- `{{ $title ?? '...' }}` definiert einen Standardtitel, falls keiner gesetzt ist.

### Verwenden der Layout Component

Statt `@extends('layout')` in einer View schreibt man:

```blade
<x-layout>
    <h1>Welcome to Holyworkopia</h1>
</x-layout>
```

**Titel anpassen:**  
Möchte man einen individuellen Titel setzen, kann man dafür `x-slot` verwenden:

```blade
<x-layout>
    <x-slot name="title">Create Job</x-slot>
    <h1>Create New Job</h1>
</x-layout>
```

**Erklärung:**
- `<x-slot name="title">` überschreibt den Standard-Titel in der Layout-Komponente.

## Partials vs. Components

Zuvor verwendete Partials (`@include('partials.navbar')`) kann man nach und nach durch Components ersetzen, um logiklastigere oder wiederverwendbare Strukturen besser zu kapseln.

- **Partials:** Eher für einfache, statische Code-Fragmente.
- **Components:** Dynamischer, können Logik enthalten, Daten entgegennehmen und Slots bieten.

## Fazit

- **Components** sind die moderne Lösung in Laravel, um wiederverwendbare Layouts und Bestandteile zu erstellen.
- Das Layout lässt sich als Component definieren und über Slots kann man Inhalte dynamisch einfügen.
- Durch `x-slot` kann man bestimmte Bereiche des Layouts (z. B. den Titel) individuell überschreiben.
- Components tragen zu einem aufgeräumten, modularen Code bei und vereinfachen die Wiederverwendbarkeit von UI-Elementen.