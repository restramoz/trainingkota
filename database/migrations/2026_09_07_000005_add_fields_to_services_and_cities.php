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
        Schema::table('services', function (Blueprint $table) {
            $table->string('status')->default('published')->after('target_audience'); // published, draft
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->string('sentra_praktik')->nullable()->after('address'); // Contoh: "Sentra Praktik K3 & Riksa Uji Kawasan Industri Singosari"
            $table->text('maps_embed_url')->nullable()->after('sentra_praktik'); // Custom Google Maps iframe/embed URL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['status']);
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn(['sentra_praktik', 'maps_embed_url']);
        });
    }
};
