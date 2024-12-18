# Blade Templating Engine

Blade ist die von Laravel bereitgestellte Template-Engine. Sie wird intern in PHP-Code kompiliert, was sehr performant ist, und bietet zudem eine Reihe spezieller Blade-Direktiven, die das Arbeiten mit Views stark vereinfachen. 

## Ausgabe von Variablen

Während man in reinem PHP-Code Variablen mit `echo` oder `<?php echo $variable; ?>` ausgibt, kann man in Blade einfach die doppelt geschweiften Klammern verwenden:

```blade
<h1>{{ $title }}</h1>
<ul>
    @foreach ($jobs as $job)
        <li>{{ $job }}</li>
    @endforeach
</ul>
```

**Sicherheitsmechanismus:**  
Blade escapt automatisch HTML-Sonderzeichen. Damit sind Variablen und Eingaben vor potenziellen XSS-Angriffen geschützt. Man braucht also nicht explizit `htmlspecialchars()` aufzurufen.

## Bedingte Anweisungen

Blade bietet eigene Direktiven für bedingte Ausgaben, z. B. `@if`, `@else`, `@endif`. Damit kann man elegant Standardwerte definieren, wenn ein Array leer ist:

```blade
@if(!empty($jobs))
    <ul>
        @foreach($jobs as $job)
            <li>{{ $job }}</li>
        @endforeach
    </ul>
@else
    <p>No Jobs Available</p>
@endif
```

## Vereinfachung durch `@forelse`

Mit der `@forelse`-Direktive lässt sich die zuvor kombinierte `@if`- und `@foreach`-Logik noch weiter vereinfachen:

```blade
<ul>
    @forelse ($jobs as $job)
        <li>{{ $job }}</li>
    @empty
        <li>No Jobs available</li>
    @endforelse
</ul>
```

**Erklärung:**
- `@forelse` iteriert über `$jobs`.
- Falls `$jobs` leer ist, wird automatisch der `@empty`-Block ausgeführt.

## Loop-Variablen

Blade stellt innerhalb von Schleifen spezielle Loop-Variablen zur Verfügung. Zum Beispiel kann man auf den aktuellen Index mit `$loop->index` zugreifen:

```blade
<ul>
    @forelse ($jobs as $job)
        <li>{{ $loop->index }} - {{ $job }}</li>
    @empty
        <li>No Jobs available</li>
    @endforelse
</ul>
```

Beispielausgabe:

```
Available Jobs
0 - Web Developer
1 - Database Administrator
2 - Software Engineer
3 - System Analyst
```

Man kann auch auf weitere Eigenschaften des `$loop`-Objekts zugreifen, wie `isFirst`, `isLast`, `count` usw. So kann man beispielsweise das letzte Element der Liste speziell kennzeichnen:

```blade
<ul>
    @forelse ($jobs as $job)
        @if($loop->last)
            <li>Last: {{ $job }}</li>
        @else
            <li>{{ $job }}</li>
        @endif
    @empty
        <li>No Jobs available</li>
    @endforelse
</ul>
```

Beispielausgabe:

```
Available Jobs
Web Developer
Database Administrator
Software Engineer
Last: System Analyst
```

## Zusammenfassung

- **Blade-Direktiven** erleichtern das Arbeiten mit Views enorm.
- **{{ $variable }}**: Einfache, sichere Ausgabe von Variablen.
- **@if, @foreach, @forelse**: Klar strukturierte, lesbare Steuerung von bedingten Ausgaben und Schleifen.
- **@empty, $loop->index, $loop->last**: Praktische Helfer, um Standardwerte anzuzeigen oder Schleifendurchläufe gezielt zu formatieren.

Blade macht das Erstellen von dynamischen, sicheren und übersichtlichen Templates deutlich angenehmer. Die automatische Escapefunktion, intuitive Direktiven und Loop-Variablen sorgen für klaren, wartbaren und lesbaren View-Code.
