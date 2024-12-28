# Factorys in Laravel: Attribute definieren und nutzen

**Factories** in Laravel sind leistungsstarke Werkzeuge, die es ermöglichen, Testdaten schnell und effizient zu generieren. Sie definieren Standardwerte für Modellattribute und nutzen dabei die **Faker**-Bibliothek, um realistische Daten zu erstellen. Dies ist besonders nützlich für das Testen und Entwickeln von Anwendungen, da es die Erstellung von Dummy-Daten erleichtert.

## Grundlagen der Factorys

- **Wiederverwendbare Attribute:** Factorys ermöglichen das Definieren von Attributen, die mehrfach verwendet werden können.
- **Klassenbasierte Definition:** Factorys basieren auf Klassen, die spezifische Methoden enthalten, um die Daten zu generieren.
- **Faker:** Eine Bibliothek, die realistische und zufällige Daten generiert, wie Namen, E-Mails, Adressen usw.
- **Tinker:** Ein CLI-Tool von Laravel, das eine interaktive Shell bereitstellt, um Factorys und andere Funktionen auszuprobieren.

## Standard-UserFactory

Hier ist ein Beispiel für eine standardmäßige `UserFactory`, die Laravel mitbringt:

```php
public function definition(): array
{
    return [
        'name' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
        'email_verified_at' => now(),
        'password' => static::$password ??= Hash::make('password'),
        'remember_token' => Str::random(10),
    ];
}
```

### Erklärung der Attribute:

- **`name`**
  - **`fake()->name()`**: Generiert einen zufälligen Namen.
  
- **`email`**
  - **`fake()->unique()->safeEmail()`**: Generiert eine eindeutige und sichere E-Mail-Adresse.
  
- **`email_verified_at`**
  - **`now()`**: Setzt das aktuelle Datum und die aktuelle Uhrzeit, um die E-Mail-Verifizierung zu simulieren.
  
- **`password`**
  - **`static::$password ??= Hash::make('password')`**: Setzt das Passwort auf einen gehashten Standardwert (`'password'`), falls es noch nicht gesetzt wurde.
  
- **`remember_token`**
  - **`Str::random(10)`**: Generiert einen zufälligen Token mit einer Länge von 10 Zeichen.

## Nutzung der Factory in Tinker

**Tinker** ermöglicht es dir, Factorys interaktiv zu nutzen, um Daten zu erstellen.

### Einfache Erstellung eines Benutzers:

```bash
php artisan tinker
```

```php
\App\Models\User::factory()->create();
```

**Ausgabe:**

```php
= App\Models\User {#6236
    name: "Prof. Claudine Lind",
    email: "leta.weissnat@example.org",
    email_verified_at: "2024-12-28 19:19:40",
    #password: "$2y$12$oXbbC5ytM9tPK81UOlW43Ot61gE7po8gcyeKXsZg23jdg9ncKkXaq",
    #remember_token: "g78dRCwfQF",
    updated_at: "2024-12-28 19:19:41",
    created_at: "2024-12-28 19:19:41",
    id: 1,
}
```

### Erstellung mehrerer Benutzer:

```php
\App\Models\User::factory()->count(10)->create();
```

### Alle Benutzer auflisten:

```php
\App\Models\User::all();
```

## Erweiterte Nutzung der Factory: Zustände definieren

Manchmal möchtest du spezifische Zustände oder Bedingungen für deine Factorys definieren, z.B. einen Benutzer ohne verifizierte E-Mail-Adresse.

### Beispiel: Unverified-Benutzer

#### Definieren der `unverified`-Methode in der Factory:

```php
public function unverified(): static
{
    return $this->state(fn (array $attributes) => [
        'email_verified_at' => null,
    ]);
}
```

#### Nutzung der `unverified`-Methode:

```php
\App\Models\User::factory()->unverified()->create();
```

**Ausgabe:**

