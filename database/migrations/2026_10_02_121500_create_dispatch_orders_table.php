<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dispatch_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignUuid('subscription_id')->nullable()->constrained('subscriptions')->nullOnDelete();
            $table->foreignUuid('pet_id')->constrained('pets')->cascadeOnDelete();
            $table->foreignUuid('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->string('product_name'); // Ej: Credelio 450mg, Nexgard Spectra, Drontal Plus
            $table->string('dosage')->default('1 comprimido oral');
            $table->integer('frequency_months')->default(3); // Cada 3 meses o mensual
            $table->date('scheduled_dispatch_date');
            $table->string('status')->default('scheduled'); // scheduled, in_preparation, shipped, delivered
            $table->string('tracking_number')->nullable();
            $table->string('courier_name')->default('Mensajería Express Local / Coordinadora');
            $table->string('delivery_address');
            $table->string('recipient_phone');
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'status']);
            $table->index(['tenant_id', 'scheduled_dispatch_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dispatch_orders');
    }
};
