<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-1 leading-tight">
            {{ __('ASSESSMENTS') }}
        </h2>
    </x-slot>

    <div class="bg-white rounded-lg shadow-sm min-h-screen mx-auto sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-between items-center gap-2">
                <div class="flex-1 max-w-md">
                    <div class="flex gap-2">
                        <input 
                            type="text"
                            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            placeholder="Search by student name or assessment..."
                        />
                        <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                        <a href="#" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-150 ease-in-out">
                            Clear
                        </a>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <div class="relative">
                        <button class="flex items-center justify-between w-full px-5 py-3 text-sm rounded-md text-gray-700 hover:bg-gray-100 focus:outline-hidden transition ease-in-out duration-150 border border-gray-300 bg-white">
                            Filter
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <button class="flex items-center gap-2 px-5 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Create Assessment
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-blue-800">Total Assessments</h3>
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold text-blue-900 mt-2">24</p>
                    <p class="text-sm text-blue-700 mt-1">This school year</p>
                </div>
                
                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-green-800">Average Score</h3>
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold text-green-900 mt-2">85.6%</p>
                    <p class="text-sm text-green-700 mt-1">Overall performance</p>
                </div>
                
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-purple-800">Pending Grading</h3>
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold text-purple-900 mt-2">3</p>
                    <p class="text-sm text-purple-700 mt-1">Need evaluation</p>
                </div>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg border">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Assessment Title
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Type
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Subject
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Date Given
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Total Items
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Average Score
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
                            <td class="px-6 py-4 font-medium text-gray-900">
                                1st Quarter Exam - Mathematics
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Quarterly</span>
                            </td>
                            <td class="px-6 py-4">
                                Mathematics
                            </td>
                            <td class="px-6 py-4">
                                Oct 15, 2024
                            </td>
                            <td class="px-6 py-4">
                                50
                            </td>
                            <td class="px-6 py-4">
                                82.5%
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Graded</span>
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="#" class="font-medium text-blue-600 hover:underline">View</a>
                                <a href="#" class="font-medium text-green-600 hover:underline">Edit</a>
                                <button type="button" class="font-medium text-red-600 hover:underline">Delete</button>
                            </td>
                        </tr>
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                Science Project - Solar System
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Project</span>
                            </td>
                            <td class="px-6 py-4">
                                Science
                            </td>
                            <td class="px-6 py-4">
                                Nov 5, 2024
                            </td>
                            <td class="px-6 py-4">
                                1
                            </td>
                            <td class="px-6 py-4">
                                -
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Pending</span>
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="#" class="font-medium text-blue-600 hover:underline">View</a>
                                <a href="#" class="font-medium text-green-600 hover:underline">Edit</a>
                                <button type="button" class="font-medium text-red-600 hover:underline">Delete</button>
                            </td>
                        </tr>
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                Weekly Quiz - English Grammar
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Weekly</span>
                            </td>
                            <td class="px-6 py-4">
                                English
                            </td>
                            <td class="px-6 py-4">
                                Nov 12, 2024
                            </td>
                            <td class="px-6 py-4">
                                25
                            </td>
                            <td class="px-6 py-4">
                                88.2%
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Graded</span>
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="#" class="font-medium text-blue-600 hover:underline">View</a>
                                <a href="#" class="font-medium text-green-600 hover:underline">Edit</a>
                                <button type="button" class="font-medium text-red-600 hover:underline">Delete</button>
                            </td>
                        </tr>
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                Monthly Test - Filipino
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-orange-100 text-orange-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Monthly</span>
                            </td>
                            <td class="px-6 py-4">
                                Filipino
                            </td>
                            <td class="px-6 py-4">
                                Nov 8, 2024
                            </td>
                            <td class="px-6 py-4">
                                40
                            </td>
                            <td class="px-6 py-4">
                                79.8%
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Graded</span>
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="#" class="font-medium text-blue-600 hover:underline">View</a>
                                <a href="#" class="font-medium text-green-600 hover:underline">Edit</a>
                                <button type="button" class="font-medium text-red-600 hover:underline">Delete</button>
                            </td>
                        </tr>
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                Research Paper - History
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Project</span>
                            </td>
                            <td class="px-6 py-4">
                                History
                            </td>
                            <td class="px-6 py-4">
                                Nov 20, 2024
                            </td>
                            <td class="px-6 py-4">
                                1
                            </td>
                            <td class="px-6 py-4">
                                -
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Pending</span>
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
                    Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of <span class="font-medium">24</span> results
                </div>
                <div class="flex gap-1">
                    <button class="px-3 py-1 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Previous</button>
                    <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700">1</button>
                    <button class="px-3 py-1 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">2</button>
                    <button class="px-3 py-1 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">3</button>
                    <button class="px-3 py-1 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">4</button>
                    <button class="px-3 py-1 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">5</button>
                    <button class="px-3 py-1 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Next</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>