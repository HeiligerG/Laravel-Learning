<x-guest-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="relative w-full h-64 overflow-hidden rounded-xl shadow-2xl">
                <img
                    src="{{ asset('images/bg-info.png') }}"
                    alt="bg-Info"
                    class="absolute inset-0 w-full h-full object-cover transform scale-105 hover:scale-100 transition-transform duration-700"
                />
                <div class="absolute inset-0 bg-gradient-to-br from-brandIndigo/60 to-brandIndigo/40"></div>
                <div class="relative z-10 flex flex-col items-center justify-center h-full px-6 space-y-4">
                    <h2 class="text-6xl font-extrabold text-white tracking-tight">
                        Community erstellen
                    </h2>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6 bg-brandDark">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('community.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <input type="text" name="name"
                           class="w-full p-2 border rounded"
                           placeholder="Community-Name"
                           required>
                </div>
                <div class="mb-4">
                    <input type="password" name="password"
                           class="w-full p-2 border rounded"
                           placeholder="Passwort (min. 8 Zeichen)"
                           required>
                </div>
                <button type="submit"
                        class="bg-green-500 text-white px-4 py-2 rounded">
                    Erstellen
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
