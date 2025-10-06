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
                <div><strong>Grade Level:</strong> <span id="review-grade-level">-</span></div>
                <div><strong>Name:</strong> <span id="review-name">-</span></div>
                <div><strong>Birthdate:</strong> <span id="review-birthdate">-</span></div>
                <div><strong>Gender:</strong> <span id="review-gender">-</span></div>
                <div><strong>Contact:</strong> <span id="review-contact">-</span></div>
                <div><strong>Email:</strong> <span id="review-email">-</span></div>
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
                    <strong>Primary Guardian:</strong>
                    <div id="review-guardian1" class="text-gray-600">-</div>
                </div>
                <div>
                    <strong>Secondary Guardian:</strong>
                    <div id="review-guardian2" class="text-gray-600">-</div>
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
                <div><strong>Previous School:</strong> <span id="review-previous-school">-</span></div>
                <div><strong>Last Grade Level:</strong> <span id="review-previous-grade">-</span></div>
                <div><strong>Transfer Reason:</strong> <span id="review-transfer-reason">-</span></div>
            </div>
        </div>
        @endif

        <!-- Declaration -->
        <div class="border border-gray-200 rounded-lg p-6 bg-gray-50">
            {{-- <div class="flex items-start">
                <x-checkbox id="declaration" name="declaration" />
                <x-input-label for="declaration" class="ml-2">
                    I hereby certify that the information provided in this enrollment form is true and correct to the best of my knowledge. I understand that any misrepresentation may result in the cancellation of enrollment.
                </x-input-label>
            </div> --}}
        </div>
    </div>

    <script>
        function navigateToStep(step) {
            window.location.href = '{{ route("enrollments.create", ["type" => $studentType]) }}?step=' + step;
        }

        function populateReviewData() {
            // Get form data from session storage
            const storedData = sessionStorage.getItem('enrollmentFormData');
            if (storedData) {
                const data = JSON.parse(storedData);
                
                // Learner Information
                document.getElementById('review-lrn').textContent = data.lrn || '-';
                document.getElementById('review-grade-level').textContent = data.grade_level ? 'Grade ' + data.grade_level : '-';
                document.getElementById('review-name').textContent = 
                    `${data.first_name || ''} ${data.middle_name || ''} ${data.last_name || ''} ${data.suffix || ''}`.trim();
                document.getElementById('review-birthdate').textContent = data.birthdate || '-';
                document.getElementById('review-gender').textContent = data.gender ? data.gender.charAt(0).toUpperCase() + data.gender.slice(1) : '-';
                document.getElementById('review-contact').textContent = data.contact_number || '-';
                document.getElementById('review-email').textContent = data.email || '-';
                
                // Address Information
                const currentAddress = `${data.current_street || ''}, ${data.current_city || ''}, ${data.current_province || ''}, ${data.current_zip_code || ''}`;
                document.getElementById('review-current-address').textContent = currentAddress.replace(/, ,/g, ',').replace(/^, |, $/g, '') || '-';
                
                let permanentAddress;
                if (data.same_as_current === 'on') {
                    permanentAddress = 'Same as current address';
                } else {
                    permanentAddress = `${data.permanent_street || ''}, ${data.permanent_city || ''}, ${data.permanent_province || ''}, ${data.permanent_zip_code || ''}`;
                }
                document.getElementById('review-permanent-address').textContent = permanentAddress.replace(/, ,/g, ',').replace(/^, |, $/g, '') || '-';
                
                // Guardian Information
                const guardian1 = `${data.guardian1_first_name || ''} ${data.guardian1_last_name || ''} (${data.guardian1_relationship || ''}) - ${data.guardian1_contact_number || ''}`;
                document.getElementById('review-guardian1').textContent = guardian1.trim() || '-';
                
                const guardian2 = data.guardian2_first_name ? 
                    `${data.guardian2_first_name} ${data.guardian2_last_name} (${data.guardian2_relationship}) - ${data.guardian2_contact_number || ''}` : 
                    'Not provided';
                document.getElementById('review-guardian2').textContent = guardian2.trim();
                
                // School Information (for transferees)
                @if($studentType === 'transferee')
                document.getElementById('review-previous-school').textContent = data.previous_school_name || '-';
                document.getElementById('review-previous-grade').textContent = data.previous_grade_level ? 'Grade ' + data.previous_grade_level : '-';
                document.getElementById('review-transfer-reason').textContent = data.transfer_reason ? 
                    data.transfer_reason.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') : '-';
                @endif
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            populateReviewData();
        });
    </script>
    
    @include('components.step-navigation')
</div>