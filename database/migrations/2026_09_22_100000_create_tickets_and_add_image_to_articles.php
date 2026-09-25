<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('articles', 'image')) {
            Schema::table('articles', function (Blueprint $table) {
                $table->string('image')->nullable()->after('content');
            });
        }

        if (!Schema::hasTable('tickets')) {
            Schema::create('tickets', function (Blueprint $table) {
                $table->id();
                $table->string('ticket_number')->unique();
                $table->string('name');
                $table->string('company')->nullable();
                $table->string('phone');
                $table->string('email')->nullable();
                $table->string('category')->nullable();
                $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
                $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
                $table->string('subject');
                $table->text('message');
                $table->enum('status', ['pending', 'in_progress', 'resolved', 'closed'])->default('pending');
                $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
                $table->text('notes')->nullable();
                $table->timestamps();

                $table->index('status');
                $table->index('ticket_number');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');

        if (Schema::hasColumn('articles', 'image')) {
            Schema::table('articles', function (Blueprint $table) {
                $table->dropColumn('image');
            });
        }
    }
};
