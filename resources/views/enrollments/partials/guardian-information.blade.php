{{-- resources/views/enrollments/partials/guardian-information.blade.php --}}
<div>
    <div class="min-w-auto bg-2 text-center rounded-lg mb-6 opacity-50">
        <h3 class="text-md font-bold text-white mx-auto">PARENT’S/GUARDIAN’S INFORMATION</h3>
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
        {{-- Father --}}
        <div>
            <h3 class="text-md font-bold text-gray-900 mb-4">Father's Name</h3>
            
            <div class="flex justify-start align-items-center gap-6 mb-6 q">
                
                <div>
                    <x-input-label for="father_last_name" value="Last Name" important />
                    <x-text-input 
                        id="father_last_name" 
                        name="father_last_name" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ $formData['father_last_name'] ?? '' }}"
                        placeholder="Enter last name"
                    />
                </div>

                <div>
                    <x-input-label for="father_first_name" value="First Name" important />
                    <x-text-input 
                        id="father_first_name" 
                        name="father_first_name" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ $formData['father_first_name'] ?? '' }}"
                        placeholder="Enter first name"
                    />
                </div>

                <div>
                    <x-input-label for="father_middle_name" value="Middle Name" />
                    <x-text-input 
                        id="father_middle_name" 
                        name="father_middle_name" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ $formData['father_middle_name'] ?? '' }}"
                        placeholder="Enter middle name"
                    />
                </div>

                <div>
                    <x-input-label for="father_contact_number" value="Contact Number" important />
                    <x-text-input 
                        id="father_contact_number" 
                        name="father_contact_number" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ $formData['father_contact_number'] ?? '' }}"
                        placeholder="Enter contact number"
                    />
                </div>
            </div>
        </div>
        <hr class="my-6">
        {{-- Mother --}}
        <div>
            <h3 class="text-md font-bold text-gray-900 mb-4">Mother's Maiden Name</h3>
            
            <div class="flex justify-start align-items-center gap-6 mb-6 q">
                
                <div>
                    <x-input-label for="mother_last_name" value="Last Name" important />
                    <x-text-input 
                        id="mother_last_name" 
                        name="mother_last_name" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ $formData['mother_last_name'] ?? '' }}"
                        placeholder="Enter last name"
                    />
                </div>

                <div>
                    <x-input-label for="mother_first_name" value="First Name" important />
                    <x-text-input 
                        id="mother_first_name" 
                        name="mother_first_name" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ $formData['mother_first_name'] ?? '' }}"
                        placeholder="Enter first name"
                    />
                </div>

                <div>
                    <x-input-label for="mother_middle_name" value="Middle Name" />
                    <x-text-input 
                        id="mother_middle_name" 
                        name="mother_middle_name" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ $formData['mother_middle_name'] ?? '' }}"
                        placeholder="Enter middle name"
                    />
                </div>

                <div>
                    <x-input-label for="mother_contact_number" value="Contact Number" important />
                    <x-text-input 
                        id="mother_contact_number" 
                        name="mother_contact_number" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ $formData['mother_contact_number'] ?? '' }}"
                        placeholder="Enter contact number"
                    />
                </div>
            </div>
        </div>
        <hr class="my-6">
        {{-- Legal Guardian --}}
        <div>
            <h3 class="text-md font-bold text-gray-900 mb-4">Legal Guardian's Name</h3>
            
            <div class="flex justify-start align-items-center gap-6 mb-6 q">
                
                <div>
                    <x-input-label for="legal_guardian_last_name" value="Last Name" important />
                    <x-text-input 
                        id="legal_guardian_last_name" 
                        name="legal_guardian_last_name" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ $formData['legal_guardian_last_name'] ?? '' }}"
                        placeholder="Enter last name"
                    />
                </div>

                <div>
                    <x-input-label for="legal_guardian_first_name" value="First Name" important />
                    <x-text-input 
                        id="legal_guardian_first_name" 
                        name="legal_guardian_first_name" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ $formData['legal_guardian_first_name'] ?? '' }}"
                        placeholder="Enter first name"
                    />
                </div>

                <div>
                    <x-input-label for="legal_guardian_middle_name" value="Middle Name" />
                    <x-text-input 
                        id="legal_guardian_middle_name" 
                        name="legal_guardian_middle_name" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ $formData['legal_guardian_middle_name'] ?? '' }}"
                        placeholder="Enter middle name"
                    />
                </div>

                <div>
                    <x-input-label for="legal_guardian_contact_number" value="Contact Number" important />
                    <x-text-input 
                        id="legal_guardian_contact_number" 
                        name="legal_guardian_contact_number" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ $formData['legal_guardian_contact_number'] ?? '' }}"
                        placeholder="Enter contact number"
                    />
                </div>
            </div>
        </div>
    </div>
    
    @include('components.step-navigation')
</div>