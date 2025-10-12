<x-modal name="lrn-search" maxWidth="md" x-data="{ show: false }">
    <form method="POST" action="{{ route('enrollments.search-lrn') }}">
        @csrf
        <input type="hidden" name="student_type" id="student_type_input">

        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">
                {{ __('Enter Student LRN') }}
            </h2>

            <div class="mt-4">
                <x-text-input 
                    id="lrn-input" 
                    name="lrn"
                    type="text" 
                    class="w-full" 
                    placeholder="Enter 12-digit LRN..."
                />
            </div>

            <div id="error-message" class="mt-4 text-sm text-red-600 hidden"></div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button onclick="closeModal('lrn-search')">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-primary-button id="search-lrn-btn" type="submit">
                    {{ __('Search') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</x-modal>