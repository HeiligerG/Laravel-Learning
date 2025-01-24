<x-app-layout>
    <x-slot name="header">
        <div class="relative w-full h-64 overflow-hidden rounded-xl shadow-2xl">
            <!-- Background -->
            <img
                src="{{ asset('images/bg-info.png') }}"
                alt="bg-Info"
                class="absolute inset-0 w-full h-full object-cover transform scale-105 hover:scale-100 transition-transform duration-700"
            />

            <!-- Gradient overlay -->
            <div class="absolute inset-0 bg-gradient-to-br from-brandIndigo/60 to-brandIndigo/40"></div>

            <!-- Content -->
            <div class="relative z-10 flex flex-col items-center justify-center h-full px-6 space-y-4">
                <h2 class="text-6xl font-extrabold text-white tracking-tight">
                    Lebensmittelübersicht
                </h2>
                <p class="text-2xl text-white/90 text-center font-medium max-w-2xl">
                    Behalte den Überblick über deine Lebensmittel und deren Verfallsdaten.
                </p>
            </div>
        </div>
    </x-slot>
    <div class="py-6 bg-green-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-mainIndigo text-gray-100 overflow-hidden shadow-lg sm:rounded-lg">
                @include('item.index', ['foodItems' => $foodItems])
            </div>
        </div>
    </div>
</x-app-layout>
