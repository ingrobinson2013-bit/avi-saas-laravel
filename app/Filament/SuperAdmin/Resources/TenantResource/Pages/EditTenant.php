<?php

namespace App\Filament\SuperAdmin\Resources\TenantResource\Pages;

use App\Filament\SuperAdmin\Resources\TenantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTenant extends EditRecord
{
    protected static string $resource = TenantResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['branding']) && is_array($data['branding'])) {
            $existingBranding = $this->record->branding ?? [];
            if (is_array($existingBranding)) {
                $data['branding'] = array_merge($existingBranding, array_filter($data['branding'], fn ($val) => !is_null($val)));
            }
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

