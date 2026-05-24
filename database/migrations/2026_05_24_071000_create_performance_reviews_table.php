<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('performance_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained();
            $table->foreignId('performance_cycle_id')->constrained();
            $table->string('status')->default('self_assessment')->index(); // self_assessment, manager_review, hr_calibration, published
            $table->json('self_assessment_data')->nullable();
            $table->json('manager_review_data')->nullable();
            $table->decimal('final_rating', 3, 2)->nullable();
            $table->text('hr_remarks')->nullable();
            $table->unsignedInteger('version')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_reviews');
    }
};
