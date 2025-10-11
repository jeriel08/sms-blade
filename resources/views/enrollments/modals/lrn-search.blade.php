<x-modal name="lrn-search" maxWidth="md" x-data="{ show: false }">
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">
            {{ __('Enter Student LRN') }}
        </h2>

        <div class="mt-4">
            <x-text-input 
                id="lrn-input" 
                type="text" 
                class="w-full" 
                placeholder="Enter 12-digit LRN..."
            />
        </div>

        <div id="student-info" class="mt-4 text-sm text-gray-700 hidden">
            Found student: <span id="student-name-text" class="font-medium"></span>
        </div>

        <div id="error-message" class="mt-4 text-sm text-red-600 hidden"></div>

        <div class="mt-6 flex justify-end gap-3">
            <x-secondary-button onclick="closeModal('lrn-search')">
                {{ __('Cancel') }}
            </x-secondary-button>
            <x-primary-button id="search-lrn-btn" type="button">
                {{ __('Search') }}
            </x-primary-button>
            <x-primary-button id="confirm-student-btn" type="button" class="hidden">
                {{ __('Confirm and Proceed') }}
            </x-primary-button>
        </div>
    </div>
</x-modal>