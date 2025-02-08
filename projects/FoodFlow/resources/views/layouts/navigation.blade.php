<nav x-data="{ open: false }" class="bg-darkCard border-b border-brandIndigo/20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="relative flex h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <x-application-logo class="h-14 w-auto"/>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden sm:ml-8 sm:flex sm:items-center sm:justify-center sm:space-x-4">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                            class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-brandIndigo text-white' : 'text-gray-300 hover:text-white hover:bg-white/5' }} transition-all">
                    <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard</span>
                </x-nav-link>

                <x-nav-link :href="route('addGrocery')" :active="request()->routeIs('addGrocery')"
                            class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('addGrocery') ? 'bg-brandIndigo text-white' : 'text-gray-300 hover:text-white hover:bg-white/5' }} transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <span>Hinzufügen</span>
                </x-nav-link>
            </div>

            <!-- User Menu -->
            <div class="flex-1 flex items-center justify-end">
                <div class="flex items-center">
                    <!-- Desktop Profile Dropdown -->
                    <div class="hidden sm:ml-3 sm:flex sm:items-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="group flex items-center gap-3 px-4 py-2.5 bg-darkCard/50 rounded-lg hover:bg-brandIndigo/20 transition-colors">
                                    <span class="text-sm font-medium text-white">{{ Auth::user()->name }}</span>
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-brandIndigo transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="bg-darkCard/95 backdrop-blur-sm border border-brandIndigo/20 rounded-lg shadow-xl divide-y divide-brandIndigo/10">
                                    <x-dropdown-link :href="route('profile.edit')">
                                        Profil bearbeiten
                                    </x-dropdown-link>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                                         onclick="event.preventDefault(); this.closest('form').submit();"
                                                         class="!text-red-400 hover:!bg-red-500/10">
                                            Abmelden
                                        </x-dropdown-link>
                                    </form>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="sm:hidden">
                        <button @click="open = !open" type="button"
                                class="inline-flex items-center justify-center p-2 text-gray-300 hover:text-white hover:bg-white/5 rounded-lg transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': !open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                                <path :class="{'hidden': !open, 'inline-flex': open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div :class="{'block': open, 'hidden': !open}" x-cloak class="sm:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                                       class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('dashboard') ? 'bg-brandIndigo text-black' : 'text-brandIndigo hover:text-white hover:bg-white/5' }} transition-colors">
                    Dashboard
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('addGrocery')" :active="request()->routeIs('addGrocery')"
                                       class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('addGrocery') ? 'bg-brandIndigo text-black' : 'text-brandIndigo hover:text-white hover:bg-white/5' }} transition-colors">
                    Hinzufügen
                </x-responsive-nav-link>
            </div>

            <!-- Mobile Profile Menu -->
            <div class="pt-4 pb-3 border-t border-brandIndigo/20">
                <div class="px-2 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')"
                                           class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('profile.edit') ? 'bg-brandIndigo text-black' : 'text-brandIndigo hover:text-white hover:bg-white/5' }} transition-colors">
                        Profil
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault(); this.closest('form').submit();"
                                               class="block px-3 py-2 rounded-lg text-base font-medium text-red-400 hover:bg-red-500/10 transition-colors">
                            Abmelden
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
