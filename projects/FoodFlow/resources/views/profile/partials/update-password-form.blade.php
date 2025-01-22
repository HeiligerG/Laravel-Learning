<section class="bg-green-800 p-6 rounded-lg shadow-lg text-gray-100">
    <header>
        <h2 class="text-xl font-semibold text-gray-100">
            {{ __('Passwort aktualisieren') }}
        </h2>
        <p class="mt-2 text-sm text-gray-300">
            {{ __('Stelle sicher, dass dein Konto ein langes, zufälliges Passwort verwendet, um sicher zu bleiben.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <!-- Aktuelles Passwort -->
        <div>
            <x-input-label for="update_password_current_password" :value="__('Aktuelles Passwort')" class="text-gray-200" />
            <x-text-input
                id="update_password_current_password"
                name="current_password"
                type="password"
                class="mt-2 block w-full rounded-lg bg-green-900 border border-green-700 text-gray-100 placeholder-gray-400 focus:ring-green-500 focus:border-green-500"
                autocomplete="current-password"
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-sm text-red-400" />
        </div>

        <!-- Neues Passwort -->
        <div>
            <x-input-label for="update_password_password" :value="__('Neues Passwort')" class="text-gray-200" />
            <x-text-input
                id="update_password_password"
                name="password"
                type="password"
                class="mt-2 block w-full rounded-lg bg-green-900 border border-green-700 text-gray-100 placeholder-gray-400 focus:ring-green-500 focus:border-green-500"
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-sm text-red-400" />
        </div>

        <!-- Passwort bestätigen -->
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Passwort bestätigen')" class="text-gray-200" />
            <x-text-input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                class="mt-2 block w-full rounded-lg bg-green-900 border border-green-700 text-gray-100 placeholder-gray-400 focus:ring-green-500 focus:border-green-500"
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-sm text-red-400" />
        </div>

        <!-- Buttons -->
        <div class="flex items-center gap-4">
            <x-primary-button class="bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded-md shadow focus:outline-none focus:ring-2 focus:ring-green-400">
                {{ __('Speichern') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-400"
                >
                    {{ __('Gespeichert.') }}
                </p>
            @endif
        </div>
    </form>
</section>
