<?php

namespace App\Filament\VetAdmin\Resources\BenefitDefinitionResource\Pages;

use App\Filament\VetAdmin\Resources\BenefitDefinitionResource;
use App\Models\Tenant;
use Filament\Resources\Pages\CreateRecord;

class CreateBenefitDefinition extends CreateRecord
{
    protected static string $resource = BenefitDefinitionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Asignar el tenant actual si no viene en el formulario
        $tenantId = session('current_tenant_id') ?? auth()->user()?->tenant_id ?? Tenant::first()?->id;
        $data['tenant_id'] = $tenantId;

        return $data;
    }
}
