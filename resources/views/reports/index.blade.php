<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('REPORTS') }}
            </h2>
            <div class="text-sm text-gray-600">
                {{ now()->format('l, F j, Y') }}
            </div>
        </div>
    </x-slot>

    {{-- Success/Error Messages --}}
    @if (session('success'))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Report Filters -->
            <div class="bg-white overflow-visible shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Report Filters</h3>
                        <div class="flex gap-3">
                            <!-- Export Dropdown -->
                            <div class="relative">
                                <button onclick="toggleExportDropdown()"
                                    class="text-sm bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-md flex items-center gap-2 transition duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Export
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div id="exportDropdown"
                                    class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50 border border-gray-200">
                                    <div class="py-1">
                                        <a href="#" onclick="exportReport('excel')"
                                            class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Export to Excel
                                        </a>
                                        <a href="#" onclick="exportReport('pdf')"
                                            class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                            Export to PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form id="filterForm" method="GET" action="{{ route('reports') }}">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">School Year</label>
                                <select name="school_year" id="school_year"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="2025-2026" {{ request('school_year') == '2025-2026' ? 'selected' : '' }}>2025-2026</option>
                                    <option value="2024-2025" {{ request('school_year') == '2024-2025' ? 'selected' : '' }}>2024-2025</option>
                                    <option value="2023-2024" {{ request('school_year') == '2023-2024' ? 'selected' : '' }}>2023-2024</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Grade Level</label>
                                <select name="grade_level" id="grade_level"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="all" {{ request('grade_level') == 'all' ? 'selected' : '' }}>All Grades
                                    </option>
                                    <option value="7" {{ request('grade_level') == '7' ? 'selected' : '' }}>Grade 7
                                    </option>
                                    <option value="8" {{ request('grade_level') == '8' ? 'selected' : '' }}>Grade 8
                                    </option>
                                    <option value="9" {{ request('grade_level') == '9' ? 'selected' : '' }}>Grade 9
                                    </option>
                                    <option value="10" {{ request('grade_level') == '10' ? 'selected' : '' }}>Grade 10
                                    </option>
                                    <option value="11" {{ request('grade_level') == '11' ? 'selected' : '' }}>Grade 11
                                    </option>
                                    <option value="12" {{ request('grade_level') == '12' ? 'selected' : '' }}>Grade 12
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                                <select name="section" id="section"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="all" {{ request('section') == 'all' ? 'selected' : '' }}>All Sections
                                    </option>
                                    @foreach($availableSections ?? [] as $sec)
                                        <option value="{{ $sec->section_id }}" {{ request('section') == $sec->section_id ? 'selected' : '' }}>
                                            {{ $sec->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 shadow-sm">
                                    Apply Filters
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="report_type" id="report_type"
                            value="{{ $reportType ?? 'enrollment' }}">
                    </form>
                </div>
            </div>

            <!-- Report Type Tabs and Quick Stats -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
                <!-- Report Type Buttons -->
                <div class="lg:col-span-3 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex flex-wrap gap-3">
                            <button type="button" onclick="switchReport('enrollment')" id="btn-enrollment"
                                class="report-tab-btn {{ ($reportType ?? 'enrollment') == 'enrollment' ? 'active' : '' }} px-6 py-3 rounded-lg font-medium transition duration-200 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Enrollment Report
                            </button>
                            <button type="button" onclick="switchReport('students')" id="btn-students"
                                class="report-tab-btn {{ ($reportType ?? '') == 'students' ? 'active' : '' }} px-6 py-3 rounded-lg font-medium transition duration-200 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Student Report
                            </button>
                            <button type="button" onclick="switchReport('teachers')" id="btn-teachers"
                                class="report-tab-btn {{ ($reportType ?? '') == 'teachers' ? 'active' : '' }} px-6 py-3 rounded-lg font-medium transition duration-200 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Teacher Report
                            </button>
                            <button type="button" onclick="switchReport('sections')" id="btn-sections"
                                class="report-tab-btn {{ ($reportType ?? '') == 'sections' ? 'active' : '' }} px-6 py-3 rounded-lg font-medium transition duration-200 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                Section Report
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Quick Summary Stats -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-sm font-medium opacity-90">Total Records</h3>
                            <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <p class="text-4xl font-bold" id="total-records">{{ number_format($totalRecords ?? 0) }}</p>
                        <p class="text-sm mt-2 opacity-90">Current School Year</p>
                    </div>
                </div>
            </div>

            <!-- Report Tables -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Enrollment Report -->
                    <div id="report-enrollment"
                        class="report-content {{ ($reportType ?? 'enrollment') == 'enrollment' ? '' : 'hidden' }}">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-900">Enrollment Report</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Student Name</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            LRN</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Grade Level</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Section</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Enrollment Type</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($reportData ?? [] as $enrollment)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $enrollment->student->first_name ?? '' }}
                                                        {{ $enrollment->student->last_name ?? '' }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $enrollment->student->lrn ?? '' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                                            @if($enrollment->grade_level == '7') bg-blue-100 text-blue-800
                                                                                            @elseif($enrollment->grade_level == '8') bg-green-100 text-green-800
                                                                                            @elseif($enrollment->grade_level == '9') bg-yellow-100 text-yellow-800
                                                                                            @elseif($enrollment->grade_level == '10') bg-purple-100 text-purple-800
                                                                                            @elseif($enrollment->grade_level == '11') bg-indigo-100 text-indigo-800
                                                                                            @elseif($enrollment->grade_level == '12') bg-pink-100 text-pink-800
                                                                                            @else bg-gray-100 text-gray-800 @endif">
                                                    Grade {{ $enrollment->grade_level }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $enrollment->section->name ?? 'Not Assigned' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $enrollment->enrollment_type }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                                            @if($enrollment->status == 'Enrolled') bg-green-100 text-green-800
                                                                                            @elseif($enrollment->status == 'Registered') bg-yellow-100 text-yellow-800
                                                                                            @else bg-red-100 text-red-800 @endif">
                                                    {{ $enrollment->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $enrollment->enrollment_date->format('M j, Y') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                                No enrollment records found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($reportData instanceof \Illuminate\Pagination\LengthAwarePaginator && $reportData->hasPages())
                            <div class="mt-4">
                                {{ $reportData->links() }}
                            </div>
                        @endif
                    </div>

                    <!-- Student Report -->
                    <div id="report-students"
                        class="report-content {{ ($reportType ?? '') == 'students' ? '' : 'hidden' }}">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-900">Student Report</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Student Name</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            LRN</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Gender</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Birth Date</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Grade & Section</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Contact</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Guardian</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($reportData ?? [] as $student)
                                        @php
                                            $currentEnrollment = $student->enrollments ? $student->enrollments->first() : null;
                                            $familyContacts = $student->familyContacts ?? collect();
                                            $contactNumber = $familyContacts->first()->contact_number ?? 'N/A';
                                            $guardian = $familyContacts->where('contact_type', 'Father')->first();
                                            $guardianName = $guardian ? ($guardian->first_name . ' ' . $guardian->last_name) : 'N/A';
                                        @endphp
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $student->first_name }} {{ $student->last_name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $student->lrn }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $student->sex }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $student->birthdate ? $student->birthdate->format('M j, Y') : 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($currentEnrollment)
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                                                                                        @if($currentEnrollment->grade_level == '7') bg-blue-100 text-blue-800
                                                                                                                                        @elseif($currentEnrollment->grade_level == '8') bg-green-100 text-green-800
                                                                                                                                        @elseif($currentEnrollment->grade_level == '9') bg-yellow-100 text-yellow-800
                                                                                                                                        @elseif($currentEnrollment->grade_level == '10') bg-purple-100 text-purple-800
                                                                                                                                        @elseif($currentEnrollment->grade_level == '11') bg-indigo-100 text-indigo-800
                                                                                                                                        @elseif($currentEnrollment->grade_level == '12') bg-pink-100 text-pink-800
                                                                                                                                        @else bg-gray-100 text-gray-800 @endif">
                                                        Grade {{ $currentEnrollment->grade_level }} -
                                                        {{ optional($currentEnrollment->section)->name ?? 'No Section' }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Not Enrolled
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $contactNumber }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $guardianName }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                                No student records found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($reportData instanceof \Illuminate\Pagination\LengthAwarePaginator && $reportData->hasPages())
                            <div class="mt-4">
                                {{ $reportData->links() }}
                            </div>
                        @endif
                    </div>

                    <!-- Teacher Report -->
                    <div id="report-teachers"
                        class="report-content {{ ($reportType ?? '') == 'teachers' ? '' : 'hidden' }}">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-900">Teacher Report</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Teacher Name</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Employee ID</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Advisory Class</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Contact</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($reportData ?? [] as $teacher)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $teacher->first_name }} {{ $teacher->last_name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                TCHR-{{ $teacher->teacher_id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $teacher->sections && $teacher->sections->isNotEmpty() ? $teacher->sections->first()->name : 'No Advisory' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $teacher->email }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                                No teacher records found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($reportData instanceof \Illuminate\Pagination\LengthAwarePaginator && $reportData->hasPages())
                            <div class="mt-4">
                                {{ $reportData->links() }}
                            </div>
                        @endif
                    </div>

                    <!-- Section Report -->
                    <div id="report-sections"
                        class="report-content {{ ($reportType ?? '') == 'sections' ? '' : 'hidden' }}">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-900">Section Report</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Section Name</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Grade Level</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Adviser</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total Students</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Male</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Female</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Capacity</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($reportData ?? [] as $section)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $section->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                                            @if($section->grade_level == '7') bg-blue-100 text-blue-800
                                                                                            @elseif($section->grade_level == '8') bg-green-100 text-green-800
                                                                                            @elseif($section->grade_level == '9') bg-yellow-100 text-yellow-800
                                                                                            @elseif($section->grade_level == '10') bg-purple-100 text-purple-800
                                                                                            @elseif($section->grade_level == '11') bg-indigo-100 text-indigo-800
                                                                                            @elseif($section->grade_level == '12') bg-pink-100 text-pink-800
                                                                                            @else bg-gray-100 text-gray-800 @endif">
                                                    Grade {{ $section->grade_level }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($section->adviser)
                                                    {{ $section->adviser->first_name }} {{ $section->adviser->last_name }}
                                                @else
                                                    No Adviser
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $section->total_students ?? 0 }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $section->male_count ?? 0 }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $section->female_count ?? 0 }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $section->capacity ?? 45 }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $utilization = $section->utilization_percentage ?? 0;
                                                @endphp
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                                            @if($utilization >= 90) bg-red-100 text-red-800
                                                                                            @elseif($utilization >= 75) bg-yellow-100 text-yellow-800
                                                                                            @else bg-green-100 text-green-800 @endif">
                                                    @if($utilization >= 90) Full
                                                    @elseif($utilization >= 75) {{ $utilization }}% Full
                                                    @else Available
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                                No section records found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($reportData instanceof \Illuminate\Pagination\LengthAwarePaginator && $reportData->hasPages())
                            <div class="mt-4">
                                {{ $reportData->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .report-tab-btn {
            background-color: #f3f4f6;
            color: #6b7280;
        }

        .report-tab-btn:hover {
            background-color: #e5e7eb;
            color: #374151;
        }

        .report-tab-btn.active {
            background-color: #2563eb;
            color: white;
        }

        .report-content {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script>
        // Toggle functions for dropdowns
        function toggleExportDropdown() {
            const dropdown = document.getElementById('exportDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function (event) {
            const exportDropdown = document.getElementById('exportDropdown');
            const exportButton = event.target.closest('button[onclick*="toggleExportDropdown"]');

            if (!exportButton && exportDropdown && !exportDropdown.contains(event.target)) {
                exportDropdown.classList.add('hidden');
            }
        });

        // Switch report type
        function switchReport(reportType) {
            document.getElementById('report_type').value = reportType;
            document.getElementById('filterForm').submit();
        }

        // Export functionality
        function exportReport(format) {
            const schoolYear = document.getElementById('school_year').value;
            const gradeLevel = document.getElementById('grade_level').value;
            const section = document.getElementById('section').value;
            const reportType = document.getElementById('report_type').value;

            // Build URL with parameters
            const params = new URLSearchParams({
                school_year: schoolYear,
                grade_level: gradeLevel,
                section: section,
                report_type: reportType,
                format: format
            });

            // Redirect to export route
            window.location.href = '{{ route("reports.export") }}?' + params.toString();

            // Prevent default link behavior
            return false;
        }

        // Dynamic section loading based on grade level
        document.getElementById('grade_level').addEventListener('change', function () {
            const gradeLevel = this.value;
            const sectionSelect = document.getElementById('section');

            if (gradeLevel === 'all') {
                // Reset to all sections
                sectionSelect.innerHTML = '<option value="all">All Sections</option>';
                return;
            }

            // Fetch sections for the selected grade level
            fetch(`{{ route('reports.sections-by-grade') }}?grade_level=${gradeLevel}`)
                .then(response => response.json())
                .then(sections => {
                    sectionSelect.innerHTML = '<option value="all">All Sections</option>';
                    sections.forEach(section => {
                        const option = document.createElement('option');
                        option.value = section.section_id;
                        option.textContent = section.name;
                        sectionSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching sections:', error);
                });
        });
    </script>
</x-app-layout>