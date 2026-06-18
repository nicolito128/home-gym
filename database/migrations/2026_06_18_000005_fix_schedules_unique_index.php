<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('schedules')) {
            return;
        }

        $driver = DB::getDriverName();

        if ($driver === 'sqlite' || $driver === 'pgsql') {
            DB::statement('DROP INDEX IF EXISTS schedules_start_at_unique');
        } elseif ($driver === 'mysql') {
            DB::statement('DROP INDEX IF EXISTS schedules_start_at_unique ON schedules');
        } else {
            Schema::table('schedules', function (Blueprint $table) {
                $table->dropUnique('schedules_start_at_unique');
            });
        }

        Schema::table('schedules', function (Blueprint $table) {
            $table->unique(['exercise_id', 'day_of_week', 'start_at'], 'schedules_exercise_day_start_unique');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('schedules')) {
            return;
        }

        Schema::table('schedules', function (Blueprint $table) {
            $table->dropUnique('schedules_exercise_day_start_unique');
            $table->unique('start_at', 'schedules_start_at_unique');
        });
    }
};
