<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('classes/{id}/students', StudentController::class);
    Route::resource('classes', ClassController::class);
    Route::resource('subjects', SubjectController::class);
    // Route::resource('classes/{classId}/subjects/{subjectId}/point', PointController::class);
    Route::resource('classes/{id}/points', PointController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
