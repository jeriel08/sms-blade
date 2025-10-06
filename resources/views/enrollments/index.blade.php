<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-1 leading-tight">
            {{ __('ENROLLMENT') }}
        </h2>
    </x-slot>

    <div class=" bg-white rounded-lg shadow-sm min-h-screen mx-auto sm:p-6 lg:p-8">
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

                <x-secondary-button 
                    class="ms-3 px-7 gap-2" 
                    x-data="{}" 
                    @click="$dispatch('open-modal', 'enrollment-settings')"
                >
                    <x-hugeicons-settings-01 />
                </x-secondary-button>

                <x-primary-button class="ms-3 px-7 gap-2">
                    <x-hugeicons-add-01 />
                    {{ __('Add Student') }}
                </x-primary-button>
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

    <!-- Settings Modal -->
    <x-modal name="enrollment-settings" maxWidth="2xl">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-6">
                {{ __('Enrollment Settings') }}
            </h2>

            <form id="enrollment-settings-form">
                <!-- School Year Input -->
                <div class="mb-6">
                    <x-input-label for="school_year" :value="__('School Year')" />
                    <x-text-input 
                        id="school_year" 
                        name="school_year" 
                        type="text" 
                        class="mt-1 block w-full" 
                        placeholder="e.g., 2024-2025"
                        required 
                    />
                </div>

                <!-- Grade Level Selector - Now using combobox/select -->
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
                            <option value="{{ $grade }}">Grade {{ $grade }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Dynamic Sections Container -->
                <div id="sections-container" class="hidden">
                    <div class="flex items-center justify-between mb-4">
                        <x-input-label :value="__('Sections for Grade')" class="!mb-0" />
                        <span id="current-grade-label" class="text-lg font-semibold text-gray-700"></span>
                    </div>

                    <!-- Sections List -->
                    <div id="sections-list" class="space-y-2 mb-4 max-h-60 overflow-y-auto p-2 border border-gray-200 rounded-md">
                        <!-- Sections will be dynamically added here -->
                    </div>

                    <!-- Add Section Button -->
                    <div class="flex gap-2">
                        <x-text-input 
                            id="new-section-input" 
                            type="text" 
                            class="flex-1" 
                            placeholder="Enter new section name..."
                        />
                        <x-primary-button 
                            type="button" 
                            onclick="addSection()"
                            class="whitespace-nowrap"
                        >
                            Add Section
                        </x-primary-button>
                    </div>

                    <!-- Helper Text -->
                    <p class="text-xs text-gray-500 mt-2">
                        Add, edit, or remove sections for the selected grade level.
                    </p>
                </div>
            </form>

            <!-- Modal Actions -->
            <div class="flex justify-end gap-3 mt-6">
                <x-secondary-button 
                    type="button" 
                    @click="$dispatch('close-modal', 'enrollment-settings')"
                >
                    {{ __('Cancel') }}
                </x-secondary-button>
                
                <x-primary-button 
                    type="button" 
                    onclick="saveSettings()"
                >
                    {{ __('Save Settings') }}
                </x-primary-button>
            </div>
        </div>
    </x-modal>

    @push('scripts')
    <script>
        let currentSections = {
            // This will store sections for each grade level
            // Example: 7: ['Section A', 'Section B'], 8: ['Section C'], etc.
        };

        function loadSectionsForGrade(grade) {
            const sectionsContainer = document.getElementById('sections-container');
            const sectionsList = document.getElementById('sections-list');
            const currentGradeLabel = document.getElementById('current-grade-label');

            if (!grade) {
                sectionsContainer.classList.add('hidden');
                return;
            }

            // Update the grade label
            currentGradeLabel.textContent = `Grade ${grade}`;
            
            // Show sections container
            sectionsContainer.classList.remove('hidden');
            
            // Clear existing sections
            sectionsList.innerHTML = '';

            // Get sections for this grade or initialize empty array
            if (!currentSections[grade]) {
                currentSections[grade] = [];
            }

            // Display each section
            currentSections[grade].forEach((section, index) => {
                const sectionElement = createSectionElement(grade, index, section);
                sectionsList.appendChild(sectionElement);
            });

            // Clear the new section input
            document.getElementById('new-section-input').value = '';
        }

        function createSectionElement(grade, index, sectionName) {
            const div = document.createElement('div');
            div.className = 'flex items-center gap-2 p-2 bg-gray-50 rounded-md';
            div.innerHTML = `
                <input 
                    type="text" 
                    value="${sectionName}" 
                    onchange="updateSection(${grade}, ${index}, this.value)"
                    class="flex-1 border-none bg-transparent focus:ring-0 focus:outline-none text-sm"
                >
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
            const sectionName = newSectionInput.value.trim();

            if (!grade) {
                alert('Please select a grade level first.');
                return;
            }

            if (!sectionName) {
                alert('Please enter a section name.');
                return;
            }

            // Initialize array if it doesn't exist
            if (!currentSections[grade]) {
                currentSections[grade] = [];
            }

            // Add new section
            currentSections[grade].push(sectionName);
            
            // Reload sections
            loadSectionsForGrade(grade);
            
            // Clear input
            newSectionInput.value = '';
            newSectionInput.focus();
        }

        function updateSection(grade, index, newValue) {
            if (currentSections[grade] && currentSections[grade][index]) {
                currentSections[grade][index] = newValue.trim();
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
                active_grade_level: gradeLevel,
                sections: currentSections
            };
            
            // Here you would typically send the data to your backend
            console.log('Saving settings:', settingsData);
            
            // Show success message or handle response
            alert('Settings saved successfully!');
            
            // Close the modal
            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'enrollment-settings' }));
        }

        // Optional: Add keyboard support for the new section input
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