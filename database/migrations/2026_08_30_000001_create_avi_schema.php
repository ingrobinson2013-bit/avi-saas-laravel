<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tenants (Clínicas Veterinarias)
        Schema::create('tenants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('domain')->nullable()->unique();
            $table->jsonb('branding')->nullable(); // { logo_url, primary_color, secondary_color }
            $table->boolean('is_active')->default(true);
            $table->string('saas_plan_tier')->default('basic'); // basic, pro, enterprise
            $table->timestamps();

            $table->index(['slug', 'is_active']);
        });

        // 2. Users (SuperAdmins, Veterinarios, Recepcionistas)
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tenant_id')->nullable()->constrained('tenants')->cascadeOnDelete();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('vet_staff'); // super_admin, clinic_admin, vet_doctor, reception
            $table->rememberToken();
            $table->timestamps();

            $table->index(['tenant_id', 'role']);
        });

        // 3. Customers (Tutores / Propietarios de mascotas)
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('identification')->nullable(); // Cédula tutor
            $table->timestamps();

            $table->index(['tenant_id', 'identification']);
            $table->index(['tenant_id', 'phone']);
        });

        // 4. Pets (Mascotas de los tutores)
        Schema::create('pets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->string('name');
            $table->string('species')->default('dog'); // dog, cat, other
            $table->string('breed')->nullable();
            $table->date('birthdate')->nullable();
            $table->text('medical_notes')->nullable();
            $table->timestamps();

            $table->index(['customer_id', 'species']);
        });

        // 5. Benefit Definitions (Catálogo maestro de servicios canjeables)
        Schema::create('benefit_definitions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->string('name'); // Ej. Consulta General, Vacuna Rabia, Baño Medicado
            $table->text('description')->nullable();
            $table->string('category')->default('consulta'); // consulta, vacuna, desparasitacion, bano, guarderia
            $table->integer('default_validity_days')->default(365);
            $table->timestamps();

            $table->index(['tenant_id', 'category']);
        });

        // 6. Plans (Catálogo de Planes de Salud por Clínica)
        Schema::create('plans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->string('name'); // Ej. Plan Cachorros, Plan Patitas Vital
            $table->text('description')->nullable();
            $table->decimal('price_cop', 12, 2);
            $table->string('billing_interval')->default('monthly'); // monthly, annual
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['tenant_id', 'is_active']);
        });

        // 7. Plan Benefits (Tabla Pivote de cupos asignados por plan)
        Schema::create('plan_benefits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('plan_id')->constrained('plans')->cascadeOnDelete();
            $table->foreignUuid('benefit_definition_id')->constrained('benefit_definitions')->cascadeOnDelete();
            $table->integer('quantity')->default(1); // Cantidad de cupos (ej: 6 consultas al año)
            $table->boolean('expires_each_cycle')->default(true);
            $table->timestamps();

            $table->unique(['plan_id', 'benefit_definition_id']);
        });

        // 8. Subscriptions (Contratos de Membresía por Mascota)
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignUuid('pet_id')->constrained('pets')->cascadeOnDelete();
            $table->foreignUuid('plan_id')->constrained('plans')->cascadeOnDelete();
            $table->string('status')->default('active'); // active, past_due, canceled, paused
            $table->timestamp('current_period_start');
            $table->timestamp('current_period_end');
            $table->string('gateway_subscription_id')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'status']);
            $table->index(['pet_id', 'status']);
        });

        // 9. Subscription Benefit Balances (Ledger de Saldo en Vivo)
        Schema::create('subscription_benefit_balances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('subscription_id')->constrained('subscriptions')->cascadeOnDelete();
            $table->foreignUuid('benefit_definition_id')->constrained('benefit_definitions')->cascadeOnDelete();
            $table->integer('total_granted')->default(0);
            $table->integer('used_count')->default(0);
            $table->integer('remaining_count')->default(0);
            $table->timestamps();

            $table->unique(['subscription_id', 'benefit_definition_id'], 'sub_benefit_unique');
            $table->index(['subscription_id', 'remaining_count']);
        });

        // 10. Benefit Redemptions (Historial Inmutable de Canjes en Recepción)
        Schema::create('benefit_redemptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignUuid('balance_id')->constrained('subscription_benefit_balances')->cascadeOnDelete();
            $table->timestamp('redeemed_at');
            $table->foreignUuid('vet_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->integer('quantity')->default(1);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'redeemed_at']);
            $table->index(['balance_id', 'redeemed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('benefit_redemptions');
        Schema::dropIfExists('subscription_benefit_balances');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('plan_benefits');
        Schema::dropIfExists('plans');
        Schema::dropIfExists('benefit_definitions');
        Schema::dropIfExists('pets');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('users');
        Schema::dropIfExists('tenants');
    }
};
