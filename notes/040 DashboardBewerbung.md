# Löschen von Bewerbern und Verwaltung der Bewerbungen

In diesem Abschnitt fügen wir Funktionen hinzu, um Bewerber zu löschen, die Bewerbungen auf dem Dashboard anzuzeigen und zu verhindern, dass Benutzer sich mehrfach auf dieselbe Stelle bewerben. Dies verbessert die Verwaltung und Integrität der Bewerbungen in unserer Anwendung.

## Bewerber Löschen

### Ziel

Benutzern ermöglichen, Bewerbungen zu löschen, die sie eingereicht haben. Dies ist besonders nützlich für Administratoren oder Job-Besitzer, um unerwünschte oder fehlerhafte Bewerbungen zu entfernen.

### Schritte

1. **Ansicht Anpassen:**
   - Füge ein Formular hinzu, das es ermöglicht, einen Bewerber zu löschen.
   - Platziere das Formular unterhalb des Buttons zum Lebenslauf-Download.

   **Beispielcode:**
   ```html
   <!-- Delete Applicant Link -->
   <form
     method="POST"
     action="{{ route('applicants.destroy', $applicant->id) }}"
     onsubmit="return confirm('Bist du sicher, dass du diesen Bewerber löschen möchtest?');"
   >
     @csrf
     @method('DELETE')
     <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
       <i class="fas fa-trash-alt"></i> Bewerber löschen
     </button>
   </form>
   ```

2. **Route Hinzufügen:**
   - Definiere eine `DELETE`-Route, die auf die `destroy` Methode im `ApplicantController` verweist.
   - Schütze die Route mit dem `auth` Middleware, um sicherzustellen, dass nur authentifizierte Benutzer Bewerber löschen können.

   **Beispielcode:**
   ```php
   use App\Http\Controllers\ApplicantController;

   Route::delete('/applicants/{applicant}', [ApplicantController::class, 'destroy'])
        ->name('applicants.destroy')
        ->middleware('auth');
   ```

3. **Controller Methode Definieren:**
   - Implementiere die `destroy` Methode im `ApplicantController`, um den Bewerber aus der Datenbank zu entfernen.
   - Stelle sicher, dass der Bewerber existiert, bevor du ihn löscht.

   **Beispielcode:**
   ```php
   <?php

   namespace App\Http\Controllers;

   use App\Models\Applicant;
   use Illuminate\Http\RedirectResponse;
   use Illuminate\Support\Facades\Auth;

   class ApplicantController extends Controller
   {
       /**
        * Löscht eine Jobbewerbung.
        *
        * @param int $id
        * @return RedirectResponse
        */
       public function destroy($id): RedirectResponse
       {
           $applicant = Applicant::findOrFail($id);

           // Optional: Überprüfen, ob der authentifizierte Benutzer berechtigt ist, den Bewerber zu löschen
           if ($applicant->user_id !== Auth::id()) {
               return redirect()->route('dashboard.show')->with('error', 'Unbefugter Zugriff.');
           }

           $applicant->delete();

           return redirect()->route('dashboard.show')->with('success', 'Bewerber erfolgreich gelöscht.');
       }
   }
   ```

### Kernpunkte

- **Sicherheit:** Verwendung von `@csrf` und `@method('DELETE')` zur Absicherung des Löschvorgangs.
- **Benutzerbestätigung:** `onsubmit`-Attribut zur Bestätigung der Löschung.
- **Zugriffskontrolle:** Sicherstellen, dass nur berechtigte Benutzer Bewerber löschen können.

## Bewerber auf dem Dashboard Anzeigen

### Ziel

Job-Besitzern ermöglichen, alle Bewerbungen für ihre Stellen direkt auf dem Dashboard einzusehen. Dies erleichtert die Verwaltung und Überprüfung der Bewerbungen.

### Schritte

1. **Dashboard Controller Anpassen:**
   - Lade die Bewerber für jede Stelle, die dem authentifizierten Benutzer gehört, mit ein.
   - Verwende Eager Loading (`with('applicants')`), um die Anzahl der Datenbankabfragen zu reduzieren.

   **Beispielcode:**
   ```php
   <?php

   namespace App\Http\Controllers;

   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Auth;
   use App\Models\Job;
   use Illuminate\View\View;

   class DashboardController extends Controller
   {
       /**
        * Zeigt das Dashboard an.
        *
        * @param Request $request
        * @return View
        */
       public function show(Request $request): View
       {
           // Authentifizierten Benutzer abrufen
           $user = Auth::user();

           // Alle Job-Listings für den authentifizierten Benutzer mit Bewerbern abrufen
           $jobs = Job::where('user_id', $user->id)->with('applicants')->get();

           return view('dashboard.show', compact('user', 'jobs'));
       }
   }
   ```

