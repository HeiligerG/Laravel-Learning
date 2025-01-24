```html
<x-guest-layout>
    <div class="bg-darkCard border border-brandIndigo/20 rounded-xl shadow-xl p-8 max-w-md w-full">
        <div class="mb-6 text-sm text-gray-300 leading-relaxed">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-lg">
                <p class="text-sm text-emerald-400">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
            </div>
        @endif

        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button class="w-full sm:w-auto justify-center py-2.5 bg-brandIndigo hover:bg-brandIndigo/90">
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-red-400 hover:text-red-300 transition-colors">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
```
