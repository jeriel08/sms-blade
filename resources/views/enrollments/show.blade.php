<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-1 leading-tight">
            {{ __('Student Details') }}
        </h2>
    </x-slot>

    <div class="bg-white rounded-lg shadow-sm min-h-screen mx-auto sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-lg font-bold mb-4">Student Information</h3>
            <p><strong>Name:</strong> {{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}</p>
            <p><strong>LRN:</strong> {{ $enrollment->student->lrn }}</p>
            <p><strong>Grade Level:</strong> {{ $enrollment->grade_level ?? 'Not Assigned' }}</p>
            <p><strong>Section:</strong> {{ $enrollment->section ? $enrollment->section->name : 'Not Assigned' }}</p>
            <p><strong>Status:</strong> {{ $enrollment->status }}</p>
            <div class="mt-4">
                <a href="{{ route('enrollments.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                    Back to Enrollments
                </a>
            </div>
        </div>
    </div>
</x-app-layout>