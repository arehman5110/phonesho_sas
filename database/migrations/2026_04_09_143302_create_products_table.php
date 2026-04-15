<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Multi-shop scope
            $table->foreignId('shop_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Category & Brand
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');

            $table->foreignId('brand_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');

            // Product details
            $table->string('name');
            $table->string('sku')->nullable();
            $table->text('description')->nullable();

            // Pricing
            $table->decimal('cost_price', 10, 2)->default(0.00);
            $table->decimal('sell_price', 10, 2)->default(0.00);

            // Stock
            $table->integer('stock')->default(0);
            $table->integer('low_stock_alert')->default(5);

            // Status
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['shop_id', 'category_id']);
            $table->index(['shop_id', 'brand_id']);
            $table->index(['shop_id', 'sku']);
            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};