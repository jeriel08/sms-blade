{{-- resources/views/enrollments/partials/address-information.blade.php --}}
<div>
    <h3 class="text-lg font-medium text-gray-900 mb-6">Address Information</h3>
    
    <div class="space-y-6">
        <!-- Current Address -->
        <div class="border-b border-gray-200 pb-6">
            <h4 class="text-md font-medium text-gray-900 mb-4">Current Address</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <x-input-label for="current_street" value="Street Address" />
                    <x-text-input 
                        id="current_street" 
                        name="current_street" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('current_street') }}"
                        placeholder="House No., Street, Barangay"
                    />
                </div>
                
                <div>
                    <x-input-label for="current_city" value="City/Municipality" />
                    <x-text-input 
                        id="current_city" 
                        name="current_city" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('current_city') }}"
                    />
                </div>
                
                <div>
                    <x-input-label for="current_province" value="Province" />
                    <x-text-input 
                        id="current_province" 
                        name="current_province" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('current_province') }}"
                    />
                </div>
                
                <div>
                    <x-input-label for="current_zip_code" value="ZIP Code" />
                    <x-text-input 
                        id="current_zip_code" 
                        name="current_zip_code" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('current_zip_code') }}"
                        maxlength="4"
                    />
                </div>
                
                <div>
                    <x-input-label for="current_country" value="Country" />
                    <x-text-input 
                        id="current_country" 
                        name="current_country" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('current_country', 'Philippines') }}"
                    />
                </div>
            </div>
        </div>

        <!-- Permanent Address (with same as current toggle) -->
        <div>
            {{-- <div class="flex items-center mb-4">
                <checkbox 
                    id="same_as_current" 
                    name="same_as_current" 
                    onchange="togglePermanentAddress()"
                />
                <x-input-label for="same_as_current" value="Permanent address is same as current address" class="ml-2" />
            </div> --}}

            <div id="permanent-address-section">
                <h4 class="text-md font-medium text-gray-900 mb-4">Permanent Address</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <x-input-label for="permanent_street" value="Street Address" />
                        <x-text-input 
                            id="permanent_street" 
                            name="permanent_street" 
                            type="text" 
                            class="mt-1 block w-full" 
                            value="{{ old('permanent_street') }}"
                            placeholder="House No., Street, Barangay"
                        />
                    </div>
                    
                    <div>
                        <x-input-label for="permanent_city" value="City/Municipality" />
                        <x-text-input 
                            id="permanent_city" 
                            name="permanent_city" 
                            type="text" 
                            class="mt-1 block w-full" 
                            value="{{ old('permanent_city') }}"
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
                        />
                    </div>
                    
                    <div>
                        <x-input-label for="permanent_zip_code" value="ZIP Code" />
                        <x-text-input 
                            id="permanent_zip_code" 
                            name="permanent_zip_code" 
                            type="text" 
                            class="mt-1 block w-full" 
                            value="{{ old('permanent_zip_code') }}"
                            maxlength="4"
                        />
                    </div>
                    
                    <div>
                        <x-input-label for="permanent_country" value="Country" />
                        <x-text-input 
                            id="permanent_country" 
                            name="permanent_country" 
                            type="text" 
                            class="mt-1 block w-full" 
                            value="{{ old('permanent_country', 'Philippines') }}"
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