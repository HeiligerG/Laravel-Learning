<x-guest-layout>
    <div class="bg-darkCard border border-brandIndigo/20 rounded-xl shadow-lg shadow-brandIndigo p-8 max-w-md w-full">
        <h2 class="text-2xl font-bold text-white mb-6 text-center">Login</h2>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div class="space-y-2">
                <x-input-label for="email" :value="__('Email')" class="text-white" />
                <x-text-input id="email"
                              class="w-full px-4 py-3 bg-slate-800/50 text-white placeholder-gray-400 rounded-lg border border-slate-700 focus:border-brandIndigo focus:ring-1 focus:ring-brandIndigo"
                              type="email"
                              name="email"
                              :value="old('email')"
                              required
                              autofocus
                              placeholder="name@example.com" />
                <x-input-error :messages="$errors->get('email')" class="text-sm text-red-400" />
            </div>

            <div class="space-y-2">
                <x-input-label for="password" :value="__('Password')" class="text-white" />
                <x-text-input id="password"
                              class="w-full px-4 py-3 bg-slate-800/50 text-white placeholder-gray-400 rounded-lg border border-slate-700 focus:border-brandIndigo focus:ring-1 focus:ring-brandIndigo"
                              type="password"
                              name="password"
                              required
                              placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="text-sm text-red-400" />
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-slate-700 bg-slate-800/50 text-brandIndigo focus:ring-brandIndigo">
                    <span class="ml-2 text-sm text-gray-300">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-sm text-brandIndigo hover:text-brandIndigo/80 transition-colors">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <div class="flex flex-col gap-4">
                <x-primary-button class="w-full justify-center py-3 bg-brandIndigo hover:bg-brandIndigo/90">
                    {{ __('Log in') }}
                </x-primary-button>

                <p class="text-center text-sm text-gray-300">
                    {{ __("Don't have an account?") }}
                    <a href="{{ route('register') }}"
                       class="text-brandIndigo hover:text-brandIndigo/80 transition-colors">
                        {{ __('Register') }}
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
