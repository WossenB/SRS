<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payroll_runs', function (Blueprint $table) {
            $table->id();
            $table->string('period_month', 7)->index(); // YYYY-MM
            $table->string('run_type')->default('regular'); // regular, supplementary
            $table->string('status')->default('draft')->index(); // draft, review, approved, locked
            $table->json('input_snapshot')->nullable();
            $table->decimal('total_gross', 15, 2)->default(0);
            $table->decimal('total_net', 15, 2)->default(0);
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->unsignedInteger('version')->default(0);
            $table->timestamps();

            $table->unique(['period_month', 'run_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payroll_runs');
    }
};
