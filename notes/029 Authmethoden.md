# Authentifizierungsmethoden für Laravel

Es gibt viele Möglichkeiten, die Authentifizierung in Laravel zu implementieren. Hier sind einige der gängigsten Methoden.

## Eigene Authentifizierung

Laravel erleichtert den Aufbau eines eigenen Authentifizierungssystems. Du kannst den Befehl `make:auth` verwenden, um die Authentifizierungsansichten und -routen zu erstellen. Zudem kannst du das `auth` Middleware nutzen, um Routen zu schützen. Mit der `Auth` Fassade kannst du Benutzer authentifizieren. Die `Hash` Fassade ermöglicht das Hashen von Passwörtern. Außerdem kannst du die `bcrypt` Helferfunktion zum Hashen verwenden.

## Laravel Breeze

Laravel Breeze ist ein minimalistisches Authentifizierungs-Starterkit, das mit Laravel geliefert wird. Es ist eine gute Möglichkeit, schnell mit der Authentifizierung zu beginnen. Breeze umfasst:

- Login
- Registrierung
- Passwortzurücksetzung
- E-Mail-Verifizierung
- Zwei-Faktor-Authentifizierung

Breeze bietet eine grundlegende Implementierung der Authentifizierungsfunktionen und ist ideal für einfache Anwendungen oder als Ausgangspunkt für eigene Anpassungen.

## Laravel Jetstream

Laravel Jetstream ist ein umfangreicheres Authentifizierungs-Starterkit, das alles bietet, was Breeze hat, plus zusätzliche Features wie:

- Team-Management
- API-Unterstützung

Jetstream ist mit **Livewire** und **Inertia** aufgebaut. Livewire ist ein Full-Stack-Framework für Laravel, das das Erstellen dynamischer Benutzeroberflächen vereinfacht. Inertia ermöglicht den Aufbau von Single-Page-Anwendungen (SPAs) unter Verwendung klassischer serverseitiger Routen und Controller. Jetstream eignet sich besser für größere Projekte und bietet erweiterte Funktionen, die über die Grundfunktionen von Breeze hinausgehen.

## Laravel Fortify

Laravel Fortify ist ein frontend-agnostisches Authentifizierungs-Backend für Laravel. Fortify stellt die Backend-Funktionen für:

- Registrierung
- Authentifizierung
- Zwei-Faktor-Authentifizierung

Fortify wird oft in Kombination mit Laravel Jetstream verwendet und bietet eine flexible Basis für die Implementierung eigener Authentifizierungslogik.

## Laravel Sanctum

Laravel Sanctum ist ein leichtgewichtiges Paket für die API-Token-Authentifizierung. Sanctum bietet eine einfache Möglichkeit, Single-Page-Anwendungen (SPAs) oder mobile Anwendungen zu authentifizieren. Es ist ideal für den Aufbau von APIs, die von Frontend-Anwendungen wie React oder Vue genutzt werden.

## Laravel Socialite

Laravel Socialite ist ein optionales Paket, das die Authentifizierung mit OAuth-Anbietern wie Facebook, Twitter, Google und GitHub ermöglicht. Socialite erlaubt es Benutzern, sich mit ihren bestehenden Social-Media-Konten in deiner Anwendung zu authentifizieren, was den Anmeldeprozess vereinfacht und die Benutzerfreundlichkeit erhöht.

## Welche Methode verwenden?

Für dieses Projekt wird eine eigene benutzerdefinierte Authentifizierungslösung verwendet, anstatt ein Starterkit wie Breeze. Dies fördert das Verständnis der zugrunde liegenden Mechanismen und der Arbeit mit dem MVC-Muster in Laravel. Starterkits wie Breeze sind zwar produktivitätssteigernd, bieten aber weniger Einblick in die internen Prozesse, was besonders für Lernzwecke nachteilig sein kann.

## Laravel Breeze Demo

Obwohl wir eine eigene Authentifizierungslösung entwickeln, ist es dennoch hilfreich, eine Demonstration von Laravel Breeze zu betrachten, um zu verstehen, was es bietet und wie es funktioniert.

### Was ist in Breeze enthalten?

Breeze umfasst:

- Routen
- Controller
- Modelle
- Ansichten mit gestylten, funktionierenden Formularen für:
  - Login
  - Registrierung
  - Passwortzurücksetzung
  - E-Mail-Verifizierung
  - Zwei-Faktor-Authentifizierung

### Neues Laravel-Projekt erstellen

Führe die folgenden Befehle in einem neuen Ordner aus, um ein neues Laravel-Projekt zu erstellen:

```bash
composer create-project laravel/laravel breeze-demo
cd breeze-demo
```

### Breeze installieren

Installiere Breeze mit dem folgenden Befehl:

```bash
composer require laravel/breeze --dev
```

Richte die Controller, Routen, Ansichten und andere Ressourcen ein:

```bash
php artisan breeze:install
```

Bei der Installation wirst du gefragt, welchen Breeze-Stack du verwenden möchtest. Wähle die Option **Blade mit Alpine** aus, indem du `blade` eingibst und Enter drückst. Bestätige die weiteren Fragen mit Enter, wenn keine speziellen Anpassungen gewünscht sind.

### Server starten

Starte den Entwicklungsserver auf einem anderen Port, z.B. 8001:

```bash
php artisan serve --port 8001
```

Besuche `http://localhost:8001` im Browser. Du solltest Links für **Login** und **Registrierung** sehen. Durch die Registrierung eines neuen Benutzers wirst du zum Dashboard weitergeleitet. Zusätzlich gibt es eine Profilseite.

### Vorteile von Breeze

- **Schnelle Einrichtung:** Ermöglicht die schnelle Implementierung eines vollständigen Authentifizierungssystems.
- **Vielseitigkeit:** Beinhaltet grundlegende Authentifizierungsfunktionen, die für viele Anwendungen ausreichend sind.
- **Anpassbar:** Bietet eine solide Basis, die nach Bedarf erweitert und angepasst werden kann.

### Nach der Demo

Nach der Demonstration von Breeze kannst du den Server stoppen und das Projekt löschen. Der Fokus liegt nun darauf, eine eigene Authentifizierungslösung zu entwickeln, um ein tieferes Verständnis für die Funktionsweise von Laravel zu erlangen.

## Zusammenfassung

- **Eigene Authentifizierung:** Fördert das Verständnis der Authentifizierungsmechanismen in Laravel.
- **Laravel Breeze:** Bietet eine schnelle Möglichkeit zur Implementierung grundlegender Authentifizierungsfunktionen, jedoch mit weniger Einblick in die internen Prozesse.
- **Laravel Jetstream, Fortify, Sanctum, Socialite:** Verschiedene Pakete und Starterkits für unterschiedliche Authentifizierungsanforderungen.
- **Demo von Breeze:** Zeigt die Leistungsfähigkeit von Laravel und wie schnell ein funktionierendes Authentifizierungssystem erstellt werden kann.

Durch die Kombination eigener Authentifizierungslösungen und das Verständnis von Starterkits wie Breeze kannst du flexible und robuste Authentifizierungssysteme in Laravel entwickeln.