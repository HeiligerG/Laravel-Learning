<x-app-layout>
<section class="min-h-screen bg-brandDark py-12">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-slate-800/40 rounded-xl shadow-xl border border-brandIndigo/20 p-6 md:p-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-white">
                    {{ $foodItem->name }}
                </h1>
                <div class="flex space-x-4">
                    <a href="{{ route('foodItems.edit', $foodItem) }}"
                       class="px-6 py-2.5 bg-brandIndigo hover:bg-brandIndigo/80 text-white rounded-lg transition-all duration-200 flex items-center gap-2 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Bearbeiten
                    </a>
                </div>
            </div>

            <div class="grid gap-6 text-gray-300">
                <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4">
                    <span class="font-medium text-white min-w-[8rem]">Kategorie</span>
                    <span class="bg-slate-700/50 px-4 py-2 rounded-lg border border-slate-600/50">
                        {{ $foodItem->category->name }}
                    </span>
                </div>

                <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4">
                    <span class="font-medium text-white min-w-[8rem]">Standort</span>
                    <span class="bg-slate-700/50 px-4 py-2 rounded-lg border border-slate-600/50">
                        {{ $foodItem->location->name }}
                    </span>
                </div>

                <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4">
                    <span class="font-medium text-white min-w-[8rem]">Verfallsdatum</span>
                    <span class="px-4 py-2 rounded-lg font-medium {{ $foodItem->expiration_date->isPast()
                        ? 'bg-red-500/20 text-red-400 border border-red-500/30'
                        : 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' }}">
                        {{ $foodItem->expiration_date->format('d.m.Y') }}
                    </span>
                </div>

                <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4">
                    <span class="font-medium text-white min-w-[8rem]">Menge</span>
                    <span class="bg-brandIndigo/20 text-brandIndigo px-4 py-2 rounded-lg border border-brandIndigo/30">
                        {{ $foodItem->quantity }} Stück
                    </span>
                </div>
            </div>

            <div class="mt-12 pt-6 border-t border-slate-700/50">
                <form method="POST" action="{{ route('foodItems.destroy', $foodItem) }}"
                      class="flex justify-end">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="group px-6 py-2.5 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white rounded-lg transition-all duration-300 flex items-center gap-2 font-medium"
                            onclick="return confirm('Möchten Sie dieses Lebensmittel wirklich löschen?')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Entfernen
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
        </x-app-layout>
