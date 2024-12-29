# Seeders

Wir kennen die Erstellung und Nutzung von Factorys und haben diese bereits in Tinker verwendet. **Seeders** ermöglichen es uns, die Datenbank direkt über die Kommandozeile mit Artisan zu befüllen. Dies ist nützlich für Test- und Entwicklungszwecke sowie für die Initialisierung der Datenbank bei der Bereitstellung der Anwendung. Zudem können Seeders verwendet werden, um die Datenbank mit initialen Daten zu befüllen, wenn wir die Anwendung bereitstellen.

Wenn du das Verzeichnis `database/seeders` öffnest, siehst du eine Datei namens `DatabaseSeeder.php`. Dies ist der Standard-Seeder, den Laravel für uns erstellt. Seeders haben nur eine einzige Methode namens `run`. Diese Methode wird aufgerufen, wenn wir den Befehl `php artisan db:seed` ausführen. Dieser spezielle Seeder verwendet die UserFactory, um einen Benutzer zu erstellen.

## Einen zufälligen User Seeder erstellen

Erstellen wir einen User-Seeder, der unsere Factory nutzt und 10 zufällige Benutzer erstellt.

### Seeder erstellen

Führe den folgenden Befehl aus, um einen neuen Seeder zu erstellen:

```bash
php artisan make:seeder RandomUserSeeder
```

Dies erstellt eine neue Datei unter `database/seeders/RandomUserSeeder.php`. Diese Datei enthält eine Klasse namens `RandomUserSeeder`, die die `Seeder`-Klasse erweitert und eine Methode namens `run` enthält. Hier definieren wir die Logik zur Befüllung unserer Datenbank mit Daten.

### `RandomUserSeeder.php` bearbeiten

Öffne die Datei `database/seeders/RandomUserSeeder.php` und füge den folgenden Code hinzu:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class RandomUserSeeder extends Seeder
{
    /**
     * Führe den Datenbank-Seeder aus.
     *
     * @return void
     */
    public function run(): void
    {
        // Erstelle 10 Benutzer mit der UserFactory
        $users = User::factory(10)->create();

        echo "Users created successfully!";
    }
}
```

**Erklärung:**

- **`use App\Models\User;`**: Importiert das `User`-Modell, damit wir die Factory verwenden können.
- **`User::factory(10)->create();`**: Erstellt und speichert 10 Benutzer in der Datenbank mithilfe der `UserFactory`.
- **`echo "Users created successfully!";`**: Gibt eine Bestätigungsmeldung aus, wenn die Benutzer erfolgreich erstellt wurden.

### Seeder ausführen

Führe den Seeder mit dem folgenden Befehl aus:

```bash
php artisan db:seed --class=RandomUserSeeder
```

## Einen zufälligen Job Seeder erstellen

Erstellen wir einen neuen Seeder namens `RandomJobSeeder.php`, der ebenfalls unsere Factory nutzt.

### Seeder erstellen

Führe den folgenden Befehl aus, um einen neuen Job-Seeder zu erstellen:

```bash
php artisan make:seeder RandomJobSeeder
```

Dies erstellt eine Datei unter `database/seeders/RandomJobSeeder.php`. Diese Datei enthält eine Klasse namens `RandomJobSeeder`, die die `Seeder`-Klasse erweitert und eine Methode namens `run` enthält.

### `RandomJobSeeder.php` bearbeiten

Öffne die Datei `database/seeders/RandomJobSeeder.php` und füge den folgenden Code hinzu:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobListing;

class RandomJobSeeder extends Seeder
{
    /**
     * Führe den Datenbank-Seeder aus.
     *
     * @return void
     */
    public function run(): void
    {
        // Erstelle 10 Job-Listings mit der JobFactory
        JobListing::factory()->count(10)->create();

        echo "Jobs created successfully!";
    }
}
```

**Erklärung:**

- **`use App\Models\JobListing;`**: Importiert das `JobListing`-Modell, damit wir die Factory verwenden können.
- **`JobListing::factory()->count(10)->create();`**: Erstellt und speichert 10 Job-Listings in der Datenbank mithilfe der `JobFactory`.
- **`echo "Jobs created successfully!";`**: Gibt eine Bestätigungsmeldung aus, wenn die Job-Listings erfolgreich erstellt wurden.

### Seeder ausführen

Führe den Seeder mit dem folgenden Befehl aus:

```bash
php artisan db:seed --class=RandomJobSeeder
```

Dies fügt 10 Job-Listings zu unserer Datenbank hinzu, basierend auf den 10 zuvor erstellten Benutzern.

## Finaler Database Seeder

