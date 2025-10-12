{{-- resources/views/enrollments/create.blade.php --}}
<x-app-layout>
    <pre>{{ json_encode($formData, JSON_PRETTY_PRINT) }}</pre>
    @section('title', 'Register Student | MBNHS-SMS')
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-1 leading-tight">
            {{ __('ENROLL STUDENT') }}
        </h2>
    </x-slot>

    <div class="bg-white rounded-lg shadow-sm min-h-screen mx-auto sm:p-6 lg:p-8">
        <div class="max-w-6xl mx-auto"> {{-- Increased width from 4xl to 6xl for wider form --}}
            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="relative flex justify-between items-center">
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

                        // Calculate completed steps
                        $stepKeys = array_keys($steps);
                        $currentIndex = array_search($currentStep, $stepKeys);
                        $completedSteps = $currentIndex; // 0-based index of completed steps
                    @endphp

                    @foreach($steps as $key => $label)
                        @php
                            $stepIndex = array_search($key, $stepKeys);
                            $isCompleted = $stepIndex < $completedSteps;
                            $isCurrent = $stepIndex === $completedSteps;
                            $isFuture = $stepIndex > $completedSteps;
                        @endphp

                        <!-- Step Circle -->
                        <div class="flex flex-col items-center min-w-0 flex-1 relative">
                            <!-- Progress Line (before circle, except first step) -->
                            @if($loop->index > 0)
                                <div class="absolute top-4 left-8 flex-1 h-1 
                                    {{ $isCompleted ? 'bg-blue-600' : 'bg-gray-300' }}"
                                    style="z-index: 9;">
                                </div>
                            @endif

                            <!-- Step Circle -->
                            <div class="relative z-10 w-15 h-15 rounded-full flex items-center justify-center text-lg font-bold
                                {{ $isCurrent ? 'bg-blue-600 text-white ring-2' : 
                                   ($isCompleted ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600') }}">
                                {{ $loop->iteration }}
                            </div>

                            <!-- Step Label -->
                            <span class="text-xs mt-2 text-center px-1
                                {{ $isCurrent ? 'font-medium text-blue-600' : 
                                   ($isCompleted ? 'text-blue-600' : 'text-gray-500') }}">
                                {{ $label }}
                            </span>

                            <!-- Progress Line (after circle, except last step) -->
                            @if(!$loop->last)
                                <div class="absolute top-4 right-8 flex-1 h-1 
                                    {{ $isCompleted ? 'bg-green-500' : 'bg-gray-300' }}"
                                    style="z-index: -1;">
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Student Type Badge -->
            <div class="mb-6 display: hidden">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                    {{ $studentType === 'new' ? 'bg-green-100 text-green-800' : 
                       ($studentType === 'old' ? 'bg-blue-100 text-blue-800' :
                       ($studentType === 'transferee' ? 'bg-purple-100 text-purple-800' : 'bg-orange-100 text-orange-800')) }}">
                    {{ ucfirst($studentType) }} Student
                </span>
            </div>

            <!-- Form Content -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <form id="enrollment-form" method="POST" action="{{ route('enrollments.create', ['type' => $studentType, 'step' => $currentStep]) }}">
                    @csrf
                    <input type="hidden" name="student_type" value="{{ $formData['student_type'] ?? $studentType }}">
                    <input type="hidden" name="_step" value="{{ $currentStep }}">

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
                            <button type="submit" id="real-submit-btn" name="action" value="submit" style="display: none;"></button>
                            @break
                    @endswitch
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function navigateStep(direction) {
            const form = document.getElementById('enrollment-form');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'action';
            input.value = direction;
            form.appendChild(input);
            form.submit();
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
    @endpush
</x-app-layout>