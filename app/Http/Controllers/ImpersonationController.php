<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ImpersonationController extends Controller
{
    /**
     * Iniciar sesión como una clínica específica desde el SuperAdmin.
     */
    public function impersonateTenant(string $tenantId)
    {
        $tenant = Tenant::findOrFail($tenantId);
        $currentUser = Auth::user();

        // Guardar el ID del SuperAdmin en sesión si no estamos ya impersonando
        if ($currentUser && !session()->has('impersonator_superadmin_id')) {
            session(['impersonator_superadmin_id' => $currentUser->id]);
        } elseif (!session()->has('impersonator_superadmin_id')) {
            // Si vino por link directo, buscamos al superadmin
            $superAdmin = User::whereNull('tenant_id')->orWhere('role', 'super_admin')->first();
            if ($superAdmin) {
                session(['impersonator_superadmin_id' => $superAdmin->id]);
            }
        }

        // Buscar el usuario administrador principal de la clínica
        $tenantUser = $tenant->users()->where('email', 'petmovilveterinario@gmail.com')->first() 
            ?? $tenant->users()->first();

        if (!$tenantUser) {
            $tenantUser = User::create([
                'name' => "Admin {$tenant->name}",
                'email' => "admin@{$tenant->slug}.local",
                'tenant_id' => $tenant->id,
                'password' => bcrypt(Str::random(24)),
            ]);
        }

        // Iniciar sesión con el usuario de la clínica
        Auth::guard('web')->login($tenantUser, true);
        session()->regenerate();
        
        session(['current_tenant_id' => $tenant->id]);
        session(['current_tenant_slug' => $tenant->slug]);

        return redirect()->to("/admin/{$tenant->slug}");
    }

    /**
     * Salir del modo soporte y volver al SuperAdmin.
     */
    public function stopImpersonating()
    {
        $superAdminId = session('impersonator_superadmin_id');
        session()->forget('impersonator_superadmin_id');
        session()->forget('current_tenant_id');
        session()->forget('current_tenant_slug');

        $superAdmin = $superAdminId ? User::find($superAdminId) : User::whereNull('tenant_id')->orWhere('role', 'super_admin')->first();

        if ($superAdmin) {
            Auth::guard('web')->login($superAdmin, true);
            session()->regenerate();
            return redirect()->to('/super-admin/tenants');
        }

        return redirect()->to('/super-admin');
    }
}
