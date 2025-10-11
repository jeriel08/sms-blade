<div class="mt-6">
    <form id="admin-enrollment-settings-form" method="POST" action="{{ route('admin.control.settings') }}">
        @csrf
        <div class="mb-6">
            <x-input-label for="admin-school-year" :value="__('School Year')" />
            <x-text-input 
                id="admin-school-year" 
                name="school_year" 
                type="text" 
                class="mt-1 block w-full" 
                placeholder="e.g., 2024-2025"
                value="{{ $schoolYear }}"
                required 
            />
            <x-input-error :messages="$errors->get('school_year')" class="mt-2" />
        </div>

        <hr class="my-6">

        <div class="mb-6">
            <x-input-label for="admin-grade-level" :value="__('Select Grade Level')" />
            <select 
                id="admin-grade-level" 
                name="grade_level"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-xs cursor-pointer"
                onchange="loadSectionsForGrade(this.value, 'admin')"
            >
                <option value="">Choose a grade level</option>
                @foreach(range(7, 12) as $grade)
                    <option value="{{ $grade }}" {{ old('grade_level', $assignedGrade) == $grade ? 'selected' : '' }}>Grade {{ $grade }}</option>
                @endforeach
            </select>
        </div>

        <div id="admin-sections-container" class="hidden">
            <div class="flex items-center justify-between mb-4">
                <x-input-label :value="__('Sections for Grade')" class="!mb-0" />
                <span id="admin-current-grade-label" class="text-lg font-semibold text-gray-700"></span>
            </div>

            <div class="mb-4">
                <x-text-input 
                    id="admin-section-search" 
                    type="text" 
                    class="w-full" 
                    placeholder="Search sections..."
                    oninput="filterSections(this.value, 'admin')"
                />
            </div>

            <div id="admin-sections-list" class="space-y-2 mb-4 max-h-60 overflow-y-auto p-2 border border-gray-200 rounded-md">
                <!-- Dynamic sections -->
            </div>

            <div class="flex gap-2 mb-4">
                <x-text-input 
                    id="admin-new-section-input" 
                    type="text" 
                    class="flex-1" 
                    placeholder="Enter new section name..."
                />
                <select id="admin-new-adviser-select" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm min-w-[150px]">
                    <option value="">Loading advisers...</option>
                </select>
                <x-primary-button 
                    type="button" 
                    onclick="addSection('admin')"
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

        <div id="admin-disabilities-container">
            <div class="mb-4">
                <x-input-label :value="__('Disabilities')" />
            </div>

            <div class="mb-4">
                <x-text-input 
                    id="admin-disability-search" 
                    type="text" 
                    class="w-full" 
                    placeholder="Search disabilities..."
                    oninput="filterDisabilities(this.value, 'admin')"
                />
            </div>

            <div id="admin-disabilities-list" class="space-y-2 mb-4 max-h-60 overflow-y-auto p-2 border border-gray-200 rounded-md">
                <!-- Dynamic disabilities -->
            </div>

            <div class="flex gap-2 mb-4">
                <x-text-input 
                    id="admin-new-disability-input" 
                    type="text" 
                    class="flex-1" 
                    placeholder="Enter disability name (e.g., Visual Impairment)..."
                />
                <x-primary-button 
                    type="button" 
                    onclick="addDisability('admin')"
                    class="whitespace-nowrap"
                >
                    Add Disability
                </x-primary-button>
            </div>

            <p class="text-xs text-gray-500 mt-2">
                Add, edit, or remove disabilities for student records.
            </p>
        </div>

        <div class="flex justify-end gap-3 mt-6">
            <x-primary-button type="button" onclick="saveSettings()">
                {{ __('Save Settings') }}
            </x-primary-button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    let currentSections = @json($sectionsByGrade ?? []);
    let currentDisabilities = @json($disabilities ?? ['ADHD']);
    const teachersByGrade = @json($teachersByGrade ?? []);
    const teachers = Object.values(teachersByGrade).flat();
    let sectionSearchTerm = '';
    let disabilitySearchTerm = '';

    function updateAdviserSelect(grade, prefix = 'admin') {
        const adviserSelect = document.getElementById(`${prefix}-new-adviser-select`);
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

    function filterSections(searchTerm, prefix = 'admin') {
        sectionSearchTerm = searchTerm.toLowerCase().trim();
        const grade = document.getElementById(`${prefix}-grade-level`).value;
        if (!grade) return;

        const sectionsList = document.getElementById(`${prefix}-sections-list`);
        sectionsList.innerHTML = '';

        const filteredSections = (currentSections[grade] || []).filter(section => 
            section.name.toLowerCase().includes(sectionSearchTerm)
        );

        if (filteredSections.length === 0) {
            sectionsList.innerHTML = '<p class="text-sm text-gray-500 p-2">No matching sections found.</p>';
            return;
        }

        filteredSections.forEach((section, index) => {
            const sectionElement = createSectionElement(grade, index, section.name, section.adviser_id, prefix);
            sectionsList.appendChild(sectionElement);
        });
    }

    function loadSectionsForGrade(grade, prefix = 'admin') {
        const sectionsContainer = document.getElementById(`${prefix}-sections-container`);
        const sectionsList = document.getElementById(`${prefix}-sections-list`);
        const currentGradeLabel = document.getElementById(`${prefix}-current-grade-label`);

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

        filterSections(sectionSearchTerm, prefix);
        updateAdviserSelect(grade, prefix);
        document.getElementById(`${prefix}-new-section-input`).value = '';
        document.getElementById(`${prefix}-new-adviser-select`).value = '';
    }

    function createSectionElement(grade, index, sectionName, adviserId, prefix = 'admin') {
        const div = document.createElement('div');
        div.className = 'flex items-center gap-2 p-2 bg-gray-50 rounded-md';
        div.innerHTML = `
            <input 
                type="text" 
                value="${sectionName}" 
                onchange="updateSection(${grade}, ${index}, this.value, '${prefix}')"
                class="flex-1 border-none bg-transparent focus:ring-0 focus:outline-none text-sm"
            >
            <select 
                onchange="updateSectionAdviser(${grade}, ${index}, this.value, '${prefix}')"
                class="border-none bg-transparent focus:ring-0 focus:outline-none text-sm"
            >
                <option value="">No Adviser</option>
                ${teachers.map(t => `<option value="${t.id}" ${t.id == adviserId ? 'selected' : ''}>${t.name}</option>`).join('')}
            </select>
            <button 
                type="button" 
                onclick="removeSection(${grade}, ${index}, '${prefix}')"
                class="text-red-600 hover:text-red-800 p-1 rounded transition-colors duration-150"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        `;
        return div;
    }

    function addSection(prefix = 'admin') {
        const grade = document.getElementById(`${prefix}-grade-level`).value;
        const newSectionInput = document.getElementById(`${prefix}-new-section-input`);
        const newAdviserSelect = document.getElementById(`${prefix}-new-adviser-select`);
        const sectionName = newSectionInput.value.trim();
        const adviserId = newAdviserSelect.value || null;

        if (!grade) {
            showToast('Please select a grade level first.', 'error');
            return;
        }
        if (!sectionName) {
            showToast('Please enter a section name.', 'error');
            return;
        }

        if (!currentSections[grade]) currentSections[grade] = [];

        if (currentSections[grade].some(section => section.name === sectionName)) {
            showToast('Section already exists.', 'error');
            return;
        }

        currentSections[grade].push({ name: sectionName, adviser_id: adviserId });
        showToast(`Section "${sectionName}" added!`, 'success');

        loadSectionsForGrade(grade, prefix);
        newSectionInput.value = '';
        newAdviserSelect.value = '';
        newSectionInput.focus();
    }

    function updateSection(grade, index, newValue, prefix = 'admin') {
        if (currentSections[grade] && currentSections[grade][index]) {
            const oldName = currentSections[grade][index].name;
            const newName = newValue.trim();
            if (!newName) {
                showToast('Section name cannot be empty.', 'error');
                return;
            }
            if (currentSections[grade].some((section, i) => i !== index && section.name === newName)) {
                showToast('Section already exists.', 'error');
                return;
            }
            currentSections[grade][index].name = newName;
            showToast(`Section updated from "${oldName}" to "${newName}"`, 'success');
            filterSections(sectionSearchTerm, prefix);
        }
    }

    function updateSectionAdviser(grade, index, newValue, prefix = 'admin') {
        if (currentSections[grade] && currentSections[grade][index]) {
            const sectionName = currentSections[grade][index].name;
            const teacher = teachers.find(t => t.id == newValue);
            currentSections[grade][index].adviser_id = newValue || null;
            showToast(`Adviser for "${sectionName}" updated to ${teacher ? teacher.name : 'None'}`, 'success');
            filterSections(sectionSearchTerm, prefix);
        }
    }

    function removeSection(grade, index, prefix = 'admin') {
        if (currentSections[grade] && currentSections[grade][index]) {
            const sectionName = currentSections[grade][index].name;
            if (confirm(`Are you sure you want to remove section "${sectionName}"?`)) {
                currentSections[grade].splice(index, 1);
                showToast(`Section "${sectionName}" removed`, 'success');
                loadSectionsForGrade(grade, prefix);
            }
        }
    }

    function filterDisabilities(searchTerm, prefix = 'admin') {
        disabilitySearchTerm = searchTerm.toLowerCase().trim();
        const disabilitiesList = document.getElementById(`${prefix}-disabilities-list`);
        disabilitiesList.innerHTML = '';

        const filteredDisabilities = currentDisabilities.filter(name => 
            name.toLowerCase().includes(disabilitySearchTerm)
        );

        if (filteredDisabilities.length === 0) {
            disabilitiesList.innerHTML = '<p class="text-sm text-gray-500 p-2">No matching disabilities found.</p>';
            return;
        }

        filteredDisabilities.forEach((disabilityName, index) => {
            const disabilityElement = createDisabilityElement(index, disabilityName, prefix);
            disabilitiesList.appendChild(disabilityElement);
        });
    }

    function loadDisabilities(prefix = 'admin') {
        filterDisabilities(disabilitySearchTerm, prefix);
        document.getElementById(`${prefix}-new-disability-input`).value = '';
    }

    function createDisabilityElement(index, disabilityName, prefix = 'admin') {
        const div = document.createElement('div');
        div.className = 'flex items-center gap-2 p-2 bg-gray-50 rounded-md';
        div.innerHTML = `
            <input 
                type="text" 
                value="${disabilityName}" 
                onchange="updateDisability(${index}, this.value, '${prefix}')"
                class="flex-1 border-none bg-transparent focus:ring-0 focus:outline-none text-sm"
            >
            <button 
                type="button" 
                onclick="removeDisability(${index}, '${prefix}')"
                class="text-red-600 hover:text-red-800 p-1 rounded transition-colors duration-150"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        `;
        return div;
    }

    function addDisability(prefix = 'admin') {
        const newDisabilityInput = document.getElementById(`${prefix}-new-disability-input`);
        const disabilityName = newDisabilityInput.value.trim();

        if (!disabilityName) {
            showToast('Please enter a disability name.', 'error');
            return;
        }

        if (currentDisabilities.includes(disabilityName)) {
            showToast('Disability already exists.', 'error');
            return;
        }

        currentDisabilities.push(disabilityName);
        showToast(`Disability "${disabilityName}" added!`, 'success');
        loadDisabilities(prefix);
        newDisabilityInput.value = '';
        newDisabilityInput.focus();
    }

    function updateDisability(index, newValue, prefix = 'admin') {
        if (currentDisabilities[index]) {
            const oldName = currentDisabilities[index];
            const newName = newValue.trim();
            if (!newName) {
                showToast('Disability name cannot be empty.', 'error');
                return;
            }
            if (currentDisabilities.includes(newName) && newName !== oldName) {
                showToast('Disability already exists.', 'error');
                return;
            }
            currentDisabilities[index] = newName;
            showToast(`Disability updated from "${oldName}" to "${newName}"`, 'success');
            loadDisabilities(prefix);
        }
    }

    function removeDisability(index, prefix = 'admin') {
        if (currentDisabilities[index]) {
            const disabilityName = currentDisabilities[index];
            if (confirm(`Are you sure you want to remove disability "${disabilityName}"?`)) {
                currentDisabilities.splice(index, 1);
                showToast(`Disability "${disabilityName}" removed`, 'success');
                loadDisabilities(prefix);
            }
        }
    }

    function saveSettings() {
        const schoolYear = document.getElementById('admin-school-year').value;
        const gradeLevel = document.getElementById('admin-grade-level').value;

        if (!schoolYear.match(/^\d{4}-\d{4}$/)) {
            showToast('Please enter a valid school year (e.g., 2024-2025).', 'error');
            return;
        }

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
                showToast('Settings saved successfully!', 'success');
                setTimeout(() => {
                    window.location.href = '{{ route("enrollments.index") }}';
                }, 1500);
            } else {
                let errorMessage = data.message || 'Error saving settings.';
                if (data.errors) {
                    errorMessage = Object.values(data.errors).flat().join(' ');
                }
                showToast(errorMessage, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error saving settings.', 'error');
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        try {
            console.log('Enrollment script loaded');
            loadDisabilities('admin');
            const assignedGrade = {{ $assignedGrade ?? 7 }};
            if (assignedGrade) {
                document.getElementById('admin-grade-level').value = assignedGrade;
                loadSectionsForGrade(assignedGrade, 'admin');
            }

            const newDisabilityInput = document.getElementById('admin-new-disability-input');
            if (newDisabilityInput) {
                newDisabilityInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        addDisability('admin');
                    }
                });
            }

            const newSectionInput = document.getElementById('admin-new-section-input');
            if (newSectionInput) {
                newSectionInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        addSection('admin');
                    }
                });
            }

            document.getElementById('admin-enrollment-settings-form')?.addEventListener('submit', function(e) {
                e.preventDefault();
                saveSettings();
            });
        } catch (error) {
            console.error('Error in enrollment script:', error);
        }
    });
</script>
@endpush