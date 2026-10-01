<?php

namespace App\Filament\VetAdmin\Widgets;

use App\Models\Plan;
use App\Models\Subscription;
use Filament\Facades\Filament;
use Filament\Widgets\Widget;

class AviRecommendsWidget extends Widget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';
    protected static string $view = 'filament.vet-admin.widgets.avi-recommends';

    public string $slug = 'vet-pet-patitas';
    public array $recommendation = [];

    public function mount(): void
    {
        $tenant = Filament::getTenant();
        $this->slug = $tenant?->slug ?? session('current_tenant_slug') ?? 'vet-pet-patitas';
        $tenantId = $tenant?->id ?? session('current_tenant_id') ?? auth()->user()?->tenant_id;

        // 1. Detección de Vencimientos Inminentes (< 7 días)
        $expiringSub = Subscription::query()
            ->with(['pet.customer', 'plan'])
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where('status', 'active')
            ->whereBetween('current_period_end', [now(), now()->addDays(7)])
            ->orderBy('current_period_end', 'asc')
            ->first();

        // 2. Paciente con beneficios sin utilizar en los últimos 60 días
        $inactiveSub = Subscription::query()
            ->with(['pet.customer', 'benefitBalances.benefitDefinition', 'plan'])
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where('status', 'active')
            ->whereDoesntHave('benefitBalances.redemptions', fn ($q) => $q->where('redeemed_at', '>=', now()->subDays(60)))
            ->first();

        $inactiveCount = Subscription::query()
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where('status', 'active')
            ->whereDoesntHave('benefitBalances.redemptions', fn ($q) => $q->where('redeemed_at', '>=', now()->subDays(60)))
            ->count();

        // 3. Plan más popular
        $topPlan = Plan::query()
            ->when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))
            ->withCount(['subscriptions' => fn ($q) => $q->where('status', 'active')])
            ->orderBy('subscriptions_count', 'desc')
            ->first();

        $activeSubsCount = Subscription::query()
            ->when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))
            ->where('status', 'active')
            ->count();

        // GENERAR RECOMENDACIÓN HIPERPERSONALIZADA Y ACCIONABLE
        if ($inactiveSub) {
            $customerName = $inactiveSub->pet?->customer?->name ?? 'el tutor';
            $firstName = explode(' ', trim($customerName))[0];
            $petName = $inactiveSub->pet?->name ?? 'su mascota';
            $phone = preg_replace('/[^0-9]/', '', $inactiveSub->pet?->customer?->phone ?? '');
            
            $balances = $inactiveSub->benefitBalances;
            $availCount = (int) $balances->sum(fn ($b) => $b->remaining_count ?? ($b->total_granted - $b->used_count));
            $exampleBenefit = $balances->first(fn ($b) => ($b->remaining_count ?? ($b->total_granted - $b->used_count)) > 0)?->benefitDefinition?->name ?? 'chequeo preventivo';

            $waMsg = "🐾 Hola {$firstName}, te saludamos de la clínica veterinaria. Queríamos recordarte que {$petName} tiene {$availCount} beneficios disponibles en su plan de salud (incluyendo {$exampleBenefit}) y hace más de 60 días no nos visita. ¿Te gustaría agendar su cita esta semana para consentirlo?";
            $waUrl = !empty($phone) ? "https://wa.me/{$phone}?text=" . urlencode($waMsg) : "https://wa.me/?text=" . urlencode($waMsg);

            $this->recommendation = [
                'type' => 'activation',
                'badge' => 'Oportunidad de Fidelización',
                'badge_color' => 'blue',
                'impact_text' => $inactiveCount . ' ' . ($inactiveCount === 1 ? 'oportunidad detectada' : 'oportunidades detectadas'),
                'title' => "Te recomiendo contactar a {$firstName} porque {$petName} tiene {$availCount} " . ($availCount === 1 ? 'beneficio disponible' : 'beneficios disponibles') . " (como {$exampleBenefit}) y no ha realizado una visita en los últimos 60 días.",
                'whatsapp_url' => $waUrl,
                'pet_url' => "/admin/{$this->slug}/pets/{$inactiveSub->pet_id}/edit",
                'action_label' => 'Enviar WhatsApp',
                'pet_label' => 'Ver Paciente',
            ];
        } elseif ($expiringSub) {
            $customerName = $expiringSub->pet?->customer?->name ?? 'el tutor';
            $firstName = explode(' ', trim($customerName))[0];
            $petName = $expiringSub->pet?->name ?? 'su mascota';
            $planName = $expiringSub->plan?->name ?? 'Plan de Bienestar';
            $days = (int) max(1, round(now()->diffInDays($expiringSub->current_period_end, false)));
            $phone = preg_replace('/[^0-9]/', '', $expiringSub->pet?->customer?->phone ?? '');

            $waMsg = "🐾 Hola {$firstName}, te saludamos de la clínica veterinaria. El plan de bienestar {$planName} de {$petName} finaliza su ciclo en {$days} días. ¿Deseas renovar su plan para que siga protegido?";

            $this->recommendation = [
                'type' => 'renewals',
                'badge' => 'Campaña de Retención',
                'badge_color' => 'amber',
                'impact_text' => '1 renovación crítica',
                'title' => "Te recomiendo contactar a {$firstName} porque el plan de {$petName} finaliza su ciclo en {$days} días.",
                'whatsapp_url' => !empty($phone) ? "https://wa.me/{$phone}?text=" . urlencode($waMsg) : null,
                'pet_url' => "/admin/{$this->slug}/subscriptions/{$expiringSub->id}/edit",
                'action_label' => 'Enviar WhatsApp',
                'pet_label' => 'Ver Membresía',
            ];
        } elseif ($topPlan && $topPlan->subscriptions_count > 0 && $activeSubsCount > 0) {
            $percentage = round(($topPlan->subscriptions_count / $activeSubsCount) * 100);
            $this->recommendation = [
                'type' => 'growth',
                'badge' => 'Inteligencia de Producto',
                'badge_color' => 'emerald',
                'impact_text' => 'Producto Estrella',
                'title' => "El plan '{$topPlan->name}' representa el {$percentage}% de tus afiliaciones activas. Te recomiendo compartir su enlace directo en tus estados de WhatsApp.",
                'whatsapp_url' => null,
                'pet_url' => "/v/{$this->slug}",
                'action_label' => 'Ver Portal B2C',
                'pet_label' => 'Editar Plan',
            ];
        } else {
            $this->recommendation = [
                'type' => 'starter',
                'badge' => 'Impulso Inicial',
                'badge_color' => 'indigo',
                'impact_text' => 'Activación',
                'title' => "Tu programa de membresías está activo. Te recomiendo colocar el afiche QR en la mesa de recepción para que cada tutor que entre se afilie en 1 minuto.",
                'whatsapp_url' => null,
                'pet_url' => "/v/{$this->slug}/afiche",
                'action_label' => 'Imprimir Afiche QR',
                'pet_label' => 'Ver Planes',
            ];
        }
    }
}
