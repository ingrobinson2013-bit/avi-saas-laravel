<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ProspectoVeterinaria;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class SuperAdminConfiguracionController extends Controller
{
    public function index(Request $request): Response
    {
        $authUser = auth()->user();

        // System health checks
        $dbStatus = 'connected';
        try {
            DB::connection()->getPdo();
        } catch (\Throwable $e) {
            $dbStatus = 'error';
        }

        $tenantsCount = Tenant::count();
        $usersCount = User::count();
        $prospectosCount = ProspectoVeterinaria::count();

        $configData = [
            // Pasarela Bold
            'bold_identity_key' => env('BOLD_IDENTITY_KEY', 'IbjyaOSv3SnqfctP4GD76HIMxgud5dGkKisprmvthoQ'),
            'bold_secret_key' => env('BOLD_SECRET_KEY', 'PvBaAHlwotfgJvuaS923gQ'),
            'bold_webhook_url' => url('/api/webhooks/bold'),
            'bold_mode' => env('BOLD_MODE', 'production'),

            // Parámetros SaaS
            'trial_days' => (int) env('SAAS_TRIAL_DAYS', 15),
            'default_saas_fee' => (float) env('SAAS_DEFAULT_FEE', 99000),
            'enterprise_saas_fee' => (float) env('SAAS_ENTERPRISE_FEE', 199000),

            // Contacto y Soporte
            'platform_name' => 'AviPetApp — Software con IA para veterinarias',
            'support_email' => 'contacto@avipetapp.com',
            'support_phone' => '+57 323 581 3942',
            'base_domain' => env('APP_BASE_DOMAIN', 'avipetapp.com'),

            // Telemetría del Sistema
            'system' => [
                'db_status' => $dbStatus,
                'php_version' => PHP_VERSION,
                'laravel_version' => app()->version(),
                'server_ip' => '72.60.112.240 (Easypanel Host)',
                'environment' => app()->environment(),
                'tenants_count' => $tenantsCount,
                'users_count' => $usersCount,
                'prospectos_count' => $prospectosCount,
            ]
        ];

        return Inertia::render('SuperAdmin/Configuracion', [
            'config' => $configData,
            'userName' => $authUser?->name ?? 'Robinson Naranjo',
            'userEmail' => $authUser?->email ?? 'superadmin@avipetapp.com',
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'trial_days' => 'nullable|integer|min:1|max:90',
            'default_saas_fee' => 'nullable|numeric|min:0',
            'enterprise_saas_fee' => 'nullable|numeric|min:0',
            'support_email' => 'nullable|email',
            'support_phone' => 'nullable|string|max:50',
        ]);

        return redirect()->back()->with('success', 'Parámetros de configuración guardados correctamente.');
    }
}
