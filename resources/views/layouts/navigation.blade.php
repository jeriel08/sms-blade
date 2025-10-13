<nav x-data="{ open: false, mobileOpen: false }"
    class="bg-white border-r border-gray-200 w-64 shrink-0 fixed left-0 top-0 h-screen flex flex-col">
    <!-- Logo Section -->
    <div class="p-4 border-b border-gray-200 bg-white shrink-0">
        <div class="flex flex-col items-center text-center">
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center space-y-2">
                <x-application-logo class="block h-24 w-auto fill-current text-gray-800" />
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-1">Student Management System</span>
                </div>
            </a>
        </div>
    </div>
    <!-- Navigation Links - This will grow to take available space -->
    <div class="flex-1 px-4 py-4 space-y-3">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
            class="flex gap-2 !justify-start !px-4 !py-auto w-full">
            <x-hugeicons-dashboard-square-02 />
            {{ __('Dashboard') }}
        </x-nav-link>

        @if (auth()->user()->hasRole(['adviser']))
        <x-nav-link :href="route('advisory.index')" :active="request()->routeIs('advisory.index')"
            class="flex gap-2 !justify-start !px-4 !py-auto w-full">
            <x-hugeicons-teacher />
            {{ __('Advisory') }}
        </x-nav-link>
        @endif

        <x-nav-link :href="route('students.index')" :active="request()->routeIs('students.*')" 
                    class="flex gap-2 !justify-start !px-4 !py-auto w-full">
            <x-hugeicons-student />
            {{ __('Students') }}
        </x-nav-link>

        <x-nav-link :href="route('courses')" :active="request()->routeIs('courses')"
            class="flex gap-2 !justify-start !px-4 !py-auto w-full">
            <x-hugeicons-course />
            {{ __('Courses') }}
        </x-nav-link>
        
        <x-nav-link :href="route('enrollments.index')" :active="request()->routeIs('enrollments.*')" 
                    class="flex gap-2 !justify-start !px-4 !py-auto w-full">
            <x-hugeicons-user-add-01 />
            {{ __('Enrollment') }}
        </x-nav-link>

        @if (auth()->user()->hasRole(['principal', 'head-teacher']))    
            <x-nav-link :href="route('admin.control.index')" :active="request()->routeIs('admin.*')" 
                        class="flex gap-2 !justify-start !px-4 !py-auto w-full">
                <x-hugeicons-shield-user />
                {{ __('Admin Panel') }}
            </x-nav-link>
        @endif

        <x-nav-link :href="route('reports')" :active="request()->routeIs('reports')"
            class="flex gap-2 !justify-start !px-4 !py-auto w-full">
            <x-hugeicons-chart-line-data-01 />
            {{ __('Reports') }}
        </x-nav-link>



        <!-- Add more navigation links here as needed -->
    </div>

    <!-- User Section - This stays at the bottom but not forced -->
    <div class="p-4 border-t border-gray-200 bg-white shrink-0">
        <x-dropdown align="left" width="48">
            <x-slot name="trigger">
                <button
                    class="flex items-center justify-between w-full px-3 py-2 text-sm rounded-md text-gray-700 hover:bg-gray-100 focus:outline-hidden transition ease-in-out duration-150">
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
                    <x-hugeicons-arrow-down-01 />
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2">
                    <x-hugeicons-user-account />
                    {{ __('Profile') }}
                </x-dropdown-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();"
                        class="flex items-center gap-2 text-red-600 hover:text-red-700">
                        <x-hugeicons-logout-02 />
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>

    <!-- Mobile Navigation Button -->
    <div class="sm:hidden p-4 border-b border-gray-200">
        <button @click="mobileOpen = ! mobileOpen"
            class="flex items-center justify-between w-full px-3 py-2 text-sm rounded-md text-gray-700 hover:bg-gray-100 focus:outline-hidden transition ease-in-out duration-150">
            <span>Menu</span>
            <svg class="h-4 w-4" :class="{'rotate-180': mobileOpen}" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{'block': mobileOpen, 'hidden': ! mobileOpen}" class="sm:hidden border-t border-gray-200">
        <div class="px-2 py-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="!justify-start !px-3">
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
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();" class="!justify-start !px-3 text-red-600">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>