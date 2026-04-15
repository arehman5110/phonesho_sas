<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repair_parts', function (Blueprint $table) {
            $table->id();

            // Which repair device this part belongs to
            $table->foreignId('repair_device_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Product from inventory (nullable — can be manual)
            $table->foreignId('product_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');

            // Who added this part
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');

            // Part name — auto filled from product
            // or manually entered
            $table->string('name');

            // Quantity used
            $table->integer('quantity')->default(1);

            // Price at time of use
            $table->decimal('price', 10, 2)->default(0.00);

            // Was stock deducted from inventory?
            $table->boolean('stock_deducted')->default(false);

            $table->text('notes')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('repair_device_id');
            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repair_parts');
    }
};