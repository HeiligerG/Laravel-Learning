<form action="{{ route('foodItems.store') }}" method="POST" class="p-6 bg-green-800 rounded-lg shadow-lg text-gray-100">
    @csrf

    <!-- Allgemeine Fehlermeldungen -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-200">Name</label>
            <input type="text" name="name" id="name" placeholder="Lebensmittelname eingeben"
                   class="w-full mt-2 p-3 bg-green-900 text-gray-100 placeholder-gray-400 rounded-lg border border-green-700 focus:ring-2 focus:ring-green-500 focus:outline-none" required>
            @error('name')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Verfallsdatum -->
        <div>
            <label for="expiration_date" class="block text-sm font-medium text-gray-200">Verfallsdatum</label>
            <input type="date" name="expiration_date" id="expiration_date"
                   class="w-full mt-2 p-3 bg-green-900 text-gray-100 placeholder-gray-400 rounded-lg border border-green-700 focus:ring-2 focus:ring-green-500 focus:outline-none" required>
            @error('expiration_date')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Menge -->
        <div>
            <label for="quantity" class="block text-sm font-medium text-gray-200">Menge</label>
            <input type="number" name="quantity" id="quantity" min="1" placeholder="Menge eingeben"
                   class="w-full mt-2 p-3 bg-green-900 text-gray-100 placeholder-gray-400 rounded-lg border border-green-700 focus:ring-2 focus:ring-green-500 focus:outline-none" required>
            @error('quantity')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Kategorie -->
        <!-- Kategorie-Dropdown -->
        <x-generic-dropdown
            :items="$categories"
            name="category_id"
            label="Kategorie"
            route="{{ route('categories.store') }}"
            class="w-full mt-2 p-3 bg-green-900 text-gray-100 placeholder-gray-400 rounded-lg border border-green-700 focus:ring-2 focus:ring-green-500 focus:outline-none" />

        <!-- Standort-Dropdown -->
        <x-generic-dropdown
            :items="$locations"
            name="location_id"
            label="Standort"
            route="{{ route('locations.store') }}"
            class="w-full mt-2 p-3 bg-green-900 text-gray-100 placeholder-gray-400 rounded-lg border border-green-700 focus:ring-2 focus:ring-green-500 focus:outline-none" />
    </div>

    <!-- Submit Button -->
    <div class="mt-6 flex justify-end">
        <button type="submit"
                class="bg-green-600 hover:bg-green-500 text-white px-6 py-3 rounded-lg font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-green-400">
            Hinzufügen
        </button>
    </div>
</form>
