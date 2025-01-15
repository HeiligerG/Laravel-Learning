@props(['items', 'name', 'label', 'route'])

<div x-data="{
    open: false,
    modalOpen: false,
    items: {{$items}},
    newItem: '',
    async addItem() {
        const trimmedItem = this.newItem.trim();

        if (!trimmedItem) {
            alert('Der {{$label}} darf nicht leer sein.');
            return;
        }

        try {
            const response = await axios.post(route('{{$route}}'), {
                item: trimmedItem
            });

            if (response && response.data) {
                this.items.push(response.data);
                this.newItem = '';
                this.modalOpen = false;
            } else {
                console.error('Leere oder ungültige Antwort vom Server:', response);
                alert('Es ist ein unerwarteter Fehler aufgetreten.');
            }
        } catch (error) {
            console.error('Fehler beim Hinzufügen von {{$label}}:', error);

            if (error.response && error.response.data && error.response.data.message) {
                alert(`Fehler: ${error.response.data.message}`);
            } else {
                alert('Es ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut.');
            }
        }
    }
}">

    <div class="relative">
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
            @click="modalOpen = true"
            class="mt-2 text-sm text-blue-600 hover:text-blue-800"
        >
            + Neue{{ $label === 'Standort' ? 'r' : '' }} {{ $label }}
        </button>
    </div>

    <!-- Modal -->
    <div
        x-show="modalOpen"
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto"
        @click.away="modalOpen = false"
    >
        <div class="flex min-h-screen items-center justify-center px-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
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
                        @click="modalOpen = false"
                        class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:col-start-1 sm:mt-0 sm:text-sm"
                    >
                        Abbrechen
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
