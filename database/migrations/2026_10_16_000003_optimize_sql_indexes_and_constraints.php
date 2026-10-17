<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Optimizes PostgreSQL foreign key B-Tree indexes and enforces native
     * mathematical CHECK constraints on ledgers and wallets.
     */
    public function up(): void
    {
        // 1. Índices B-Tree para todas las llaves foráneas que carecían de índice individual
        $indexes = [
            'CREATE INDEX IF NOT EXISTS idx_subscriptions_plan_id ON subscriptions (plan_id)',
            'CREATE INDEX IF NOT EXISTS idx_benefit_redemptions_vet_user_id ON benefit_redemptions (vet_user_id)',
            'CREATE INDEX IF NOT EXISTS idx_saas_payment_logs_tenant_id ON saas_payment_logs (tenant_id)',
            'CREATE INDEX IF NOT EXISTS idx_wallet_transactions_created_by_user_id ON wallet_transactions (created_by_user_id)',
            'CREATE INDEX IF NOT EXISTS idx_dispatch_orders_subscription_id ON dispatch_orders (subscription_id)',
            'CREATE INDEX IF NOT EXISTS idx_dispatch_orders_pet_id ON dispatch_orders (pet_id)',
            'CREATE INDEX IF NOT EXISTS idx_dispatch_orders_customer_id ON dispatch_orders (customer_id)',
            'CREATE INDEX IF NOT EXISTS idx_appointments_benefit_definition_id ON appointments (benefit_definition_id)',
            'CREATE INDEX IF NOT EXISTS idx_whatsapp_sessions_customer_id ON whatsapp_sessions (customer_id)',
            'CREATE INDEX IF NOT EXISTS idx_whatsapp_sessions_active_pet_id ON whatsapp_sessions (active_pet_id)',
            'CREATE INDEX IF NOT EXISTS idx_triage_cases_customer_id ON triage_cases (customer_id)',
            'CREATE INDEX IF NOT EXISTS idx_triage_cases_pet_id ON triage_cases (pet_id)',
            'CREATE INDEX IF NOT EXISTS idx_triage_cases_whatsapp_session_id ON triage_cases (whatsapp_session_id)',
        ];

        foreach ($indexes as $sql) {
            DB::statement($sql);
        }

        // 2. Restricciones CHECK nativas en PostgreSQL para blindar saldos y ledgers
        if (DB::getDriverName() === 'pgsql') {
            DB::statement(<<<'SQL'
            DO $$
            BEGIN
                IF NOT EXISTS (
                    SELECT 1 FROM pg_constraint WHERE conname = 'chk_benefit_balances_integrity'
                ) THEN
                    ALTER TABLE subscription_benefit_balances
                    ADD CONSTRAINT chk_benefit_balances_integrity
                    CHECK (
                        remaining_count >= 0
                        AND used_count >= 0
                        AND total_granted >= 0
                        AND (total_granted - used_count) = remaining_count
                    );
                END IF;

                IF NOT EXISTS (
                    SELECT 1 FROM pg_constraint WHERE conname = 'chk_subscription_wallets_integrity'
                ) THEN
                    ALTER TABLE subscription_wallets
                    ADD CONSTRAINT chk_subscription_wallets_integrity
                    CHECK (
                        balance_cop >= 0
                        AND total_accrued_cop >= 0
                        AND total_redeemed_cop >= 0
                        AND (total_accrued_cop - total_redeemed_cop) = balance_cop
                    );
                END IF;

                IF NOT EXISTS (
                    SELECT 1 FROM pg_constraint WHERE conname = 'chk_benefit_redemptions_positive_qty'
                ) THEN
                    ALTER TABLE benefit_redemptions
                    ADD CONSTRAINT chk_benefit_redemptions_positive_qty
                    CHECK (quantity > 0);
                END IF;

                IF NOT EXISTS (
                    SELECT 1 FROM pg_constraint WHERE conname = 'chk_plans_non_negative_price'
                ) THEN
                    ALTER TABLE plans
                    ADD CONSTRAINT chk_plans_non_negative_price
                    CHECK (price_cop >= 0);
                END IF;
            END
            $$;
            SQL);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE subscription_benefit_balances DROP CONSTRAINT IF EXISTS chk_benefit_balances_integrity');
            DB::statement('ALTER TABLE subscription_wallets DROP CONSTRAINT IF EXISTS chk_subscription_wallets_integrity');
            DB::statement('ALTER TABLE benefit_redemptions DROP CONSTRAINT IF EXISTS chk_benefit_redemptions_positive_qty');
            DB::statement('ALTER TABLE plans DROP CONSTRAINT IF EXISTS chk_plans_non_negative_price');
        }

        $dropIndexes = [
            'DROP INDEX IF EXISTS idx_subscriptions_plan_id',
            'DROP INDEX IF EXISTS idx_benefit_redemptions_vet_user_id',
            'DROP INDEX IF EXISTS idx_saas_payment_logs_tenant_id',
            'DROP INDEX IF EXISTS idx_wallet_transactions_created_by_user_id',
            'DROP INDEX IF EXISTS idx_dispatch_orders_subscription_id',
            'DROP INDEX IF EXISTS idx_dispatch_orders_pet_id',
            'DROP INDEX IF EXISTS idx_dispatch_orders_customer_id',
            'DROP INDEX IF EXISTS idx_appointments_benefit_definition_id',
            'DROP INDEX IF EXISTS idx_whatsapp_sessions_customer_id',
            'DROP INDEX IF EXISTS idx_whatsapp_sessions_active_pet_id',
            'DROP INDEX IF EXISTS idx_triage_cases_customer_id',
            'DROP INDEX IF EXISTS idx_triage_cases_pet_id',
            'DROP INDEX IF EXISTS idx_triage_cases_whatsapp_session_id',
        ];

        foreach ($dropIndexes as $sql) {
            DB::statement($sql);
        }
    }
};
