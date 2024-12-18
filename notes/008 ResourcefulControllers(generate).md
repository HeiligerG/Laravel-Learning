# Resourceful Controllers in Laravel

In Laravel besteht die Möglichkeit, Controller mit standardisierten Aktionen zu generieren. Diese Controller orientieren sich an RESTful-Konventionen und stellen die üblichen Methoden für das Erstellen, Anzeigen, Bearbeiten und Löschen von Ressourcen bereit. Das spart viel Zeit, da nicht jede Methode manuell geschrieben werden muss.

## Resource-Methoden

Durch den Befehl `--resource` erstellt Laravel automatisch folgende Methoden im Controller:

- **index()**: Listet alle Ressourcen auf
- **show()**: Zeigt eine einzelne Ressource an
- **create()**: Zeigt ein Formular zur Erstellung einer neuen Ressource an
- **store()**: Nimmt die Formulardaten entgegen und speichert eine neue Ressource
- **edit()**: Zeigt ein Formular zur Bearbeitung einer Ressource an
- **update()**: Nimmt die geänderten Daten entgegen und aktualisiert die Ressource
- **destroy()**: Löscht eine Ressource

## Erstellen eines Resource-Controllers

Mit dem folgenden Artisan-Befehl generierst du einen neuen Controller mit allen Resource-Methoden:

```bash
php artisan make:controller JobController --resource
```

Dieser Befehl erstellt `JobController` im Verzeichnis `app/Http/Controllers` und fügt automatisch die oben genannten Methoden ein.

## Resource Routes

Um nun alle Resource-Methoden durch eine einzige Routen-Deklaration verfügbar zu machen, nutzt man `Route::resource()`:

```php
use App\Http\Controllers\JobController;

Route::resource('jobs', JobController::class);
```

**Ergebnis:**  
Dies erzeugt eine ganze Palette an Routen für die `jobs`-Ressource, die jeweils auf eine der Methoden im `JobController` zeigen:

- `GET /jobs` → `index()`
- `GET /jobs/create` → `create()`
- `POST /jobs` → `store()`
- `GET /jobs/{job}` → `show()`
- `GET /jobs/{job}/edit` → `edit()`
- `PUT/PATCH /jobs/{job}` → `update()`
- `DELETE /jobs/{job}` → `destroy()`

## Überprüfung mit `route:list`

Mit dem Artisan-Befehl `php artisan route:list` kannst du überprüfen, welche Routen nun existieren:

Beispielausgabe (gekürzt):

```
  GET|HEAD        jobs             jobs.index   › JobController@index
  POST            jobs             jobs.store   › JobController@store
  GET|HEAD        jobs/create      jobs.create  › JobController@create
  GET|HEAD        jobs/{job}       jobs.show    › JobController@show
  PUT|PATCH       jobs/{job}       jobs.update  › JobController@update
  DELETE          jobs/{job}       jobs.destroy › JobController@destroy
  GET|HEAD        jobs/{job}/edit  jobs.edit    › JobController@edit
```

Alle notwendigen Routen sind mit nur einer Zeile Code verfügbar.

## Zusammenfassung

- **Ressourcen-Controller**: Vereinfachen die Controller-Erstellung, indem sie Standardaktionen bereitstellen.
- **`php artisan make:controller NameController --resource`**: Erzeugt automatisch alle vordefinierten Methoden.
- **`Route::resource('name', NameController::class)`**: Registriert alle RESTful-Routen für die entsprechende Ressource.
- **`php artisan route:list`**: Zeigt alle registrierten Routen, um die erfolgreiche Einrichtung zu prüfen.

Diese Techniken sparen Entwicklungszeit und sorgen für einen konsistenten, einheitlichen Aufbau deiner Laravel-Anwendung.