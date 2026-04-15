<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();

            // Brands are shop-scoped
            // Each shop manages their own brand list
            $table->foreignId('shop_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            // Same brand name allowed across different shops
            $table->unique(['shop_id', 'slug']);
            $table->index('shop_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};