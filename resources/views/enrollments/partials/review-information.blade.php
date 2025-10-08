{{-- resources/views/enrollments/partials/review-information.blade.php --}}
<div>
    <h3 class="text-lg font-medium text-gray-900 mb-6">Review Information</h3>
    
    <div class="space-y-8">
        <!-- Learner Information Review -->
        <div class="border border-gray-200 rounded-lg p-6">
            <h4 class="text-md font-medium text-gray-900 mb-4 flex items-center justify-between">
                <span>Learner Information</span>
                <button type="button" onclick="navigateToStep('learner')" class="text-blue-600 hover:text-blue-800 text-sm font-normal">
                    Edit
                </button>
            </h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><strong>LRN:</strong> <span id="review-lrn">-</span></div>
                <div><strong>Name:</strong> <span id="review-name">-</span></div>
                <div><strong>Birthdate:</strong> <span id="review-birthdate">-</span></div>
                <div><strong>Gender:</strong> <span id="review-gender">-</span></div>
                <div><strong>Age:</strong> <span id="review-age">-</span></div>
                <div><strong>Mother Tongue:</strong> <span id="review-mother-tongue">-</span></div>
                <div><strong>PSA Birth Cert No:</strong> <span id="review-psa">-</span></div>
                <div><strong>With LRN:</strong> <span id="review-with-lrn">-</span></div>
                <div><strong>Returning Student:</strong> <span id="review-returning">-</span></div>
                <div><strong>IP Community Member:</strong> <span id="review-ip-member">-</span></div>
                <div><strong>IP Community:</strong> <span id="review-ip-community">-</span></div>
                <div><strong>4Ps Beneficiary:</strong> <span id="review-4ps">-</span></div>
                <div><strong>4Ps Household ID:</strong> <span id="review-4ps-id">-</span></div>
                <div><strong>Has Disability:</strong> <span id="review-disabled">-</span></div>
                <div><strong>Disabilities:</strong> <span id="review-disabilities">-</span></div>
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
                <div>
                    <strong>Current Address:</strong>
                    <div id="review-current-address" class="text-gray-600">-</div>
                </div>
                <div>
                    <strong>Permanent Address:</strong>
                    <div id="review-permanent-address" class="text-gray-600">-</div>
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
                    <div id="review-father" class="text-gray-600">-</div>
                </div>
                <div>
                    <strong>Father's Contact:</strong>
                    <div id="review-father-contact" class="text-gray-600">-</div>
                </div>
                <div>
                    <strong>Mother's Name:</strong>
                    <div id="review-mother" class="text-gray-600">-</div>
                </div>
                <div>
                    <strong>Mother's Contact:</strong>
                    <div id="review-mother-contact" class="text-gray-600">-</div>
                </div>
                <div>
                    <strong>Legal Guardian:</strong>
                    <div id="review-legal-guardian" class="text-gray-600">-</div>
                </div>
                <div>
                    <strong>Legal Guardian Contact:</strong>
                    <div id="review-legal-guardian-contact" class="text-gray-600">-</div>
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
                <div><strong>Last Grade Level Completed:</strong> <span id="review-previous-grade">-</span></div>
                <div><strong>Last School Year Completed:</strong> <span id="review-school-year">-</span></div>
                <div><strong>Last School Attended:</strong> <span id="review-previous-school">-</span></div>
                <div><strong>School ID:</strong> <span id="review-school-id">-</span></div>
                <div><strong>Semester:</strong> <span id="review-semester">-</span></div>
                <div><strong>Track:</strong> <span id="review-track">-</span></div>
                <div><strong>Strand:</strong> <span id="review-strand">-</span></div>
            </div>
        </div>
        @endif

        <!-- Declaration -->
        <div class="border border-gray-200 rounded-lg p-6 bg-gray-50">
            <div class="flex items-start">
                <input type="checkbox" id="declaration" name="declaration" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <x-input-label for="declaration" class="ml-2">
                    I hereby certify that the information provided in this enrollment form is true and correct to the best of my knowledge. I understand that any misrepresentation may result in the cancellation of enrollment.
                </x-input-label>
            </div>
            <x-input-error :messages="$errors->get('declaration')" class="mt-1" />
        </div>
    </div>

    <script>
        function navigateToStep(step) {
            window.location.href = '{{ route("enrollments.create", ["type" => $studentType]) }}?step=' + step;
        }

        function getRadioDisplayValue(value) {
            if (value === '1') return 'Yes';
            if (value === '0') return 'No';
            return '-';
        }

        function formatName(data, prefix = '') {
            const first = data[`${prefix}first_name`] || '';
            const middle = data[`${prefix}middle_name`] || '';
            const last = data[`${prefix}last_name`] || '';
            const extension = data[`${prefix}extension_name`] || '';
            
            let name = `${first} ${middle} ${last}`.trim().replace(/\s+/g, ' ');
            if (extension) {
                name += ` ${extension}`;
            }
            return name || '-';
        }

        function getDisabilities(data) {
            const disabilities = [];
            // Get all keys that start with 'disabilities'
            for (const key in data) {
                if (key.startsWith('disabilities') && data[key] === '1') {
                    // For checkboxes with array syntax like disabilities[1], disabilities[2], etc.
                    const match = key.match(/disabilities\[(\d+)\]/);
                    if (match) {
                        const disabilityId = match[1];
                        // We need to get the disability name - this is tricky without the actual names
                        // For now, we'll show the ID, but you might want to store the names in session too
                        disabilities.push(`Disability ${disabilityId}`);
                    }
                }
            }
            return disabilities.length > 0 ? disabilities.join(', ') : 'None';
        }

        function populateReviewData() {
            const storedData = sessionStorage.getItem('enrollmentFormData');
            console.log('Stored data:', storedData); // Debug log
            
            if (!storedData) {
                console.log('No data found in sessionStorage');
                return;
            }

            try {
                const data = JSON.parse(storedData);
                console.log('Parsed data:', data); // Debug log

                // Learner Information
                document.getElementById('review-lrn').textContent = data.lrn || '-';
                document.getElementById('review-name').textContent = formatName(data);
                document.getElementById('review-birthdate').textContent = data.birthdate || '-';
                document.getElementById('review-gender').textContent = data.gender ? 
                    data.gender.charAt(0).toUpperCase() + data.gender.slice(1) : '-';
                document.getElementById('review-age').textContent = data.age || '-';
                document.getElementById('review-mother-tongue').textContent = data.mother_tounge || '-';
                document.getElementById('review-psa').textContent = data.psa_birth_certification_no || '-';
                document.getElementById('review-with-lrn').textContent = getRadioDisplayValue(data.with_lrn);
                document.getElementById('review-returning').textContent = getRadioDisplayValue(data.returning);
                document.getElementById('review-ip-member').textContent = getRadioDisplayValue(data.ip_community_member);
                document.getElementById('review-ip-community').textContent = data.ip_community || '-';
                document.getElementById('review-4ps').textContent = getRadioDisplayValue(data['4ps_beneficiary']);
                document.getElementById('review-4ps-id').textContent = data['4ps_household_id'] || '-';
                document.getElementById('review-disabled').textContent = getRadioDisplayValue(data.is_disabled);
                document.getElementById('review-disabilities').textContent = getDisabilities(data);
                
                // Address Information
                const currentAddress = [
                    data.house_number,
                    data.street_name,
                    data.barangay,
                    data.city,
                    data.province,
                    data.country,
                    data.zip_code ? `Zip: ${data.zip_code}` : ''
                ].filter(Boolean).join(', ');
                document.getElementById('review-current-address').textContent = currentAddress || '-';
                
                let permanentAddress;
                if (data.same_as_current_address === '1') {
                    permanentAddress = 'Same as current address';
                } else {
                    permanentAddress = [
                        data.permanent_house_number,
                        data.permanent_street_name,
                        data.permanent_barangay,
                        data.permanent_city,
                        data.permanent_province,
                        data.permanent_country,
                        data.permanent_zip_code ? `Zip: ${data.permanent_zip_code}` : ''
                    ].filter(Boolean).join(', ');
                }
                document.getElementById('review-permanent-address').textContent = permanentAddress || '-';
                
                // Guardian Information
                document.getElementById('review-father').textContent = formatName(data, 'father_');
                document.getElementById('review-father-contact').textContent = data.father_contact_number || '-';
                
                document.getElementById('review-mother').textContent = formatName(data, 'mother_');
                document.getElementById('review-mother-contact').textContent = data.mother_contact_number || '-';
                
                const legalGuardianName = formatName(data, 'legal_guardian_');
                document.getElementById('review-legal-guardian').textContent = legalGuardianName !== '-' ? legalGuardianName : 'Not specified';
                document.getElementById('review-legal-guardian-contact').textContent = data.legal_guardian_contact_number || '-';
                
                // School Information (for transferees)
                @if($studentType === 'transferee')
                document.getElementById('review-previous-grade').textContent = data.last_grade_level_completed || '-';
                document.getElementById('review-school-year').textContent = data.last_school_year_completed || '-';
                document.getElementById('review-previous-school').textContent = data.last_school_attended || '-';
                document.getElementById('review-school-id').textContent = data.school_id || '-';
                document.getElementById('review-semester').textContent = data.semester ? 
                    (data.semester === 'first_sem' ? '1st Semester' : '2nd Semester') : '-';
                document.getElementById('review-track').textContent = data.track || '-';
                document.getElementById('review-strand').textContent = data.strand || '-';
                @endif

            } catch (error) {
                console.error('Error parsing session storage data:', error);
            }
        }

        function validateFinalSubmission() {
            let isValid = true;
            const errors = [];

            // Check declaration checkbox
            const declaration = document.getElementById('declaration');
            if (!declaration || !declaration.checked) {
                isValid = false;
                declaration.classList.add('border-red-500');
                errors.push({ 
                    message: 'You must accept the declaration to submit the enrollment',
                    element: declaration
                });
            }

            return { isValid, errors };
        }

        function submitEnrollment() {
            // Validate final submission
            const validationResult = validateFinalSubmission();
            
            if (validationResult.isValid) {
                // Save final data before submission
                saveFormData();
                document.getElementById('enrollment-form').submit();
            } else {
                showValidationErrors(validationResult.errors);
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Review page loaded'); // Debug log
            populateReviewData();
        });
    </script>
    
    @include('components.step-navigation')
</div>