<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Settings;
use App\Models\Section;
use App\Models\Teacher;
use App\Models\Disability;
use Illuminate\Http\Request;

class AdminControlController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('approved', false)->paginate(10);
        $schoolYear = Settings::where('key', 'school_year')->value('value') ?? '2024-2025';

        // Data for enrollment setup tab (from your EnrollmentController::settings)
        $sectionsByGrade = Section::all()->groupBy('grade_level')->map(function ($group) {
            return $group->map(function ($section) {
                return [
                    'name' => $section->name,
                    'adviser_id' => $section->adviser_teacher_id,
                ];
            })->toArray();
        });

        $teachersByGrade = Teacher::whereNotNull('assigned_grade_level')
            ->orWhereNull('assigned_grade_level')
            ->get()
            ->groupBy('assigned_grade_level')
            ->map(function ($group) {
                return $group->map(function ($teacher) {
                    return [
                        'id' => $teacher->teacher_id,
                        'name' => $teacher->user->name ?? trim($teacher->first_name . ' ' . $teacher->last_name),
                    ];
                })->values();
            })
            ->toArray();

        $user = auth()->user();
        $assignedGrade = $user?->assigned_grade_level ?? 7;
        $disabilities = Disability::all()->pluck('name')->toArray();

        return view('admin.control.index', compact(
            'pendingUsers',
            'schoolYear',
            'sectionsByGrade',
            'teachersByGrade',
            'assignedGrade',
            'disabilities'
        ));
    }

    public function settings(Request $request)
    {
        // Same as your EnrollmentController::settings logic
        $validated = $request->validate([
            'school_year' => 'required|string|max:20',
            'sections' => 'json|nullable', // Handle sections JSON if needed
            'disabilities' => 'array|nullable',
        ]);

        Settings::updateOrCreate(['key' => 'school_year'], ['value' => $validated['school_year']]);

        // Handle disabilities (from your original)
        if ($request->has('disabilities')) {
            Disability::truncate();
            foreach ($request->disabilities as $name) {
                Disability::create(['name' => trim($name)]);
            }
        }

        // Handle sections sync (call your SectionController::sync if needed)
        // app(Http\Controllers\SectionController::class)->sync($request);

        return redirect()->route('admin.control.index')->with('success', 'Settings updated successfully.');
    }
}
