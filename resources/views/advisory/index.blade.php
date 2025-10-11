<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-1 leading-tight">
            {{ __('ADVISORY') }}
        </h2>
    </x-slot>

    <div class="bg-white rounded-lg shadow-sm min-h-screen mx-auto sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Advisory Card -->
            <div class="grid grid-cols-1 gap-6 mb-6">
                <div
                    class="bg-gradient-to-r from-blue-50 to-white border border-blue-100 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-blue-800 mb-2">
                                Advisory Class 7A</h3>
                            <p class="text-md font-semibold text-gray-700 mb-1">Teacher: <span
                                    class="text-blue-600">John Doe</span></p>
                            <p class="text-md font-semibold text-gray-700 mb-1">Grade 8 | <span
                                    class="text-green-600">Section Atis</span></p>
                            <p class="text-md text-gray-600 mb-1">Subject: <span class="text-purple-600">Science</span>
                            </p>
                            <p class="text-md text-gray-600">Total Students: <span class="class="
                                    text-yellow-600">25</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4 flex justify-between items-center gap-2">
                <!-- Search Input on the left -->
                <div class="flex-1 max-w-md">
                    <form method="GET" action="#" class="flex gap-2">
                        <x-text-input name="search" type="text" class="w-full" placeholder="Search by students..."
                            value="{{ request('search') }}" />
                        <x-primary-button type="submit">
                            <x-hugeicons-search-01 />
                        </x-primary-button>
                        @if(request('search'))
                            <a href="#"
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
                                <span class="sort-text">Sort By</span>
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content" id="sort-content">
                            <x-dropdown-link href="#" data-sort="name_asc">
                                Name (A-Z)
                            </x-dropdown-link>
                            <x-dropdown-link href="#" data-sort="name_desc">
                                Name (Z-A)
                            </x-dropdown-link>
                            <x-dropdown-link href="#" data-sort="lrn_asc">
                                LRN (Ascending)
                            </x-dropdown-link>
                            <x-dropdown-link href="#" data-sort="lrn_desc">
                                LRN (Descending)
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Students Table -->
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
                        <tr class="bg-white border-b border-gray-200">
                            <td class="px-6 py-4">STU001</td>
                            <td class="px-6 py-4">1234567890</td>
                            <td class="px-6 py-4 font-medium text-gray-900">John Smith</td>
                            <td class="px-6 py-4">Male</td>
                            <td class="px-6 py-4 flex gap-2">
                                <x-tooltip text="View profile" position="top">
                                    <a href="#" class="text-blue-600 hover:text-blue-800">
                                        <x-hugeicons-eye class="w-4 h-4" />
                                    </a>
                                </x-tooltip>
                                <x-tooltip text="Delete student" position="top">
                                    <button class="text-red-600 hover:text-red-800">
                                        <x-heroicon-o-trash class="w-4 h-4" />
                                    </button>
                                </x-tooltip>
                            </td>
                        </tr>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <td class="px-6 py-4">STU002</td>
                            <td class="px-6 py-4">0987654321</td>
                            <td class="px-6 py-4 font-medium text-gray-900">Jane Doe</td>
                            <td class="px-6 py-4">Female</td>
                            <td class="px-6 py-4 flex gap-2">
                                <x-tooltip text="View profile" position="top">
                                    <a href="#" class="text-blue-600 hover:text-blue-800">
                                        <x-hugeicons-eye class="w-4 h-4" />
                                    </a>
                                </x-tooltip>
                                <x-tooltip text="Delete student" position="top">
                                    <button class="text-red-600 hover:text-red-800">
                                        <x-heroicon-o-trash class="w-4 h-4" />
                                    </button>
                                </x-tooltip>
                            </td>
                        </tr>
                        <tr class="bg-white border-b border-gray-200">
                            <td class="px-6 py-4">STU003</td>
                            <td class="px-6 py-4">1122334455</td>
                            <td class="px-6 py-4 font-medium text-gray-900">Mike Johnson</td>
                            <td class="px-6 py-4">Male</td>
                            <td class="px-6 py-4 flex gap-2">
                                <x-tooltip text="View profile" position="top">
                                    <a href="#" class="text-blue-600 hover:text-blue-800">
                                        <x-hugeicons-eye class="w-4 h-4" />
                                    </a>
                                </x-tooltip>
                                <x-tooltip text="Delete student" position="top">
                                    <button class="text-red-600 hover:text-red-800">
                                        <x-heroicon-o-trash class="w-4 h-4" />
                                    </button>
                                </x-tooltip>
                            </td>
                        </tr>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <td class="px-6 py-4">STU004</td>
                            <td class="px-6 py-4">5566778899</td>
                            <td class="px-6 py-4 font-medium text-gray-900">Sarah Wilson</td>
                            <td class="px-6 py-4">Female</td>
                            <td class="px-6 py-4 flex gap-2">
                                <x-tooltip text="View profile" position="top">
                                    <a href="#" class="text-blue-600 hover:text-blue-800">
                                        <x-hugeicons-eye class="w-4 h-4" />
                                    </a>
                                </x-tooltip>
                                <x-tooltip text="Delete student" position="top">
                                    <button class="text-red-600 hover:text-red-800">
                                        <x-heroicon-o-trash class="w-4 h-4" />
                                    </button>
                                </x-tooltip>
                            </td>
                        </tr>
                        <tr class="bg-white border-b border-gray-200">
                            <td class="px-6 py-4">STU005</td>
                            <td class="px-6 py-4">6677889900</td>
                            <td class="px-6 py-4 font-medium text-gray-900">David Brown</td>
                            <td class="px-6 py-4">Male</td>
                            <td class="px-6 py-4 flex gap-2">
                                <x-tooltip text="View profile" position="top">
                                    <a href="#" class="text-blue-600 hover:text-blue-800">
                                        <x-hugeicons-eye class="w-4 h-4" />
                                    </a>
                                </x-tooltip>
                                <x-tooltip text="Delete student" position="top">
                                    <button class="text-red-600 hover:text-red-800">
                                        <x-heroicon-o-trash class="w-4 h-4" />
                                    </button>
                                </x-tooltip>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of <span
                        class="font-medium">25</span> results
                </div>
                <div class="flex gap-1">
                    <button
                        class="px-3 py-1 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Previous</button>
                    <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700">1</button>
                    <button class="px-3 py-1 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">2</button>
                    <button class="px-3 py-1 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">3</button>
                    <button class="px-3 py-1 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">4</button>
                    <button class="px-3 py-1 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">5</button>
                    <button
                        class="px-3 py-1 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Next</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sortButton = document.getElementById('sort-button');
            const sortContent = document.getElementById('sort-content');

            sortContent.addEventListener('click', function (e) {
                if (e.target.tagName === 'A') {
                    e.preventDefault();
                    const text = e.target.textContent.trim();
                    sortButton.querySelector('.sort-text').textContent = text;
                }
            });
        });
    </script>
</x-app-layout>