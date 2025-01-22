<section class="bg-green-800 p-6 rounded-lg shadow-lg text-gray-100">
    <header>
        <h2 class="text-xl font-semibold text-gray-100">
            {{ __('Profilinformationen') }}
        </h2>
        <p class="mt-2 text-sm text-gray-300">
            {{ __("Aktualisiere die Profilinformationen und die E-Mail-Adresse deines Kontos.") }}
        </p>
    </header>

    <!-- Verifizierung senden -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Profilinformationen aktualisieren -->
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-gray-200" />
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-2 block w-full rounded-lg bg-green-900 border border-green-700 text-gray-100 placeholder-gray-400 focus:ring-green-500 focus:border-green-500"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
            />
            <x-input-error class="mt-2 text-sm text-red-400" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-200" />
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-2 block w-full rounded-lg bg-green-900 border border-green-700 text-gray-100 placeholder-gray-400 focus:ring-green-500 focus:border-green-500"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
            />
            <x-input-error class="mt-2 text-sm text-red-400" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4">
                    <p class="text-sm text-gray-300">
                        {{ __('Deine E-Mail-Adresse ist nicht verifiziert.') }}

                        <button form="send-verification" class="underline text-sm text-green-400 hover:text-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            {{ __('Hier klicken, um die Verifizierungs-E-Mail erneut zu senden.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-400">
                            {{ __('Ein neuer Verifizierungslink wurde an deine E-Mail-Adresse gesendet.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Buttons -->
        <div class="flex items-center gap-4">
            <x-primary-button class="bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-green-400">
                {{ __('Speichern') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
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
