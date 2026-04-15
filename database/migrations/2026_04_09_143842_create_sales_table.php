<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            // Multi-shop scope
            $table->foreignId('shop_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Customer is optional — walk-in sales
            $table->foreignId('customer_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');

            // Who created this sale
            $table->foreignId('created_by')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

            // Sale reference number e.g. SALE-00001
            $table->string('reference')->nullable();

            // Amounts
            $table->decimal('total_amount', 10, 2)->default(0.00);
            $table->decimal('discount',     10, 2)->default(0.00);
            $table->decimal('final_amount', 10, 2)->default(0.00);

            // Payment
            // pending  = not yet paid
            // paid     = fully paid
            // partial  = partially paid
            // refunded = refunded
            $table->enum('payment_status', [
                'pending',
                'paid',
                'partial',
                'refunded',
            ])->default('pending');

            $table->enum('payment_method', [
                'cash',
                'card',
                'split',
                'other',
            ])->default('cash');

            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['shop_id', 'customer_id']);
            $table->index(['shop_id', 'payment_status']);
            $table->index('reference');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};