Wir haben nun Seeder für zufällige Jobs und Benutzer erstellt, was in Ordnung ist. Allerdings möchten wir eine Gruppe von festen Job-Listings erstellen und die Tabellen vor dem Seeden leeren. Zudem möchten wir Seeders innerhalb eines anderen Seeders aufrufen, indem wir die `call`-Methode verwenden.

### Daten für feste Job-Listings vorbereiten

Lade eine Datei `job_listings.php` herunter, die ein Array von 10 Job-Listings zurückgibt. Lege diese Datei im Verzeichnis `database/seeders/data` ab. Falls das Verzeichnis `data` noch nicht existiert, erstelle es.

### Seeder erstellen

Erstelle einen neuen Seeder namens `JobSeeder.php`:

```bash
php artisan make:seeder JobSeeder
```

Dies erstellt eine Datei unter `database/seeders/JobSeeder.php`.

### `JobSeeder.php` bearbeiten

Öffne die Datei `database/seeders/JobSeeder.php` und füge den folgenden Code hinzu:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class JobSeeder extends Seeder
{
    /**
     * Führe den Datenbank-Seeder aus.
     *
     * @return void
     */
    public function run(): void
    {
        // Lade Job-Listings-Daten
        $jobListings = include database_path('seeders/data/job_listings.php');

        // Hole alle Benutzer-IDs
        $userIds = User::pluck('id')->toArray();

        foreach ($jobListings as &$listing) {
            // Weisen Sie jedem Job-Listing eine zufällige user_id zu
            $listing['user_id'] = $userIds[array_rand($userIds)];
            // Füge Timestamps hinzu
            $listing['created_at'] = now();
            $listing['updated_at'] = now();
        }

        // Füge Job-Listings in die Datenbank ein
        DB::table('job_listings')->insert($jobListings);
    }
}
```

**Erklärung:**

- **`use Illuminate\Support\Facades\DB;`**: Importiert das `DB`-Facade, um direkt auf die Datenbank zuzugreifen.
- **`use App\Models\User;`**: Importiert das `User`-Modell, um Benutzer-IDs zu holen.
- **`$jobListings = include database_path('seeders/data/job_listings.php');`**: Lädt die Job-Listings-Daten aus der Datei `job_listings.php`.
- **`$userIds = User::pluck('id')->toArray();`**: Holt alle Benutzer-IDs und speichert sie in einem Array.
- **`foreach ($jobListings as &$listing)`**: Iteriert über jedes Job-Listing und weist eine zufällige `user_id` zu sowie Timestamps hinzufügt.
- **`DB::table('job_listings')->insert($jobListings);`**: Fügt die Job-Listings in die Datenbank ein.

### Finalen DatabaseSeeder aktualisieren

Öffne die Datei `database/seeders/DatabaseSeeder.php` und füge den folgenden Code hinzu:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Führe die Datenbank-Seeder aus.
     *
     * @return void
     */
    public function run(): void
    {
        // Leere die Tabellen
        DB::table('job_listings')->truncate();
        DB::table('users')->truncate();

        // Führe die Seeders aus
        $this->call([
            RandomUserSeeder::class,
            JobSeeder::class,
        ]);
    }
}
```

**Erklärung:**

- **`DB::table('job_listings')->truncate();`** und **`DB::table('users')->truncate();`**: Leeren die Tabellen `job_listings` und `users`, um vorhandene Daten zu entfernen.
- **`$this->call([...]);`**: Ruft die angegebenen Seeder-Klassen nacheinander auf.

### Seeder ausführen

Führe den finalen Seeder mit dem folgenden Befehl aus:

```bash
php artisan db:seed
```

Dies führt alle registrierten Seeder aus, leert die Tabellen und fügt die neuen Benutzer und Job-Listings hinzu.

## Zusammenfassung

- **Factorys:** Definieren wiederverwendbare Attribute zur Erstellung von Testdaten mithilfe von Faker.
- **Seeders:** Befüllen die Datenbank mit Daten entweder zufällig oder anhand festgelegter Datensätze.
  - **RandomUserSeeder:** Erstellt zufällige Benutzer.
  - **RandomJobSeeder:** Erstellt zufällige Job-Listings.
  - **JobSeeder:** Fügt feste Job-Listings hinzu und weist ihnen zufällige Benutzer zu.
- **DatabaseSeeder:** Zentraler Seeder, der andere Seeder aufruft und Tabellen vor dem Seeden leert.
- **Tinker:** Interaktive Shell zur Nutzung von Factorys und Seeders.

Durch die Nutzung von Factorys und Seeders kannst du deine Datenbank effizient mit Testdaten befüllen, was den Entwicklungsprozess beschleunigt und die Anwendung besser testbar macht.