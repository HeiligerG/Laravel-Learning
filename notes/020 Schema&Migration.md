Datenbankschema & Migrationen in Laravel

Nachdem wir grundlegende Funktionen zum Erstellen und Lesen von Datensätzen implementiert haben, besteht der nächste Schritt darin, das Datenbankschema zu aktualisieren und Migrationen durchzuführen, um zusätzliche Felder oder Tabellen hinzuzufügen. Zudem werden wir die entsprechenden Formulare aktualisieren, um diese neuen Felder zu integrieren. In diesem Abschnitt werden wir die allgemeinen Konzepte und Schritte erläutern, die notwendig sind, um das Datenbankschema in Laravel zu erweitern.

## Grundlagen: Schema und Migration

- **Schema:** Eine Schema-Definition beschreibt die Struktur einer Datenbanktabelle, einschließlich der Spalten und deren Datentypen.
- **Migration:** Migrationen sind versionierte Dateien, die es ermöglichen, Änderungen am Schema der Datenbank nachzuverfolgen und systematisch durchzuführen. Sie dienen dazu, das Schema zu aktualisieren, zu ändern oder zurückzusetzen.

## Erstellen einer neuen Migration

Wenn du das Schema einer bestehenden Tabelle ändern möchtest, solltest du eine neue Migration erstellen. Dies gewährleistet eine saubere und nachvollziehbare Historie der Änderungen.

### Befehl zum Erstellen einer Migration

Verwende den folgenden Artisan-Befehl, um eine neue Migration zu erstellen, die eine bestehende Tabelle modifiziert:

```bash
php artisan make:migration add_fields_to_table_name --table=table_name
```

**Erklärung:**
- **`add_fields_to_table_name`**: Beschreibt, was die Migration bewirken soll (z.B. Hinzufügen von Feldern).
- **`--table=table_name`**: Gibt an, welche Tabelle modifiziert werden soll.

## Beispiel: Hinzufügen neuer Felder zu einer Tabelle

Angenommen, wir möchten einer bestehenden Tabelle zusätzliche Felder hinzufügen, um weitere Informationen zu speichern.

### Beispiel-Datenstruktur

Hier ist ein allgemeines Beispiel für zusätzliche Felder, die wir einer Tabelle hinzufügen könnten:

```php
[
    "id" => 1,
    "user_id" => 1,
    "title" => "Beispieltitel",
    "description" => "Eine ausführliche Beschreibung des Eintrags.",
    "salary" => 50000,
    "tags" => "entwicklung, coding, php, laravel",
    "job_type" => "Vollzeit",
    "remote" => true,
    "requirements" => "Abschluss in Informatik oder einem verwandten Feld, 2+ Jahre Berufserfahrung",
    "benefits" => "Gesundheitsversorgung, 401(k) Matching, flexible Arbeitszeiten",
    "address" => "Musterstraße 123",
    "city" => "Musterstadt",
    "state" => "MS",
    "zipcode" => "12345",
    "contact_email" => "kontakt@example.com",
    "contact_phone" => "123-456-7890",
    "company_name" => "Beispielunternehmen",
    "company_description" => "Ein führendes Unternehmen im Bereich Softwareentwicklung.",
    "company_logo" => "logos/logo-beispiel.png",
    "company_website" => "https://beispielunternehmen.com"
];
```

## `up` Methode

In der `up`-Methode fügst du die neuen Felder zur Tabelle hinzu. Falls du bestehende Daten hast und sicherstellen möchtest, dass die Migration ohne Fehler durchläuft, kannst du die Tabelle vorübergehend leeren. **Achtung:** Dies löscht alle bestehenden Daten in der Tabelle. In einer Produktionsumgebung solltest du alternative Methoden in Betracht ziehen, um Datenverlust zu vermeiden.

