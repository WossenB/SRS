<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained();
            $table->foreignId('training_course_id')->constrained();
            $table->date('due_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->string('status')->default('assigned')->index(); // assigned, in_progress, completed, overdue
            $table->string('certificate_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_assignments');
    }
};
