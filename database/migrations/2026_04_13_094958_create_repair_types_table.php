<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repair_types', function (Blueprint $table) {
            $table->id();

            $table->foreignId('shop_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('name');

            // Track usage for sorting popular ones first
            $table->unsignedInteger('used_count')->default(0);

            $table->timestamps();

            $table->unique(['shop_id', 'name']);
            $table->index('shop_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repair_types');
    }
};