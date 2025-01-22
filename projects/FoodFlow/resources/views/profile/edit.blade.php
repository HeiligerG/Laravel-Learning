<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-100 leading-tight">
            {{ __('Profil') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-green-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profilinformationen aktualisieren -->
            <div class="p-6 sm:p-8 bg-green-800 shadow-lg sm:rounded-lg">
                <div class="max-w-xl text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Profilinformationen</h3>
                    <p class="text-sm text-gray-300 mb-6">Aktualisiere deine Profilinformationen und E-Mail-Adresse.</p>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Passwort aktualisieren -->
            <div class="p-6 sm:p-8 bg-green-800 shadow-lg sm:rounded-lg">
                <div class="max-w-xl text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Passwort aktualisieren</h3>
                    <p class="text-sm text-gray-300 mb-6">Stelle sicher, dass dein Konto ein langes, zufälliges Passwort verwendet, um sicher zu bleiben.</p>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Benutzer löschen -->
            <div class="p-6 sm:p-8 bg-red-800 shadow-lg sm:rounded-lg">
                <div class="max-w-xl text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Benutzer löschen</h3>
                    <p class="text-sm text-gray-300 mb-6">Einmal gelöscht, können alle Ressourcen und Daten unwiederbringlich entfernt werden.</p>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
