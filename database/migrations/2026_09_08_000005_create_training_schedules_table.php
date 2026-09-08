<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->foreignId('city_id')->constrained('cities')->cascadeOnDelete();
            $table->date('date');
            $table->string('start_time')->nullable()->default('08:30');
            $table->string('end_time')->nullable()->default('16:30');
            $table->string('location');
            $table->integer('available_slots')->default(20);
            $table->string('status')->default('open'); // open, closed, full, completed
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('service_id');
            $table->index('city_id');
            $table->index('date');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_schedules');
    }
};
