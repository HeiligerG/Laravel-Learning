@props(['items', 'name', 'label', 'route'])

<div x-data="dropdownComponent(@js($items), '{{ $route }}')" class="relative">
    <!-- Label und Dropdown -->
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-200">{{ $label }}</label>
    <select
        name="{{ $name }}"
        id="{{ $name }}_id"
        class="block w-full h-14 mt-2 rounded-lg border border-green-700 bg-green-900 text-gray-100 shadow-sm focus:border-green-500 focus:ring-green-500"
        required
    >
        <option value="">Bitte wählen</option>
        <template x-for="item in items" :key="item.id">
            <option :value="item.id" x-text="item.name || 'Kein Name gefunden'" ></option>
        </template>
    </select>

    <!-- Neuer Eintrag Button -->
    <button
        type="button"
        @click="openModal = true"
        class="mt-3 text-sm text-green-400 hover:text-green-500"
    >
        + Neue{{ $label === 'Standort' ? 'r' : '' }} {{ $label }}
    </button>

    <!-- Modal -->
    <div
        x-show="openModal"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75"
    >
        <div @click.away="openModal = false" class="bg-white rounded-lg shadow-xl w-96 p-6">
            <!-- Modal Header -->
            <h3 class="text-lg font-medium text-gray-900">
                Neue{{ $label === 'Standort' ? 'r' : '' }} {{ $label }} hinzufügen
            </h3>

            <!-- Modal Body -->
            <div class="mt-4">
                <input
                    type="text"
                    x-model="newItem"
                    placeholder="{{ $label }} eingeben"
                    class="block w-full rounded-md border border-gray-300 bg-gray-50 text-gray-800 shadow-sm focus:border-green-500 focus:ring-green-500"
                >
            </div>

            <!-- Modal Footer -->
            <div class="mt-6 flex justify-end space-x-3">
                <button
                    type="button"
                    @click="addItem"
                    class="bg-green-600 text-white px-4 py-2 rounded-md shadow hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-400"
                >
                    Hinzufügen
                </button>
                <button
                    type="button"
                    @click="openModal = false"
                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md shadow hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-green-400"
                >
                    Abbrechen
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function dropdownComponent(initialItems, route) {
        return {
            items: initialItems,
            openModal: false,
            newItem: '',
            async addItem() {
                if (!this.newItem.trim()) return alert('Name darf nicht leer sein.');

                try {
                    const response = await axios.post(route, { name: this.newItem.trim() });
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
