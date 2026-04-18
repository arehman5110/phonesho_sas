<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();

            // ── Shop scope ─────────────────────────────────────
            $table->foreignId('shop_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // ── Optional link to products catalogue ────────────
            $table->foreignId('product_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            // ── Brand (required) ───────────────────────────────
            $table->foreignId('brand_id')
                  ->constrained()
                  ->restrictOnDelete();

            // ── Device identity ────────────────────────────────
            $table->string('model_name', 200);
            $table->string('imei', 20)->nullable()->unique();
            $table->string('serial_number', 100)->nullable();

            // ── Physical attributes ────────────────────────────
            $table->enum('condition', [
                'new',
                'used',
                'faulty',
                'refurbished',
            ])->default('used');

            $table->string('storage', 50)->nullable();    // e.g. 128GB
            $table->string('color', 50)->nullable();

            // ── Pricing ────────────────────────────────────────
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('selling_price',  10, 2)->nullable();

            // ── Lifecycle ──────────────────────────────────────
            $table->enum('status', [
                'in_stock',
                'sold',
                'reserved',
                'under_repair',
            ])->default('in_stock');

            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // ── Indexes ────────────────────────────────────────
            $table->index('shop_id');
            $table->index('brand_id');
            $table->index('status');
            $table->index('condition');
            $table->index(['shop_id', 'status']);         // common filter
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};