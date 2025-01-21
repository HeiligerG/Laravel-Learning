@props(['items', 'name', 'label', 'route'])

<div x-data="{
    open: false,
    items: {{$items}},
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

    <div class="relative" x-data="{ open: false }">
    <div>
        <label :for="$name" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
        <div class="mt-1">
            <select
                :name="$name"
                :id="$name"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
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
            class="mt-2 text-sm text-blue-600 hover:text-blue-800"
        >
            + Neue{{ $label === 'Standort' ? 'r' : '' }} {{ $label }}
        </button>
    </div>

    <!-- Modal -->
    <div
        x-show="open"
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto"
    >
        <div class="flex min-h-screen items-center justify-center px-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div @click.away="open = false" class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Neue{{ $label === 'Standort' ? 'r' : '' }} {{ $label }} hinzufügen</h3>

                    <div class="mt-4">
                        <input
                            type="text"
                            x-model="newItem"
                            @keyup.enter="addItem"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            :placeholder="'{{$label}}name eingeben'"
                        >
                    </div>
                </div>

                <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                    <button
                        type="button"
                        @click="addItem"
                        class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:col-start-2 sm:text-sm"
                    >
                        Hinzufügen
                    </button>
                    <button
                        type="button"
                        @click="open = false"
                        class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:col-start-1 sm:mt-0 sm:text-sm"
                    >
                        Abbrechen
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
