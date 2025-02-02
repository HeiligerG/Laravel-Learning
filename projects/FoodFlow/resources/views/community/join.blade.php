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
                        Community beitreten
                    </h2>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6 ">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 bg-darkCard rounded-xl border border-brandIndigo/20 shadow-lg shadow-brandIndigo p-6">
                <h3 class="text-xl font-bold text-white mb-4">Community beitreten</h3>
                <form action="{{ route('community.join') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-white mb-2">Community-Code</label>
                            <input type="text" name="code"
                                   placeholder="Code eingeben"
                                   required
                                   class="w-full px-4 py-3 bg-slate-800/50 text-white placeholder-gray-400 rounded-lg border border-slate-700 focus:border-brandIndigo focus:ring-1 focus:ring-brandIndigo transition-colors">
                        </div>
                        <button type="submit"
                                class="w-full px-6 py-3 bg-brandIndigo hover:bg-brandIndigo/80 text-white rounded-lg transition-all duration-200 flex items-center justify-center gap-2 font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            Beitreten
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-darkCard rounded-xl border border-brandIndigo/20 shadow-lg shadow-brandIndigo p-6">
                <h3 class="text-xl font-bold text-white mb-4">Neue Community erstellen</h3>
                <form action="{{ route('community.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-white mb-2">Community-Name</label>
                            <input type="text" name="name"
                                   placeholder="Name eingeben"
                                   required
                                   class="w-full px-4 py-3 bg-slate-800/50 text-white placeholder-gray-400 rounded-lg border border-slate-700 focus:border-brandIndigo focus:ring-1 focus:ring-brandIndigo transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-white mb-2">Passwort</label>
                            <input type="password" name="password"
                                   placeholder="Min. 8 Zeichen"
                                   required
                                   class="w-full px-4 py-3 bg-slate-800/50 text-white placeholder-gray-400 rounded-lg border border-slate-700 focus:border-brandIndigo focus:ring-1 focus:ring-brandIndigo transition-colors">
                        </div>
                        <button type="submit"
                                class="w-full px-6 py-3 bg-brandIndigo hover:bg-brandIndigo/80 text-white rounded-lg transition-all duration-200 flex items-center justify-center gap-2 font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Erstellen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
