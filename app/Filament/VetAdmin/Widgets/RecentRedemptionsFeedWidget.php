<?php

namespace App\Filament\VetAdmin\Widgets;

use App\Models\BenefitRedemption;
use App\Models\SubscriptionBenefitBalance;
use Filament\Facades\Filament;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentRedemptionsFeedWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = ['md' => 2, 'xl' => 1];
    protected static ?string $heading = '🐾 Actividad Reciente';
    protected static string $view = 'filament.vet-admin.widgets.recent-redemptions-feed';

    public int $totalUsed = 0;
    public int $totalGranted = 0;
    public int $percent = 0;

    public function mount(): void
    {
        $tenant = Filament::getTenant();
        $tenantId = $tenant?->id ?? session('current_tenant_id') ?? auth()->user()?->tenant_id;

        $this->totalGranted = (int) SubscriptionBenefitBalance::query()
            ->where('total_granted', '<', 500)
            ->when($tenantId, fn ($q) => $q->whereHas('subscription', fn ($s) => $s->where('tenant_id', $tenantId)))
            ->sum('total_granted');

        $this->totalUsed = (int) SubscriptionBenefitBalance::query()
            ->where('total_granted', '<', 500)
            ->when($tenantId, fn ($q) => $q->whereHas('subscription', fn ($s) => $s->where('tenant_id', $tenantId)))
            ->sum('used_count');

        $this->percent = $this->totalGranted > 0 
            ? (int) round(($this->totalUsed / $this->totalGranted) * 100) 
            : 0;
    }

    public function table(Table $table): Table
    {
        $tenant = Filament::getTenant();
        $tenantId = $tenant?->id ?? session('current_tenant_id') ?? auth()->user()?->tenant_id;

        return $table
            ->query(
                BenefitRedemption::query()
                    ->with(['balance.subscription.pet', 'balance.benefitDefinition', 'vetUser'])
                    ->when($tenantId, fn ($q) => $q->where('benefit_redemptions.tenant_id', $tenantId))
                    ->latest('redeemed_at')
                    ->limit(6)
            )
            ->columns([
                Tables\Columns\TextColumn::make('balance.subscription.pet.name')
                    ->label('Paciente')
                    ->formatStateUsing(function ($state, BenefitRedemption $record) {
                        $species = $record->balance?->subscription?->pet?->species === 'cat' ? '🐱' : '🐶';
                        return "{$species} " . ($state ?? 'Paciente');
                    })
                    ->description(fn (BenefitRedemption $record) => $record->balance?->benefitDefinition?->name ?? 'Servicio')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('redeemed_at')
                    ->label('Hora / Canje')
                    ->since()
                    ->description(fn (BenefitRedemption $record) => $record->vetUser?->name ?? 'Responsable Vet')
                    ->badge()
                    ->color('success'),
            ])
            ->emptyStateHeading('Sin canjes registrados todavía')
            ->emptyStateDescription('Cuando atiendas a un paciente en mostrador y descuentes un servicio, aparecerá aquí en tiempo real.')
            ->emptyStateIcon('heroicon-o-qr-code')
            ->emptyStateActions([
                Tables\Actions\Action::make('openCounter')
                    ->label('Abrir Terminal de Canje')
                    ->icon('heroicon-m-qr-code')
                    ->color('primary')
                    ->url(fn () => '/admin/' . (\Filament\Facades\Filament::getTenant()?->slug ?? 'vet-pet-patitas') . '/counter-redeem'),
            ])
            ->paginated(false);
    }
}
