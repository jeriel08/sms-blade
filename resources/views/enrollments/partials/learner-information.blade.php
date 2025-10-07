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
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        {{ old('with_lrn') ? 'checked' : '' }}>
                    <x-input-label for="with_lrn" value="Yes" />
                </div>
                <div class="flex align-items-center justify-start gap-2">
                    <input 
                        id="without_lrn" 
                        name="with_lrn" 
                        type="radio" 
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        {{ old('without_lrn') ? 'checked' : '' }}>
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
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        {{ old('returning_yes') ? 'checked' : '' }}>
                    <x-input-label for="returning_yes" value="Yes" />
                </div>
                <div class="flex align-items-center justify-start gap-2">
                    <input 
                        id="returning_no" 
                        name="returning" 
                        type="radio" 
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        {{ old('returning_no') ? 'checked' : '' }}>
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
                    value="{{ old('psn_birth_certification_no') }}"
                    maxlength="12"
                    placeholder="Enter PSA Birth Certificate No."
                />
            </div>
            <div>
                <x-input-label for="lrn" value="Learner Reference Number (LRN)" />
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
                <x-input-label for="first_name" value="First Name" />
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
                <x-input-label for="birthdate" value="Birthdate" />
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
                <x-input-label for="last_name" value="Last Name" />
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
                <x-input-label for="gender" value="Gender" />
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
                <x-input-label for="age" value="Age" />
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
                                value="1"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('ip_community_member') == 'yes' ? 'checked' : '' }}>
                            <x-input-label for="ip_yes" value="Yes" class="mb-0" />
                        </div>
                        <div class="flex items-center gap-2">
                            <input 
                                id="ip_no" 
                                name="ip_community_member" 
                                type="radio" 
                                value="0"
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
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        {{ old('is_disabled_yes') ? 'checked' : '' }}>
                    <x-input-label for="is_disabled_yes" value="Yes" />
                </div>
                <div class="flex align-items-center justify-start gap-2">
                    <input 
                        id="is_disabled_no" 
                        name="is_disabled" 
                        type="radio" 
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        {{ old('is_disabled_no') ? 'checked' : '' }}>
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
                                id="visual_impairment_blind" 
                                name="visual_impairment_blind" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('visual_impairment_blind') ? 'checked' : '' }}>
                            <x-input-label for="visual_impairment_blind" value="Visual Impairment (Blind)" />
                        </div>
                        <div class="flex align-items-center justify-start gap-2">
                            <input 
                                id="visual_impairment_low_vision" 
                                name="visual_impairment_low_vision" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('visual_impairment_low_vision') ? 'checked' : '' }}>
                            <x-input-label for="visual_impairment_low_vision" value="Visual Impairment (Low Vision)" />
                        </div>
                        <div class="flex align-items-center justify-start gap-2">
                            <input 
                                id="multiple_disorder" 
                                name="multiple_disorder" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('multiple_disorder') ? 'checked' : '' }}>
                            <x-input-label for="multiple_disorder" value="Multiple Disorder" />
                        </div>
                    </div>
                </div>
    
                {{-- Column 2 --}}
                <div class="flex justify-content-between align-items-start gap-6 mt-4">
                    <div class="flex flex-col gap-4">
                        <div class="flex align-items-center justify-start gap-2">
                            <input 
                                id="visual_impairment_blind" 
                                name="visual_impairment_blind" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('visual_impairment_blind') ? 'checked' : '' }}>
                            <x-input-label for="visual_impairment_blind" value="Hearing Impairment" />
                        </div>
                        <div class="flex align-items-center justify-start gap-2">
                            <input 
                                id="visual_impairment_low_vision" 
                                name="visual_impairment_low_vision" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('visual_impairment_low_vision') ? 'checked' : '' }}>
                            <x-input-label for="visual_impairment_low_vision" value="Autism Spectrum Disorder" />
                        </div>
                        <div class="flex align-items-center justify-start gap-2">
                            <input 
                                id="multiple_disorder" 
                                name="multiple_disorder" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('multiple_disorder') ? 'checked' : '' }}>
                            <x-input-label for="multiple_disorder" value="Speech/Language Disorder" />
                        </div>
                        <div class="flex align-items-center justify-start gap-2">
                            <input 
                                id="multiple_disorder" 
                                name="multiple_disorder" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('multiple_disorder') ? 'checked' : '' }}>
                            <x-input-label for="multiple_disorder" value="Learning Disability" />
                        </div>
                        <div class="flex align-items-center justify-start gap-2">
                            <input 
                                id="multiple_disorder" 
                                name="multiple_disorder" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('multiple_disorder') ? 'checked' : '' }}>
                            <x-input-label for="multiple_disorder" value="Emotional-Behavioral Disorder" />
                        </div>
                    </div>
                </div>
    
                {{-- Column 3 --}}
                <div class="flex justify-content-between align-items-start gap-6 mt-4">
                    <div class="flex flex-col gap-4">
                        <div class="flex align-items-center justify-start gap-2">
                            <input 
                                id="visual_impairment_blind" 
                                name="visual_impairment_blind" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('visual_impairment_blind') ? 'checked' : '' }}>
                            <x-input-label for="visual_impairment_blind" value="Cerebral Palsy" />
                        </div>
                        <div class="flex align-items-center justify-start gap-2">
                            <input 
                                id="visual_impairment_low_vision" 
                                name="visual_impairment_low_vision" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('visual_impairment_low_vision') ? 'checked' : '' }}>
                            <x-input-label for="visual_impairment_low_vision" value="Intellectual Disability" />
                        </div>
                        <div class="flex align-items-center justify-start gap-2">
                            <input 
                                id="multiple_disorder" 
                                name="multiple_disorder" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('multiple_disorder') ? 'checked' : '' }}>
                            <x-input-label for="multiple_disorder" value="Orthopedic/Physical Handicap" />
                        </div>
                        <div class="flex align-items-center justify-start gap-2">
                            <input 
                                id="multiple_disorder" 
                                name="multiple_disorder" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('multiple_disorder') ? 'checked' : '' }}>
                            <x-input-label for="multiple_disorder" value="Special Health Problem / Chronic Disease" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @include('components.step-navigation')
</div>