2. **Ansicht Anpassen:**
   - Zeige die Bewerber unter jeder Job-Listing an.
   - Integriere das Löschen von Bewerbern in der Ansicht.

   **Beispielcode:**
   ```html
   {{-- Applicants --}}
   <div class="mt-4">
     <h4 class="text-lg font-semibold mb-2">Bewerber</h4>
     @forelse($job->applicants as $applicant)
     <div class="py-2 border-b">
       <p class="text-gray-800"><strong>Name:</strong> {{ $applicant->full_name }}</p>
       <p class="text-gray-800"><strong>Telefon:</strong> {{ $applicant->contact_phone }}</p>
       <p class="text-gray-800"><strong>Email:</strong> {{ $applicant->contact_email }}</p>
       <p class="text-gray-800"><strong>Nachricht:</strong> {{ $applicant->message }}</p>
       <p class="text-gray-800 my-2">
         <a href="{{ asset('storage/' . $applicant->resume_path) }}" class="text-blue-500 hover:underline" download>
           <i class="fas fa-download"></i> Lebenslauf herunterladen
         </a>
       </p>
       <!-- Delete Applicant Link -->
       <form
         method="POST"
         action="{{ route('applicants.destroy', $applicant->id) }}"
         onsubmit="return confirm('Bist du sicher, dass du diesen Bewerber löschen möchtest?');"
       >
         @csrf
         @method('DELETE')
         <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
           <i class="fas fa-trash-alt"></i> Bewerber löschen
         </button>
       </form>
     </div>
     @empty
     <p class="text-gray-700">Keine Bewerber für diese Stelle.</p>
     @endforelse
   </div>
   ```

### Kernpunkte

- **Eager Loading:** Optimierung der Datenbankabfragen durch Laden der Bewerber zusammen mit den Jobs.
- **Benutzerfreundlichkeit:** Klare Darstellung der Bewerberinformationen und einfache Möglichkeit zur Verwaltung (Löschen).
- **Feedback:** Anzeige von Nachrichten, wenn keine Bewerber vorhanden sind.

## Verhindern Mehrfachbewerbungen

### Ziel

Sicherstellen, dass ein Benutzer sich nicht mehrfach auf dieselbe Stelle bewerben kann. Dies verhindert Spam und stellt die Integrität der Bewerbungen sicher.

### Schritte

1. **Controller Methode Anpassen:**
   - Überprüfe, ob der Benutzer bereits eine Bewerbung für die betreffende Stelle eingereicht hat.
   - Falls ja, verhindere das Einreichen einer weiteren Bewerbung und gib eine entsprechende Nachricht aus.

   **Beispielcode:**
   ```php
   <?php

   namespace App\Http\Controllers;

   use Illuminate\Http\Request;
   use App\Models\Job;
   use App\Models\Applicant;
   use Illuminate\Http\RedirectResponse;
   use Illuminate\Support\Facades\Auth;
   use Illuminate\Support\Facades\Storage;

   class ApplicantController extends Controller
   {
       /**
        * Speichert eine neue Jobbewerbung.
        *
        * @param Request $request
        * @param Job $job
        * @return RedirectResponse
        */
       public function store(Request $request, Job $job): RedirectResponse
       {
           // Überprüfen, ob der Benutzer bereits für diese Stelle beworben hat
           $existingApplication = Applicant::where('job_id', $job->id)
                                           ->where('user_id', Auth::id())
                                           ->exists();

           if ($existingApplication) {
               return redirect()->back()->with('status', 'Du hast dich bereits für diese Stelle beworben.');
           }

           // Validierung der eingehenden Daten
           $validatedData = $request->validate([
               'full_name' => 'required|string|max:255',
               'contact_phone' => 'nullable|string|max:20',
               'contact_email' => 'required|email|max:255',
               'message' => 'nullable|string',
               'location' => 'nullable|string|max:255',
               'resume' => 'required|file|mimes:pdf|max:2048',
           ]);

           // Lebenslauf-Datei verarbeiten
           if ($request->hasFile('resume')) {
               $path = $request->file('resume')->store('resumes', 'public');
               $validatedData['resume_path'] = $path;
           }

           // Bewerbung speichern
           $application = new Applicant($validatedData);
           $application->job_id = $job->id;
           $application->user_id = Auth::id();
           $application->save();

           return redirect()->back()->with('success', 'Deine Bewerbung wurde erfolgreich eingereicht.');
       }

       /**
        * Löscht eine Jobbewerbung.
        *
        * @param int $id
        * @return RedirectResponse
        */
       public function destroy($id): RedirectResponse
       {
           $applicant = Applicant::findOrFail($id);

           // Optional: Überprüfen, ob der authentifizierte Benutzer berechtigt ist, den Bewerber zu löschen
           if ($applicant->user_id !== Auth::id()) {
               return redirect()->route('dashboard.show')->with('error', 'Unbefugter Zugriff.');
           }

           $applicant->delete();

           return redirect()->route('dashboard.show')->with('success', 'Bewerber erfolgreich gelöscht.');
       }
   }
   ```

