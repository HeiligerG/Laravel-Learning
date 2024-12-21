# Interaktion mit der Datenbank in Laravel: Modelle und Eloquent ORM

## Einführung in das Eloquent ORM

**Eloquent ORM** (Object-Relational Mapping) ist Laravels leistungsstarkes ORM-System, das die Interaktion mit der Datenbank vereinfacht. Es ermöglicht die Arbeit mit Datenbanktabellen als PHP-Objekte, wodurch CRUD-Operationen (Erstellen, Lesen, Aktualisieren, Löschen) intuitiver und lesbarer werden.

**Vorteile von Eloquent ORM:**

- **Automatisierung:** Eloquent automatisiert viele Aspekte der Datenbankinteraktion, wie das Mapping von Tabellen zu Modellen.
- **Lesbarkeit und Wartbarkeit:** Der Code ist sauberer und leichter zu verstehen.
- **Beziehungen:** Einfache Definition und Nutzung von Beziehungen zwischen Tabellen (z.B. Eins-zu-Eins, Eins-zu-Viele).
- **Flexibilität:** Unterstützung für komplexe Abfragen und Manipulationen.

## Modelle erstellen und konfigurieren

### Erstellen eines Modells

Um ein Modell zu erstellen, verwenden wir den Artisan-Befehl `make:model`. Im Folgenden erstellen wir ein Modell namens `Job`:

```bash
php artisan make:model Job
```

Dieser Befehl generiert zwei Dateien:

1. **Model-Klasse:** `app/Models/Job.php`
2. **Factory (optional):** `database/factories/JobFactory.php` (falls mit `--factory` Option erstellt)

### Anpassen des Modells

Standardmäßig nimmt Eloquent an, dass das Modell `Job` mit der Tabelle `jobs` in der Datenbank verknüpft ist. Da wir jedoch eine andere Tabellenbezeichnung verwenden möchten (`job_listings`), müssen wir dies explizit angeben.

**Job Modell (`app/Models/Job.php`):**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    /**
     * Die Tabelle, die diesem Modell zugeordnet ist.
     *
     * @var string
     */
    protected $table = 'job_listings';

    /**
     * Die Attribute, die massenweise zuweisbar sind.
     *
     * @var array<int, string>
     */
    protected $fillable = ['title', 'description'];
}
```

**Erklärung:**

- `protected $table`: Definiert den Namen der Tabelle, die dem Modell zugeordnet ist.
- `protected $fillable`: Gibt die Felder an, die massenweise zuweisbar sind, um **Mass Assignment**-Angriffe zu verhindern.

### CRUD-Operationen mit Eloquent

#### Erstellen (Create)

Um einen neuen Job-Eintrag zu erstellen, verwenden wir die `create`-Methode. Stellen Sie sicher, dass die Felder im `$fillable`-Array definiert sind.

**Beispiel:**

```php
use App\Models\Job;

Job::create([
    'title' => 'Software Engineer',
    'description' => 'Entwickle und pflege hochwertige Softwareanwendungen.'
]);
```

#### Lesen (Read)

Alle Einträge aus der Tabelle abrufen:

```php
$jobs = Job::all();
```

Einen spezifischen Eintrag finden:

```php
$job = Job::find(1);
```

#### Aktualisieren (Update)

Einen bestehenden Eintrag aktualisieren:

```php
$job = Job::find(1);
$job->update([
    'title' => 'Senior Software Engineer',
    'description' => 'Verantworte die Entwicklung und Wartung komplexer Softwarelösungen.'
]);
```

#### Löschen (Delete)

Einen Eintrag löschen:

```php
$job = Job::find(1);
$job->delete();
```

## Beziehungen zwischen Modellen

Eloquent unterstützt verschiedene Arten von Beziehungen zwischen Modellen. Hier sind die häufigsten:

- **Eins-zu-Eins (One-to-One)**
- **Eins-zu-Viele (One-to-Many)**
- **Viele-zu-Viele (Many-to-Many)**
- **Polymorphe Beziehungen**

### Beispiel: Eins-zu-Viele Beziehung

Angenommen, ein Benutzer (`User`) kann mehrere Jobs (`Job`) erstellen.

**User Modell (`app/Models/User.php`):**

```php
public function jobs()
{
    return $this->hasMany(Job::class);
}
```

**Job Modell (`app/Models/Job.php`):**

```php
public function user()
{
    return $this->belongsTo(User::class);
}
```

**Verwendung:**

```php
// Alle Jobs eines Benutzers abrufen
$user = User::find(1);
$jobs = $user->jobs;

