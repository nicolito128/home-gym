<?php

namespace App\Http\Controllers;

use App\Models\WorkoutPlan;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class WorkoutPlanController extends Controller
{
    public function index(Request $request)
    {
        $plans = WorkoutPlan::where('owner_id', $request->user()->id)->with('exercises.schedules')->get();
        return view('me', ['plans' => $plans]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('workout_plans')->where('owner_id', $request->user()->id)],
        ]);

        try {
            $plan = DB::transaction(function () use ($request, $data) {
                return WorkoutPlan::firstOrCreate([
                    'owner_id' => $request->user()->id,
                    'name' => $data['name'],
                ]);
            });
        } catch (QueryException $exception) {
            return redirect()->back()->withInput()->withErrors(['name' => 'No se pudo crear el plan.'])->with('status', 'Error al crear el plan');
        }

        $status = $plan->wasRecentlyCreated ? 'Plan creado' : 'El plan ya existe';

        return redirect()->route('me')->with('status', $status);
    }

    public function show(Request $request, WorkoutPlan $workout_plan)
    {
        $this->authorizePlanOwner($request->user()->id, $workout_plan);
        $workout_plan->load('exercises.schedules');
        return view('plan.show', ['plan' => $workout_plan]);
    }

    protected function authorizePlanOwner($userId, WorkoutPlan $plan)
    {
        if ($plan->owner_id !== $userId) {
            abort(403);
        }
    }
}
