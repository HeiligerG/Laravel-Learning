<x-app-layout>
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">

            <div class="max-w-7xl mx-auto mb-4">
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

            <div class="relative w-full h-64 overflow-hidden rounded-xl shadow-2xl">
                <img
                    src="{{ asset('images/bg-info.png') }}"
                    alt="bg-Info"
                    class="absolute inset-0 w-full h-full object-cover transform scale-105 hover:scale-100 transition-transform duration-700"
                />
                <div class="absolute inset-0 bg-gradient-to-br from-brandIndigo/60 to-brandIndigo/40"></div>

                <div class="relative z-10 h-full flex flex-col items-center justify-center p-6">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 text-center">
                        Lebensmittelübersicht
                    </h1>
                    <p class="text-lg sm:text-xl text-white/90 font-medium max-w-2xl text-center">
                        Behalte den Überblick über deine Lebensmittel und deren Verfallsdaten.
                    </p>
                    @include('patch-notes.show', ['unseenPatchNotes' => $unseenPatchNotes ?? collect()])
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-mainIndigo text-gray-100 overflow-hidden shadow-lg sm:rounded-lg">
                @include('item.index', ['foodItems' => $foodItems])
            </div>
        </div>
</x-app-layout>

