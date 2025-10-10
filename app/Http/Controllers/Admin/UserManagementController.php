<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:principal']);
    }

    public function index()
    {
        $pendingUsers = User::where('approved', false)->get();
        return view('admin.users.index', compact('pendingUsers'));
    }

    public function approve(Request $request, User $user)
    {
        $user->update(['approved' => true]);

        // Optionally create a Teacher record
        \App\Models\Teacher::firstOrCreate(
            ['teacher_id' => $user->id],
            [
                // Add teacher-specific fields if needed
            ]
        );

        $user->notify(new \App\Notifications\UserApproved());

        return redirect()->route('admin.users.index')->with('success', 'User approved successfully.');
    }
}
