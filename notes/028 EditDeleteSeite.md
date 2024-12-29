# Edit-Seite in Laravel

Nachdem wir die Erstellung ("C") und Anzeige ("R") von Job-Listings implementiert haben, fehlt noch das Update ("U") sowie das Löschen ("D"), um das vollständige CRUD-Muster abzuschließen. In diesem Abschnitt konzentrieren wir uns auf die Implementierung der Edit-Funktionalität, gefolgt von der Löschfunktionalität.

## 1. **Edit-Methode im Controller**

### 1.1. **Controller-Methode für die Bearbeitung**

Wir nutzen Laravel's Model Binding, um die zu bearbeitende Job-Instanz direkt in die Methode zu übergeben. Öffnen Sie die Datei `app/Http/Controllers/JobController.php` und fügen Sie die `edit`-Methode hinzu:

```php
public function edit(Job $job): View
{
    return view('jobs.edit')->with('job', $job);
}
```

### 1.2. **Update-Methode im Controller**

Die `update`-Methode verarbeitet die Aktualisierung der Job-Daten. Sie ähnelt der `store`-Methode, enthält jedoch zusätzliche Logik zum Umgang mit bestehenden Dateien.

```php
use Illuminate\Support\Facades\Storage;

public function update(Request $request, Job $job): RedirectResponse
{
    // Validierung der eingehenden Daten
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'salary' => 'required|integer',
        'tags' => 'nullable|string',
        'job_type' => 'required|string',
        'remote' => 'required|boolean',
        'requirements' => 'nullable|string',
        'benefits' => 'nullable|string',
        'address' => 'nullable|string',
        'city' => 'required|string',
        'state' => 'required|string',
        'zipcode' => 'required|string',
        'contact_email' => 'required|email',
        'contact_phone' => 'nullable|string',
        'company_name' => 'required|string|max:255',
        'company_description' => 'nullable|string',
        'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'company_website' => 'nullable|url',
    ]);

    // Überprüfung und Speicherung der hochgeladenen Datei
    if ($request->hasFile('company_logo')) {
        // Löschen des alten Firmenlogos, falls vorhanden
        if ($job->company_logo) {
            Storage::delete('public/logos/' . basename($job->company_logo));
        }

        // Speicherung der neuen Datei
        $path = $request->file('company_logo')->store('logos', 'public');
        $validatedData['company_logo'] = $path;
    }

    // Aktualisierung des Job-Eintrags mit den validierten Daten
    $job->update($validatedData);

    return redirect()->route('jobs.index')->with('success', 'Job listing updated successfully!');
}
```

## 2. **Erstellung der Edit-View**

Erstellen Sie eine neue Blade-Datei `edit.blade.php` im Verzeichnis `resources/views/jobs`. Diese Datei basiert auf der `create.blade.php` und wird entsprechend angepasst.

### 2.1. **Edit-Formular**

