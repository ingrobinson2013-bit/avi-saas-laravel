<?php

namespace App\Filament\VetAdmin\Widgets;

use App\Filament\VetAdmin\Resources\SubscriptionResource;
use App\Models\Subscription;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ExpiringSubscriptionsWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = '⏰ Membresías Próximas a Vencer & Renovaciones (Próximos 15 Días)';

    public function table(Table $table): Table
    {
        $tenantId = session('current_tenant_id') ?? auth()->user()?->tenant_id;

        return $table
            ->query(
                Subscription::query()
                    ->with(['pet.customer', 'plan', 'benefitBalances'])
                    ->when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))
                    ->where('status', 'active')
                    ->whereBetween('current_period_end', [now()->subDays(2), now()->addDays(15)])
                    ->orderBy('current_period_end', 'asc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('pet.name')
                    ->label('Mascota')
                    ->description(fn (Subscription $record) => ($record->pet?->species === 'cat' ? '🐱 ' : '🐶 ') . ($record->pet?->breed ?? 'Mestizo'))
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('pet.customer.name')
                    ->label('Tutor / WhatsApp')
                    ->description(fn (Subscription $record) => $record->pet?->customer?->phone ?? ''),

                Tables\Columns\TextColumn::make('plan.name')
                    ->label('Plan')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('current_period_end')
                    ->label('Fecha de Vencimiento')
                    ->dateTime('d/m/Y')
                    ->description(function (Subscription $record) {
                        $days = now()->diffInDays($record->current_period_end, false);
                        if ($days < 0) return '🔴 Vencida hace ' . abs($days) . ' días';
                        if ($days === 0) return '🟡 Vence HOY';
                        return "🟡 Vence en {$days} días";
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('benefit_usage')
                    ->label('Uso del Ciclo')
                    ->getStateUsing(fn (Subscription $record) => "{$record->total_used}/{$record->total_granted} servicios")
                    ->badge()
                    ->color('success'),
            ])
            ->actions([
                Tables\Actions\Action::make('whatsappReminder')
                    ->label('Recordar Renovación')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->url(function (Subscription $record) {
                        $phone = preg_replace('/[^0-9]/', '', $record->pet?->customer?->phone ?? '');
                        $tutorName = $record->pet?->customer?->name ?? 'Tutor';
                        $petName = $record->pet?->name ?? 'tu mascota';
                        $planName = $record->plan?->name ?? 'Plan de Bienestar';
                        $date = $record->current_period_end?->format('d/m/Y');
                        
                        $text = "🐾 Hola {$tutorName}, te saludamos de la veterinaria. Te recordamos que el {$planName} de {$petName} finaliza su ciclo el {$date}. ¿Deseas renovar su plan para seguir disfrutando de sus consultas, vacunas y beneficios?";
                        return "https://wa.me/{$phone}?text=" . urlencode($text);
                    })
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make('view')
                    ->label('Ver Ficha')
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->url(fn (Subscription $record) => SubscriptionResource::getUrl('view', ['record' => $record->id])),
            ]);
    }
}
