# Einfaches Job-Paginierungssystem

Derzeit werden alle Jobs auf einmal angezeigt, selbst wenn es Hunderte von ihnen gibt. Das ist keine gute Idee. Wir sollten sie paginieren. Laravel verfügt über ein integriertes Paginierungssystem. Wir werden dieses verwenden, um die Jobs zu paginieren.

## Job Controller

Der erste Schritt besteht darin, die `index` Methode im `JobController` zu bearbeiten, um die Jobs zu paginieren. Ändere den folgenden Code:

```php
$jobs = Job::all();
```

zu diesem:

```php
$jobs = Job::paginate(3);
```

Ich verwende nur `3`, um es zu testen. Später werde ich die Zahl erhöhen.

Wenn du zur Route `/jobs` gehst, siehst du nur drei Listings. Wenn du manuell `/jobs?page=2` eingibst, siehst du die nächsten drei Listings.

## Links hinzufügen

Jetzt fügen wir die Paginierungslinks hinzu. Öffne die Datei `resources/views/jobs/index.blade.php` und füge den folgenden Code direkt über dem schließenden `</x-layout>` hinzu:

```html
<!-- Paginierungslinks -->
<div class="mt-4">{{ $jobs->links() }}</div>
```

Es ist so einfach, Paginierung in Laravel hinzuzufügen.

Ein Problem dabei ist jedoch, dass du an den Stil der Paginierungslinks gebunden bist. Außerdem hast du derzeit nur „Vorherige“ und „Nächste“-Buttons und keine einzelnen Seitennummern. Wir können dies ändern, indem wir die Paginierungsansicht veröffentlichen und anpassen. Ich zeige dir, wie das in der nächsten Lektion funktioniert.

# Paginierungsansicht anpassen

Derzeit haben wir einen „Vorherige“ und „Nächste“-Button, aber was ist, wenn wir sie anders stylen und einzelne Seitennummern hinzufügen möchten? Derzeit ist dieser Code nicht in unseren Ansichten verfügbar. Allerdings können wir die Paginierungsansicht veröffentlichen und anpassen.

Öffne ein Terminal und führe den folgenden Befehl aus:

```bash
php artisan vendor:publish --tag=laravel-pagination
```

Dies veröffentlicht die Paginierungsansicht in das Verzeichnis `resources/views/vendor/pagination`. Es werden mehrere Dateien dort vorhanden sein, abhängig davon, welches CSS-Framework du verwendest. Ich verwende Tailwind CSS, daher werde ich die Datei `tailwind.blade.php` bearbeiten.

Öffne die Datei `resources/views/vendor/pagination/tailwind.blade.php` und lösche zunächst den gesamten Code. Füge dann den folgenden Code hinzu:

```html
@if ($paginator->hasPages())
<nav
  role="navigation"
  aria-label="Paginierungsnavigation"
  class="flex justify-center"
>
  {{-- Link zur vorherigen Seite --}}
  @if ($paginator->onFirstPage())
    <span class="px-4 py-2 bg-gray-300 text-gray-500 rounded-l-lg">Vorherige</span>
  @else
    <a
      href="{{ $paginator->previousPageUrl() }}"
      rel="prev"
      class="px-4 py-2 bg-blue-500 text-white rounded-l-lg hover:bg-blue-600"
      >Vorherige</a
    >
  @endif

  {{-- Paginierungselemente --}}
  @foreach ($elements as $element)
    {{-- "Drei Punkte" Separator --}}
    @if (is_string($element))
      <span class="px-4 py-2 bg-gray-300 text-gray-500">{{ $element }}</span>
    @endif

    {{-- Array von Links --}}
    @if (is_array($element))
      @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
          <span class="px-4 py-2 bg-blue-500 text-white">{{ $page }}</span>
        @else
          <a
            href="{{ $url }}"
            class="px-4 py-2 bg-gray-200 text-gray-700 hover:bg-blue-600 hover:text-white"
            >{{ $page }}</a
          >
        @endif
      @endforeach
    @endif
  @endforeach

  {{-- Link zur nächsten Seite --}}
  @if ($paginator->hasMorePages())
    <a
      href="{{ $paginator->nextPageUrl() }}"
      rel="next"
      class="px-4 py-2 bg-blue-500 text-white rounded-r-lg hover:bg-blue-600"
      >Nächste</a
    >
  @else
    <span class="px-4 py-2 bg-gray-300 text-gray-500 rounded-r-lg">Nächste</span>
  @endif
</nav>
@endif
```

Wir verwenden das gleiche HTML und die gleichen Stile wie in unserem Template. Wir machen es nur dynamisch, indem wir Schleifen, bestimmte Direktiven und Variablen verwenden.

Du solltest jetzt die neue Paginierung mit den einzelnen Seitennummern sehen. Du kannst sie weiter anpassen, indem du mehr Klassen hinzufügst oder die Stile änderst.

Ändern wir nun die Anzahl der Listings von 3 auf 12, da wir mit der Paginierung fertig sind. Öffne die Datei `app/Http/Controllers/JobController.php` und bearbeite die Zeile in der `index` Methode:

```php
$jobs = Job::paginate(12);
```

Jetzt, wenn du weniger als 12 Listings hast, siehst du die Paginierungslinks nicht mehr.