// Den Benutzer eines Jobs abrufen
$job = Job::find(1);
$user = $job->user;
```

## Nutzung von Tinker zur Datenbankinteraktion

**Tinker** ist ein leistungsfähiges CLI-Tool, das eine interaktive Shell für Laravel bietet. Mit Tinker kannst du direkt mit deinen Eloquent-Modellen interagieren.

### Starten von Tinker

```bash
php artisan tinker
```

### Beispiele für Tinker-Befehle

#### Alle Einträge anzeigen

```php
App\Models\Job::all();
```

#### Spalten einer Tabelle anzeigen

```php
Schema::getColumnListing('job_listings');
```

#### Einen neuen Eintrag erstellen

```php
App\Models\Job::create(['title' => 'Job One', 'description' => 'This is Job one']);
```

**Hinweis:** Stelle sicher, dass im Modell die `$fillable`-Eigenschaft gesetzt ist:

```php
protected $fillable = ['title', 'description'];
```

#### Einen Eintrag finden und anzeigen

```php
$job = App\Models\Job::find(1);
$job;
```

#### Einen Eintrag aktualisieren

```php
$job = App\Models\Job::find(1);
$job->update(['title' => 'Updated Job One']);
```

#### Einen Eintrag löschen

```php
$job = App\Models\Job::find(1);
$job->delete();
```

## Factories und Faker für Testdaten

**Factories** ermöglichen das einfache Erstellen von Testdaten mithilfe von Faker, einer Bibliothek zur Generierung gefälschter Daten.

### Erstellen einer Factory

```bash
php artisan make:factory JobFactory --model=Job
```

**JobFactory (`database/factories/JobFactory.php`):**

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Das zugehörige Modell.
     *
     * @var string
     */
    protected $model = \App\Models\Job::class;

    /**
     * Definiert die Modell-Standardwerte.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->paragraph(),
            // Weitere Felder hier hinzufügen
        ];
    }
}
```

### Nutzung der Factory

**Erstellen einzelner Einträge:**

```php
App\Models\Job::factory()->create();
```

**Erstellen mehrerer Einträge:**

```php
App\Models\Job::factory()->count(10)->create();
```

## Datenbank-Seeding

**Seeding** ermöglicht das Befüllen der Datenbank mit initialen oder Testdaten.

### Erstellen eines Seeders

```bash
php artisan make:seeder JobSeeder
```

**JobSeeder (`database/seeders/JobSeeder.php`):**

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;

class JobSeeder extends Seeder
{
    /**
     * Führe den Datenbank-Seeder aus.
     *
     * @return void
     */
    public function run()
    {
        Job::factory()->count(50)->create();
    }
}
```

### Registrierung des Seeders

Füge den Seeder im `DatabaseSeeder` hinzu (`database/seeders/DatabaseSeeder.php`):

```php
public function run()
{
    $this->call([
        JobSeeder::class,
        // Weitere Seeder hier hinzufügen
    ]);
}
```

### Ausführen der Seeder

```bash
php artisan db:seed
```

**Hinweis:** Du kannst auch alle Migrationen und Seeder neu ausführen mit:

```bash
php artisan migrate:fresh --seed
```

Dies löscht alle Tabellen, führt die Migrationen erneut aus und füllt die Datenbank mit den definierten Seedern.

## Zusammenfassung

- **Eloquent ORM:** Vereinfacht die Datenbankinteraktion durch Modelle als PHP-Objekte.
- **Modelle erstellen:** Mit `php artisan make:model`, Anpassung der Tabellenbezeichnung und `$fillable`-Eigenschaften.
- **Beziehungen:** Einfache Definition von Beziehungen wie Eins-zu-Viele.
- **Tinker:** Interaktive Shell zur direkten Interaktion mit der Datenbank.
- **Factories und Faker:** Automatisierte Generierung von Testdaten.
- **Seeding:** Befüllen der Datenbank mit initialen oder Testdaten durch Seeder.

Durch die Nutzung von Eloquent ORM und den damit verbundenen Werkzeugen wie Tinker, Factories und Seeder kannst du deine Datenbank effizient verwalten, Testdaten schnell generieren und die Entwicklung deiner Laravel-Anwendung erheblich beschleunigen.