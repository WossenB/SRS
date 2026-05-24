<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timesheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('restrict');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default('draft')->index(); // draft, submitted, under_review, approved, returned
            $table->foreignId('supervisor_id')->nullable()->constrained('employees')->onDelete('set null');
            $table->text('remarks')->nullable();
            $table->unsignedInteger('version')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timesheets');
    }
};
