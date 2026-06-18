<?php

use App\Models\Exercise;
use App\Models\Schedule;
use App\Models\User;
use App\Models\WorkoutPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('does not create duplicate workout plans for the same user', function () {
    $planName = 'Full Body';

    $this->post(route('plans.store'), ['name' => $planName]);
    $this->post(route('plans.store'), ['name' => $planName]);

    $this->assertDatabaseCount('workout_plans', 1);
    $this->assertDatabaseHas('workout_plans', ['owner_id' => $this->user->id, 'name' => $planName]);
});

it('does not create duplicate exercises in the same plan', function () {
    $plan = WorkoutPlan::create(['owner_id' => $this->user->id, 'name' => 'Plan de prueba']);
    $exerciseName = 'Press de banca';

    $this->post(route('exercises.store', ['workout_plan' => $plan->id]), [
        'name' => $exerciseName,
        'muscle_group' => 'Pecho',
    ]);

    $this->post(route('exercises.store', ['workout_plan' => $plan->id]), [
        'name' => $exerciseName,
        'muscle_group' => 'Pecho',
    ]);

    $this->assertDatabaseCount('exercises', 1);
    $this->assertDatabaseHas('exercises', ['workout_plan_id' => $plan->id, 'name' => $exerciseName]);
});

it('does not create duplicate schedules for the same exercise, day and time', function () {
    $plan = WorkoutPlan::create(['owner_id' => $this->user->id, 'name' => 'Plan de prueba']);
    $exercise = Exercise::create(['workout_plan_id' => $plan->id, 'name' => 'Sentadillas']);

    $this->post(route('schedules.store', ['exercise' => $exercise->id]), [
        'day_of_week' => 1,
        'start_at' => '08:00',
    ]);

    $this->post(route('schedules.store', ['exercise' => $exercise->id]), [
        'day_of_week' => 1,
        'start_at' => '08:00',
    ]);

    $this->assertDatabaseCount('schedules', 1);
    $this->assertDatabaseHas('schedules', ['exercise_id' => $exercise->id, 'day_of_week' => 1, 'start_at' => '08:00']);
});

it('allows multiple exercises on the same day with different start times', function () {
    $plan = WorkoutPlan::create(['owner_id' => $this->user->id, 'name' => 'Plan de prueba']);
    $exerciseA = Exercise::create(['workout_plan_id' => $plan->id, 'name' => 'Sentadillas']);
    $exerciseB = Exercise::create(['workout_plan_id' => $plan->id, 'name' => 'Press de banca']);

    $this->post(route('schedules.store', ['exercise' => $exerciseA->id]), [
        'day_of_week' => 1,
        'start_at' => '08:00',
    ]);

    $this->post(route('schedules.store', ['exercise' => $exerciseB->id]), [
        'day_of_week' => 1,
        'start_at' => '09:00',
    ]);

    $this->assertDatabaseCount('schedules', 2);
    $this->assertDatabaseHas('schedules', ['exercise_id' => $exerciseA->id, 'day_of_week' => 1, 'start_at' => '08:00']);
    $this->assertDatabaseHas('schedules', ['exercise_id' => $exerciseB->id, 'day_of_week' => 1, 'start_at' => '09:00']);
});
