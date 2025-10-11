<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-1 leading-tight">
            {{ __('ADVISORY') }}
        </h2>
    </x-slot>

    <div class="bg-white rounded-lg shadow-sm min-h-screen mx-auto sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 border border-green-200 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 px-4 py-3 rounded-lg bg-red-50 border border-red-200 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            @if($advisorySection)
                <!-- Advisory Card -->
                <div class="grid grid-cols-1 gap-6 mb-6">
                    <div class="bg-gradient-to-r from-blue-50 to-white border border-blue-100 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                        <div class="mb-4">
                            <div>
                                <h3 class="text-2xl font-bold text-blue-800 mb-2">
                                    Advisory Class - Grade {{ $advisorySection->grade_level }}
                                </h3>
                                <p class="text-md font-semibold text-gray-700 mb-1">
                                    Teacher: <span class="text-blue-600">{{ Auth::user()->name }}</span>
                                </p>
                                <p class="text-md font-semibold text-gray-700 mb-1">
                                    Grade {{ $advisorySection->grade_level }} | 
                                    <span class="text-green-600">Section {{ $advisorySection->name }}</span>
                                </p>
                                <p class="text-md text-gray-600">
                                    Total Students: <span class="text-yellow-600 font-bold">{{ $totalStudents ?? 0 }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4 flex justify-between items-center gap-2">
                    <!-- Search Input on the left -->
                    <div class="flex-1 max-w-md">
                        <form method="GET" action="{{ route('advisory.index') }}" class="flex gap-2">
                            <x-text-input name="search" type="text" class="w-full" placeholder="Search by students..."
                                value="{{ request('search') }}" />
                            <x-primary-button type="submit">
                                <x-hugeicons-search-01 />
                            </x-primary-button>
                            @if(request('search'))
                                <a href="{{ route('advisory.index') }}"
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-150 ease-in-out">
                                    Clear
                                </a>
                            @endif
                        </form>
                    </div>

                    <!-- Sort Dropdown -->
                    <div class="flex items-center gap-2">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button id="sort-button"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                    </svg>
                                    <span class="sort-text">
                                        @switch($currentSort)
                                            @case('name_desc') Name (Z-A) @break
                                            @case('lrn_asc') LRN (Ascending) @break
                                            @case('lrn_desc') LRN (Descending) @break
                                            @case('gender_asc') Gender (A-Z) @break
                                            @case('gender_desc') Gender (Z-A) @break
                                            @default Name (A-Z)
                                        @endswitch
                                    </span>
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content" id="sort-content">
                                <x-dropdown-link href="{{ route('advisory.index', array_merge(request()->query(), ['sort_by' => 'name_asc'])) }}">
                                    Name (A-Z)
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('advisory.index', array_merge(request()->query(), ['sort_by' => 'name_desc'])) }}">
                                    Name (Z-A)
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('advisory.index', array_merge(request()->query(), ['sort_by' => 'lrn_asc'])) }}">
                                    LRN (Ascending)
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('advisory.index', array_merge(request()->query(), ['sort_by' => 'lrn_desc'])) }}">
                                    LRN (Descending)
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('advisory.index', array_merge(request()->query(), ['sort_by' => 'gender_asc'])) }}">
                                    Gender (A-Z)
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('advisory.index', array_merge(request()->query(), ['sort_by' => 'gender_desc'])) }}">
                                    Gender (Z-A)
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>

                <!-- Students Table -->
                @if($students->count() > 0)
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg border mb-6">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Student ID</th>
                                    <th scope="col" class="px-6 py-3">LRN</th>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">Gender</th>
                                    <th scope="col" class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                    <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} border-b border-gray-200 hover:bg-gray-100 transition">
                                        <td class="px-6 py-4">{{ $student->student_id }}</td>
                                        <td class="px-6 py-4">{{ $student->lrn }}</td>
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            {{ $student->first_name }} 
                                            {{ $student->middle_name ? $student->middle_name . ' ' : '' }}
                                            {{ $student->last_name }}
                                            {{ $student->extension_name ?? '' }}
                                        </td>
                                        <td class="px-6 py-4 capitalize">{{ $student->sex }}</td>
                                        <td class="px-6 py-4 flex gap-2">
                                            <x-tooltip text="View profile" position="top">
                                                <a href="{{ route('students.show', $student->lrn) }}" 
                                                   class="text-blue-600 hover:text-blue-800">
                                                    <x-hugeicons-eye class="w-4 h-4" />
                                                </a>
                                            </x-tooltip>
                                            <x-tooltip text="Remove from section" position="top">
                                                <form method="POST" 
                                                      action="{{ route('advisory.remove-student', $student->lrn) }}"
                                                      onsubmit="return confirm('Are you sure you want to remove this student from your advisory section?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                                        <x-heroicon-o-trash class="w-4 h-4" />
                                                    </button>
                                                </form>
                                            </x-tooltip>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4 flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Showing <span class="font-medium">{{ $students->firstItem() ?? 0 }}</span> 
                            to <span class="font-medium">{{ $students->lastItem() ?? 0 }}</span> 
                            of <span class="font-medium">{{ $students->total() }}</span> results
                        </div>
                        <div>
                            {{ $students->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No students found</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            @if(request('search'))
                                No students match your search criteria.
                            @else
                                There are no students enrolled in this advisory section yet.
                            @endif
                        </p>
                    </div>
                @endif
            @else
                <!-- No Advisory Section Assigned -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No Advisory Section Assigned</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        You are not currently assigned as an adviser to any section.<br>
                        Please contact the school administrator to assign you to a section.
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>