<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shop_settings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('shop_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Key-value store
            // e.g. receipt_footer, receipt_terms, email_subject
            $table->string('key');
            $table->text('value')->nullable();

            $table->timestamps();

            // One value per key per shop
            $table->unique(['shop_id', 'key']);
            $table->index('shop_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shop_settings');
    }
};