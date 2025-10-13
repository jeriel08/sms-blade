<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-1 leading-tight">
            {{ __('ADMIN PANEL') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto" x-data="{ tab: 'teachers' }">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-lg font-medium">Administrative Dashboard</h3>
                <p class="mt-2 text-gray-600">Manage key system settings and approvals.</p>

                <!-- Button Group for Tabs -->
                <div class="mt-6 flex gap-6 border-b border-gray-200">
                    <button 
                        @click="tab = 'teachers'" 
                        :class="{ 'border-b-2 border-indigo-500 text-indigo-600': tab === 'teachers', 'text-gray-600': tab !== 'teachers' }"
                        class="pb-2 font-medium"
                    >
                        Teacher Approvals
                    </button>
                    <button 
                        @click="tab = 'enrollment-setup'" 
                        :class="{ 'border-b-2 border-indigo-500 text-indigo-600': tab === 'enrollment-setup', 'text-gray-600': tab !== 'enrollment-setup' }"
                        class="pb-2 font-medium"
                    >
                        Enrollment Setup
                    </button>
                </div>

                <!-- Tab Content -->
                <div x-show="tab === 'teachers'" x-transition>
                    @include('admin.control.partials.teachers')
                </div>
                <div x-show="tab === 'enrollment-setup'" x-transition>
                    @include('admin.control.partials.enrollment-setup')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>