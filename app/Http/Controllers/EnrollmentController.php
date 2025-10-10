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
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        $studentType = $request->query('type', session('enrollment_form_data.student_type', 'new'));
        $currentStep = $request->query('step', 'learner');

        // Validate student_type
        if (!in_array($studentType, ['new', 'transferee', 'balik_aral'])) {
            \Log::warning('Invalid student_type: ' . $studentType);
            $studentType = 'new'; // Fallback
        }

        $validSteps = ['learner', 'address', 'guardian', 'review'];
        if ($studentType === 'transferee') {
            $validSteps = ['learner', 'address', 'guardian', 'school', 'review'];
        }

        if (!in_array($currentStep, $validSteps)) {
            $currentStep = 'learner';
        }

        if ($request->isMethod('post')) {
            if ($request->input('action') === 'submit' && $currentStep === 'review') {
                return $this->store($request);
            }

            $this->saveStepData($request, $currentStep);

            $action = $request->input('action');
            $nextStep = ($action === 'next') ? $this->getNextStep($currentStep, $validSteps) : $this->getPreviousStep($currentStep, $validSteps);

            if ($nextStep) {
                return redirect()->route('enrollments.create', ['type' => $studentType, 'step' => $nextStep]);
            }
        }

        $disabilities = Disability::orderBy('name')->get();
        $formData = session('enrollment_form_data', []);
        $schoolYear = Settings::where('key', 'school_year')->value('value') ?? '2024-2025';

        return view('enrollments.create', [
            'studentType' => $studentType,
            'currentStep' => $currentStep,
            'disabilities' => $disabilities,
            'formData' => $formData,
            'schoolYear'=> $schoolYear,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Get session data and merge with current request data
            $formData = session('enrollment_form_data', []);
            $formData = array_merge($formData, $request->only(['declaration']));

            // Log form data for debugging
            \Log::info('Form data before validation:', $formData);

            // Validate all data together
            $rules = array_merge(
                $this->getValidationRules('learner'),
                $this->getValidationRules('address'),
                $this->getValidationRules('guardian'),
                $request->student_type === 'transferee' ? $this->getValidationRules('school') : [],
                $this->getValidationRules('review')
            );
            $validator = Validator::make($formData, $rules);
            
            if ($validator->fails()) {
                \Log::info('Validation errors in store:', $validator->errors()->all());
                return back()->with('error', 'Failed to enroll student: ' . implode(' ', $validator->errors()->all()))->withInput();
            }

            $validated = $validator->validated();

            // Create current address
            $currentAddress = Address::create([
                'house_no' => $validated['house_number'],
                'street_name' => $validated['street_name'],
                'barangay' => $validated['barangay'],
                'municipality_city' => $validated['city'],
                'province' => $validated['province'],
                'country' => $validated['country'],
                'zip_code' => $validated['zip_code'],
            ]);

            // Create permanent address
            $permanentAddress = $currentAddress;
            if ($validated['same_as_current_address'] == 0) {
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

            // Create student
            $studentData = [
                'lrn' => $validated['lrn'],
                'last_name' => $validated['last_name'],
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'extension_name' => $validated['extension_name'] ?? null,
                'birthdate' => $validated['birthdate'],
                'place_of_birth' => $validated['place_of_birth'] ?? null,
                'sex' => $validated['gender'],
                'mother_tongue' => $validated['mother_tongue'] ?? null,
                'psa_birth_cert_no' => $validated['psa_birth_certification_no'] ?? null,
                'is_ip' => $validated['ip_community_member'],
                'ip_community' => $validated['ip_community'] ?? null,
                'current_address_id' => $currentAddress->address_id,
                'permanent_address_id' => $permanentAddress->address_id,
                'is_disabled' => $validated['is_disabled'],
            ];
            $student = Student::create($studentData);
            $studentId = $student->student_id;

            // Create family contacts
            $familyContacts = [
                [
                    'student_id' => $studentId,
                    'contact_type' => 'father',
                    'last_name' => $validated['father_last_name'],
                    'first_name' => $validated['father_first_name'],
                    'middle_name' => $validated['father_middle_name'] ?? null,
                    'contact_number' => $validated['father_contact_number'],
                ],
                [
                    'student_id' => $studentId,
                    'contact_type' => 'mother',
                    'last_name' => $validated['mother_last_name'],
                    'first_name' => $validated['mother_first_name'],
                    'middle_name' => $validated['mother_middle_name'] ?? null,
                    'contact_number' => $validated['mother_contact_number'],
                ],
            ];
            if (!empty($validated['legal_guardian_first_name'])) {
                $familyContacts[] = [
                    'student_id' => $studentId,
                    'contact_type' => 'guardian',
                    'last_name' => $validated['legal_guardian_last_name'],
                    'first_name' => $validated['legal_guardian_first_name'],
                    'middle_name' => $validated['legal_guardian_middle_name'] ?? null,
                    'contact_number' => $validated['legal_guardian_contact_number'],
                ];
            }
            FamilyContact::insert($familyContacts);

            // Create enrollment
            $schoolYear = Settings::where('key', 'school_year')->value('value') ?? '2024-2025';
            $enrollmentData = [
                'student_id' => $studentId,
                'school_year' => $schoolYear,
                'enrollment_type' => $validated['student_type'],
                'is_4ps' => $validated['4ps_beneficiary'],
                '_4ps_household_id' => $validated['4ps_household_id'] ?? null,
                'enrollment_date' => now(),
            ];
            if ($validated['student_type'] === 'transferee') {
                $enrollmentData['last_grade_level'] = $validated['last_grade_level_completed'] ?? null;
                $enrollmentData['last_school_year'] = $validated['last_school_year_completed'] ?? null;
                $enrollmentData['last_school_attended'] = $validated['last_school_attended'] ?? null;
                $enrollmentData['school_id'] = $validated['school_id'] ?? null;
                $enrollmentData['semester'] = $validated['semester'] ?? null;
                $enrollmentData['track'] = $validated['track'] ?? null;
                $enrollmentData['strand'] = $validated['strand'] ?? null;
            }
            $enrollment = Enrollment::create($enrollmentData);

            // Handle disabilities
            if ($validated['is_disabled'] == 1 && !empty($formData['disabilities'])) {
                $student->disabilities()->attach($formData['disabilities']);
            }

            DB::commit();

            // Clear session data
            session()->forget('enrollment_form_data');

            return redirect()->route('enrollments.index')
                ->with('success', 'Student enrolled successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Enrollment failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data' => $formData,
            ]);
            return back()->with('error', 'Failed to enroll student: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Enrollment $enrollment)
    {
        return view('enrollments.show', compact('enrollment'));
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

    public function assignGradeAndSection(Request $request, Enrollment $enrollment)
    {
        try {
            $validated = $request->validate([
                'grade_level' => 'required|string|in:7,8,9,10,11,12',
                'section_id' => 'required|exists:sections,section_id',
            ]);

            $section = Section::where('section_id', $validated['section_id'])
                ->where('grade_level', $validated['grade_level'])
                ->first();

            if (!$section) {
                throw new \Exception('Selected section does not match the grade level');
            }

            $enrollment->update([
                'grade_level' => $validated['grade_level'],
                'section_id' => $validated['section_id'],
                'status' => 'Enrolled',
                'enrolled_by_teacher_id' => auth()->user()->teacher_id ?? null,
            ]);

            Log::info('Assigned grade and section for enrollment: ' . $enrollment->enrollment_id, [
                'grade_level' => $validated['grade_level'],
                'section_id' => $validated['section_id'],
                'status' => 'Enrolled',
            ]);

            return redirect()->route('enrollments.index')
                ->with('success', 'Grade and section assigned successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to assign grade and section: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data' => $request->all(),
            ]);
            return back()->with('error', 'Failed to assign grade and section: ' . $e->getMessage());
        }
    }

    // Helper to save step data to session
    /**
     * Save form data for the current step to session
     */
    protected function saveStepData(Request $request, $currentStep)
    {
        // Get existing session data or initialize empty array
        $formData = session('enrollment_form_data', []);

        // Define validation rules for each step
        $rules = $this->getValidationRules($currentStep);

        // Validate the incoming data
        $validated = $request->validate($rules);

        // Merge validated data with existing session data
        $formData = array_merge($formData, $validated);

        // Handle disabilities separately (store only checked ones)
        if ($currentStep === 'learner' && isset($request->disabilities)) {
            $formData['disabilities'] = array_keys(array_filter($request->disabilities, fn($value) => $value == '1'));
        }

        // Ensure ip_community is cleared if ip_community_member is 0
        if ($currentStep === 'learner' && isset($validated['ip_community_member']) && $validated['ip_community_member'] == 0) {
            $formData['ip_community'] = null;
        }

        // Ensure school_year is always saved
        if ($currentStep === 'learner') {
            $formData['school_year'] = Settings::where('key', 'school_year')->value('value') ?? '2024-2025';
        }

        // Save merged data to session
        session()->put('enrollment_form_data', $formData);

        // Flash input for validation errors (if any)
        session()->flashInput($request->input());
    }

    /**
     * Get validation rules for the current step
     */
    protected function getValidationRules($currentStep)
    {
        $rules = [
            'learner' => [
                'student_type' => 'required|in:new,old,transferee,balik_aral',
                'school_year' => 'required|string|max:20',
                'with_lrn' => 'required|boolean',
                'returning' => 'required|boolean',
                'psa_birth_certification_no' => 'nullable|string|max:20',
                'lrn' => 'required_if:with_lrn,1|string|size:12|unique:students,lrn',
                'first_name' => 'required|string|max:50',
                'birthdate' => 'required|date|before:today',
                'place_of_birth' => 'nullable|string|max:100',
                'last_name' => 'required|string|max:50',
                'gender' => 'required|in:male,female,other',
                'age' => 'required|integer|min:1',
                'mother_tongue' => 'nullable|string|max:100',
                'middle_name' => 'nullable|string|max:50',
                'ip_community_member' => 'required|boolean',
                'ip_community' => 'nullable|required_if:ip_community_member,1|string|max:100',
                'extension_name' => 'nullable|string|max:10',
                '4ps_beneficiary' => 'required|boolean',
                '4ps_household_id' => 'required_if:4ps_beneficiary,1|string|max:20',
                'is_disabled' => 'required|boolean',
                'disabilities.*' => 'nullable|exists:disabilities,disability_id',
            ],
            'address' => [
                'house_number' => 'nullable|string|max:50',
                'street_name' => 'required|string|max:100',
                'barangay' => 'required|string|max:100',
                'city' => 'required|string|max:100',
                'province' => 'required|string|max:100',
                'country' => 'required|string|max:100',
                'zip_code' => 'required|string|max:10',
                'same_as_current_address' => 'required|boolean',
                'permanent_house_number' => 'required_if:same_as_current_address,0|string|max:50',
                'permanent_street_name' => 'required_if:same_as_current_address,0|string|max:100',
                'permanent_barangay' => 'required_if:same_as_current_address,0|string|max:100',
                'permanent_city' => 'required_if:same_as_current_address,0|string|max:100',
                'permanent_province' => 'required_if:same_as_current_address,0|string|max:100',
                'permanent_country' => 'required_if:same_as_current_address,0|string|max:100',
                'permanent_zip_code' => 'required_if:same_as_current_address,0|string|max:10',
            ],
            'guardian' => [
                'father_last_name' => 'required|string|max:50',
                'father_first_name' => 'required|string|max:50',
                'father_middle_name' => 'nullable|string|max:50',
                'father_contact_number' => 'required|string|max:20',
                'mother_last_name' => 'required|string|max:50',
                'mother_first_name' => 'required|string|max:50',
                'mother_middle_name' => 'nullable|string|max:50',
                'mother_contact_number' => 'required|string|max:20',
                'legal_guardian_last_name' => 'nullable|string|max:50',
                'legal_guardian_first_name' => 'nullable|string|max:50',
                'legal_guardian_middle_name' => 'nullable|string|max:50',
                'legal_guardian_contact_number' => 'nullable|string|max:20',
            ],
            'school' => [
                'last_grade_level_completed' => 'nullable|string|max:50',
                'last_school_year_completed' => 'nullable|string|max:20',
                'last_school_attended' => 'nullable|string|max:100',
                'school_id' => 'nullable|string|max:20',
                'semester' => 'nullable|in:first_sem,second_sem',
                'track' => 'nullable|string|max:100',
                'strand' => 'nullable|string|max:100',
            ],
            'review' => [
                'declaration' => 'required|accepted',
            ],
        ];

        return $rules[$currentStep] ?? [];
    }

    /**
     * Get the next step in the form
     */
    protected function getNextStep($currentStep, $validSteps)
    {
        $currentIndex = array_search($currentStep, $validSteps);
        if ($currentIndex === false || $currentIndex >= count($validSteps) - 1) {
            return null;
        }
        return $validSteps[$currentIndex + 1];
    }

    /**
     * Get the previous step in the form
     */
    protected function getPreviousStep($currentStep, $validSteps)
    {
        $currentIndex = array_search($currentStep, $validSteps);
        if ($currentIndex === false || $currentIndex <= 0) {
            return null;
        }
        return $validSteps[$currentIndex - 1];
    }
}
