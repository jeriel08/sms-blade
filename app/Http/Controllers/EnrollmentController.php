<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Settings;
use App\Models\Section;
use App\Models\Address;
use App\Models\FamilyContact;
use App\Models\Disability;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
        $teachersByGrade = Teacher::whereNotNull('assigned_grade_level')
            ->orWhereNull('assigned_grade_level')
            ->get()  // <-- Add this to execute the query and get a Collection
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
        // User's assigned grade level (default to 7 if none)
        $user = Auth::user();
        $assignedGrade = $user?->assigned_grade_level ?? 7;

        // Initial disabilities (from DB)
        $disabilities = Disability::all()->pluck('name')->toArray();

        return view('enrollments.settings', compact('schoolYear', 'sectionsByGrade', 'teachersByGrade', 'assignedGrade', 'disabilities'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $studentType = $request->query('type', 'new');
        $currentStep = $request->query('step', 'learner');

        // Define valid steps based on student type
        $validSteps = ['learner', 'address', 'guardian', 'review'];
        if ($studentType === 'transferee') {
            $validSteps = ['learner', 'address', 'guardian', 'school', 'review'];
        }

        // Validate current step
        if (!in_array($currentStep, $validSteps)) {
            $currentStep = 'learner';
        }

        // Get disabilities from database for dynamic rendering
        $disabilities = Disability::orderBy('name')->get();

        return view('enrollments.create', [
            'studentType' => $studentType,
            'currentStep' => $currentStep,
            'disabilities' => $disabilities,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate all data at once when submitting
        $validated = $request->validate([
            // Learner Information
            'lrn' => 'required|string|max:12|unique:students,lrn',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'extension_name' => 'nullable|string|max:10',
            'birthdate' => 'required|date',
            'place_of_birth' => 'nullable|string|max:200',
            'gender' => 'required|in:male,female',
            'age' => 'required|integer|min:4|max:25',
            'mother_tounge' => 'nullable|string|max:50',
            'psa_birth_certification_no' => 'nullable|string|max:20',
            'with_lrn' => 'required|in:yes,no',
            'returning' => 'required|in:yes,no',
            'ip_community_member' => 'required|in:yes,no',
            'ip_community' => 'nullable|required_if:ip_community_member,yes|string|max:100',
            '4ps_beneficiary' => 'required|in:yes,no',
            '4ps_household_id' => 'nullable|required_if:4ps_beneficiary,yes|string|max:20',
            'is_disabled' => 'required|in:yes,no',
            'disabilities' => 'nullable|array',
            'disabilities.*' => 'exists:disabilities,disability_id',

            // Current Address
            'house_number' => 'nullable|string|max:50',
            'street_name' => 'required|string|max:100',
            'barangay' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'zip_code' => 'required|string|max:10',

            // Permanent Address
            'same_as_current_address' => 'required|in:0,1',
            'permanent_house_number' => 'nullable|required_if:same_as_current_address,0|string|max:50',
            'permanent_street_name' => 'nullable|required_if:same_as_current_address,0|string|max:100',
            'permanent_barangay' => 'nullable|required_if:same_as_current_address,0|string|max:100',
            'permanent_city' => 'nullable|required_if:same_as_current_address,0|string|max:100',
            'permanent_province' => 'nullable|required_if:same_as_current_address,0|string|max:100',
            'permanent_country' => 'nullable|required_if:same_as_current_address,0|string|max:100',
            'permanent_zip_code' => 'nullable|required_if:same_as_current_address,0|string|max:10',

            // Guardian Information
            'father_last_name' => 'required|string|max:100',
            'father_first_name' => 'required|string|max:100',
            'father_middle_name' => 'nullable|string|max:100',
            'father_contact_number' => 'required|string|max:20',

            'mother_last_name' => 'required|string|max:100',
            'mother_first_name' => 'required|string|max:100',
            'mother_middle_name' => 'nullable|string|max:100',
            'mother_contact_number' => 'required|string|max:20',

            'legal_guardian_last_name' => 'nullable|string|max:100',
            'legal_guardian_first_name' => 'nullable|string|max:100',
            'legal_guardian_middle_name' => 'nullable|string|max:100',
            'legal_guardian_contact_number' => 'nullable|string|max:20',

            // School Information (for transferees)
            'last_grade_level_completed' => 'nullable|string|max:10',
            'last_school_year_completed' => 'nullable|string|max:9',
            'last_school_attended' => 'nullable|string|max:200',
            'school_id' => 'nullable|string|max:20',
            'semester' => 'nullable|in:first_sem,second_sem',
            'track' => 'nullable|string|max:100',
            'strand' => 'nullable|string|max:100',

            // Student type
            'student_type' => 'required|in:new,old,transferee',
        ]);

        try {
            DB::beginTransaction();

            // Generate student ID
            $studentId = 'STU' . date('Y') . strtoupper(Str::random(6));

            // 1. Create Current Address
            $currentAddress = Address::create([
                'house_no' => $validated['house_number'],
                'street_name' => $validated['street_name'],
                'barangay' => $validated['barangay'],
                'municipality_city' => $validated['city'],
                'province' => $validated['province'],
                'country' => $validated['country'],
                'zip_code' => $validated['zip_code'],
            ]);

            // 2. Create Permanent Address
            if ($validated['same_as_current_address'] == 1) {
                $permanentAddress = $currentAddress;
            } else {
                $permanentAddress = Address::create([
                    'house_no' => $validated['permanent_house_number'],
                    'street_name' => $validated['permanent_street_name'],
                    'barangay' => $validated['permanent_barangay'],
                    'municipality_city' => $validated['permanent_city'],
                    'province' => $validated['permanent_province'],
                    'country' => $validated['permanent_country'],
                    'zip_code' => $validated['permanent_zip_code'],
                ]);
            }

            // 3. Create Student
            $student = Student::create([
                'student_id' => $studentId,
                'lrn' => $validated['lrn'],
                'last_name' => $validated['last_name'],
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'extension_name' => $validated['extension_name'] ?? null,
                'birthdate' => $validated['birthdate'],
                'place_of_birth' => $validated['place_of_birth'] ?? null,
                'sex' => $validated['gender'],
                'mother_tounge' => $validated['mother_tounge'] ?? null,
                'psa_birth_cert_no' => $validated['psa_birth_certification_no'] ?? null,
                'is_ip' => $validated['ip_community_member'] == 'yes',
                'ip_community' => $validated['ip_community'] ?? null,
                'current_address_id' => $currentAddress->address_id,
                'permanent_address_id' => $permanentAddress->address_id,
                'is_disabled' => $validated['is_disabled'] == 'yes',
            ]);

            // 4. Create Family Contacts
            $familyContacts = [];

            // Father
            $familyContacts[] = [
                'student_id' => $studentId,
                'contact_type' => 'father',
                'last_name' => $validated['father_last_name'],
                'first_name' => $validated['father_first_name'],
                'middle_name' => $validated['father_middle_name'] ?? null,
                'contact_number' => $validated['father_contact_number'],
            ];

            // Mother
            $familyContacts[] = [
                'student_id' => $studentId,
                'contact_type' => 'mother',
                'last_name' => $validated['mother_last_name'],
                'first_name' => $validated['mother_first_name'],
                'middle_name' => $validated['mother_middle_name'] ?? null,
                'contact_number' => $validated['mother_contact_number'],
            ];

            // Legal Guardian (if provided)
            if (!empty($validated['legal_guardian_first_name'])) {
                $familyContacts[] = [
                    'student_id' => $studentId,
                    'contact_type' => 'legal_guardian',
                    'last_name' => $validated['legal_guardian_last_name'],
                    'first_name' => $validated['legal_guardian_first_name'],
                    'middle_name' => $validated['legal_guardian_middle_name'] ?? null,
                    'contact_number' => $validated['legal_guardian_contact_number'],
                ];
            }

            FamilyContact::insert($familyContacts);

            // 5. Create Enrollment
            $schoolYear = Settings::where('key', 'school_year')->value('value') ?? '2024-2025';

            $enrollmentData = [
                'student_id' => $studentId,
                'school_year' => $schoolYear,
                'grade_level' => '7', // You might want to make this dynamic
                'enrollment_type' => $validated['student_type'],
                'is_4ps' => $validated['4ps_beneficiary'] == 'yes',
                '_4ps_household_id' => $validated['4ps_household_id'] ?? null,
                'enrollment_date' => now(),
            ];

            // Add school info for transferees
            if ($validated['student_type'] === 'transferee') {
                $enrollmentData = array_merge($enrollmentData, [
                    'last_grade_completed' => $validated['last_grade_level_completed'] ?? null,
                    'last_school_year_completed' => $validated['last_school_year_completed'] ?? null,
                    'last_school_attended' => $validated['last_school_attended'] ?? null,
                    'last_school_id' => $validated['school_id'] ?? null,
                    'semester' => $validated['semester'] ?? null,
                    'track' => $validated['track'] ?? null,
                    'strand' => $validated['strand'] ?? null,
                ]);
            }

            $enrollment = Enrollment::create($enrollmentData);

            // 6. Handle Disabilities
            if ($validated['is_disabled'] == 'yes' && !empty($request->disabilities)) {
                $student->disabilities()->attach($request->disabilities);
            }

            DB::commit();

            // Clear session storage
            session()->forget('enrollment_form_data');

            return redirect()->route('enrollments.index')
                ->with('success', 'Student enrolled successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to enroll student: ' . $e->getMessage())
                ->withInput();
        }
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
