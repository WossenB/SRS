<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payroll_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_run_id')->constrained()->onDelete('restrict');
            $table->foreignId('employee_id')->constrained()->onDelete('restrict');
            $table->decimal('basic_salary', 15, 2);
            $table->decimal('gross_salary', 15, 2);
            $table->decimal('taxable_income', 15, 2);
            $table->decimal('income_tax', 15, 2);
            $table->decimal('pension_employee', 15, 2);
            $table->decimal('pension_employer', 15, 2);
            $table->decimal('net_pay', 15, 2);
            $table->json('adjustments')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payroll_items');
    }
};
