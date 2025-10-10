<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-1 leading-tight">
                {{ __('STUDENT PROFILE') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('students.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition duration-150">
                    Back to Students
                </a>
                <a href="{{ route('students.edit', $student->lrn) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-150">
                    Edit Student
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Student Information -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Personal Information</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">LRN</p>
                                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $student->lrn }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Full Name</p>
                                    <p class="mt-1 text-lg font-semibold text-gray-900">
                                        {{ $student->first_name }} {{ $student->last_name }}
                                        {{ $student->middle_name ? ' ' . $student->middle_name : '' }}
                                        {{ $student->extension_name ? ' ' . $student->extension_name : '' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Birthdate</p>
                                    <p class="mt-1 text-lg text-gray-900">{{ \Carbon\Carbon::parse($student->birthdate)->format('F d, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Sex</p>
                                    <p class="mt-1 text-lg text-gray-900">{{ $student->sex }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Place of Birth</p>
                                    <p class="mt-1 text-lg text-gray-900">{{ $student->place_of_birth ?? 'Not specified' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Mother Tongue</p>
                                    <p class="mt-1 text-lg text-gray-900">{{ $student->mother_tongue ?? 'Not specified' }}</p>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">IP Community Member</p>
                                    <p class="mt-1 text-lg text-gray-900">{{ $student->is_ip ? 'Yes' : 'No' }}</p>
                                    @if($student->is_ip && $student->ip_community)
                                        <p class="text-sm text-gray-600">Community: {{ $student->ip_community }}</p>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">With Disability</p>
                                    <p class="mt-1 text-lg text-gray-900">{{ $student->is_disabled ? 'Yes' : 'No' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">PSA Birth Certificate</p>
                                    <p class="mt-1 text-lg text-gray-900">{{ $student->psa_birth_cert_no ?? 'Not provided' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Current Enrollment -->
                    <div class="bg-white rounded-xl shadow-sm mt-6">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Current Enrollment</h3>
                        </div>
                        <div class="p-6">
                            @php
                                $currentEnrollment = $student->enrollments->sortByDesc('created_at')->first();
                            @endphp
                            
                            @if($currentEnrollment)
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">School Year</p>
                                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $currentEnrollment->school_year }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Grade Level</p>
                                        <p class="mt-1 text-lg font-semibold text-gray-900">
                                            {{ $currentEnrollment->grade_level ? 'Grade ' . $currentEnrollment->grade_level : 'Not assigned' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Section</p>
                                        <p class="mt-1 text-lg font-semibold text-gray-900">
                                            {{ $currentEnrollment->section ? $currentEnrollment->section->name : 'Not assigned' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Status</p>
                                        <p class="mt-1">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $currentEnrollment->status === 'Enrolled' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $currentEnrollment->status }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-gray-200">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Enrollment Type</p>
                                        <p class="mt-1 text-lg text-gray-900">{{ $currentEnrollment->enrollment_type }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">4PS Beneficiary</p>
                                        <p class="mt-1 text-lg text-gray-900">{{ $currentEnrollment->is_4ps ? 'Yes' : 'No' }}</p>
                                        @if($currentEnrollment->is_4ps && $currentEnrollment->_4ps_household_id)
                                            <p class="text-sm text-gray-600">Household ID: {{ $currentEnrollment->_4ps_household_id }}</p>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-500">
                                    <p>No enrollment record found.</p>
                                    <a href="{{ route('students.index') }}" class="inline-flex items-center mt-2 text-blue-600 hover:text-blue-800">
                                        Enroll this student
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Family Contacts -->
                    <div class="bg-white rounded-xl shadow-sm">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Family Contacts</h3>
                        </div>
                        <div class="p-6">
                            @if($student->familyContacts->count() > 0)
                                <div class="space-y-4">
                                    @foreach($student->familyContacts as $contact)
                                        <div class="border-l-4 border-blue-500 pl-4">
                                            <p class="font-medium text-gray-900 capitalize">{{ $contact->contact_type }}</p>
                                            <p class="text-sm text-gray-600">
                                                {{ $contact->first_name }} {{ $contact->last_name }}
                                                {{ $contact->middle_name ? ' ' . $contact->middle_name : '' }}
                                            </p>
                                            @if($contact->contact_number)
                                                <p class="text-sm text-blue-600">{{ $contact->contact_number }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No family contacts recorded.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="bg-white rounded-xl shadow-sm">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Address Information</h3>
                        </div>
                        <div class="p-6">
                            @if($student->currentAddress)
                                <div class="mb-4">
                                    <p class="font-medium text-gray-900">Current Address</p>
                                    <p class="text-sm text-gray-600">
                                        {{ $student->currentAddress->house_no ? $student->currentAddress->house_no . ', ' : '' }}
                                        {{ $student->currentAddress->street_name }}, 
                                        {{ $student->currentAddress->barangay }}, 
                                        {{ $student->currentAddress->municipality_city }}, 
                                        {{ $student->currentAddress->province }}
                                    </p>
                                </div>
                            @endif

                            @if($student->permanentAddress && $student->permanent_address_id !== $student->current_address_id)
                                <div class="pt-4 border-t border-gray-200">
                                    <p class="font-medium text-gray-900">Permanent Address</p>
                                    <p class="text-sm text-gray-600">
                                        {{ $student->permanentAddress->house_no ? $student->permanentAddress->house_no . ', ' : '' }}
                                        {{ $student->permanentAddress->street_name }}, 
                                        {{ $student->permanentAddress->barangay }}, 
                                        {{ $student->permanentAddress->municipality_city }}, 
                                        {{ $student->permanentAddress->province }}
                                    </p>
                                </div>
                            @endif

                            @if(!$student->currentAddress)
                                <p class="text-gray-500">No address information recorded.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-sm">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-2">
                                <a href="{{ route('students.academic-record', $student->lrn) }}" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition duration-150 block">
                                    📊 View Academic Record
                                </a>
                                @if($currentEnrollment && $currentEnrollment->status !== 'Enrolled')
                                    <a href="{{ route('students.index') }}" class="w-full text-left px-4 py-3 text-sm text-green-700 hover:bg-green-50 rounded-lg transition duration-150 block">
                                        ✅ Enroll Student
                                    </a>
                                @endif
                                <button onclick="window.print()" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition duration-150">
                                    🖨️ Print Profile
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            .bg-white {
                background: white !important;
            }
            .shadow-sm {
                box-shadow: none !important;
            }
        }
    </style>
</x-app-layout>