<?php

namespace App\Filament\VetAdmin\Pages;

use App\Models\BenefitDefinition;
use App\Models\BenefitRedemption;
use App\Models\Customer;
use App\Models\Pet;
use App\Models\Subscription;
use App\Models\SubscriptionBenefitBalance;
use App\Services\BenefitLedgerService;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Collection;

class CounterRedeem extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-qr-code';
    protected static ?string $navigationLabel = 'Canje en Recepción';
    protected static ?int $navigationSort = 2;
    protected static ?string $title = 'Terminal de Canje & Validación de Saldos';
    protected static ?string $slug = 'counter-redeem';
    protected static string $view = 'filament.vet-admin.pages.counter-redeem';

    public string $searchQuery = '';
    public ?string $selectedSubscriptionId = null;
    public string $selectedCategory = 'all';

    // Modal de Canje Interactivo
    public bool $showRedeemModal = false;
    public ?string $activeBalanceId = null;
    public ?string $activeBenefitName = null;
    public ?string $activeBenefitCategory = null;
    public int $activeAvailableCount = 0;
    public int $activeTotalGranted = 0;
    public int $redeemQuantity = 1;
    public ?string $redeemNotes = null;

    public function mount(): void
    {
        if (request()->has('sub')) {
            $this->selectedSubscriptionId = request()->get('sub');
        } else {
            // Auto-seleccionar primer paciente para experiencia táctil inmediata
            $first = $this->search()->first();
            if ($first) {
                $this->selectedSubscriptionId = $first->id;
            }
        }
    }

    public function search(): Collection
    {
        $tenant = \Filament\Facades\Filament::getTenant() ?? auth()->user()?->tenant ?? \App\Models\Tenant::first();
        $tenantId = $tenant?->id;

        $query = trim($this->searchQuery);

        $builder = Subscription::with(['pet.customer', 'plan', 'benefitBalances.benefitDefinition'])
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->whereIn('subscriptions.status', ['active', 'past_due', 'paused', 'expired']);

        if (strlen($query) >= 2) {
            $builder->where(function ($mainQuery) use ($query) {
                $mainQuery->whereHas('pet.customer', function ($q) use ($query) {
                    $q->where('identification', 'ilike', "%{$query}%")
                      ->orWhere('phone', 'ilike', "%{$query}%")
                      ->orWhere('name', 'ilike', "%{$query}%");
                })
                ->orWhereHas('pet', function ($q) use ($query) {
                    $q->where('name', 'ilike', "%{$query}%")
                      ->orWhere('breed', 'ilike', "%{$query}%");
                })
                ->orWhere('subscriptions.gateway_subscription_id', 'ilike', "%{$query}%");
            });
        }

        return $builder
            ->orderByRaw("CASE WHEN subscriptions.status = 'active' THEN 0 ELSE 1 END")
            ->latest('subscriptions.created_at')
            ->limit(10)
            ->get();
    }

    public function selectSubscription(string $id): void
    {
        $this->selectedSubscriptionId = $id;
        $this->selectedCategory = 'all';
        $this->closeRedeemModal();
    }

    public function filterCategory(string $category): void
    {
        $this->selectedCategory = $category;
    }

    public function openRedeemModal(string $balanceId): void
    {
        $balance = SubscriptionBenefitBalance::with('benefitDefinition')->findOrFail($balanceId);
        
        $this->activeBalanceId = $balance->id;
        $this->activeBenefitName = $balance->benefitDefinition->name;
        $this->activeBenefitCategory = $balance->benefitDefinition->category;
        $this->activeAvailableCount = $balance->remaining_count;
        $this->activeTotalGranted = $balance->total_granted;
        $this->redeemQuantity = 1;
        $this->redeemNotes = null;
        $this->showRedeemModal = true;
    }

    public function closeRedeemModal(): void
    {
        $this->showRedeemModal = false;
        $this->activeBalanceId = null;
        $this->activeBenefitName = null;
        $this->redeemNotes = null;
        $this->redeemQuantity = 1;
    }

    public function incrementQuantity(): void
    {
        if ($this->redeemQuantity < $this->activeAvailableCount) {
            $this->redeemQuantity++;
        }
    }

    public function decrementQuantity(): void
    {
        if ($this->redeemQuantity > 1) {
            $this->redeemQuantity--;
        }
    }

    public function setQuickNote(string $note): void
    {
        $this->redeemNotes = empty($this->redeemNotes) ? $note : ($this->redeemNotes . ' • ' . $note);
    }

    public function confirmRedeem(BenefitLedgerService $ledgerService): void
    {
        if (!$this->selectedSubscriptionId || !$this->activeBalanceId) {
            return;
        }

        $subscription = Subscription::findOrFail($this->selectedSubscriptionId);
        $balance = SubscriptionBenefitBalance::with('benefitDefinition')->findOrFail($this->activeBalanceId);

        try {
            $redemption = $ledgerService->redeemBenefit(
                subscription: $subscription,
                benefit: $balance->benefitDefinition,
                quantity: $this->redeemQuantity,
                vetUserId: auth()->id(),
                notes: $this->redeemNotes
            );

            $benefitName = $balance->benefitDefinition->name;
            $qty = $this->redeemQuantity;

            $this->closeRedeemModal();

            $this->dispatch('benefit-redeemed', [
                'benefit' => $benefitName,
                'quantity' => $qty,
            ]);

            Notification::make()
                ->title('🎉 ¡Canje aplicado exitosamente!')
                ->body("Se descontaron {$qty} cupo(s) de \"{$benefitName}\". Nuevo saldo actualizado.")
                ->success()
                ->duration(5000)
                ->send();

        } catch (\Throwable $e) {
            Notification::make()
                ->title('Error al realizar el canje')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function getSelectedSubscriptionProperty(): ?Subscription
    {
        if (!$this->selectedSubscriptionId) {
            return null;
        }

        return Subscription::with([
            'pet.customer',
            'plan',
            'benefitBalances.benefitDefinition',
        ])->find($this->selectedSubscriptionId);
    }

    public function getRecentRedemptionsProperty(): Collection
    {
        if (!$this->selectedSubscriptionId) {
            return collect();
        }

        return BenefitRedemption::whereHas('balance', function ($q) {
            $q->where('subscription_id', $this->selectedSubscriptionId);
        })
        ->with(['balance.benefitDefinition', 'vetUser'])
        ->latest('redeemed_at')
        ->limit(10)
        ->get();
    }

    protected function getHeaderActions(): array
    {
        $tenant = \Filament\Facades\Filament::getTenant() ?? auth()->user()?->tenant ?? \App\Models\Tenant::where('slug', 'vet-pet-patitas')->first() ?? \App\Models\Tenant::first();
        $slug = $tenant?->slug ?? 'vet-pet-patitas';

        return [
            \Filament\Actions\Action::make('print_flyer')
                ->label('🖨️ Afiche QR Mostrador')
                ->icon('heroicon-o-qr-code')
                ->color('success')
                ->url("/v/{$slug}/afiche", shouldOpenInNewTab: true),
        ];
    }
}
