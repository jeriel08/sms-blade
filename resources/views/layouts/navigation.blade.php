<nav x-data="{ open: false, mobileOpen: false }" class="bg-white border-r border-gray-200 w-64 shrink-0 fixed left-0 top-0 h-screen flex flex-col">
    <!-- Logo Section -->
    <div class="p-4 border-b border-gray-200 bg-white shrink-0">
        <div class="flex items-center">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                <x-application-logo class="block h-8 w-auto fill-current text-gray-800" />
                <span class="text-xl font-bold text-gray-900">{{ config('app.name', 'Laravel') }}</span>
            </a>
        </div>
    </div>

    <!-- Navigation Links - This will grow to take available space -->
    <div class="flex-1 px-4 py-4 space-y-2">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="!justify-start !px-4 !py-3">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            {{ __('Dashboard') }}
        </x-nav-link>
        
        <!-- Add more navigation links here as needed -->
    </div>

    <!-- User Section - This stays at the bottom but not forced -->
    <div class="p-4 border-t border-gray-200 bg-white shrink-0">
        <x-dropdown align="left" width="48">
           <x-slot name="trigger">
                <button class="flex items-center justify-between w-full px-3 py-2 text-sm rounded-md text-gray-700 hover:bg-gray-100 focus:outline-hidden transition ease-in-out duration-150">
                    <div class="flex items-center min-w-0 flex-1">
                        <div class="min-w-0 flex-1 text-left">
                            <div class="text-sm font-medium text-gray-900 truncate">
                                {{ Auth::user()->name }}
                            </div>
                            <div class="text-xs text-gray-500 truncate">
                                {{ Auth::user()->email }}
                            </div>
                        </div>
                    </div>
                    <svg class="ms-2 flex-shrink-0 fill-current h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')" class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {{ __('Profile') }}
                </x-dropdown-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            class="flex items-center text-red-600 hover:text-red-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>

    <!-- Mobile Navigation Button -->
    <div class="sm:hidden p-4 border-b border-gray-200">
        <button @click="mobileOpen = ! mobileOpen" class="flex items-center justify-between w-full px-3 py-2 text-sm rounded-md text-gray-700 hover:bg-gray-100 focus:outline-hidden transition ease-in-out duration-150">
            <span>Menu</span>
            <svg class="h-4 w-4" :class="{'rotate-180': mobileOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{'block': mobileOpen, 'hidden': ! mobileOpen}" class="sm:hidden border-t border-gray-200">
        <div class="px-2 py-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="!justify-start !px-3">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Mobile User Section -->
        <div class="px-4 py-4 border-t border-gray-200 space-y-3">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-[--color-1] rounded-full flex items-center justify-center">
                        <span class="text-white text-sm font-medium uppercase">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </span>
                    </div>
                </div>
                <div class="ms-3">
                    <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="!justify-start !px-3">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            class="!justify-start !px-3 text-red-600">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>