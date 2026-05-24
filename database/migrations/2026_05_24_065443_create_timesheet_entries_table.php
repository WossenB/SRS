<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timesheet_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('timesheet_id')->constrained()->onDelete('restrict');
            $table->date('date')->index();
            $table->decimal('hours', 4, 2);
            $table->string('type')->default('regular'); // regular, overtime, holiday
            $table->text('task_description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timesheet_entries');
    }
};
