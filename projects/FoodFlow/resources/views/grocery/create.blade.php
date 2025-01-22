<x-app-layout>
    <x-slot name="header">
        <div class="py-12 bg-green-900">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-green-800 text-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6">
                        <h2>Neues Lebensmittel hinzufügen</h2>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    <div class="py-6 bg-green-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-green-800 text-gray-100 overflow-hidden shadow-lg sm:rounded-lg">
    @include('item.create', ['categories' => $categories, 'locations' => $locations])
            </div>
        </div>
    </div>
</x-app-layout>
