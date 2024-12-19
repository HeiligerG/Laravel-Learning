# Datenbanken und Migrationen in Laravel

## Überblick über unterstützte Datenbanken

Laravel unterstützt verschiedene Datenbanksysteme, die sich in Funktionalität und Einsatzgebiet unterscheiden. Die wichtigsten sind:

- **SQLite** (Standardmäßig vorinstalliert und sehr einfach einzurichten)
- **MySQL**
- **PostgreSQL**

Diese Datenbanken decken die meisten Anforderungen ab, von kleinen Projekten bis hin zu großen, skalierbaren Anwendungen.

## Konfiguration der Datenbank in der `.env` Datei

Die Datenbankverbindung wird in der `.env`-Datei deines Laravel-Projekts konfiguriert. Je nach gewähltem Datenbanksystem müssen spezifische Umgebungsvariablen gesetzt werden.

### SQLite

SQLite ist eine leichtgewichtige, dateibasierte Datenbank, die besonders für Entwicklungs- und Testumgebungen geeignet ist.

```env
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```

**Einrichtung:**

1. Erstelle eine SQLite-Datenbankdatei im Verzeichnis `database` deines Projekts:

   ```bash
   touch database/database.sqlite
   ```

2. In der `.env`-Datei sicherstellen, dass `DB_CONNECTION=sqlite` gesetzt ist und die anderen DB-Variablen auskommentiert oder entfernt sind.

### MySQL

MySQL ist eine der populärsten relationalen Datenbanken und eignet sich gut für Produktionsumgebungen.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=deine_datenbank
DB_USERNAME=dein_benutzer
DB_PASSWORD=dein_passwort
```

**Einrichtung:**

1. Installiere MySQL auf deinem System.
2. Erstelle eine neue Datenbank und einen Benutzer mit entsprechenden Rechten.
3. Trage die Verbindungsdaten in der `.env`-Datei ein.

### PostgreSQL

PostgreSQL ist eine leistungsfähige, objektrelationale Datenbank, die sich durch ihre Erweiterbarkeit und Konformität zu Standards auszeichnet.

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=deine_datenbank
DB_USERNAME=dein_benutzer
DB_PASSWORD=dein_passwort
```

**Einrichtung:**

