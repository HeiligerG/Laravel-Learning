<x-app-layout>
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="relative w-full h-64 overflow-hidden rounded-xl shadow-2xl">
                <img
                    src="{{ asset('images/bg-info.png') }}"
                    alt="bg-Info"
                    class="absolute inset-0 w-full h-full object-cover transform scale-105 hover:scale-100 transition-transform duration-700"
                />

                <!-- Gradient overlay -->
                <div class="absolute inset-0 bg-gradient-to-br from-brandIndigo/60 to-brandIndigo/40"></div>

                <!-- Content -->
                <div class="relative z-10 h-full flex flex-col items-center justify-center p-6">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 text-center">
                        Lebensmittelübersicht
                    </h1>
                    <p class="text-lg sm:text-xl text-white/90 font-medium max-w-2xl text-center">
                        Behalte den Überblick über deine Lebensmittel und deren Verfallsdaten.
                    </p>
                </div>
            </div>
    <div class="py-6 bg-brandDark">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-mainIndigo text-gray-100 overflow-hidden shadow-lg sm:rounded-lg">
                @include('item.index', ['foodItems' => $foodItems])
            </div>
        </div>
    </div>
</x-app-layout>
