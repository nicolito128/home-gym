<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\WorkoutPlanController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\CalendarController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/me', [WorkoutPlanController::class, 'index'])->name('me');

    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');

    // Workout plans
    Route::post('/plans', [WorkoutPlanController::class, 'store'])->name('plans.store');
    Route::get('/plans/{workout_plan}', [WorkoutPlanController::class, 'show'])->name('plans.show');

    // Exercises
    Route::post('/plans/{workout_plan}/exercises', [ExerciseController::class, 'store'])->name('exercises.store');
    Route::delete('/exercises/{exercise}', [ExerciseController::class, 'destroy'])->name('exercises.destroy');

    // Schedules / calendar assignments
    Route::post('/exercises/{exercise}/schedules', [ScheduleController::class, 'store'])->name('schedules.store');
    Route::delete('/exercises/{exercise}/schedules', [ScheduleController::class, 'destroyByExercise'])->name('schedules.destroyByExercise');
    Route::delete('/schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
