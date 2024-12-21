# Modellbindung und Datenbankinteraktion in Laravel

In diesem Abschnitt werden wir die **Modellbindung**, die **Speicherung von Formulardaten**, die **Formularvalidierung** und das **Fehlerhandling** in Laravel detailliert erläutern. Diese Konzepte sind essenziell für die effiziente und sichere Verwaltung von Daten in deiner Anwendung.

## 1. Modellbindung in der Controller-Methode `show`

### Code:

```php
public function show(Job $job) : string
{
    return view('jobs.show')->with('job', $job);
}
```

### Erklärung:

**Modellbindung** (Model Binding) ist eine Funktion in Laravel, die es ermöglicht, automatisch ein Modell anhand eines Routenparameters zu laden und es der Controller-Methode als Argument zu übergeben. Dies vereinfacht den Code und erhöht die Lesbarkeit.

- **Methodensignatur:**
  - `public function show(Job $job) : string`
    - **Job $job:** Durch das Type Hinting (`Job $job`) erkennt Laravel, dass es das `Job`-Modell anhand der ID aus der Route laden soll.
    - **: string:** Gibt an, dass die Methode einen String zurückgibt (kann je nach Kontext angepasst werden, z.B. `View`).

- **Methodeninhalt:**
  - `return view('jobs.show')->with('job', $job);`
    - **view('jobs.show'):** Lädt die Blade-View `jobs.show`.
    - **->with('job', $job):** Übergibt das geladene `Job`-Modell an die View als Variable `job`.

**Vorteile der Modellbindung:**
- **Automatisierung:** Laravel übernimmt das Laden des Modells basierend auf der Routen-ID.
- **Sauberer Code:** Reduziert die Notwendigkeit, manuell nach dem Modell zu suchen.
- **Fehlervermeidung:** Minimiert das Risiko von Fehlern beim Laden des Modells.

## 2. Darstellung der Daten in der View

### Code:

```blade
<x-layout>
    <h1 class="text-2xl">{{$job->title}}</h1>
    <p>{{$job->description}}</p>
</x-layout>
```

### Erklärung:

Diese Blade-Template zeigt die Details eines einzelnen `Job`-Eintrags an.

- **<x-layout>:** Verwendet eine Blade-Komponente namens `layout`, die als Grundgerüst für die Seite dient.
- **<h1 class="text-2xl">{{$job->title}}</h1>:**
  - **{{$job->title}}:** Gibt den `title`-Wert des `Job`-Modells aus.
  - **class="text-2xl":** Verwendet Tailwind CSS-Klassen zur Stilgestaltung (hier: Textgröße 2XL).
- **<p>{{$job->description}}</p>:**
  - **{{$job->description}}:** Gibt die `description` des `Job`-Modells aus.

**Vorteile:**
- **Wiederverwendbarkeit:** Die Layout-Komponente sorgt für ein konsistentes Design.
- **Dynamische Inhalte:** Die Daten werden direkt aus dem Modell geladen und angezeigt.

## 3. Verlinkung der einzelnen Job-Seiten in der Index-View

### Code:

```blade
<x-layout>
    <h1>Available Jobs</h1>
    <ul>
        @forelse($jobs as $job)
            <li>
                <a href="{{ route('jobs.show', $job->id) }}">
                    {{$job->title}} - {{$job->description}}
                </a>
            </li>
        @empty
            <li>No Jobs available</li>
        @endforelse
    </ul>
</x-layout>
```

### Erklärung:

Diese Blade-View listet alle verfügbaren Jobs auf und verlinkt jeden Job zu seiner Detailseite.

- **<x-layout>:** Verwendet die `layout`-Komponente als Grundgerüst.
- **<h1>Available Jobs</h1>:** Überschrift der Seite.
- **<ul>:** Ungeordnete Liste zur Darstellung der Jobs.
- **@forelse($jobs as $job):**
  - **$jobs:** Eine Sammlung von `Job`-Modellen, die vom Controller übergeben wurden.
  - **$job:** Ein einzelnes `Job`-Modell innerhalb der Schleife.
