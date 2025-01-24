<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="space-y-2">
            <x-input-label for="update_password_current_password" :value="__('Aktuelles Passwort')" class="text-white" />
            <x-text-input
                id="update_password_current_password"
                name="current_password"
                type="password"
                class="w-full px-4 py-3 bg-slate-800/50 text-white placeholder-gray-400 rounded-lg border border-slate-700 focus:border-brandIndigo focus:ring-1 focus:ring-brandIndigo transition-colors"
                autocomplete="current-password"
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="text-sm text-red-400" />
        </div>

        <div class="space-y-2">
            <x-input-label for="update_password_password" :value="__('Neues Passwort')" class="text-white" />
            <x-text-input
                id="update_password_password"
                name="password"
                type="password"
                class="w-full px-4 py-3 bg-slate-800/50 text-white placeholder-gray-400 rounded-lg border border-slate-700 focus:border-brandIndigo focus:ring-1 focus:ring-brandIndigo transition-colors"
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="text-sm text-red-400" />
        </div>

        <div class="space-y-2">
            <x-input-label for="update_password_password_confirmation" :value="__('Passwort bestätigen')" class="text-white" />
            <x-text-input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                class="w-full px-4 py-3 bg-slate-800/50 text-white placeholder-gray-400 rounded-lg border border-slate-700 focus:border-brandIndigo focus:ring-1 focus:ring-brandIndigo transition-colors"
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="text-sm text-red-400" />
        </div>

        <div class="flex items-center justify-end gap-4">
            <x-primary-button class="px-6 py-2.5 bg-brandIndigo hover:bg-brandIndigo/80 text-white rounded-lg transition-all duration-200 font-medium">
                {{ __('Speichern') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-emerald-400">{{ __('Gespeichert.') }}</p>
            @endif
        </div>
    </form>
</section>
