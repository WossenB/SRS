<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('performance_cycles', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., 2024 Annual Review
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default('active')->index(); // active, calibrating, published
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_cycles');
    }
};
