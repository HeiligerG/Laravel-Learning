<section>
    <header class="mb-6">
        <h2 class="text-xl font-bold text-white">{{ __('Profilinformationen') }}</h2>
        <p class="mt-1.5 text-sm text-gray-400">
            {{ __("Aktualisiere die Profilinformationen und die E-Mail-Adresse deines Kontos.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="space-y-2">
            <x-input-label for="name" :value="__('Name')" class="text-white" />
            <x-text-input id="name" name="name" type="text"
                          class="w-full px-4 py-3 bg-slate-800/50 text-white placeholder-gray-400 rounded-lg border border-slate-700 focus:border-brandIndigo focus:ring-1 focus:ring-brandIndigo transition-colors"
                          :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="text-sm text-red-400" :messages="$errors->get('name')" />
        </div>

        <div class="space-y-2">
            <x-input-label for="email" :value="__('Email')" class="text-white" />
            <x-text-input id="email" name="email" type="email"
                          class="w-full px-4 py-3 bg-slate-800/50 text-white placeholder-gray-400 rounded-lg border border-slate-700 focus:border-brandIndigo focus:ring-1 focus:ring-brandIndigo transition-colors"
                          :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="text-sm text-red-400" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-yellow-500/10 border border-yellow-500/20 rounded-lg">
                    <p class="text-sm text-gray-300">
                        {{ __('Deine E-Mail-Adresse ist nicht verifiziert.') }}
                        <button form="send-verification"
                                class="text-brandIndigo hover:text-brandIndigo/80 underline transition-colors focus:outline-none">
                            {{ __('Hier klicken, um die Verifizierungs-E-Mail erneut zu senden.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-emerald-400">
                            {{ __('Ein neuer Verifizierungslink wurde an deine E-Mail-Adresse gesendet.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center justify-end gap-4">
            <x-primary-button
                class="px-6 py-2.5 bg-brandIndigo hover:bg-brandIndigo/80 text-white rounded-lg transition-all duration-200 font-medium">
                {{ __('Speichern') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-emerald-400">
                    {{ __('Gespeichert.') }}
                </p>
            @endif
        </div>
    </form>
</section>
