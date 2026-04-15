<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();

            // Multi-shop scope
            $table->foreignId('shop_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Which product
            $table->foreignId('product_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Who made this movement
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');

            // Type of movement
            // purchase = stock coming in
            // sale     = stock going out via POS
            // repair   = stock used in repair
            // manual   = manual adjustment by admin
            // return   = stock returned
            $table->enum('type', [
                'purchase',
                'sale',
                'repair',
                'manual',
                'return',
            ]);

            // Positive = stock added
            // Negative = stock removed
            $table->integer('quantity');

            // Stock level before and after
            // Useful for audit trail
            $table->integer('stock_before')->default(0);
            $table->integer('stock_after')->default(0);

            // Polymorphic reference
            // Links to repair, sale, purchase order etc
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();

            $table->string('note')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['shop_id', 'product_id']);
            $table->index(['reference_type', 'reference_id']);
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};