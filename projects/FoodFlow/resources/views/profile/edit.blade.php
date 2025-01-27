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
                    {{ Auth::user()->name }}'s Profil
                </h1>
            </div>
        </div>
    <div class="min-h-screen bg-brandDark py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <!-- Profile Info -->
            <div class="bg-darkCard rounded-xl shadow-xl border border-brandIndigo/20 p-6 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="bg-darkCard rounded-xl shadow-xl border border-brandIndigo/20 p-6 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.community-management')
                </div>
            </div>

            <!-- Password -->
            <div class="bg-darkCard rounded-xl shadow-xl border border-brandIndigo/20 p-6 sm:p-8">
                <div class="max-w-xl">
                    <h3 class="text-xl font-bold text-white mb-2">Passwort aktualisieren</h3>
                    <p class="text-gray-400 text-sm mb-6">Stelle sicher, dass dein Konto ein langes, zufälliges Passwort verwendet, um sicher zu bleiben.</p>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account -->
            <div class="bg-darkCard rounded-xl shadow-xl border border-red-500/20 p-6 sm:p-8">
                <div class="max-w-xl">
                    <h3 class="text-xl font-bold text-red-400 mb-2">Benutzer löschen</h3>
                    <p class="text-gray-400 text-sm mb-6">Einmal gelöscht, können alle Ressourcen und Daten unwiederbringlich entfernt werden.</p>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
