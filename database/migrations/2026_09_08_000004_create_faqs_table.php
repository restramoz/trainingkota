<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatans')->nullOnDelete();
            $table->text('question');
            $table->text('answer');
            $table->integer('order')->default(0);
            $table->string('status')->default('published');
            $table->timestamps();

            $table->index('service_id');
            $table->index('city_id');
            $table->index('kecamatan_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
