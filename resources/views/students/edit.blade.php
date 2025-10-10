<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-1 leading-tight">
                {{ __('EDIT STUDENT') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('students.show', $student->lrn) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition duration-150">
                    Back to Profile
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Edit Student Information</h3>
                    <p class="text-sm text-gray-600 mt-1">LRN: {{ $student->lrn }}</p>
                </div>

                <form method="POST" action="{{ route('students.update', $student->lrn) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="p-6 space-y-6">
                        <!-- Personal Information -->
                        <div>
                            <h4 class="text-md font-semibold text-gray-900 mb-4">Personal Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="lrn" value="LRN" />
                                    <x-text-input 
                                        id="lrn" 
                                        name="lrn" 
                                        type="text" 
                                        class="mt-1 block w-full bg-gray-100" 
                                        value="{{ old('lrn', $student->lrn) }}" 
                                        readonly
                                    />
                                    <x-input-error class="mt-2" :messages="$errors->get('lrn')" />
                                </div>

                                <div>
                                    <x-input-label for="birthdate" value="Birthdate" />
                                    <x-text-input 
                                        id="birthdate" 
                                        name="birthdate" 
                                        type="date" 
                                        class="mt-1 block w-full" 
                                        value="{{ old('birthdate', $student->birthdate) }}" 
                                        required
                                    />
                                    <x-input-error class="mt-2" :messages="$errors->get('birthdate')" />
                                </div>

                                <div>
                                    <x-input-label for="first_name" value="First Name" />
                                    <x-text-input 
                                        id="first_name" 
                                        name="first_name" 
                                        type="text" 
                                        class="mt-1 block w-full" 
                                        value="{{ old('first_name', $student->first_name) }}" 
                                        required
                                    />
                                    <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                                </div>

                                <div>
                                    <x-input-label for="last_name" value="Last Name" />
                                    <x-text-input 
                                        id="last_name" 
                                        name="last_name" 
                                        type="text" 
                                        class="mt-1 block w-full" 
                                        value="{{ old('last_name', $student->last_name) }}" 
                                        required
                                    />
                                    <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                                </div>

                                <div>
                                    <x-input-label for="middle_name" value="Middle Name" />
                                    <x-text-input 
                                        id="middle_name" 
                                        name="middle_name" 
                                        type="text" 
                                        class="mt-1 block w-full" 
                                        value="{{ old('middle_name', $student->middle_name) }}" 
                                    />
                                    <x-input-error class="mt-2" :messages="$errors->get('middle_name')" />
                                </div>

                                <div>
                                    <x-input-label for="extension_name" value="Extension Name" />
                                    <x-text-input 
                                        id="extension_name" 
                                        name="extension_name" 
                                        type="text" 
                                        class="mt-1 block w-full" 
                                        value="{{ old('extension_name', $student->extension_name) }}" 
                                        placeholder="Jr., Sr., III, etc."
                                    />
                                    <x-input-error class="mt-2" :messages="$errors->get('extension_name')" />
                                </div>

                                <div>
                                    <x-input-label for="sex" value="Sex" />
                                    <select id="sex" name="sex" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="">Select Sex</option>
                                        <option value="Male" {{ old('sex', $student->sex) == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('sex', $student->sex) == 'Female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('sex')" />
                                </div>

                                <div>
                                    <x-input-label for="place_of_birth" value="Place of Birth" />
                                    <x-text-input 
                                        id="place_of_birth" 
                                        name="place_of_birth" 
                                        type="text" 
                                        class="mt-1 block w-full" 
                                        value="{{ old('place_of_birth', $student->place_of_birth) }}" 
                                    />
                                    <x-input-error class="mt-2" :messages="$errors->get('place_of_birth')" />
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="pt-6 border-t border-gray-200">
                            <h4 class="text-md font-semibold text-gray-900 mb-4">Additional Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="mother_tongue" value="Mother Tongue" />
                                    <x-text-input 
                                        id="mother_tongue" 
                                        name="mother_tongue" 
                                        type="text" 
                                        class="mt-1 block w-full" 
                                        value="{{ old('mother_tongue', $student->mother_tongue) }}" 
                                    />
                                    <x-input-error class="mt-2" :messages="$errors->get('mother_tongue')" />
                                </div>

                                <div>
                                    <x-input-label for="psa_birth_cert_no" value="PSA Birth Certificate No." />
                                    <x-text-input 
                                        id="psa_birth_cert_no" 
                                        name="psa_birth_cert_no" 
                                        type="text" 
                                        class="mt-1 block w-full" 
                                        value="{{ old('psa_birth_cert_no', $student->psa_birth_cert_no) }}" 
                                    />
                                    <x-input-error class="mt-2" :messages="$errors->get('psa_birth_cert_no')" />
                                </div>

                                <div>
                                    <x-input-label for="is_ip" value="IP Community Member" />
                                    <select id="is_ip" name="is_ip" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="0" {{ old('is_ip', $student->is_ip) == 0 ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ old('is_ip', $student->is_ip) == 1 ? 'selected' : '' }}>Yes</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('is_ip')" />
                                </div>

                                <div>
                                    <x-input-label for="ip_community" value="IP Community" />
                                    <x-text-input 
                                        id="ip_community" 
                                        name="ip_community" 
                                        type="text" 
                                        class="mt-1 block w-full" 
                                        value="{{ old('ip_community', $student->ip_community) }}" 
                                        placeholder="If applicable"
                                    />
                                    <x-input-error class="mt-2" :messages="$errors->get('ip_community')" />
                                </div>

                                <div>
                                    <x-input-label for="is_disabled" value="With Disability" />
                                    <select id="is_disabled" name="is_disabled" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="0" {{ old('is_disabled', $student->is_disabled) == 0 ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ old('is_disabled', $student->is_disabled) == 1 ? 'selected' : '' }}>Yes</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('is_disabled')" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 bg-gray-50 rounded-b-xl">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('students.show', $student->lrn) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition duration-150">
                                Cancel
                            </a>
                            <x-primary-button type="submit">
                                Update Student
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>