```php
= App\Models\User {#6236
    name: "Prof. Claudine Lind",
    email: "leta.weissnat@example.org",
    email_verified_at: null,
    #password: "$2y$12$oXbbC5ytM9tPK81UOlW43Ot61gE7po8gcyeKXsZg23jdg9ncKkXaq",
    #remember_token: "g78dRCwfQF",
    updated_at: "2024-12-28 19:19:41",
    created_at: "2024-12-28 19:19:41",
    id: 2,
}
```

### Erklärung:

- **`unverified`-Methode:**
  - **`state(fn (array $attributes) => [...])`**: Definiert einen Zustand, in dem bestimmte Attribute überschrieben werden.
  - **`'email_verified_at' => null`**: Setzt das `email_verified_at`-Feld auf `null`, um einen unbestätigten Benutzer zu erstellen.

## Eigene Factory-Klasse erstellen: `JobFactory`

Du kannst eigene Factory-Klassen erstellen, um spezifische Modelle zu generieren. Hier erstellen wir eine `JobFactory` für das `JobListing`-Modell.

### Erstellen der Factory:

```bash
php artisan make:factory JobFactory
```

**Ausgabe:**

```
INFO  Factory [C:\Users\gianl\Desktop\Laravel-Learning\tutorials\holyworkopia\database\factories\JobFactory.php] created successfully.
```

### Definition der `JobFactory`:

```php
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    protected $model = \App\Models\JobListing::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->paragraph(2, true),
            'salary' => $this->faker->numberBetween(40000, 120000),
            'tags' => implode(', ', $this->faker->words(3)),
            'job_type' => $this->faker->randomElement(['Full-Time', 'Part-Time', 'Contract']),
            'remote' => $this->faker->boolean(),
            'requirements' => $this->faker->sentence(3, true),
            'benefits' => $this->faker->sentence(2, true),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'zipcode' => $this->faker->postcode(),
            'contact_email' => $this->faker->safeEmail(),
            'contact_phone' => $this->faker->phoneNumber(),
            'company_name' => $this->faker->company(),
            'company_description' => $this->faker->paragraph(2, true),
            'company_logo' => $this->faker->imageUrl(100, 100, 'business', true, 'logo'),
            'company_website' => $this->faker->url(),
        ];
    }
}
```

### Erklärung der Attribute:

- **`user_id`**
  - **`User::factory()`**: Erstellt automatisch einen neuen Benutzer und setzt dessen ID als Fremdschlüssel. Dies stellt sicher, dass jeder erstellte Job einem bestehenden Benutzer zugeordnet ist.
  
- **`title`**
  - **`$this->faker->jobTitle()`**: Generiert einen zufälligen Jobtitel, z.B. "Software Engineer" oder "Project Manager".
  
- **`description`**
  - **`$this->faker->paragraph(2, true)`**: Erstellt eine zufällige Beschreibung bestehend aus 2 Sätzen. Das zweite Argument `true` sorgt dafür, dass die Sätze als zusammenhängender Text generiert werden.
  
- **`salary`**
  - **`$this->faker->numberBetween(40000, 120000)`**: Generiert eine zufällige Zahl zwischen 40.000 und 120.000, um das Gehalt darzustellen.
  
- **`tags`**
  - **`implode(', ', $this->faker->words(3))`**: Generiert ein Array von 3 zufälligen Wörtern und fügt sie mit einem Komma und Leerzeichen zu einem String zusammen, z.B. "entwicklung, coding, php".
  
- **`job_type`**
  - **`$this->faker->randomElement(['Full-Time', 'Part-Time', 'Contract'])`**: Wählt zufällig eines der angegebenen Jobtypen aus, um die Art der Stelle festzulegen.
  
- **`remote`**
  - **`$this->faker->boolean()`**: Generiert zufällig `true` oder `false`, um anzugeben, ob die Stelle remote ist.
  
- **`requirements`**
  - **`$this->faker->sentence(3, true)`**: Erstellt einen zufälligen Satz mit 3 Wörtern, der die Anforderungen beschreibt.
  
