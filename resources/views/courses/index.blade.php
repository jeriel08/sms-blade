<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-1 leading-tight">
            {{ __('COURSES') }}
        </h2>
    </x-slot>

    <div class="bg-white rounded-lg shadow-sm min-h-screen mx-auto sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-between items-center gap-2">
                <!-- Search Input on the left -->
                <div class="flex-1 max-w-md">
                    <form method="GET" action="#" class="flex gap-2">
                        <x-text-input 
                            name="search"
                            type="text"
                            class="w-full"
                            placeholder="Search courses..."
                            value="{{ request('search') }}"
                        />
                        <x-primary-button type="submit">
                            <x-hugeicons-search-01 />
                        </x-primary-button>
                        @if(request('search'))
                            <a href="#" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-150 ease-in-out">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Filter and Add Button -->
                <div class="flex items-center gap-2">
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center justify-between w-full px-5 py-3 text-sm rounded-md text-gray-700 hover:bg-gray-100 focus:outline-hidden transition ease-in-out duration-150 border border-gray-300 bg-white">
                                Filter by Grade
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link href="#" class="flex items-center gap-2">
                                All Grades
                            </x-dropdown-link>
                            <x-dropdown-link href="#" class="flex items-center gap-2">
                                Grade 7
                            </x-dropdown-link>
                            <x-dropdown-link href="#" class="flex items-center gap-2">
                                Grade 8
                            </x-dropdown-link>
                            <x-dropdown-link href="#" class="flex items-center gap-2">
                                Grade 9
                            </x-dropdown-link>
                            <x-dropdown-link href="#" class="flex items-center gap-2">
                                Grade 10
                            </x-dropdown-link>
                            <x-dropdown-link href="#" class="flex items-center gap-2">
                                Grade 11
                            </x-dropdown-link>
                            <x-dropdown-link href="#" class="flex items-center gap-2">
                                Grade 12
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                    
                    <x-tooltip text="Add New Course" position="bottom">
                        <x-primary-button 
                            class="gap-2 px-5" 
                            x-data="{}" 
                            @click="$dispatch('open-modal', 'add-course')"
                        >
                            <x-hugeicons-add-01 />
                            {{ __('Add Course') }}
                        </x-primary-button>
                    </x-tooltip>
                </div>
            </div>

            <!-- Course Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Course Card 1 -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition duration-150">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">
                                    Grade 7
                                </span>
                            </div>
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="text-gray-500 hover:text-gray-700">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link href="#">
                                        View Details
                                    </x-dropdown-link>
                                    <x-dropdown-link href="#">
                                        Edit
                                    </x-dropdown-link>
                                    <x-dropdown-link href="#" class="text-red-600">
                                        Delete
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Mathematics 7</h3>
                        <p class="text-sm text-gray-600 mb-4">MATH-7</p>
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <span>3 Units</span>
                            <span>•</span>
                            <span>Full Year</span>
                        </div>
                    </div>
                </div>

                <!-- Course Card 2 -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition duration-150">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">
                                    Grade 7
                                </span>
                            </div>
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="text-gray-500 hover:text-gray-700">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link href="#">
                                        View Details
                                    </x-dropdown-link>
                                    <x-dropdown-link href="#">
                                        Edit
                                    </x-dropdown-link>
                                    <x-dropdown-link href="#" class="text-red-600">
                                        Delete
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Science 7</h3>
                        <p class="text-sm text-gray-600 mb-4">SCI-7</p>
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <span>3 Units</span>
                            <span>•</span>
                            <span>Full Year</span>
                        </div>
                    </div>
                </div>

                <!-- Course Card 3 -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition duration-150">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">
                                    Grade 7
                                </span>
                            </div>
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="text-gray-500 hover:text-gray-700">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link href="#">
                                        View Details
                                    </x-dropdown-link>
                                    <x-dropdown-link href="#">
                                        Edit
                                    </x-dropdown-link>
                                    <x-dropdown-link href="#" class="text-red-600">
                                        Delete
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">English 7</h3>
                        <p class="text-sm text-gray-600 mb-4">ENG-7</p>
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <span>3 Units</span>
                            <span>•</span>
                            <span>Full Year</span>
                        </div>
                    </div>
                </div>

                <!-- Course Card 4 -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition duration-150">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">
                                    Grade 11
                                </span>
                            </div>
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="text-gray-500 hover:text-gray-700">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link href="#">
                                        View Details
                                    </x-dropdown-link>
                                    <x-dropdown-link href="#">
                                        Edit
                                    </x-dropdown-link>
                                    <x-dropdown-link href="#" class="text-red-600">
                                        Delete
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">English for Academic Purposes</h3>
                        <p class="text-sm text-gray-600 mb-4">ENG-11</p>
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <span>4 Units</span>
                            <span>•</span>
                            <span>1st Semester</span>
                        </div>
                    </div>
                </div>

                <!-- Course Card 5 -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition duration-150">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">
                                    Grade 11
                                </span>
                            </div>
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="text-gray-500 hover:text-gray-700">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link href="#">
                                        View Details
                                    </x-dropdown-link>
                                    <x-dropdown-link href="#">
                                        Edit
                                    </x-dropdown-link>
                                    <x-dropdown-link href="#" class="text-red-600">
                                        Delete
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">General Mathematics</h3>
                        <p class="text-sm text-gray-600 mb-4">MATH-11</p>
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <span>4 Units</span>
                            <span>•</span>
                            <span>1st Semester</span>
                        </div>
                    </div>
                </div>

                <!-- Course Card 6 -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition duration-150">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">
                                    Grade 12
                                </span>
                            </div>
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="text-gray-500 hover:text-gray-700">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link href="#">
                                        View Details
                                    </x-dropdown-link>
                                    <x-dropdown-link href="#">
                                        Edit
                                    </x-dropdown-link>
                                    <x-dropdown-link href="#" class="text-red-600">
                                        Delete
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Practical Research 2</h3>
                        <p class="text-sm text-gray-600 mb-4">RES-12</p>
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <span>4 Units</span>
                            <span>•</span>
                            <span>2nd Semester</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pagination placeholder --}}
            <div class="mt-6">
                {{-- Pagination will go here when backend is ready --}}
            </div>
        </div>
    </div>
</x-app-layout>