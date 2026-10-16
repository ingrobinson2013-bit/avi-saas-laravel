<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('whatsapp_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('phone_number')->index(); // Ej: 573123456789
            $table->foreignUuid('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->foreignUuid('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignUuid('active_pet_id')->nullable()->constrained('pets')->nullOnDelete();
            
            // Estado de la conversación: initial, menu, awaiting_triage, awaiting_payment, etc.
            $table->string('current_step')->default('initial');
            
            // Contexto persistente (JSON): datos temporales del flujo, última selección, historial breve
            $table->jsonb('context_data')->nullable();
            
            $table->timestamp('last_interaction_at')->nullable();
            $table->timestamps();

            $table->index(['phone_number', 'tenant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_sessions');
    }
};
