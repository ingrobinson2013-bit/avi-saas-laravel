<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Models\User;
use App\Notifications\NewEnrollmentClinicNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class CheckExpiringSubscriptionsCommand extends Command
{
    protected $signature = 'avi:check-expiring-subscriptions {--days=7 : Días de anticipación para la alerta}';

    protected $description = 'Audita suscripciones próximas a vencer (7, 3 y 1 día) y actualiza estados de mora';

    public function handle(): int
    {
        $days = (int) $this->option('days');
        $targetDate = Carbon::today()->addDays($days);

        $this->info("🔍 Escaneando suscripciones con vencimiento dentro de {$days} días...");

        // 1. Suscripciones próximas a vencer
        $expiringSubscriptions = Subscription::query()
            ->with(['pet.customer', 'plan', 'tenant'])
            ->where('status', 'active')
            ->whereDate('current_period_end', '<=', $targetDate)
            ->whereDate('current_period_end', '>=', Carbon::today())
            ->get();

        $this->info("📋 Suscripciones próximas a vencer encontradas: {$expiringSubscriptions->count()}");

        foreach ($expiringSubscriptions as $sub) {
            $daysLeft = Carbon::today()->diffInDays(Carbon::parse($sub->current_period_end), false);
            $pet = $sub->pet;
            $customer = $pet?->customer;
            $tenant = $sub->tenant;

            $this->line("   🐾 [{$tenant?->name}] {$pet?->name} ({$customer?->name}) - Vence en {$daysLeft} día(s)");

            Log::info("⏰ [SCHEDULE] Alerta de Renovación Próxima:", [
                'tenant' => $tenant?->name,
                'subscription_id' => $sub->id,
                'contract_id' => $sub->gateway_subscription_id,
                'pet' => $pet?->name,
                'tutor' => $customer?->name,
                'phone' => $customer?->phone,
                'days_left' => $daysLeft,
                'expires_at' => $sub->current_period_end?->toDateString(),
            ]);
        }

        // 2. Marcar suscripciones vencidas que no hayan sido renovadas
        $overdueSubscriptions = Subscription::query()
            ->where('status', 'active')
            ->where('current_period_end', '<', Carbon::today())
            ->get();

        if ($overdueSubscriptions->isNotEmpty()) {
            $this->warn("⚠️  Marcando {$overdueSubscriptions->count()} suscripción(es) expiradas a estado 'overdue'...");
            foreach ($overdueSubscriptions as $overdueSub) {
                $overdueSub->update(['status' => 'overdue']);
                Log::notice("⚠️ [SCHEDULE] Suscripción vencida marcada como 'overdue':", [
                    'id' => $overdueSub->id,
                    'contract_id' => $overdueSub->gateway_subscription_id,
                    'tenant_id' => $overdueSub->tenant_id,
                ]);
            }
        }

        $this->info("✅ Auditoría de suscripciones completada con éxito.");
        return Command::SUCCESS;
    }
}
