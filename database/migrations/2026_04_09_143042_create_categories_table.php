<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('shop_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('name');
            $table->string('slug')->nullable();

            // accessories = for products/POS
            // repair = for repair jobs
            $table->enum('type', ['accessories', 'repair', 'both'])
                  ->default('accessories');

            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->unique(['shop_id', 'slug']);
            $table->index(['shop_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};