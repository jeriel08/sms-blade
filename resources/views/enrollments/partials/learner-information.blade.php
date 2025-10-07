{{-- resources/views/enrollments/partials/learner-information.blade.php --}}
<div>

    {{-- Header Part --}}
    <div class="flex justify-between items-center mb-4">
        <div class="flex align-items-center justify-start gap-4">
            <div class="flex flex-col align-items-center justify-start">
                <x-input-label for="school_year" value="School Year" />
                <x-text-input 
                    id="school_year" 
                    name="school_year" 
                    type="text" 
                    class="mt-1 block bg-gray-100 cursor-not-allowed" 
                    value="2025-2026" 
                    readonly 
                />
            </div>
        </div>
        <div class="flex flex-col gap-4 border border-1 p-4 rounded-md">
            <p>Check the appropriate box only</p>
            <div class="flex align-items-center justify-content-start gap-4">
                <x-input-label for="with_lrn" value="1. With LRN?" />
                <div class="flex align-items-center justify-start gap-2">
                    <input 
                        id="with_lrn" 
                        name="with_lrn" 
                        type="radio" 
                        value="yes"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        {{ old('with_lrn') == 'yes' ? 'checked' : '' }}>
                    <x-input-label for="with_lrn" value="Yes" />
                </div>
                <div class="flex align-items-center justify-start gap-2">
                    <input 
                        id="without_lrn" 
                        name="with_lrn" 
                        type="radio" 
                        value="no"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        {{ old('with_lrn') == 'no' ? 'checked' : '' }}>
                    <x-input-label for="without_lrn" value="No" />
                </div>
            </div>
            <div class="flex align-items-center justify-content-start gap-4">
                <x-input-label for="balik-aral" value="2. Returning (Balik-Aral)" />
                <div class="flex align-items-center justify-start gap-2">
                    <input 
                        id="returning_yes" 
                        name="returning" 
                        type="radio" 
                        value="yes"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        {{ old('returning') == 'yes' ? 'checked' : '' }}>
                    <x-input-label for="returning_yes" value="Yes" />
                </div>
                <div class="flex align-items-center justify-start gap-2">
                    <input 
                        id="returning_no" 
                        name="returning" 
                        type="radio" 
                        value="no"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        {{ old('returning') == 'no' ? 'checked' : '' }}>
                    <x-input-label for="returning_no" value="No" />
                </div>
            </div>
        </div>
    </div>

    <hr class="my-8">

    <div class="min-w-auto bg-2 text-center rounded-lg mb-6 opacity-50">
        <h3 class="text-md font-bold text-white mx-auto">LEARNER INFORMATION</h3>
    </div>
    
    <div class="space-y-6">
        {{-- First Row --}}
        <div class="flex justify-between align-items-center gap-6 mb-6">
            <div>
                <x-input-label for="psa_birth_certification_no" value="PSA Birth Certification No. (If available upon registration)" />
                <x-text-input 
                    id="psa_birth_certification_no" 
                    name="psa_birth_certification_no" 
                    type="text" 
                    class="mt-1 block w-sm" 
                    value="{{ old('psa_birth_certification_no') }}"
                    maxlength="12"
                    placeholder="Enter PSA Birth Certificate No."
                />
            </div>
            <div>
                <x-input-label for="lrn" value="Learner Reference Number (LRN)" important />
                <x-text-input 
                    id="lrn" 
                    name="lrn" 
                    type="text" 
                    class="mt-1 block w-sm" 
                    value="{{ old('lrn') }}"
                    maxlength="12"
                    placeholder="12-digit LRN"
                />
            </div>
        </div>

        {{-- Second Row --}}
        <div class="flex justify-start align-items-center gap-6 mb-6">
            <div>
                <x-input-label for="first_name" value="First Name" important />
                <x-text-input 
                    id="first_name" 
                    name="first_name" 
                    type="text" 
                    class="mt-1 block w-full" 
                    value="{{ old('first_name') }}"
                    placeholder="Enter first name"
                />
            </div>
            
            <div>
                <x-input-label for="birthdate" value="Birthdate" important />
                <x-text-input 
                    id="birthdate" 
                    name="birthdate" 
                    type="date" 
                    class="mt-1 block w-full" 
                    value="{{ old('birthdate') }}"
                />
            </div>
            
            <div>
                <x-input-label for="place_of_birth" value="Place of Birth" />
                <x-text-input 
                    id="place_of_birth" 
                    name="place_of_birth" 
                    type="text" 
                    class="mt-1 block w-full" 
                    value="{{ old('place_of_birth') }}"
                    placeholder="Enter place of birth"
                />
            </div>
        </div>

        {{-- Third Row --}}
        <div class="flex justify-start align-items-center gap-6 mb-6">
           <div>
                <x-input-label for="last_name" value="Last Name" important />
                <x-text-input 
                    id="last_name" 
                    name="last_name" 
                    type="text" 
                    class="mt-1 block w-full" 
                    value="{{ old('last_name') }}"
                    placeholder="Enter last name"
                />
            </div>

             <div>
                <x-input-label for="gender" value="Gender" important />
                <select 
                    id="gender" 
                    name="gender"
                    class="mt-1 block w-4xs border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-xs cursor-pointer"
                >
                    <option value="">Select Gender</option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div>
                <x-input-label for="age" value="Age" important />
                <x-text-input 
                    id="age" 
                    name="age" 
                    type="number"
                    class="mt-1 block w-full" 
                    value="{{ old('age') }}"
                    placeholder="Enter age"
                />
            </div>

            <div>
                <x-input-label for="mother_tounge" value="Mother Tounge" />
                <x-text-input 
                    id="mother_tounge" 
                    name="mother_tounge" 
                    type="text" 
                    class="mt-1 block w-full" 
                    value="{{ old('mother_tounge') }}"
                    placeholder="Enter mother tounge"
                />
            </div>
        </div>

        {{-- Fourth Row --}}
        <div class="flex items-start gap-6 mb-6">
            <div>
                <x-input-label for="middle_name" value="Middle Name" />
                <x-text-input 
                    id="middle_name" 
                    name="middle_name" 
                    type="text" 
                    class="mt-1 block w-full" 
                    value="{{ old('middle_name') }}"
                    placeholder="Enter middle name"
                />
            </div>
            
            <div class="flex-1">
                <x-input-label for="ip_community_member" value="Belonging to any Indigenous Peoples (IP) Community/Indigenous Cultural Community" />
                <div class="flex items-center gap-4 mt-1">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <input 
                                id="ip_yes" 
                                name="ip_community_member" 
                                type="radio" 
                                value="yes"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('ip_community_member') == 'yes' ? 'checked' : '' }}>
                            <x-input-label for="ip_yes" value="Yes" class="mb-0" />
                        </div>
                        <div class="flex items-center gap-2">
                            <input 
                                id="ip_no" 
                                name="ip_community_member" 
                                type="radio" 
                                value="no"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('ip_community_member') == 'no' ? 'checked' : '' }}>
                            <x-input-label for="ip_no" value="No" class="mb-0" />
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <x-input-label for="ip_community" value="If Yes, please specify:" class="whitespace-nowrap mb-0" />
                        <x-text-input 
                            id="ip_community" 
                            name="ip_community" 
                            type="text" 
                            class="block w-xs" 
                            value="{{ old('ip_community') }}"
                            placeholder="Specify IP Community"
                        />
                    </div>
                </div>
            </div>
        </div>

        {{-- Fifth Row --}}
        <div class="flex items-start gap-6 mb-6">
            <div>
                <x-input-label for="extension_name" value="Extension Name (e.g. Jr, III)" />
                <x-text-input 
                    id="extension_name" 
                    name="extension_name" 
                    type="text" 
                    class="mt-1 block w-full" 
                    value="{{ old('extension_name') }}"
                    placeholder="Enter extension name"
                />
            </div>

            <div class="flex-1 flex align-items-center justify-start gap-6">
                <div>
                    <x-input-label for="4ps_beneficiary" value="Is your family a beneficiary of 4Ps?" />
                    <div class="flex align-items-center justify-start gap-6 mt-3">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-2">
                                <input 
                                    id="4ps_yes" 
                                    name="4ps_beneficiary" 
                                    type="radio" 
                                    value="yes"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                    {{ old('4ps_beneficiary') == 'yes' ? 'checked' : '' }}>
                                <x-input-label for="4ps_yes" value="Yes" class="mb-0" />
                            </div>
                            <div class="flex items-center gap-4">
                                <input 
                                    id="4ps_no" 
                                    name="4ps_beneficiary" 
                                    type="radio" 
                                    value="no"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                    {{ old('4ps_beneficiary') == 'no' ? 'checked' : '' }}>
                                <x-input-label for="4ps_no" value="No" class="mb-0" />
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <x-input-label for="4ps_household_id" value="If Yes, write the 4Ps Household ID Number below" />
                    <x-text-input 
                        id="4ps_household_id" 
                        name="4ps_household_id" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('4ps_household_id') }}"
                        placeholder="Enter 4Ps Household ID Number"
                    />
                </div>
            </div>
            
            
        </div>

        {{-- Disability --}}
        <div class="border border-1 p-4 rounded-sm">
            <div class="flex align-items-center justify-content-start gap-4">
                <x-input-label for="is_disabled" value="Is the child a Learner with a Disability?" />
                <div class="flex align-items-center justify-start gap-2">
                    <input 
                        id="is_disabled_yes" 
                        name="is_disabled" 
                        type="radio" 
                        value="yes"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        {{ old('is_disabled') == 'yes' ? 'checked' : '' }}>
                    <x-input-label for="is_disabled_yes" value="Yes" />
                </div>
                <div class="flex align-items-center justify-start gap-2">
                    <input 
                        id="is_disabled_no" 
                        name="is_disabled" 
                        type="radio" 
                        value="no"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        {{ old('is_disabled') == 'no' ? 'checked' : '' }}>
                    <x-input-label for="is_disabled_no" value="No" />
                </div>
            </div>

            <x-input-label class="mt-4" value="If Yes, specify the type of disability:" />
            <div class="flex justify-between gap-10 mt-4">
                {{-- Column 1 --}}
                <div class="flex justify-content-between align-items-start gap-6 mt-4">
                    <div class="flex flex-col gap-4">
                        <div class="flex align-items-center justify-start gap-2">
                            <input 
                                id="disability_visual_blind" 
                                name="disability_visual_blind" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('disability_visual_blind') ? 'checked' : '' }}>
                            <x-input-label for="disability_visual_blind" value="Visual Impairment (Blind)" />
                        </div>
                        <div class="flex align-items-center justify-start gap-2">
                            <input 
                                id="disability_visual_low_vision" 
                                name="disability_visual_low_vision" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('disability_visual_low_vision') ? 'checked' : '' }}>
                            <x-input-label for="disability_visual_low_vision" value="Visual Impairment (Low Vision)" />
                        </div>
                        <div class="flex align-items-center justify-start gap-2">
                            <input 
                                id="disability_multiple_disorder" 
                                name="disability_multiple_disorder" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('disability_multiple_disorder') ? 'checked' : '' }}>
                            <x-input-label for="disability_multiple_disorder" value="Multiple Disorder" />
                        </div>
                    </div>
                </div>
    
                {{-- Column 2 --}}
                <div class="flex justify-content-between align-items-start gap-6 mt-4">
                    <div class="flex flex-col gap-4">
                        <div class="flex align-items-center justify-start gap-2">
                            <input 
                                id="disability_hearing_impairment" 
                                name="disability_hearing_impairment" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('disability_hearing_impairment') ? 'checked' : '' }}>
                            <x-input-label for="disability_hearing_impairment" value="Hearing Impairment" />
                        </div>
                        <div class="flex align-items-center justify-start gap-2">
                            <input 
                                id="disability_autism_spectrum" 
                                name="disability_autism_spectrum" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('disability_autism_spectrum') ? 'checked' : '' }}>
                            <x-input-label for="disability_autism_spectrum" value="Autism Spectrum Disorder" />
                        </div>
                        <div class="flex align-items-center justify-start gap-2">
                            <input 
                                id="disability_speech_language" 
                                name="disability_speech_language" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('disability_speech_language') ? 'checked' : '' }}>
                            <x-input-label for="disability_speech_language" value="Speech/Language Disorder" />
                        </div>
                        <div class="flex align-items-center justify-start gap-2">
                            <input 
                                id="disability_learning" 
                                name="disability_learning" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('disability_learning') ? 'checked' : '' }}>
                            <x-input-label for="disability_learning" value="Learning Disability" />
                        </div>
                        <div class="flex align-items-center justify-start gap-2">
                            <input 
                                id="disability_emotional_behavioral" 
                                name="disability_emotional_behavioral" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('disability_emotional_behavioral') ? 'checked' : '' }}>
                            <x-input-label for="disability_emotional_behavioral" value="Emotional-Behavioral Disorder" />
                        </div>
                    </div>
                </div>
    
                {{-- Column 3 --}}
                <div class="flex justify-content-between align-items-start gap-6 mt-4">
                    <div class="flex flex-col gap-4">
                        <div class="flex align-items-center justify-start gap-2">
                            <input 
                                id="disability_cerebral_palsy" 
                                name="disability_cerebral_palsy" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('disability_cerebral_palsy') ? 'checked' : '' }}>
                            <x-input-label for="disability_cerebral_palsy" value="Cerebral Palsy" />
                        </div>
                        <div class="flex align-items-center justify-start gap-2">
                            <input 
                                id="disability_intellectual" 
                                name="disability_intellectual" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('disability_intellectual') ? 'checked' : '' }}>
                            <x-input-label for="disability_intellectual" value="Intellectual Disability" />
                        </div>
                        <div class="flex align-items-center justify-start gap-2">
                            <input 
                                id="disability_orthopedic" 
                                name="disability_orthopedic" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('disability_orthopedic') ? 'checked' : '' }}>
                            <x-input-label for="disability_orthopedic" value="Orthopedic/Physical Handicap" />
                        </div>
                        <div class="flex align-items-center justify-start gap-2">
                            <input 
                                id="disability_special_health" 
                                name="disability_special_health" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('disability_special_health') ? 'checked' : '' }}>
                            <x-input-label for="disability_special_health" value="Special Health Problem / Chronic Disease" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @include('components.step-navigation')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to toggle text input state
            function toggleTextInput(radioGroupName, targetInputId, enableValue) {
                const radios = document.querySelectorAll(`input[name="${radioGroupName}"]`);
                const targetInput = document.getElementById(targetInputId);

                function updateState() {
                    const isEnabled = Array.from(radios).some(radio => radio.checked && radio.value === enableValue);
                    targetInput.disabled = !isEnabled;
                    if (!isEnabled) {
                        targetInput.value = ''; // Clear value when disabled
                    }
                }

                // Listen for changes
                radios.forEach(radio => radio.addEventListener('change', updateState));
                // Initial state
                updateState();
            }

            // Function to toggle checkbox states (for disabilities)
            function toggleCheckboxes(radioGroupName, enableValue, checkboxSelector) {
                const radios = document.querySelectorAll(`input[name="${radioGroupName}"]`);
                const checkboxes = document.querySelectorAll(checkboxSelector);

                function updateState() {
                    const isEnabled = Array.from(radios).some(radio => radio.checked && radio.value === enableValue);
                    checkboxes.forEach(checkbox => {
                        checkbox.disabled = !isEnabled;
                        if (!isEnabled) {
                            checkbox.checked = false; // Uncheck when disabled
                        }
                    });
                }

                // Listen for changes
                radios.forEach(radio => radio.addEventListener('change', updateState));
                // Initial state
                updateState();
            }

            // Apply to each radio group
            toggleTextInput('with_lrn', 'lrn', 'yes');
            toggleTextInput('ip_community_member', 'ip_community', 'yes');
            toggleTextInput('4ps_beneficiary', '4ps_household_id', 'yes');
            toggleCheckboxes('is_disabled', 'yes', 'input[name^="disability_"]');
        });
    </script>
</div>