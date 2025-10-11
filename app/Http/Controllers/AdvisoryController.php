<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Student;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdvisoryController extends Controller
{
    /**
     * Display the advisory class page
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Check if user has a teacher record and is an adviser
        if (!$user->teacher) {
            return redirect()->route('dashboard')
                ->with('error', 'You are not registered as a teacher.');
        }

        // Get the section where this teacher is an adviser
        $advisorySection = Section::where('adviser_teacher_id', $user->teacher->teacher_id)
            ->with(['adviser'])
            ->first();

        if (!$advisorySection) {
            return view('advisory.index', [
                'advisorySection' => null,
                'students' => collect([]),
                'currentSort' => 'name_asc',
            ]);
        }

        // Build query for students in this section
        $query = Student::query()
            ->join('enrollments', 'students.student_id', '=', 'enrollments.student_id')
            ->where('enrollments.section_id', $advisorySection->section_id)
            ->where('enrollments.status', 'Enrolled')
            ->select('students.*', 'enrollments.enrollment_id', 'enrollments.grade_level');

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

        // Sort functionality
        $sortBy = $request->get('sort_by', 'name_asc');
        switch ($sortBy) {
            case 'name_asc':
                $query->orderBy('students.last_name', 'asc')
                    ->orderBy('students.first_name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('students.last_name', 'desc')
                    ->orderBy('students.first_name', 'desc');
                break;
            case 'lrn_asc':
                $query->orderBy('students.lrn', 'asc');
                break;
            case 'lrn_desc':
                $query->orderBy('students.lrn', 'desc');
                break;
            case 'gender_asc':
                $query->orderBy('students.sex', 'asc');
                break;
            case 'gender_desc':
                $query->orderBy('students.sex', 'desc');
                break;
            default:
                $query->orderBy('students.last_name', 'asc')
                    ->orderBy('students.first_name', 'asc');
        }

        $students = $query->paginate(10)->appends($request->query());
        $currentSort = $sortBy;

        // Get total student count
        $totalStudents = Enrollment::where('section_id', $advisorySection->section_id)
            ->where('status', 'Enrolled')
            ->count();

        return view('advisory.index', compact(
            'advisorySection',
            'students',
            'currentSort',
            'totalStudents'
        ));
    }

    /**
     * Remove a student from the advisory section
     */
    public function removeStudent(Request $request, $lrn)
    {
        try {
            $user = Auth::user();
            
            if (!$user->teacher) {
                return back()->with('error', 'You are not authorized to perform this action.');
            }

            // Get the advisory section
            $advisorySection = Section::where('adviser_teacher_id', $user->teacher->teacher_id)->first();
            
            if (!$advisorySection) {
                return back()->with('error', 'You do not have an advisory section.');
            }

            // Find the student
            $student = Student::where('lrn', $lrn)->firstOrFail();

            // Find the enrollment
            $enrollment = Enrollment::where('student_id', $student->student_id)
                ->where('section_id', $advisorySection->section_id)
                ->where('status', 'Enrolled')
                ->first();

            if (!$enrollment) {
                return back()->with('error', 'Student is not enrolled in your advisory section.');
            }

            // Update enrollment status to inactive or remove section assignment
            $enrollment->update([
                'status' => 'Inactive',
                'section_id' => null,
            ]);

            return redirect()->route('advisory.index')
                ->with('success', 'Student removed from advisory section successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to remove student from advisory: ' . $e->getMessage());
            return back()->with('error', 'Failed to remove student: ' . $e->getMessage());
        }
    }
}