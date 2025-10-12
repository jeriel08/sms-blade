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
     * Show the form for creating a new enrollment (handles both GET and POST).
     */
    public function create(Request $request)
    {
        // Get student type and step from query parameters
        $studentType = $request->query('type', 'new');
        $currentStep = $request->query('step', 'learner');
        $lrn = $request->query('lrn');

        // Validate student type and step
        $validTypes = ['new', 'old', 'transferee', 'balik_aral'];
        $validSteps = ($studentType === 'transferee')
            ? ['learner', 'address', 'guardian', 'school', 'review']
            : ['learner', 'address', 'guardian', 'review'];

        if (!in_array($studentType, $validTypes)) {
            return redirect()->route('enrollments.index')->with('error', 'Invalid student type.');
        }
        if (!in_array($currentStep, $validSteps)) {
            return redirect()->route('enrollments.create', ['type' => $studentType, 'step' => 'learner']);
        }

        // Fetch school year
        $schoolYear = Settings::where('key', 'school_year')->value('value') ?? '2024-2025';

        // Initialize form data from session
        $formData = session('enrollment_form_data', []);

        // Set defaults
        $formData['student_type'] = $studentType;
        $formData['school_year'] = $schoolYear;

        // Pre-fill student data if LRN is provided (for old/returning)
        if ($lrn && in_array($studentType, ['old', 'balik_aral'])) {
            $student = Student::where('lrn', $lrn)->first();
            if ($student) {
                $formData['lrn'] = $student->lrn;
                $formData['first_name'] = $student->first_name;
                $formData['middle_name'] = $student->middle_name;
                $formData['last_name'] = $student->last_name;
                $formData['extension_name'] = $student->extension_name;
                $formData['birthdate'] = $student->birthdate;
                $formData['gender'] = $student->sex;
                $formData['place_of_birth'] = $student->place_of_birth;
                $formData['mother_tongue'] = $student->mother_tongue;
                $formData['psa_birth_certification_no'] = $student->psa_birth_cert_no;
                $formData['ip_community_member'] = $student->is_ip ? '1' : '0';
                $formData['ip_community'] = $student->ip_community;
                $formData['is_disabled'] = $student->is_disabled ? '1' : '0';

                // Fetch related address and family contact data
                $currentAddress = $student->currentAddress;
                if ($currentAddress) {
                    $formData['house_number'] = $currentAddress->house_no;
                    $formData['street_name'] = $currentAddress->street_name;
                    $formData['barangay'] = $currentAddress->barangay;
                    $formData['city'] = $currentAddress->municipality_city;
                    $formData['province'] = $currentAddress->province;
                    $formData['country'] = $currentAddress->country;
                    $formData['zip_code'] = $currentAddress->zip_code;
                }

                $permanentAddress = $student->permanentAddress;
                if ($permanentAddress && $permanentAddress->address_id !== $currentAddress?->address_id) {
                    $formData['same_as_current_address'] = '0';
                    $formData['permanent_house_number'] = $permanentAddress->house_no;
                    $formData['permanent_street_name'] = $permanentAddress->street_name;
                    $formData['permanent_barangay'] = $permanentAddress->barangay;
                    $formData['permanent_city'] = $permanentAddress->municipality_city;
                    $formData['permanent_province'] = $permanentAddress->province;
                    $formData['permanent_country'] = $permanentAddress->country;
                    $formData['permanent_zip_code'] = $permanentAddress->zip_code;
                } else {
                    $formData['same_as_current_address'] = '1';
                }

                $familyContacts = $student->familyContacts;
                foreach ($familyContacts as $contact) {
                    if ($contact->contact_type === 'father') {
                        $formData['father_first_name'] = $contact->first_name;
                        $formData['father_middle_name'] = $contact->middle_name;
                        $formData['father_last_name'] = $contact->last_name;
                        $formData['father_contact_number'] = $contact->contact_number;
                    } elseif ($contact->contact_type === 'mother') {
                        $formData['mother_first_name'] = $contact->first_name;
                        $formData['mother_middle_name'] = $contact->middle_name;
                        $formData['mother_last_name'] = $contact->last_name;
                        $formData['mother_contact_number'] = $contact->contact_number;
                    } elseif ($contact->contact_type === 'guardian') {
                        $formData['legal_guardian_first_name'] = $contact->first_name;
                        $formData['legal_guardian_middle_name'] = $contact->middle_name;
                        $formData['legal_guardian_last_name'] = $contact->last_name;
                        $formData['legal_guardian_contact_number'] = $contact->contact_number;
                    }
                }
            } else {
                return redirect()->route('enrollments.create', ['type' => $studentType, 'step' => 'learner'])
                    ->with('error', 'Student not found with the provided LRN.');
            }
        }

        // Handle POST request (form submission)
        if ($request->isMethod('post')) {
            // Get validation rules for the current step
            $rules = $this->getValidationRules($currentStep);

            // Validate input
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Merge validated data into formData
            $formData = array_merge($formData, $validator->validated());

            // Handle action (next, previous, submit)
            $action = $request->input('action');
            if ($action === 'submit' && $currentStep !== 'review') {
                return redirect()->back()->with('error', 'Submission is only allowed on the review step.');
            }

            $nextStep = $this->getNextStep($currentStep, $validSteps);
            $previousStep = $this->getPreviousStep($currentStep, $validSteps);

            // Determine redirect based on action
            if ($action === 'next' && $nextStep) {
                session(['enrollment_form_data' => $formData]);
                return redirect()->route('enrollments.create', ['type' => $studentType, 'step' => $nextStep]);
            } elseif ($action === 'previous' && $previousStep) {
                session(['enrollment_form_data' => $formData]);
                return redirect()->route('enrollments.create', ['type' => $studentType, 'step' => $previousStep]);
            } elseif ($action === 'submit' && $currentStep === 'review') {
                // Start transaction for saving data
                DB::beginTransaction();
                try {
                    // Create or update student
                    $studentData = [
                        'lrn' => $formData['lrn'] ?? null,
                        'first_name' => $formData['first_name'],
                        'middle_name' => $formData['middle_name'] ?? null,
                        'last_name' => $formData['last_name'],
                        'extension_name' => $formData['extension_name'] ?? null,
                        'birthdate' => $formData['birthdate'],
                        'sex' => $formData['gender'],
                        'place_of_birth' => $formData['place_of_birth'] ?? null,
                        'mother_tongue' => $formData['mother_tongue'] ?? null,
                        'psa_birth_cert_no' => $formData['psa_birth_certification_no'] ?? null,
                        'is_ip' => $formData['ip_community_member'] === '1',
                        'ip_community' => $formData['ip_community'] ?? null,
                        'is_disabled' => $formData['is_disabled'] === '1',
                    ];

                    $student = Student::updateOrCreate(
                        ['lrn' => $formData['lrn'] ?? null],
                        $studentData
                    );

                    // Save disabilities
                    if (!empty($formData['disabilities'])) {
                        $student->disabilities()->sync(array_keys($formData['disabilities']));
                    } else {
                        $student->disabilities()->detach();
                    }

                    // Save current address
                    $currentAddressData = [
                        'house_no' => $formData['house_number'] ?? null,
                        'street_name' => $formData['street_name'],
                        'barangay' => $formData['barangay'],
                        'municipality_city' => $formData['city'],
                        'province' => $formData['province'],
                        'country' => $formData['country'],
                        'zip_code' => $formData['zip_code'],
                    ];

                    $currentAddress = Address::create($currentAddressData);

                    // Save permanent address
                    $permanentAddressData = $formData['same_as_current_address'] === '1' ? $currentAddressData : [
                        'house_no' => $formData['permanent_house_number'] ?? null,
                        'street_name' => $formData['permanent_street_name'],
                        'barangay' => $formData['permanent_barangay'],
                        'municipality_city' => $formData['permanent_city'],
                        'province' => $formData['permanent_province'],
                        'country' => $formData['permanent_country'],
                        'zip_code' => $formData['permanent_zip_code'],
                    ];

                    $permanentAddress = Address::create($permanentAddressData);

                    // Update student with address IDs
                    $student->update([
                        'current_address_id' => $currentAddress->address_id,
                        'permanent_address_id' => $permanentAddress->address_id,
                    ]);

                    // Save family contacts (father, mother, guardian)
                    $familyContacts = [];

                    // Father
                    if (!empty($formData['father_first_name']) || !empty($formData['father_last_name'])) {
                        $familyContacts[] = [
                            'student_id' => $student->student_id,
                            'contact_type' => 'father',
                            'first_name' => $formData['father_first_name'],
                            'middle_name' => $formData['father_middle_name'] ?? null,
                            'last_name' => $formData['father_last_name'],
                            'contact_number' => $formData['father_contact_number'],
                        ];
                    }

                    // Mother
                    if (!empty($formData['mother_first_name']) || !empty($formData['mother_last_name'])) {
                        $familyContacts[] = [
                            'student_id' => $student->student_id,
                            'contact_type' => 'mother',
                            'first_name' => $formData['mother_first_name'],
                            'middle_name' => $formData['mother_middle_name'] ?? null,
                            'last_name' => $formData['mother_last_name'],
                            'contact_number' => $formData['mother_contact_number'],
                        ];
                    }

                    // Guardian (if provided)
                    if (!empty($formData['legal_guardian_first_name']) || !empty($formData['legal_guardian_last_name'])) {
                        $familyContacts[] = [
                            'student_id' => $student->student_id,
                            'contact_type' => 'guardian',
                            'first_name' => $formData['legal_guardian_first_name'],
                            'middle_name' => $formData['legal_guardian_middle_name'] ?? null,
                            'last_name' => $formData['legal_guardian_last_name'],
                            'contact_number' => $formData['legal_guardian_contact_number'],
                        ];
                    }

                    // Delete existing contacts and create new ones
                    FamilyContact::where('student_id', $student->student_id)->delete();
                    foreach ($familyContacts as $contactData) {
                        FamilyContact::create($contactData);
                    }

                    // Save enrollment
                    $enrollmentData = [
                        'student_id' => $student->student_id,
                        'school_year' => $formData['school_year'],
                        'grade_level' => $formData['grade_level'] ?? null,
                        'enrollment_type' => $studentType,
                        'status' => 'Registered',
                        'is_4ps' => $formData['4ps_beneficiary'] === '1',
                        '_4ps_household_id' => $formData['4ps_household_id'] ?? null,
                    ];

                    if ($studentType === 'transferee') {
                        $enrollmentData['last_grade_completed'] = $formData['last_grade_level_completed'] ?? null;
                        $enrollmentData['last_school_year_completed'] = $formData['last_school_year_completed'] ?? null;
                        $enrollmentData['last_school_attended'] = $formData['last_school_attended'] ?? null;
                        $enrollmentData['last_school_id'] = $formData['school_id'] ?? null;
                        $enrollmentData['semester'] = $formData['semester'] ?? null;
                        $enrollmentData['track'] = $formData['track'] ?? null;
                        $enrollmentData['strand'] = $formData['strand'] ?? null;
                    }

                    Enrollment::create($enrollmentData);

                    DB::commit();

                    // Clear session data
                    $request->session()->forget('enrollment_form_data');

                    return redirect()->route('enrollments.index')->with('success', 'Enrollment completed successfully.');
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Enrollment failed: ' . $e->getMessage());
                    return redirect()->back()->with('error', 'Failed to complete enrollment: ' . $e->getMessage());
                }
            }

            // If no action or invalid, return to current step
            return view('enrollments.create', compact('studentType', 'currentStep', 'formData', 'disabilities'));
        }

        // For GET requests (initial form load)
        $disabilities = Disability::all();

        return view('enrollments.create', compact('studentType', 'currentStep', 'formData', 'disabilities'));
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
            Log::info('Form data before validation:', $formData);

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
                Log::info('Validation errors in store:', $validator->errors()->all());
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
            Log::error('Enrollment failed: ' . $e->getMessage(), [
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

    public function searchStudentByLrn(Request $request)
    {
        $request->validate(['lrn' => 'required|digits:12']);
        $lrn = $request->query('lrn');
        $student = Student::where('lrn', $lrn)->first();
        if ($student) {
            return response()->json([
                'success' => true,
                'name' => trim(implode(' ', array_filter([
                    $student->first_name,
                    $student->middle_name,
                    $student->last_name
                ]))),
                'student_id' => $student->student_id,
            ]);
        }
        return response()->json(['success' => false, 'message' => 'Student not found with this LRN.'], 404);
    }
}
