<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-1 leading-tight">
            {{ __('Student Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Main Card -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <!-- Header Banner -->
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-8">
                    <div class="flex items-center space-x-4">
                        <div class="bg-white rounded-full p-4 shadow-lg">
                            <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white">{{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}</h3>
                            <p class="text-blue-100 text-sm mt-1">Student Enrollment Record</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <!-- Info Cards Section -->
                    <div class="mb-8">
                        <div class="flex items-center mb-6">
                            <div class="w-1 h-6 bg-blue-600 rounded mr-3"></div>
                            <h4 class="text-lg font-semibold text-gray-800">Personal Information</h4>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Full Name Card -->
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-5 rounded-xl border-blue-200 shadow-sm hover:shadow-md transition-shadow duration-200" style="border-width: 1px;">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <p class="text-xs font-semibold text-blue-600 uppercase tracking-wide mb-2">Full Name</p>
                                        <p class="text-lg font-bold text-gray-900">{{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}</p>
                                    </div>
                                    <div class="bg-blue-200 rounded-lg p-2">
                                        <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- LRN Card -->
                            <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-5 rounded-xl border-purple-200 shadow-sm hover:shadow-md transition-shadow duration-200" style="border-width: 1px;">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <p class="text-xs font-semibold text-purple-600 uppercase tracking-wide mb-2">LRN Number</p>
                                        <p class="text-lg font-bold text-gray-900">{{ $enrollment->student->lrn }}</p>
                                    </div>
                                    <div class="bg-purple-200 rounded-lg p-2">
                                        <svg class="w-5 h-5 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Card -->
                            <div class="bg-gradient-to-br from-green-50 to-green-100 p-5 rounded-xl border-green-200 shadow-sm hover:shadow-md transition-shadow duration-200" style="border-width: 1px;">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <p class="text-xs font-semibold text-green-600 uppercase tracking-wide mb-2">Status</p>
                                        <p class="text-lg font-bold text-gray-900">{{ ucfirst($enrollment->status) }}</p>
                                    </div>
                                    <div class="bg-green-200 rounded-lg p-2">
                                        <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Academic Information Section -->
                    <div class="mb-8">
                        <div class="flex items-center mb-6">
                            <div class="w-1 h-6 bg-indigo-600 rounded mr-3"></div>
                            <h4 class="text-lg font-semibold text-gray-800">Academic Information</h4>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Grade Level Card -->
                            <div class="bg-white p-6 rounded-xl border-gray-200 shadow-sm hover:border-indigo-300 transition-colors duration-200" style="border-width: 2px;">
                                <div class="flex items-center space-x-4">
                                    <div class="bg-indigo-100 rounded-full p-3">
                                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-500 mb-1">Grade Level</p>
                                        <p class="text-xl font-bold text-gray-900">{{ $enrollment->grade_level ?? 'Not Assigned' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Section Card -->
                            <div class="bg-white p-6 rounded-xl border-gray-200 shadow-sm hover:border-indigo-300 transition-colors duration-200" style="border-width: 2px;">
                                <div class="flex items-center space-x-4">
                                    <div class="bg-indigo-100 rounded-full p-3">
                                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-500 mb-1">Section</p>
                                        <p class="text-xl font-bold text-gray-900">{{ $enrollment->section ? $enrollment->section->name : 'Not Assigned' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info Box -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-6 rounded-xl border-gray-200 mb-6" style="border-width: 1px;">
                        <div class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-gray-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <h5 class="font-semibold text-gray-800 mb-1">Enrollment Information</h5>
                                <p class="text-sm text-gray-600 leading-relaxed">This record contains the complete enrollment details for the student. All information displayed is current and reflects the latest updates in the system.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-gray-200" style="border-top-width: 2px;">
                        <div class="text-sm text-gray-500">
                            <p>Last updated: <span class="font-medium text-gray-700">{{ now()->format('M d, Y') }}</span></p>
                        </div>
                        <a href="{{ route('enrollments.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gray-700 text-white text-sm font-semibold rounded-lg hover:bg-gray-800 shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Enrollments
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>