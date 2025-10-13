<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Configuration\Middleware; // Correct import

#[Middleware(['auth', 'role:principal'])]
class UserManagementController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('approved', false)->get();
        return view('admin.users.index', compact('pendingUsers'));
    }

    public function approve(Request $request, User $user)
    {
        $user->update(['approved' => 1]);

        \App\Models\Teacher::firstOrCreate(
            ['teacher_id' => $user->id],
            [
                'email' => $user->email,
                'role' => $user->role,
                'password_hash' => $user->password,
                'assigned_grade_level' => $user->assigned_grade_level,
            ]
        );

        $user->notify(new \App\Notifications\UserApproved());

        return redirect()->route('admin.users.index')->with('success', 'User approved successfully.');
    }
}