### Kernpunkte

- **Existenzprüfung:** Verwendung von `exists()` zur Überprüfung, ob bereits eine Bewerbung vorliegt.
- **Feedback:** Informieren des Benutzers, wenn eine Bewerbung bereits eingereicht wurde.
- **Sicherheit:** Sicherstellen, dass nur berechtigte Benutzer Bewerber löschen können.

## Zusammenfassung der Verbesserungen

- **Bewerberverwaltung:**
  - **Löschen von Bewerbern:** Ermöglicht das Entfernen unerwünschter Bewerbungen.
  - **Anzeige von Bewerbern:** Job-Besitzer können alle Bewerbungen direkt auf dem Dashboard einsehen.
  
- **Datenintegrität:**
  - **Verhindern von Mehrfachbewerbungen:** Sicherstellt, dass Benutzer sich nicht mehrfach auf dieselbe Stelle bewerben können.

- **Benutzererfahrung:**
  - **Bestätigungsdialoge:** Erhöht die Sicherheit und verhindert unbeabsichtigte Löschungen.
  - **Feedbacknachrichten:** Informiert Benutzer über den Status ihrer Aktionen (z.B. erfolgreiche Bewerbung, bereits beworben).

- **Sicherheit:**
  - **Zugriffskontrollen:** Nur berechtigte Benutzer können Bewerbungen löschen.
  - **Validierung:** Sicherstellt, dass nur korrekte und vollständige Daten gespeichert werden.

- **Optimierung:**
  - **Eager Loading:** Reduziert die Anzahl der Datenbankabfragen beim Laden von Bewerbungen.

## Beispiele

### Beispiel 1: Bewerbung Löschen

1. **Aktion:** Ein Job-Besitzer sieht eine Bewerbung und klickt auf den "Bewerber löschen" Button.
2. **Bestätigung:** Ein Bestätigungsdialog erscheint (`onsubmit`), um die Aktion zu bestätigen.
3. **Löschung:** Nach Bestätigung wird die Bewerbung aus der Datenbank entfernt.
4. **Feedback:** Eine Erfolgsmeldung wird angezeigt (`'Bewerber erfolgreich gelöscht.'`).

### Beispiel 2: Mehrfachbewerbung Verhindern

1. **Aktion:** Ein Benutzer versucht, sich erneut auf eine Stelle zu bewerben, für die er bereits eine Bewerbung eingereicht hat.
2. **Überprüfung:** Der Controller überprüft, ob bereits eine Bewerbung existiert.
3. **Verhinderung:** Da eine Bewerbung existiert, wird die neue Bewerbung abgelehnt.
4. **Feedback:** Der Benutzer erhält eine Nachricht (`'Du hast dich bereits für diese Stelle beworben.'`).

### Beispiel 3: Anzeige von Bewerbern im Dashboard

1. **Aktion:** Ein Job-Besitzer besucht das Dashboard.
2. **Anzeige:** Unter jeder Job-Listing werden die entsprechenden Bewerber angezeigt.
3. **Optionen:** Der Job-Besitzer kann Lebensläufe herunterladen oder Bewerber löschen.
4. **Feedback:** Erfolgreiche Aktionen werden mit entsprechenden Nachrichten angezeigt.