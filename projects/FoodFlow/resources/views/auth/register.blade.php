<x-guest-layout>
    <div class="bg-darkCard border border-brandIndigo/20 rounded-xl shadow-lg shadow-brandIndigo p-8 max-w-md w-full">
        <h2 class="text-2xl font-bold text-white mb-6 text-center">Register</h2>

        <form method="POST" action="{{ route('register') }}" novalidate class="space-y-6">
            @csrf

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

            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium text-white">Name</label>
                <input id="name"
                       type="text"
                       name="name"
                       value="{{ old('name') }}"
                       class="w-full px-4 py-3 bg-slate-800/50 text-white placeholder-gray-400 rounded-lg border border-slate-700 focus:border-brandIndigo focus:ring-1 focus:ring-brandIndigo transition-colors"
                       required
                       autofocus
                       placeholder="John Doe" />
            </div>

            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-white">Email</label>
                <input id="email"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       class="w-full px-4 py-3 bg-slate-800/50 text-white placeholder-gray-400 rounded-lg border border-slate-700 focus:border-brandIndigo focus:ring-1 focus:ring-brandIndigo transition-colors"
                       required
                       placeholder="name@example.com" />
            </div>

            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-white">Password</label>
                <input id="password"
                       type="password"
                       name="password"
                       class="w-full px-4 py-3 bg-slate-800/50 text-white placeholder-gray-400 rounded-lg border border-slate-700 focus:border-brandIndigo focus:ring-1 focus:ring-brandIndigo transition-colors"
                       required
                       placeholder="••••••••" />
            </div>

            <div class="space-y-2">
                <label for="password_confirmation" class="block text-sm font-medium text-white">Confirm Password</label>
                <input id="password_confirmation"
                       type="password"
                       name="password_confirmation"
                       class="w-full px-4 py-3 bg-slate-800/50 text-white placeholder-gray-400 rounded-lg border border-slate-700 focus:border-brandIndigo focus:ring-1 focus:ring-brandIndigo transition-colors"
                       required
                       placeholder="••••••••" />
            </div>

            <div class="flex flex-col gap-4 pt-2">
                <x-primary-button class="w-full justify-center py-3 bg-brandIndigo hover:bg-brandIndigo/90">
                    Register
                </x-primary-button>

                <p class="text-center text-sm text-gray-300">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-brandIndigo hover:text-brandIndigo/80 transition-colors">
                        Log in
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
