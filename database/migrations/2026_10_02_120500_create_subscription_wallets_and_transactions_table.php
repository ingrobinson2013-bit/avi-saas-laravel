<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Subscription Wallets (Billetera de Salud Dinámica / Fondo de Emergencia de la Mascota)
        Schema::create('subscription_wallets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignUuid('subscription_id')->unique()->constrained('subscriptions')->cascadeOnDelete();
            $table->decimal('balance_cop', 12, 2)->default(0); // Saldo actual acumulado y disponible
            $table->decimal('total_accrued_cop', 12, 2)->default(0); // Total histórico acumulado por aportes (10%)
            $table->decimal('total_redeemed_cop', 12, 2)->default(0); // Total histórico redimido en cirugías/urgencias
            $table->decimal('reserve_percentage', 5, 2)->default(10.00); // 10.00% por defecto
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['tenant_id', 'balance_cop']);
        });

        // 2. Wallet Transactions (Ledger Inmutable de Movimientos de la Billetera)
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('wallet_id')->constrained('subscription_wallets')->cascadeOnDelete();
            $table->string('type'); // 'accrual' (aporte cuota), 'redemption' (canje urgencia), 'bonus', 'adjustment'
            $table->decimal('amount_cop', 12, 2);
            $table->decimal('balance_after_cop', 12, 2);
            $table->string('description');
            $table->string('reference_id')->nullable(); // Ej: ID de canje, factura o pago
            $table->foreignUuid('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['wallet_id', 'created_at']);
            $table->index(['wallet_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
        Schema::dropIfExists('subscription_wallets');
    }
};
