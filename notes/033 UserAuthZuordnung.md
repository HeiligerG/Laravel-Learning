# Test User Seeder

Wir haben bereits die Möglichkeit, die Datenbank-Tabellen `jobs` und `users` zu löschen und 10 neue Einträge mit folgendem Befehl neu zu erstellen:

```bash
php artisan db:seed
```

Ich möchte außerdem einen Testbenutzer erstellen, sodass ich nicht jedes Mal einen neuen Benutzer registrieren muss, wenn ich etwas testen möchte.

## Einen neuen Seeder erstellen

Erstellen wir einen neuen Seeder:

```bash
php artisan make:seeder TestUserSeeder
```

Öffne die Datei `database/seeders/TestUserSeeder.php` und füge den folgenden Code hinzu:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class TestUserSeeder extends Seeder
{
    /**
     * Führe die Datenbank-Seeder aus.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('12345678'),
        ]);
    }
}
```

## Seeder zur `DatabaseSeeder` Klasse hinzufügen

Nun müssen wir den neuen Seeder zur `DatabaseSeeder` Klasse hinzufügen. Öffne die Datei `database/seeders/DatabaseSeeder.php` und füge die Zeile hinzu, um den neuen Seeder aufzurufen:

```php
public function run(): void
{
    // Tabellen leeren
    DB::table('job_listings')->truncate();
    DB::table('users')->truncate();

    $this->call(TestUserSeeder::class); // Diese Zeile hinzufügen
    $this->call(RandomUserSeeder::class);
    $this->call(JobSeeder::class);
}
```

## Benutzer-ID zu Listings zuweisen

Lass uns dafür sorgen, dass einige der Listings vom Testbenutzer erstellt werden. Öffne die Datei `database/seeders/JobSeeder.php` und ändere die `run` Methode wie folgt:

```php
public function run(): void
{
    // Job-Listings-Daten laden
    $jobListings = include database_path('seeders/data/job_listings.php');

    // ID des Benutzers, der von TestUserSeeder erstellt wurde, abrufen
    $testUserId = User::where('email', 'test@test.com')->value('id');

    // Alle anderen Benutzer-IDs abrufen
    $userIds = User::where('email', '!=', 'test@test.com')->pluck('id')->toArray();

    foreach ($jobListings as $index => &$listing) {
        if ($index < 2) {
            // Weisen die ersten beiden Job-Listings dem Testbenutzer zu
            $listing['user_id'] = $testUserId;
        } else {
            // Weisen die restlichen Listings zufälligen Benutzern zu
            $listing['user_id'] = $userIds[array_rand($userIds)];
        }
        // Timestamps hinzufügen
        $listing['created_at'] = now();
        $listing['updated_at'] = now();
    }

    // Job-Listings in die Datenbank einfügen
    DB::table('job_listings')->insert($jobListings);
}
```

Wir holen die ID des Testbenutzers und alle anderen Benutzer-IDs. Dann durchlaufen wir die Job-Listings und weisen die ersten beiden dem Testbenutzer und die restlichen zufälligen Benutzern zu.

Jetzt wird jedes Mal, wenn wir `php artisan db:seed` ausführen, ein neuer Benutzer mit der E-Mail `test@test.com` und dem Passwort `12345678` erstellt. Außerdem werden 10 neue Job-Listings erstellt, wobei die ersten beiden vom Testbenutzer und die restlichen von zufälligen Benutzern erstellt werden.

# Aktuellen Benutzer zu Listing hinzufügen

Wir haben die vollständige Authentifizierung in unserer Anwendung implementiert. Allerdings müssen wir noch die Autorisierung implementieren. Derzeit kann jeder ein beliebiges Listing bearbeiten oder löschen. Wir müssen die Autorisierung implementieren, sodass nur der Benutzer, der ein Listing erstellt hat, es bearbeiten oder löschen kann.

## Benutzer-ID beim Erstellen eines Listings hinzufügen

Der erste Schritt ist, die Benutzer-ID zum Listing hinzuzufügen, wenn es erstellt wird. Öffne die Datei `/app/Http/Controllers/JobController.php`, und du siehst, dass die `store` Methode diese Zeile enthält:

```php
// Füge die fest codierte user_id hinzu
$validatedData['user_id'] = 1;
```

Diese Zeile ist fest auf die Benutzer-ID 1 gesetzt. Wir müssen dies ändern, sodass die Benutzer-ID des aktuell authentifizierten Benutzers verwendet wird. Füge dazu in der `store` Methode folgende Zeile hinzu:

```php
// Füge die Benutzer-ID des aktuellen Benutzers hinzu
$validatedData['user_id'] = auth()->user()->id;
```

Jetzt melde dich an und erstelle ein neues Job-Listing. Wenn du die Datenbank überprüfst, siehst du, dass die Benutzer-ID des Listings die Benutzer-ID des aktuell authentifizierten Benutzers ist.

## Autorisierung zu den Editier- und Lösch-Buttons hinzufügen

Derzeit sind die Editier- und Lösch-Buttons auf den Listings immer sichtbar. Lass uns dafür sorgen, dass der Benutzer eingeloggt sein muss und derjenige, der das Listing erstellt hat, die Editier- und Lösch-Buttons sehen kann. In den nächsten Lektionen werden wir dies vereinfachen, indem wir sogenannte "Policies" erstellen und die `@can` Direktive verwenden. Aber vorerst machen wir eine manuelle Bedingung.

Öffne die Datei `/resources/views/jobs/show.blade.php` und ändere die Editier- und Lösch-Buttons wie folgt:

````html
@auth
    @if (auth()->user()->id === $job->user_id)
    <div class="flex space-x-3 ml-4">
      <a
        href="{{ route('jobs.edit', $job->id) }}"
        class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded"
        >Edit</a
      >
      <!-- Delete Form -->
      <form
        method="POST"
        action="{{ route('jobs.destroy', $job->id) }}"
        onsubmit="return confirm('Are you sure you want to delete this job?');"
      >
        @csrf
        @method('DELETE')
        <button
          type="submit"
          class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded"
        >
          Delete
        </button>
      </form>
      <!-- End Delete Form -->
    </div>
    @endif
@endauth
````
    
Wir überprüfen, ob der Benutzer eingeloggt ist und ob die Benutzer-ID des aktuell authentifizierten Benutzers mit der Benutzer-ID des Listings übereinstimmt. Wenn ja, zeigen wir die Editier- und Lösch-Buttons an.

Dies ist in Ordnung, aber in der nächsten Lektion möchte ich dir zeigen, wie du die `@can` Direktive verwenden kannst, indem wir eine sogenannte "Policy" erstellen.

# Policies & `@can` Direktive

In der letzten Lektion haben wir Autorisierung zu den Editier- und Lösch-Buttons auf den Job-Listings hinzugefügt. Wir können die eigentliche Aktualisierung und Löschung immer noch ohne Besitz des Listings durchführen, was wir ändern müssen. Zuerst möchte ich dir jedoch zeigen, wie du eine neue Policy erstellst und die `@can` Direktive verwendest.

Öffne das Terminal und führe den folgenden Befehl aus, um eine neue Policy zu erstellen:

```bash
php artisan make:policy JobPolicy --model=Job
```

Dieser Befehl erstellt eine Datei unter `app/Policies/JobPolicy.php`. Öffne diese Datei und du wirst Methoden wie `viewAny`, `view`, `create`, `update`, `delete` usw. sehen. Hier kannst du die Autorisierungsregeln für das `Job` Modell definieren.

Füge den folgenden Code zur `update` Methode hinzu:

```php
public function update(User $user, Job $job)
{
    return $user->id === $job->user_id;
}
```

Diese Methode gibt `true` zurück, wenn die Benutzer-ID des aktuell authentifizierten Benutzers mit der Benutzer-ID des Job-Listings übereinstimmt. Wenn sie `true` zurückgibt, kann der Benutzer das Job-Listing aktualisieren. Wenn sie `false` zurückgibt, kann der Benutzer das Job-Listing nicht aktualisieren.

Füge den folgenden Code zur `delete` Methode hinzu:

```php
public function delete(User $user, Job $job)
{
    return $user->id === $job->user_id;
}
```

Dies funktioniert genauso wie die `update` Methode, jedoch für die `delete` Methode.

## Policy registrieren

Wir müssen diese Policy innerhalb eines Auth-Service-Providers registrieren. Erstelle einen neuen Auth-Service-Provider, indem du den folgenden Befehl ausführst:

```bash
php artisan make:provider AuthServiceProvider
```

Ein Service-Provider ist eine Klasse, die Bindungen im Service-Container registriert. Sie enthält eine `boot` Methode, die aufgerufen wird, wenn die Anwendung gestartet wird. Hier können wir unsere Policies registrieren.

Öffne die Datei `app/Providers/AuthServiceProvider.php` und füge die folgenden Importe hinzu:

```php
use App\Models\Job;
use App\Policies\JobPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
```

Entferne diesen Import:

```php
use Illuminate\Support\ServiceProvider;
```

Dies mag etwas verwirrend sein, lass mich erklären, warum wir diese Importe geändert haben. Wenn du einen Service-Provider in Laravel generierst, wird standardmäßig die Klasse `Illuminate\Support\ServiceProvider` erweitert. Für bestimmte Typen von Service-Providern, wie z.B. den `AuthServiceProvider`, bietet Laravel spezialisierte Basisklassen wie `Illuminate\Foundation\Support\Providers\AuthServiceProvider`, die zusätzliche Funktionen enthalten, die für diesen Bereich spezifisch sind, wie die `registerPolicies` Methode, die wir aufrufen müssen. Diese Methode ist in der ursprünglichen `Illuminate\Support\ServiceProvider` Klasse nicht verfügbar.

Füge die folgende Eigenschaft oberhalb der `register` Methode hinzu:

```php
protected $policies = [
    Job::class => JobPolicy::class,
];
```

Das `$policies` Array wird verwendet, um festzulegen, welche Policy-Klasse für welches Eloquent-Modell verwendet werden soll. In diesem Fall ordnet es das `Job` Modell (`Job::class`) der `JobPolicy` Klasse (`JobPolicy::class`) zu.

Dann füge den folgenden Code zur `boot` Methode hinzu:

```php
public function boot()
{
    $this->registerPolicies();
}
```

Dies registriert die Policies.

## Die `@can` Direktive verwenden

Jetzt, da wir eine Policy haben, können wir die `@can` Direktive verwenden, um zu überprüfen, ob der Benutzer das Job-Listing aktualisieren oder löschen kann. Öffne die Datei `resources/views/jobs/show.blade.php` und ändere die Editier- und Lösch-Buttons wie folgt:

```html
@can('update', $job)
<div class="flex space-x-3 ml-4">
  <a
    href="{{ route('jobs.edit', $job->id) }}"
    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded"
    >Edit</a
  >
  <!-- Delete Form -->
  <form
    method="POST"
    action="{{ route('jobs.destroy', $job->id) }}"
    onsubmit="return confirm('Are you sure you want to delete this job?');"
  >
    @csrf
    @method('DELETE')
    <button
      type="submit"
      class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded"
    >
      Delete
    </button>
  </form>
  <!-- End Delete Form -->
</div>
@endcan
```

Dies ist viel sauberer als der vorherige Code. Wir können die `@can` Direktive verwenden, um zu überprüfen, ob der Benutzer das Job-Listing aktualisieren oder löschen kann.

Wir müssen jedoch noch verhindern, dass tatsächlich aktualisiert oder gelöscht wird, wenn der Benutzer das Listing nicht besitzt. Dies werden wir in der nächsten Lektion tun.

## Policy & Autorisierung im Controller

Derzeit verhindert die Policy nur, dass der Benutzer die Editier- und Lösch-Buttons sieht. Wir müssen die Policy im Job-Controller verwenden, sodass der Benutzer das Listing tatsächlich nicht aktualisieren oder löschen kann, wenn er es nicht besitzt.

Öffne die Datei `app/Http/Controllers/JobController.php` und füge den folgenden Import hinzu:

```php
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
```

Wir müssen außerdem folgendes zur Klasse hinzufügen:

```php
class JobController extends Controller
{
    use AuthorizesRequests;

    // ...rest der Klasse
}
```

Dies macht das `AuthorizesRequests` Trait für die Klasse verfügbar. So können wir Methoden wie `authorize` und `authorizeForUser` im Controller verwenden.

Jetzt füge den folgenden Code zur `update` Methode hinzu:

```php
public function update(Request $request, Job $job): RedirectResponse
{
    // Überprüfen, ob der Benutzer autorisiert ist
    $this->authorize('update', $job);

    // ...rest der Methode
}
```

Füge den folgenden Code zur `destroy` Methode hinzu:

```php
public function destroy(Job $job): RedirectResponse
{
    // Überprüfen, ob der Benutzer autorisiert ist
    $this->authorize('delete', $job);
    // ...rest der Methode
}
```

Jetzt, wenn du versuchst, ein Listing zu bearbeiten oder zu löschen, das du nicht besitzt, erhältst du einen 403 Fehler.

## Editierformular für Benutzer verhindern, die das Listing nicht besitzen

Wir müssen auch verhindern, dass der Benutzer das Edit-Formular sieht, wenn er das Listing nicht besitzt. Öffne die Datei `app/Http/Controllers/JobController.php` und füge den folgenden Code zur `edit` Methode hinzu:

```php
public function edit(Job $job): View
{
    // Überprüfen, ob der Benutzer autorisiert ist
    $this->authorize('update', $job);
    // ...rest der Methode
}
```

Nun kann der Benutzer das Formular nicht einmal sehen, wenn er das Listing nicht besitzt.

Das war es soweit mit der Autorisierung für Job-Listings.