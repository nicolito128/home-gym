<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_id')->constrained('exercises');
            $table->smallInteger('day_of_week');
            $table->time('start_at')->useCurrent();
            $table->unique(['exercise_id', 'day_of_week', 'start_at'], 'schedules_exercise_day_start_unique');
            $table->integer('repetitions')->default(1);
            $table->integer('breaks')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
