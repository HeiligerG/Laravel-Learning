<x-guest-layout>
    <div class="mb-4 text-sm text-gray-400 text-center">
        <p>{{ __('Passwort vergessen?') }}</p>
        <p>{{ __('Kein Problem! Gib einfach deine E-Mail-Adresse ein, und wir senden dir einen Link zum Zurücksetzen. 😊') }}</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" novalidate>
        @csrf

        <div>
            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-white text-center">
                    {{ __('Deine E-mail') }}
                </label>
                <input id="email"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       class="w-full px-4 py-3 bg-slate-800/50 text-white placeholder-gray-400 placeholder:text-center rounded-lg border border-slate-700 focus:border-brandIndigo focus:ring-1 focus:ring-brandIndigo transition-colors"
                       required
                       autofocus
                       placeholder="name@example.com"
                >
            </div>
        </div>

        <div class="mt-4">
        @if (session('status'))
            <x-alert
                type="info"
                :message="session('status')"
                class="mb-4"
            />
        @endif

        @if (session('success'))
            <x-alert
                type="success"
                :message="session('success')"
                class="mb-4"
            />
        @endif

        @if ($errors->any())
            <x-alert
                type="error"
                :message="$errors->first()"
                class="mb-4"
            />
        @endif
        </div>

        <div class="flex items-center justify-center mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
