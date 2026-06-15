<?php

namespace App\Models;

use App\Models\User;
use App\Models\Exercise;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutPlan extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['owner_id', 'name'];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }
}
