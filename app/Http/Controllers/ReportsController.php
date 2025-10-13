<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Section;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportsController extends Controller
{
    /**
     * Display the reports page
     */
    public function index(Request $request)
    {
        $reportType = $request->get('report_type', 'enrollment');
        $schoolYear = $request->get('school_year', '2025-2026');
        $gradeLevel = $request->get('grade_level', 'all');
        $section = $request->get('section', 'all');

        // Get available sections for filter dropdown
        $availableSections = Section::with('adviser')->get();

        // Get report data based on type
        $reportData = $this->getReportData($reportType, $schoolYear, $gradeLevel, $section);
        $totalRecords = $this->getTotalRecords($reportType, $schoolYear, $gradeLevel, $section);

        return view('reports.index', compact(
            'reportType',
            'schoolYear',
            'gradeLevel',
            'section',
            'reportData',
            'totalRecords',
            'availableSections'
        ));
    }

    /**
     * Get report data based on type and filters
     */
    private function getReportData($reportType, $schoolYear, $gradeLevel, $section)
    {
        switch ($reportType) {
            case 'enrollment':
                return $this->getEnrollmentReport($schoolYear, $gradeLevel, $section);
            
            case 'students':
                return $this->getStudentReport($schoolYear, $gradeLevel, $section);
            
            case 'teachers':
                return $this->getTeacherReport();
            
            case 'sections':
                return $this->getSectionReport($schoolYear, $gradeLevel);
            
            default:
                return $this->getEnrollmentReport($schoolYear, $gradeLevel, $section);
        }
    }

    /**
     * Get enrollment report data
     */
    private function getEnrollmentReport($schoolYear, $gradeLevel, $section)
    {
        $query = Enrollment::with(['student', 'section'])
            ->where('school_year', $schoolYear);

        // Apply grade level filter
        if ($gradeLevel !== 'all') {
            $query->where('grade_level', $gradeLevel);
        }

        // Apply section filter
        if ($section !== 'all') {
            $query->where('section_id', $section);
        }

        $enrollments = $query->orderBy('enrollment_date', 'desc')->paginate(15);

        // Convert enrollment_date strings to Carbon objects for the view
        foreach ($enrollments as $enrollment) {
            if ($enrollment->enrollment_date && is_string($enrollment->enrollment_date)) {
                $enrollment->enrollment_date = Carbon::parse($enrollment->enrollment_date);
            }
        }

        return $enrollments;
    }

    /**
     * Get student report data
     */
    private function getStudentReport($schoolYear, $gradeLevel, $section)
    {
        $query = Student::with([
            'enrollments.section', 
            'familyContacts'
        ])->whereHas('enrollments', function ($q) use ($schoolYear, $gradeLevel, $section) {
            $q->where('school_year', $schoolYear);
            
            if ($gradeLevel !== 'all') {
                $q->where('grade_level', $gradeLevel);
            }
            
            if ($section !== 'all') {
                $q->where('section_id', $section);
            }
        });

        $students = $query->orderBy('last_name')->orderBy('first_name')->paginate(15);

        // Convert birthdate strings to Carbon objects for the view
        foreach ($students as $student) {
            if ($student->birthdate && is_string($student->birthdate)) {
                $student->birthdate = Carbon::parse($student->birthdate);
            }
        }

        return $students;
    }

    /**
     * Get teacher report data
     */
    private function getTeacherReport()
    {
        $teachers = Teacher::with(['sections' => function($query) {
            $query->orderBy('grade_level')->orderBy('name');
        }])->orderBy('last_name')->orderBy('first_name')->paginate(15);

        // Ensure sections relationship is loaded and not null
        foreach ($teachers as $teacher) {
            if (!$teacher->sections) {
                $teacher->sections = collect(); // Empty collection if null
            }
        }

        return $teachers;
    }

    /**
     * Get section report data with statistics
     */
    private function getSectionReport($schoolYear, $gradeLevel)
    {
        $query = Section::with(['adviser', 'enrollments' => function($q) use ($schoolYear) {
            $q->where('school_year', $schoolYear)->where('status', 'Enrolled');
        }])
        ->withCount(['enrollments as total_students' => function ($q) use ($schoolYear) {
            $q->where('school_year', $schoolYear)
              ->where('status', 'Enrolled');
        }]);

        // Apply grade level filter
        if ($gradeLevel !== 'all') {
            $query->where('grade_level', $gradeLevel);
        }

        $sections = $query->get();

        // Add gender statistics and capacity utilization
        foreach ($sections as $section) {
            $genderStats = $this->getSectionGenderStats($section->section_id, $schoolYear);
            $section->male_count = $genderStats->male ?? 0;
            $section->female_count = $genderStats->female ?? 0;
            $section->capacity = 45; // Default capacity
            $section->utilization_percentage = $section->total_students > 0 
                ? round(($section->total_students / $section->capacity) * 100, 2)
                : 0;
        }

        return $sections;
    }

    /**
     * Get gender statistics for a section
     */
    private function getSectionGenderStats($sectionId, $schoolYear)
    {
        return DB::table('enrollments')
            ->join('students', 'enrollments.student_id', '=', 'students.student_id')
            ->where('enrollments.section_id', $sectionId)
            ->where('enrollments.school_year', $schoolYear)
            ->where('enrollments.status', 'Enrolled')
            ->select(
                DB::raw('COUNT(CASE WHEN students.sex = "Male" THEN 1 END) as male'),
                DB::raw('COUNT(CASE WHEN students.sex = "Female" THEN 1 END) as female')
            )
            ->first();
    }

    /**
     * Get total records count for the quick stats
     */
    private function getTotalRecords($reportType, $schoolYear, $gradeLevel, $section)
    {
        switch ($reportType) {
            case 'enrollment':
                $query = Enrollment::where('school_year', $schoolYear);
                if ($gradeLevel !== 'all') $query->where('grade_level', $gradeLevel);
                if ($section !== 'all') $query->where('section_id', $section);
                return $query->count();
            
            case 'students':
                $query = Student::whereHas('enrollments', function ($q) use ($schoolYear, $gradeLevel, $section) {
                    $q->where('school_year', $schoolYear);
                    if ($gradeLevel !== 'all') $q->where('grade_level', $gradeLevel);
                    if ($section !== 'all') $q->where('section_id', $section);
                });
                return $query->count();
            
            case 'teachers':
                return Teacher::count();
            
            case 'sections':
                $query = Section::query();
                if ($gradeLevel !== 'all') $query->where('grade_level', $gradeLevel);
                return $query->count();
            
            default:
                return 0;
        }
    }

    /**
     * Export reports to Excel or PDF
     */
    public function export(Request $request)
    {
        $reportType = $request->get('report_type', 'enrollment');
        $schoolYear = $request->get('school_year', '2025-2026');
        $gradeLevel = $request->get('grade_level', 'all');
        $section = $request->get('section', 'all');
        $format = $request->get('format', 'excel');

        $data = $this->getExportData($reportType, $schoolYear, $gradeLevel, $section);
        $fileName = $this->generateFileName($reportType, $schoolYear);

        if ($format === 'pdf') {
            return $this->exportToPDF($reportType, $data, $fileName);
        }

        return $this->exportToExcel($reportType, $data, $fileName);
    }

    /**
     * Get data for export (without pagination)
     */
    private function getExportData($reportType, $schoolYear, $gradeLevel, $section)
    {
        switch ($reportType) {
            case 'enrollment':
                $query = Enrollment::with(['student', 'section'])
                    ->where('school_year', $schoolYear);
                if ($gradeLevel !== 'all') $query->where('grade_level', $gradeLevel);
                if ($section !== 'all') $query->where('section_id', $section);
                $enrollments = $query->orderBy('enrollment_date', 'desc')->get();
                
                // Format dates for export
                foreach ($enrollments as $enrollment) {
                    if ($enrollment->enrollment_date && is_string($enrollment->enrollment_date)) {
                        $enrollment->enrollment_date = Carbon::parse($enrollment->enrollment_date);
                    }
                }
                return $enrollments;
            
            case 'students':
                $query = Student::with(['enrollments.section', 'familyContacts'])
                    ->whereHas('enrollments', function ($q) use ($schoolYear, $gradeLevel, $section) {
                        $q->where('school_year', $schoolYear);
                        if ($gradeLevel !== 'all') $q->where('grade_level', $gradeLevel);
                        if ($section !== 'all') $q->where('section_id', $section);
                    });
                $students = $query->orderBy('last_name')->orderBy('first_name')->get();
                
                // Format dates for export
                foreach ($students as $student) {
                    if ($student->birthdate && is_string($student->birthdate)) {
                        $student->birthdate = Carbon::parse($student->birthdate);
                    }
                }
                return $students;
            
            case 'teachers':
                $teachers = Teacher::with(['sections'])->orderBy('last_name')->get();
                
                // Ensure sections relationship is loaded and not null
                foreach ($teachers as $teacher) {
                    if (!$teacher->sections) {
                        $teacher->sections = collect();
                    }
                }
                return $teachers;
            
            case 'sections':
                return $this->getSectionReport($schoolYear, $gradeLevel);
            
            default:
                return collect();
        }
    }

    /**
     * Generate filename for export
     */
    private function generateFileName($reportType, $schoolYear)
    {
        $typeMap = [
            'enrollment' => 'Enrollment_Report',
            'students' => 'Student_Report',
            'teachers' => 'Teacher_Report',
            'sections' => 'Section_Report'
        ];

        $type = $typeMap[$reportType] ?? 'Report';
        return $type . '_' . $schoolYear . '_' . now()->format('Y-m-d');
    }

    /**
     * Export to Excel using PhpSpreadsheet
     */
    private function exportToExcel($reportType, $data, $fileName)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers based on report type
        $headers = $this->getExportHeaders($reportType);
        $column = 'A';
        
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '1', $header);
            $sheet->getStyle($column . '1')->getFont()->setBold(true);
            $column++;
        }

        // Add data rows
        $row = 2;
        foreach ($data as $item) {
            $column = 'A';
            $rowData = $this->getExportRowData($reportType, $item);
            
            foreach ($rowData as $value) {
                $sheet->setCellValue($column . $row, $value);
                $column++;
            }
            $row++;
        }

        // Auto-size columns
        foreach (range('A', $column) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    /**
     * Export to PDF using DomPDF
     */
    private function exportToPDF($reportType, $data, $fileName)
    {
        $headers = $this->getExportHeaders($reportType);
        
        $pdf = PDF::loadView('reports.export-pdf', [
            'reportType' => $reportType,
            'data' => $data,
            'headers' => $headers,
            'fileName' => $fileName,
            'exportDate' => now()->format('F j, Y')
        ]);

        return $pdf->download($fileName . '.pdf');
    }

    /**
     * Get export headers based on report type
     */
    private function getExportHeaders($reportType)
    {
        switch ($reportType) {
            case 'enrollment':
                return ['Student Name', 'LRN', 'Grade Level', 'Section', 'Enrollment Type', 'Status', 'Date'];
            
            case 'students':
                return ['Student Name', 'LRN', 'Gender', 'Birth Date', 'Grade Level', 'Section', 'Contact Number', 'Guardian'];
            
            case 'teachers':
                return ['Teacher Name', 'Employee ID', 'Advisory Class', 'Email', 'Status'];
            
            case 'sections':
                return ['Section Name', 'Grade Level', 'Adviser', 'Total Students', 'Male', 'Female', 'Capacity', 'Status'];
            
            default:
                return [];
        }
    }

    /**
     * Get export row data based on report type and item
     */
    private function getExportRowData($reportType, $item)
    {
        switch ($reportType) {
            case 'enrollment':
                $enrollmentDate = $item->enrollment_date;
                if ($enrollmentDate instanceof Carbon) {
                    $formattedDate = $enrollmentDate->format('M j, Y');
                } else {
                    $formattedDate = $enrollmentDate ? Carbon::parse($enrollmentDate)->format('M j, Y') : 'N/A';
                }
                
                return [
                    ($item->student->first_name ?? '') . ' ' . ($item->student->last_name ?? ''),
                    $item->student->lrn ?? '',
                    'Grade ' . $item->grade_level,
                    $item->section->name ?? 'Not Assigned',
                    $item->enrollment_type,
                    $item->status,
                    $formattedDate
                ];
            
            case 'students':
                $currentEnrollment = $item->enrollments->first();
                $familyContacts = $item->familyContacts ?? collect();
                $contactNumber = $familyContacts->first()->contact_number ?? 'N/A';
                $guardian = $familyContacts->where('contact_type', 'Father')->first();
                $guardianName = $guardian ? ($guardian->first_name . ' ' . $guardian->last_name) : 'N/A';
                
                $birthdate = $item->birthdate;
                if ($birthdate instanceof Carbon) {
                    $formattedBirthdate = $birthdate->format('M j, Y');
                } else {
                    $formattedBirthdate = $birthdate ? Carbon::parse($birthdate)->format('M j, Y') : 'N/A';
                }
                
                return [
                    $item->first_name . ' ' . $item->last_name,
                    $item->lrn,
                    $item->sex,
                    $formattedBirthdate,
                    $currentEnrollment ? 'Grade ' . $currentEnrollment->grade_level : 'Not Enrolled',
                    $currentEnrollment ? ($currentEnrollment->section->name ?? 'No Section') : 'N/A',
                    $contactNumber,
                    $guardianName
                ];
            
            case 'teachers':
                $advisoryClass = 'No Advisory';
                if ($item->sections && $item->sections->isNotEmpty()) {
                    $advisoryClass = $item->sections->first()->name ?? 'No Advisory';
                }
                
                return [
                    $item->first_name . ' ' . $item->last_name,
                    'TCHR-' . $item->teacher_id,
                    $advisoryClass,
                    $item->email,
                    'Active'
                ];
            
            case 'sections':
                $utilization = $item->utilization_percentage ?? 0;
                $status = $utilization >= 90 ? 'Full' : ($utilization >= 75 ? $utilization . '% Full' : 'Available');
                
                return [
                    $item->name,
                    'Grade ' . $item->grade_level,
                    $item->adviser ? $item->adviser->first_name . ' ' . $item->adviser->last_name : 'No Adviser',
                    $item->total_students ?? 0,
                    $item->male_count ?? 0,
                    $item->female_count ?? 0,
                    $item->capacity ?? 45,
                    $status
                ];
            
            default:
                return [];
        }
    }

    /**
     * Get sections by grade level for dynamic dropdown
     */
    public function getSectionsByGrade(Request $request)
    {
        $gradeLevel = $request->get('grade_level');
        
        if ($gradeLevel === 'all') {
            return response()->json([]);
        }

        $sections = Section::where('grade_level', $gradeLevel)
            ->select('section_id', 'name')
            ->get();

        return response()->json($sections);
    }
}