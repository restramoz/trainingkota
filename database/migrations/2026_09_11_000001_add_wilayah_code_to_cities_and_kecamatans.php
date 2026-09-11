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
        // Add EMSIFA / Wilayah.id code to cities table
        Schema::table('cities', function (Blueprint $table) {
            $table->string('wilayah_code')->nullable()->after('slug');
            // Optional unique index if you want to enforce uniqueness across all cities
            $table->unique('wilayah_code');
        });

        // Add EMSIFA / Wilayah.id code to kecamatans table
        Schema::table('kecamatans', function (Blueprint $table) {
            $table->string('wilayah_code')->nullable()->after('status');
            // Composite unique index on city_id + wilayah_code (allows multiple NULLs)
            $table->unique(['city_id', 'wilayah_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropUnique(['wilayah_code']);
            $table->dropColumn('wilayah_code');
        });

        Schema::table('kecamatans', function (Blueprint $table) {
            $table->dropUnique(['city_id', 'wilayah_code']);
            $table->dropColumn('wilayah_code');
        });
    }
};
