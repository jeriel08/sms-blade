<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EnrollmentController;
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
    });

    // Student Enrollment System
    Route::prefix('enrollments')->group(function () {
        Route::get('/', [EnrollmentController::class, 'index'])->name('enrollments.index');
        Route::get('/create', [EnrollmentController::class, 'create'])->name('enrollments.create');
        Route::post('/', [EnrollmentController::class, 'store'])->name('enrollments.store');
        Route::get('/{enrollment_id}', [EnrollmentController::class, 'show'])->name('enrollments.show');
        Route::post('/{enrollment_id}/confirm', [EnrollmentController::class, 'confirm'])->name('enrollments.confirm');
    });
});

require __DIR__ . '/auth.php';
