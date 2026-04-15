<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('repairs', function (Blueprint $table) {

            // Link to original repair for warranty returns
            $table->foreignId('parent_repair_id')
                  ->nullable()
                  ->after('shop_id')
                  ->constrained('repairs')
                  ->onDelete('set null');

            // Flag as warranty return
            $table->boolean('is_warranty_return')
                  ->default(false)
                  ->after('parent_repair_id');

        });
    }

    public function down(): void
    {
        Schema::table('repairs', function (Blueprint $table) {
            $table->dropForeign(['parent_repair_id']);
            $table->dropColumn(['parent_repair_id', 'is_warranty_return']);
        });
    }
};