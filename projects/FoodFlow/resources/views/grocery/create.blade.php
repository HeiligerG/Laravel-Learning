<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="relative w-full h-64 overflow-hidden rounded-xl shadow-2xl">
            <img
                src="{{ asset('images/bg-info.png') }}"
                alt="bg-Info"
                class="absolute inset-0 w-full h-full object-cover transform scale-105 hover:scale-100 transition-transform duration-700"
            />

            <div class="absolute inset-0 bg-gradient-to-br from-brandIndigo/60 to-brandIndigo/40"></div>

            <div class="relative z-10 h-full flex flex-col items-center justify-center p-6">
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 text-center">
                    Neues Lebensmittel hinzufügen
                </h1>
            </div>
        </div>
    <div class="py-6 bg-brandDark">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    @include('item.create', ['categories' => $categories, 'locations' => $locations])
        </div>
    </div>
</x-app-layout>
