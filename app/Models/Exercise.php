<?php

namespace App\Models;

use App\Models\WorkoutPlan;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['workout_plan_id', 'name', 'description', 'muscle_group', 'equipment_needed'];

    public function workoutPlan()
    {
        return $this->belongsTo(WorkoutPlan::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
