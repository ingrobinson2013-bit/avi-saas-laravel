<?php

namespace App\Filament\VetAdmin\Pages;

use App\Models\BenefitDefinition;
use App\Models\Customer;
use App\Models\Pet;
use App\Models\Subscription;
use App\Services\BenefitLedgerService;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Collection;

class CounterRedeem extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-qr-code';
    protected static ?string $navigationLabel = 'Canje en Recepción';
    protected static ?string $title = 'Punto de Canje & Validación de Saldos';
    protected static ?string $slug = 'counter-redeem';
    protected static string $view = 'filament.vet-admin.pages.counter-redeem';

    public string $searchQuery = '';
    public ?string $selectedSubscriptionId = null;
    public ?string $redeemNotes = null;
    public int $redeemQuantity = 1;

    public function search(): Collection
    {
        if (strlen(trim($this->searchQuery)) < 2) {
            return collect();
        }

        $query = trim($this->searchQuery);
        $tenant = \Filament\Facades\Filament::getTenant();
        $tenantId = $tenant?->id ?? session('current_tenant_id') ?? auth()->user()?->tenant_id;

        return Subscription::with(['pet.customer', 'plan', 'benefitBalances.benefitDefinition'])
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where(function ($mainQuery) use ($query) {
                $mainQuery->whereHas('pet.customer', function ($q) use ($query) {
                    $q->where('identification', 'ilike', "%{$query}%")
                      ->orWhere('phone', 'ilike', "%{$query}%")
                      ->orWhere('name', 'ilike', "%{$query}%");
                })
                ->orWhereHas('pet', function ($q) use ($query) {
                    $q->where('name', 'ilike', "%{$query}%");
                });
            })
            ->where('subscriptions.status', 'active')
            ->limit(8)
            ->get();
    }

    public function selectSubscription(string $id): void
    {
        $this->selectedSubscriptionId = $id;
    }

    public function redeemBenefit(string $benefitDefinitionId, BenefitLedgerService $ledgerService): void
    {
        if (!$this->selectedSubscriptionId) {
            return;
        }

        $subscription = Subscription::findOrFail($this->selectedSubscriptionId);
        $benefit = BenefitDefinition::findOrFail($benefitDefinitionId);

        try {
            $redemption = $ledgerService->redeemBenefit(
                subscription: $subscription,
                benefit: $benefit,
                quantity: $this->redeemQuantity,
                vetUserId: auth()->id(),
                notes: $this->redeemNotes
            );

            $this->redeemNotes = null;
            $this->redeemQuantity = 1;

            Notification::make()
                ->title('¡Beneficio canjeado con éxito!')
                ->body("Se descontaron {$redemption->quantity} cupo(s) de {$benefit->name}.")
                ->success()
                ->send();

        } catch (\Throwable $e) {
            Notification::make()
                ->title('Error al canjear')
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

        return Subscription::with(['pet.customer', 'plan', 'benefitBalances.benefitDefinition', 'benefitBalances.redemptions'])
            ->find($this->selectedSubscriptionId);
    }
}
