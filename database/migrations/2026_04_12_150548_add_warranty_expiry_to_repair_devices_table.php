<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('repair_devices', function (Blueprint $table) {

            // How many days warranty this device gets
            $table->unsignedInteger('warranty_days')
                  ->nullable()
                  ->after('warranty_status');

            // Calculated expiry date
            $table->date('warranty_expiry_date')
                  ->nullable()
                  ->after('warranty_days');

        });
    }

    public function down(): void
    {
        Schema::table('repair_devices', function (Blueprint $table) {
            $table->dropColumn(['warranty_days', 'warranty_expiry_date']);
        });
    }
};