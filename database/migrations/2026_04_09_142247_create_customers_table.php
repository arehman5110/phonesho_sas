<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            // Multi-shop scope
            $table->foreignId('shop_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Basic info
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->text('notes')->nullable();

            // Balance tracking
            // Positive = customer owes us (outstanding)
            // Negative = we owe customer (credit/overpaid)
            $table->decimal('balance', 10, 2)->default(0.00);

            // Soft delete so history is never lost
            $table->timestamps();
            $table->softDeletes();

            // Indexes for fast lookup
            $table->index(['shop_id', 'phone']);
            $table->index(['shop_id', 'email']);
            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};