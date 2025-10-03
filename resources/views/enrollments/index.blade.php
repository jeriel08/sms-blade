<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-1 leading-tight">
            {{ __('ENROLLMENT') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-end gap-2">
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
                        <x-dropdown-link href="#" class="flex items-center gap-2">
                            Name (A-Z)
                        </x-dropdown-link>
                        <x-dropdown-link href="#" class="flex items-center gap-2">
                            Name (Z-A)
                        </x-dropdown-link>
                        <x-dropdown-link href="#" class="flex items-center gap-2">
                            LRN (Ascending)
                        </x-dropdown-link>
                        <x-dropdown-link href="#" class="flex items-center gap-2">
                            LRN (Descending)
                        </x-dropdown-link>
                        <x-dropdown-link href="#" class="flex items-center gap-2">
                            Grade Level
                        </x-dropdown-link>
                        <x-dropdown-link href="#" class="flex items-center gap-2">
                            Status
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>

                <x-primary-button class="ms-3 px-7 gap-2">
                    <x-hugeicons-add-01 />
                    {{ __('Add Student') }}
                </x-primary-button>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg border border-7">
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
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                               129558130011
                            </th>
                            <td class="px-6 py-4">
                                Kristine Paula Coretico
                            </td>
                            <td class="px-6 py-4">
                                12
                            </td>
                            <td class="px-6 py-4">
                                Enrolled
                            </td>
                            <td class="px-6 py-4">
                                <a href="#" class="font-medium text-blue-600 hover:underline">Edit</a>
                            </td>
                        </tr>
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                129558130012
                            </th>
                            <td class="px-6 py-4">
                                Russel Labiaga
                            </td>
                            <td class="px-6 py-4">
                                11
                            </td>
                            <td class="px-6 py-4">
                                Enrolled
                            </td>
                            <td class="px-6 py-4">
                                <a href="#" class="font-medium text-blue-600 hover:underline">Edit</a>
                            </td>
                        </tr>
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                129558130013
                            </th>
                            <td class="px-6 py-4">
                                Jeriel Lian Sanao
                            </td>
                            <td class="px-6 py-4">
                                10
                            </td>
                            <td class="px-6 py-4">
                                Pending
                            </td>
                            <td class="px-6 py-4">
                                <a href="#" class="font-medium text-blue-600 hover:underline">Edit</a>
                            </td>
                        </tr>
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                129558130014
                            </th>
                            <td class="px-6 py-4">
                                Kevin Macuno
                            </td>
                            <td class="px-6 py-4">
                                9
                            </td>
                            <td class="px-6 py-4">
                                Enrolled
                            </td>
                            <td class="px-6 py-4">
                                <a href="#" class="font-medium text-blue-600 hover:underline">Edit</a>
                            </td>
                        </tr>
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                129558130015
                            </th>
                            <td class="px-6 py-4">
                                Glaiza Incio
                            </td>
                            <td class="px-6 py-4">
                                8
                            </td>
                            <td class="px-6 py-4">
                                Enrolled
                            </td>
                            <td class="px-6 py-4">
                                <a href="#" class="font-medium text-blue-600 hover:underline">Edit</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>