```blade
<!-- resources/views/jobs/edit.blade.php -->
<x-layout>
  <div class="bg-white mx-auto p-8 rounded-lg shadow-md w-full md:max-w-3xl">
    <h2 class="text-4xl text-center font-bold mb-4">Edit Job Listing</h2>

    <!-- Formular Start -->
    <form
      method="POST"
      action="{{ route('jobs.update', $job->id) }}"
      enctype="multipart/form-data"
    >
      @csrf
      @method('PUT')

      <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
        Job Info
      </h2>

      <!-- Job Title -->
      <x-inputs.text
        id="title"
        name="title"
        label="Job Title"
        placeholder="Software Engineer"
        :value="old('title', $job->title)"
      />

      <x-inputs.textarea
        id="description"
        name="description"
        label="Job Description"
        placeholder="We are seeking a skilled and motivated Software Developer..."
        :value="old('description', $job->description)"
      />

      <x-inputs.text
        id="salary"
        name="salary"
        label="Annual Salary"
        type="number"
        placeholder="90000"
        :value="old('salary', $job->salary)"
      />

      <x-inputs.textarea
        id="requirements"
        name="requirements"
        label="Requirements"
        placeholder="Bachelor's degree in Computer Science"
        :value="old('requirements', $job->requirements)"
      />

      <x-inputs.textarea
        id="benefits"
        name="benefits"
        label="Benefits"
        placeholder="Health insurance, 401k, paid time off"
        :value="old('benefits', $job->benefits)"
      />

      <x-inputs.text
        id="tags"
        name="tags"
        label="Tags (comma-separated)"
        placeholder="development,coding,java,python"
        :value="old('tags', $job->tags)"
      />

      <x-inputs.select
        id="job_type"
        name="job_type"
        label="Job Type"
        :options="['Full-Time' => 'Full-Time', 'Part-Time' => 'Part-Time', 'Contract' => 'Contract', 'Temporary' => 'Temporary', 'Internship' => 'Internship', 'Volunteer' => 'Volunteer', 'On-Call' => 'On-Call']"
        :value="old('job_type', $job->job_type)"
      />

      <x-inputs.select
        id="remote"
        name="remote"
        label="Remote"
        :options="[0 => 'No', 1 => 'Yes']"
        :value="old('remote', $job->remote)"
      />

      <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
        Company Info
      </h2>

      <x-inputs.text
        id="address"
        name="address"
        label="Address"
        placeholder="123 Main St"
        :value="old('address', $job->address)"
      />

      <x-inputs.text
        id="city"
        name="city"
        label="City"
        placeholder="Albany"
        :value="old('city', $job->city)"
      />

      <x-inputs.text
        id="state"
        name="state"
        label="State"
        placeholder="NY"
        :value="old('state', $job->state)"
      />

      <x-inputs.text
        id="zipcode"
        name="zipcode"
        label="ZIP Code"
        placeholder="12201"
        :value="old('zipcode', $job->zipcode)"
      />

      <x-inputs.text
        id="company_name"
        name="company_name"
        label="Company Name"
        placeholder="Company name"
        :value="old('company_name', $job->company_name)"
      />

      <x-inputs.textarea
        id="company_description"
        name="company_description"
        label="Company Description"
        placeholder="Company Description"
        :value="old('company_description', $job->company_description)"
      />

      <x-inputs.text
        id="company_website"
        name="company_website"
        label="Company Website"
        type="url"
        placeholder="Enter website"
        :value="old('company_website', $job->company_website)"
      />

      <x-inputs.text
        id="contact_phone"
        name="contact_phone"
        label="Contact Phone"
        placeholder="Enter phone"
        :value="old('contact_phone', $job->contact_phone)"
      />

      <x-inputs.text
        id="contact_email"
        name="contact_email"
        label="Contact Email"
        type="email"
        placeholder="Email where you want to receive applications"
        :value="old('contact_email', $job->contact_email)"
      />

      <x-inputs.file
        id="company_logo"
        name="company_logo"
        label="Company Logo"
      />

      <!-- Submit Button -->
      <button
        type="submit"
        class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none"
      >
        Save Changes
      </button>
    </form>
  </div>
</x-layout>
```

### 2.2. **Formularanpassungen**

- **Überschrift ändern:** Die Überschrift des Formulars wurde auf "Edit Job Listing" angepasst.
- **Formularaktion und Methode:** Die `action` des Formulars verweist nun auf die `jobs.update`-Route mit der entsprechenden Job-ID. Zusätzlich wurde die `@method('PUT')`-Direktive hinzugefügt, um die HTTP-Methode auf `PUT` zu setzen.
- **Vordefinierte Werte:** Die Eingabefelder sind nun mit den aktuellen Werten des Jobs vorausgefüllt, indem die `:value`-Prop mit `old()` und den Job-Attributen gefüllt wird.

## 3. **Routenanpassungen**

Stellen Sie sicher, dass die Routen für die Edit- und Update-Methoden in der Datei `routes/web.php` definiert sind. Wenn Sie einen Resource-Controller verwenden, sind diese bereits enthalten. Andernfalls fügen Sie folgende Routen hinzu:

```php
use App\Http\Controllers\JobController;

Route::resource('jobs', JobController::class);
```

Dies stellt sicher, dass alle notwendigen Routen für CRUD-Operationen automatisch erstellt werden, einschließlich `jobs.edit` und `jobs.update`.

## 4. **Datei-Upload-Handling beim Update**

Die `update`-Methode im Controller behandelt bereits den Datei-Upload für das Firmenlogo. Hier sind die wesentlichen Schritte:

