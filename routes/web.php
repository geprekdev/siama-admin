<?php

use App\Http\Controllers\Attendance;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Classroom;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Recap\StudentMonthlyController;
use App\Http\Controllers\UserController;
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

    Route::middleware('role:ADMIN')->group(function () {
        Route::resource('users', UserController::class)->except('show');

        Route::resource('attendances/leaves/half-days', Attendance\LeaveHalfDayController::class)
            ->names('attendances.leaves.half-days');

        Route::resource('attendances/leaves/full-days', Attendance\LeaveFullDayController::class)
            ->names('attendances.leaves.full-days')
            ->only('index', 'edit', 'update', 'destroy');
    });

    Route::middleware('role:ADMIN,KURIKULUM')->group(function () {
        Route::resource('attendances/timetables', Attendance\TimetableController::class)
            ->names('attendances.timetables');

        Route::resource('classrooms/subjects', Classroom\SubjectController::class)
            ->names('classrooms.subjects');

        Route::resource('classrooms/timetables', Classroom\TimetableController::class)
            ->names('classrooms.timetables');
    });

    Route::middleware('role:ADMIN,BK')->group(function () {
        Route::get('recaps/students/monthly', [StudentMonthlyController::class, 'index'])
            ->name('recaps.students.monthly.index');

        Route::get('recaps/students/monthly/export', [StudentMonthlyController::class, 'export'])
            ->name('recaps.students.monthly.export');
    });
});
