<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('status_logs', function (Blueprint $table) {
            $table->id();
            $table->string('entity_type')->index();
            $table->unsignedBigInteger('entity_id')->index();
            $table->string('from_status')->nullable();
            $table->string('to_status')->index();
            $table->json('metadata')->nullable();
            $table->uuid('correlation_id')->nullable()->index();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('created_at')->nullable()->index();
            // Immutable: no updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('status_logs');
    }
};
