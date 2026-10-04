<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignUuid('pet_id')->constrained('pets')->cascadeOnDelete();
            $table->foreignUuid('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignUuid('benefit_definition_id')->nullable()->constrained('benefit_definitions')->nullOnDelete();
            $table->string('doctor_name')->default('Dra. Vicky Naranjo');
            $table->string('title');
            $table->dateTime('scheduled_at');
            $table->dateTime('end_at');
            $table->integer('duration_minutes')->default(30);
            $table->string('status')->default('scheduled'); // scheduled, confirmed, completed, cancelled, no_show
            $table->string('service_type')->default('consulta'); // consulta, vacuna, desparasitacion, profilaxis, urgencia, control
            $table->text('notes')->nullable();
            $table->string('google_event_id')->nullable();
            $table->string('google_calendar_url', 1000)->nullable();
            $table->string('sync_status')->default('synced'); // synced, pending, failed
            $table->timestamps();

            $table->index(['tenant_id', 'scheduled_at']);
            $table->index(['tenant_id', 'status']);
            $table->index('pet_id');
            $table->index('customer_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
