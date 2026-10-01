<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saas_payment_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->string('order_id')->nullable()->index();
            $table->string('gateway')->default('bold'); // bold, nequi, bancolombia, cash, manual
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('COP');
            $table->string('plan_tier')->default('pro'); // starter, pro, enterprise, pay_per_pet, custom
            $table->string('status')->default('approved'); // approved, pending, failed, refunded
            $table->string('transaction_id')->nullable();
            $table->string('payer_name')->nullable();
            $table->string('payer_email')->nullable();
            $table->string('payer_phone')->nullable();
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->text('notes')->nullable();
            $table->json('raw_payload')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saas_payment_logs');
    }
};
