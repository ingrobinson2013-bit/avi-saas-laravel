<?php

namespace App\Filament\SuperAdmin\Pages;

use Filament\Pages\Page;

class Configuracion extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Configuración';
    protected static ?string $title = 'Configuración Global de la Plataforma';
    protected static ?int $navigationSort = 5;
    protected static string $view = 'filament.super-admin.pages.configuracion';

    public string $boldIdentityKey = 'IbjyaOSv3SnqfctP4GD76HIMxgud5dGkKisprmvthoQ';
    public string $boldSecretKey = 'PvBaAHlwotfgJvuaS923gQ';
    public string $platformName = 'AviPetApp';
    public string $supportEmail = 'contacto@avipetapp.com';
    public string $supportPhone = '+57 300 000 0000';
    public int $trialDays = 15;
    public float $defaultSaaSFee = 99000;
}
