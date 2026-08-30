<?php

namespace App\Filament\VetAdmin\Resources\SubscriptionResource\Pages;

use App\Filament\VetAdmin\Resources\SubscriptionResource;
use App\Models\Tenant;
use App\Services\BenefitLedgerService;
use Filament\Resources\Pages\CreateRecord;

class CreateSubscription extends CreateRecord
{
    protected static string $resource = SubscriptionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $tenantId = session('current_tenant_id') ?? auth()->user()?->tenant_id ?? Tenant::first()?->id;
        $data['tenant_id'] = $tenantId;

        return $data;
    }

    protected function afterCreate(): void
    {
        // Inicializar saldos de beneficios para el nuevo contrato
        $ledgerService = app(BenefitLedgerService::class);
        $ledgerService->resetCycleBalances($this->record);
    }
}
