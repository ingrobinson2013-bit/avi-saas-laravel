<?php

namespace App\Filament\VetAdmin\Pages;

use App\Filament\VetAdmin\Widgets\ClinicOperationsToolbarWidget;
use App\Filament\VetAdmin\Widgets\ExpiringSubscriptionsWidget;
use App\Filament\VetAdmin\Widgets\RecentRedemptionsFeedWidget;
use App\Filament\VetAdmin\Widgets\SaasSubscriptionStatusWidget;
use App\Filament\VetAdmin\Widgets\VetStatsOverviewWidget;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Centro de Operaciones Clínicas';
    protected static ?string $navigationLabel = 'Home';
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?int $navigationSort = 1;

    protected function getHeaderActions(): array
    {
        $tenant = Filament::getTenant();
        $slug = $tenant?->slug ?? session('current_tenant_slug') ?? 'vet-pet-patitas';

        return [
            Action::make('counter_redeem')
                ->label('Canje en Recepción')
                ->icon('heroicon-m-qr-code')
                ->color('primary')
                ->url("/admin/{$slug}/counter-redeem"),

            Action::make('view_flyer')
                ->label('Afiche QR')
                ->icon('heroicon-m-printer')
                ->color('gray')
                ->url("/v/{$slug}/afiche")
                ->openUrlInNewTab(),

            Action::make('view_storefront')
                ->label('Ver Web Pacientes')
                ->icon('heroicon-m-arrow-top-right-on-square')
                ->color('gray')
                ->url("/v/{$slug}")
                ->openUrlInNewTab(),

            Action::make('new_subscription')
                ->label('+ Afiliar Mascota')
                ->icon('heroicon-m-user-plus')
                ->color('success')
                ->url("/admin/{$slug}/subscriptions/create"),
        ];
    }

    public function getWidgets(): array
    {
        return [
            SaasSubscriptionStatusWidget::class,
            ClinicOperationsToolbarWidget::class,
            VetStatsOverviewWidget::class,
            ExpiringSubscriptionsWidget::class,
            RecentRedemptionsFeedWidget::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return 2;
    }
}