1. **PostgreSQL unter Windows installieren:**

   - **Schritt 1:** Gehe zur [offiziellen PostgreSQL-Downloadseite für Windows](https://www.postgresql.org/download/windows/) und lade die neueste Version (z.B. Version 16) herunter.
   
   - **Schritt 2:** Führe den Installer aus und wähle alle Komponenten einschließlich PGAdmin4 aus. PGAdmin4 ist eine grafische Benutzeroberfläche zur Verwaltung deiner Datenbanken.
   
   - **Schritt 3:** Lege während der Installation ein Passwort für den `postgres`-Superuser fest.
   
   - **Schritt 4:** Behalte den Standardport `5432` bei. Wenn dieser bereits belegt ist, kannst du alternativ `5433` wählen.
   
   - **Schritt 5:** Vermeide die Auswahl von Stack Builder, da dieser zusätzliche Software installiert, die du möglicherweise nicht benötigst.

2. **PostgreSQL einrichten:**

   - **Mit PGAdmin4:**
   
     - **Datenbank und Benutzer erstellen:**
     
       1. Öffne PGAdmin4.
       2. Rechtsklicke auf "Login/Group Roles" → "Create" → "Login/Group Role".
       3. Vergib einen Namen, z.B. `workopia`, und setze ein sicheres Passwort unter der Registerkarte "Definition".
       4. Unter "Privileges" kannst du alle Optionen auswählen, um den Benutzer zu einem Superuser zu machen (optional).
       5. Klicke auf "Save".
       
       6. Rechtsklicke auf "Databases" → "Create" → "Database".
       7. Vergib den Namen `workopia` und wähle `workopia` als Owner aus.
       8. Klicke auf "Save".
   
   - **Mit der Kommandozeile:**
   
     ```bash
     psql -U postgres -d postgres
     ```
     
     Falls dein Standardbenutzer nicht `postgres` ist, ersetze ihn entsprechend.
     
     **Hinweis für Windows:** Navigiere zum Verzeichnis `C:\Program Files\PostgreSQL\16\bin` und führe dort folgendes aus:
     
     ```bash
     ./psql -U postgres -d postgres
     ```
     
     **In der `psql`-Konsole:**
     
     ```sql
     CREATE DATABASE workopia;
     CREATE USER workopia WITH SUPERUSER PASSWORD 'dein_passwort';
     GRANT ALL PRIVILEGES ON DATABASE workopia TO workopia;
     
     -- Datenbanken auflisten
     \l
     
     -- Benutzer auflisten
     \du
     
     -- Beenden
     \q
     ```

## Migrationen in Laravel

### Einführung

Migrationen sind versionierte Dateien, die zur Verwaltung und Veränderung der Datenbankschemata verwendet werden. Sie ermöglichen es, Tabellen und Spalten strukturiert und wiederholbar zu erstellen, zu ändern oder zu löschen. Migrationen bieten eine Möglichkeit, die Datenbankentwicklung zu automatisieren und Änderungen nachzuverfolgen.

**Vorteile von Migrationen:**

- **Versionierung:** Jede Änderung wird dokumentiert und kann rückgängig gemacht werden.
- **Teamarbeit:** Mehrere Entwickler können synchronisierte Datenbankschemata verwenden.
- **Automatisierung:** Einfache Ausführung von Änderungen über die Kommandozeile.

### Standardmigrationen

Laravel liefert einige Standardmigrationen, die im Verzeichnis `database/migrations` zu finden sind. Diese Migrationen erstellen die grundlegenden Tabellen, die für Benutzerverwaltung, Caching und Hintergrundaufgaben benötigt werden.

Beispiele für Standardmigrationen:

- `0001_01_01_000000_create_users_table.php`
- `0001_01_01_000001_create_cache_table.php`
- `0001_01_01_000002_create_jobs_table.php`

**Hinweis:** Die Dateinamen sind mit einem Zeitstempel (`YYYY_MM_DD_HHMMSS`) versehen, um die Reihenfolge der Ausführung sicherzustellen.

### Problem mit der Standard `jobs` Tabelle

Die Standard-`jobs` Tabelle wird von Laravel für das Queuing von Jobs (Aufgaben) verwendet. Da wir jedoch eine Job-Listing-Website entwickeln, möchten wir eine eigene Tabelle `job_listings` verwenden, um Konflikte zu vermeiden.

### Migrationen ausführen

Bevor wir eigene Migrationen erstellen, führen wir die vorhandenen Migrationen aus.

```bash
php artisan migrate
```

Dieser Befehl erstellt alle Tabellen, die durch die Migrationen im `database/migrations` Verzeichnis definiert sind.

### Erstellen eigener Migrationen

Da die Standard-`jobs` Tabelle für unser Projekt ungeeignet ist, erstellen wir eine eigene Migration für die `job_listings` Tabelle.

#### Schritt 1: Migration erstellen

```bash
php artisan make:migration create_job_listings_table
```

Dieser Befehl erstellt eine neue Migrationsdatei im Verzeichnis `database/migrations`.

#### Schritt 2: Migration bearbeiten

Öffne die neu erstellte Migrationsdatei und füge die gewünschten Spalten hinzu:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Referenz zum Benutzer
            $table->string('title');
            $table->text('description');
            $table->decimal('salary', 8, 2)->nullable();
            $table->string('job_type')->default('Full-time'); // z.B. Full-time, Part-time
            $table->boolean('remote')->default(false);
            $table->timestamps();
            
            // Fremdschlüsselbeziehung zur users Tabelle
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
```

**Erklärung der Spalten:**

- `id`: Primärschlüssel, auto-incrementierend.
- `user_id`: Fremdschlüssel zur `users` Tabelle, referenziert den Ersteller des Job-Angebots.
- `title`: Titel der Job-Stelle.
- `description`: Beschreibung der Stelle.
- `salary`: Gehalt, optional.
- `job_type`: Art der Stelle, standardmäßig 'Full-time'.
- `remote`: Boolean, ob die Stelle remote ist.
- `timestamps`: `created_at` und `updated_at` Spalten.

#### Schritt 3: Migration ausführen

```bash
php artisan migrate
```

Dieser Befehl erstellt die `job_listings` Tabelle mit den definierten Spalten in der Datenbank.

### Wichtige Migrationsbefehle

- **Migration ausführen:**

  ```bash
  php artisan migrate
  ```

- **Migrationen zurücksetzen:**

  ```bash
  php artisan migrate:rollback
  ```

  Rollt die letzte Migration zurück.

- **Alle Migrationen zurücksetzen und erneut ausführen:**

  ```bash
  php artisan migrate:refresh
  ```

- **Migrationen vollständig neu ausführen (löscht alle Tabellen und führt alle Migrationen erneut aus):**

  ```bash
  php artisan migrate:fresh
  ```

- **Status der Migrationen anzeigen:**

  ```bash
  php artisan migrate:status
  ```

  Zeigt an, welche Migrationen bereits ausgeführt wurden und welche noch ausstehen.

### Best Practices bei Migrationen

- **Versionskontrolle:** Halte deine Migrationen unter Versionskontrolle (z.B. Git), um Änderungen nachverfolgen zu können.
- **Beschreibende Namen:** Verwende beschreibende Namen für Migrationen, z.B. `create_job_listings_table` statt `create_table`.
- **Trennung der Logik:** Vermeide komplexe Logik in den Migrationsdateien. Nutze sie nur für die Strukturierung der Datenbank.
- **Regelmäßige Backups:** Besonders in Produktionsumgebungen, um Datenverlust zu vermeiden.

## Zusammenfassung

- **Datenbankkonfiguration:** Passe die `.env`-Datei entsprechend deiner Datenbankwahl (SQLite, MySQL, PostgreSQL) an.
- **PostgreSQL Installation:** Unter Windows mit PGAdmin4 installieren und konfigurieren.
- **Migrationen:** Nutzen, um Datenbankschemata strukturiert und versioniert zu verwalten.
- **Eigene Migrationen:** Erstellen und ausführen, um spezifische Tabellen wie `job_listings` anzulegen.
- **Wichtige Befehle:** `php artisan migrate`, `php artisan migrate:rollback`, `php artisan migrate:refresh`, etc.

Durch das Verständnis und die korrekte Nutzung von Datenbanken und Migrationen in Laravel kannst du deine Anwendungen effizienter und skalierbarer gestalten.