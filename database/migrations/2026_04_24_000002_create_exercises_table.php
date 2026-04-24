<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_plan_id')->constrained('workout_plans');
            $table->text('name');
            $table->text('description')->nullable();
            $table->text('muscle_group')->nullable();
            $table->text('equipment_needed')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
