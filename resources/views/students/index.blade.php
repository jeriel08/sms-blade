<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-1 leading-tight">
            {{ __('STUDENTS MANAGEMENT') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Main Content Card -->
            <div class="bg-white rounded-xl shadow-sm">
                <!-- Search and Filter Section -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="flex-1 max-w-md w-full">
                            <form method="GET" action="{{ route('students.index') }}" class="flex gap-2">
                                <div class="relative flex-1">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                    <x-text-input 
                                        name="search"
                                        type="text"
                                        class="w-full pl-10"
                                        placeholder="Search by name, LRN, or grade level..."
                                        value="{{ request('search') }}"
                                    />
                                </div>
                                <x-primary-button type="submit" class="px-6">
                                    Search
                                </x-primary-button>
                                @if(request('search'))
                                    <a href="{{ route('students.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition duration-150">
                                        Clear
                                    </a>
                                @endif
                            </form>
                        </div>

                        <div class="flex items-center gap-3">
                            <!-- Status Filter Dropdown -->
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
                                        </svg>
                                        Filter Status
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link href="{{ route('students.index', array_merge(request()->query(), ['status' => 'all'])) }}">
                                        All Students
                                    </x-dropdown-link>
                                    <x-dropdown-link href="{{ route('students.index', array_merge(request()->query(), ['status' => 'registered'])) }}">
                                        Registered
                                    </x-dropdown-link>
                                    <x-dropdown-link href="{{ route('students.index', array_merge(request()->query(), ['status' => 'enrolled'])) }}">
                                        Enrolled
                                    </x-dropdown-link>
                                    <x-dropdown-link href="{{ route('students.index', array_merge(request()->query(), ['status' => 'inactive'])) }}">
                                        Inactive
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>

                            <!-- Sort Dropdown -->
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
                                        </svg>
                                        Sort By
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link href="{{ route('students.index', array_merge(request()->query(), ['sort_by' => 'name_asc'])) }}">
                                        Name (A-Z)
                                    </x-dropdown-link>
                                    <x-dropdown-link href="{{ route('students.index', array_merge(request()->query(), ['sort_by' => 'name_desc'])) }}">
                                        Name (Z-A)
                                    </x-dropdown-link>
                                    <x-dropdown-link href="{{ route('students.index', array_merge(request()->query(), ['sort_by' => 'lrn_asc'])) }}">
                                        LRN (Ascending)
                                    </x-dropdown-link>
                                    <x-dropdown-link href="{{ route('students.index', array_merge(request()->query(), ['sort_by' => 'lrn_desc'])) }}">
                                        LRN (Descending)
                                    </x-dropdown-link>
                                    <x-dropdown-link href="{{ route('students.index', array_merge(request()->query(), ['sort_by' => 'grade_asc'])) }}">
                                        Grade Level (Low to High)
                                    </x-dropdown-link>
                                    <x-dropdown-link href="{{ route('students.index', array_merge(request()->query(), ['sort_by' => 'grade_desc'])) }}">
                                        Grade Level (High to Low)
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                            
                            <!-- Export Button -->
                            <x-tooltip text="Export to CSV" position="bottom">
                                <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Export
                                </button>
                            </x-tooltip>
                        </div>
                    </div>

                    <!-- Active Filters Display -->
                    <div class="flex flex-wrap gap-2 mt-4">
                        @if(request('status') && request('status') != 'all')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Status: {{ ucfirst(request('status')) }}
                                <a href="{{ route('students.index', array_merge(request()->query(), ['status' => null])) }}" class="ml-1 hover:text-blue-900">
                                    ×
                                </a>
                            </span>
                        @endif
                        @if(request('search'))
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Search: "{{ request('search') }}"
                                <a href="{{ route('students.index', array_merge(request()->query(), ['search' => null])) }}" class="ml-1 hover:text-green-900">
                                    ×
                                </a>
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Table Section -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold">LRN</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Student Name</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Student Type</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Grade Level</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Section</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Date Registered</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Date Enrolled</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($students as $student)
                                @php
                                    $latestEnrollment = $student->enrollments->sortByDesc('created_at')->first();
                                    $studentType = $latestEnrollment ? strtolower($latestEnrollment->enrollment_type) : 'new';
                                    $status = $latestEnrollment ? strtolower($latestEnrollment->status) : 'registered';
                                    $gradeLevel = $latestEnrollment ? $latestEnrollment->grade_level : null;
                                    $section = $latestEnrollment && $latestEnrollment->section ? $latestEnrollment->section->name : null;
                                    $dateEnrolled = $latestEnrollment ? $latestEnrollment->enrollment_date : null;
                                @endphp
                                
                                <tr class="bg-white hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $student->lrn }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $student->first_name }} {{ $student->last_name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-medium min-w-[85px] 
                                            {{ $studentType === 'new' ? 'bg-purple-100 text-purple-800' : 
                                               ($studentType === 'transferee' ? 'bg-orange-100 text-orange-800' : 
                                               ($studentType === 'returning' ? 'bg-pink-100 text-pink-800' : 'bg-green-100 text-green-800')) }}">
                                            {{ ucfirst($studentType) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 {{ $gradeLevel ? '' : 'text-gray-500' }}">
                                        {{ $gradeLevel ? 'Grade ' . $gradeLevel : '-' }}
                                    </td>
                                    <td class="px-6 py-4 {{ $section ? '' : 'text-gray-500' }}">
                                        {{ $section ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
    <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-medium w-24 
        {{ $status === 'enrolled' ? 'bg-green-100 text-green-800' : 
           ($status === 'registered' ? 'bg-yellow-100 text-yellow-800' : 
           ($status === 'inactive' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
        <span class="w-2 h-2 mr-1.5 rounded-full 
            {{ $status === 'enrolled' ? 'bg-green-600' : 
               ($status === 'registered' ? 'bg-yellow-600' : 
               ($status === 'inactive' ? 'bg-red-600' : 'bg-gray-600')) }}"></span>
        {{ ucfirst($status) }}
    </span>
</td>
                                    <td class="px-6 py-4 text-sm">{{ $student->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 text-sm {{ $dateEnrolled ? '' : 'text-gray-500' }}">
                                        {{ $dateEnrolled ? \Carbon\Carbon::parse($dateEnrolled)->format('M d, Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            @if($status === 'registered')
                                                <x-tooltip text="Enroll Student" position="top">
                                                    <button class="text-green-600 hover:text-green-800 transition duration-150" 
                                                            x-data="{}" 
                                                            @click="
                                                                $dispatch('open-modal', 'enroll-student');
                                                                document.getElementById('enroll_student_lrn').value = '{{ $student->lrn }}';
                                                                document.getElementById('enroll_student_name').textContent = '{{ $student->first_name }} {{ $student->last_name }} ({{ $student->lrn }})';
                                                            ">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                    </button>
                                                </x-tooltip>
                                                <x-tooltip text="View Details" position="top">
                                                    <a href="{{ route('students.show', $student->lrn) }}" class="text-blue-600 hover:text-blue-800 transition duration-150">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                        </svg>
                                                    </a>
                                                </x-tooltip>
                                            @else
                                                <x-tooltip text="View Profile" position="top">
                                                    <a href="{{ route('students.show', $student->lrn) }}" class="text-blue-600 hover:text-blue-800 transition duration-150">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                        </svg>
                                                    </a>
                                                </x-tooltip>
                                                <x-tooltip text="Academic Record" position="top">
                                                    <a href="{{ route('students.academic-record', $student->lrn) }}" class="text-indigo-600 hover:text-indigo-800 transition duration-150">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                                        </svg>
                                                    </a>
                                                </x-tooltip>
                                            @endif
                                            <x-tooltip text="Edit Student" position="top">
                                                <a href="{{ route('students.edit', $student->lrn) }}" class="text-gray-600 hover:text-gray-800 transition duration-150">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>
                                            </x-tooltip>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-4 text-center text-gray-500">
                                        No students found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-sm text-gray-700">
                            Showing <span class="font-medium text-gray-900">{{ $students->firstItem() }}</span> to 
                            <span class="font-medium text-gray-900">{{ $students->lastItem() }}</span> of 
                            <span class="font-medium text-gray-900">{{ $students->total() }}</span> students
                        </div>
                        <div class="flex items-center gap-2">
                            {{ $students->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enroll Student Modal -->
    <x-modal name="enroll-student" focusable>
        <form method="POST" action="" id="enrollForm">
            @csrf
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">
                    Enroll Student
                </h2>
                
                <div class="space-y-4">
                    <div>
                        <x-input-label for="student_name" value="Student" />
                        <p id="enroll_student_name" class="mt-1 text-sm text-gray-600"></p>
                        <input type="hidden" name="lrn" id="enroll_student_lrn">
                    </div>

                    <div>
                        <x-input-label for="grade_level" value="Grade Level" />
                        <select id="grade_level" name="grade_level" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">Select Grade Level</option>
                            <option value="7">Grade 7</option>
                            <option value="8">Grade 8</option>
                            <option value="9">Grade 9</option>
                            <option value="10">Grade 10</option>
                            <option value="11">Grade 11</option>
                            <option value="12">Grade 12</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label for="section_id" value="Section" />
                        <select id="section_id" name="section_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">Select Section</option>
                            @foreach($sections as $grade => $gradeSections)
                                <optgroup label="Grade {{ $grade }}" class="grade-sections grade-{{ $grade }}" style="display: none;">
                                    @foreach($gradeSections as $section)
                                        <option value="{{ $section->section_id }}">{{ $section->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="school_year" value="School Year" />
                        <x-text-input id="school_year" type="text" class="mt-1 block w-full" value="2024-2025" readonly />
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <x-secondary-button type="button" @click="$dispatch('close')">
                        Cancel
                    </x-secondary-button>
                    <x-primary-button type="submit">
                        Enroll Student
                    </x-primary-button>
                </div>
            </div>
        </form>
    </x-modal>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const gradeSelect = document.getElementById('grade_level');
            const sectionSelect = document.getElementById('section_id');
            const enrollForm = document.getElementById('enrollForm');

            // Update form action when modal opens
            document.addEventListener('open-modal', function(event) {
                if (event.detail === 'enroll-student') {
                    const lrn = document.getElementById('enroll_student_lrn').value;
                    enrollForm.action = `/students/${lrn}/enroll`;
                }
            });

            // Show/hide sections based on grade level selection
            gradeSelect.addEventListener('change', function() {
                const selectedGrade = this.value;
                
                // Hide all section groups
                document.querySelectorAll('.grade-sections').forEach(group => {
                    group.style.display = 'none';
                });
                
                // Show sections for selected grade
                if (selectedGrade) {
                    const targetGroup = document.querySelector('.grade-' + selectedGrade);
                    if (targetGroup) {
                        targetGroup.style.display = 'block';
                    }
                }
                
                // Reset section selection
                sectionSelect.value = '';
            });

            // Update sections when modal opens (in case there's a previously selected grade)
            if (gradeSelect.value) {
                gradeSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
</x-app-layout>