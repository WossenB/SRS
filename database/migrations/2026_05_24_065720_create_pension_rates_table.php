<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pension_rates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('employee_rate', 5, 2);
            $table->decimal('employer_rate', 5, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pension_rates');
    }
};
