{{-- resources/views/enrollments/partials/school-information.blade.php --}}
<div>
    <h3 class="text-lg font-medium text-gray-900 mb-6">Recent School Information</h3>
    
    <div class="space-y-6">
        <!-- Previous School Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <x-input-label for="previous_school_name" value="Name of Previous School" />
                <x-text-input 
                    id="previous_school_name" 
                    name="previous_school_name" 
                    type="text" 
                    class="mt-1 block w-full" 
                    value="{{ old('previous_school_name') }}"
                    placeholder="Full name of the school"
                />
            </div>
            
            <div>
                <x-input-label for="previous_school_type" value="Type of School" />
                <select 
                    id="previous_school_type" 
                    name="previous_school_type" 
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-xs cursor-pointer"
                >
                    <option value="">Select School Type</option>
                    <option value="public" {{ old('previous_school_type') == 'public' ? 'selected' : '' }}>Public</option>
                    <option value="private" {{ old('previous_school_type') == 'private' ? 'selected' : '' }}>Private</option>
                    <option value="state_university" {{ old('previous_school_type') == 'state_university' ? 'selected' : '' }}>State University</option>
                    <option value="other" {{ old('previous_school_type') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            
            <div>
                <x-input-label for="previous_school_year" value="Last School Year Completed" />
                <x-text-input 
                    id="previous_school_year" 
                    name="previous_school_year" 
                    type="text" 
                    class="mt-1 block w-full" 
                    value="{{ old('previous_school_year') }}"
                    placeholder="e.g., 2023-2024"
                />
            </div>
            
            <div>
                <x-input-label for="previous_grade_level" value="Last Grade Level Completed" />
                <select 
                    id="previous_grade_level" 
                    name="previous_grade_level" 
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-xs cursor-pointer"
                >
                    <option value="">Select Grade Level</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ old('previous_grade_level') == $i ? 'selected' : '' }}>
                            Grade {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
            
            <div>
                <x-input-label for="previous_section" value="Last Section/Strand" />
                <x-text-input 
                    id="previous_section" 
                    name="previous_section" 
                    type="text" 
                    class="mt-1 block w-full" 
                    value="{{ old('previous_section') }}"
                />
            </div>
        </div>

        <!-- School Address -->
        <div class="border-t border-gray-200 pt-6">
            <h4 class="text-md font-medium text-gray-900 mb-4">School Address</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <x-input-label for="previous_school_street" value="Street Address" />
                    <x-text-input 
                        id="previous_school_street" 
                        name="previous_school_street" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('previous_school_street') }}"
                    />
                </div>
                
                <div>
                    <x-input-label for="previous_school_city" value="City/Municipality" />
                    <x-text-input 
                        id="previous_school_city" 
                        name="previous_school_city" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('previous_school_city') }}"
                    />
                </div>
                
                <div>
                    <x-input-label for="previous_school_province" value="Province" />
                    <x-text-input 
                        id="previous_school_province" 
                        name="previous_school_province" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('previous_school_province') }}"
                    />
                </div>
                
                <div>
                    <x-input-label for="previous_school_country" value="Country" />
                    <x-text-input 
                        id="previous_school_country" 
                        name="previous_school_country" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('previous_school_country', 'Philippines') }}"
                    />
                </div>
            </div>
        </div>

        <!-- Transfer Details -->
        <div class="border-t border-gray-200 pt-6">
            <h4 class="text-md font-medium text-gray-900 mb-4">Transfer Details</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="transfer_reason" value="Reason for Transfer" />
                    <select 
                        id="transfer_reason" 
                        name="transfer_reason" 
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-xs cursor-pointer"
                    >
                        <option value="">Select Reason</option>
                        <option value="family_transfer" {{ old('transfer_reason') == 'family_transfer' ? 'selected' : '' }}>Family Transfer</option>
                        <option value="academic_reasons" {{ old('transfer_reason') == 'academic_reasons' ? 'selected' : '' }}>Academic Reasons</option>
                        <option value="financial_reasons" {{ old('transfer_reason') == 'financial_reasons' ? 'selected' : '' }}>Financial Reasons</option>
                        <option value="personal_reasons" {{ old('transfer_reason') == 'personal_reasons' ? 'selected' : '' }}>Personal Reasons</option>
                        <option value="other" {{ old('transfer_reason') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                
                <div>
                    <x-input-label for="transfer_date" value="Date of Transfer" />
                    <x-text-input 
                        id="transfer_date" 
                        name="transfer_date" 
                        type="date" 
                        class="mt-1 block w-full" 
                        value="{{ old('transfer_date') }}"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <x-input-label for="other_transfer_reason" value="Other Reason (Please specify)" />
                    <x-textarea 
                        id="other_transfer_reason" 
                        name="other_transfer_reason" 
                        class="mt-1 block w-full" 
                        rows="3"
                        placeholder="Please specify if you selected 'Other'"
                    >{{ old('other_transfer_reason') }}</x-textarea>
                </div>
            </div>
        </div>
    </div>
    
    @include('components.step-navigation')
</div>