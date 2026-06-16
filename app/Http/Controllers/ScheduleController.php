<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Exercise;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
            'start_at' => ['required', 'date_format:H:i', Rule::unique('schedules')->where(function ($query) use ($exercise, $request) {
                return $query->where('exercise_id', $exercise->id)
                    ->where('day_of_week', $request->input('day_of_week'));
            })],
            'repetitions' => 'nullable|integer|min:1',
            'breaks' => 'nullable|integer|min:0',
        ]);

        // Defensive check: some DB schemas have a global unique on `start_at`
        // which would cause a DB-level constraint error. Check early and
        // return a readable JSON error to the frontend to avoid 500s.
        if (Schedule::where('start_at', $data['start_at'])->exists()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Ya existe un horario con esa hora.',
                ], 422);
            }

            return redirect()->back()->withInput()->withErrors(['start_at' => 'Ya existe un horario con esa hora.'])->with('status', 'Error al asignar el horario');
        }

        try {
            $schedule = DB::transaction(function () use ($exercise, $data) {
                return Schedule::firstOrCreate(
                    [
                        'exercise_id' => $exercise->id,
                        'day_of_week' => $data['day_of_week'],
                        'start_at' => $data['start_at'],
                    ],
                    array_merge($data, ['exercise_id' => $exercise->id])
                );
            });
        } catch (QueryException $exception) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No se pudo asignar el horario.',
                    'errors' => ['start_at' => ['Ya existe un horario con esa hora.']],
                ], 422);
            }

            return redirect()->back()->withInput()->withErrors(['start_at' => 'No se pudo asignar el horario.'])->with('status', 'Error al asignar el horario');
        }

        if ($request->expectsJson()) {
            $schedule->load('exercise.workoutPlan');
            return response()->json(['status' => 'ok', 'schedule' => $schedule]);
        }

        $status = $schedule->wasRecentlyCreated ? 'Horario asignado' : 'El horario ya existe';
        return redirect()->back()->with('status', $status);
    }
}
