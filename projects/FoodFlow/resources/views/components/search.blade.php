<div x-data="{
        params: {
            search: '',
            category: '',
            location: '',
            sort: 'expiration_date'
        },
        init() {
            // Initialize from URL
            const urlParams = new URLSearchParams(window.location.search);
            this.params = {
                search: urlParams.get('search') || '',
                category: urlParams.get('category') || '',
                location: urlParams.get('location') || '',
                sort: urlParams.get('sort') || 'expiration_date'
            };

            // Dispatch initial values
            this.$watch('params', () => this.updateFilters(), { deep: true });
        },
        updateFilters: Alpine.debounce(function() {
            this.$dispatch('filter-changed', this.params);
        }, 150)
    }"
     @filter-changed.window="params = $event.detail">

    <form id="search-form"
          class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-4">

        <!-- Search Field -->
        <input type="text"
               name="search"
               x-model="params.search"
               @input.debounce.300ms="$dispatch('search-updated', params.search)"
               placeholder="Suche..."
               class="w-full p-3 rounded-lg bg-darkCard border border-brandIndigo/30 text-white">

        <!-- Filter Dropdowns -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <select x-model="params.category"
                    name="category"
                    @change="$dispatch('filter-changed')"
                    class="p-3 rounded-lg bg-darkCard border border-brandIndigo/30 text-white">
                <option value="">Alle Kategorien</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            <select x-model="params.location"
                    name="location"
                    @change="$dispatch('filter-changed')"
                    class="p-3 rounded-lg bg-darkCard border border-brandIndigo/30 text-white">
                <option value="">Alle Standorte</option>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
            </select>

            <select x-model="params.sort"
                    name="sort"
                    @change="$dispatch('filter-changed')"
                    class="p-3 rounded-lg bg-darkCard border border-brandIndigo/30 text-white">
                <option value="expiration_date">Sortieren nach Datum</option>
                <option value="name">Sortieren nach Name</option>
                <option value="created_at">Sortieren nach Hinzugefügt</option>
            </select>
        </div>
    </form>
</div>
