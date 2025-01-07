# Suchkomponente & Route in Laravel

## Überblick
Diese Dokumentation beschreibt die Implementierung einer wiederverwendbaren Suchkomponente in einer Laravel-Anwendung, mit besonderem Fokus auf die Verwendung von Closures und Query Builder.

## Komponenten-Erstellung
Die Suchkomponente wird mit folgendem Artisan-Befehl erstellt:
```bash
php artisan make:component Search
```

## Wichtige Konzepte

### 1. Closures in Laravel Queries
Ein besonders wichtiges Konzept in diesem Code ist die Verwendung von Closures (anonyme Funktionen) in Datenbankabfragen:

```php
$query->where(function ($q) use ($keywords) {
    $q->whereRaw('LOWER(title) like ?', ['%' . $keywords . '%'])
      ->orWhereRaw('LOWER(description) like ?', ['%' . $keywords . '%']);
});
```

**Detaillierte Erklärung:**
- Eine Closure ist eine anonyme Funktion, die ihren eigenen Scope hat
- `use ($keywords)` ermöglicht den Zugriff auf die äußere Variable innerhalb der Closure
- Dies ist besonders nützlich für komplexe Queries, da mehrere Bedingungen gruppiert werden können
- Ohne `use` wäre die `$keywords` Variable innerhalb der Closure nicht verfügbar

### 2. Query Builder Methoden
Der Code nutzt verschiedene Query Builder Methoden:

- `whereRaw()`: Erlaubt Raw-SQL für case-insensitive Suche
- `orWhereRaw()`: Fügt OR-Bedingungen hinzu
- `paginate()`: Implementiert Pagination für die Suchergebnisse

## Kernfunktionalitäten

### Suchlogik
Die Hauptsuchfunktion beinhaltet:
1. Umwandlung der Eingaben in Kleinbuchstaben
2. Dynamische Query-Erstellung basierend auf Eingabefeldern
3. Case-insensitive Suche durch LOWER()-Funktion
4. Durchsuchung mehrerer Felder (Titel, Beschreibung, Adresse)

### Formular-Persistenz
- Suchparameter bleiben durch `value="{{ request('keywords') }}"` erhalten
- Implementierung eines "Zurück"-Buttons bei aktiver Suche

## Best Practices
- Wiederverwendbare Komponenten durch Blade-Components
- Saubere Trennung von Layout und Logik
- Effiziente Datenbankabfragen durch Query Builder
- Benutzerfreundlichkeit durch Formular-Persistenz

## Technische Details

### Route-Definition
```php
Route::get('/jobs/search', [JobController::class, 'search'])->name('jobs.search');
```

### Controller-Methode
Die search-Methode im JobController handhabt:
- Eingabevalidierung
- Query-Aufbau
- Ergebnispaginierung
- View-Rendering

## Hinweise für Entwickler
- Beachten Sie die Case-Sensitivity bei Suchen
- Nutzen Sie die Query Builder Methoden für optimale Performance
- Verwenden Sie Closures für komplexe Bedingungen
- Denken Sie an die Wiederverwendbarkeit der Komponenten