- **`benefits`**
  - **`$this->faker->sentence(2, true)`**: Erstellt einen zufälligen Satz mit 2 Wörtern, der die Vorteile beschreibt.
  
- **`address`**
  - **`$this->faker->streetAddress()`**: Generiert eine zufällige Straßenadresse, z.B. "Musterstraße 123".
  
- **`city`**
  - **`$this->faker->city()`**: Generiert einen zufälligen Stadtnamen, z.B. "Musterstadt".
  
- **`state`**
  - **`$this->faker->state()`**: Generiert einen zufälligen Bundesstaat oder ein Bundesland, z.B. "MS".
  
- **`zipcode`**
  - **`$this->faker->postcode()`**: Generiert eine zufällige Postleitzahl, z.B. "12345".
  
- **`contact_email`**
  - **`$this->faker->safeEmail()`**: Generiert eine sichere E-Mail-Adresse, z.B. "kontakt@example.com".
  
- **`contact_phone`**
  - **`$this->faker->phoneNumber()`**: Generiert eine zufällige Telefonnummer, z.B. "123-456-7890".
  
- **`company_name`**
  - **`$this->faker->company()`**: Generiert einen zufälligen Firmennamen, z.B. "Beispielunternehmen".
  
- **`company_description`**
  - **`$this->faker->paragraph(2, true)`**: Erstellt eine zufällige Unternehmensbeschreibung bestehend aus 2 Sätzen.
  
- **`company_logo`**
  - **`$this->faker->imageUrl(100, 100, 'business', true, 'logo')`**: Generiert eine zufällige URL für ein Firmenlogo mit den angegebenen Abmessungen (100x100), dem Themenbereich 'business', einem zufälligen Bild und dem Namen 'logo'.
  
- **`company_website`**
  - **`$this->faker->url()`**: Generiert eine zufällige URL, z.B. "https://beispielunternehmen.com".

## Nutzung der `JobFactory`

Nachdem die `JobFactory` definiert wurde, kannst du sie in **Tinker** oder in deinen Tests verwenden, um Job-Einträge zu erstellen.

### Beispiel: Einen einzelnen Job erstellen

```bash
php artisan tinker
```

```php
\App\Models\JobListing::factory()->create();
```

### Beispiel: Mehrere Jobs erstellen

```php
\App\Models\JobListing::factory()->count(10)->create();
```

### Beispiel: Jobs mit spezifischen Zuständen erstellen

Angenommen, du möchtest Jobs erstellen, die remote sind:

```php
\App\Models\JobListing::factory()->state([
    'remote' => true,
])->create();
```

Oder du möchtest Jobs mit einem bestimmten Jobtyp:

```php
\App\Models\JobListing::factory()->state([
    'job_type' => 'Part-Time',
])->create();
```

## Fazit

**Factorys** in Laravel sind essenziell für die effiziente Erstellung von Test- und Entwicklungsdaten. Durch die Definition von Attributen und Zuständen mit Hilfe von **Faker** kannst du realistische und vielfältige Datensätze generieren, die deine Anwendung robust testen lassen. Die Nutzung von **Tinker** ermöglicht es dir zudem, diese Daten interaktiv zu erstellen und direkt in deiner Datenbank zu überprüfen.

### Wichtige Punkte:

- **Wiederverwendbare Definitionen:** Definiere Attribute einmal und verwende sie mehrfach.
- **Flexibilität durch Zustände:** Passe die generierten Daten mit Zuständen wie `unverified` oder spezifischen Attributwerten an.
- **Integration mit Tinker:** Nutze Tinker für eine schnelle und interaktive Erstellung von Daten.
- **Sicherheit durch `$fillable`:** Stelle sicher, dass alle massenweise zuweisbaren Felder im Modell definiert sind, um **Mass Assignment**-Angriffe zu verhindern.

Durch die korrekte Nutzung von Factorys kannst du den Entwicklungsprozess beschleunigen und sicherstellen, dass deine Anwendung mit realistischen Daten getestet wird.