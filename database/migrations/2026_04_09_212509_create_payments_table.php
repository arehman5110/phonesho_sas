<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Multi-shop scope
            $table->foreignId('shop_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Who took the payment
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');

            // Polymorphic — links to Sale, Repair, BuySell etc
            $table->string('payable_type');
            $table->unsignedBigInteger('payable_id');

            // Payment details
            $table->enum('method', [
                'cash',
                'card',
                'split',
                'trade',
                'other',
            ])->default('cash');

            $table->decimal('amount', 10, 2);

            // For split payments — which part is this
            // e.g. split_cash, split_card
            $table->string('split_part')->nullable();

            // Optional reference
            $table->string('reference')->nullable();

            $table->text('note')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['payable_type', 'payable_id']);
            $table->index(['shop_id', 'method']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};