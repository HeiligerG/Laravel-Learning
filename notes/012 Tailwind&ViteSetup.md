# Tailwind & Vite Setup in Laravel

## Warum Vite?

Vite ermöglicht ein schnelles, modulares Bundling und liefert einen **Hot-Reload-Server**, der Änderungen an CSS und JavaScript-Dateien sofort im Browser aktualisiert. Damit spart man Entwicklungszeit und vermeidet lästige Neustarts.

## Schritte zur Einrichtung

1. **TailwindCSS, PostCSS & Autoprefixer installieren**

   Im Projektverzeichnis folgende Befehle ausführen:

   ```bash
   npm i -D tailwindcss postcss autoprefixer
   ```

2. **Tailwind-Konfiguration erstellen**

   Mit dem folgenden Befehl werden automatisch eine `tailwind.config.js` und eine `postcss.config.js` generiert:
   
   ```bash
   npx tailwindcss init -p
   ```

3. **Content-Pfade definieren**

   In der `tailwind.config.js` sicherstellen, dass die `content`-Option alle relevanten Dateien enthält:
   
   ```js
   content: [
     './resources/**/*.blade.php',
     './resources/**/*.js',
     './resources/**/*.vue',
   ],
   ```
   
   Dadurch weiß Tailwind, in welchen Dateien es nach Klassen suchen soll, um ungenutzte CSS-Klassen zu entfernen (Tree-Shaking).

4. **Tailwind in die CSS-Datei einbinden**

   In `resources/css/app.css` folgende Direktiven einfügen:
   
   ```css
   @tailwind base;
   @tailwind components;
   @tailwind utilities;
   ```

   Diese stellen sicher, dass Tailwind-Basissytles, Komponenten und Utilities eingebunden werden.

5. **Einbindung in Blade-Layout**

   In eurer Layoutdatei (z. B. `resources/views/layout.blade.php`) vor dem `</head>`-Tag:
   
   ```blade
   @vite('resources/css/app.css')
   <title>@yield('title', 'Default Title')</title>
   ```
   
   Hier bindet ihr euren generierten Tailwind-CSS-Output ein.

6. **Entwicklungsserver starten**

   Um Hot Reloading zu nutzen, in der Projektkonsole:
   
   ```bash
   npm run dev
   ```
   
   Diese Konsole offenlassen, solange ihr entwickelt. Änderungen an euren CSS/JS-Dateien werden nun direkt im Browser ohne manuelles Neuladen übernommen.

## CDN-Alternativen

**cdnjs** ist ein freier CDN-Dienst, der von Cloudflare betrieben wird. Er kann externe Bibliotheken und Ressourcen hosten. In vielen Fällen bietet sich dies an, um Ressourcen einzubinden, ohne sie lokal zu speichern.

**Link:** [https://cdnjs.com/](https://cdnjs.com/)

## Dynamische Klassen in Blade

Tailwind bietet Utility-Klassen an, die im Template mittels Blade-Direktiven dynamisch angewandt werden können:

Beispiel:

```blade
<a href="{{ url('/jobs') }}"
   class="text-white hover:underline py-2 {{ request()->is('jobs') ? 'text-yellow-500 font-bold' : '' }}"
>
  All Jobs
</a>
```

**Erklärung:**
- `{{ request()->is('jobs') ? 'text-yellow-500 font-bold' : '' }}` prüft, ob die aktuelle Route `/jobs` ist.  
- Wenn ja, werden zusätzliche Klassen (`text-yellow-500 font-bold`) angewandt.  
- Ist man nicht auf `/jobs`, bleiben diese Klassen weg und der Link hat sein Standardstyling.

So erhält man dynamische, kontextbezogene Styling-Anpassungen, ohne zusätzlichen JavaScript-Code oder bedingte CSS-Regeln zu schreiben.

---

**Fazit:**  
- Vite + Tailwind bieten einen modernen und performanten Workflow für die Frontendentwicklung in Laravel.  
- Änderungen sind sofort im Browser sichtbar, dank Hot Reloading.  
- Blade und Tailwind harmonieren perfekt durch das Nutzen von dynamischen Klassen, was ein konsistentes und sauberes Styling gewährleistet.