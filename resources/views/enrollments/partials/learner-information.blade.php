{{-- resources/views/enrollments/partials/learner-information.blade.php --}}
<div>
    <h3 class="text-lg font-medium text-gray-900 mb-6">Learner Information</h3>
    
    <div class="space-y-6">
        <!-- LRN and Grade Level -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="lrn" value="Learner Reference Number (LRN)" />
                <x-text-input 
                    id="lrn" 
                    name="lrn" 
                    type="text" 
                    class="mt-1 block w-full" 
                    value="{{ old('lrn') }}"
                    maxlength="12"
                    placeholder="12-digit LRN"
                />
            </div>
            
            <div>
                <x-input-label for="grade_level" value="Grade Level" />
                <select 
                    id="grade_level" 
                    name="grade_level"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-xs cursor-pointer"
                >
                    <option value="">Select Grade Level</option>
                    @for($i = 7; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ old('grade_level') == $i ? 'selected' : '' }}>
                            Grade {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
        </div>

        <!-- Name Fields -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <x-input-label for="last_name" value="Last Name" />
                <x-text-input 
                    id="last_name" 
                    name="last_name" 
                    type="text" 
                    class="mt-1 block w-full" 
                    value="{{ old('last_name') }}"
                />
            </div>
            
            <div>
                <x-input-label for="first_name" value="First Name" />
                <x-text-input 
                    id="first_name" 
                    name="first_name" 
                    type="text" 
                    class="mt-1 block w-full" 
                    value="{{ old('first_name') }}"
                />
            </div>
            
            <div>
                <x-input-label for="middle_name" value="Middle Name" />
                <x-text-input 
                    id="middle_name" 
                    name="middle_name" 
                    type="text" 
                    class="mt-1 block w-full" 
                    value="{{ old('middle_name') }}"
                />
            </div>
        </div>

        <!-- Suffix and Extension Name -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="suffix" value="Suffix (Jr., III, etc.)" />
                <x-text-input 
                    id="suffix" 
                    name="suffix" 
                    type="text" 
                    class="mt-1 block w-full" 
                    value="{{ old('suffix') }}"
                    placeholder="e.g., Jr., III"
                />
            </div>
        </div>

        <!-- Personal Information -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <x-input-label for="birthdate" value="Birthdate" />
                <x-text-input 
                    id="birthdate" 
                    name="birthdate" 
                    type="date" 
                    class="mt-1 block w-full" 
                    value="{{ old('birthdate') }}"
                />
            </div>
            
            <div>
                <x-input-label for="gender" value="Gender" />
                <select 
                    id="gender" 
                    name="gender"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-xs cursor-pointer"
                >
                    <option value="">Select Gender</option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            
            <div>
                <x-input-label for="religion" value="Religion" />
                <x-text-input 
                    id="religion" 
                    name="religion" 
                    type="text" 
                    class="mt-1 block w-full" 
                    value="{{ old('religion') }}"
                />
            </div>
        </div>

        <!-- Contact Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="email" value="Email Address" />
                <x-text-input 
                    id="email" 
                    name="email" 
                    type="email" 
                    class="mt-1 block w-full" 
                    value="{{ old('email') }}"
                />
            </div>
            
            <div>
                <x-input-label for="contact_number" value="Contact Number" />
                <x-text-input 
                    id="contact_number" 
                    name="contact_number" 
                    type="tel" 
                    class="mt-1 block w-full" 
                    value="{{ old('contact_number') }}"
                    placeholder="09XXXXXXXXX"
                />
            </div>
        </div>
    </div>
    
    @include('components.step-navigation')
</div>