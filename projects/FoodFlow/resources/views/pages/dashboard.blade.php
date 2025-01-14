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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
