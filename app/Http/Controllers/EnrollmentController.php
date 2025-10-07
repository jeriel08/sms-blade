<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Settings;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Enrollment::with(['student', 'section'])
            ->join('students', 'enrollments.student_id', '=', 'students.student_id');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('students.first_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('students.last_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('students.lrn', 'LIKE', "%{$searchTerm}%")
                    ->orWhereRaw("CONCAT(students.first_name, ' ', students.last_name) LIKE ?", ["%{$searchTerm}%"]);
            });
        }

        $sortBy = $request->get('sort_by', 'name_asc');
        switch ($sortBy) {
            case 'name_asc':
                $query->orderBy('students.last_name', 'asc')->orderBy('students.first_name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('students.last_name', 'desc')->orderBy('students.first_name', 'desc');
                break;
            case 'lrn_asc':
                $query->orderBy('students.lrn', 'asc');
                break;
            case 'lrn_desc':
                $query->orderBy('students.lrn', 'desc');
                break;
            case 'grade_asc':
                $query->orderBy('enrollments.grade_level', 'asc');
                break;
            case 'grade_desc':
                $query->orderBy('enrollments.grade_level', 'desc');
                break;
            case 'status_asc':
                $query->orderBy('enrollments.status', 'asc');
                break;
            case 'status_desc':
                $query->orderBy('enrollments.status', 'desc');
                break;
            default:
                $query->orderBy('students.last_name', 'asc')->orderBy('students.first_name', 'asc');
        }

        $enrollments = $query->paginate(10);
        $currentSort = $sortBy;

        // Global school year
        $schoolYear = Settings::where('key', 'school_year')->value('value') ?? '2024-2025';

        // Sections for modal
        $sectionsByGrade = Section::all()->groupBy('grade_level')->map(function ($group) {
            return $group->map(function ($section) {
                return [
                    'name' => $section->name,
                    'adviser_id' => $section->adviser_teacher_id,
                ];
            })->toArray();
        });

        // Teachers for adviser dropdown
        $teachers = Teacher::all()->map(function ($teacher) {
            return [
                'id' => $teacher->teacher_id,
                'name' => $teacher->user->name ?? trim($teacher->first_name . ' ' . $teacher->last_name), // Adjust if no full_name accessor
            ];
        });

        // Authorization for settings
        $user = Auth::user();
        $canAccessSettings = $user && in_array($user->role, ['Principal', 'Head Teacher']);

        return view('enrollments.index', compact(
            'enrollments',
            'currentSort',
            'schoolYear',
            'sectionsByGrade',
            'teachers',
            'canAccessSettings',
        ));
    }

    /**
     * Display the enrollment settings page.
     */
    public function settings()
    {
        // Global school year
        $schoolYear = Settings::where('key', 'school_year')->value('value') ?? '2024-2025';

        // Sections by grade
        $sectionsByGrade = Section::all()->groupBy('grade_level')->map(function ($group) {
            return $group->map(function ($section) {
                return [
                    'name' => $section->name,
                    'adviser_id' => $section->adviser_teacher_id,
                ];
            })->toArray();
        });

        // Teachers for adviser dropdown
        $teachers = Teacher::all()->map(function ($teacher) {
            return [
                'id' => $teacher->teacher_id,
                'name' => $teacher->user->name ?? trim($teacher->first_name . ' ' . $teacher->last_name),
            ];
        });

        return view('enrollments.settings', compact('schoolYear', 'sectionsByGrade', 'teachers'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $studentType = $request->query('type', 'new'); // Use query() to safely get 'type'
        $currentStep = $request->query('step', 'learner'); // Use query() to safely get 'step'

        // Define valid steps based on student type
        $validSteps = ['learner', 'address', 'guardian', 'review'];
        if ($studentType === 'transferee') {
            $validSteps = ['learner', 'address', 'guardian', 'school', 'review'];
        }

        // Validate current step
        if (!in_array($currentStep, $validSteps)) {
            $currentStep = 'learner';
        }

        return view('enrollments.create', [
            'studentType' => $studentType,
            'currentStep' => $currentStep,
        ]);
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
}
