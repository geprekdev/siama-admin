<?php

use App\Http\Controllers\Attendance;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Classroom;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Recap\StudentMonthlyController;
use App\Http\Controllers\Recap\TeacherMonthlyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserImportController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('users', UserController::class)->except('show');
    Route::get('users/import', [UserImportController::class, 'create'])->name('users.import');
    Route::post('users/import', [UserImportController::class, 'store']);

    Route::resource('attendances/leaves/half-days', Attendance\LeaveHalfDayController::class)
        ->names('attendances.leaves.half-days');

    Route::resource('attendances/leaves/full-days', Attendance\LeaveFullDayController::class)
        ->names('attendances.leaves.full-days')
        ->only('index', 'edit', 'update', 'destroy');

    Route::resource('attendances/timetables', Attendance\TimetableController::class)
        ->names('attendances.timetables');

    Route::resource('classrooms/subjects', Classroom\SubjectController::class)
        ->names('classrooms.subjects');

    Route::resource('classrooms/timetables', Classroom\TimetableController::class)
        ->names('classrooms.timetables');

    Route::get('recaps/students/monthly', [StudentMonthlyController::class, 'index'])
        ->name('recaps.students.monthly.index');

    Route::get('recaps/students/monthly/export', [StudentMonthlyController::class, 'export'])
        ->name('recaps.students.monthly.export');

    Route::get('recaps/non-students/monthly', [TeacherMonthlyController::class, 'index'])
        ->name('recaps.non-students.monthly.index');

    Route::get('recaps/non-students/monthly/export', [TeacherMonthlyController::class, 'export'])
        ->name('recaps.non-students.monthly.export');
});
