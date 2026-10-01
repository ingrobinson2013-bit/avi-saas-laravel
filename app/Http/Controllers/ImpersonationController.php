<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
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
        $currentUser = Auth::user();
        if (!$currentUser) {
            return redirect('/super-admin/login');
        }

        $tenant = Tenant::findOrFail($tenantId);

        // Guardar el ID del SuperAdmin en sesión si no estamos ya impersonando
        if (!session()->has('impersonator_superadmin_id')) {
            session(['impersonator_superadmin_id' => $currentUser->id]);
        }

        // Buscar un usuario de la clínica o aprovisionar uno administrador
        $tenantUser = $tenant->users()->first();
        if (!$tenantUser) {
            $tenantUser = User::create([
                'name' => "Admin {$tenant->name}",
                'email' => "admin@{$tenant->slug}.local",
                'tenant_id' => $tenant->id,
                'password' => bcrypt(Str::random(24)),
            ]);
        }

        Auth::login($tenantUser);

        return redirect("/admin/{$tenant->slug}");
    }

    /**
     * Salir del modo soporte y volver al SuperAdmin.
     */
    public function stopImpersonating()
    {
        $superAdminId = session('impersonator_superadmin_id');
        session()->forget('impersonator_superadmin_id');

        if ($superAdminId) {
            $superAdmin = User::find($superAdminId);
            if ($superAdmin) {
                Auth::login($superAdmin);
                return redirect('/super-admin/tenants');
            }
        }

        return redirect('/super-admin');
    }
}
