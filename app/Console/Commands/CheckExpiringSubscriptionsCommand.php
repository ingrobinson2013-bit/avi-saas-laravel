<?php

namespace App\Console\Commands;

use App\Mail\TutorRenewalReminderMail;
use App\Models\Subscription;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckExpiringSubscriptionsCommand extends Command
{
    protected $signature = 'avi:check-expiring-subscriptions
                            {--days=7 : Días de anticipación para la alerta}
                            {--tenant= : Slug opcional de una clínica específica}
                            {--force : Enviar correo a todas las suscripciones dentro del rango sin filtrar día exacto}';

    protected $aliases = ['subscriptions:notify-expiring'];

    protected $description = 'Audita suscripciones próximas a vencer (7, 5, 3, 1 y 0 días), envía recordatorios de renovación con link de pago en 1 clic y actualiza estados de mora';

    public function handle(): int
    {
        $days = (int) $this->option('days');
        $tenantSlug = $this->option('tenant');
        $force = (bool) $this->option('force');
        $targetDate = Carbon::today()->addDays($days);

        $tenantFilter = null;
        if (!empty($tenantSlug)) {
            $tenantFilter = Tenant::where('slug', $tenantSlug)->first();
        }

        $this->info("🔍 Escaneando suscripciones con vencimiento dentro de {$days} días...");

        // 1. Suscripciones próximas a vencer
        $expiringSubscriptions = Subscription::query()
            ->with(['pet.customer', 'plan', 'tenant', 'wallet'])
            ->whereIn('status', ['active', 'overdue', 'pending_payment'])
            ->when($tenantFilter, fn ($q) => $q->where('tenant_id', $tenantFilter->id))
            ->whereDate('current_period_end', '<=', $targetDate)
            ->whereDate('current_period_end', '>=', Carbon::today())
            ->get();

        $this->info("📋 Suscripciones próximas a vencer encontradas: {$expiringSubscriptions->count()}");

        $emailsSent = 0;

        foreach ($expiringSubscriptions as $sub) {
            $daysLeft = (int) Carbon::today()->diffInDays(Carbon::parse($sub->current_period_end)->startOfDay(), false);
            $pet = $sub->pet;
            $customer = $pet?->customer;
            $tenant = $sub->tenant;

            $this->line("   🐾 [{$tenant?->name}] {$pet?->name} ({$customer?->name}) - Vence en {$daysLeft} día(s)");

            // Enviar correo en los hitos clave (7, 5, 3, 1, 0 días) o si se ejecuta con --force
            $shouldSendEmail = $force || in_array($daysLeft, [7, 5, 3, 1, 0], true);

            if ($shouldSendEmail && $tenant && $pet && $customer) {
                $tutorEmail = trim($customer->email ?? '');
                if (!empty($tutorEmail) && filter_var($tutorEmail, FILTER_VALIDATE_EMAIL)) {
                    try {
                        $contractRef = $sub->gateway_subscription_id ?? $sub->id;
                        $paymentUrl = url("/v/{$tenant->slug}/pagar/{$contractRef}");
                        $carnetUrl = $tenant->getCarnetUrl($contractRef);
                        $walletBalance = (float) ($sub->wallet?->balance_cop ?? 0);

                        $mailPending = Mail::to($tutorEmail);
                        $clinicEmail = trim($tenant->branding['email'] ?? '');
                        if (!empty($clinicEmail) && filter_var($clinicEmail, FILTER_VALIDATE_EMAIL) && strtolower($clinicEmail) !== strtolower($tutorEmail)) {
                            $mailPending->bcc($clinicEmail);
                        }

                        $mailPending->send(new TutorRenewalReminderMail(
                            $tenant,
                            $sub,
                            $customer,
                            $pet,
                            $sub->plan,
                            $paymentUrl,
                            $carnetUrl,
                            $daysLeft,
                            $walletBalance
                        ));

                        $emailsSent++;
                        $this->info("      ✉️ Recordatorio enviado a {$tutorEmail}");
                    } catch (\Throwable $e) {
                        Log::warning("No se pudo enviar TutorRenewalReminderMail a {$tutorEmail}: " . $e->getMessage());
                    }
                }
            }

            Log::info("⏰ [SCHEDULE] Alerta de Renovación Próxima:", [
                'tenant' => $tenant?->name,
                'subscription_id' => $sub->id,
                'contract_id' => $sub->gateway_subscription_id,
                'pet' => $pet?->name,
                'tutor' => $customer?->name,
                'phone' => $customer?->phone,
                'days_left' => $daysLeft,
                'email_sent' => $shouldSendEmail,
                'expires_at' => $sub->current_period_end?->toDateString(),
            ]);
        }

        // 2. Marcar suscripciones vencidas que no hayan sido renovadas
        $overdueSubscriptions = Subscription::query()
            ->with(['pet.customer', 'plan', 'tenant', 'wallet'])
            ->where('status', 'active')
            ->when($tenantFilter, fn ($q) => $q->where('tenant_id', $tenantFilter->id))
            ->whereDate('current_period_end', '<', Carbon::today())
            ->get();

        if ($overdueSubscriptions->isNotEmpty()) {
            $this->warn("⚠️  Marcando {$overdueSubscriptions->count()} suscripción(es) expiradas a estado 'overdue'...");
            foreach ($overdueSubscriptions as $overdueSub) {
                $overdueSub->update(['status' => 'overdue']);

                $pet = $overdueSub->pet;
                $customer = $pet?->customer;
                $tenant = $overdueSub->tenant;
                $tutorEmail = trim($customer?->email ?? '');

                if ($tenant && $pet && $customer && !empty($tutorEmail) && filter_var($tutorEmail, FILTER_VALIDATE_EMAIL)) {
                    try {
                        $contractRef = $overdueSub->gateway_subscription_id ?? $overdueSub->id;
                        $paymentUrl = url("/v/{$tenant->slug}/pagar/{$contractRef}");
                        $carnetUrl = $tenant->getCarnetUrl($contractRef);
                        $walletBalance = (float) ($overdueSub->wallet?->balance_cop ?? 0);

                        Mail::to($tutorEmail)->send(new TutorRenewalReminderMail(
                            $tenant,
                            $overdueSub,
                            $customer,
                            $pet,
                            $overdueSub->plan,
                            $paymentUrl,
                            $carnetUrl,
                            -1,
                            $walletBalance
                        ));
                        $emailsSent++;
                    } catch (\Throwable $e) {
                        Log::warning("Error enviando aviso de mora a {$tutorEmail}: " . $e->getMessage());
                    }
                }

                Log::notice("⚠️ [SCHEDULE] Suscripción vencida marcada como 'overdue':", [
                    'id' => $overdueSub->id,
                    'contract_id' => $overdueSub->gateway_subscription_id,
                    'tenant_id' => $overdueSub->tenant_id,
                ]);
            }
        }

        $this->info("✅ Auditoría completada. Correos de recordatorio enviados: {$emailsSent}.");
        return Command::SUCCESS;
    }
}
