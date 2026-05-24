<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained();
            $table->dateTime('interview_date');
            $table->string('type')->nullable(); // Phone, Technical, HR
            $table->json('panel_json')->nullable();
            $table->decimal('score', 3, 1)->nullable(); // 1-5
            $table->text('feedback')->nullable();
            $table->string('status')->default('scheduled'); // scheduled, completed, cancelled
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};
