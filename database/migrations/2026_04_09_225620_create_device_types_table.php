<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('device_types', function (Blueprint $table) {
            $table->id();

            // Shop scoped — each shop manages their own device types
            $table->foreignId('shop_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('name');
            $table->string('icon')->nullable(); // e.g. 'mobile', 'laptop'
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            // Indexes
            $table->index(['shop_id', 'is_active']);
            $table->unique(['shop_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('device_types');
    }
};