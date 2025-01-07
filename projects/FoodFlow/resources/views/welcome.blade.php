<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FoodFlow</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* Farben aktualisiert zu grün (#28A745) */
            .bg-primary { background-color: #28A745; }
            .text-primary { color: #28A745; }
            .hover\:text-primary:hover { color: #196F3D; }
            .ring-primary { --tw-ring-color: #28A745; }
            .hover\:ring-primary:hover { --tw-ring-color: #196F3D; }
        </style>
    @endif
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
    <div class="w-full max-w-3xl px-6">
        <header class="py-6 text-center">
            <h1 class="text-4xl font-bold text-primary">Willkommen bei FoodFlow</h1>
            <p class="mt-4 text-lg">Verwalte deine Lebensmittel mühelos und reduziere Verschwendung.</p>
        </header>

        <main class="grid gap-6 lg:grid-cols-2 lg:gap-8">
            <!-- Dokumentation -->
            <a href="{{ route('dashboard') }}" class="flex items-start gap-4 rounded-lg bg-white p-6 shadow ring-1 ring-gray-200 transition hover:text-primary hover:ring-primary">
                <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-primary/10">
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path fill="#28A745" d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm0 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16Z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold">Lebensmittelübersicht</h2>
                    <p class="mt-2 text-sm">Erhalte eine detaillierte Übersicht über deinen Vorrat und plane smarter.</p>
                </div>
            </a>

            <!-- Tutorials -->
            <a href="#" class="flex items-start gap-4 rounded-lg bg-white p-6 shadow ring-1 ring-gray-200 transition hover:text-primary hover:ring-primary">
                <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-primary/10">
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path fill="#28A745" d="M3 4h18a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1Zm2 2v12h14V6H5Z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold">Rezepte entdecken</h2>
                    <p class="mt-2 text-sm">Finde passende Rezepte für deine vorhandenen Lebensmittel.</p>
                    <p class="text-red-300">(In der Entwicklung)</p>
                </div>
            </a>

            <!-- Nachhaltigkeit -->
            <a href="#" class="flex items-start gap-4 rounded-lg bg-white p-6 shadow ring-1 ring-gray-200 transition hover:text-primary hover:ring-primary">
                <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-primary/10">
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path fill="#28A745" d="M11 2v20h2V2h-2Zm-9 9h20v2H2v-2Z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold">Nachhaltigkeit fördern</h2>
                    <p class="mt-2 text-sm">Minimiere Lebensmittelabfälle durch intelligente Planung.</p>
                    <p class="text-red-300">(In der Entwicklung)</p>
                </div>
            </a>
        </main>

        <footer class="mt-12 text-center text-sm text-gray-500">
            © 2025 FoodFlow. Alle Rechte vorbehalten.
        </footer>
    </div>
</div>
</body>
</html>
