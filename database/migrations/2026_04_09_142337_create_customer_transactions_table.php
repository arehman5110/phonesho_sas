<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_transactions', function (Blueprint $table) {
            $table->id();

            // Multi-shop scope
            $table->foreignId('shop_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Which customer
            $table->foreignId('customer_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Who created this transaction
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');

            // debit  = customer owes more (e.g. new repair, new sale)
            // credit = customer balance reduced (e.g. payment received)
            $table->enum('type', ['debit', 'credit']);

            $table->decimal('amount', 10, 2);

            // Polymorphic reference — links to repair, sale, payment etc
            // e.g. reference_type = 'App\Models\Repair', reference_id = 5
            $table->string('reference_type')->nullable();
            $table->foreignId('reference_id')->nullable();

            $table->string('note')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['shop_id', 'customer_id']);
            $table->index(['reference_type', 'reference_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_transactions');
    }
};