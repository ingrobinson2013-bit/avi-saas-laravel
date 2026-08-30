<?php

namespace App\Providers\Filament;

use App\Models\Tenant;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class VetAdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('vet-admin')
            ->path('admin')
            ->tenant(Tenant::class, slugAttribute: 'slug')
            ->login()
            ->brandName('Vet-Pet Patitas — Consultorio Veterinario')
            ->brandLogo(fn () => view('filament.vet-admin.logo'))
            ->brandLogoHeight('2.5rem')
            ->favicon('https://images.unsplash.com/photo-1576201836106-db1758fd1c97?w=64')
            ->font('Plus Jakarta Sans')
            ->darkMode(true)
            ->colors([
                'primary' => [
                    50 => '#ecfdf5',
                    100 => '#d1fae5',
                    200 => '#a7f3d0',
                    300 => '#6ee7b7',
                    400 => '#34d399',
                    500 => '#10b981',
                    600 => '#059669',
                    700 => '#047857',
                    800 => '#065f46',
                    900 => '#064e3b',
                    950 => '#022c22',
                ],
                'info' => Color::Sky,
                'success' => Color::Emerald,
                'warning' => Color::Amber,
                'danger' => Color::Rose,
                'gray' => Color::Slate,
            ])
            ->renderHook(
                'panels::head.end',
                fn () => view('filament.vet-admin.custom-styles')
            )
            ->renderHook(
                'panels::sidebar.nav.start',
                fn () => view('filament.vet-admin.components.quick-redeem-cta')
            )
            ->discoverResources(in: app_path('Filament/VetAdmin/Resources'), for: 'App\\Filament\\VetAdmin\\Resources')
            ->discoverPages(in: app_path('Filament/VetAdmin/Pages'), for: 'App\\Filament\\VetAdmin\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/VetAdmin/Widgets'), for: 'App\\Filament\\VetAdmin\\Widgets')
            ->widgets([
                // Widgets descubiertos automáticamente
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
