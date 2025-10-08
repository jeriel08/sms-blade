{{-- resources/views/enrollments/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-1 leading-tight">
            {{ __('ENROLL STUDENT') }}
        </h2>
    </x-slot>

    <div class="bg-white rounded-lg shadow-sm min-h-screen mx-auto sm:p-6 lg:p-8">
        <div class="max-w-6xl mx-auto"> {{-- Increased width from 4xl to 6xl for wider form --}}
            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="relative flex justify-between items-center">
                    @php
                        $steps = [
                            'learner' => 'Learner Information',
                            'address' => 'Address',
                            'guardian' => 'Guardian Information',
                            'school' => 'Recent School',
                            'review' => 'Review'
                        ];
                        
                        // Hide school step if not transferee
                        if($studentType !== 'transferee') {
                            unset($steps['school']);
                            // Reindex array
                            $steps = array_combine(
                                ['learner', 'address', 'guardian', 'review'],
                                array_values($steps)
                            );
                        }

                        // Calculate completed steps
                        $stepKeys = array_keys($steps);
                        $currentIndex = array_search($currentStep, $stepKeys);
                        $completedSteps = $currentIndex; // 0-based index of completed steps
                    @endphp

                    @foreach($steps as $key => $label)
                        @php
                            $stepIndex = array_search($key, $stepKeys);
                            $isCompleted = $stepIndex < $completedSteps;
                            $isCurrent = $stepIndex === $completedSteps;
                            $isFuture = $stepIndex > $completedSteps;
                        @endphp

                        <!-- Step Circle -->
                        <div class="flex flex-col items-center min-w-0 flex-1 relative">
                            <!-- Progress Line (before circle, except first step) -->
                            @if($loop->index > 0)
                                <div class="absolute top-4 left-8 flex-1 h-1 
                                    {{ $isCompleted ? 'bg-blue-600' : 'bg-gray-300' }}"
                                    style="z-index: 9;">
                                </div>
                            @endif

                            <!-- Step Circle -->
                            <div class="relative z-10 w-15 h-15 rounded-full flex items-center justify-center text-lg font-bold
                                {{ $isCurrent ? 'bg-blue-600 text-white ring-2' : 
                                   ($isCompleted ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600') }}">
                                {{ $loop->iteration }}
                            </div>

                            <!-- Step Label -->
                            <span class="text-xs mt-2 text-center px-1
                                {{ $isCurrent ? 'font-medium text-blue-600' : 
                                   ($isCompleted ? 'text-blue-600' : 'text-gray-500') }}">
                                {{ $label }}
                            </span>

                            <!-- Progress Line (after circle, except last step) -->
                            @if(!$loop->last)
                                <div class="absolute top-4 right-8 flex-1 h-1 
                                    {{ $isCompleted ? 'bg-green-500' : 'bg-gray-300' }}"
                                    style="z-index: -1;">
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Student Type Badge -->
            <div class="mb-6 display: hidden">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                    {{ $studentType === 'new' ? 'bg-green-100 text-green-800' : 
                       ($studentType === 'old' ? 'bg-blue-100 text-blue-800' :
                       ($studentType === 'transferee' ? 'bg-purple-100 text-purple-800' : 'bg-orange-100 text-orange-800')) }}">
                    {{ ucfirst($studentType) }} Student
                </span>
            </div>

            <!-- Form Content -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <form id="enrollment-form" method="POST" action="{{ route('enrollments.store') }}">
                    @csrf
                    <input type="hidden" name="student_type" value="{{ $studentType }}">

                    @switch($currentStep)
                        @case('learner')
                            @include('enrollments.partials.learner-information')
                            @break
                            
                        @case('address')
                            @include('enrollments.partials.address-information')
                            @break
                            
                        @case('guardian')
                            @include('enrollments.partials.guardian-information')
                            @break
                            
                        @case('school')
                            @include('enrollments.partials.school-information')
                            @break
                            
                        @case('review')
                            @include('enrollments.partials.review-information')
                            @break
                    @endswitch
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function navigateStep(direction) {
            const steps = ['learner', 'address', 'guardian', 'school', 'review'];
            const studentType = '{{ $studentType }}';
            
            // Adjust steps based on student type
            let availableSteps = [...steps];
            if (studentType !== 'transferee') {
                availableSteps = availableSteps.filter(step => step !== 'school');
            }
            
            const currentStep = '{{ $currentStep }}';
            const currentIndex = availableSteps.indexOf(currentStep);
            
            let nextStep = null;
            if (direction === 'next') {
                if (currentIndex < availableSteps.length - 1) {
                    nextStep = availableSteps[currentIndex + 1];
                }
            } else if (direction === 'prev') {
                if (currentIndex > 0) {
                    nextStep = availableSteps[currentIndex - 1];
                }
            }
            
            if (nextStep) {
                // Save current form data to session storage before navigating
                saveFormData();
                
                // Build URL properly with URLSearchParams
                const url = new URL('{{ route("enrollments.create") }}');
                url.searchParams.set('type', studentType);
                url.searchParams.set('step', nextStep);
                window.location.href = url.toString();
            }
        }

        function saveFormData() {
            const form = document.getElementById('enrollment-form');
            const formData = new FormData(form);
            const data = {};
            
            // Get all form data including disabled fields
            for (let [key, value] of formData.entries()) {
                data[key] = value;
            }
            
            // Handle checkboxes separately (including disability checkboxes)
            const checkboxes = form.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                if (checkbox.name.startsWith('disabilities')) {
                    // For disability checkboxes, store as 1 if checked
                    data[checkbox.name] = checkbox.checked ? '1' : '0';
                } else {
                    // For other checkboxes
                    data[checkbox.name] = checkbox.checked ? '1' : '0';
                }
            });
            
            // Handle radio buttons to ensure they're captured
            const radios = form.querySelectorAll('input[type="radio"]:checked');
            radios.forEach(radio => {
                data[radio.name] = radio.value;
            });
            
            // Get current session data and merge
            const currentData = JSON.parse(sessionStorage.getItem('enrollmentFormData') || '{}');
            const mergedData = {...currentData, ...data};
            
            console.log('Saving to session storage:', mergedData); // Debug log
            sessionStorage.setItem('enrollmentFormData', JSON.stringify(mergedData));
        }

        function loadFormData() {
            const storedData = sessionStorage.getItem('enrollmentFormData');
            if (storedData) {
                const data = JSON.parse(storedData);
                const form = document.getElementById('enrollment-form');
                
                for (let [key, value] of Object.entries(data)) {
                    const input = form.querySelector(`[name="${key}"]`);
                    if (input) {
                        if (input.type === 'checkbox') {
                            input.checked = value === '1';
                        } else if (input.type === 'radio') {
                            const radio = form.querySelector(`[name="${key}"][value="${value}"]`);
                            if (radio) radio.checked = true;
                        } else {
                            input.value = value;
                        }
                    }
                    
                    // Handle select elements
                    const select = form.querySelector(`select[name="${key}"]`);
                    if (select) {
                        select.value = value;
                    }
                }
                
                // Trigger any change events for dynamic elements
                triggerChangeEvents();
            }
        }

        function triggerChangeEvents() {
            // Trigger change events for radio buttons that might show/hide fields
            const radios = document.querySelectorAll('input[type="radio"]:checked');
            radios.forEach(radio => {
                radio.dispatchEvent(new Event('change', { bubbles: true }));
            });
        }

        function validateAndProceed() {
            const currentStep = '{{ $currentStep }}';
            
            // Remove any existing error highlights
            document.querySelectorAll('.border-red-500').forEach(el => {
                el.classList.remove('border-red-500');
            });
            document.querySelectorAll('.error-highlight').forEach(el => {
                el.classList.remove('border', 'border-red-500', 'p-2', 'rounded', 'error-highlight');
            });

            let validationResult = { isValid: true, errors: [] };

            // Step-specific validation
            switch(currentStep) {
                case 'learner':
                    validationResult = validateLearnerStep();
                    break;
                case 'address':
                    validationResult = validateAddressStep();
                    break;
                case 'guardian':
                    validationResult = validateGuardianStep();
                    break;
                case 'school':
                    validationResult = validateSchoolStep();
                    break;
                default:
                    validationResult = { isValid: true, errors: [] };
            }

            if (validationResult.isValid) {
                // Save data before navigating
                saveFormData();
                navigateStep('next');
            } else {
                showValidationErrors(validationResult.errors);
            }
        }

        function showValidationErrors(errors) {
            let errorMessage = 'Please fix the following errors before proceeding:\n\n';
            errors.forEach((error, index) => {
                errorMessage += `${index + 1}. ${error.message}\n`;
            });
            
            alert(errorMessage);
            
            // Scroll to first error
            if (errors.length > 0 && errors[0].element) {
                errors[0].element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                errors[0].element.focus();
            }
        }

        function validateLearnerStep() {
            let isValid = true;
            const errors = [];

            // Required fields for learner information
            const requiredFields = [
                { name: 'lrn', label: 'Learner Reference Number (LRN)' },
                { name: 'first_name', label: 'First Name' },
                { name: 'last_name', label: 'Last Name' },
                { name: 'birthdate', label: 'Birthdate' },
                { name: 'gender', label: 'Gender' },
                { name: 'age', label: 'Age' }
            ];

            requiredFields.forEach(field => {
                const element = document.querySelector(`[name="${field.name}"]`);
                if (element && !element.value.trim()) {
                    isValid = false;
                    element.classList.add('border-red-500');
                    errors.push({ 
                        message: `${field.label} is required`,
                        element: element
                    });
                }
            });

            // Radio button groups
            const radioGroups = [
                { name: 'with_lrn', label: 'With LRN?' },
                { name: 'returning', label: 'Returning Student (Balik-Aral)' },
                { name: 'ip_community_member', label: 'IP Community Member' },
                { name: '4ps_beneficiary', label: '4Ps Beneficiary' },
                { name: 'is_disabled', label: 'Has Disability' }
            ];
            
            radioGroups.forEach(group => {
                const radios = document.querySelectorAll(`input[name="${group.name}"]`);
                const isChecked = Array.from(radios).some(radio => radio.checked);
                if (!isChecked) {
                    isValid = false;
                    // Highlight the radio group
                    if (radios[0]) {
                        const radioContainer = radios[0].closest('.flex');
                        if (radioContainer) {
                            radioContainer.classList.add('border', 'border-red-500', 'p-2', 'rounded', 'error-highlight');
                            errors.push({ 
                                message: `${group.label} is required`,
                                element: radioContainer
                            });
                        }
                    }
                }
            });

            // Conditional validation for IP community
            const ipCommunityRadio = document.querySelector('input[name="ip_community_member"]:checked');
            if (ipCommunityRadio && ipCommunityRadio.value === '1') {
                const ipCommunity = document.getElementById('ip_community');
                if (!ipCommunity.value.trim()) {
                    isValid = false;
                    ipCommunity.classList.add('border-red-500');
                    errors.push({ 
                        message: 'IP Community specification is required when "Yes" is selected for IP Community Member',
                        element: ipCommunity
                    });
                }
            }

            // Conditional validation for 4Ps
            const fourPsRadio = document.querySelector('input[name="4ps_beneficiary"]:checked');
            if (fourPsRadio && fourPsRadio.value === '1') {
                const householdId = document.getElementById('4ps_household_id');
                if (!householdId.value.trim()) {
                    isValid = false;
                    householdId.classList.add('border-red-500');
                    errors.push({ 
                        message: '4Ps Household ID is required when "Yes" is selected for 4Ps Beneficiary',
                        element: householdId
                    });
                }
            }

            return { isValid, errors };
        }

        function validateAddressStep() {
            let isValid = true;
            const errors = [];
            
            // Current address fields
            const currentAddressFields = [
                { name: 'house_number', label: 'House Number' },
                { name: 'street_name', label: 'Street Name' },
                { name: 'barangay', label: 'Barangay' },
                { name: 'city', label: 'Municipality/City' },
                { name: 'province', label: 'Province' },
                { name: 'country', label: 'Country' },
                { name: 'zip_code', label: 'Zip Code' }
            ];
            
            currentAddressFields.forEach(field => {
                const element = document.querySelector(`[name="${field.name}"]`);
                if (element && !element.value.trim()) {
                    isValid = false;
                    element.classList.add('border-red-500');
                    errors.push({ 
                        message: `Current Address - ${field.label} is required`,
                        element: element
                    });
                }
            });

            // Permanent address (only validate if not same as current)
            const sameAsCurrent = document.querySelector('input[name="same_as_current_address"]:checked');
            if (!sameAsCurrent) {
                isValid = false;
                errors.push({ 
                    message: 'Please specify if permanent address is same as current address',
                    element: document.querySelector('input[name="same_as_current_address"]')
                });
            } else if (sameAsCurrent.value === '0') {
                const permanentFields = [
                    { name: 'permanent_house_number', label: 'Permanent House Number' },
                    { name: 'permanent_street_name', label: 'Permanent Street Name' },
                    { name: 'permanent_barangay', label: 'Permanent Barangay' },
                    { name: 'permanent_city', label: 'Permanent Municipality/City' },
                    { name: 'permanent_province', label: 'Permanent Province' },
                    { name: 'permanent_country', label: 'Permanent Country' },
                    { name: 'permanent_zip_code', label: 'Permanent Zip Code' }
                ];
                
                permanentFields.forEach(field => {
                    const element = document.querySelector(`[name="${field.name}"]`);
                    if (element && !element.value.trim()) {
                        isValid = false;
                        element.classList.add('border-red-500');
                        errors.push({ 
                            message: `Permanent Address - ${field.label} is required`,
                            element: element
                        });
                    }
                });
            }

            return { isValid, errors };
        }


        function validateGuardianStep() {
            let isValid = true;
            const errors = [];
            
            // Father's information
            const fatherFields = [
                { name: 'father_last_name', label: "Father's Last Name" },
                { name: 'father_first_name', label: "Father's First Name" },
                { name: 'father_contact_number', label: "Father's Contact Number" }
            ];
            
            fatherFields.forEach(field => {
                const element = document.querySelector(`[name="${field.name}"]`);
                if (element && !element.value.trim()) {
                    isValid = false;
                    element.classList.add('border-red-500');
                    errors.push({ 
                        message: `${field.label} is required`,
                        element: element
                    });
                }
            });

            // Mother's information  
            const motherFields = [
                { name: 'mother_last_name', label: "Mother's Last Name" },
                { name: 'mother_first_name', label: "Mother's First Name" },
                { name: 'mother_contact_number', label: "Mother's Contact Number" }
            ];
            
            motherFields.forEach(field => {
                const element = document.querySelector(`[name="${field.name}"]`);
                if (element && !element.value.trim()) {
                    isValid = false;
                    element.classList.add('border-red-500');
                    errors.push({ 
                        message: `${field.label} is required`,
                        element: element
                    });
                }
            });

            return { isValid, errors };
        }

        function validateSchoolStep() {
            // School step is optional for transferees, so no validation needed
            return { isValid: true, errors: [] };
        }

        function submitEnrollment() {
            // Save final data before submission
            saveFormData();
            document.getElementById('enrollment-form').submit();
        }

        // Remove error styling when user interacts with fields
        document.addEventListener('DOMContentLoaded', function() {
            // Load form data from session storage
            loadFormData();

            document.querySelectorAll('input, select').forEach(element => {
                element.addEventListener('input', function() {
                    this.classList.remove('border-red-500');
                });
            });

            // For radio groups, remove highlighting when any radio is clicked
            document.querySelectorAll('input[type="radio"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    const radioGroup = document.querySelectorAll(`[name="${this.name}"]`);
                    radioGroup.forEach(r => {
                        r.closest('.flex')?.classList.remove('border', 'border-red-500', 'p-2', 'rounded');
                    });
                });
            });
        });
    </script>
    @endpush
</x-app-layout>