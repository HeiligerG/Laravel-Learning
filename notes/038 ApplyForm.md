# Bewerber-Migration und Modell – Zusammenfassung und Kernpunkte

## Einführung

Um Benutzern das Bewerben auf ausgeschriebene Jobs zu ermöglichen, müssen wir eine neue Datenbanktabelle erstellen, ein entsprechendes Modell definieren und die notwendigen Beziehungen zwischen den Modellen herstellen. Zudem benötigen wir ein Formular zur Einreichung der Bewerbungen und die entsprechende Controller-Logik zur Verarbeitung der Daten.

## Erstellung der Bewerber-Tabelle

### Migration erstellen

**Befehl:**
```bash
php artisan make:migration create_applicants_table
```

**Wichtige Spalten:**
- `id`: Primärschlüssel.
- `user_id`: Fremdschlüssel zum Benutzer, der die Bewerbung einreicht.
- `job_id`: Fremdschlüssel zur Stelle, auf die sich beworben wird.
- `full_name`: Vollständiger Name des Bewerbers.
- `contact_phone`: Kontaktnummer des Bewerbers (optional).
- `contact_email`: E-Mail-Adresse des Bewerbers.
- `message`: Nachricht des Bewerbers (optional).
- `location`: Standort des Bewerbers (optional).
- `resume_path`: Pfad zum hochgeladenen Lebenslauf.
- `created_at` & `updated_at`: Zeitstempel.

**Beispielcode:**
```php
Schema::create('applicants', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('job_id')->constrained('job_listings')->onDelete('cascade');
    $table->string('full_name');
    $table->string('contact_phone')->nullable();
    $table->string('contact_email');
    $table->text('message')->nullable();
    $table->string('location')->nullable();
    $table->string('resume_path');
    $table->timestamps();
});
```

### Migration durchführen

**Befehl:**
```bash
php artisan migrate
```

**Kernpunkt:** Die `applicants` Tabelle wird in der Datenbank erstellt und ermöglicht die Speicherung aller relevanten Bewerberdaten.

## Erstellung des Bewerber-Modells

### Modell erstellen

**Befehl:**
```bash
php artisan make:model Applicant
```

### Modell-Definition

**Wichtige Aspekte:**
- **Fillable Felder:** Bestimmen, welche Felder massenweise zuweisbar sind.
- **Beziehungen:** Definieren, wie das Modell mit anderen Modellen verknüpft ist.

**Beispielcode:**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'user_id',
        'full_name',
        'contact_phone',
        'contact_email',
        'message',
        'location',
        'resume_path',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

**Kernpunkte:**
- **`fillable` Array:** Erlaubt die Massenzuweisung der angegebenen Felder.
- **Beziehungen:** 
  - Ein Bewerber gehört zu einem Job (`job()`).
  - Ein Bewerber gehört zu einem Benutzer (`user()`).

## Beziehungen in bestehenden Modellen

### Job-Modell

**Beziehung:**
Eine Stelle (`Job`) kann viele Bewerbungen (`Applicant`) haben.

**Beispielcode:**
```php
use Illuminate\Database\Eloquent\Relations\HasMany;

public function applicants(): HasMany
{
    return $this->hasMany(Applicant::class);
}
```

### User-Modell

**Beziehung:**
Ein Benutzer (`User`) kann viele Bewerbungen (`Applicant`) einreichen. Die Beziehung wird sinnvollerweise `applications` genannt.

**Beispielcode:**
```php
use Illuminate\Database\Eloquent\Relations\HasMany;

public function applications(): HasMany
{
    return $this->hasMany(Applicant::class, 'user_id');
}
```

**Kernpunkte:**
- **`hasMany` Beziehung:** Ermöglicht den Zugriff auf alle Bewerbungen eines Benutzers oder alle Bewerbungen für einen Job.
- **Alias für Beziehung:** Verwendung von `applications` im `User`-Modell für Klarheit.

## Bewerber-Formular mit Alpine.js

### Ziel

Ein modales Formular zur Einreichung von Bewerbungen direkt auf der Job-Detailseite, gesteuert durch Alpine.js für eine verbesserte Benutzererfahrung.

### Wichtige Elemente

- **Alpine.js:** Steuerung des Modals (öffnen/schließen).
- **Formularfelder:**
  - Vollständiger Name (erforderlich)
  - Kontakttelefon (optional)
  - Kontakt-E-Mail (erforderlich)
  - Nachricht (optional)
  - Standort (optional)
  - Lebenslauf hochladen (erforderlich, PDF)

### Beispielcode des Formulars

```html
<!-- Bewerber-Formular -->
<div x-data="{ open: false }" id="applicant-form">
  <button @click="open = true" class="...">Jetzt bewerben</button>

  <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div @click.away="open = false" class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
      <h3 class="text-lg font-semibold mb-4">Bewerbung für {{ $job->title }}</h3>

      <form action="{{ route('applicants.store', $job->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
          <label for="full_name">Vollständiger Name</label>
          <input id="full_name" type="text" name="full_name" required class="..." />
        </div>
        <!-- Weitere Felder ähnlich -->
        <div class="flex justify-end">
          <button type="submit" class="...">Bewerbung absenden</button>
          <button type="button" @click="open = false" class="...">Abbrechen</button>
        </div>
      </form>
    </div>
  </div>
</div>
```

