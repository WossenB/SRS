<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('restrict');
            $table->foreignId('leave_type_id')->constrained()->onDelete('restrict');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('days_requested', 5, 2);
            $table->text('reason')->nullable();
            $table->string('status')->default('submitted')->index(); // submitted, manager_approved, hr_approved, rejected, cancelled
            $table->foreignId('approved_by_manager')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('approved_by_hr')->nullable()->constrained('users')->onDelete('set null');
            $table->text('rejection_reason')->nullable();
            $table->unsignedInteger('version')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
