{{-- resources/views/enrollments/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-1 leading-tight">
            {{ __('ENROLL STUDENT') }}
        </h2>
    </x-slot>

    <div class="bg-white rounded-lg shadow-sm min-h-screen mx-auto sm:p-6 lg:p-8">
        <div class="max-w-4xl mx-auto">
            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex justify-between items-center">
                    @php
                        $steps = [
                            'learner' => 'Learner Information',
                            'address' => 'Address',
                            'guardian' => 'Guardian Information',
                            'school' => 'Recent School',
                            'review' => 'Review'
                        ];
                        
                        // Hide school step if not transferee
                        if($studentType !== 'transferee') {
                            unset($steps['school']);
                            // Reindex array
                            $steps = array_combine(
                                ['learner', 'address', 'guardian', 'review'],
                                array_values($steps)
                            );
                        }
                    @endphp

                    @foreach($steps as $key => $label)
                        <div class="flex flex-col items-center flex-1">
                            <div class="flex items-center w-full">
                                @if(!$loop->first)
                                    <div class="flex-1 h-1 bg-gray-300"></div>
                                @endif
                                <div class="w-8 h-8 rounded-full flex items-center justify-center 
                                    {{ $currentStep === $key ? 'bg-blue-600 text-white' : 
                                       ($loop->index < array_search($currentStep, array_keys($steps)) ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600') }}">
                                    {{ $loop->iteration }}
                                </div>
                                @if(!$loop->last)
                                    <div class="flex-1 h-1 bg-gray-300"></div>
                                @endif
                            </div>
                            <span class="text-xs mt-2 text-center {{ $currentStep === $key ? 'font-medium text-blue-600' : 'text-gray-500' }}">
                                {{ $label }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Student Type Badge -->
            <div class="mb-6">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                    {{ $studentType === 'new' ? 'bg-green-100 text-green-800' : 
                       ($studentType === 'old' ? 'bg-blue-100 text-blue-800' :
                       ($studentType === 'transferee' ? 'bg-purple-100 text-purple-800' : 'bg-orange-100 text-orange-800')) }}">
                    {{ ucfirst($studentType) }} Student
                </span>
            </div>

            <!-- Form Content -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <form id="enrollment-form" method="POST" action="{{ route('enrollments.store') }}">
                    @csrf
                    <input type="hidden" name="student_type" value="{{ $studentType }}">

                    @switch($currentStep)
                        @case('learner')
                            @include('enrollments.partials.learner-information')
                            @break
                            
                        @case('address')
                            @include('enrollments.partials.address-information')
                            @break
                            
                        @case('guardian')
                            @include('enrollments.partials.guardian-information')
                            @break
                            
                        @case('school')
                            @include('enrollments.partials.school-information')
                            @break
                            
                        @case('review')
                            @include('enrollments.partials.review-information')
                            @break
                    @endswitch
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function navigateStep(direction) {
            const steps = ['learner', 'address', 'guardian', 'school', 'review'];
            const studentType = '{{ $studentType }}';
            
            // Adjust steps based on student type
            let availableSteps = [...steps];
            if (studentType !== 'transferee') {
                availableSteps = availableSteps.filter(step => step !== 'school');
            }
            
            const currentStep = '{{ $currentStep }}';
            const currentIndex = availableSteps.indexOf(currentStep);
            
            let nextStep = null;
            if (direction === 'next') {
                if (currentIndex < availableSteps.length - 1) {
                    nextStep = availableSteps[currentIndex + 1];
                }
            } else if (direction === 'prev') {
                if (currentIndex > 0) {
                    nextStep = availableSteps[currentIndex - 1];
                }
            }
            
            if (nextStep) {
                storeFormData();
                
                // Build URL properly with URLSearchParams to avoid double ? or malformed params
                const url = new URL('{{ route("enrollments.create") }}'); // Base URL without params
                url.searchParams.set('type', studentType);
                url.searchParams.set('step', nextStep);
                window.location.href = url.toString();
            }
        }

        function validateStep(step) {
            // Bypass all validation for testing
            return true;
        }

        function storeFormData() {
            const form = document.getElementById('enrollment-form');
            const formData = new FormData(form);
            const data = {};
            
            for (let [key, value] of formData.entries()) {
                // Handle checkboxes
                if (key === 'same_as_current' || key === 'declaration') {
                    data[key] = 'on'; // Store as 'on' if it's in formData (meaning it's checked)
                } else {
                    data[key] = value;
                }
            }
            
            // Explicitly handle unchecked checkboxes
            const checkboxes = form.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                if (!checkbox.checked) {
                    data[checkbox.name] = '';
                }
            });
            
            sessionStorage.setItem('enrollmentFormData', JSON.stringify(data));
        }

        function loadFormData() {
            const storedData = sessionStorage.getItem('enrollmentFormData');
            if (storedData) {
                const data = JSON.parse(storedData);
                const form = document.getElementById('enrollment-form');
                
                for (let [key, value] of Object.entries(data)) {
                    const input = form.querySelector(`[name="${key}"]`);
                    if (input) {
                        if (input.type === 'checkbox') {
                            input.checked = value === 'on' || value === true;
                        } else {
                            input.value = value;
                        }
                    }
                    
                    // Handle select elements
                    const select = form.querySelector(`select[name="${key}"]`);
                    if (select) {
                        select.value = value;
                    }
                }
                
                // Trigger any change events for dynamic elements
                const sameAsCurrent = document.getElementById('same_as_current');
                if (sameAsCurrent) {
                    // Use setTimeout to ensure DOM is fully loaded
                    setTimeout(() => {
                        togglePermanentAddress();
                    }, 100);
                }
            }
        }

        function submitEnrollment() {
            // Bypass declaration check for testing
            document.getElementById('enrollment-form').submit();
        }

        // Load stored data when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadFormData();
            
            // No input event listeners for validation needed since bypassed
        });
    </script>
    @endpush
</x-app-layout>