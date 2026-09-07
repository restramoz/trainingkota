<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add geographic & address fields to cities table
     * for Google Maps embed and LocalBusiness JSON-LD Schema.
     */
    public function up(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->decimal('lat', 10, 7)->nullable()->after('is_hub');
            $table->decimal('lng', 10, 7)->nullable()->after('lat');
            $table->string('address')->nullable()->after('lng'); // Contoh: "Jl. Soekarno Hatta, Malang, Jawa Timur"
            $table->string('province')->nullable()->after('address'); // Provinsi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn(['lat', 'lng', 'address', 'province']);
        });
    }
};
