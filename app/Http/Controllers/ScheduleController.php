<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Exercise;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function store(Request $request, Exercise $exercise)
    {
        // ensure the exercise belongs to the current user via plan
        if ($exercise->workoutPlan->owner_id !== $request->user()->id) {
            abort(403);
        }

        $data = $request->validate([
            'day_of_week' => 'required|integer|min:0|max:6',
            'start_at' => 'required|date_format:H:i',
            'repetitions' => 'nullable|integer|min:1',
            'breaks' => 'nullable|integer|min:0',
        ]);

        $schedule = Schedule::create(array_merge($data, ['exercise_id' => $exercise->id]));

        if ($request->expectsJson()) {
            $schedule->load('exercise.workoutPlan');
            return response()->json(['status' => 'ok', 'schedule' => $schedule]);
        }

        return redirect()->back()->with('status', 'Horario asignado');
    }
}
