<?php

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AdvisoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Temporary Routes

Route::get('/courses', function () {
    return view('courses.index');
})->middleware(['auth', 'verified'])->name('courses');

Route::get('/assessments', function () {
    return view('assessments.index');
})->middleware(['auth', 'verified'])->name('assessments');

Route::get('/reports', function () {
    return view('reports.index');
})->middleware(['auth', 'verified'])->name('reports');

// Advisory Routes - Now using controller instead of direct view
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/advisory', [AdvisoryController::class, 'index'])->name('advisory.index');
    Route::delete('/advisory/remove/{lrn}', [AdvisoryController::class, 'removeStudent'])->name('advisory.remove-student');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Student Information System
    Route::prefix('students')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('students.index');
        Route::get('/{lrn}', [StudentController::class, 'show'])->name('students.show');
        Route::get('/{lrn}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('/{lrn}', [StudentController::class, 'update'])->name('students.update');
        Route::post('/{lrn}/enroll', [StudentController::class, 'enroll'])->name('students.enroll');
        Route::get('/{lrn}/academic-record', [StudentController::class, 'academicRecord'])->name('students.academic-record');
    });

    // Student Enrollment System
    Route::prefix('enrollments')->group(function () {
        Route::get('/', [EnrollmentController::class, 'index'])->name('enrollments.index');
        Route::match(['get', 'post'], '/create', [EnrollmentController::class, 'create'])->name('enrollments.create');
        Route::post('/', [EnrollmentController::class, 'store'])->name('enrollments.store');
        Route::get('/settings', [EnrollmentController::class, 'settings'])->name('enrollments.settings');
        Route::post('/enrollments/{enrollment}/assign', [EnrollmentController::class, 'assignGradeAndSection'])->name('enrollments.assign');
        Route::get('/enrollments/{enrollment}', [EnrollmentController::class, 'show'])->name('enrollments.show');
        Route::get('/{enrollment_id}', [EnrollmentController::class, 'show'])->name('enrollments.show');
        Route::post('/{enrollment_id}/confirm', [EnrollmentController::class, 'confirm'])->name('enrollments.confirm');
    });

    
    Route::post('/sections/sync', [SectionController::class, 'sync'])->name('sections.sync');
    Route::get('/sections', function (Request $request) {
        $gradeLevel = $request->query('grade_level');
        $sections = Section::where('grade_level', $gradeLevel)->get(['section_id', 'name']);
        return response()->json($sections);
    });

});

require __DIR__ . '/auth.php';