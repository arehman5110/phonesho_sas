<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('shop_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Voucher code — unique per shop
            $table->string('code', 50);

            // fixed = £ off, percentage = % off
            $table->enum('type', ['fixed', 'percentage']);

            // Discount value
            $table->decimal('value', 10, 2);

            // Max uses — null = unlimited
            $table->unsignedInteger('usage_limit')->nullable();

            // How many times used
            $table->unsignedInteger('used_count')->default(0);

            // Minimum order amount
            $table->decimal('min_order_amount', 10, 2)->default(0);

            // Assign to specific customer (nullable = anyone can use)
            $table->foreignId('assigned_to')
                  ->nullable()
                  ->constrained('customers')
                  ->onDelete('set null');

            // Expiry
            $table->date('expiry_date')->nullable();

            // Active flag
            $table->boolean('is_active')->default(true);

            // Notes
            $table->text('notes')->nullable();

            $table->timestamps();

            // Unique code per shop
            $table->unique(['shop_id', 'code']);
            $table->index(['shop_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};