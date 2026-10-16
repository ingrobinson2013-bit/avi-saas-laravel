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
        Schema::create('triage_cases', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignUuid('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignUuid('pet_id')->nullable()->constrained('pets')->nullOnDelete();
            $table->foreignUuid('whatsapp_session_id')->nullable()->constrained('whatsapp_sessions')->nullOnDelete();
            
            $table->string('phone_number')->index();
            $table->text('symptoms_raw');
            $table->text('ai_draft_response')->nullable();
            
            // Niveles de gravedad: leve, moderado, urgente, critico
            $table->string('ai_severity_level')->default('moderado');
            $table->decimal('ai_confidence_score', 4, 2)->default(0.85);
            
            // Estado: pending_approval, approved, modified, rejected, emergency_redirected
            $table->string('status')->default('pending_approval')->index();
            
            // Feedback del especialista (Human-in-the-Loop / RLHF)
            $table->text('doctor_notes')->nullable();
            $table->string('doctor_reviewed_by')->nullable();
            $table->string('telegram_message_id')->nullable();
            
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('sent_to_whatsapp_at')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('triage_cases');
    }
};
