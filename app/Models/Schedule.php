<?php

namespace App\Models;

use App\Models\Exercise;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['exercise_id', 'day_of_week', 'start_at', 'repetitions', 'breaks'];

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}
