<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-1 leading-tight">
            {{ __('ENROLLMENT SETTINGS') }}
        </h2>
    </x-slot>

    <div class="bg-white rounded-lg shadow-sm min-h-screen mx-auto sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form id="enrollment-settings-form">
                <div class="mb-6">
                    <x-input-label for="school_year" :value="__('School Year')" />
                    <x-text-input 
                        id="school_year" 
                        name="school_year" 
                        type="text" 
                        class="mt-1 block w-full" 
                        placeholder="e.g., 2024-2025"
                        value="{{ $schoolYear }}"
                        required 
                    />
                </div>

                <hr class="my-6">

                <div class="mb-6">
                    <x-input-label for="grade_level" :value="__('Select Grade Level')" />
                    <select 
                        id="grade_level" 
                        name="grade_level"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-xs cursor-pointer"
                        onchange="loadSectionsForGrade(this.value)"
                    >
                        <option value="">Choose a grade level</option>
                        @foreach(range(7, 12) as $grade)
                            <option value="{{ $grade }}" {{ old('grade_level', $assignedGrade) == $grade ? 'selected' : '' }}>Grade {{ $grade }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="sections-container" class="hidden">
                    <div class="flex items-center justify-between mb-4">
                        <x-input-label :value="__('Sections for Grade')" class="!mb-0" />
                        <span id="current-grade-label" class="text-lg font-semibold text-gray-700"></span>
                    </div>

                    <div class="mb-4">
                        <x-text-input 
                            id="section-search" 
                            type="text" 
                            class="w-full" 
                            placeholder="Search sections..."
                            oninput="filterSections(this.value)"
                        />
                    </div>

                    <div id="sections-list" class="space-y-2 mb-4 max-h-60 overflow-y-auto p-2 border border-gray-200 rounded-md">
                        <!-- Dynamic sections -->
                    </div>

                    <div class="flex gap-2 mb-4">
                        <x-text-input 
                            id="new-section-input" 
                            type="text" 
                            class="flex-1" 
                            placeholder="Enter new section name..."
                        />
                        <select id="new-adviser-select" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm min-w-[150px]">
                            <option value="">Loading advisers...</option>
                        </select>
                        <x-primary-button 
                            type="button" 
                            onclick="addSection()"
                            class="whitespace-nowrap"
                        >
                            Add Section
                        </x-primary-button>
                    </div>

                    <p class="text-xs text-gray-500 mt-2">
                        Add, edit, or remove sections and assign advisers for the selected grade level.
                    </p>
                </div>

                <hr class="my-6">

                <div id="disabilities-container">
                    <div class="mb-4">
                        <x-input-label :value="__('Disabilities')" />
                    </div>

                    <div class="mb-4">
                        <x-text-input 
                            id="disability-search" 
                            type="text" 
                            class="w-full" 
                            placeholder="Search disabilities..."
                            oninput="filterDisabilities(this.value)"
                        />
                    </div>

                    <div id="disabilities-list" class="space-y-2 mb-4 max-h-60 overflow-y-auto p-2 border border-gray-200 rounded-md">
                        <!-- Dynamic disabilities -->
                    </div>

                    <div class="flex gap-2 mb-4">
                        <x-text-input 
                            id="new-disability-input" 
                            type="text" 
                            class="flex-1" 
                            placeholder="Enter disability name (e.g., Visual Impairment)..."
                        />
                        <x-primary-button 
                            type="button" 
                            onclick="addDisability()"
                            class="whitespace-nowrap"
                        >
                            Add Disability
                        </x-primary-button>
                    </div>

                    <p class="text-xs text-gray-500 mt-2">
                        Add, edit, or remove disabilities for student records.
                    </p>
                </div>
            </form>

            <div class="flex justify-end gap-3 mt-6">
                <x-secondary-button 
                    type="button" 
                    onclick="window.location.href='{{ route('enrollments.index') }}'"
                >
                    {{ __('Back to Enrollments') }}
                </x-secondary-button>
                
                <x-primary-button 
                    type="button" 
                    onclick="saveSettings()"
                >
                    {{ __('Save Settings') }}
                </x-primary-button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let currentSections = @json($sectionsByGrade ?? []);
        let currentDisabilities = @json($disabilities ?? []);
        const teachersByGrade = @json($teachersByGrade ?? []);
        const teachers = Object.values(teachersByGrade).flat();
        let sectionSearchTerm = '';
        let disabilitySearchTerm = '';

        function updateAdviserSelect(grade) {
            const adviserSelect = document.getElementById('new-adviser-select');
            if (!adviserSelect) return;

            const gradeTeachers = teachersByGrade[grade] || teachersByGrade[null] || [];
            adviserSelect.innerHTML = '<option value="">No Adviser</option>';
            
            gradeTeachers.forEach(teacher => {
                const option = document.createElement('option');
                option.value = teacher.id;
                option.textContent = teacher.name;
                adviserSelect.appendChild(option);
            });

            if (gradeTeachers.length === 0) {
                const hintOption = document.createElement('option');
                hintOption.value = '';
                hintOption.textContent = 'No advisers assigned to this grade';
                hintOption.disabled = true;
                adviserSelect.appendChild(hintOption);
            }
        }

        function filterSections(searchTerm) {
            sectionSearchTerm = searchTerm.toLowerCase().trim();
            const grade = document.getElementById('grade_level').value;
            if (!grade) return;

            const sectionsList = document.getElementById('sections-list');
            sectionsList.innerHTML = '';

            const filteredSections = (currentSections[grade] || []).filter(section => 
                section.name.toLowerCase().includes(sectionSearchTerm)
            );

            if (filteredSections.length === 0) {
                sectionsList.innerHTML = '<p class="text-sm text-gray-500 p-2">No matching sections found.</p>';
                return;
            }

            filteredSections.forEach((section, index) => {
                const sectionElement = createSectionElement(grade, index, section.name, section.adviser_id);
                sectionsList.appendChild(sectionElement);
            });
        }

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

            filterSections(sectionSearchTerm);
            updateAdviserSelect(grade);
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
                filterSections(sectionSearchTerm);
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

        function filterDisabilities(searchTerm) {
            disabilitySearchTerm = searchTerm.toLowerCase().trim();
            const disabilitiesList = document.getElementById('disabilities-list');
            disabilitiesList.innerHTML = '';

            const filteredDisabilities = currentDisabilities.filter(name => 
                name.toLowerCase().includes(disabilitySearchTerm)
            );

            if (filteredDisabilities.length === 0) {
                disabilitiesList.innerHTML = '<p class="text-sm text-gray-500 p-2">No matching disabilities found.</p>';
                return;
            }

            filteredDisabilities.forEach((disabilityName, index) => {
                const disabilityElement = createDisabilityElement(index, disabilityName);
                disabilitiesList.appendChild(disabilityElement);
            });
        }

        function loadDisabilities() {
            filterDisabilities(disabilitySearchTerm);
            document.getElementById('new-disability-input').value = '';
        }

        function createDisabilityElement(index, disabilityName) {
            const div = document.createElement('div');
            div.className = 'flex items-center gap-2 p-2 bg-gray-50 rounded-md';
            div.innerHTML = `
                <input 
                    type="text" 
                    value="${disabilityName}" 
                    onchange="updateDisability(${index}, this.value)"
                    class="flex-1 border-none bg-transparent focus:ring-0 focus:outline-none text-sm"
                >
                <button 
                    type="button" 
                    onclick="removeDisability(${index})"
                    class="text-red-600 hover:text-red-800 p-1 rounded transition-colors duration-150"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            `;
            return div;
        }

        function addDisability() {
            const newDisabilityInput = document.getElementById('new-disability-input');
            const disabilityName = newDisabilityInput.value.trim();

            if (!disabilityName) return alert('Please enter a disability name.');

            currentDisabilities.push(disabilityName);
            loadDisabilities();
            newDisabilityInput.value = '';
            newDisabilityInput.focus();
        }

        function updateDisability(index, newValue) {
            if (currentDisabilities[index]) {
                currentDisabilities[index] = newValue.trim();
                loadDisabilities();
            }
        }

        function removeDisability(index) {
            if (currentDisabilities[index]) {
                if (confirm('Are you sure you want to remove this disability?')) {
                    currentDisabilities.splice(index, 1);
                    loadDisabilities();
                }
            }
        }

        function saveSettings() {
            const schoolYear = document.getElementById('school_year').value;
            const gradeLevel = document.getElementById('grade_level').value;

            const settingsData = {
                school_year: schoolYear,
                active_grade_level: gradeLevel,
                sections: currentSections,
                disabilities: currentDisabilities
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
                if (data.success) {
                    alert('Settings saved successfully!');
                    window.location.href = '{{ route("enrollments.index") }}';
                } else {
                    alert(data.message || 'Error saving settings.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving settings.');
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadDisabilities();
            const assignedGrade = {{ $assignedGrade ?? 7 }};
            if (assignedGrade) {
                document.getElementById('grade_level').value = assignedGrade;
                loadSectionsForGrade(assignedGrade);
            }

            const newDisabilityInput = document.getElementById('new-disability-input');
            if (newDisabilityInput) {
                newDisabilityInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        addDisability();
                    }
                });
            }

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