- **<li><a href="{{ route('jobs.show', $job->id) }}">{{$job->title}} - {{$job->description}}</a></li>:**
  - **route('jobs.show', $job->id):** Generiert die URL zur `show`-Methode des `JobController` für den aktuellen Job.
  - **{{$job->title}} - {{$job->description}}:** Zeigt den Titel und die Beschreibung des Jobs an.
- **@empty:**
  - **<li>No Jobs available</li>:** Wird angezeigt, wenn keine Jobs vorhanden sind.
- **@endforelse:** Beendet die `@forelse`-Schleife.

**Vorteile:**
- **Dynamische Verlinkung:** Jeder Job ist direkt zu seiner Detailseite verlinkt.
- **Benutzerfreundlichkeit:** Nutzer können leicht auf einzelne Jobangebote zugreifen.
- **Fehlerbehandlung:** Zeigt eine Nachricht an, wenn keine Jobs verfügbar sind.

## 4. Speicherung von Formulardaten mit der `store` Methode

### Code:

```php
public function store(Request $request) : RedirectResponse
{
    $title = $request->input('title');
    $description = $request->input('description');

    Job::create([
        'title' => $title,
        'description' => $description
    ]);

    return redirect()->route('jobs.index');
}
```

### Erklärung:

Die `store`-Methode verarbeitet die Daten eines Formulars, erstellt einen neuen Job-Eintrag und leitet den Nutzer zurück zur Job-Übersichtsseite.

- **Methodensignatur:**
  - `public function store(Request $request) : RedirectResponse`
    - **Request $request:** Enthält alle Daten, die vom Formular gesendet wurden.
    - **: RedirectResponse:** Gibt eine Weiterleitung als Antwort zurück.

- **Methodeninhalt:**
  - **$title = $request->input('title');**
    - Holt den Wert des `title`-Feldes aus dem Formular.
  - **$description = $request->input('description');**
    - Holt den Wert des `description`-Feldes aus dem Formular.
  - **Job::create([...]);**
    - Erstellt einen neuen Eintrag in der `job_listings`-Tabelle mit den angegebenen `title` und `description`.
  - **return redirect()->route('jobs.index');**
    - Leitet den Nutzer zur `jobs.index`-Route weiter, die typischerweise die Job-Übersichtsseite darstellt.

**Vorteile:**
- **Einfache Datenverarbeitung:** Holt die notwendigen Daten aus dem Request und erstellt den Eintrag.
- **Benutzerführung:** Nach dem Speichern wird der Nutzer zur Übersicht weitergeleitet.
- **Klarheit:** Der Code ist einfach und leicht verständlich.

## 5. Formularvalidierung mit dem Request-Objekt

### Code:

```php
$validatedData = $request->validate([
    'title' => 'required|string|max:255',
    'description' => 'required|string',
]);

Job::create([
    'title' => $validatedData['title'],
    'description' => $validatedData['description'],
]);
```

### Erklärung:

Dieser Abschnitt zeigt, wie Laravel die Validierung von Formulardaten übernimmt, bevor sie in die Datenbank gespeichert werden.

- **$request->validate([...]):**
  - **title:**
    - `required`: Das Feld muss ausgefüllt sein.
    - `string`: Der Inhalt muss ein String sein.
    - `max:255`: Die maximale Länge des Strings beträgt 255 Zeichen.
  - **description:**
    - `required`: Das Feld muss ausgefüllt sein.
    - `string`: Der Inhalt muss ein String sein.

- **$validatedData:** Enthält die validierten Daten, die sicher in die Datenbank eingefügt werden können.

- **Job::create([...]);**
  - Erstellt einen neuen Job-Eintrag mit den validierten Daten.

