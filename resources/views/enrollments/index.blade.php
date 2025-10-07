<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-1 leading-tight">
            {{ __('ENROLLMENT') }}
        </h2>
    </x-slot>

    <div class="bg-white rounded-lg shadow-sm min-h-screen mx-auto sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-between items-center gap-2">
                <!-- Search Input on the left -->
                <div class="flex-1 max-w-md">
                    <form method="GET" action="{{ route('enrollments.index') }}" class="flex gap-2">
                        <x-text-input 
                            name="search"
                            type="text"
                            class="w-full"
                            placeholder="Search by name or LRN..."
                            value="{{ request('search') }}"
                        />
                        <x-primary-button type="submit">
                            <x-hugeicons-search-01 />
                        </x-primary-button>
                        @if(request('search'))
                            <a href="{{ route('enrollments.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-150 ease-in-out">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Filter Dropdown and Buttons on the right -->
                <div class="flex items-center gap-2">
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center justify-between w-full px-5 py-3 text-sm rounded-md text-gray-700 hover:bg-gray-100 focus:outline-hidden transition ease-in-out duration-150 border border-gray-300 bg-white">
                                Sort By
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('enrollments.index', array_merge(request()->query(), ['sort_by' => 'name_asc'])) }}" class="flex items-center gap-2">
                                Name (A-Z)
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('enrollments.index', array_merge(request()->query(), ['sort_by' => 'name_desc'])) }}" class="flex items-center gap-2">
                                Name (Z-A)
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('enrollments.index', array_merge(request()->query(), ['sort_by' => 'lrn_asc'])) }}" class="flex items-center gap-2">
                                LRN (Ascending)
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('enrollments.index', array_merge(request()->query(), ['sort_by' => 'lrn_desc'])) }}" class="flex items-center gap-2">
                                LRN (Descending)
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('enrollments.index', array_merge(request()->query(), ['sort_by' => 'grade_asc'])) }}" class="flex items-center gap-2">
                                Grade Level (Ascending)
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('enrollments.index', array_merge(request()->query(), ['sort_by' => 'grade_desc'])) }}" class="flex items-center gap-2">
                                Grade Level (Descending)
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('enrollments.index', array_merge(request()->query(), ['sort_by' => 'status_asc'])) }}" class="flex items-center gap-2">
                                Status (Ascending)
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('enrollments.index', array_merge(request()->query(), ['sort_by' => 'status_desc'])) }}" class="flex items-center gap-2">
                                Status (Descending)
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    {{-- Settings button with tooltip --}}
                    @if($canAccessSettings)
                        <x-tooltip text="Enrollment Setup" position="bottom">
                            <a href="{{ route('enrollments.settings') }}" class="ms-3 px-7 gap-2 inline-flex items-center">
                                <x-secondary-button class="gap-2">
                                    <x-hugeicons-settings-01 />
                                </x-secondary-button>
                            </a>
                        </x-tooltip>
                    @endif
                    
                    {{-- In the buttons section --}}
                    <x-tooltip text="Register a Student" position="bottom">
                        <x-primary-button 
                            class="gap-2 px-5" 
                            x-data="{}" 
                            @click="$dispatch('open-modal', 'select-student-type')"
                        >
                            <x-hugeicons-add-01 />
                            {{ __('Add Student') }}
                        </x-primary-button>
                    </x-tooltip>
                </div>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg border">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                LRN
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Grade Level
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($enrollments as $enrollment)
                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $enrollment->student->lrn }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $enrollment->grade_level }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $enrollment->status }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('enrollments.index', $enrollment) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center">
                                    @if(request('search'))
                                        No enrollments found for your search criteria.
                                    @else
                                        No enrollments found.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $enrollments->appends(request()->query())->links() }}
        </div>
    </div>

    @include('enrollments.modals.student-classification') {{-- Keep other modals if needed --}}
</x-app-layout>