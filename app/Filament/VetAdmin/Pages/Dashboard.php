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
    protected static ?string $navigationLabel = 'Home';
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return 'Home';
    }
    public function getTitle(): string
    {
        $tenant = Filament::getTenant();
        $fullName = $tenant?->name ?? 'Clínica Veterinaria';
        $brandName = $fullName;
        if (preg_match('/^(.*?)\s+(Consultorio Veterinario|Clínica Veterinaria|Hospital Veterinario|Veterinaria|Vet)(.*)$/i', $fullName, $matches)) {
            $extracted = trim($matches[1] . ' ' . $matches[3]);
            if (!empty($extracted)) {
                $brandName = $extracted;
            }
        }

        $hour = (int) now()->timezone('America/Bogota')->format('H');
        $greeting = $hour < 12 ? 'Buenos días' : ($hour < 18 ? 'Buenas tardes' : 'Buenas noches');

        return "{$greeting}, {$brandName} 👋";
    }

    public function getSubheading(): ?string
    {
        $tenant = Filament::getTenant();
        $rawCity = $tenant?->branding['city'] ?? 'Sede Principal';
        $cleanCity = trim(explode(',', $rawCity)[0]);

        \Carbon\Carbon::setLocale('es');
        $dateFormatted = now()->timezone('America/Bogota')->translatedFormat('l j \d\e F');

        return "Sede {$cleanCity} · " . ucfirst($dateFormatted);
    }

    protected function getHeaderActions(): array
    {
        $tenant = Filament::getTenant();
        $slug = $tenant?->slug ?? session('current_tenant_slug') ?? 'vet-pet-patitas';

        return [
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
            VetStatsOverviewWidget::class,
            ClinicOperationsToolbarWidget::class,
            ExpiringSubscriptionsWidget::class,
            RecentRedemptionsFeedWidget::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return 2;
    }
}
