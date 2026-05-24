<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('benefit_catalogs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->index(); // allowance, insurance, etc.
            $table->text('description')->nullable();
            $table->json('eligibility_rules')->nullable();
            $table->boolean('is_taxable')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('benefit_catalogs');
    }
};
