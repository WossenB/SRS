<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('timesheets', function (Blueprint $table) {
            $table->date('week_start')->nullable();
            $table->date('week_end')->nullable();
            $table->dateTime('submitted_at')->nullable();
            $table->foreignId('submitted_by')->nullable()->constrained('users');
            $table->dateTime('supervisor_approved_at')->nullable();
            $table->foreignId('supervisor_approved_by')->nullable()->constrained('users');
        });

        Schema::table('timesheet_entries', function (Blueprint $table) {
            $table->string('day_of_week')->nullable();
            $table->decimal('hours_worked', 4, 2)->default(0);
            $table->decimal('overtime_hours', 4, 2)->default(0);
            $table->boolean('is_working_day')->default(true);
            $table->text('remarks')->nullable();
        });
    }

    public function down(): void
    {
        // Skip for simplicity in this sandbox
    }
};
