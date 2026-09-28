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
        Schema::table('articles', function (Blueprint $table) {
            // Unique constraint to prevent duplicate global articles
            // One article per service + category + city + kecamatan combination
            $table->unique(['service_id', 'category', 'city_id', 'kecamatan_id'], 
                'articles_service_category_city_kec_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropUnique('articles_service_category_city_kec_unique');
        });
    }
};
