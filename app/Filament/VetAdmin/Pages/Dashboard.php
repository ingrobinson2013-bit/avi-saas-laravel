<?php

namespace App\Filament\VetAdmin\Pages;

use App\Filament\VetAdmin\Widgets\ExpiringSubscriptionsWidget;
use App\Filament\VetAdmin\Widgets\RecentRedemptionsFeedWidget;
use App\Filament\VetAdmin\Widgets\SaasSubscriptionStatusWidget;
use App\Filament\VetAdmin\Widgets\VetStatsOverviewWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Escritorio Clínico';

    public function getWidgets(): array
    {
        return [
            SaasSubscriptionStatusWidget::class,
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
