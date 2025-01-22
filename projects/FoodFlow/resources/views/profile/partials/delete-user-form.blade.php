<section class="bg-red-800 p-6 rounded-lg shadow-lg text-gray-100 space-y-6">
    <header>
        <h2 class="text-xl font-semibold">
            {{ __('Account löschen') }}
        </h2>
        <p class="mt-2 text-sm text-gray-300">
            {{ __('Sobald dein Konto gelöscht ist, werden alle Ressourcen und Daten unwiderruflich entfernt. Bitte lade alle Daten herunter, die du behalten möchtest, bevor du dein Konto löschst.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded-md shadow focus:outline-none focus:ring-2 focus:ring-red-400"
    >
        {{ __('Account löschen') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-red-700 rounded-lg text-gray-100">
            @csrf
            @method('delete')

            <h2 class="text-lg font-semibold text-gray-100">
                {{ __('Bist du sicher, dass du dein Konto löschen möchtest?') }}
            </h2>

            <p class="mt-2 text-sm text-gray-300">
                {{ __('Sobald dein Konto gelöscht ist, werden alle Ressourcen und Daten unwiderruflich entfernt. Bitte gib dein Passwort ein, um die Löschung zu bestätigen.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" :value="__('Passwort')" class="sr-only" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-2 block w-3/4 rounded-lg bg-red-800 border border-red-600 text-gray-100 placeholder-gray-400 focus:ring-red-500 focus:border-red-500"
                    placeholder="{{ __('Passwort') }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-sm text-red-400" />
            </div>

            <div class="mt-6 flex justify-end gap-4">
                <x-secondary-button
                    x-on:click="$dispatch('close')"
                    class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500"
                >
                    {{ __('Abbrechen') }}
                </x-secondary-button>

                <x-danger-button
                    class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded-md shadow focus:outline-none focus:ring-2 focus:ring-red-400"
                >
                    {{ __('Account löschen') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
