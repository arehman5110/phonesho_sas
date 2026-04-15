<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();

            // Multi-shop scope
            $table->foreignId('shop_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Customer
            $table->foreignId('customer_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');

            // Status — dynamic (set after statuses table is created)
            $table->unsignedBigInteger('status_id')->nullable();

            // Who created this repair
            $table->foreignId('created_by')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

            // Who is assigned to this repair
            $table->foreignId('assigned_to')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

            // Repair reference number e.g. REP-00001
            $table->string('reference')->nullable();

            // Pricing
            $table->decimal('total_price',  10, 2)->default(0.00);
            $table->decimal('discount',     10, 2)->default(0.00);
            $table->decimal('final_price',  10, 2)->default(0.00);

            // Dates
            $table->date('book_in_date')->nullable();
            $table->date('completion_date')->nullable();

            // delivery = we deliver to customer
            // collection = customer collects
            $table->enum('delivery_type', [
                'collection',
                'delivery',
            ])->default('collection');

            // Internal notes
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['shop_id', 'customer_id']);
            $table->index(['shop_id', 'status_id']);
            $table->index('reference');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repairs');
    }
};