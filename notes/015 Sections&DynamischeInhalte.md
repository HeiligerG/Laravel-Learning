# Blade Components: Sections und Dynamische Inhalte

Components in Laravel erlauben es, wiederverwendbare und dynamische UI-Bausteine zu erstellen. Durch Props und Slots lassen sich Inhalte flexibel steuern. Hier erweitern wir das Konzept um eine Sektion, die beispielsweise einen Banner am Seitenende (Bottom-Banner) darstellen kann.

## Erstellen einer neuen Komponente

Mit Artisan lässt sich eine neue Komponente schnell generieren:

```bash
php artisan make:component BottomBanner
```

Dies erstellt zwei Dateien:

- `app/View/Components/BottomBanner.php` – Die PHP-Klasse für Logik (meist minimal, oft nicht mal notwendig).
- `resources/views/components/bottom-banner.blade.php` – Das Blade-Template der Komponente.

## Dynamische Inhalte per Props

In der `bottom-banner.blade.php` setzen wir Props, um Überschriften, Unterüberschriften und andere Inhalte dynamisch zu gestalten:

```blade
@props(['heading' => 'Looking to hire?', 'subheading' => 'Post your job listing now and find the perfect candidate.'])

<section class="container mx-auto my-6">
    <div class="bg-blue-800 text-white rounded p-4 flex items-center justify-between flex-col md:flex-row gap-4">
        <div>
            <h2 class="text-xl font-semibold">{{ $heading }}</h2>
            <p class="text-gray-200 text-lg mt-2">
                {{ $subheading }}
            </p>
        </div>
        <x-button-link url="/jobs/create" icon="edit">Create Job</x-button-link>
    </div>
</section>
```

**Erläuterung:**

- `@props(['heading' => '...', 'subheading' => '...'])`  
  Definiert zwei Props mit Standardwerten. Wenn die Komponente ohne Props aufgerufen wird, verwendet sie diese Standardwerte.
  
- `{{ $heading }}` und `{{ $subheading }}`  
  Geben die dynamischen Inhalte aus. Sie können zur Laufzeit geändert werden, ohne das Template anpassen zu müssen.

- `<x-button-link />`  
  Hier wird eine bereits bestehende Button-Komponente eingebunden. Somit können wir UI-Bausteine kombinieren, um komplexere Komponenten aus einfachen Bausteinen aufzubauen.

## Verwendung der Komponente

In einer beliebigen Blade-View (z. B. `resources/views/jobs/index.blade.php` oder in einer Layout-View):

```blade
<x-layout>
    <h1>Welcome to Holyworkopia</h1>
    <x-bottom-banner />
</x-layout>
```

**Ergebnis:**  
Die Seite zeigt nun unter der Überschrift "Welcome to Holyworkopia" den Banner an, der von der `BottomBanner`-Komponente stammt. Da wir keine Props übergeben haben, werden die Standardwerte verwendet.

### Props überschreiben

Möchte man für eine bestimmte Seite andere Texte oder Inhalte setzen, übergibt man Props direkt in der Verwendung:

```blade
<x-layout>
    <h1>Our Job Listings</h1>
    <x-bottom-banner
        heading="Ready to expand your team?"
        subheading="Post your job today and reach thousands of potential candidates."
    />
</x-layout>
```

**Ergebnis:**  
Der Banner zeigt nun den neuen Heading- und Subheading-Text an, ohne dass wir den Code in der Komponente selbst ändern mussten.

## Vorteile dieses Ansatzes

- **Wiederverwendbarkeit:** Einmal definierte Komponenten können in beliebig vielen Views genutzt werden.
- **Modularität:** Komponenten lassen sich kombinieren und aufeinander aufbauen, was die Entwicklung und Wartung großer Projekte vereinfacht.
- **Konsistente UI:** Durch zentrale Komponenten hat man ein einheitliches Look & Feel im gesamten Projekt.
- **Einfache Änderungen:** Texte oder Stile können für jeden Einsatzort individuell überschrieben werden, ohne den Quellcode der Komponente anpassen zu müssen.

## Fazit

Das Arbeiten mit Components und Props in Laravel Blade macht den Code sauber, strukturiert und leicht wartbar. Mit jeder neuen Komponente wächst ein Baukasten wiederverwendbarer und anpassbarer UI-Elemente, der die Entwicklungs- und Pflegekosten langfristig reduziert.