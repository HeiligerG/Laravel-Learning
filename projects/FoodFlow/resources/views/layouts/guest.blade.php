<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-brandDark">
<div class="min-h-screen flex flex-col items-center justify-center p-6">
    <div class="mb-8">
        <a href="/">
            <x-application-logo class="h-20 w-auto" />
        </a>
    </div>

    <div class="w-full sm:max-w-md bg-darkCard border border-brandIndigo/20 rounded-xl shadow-xl p-8">
        {{ $slot }}
    </div>

    <p class="mt-8 text-sm text-gray-500">© 2025 FoodFlow. All rights reserved.</p>
</div>
</body>
</html>