### Beispiel für die `up`-Methode

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddFieldsToTableName extends Migration
{
    public function up(): void
    {
        // Optional: Tabelle leeren (nur für Entwicklungszwecke empfohlen)
        DB::table('table_name')->truncate();

        // Tabelle modifizieren
        Schema::table('table_name', function (Blueprint $table) {
            $table->integer('salary')->nullable();
            $table->string('tags')->nullable();
            $table->enum('job_type', ['Vollzeit', 'Teilzeit', 'Vertrag', 'Praktikum'])->default('Vollzeit');
            $table->boolean('remote')->default(false);
            $table->text('requirements')->nullable();
            $table->text('benefits')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('company_name')->nullable();
            $table->text('company_description')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('company_website')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('table_name', function (Blueprint $table) {
            $table->dropColumn([
                'salary', 'tags', 'job_type', 'remote',
                'requirements', 'benefits', 'address',
                'city', 'state', 'zipcode', 'contact_email',
                'contact_phone', 'company_name',
                'company_description', 'company_logo',
                'company_website'
            ]);
        });
    }
}
```

### Erklärung:

- **Truncate der Tabelle:**
  ```php
  DB::table('table_name')->truncate();
  ```
  - **`truncate()`**: Löscht alle Datensätze in der Tabelle und setzt den Auto-Inkrement-Zähler zurück.
  - **Warnung:** Verwende dies nur in Entwicklungsumgebungen, um Datenverlust in Produktionsdatenbanken zu vermeiden.

- **Hinzufügen neuer Felder:**
  ```php
  Schema::table('table_name', function (Blueprint $table) {
      $table->integer('salary')->nullable();
      $table->string('tags')->nullable();
      $table->enum('job_type', ['Vollzeit', 'Teilzeit', 'Vertrag', 'Praktikum'])->default('Vollzeit');
      $table->boolean('remote')->default(false);
      $table->text('requirements')->nullable();
      $table->text('benefits')->nullable();
      $table->string('address')->nullable();
      $table->string('city')->nullable();
      $table->string('state')->nullable();
      $table->string('zipcode')->nullable();
      $table->string('contact_email')->nullable();
      $table->string('contact_phone')->nullable();
      $table->string('company_name')->nullable();
      $table->text('company_description')->nullable();
      $table->string('company_logo')->nullable();
      $table->string('company_website')->nullable();
  });
  ```
  - **Datentypen:**
    - **`integer`**: Ganze Zahlen.
    - **`string`**: Kurze Texte (VARCHAR).
    - **`enum`**: Auf eine vordefinierte Auswahl beschränkte Strings.
    - **`boolean`**: Wahrheitswerte (TRUE/FALSE).
    - **`text`**: Längere Texte (TEXT).

  - **`nullable()`**: Gibt an, dass das Feld leer bleiben kann.
  - **`default()`**: Setzt einen Standardwert für das Feld.

## `down` Methode

Die `down`-Methode stellt die Änderungen der `up`-Methode rückgängig, indem sie die hinzugefügten Spalten entfernt.

### Beispiel für die `down`-Methode

```php
public function down(): void
{
    Schema::table('table_name', function (Blueprint $table) {
        $table->dropColumn([
            'salary', 'tags', 'job_type', 'remote',
            'requirements', 'benefits', 'address',
            'city', 'state', 'zipcode', 'contact_email',
            'contact_phone', 'company_name',
            'company_description', 'company_logo',
            'company_website'
        ]);
    });
}
```

### Erklärung:

- **Entfernen der Spalten:**
  ```php
  $table->dropColumn([...]);
  ```
  - **`dropColumn([...])`**: Entfernt die aufgeführten Spalten aus der Tabelle.

## Mass Assignment

Um sicherzustellen, dass die neuen Felder massenweise zuweisbar sind, musst du das entsprechende Modell aktualisieren und die `$fillable`-Eigenschaft erweitern.

### Beispiel für das Aktualisieren des Modells

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelName extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'salary',
        'tags',
        'job_type',
        'remote',
        'requirements',
        'benefits',
        'address',
        'city',
        'state',
        'zipcode',
        'contact_email',
        'contact_phone',
        'company_name',
        'company_description',
        'company_logo',
        'company_website'
    ];
}
```

### Erklärung:

- **`$fillable` Property:**
  ```php
  protected $fillable = [
      'title',
      'description',
      // ... weitere Felder
  ];
  ```
  - Definiert, welche Felder massenweise zugewiesen werden dürfen.
  - Schutz vor **Mass Assignment**-Angriffen, indem nur die in `$fillable` definierten Felder über Methoden wie `create` oder `update` zugewiesen werden können.

## Ausführen der Migration

Nachdem du die Migration und das Modell aktualisiert hast, kannst du die Migration ausführen, um die Änderungen in der Datenbank anzuwenden.

### Befehl zum Ausführen der Migration

```bash
php artisan migrate
```

**Erklärung:**
- Führt alle ausstehenden Migrationen aus und aktualisiert das Datenbankschema entsprechend.

### Hinweis:

- **Datenverlust:** Da wir in der `up`-Methode die Tabelle geleert haben (`truncate()`), gehen alle bestehenden Daten in der Tabelle verloren. Verwende diese Methode nur in Entwicklungsumgebungen oder wenn du sicherstellen kannst, dass der Datenverlust kein Problem darstellt.
- **Produktionsumgebung:** In einer Produktionsumgebung solltest du alternative Methoden verwenden, um Datenverlust zu vermeiden, wie z.B. das Hinzufügen von Feldern ohne die Tabelle zu leeren oder das Schreiben von Skripten zum Mappen vorhandener Daten auf die neuen Felder.

## Zusammenfassung

- **Migrationen:** Ermöglichen das systematische Aktualisieren des Datenbankschemas.
- **Neue Migration erstellen:** Verwende `php artisan make:migration` mit der `--table`-Option, um bestehende Tabellen zu modifizieren.
- **`up` Methode:** Definiert die Änderungen, die an der Tabelle vorgenommen werden sollen, wie das Hinzufügen neuer Felder.
- **`down` Methode:** Stellt die Änderungen der `up`-Methode rückgängig, indem die hinzugefügten Felder entfernt werden.
- **Mass Assignment:** Aktualisiere das Modell und erweitere die `$fillable`-Eigenschaft, um sichere und massenweise Zuweisungen zu ermöglichen.
- **Migration ausführen:** Verwende `php artisan migrate`, um die Änderungen in der Datenbank anzuwenden.

Durch das Verständnis und die Anwendung dieser Schritte kannst du dein Datenbankschema flexibel und sicher erweitern, um den Anforderungen deiner Anwendung gerecht zu werden.