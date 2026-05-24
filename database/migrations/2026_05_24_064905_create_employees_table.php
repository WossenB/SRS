<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('employees');
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('restrict');
            $table->string('employee_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();

            $table->text('address')->nullable();
            $table->dateTime('date_of_birth')->nullable();
            $table->dateTime('hire_date')->nullable();
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('restrict');
            $table->foreignId('position_id')->nullable()->constrained()->onDelete('restrict');
            $table->foreignId('supervisor_id')->nullable()->constrained('employees')->onDelete('set null');

            $table->text('basic_salary');
            $table->text('bank_details')->nullable();
            $table->text('tin_number')->nullable();

            $table->string('status')->default('active')->index();
            $table->unsignedInteger('version')->default(0);

            $table->timestamps();
            $table->softDeletes();

            // FULLTEXT for search - MySQL only
            // $table->fulltext(['first_name', 'last_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
