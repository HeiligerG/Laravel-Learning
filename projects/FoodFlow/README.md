# FoodFlow

## Über das Projekt
FoodFlow ist eine webbasierte Anwendung zur Organisation und Verwaltung von Lebensmitteln in Gemeinschaften. Die Anwendung ermöglicht es Gruppen (z.B. WGs, Familien, kleine Organisationen), ihre Lebensmittel effizient zu verwalten, Verfallsdaten zu überwachen und Lebensmittelverschwendung zu reduzieren.

## Features
- Benutzer-Authentifizierung und Community-Management
- Verwaltung von Lebensmittelkategorien und Standorten
- Übersicht über vorhandene Lebensmittel
- Verfallsdatum-Tracking
- Suchfunktion für schnelles Finden von Produkten
- Filterfunktion für Standorte und Kategorie
- Community-Wechsel als Benutzer möglich
- Custom Alert

## Technologie-Stack
- Laravel 10
- PHP 8.3
- PostgreSQL
- Tailwind CSS
- Alpine.js
- Blade Templates

## Installation

### Voraussetzungen
- PHP 8.3+
- Composer
- PostgreSQL
- Node.js & NPM

### Setup
1. Repository klonen:
```bash
git clone https://github.com/[username]/FoodFlow.git
cd FoodFlow
```

2. Dependencies installieren:
```bash
composer install
npm install
```

3. Umgebungsvariablen konfigurieren:
```bash
cp .env.example .env
php artisan key:generate
```

4. Datenbank einrichten:
```bash
php artisan migrate
php artisan db:seed
```

5. Entwicklungsserver starten:
```bash
php artisan serve
npm run dev
```

## Deployment
Die Anwendung ist konfiguriert für Deployment auf:
- Oracle Cloud Infrastructure
- Ähnliche Linux-basierte Server

## Updates & Patches
Das System verfügt über ein integriertes Patch-Notes-System zur Information der Benutzer über Updates und neue Features.
