<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('restrict');
            $table->string('title');
            $table->string('category')->index(); // ID, Contract, Educational, etc.
            $table->string('file_path');
            $table->string('file_type');
            $table->integer('file_size');
            $table->string('verification_status')->default('pending')->index();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('verified_at')->nullable();
            $table->date('expiry_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_documents');
    }
};
