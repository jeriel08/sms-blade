<div class="mt-6">
    @if (session('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
    @endif
    @if ($pendingUsers->isEmpty())
        <p class="mt-2 text-gray-600">No pending approvals.</p>
    @else
        <table class="min-w-full mt-4">
            <thead>
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Current Role</th>
                    <th class="px-4 py-2">Assign Role</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendingUsers as $user)
                    <tr>
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2">{{ $user->role }}</td>
                        <td class="px-4 py-2">
                            <form action="{{ route('admin.users.approve', $user) }}" method="POST">
                                @csrf
                                <select name="role" class="border-gray-300 rounded-md">
                                    <option value="Subject Teacher">Subject Teacher</option>
                                    <option value="Adviser">Adviser</option>
                                    <option value="Head Teacher">Head Teacher</option>
                                </select>
                                <select name="assigned_grade_level" class="border-gray-300 rounded-md mt-2 adviser-grade-select" style="display: {{ $user->role === 'Adviser' ? 'block' : 'none' }};">
                                    <option value="7">Grade 7</option>
                                    <option value="8">Grade 8</option>
                                    <option value="9">Grade 9</option>
                                    <option value="10">Grade 10</option>
                                    <option value="11">Grade 11</option>
                                    <option value="12">Grade 12</option>
                                </select>
                        </td>
                        <td class="px-4 py-2">
                            <button type="submit" class="text-blue-600 hover:underline">Approve</button>
                        </td>
                    </form>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $pendingUsers->links() }}
    @endif
</div>

<script>
    document.querySelectorAll('select[name="role"]').forEach(select => {
        select.addEventListener('change', function () {
            const gradeLevelSelect = this.parentElement.querySelector('.adviser-grade-select');
            gradeLevelSelect.style.display = this.value === 'Adviser' ? 'block' : 'none';
        });
    });
</script>