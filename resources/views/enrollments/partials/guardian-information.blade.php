{{-- resources/views/enrollments/partials/guardian-information.blade.php --}}
<div>
    <h3 class="text-lg font-medium text-gray-900 mb-6">Guardian Information</h3>
    
    <div class="space-y-6">
        <!-- Parent/Guardian 1 -->
        <div class="border-b border-gray-200 pb-6">
            <h4 class="text-md font-medium text-gray-900 mb-4">Parent/Guardian 1</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="guardian1_relationship" value="Relationship" />
                    <select 
                        id="guardian1_relationship" 
                        name="guardian1_relationship" 
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-xs cursor-pointer"
                    >
                        <option value="">Select Relationship</option>
                        <option value="father" {{ old('guardian1_relationship') == 'father' ? 'selected' : '' }}>Father</option>
                        <option value="mother" {{ old('guardian1_relationship') == 'mother' ? 'selected' : '' }}>Mother</option>
                        <option value="grandfather" {{ old('guardian1_relationship') == 'grandfather' ? 'selected' : '' }}>Grandfather</option>
                        <option value="grandmother" {{ old('guardian1_relationship') == 'grandmother' ? 'selected' : '' }}>Grandmother</option>
                        <option value="uncle" {{ old('guardian1_relationship') == 'uncle' ? 'selected' : '' }}>Uncle</option>
                        <option value="aunt" {{ old('guardian1_relationship') == 'aunt' ? 'selected' : '' }}>Aunt</option>
                        <option value="guardian" {{ old('guardian1_relationship') == 'guardian' ? 'selected' : '' }}>Guardian</option>
                        <option value="other" {{ old('guardian1_relationship') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                
                <div>
                    <x-input-label for="guardian1_other_relationship" value="Other Relationship" />
                    <x-text-input 
                        id="guardian1_other_relationship" 
                        name="guardian1_other_relationship" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('guardian1_other_relationship') }}"
                        placeholder="Specify if other"
                    />
                </div>
                
                <div>
                    <x-input-label for="guardian1_last_name" value="Last Name" />
                    <x-text-input 
                        id="guardian1_last_name" 
                        name="guardian1_last_name" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('guardian1_last_name') }}"
                    />
                </div>
                
                <div>
                    <x-input-label for="guardian1_first_name" value="First Name" />
                    <x-text-input 
                        id="guardian1_first_name" 
                        name="guardian1_first_name" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('guardian1_first_name') }}"
                    />
                </div>
                
                <div>
                    <x-input-label for="guardian1_middle_name" value="Middle Name" />
                    <x-text-input 
                        id="guardian1_middle_name" 
                        name="guardian1_middle_name" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('guardian1_middle_name') }}"
                    />
                </div>
                
                <div>
                    <x-input-label for="guardian1_contact_number" value="Contact Number" />
                    <x-text-input 
                        id="guardian1_contact_number" 
                        name="guardian1_contact_number" 
                        type="tel" 
                        class="mt-1 block w-full" 
                        value="{{ old('guardian1_contact_number') }}"
                        placeholder="09XXXXXXXXX"
                    />
                </div>
            </div>
        </div>

        <!-- Parent/Guardian 2 (Optional) -->
        <div>
            <h4 class="text-md font-medium text-gray-900 mb-4">Parent/Guardian 2 (Optional)</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="guardian2_relationship" value="Relationship" />
                    <select 
                        id="guardian2_relationship" 
                        name="guardian2_relationship" 
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-xs cursor-pointer"
                    >
                        <option value="">Select Relationship</option>
                        <option value="father" {{ old('guardian2_relationship') == 'father' ? 'selected' : '' }}>Father</option>
                        <option value="mother" {{ old('guardian2_relationship') == 'mother' ? 'selected' : '' }}>Mother</option>
                        <option value="grandfather" {{ old('guardian2_relationship') == 'grandfather' ? 'selected' : '' }}>Grandfather</option>
                        <option value="grandmother" {{ old('guardian2_relationship') == 'grandmother' ? 'selected' : '' }}>Grandmother</option>
                        <option value="uncle" {{ old('guardian2_relationship') == 'uncle' ? 'selected' : '' }}>Uncle</option>
                        <option value="aunt" {{ old('guardian2_relationship') == 'aunt' ? 'selected' : '' }}>Aunt</option>
                        <option value="guardian" {{ old('guardian2_relationship') == 'guardian' ? 'selected' : '' }}>Guardian</option>
                        <option value="other" {{ old('guardian2_relationship') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                
                <div>
                    <x-input-label for="guardian2_other_relationship" value="Other Relationship" />
                    <x-text-input 
                        id="guardian2_other_relationship" 
                        name="guardian2_other_relationship" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('guardian2_other_relationship') }}"
                        placeholder="Specify if other"
                    />
                </div>
                
                <div>
                    <x-input-label for="guardian2_last_name" value="Last Name" />
                    <x-text-input 
                        id="guardian2_last_name" 
                        name="guardian2_last_name" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('guardian2_last_name') }}"
                    />
                </div>
                
                <div>
                    <x-input-label for="guardian2_first_name" value="First Name" />
                    <x-text-input 
                        id="guardian2_first_name" 
                        name="guardian2_first_name" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('guardian2_first_name') }}"
                    />
                </div>
                
                <div>
                    <x-input-label for="guardian2_middle_name" value="Middle Name" />
                    <x-text-input 
                        id="guardian2_middle_name" 
                        name="guardian2_middle_name" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('guardian2_middle_name') }}"
                    />
                </div>
                
                <div>
                    <x-input-label for="guardian2_contact_number" value="Contact Number" />
                    <x-text-input 
                        id="guardian2_contact_number" 
                        name="guardian2_contact_number" 
                        type="tel" 
                        class="mt-1 block w-full" 
                        value="{{ old('guardian2_contact_number') }}"
                        placeholder="09XXXXXXXXX"
                    />
                </div>
            </div>
        </div>
    </div>
    
    @include('components.step-navigation')
</div>