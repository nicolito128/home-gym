<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\WorkoutPlan;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ExerciseController extends Controller
{
    public function store(Request $request, WorkoutPlan $workout_plan)
    {
        if ($workout_plan->owner_id !== $request->user()->id) {
            abort(403);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('exercises')->where(fn ($query) => $query->where('workout_plan_id', $workout_plan->id))],
            'description' => 'nullable|string',
            'muscle_group' => 'nullable|string',
            'equipment_needed' => 'nullable|string',
        ]);

        try {
            $exercise = DB::transaction(function () use ($workout_plan, $data) {
                return Exercise::firstOrCreate(
                    ['workout_plan_id' => $workout_plan->id, 'name' => $data['name']],
                    array_merge($data, ['workout_plan_id' => $workout_plan->id])
                );
            });
        } catch (QueryException $exception) {
            return redirect()->back()->withInput()->withErrors(['name' => 'No se pudo crear el ejercicio.'])->with('status', 'Error al crear el ejercicio');
        }

        $status = $exercise->wasRecentlyCreated ? 'Ejercicio creado' : 'El ejercicio ya existe';

        return redirect()->back()->with('status', $status);
    }
}
