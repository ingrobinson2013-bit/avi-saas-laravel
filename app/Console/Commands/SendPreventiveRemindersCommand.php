<?php

namespace App\Console\Commands;

use App\Mail\TutorPreventiveReminderMail;
use App\Models\SubscriptionBenefitBalance;
use App\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPreventiveRemindersCommand extends Command
{
    protected $signature = 'avi:send-preventive-reminders
                            {--tenant= : Slug opcional de una clínica específica}
                            {--limit=25 : Máximo de pacientes a notificar por corrida}';

    protected $aliases = ['subscriptions:send-preventive-reminders'];

    protected $description = 'Identifica pacientes activos con vacunas, desparasitaciones o controles disponibles (con carencia liberada) y envía invitación preventiva por correo';

    public function handle(): int
    {
        $tenantSlug = $this->option('tenant');
        $limit = (int) $this->option('limit');
        $tenantFilter = !empty($tenantSlug) ? Tenant::where('slug', $tenantSlug)->first() : null;

        $this->info("🩺 Escaneando pacientes con beneficios preventivos disponibles y carencia liberada...");

        $pendingBalances = SubscriptionBenefitBalance::query()
            ->with(['subscription.pet.customer', 'subscription.tenant', 'subscription.plan', 'benefitDefinition'])
            ->whereHas('subscription', function ($q) use ($tenantFilter) {
                $q->where('status', 'active')
                  ->when($tenantFilter, fn ($sq) => $sq->where('tenant_id', $tenantFilter->id));
            })
            ->where('remaining_count', '>', 0)
            ->whereHas('benefitDefinition', function ($b) {
                $b->whereIn('category', ['vacunacion', 'prevencion', 'vacuna', 'desparasitacion', 'consultas'])
                  ->orWhere('name', 'ilike', '%vacuna%')
                  ->orWhere('name', 'ilike', '%desparasita%')
                  ->orWhere('name', 'ilike', '%control%');
            })
            ->get();

        $groupedBySubscription = $pendingBalances->groupBy('subscription_id');
        $this->info("📋 Pacientes con cupos preventivos activos encontrados: {$groupedBySubscription->count()}");

        $emailsSent = 0;

        foreach ($groupedBySubscription->take($limit) as $subId => $balances) {
            $firstBalance = $balances->first();
            $sub = $firstBalance?->subscription;
            $pet = $sub?->pet;
            $customer = $pet?->customer;
            $tenant = $sub?->tenant;

            if (!$sub || !$pet || !$customer || !$tenant) {
                continue;
            }

            $startDate = $sub->current_period_start ?? $sub->created_at ?? now();
            $daysActive = (int) max(0, $startDate->diffInDays(now(), false));

            $unlockedBenefits = [];
            foreach ($balances as $b) {
                $waitingDays = (int) ($b->benefitDefinition?->waiting_period_days ?? 0);
                if ($daysActive >= $waitingDays && $b->remaining_count > 0) {
                    $unlockedBenefits[] = [
                        'name' => $b->benefitDefinition?->name ?? 'Control Preventivo',
                        'remaining' => (int) $b->remaining_count,
                        'granted' => (int) $b->total_granted,
                        'category' => $b->benefitDefinition?->category ?? 'prevencion',
                    ];
                }
            }

            if (empty($unlockedBenefits)) {
                continue;
            }

            $benefitNamesList = collect($unlockedBenefits)->pluck('name')->implode(', ');
            $this->line("   💉 [{$tenant->name}] {$pet->name} ({$customer->name}): {$benefitNamesList}");

            $tutorEmail = trim($customer->email ?? '');
            if (!empty($tutorEmail) && filter_var($tutorEmail, FILTER_VALIDATE_EMAIL)) {
                try {
                    $contractRef = $sub->gateway_subscription_id ?? $sub->id;
                    $carnetUrl = $tenant->getCarnetUrl($contractRef);
                    $clinicPhone = preg_replace('/[^0-9]/', '', $tenant->branding['phone'] ?? '3235813942');
                    if (strlen($clinicPhone) === 10) {
                        $clinicPhone = '57' . $clinicPhone;
                    }

                    $waScheduleMsg = "¡Hola {$tenant->name}! 👋 Quiero agendar una cita preventiva para mi mascota *{$pet->name}* (Contrato *{$contractRef}*) para aplicar su beneficio incluido: *{$unlockedBenefits[0]['name']}*.";
                    $scheduleWhatsappUrl = "https://wa.me/{$clinicPhone}?text=" . urlencode($waScheduleMsg);

                    $mailPending = Mail::to($tutorEmail);
                    $clinicEmail = trim($tenant->branding['email'] ?? '');
                    if (!empty($clinicEmail) && filter_var($clinicEmail, FILTER_VALIDATE_EMAIL) && strtolower($clinicEmail) !== strtolower($tutorEmail)) {
                        $mailPending->bcc($clinicEmail);
                    }

                    $mailPending->send(new TutorPreventiveReminderMail(
                        $tenant,
                        $sub,
                        $customer,
                        $pet,
                        $sub->plan,
                        $unlockedBenefits,
                        $carnetUrl,
                        $scheduleWhatsappUrl
                    ));

                    $emailsSent++;
                    $this->info("      ✉️ Invitación preventiva enviada a {$tutorEmail}");
                } catch (\Throwable $e) {
                    Log::warning("Error enviando TutorPreventiveReminderMail a {$tutorEmail}: " . $e->getMessage());
                }
            }

            Log::info("🐾 [PREVENTIVE HEALTH] Recordatorio preventivo procesado:", [
                'tenant' => $tenant->name,
                'pet' => $pet->name,
                'customer' => $customer->name,
                'email' => $tutorEmail,
                'benefits' => $unlockedBenefits,
            ]);
        }

        $this->info("✅ Proceso finalizado. Invitaciones preventivas enviadas por correo: {$emailsSent}.");
        return Command::SUCCESS;
    }
}
