<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\WorkoutPlan;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function store(Request $request, WorkoutPlan $workout_plan)
    {
        if ($workout_plan->owner_id !== $request->user()->id) {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'muscle_group' => 'nullable|string',
            'equipment_needed' => 'nullable|string',
        ]);

        Exercise::create(array_merge($data, ['workout_plan_id' => $workout_plan->id]));

        return redirect()->back()->with('status', 'Ejercicio creado');
    }
}
