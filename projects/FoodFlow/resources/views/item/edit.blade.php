<div class="max-w-4xl mx-auto">
    <div class="mb-8 bg-darkCard rounded-xl shadow-xl border border-brandIndigo/20 p-6">
        <h3 class="text-lg font-bold text-white mb-4">Aktuelle Informationen</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-300">
            <div>
                <span class="text-sm font-medium text-white">Name:</span>
                <p class="mt-1">{{ $foodItem->name }}</p>
            </div>
            <div>
                <span class="text-sm font-medium text-white">Verfallsdatum:</span>
                <p class="mt-1">{{ $foodItem->expiration_date->format('d.m.Y') }}</p>
            </div>
            <div>
                <span class="text-sm font-medium text-white">Menge:</span>
                <p class="mt-1">{{ $foodItem->quantity }}</p>
            </div>
            <div>
                <span class="text-sm font-medium text-white">Kategorie:</span>
                <p class="mt-1">{{ $foodItem->category->name }}</p>
            </div>
            <div>
                <span class="text-sm font-medium text-white">Standort:</span>
                <p class="mt-1">{{ $foodItem->location->name }}</p>
            </div>
        </div>
    </div>

    <form action="{{ route('foodItems.update', $foodItem) }}" novalidate method="POST" class="bg-darkCard rounded-xl shadow-xl border border-brandIndigo/20 p-6">
        @csrf
        @method('PATCH')

        @if (session('status'))
            <x-alert
                type="info"
                :message="session('status')"
                class="mb-4"
            />
        @endif

        @if (session('success'))
            <x-alert
                type="success"
                :message="session('success')"
                class="mb-4"
            />
        @endif

        @if ($errors->any())
            <x-alert
                type="error"
                :message="$errors->first()"
                class="mb-4"
            />
        @endif

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium text-white">Name</label>
                <input type="text" name="name" id="name"
                       class="w-full px-4 py-3 bg-slate-800/50 text-white placeholder-gray-400 rounded-lg border border-slate-700 focus:border-brandIndigo focus:ring-1 focus:ring-brandIndigo transition-colors"
                       value="{{ old('name', $foodItem->name) }}" required>
            </div>

            <div class="space-y-2">
                <label for="expiration_date" class="block text-sm font-medium text-white">Verfallsdatum</label>
                <input type="date" name="expiration_date" id="expiration_date"
                       class="w-full px-4 py-3 bg-slate-800/50 text-white placeholder-gray-400 rounded-lg border border-slate-700 focus:border-brandIndigo focus:ring-1 focus:ring-brandIndigo transition-colors"
                       value="{{ old('expiration_date', $foodItem->expiration_date->format('Y-m-d')) }}" required>
            </div>

            <div class="space-y-2">
                <label for="quantity" class="block text-sm font-medium text-white">Menge</label>
                <input type="number" name="quantity" id="quantity" min="1"
                       class="w-full px-4 py-3 bg-slate-800/50 text-white placeholder-gray-400 rounded-lg border border-slate-700 focus:border-brandIndigo focus:ring-1 focus:ring-brandIndigo transition-colors"
                       value="{{ old('quantity', $foodItem->quantity) }}" required>
            </div>

            <x-generic-dropdown
                :items="$categories"
                name="category_id"
                label="Kategorie"
                route="{{ route('categories.store') }}"
                :selected="old('category_id', $foodItem->category_id)" />

            <x-generic-dropdown
                :items="$locations"
                name="location_id"
                label="Standort"
                route="{{ route('locations.store') }}"
                :selected="old('location_id', $foodItem->location_id)" />
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit"
                    class="px-6 py-2.5 bg-brandIndigo hover:bg-brandIndigo/80 text-white rounded-lg transition-all duration-200 flex items-center gap-2 font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Änderungen speichern
            </button>
        </div>
    </form>
</div>
