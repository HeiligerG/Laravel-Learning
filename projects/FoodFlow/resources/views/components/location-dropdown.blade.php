@props(['locations'])

<div x-data="{
    open: false,
    locations: @js($locations),
    newLocation: '',
    addLocation() {
        if (!this.newLocation.trim()) {
            alert('Der Standortname darf nicht leer sein.');
            return;
        }

        axios.post('/locations', { name: this.newLocation })
            .then(response => {
                this.locations.push(response.data);
                this.newLocation = '';
                this.open = false;
            })
            .catch(error => {
                console.error('Fehler beim Hinzufügen des Standorts:', error);
                alert('Es ist ein Fehler aufgetreten.');
            });
    }
}">
    <div class="relative">
        <label for="location" class="block text-sm font-medium text-gray-700">Standort</label>
        <div class="mt-1">
            <select
                name="location"
                id="location"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                required
            >
                <option value="">Bitte wählen</option>
                <template x-for="location in locations" :key="location.id">
                    <option :value="location.id" x-text="location.name"></option>
                </template>
            </select>
        </div>

        <button
            type="button"
            @click="open = true"
            class="mt-2 text-sm text-blue-600 hover:text-blue-800"
        >
            + Neuer Standort
        </button>
    </div>

    <!-- Modal -->
    <div
        x-show="open"
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto"
        @click.away="open = false"
    >
        <div class="flex min-h-screen items-center justify-center px-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Neuen Standort hinzufügen</h3>

                    <div class="mt-4">
                        <input
                            type="text"
                            x-model="newLocation"
                            @keyup.enter="addLocation"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Standortname eingeben"
                        >
                    </div>
                </div>

                <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                    <button
                        type="button"
                        @click="addLocation"
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
