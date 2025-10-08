<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-1 leading-tight">
            {{ __('STUDENTS') }}
        </h2>
    </x-slot>

    <div class="bg-white rounded-lg shadow-sm min-h-screen mx-auto sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-between items-center gap-2">
                <div class="flex-1 max-w-md">
                    <form method="GET" action="{{ route('students.index') }}" class="flex gap-2">
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
                            <a href="{{ route('students.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-150 ease-in-out">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>

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
                            <x-dropdown-link href="{{ route('students.index', array_merge(request()->query(), ['sort_by' => 'name_asc'])) }}" class="flex items-center gap-2">
                                Name (A-Z)
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('students.index', array_merge(request()->query(), ['sort_by' => 'name_desc'])) }}" class="flex items-center gap-2">
                                Name (Z-A)
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('students.index', array_merge(request()->query(), ['sort_by' => 'lrn_asc'])) }}" class="flex items-center gap-2">
                                LRN (Ascending)
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('students.index', array_merge(request()->query(), ['sort_by' => 'lrn_desc'])) }}" class="flex items-center gap-2">
                                LRN (Descending)
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('students.index', array_merge(request()->query(), ['sort_by' => 'sex_asc'])) }}" class="flex items-center gap-2">
                                Sex (Male First)
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('students.index', array_merge(request()->query(), ['sort_by' => 'sex_desc'])) }}" class="flex items-center gap-2">
                                Sex (Female First)
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('students.index', array_merge(request()->query(), ['sort_by' => 'birthdate_asc'])) }}" class="flex items-center gap-2">
                                Age (Oldest First)
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('students.index', array_merge(request()->query(), ['sort_by' => 'birthdate_desc'])) }}" class="flex items-center gap-2">
                                Age (Youngest First)
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                    
                    <x-tooltip text="Add New Student" position="bottom">
                        <x-primary-button 
                            class="gap-2 px-5" 
                            x-data="{}" 
                            @click="$dispatch('open-modal', 'add-student')"
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
                                Sex
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Birthdate
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Age
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Grade Level
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Section
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
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                123456789012
                            </th>
                            <td class="px-6 py-4">
                                Juan Dela Cruz Jr.
                            </td>
                            <td class="px-6 py-4">
                                Male
                            </td>
                            <td class="px-6 py-4">
                                May 15, 2008
                            </td>
                            <td class="px-6 py-4">
                                15
                            </td>
                            <td class="px-6 py-4">
                                Grade 10
                            </td>
                            <td class="px-6 py-4">
                                Section A
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Active</span>
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="#" class="font-medium text-blue-600 hover:underline">View</a>
                                <a href="#" class="font-medium text-green-600 hover:underline">Edit</a>
                                <button type="button" class="font-medium text-red-600 hover:underline">Delete</button>
                            </td>
                        </tr>
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                123456789013
                            </th>
                            <td class="px-6 py-4">
                                Maria Clara Santos
                            </td>
                            <td class="px-6 py-4">
                                Female
                            </td>
                            <td class="px-6 py-4">
                                Mar 20, 2009
                            </td>
                            <td class="px-6 py-4">
                                14
                            </td>
                            <td class="px-6 py-4">
                                Grade 9
                            </td>
                            <td class="px-6 py-4">
                                Section B
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Active</span>
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="#" class="font-medium text-blue-600 hover:underline">View</a>
                                <a href="#" class="font-medium text-green-600 hover:underline">Edit</a>
                                <button type="button" class="font-medium text-red-600 hover:underline">Delete</button>
                            </td>
                        </tr>
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                123456789014
                            </th>
                            <td class="px-6 py-4">
                                Andres Bonifacio
                            </td>
                            <td class="px-6 py-4">
                                Male
                            </td>
                            <td class="px-6 py-4">
                                Nov 30, 2007
                            </td>
                            <td class="px-6 py-4">
                                16
                            </td>
                            <td class="px-6 py-4">
                                Grade 11
                            </td>
                            <td class="px-6 py-4">
                                Section C
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Inactive</span>
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="#" class="font-medium text-blue-600 hover:underline">View</a>
                                <a href="#" class="font-medium text-green-600 hover:underline">Edit</a>
                                <button type="button" class="font-medium text-red-600 hover:underline">Delete</button>
                            </td>
                        </tr>
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                123456789015
                            </th>
                            <td class="px-6 py-4">
                                Gabriela Silang
                            </td>
                            <td class="px-6 py-4">
                                Female
                            </td>
                            <td class="px-6 py-4">
                                Mar 19, 2008
                            </td>
                            <td class="px-6 py-4">
                                15
                            </td>
                            <td class="px-6 py-4">
                                Grade 10
                            </td>
                            <td class="px-6 py-4">
                                Section A
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Active</span>
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="#" class="font-medium text-blue-600 hover:underline">View</a>
                                <a href="#" class="font-medium text-green-600 hover:underline">Edit</a>
                                <button type="button" class="font-medium text-red-600 hover:underline">Delete</button>
                            </td>
                        </tr>
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                123456789016
                            </th>
                            <td class="px-6 py-4">
                                Jose Rizal
                            </td>
                            <td class="px-6 py-4">
                                Male
                            </td>
                            <td class="px-6 py-4">
                                Jun 19, 2009
                            </td>
                            <td class="px-6 py-4">
                                14
                            </td>
                            <td class="px-6 py-4">
                                Grade 9
                            </td>
                            <td class="px-6 py-4">
                                Section B
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Transferred</span>
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="#" class="font-medium text-blue-600 hover:underline">View</a>
                                <a href="#" class="font-medium text-green-600 hover:underline">Edit</a>
                                <button type="button" class="font-medium text-red-600 hover:underline">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of <span class="font-medium">50</span> results
                </div>
                <div class="flex gap-1">
                    <button class="px-3 py-1 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Previous</button>
                    <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700">1</button>
                    <button class="px-3 py-1 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">2</button>
                    <button class="px-3 py-1 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">3</button>
                    <button class="px-3 py-1 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Next</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>