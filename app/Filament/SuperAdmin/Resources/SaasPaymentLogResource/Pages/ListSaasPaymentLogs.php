<?php

namespace App\Filament\SuperAdmin\Resources\SaasPaymentLogResource\Pages;

use App\Filament\SuperAdmin\Resources\SaasPaymentLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSaasPaymentLogs extends ListRecords
{
    protected static string $resource = SaasPaymentLogResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
