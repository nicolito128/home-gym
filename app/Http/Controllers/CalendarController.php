<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Exercise;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $schedules = Schedule::whereHas('exercise.workoutPlan', function ($q) use ($userId) {
            $q->where('owner_id', $userId);
        })->with(['exercise.workoutPlan'])->get();

        $grouped = $schedules->groupBy('day_of_week')->map(function ($day) {
            return $day->sortBy('start_at');
        });

        $exercises = Exercise::whereHas('workoutPlan', function ($q) use ($userId) {
            $q->where('owner_id', $userId);
        })->get();

        return view('calendar', ['grouped' => $grouped, 'exercises' => $exercises]);
    }
}
