<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Filament\SuperAdmin\Resources\TenantResource\Pages;
use App\Models\Tenant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TenantResource extends Resource
{
    protected static ?string $model = Tenant::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationLabel = 'Clínicas Veterinarias';
    protected static ?string $modelLabel = 'Clínica Veterinaria';
    protected static ?string $pluralModelLabel = 'Clínicas Veterinarias';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Detalles de la Clínica')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('SaaS & Facturación')
                            ->icon('heroicon-o-credit-card')
                            ->schema([
                                Forms\Components\Grid::make(3)->schema([
                                    Forms\Components\Select::make('branding.saas_status')
                                        ->label('Estado de Cuenta SaaS')
                                        ->options([
                                            'trial' => '⏳ En Período de Prueba (15 Días)',
                                            'paid' => '⭐ Suscripción Oficial / Pago Activo',
                                            'suspended' => '⛔ Suspendido por Falta de Pago',
                                        ])
                                        ->default('trial')
                                        ->required()
                                        ->live()
                                        ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                            if ($state === 'paid') {
                                                if (!$get('branding.saas_last_payment_date')) {
                                                    $set('branding.saas_last_payment_date', now()->format('Y-m-d'));
                                                }
                                                if (!$get('branding.saas_next_payment_due')) {
                                                    $set('branding.saas_next_payment_due', now()->addDays(30)->format('Y-m-d'));
                                                }
                                                if (!$get('branding.saas_payment_method')) {
                                                    $set('branding.saas_payment_method', 'bold_wompi');
                                                }
                                            }
                                        }),

                                    Forms\Components\DatePicker::make('branding.trial_ends_at')
                                        ->label('Fecha Fin de Prueba (15 Días)')
                                        ->helperText('Fecha en que expiran los 15 días gratis'),

                                    Forms\Components\Select::make('saas_plan_tier')
                                        ->label('Nivel de Plan AVI-Plan')
                                        ->options([
                                            'pay_per_pet' => '🌱 Por Mascota Activa ($5.000 COP / mascota)',
                                            'starter' => '🚀 Starter ($99.000 COP/mes — Hasta 60 mascotas)',
                                            'pro' => '⭐ Profesional ($229.000 COP/mes — Hasta 250 mascotas)',
                                            'enterprise' => '👑 Enterprise ($489.000 COP/mes — Ilimitado)',
                                        ])
                                        ->default('pro')
                                        ->required()
                                        ->live()
                                        ->afterStateUpdated(function ($state, Forms\Set $set) {
                                            $defaultFees = [
                                                'pay_per_pet' => 50000,
                                                'starter' => 99000,
                                                'pro' => 229000,
                                                'enterprise' => 489000,
                                            ];
                                            if (isset($defaultFees[$state])) {
                                                $set('branding.saas_monthly_fee', $defaultFees[$state]);
                                            }
                                        }),
                                ]),

                                Forms\Components\Grid::make(3)->schema([
                                    Forms\Components\TextInput::make('branding.saas_monthly_fee')
                                        ->label('Canon Mensual SaaS Acordado (COP)')
                                        ->numeric()
                                        ->prefix('$')
                                        ->placeholder('229000')
                                        ->helperText('Monto mensual cobrado a la clínica'),

                                    Forms\Components\Select::make('branding.saas_payment_method')
                                        ->label('Medio de Pago del Canon')
                                        ->options([
                                            'nequi' => '📱 Nequi / Daviplata',
                                            'bancolombia' => '🏦 Transferencia Bancaria',
                                            'bold_wompi' => '💳 Débito / Tarjeta / PSE (Bold o Wompi)',
                                            'cash' => '💵 Efectivo / Directo',
                                        ])
                                        ->default('nequi'),

                                    Forms\Components\Toggle::make('is_active')
                                        ->label('Acceso al Software Activo')
                                        ->helperText('Si se apaga, el acceso para esta clínica quedará bloqueado.')
                                        ->default(true),
                                ]),

                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\DatePicker::make('branding.saas_last_payment_date')
                                        ->label('Fecha del Último Pago Recibido'),

                                    Forms\Components\DatePicker::make('branding.saas_next_payment_due')
                                        ->label('Próxima Fecha Límite de Pago'),
                                ]),

                                Forms\Components\Textarea::make('branding.admin_notes')
                                    ->label('Notas de Seguimiento Comercial / Robinson')
                                    ->placeholder('Ej. Contactado por WhatsApp el 30/09, interesado en plan Pro con 2 sedes...')
                                    ->rows(3),
                            ]),

                        Forms\Components\Tabs\Tab::make('Información y Contacto')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->label('Nombre de la Veterinaria')
                                        ->required()
                                        ->maxLength(255),

                                    Forms\Components\TextInput::make('slug')
                                        ->label('Slug / Identificador Web (/v/slug)')
                                        ->required()
                                        ->unique(ignoreRecord: true)
                                        ->maxLength(255),
                                ]),

                                Forms\Components\Placeholder::make('clinic_access_urls')
                                    ->label('Rutas Oficiales de Acceso de esta Clínica')
                                    ->columnSpanFull()
                                    ->content(function (?Tenant $record): \Illuminate\Support\HtmlString {
                                        if (!$record) return new \Illuminate\Support\HtmlString('<span class="text-xs text-gray-500">Guarda la clínica primero para generar sus enlaces oficiales.</span>');

                                        $baseDomain = env('APP_BASE_DOMAIN', 'avipetapp.com');
                                        $storefrontUrl = $record->domain ? "https://{$record->domain}" : "https://{$baseDomain}/v/{$record->slug}";
                                        $adminUrl = $record->domain ? "https://{$record->domain}/admin" : "https://{$baseDomain}/admin/{$record->slug}?preview=1";

                                        $html = "
                                        <div class='grid grid-cols-1 md:grid-cols-2 gap-3 p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs'>
                                            <!-- Vitrina -->
                                            <div class='p-3 bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 space-y-1.5'>
                                                <div class='flex items-center justify-between'>
                                                    <span class='text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider flex items-center gap-1'>
                                                        🌐 Vitrina Pública para Tutores
                                                    </span>
                                                    <a href='{$storefrontUrl}' target='_blank' class='text-[11px] font-bold text-blue-600 hover:underline'>
                                                        Abrir ↗
                                                    </a>
                                                </div>
                                                <div class='flex items-center justify-between gap-2 p-1.5 bg-slate-50 dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800'>
                                                    <code class='text-xs font-mono font-bold text-slate-800 dark:text-slate-200 truncate select-all'>{$storefrontUrl}</code>
                                                    <button type='button' onclick=\"navigator.clipboard.writeText('{$storefrontUrl}'); alert('¡Copiado al portapapeles!:\\n{$storefrontUrl}');\" class='px-2.5 py-1 text-[11px] font-bold bg-blue-50 hover:bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300 rounded-md shrink-0 cursor-pointer'>
                                                        Copiar
                                                    </button>
                                                </div>
                                                <p class='text-[10px] text-slate-500'>Donde los clientes eligen planes y afilian a sus mascotas.</p>
                                            </div>

                                            <!-- Panel Admin -->
                                            <div class='p-3 bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 space-y-1.5'>
                                                <div class='flex items-center justify-between'>
                                                    <span class='text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider flex items-center gap-1'>
                                                        ⚙️ Tu Panel de Administración
                                                    </span>
                                                    <a href='{$adminUrl}' target='_blank' class='text-[11px] font-bold text-emerald-600 hover:underline'>
                                                        Abrir ↗
                                                    </a>
                                                </div>
                                                <div class='flex items-center justify-between gap-2 p-1.5 bg-slate-50 dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800'>
                                                    <code class='text-xs font-mono font-bold text-slate-800 dark:text-slate-200 truncate select-all'>{$adminUrl}</code>
                                                    <button type='button' onclick=\"navigator.clipboard.writeText('{$adminUrl}'); alert('¡Copiado al portapapeles!:\\n{$adminUrl}');\" class='px-2.5 py-1 text-[11px] font-bold bg-emerald-50 hover:bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300 rounded-md shrink-0 cursor-pointer'>
                                                        Copiar
                                                    </button>
                                                </div>
                                                <p class='text-[10px] text-slate-500'>Donde la clínica gestiona pacientes, canjes en mostrador y citas.</p>
                                            </div>
                                        </div>
                                        ";

                                        return new \Illuminate\Support\HtmlString($html);
                                    }),

                                Forms\Components\Grid::make(3)->schema([
                                    Forms\Components\TextInput::make('branding.city')
                                        ->label('Ciudad / Municipio')
                                        ->placeholder('Ej. Cajicá, Cundinamarca'),

                                    Forms\Components\TextInput::make('branding.phone')
                                        ->label('WhatsApp Oficial de Contacto')
                                        ->tel()
                                        ->placeholder('3235813942'),

                                    Forms\Components\TextInput::make('branding.email')
                                        ->label('Email de Contacto')
                                        ->email()
                                        ->placeholder('contacto@veterinaria.com'),
                                ]),

                                Forms\Components\TextInput::make('branding.address')
                                    ->label('Dirección de la Sede')
                                    ->placeholder('Calle 7 # 4-73'),

                                Forms\Components\TextInput::make('domain')
                                    ->label('Dominio Oficial / Subdominio de la Clínica')
                                    ->placeholder('ej. vet-pet-patitas.avipetapp.com o planes.veterinariapatitas.com')
                                    ->helperText('Configura el dominio o subdominio asignado a esta clínica. El sistema adaptará automáticamente la tienda de afiliación y el panel administrativo. Recuerda agregar este mismo dominio en Easypanel (App -> Domains).')
                                    ->dehydrateStateUsing(fn (?string $state): ?string => $state ? strtolower(trim(preg_replace('#^https?://#', '', rtrim($state, '/')))) : null)
                                    ->maxLength(255),
                            ]),

                        Forms\Components\Tabs\Tab::make('Métricas & Rendimiento')
                            ->icon('heroicon-o-chart-bar')
                            ->schema([
                                Forms\Components\Placeholder::make('clinic_summary')
                                    ->label('Rendimiento en Vivo de esta Clínica')
                                    ->content(function (?Tenant $record): string {
                                        if (!$record) return 'Guarda la clínica primero para ver sus métricas.';

                                        $tutores = $record->customers()->count();
                                        $subs = $record->subscriptions()->where('status', 'active')->count();
                                        
                                        $gmv = $record->subscriptions()
                                            ->where('subscriptions.status', 'active')
                                            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
                                            ->sum('plans.price_cop');

                                        $mrr = '$' . number_format($gmv, 0, ',', '.') . ' COP/mes';
                                        $canon = '$' . number_format((float) ($record->branding['saas_monthly_fee'] ?? 229000), 0, ',', '.') . ' COP/mes';

                                        return "📊 {$tutores} Tutores Registrados | 🐕 {$subs} Membresías Activas | 💰 Facturación Clínica: {$mrr} | 🏷️ Canon AVI-Plan: {$canon}";
                                    }),
                            ]),

                        Forms\Components\Tabs\Tab::make('Pasarela de Pagos (Bold & Cuentas)')
                            ->icon('heroicon-o-banknotes')
                            ->schema([
                                Forms\Components\TextInput::make('branding.payment_bold_link')
                                    ->label('Link de Pago de Bold de la Clínica (Smart Link)')
                                    ->placeholder('https://checkout.bold.co/payment/LNK_...')
                                    ->helperText('Enlace oficial para que los tutores paguen sus planes con PSE, Tarjeta y Botón Bancolombia.'),

                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\TextInput::make('branding.bold_api_key')
                                        ->label('Bold API Key (Para checkout automatizado)')
                                        ->placeholder('B_pk_live_... / sandbox key')
                                        ->password()
                                        ->helperText('Para generar links dinámicos y validar pagos por Webhook.'),

                                    Forms\Components\TextInput::make('branding.bold_secret_key')
                                        ->label('Bold Secret Key (Firma SHA256)')
                                        ->placeholder('Llave secreta de integridad')
                                        ->password(),
                                ]),

                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\TextInput::make('branding.payment_nequi')
                                        ->label('Número Nequi / Daviplata Oficial')
                                        ->placeholder('3235813942'),

                                    Forms\Components\TextInput::make('branding.payment_bank_info')
                                        ->label('Cuenta Bancaria Oficial')
                                        ->placeholder('Bancolombia Ahorros # 123-456789-01'),
                                ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Historial de Pagos SaaS')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Forms\Components\Placeholder::make('payment_history')
                                    ->label('Registro y Auditoría de Pagos')
                                    ->content(function (?Tenant $record): \Illuminate\Contracts\Support\Htmlable {
                                        if (!$record) return new \Illuminate\Support\HtmlString('<p class="text-sm text-gray-500">Guarda la clínica primero.</p>');
                                        
                                        $logs = $record->saasPaymentLogs()->latest('paid_at')->take(10)->get();
                                        if ($logs->isEmpty()) {
                                            return new \Illuminate\Support\HtmlString('<div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl text-sm text-gray-500">No hay pagos registrados aún para esta clínica en el log oficial.</div>');
                                        }

                                        $html = '<div class="overflow-x-auto"><table class="w-full text-xs text-left border border-gray-200 dark:border-gray-700 rounded-xl">';
                                        $html .= '<thead class="bg-gray-100 dark:bg-gray-800 font-bold"><tr><th class="p-2.5">Fecha</th><th class="p-2.5">Monto</th><th class="p-2.5">Medio</th><th class="p-2.5">Plan</th><th class="p-2.5">Estado</th><th class="p-2.5">Vigencia Hasta</th><th class="p-2.5">Notas</th></tr></thead><tbody>';
                                        foreach ($logs as $log) {
                                            $amount = '$' . number_format($log->amount, 0, ',', '.') . ' COP';
                                            $paidAt = $log->paid_at ? $log->paid_at->format('d/m/Y H:i') : '-';
                                            $end = $log->period_end ? $log->period_end->format('d/m/Y') : '-';
                                            $html .= "<tr class='border-t border-gray-200 dark:border-gray-700'><td class='p-2.5 font-bold'>{$paidAt}</td><td class='p-2.5 text-emerald-600 font-black'>{$amount}</td><td class='p-2.5 uppercase font-semibold'>{$log->gateway}</td><td class='p-2.5 uppercase'>{$log->plan_tier}</td><td class='p-2.5 text-emerald-600 font-bold'>{$log->status}</td><td class='p-2.5'>{$end}</td><td class='p-2.5 text-gray-500'>{$log->notes}</td></tr>";
                                        }
                                        $html .= '</tbody></table></div>';
                                        return new \Illuminate\Support\HtmlString($html);
                                    }),
                            ]),

                        Forms\Components\Tabs\Tab::make('Marca Blanca & Colores')
                            ->icon('heroicon-o-swatch')
                            ->schema([
                                Forms\Components\TextInput::make('branding.logo_url')
                                    ->label('URL del Logo')
                                    ->placeholder('https://...'),

                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\ColorPicker::make('branding.primary_color')
                                        ->label('Color Primario de Marca')
                                        ->default('#0D9488'),

                                    Forms\Components\ColorPicker::make('branding.secondary_color')
                                        ->label('Color Secundario')
                                        ->default('#0F172A'),
                                ]),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('30s')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Clínica & Identidad')
                    ->searchable(['name', 'slug', 'domain'])
                    ->sortable()
                    ->html()
                    ->formatStateUsing(function (Tenant $record): string {
                        $name = e($record->name);
                        $city = e($record->branding['city'] ?? 'Colombia');
                        $doctor = e($record->branding['doctor_name'] ?? '');
                        $logoUrl = $record->branding['logo_url'] ?? null;
                        $domain = e($record->domain ?? ($record->slug . '.' . env('APP_BASE_DOMAIN', 'avipetapp.com')));
                        $storefrontUrl = e($record->base_url);
                        $adminUrl = e($record->getAdminUrl());
                        $impersonateUrl = e(url("/impersonate-clinic/{$record->id}"));

                        $initials = collect(explode(' ', $record->name))->map(fn ($p) => mb_substr($p, 0, 1))->take(2)->join('');

                        $avatarHtml = $logoUrl 
                            ? "<img src='{$logoUrl}' alt='{$name}' class='w-11 h-11 rounded-xl object-contain bg-white border border-slate-200 dark:border-slate-700 shadow-xs p-0.5 shrink-0' />"
                            : "<div class='w-11 h-11 rounded-xl bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 text-white font-black text-xs flex items-center justify-center shadow-xs shrink-0 tracking-wider'>{$initials}</div>";

                        $doctorBadge = $doctor 
                            ? "<span class='inline-flex items-center gap-1 text-[11px] font-semibold text-indigo-600 dark:text-indigo-400'>👩‍⚕️ {$doctor}</span> · "
                            : "";

                        return "
                        <div class='flex items-start gap-3 py-1.5 min-w-[260px]'>
                            {$avatarHtml}
                            <div class='space-y-1.5 flex-1 min-w-0'>
                                <div>
                                    <span class='text-sm font-black text-slate-900 dark:text-white leading-snug block truncate hover:text-indigo-600 transition-colors'>{$name}</span>
                                    <div class='text-[11px] text-slate-500 dark:text-slate-400 font-medium truncate'>
                                        {$doctorBadge}<span>📍 {$city}</span> · <span class='font-mono text-slate-600 dark:text-slate-300'>{$domain}</span>
                                    </div>
                                </div>
                                <div class='flex items-center gap-1.5 pt-0.5'>
                                    <a href='{$storefrontUrl}' target='_blank' class='inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-bold rounded-lg bg-sky-50 text-sky-700 hover:bg-sky-100 dark:bg-sky-950/70 dark:text-sky-300 border border-sky-200/80 dark:border-sky-800 shadow-xs transition-all' title='Abrir Vitrina Pública de Afiliación'>
                                        🌐 Vitrina ↗
                                    </a>
                                    <a href='{$adminUrl}' target='_blank' class='inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-bold rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 dark:bg-emerald-950/70 dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-800 shadow-xs transition-all' title='Abrir Panel de Gestión de la Clínica'>
                                        ⚙️ Panel ↗
                                    </a>
                                    <a href='{$impersonateUrl}' class='inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-bold rounded-lg bg-purple-50 text-purple-700 hover:bg-purple-100 dark:bg-purple-950/70 dark:text-purple-300 border border-purple-200/80 dark:border-purple-800 shadow-xs transition-all' title='Acceder como Administrador de la Clínica'>
                                        🔑 Acceso
                                    </a>
                                </div>
                            </div>
                        </div>
                        ";
                    }),

                Tables\Columns\TextColumn::make('saas_status_badge')
                    ->label('Estado SaaS & Canon')
                    ->html()
                    ->formatStateUsing(function (Tenant $record): string {
                        $status = $record->saas_status;
                        $days = $record->trial_days_remaining;
                        
                        if ($status === 'paid') {
                            $badge = "<span class='inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800'><span class='w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse'></span>⭐ Plan Pago Activo</span>";
                        } elseif ($status === 'suspended') {
                            $badge = "<span class='inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-100 text-rose-800 dark:bg-rose-900/60 dark:text-rose-300 border border-rose-200 dark:border-rose-800'>⛔ Suspendido</span>";
                        } elseif ($days < 0) {
                            $badge = "<span class='inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-100 text-rose-800 dark:bg-rose-900/60 dark:text-rose-300 border border-rose-200 dark:border-rose-800'>🔴 Vencida (" . abs($days) . "d)</span>";
                        } else {
                            $badge = "<span class='inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-900/60 dark:text-amber-300 border border-amber-200 dark:border-amber-800'>⏳ Prueba ({$days}d rest.)</span>";
                        }

                        $tierName = match ($record->saas_plan_tier) {
                            'pay_per_pet' => 'Por Mascota',
                            'starter' => 'Starter ($99k)',
                            'pro' => 'Profesional ($229k)',
                            'enterprise' => 'Enterprise ($489k)',
                            default => ucfirst((string) $record->saas_plan_tier),
                        };

                        $fee = $record->branding['saas_monthly_fee'] ?? null;
                        $feeFormatted = $fee ? '$' . number_format((float) $fee, 0, ',', '.') . ' COP/mes' : 'Tarifa convenir';

                        $paidUntil = $record->branding['saas_next_payment_due'] ?? $record->branding['saas_paid_until'] ?? null;
                        $untilText = $paidUntil ? '📅 Próx. cobro: ' . date('d/m/Y', strtotime($paidUntil)) : 'Sin fecha límite';

                        return "
                        <div class='space-y-1 min-w-[140px]'>
                            <div>{$badge}</div>
                            <div class='text-xs font-black text-slate-800 dark:text-slate-200'>{$feeFormatted}</div>
                            <div class='text-[10px] text-slate-500 dark:text-slate-400 font-medium'>
                                <span>🚀 {$tierName}</span> · <span>{$untilText}</span>
                            </div>
                        </div>
                        ";
                    }),

                Tables\Columns\TextColumn::make('ecosystem_metrics')
                    ->label('Pacientes & Rendimiento')
                    ->html()
                    ->formatStateUsing(function (Tenant $record): string {
                        $subsCount = $record->subscriptions()->where('status', 'active')->count();
                        $petsCount = $record->pets()->count();
                        $custCount = $record->customers()->count();
                        
                        $gmv = $record->subscriptions()
                            ->where('subscriptions.status', 'active')
                            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
                            ->sum('plans.price_cop');
                        $gmvFormatted = '$' . number_format($gmv, 0, ',', '.') . ' COP';

                        return "
                        <div class='space-y-1 min-w-[150px]'>
                            <div class='inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-xs font-black bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-800'>
                                ⭐ {$subsCount} membresías activas
                            </div>
                            <div class='text-[11px] text-slate-600 dark:text-slate-300 font-medium'>
                                🐾 {$petsCount} mascotas · 👤 {$custCount} tutores
                            </div>
                            <div class='text-[11px] font-bold text-slate-500 dark:text-slate-400'>
                                📈 {$gmvFormatted} facturado
                            </div>
                        </div>
                        ";
                    }),

                Tables\Columns\TextColumn::make('contact_phone')
                    ->label('WhatsApp Directo')
                    ->html()
                    ->formatStateUsing(function (Tenant $record): string {
                        $phone = preg_replace('/[^0-9]/', '', $record->branding['phone'] ?? '');
                        if (empty($phone)) {
                            return "
                            <span class='inline-flex items-center gap-1 text-[11px] text-slate-400 italic px-2 py-1 rounded-md bg-slate-100 dark:bg-slate-800'>
                                Sin teléfono
                            </span>
                            ";
                        }
                        $prefix = str_starts_with($phone, '57') ? $phone : "57{$phone}";
                        $formattedPhone = strlen($phone) === 10 
                            ? substr($phone, 0, 3) . ' ' . substr($phone, 3, 3) . ' ' . substr($phone, 6)
                            : $phone;
                        $msg = urlencode("Hola Dr(a) de {$record->name}, te escribo del equipo AVI-Plan para conocer cómo va la experiencia en tu clínica veterinaria.");
                        $waUrl = "https://wa.me/{$prefix}?text={$msg}";

                        return "
                        <a href='{$waUrl}' target='_blank' class='inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-lg bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white shadow-xs transition-all shrink-0' title='Abrir chat directo en WhatsApp'>
                            <svg class='w-3.5 h-3.5 fill-current' viewBox='0 0 24 24'><path d='M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z'/></svg>
                            <span>{$formattedPhone}</span>
                        </a>
                        ";
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha Alta')
                    ->date('d M Y')
                    ->sortable()
                    ->color('gray'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('saas_plan_tier')
                    ->label('Filtrar por Plan')
                    ->options([
                        'pay_per_pet' => 'Por Mascota Activa ($5.000)',
                        'starter' => 'Starter ($99.000)',
                        'pro' => 'Profesional ($229.000)',
                        'enterprise' => 'Enterprise ($489.000)',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Activas / Suspendidas'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->label('✏️ Editar Configuración Completa'),

                    Tables\Actions\Action::make('extendTrial')
                        ->label('⏳ Extender +15 Días de Prueba')
                        ->icon('heroicon-o-clock')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->modalHeading('¿Extender período de prueba?')
                        ->modalDescription('Se sumarán 15 días adicionales a partir de hoy a la clínica para que continúe evaluando AVI-Plan.')
                        ->action(function (Tenant $record) {
                            $branding = $record->branding ?? [];
                            $branding['trial_ends_at'] = now()->addDays(15)->toIso8601String();
                            $branding['saas_status'] = 'trial';
                            $record->update(['branding' => $branding, 'is_active' => true]);

                            Notification::make()
                                ->title('¡Prueba extendida con éxito!')
                                ->body("La clínica {$record->name} tiene 15 días más de prueba activa.")
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\Action::make('activatePaid')
                        ->label('⭐ Activar Suscripción Oficial de Pago')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('¿Activar Suscripción Oficial de Pago?')
                        ->modalDescription('Esta clínica pasará a estado oficial activo pagado en AVI-Plan y se sumarán 30 días de cobertura.')
                        ->action(function (Tenant $record) {
                            $branding = $record->branding ?? [];
                            $branding['saas_status'] = 'paid';
                            $branding['saas_last_payment_date'] = now()->toDateString();
                            $branding['saas_next_payment_due'] = now()->addDays(30)->toDateString();
                            $branding['saas_paid_until'] = now()->addDays(30)->toDateString();
                            $branding['saas_payment_method'] = $branding['saas_payment_method'] ?? 'bold_wompi';
                            $fee = (float) ($branding['saas_monthly_fee'] ?? 99000);
                            $record->update(['branding' => $branding, 'is_active' => true]);

                            // Registrar en Log Oficial de Pagos
                            \App\Models\SaasPaymentLog::create([
                                'tenant_id' => $record->id,
                                'order_id' => "ADMIN-ACTIVATE-{$record->slug}-" . time(),
                                'gateway' => $branding['saas_payment_method'] ?? 'manual',
                                'amount' => $fee,
                                'currency' => 'COP',
                                'plan_tier' => $record->saas_plan_tier ?? 'starter',
                                'status' => 'approved',
                                'payer_name' => $record->name,
                                'period_start' => now()->toDateString(),
                                'period_end' => now()->addDays(30)->toDateString(),
                                'notes' => 'Activación directa desde el panel de SuperAdmin.',
                                'paid_at' => now(),
                            ]);

                            Notification::make()
                                ->title('¡Plan de Pago Activado y Registrado!')
                                ->body("La clínica {$record->name} quedó al día hasta el " . now()->addDays(30)->format('d/m/Y') . " y se registró en el Historial de Pagos.")
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\Action::make('registerPayment')
                        ->label('💵 Registrar Pago Manual / Renovación')
                        ->icon('heroicon-o-banknotes')
                        ->color('success')
                        ->form([
                            Forms\Components\TextInput::make('amount')
                                ->label('Monto Pagado (COP)')
                                ->numeric()
                                ->prefix('$')
                                ->default(fn (Tenant $record) => $record->branding['saas_monthly_fee'] ?? 99000)
                                ->required(),

                            Forms\Components\Select::make('gateway')
                                ->label('Medio de Pago')
                                ->options([
                                    'nequi' => '📱 Transferencia Nequi / Daviplata',
                                    'bancolombia' => '🏦 Transferencia Bancolombia',
                                    'bold' => '💳 Pasarela Bold',
                                    'cash' => '💵 Efectivo Directo',
                                ])
                                ->default('nequi')
                                ->required(),

                            Forms\Components\DatePicker::make('paid_date')
                                ->label('Fecha del Pago')
                                ->default(now()->toDateString())
                                ->required(),

                            Forms\Components\Textarea::make('notes')
                                ->label('Notas / Comprobante')
                                ->placeholder('Ej. Comprobante de Nequi recibido por WhatsApp')
                                ->rows(2),
                        ])
                        ->action(function (Tenant $record, array $data) {
                            $paidDate = \Carbon\Carbon::parse($data['paid_date']);
                            $nextDue = $paidDate->copy()->addDays(30);

                            $branding = $record->branding ?? [];
                            $branding['saas_status'] = 'paid';
                            $branding['saas_last_payment_date'] = $paidDate->toDateString();
                            $branding['saas_next_payment_due'] = $nextDue->toDateString();
                            $branding['saas_paid_until'] = $nextDue->toDateString();
                            $branding['saas_payment_method'] = $data['gateway'];
                            $branding['saas_monthly_fee'] = $data['amount'];
                            $record->update(['branding' => $branding, 'is_active' => true]);

                            \App\Models\SaasPaymentLog::create([
                                'tenant_id' => $record->id,
                                'order_id' => "MANUAL-{$record->slug}-" . time(),
                                'gateway' => $data['gateway'],
                                'amount' => $data['amount'],
                                'currency' => 'COP',
                                'plan_tier' => $record->saas_plan_tier ?? 'starter',
                                'status' => 'approved',
                                'payer_name' => $record->name,
                                'period_start' => $paidDate->toDateString(),
                                'period_end' => $nextDue->toDateString(),
                                'notes' => $data['notes'] ?? 'Pago manual registrado desde SuperAdmin',
                                'paid_at' => $paidDate,
                            ]);

                            Notification::make()
                                ->title('¡Pago Registrado Exitosamente!')
                                ->body("La clínica {$record->name} quedó al día hasta el {$nextDue->format('d/m/Y')}.")
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\Action::make('openSaasCheckout')
                        ->label('💳 Pasarela Bold SaaS de la Clínica')
                        ->icon('heroicon-o-credit-card')
                        ->color('info')
                        ->url(fn (Tenant $record): string => url("/admin/{$record->slug}/renovar-saas"), true),

                    Tables\Actions\Action::make('sendBoldLinkWhatsApp')
                        ->label('📲 Enviar Link Bold por WhatsApp')
                        ->icon('heroicon-m-chat-bubble-left-ellipsis')
                        ->color('success')
                        ->url(function (Tenant $record): ?string {
                            $phone = preg_replace('/[^0-9]/', '', $record->branding['phone'] ?? '');
                            if (empty($phone)) return null;
                            $prefix = str_starts_with($phone, '57') ? $phone : "57{$phone}";
                            $fee = '$' . number_format((float) ($record->branding['saas_monthly_fee'] ?? 99000), 0, ',', '.') . ' COP';
                            $link = url("/admin/{$record->slug}/renovar-saas");
                            $msg = "Hola Dr(a) de {$record->name}, te escribo de AVI-Plan. Tu suscripción mensual ({$fee}) está lista para renovación. Puedes realizar tu pago seguro con PSE, Tarjeta o Botón Bancolombia en el siguiente link oficial de Bold: {$link} . ¡Muchas gracias!";
                            return "https://wa.me/{$prefix}?text=" . urlencode($msg);
                        }, true),

                    Tables\Actions\Action::make('impersonate')
                        ->label('🔑 Impersonar Sesión (1-Clic)')
                        ->icon('heroicon-o-key')
                        ->color('warning')
                        ->url(fn (Tenant $record): string => url("/impersonate-clinic/{$record->id}")),

                    Tables\Actions\Action::make('openStorefront')
                        ->label('🌐 Abrir Vitrina Pública')
                        ->icon('heroicon-o-globe-alt')
                        ->color('info')
                        ->url(fn (Tenant $record): string => $record->base_url, true),

                    Tables\Actions\Action::make('openAdmin')
                        ->label('⚙️ Abrir Panel Administrativo')
                        ->icon('heroicon-o-computer-desktop')
                        ->color('primary')
                        ->url(fn (Tenant $record): string => $record->getAdminUrl(), true),

                    Tables\Actions\Action::make('toggleActive')
                        ->label(fn (Tenant $record) => $record->is_active ? '⛔ Suspender Acceso' : '✅ Reactivar Acceso')
                        ->icon(fn (Tenant $record) => $record->is_active ? 'heroicon-o-no-symbol' : 'heroicon-o-check-circle')
                        ->color(fn (Tenant $record) => $record->is_active ? 'danger' : 'success')
                        ->requiresConfirmation()
                        ->action(fn (Tenant $record) => $record->update(['is_active' => !$record->is_active])),

                    Tables\Actions\DeleteAction::make()
                        ->label('🗑️ Eliminar Clínica y Datos')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->modalHeading(fn (Tenant $record) => "⚠️ ¿Eliminar permanentemente a {$record->name}?")
                        ->modalDescription('Esta acción es irreversible: se eliminarán automáticamente todos los usuarios, tutores, mascotas, citas y configuraciones de esta clínica en cascada.')
                        ->modalSubmitActionLabel('Sí, eliminar clínica')
                        ->hidden(fn (Tenant $record) => $record->slug === 'vet-pet-patitas'),
                ])
                ->label('⚡ Gestionar')
                ->icon('heroicon-m-cog-6-tooth')
                ->size('sm')
                ->color('primary')
                ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTenants::route('/'),
            'create' => Pages\CreateTenant::route('/create'),
            'edit' => Pages\EditTenant::route('/{record}/edit'),
        ];
    }
}
