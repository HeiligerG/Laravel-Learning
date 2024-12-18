# Projekt Setup-Anleitung

In dieser Anleitung findest du die nötigen Schritte, um dieses Laravel-Projekt erfolgreich einzurichten, nachdem du das Git-Repository geklont hast. 

---

## Voraussetzungen

Stelle sicher, dass du die folgenden Tools auf deinem System installiert hast:

1. **Git**
   - Installiere Git von [git-scm.com](https://git-scm.com/)

2. **Composer** (PHP-Abhängigkeitsmanager)
   - Installiere Composer von [getcomposer.org](https://getcomposer.org)
   - Prüfe die Installation:
     ```bash
     composer --version
     ```

3. **PHP**
   - Installiere PHP **8.3** oder höher.
   - Prüfe die PHP-Version:
     ```bash
     php -v
     ```

4. **Laravel Herd** (lokaler Entwicklungsserver für Laravel-Projekte)
   - Installiere Herd von [https://herd.laravel.com/](https://herd.laravel.com/)

---

## Projekt-Setup

### 1. Git-Repository klonen
Kopiere das Git-Repository in dein lokales Verzeichnis:

```bash
git clone https://github.com/DEIN_REPO_LINK.git
```

Navigiere ins Projektverzeichnis:
```bash
cd dein-projektverzeichnis
```

---

### 2. Composer-Abhängigkeiten installieren
Führe den folgenden Befehl aus, um alle Abhängigkeiten zu installieren:

```bash
composer install
```

> **Hinweis:** Dieser Schritt erstellt den `vendor`-Ordner und die `autoload.php`-Datei.

---

### 3. Umgebungsdatei erstellen
Kopiere die Beispiel-Umgebungsdatei:

```bash
cp .env.example .env
```

Generiere den Laravel-Schlüssel:

```bash
php artisan key:generate
```

Öffne die .env Datei und ändere

```bash
SESSION_DRIVER=database

```

zu

```bash
SESSION_DRIVER=file

```

---

### 4. Lokale Entwicklungsserver konfigurieren (Herd)

Falls du Laravel Herd verwendest:

1. Navigiere in deinem Herd-Tool zum Projektverzeichnis.
2. Stelle sicher, dass HTTPS aktiviert ist (falls benötigt).
3. Starte den Entwicklungsserver.

Du solltest jetzt dein Projekt unter `https://holyworkopia.test` öffnen können.

---

### 5. Caches löschen (optional)
Falls es Probleme gibt, kannst du alle Laravel-Caches löschen:

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

### 6. Migrationen ausführen (falls Datenbank vorhanden)
Führe die Datenbank-Migrationen aus, um die Tabellen zu erstellen:

```bash
php artisan migrate
```

> Stelle sicher, dass die Datenbank-Verbindung in der `.env`-Datei korrekt konfiguriert ist.

---

## Projekt testen

Öffne deinen Browser und gehe zu:
```text
https://DEIN_PROJEKT_NAME.test
```

Du solltest die Startseite des Laravel-Projekts sehen.

---

## Zusammenfassung der Befehle

Hier sind alle wichtigen Befehle zusammengefasst:

```bash
git clone https://github.com/DEIN_REPO_LINK.git
cd dein-projektverzeichnis
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

---

**Viel Erfolg und Spass beim testen!** 🚀
