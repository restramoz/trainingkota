<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained('cities')->cascadeOnDelete();
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatans')->nullOnDelete();
            $table->string('location_name');
            $table->text('address')->nullable();
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->text('google_maps_url')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();

            $table->index('city_id');
            $table->index('kecamatan_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
