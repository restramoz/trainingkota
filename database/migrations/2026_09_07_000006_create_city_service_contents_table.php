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
        Schema::create('city_service_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->foreignId('service_id')->nullable()->constrained('services')->onDelete('cascade');
            $table->string('category')->nullable(); // pelatihan, kajian, jasa
            $table->string('seo_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('custom_heading')->nullable();
            $table->longText('custom_content')->nullable();
            $table->timestamps();

            $table->unique(['city_id', 'service_id', 'category'], 'city_service_cat_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('city_service_contents');
    }
};
