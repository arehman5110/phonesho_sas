<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repair_devices', function (Blueprint $table) {
            $table->id();

            // Which repair this device belongs to
            $table->foreignId('repair_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Device type (mobile, laptop, tablet etc)
            $table->foreignId('device_type_id')
                  ->nullable()
                  ->constrained('device_types')
                  ->onDelete('set null');

            // Device status
            $table->unsignedBigInteger('status_id')->nullable();

            // Device details
            $table->string('imei')->nullable();
            $table->string('color')->nullable();
            $table->string('issue')->nullable();

            // Repair type — autocomplete text
            // e.g. Screen Replacement, Battery Replacement
            $table->string('repair_type')->nullable();

            // Internal notes
            $table->text('notes')->nullable();

            // Warranty
            // none     = no warranty
            // active   = under warranty
            // expired  = warranty expired
            $table->enum('warranty_status', [
                'none',
                'active',
                'expired',
            ])->default('none');

            // Price for this specific device repair
            $table->decimal('price', 10, 2)->default(0.00);

            $table->timestamps();

            // Indexes
            $table->index('repair_id');
            $table->index('imei');
            $table->index('status_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repair_devices');
    }
};