<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Models\SubscriptionBenefitBalance;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendPreventiveRemindersCommand extends Command
{
    protected $signature = 'avi:send-preventive-reminders';

    protected $description = 'Identifica pacientes con vacunas o desparasitaciones pendientes y genera recordatorios preventivos';

    public function handle(): int
    {
        $this->info("🩺 Escaneando pacientes con beneficios preventivos pendientes de aplicar...");

        // Buscar balances con cupos disponibles de vacunas o desparasitación en planes activos
        $pendingBalances = SubscriptionBenefitBalance::query()
            ->with(['subscription.pet.customer', 'subscription.tenant', 'benefitDefinition'])
            ->whereHas('subscription', fn ($q) => $q->where('status', 'active'))
            ->where('remaining_count', '>', 0)
            ->whereHas('benefitDefinition', function ($b) {
                $b->where('category', 'in', ['vacunacion', 'prevencion'])
                  ->orWhere('name', 'ilike', '%vacuna%')
                  ->orWhere('name', 'ilike', '%desparasita%');
            })
            ->get();

        $this->info("📋 Total de beneficios preventivos disponibles en pacientes activos: {$pendingBalances->count()}");

        $remindersCount = 0;
        foreach ($pendingBalances->take(20) as $balance) {
            $sub = $balance->subscription;
            $pet = $sub?->pet;
            $customer = $pet?->customer;
            $tenant = $sub?->tenant;
            $benefit = $balance->benefitDefinition;

            if ($pet && $customer && $tenant) {
                $remindersCount++;
                $this->line("   💉 [{$tenant->name}] {$pet->name}: {$benefit->name} (Restantes: {$balance->remaining_count})");

                Log::info("🐾 [PREVENTIVE HEALTH] Recordatorio preventivo listo para envío:", [
                    'tenant' => $tenant->name,
                    'pet' => $pet->name,
                    'customer' => $customer->name,
                    'phone' => $customer->phone,
                    'benefit' => $benefit->name,
                    'remaining' => $balance->remaining_count,
                ]);
            }
        }

        $this->info("✅ Generados {$remindersCount} recordatorios preventivos con éxito.");
        return Command::SUCCESS;
    }
}
