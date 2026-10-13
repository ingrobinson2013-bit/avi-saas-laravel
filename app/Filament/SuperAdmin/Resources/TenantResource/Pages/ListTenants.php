<?php

namespace App\Filament\SuperAdmin\Resources\TenantResource\Pages;

use App\Filament\SuperAdmin\Resources\TenantResource;
use App\Filament\SuperAdmin\Widgets\SuperAdminStatsOverviewWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTenants extends ListRecords
{
    protected static string $resource = TenantResource::class;

    public function getTitle(): string | \Illuminate\Contracts\Support\Htmlable
    {
        return 'Listado de Clínicas Veterinarias';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('➕ Registrar Nueva Veterinaria')
                ->icon('heroicon-o-plus-circle'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            SuperAdminStatsOverviewWidget::class,
        ];
    }
}
