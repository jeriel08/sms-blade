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
                    value="{{ $formData['school_year'] ?? '' }}" 
                    readonly 
                />
            </div>
        </div>
        <div class="flex flex-col gap-4 border border-1 p-4 rounded-md">
            <p>Check the appropriate box only</p>

            {{-- For With LRN --}}
            <div class="flex align-items-center justify-content-start gap-4">
                <x-input-label for="with_lrn" value="1. With LRN?" />
                <div class="flex align-items-center justify-start gap-2">
                    <input 
                        id="with_lrn" 
                        name="with_lrn" 
                        type="radio" 
                        value="1"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        {{ isset($formData['with_lrn']) && $formData['with_lrn'] == '1' ? 'checked' : '' }}>
                    <x-input-label for="with_lrn" value="Yes" />
                </div>
                <div class="flex align-items-center justify-start gap-2">
                    <input 
                        id="without_lrn" 
                        name="with_lrn" 
                        type="radio" 
                        value="0"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        {{ isset($formData['with_lrn']) && $formData['with_lrn'] == '0' ? 'checked' : '' }}>
                    <x-input-label for="without_lrn" value="No" />
                </div>
            </div>

            {{-- For Returning --}}
            <div class="flex align-items-center justify-content-start gap-4">
                <x-input-label for="balik-aral" value="2. Returning (Balik-Aral)" />
                <div class="flex align-items-center justify-start gap-2">
                    <input 
                        id="returning_yes" 
                        name="returning" 
                        type="radio" 
                        value="1"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        {{ isset($formData['returning']) && $formData['returning'] == '1' ? 'checked' : '' }}>
                    <x-input-label for="returning_yes" value="Yes" />
                </div>
                <div class="flex align-items-center justify-start gap-2">
                    <input 
                        id="returning_no" 
                        name="returning" 
                        type="radio" 
                        value="0"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        {{ isset($formData['returning']) && $formData['returning'] == '0' ? 'checked' : '' }}>
                    <x-input-label for="returning_no" value="No" />
                </div>
            </div>
        </div>
    </div>

    <hr class="my-8">

    <div class="min-w-auto bg-2 text-center rounded-lg mb-6 opacity-50">
        <h3 class="text-md font-bold text-white mx-auto">LEARNER INFORMATION</h3>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <strong class="font-bold">Errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
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
                    value="{{ $formData['psa_birth_certification_no'] ?? '' }}"
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
                    value="{{ $formData['lrn'] ?? '' }}"
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
                    value="{{ $formData['first_name'] ?? '' }}"
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
                    value="{{ $formData['birthdate'] ?? '' }}"
                />
            </div>
            
            <div>
                <x-input-label for="place_of_birth" value="Place of Birth" />
                <x-text-input 
                    id="place_of_birth" 
                    name="place_of_birth" 
                    type="text" 
                    class="mt-1 block w-full" 
                    value="{{ $formData['place_of_birth'] ?? '' }}"
                    placeholder="Enter place of birth"
                />
            </div>
        </div>

        {{-- Third Row --}}
        <div class="flex justify-start align-items-center gap-6 mb-6">
            {{-- Last Name --}}
           <div>
                <x-input-label for="last_name" value="Last Name" important />
                <x-text-input 
                    id="last_name" 
                    name="last_name" 
                    type="text" 
                    class="mt-1 block w-full" 
                    value="{{ $formData['last_name'] ?? '' }}"
                    placeholder="Enter last name"
                />
            </div>

            {{-- Gender --}}
            <div>
                <x-input-label for="gender" value="Gender" important />
                <select 
                    id="gender" 
                    name="gender"
                    class="mt-1 block w-4xs border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-xs cursor-pointer"
                >
                    <option value="">Select Gender</option>
                    <option value="male" {{ isset($formData['gender']) && $formData['gender'] == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ isset($formData['gender']) && $formData['gender'] == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            {{-- Age --}}
            <div>
                <x-input-label for="age" value="Age" important />
                <x-text-input 
                    id="age" 
                    name="age" 
                    type="number"
                    class="mt-1 block w-full" 
                    value="{{ $formData['age'] ?? '' }}"
                    placeholder="Enter age"
                />
            </div>

            {{-- Mother Tongue --}}
            <div>
                <x-input-label for="mother_tongue" value="Mother Tongue" />
                <x-text-input 
                    id="mother_tongue" 
                    name="mother_tongue" 
                    type="text" 
                    class="mt-1 block w-full" 
                    value="{{ $formData['mother_tongue'] ?? '' }}"
                    placeholder="Enter mother tongue"
                />
            </div>
        </div>

        {{-- Fourth Row --}}
        <div class="flex items-start gap-6 mb-6">
            {{-- Middle Name --}}
            <div>
                <x-input-label for="middle_name" value="Middle Name" />
                <x-text-input 
                    id="middle_name" 
                    name="middle_name" 
                    type="text" 
                    class="mt-1 block w-full" 
                    value="{{ $formData['middle_name'] ?? '' }}"
                    placeholder="Enter middle name"
                />
            </div>
            
            {{-- IP Community --}}
            <div class="flex-1">
                <x-input-label for="ip_community_member" value="Belonging to any Indigenous Peoples (IP) Community/Indigenous Cultural Community" />
                <div class="flex items-center gap-4 mt-1">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <input 
                                id="ip_yes" 
                                name="ip_community_member" 
                                type="radio" 
                                value="1"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ isset($formData['ip_community_member']) && $formData['ip_community_member'] == '1' ? 'checked' : '' }}>
                            <x-input-label for="ip_yes" value="Yes" class="mb-0" />
                        </div>
                        <div class="flex items-center gap-2">
                            <input 
                                id="ip_no" 
                                name="ip_community_member" 
                                type="radio" 
                                value="0"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ isset($formData['ip_community_member']) && $formData['ip_community_member'] == '0' ? 'checked' : '' }}>
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
                            value="{{ $formData['ip_community'] ?? '' }}"
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
                    value="{{ $formData['extension_name'] ?? '' }}"
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
                                    value="1"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                    {{ isset($formData['4ps_beneficiary']) && $formData['4ps_beneficiary'] == '1' ? 'checked' : '' }}>
                                <x-input-label for="4ps_yes" value="Yes" class="mb-0" />
                            </div>
                            <div class="flex items-center gap-4">
                                <input 
                                    id="4ps_no" 
                                    name="4ps_beneficiary" 
                                    type="radio" 
                                    value="0"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                    {{ isset($formData['4ps_beneficiary']) && $formData['4ps_beneficiary'] == '0' ? 'checked' : '' }}>
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
                        value="{{ $formData['4ps_household_id'] ?? '' }}"
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
                        value="1"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        {{ isset($formData['is_disabled']) && $formData['is_disabled'] == '1' ? 'checked' : '' }}>
                    <x-input-label for="is_disabled_yes" value="Yes" />
                </div>
                <div class="flex align-items-center justify-start gap-2">
                    <input 
                        id="is_disabled_no" 
                        name="is_disabled" 
                        type="radio" 
                        value="0"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        {{ isset($formData['is_disabled']) && $formData['is_disabled'] == '0' ? 'checked' : '' }}>
                    <x-input-label for="is_disabled_no" value="No" />
                </div>
            </div>

            <x-input-label class="mt-4" value="If Yes, specify the type of disability:" />
            
            @if(isset($disabilities) && $disabilities->count() > 0)
                @php
                    // Calculate how many items per column (divide by 3)
                    $totalDisabilities = $disabilities->count();
                    $itemsPerColumn = ceil($totalDisabilities / 3);
                    $chunkedDisabilities = $disabilities->chunk($itemsPerColumn);
                @endphp

                <div class="flex justify-between gap-10 mt-4">
                    @foreach($chunkedDisabilities as $columnDisabilities)
                        <div class="flex flex-col gap-4">
                            @foreach($columnDisabilities as $disability)
                                <div class="flex align-items-center justify-start gap-2">
                                    <input 
                                        id="disability_{{ $disability->disability_id }}" 
                                        name="disabilities[{{ $disability->disability_id }}]" 
                                        type="checkbox" 
                                        value="1"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded disability-checkbox"
                                        {{ in_array($disability->disability_id, $formData['disabilities'] ?? []) ? 'checked' : '' }}>
                                    <x-input-label for="disability_{{ $disability->disability_id }}" value="{{ $disability->name }}" />
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @else
                <div class="mt-4 text-gray-500">
                    No disabilities configured in the system. Please contact administrator.
                </div>
            @endif
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
            function toggleCheckboxes(radioGroupName, enableValue) {
                const radios = document.querySelectorAll(`input[name="${radioGroupName}"]`);
                const checkboxes = document.querySelectorAll('.disability-checkbox');

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
            toggleTextInput('with_lrn', 'lrn', '1');
            toggleTextInput('ip_community_member', 'ip_community', '1');
            toggleTextInput('4ps_beneficiary', '4ps_household_id', '1');
            toggleCheckboxes('is_disabled', '1');
        });
    </script>
</div>