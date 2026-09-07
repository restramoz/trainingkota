<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create articles table for SEO high-authority content
     * (1500+ kata, H2/H3, Table of Contents, FAQ, Schema JSON-LD).
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            // Relasi (nullable → artikel bisa generic tanpa kota/service)
            $table->string('category')->nullable();    // 'pelatihan', 'kajian', 'jasa', atau null
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();

            // Konten Utama
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt');                   // ~150-200 kata untuk preview
            $table->longText('content');               // HTML penuh 1500+ kata
            $table->integer('reading_time')->default(7); // dalam menit

            // FAQ items sebagai JSON array [{q: '...', a: '...'}]
            $table->json('faq_items')->nullable();

            // SEO Meta
            $table->string('seo_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('focus_keywords')->nullable();

            // Status
            $table->enum('status', ['draft', 'published'])->default('published');

            $table->timestamps();

            // Index untuk lookup cepat
            $table->index(['category', 'status']);
            $table->index(['city_id', 'status']);
            $table->index(['service_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
