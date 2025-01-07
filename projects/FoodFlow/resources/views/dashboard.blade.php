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
                        <div class="mb-4 text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Tabelle der Lebensmittel -->
                    <table class="min-w-full border-collapse border border-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-200 px-4 py-2">Name</th>
                            <th class="border border-gray-200 px-4 py-2">Kategorie</th>
                            <th class="border border-gray-200 px-4 py-2">Standort</th>
                            <th class="border border-gray-200 px-4 py-2">Verfallsdatum</th>
                            <th class="border border-gray-200 px-4 py-2">Menge</th>
                            <th class="border border-gray-200 px-4 py-2">Aktionen</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($foodItems as $item)
                            <tr>
                                <td class="border border-gray-200 px-4 py-2">{{ $item->name }}</td>
                                <td class="border border-gray-200 px-4 py-2">{{ $item->category }}</td>
                                <td class="border border-gray-200 px-4 py-2">{{ $item->location }}</td>
                                <td class="border border-gray-200 px-4 py-2">{{ \Carbon\Carbon::parse($item->expiration_date)->format('d.m.Y') }}</td>
                                <td class="border border-gray-200 px-4 py-2">{{ $item->quantity }}</td>
                                <td class="border border-gray-200 px-4 py-2">
                                    <form action="{{ route('foodItems.destroy', $item) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">Löschen</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border border-gray-200 px-4 py-2 text-center">Keine Lebensmittel gefunden.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <!-- Formular zum Hinzufügen -->
                    <h3 class="text-lg font-semibold mt-8">Neues Lebensmittel hinzufügen</h3>
                    <form action="{{ route('foodItems.store') }}" method="POST" class="mt-4">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">Kategorie</label>
                                <input type="text" name="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700">Standort</label>
                                <input type="text" name="location" id="location" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label for="expiration_date" class="block text-sm font-medium text-gray-700">Verfallsdatum</label>
                                <input type="date" name="expiration_date" id="expiration_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700">Menge</label>
                                <input type="number" name="quantity" id="quantity" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>

                        <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Hinzufügen
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
