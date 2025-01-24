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
<div class="min-h-screen flex flex-col items-center justify-center bg-brandDark p-6">
    <div class="w-full max-w-4xl">
        <header class="text-center mb-12">
            <h1 class="text-5xl font-bold text-white mb-4">Willkommen bei FoodFlow</h1>
            <p class="text-xl text-gray-300">Verwalte deine Lebensmittel mühelos und reduziere Verschwendung.</p>
        </header>

        <main class="grid gap-8 md:grid-cols-2">
            <a href="{{ route('dashboard') }}" class="group bg-darkCard hover:bg-darkCard/80 border border-brandIndigo/20 rounded-xl p-6 transition-all hover:scale-[1.02] hover:shadow-xl">
                <div class="flex gap-6">
                    <div class="flex-shrink-0 size-14 bg-brandIndigo/20 rounded-lg flex items-center justify-center">
                        <svg class="size-7 text-brandIndigo" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white mb-2 group-hover:text-brandIndigo transition-colors">Lebensmittelübersicht</h2>
                        <p class="text-gray-400">Erhalte eine detaillierte Übersicht über deinen Vorrat und plane smarter.</p>
                    </div>
                </div>
            </a>

            <div class="bg-darkCard border border-brandIndigo/20 rounded-xl p-6">
                <div class="flex gap-6">
                    <div class="flex-shrink-0 size-14 bg-brandIndigo/20 rounded-lg flex items-center justify-center">
                        <svg class="size-7 text-brandIndigo" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white mb-2">Rezepte entdecken</h2>
                        <p class="text-gray-400">Finde passende Rezepte für deine vorhandenen Lebensmittel.</p>
                        <span class="inline-block mt-2 text-sm text-red-400">(In der Entwicklung)</span>
                    </div>
                </div>
            </div>

            <div class="bg-darkCard border border-brandIndigo/20 rounded-xl p-6 md:col-span-2">
                <div class="flex gap-6">
                    <div class="flex-shrink-0 size-14 bg-brandIndigo/20 rounded-lg flex items-center justify-center">
                        <svg class="size-7 text-brandIndigo" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white mb-2">Nachhaltigkeit fördern</h2>
                        <p class="text-gray-400">Minimiere Lebensmittelabfälle durch intelligente Planung.</p>
                        <span class="inline-block mt-2 text-sm text-red-400">(In der Entwicklung)</span>
                    </div>
                </div>
            </div>
        </main>

        <footer class="mt-12 text-center text-sm text-gray-500">
            © 2025 FoodFlow. Alle Rechte vorbehalten.
        </footer>
    </div>
</div>
</body>
</html>
