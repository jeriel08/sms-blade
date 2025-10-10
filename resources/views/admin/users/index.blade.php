<x-app-layout>
    @section('title', 'Account Approvals | MBNHS-SMS')
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-1 leading-tight">
            {{ __('ACCOUNT APPROVALS') }}
        </h2>
    </x-slot>

    <div class="bg-white rounded-lg shadow-sm min-h-screen mx-auto sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Search Filter --}}
            <div class="mb-4 flex justify-start items-center gap-2">
                <!-- Search Input on the left -->
                <div class="flex-1 max-w-md">
                    <form method="GET" action="{{ route('enrollments.index') }}" class="flex gap-2">
                        <x-text-input 
                            name="search"
                            type="text"
                            class="w-full"
                            placeholder="Search by name or email..."
                            value="{{ request('search') }}"
                        />
                        <x-primary-button type="submit">
                            <x-hugeicons-search-01 />
                        </x-primary-button>
                        @if(request('search'))
                            <a href="{{ route('enrollments.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-150 ease-in-out">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            {{-- Success Notification --}}
            @if (session('success'))
                <div class="mb-4 text-green-600">{{ session('success') }}</div>
            @endif

            {{-- Teacher Table --}}
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg border">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Role
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingUsers as $user)
                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                                <td class="px-6 py-4">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user->role }}
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('admin.users.approve', $user) }}" method="POST">
                                        @csrf
                                        <x-primary-button type="submit" class="gap-2">
                                            <x-hugeicons-checkmark-circle-01 /> 
                                            {{ __('Approve') }}
                                         </x-primary-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>