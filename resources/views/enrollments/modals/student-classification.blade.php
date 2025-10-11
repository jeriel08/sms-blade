<x-modal name="select-student-type" maxWidth="md" x-data="{ show: false }">
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">
            {{ __('Select Type of Student') }}
        </h2>

        <div class="grid grid-cols-2 gap-4 mt-4">
            <x-primary-button 
                class="flex-col h-16 justify-center"
                onclick="window.location.href='{{ route('enrollments.create', ['type' => 'new']) }}'"
            >
                <span class="text-sm mt-1">New</span>
            </x-primary-button>

            <x-primary-button 
                class="flex-col h-16 justify-center"
                onclick="openLrnModal('old')"
            >
                <span class="text-sm mt-1">Old</span>
            </x-primary-button>

            <x-primary-button 
                class="flex-col h-16 justify-center"
                onclick="window.location.href='{{ route('enrollments.create', ['type' => 'transferee']) }}'"
            >
                <span class="text-sm mt-1">Transferee</span>
            </x-primary-button>

            <x-primary-button 
                class="flex-col h-16 justify-center"
                onclick="openLrnModal('balik_aral')"
            >
                <span class="text-sm mt-1">Returning</span>
            </x-primary-button>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button onclick="closeModal('select-student-type')">
                {{ __('Cancel') }}
            </x-secondary-button>
        </div>
    </div>
</x-modal>