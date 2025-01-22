<nav x-data="{ open: false }" class="bg-green-700 border-b border-green-600 text-gray-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-12 w-auto fill-current text-white" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-white ">
                    {{ __('Dashboard') }}
                </x-nav-link>

                <x-nav-link :href="route('addGrocery')" :active="request()->routeIs('addGrocery')" class="text-white hover:text-white ">
                    {{ __('Hinzufügen') }}
                </x-nav-link>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-50 bg-green-600 hover:bg-green-500 focus:outline-none transition">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-2 h-4 w-4 text-gray-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path d="M5.23 7.71l4.76 4.77 4.76-4.77" stroke="currentColor" stroke-width="1.5" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-green-500">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="hover:bg-green-500">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="sm:hidden flex items-center">
                <button @click="open = ! open" class="text-gray-50 hover:text-gray-300 focus:outline-none">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path x-show="!open" stroke="currentColor" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="open" stroke="currentColor" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-green-600">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-50 hover:bg-green-500">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('addGrocery')" :active="request()->routeIs('addGrocery')" class="text-gray-50 hover:bg-green-500">
            {{ __('Hinzufügen') }}
        </x-responsive-nav-link>

        <!-- Responsive Settings Options -->
        <div class="border-t border-green-500 py-4 px-4">
            <x-responsive-nav-link :href="route('profile.edit')" class="hover:bg-green-500">
                {{ __('Profile') }}
            </x-responsive-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="hover:bg-green-500">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>
