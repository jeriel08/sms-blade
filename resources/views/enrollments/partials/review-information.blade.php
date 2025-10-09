{{-- resources/views/enrollments/partials/review-information.blade.php --}}
<div>
    <h3 class="text-lg font-medium text-gray-900 mb-6">Review Information</h3>
    
    <div class="space-y-8">
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <strong class="font-bold">Error:</strong>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <strong class="font-bold">Please fix the following errors:</strong>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Learner Information Review -->
        <div class="border border-gray-200 rounded-lg p-6">
            <h4 class="text-md font-medium text-gray-900 mb-4 flex items-center justify-between">
                <span>Learner Information</span>
                <button type="button" onclick="navigateToStep('learner')" class="text-blue-600 hover:text-blue-800 text-sm font-normal">
                    Edit
                </button>
            </h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><strong>LRN:</strong> {{ $formData['lrn'] ?? '-' }} </div>
                <div><strong>Name:</strong> {{ ($formData['first_name'] ?? '-') . ' ' . ($formData['middle_name'] ?? '') . ' ' . ($formData['last_name'] ?? '') . ' ' . ($formData['extension_name'] ?? '') }} </div>
                <div><strong>Birthdate:</strong> {{ $formData['birthdate'] ?? '-' }} </div>
                <div><strong>Gender:</strong> {{ isset($formData['gender']) && $formData['gender'] ? ucfirst($formData['gender']) : '-' }}</div>
                <div><strong>Age:</strong> {{ $formData['age'] ?? '-' }} </div>
                <div><strong>Mother Tongue:</strong> {{ $formData['mother_tongue'] ?? '-' }} </div>
                <div><strong>PSA Birth Cert No:</strong> {{ $formData['psa_birth_certification_no'] ?? '-' }} </div>
                <div><strong>With LRN:</strong> {{ isset($formData['with_lrn']) && $formData['with_lrn'] == '1' ? 'Yes' : 'No' }} </div>
                <div><strong>Returning Student:</strong> {{ isset($formData['returning']) && $formData['returning'] == '1' ? 'Yes' : 'No' }} </div>
                <div><strong>IP Community Member:</strong> {{ isset($formData['ip_community_member']) && ['ip_community_member'] == '1' ? 'Yes' : 'No' }} </div>
                <div><strong>IP Community:</strong> {{ $formData['ip_community'] ?? '-' }} </div>
                <div><strong>4Ps Beneficiary:</strong> {{ isset($formData['4ps_beneficiary']) && $formData['4ps_beneficiary'] == '1' ? 'Yes' : 'No' }} </div>
                <div><strong>4Ps Household ID:</strong> {{ $formData['4ps_household_id'] ?? '-' }} </div>
                <div><strong>Has Disability:</strong> {{ isset($formData['is_disabled']) && $formData['is_disabled'] == '1' ? 'Yes' : 'No' }} </div>
                <div><strong>Disabilities:</strong> 
                    @if(isset($formData['disabilities']) && !empty($formData['disabilities']))
                        {{ implode(', ', \App\Models\Disability::whereIn('disability_id', $formData['disabilities'])->pluck('name')->toArray()) }}
                    @else
                        None
                    @endif
                </div>
            </div>
        </div>

        <!-- Address Information Review -->
        <div class="border border-gray-200 rounded-lg p-6">
            <h4 class="text-md font-medium text-gray-900 mb-4 flex items-center justify-between">
                <span>Address Information</span>
                <button type="button" onclick="navigateToStep('address')" class="text-blue-600 hover:text-blue-800 text-sm font-normal">
                    Edit
                </button>
            </h4>
            
            <div class="space-y-4 text-sm">
                <div><strong>Current Address:</strong> 
                    @php
                        $zipCode = isset($formData['zip_code']) && $formData['zip_code'] ? 'Zip: ' . $formData['zip_code'] : '';
                        $currentAddress = implode(', ', array_filter([
                            $formData['house_number'] ?? '',
                            $formData['street_name'] ?? '',
                            $formData['barangay'] ?? '',
                            $formData['city'] ?? '',
                            $formData['province'] ?? '',
                            $formData['country'] ?? '',
                            $zipCode,
                        ])) ?: '-';
                    @endphp
                    {{ $currentAddress }}
                </div>
                <div><strong>Permanent Address:</strong> 
                    @if(($formData['same_as_current_address'] ?? false) == 1)
                        Same as current address
                    @else
                        @php
                            $permZipCode = isset($formData['permanent_zip_code']) && $formData['permanent_zip_code'] ? 'Zip: ' . $formData['permanent_zip_code'] : '';
                            $permanentAddress = implode(', ', array_filter([
                                $formData['permanent_house_number'] ?? '',
                                $formData['permanent_street_name'] ?? '',
                                $formData['permanent_barangay'] ?? '',
                                $formData['permanent_city'] ?? '',
                                $formData['permanent_province'] ?? '',
                                $formData['permanent_country'] ?? '',
                                $permZipCode,
                            ])) ?: '-';
                        @endphp
                        {{ $permanentAddress }}
                    @endif
                </div>
            </div>
        </div>

        <!-- Guardian Information Review -->
        <div class="border border-gray-200 rounded-lg p-6">
            <h4 class="text-md font-medium text-gray-900 mb-4 flex items-center justify-between">
                <span>Guardian Information</span>
                <button type="button" onclick="navigateToStep('guardian')" class="text-blue-600 hover:text-blue-800 text-sm font-normal">
                    Edit
                </button>
            </h4>
            
            <div class="space-y-4 text-sm">
                <div>
                    <strong>Father's Name:</strong>
                    <div id="review-father" class="text-gray-600"> {{ ($formData['father_first_name'] ?? '') . ' ' . ($formData['father_middle_name'] ?? '') . ' ' . ($formData['father_last_name'] ?? '') }} </div>
                </div>
                <div>
                    <strong>Father's Contact:</strong>
                    <div id="review-father-contact" class="text-gray-600"> {{ $formData['father_contact_number'] ?? '-' }} </div>
                </div>
                <div>
                    <strong>Mother's Name:</strong>
                    <div id="review-mother" class="text-gray-600"> {{ ($formData['mother_first_name'] ?? '') . ' ' . ($formData['mother_middle_name'] ?? '') . ' ' . ($formData['mother_last_name'] ?? '') }} </div>
                </div>
                <div>
                    <strong>Mother's Contact:</strong>
                    <div id="review-mother-contact" class="text-gray-600"> {{ $formData['mother_contact_number'] ?? '-' }} </div>
                </div>
                <div>
                    <strong>Legal Guardian:</strong>
                    <div id="review-legal-guardian" class="text-gray-600"> {{ ($formData['legal_guardian_first_name'] ?? '') . ' ' . ($formData['legal_guardian_middle_name'] ?? '') . ' ' . ($formData['legal_guardian_last_name'] ?? '') }} </div>
                </div>
                <div>
                    <strong>Legal Guardian Contact:</strong>
                    <div id="review-legal-guardian-contact" class="text-gray-600"> {{ $formData['legal_guardian_contact_number'] ?? '-' }} </div>
                </div>
            </div>
        </div>

        @if($studentType === 'transferee')
        <!-- School Information Review -->
        <div class="border border-gray-200 rounded-lg p-6">
            <h4 class="text-md font-medium text-gray-900 mb-4 flex items-center justify-between">
                <span>School Information</span>
                <button type="button" onclick="navigateToStep('school')" class="text-blue-600 hover:text-blue-800 text-sm font-normal">
                    Edit
                </button>
            </h4>
            
            <div class="space-y-4 text-sm">
                <div><strong>Last Grade Level Completed:</strong> {{ $formData['last_grade_level_completed'] ?? '-' }} </div>
                <div><strong>Last School Year Completed:</strong> {{ $formData['last_school_year_completed'] ?? '-' }} </div>
                <div><strong>Last School Attended:</strong> {{ $formData['last_school_attended'] ?? '-' }} </div>
                <div><strong>School ID:</strong> {{ $formData['school_id'] ?? '-' }} </div>
                <div><strong>Semester:</strong> {{ $formData['semester'] ?? '-' }} </div>
                <div><strong>Track:</strong> {{ $formData['track'] ?? '-' }} </div>
                <div><strong>Strand:</strong> {{ $formData['strand'] ?? '-' }} </div>
            </div>
        </div>
        @endif

        <!-- Declaration -->
        <div class="border border-gray-200 rounded-lg p-6 bg-gray-50">
            <div class="flex items-start">
                <input type="checkbox" id="declaration" name="declaration" value='1' {{ isset($formData['declaration']) && $formData['declaration'] == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <x-input-label for="declaration" class="ml-2">
                    I hereby certify that the information provided in this enrollment form is true and correct to the best of my knowledge. I understand that any misrepresentation may result in the cancellation of enrollment.
                </x-input-label>
            </div>
            <x-input-error :messages="$errors->get('declaration')" class="mt-1" />
        </div>
    </div>

    <script>
        function navigateToStep(step) {
            const studentType = '{{ $formData['student_type'] ?? $studentType }}';
            window.location.href = '{{ route("enrollments.create") }}?type=' + encodeURIComponent(studentType) + '&step=' + encodeURIComponent(step);
        }

        function submitEnrollment() {
            const declaration = document.getElementById('declaration');
            if (!declaration || !declaration.checked) {
                alert("Please confirm that the information provided is true by checking the declaration box.");
                declaration?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }
            const form = document.getElementById('enrollment-form');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'action';
            input.value = 'submit';
            form.appendChild(input);
            form.submit();
        }
    </script>
    
    @include('components.step-navigation')
</div>