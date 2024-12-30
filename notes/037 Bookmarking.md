# Zusammenfassung Bookmarking-Funktionalität

## Migration für `job_user_bookmarks`-Tabelle
Die Funktionalität startet mit der Erstellung einer Pivot-Tabelle, um eine viele-zu-viele-Beziehung zwischen Benutzern und Jobs zu realisieren. Die Tabelle `job_user_bookmarks` speichert die IDs von Benutzern und Job-Listings, die sie gebookmarkt haben. Die Beziehungen wurden wie folgt definiert:
- In der **Job**-Modellklasse: `bookmarkedByUsers()` für Benutzer, die einen Job gebookmarkt haben.
- In der **User**-Modellklasse: `bookmarkedJobs()` für Jobs, die ein Benutzer gebookmarkt hat.

Migration-Befehl:
```bash
php artisan make:migration create_job_user_bookmarks_table
php artisan migrate
```


---

## Seeder für Bookmarks
Ein `BookmarkSeeder` wurde erstellt, um zufällige Jobs für den Testbenutzer zu bookmarken. Der Seeder greift auf den Testbenutzer und eine zufällige Auswahl von Job-IDs zu und verknüpft diese. 

Seeder-Befehl:
```bash
php artisan make:seeder BookmarkSeeder
php artisan db:seed
```


---

## Bookmark-Routen und Controller
- **Routen**: 
  - GET `/bookmarks`: Zeigt alle gebookmarkten Jobs eines Benutzers an.
  - POST `/bookmarks/{job}`: Fügt einen Job zu den Bookmarks des Benutzers hinzu.
  - DELETE `/bookmarks/{job}`: Entfernt einen Job aus den Bookmarks.

- **Controller**:
  - Methode `index()`: Zeigt die Bookmarks in einer paginierten Liste.
  - Methode `store()`: Fügt einen neuen Bookmark hinzu, falls er noch nicht existiert.
  - Methode `destroy()`: Entfernt einen Bookmark, falls er existiert.


---

## Frontend-Integration
1. **Bookmark-Ansicht (`resources/views/jobs/bookmarked.blade.php`)**:
   - Zeigt eine Liste von gebookmarkten Jobs an. Falls keine vorhanden sind, wird eine entsprechende Nachricht angezeigt.
2. **Job-Details mit Bookmark-Button**:
   - Formular für das Bookmarken oder Entfernen eines Jobs. Der Button wechselt je nach Bookmark-Status.

Beispiel:
```html
<form
  action="{{ auth()->user()->bookmarkedJobs()->where('job_id', $job->id)->exists() ? route('bookmarks.destroy', $job->id) : route('bookmarks.store', $job->id) }}"
  method="POST">
  @csrf
  @if (auth()->user()->bookmarkedJobs()->where('job_id', $job->id)->exists())
    @method('DELETE')
    <button>Remove Bookmark</button>
  @else
    <button>Bookmark Listing</button>
  @endif
</form>
```


---

## Zusammenfassung der Benutzererfahrung
- Benutzer können Jobs bookmarken und diese in einer speziellen Ansicht ansehen.
- Die Funktionalität prüft stets den Login-Status des Benutzers und aktualisiert die Ansicht und Buttons dynamisch.
- Die Routen und Controller sind in Middleware `auth` eingebunden, um unberechtigte Zugriffe zu verhindern.

Mit dieser Struktur sind Bookmarking und die Verwaltung von Bookmarks effizient in die bestehende Anwendung integriert.