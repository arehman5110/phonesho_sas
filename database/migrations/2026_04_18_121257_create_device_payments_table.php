<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('device_payments', function (Blueprint $table) {
            $table->id();

            // ── Belongs to a transaction ───────────────────────
            $table->foreignId('transaction_id')
                  ->constrained('device_transactions')
                  ->cascadeOnDelete();

            // ── Payment details ────────────────────────────────
            $table->string('method', 50);   // cash, card, bank_transfer, trade, etc.
            $table->decimal('amount', 10, 2);
            $table->string('note', 500)->nullable();

            $table->timestamps();

            // ── Indexes ────────────────────────────────────────
            $table->index('transaction_id');
            $table->index('method');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('device_payments');
    }
};