<x-modal name="enroll-student-{{ $enrollment_id }}" maxWidth="md" x-init="updateSections({{ $enrollment_id }})">
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">
            {{ __('Assign Grade and Section') }}
        </h2>

        <form id="enrollForm-{{ $enrollment_id }}" method="POST" action="{{ route('enrollments.assign', $enrollment_id) }}">
            @csrf
            <div class="mb-4">
                <x-input-label for="grade_level_{{ $enrollment_id }}" value="Grade Level" />
                <select name="grade_level" id="grade_level_{{ $enrollment_id }}" class="mt-1 block w-full border-gray-300 rounded-md" onchange="updateSections({{ $enrollment_id }})">
                    <option value="">Select Grade Level</option>
                    @foreach (['7', '8', '9', '10', '11', '12'] as $grade)
                        <option value="{{ $grade }}">{{ $grade }}</option>
                    @endforeach
                </select>
                @error('grade_level')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <x-input-label for="section_id_{{ $enrollment_id }}" value="Section" />
                <select name="section_id" id="section_id_{{ $enrollment_id }}" class="mt-1 block w-full border-gray-300 rounded-md">
                    <option value="" disabled selected>Select Section</option>
                </select>
                @error('section_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button @click="$dispatch('close-modal', 'enroll-student-{{ $enrollment_id }}')">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-primary-button type="submit">
                    {{ __('Assign') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-modal>