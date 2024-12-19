# Datenbanken in Laravel

Laravel unterstützt verschiedene Datenbanken. Die gängigsten sind:

- **SQLite** (standardmäßig bereits vorinstalliert und sehr einfach einzurichten)
- **MySQL**
- **PostgreSQL**

## Konfiguration in der `.env` Datei

In der `.env`-Datei legt man fest, mit welcher Datenbank man arbeiten möchte. Je nach Wahl müssen bestimmte Umgebungsvariablen gesetzt werden.

### Beispiel für SQLite

```env
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```

Bei SQLite genügt es, `DB_CONNECTION=sqlite` anzugeben. Die Datenbank ist dann standardmäßig unter `database/database.sqlite` (oder einem selbst gewählten Pfad) erreichbar.

### Beispiel für MySQL

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

Nach dem Eintragen dieser Daten können alle Laravel-Befehle wie Migrationen (`php artisan migrate`) mit der MySQL-Datenbank arbeiten.

### Beispiel für PostgreSQL

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

## PostgreSQL mit PGAdmin installieren und einrichten (Windows)

1. **Installation:**  
   Gehe zur [offiziellen Website](https://www.postgresql.org/download/windows/) und lade die aktuelle Version von PostgreSQL herunter (z. B. Version 16).  
   
   Führe den Installer aus, wähle alle Komponenten einschließlich PGAdmin4. PGAdmin4 ist eine grafische Benutzeroberfläche, um deine Datenbanken bequem zu verwalten.

   Während der Installation:
   - Lege ein Passwort für den `postgres`-Superuser fest.
   - Der Standardport ist 5432. Falls dieser schon belegt ist, kannst du z. B. 5433 wählen.
   - Du kannst auf Stack Builder verzichten.

2. **Nach der Installation:**  
   Öffne PGAdmin4. Hier kannst du deine Datenbanken und Benutzer komfortabel anlegen.

### Neue Nutzer und Datenbanken mit PGAdmin anlegen

- In PGAdmin4 findest du links den Browser-Bereich mit Servern, Rollen (Logins) und Datenbanken.

- Um einen neuen Benutzer (Login/Group Role) anzulegen:
  - Rechtsklick auf "Login/Group Roles" → "Create" → "Login/Group Role".
  - Vergib einen Namen, z. B. `workopia`.
  - Unter "Definition" ein Passwort wählen.
  - Unter "Privileges" alle Rechte aktivieren, um diesen Nutzer zum Superuser zu machen (optional, je nach Bedarf).
  - Speichern.

- Um eine neue Datenbank anzulegen:
  - Rechtsklick auf "Databases" → "Create" → "Database".
  - Vergib einen Namen, z. B. `workopia`.
  - Wähle unter "Definition" den gerade angelegten Benutzer als Owner aus.
  - Speichern.

Jetzt hast du eine neue Datenbank `workopia` und einen Nutzer `workopia`, der darauf zugreifen kann.

## PostgreSQL über die Kommandozeile

Alternativ kannst du Nutzer und Datenbanken auch über die PostgreSQL-Kommandozeile (`psql`) anlegen.

```bash
psql -U postgres -d postgres
```

Falls dein System keinen Pfad kennt, navigiere zu:

```bash
cd "C:\Program Files\PostgreSQL\16\bin"
./psql -U postgres -d postgres
```

In der psql-Konsole kannst du dann Befehle ausführen:

```sql
CREATE DATABASE workopia;
CREATE USER workopia WITH SUPERUSER PASSWORD 'your_password';
GRANT ALL PRIVILEGES ON DATABASE workopia TO workopia;

-- Datenbanken auflisten
\l

-- Benutzer auflisten
\du

-- Beenden
\q
```

Damit ist die PostgreSQL-Datenbank und der Nutzer angelegt. In Laravel genügt es nun, die `.env` entsprechend anzupassen und ggf. Migrationen mit `php artisan migrate` auszuführen, um Tabellen und Strukturen anzulegen.