<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();

            // Shop scoped — each shop manages their own statuses
            $table->foreignId('shop_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Type allows same table for repair, buy_sell etc
            // e.g. type = 'repair', 'buy_sell'
            $table->string('type')->default('repair');

            $table->string('name');

            // Color for UI badge
            // e.g. green, red, blue, yellow, orange, purple, gray
            $table->string('color')->default('gray');

            // Is this the default status for new repairs?
            $table->boolean('is_default')->default(false);

            // Is this a completion status?
            // Used to mark repair as done
            $table->boolean('is_completed')->default(false);

            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            // Indexes
            $table->index(['shop_id', 'type']);
            $table->index(['shop_id', 'is_default']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};