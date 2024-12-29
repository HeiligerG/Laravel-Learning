# Wie Sessions & Authentifizierung in Laravel funktionieren

Bevor wir Code schreiben, möchte ich kurz darüber sprechen, wie Sessions in Laravel funktionieren. Es ist wichtig, nicht nur die Syntax zu lernen, sondern auch zu verstehen, was im Hintergrund passiert. Wir werden auch die `session` Helferfunktion verwenden, um manuell Sitzungsdaten zu erstellen.

## Sessions

Eine Session ist eine Methode, um Informationen über mehrere Anfragen hinweg in deiner Anwendung zu speichern. HTTP ist ein zustandsloses Protokoll, was bedeutet, dass jede Anfrage unabhängig von den vorherigen ist. Dies ist gut für die Performance, kann aber problematisch sein, wenn du Zustandsinformationen über mehrere Anfragen hinweg speichern musst.

In Laravel und vielen anderen Frameworks und Webanwendungen werden Sessions verwendet, um Zustandsinformationen wie den Authentifizierungsstatus des Benutzers, Flash-Nachrichten usw. zu speichern. Ein Beispiel für Flash-Nachrichten haben wir bereits gesehen.

## Authentifizierung & Sessions

Wenn sich ein Benutzer anmeldet, erstellt Laravel eine Session für diesen Benutzer und speichert den Authentifizierungsstatus in der Session. Beim Abmelden wird die Session zerstört.

Wenn wir beispielsweise eine neue Jobanzeige erstellen, möchten wir die Benutzer-ID aus der Session abrufen und zusammen mit der Anzeige in der Datenbank speichern. Beim Aktualisieren oder Löschen von Anzeigen prüfen wir, ob der Benutzer eingeloggt ist und ob er der Besitzer der Anzeige ist.

## Session-Cookies

Wie bereits erwähnt, erstellt Laravel beim Login eine Session für den Benutzer und speichert den Authentifizierungsstatus in der Session. Diese Session wird in einem Cookie im Browser des Benutzers gespeichert. Das Cookie enthält die Session-ID, einen eindeutigen Bezeichner für die Session. Die Session-ID wird bei jeder Anfrage an den Server gesendet. Der Server verwendet die Session-ID, um die Sitzungsdaten aus der Datenbank abzurufen.

Standardmäßig verwendet Laravel ein Cookie namens `laravel_session` oder `dein_projektname_session`, um die Session-ID zu speichern. Du kannst in den Entwicklertools deines Browsers das Cookie sehen. Die Daten werden verschlüsselt und signiert, um Manipulationen zu verhindern. Deine Anwendung hat einen Schlüssel in der `.env`-Datei definiert, der zur Verschlüsselung und Signierung der Daten verwendet wird. Der Schlüssel ist `APP_KEY` und der Wert ist eine zufällige Zeichenkette.

### "Remember Me" Cookie

Wenn die Option "Remember Me" beim Login aktiviert ist, generiert Laravel ein langlebiges Cookie namens `remember_token`. Dieses Token wird im Feld `remember_token` der Benutzertabelle gespeichert. Wenn die Session abläuft (z.B. beim Schließen des Browsers), kann Laravel den Benutzer beim nächsten Besuch der Seite automatisch mit diesem Cookie wieder einloggen.

### CSRF-Tokens

Laravel verwendet auch ein CSRF-Token (Cross-Site Request Forgery), um Angriffe dieser Art zu verhindern. Dieses Token wird in der Session gespeichert und bei jeder Anfrage an den Server gesendet. Der Server überprüft das Token, um sicherzustellen, dass die Anfrage legitim ist.

## Sitzungs-Konfiguration & Datenbank-Setup

Sessions werden in der Datei `config/session.php` konfiguriert. Laravel unterstützt verschiedene Session-Treiber wie `file`, `cookie`, `database`, `memcached`, `redis` und `array`. In diesem Projekt verwenden wir den `database`-Treiber.

Wenn du deine Datenbank mit einem Tool wie PG Admin öffnest, siehst du eine Tabelle namens `sessions`. Hier speichert Laravel die Sitzungsdaten. Es gibt ein Feld namens `payload`, das die Sitzungsdaten enthält. Diese Daten werden serialisiert und verschlüsselt, bevor sie in der Datenbank gespeichert werden. Diese Daten können alles Mögliche umfassen, von Benutzer-Authentifizierungsstatus bis hin zu CSRF-Tokens und Flash-Nachrichten.

Es gibt auch ein Feld `user_id`, das verwendet wird, um die Session einem Benutzer zuzuordnen. Dies wird genutzt, um zu bestimmen, ob der Benutzer eingeloggt ist oder nicht. Momentan haben die vorhandenen Sessions keine `user_id`, da noch kein Login erfolgt ist.

## `session` Helferfunktion

Wir können Sitzungsdaten manuell erstellen, indem wir die `session` Helferfunktion verwenden.

Beispiel in einem Controller (z.B. `HomeController`):

```php
session()->put('test', '123');
$value = session()->get('test');
dd($value);
```

Beim Besuch der entsprechenden Route siehst du `123`. So kannst du manuell Sitzungsdaten erstellen.

In der Datenbank findest du diese Daten in der `sessions`-Tabelle, allerdings verschlüsselt. Ein einzelner Datensatz kann mehrere Werte enthalten. Du kannst den `payload` kopieren und auf Websites wie [https://www.base64decode.org/](https://www.base64decode.org/) oder sogar ChatGPT einfügen, um zu sehen, wie die Daten aussehen.

### Sitzungsdaten löschen

Du kannst Sitzungsdaten auch löschen, indem du die `forget()` Methode verwendest:

```php
session()->put('hello', 'world');
session()->put('test', '123');
session()->forget('test');
$value = session()->get('test'); // Dies wird 'null' zurückgeben
dd($value);
```

Nun siehst du `null`, da der Schlüssel `test` gelöscht wurde.

Diese Beispiele zeigen, wie Sessions in Laravel funktionieren.

## Zusammenfassung

- **Authentifizierungsmethoden:** Laravel bietet verschiedene Methoden zur Implementierung der Authentifizierung, von eigenen Lösungen bis hin zu Starterkits wie Breeze und Jetstream.
- **Sessions:** Sessions ermöglichen das Speichern von Zustandsinformationen über mehrere Anfragen hinweg, was für Authentifizierungsprozesse unerlässlich ist.
- **Session-Cookies:** Laravel speichert die Session-ID in verschlüsselten Cookies, um die Verbindung zwischen Benutzer und Session herzustellen.
- **"Remember Me" Cookie:** Ermöglicht das langfristige Einloggen von Benutzern durch ein langlebiges Cookie.
- **CSRF-Schutz:** Durch CSRF-Tokens schützt Laravel die Anwendung vor bestimmten Arten von Angriffen.
- **Konfiguration:** Sessions können über verschiedene Treiber konfiguriert werden, wobei `database` eine flexible und skalierbare Option darstellt.
- **Manuelle Sitzungsverwaltung:** Mit der `session` Helferfunktion können Sitzungsdaten gezielt erstellt, abgerufen und gelöscht werden.

Durch das Verständnis dieser Konzepte kannst du effektive und sichere Authentifizierungssysteme in Laravel entwickeln und die Funktionsweise von Sessions besser nachvollziehen.