<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_openings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('department_id')->constrained();
            $table->text('description');
            $table->json('requirements')->nullable();
            $table->string('status')->default('open')->index(); // open, closed, on_hold
            $table->date('closing_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_openings');
    }
};
