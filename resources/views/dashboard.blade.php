<x-app-layout>
    @section('title', 'Dashboard | MBNHS-SMS')
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-1 leading-tight">
                {{ __('DASHBOARD') }}
            </h2>
            <div class="text-sm text-gray-600">
                {{ now()->format('l, F j, Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg p-6 mb-8 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h3>
                        <p class="text-blue-100">Here's what's happening with your school today.</p>
                    </div>
                    <div class="hidden md:block">
                        <svg class="w-24 h-24 text-blue-400 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Students -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-blue-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-green-600 bg-green-100 px-2 py-1 rounded">+12%</span>
                        </div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Students</p>
                        <p class="text-3xl font-bold text-gray-900">1,247</p>
                        <p class="text-xs text-gray-500 mt-2">+145 from last year</p>
                    </div>
                </div>

                <!-- Total Teachers -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-green-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-2 py-1 rounded">+3</span>
                        </div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Teachers</p>
                        <p class="text-3xl font-bold text-gray-900">48</p>
                        <p class="text-xs text-gray-500 mt-2">3 new this semester</p>
                    </div>
                </div>

                <!-- Active Classes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-purple-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-purple-600 bg-purple-100 px-2 py-1 rounded">Active</span>
                        </div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Active Classes</p>
                        <p class="text-3xl font-bold text-gray-900">32</p>
                        <p class="text-xs text-gray-500 mt-2">Across all grades</p>
                    </div>
                </div>

                <!-- Pending Enrollments -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-orange-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-orange-600 bg-orange-100 px-2 py-1 rounded">Pending</span>
                        </div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Pending Enrollments</p>
                        <p class="text-3xl font-bold text-gray-900">24</p>
                        <p class="text-xs text-gray-500 mt-2">Awaiting assignment</p>
                    </div>
                </div>
            </div>

            <!-- Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Recent Activities -->
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-gray-900">Recent Activities</h3>
                            <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View All</a>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-start gap-4 pb-4 border-b border-gray-100">
                                <div class="bg-blue-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">New student enrolled</p>
                                    <p class="text-xs text-gray-500">John Doe has been enrolled in Grade 7 - Section A</p>
                                    <p class="text-xs text-gray-400 mt-1">2 hours ago</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 pb-4 border-b border-gray-100">
                                <div class="bg-green-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Assessment completed</p>
                                    <p class="text-xs text-gray-500">Grade 8 Mathematics Quiz has been graded</p>
                                    <p class="text-xs text-gray-400 mt-1">5 hours ago</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 pb-4 border-b border-gray-100">
                                <div class="bg-purple-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">New course added</p>
                                    <p class="text-xs text-gray-500">Advanced Mathematics has been added to curriculum</p>
                                    <p class="text-xs text-gray-400 mt-1">1 day ago</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="bg-orange-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Reminder</p>
                                    <p class="text-xs text-gray-500">Parent-Teacher Conference scheduled tomorrow</p>
                                    <p class="text-xs text-gray-400 mt-1">2 days ago</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6">Quick Actions</h3>
                        <div class="space-y-3">
                            <a href="{{ route('enrollments.create') }}" class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-colors duration-200">
                                <div class="bg-blue-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">New Enrollment</p>
                                    <p class="text-xs text-gray-500">Add new student</p>
                                </div>
                            </a>

                            <a href="{{ route('students.index') }}" class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:border-green-300 hover:bg-green-50 transition-colors duration-200">
                                <div class="bg-green-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">View Students</p>
                                    <p class="text-xs text-gray-500">Manage students</p>
                                </div>
                            </a>

                            <a href="{{ route('enrollments.index') }}" class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition-colors duration-200">
                                <div class="bg-purple-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Enrollments</p>
                                    <p class="text-xs text-gray-500">Process enrollments</p>
                                </div>
                            </a>

                            <a href="{{ route('reports') }}" class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:border-orange-300 hover:bg-orange-50 transition-colors duration-200">
                                <div class="bg-orange-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Reports</p>
                                    <p class="text-xs text-gray-500">Generate reports</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grade Level Distribution -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Student Distribution by Grade Level</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                        <div class="text-center p-4 rounded-lg bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200">
                            <p class="text-2xl font-bold text-blue-600">Grade 7</p>
                            <p class="text-3xl font-extrabold text-blue-800 mt-2">215</p>
                            <p class="text-xs text-blue-600 mt-1">Students</p>
                        </div>
                        <div class="text-center p-4 rounded-lg bg-gradient-to-br from-green-50 to-green-100 border border-green-200">
                            <p class="text-2xl font-bold text-green-600">Grade 8</p>
                            <p class="text-3xl font-extrabold text-green-800 mt-2">198</p>
                            <p class="text-xs text-green-600 mt-1">Students</p>
                        </div>
                        <div class="text-center p-4 rounded-lg bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200">
                            <p class="text-2xl font-bold text-purple-600">Grade 9</p>
                            <p class="text-3xl font-extrabold text-purple-800 mt-2">210</p>
                            <p class="text-xs text-purple-600 mt-1">Students</p>
                        </div>
                        <div class="text-center p-4 rounded-lg bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-200">
                            <p class="text-2xl font-bold text-orange-600">Grade 10</p>
                            <p class="text-3xl font-extrabold text-orange-800 mt-2">205</p>
                            <p class="text-xs text-orange-600 mt-1">Students</p>
                        </div>
                        <div class="text-center p-4 rounded-lg bg-gradient-to-br from-pink-50 to-pink-100 border border-pink-200">
                            <p class="text-2xl font-bold text-pink-600">Grade 11</p>
                            <p class="text-3xl font-extrabold text-pink-800 mt-2">218</p>
                            <p class="text-xs text-pink-600 mt-1">Students</p>
                        </div>
                        <div class="text-center p-4 rounded-lg bg-gradient-to-br from-indigo-50 to-indigo-100 border border-indigo-200">
                            <p class="text-2xl font-bold text-indigo-600">Grade 12</p>
                            <p class="text-3xl font-extrabold text-indigo-800 mt-2">201</p>
                            <p class="text-xs text-indigo-600 mt-1">Students</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>