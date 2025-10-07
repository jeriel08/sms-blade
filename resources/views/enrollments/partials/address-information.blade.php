{{-- resources/views/enrollments/partials/address-information.blade.php --}}
<div>
    <div class="min-w-auto bg-2 text-center rounded-lg mb-6 opacity-50">
        <h3 class="text-md font-bold text-white mx-auto">LEARNER ADDRESS</h3>
    </div>
    
    <div class="space-y-6">
        <!-- Current Address -->
        <div class="border-b border-gray-200 pb-6">
            <h4 class="text-md font-bold text-gray-900 mb-4">Current Address</h4>

            {{-- First Row --}}
            <div class="flex justify-start align-items-center gap-6 mb-6">
                <div>
                    <x-input-label for="house_number" value="House No." />
                    <x-text-input 
                        id="house_number" 
                        name="house_number" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('house_number') }}"
                        placeholder="Enter house number"
                    />
                </div>
                <div>
                    <x-input-label for="street_name" value="Street Name" />
                    <x-text-input 
                        id="street_name" 
                        name="street_name" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('street_name') }}"
                        placeholder="Enter street name"
                    />
                </div>
                <div>
                    <x-input-label for="barangay" value="Barangay" />
                    <x-text-input 
                        id="barangay" 
                        name="barangay" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('barangay') }}"
                        placeholder="Enter barangay"
                    />
                </div>
            </div>

            {{-- Second Row --}}
            <div class="flex justify-start align-items-center gap-6 mb-4">
                <div>
                    <x-input-label for="city" value="Municipality/City" />
                    <x-text-input 
                        id="city" 
                        name="city" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('city') }}"
                        placeholder="Enter municipalit/city"
                    />
                </div>
                <div>
                    <x-input-label for="province" value="Province" />
                    <x-text-input 
                        id="province" 
                        name="province" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('province') }}"
                        placeholder="Enter province"
                    />
                </div>
                <div>
                    <x-input-label for="country" value="Country" />
                    <x-text-input 
                        id="country" 
                        name="country" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('country') }}"
                        placeholder="Enter country"
                    />
                </div>
                <div>
                    <x-input-label for="zip_code" value="Zip Code" />
                    <x-text-input 
                        id="zip_code" 
                        name="zip_code" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('zip_code') }}"
                        placeholder="Enter zip code"
                    />
                </div>
            </div>
        </div>

        <!-- Permanent Address (with same as current toggle) -->
        <div>

            <div id="permanent-address-section">
                <div class="flex justify-start align-items-center gap-6 mb-4">
                    <h4 class="text-md font-bold text-gray-900">Permanent Address</h4>
                    <div class="flex items-center gap-4">
                        <x-input-label for="same_as_current_address" value="Same with your current address?" class="italic mb-0" />
                        <div class="flex items-center gap-2">
                            <input 
                                id=same_yes" 
                                name="same_as_current_address" 
                                type="radio" 
                                value="1"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('same_as_current_address') == 'yes' ? 'checked' : '' }}>
                            <x-input-label for="same_yes" value="Yes" class="mb-0" />
                        </div>
                        <div class="flex items-center gap-2">
                            <input 
                                id="same_no" 
                                name="same_as_current_address" 
                                type="radio" 
                                value="0"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('same_as_current_address') == 'no' ? 'checked' : '' }}>
                            <x-input-label for="same_no" value="No" class="mb-0" />
                        </div>
                    </div>
                </div>
                
                {{-- First Row --}}
                <div class="flex justify-start align-items-center gap-6 mb-6">
                    <div>
                        <x-input-label for="permanent_house_number" value="House No." />
                        <x-text-input 
                            id="permanent_house_number" 
                            name="permanent_house_number" 
                            type="text" 
                            class="mt-1 block w-full" 
                            value="{{ old('permanent_house_number') }}"
                            placeholder="Enter house number"
                        />
                    </div>
                    <div>
                        <x-input-label for="permanent_street_name" value="Street Name" />
                        <x-text-input 
                            id="permanent_street_name" 
                            name="permanent_street_name" 
                            type="text" 
                            class="mt-1 block w-full" 
                            value="{{ old('permanent_street_name') }}"
                            placeholder="Enter street name"
                        />
                    </div>
                    <div>
                        <x-input-label for="permanent_barangay" value="Barangay" />
                        <x-text-input 
                            id="permanent_barangay" 
                            name="permanent_barangay" 
                            type="text" 
                            class="mt-1 block w-full" 
                            value="{{ old('permanent_barangay') }}"
                            placeholder="Enter barangay"
                        />
                    </div>
                </div>

                {{-- Second Row --}}
                <div class="flex justify-start align-items-center gap-6 mb-4">
                    <div>
                        <x-input-label for="permanent_city" value="Municipality/City" />
                        <x-text-input 
                            id="permanent_city" 
                            name="permanent_city" 
                            type="text" 
                            class="mt-1 block w-full" 
                            value="{{ old('permanent_city') }}"
                            placeholder="Enter municipalit/city"
                        />
                    </div>
                    <div>
                        <x-input-label for="permanent_province" value="Province" />
                        <x-text-input 
                            id="permanent_province" 
                            name="permanent_province" 
                            type="text" 
                            class="mt-1 block w-full" 
                            value="{{ old('permanent_province') }}"
                            placeholder="Enter province"
                        />
                    </div>
                    <div>
                        <x-input-label for="permanent_country" value="Country" />
                        <x-text-input 
                            id="permanent_country" 
                            name="permanent_country" 
                            type="text" 
                            class="mt-1 block w-full" 
                            value="{{ old('permanent_country') }}"
                            placeholder="Enter country"
                        />
                    </div>
                    <div>
                        <x-input-label for="permanent_zip_code" value="Zip Code" />
                        <x-text-input 
                            id="permanent_zip_code" 
                            name="permanent_zip_code" 
                            type="text" 
                            class="mt-1 block w-full" 
                            value="{{ old('permanent_zip_code') }}"
                            placeholder="Enter zip code"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePermanentAddress() {
            const sameAsCurrent = document.getElementById('same_as_current');
            const permanentSection = document.getElementById('permanent-address-section');
            const permanentInputs = permanentSection.querySelectorAll('input, select');
            
            if (sameAsCurrent.checked) {
                permanentSection.style.opacity = '0.5';
                permanentInputs.forEach(input => {
                    input.disabled = true;
                    // Copy values from current address
                    const currentFieldName = input.name.replace('permanent_', 'current_');
                    const currentField = document.querySelector(`[name="${currentFieldName}"]`);
                    if (currentField) {
                        input.value = currentField.value;
                    }
                });
            } else {
                permanentSection.style.opacity = '1';
                permanentInputs.forEach(input => {
                    input.disabled = false;
                });
            }
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            togglePermanentAddress();
        });
    </script>
    
    @include('components.step-navigation')
</div>