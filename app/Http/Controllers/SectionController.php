<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Settings;
use App\Models\Disability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SectionController extends Controller
{
    public function sync(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'school_year' => 'required|string|regex:/^\d{4}-\d{4}$/',
                'active_grade_level' => 'nullable|integer|between:7,12',
                'sections' => 'required|array',
                'sections.*' => 'array', // Each grade has an array of sections
                'sections.*.*.name' => 'required|string|max:100',
                'sections.*.*.adviser_id' => 'nullable|integer|exists:teachers,teacher_id',
                'disabilities' => 'required|array',
                'disabilities.*' => 'required|string|max:100',
            ]);

            DB::beginTransaction();

            // Update school year
            Settings::updateOrCreate(
                ['key' => 'school_year'],
                ['value' => $request->school_year]
            );

            // Update user's assigned grade level
            $user = Auth::user();
            if ($user && $request->active_grade_level) {
                $user->assigned_grade_level = $request->active_grade_level;
                $user->save();
            }

            // Sync sections
            $sectionsData = $request->input('sections');

            foreach ($sectionsData as $grade => $sections) {
                $submittedSections = collect($sections)
                    ->map(function ($section) {
                        $section['name'] = trim($section['name']);
                        return $section;
                    })
                    ->filter(fn($s) => !empty($s['name']));

                $existingSections = Section::where('grade_level', $grade)->get();

                // Create or update sections
                foreach ($submittedSections as $submitted) {
                    Section::updateOrCreate(
                        ['grade_level' => $grade, 'name' => $submitted['name']],
                        ['adviser_teacher_id' => $submitted['adviser_id'] ?: null]
                    );
                }

                // Delete removed sections
                $submittedNames = $submittedSections->pluck('name');
                $toDelete = $existingSections->whereNotIn('name', $submittedNames);
                $toDelete->each->delete();
            }

            // Sync disabilities
            $disabilityNames = collect($request->disabilities)->map(fn($name) => trim($name))->filter()->unique()->toArray();
            Disability::whereNotIn('name', $disabilityNames)->delete();
            foreach ($disabilityNames as $name) {
                Disability::updateOrCreate(
                    ['name' => $name],
                    ['name' => $name]
                );
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Settings saved successfully']);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to save settings: ' . $e->getMessage()], 500);
        }
    }
}