1. **Überprüfung auf hochgeladene Datei:**
   ```php
   if ($request->hasFile('company_logo')) {
       // Löschen des alten Logos, falls vorhanden
       if ($job->company_logo) {
           Storage::delete('public/logos/' . basename($job->company_logo));
       }

       // Speicherung der neuen Datei
       $path = $request->file('company_logo')->store('logos', 'public');
       $validatedData['company_logo'] = $path;
   }
   ```

2. **Aktualisierung des Job-Eintrags:**
   ```php
   $job->update($validatedData);
   ```

Dadurch wird das alte Firmenlogo gelöscht und durch das neue hochgeladene Logo ersetzt.

## 5. **Anzeige des Firmenlogos in der Edit-Seite**

Es ist hilfreich, das aktuelle Firmenlogo in der Edit-Seite anzuzeigen, damit der Benutzer sehen kann, welches Logo derzeit verwendet wird. Fügen Sie hierzu folgenden Code vor dem Datei-Upload-Feld ein:

```blade
@if($job->company_logo)
    <div class="mb-4">
        <img src="/storage/{{ $job->company_logo }}" alt="{{ $job->company_name }}" class="w-32 h-32 object-contain">
    </div>
@endif
```

Dies zeigt das aktuelle Firmenlogo an, sofern eines vorhanden ist.

## 6. **Testen der Edit-Funktionalität**

1. **Job-Erstellung:**
   - Erstellen Sie zunächst einen neuen Job-Eintrag mit allen erforderlichen Feldern und einem Firmenlogo.

2. **Job-Bearbeitung:**
   - Navigieren Sie zur Detailseite des erstellten Jobs und klicken Sie auf den "Bearbeiten"-Button.
   - Ändern Sie einige Felder und laden Sie ein neues Firmenlogo hoch.
   - Speichern Sie die Änderungen.

3. **Überprüfung:**
   - Stellen Sie sicher, dass die Änderungen korrekt in der Datenbank gespeichert wurden.
   - Überprüfen Sie, ob das alte Firmenlogo gelöscht und das neue korrekt angezeigt wird.
   - Vergewissern Sie sich, dass die Erfolgsmeldung angezeigt wird und nach einigen Sekunden ausgeblendet wird.

## 7. **Delete-Funktionalität**

Nachdem wir nun die "CRU" der CRUD-Funktionalitäten implementiert haben, schließen wir das vollständige CRUD mit der Delete-Funktion ab.

### 7.1. **Delete-Formular im Detailansicht**

In der Detailansicht des Jobs (`resources/views/jobs/show.blade.php`) befindet sich bereits ein Lösch-Button in einem Formular. Stellen Sie sicher, dass das Formular wie folgt aussieht:

```blade
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
```

### 7.2. **Destroy-Methode im Controller**

Fügen Sie die `destroy`-Methode im `JobController` hinzu, um den Job-Eintrag sowie das zugehörige Firmenlogo zu löschen:

```php
public function destroy(Job $job): RedirectResponse
{
    // Löschen des Firmenlogos, falls vorhanden
    if ($job->company_logo) {
        Storage::delete('public/logos/' . basename($job->company_logo));
    }

    // Löschen des Job-Eintrags
    $job->delete();

    return redirect()->route('jobs.index')->with('success', 'Job listing deleted successfully!');
}
```

## 8. **Testen der Delete-Funktionalität**

1. **Job-Erstellung:**
   - Erstellen Sie einen neuen Job-Eintrag mit allen erforderlichen Feldern und einem Firmenlogo.

2. **Job-Löschung:**
   - Navigieren Sie zur Detailseite des erstellten Jobs und klicken Sie auf den "Delete"-Button.
   - Bestätigen Sie die Löschanfrage im angezeigten Bestätigungsdialog.

3. **Überprüfung:**
   - Stellen Sie sicher, dass der Job-Eintrag aus der Datenbank entfernt wurde.
   - Überprüfen Sie, ob das zugehörige Firmenlogo aus dem `storage/app/public/logos`-Verzeichnis gelöscht wurde.
   - Vergewissern Sie sich, dass die Erfolgsmeldung angezeigt wird und nach einigen Sekunden ausgeblendet wird.

---

Diese Notizen bieten eine strukturierte Übersicht über die strategische Implementierung der Edit- und Delete-Funktionalitäten in Laravel. Sie dienen als Referenz für die angewandten Prinzipien, Best Practices und bewährten Methoden zur Erstellung einer flexiblen, skalierbaren und benutzerfreundlichen Anwendung.