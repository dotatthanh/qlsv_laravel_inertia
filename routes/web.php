<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\StudentController;
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
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
