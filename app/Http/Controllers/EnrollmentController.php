<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Section;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('enrollments.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Enrollment $enrollment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enrollment $enrollment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        //
    }

    public function settings()
    {
        // Load current settings (e.g., from DB or config; for now, fetch sections grouped by grade)
        $sectionsByGrade = Section::select('grade_level', 'name')
            ->get()
            ->groupBy('grade_level')
            ->map(function ($group) {
                return $group->pluck('name')->toArray();
            });

        // Assume school year from config or latest enrollment; hardcode for now
        $schoolYear = '2025-2026';
        $gradeLevels = ['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12']; // Or fetch dynamically

        return response()->json([
            'school_year' => $schoolYear,
            'grade_levels' => $gradeLevels,
            'sections' => $sectionsByGrade,
        ]);
    }

    public function saveSettings(Request $request)
    {
        // Validate input
        $data = $request->validate([
            'school_year' => 'required|string|max:9',
            'sections' => 'required|array', // e.g., ['Grade 7' => ['Lanzones', 'Strawberry'], ...]
        ]);

        // Save sections: Delete old ones for simplicity, then create new
        Section::truncate(); // Careful in production; use soft deletes if needed

        foreach ($data['sections'] as $grade => $sectionNames) {
            foreach ($sectionNames as $name) {
                Section::create([
                    'grade_level' => $grade,
                    'name' => $name,
                ]);
            }
        }

        // Save school year somewhere (e.g., config, or add to a new table if needed)

        return response()->json(['message' => 'Settings saved successfully']);
    }
}
