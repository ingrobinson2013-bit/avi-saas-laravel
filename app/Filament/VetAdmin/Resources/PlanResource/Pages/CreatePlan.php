<?php

namespace App\Filament\VetAdmin\Resources\PlanResource\Pages;

use App\Filament\VetAdmin\Resources\PlanResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePlan extends CreateRecord
{
    protected static string $resource = PlanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $tenantId = session('current_tenant_id') ?? auth()->user()?->tenant_id ?? \App\Models\Tenant::where('slug', 'vet-pet-patitas')->first()?->id ?? \App\Models\Tenant::first()?->id;
        $data['tenant_id'] = $tenantId;
        return $data;
    }
}
