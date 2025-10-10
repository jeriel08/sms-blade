<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('ACADEMIC RECORD') }}
            </h2>
            <div class="flex gap-2">
                <x-secondary-button onclick="window.print()">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print Record
                </x-secondary-button>
                <a href="{{ route('students.show', $student->lrn) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition duration-150">
                    Back to Profile
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Student Information Card -->
            <div class="bg-white rounded-xl shadow-sm mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Student Information</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500">LRN</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $student->lrn }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Full Name</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900">
                                {{ $student->first_name }} {{ $student->last_name }}
                                {{ $student->middle_name ? ' ' . $student->middle_name : '' }}
                                {{ $student->extension_name ? ' ' . $student->extension_name : '' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Grade & Section</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900">
                                @if($currentEnrollment && $currentEnrollment->grade_level && $currentEnrollment->section)
                                    Grade {{ $currentEnrollment->grade_level }} - {{ $currentEnrollment->section->name }}
                                @else
                                    Not Enrolled
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Status</p>
                            <p class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $currentEnrollment ? ucfirst($currentEnrollment->status) : 'Registered' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Academic Performance Card -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Academic Performance</h3>
                            <p class="text-sm text-gray-600 mt-1">School Year: {{ $currentEnrollment->school_year ?? '2024-2025' }}</p>
                        </div>
                        <div class="p-6">
                            <!-- Empty State Message -->
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <h4 class="mt-4 text-lg font-medium text-gray-900">No Academic Records Yet</h4>
                                <p class="mt-2 text-sm text-gray-600">
                                    Grades and performance data will appear here once teachers start inputting information.
                                </p>
                            </div>

                            <!-- Subjects Table (Structure Ready) -->
                            <div class="mt-6">
                                <h4 class="text-md font-semibold text-gray-900 mb-4">Subject List</h4>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm text-left text-gray-500">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-3">Subject Code</th>
                                                <th class="px-4 py-3">Subject Name</th>
                                                <th class="px-4 py-3">Grade</th>
                                                <th class="px-4 py-3">Teacher</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($sampleSubjects as $subject)
                                                <tr class="bg-white border-b hover:bg-gray-50">
                                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $subject['code'] }}</td>
                                                    <td class="px-4 py-3">{{ $subject['name'] }}</td>
                                                    <td class="px-4 py-3">
                                                        @if($subject['grade'])
                                                            {{ $subject['grade'] }}
                                                        @else
                                                            <span class="text-gray-400">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3">{{ $subject['teacher'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Cards -->
                <div class="space-y-6">
                    <!-- Enrollment History -->
                    <div class="bg-white rounded-xl shadow-sm">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Enrollment History</h3>
                        </div>
                        <div class="p-6">
                            @if($student->enrollments->count() > 0)
                                <div class="space-y-3">
                                    @foreach($student->enrollments->sortByDesc('enrollment_date') as $enrollment)
                                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                            <div>
                                                <p class="font-medium text-gray-900">
                                                    {{ $enrollment->school_year }}
                                                </p>
                                                <p class="text-sm text-gray-600">
                                                    {{ ucfirst($enrollment->enrollment_type) }} • 
                                                    @if($enrollment->grade_level)
                                                        Grade {{ $enrollment->grade_level }}
                                                    @else
                                                        Not Assigned
                                                    @endif
                                                </p>
                                            </div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $enrollment->status === 'Enrolled' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $enrollment->status }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4 text-gray-500">
                                    No enrollment history found.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            .bg-white {
                background: white !important;
            }
            .shadow-sm {
                box-shadow: none !important;
            }
        }
    </style>
</x-app-layout>