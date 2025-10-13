<x-app-layout x-transition>
    @section('title', 'Enrollments | MBNHS-SMS')
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
                            <a href="{{ route('enrollments.settings') }}" class="gap-2 inline-flex items-center">
                                <x-secondary-button class="gap-2">
                                    <x-hugeicons-settings-01 />
                                </x-secondary-button>
                            </a>
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
                                Section
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($enrollments as $enrollment)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    {{ $enrollment->student->lrn ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $enrollment->student->last_name . ', ' . $enrollment->student->first_name . ' ' . ($enrollment->student->middle_name ? $enrollment->student->middle_name[0] . '.' : '') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $enrollment->grade_level ?? 'Unassigned' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $enrollment->section->name ?? 'Unassigned' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium 
                                        {{ $enrollment->status === 'Enrolled' ? 'bg-green-100 text-green-800' : 
                                           ($enrollment->status === 'Registered' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $enrollment->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($enrollment->status === 'Registered')
                                    <x-tooltip text="Enroll Student" position="bottom">
                                        <x-primary-button x-on:click="console.log('Dispatching open-modal for enroll-student-{{ $enrollment->enrollment_id }}'); $dispatch('open-modal', 'enroll-student-{{ $enrollment->enrollment_id }}')">
                                            Assign
                                        </x-primary-button>
                                    </x-tooltip>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    No enrollments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $enrollments->appends(request()->query())->links() }}
        </div>
    </div>

    @include('enrollments.modals.student-classification')
    @include('enrollments.modals.lrn-search')
    @foreach ($enrollments as $enrollment)
        @if ($enrollment->status === 'Registered')
            @include('enrollments.modals.enroll-student', ['enrollment_id' => $enrollment->enrollment_id])
        @endif
    @endforeach

    <script>
        let currentStudentType = '';
        let studentLrn = '';

        function openLrnModal(type) {
            console.log('Opening LRN modal for type:', type);
            currentStudentType = type;
            
            // Reset LRN modal form
            setTimeout(() => {
                const lrnInput = document.getElementById('lrn-input');
                if (lrnInput) lrnInput.value = '';
                const studentTypeInput = document.getElementById('student_type_input');
                if (studentTypeInput) studentTypeInput.value = type;
                const errorMsg = document.getElementById('error-message');
                if (errorMsg) {
                    errorMsg.classList.add('hidden');
                    errorMsg.textContent = '';
                }
            }, 100);

            // Dispatch proper Alpine.js events
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'lrn-search' }));
            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'select-student-type' }));
            console.log('Dispatched events to open LRN modal');
        }

        function closeModal(name) {
            window.dispatchEvent(new CustomEvent('close-modal', { detail: name }));
            console.log(`Dispatched close event for: ${name}`);
        }

        // Update sections function remains the same
        function updateSections(enrollmentId) {
            const gradeLevel = document.getElementById(`grade_level_${enrollmentId}`).value || '7';
            const sectionSelect = document.getElementById(`section_id_${enrollmentId}`);
            sectionSelect.innerHTML = '<option value="" disabled selected>Loading...</option>';

            fetch(`/sections?grade_level=${gradeLevel}`)
                .then(response => response.json())
                .then(sections => {
                    sectionSelect.innerHTML = '<option value="" disabled selected>Select Section</option>';
                    sections.forEach(section => {
                        const option = document.createElement('option');
                        option.value = section.section_id;
                        option.textContent = section.name;
                        sectionSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching sections:', error);
                    sectionSelect.innerHTML = '<option value="" disabled selected>Error loading sections</option>';
                });
        }
    </script>

    @if (session('error'))
        <script>
            window.addEventListener('load', () => {
                window.dispatchEvent(new CustomEvent('open-modal', { detail: 'lrn-search' }));
                setTimeout(() => {
                    const errorMsg = document.getElementById('error-message');
                    if (errorMsg) {
                        errorMsg.textContent = '{{ session('error') }}';
                        errorMsg.classList.remove('hidden');
                    }
                    // Optional: If you have a toast function
                    if (typeof showToast === 'function') {
                        showToast('{{ session('error') }}', 'error');
                    }
                }, 100);
            });
        </script>
    @endif
</x-app-layout>