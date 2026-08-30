<?php

namespace App\Filament\VetAdmin\Widgets;

use App\Models\BenefitRedemption;
use Filament\Facades\Filament;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentRedemptionsFeedWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = ['md' => 2, 'xl' => 1];
    protected static ?string $heading = '⚡ Canjes Recientes en Mostrador (Feed en vivo)';

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
            ->paginated(false);
    }
}
