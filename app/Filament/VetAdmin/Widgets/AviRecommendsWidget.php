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
        $expiring7Days = Subscription::query()
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where('status', 'active')
            ->whereBetween('current_period_end', [now(), now()->addDays(7)])
            ->count();

        // 2. Clientes con beneficios sin usar en los últimos 60 días
        $unusedBenefitsCount = Subscription::query()
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where('status', 'active')
            ->whereDoesntHave('redemptions', fn ($q) => $q->where('redeemed_at', '>=', now()->subDays(60)))
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

        // Generar recomendación inteligente según estado real
        if ($expiring7Days > 0) {
            $this->recommendation = [
                'type' => 'renewals',
                'badge' => 'Campaña de Retención',
                'badge_color' => 'amber',
                'title' => "Tienes {$expiring7Days} " . ($expiring7Days === 1 ? 'plan que vence' : 'planes que vencen') . " en los próximos 7 días.",
                'description' => "Los tutores son 4 veces más propensos a renovar si reciben un recordatorio amigable antes de que expire la cobertura de su mascota.",
                'action_label' => 'Gestionar Renovaciones',
                'action_url' => "/admin/{$this->slug}/subscriptions",
                'action_icon' => 'heroicon-m-arrow-path',
            ];
        } elseif ($unusedBenefitsCount > 0) {
            $this->recommendation = [
                'type' => 'activation',
                'badge' => 'Oportunidad de Fidelización',
                'badge_color' => 'blue',
                'title' => "Tienes {$unusedBenefitsCount} " . ($unusedBenefitsCount === 1 ? 'paciente' : 'pacientes') . " con beneficios disponibles sin redimir en los últimos 60 días.",
                'description' => "Invita a los tutores a agendar su chequeo preventivo o baño de cortesía. El uso continuo de beneficios reduce el abandono de membresías en un 68%.",
                'action_label' => 'Ver Pacientes para Invitar',
                'action_url' => "/admin/{$this->slug}/subscriptions",
                'action_icon' => 'heroicon-m-user-group',
            ];
        } elseif ($topPlan && $topPlan->subscriptions_count > 0 && $activeSubsCount > 0) {
            $percentage = round(($topPlan->subscriptions_count / $activeSubsCount) * 100);
            $this->recommendation = [
                'type' => 'growth',
                'badge' => 'Inteligencia de Producto',
                'badge_color' => 'emerald',
                'title' => "El plan '{$topPlan->name}' representa el {$percentage}% de tus suscripciones activas.",
                'description' => "Es tu producto estrella. Considera destacarlo en tu afiche de mostrador y compartir el enlace directo con tutores nuevos.",
                'action_label' => 'Ver Detalle del Plan',
                'action_url' => "/admin/{$this->slug}/plans/{$topPlan->id}/edit",
                'action_icon' => 'heroicon-m-sparkles',
            ];
        } else {
            $this->recommendation = [
                'type' => 'starter',
                'badge' => 'Primer Impulso',
                'badge_color' => 'indigo',
                'title' => "Tu programa de bienestar está listo para despegar.",
                'description' => "Coloca tu afiche con código QR en la mesa de recepción. Cada tutor que afilies genera ingresos recurrentes predecibles mes a mes.",
                'action_label' => 'Descargar Afiche QR',
                'action_url' => "/v/{$this->slug}/afiche",
                'action_icon' => 'heroicon-m-printer',
            ];
        }
    }
}