**Kernpunkte:**
- **Modal mit Alpine.js:** Verbessert die UX durch ein ansprechendes, interaktives Formular.
- **Validierung:** Erforderliche Felder sind mit `required` markiert.
- **Dateiupload:** Unterstützung für das Hochladen von Lebensläufen im PDF-Format.

## Bewerber-Controller & Speicherung

### Controller erstellen

**Befehl:**
```bash
php artisan make:controller ApplicantController
```

### Wichtige Methoden

**`store()` Methode:**
- **Validierung:** Sicherstellen, dass alle erforderlichen Daten korrekt eingegeben wurden.
- **Datei-Upload:** Lebenslauf wird gespeichert und Pfad wird in der Datenbank gespeichert.
- **Speichern der Bewerbung:** Erstellung eines neuen Bewerber-Eintrags mit den validierten Daten.

### Beispielcode der `store` Methode

```php
public function store(Request $request, Job $job): RedirectResponse
{
    // Validierung der eingehenden Daten
    $validatedData = $request->validate([
        'full_name' => 'required|string|max:255',
        'contact_phone' => 'nullable|string|max:20',
        'contact_email' => 'required|email|max:255',
        'message' => 'nullable|string',
        'location' => 'nullable|string|max:255',
        'resume' => 'required|file|mimes:pdf|max:2048',
    ]);

    // Lebenslauf-Datei verarbeiten
    if ($request->hasFile('resume')) {
        $path = $request->file('resume')->store('resumes', 'public');
        $validatedData['resume_path'] = $path;
    }

    // Bewerbung speichern
    $application = new Applicant($validatedData);
    $application->job_id = $job->id;
    $application->user_id = auth()->id();
    $application->save();

    return redirect()->back()->with('success', 'Ihre Bewerbung wurde erfolgreich eingereicht!');
}
```

**Kernpunkte:**
- **Validierung:** Sicherstellung der Datenintegrität.
- **Dateispeicherung:** Lebenslauf wird sicher im `public/resumes` Verzeichnis gespeichert.
- **Datenbankeintrag:** Erstellung und Speicherung des Bewerber-Eintrags.

## Routen definieren

### Route hinzufügen

**Import:**
```php
use App\Http\Controllers\ApplicantController;
```

**Route definieren:**
```php
Route::post('/jobs/{job}/apply', [ApplicantController::class, 'store'])->name('applicants.store');
```

**Kernpunkt:** Die Route verbindet das Bewerberformular mit der `store` Methode im `ApplicantController`.

## Seeder anpassen

### Tabelle bei Seeding leeren

**Datei:** `DatabaseSeeder.php`

**Code hinzufügen:**
```php
DB::table('applicants')->truncate();
```

**Kernpunkt:** Sicherstellen, dass die Bewerber-Tabelle bei jedem Seed-Vorgang geleert wird, um konsistente Testdaten zu gewährleisten.

**Befehl:**
```bash
php artisan db:seed
```

## Zusammenfassung der Kernpunkte

- **Datenbankstruktur:**
  - Erstellung einer `applicants` Tabelle zur Speicherung von Bewerberdaten.
  - Definieren von Fremdschlüsseln zu `users` und `job_listings`.

- **Modelle und Beziehungen:**
  - `Applicant` Modell mit `fillable` Feldern und Beziehungen zu `Job` und `User`.
  - `Job` Modell: `hasMany` Beziehung zu `Applicant`.
  - `User` Modell: `hasMany` Beziehung zu `Applicant` (alias `applications`).

- **Benutzeroberfläche:**
  - Implementierung eines modalen Bewerberformulars mit Alpine.js.
  - Formularfelder für alle relevanten Bewerberinformationen inklusive Lebenslauf-Upload.

- **Controller-Logik:**
  - `ApplicantController` verwaltet die Speicherung der Bewerbungen.
  - Validierung der Eingabedaten und Verarbeitung des Dateiuploads.
  - Speicherung der Bewerberdaten in der Datenbank.

- **Routing:**
  - Definieren einer POST-Route zur Verarbeitung der Bewerbungen.
  
- **Seeder:**
  - Leeren der `applicants` Tabelle beim Seeding zur Sicherstellung konsistenter Testdaten.

## Beispiele

### Beispiel 1: Bewerbung einreichen

1. **Aktion:** Ein Benutzer klickt auf "Jetzt bewerben".
2. **Modal öffnet sich:** Benutzer füllt das Formular aus, lädt seinen Lebenslauf hoch und sendet die Bewerbung ab.
3. **Validierung:** Laravel überprüft die eingegebenen Daten.
4. **Speicherung:** Lebenslauf wird gespeichert, Bewerbung wird in der Datenbank erfasst.
5. **Feedback:** Benutzer erhält eine Erfolgsmeldung.

### Beispiel 2: Datenbankeintrag nach Bewerbung

| id | user_id | job_id | full_name     | contact_phone | contact_email      | message            | location   | resume_path        | created_at         | updated_at         |
|----|---------|--------|---------------|---------------|--------------------|--------------------|------------|---------------------|--------------------|--------------------|
| 1  | 2       | 5      | Max Mustermann | 0123456789    | max@beispiel.de    | Ich bin interessiert. | Berlin     | resumes/lebenslauf1.pdf | 2024-04-27 10:00:00 | 2024-04-27 10:00:00 |
