{{-- resources/views/enrollments/partials/school-information.blade.php --}}
<div>
    <div class="space-y-6">
        {{-- For Returning Learner --}}
        <div class="mb-10">
            <div class="min-w-auto bg-2 text-center rounded-lg mb-6 opacity-50">
                <h3 class="text-md font-bold text-white mx-auto">FOR RETURNING LEARNER (BALIK-ARAL) AND THOSE WHO WILL MOVE IN</h3>
            </div>

            <div class="flex justify-start align-items-center gap-6 mb-6">
                <div>
                    <x-input-label for="last_grade_level_completed" value="Last Grade Level Completed" />
                    <x-text-input 
                        id="last_grade_level_completed" 
                        name="last_grade_level_completed" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('last_grade_level_completed') }}"
                        placeholder="Enter Grade Level"
                    />
                </div>
                
                <div>
                    <x-input-label for="last_school_year_completed" value="Last School Year Completed" />
                    <x-text-input 
                        id="last_school_year_completed" 
                        name="last_school_year_completed" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('last_school_year_completed') }}"
                        placeholder="Enter School Year"
                    />
                </div>

                <div>
                    <x-input-label for="last_school_attended" value="Last School Attended" />
                    <x-text-input 
                        id="last_school_attended" 
                        name="last_school_attended" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('last_school_attended') }}"
                        placeholder="Enter School Name"
                    />
                </div>

                <div>
                    <x-input-label for="school_id" value="School ID" />
                    <x-text-input 
                        id="school_id" 
                        name="school_id" 
                        type="text" 
                        class="mt-1 block w-full" 
                        value="{{ old('school_id') }}"
                        placeholder="Enter School ID"
                    />
                </div>
            </div>
        </div>

        {{-- For Learners in Senior High School --}}
        <div>
            <div class="min-w-auto bg-2 text-center rounded-lg mb-6 opacity-50">
                <h3 class="text-md font-bold text-white mx-auto">FOR LEARNERS IN SENIOR HIGH SCHOOL</h3>
            </div>
    
            <div class="flex justify-start align-items-center gap-6 mb-6">
                <div class="flex flex-col justify-start align-items-center gap-6 mb-6">
                    <div class="flex justify-start align-items-start gap-10">
                        {{-- Semester Checkboxes --}}
                        <div class="flex align-items-center justify-content-start gap-4">
                            <x-input-label for="semester" value="Semester" />
                            <div class="flex align-items-center justify-start gap-2">
                                <input 
                                    id="first_sem" 
                                    name="semester" 
                                    type="radio" 
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                    {{ old('first_sem') ? 'checked' : '' }}>
                                <x-input-label for="first_sem" value="1st" />
                            </div>
                            <div class="flex align-items-center justify-start gap-2">
                                <input 
                                    id="second_sem" 
                                    name="semester" 
                                    type="radio" 
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                    {{ old('second_sem') ? 'checked' : '' }}>
                                <x-input-label for="second_sem" value="2nd" />
                            </div>
                        </div>

                        {{-- Track and Strand --}}
                        <div class="flex flex-col gap-6">
                            <div class="flex justify-start gap-6">
                                <x-input-label for="track" value="Track" class="whitespace-nowrap" />
                                <x-text-input 
                                    id="track" 
                                    name="track" 
                                    type="text" 
                                    class="block w-full" 
                                    value="{{ old('track') }}"
                                    placeholder="Enter Track"
                                />
                            </div>
                            <div class="flex items-center gap-6">
                                <x-input-label for="strand" value="Strand" class="whitespace-nowrap" />
                                <x-text-input 
                                    id="strand" 
                                    name="strand" 
                                    type="text" 
                                    class="block w-full" 
                                    value="{{ old('strand') }}"
                                    placeholder="Enter Strand"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @include('components.step-navigation')
</div>