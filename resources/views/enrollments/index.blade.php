<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-1 leading-tight">
            {{ __('ENROLLMENT') }}
        </h2>
    </x-slot>

    <div class="bg-white rounded-lg shadow-sm min-h-screen mx-auto sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-between items-center gap-2">
                <!-- Search Input on the left -->
                <div class="flex-1 max-w-md">
                    <form method="GET" action="{{ route('enrollments.index') }}" class="flex gap-2">
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
                            <a href="{{ route('enrollments.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-150 ease-in-out">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Filter Dropdown and Buttons on the right -->
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
                            <x-dropdown-link href="{{ route('enrollments.index', array_merge(request()->query(), ['sort_by' => 'name_asc'])) }}" class="flex items-center gap-2">
                                Name (A-Z)
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('enrollments.index', array_merge(request()->query(), ['sort_by' => 'name_desc'])) }}" class="flex items-center gap-2">
                                Name (Z-A)
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('enrollments.index', array_merge(request()->query(), ['sort_by' => 'lrn_asc'])) }}" class="flex items-center gap-2">
                                LRN (Ascending)
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('enrollments.index', array_merge(request()->query(), ['sort_by' => 'lrn_desc'])) }}" class="flex items-center gap-2">
                                LRN (Descending)
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('enrollments.index', array_merge(request()->query(), ['sort_by' => 'grade_asc'])) }}" class="flex items-center gap-2">
                                Grade Level (Ascending)
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('enrollments.index', array_merge(request()->query(), ['sort_by' => 'grade_desc'])) }}" class="flex items-center gap-2">
                                Grade Level (Descending)
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('enrollments.index', array_merge(request()->query(), ['sort_by' => 'status_asc'])) }}" class="flex items-center gap-2">
                                Status (Ascending)
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('enrollments.index', array_merge(request()->query(), ['sort_by' => 'status_desc'])) }}" class="flex items-center gap-2">
                                Status (Descending)
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    {{-- Settings button with tooltip --}}
                    @if($canAccessSettings)
                        <x-tooltip text="Enrollment Setup" position="bottom">
                            <x-secondary-button 
                                class="ms-3 px-7 gap-2" 
                                x-data="{}" 
                                @click="$dispatch('open-modal', 'enrollment-settings')"
                            >
                                <x-hugeicons-settings-01 />
                            </x-secondary-button>
                        </x-tooltip>
                    @endif
                    
                    {{-- In the buttons section --}}
                    <x-tooltip text="Register a Student" position="bottom">
                        <x-primary-button 
                            class="gap-2 px-5" 
                            x-data="{}" 
                            @click="$dispatch('open-modal', 'select-student-type')"
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
                        @forelse ($enrollments as $enrollment)
                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $enrollment->student->lrn }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $enrollment->grade_level }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $enrollment->status }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('enrollments.edit', $enrollment) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center">
                                    @if(request('search'))
                                        No enrollments found for your search criteria.
                                    @else
                                        No enrollments found.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $enrollments->appends(request()->query())->links() }}
        </div>
    </div>

    @include('enrollments.modals.enrollment-settings')
    @include('enrollments.modals.student-classification')

    @push('scripts')
    <script>
        let currentSections = @json($sectionsByGrade);
        const teachers = @json($teachers);

        function loadSectionsForGrade(grade) {
            const sectionsContainer = document.getElementById('sections-container');
            const sectionsList = document.getElementById('sections-list');
            const currentGradeLabel = document.getElementById('current-grade-label');

            if (!grade) {
                sectionsContainer.classList.add('hidden');
                return;
            }

            currentGradeLabel.textContent = `Grade ${grade}`;
            sectionsContainer.classList.remove('hidden');
            sectionsList.innerHTML = '';

            if (!currentSections[grade]) {
                currentSections[grade] = [];
            }

            currentSections[grade].forEach((section, index) => {
                const sectionElement = createSectionElement(grade, index, section.name, section.adviser_id);
                sectionsList.appendChild(sectionElement);
            });

            document.getElementById('new-section-input').value = '';
            document.getElementById('new-adviser-select').value = '';
        }

        function createSectionElement(grade, index, sectionName, adviserId) {
            const div = document.createElement('div');
            div.className = 'flex items-center gap-2 p-2 bg-gray-50 rounded-md';
            div.innerHTML = `
                <input 
                    type="text" 
                    value="${sectionName}" 
                    onchange="updateSection(${grade}, ${index}, this.value)"
                    class="flex-1 border-none bg-transparent focus:ring-0 focus:outline-none text-sm"
                >
                <select 
                    onchange="updateSectionAdviser(${grade}, ${index}, this.value)"
                    class="border-none bg-transparent focus:ring-0 focus:outline-none text-sm"
                >
                    <option value="">No Adviser</option>
                    ${teachers.map(t => `<option value="${t.id}" ${t.id == adviserId ? 'selected' : ''}>${t.name}</option>`).join('')}
                </select>
                <button 
                    type="button" 
                    onclick="removeSection(${grade}, ${index})"
                    class="text-red-600 hover:text-red-800 p-1 rounded transition-colors duration-150"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            `;
            return div;
        }

        function addSection() {
            const grade = document.getElementById('grade_level').value;
            const newSectionInput = document.getElementById('new-section-input');
            const newAdviserSelect = document.getElementById('new-adviser-select');
            const sectionName = newSectionInput.value.trim();
            const adviserId = newAdviserSelect.value || null;

            if (!grade) return alert('Please select a grade level first.');
            if (!sectionName) return alert('Please enter a section name.');

            if (!currentSections[grade]) currentSections[grade] = [];

            currentSections[grade].push({ name: sectionName, adviser_id: adviserId });

            loadSectionsForGrade(grade);

            newSectionInput.value = '';
            newAdviserSelect.value = '';
            newSectionInput.focus();
        }

        function updateSection(grade, index, newValue) {
            if (currentSections[grade] && currentSections[grade][index]) {
                currentSections[grade][index].name = newValue.trim();
            }
        }

        function updateSectionAdviser(grade, index, newValue) {
            if (currentSections[grade] && currentSections[grade][index]) {
                currentSections[grade][index].adviser_id = newValue || null;
            }
        }

        function removeSection(grade, index) {
            if (currentSections[grade] && currentSections[grade][index]) {
                if (confirm('Are you sure you want to remove this section?')) {
                    currentSections[grade].splice(index, 1);
                    loadSectionsForGrade(grade);
                }
            }
        }

        function saveSettings() {
            const schoolYear = document.getElementById('school_year').value;
            const gradeLevel = document.getElementById('grade_level').value;

            const settingsData = {
                school_year: schoolYear,
                active_grade_level: gradeLevel, // Optional, if needed
                sections: currentSections
            };

            fetch('{{ route("sections.sync") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(settingsData)
            })
            .then(response => response.json())
            .then(data => {
                alert('Settings saved successfully!');
                window.dispatchEvent(new CustomEvent('close-modal', { detail: 'enrollment-settings' }));
                window.location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving settings.');
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const newSectionInput = document.getElementById('new-section-input');
            if (newSectionInput) {
                newSectionInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        addSection();
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>