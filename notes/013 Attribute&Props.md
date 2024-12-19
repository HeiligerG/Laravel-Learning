# Laravel Blade Components: Attribute vs. Props

**Grundlagen:**  
In Laravel Blade Components unterscheidet man zwischen Attributen und Props:

- **Attribute:** Vordefinierte HTML-Attribute, die direkt im Komponententag gesetzt werden können, z. B. `class`, `id`, `title`.
- **Props:** Individuell definierte Parameter, die man einer Komponente übergeben kann. Diese werden in der Komponente mit `@props()` als Variablen definiert und können dann in der Blade-Template-Logik und im Markup genutzt werden.

## Beispiel: Einfache Komponente mit Slots

Erstellt mit Artisan:

```bash
php artisan make:component NavLink
```

Erzeugt zwei Dateien:
- `app/View/Components/NavLink.php` (Klasse, Logik der Komponente)
- `resources/views/components/nav-link.blade.php` (Template der Komponente)

### Einfacher Slot

In `nav-link.blade.php`:

```blade
<a>
    {{ $slot }}
</a>
```

**Verwendung:**  
```blade
<x-nav-link>Home</x-nav-link>
```

Der Inhalt zwischen `<x-nav-link>` und `</x-nav-link>` erscheint anstelle von `{{ $slot }}`.

## Props: Individuelle Parameter für Komponenten

Mit `@props()` können Variablen (Props) definiert werden, um bestimmte Werte an die Komponente zu übergeben. Dies ist nützlich für dynamische URLs, Klassen oder Zustände (z. B. ob ein Link aktiv ist).

### Props Definieren

In `nav-link.blade.php`:

```blade
@props(['url' => '/', 'active' => false])

<a href="{{ $url }}" class="text-white hover:underline py-2 {{ $active ? 'text-yellow-500 font-bold' : '' }}">
    {{ $slot }}
</a>
```

Hier haben wir zwei Props definiert:

- `$url` mit Standardwert `'/'`
- `$active` mit Standardwert `false`

### Props Verwenden

Wenn die Komponente eingebunden wird, können diese Props überschrieben werden:

```blade
<x-nav-link url="/" :active="request()->is('/')">Home</x-nav-link>
```

- `:active="request()->is('/')"` wertet die Anfrage-URL aus. Ist sie `'/'`, wird `$active` auf `true` gesetzt, sonst auf `false`.
- Da `url` bereits den Standardwert `'/'` hat, müsste man es nicht zwingend angeben, es ist aber zur Klarheit hilfreich.

### Erweiterte Props (Icons, Styles)

Man kann Props beliebig erweitern:

```blade
@props(['url' => '/', 'active' => false, 'icon' => null])

<a href="{{ $url }}" class="text-white hover:underline py-2 {{ $active ? 'text-yellow-500 font-bold' : '' }}">
    @if($icon)
        <i class="fa fa-{{ $icon }} mr-1"></i>
    @endif
    {{ $slot }}
</a>
```

Verwendung mit Icon:

```blade
<x-nav-link url="/dashboard" :active="request()->is('dashboard')" icon="gauge">Dashboard</x-nav-link>
```

**Ergebnis:**  
Ein Link mit einem Icon davor, der aktiv markiert wird, wenn sich der Nutzer auf `/dashboard` befindet.

### Dynamische Klassen per Props

Man kann auch Props für dynamische Styles verwenden:

```blade
@props(['url' => '/', 'icon' => null, 'bgClass' => 'bg-yellow-500', 'hoverClass' => 'hover:bg-yellow-600', 'textClass' => 'text-black'])

<a href="{{ $url }}" class="{{ $bgClass }} {{ $hoverClass }} {{ $textClass }} py-2">
    @if($icon)
        <i class="fa fa-{{ $icon }} mr-1"></i>
    @endif
    {{ $slot }}
</a>
```

In der Verwendung kann man nun spezifisch andere Klassen übergeben, um verschiedene Farbvarianten derselben Komponente zu erzeugen.

## Fazit

- **Slots**: Platzhalter für Inhalt zwischen Komponententags.
- **Props**: Anpassbare Variablen, um Komponenten flexibel zu gestalten (URLs, Zustände, Icons, Style-Klassen).
- **Attribute**: Standard-HTML-Attribute, aber Props bieten mehr Kontrolle und Dynamik.

Dank Props und Slots lassen sich Komponenten in Laravel Blade einfach wiederverwenden, anpassen und dynamisieren, was zu einem sauberen, konsistenten und flexiblen UI-Code führt.