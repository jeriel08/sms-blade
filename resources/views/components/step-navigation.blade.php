{{-- In create.blade.php, update the step navigation part --}}
<div class="flex justify-between mt-8 pt-6 border-t border-gray-200">
    @if($currentStep !== 'learner')
        <x-secondary-button 
            type="button"
            onclick="navigateStep('prev')"
            class="flex items-center gap-2"
        >
            <x-hugeicons-arrow-left-01 class="w-4 h-4" />
            Previous
        </x-secondary-button>
    @else
        <div></div>
    @endif

    @if($currentStep !== 'review')
        <x-primary-button 
            type="button"
            onclick="navigateStep('next')"
            class="flex items-center gap-2"
        >
            Next
            <x-hugeicons-arrow-right-01 class="w-4 h-4" />
        </x-primary-button>
    @else
        <x-primary-button 
            type="button"
            onclick="submitEnrollment()"
            class="flex items-center gap-2"
        >
            Submit Enrollment
        </x-primary-button>
    @endif
</div>