<?php

namespace App\Filament\VetAdmin\Resources\SubscriptionResource\Pages;

use App\Filament\VetAdmin\Resources\SubscriptionResource;
use App\Models\BenefitDefinition;
use App\Services\BenefitLedgerService;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewSubscription extends ViewRecord
{
    protected static string $resource = SubscriptionResource::class;

    protected static string $view = 'filament.vet-admin.resources.subscription-view';

    public ?string $selectedBenefitId = null;
    public int $redeemQuantity = 1;
    public ?string $redeemNotes = null;

    public function redeemSingleBenefit(string $benefitDefinitionId, BenefitLedgerService $ledgerService): void
    {
        $subscription = $this->record;
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
                ->title('¡Servicio Canjeado con Éxito!')
                ->body("Se descontaron {$redemption->quantity} cupo(s) de {$benefit->name} para {$subscription->pet?->name}.")
                ->success()
                ->send();

            // Refrescar el registro
            $this->record->refresh();

        } catch (\Throwable $e) {
            Notification::make()
                ->title('Límite alcanzado o error')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function resetBalances(BenefitLedgerService $ledgerService): void
    {
        $ledgerService->resetCycleBalances($this->record);
        $this->record->refresh();

        Notification::make()
            ->title('Saldos reiniciados')
            ->body('Los cupos de beneficios fueron restablecidos según las reglas del plan.')
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('renew')
                ->label('Renovar Ciclo de Membresía')
                ->icon('heroicon-o-arrow-path')
                ->color('success')
                ->requiresConfirmation()
                ->action(function (BenefitLedgerService $ledgerService) {
                    $this->record->update([
                        'status' => 'active',
                        'current_period_start' => now(),
                        'current_period_end' => now()->addMonth(),
                    ]);
                    $ledgerService->resetCycleBalances($this->record);
                    $this->record->refresh();

                    Notification::make()
                        ->title('Membresía renovada por 1 mes')
                        ->success()
                        ->send();
                }),
        ];
    }
}
