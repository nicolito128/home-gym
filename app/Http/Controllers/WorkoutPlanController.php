<?php

namespace App\Http\Controllers;

use App\Models\WorkoutPlan;
use Illuminate\Http\Request;

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
            'name' => 'required|string|max:255',
        ]);

        $plan = WorkoutPlan::create([
            'owner_id' => $request->user()->id,
            'name' => $data['name'],
        ]);

        return redirect()->route('me')->with('status', 'Plan creado');
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
