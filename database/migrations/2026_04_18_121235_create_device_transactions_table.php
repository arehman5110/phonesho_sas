<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('device_transactions', function (Blueprint $table) {
            $table->id();

            // ── Core relationships ─────────────────────────────
            $table->foreignId('device_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // ── Buy = we bought from someone, Sell = we sold to someone
            $table->enum('type', ['buy', 'sell']);

            $table->foreignId('customer_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            // ── Financials ─────────────────────────────────────
            $table->decimal('price',        10, 2);
            $table->decimal('discount',     10, 2)->default(0);
            $table->decimal('final_amount', 10, 2);           // price - discount

            // ── Payment state ──────────────────────────────────
            $table->enum('payment_status', [
                'unpaid',
                'partial',
                'paid',
            ])->default('unpaid');

            $table->text('notes')->nullable();

            $table->timestamps();

            // ── Indexes ────────────────────────────────────────
            $table->index('device_id');
            $table->index('customer_id');
            $table->index('type');
            $table->index('payment_status');
            $table->index(['device_id', 'type']);             // find all sells for a device
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('device_transactions');
    }
};