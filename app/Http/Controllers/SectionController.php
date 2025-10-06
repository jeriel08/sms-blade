<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Settings;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function sync(Request $request)
    {
        $request->validate([
            'school_year' => 'required|string|max:9',
            'sections' => 'required|array',
        ]);

        // Update global school year
        Settings::updateOrCreate(['key' => 'school_year'], ['value' => $request->school_year]);

        $sectionsData = $request->input('sections');

        foreach ($sectionsData as $grade => $sections) {
            $submittedSections = collect($sections)
                ->map(function ($section) {
                    $section['name'] = trim($section['name']);
                    return $section;
                })
                ->filter(fn($s) => !empty($s['name']));

            $existingSections = Section::where('grade_level', $grade)->get();

            // Create or update
            foreach ($submittedSections as $submitted) {
                Section::updateOrCreate(
                    ['grade_level' => $grade, 'name' => $submitted['name']],
                    ['adviser_teacher_id' => $submitted['adviser_id'] ?: null]
                );
            }

            // Delete removed
            $submittedNames = $submittedSections->pluck('name');
            $toDelete = $existingSections->whereNotIn('name', $submittedNames);
            $toDelete->each->delete();
        }

        return response()->json(['message' => 'Settings saved successfully']);
    }
}
