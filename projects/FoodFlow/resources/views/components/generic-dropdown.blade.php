@props(['items', 'name', 'label', 'route'])

<div x-data="{
    open: false,
    items: @js($items),
    newItem: '',
    async addItem() {
        if (!this.newItem.trim()) return;

        try {
            const response = await axios.post('{{ $route }}', {
                name: this.newItem.trim()
            });

            this.items.push(response.data);
            this.newItem = '';
            this.open = false;

        } catch (error) {
            const message = error.response?.data?.message || 'Es ist ein Fehler aufgetreten.';
            alert(message);
        }
    }
}">

    <div class="relative">
        <!-- Label und Dropdown -->
        <div>
            <label for="{{ $name }}" class="block text-sm font-medium text-gray-200">{{ $label }}</label>
            <div class="mt-2">
                <select
                    name="{{ $name }}_id"
                    id="{{ $name }}_id"
                    class="block w-full h-14 rounded-lg border border-green-700 bg-green-900 text-gray-100 shadow-sm focus:border-green-500 focus:ring-green-500"
                    required
                >
                    <option value="">Bitte wählen</option>
                    <template x-for="item in items" :key="item.id">
                        <option :value="item.id" x-text="item.name"></option>
                    </template>
                </select>
            </div>

            <button
                type="button"
                @click="open = true"
                class="mt-3 text-sm text-green-400 hover:text-green-500"
            >
                + Neue{{ $label === 'Standort' ? 'r' : '' }} {{ $label }}
            </button>
        </div>

        <!-- Modal -->
        <div
            x-show="open"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75"
        >
            <div @click.away="open = false" class="relative bg-white rounded-lg shadow-xl sm:w-full sm:max-w-lg">
                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Neue{{ $label === 'Standort' ? 'r' : '' }} {{ $label }} hinzufügen</h3>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-4">
                    <input
                        type="text"
                        x-model="newItem"
                        @keyup.enter="addItem"
                        class="block w-full rounded-md border border-gray-300 bg-gray-50 text-gray-800 shadow-sm focus:border-green-500 focus:ring-green-500"
                        :placeholder="'{{$label}}name eingeben'"
                    >
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                    <button
                        type="button"
                        @click="addItem"
                        class="bg-green-600 text-white px-4 py-2 rounded-md shadow hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-400"
                    >
                        Hinzufügen
                    </button>
                    <button
                        type="button"
                        @click="open = false"
                        class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md shadow hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-green-400"
                    >
                        Abbrechen
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
