<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\SubscriptionWallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class HealthWalletService
{
    /**
     * Obtiene o crea la Billetera de Salud Dinámica para una suscripción.
     */
    public function getOrCreateWallet(Subscription $subscription): SubscriptionWallet
    {
        return SubscriptionWallet::firstOrCreate(
            ['subscription_id' => $subscription->id],
            [
                'tenant_id' => $subscription->tenant_id,
                'balance_cop' => 0,
                'total_accrued_cop' => 0,
                'total_redeemed_cop' => 0,
                'reserve_percentage' => 10.00,
                'is_active' => true,
            ]
        );
    }

    /**
     * Acumula el 10% de la cuota mensual en la billetera de salud como Fondo de Reserva.
     */
    public function accrueMonthlyFund(
        Subscription $subscription,
        ?float $amountCop = null,
        string $description = 'Aporte Fondo de Reserva Preventivo (10% cuota mensual)'
    ): WalletTransaction {
        return DB::transaction(function () use ($subscription, $amountCop, $description) {
            $wallet = $this->getOrCreateWallet($subscription);

            // Si no se especifica el monto, calcular el 10% del precio del plan
            if ($amountCop === null) {
                $planPrice = (float) ($subscription->plan?->price_cop ?? 50000);
                $percentage = (float) ($wallet->reserve_percentage ?? 10.00);
                $amountCop = round(($planPrice * $percentage) / 100, 2);
            }

            if ($amountCop <= 0) {
                throw new InvalidArgumentException('El monto a acumular en la billetera debe ser mayor a cero.');
            }

            $wallet->balance_cop += $amountCop;
            $wallet->total_accrued_cop += $amountCop;
            $wallet->save();

            return WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'accrual',
                'amount_cop' => $amountCop,
                'balance_after_cop' => $wallet->balance_cop,
                'description' => $description,
                'reference_id' => $subscription->id,
            ]);
        });
    }

    /**
     * Redime saldo del Fondo de Emergencia para cirugías, urgencias o tratamientos especializados.
     */
    public function redeemFund(
        SubscriptionWallet $wallet,
        float $amountCop,
        string $reason,
        ?string $referenceId = null,
        ?string $vetUserId = null
    ): WalletTransaction {
        return DB::transaction(function () use ($wallet, $amountCop, $reason, $referenceId, $vetUserId) {
            if ($amountCop <= 0) {
                throw new InvalidArgumentException('El monto a redimir debe ser mayor a cero.');
            }

            if ($wallet->balance_cop < $amountCop) {
                throw new InvalidArgumentException(
                    "Saldo insuficiente en el Fondo de Emergencia. Saldo actual: \${$wallet->balance_cop} COP, solicitado: \${$amountCop} COP."
                );
            }

            $wallet->balance_cop -= $amountCop;
            $wallet->total_redeemed_cop += $amountCop;
            $wallet->save();

            return WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'redemption',
                'amount_cop' => $amountCop,
                'balance_after_cop' => $wallet->balance_cop,
                'description' => $reason,
                'reference_id' => $referenceId,
                'created_by_user_id' => $vetUserId,
            ]);
        });
    }

    /**
     * Métricas globales de la Billetera para el Dashboard de la Clínica.
     */
    public function getWalletMetrics(string $tenantId): array
    {
        $wallets = SubscriptionWallet::where('tenant_id', $tenantId)->get();

        $totalBalance = $wallets->sum('balance_cop');
        $totalAccrued = $wallets->sum('total_accrued_cop');
        $totalRedeemed = $wallets->sum('total_redeemed_cop');
        $activeWalletsCount = $wallets->where('balance_cop', '>', 0)->count();

        return [
            'total_balance_cop' => $totalBalance,
            'formatted_total_balance' => '$' . number_format($totalBalance, 0, ',', '.') . ' COP',
            'total_accrued_cop' => $totalAccrued,
            'total_redeemed_cop' => $totalRedeemed,
            'active_wallets_count' => $activeWalletsCount,
            'avg_wallet_balance' => $activeWalletsCount > 0 ? round($totalBalance / $activeWalletsCount, 2) : 0,
        ];
    }
}
