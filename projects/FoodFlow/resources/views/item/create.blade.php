<form action="{{ route('foodItems.store') }}" method="POST" novalidate class="max-w-4xl mx-auto">
    @csrf
    <div class="bg-darkCard rounded-xl shadow-xl border border-brandIndigo/20 p-6 sm:p-8">

        <div class="max-w-7xl mx-auto mb-4">
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
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div class="space-y-2">
                <x-input-label for="name" :value="__('Name')" class="text-white"></x-input-label>
                <input type="text" name="name" id="name" placeholder="Lebensmittelname eingeben"
                       class="w-full px-4 py-3 bg-slate-800/50 text-white placeholder-white rounded-lg border border-slate-700 focus:border-brandIndigo focus:ring-1 focus:ring-brandIndigo transition-colors"
                value="{{ old('name') }}" required>
            </div>



            <div class="space-y-2">
                <x-input-label for="expiration_date" :value="__('Verfallsdatum')" class="text-white"></x-input-label>
                <input type="date" name="expiration_date" id="expiration_date"
                       class="w-full px-4 py-3 bg-slate-800/50 text-white placeholder-gray-400 rounded-lg border border-slate-700 focus:border-brandIndigo focus:ring-1 focus:ring-brandIndigo transition-colors"
                       value="{{ old('expiration_date') }}" required>
            </div>

            <div class="space-y-2">
                <x-input-label for="quantity" :value="__('Menge')" class="text-white"></x-input-label>
                <div class="relative flex items-center">
                    <input type="number" name="quantity" id="quantity" min="1" placeholder="Menge"
                           class="w-full px-4 py-3 bg-slate-800/50 text-white placeholder-white rounded-lg border border-slate-700 focus:border-brandIndigo focus:ring-1 focus:ring-brandIndigo transition-colors"
                           value="{{ old('quantity') }}" required>

                    <!-- Custom Pfeile -->
                    <div class="absolute mr-4 right-1 flex flex-col">
                        <button type="button" onclick="document.getElementById('quantity').stepUp()"
                                class="text-gray-400 hover:text-white text-xs px-1">
                            ▲
                        </button>
                        <button type="button" onclick="document.getElementById('quantity').stepDown()"
                                class="text-gray-400 hover:text-white text-xs px-1">
                            ▼
                        </button>
                    </div>
                </div>
            </div>

            <x-generic-dropdown
                :items="$categories"
                name="category_id"
                label="Kategorie"
                route="{{ route('categories.store') }}" />

            <x-generic-dropdown
                :items="$locations"
                name="location_id"
                label="Standort"
                route="{{ route('locations.store') }}" />
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit"
                    class="px-6 py-3 bg-brandIndigo hover:bg-brandIndigo/80 text-white rounded-lg transition-all duration-200 flex items-center gap-2 font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Hinzufügen
            </button>
        </div>
    </div>
</form>