**Vorteile:**
- **Sicherheit:** Verhindert das Einfügen von ungültigen oder schädlichen Daten in die Datenbank.
- **Benutzerfeedback:** Automatische Rückmeldung bei Validierungsfehlern.
- **Sauberer Code:** Trennung der Validierungslogik von der Datenverarbeitung.

## 6. Fehlerhandling im Formular

### Code:

```blade
<div class="my-5">
    <input type="text" name="title" placeholder="title" value="{{ old('title') }}">
    @error('title')
        <div class="text-red-500 mt-2 text-sm">{{$message}}</div>
    @enderror
</div>
<div class="mb-5">
    <input type="text" name="description" placeholder="description" value="{{ old('description') }}">
    @error('description')
        <div class="text-red-500 mt-2 text-sm">{{$message}}</div>
    @enderror
</div>
```

### Erklärung:

Dieser Abschnitt zeigt, wie Laravel Fehlernachrichten im Formular anzeigt, wenn die Validierung fehlschlägt.

- **Erster Block: Titel-Feld**
  - **<div class="my-5">:** Ein Container mit Margin für den oberen und unteren Abstand.
  - **<input type="text" name="title" placeholder="title" value="{{ old('title') }}">**
    - **name="title":** Der Name des Eingabefeldes, der mit der Validierung und dem Datenmodell übereinstimmt.
    - **placeholder="title":** Platzhaltertext, der im Eingabefeld angezeigt wird.
    - **value="{{ old('title') }}":** Beibehaltung des eingegebenen Wertes nach einem Validierungsfehler.
  - **@error('title'):**
    - Überprüft, ob es einen Validierungsfehler für das `title`-Feld gibt.
    - **<div class="text-red-500 mt-2 text-sm">{{$message}}</div>:**
      - **class="text-red-500 mt-2 text-sm":** Verwendet Tailwind CSS-Klassen für die Farbgebung (rot für Fehler), Margin-Top und kleinere Schriftgröße.
      - **{{$message}}:** Gibt die Fehlermeldung aus, die von der Validierung generiert wurde.

- **Zweiter Block: Beschreibung-Feld**
  - **<div class="mb-5">:** Ein Container mit Margin für den unteren Abstand.
  - **<input type="text" name="description" placeholder="description" value="{{ old('description') }}">**
    - **name="description":** Der Name des Eingabefeldes.
    - **placeholder="description":** Platzhaltertext.
    - **value="{{ old('description') }}":** Beibehaltung des eingegebenen Wertes.
  - **@error('description'):**
    - Überprüft, ob es einen Validierungsfehler für das `description`-Feld gibt.
    - **<div class="text-red-500 mt-2 text-sm">{{$message}}</div>:**
      - **{{$message}}:** Gibt die Fehlermeldung aus.

**Vorteile:**
- **Benutzerfreundlichkeit:** Nutzer erhalten sofortiges Feedback, wenn sie ungültige Daten eingeben.
- **Datenintegrität:** Sicherstellt, dass nur validierte Daten in die Datenbank gelangen.
- **Design:** Mit Tailwind CSS werden die Fehlermeldungen ansprechend und deutlich hervorgehoben.

## Zusammenfassung

- **Modellbindung:** Erleichtert das Laden von Modellen basierend auf Routenparametern und macht den Controller-Code sauberer.
- **CRUD-Methoden:** Eloquent ORM bietet intuitive Methoden zum Erstellen, Lesen, Aktualisieren und Löschen von Daten.
- **Formularvalidierung:** Laravel's Validierungsfunktionen gewährleisten die Sicherheit und Integrität der Daten.
- **Fehlerhandling:** Durch die Anzeige von Fehlermeldungen im Formular wird die Benutzererfahrung verbessert.

Durch das Verständnis und die korrekte Anwendung dieser Konzepte kannst du effektive und sichere Laravel-Anwendungen entwickeln, die sowohl leistungsfähig als auch benutzerfreundlich sind.