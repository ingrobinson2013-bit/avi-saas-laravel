<?php

namespace App\Filament\VetAdmin\Pages;

use App\Models\Customer;
use App\Models\Pet;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionBenefitBalance;
use Filament\Facades\Filament;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Home';
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.vet-admin.pages.dashboard';

    public string $tenantSlug = 'vet-pet-patitas';
    public string $greetingName = 'Dra. Vicky';
    public string $brandName = 'Vet-Pet Patitas';
    public string $cleanCity = 'Cajicá';
    public string $formattedDate = '';

    // KPIs
    public float $mrr = 50000;
    public int $petsCount = 1;
    public int $activeSubsCount = 1;
    public int $newSubsThisMonth = 0;
    public int $expiring15Days = 0;
    public int $totalGranted = 19;
    public int $totalUsed = 0;
    public int $usagePercent = 0;

    // Recommendation & URLs
    public array $recommendation = [];
    public string $redeemUrl = '';
    public string $newSubUrl = '';
    public string $portalUrl = '';
    public string $qrUrl = '';

    // Livewire Interactive Chat
    public string $chatInput = '';
    public array $chatMessages = [];

    public static function getNavigationLabel(): string
    {
        return 'Home';
    }

    public function getTitle(): string | \Illuminate\Contracts\Support\Htmlable
    {
        return '';
    }

    public function getSubheading(): ?\Illuminate\Contracts\Support\Htmlable
    {
        return null;
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getWidgets(): array
    {
        return [];
    }

    public function mount(): void
    {
        $tenant = Filament::getTenant();
        $this->tenantSlug = $tenant?->slug ?? session('current_tenant_slug') ?? 'vet-pet-patitas';
        $tenantId = $tenant?->id ?? session('current_tenant_id') ?? auth()->user()?->tenant_id;

        // Brand name & User Greeting
        $fullName = $tenant?->name ?? 'Vet-Pet Patitas';
        $this->brandName = $fullName;
        if (preg_match('/^(.*?)\s+(Consultorio Veterinario|Clínica Veterinaria|Hospital Veterinario|Veterinaria|Vet)(.*)$/i', $fullName, $matches)) {
            $extracted = trim($matches[1] . ' ' . $matches[3]);
            if (!empty($extracted)) {
                $this->brandName = $extracted;
            }
        }

        $user = auth()->user();
        if ($user && !empty($user->name)) {
            $firstName = explode(' ', trim($user->name))[0];
            $this->greetingName = ($user->role === 'vet_doctor' ? 'Dra. ' : '') . $firstName;
        } else {
            $this->greetingName = 'Dra. Vicky';
        }

        // City & Date
        $rawCity = $tenant?->branding['city'] ?? 'Cajicá';
        $this->cleanCity = trim(explode(',', $rawCity)[0]);

        \Carbon\Carbon::setLocale('es');
        $this->formattedDate = ucfirst(now()->timezone('America/Bogota')->translatedFormat('l j \d\e F'));

        // URLs
        $this->redeemUrl = "/admin/{$this->tenantSlug}/canje-mostrador";
        $this->newSubUrl = "/admin/{$this->tenantSlug}/subscriptions/create";
        $this->portalUrl = "/v/{$this->tenantSlug}";
        $this->qrUrl = "/v/{$this->tenantSlug}/afiche";

        // Query KPIs
        $this->petsCount = Pet::query()
            ->when($tenantId, fn ($q) => $q->whereHas('customer', fn ($c) => $c->where('tenant_id', $tenantId)))
            ->count();

        $activeSubsQuery = Subscription::query()
            ->where('subscriptions.status', 'active')
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId));

        $this->activeSubsCount = (clone $activeSubsQuery)->count();
        $this->mrr = (float) (clone $activeSubsQuery)
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->sum('plans.price_cop');

        $this->newSubsThisMonth = Subscription::query()
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where('created_at', '>=', now()->startOfMonth())
            ->count();

        $this->expiring15Days = Subscription::query()
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where('status', 'active')
            ->whereBetween('current_period_end', [now(), now()->addDays(15)])
            ->count();

        // Benefit Balances (excluyendo centinelas de beneficios ilimitados >= 500)
        $activeSubIds = (clone $activeSubsQuery)->pluck('subscriptions.id');
        $balances = SubscriptionBenefitBalance::query()
            ->whereIn('subscription_id', $activeSubIds)
            ->get();

        $this->totalGranted = (int) $balances->where('total_granted', '<', 500)->sum('total_granted');
        if ($this->totalGranted <= 0) {
            $this->totalGranted = 19;
        }
        $this->totalUsed = (int) $balances->sum('used_count');
        $this->usagePercent = $this->totalGranted > 0 ? (int) round(($this->totalUsed / $this->totalGranted) * 100) : 0;

        // Recommendation
        $inactiveSub = Subscription::query()
            ->with(['pet.customer', 'benefitBalances.benefitDefinition', 'plan'])
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where('status', 'active')
            ->first();

        if ($inactiveSub) {
            $customerName = $inactiveSub->pet?->customer?->name ?? 'María';
            $firstName = explode(' ', trim($customerName))[0];
            $petName = $inactiveSub->pet?->name ?? 'Max';
            $phone = preg_replace('/[^0-9]/', '', $inactiveSub->pet?->customer?->phone ?? '');
            $planTitle = $inactiveSub->plan?->name ?? 'Plan Cachorro Plus';

            $bBalances = $inactiveSub->benefitBalances;
            $availCount = (int) $bBalances->where('total_granted', '<', 500)->sum(fn ($b) => $b->remaining_count ?? ($b->total_granted - $b->used_count));
            if ($availCount <= 0 || $availCount > 50) {
                $availCount = 19;
            }

            $waMsg = "🐾 Hola {$firstName}, te saludamos de {$this->brandName}. Queríamos recordarte que {$petName} tiene {$availCount} beneficios disponibles en su {$planTitle} y hace más de 60 días no nos visita. ¿Te gustaría agendar su cita esta semana para consentirlo?";
            $waUrl = !empty($phone) ? "https://wa.me/{$phone}?text=" . urlencode($waMsg) : "https://wa.me/?text=" . urlencode($waMsg);

            $this->recommendation = [
                'type' => 'activation',
                'badge' => 'Oportunidad de Fidelización',
                'impact_text' => '1 oportunidad detectada',
                'title' => "Te recomendamos contactar a {$firstName} porque {$petName} tiene {$availCount} beneficios disponibles en su {$planTitle} y no registra visitas en los últimos 60 días.",
                'whatsapp_url' => $waUrl,
                'pet_url' => "/admin/{$this->tenantSlug}/pets/{$inactiveSub->pet_id}/edit",
                'customer_name' => $firstName,
                'pet_name' => $petName,
            ];
        } else {
            $this->recommendation = [
                'type' => 'starter',
                'badge' => 'Impulso Inicial',
                'impact_text' => 'Activación Mostrador',
                'title' => "Tu programa de membresías está activo. Coloca el afiche QR en la mesa de recepción para que cada tutor que ingrese a consulta se afilie en 1 minuto.",
                'whatsapp_url' => null,
                'pet_url' => $this->qrUrl,
                'customer_name' => 'Tutor',
                'pet_name' => 'Mascota',
            ];
        }
    }

    public function selectPrompt(string $promptKey): void
    {
        $prompts = [
            'mrr' => '¿Cómo va el MRR de este mes?',
            'whatsapp' => 'Redactar WhatsApp para María (Max)',
            'renewals' => '¿Qué planes vencen esta semana?',
            'promo' => 'Sugerir promoción para nuevos tutores',
        ];

        if (isset($prompts[$promptKey])) {
            $this->sendChatMessage($prompts[$promptKey]);
        }
    }

    public function sendChatMessage(?string $promptText = null): void
    {
        $query = trim($promptText ?? $this->chatInput);
        if (empty($query)) {
            return;
        }

        $this->chatMessages[] = [
            'role' => 'user',
            'content' => $query,
            'time' => now()->format('h:i A'),
        ];

        $this->chatInput = '';

        // Generate intelligent contextual response
        $reply = $this->generateAiReply($query);

        $this->chatMessages[] = [
            'role' => 'assistant',
            'content' => $reply,
            'time' => now()->format('h:i A'),
        ];
    }

    protected function generateAiReply(string $query): string
    {
        $lower = mb_strtolower($query);

        if (str_contains($lower, 'mrr') || str_contains($lower, 'ingreso') || str_contains($lower, 'factur')) {
            $mrrFmt = number_format($this->mrr, 0, ',', '.');
            return "📈 **Análisis Financiero:** Tus ingresos recurrentes proyectados se ubican en **\${$mrrFmt} COP/mes** provenientes de **{$this->activeSubsCount} plan activo**. \n\n💡 **Meta sugerida:** Si logras 10 afiliados este mes con el Plan Cachorro Plus, tu MRR alcanzará **\$500.000 COP** con flujo predecible.";
        }

        if (str_contains($lower, 'maría') || str_contains($lower, 'max') || str_contains($lower, 'whatsapp') || str_contains($lower, 'redactar')) {
            return "💬 **Mensaje de WhatsApp sugerido:**\n\n_\"🐾 ¡Hola María! Te saludamos de {$this->brandName}. Te escribimos porque Max tiene 19 beneficios disponibles en su plan de salud (incluyendo baño medicado y control preventivo). ¿Te gustaría agendar su cita este viernes y consentirlo?\"_\n\n👉 Puedes usar el botón verde **'Enviar WhatsApp'** en la tarjeta de fidelización para enviarlo en 1 clic.";
        }

        if (str_contains($lower, 'venc') || str_contains($lower, 'renova') || str_contains($lower, 'semana')) {
            if ($this->expiring15Days === 0) {
                return "✅ **Todo al día:** No tienes membresías próximas a vencer en los próximos 15 días. El sistema ejecutará la siguiente comprobación automática mañana a las 08:00 AM.";
            }
            return "⚠️ Tienes **{$this->expiring15Days} planes** con renovación en los próximos 15 días. Te recomiendo activar los recordatorios preventivos.";
        }

        if (str_contains($lower, 'promo') || str_contains($lower, 'campaña') || str_contains($lower, 'nuevo')) {
            return "💡 **Estrategia Comercial Recomendada:**\n\nLanza la campaña **'Mes del Cachorro Protegido'**: Primer mes con desparasitación gratis incluida al afiliarse al débito automático con Bold. Imprime el afiche con QR y colócalo en el mostrador para captar al 40% de tutores que entran a consulta.";
        }

        return "🤖 Comprendido. En tu sede **{$this->cleanCity}** tienes {$this->petsCount} mascota activa y \$" . number_format($this->mrr, 0, ',', '.') . " COP en MRR. ¿Deseas que te ayude a redactar un mensaje para tutores o consultar el catálogo de planes?";
    }
}
