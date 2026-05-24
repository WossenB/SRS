<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tax_slabs', function (Blueprint $table) {
            $table->id();
            $table->decimal('min_income', 15, 2);
            $table->decimal('max_income', 15, 2)->nullable();
            $table->decimal('rate', 5, 2);
            $table->decimal('deduction', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tax_slabs');
    }
};
