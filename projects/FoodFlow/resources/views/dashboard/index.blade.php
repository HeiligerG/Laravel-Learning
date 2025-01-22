<x-app-layout>
    <x-slot name="header">
        <div class="py-16 bg-green-900">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="bg-green-700 shadow-xl sm:rounded-lg transform transition hover:scale-105">
                    <div class="p-10 text-center">
                        <h1 class="text-4xl font-extrabold text-white">Lebensmittelübersicht</h1>
                        <p class="text-gray-300 mt-4 text-lg">Behalte den Überblick über deine Lebensmittel und deren Verfallsdaten.</p>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    <div class="py-6 bg-green-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-green-800 text-gray-100 overflow-hidden shadow-lg sm:rounded-lg">
                @include('item.index', ['foodItems' => $foodItems])
            </div>
        </div>
    </div>
</x-app-layout>
