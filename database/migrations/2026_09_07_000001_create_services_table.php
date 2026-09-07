<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('category')->index(); // pelatihan, kajian, jasa
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('badge')->nullable(); // Kemnaker RI, BNSP, PJK3 Resmi
            $table->string('duration')->nullable(); // e.g. 12 Hari, 4 Hari, Fleksibel
            $table->string('price_estimate')->nullable();
            $table->text('description')->nullable();
            $table->text('syllabus')->nullable();
            $table->text('target_audience')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
