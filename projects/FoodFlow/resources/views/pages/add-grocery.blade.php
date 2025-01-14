<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif
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

                                <x-generic-dropdown
                                    :items="$categories"
                                    name="category"
                                    label="Kategorie"
                                    route="{{ route('categories.add') }}"
                                />

                                <x-generic-dropdown
                                    :items="$locations"
                                    name="location"
                                    label="Standort"
                                    route="{{ route('locations.add') }}"
                                />

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
