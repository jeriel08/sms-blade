@if($canAccessSettings)
    <x-modal name="enrollment-settings" maxWidth="2xl">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-6">
                {{ __('Enrollment Settings') }}
            </h2>

            <form id="enrollment-settings-form">
                <div class="mb-6">
                    <x-input-label for="school_year" :value="__('School Year')" />
                    <x-text-input 
                        id="school_year" 
                        name="school_year" 
                        type="text" 
                        class="mt-1 block w-full" 
                        placeholder="e.g., 2024-2025"
                        value="{{ $schoolYear }}"
                        required 
                    />
                </div>

                <div class="mb-6">
                    <x-input-label for="grade_level" :value="__('Select Grade Level')" />
                    <select 
                        id="grade_level" 
                        name="grade_level"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-xs cursor-pointer"
                        onchange="loadSectionsForGrade(this.value)"
                    >
                        <option value="">Choose a grade level</option>
                        @foreach(range(7, 12) as $grade)
                            <option value="{{ $grade }}">Grade {{ $grade }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="sections-container" class="hidden">
                    <div class="flex items-center justify-between mb-4">
                        <x-input-label :value="__('Sections for Grade')" class="!mb-0" />
                        <span id="current-grade-label" class="text-lg font-semibold text-gray-700"></span>
                    </div>

                    <div id="sections-list" class="space-y-2 mb-4 max-h-60 overflow-y-auto p-2 border border-gray-200 rounded-md">
                        <!-- Dynamic sections -->
                    </div>

                    <div class="flex gap-2 mb-4">
                        <x-text-input 
                            id="new-section-input" 
                            type="text" 
                            class="flex-1" 
                            placeholder="Enter new section name..."
                        />
                        <select id="new-adviser-select" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">No Adviser</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher['id'] }}">{{ $teacher['name'] }}</option>
                            @endforeach
                        </select>
                        <x-primary-button 
                            type="button" 
                            onclick="addSection()"
                            class="whitespace-nowrap"
                        >
                            Add Section
                        </x-primary-button>
                    </div>

                    <p class="text-xs text-gray-500 mt-2">
                        Add, edit, or remove sections and assign advisers for the selected grade level.
                    </p>
                </div>
            </form>

            <div class="flex justify-end gap-3 mt-6">
                <x-secondary-button 
                    type="button" 
                    @click="$dispatch('close-modal', 'enrollment-settings')"
                >
                    {{ __('Cancel') }}
                </x-secondary-button>
                
                <x-primary-button 
                    type="button" 
                    onclick="saveSettings()"
                >
                    {{ __('Save Settings') }}
                </x-primary-button>
            </div>
        </div>
    </x-modal>
    @endif