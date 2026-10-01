<?php

namespace App\Filament\VetAdmin\Pages;

use App\Filament\VetAdmin\Widgets\AviRecommendsWidget;
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

    public function getSubheading(): ?\Illuminate\Contracts\Support\Htmlable
    {
        $tenant = Filament::getTenant();
        $rawCity = $tenant?->branding['city'] ?? 'Sede Principal';
        $cleanCity = trim(explode(',', $rawCity)[0]);

        \Carbon\Carbon::setLocale('es');
        $dateFormatted = now()->timezone('America/Bogota')->translatedFormat('l j \d\e F');
        $dateText = "Sede {$cleanCity} · " . ucfirst($dateFormatted);

        return new \Illuminate\Support\HtmlString('
            <div class="flex items-center gap-2.5 flex-wrap mt-0.5">
                <span class="text-xs sm:text-sm font-semibold text-slate-500 dark:text-slate-400">' . e($dateText) . '</span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10.5px] font-black uppercase tracking-wider bg-emerald-50 dark:bg-emerald-950/70 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 shadow-2xs">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span>Mostrador en Vivo · Sincronizado</span>
                </span>
            </div>
        ');
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
            AviRecommendsWidget::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return 2;
    }
}
