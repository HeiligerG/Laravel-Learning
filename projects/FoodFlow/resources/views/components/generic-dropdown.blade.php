@props(['items', 'name', 'label', 'route'])

<div x-data="dropdownComponent(@js($items), '{{ $route }}')" class="space-y-2">
    <label for="{{ $name }}" class="block text-sm font-medium text-white">{{ $label }}</label>
    <div class="relative">
        <select name="{{ $name }}" id="{{ $name }}_id"
                class="w-full px-4 py-3 bg-slate-800/50 text-white placeholder-gray-400 rounded-lg border border-slate-700 focus:border-brandIndigo focus:ring-1 focus:ring-brandIndigo appearance-none transition-colors"
                required>
            <option value="">Bitte wählen</option>
            <template x-for="item in items" :key="item.id">
                <option :value="item.id" x-text="item.name"></option>
            </template>
        </select>
    </div>

    <button type="button" @click="openModal = true"
            class="text-sm text-brandIndigo hover:text-brandIndigo/80 transition-colors flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Neue{{ $label === 'Standort' ? 'r' : '' }} {{ $label }}
    </button>

    <!-- Modal -->
    <template x-teleport="body">
        <div x-show="openModal" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div @click.away="openModal = false"
                 class="bg-darkCard rounded-xl border border-brandIndigo/20 shadow-xl w-96 p-6 transform transition-all"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">

                <h3 class="text-lg font-medium text-white mb-4">
                    Neue{{ $label === 'Standort' ? 'r' : '' }} {{ $label }} hinzufügen
                </h3>

                <input type="text" x-model="newItem" placeholder="{{ $label }} eingeben"
                       class="w-full px-4 py-3 bg-slate-800/50 text-white placeholder-gray-400 rounded-lg border border-slate-700 focus:border-brandIndigo focus:ring-1 focus:ring-brandIndigo transition-colors">

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="openModal = false"
                            class="px-4 py-2 text-gray-400 hover:text-white transition-colors">
                        Abbrechen
                    </button>
                    <button type="button" @click="addItem"
                            class="px-4 py-2 bg-brandIndigo hover:bg-brandIndigo/80 text-white rounded-lg transition-colors">
                        Hinzufügen
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>

<script>
    function dropdownComponent(initialItems, route) {
        return {
            items: initialItems,
            openModal: false,
            newItem: '',
            async addItem() {
                if (!this.newItem.trim()) {
                    alert('Name darf nicht leer sein.');
                    return;
                }

                try {
                    const response = await axios.post(route, {
                        name: this.newItem.trim()
                    });
                    this.items.push(response.data);
                    this.newItem = '';
                    this.openModal = false;
                } catch (error) {
                    alert(error.response?.data?.message || 'Ein Fehler ist aufgetreten.');
                }
            }
        };
    }
</script>
