<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exit_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained();
            $table->date('separation_date');
            $table->string('exit_type'); // Resignation, Termination, Retirement
            $table->string('status')->default('initiated')->index(); // initiated, in_progress, cleared, completed
            $table->json('clearance_checklist')->nullable(); // IT, Finance, HR, Supervisor status
            $table->text('reason')->nullable();
            $table->unsignedInteger('version')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exit_records');
    }
};
