<?php

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\Admin\AdminControlController;
use App\Http\Controllers\Admin\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/pending-approval', function () {
    return view('auth.pending-approval');
})->middleware(['auth', 'verified'])->name('pending-approval');

// Temporary Routes

Route::get('/courses', function () {
    return view('courses.index');
})->middleware(['auth', 'verified'])->name('courses');

Route::get('/reports', function () {
    return view('reports.index');
})->middleware(['auth', 'verified'])->name('reports');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'approved'])->group(function () {
    // Student Information System
    Route::prefix('students')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('students.index');
        Route::get('/{lrn}', [StudentController::class, 'show'])->name('students.show');
        Route::get('/{lrn}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('/{lrn}', [StudentController::class, 'update'])->name('students.update');
        Route::post('/{lrn}/enroll', [StudentController::class, 'enroll'])->name('students.enroll');
        Route::get('/{lrn}/academic-record', [StudentController::class, 'academicRecord'])->name('students.academic-record');
    });

    Route::get('/students/search-by-lrn', [EnrollmentController::class, 'searchStudentByLrn'])->name('students.search-by-lrn');

    // Student Enrollment System
    Route::prefix('enrollments')->group(function () {
        Route::get('/', [EnrollmentController::class, 'index'])->name('enrollments.index');
        Route::match(['get', 'post'], '/create', [EnrollmentController::class, 'create'])->name('enrollments.create');
        Route::post('/', [EnrollmentController::class, 'store'])->name('enrollments.store');
        Route::get('/settings', [EnrollmentController::class, 'settings'])->name('enrollments.settings');
        Route::post('/{enrollment}/assign', [EnrollmentController::class, 'assignGradeAndSection'])->name('enrollments.assign');
        Route::get('/{enrollment}', [EnrollmentController::class, 'show'])->name('enrollments.show');
        Route::post('/{enrollment}/confirm', [EnrollmentController::class, 'confirm'])->name('enrollments.confirm');
    });

    Route::post('/sections/sync', [SectionController::class, 'sync'])->name('sections.sync');
    Route::get('/sections', function (Request $request) {
        $gradeLevel = $request->query('grade_level');
        $sections = Section::where('grade_level', $gradeLevel)->get(['section_id', 'name']);
        return response()->json($sections);
    });
});

// Admin Control (new section)
Route::prefix('admin')->middleware(['admin', 'auth', 'approved', 'verified'])->group(function () {
    Route::get('/control', [AdminControlController::class, 'index'])->name('admin.control.index');
    Route::post('/control/settings', [AdminControlController::class, 'settings'])->name('admin.control.settings');
    Route::get('/users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::post('/users/{user}/approve', [UserManagementController::class, 'approve'])->name('admin.users.approve');
});


require __DIR__ . '/auth.php';
