<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard - Lebensmittelübersicht') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Deine Lebensmittel</h3>

                    @if (session('success'))
                        <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Tabelle -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse border border-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategorie</th>
                                <th class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Standort</th>
                                <th class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verfallsdatum</th>
                                <th class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Menge</th>
                                <th class="border border-gray-200 px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aktionen</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($foodItems as $item)
                                <tr>
                                    <td class="border border-gray-200 px-4 py-2">{{ $item->name }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $item->category->name }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $item->location->name }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $item->expiration_date->format('d.m.Y') }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $item->quantity }}</td>
                                    <td class="border border-gray-200 px-4 py-2 text-center">
                                        <form action="{{ route('foodItems.destroy', $item) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-800 text-sm font-medium"
                                                    onclick="return confirm('Möchten Sie diesen Eintrag wirklich löschen?')">
                                                Löschen
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="border border-gray-200 px-4 py-8 text-center text-sm text-gray-500">
                                        Keine Lebensmittel gefunden.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Formular -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Neues Lebensmittel hinzufügen</h3>

                        <form action="{{ route('foodItems.store') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text"
                                           name="name"
                                           id="name"
                                           required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label for="expiration_date" class="block text-sm font-medium text-gray-700">Verfallsdatum</label>
                                    <input type="date"
                                           name="expiration_date"
                                           id="expiration_date"
                                           required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label for="quantity" class="block text-sm font-medium text-gray-700">Menge</label>
                                    <input type="number"
                                           name="quantity"
                                           id="quantity"
                                           min="1"
                                           required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>

                                <x-category-dropdown :categories="$categories" />

                                <x-location-dropdown :locations="$locations" />
                            </div>

                            <div class="mt-6">
                                <button type="submit"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Hinzufügen
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
