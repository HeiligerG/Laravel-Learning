<x-app-layout>
    <x-slot name="header">
        <div class="relative w-full h-56 overflow-hidden">
            <!-- Das Bild -->
            <img
                src="{{ asset('images/bg-info.png') }}"
                alt="bg-Info"
                class="w-full h-full object-cover "
            />

            <!-- Text-Overlay -->
            <div
                class="absolute inset-0 flex items-center justify-center bg-opacity-30"
            >
                <h2 class="text-3xl m-5 border-4 border-white p-3 bg-brandIndigo font-bold text-white">
                    Neues Lebensmittel hinzufügen
                </h2>
            </div>
        </div>
    </x-slot>
    <div class="py-6 bg-brandIndigo">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-green-800 text-gray-100 overflow-hidden shadow-lg sm:rounded-lg">
    @include('item.create', ['categories' => $categories, 'locations' => $locations])
            </div>
        </div>
    </div>
</x-app-layout>