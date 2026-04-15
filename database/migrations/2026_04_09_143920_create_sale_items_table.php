<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();

            // Which sale
            $table->foreignId('sale_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Which product
            $table->foreignId('product_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');

            // Store product name at time of sale
            // In case product is deleted later
            $table->string('product_name');

            // Quantity sold
            $table->integer('quantity')->default(1);

            // Price at time of sale
            // Stored separately in case product price changes later
            $table->decimal('price',     10, 2)->default(0.00);
            $table->decimal('cost_price',10, 2)->default(0.00);

            // Line total = quantity * price
            $table->decimal('line_total', 10, 2)->default(0.00);

            $table->timestamps();

            // Indexes
            $table->index('sale_id');
            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};