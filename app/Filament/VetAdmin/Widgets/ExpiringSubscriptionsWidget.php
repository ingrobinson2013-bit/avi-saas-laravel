<?php

namespace App\Filament\VetAdmin\Widgets;

use App\Filament\VetAdmin\Resources\SubscriptionResource;
use App\Models\Subscription;
use Filament\Facades\Filament;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ExpiringSubscriptionsWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = ['md' => 2, 'xl' => 1];
    protected static ?string $heading = '⏰ Membresías Próximas a Renovar';

    public function table(Table $table): Table
    {
        $tenant = Filament::getTenant();
        $tenantId = $tenant?->id ?? session('current_tenant_id') ?? auth()->user()?->tenant_id;

        return $table
            ->query(
                Subscription::query()
                    ->with(['pet.customer', 'plan', 'benefitBalances'])
                    ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
                    ->where('subscriptions.status', 'active')
                    ->whereBetween('current_period_end', [now()->subDays(2), now()->addDays(15)])
                    ->orderBy('current_period_end', 'asc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('pet.name')
                    ->label('Paciente')
                    ->formatStateUsing(function ($state, Subscription $record) {
                        $species = $record->pet?->species === 'cat' ? '🐱' : '🐶';
                        return "{$species} " . ($state ?? 'Mascota');
                    })
                    ->description(fn (Subscription $record) => $record->pet?->customer?->name ?? 'Tutor')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('plan.name')
                    ->label('Plan')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('current_period_end')
                    ->label('Vencimiento')
                    ->dateTime('d/m/Y')
                    ->description(function (Subscription $record) {
                        $days = (int) round(now()->diffInDays($record->current_period_end, false));
                        if ($days < 0) return '🔴 Vencida';
                        if ($days === 0) return '🟡 Vence hoy';
                        return "🟡 En {$days} días";
                    })
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('whatsappReminder')
                    ->label('WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->url(function (Subscription $record) {
                        $phone = preg_replace('/[^0-9]/', '', $record->pet?->customer?->phone ?? '');
                        $tutorName = $record->pet?->customer?->name ?? 'Tutor';
                        $petName = $record->pet?->name ?? 'tu mascota';
                        $planName = $record->plan?->name ?? 'Plan de Bienestar';
                        $date = $record->current_period_end?->format('d/m/Y');
                        
                        $text = "🐾 Hola {$tutorName}, te saludamos de la clínica veterinaria. Te recordamos que el {$planName} de {$petName} finaliza su ciclo el {$date}. ¿Deseas renovar su plan para seguir disfrutando de sus consultas, vacunas y beneficios?";
                        return "https://wa.me/{$phone}?text=" . urlencode($text);
                    })
                    ->openUrlInNewTab(),
            ])
            ->paginated(false);
    }
}
