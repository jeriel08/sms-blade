<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Section;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Student::with(['enrollments.section']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('first_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('last_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('lrn', 'LIKE', "%{$searchTerm}%")
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$searchTerm}%"]);
            });
        }

        // Status filter
        if ($request->has('status') && $request->status !== 'all') {
            if ($request->status === 'registered') {
                $query->whereDoesntHave('enrollments', function ($q) {
                    $q->where('status', 'Enrolled');
                });
            } elseif ($request->status === 'enrolled') {
                $query->whereHas('enrollments', function ($q) {
                    $q->where('status', 'Enrolled');
                });
            } elseif ($request->status === 'inactive') {
                $query->whereHas('enrollments', function ($q) {
                    $q->where('status', 'Inactive');
                });
            }
        }

        // Sort functionality
        $sortBy = $request->get('sort_by', 'name_asc');
        switch ($sortBy) {
            case 'name_asc':
                $query->orderBy('last_name', 'asc')->orderBy('first_name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('last_name', 'desc')->orderBy('first_name', 'desc');
                break;
            case 'lrn_asc':
                $query->orderBy('lrn', 'asc');
                break;
            case 'lrn_desc':
                $query->orderBy('lrn', 'desc');
                break;
            case 'grade_asc':
                $query->select('students.*')
                    ->leftJoin('enrollments', 'students.student_id', '=', 'enrollments.student_id')
                    ->orderBy('enrollments.grade_level', 'asc');
                break;
            case 'grade_desc':
                $query->select('students.*')
                    ->leftJoin('enrollments', 'students.student_id', '=', 'enrollments.student_id')
                    ->orderBy('enrollments.grade_level', 'desc');
                break;
            default:
                $query->orderBy('last_name', 'asc')->orderBy('first_name', 'asc');
        }

        $students = $query->paginate(10);
        $currentSort = $sortBy;

        // Get sections for enrollment modal
        $sections = Section::all()->groupBy('grade_level');

        return view('students.index', compact('students', 'currentSort', 'sections'));
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
    public function show($lrn)
    {
        $student = Student::where('lrn', $lrn)->with(['enrollments.section', 'familyContacts', 'currentAddress', 'permanentAddress'])->firstOrFail();
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($lrn)
    {
        $student = Student::where('lrn', $lrn)->firstOrFail();
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    /**
 * Update the specified resource in storage.
 */
/**
 * Update the specified resource in storage.
 */
public function update(Request $request, $lrn)
{
    $student = Student::where('lrn', $lrn)->firstOrFail();
    
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'extension_name' => 'nullable|string|max:10',
        'birthdate' => 'required|date',
        'sex' => 'required|in:Male,Female',
        'place_of_birth' => 'nullable|string|max:100',
        'mother_tongue' => 'nullable|string|max:50',
        'psa_birth_cert_no' => 'nullable|string|max:50',
        'is_ip' => 'required|boolean',
        'ip_community' => 'nullable|string|max:100',
        'is_disabled' => 'required|boolean',
    ]);

    $student->update($validated);

    return redirect()->route('students.show', $student->lrn)
        ->with('success', 'Student updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }

    /**
     * Enroll a student (assign grade level and section)
     */
    public function enroll(Request $request, $lrn)
    {
        try {
            $student = Student::where('lrn', $lrn)->firstOrFail();

            $validated = $request->validate([
                'grade_level' => 'required|string|in:7,8,9,10,11,12',
                'section_id' => 'required|exists:sections,section_id',
            ]);

            // Check if section belongs to the selected grade level
            $section = Section::where('section_id', $validated['section_id'])
                ->where('grade_level', $validated['grade_level'])
                ->first();

            if (!$section) {
                return back()->with('error', 'Selected section does not match the grade level.');
            }

            // Get or create enrollment
            $enrollment = Enrollment::firstOrNew([
                'student_id' => $student->student_id,
                'school_year' => '2024-2025' // You might want to make this dynamic
            ]);

            $enrollment->fill([
                'grade_level' => $validated['grade_level'],
                'section_id' => $validated['section_id'],
                'enrollment_type' => 'New', // You might want to determine this based on student data
                'status' => 'Enrolled',
                'enrolled_by_teacher_id' => auth()->user()->teacher_id ?? null,
                'enrollment_date' => now(),
            ]);

            $enrollment->save();

            return redirect()->route('students.index')
                ->with('success', 'Student enrolled successfully in ' . $validated['grade_level'] . ' - ' . $section->name . '!');
                
        } catch (\Exception $e) {
            \Log::error('Enrollment failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to enroll student: ' . $e->getMessage());
        }
    }

    /**
     * Get student status for display
     */
    private function getStudentStatus($student)
    {
        $latestEnrollment = $student->enrollments->sortByDesc('created_at')->first();
        
        if (!$latestEnrollment) {
            return 'registered';
        }

        return strtolower($latestEnrollment->status);
    }

    /**
     * Get student type for display
     */
    private function getStudentType($student)
    {
        $latestEnrollment = $student->enrollments->sortByDesc('created_at')->first();
        
        if (!$latestEnrollment) {
            return 'new';
        }

        return strtolower($latestEnrollment->enrollment_type);
    }
    /**
 * Display academic record for a student
 */
public function academicRecord($lrn)
{
    $student = Student::where('lrn', $lrn)
        ->with([
            'enrollments.section',
            'familyContacts',
            'currentAddress',
            'permanentAddress'
        ])
        ->firstOrFail();

    // Get current enrollment
    $currentEnrollment = $student->enrollments
        ->sortByDesc('created_at')
        ->first();

    // Sample subjects structure (you can replace this with your actual subjects later)
    $sampleSubjects = [
        ['code' => 'MATH', 'name' => 'Mathematics', 'grade' => null, 'teacher' => 'TBA'],
        ['code' => 'SCI', 'name' => 'Science', 'grade' => null, 'teacher' => 'TBA'],
        ['code' => 'ENG', 'name' => 'English', 'grade' => null, 'teacher' => 'TBA'],
        ['code' => 'FIL', 'name' => 'Filipino', 'grade' => null, 'teacher' => 'TBA'],
        ['code' => 'AP', 'name' => 'Araling Panlipunan', 'grade' => null, 'teacher' => 'TBA'],
        ['code' => 'PE', 'name' => 'Physical Education', 'grade' => null, 'teacher' => 'TBA'],
        ['code' => 'ARTS', 'name' => 'Arts', 'grade' => null, 'teacher' => 'TBA'],
        ['code' => 'TLE', 'name' => 'Technology and Livelihood Education', 'grade' => null, 'teacher' => 'TBA'],
    ];

    return view('students.academic-record', compact(
        'student', 
        'currentEnrollment',
        'sampleSubjects'
    ));
}
}