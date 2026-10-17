<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    /**
     * Acceder al panel de una clínica específica desde el SuperAdmin
     * SIN sobrescribir la identidad del SuperAdmin en Auth::user().
     */
    public function impersonateTenant(string $tenantId)
    {
        $tenant = Tenant::findOrFail($tenantId);
        $currentUser = Auth::user();

        // Si el usuario actual no es super_admin (ej. quedó logueado como doctor en sesión previa), restaurar SuperAdmin
        if (!$currentUser || $currentUser->role !== 'super_admin') {
            $superAdmin = User::where('role', 'super_admin')
                ->orWhere('email', 'contacto@avipetapp.com')
                ->first();

            if ($superAdmin) {
                Auth::guard('web')->login($superAdmin, true);
                $currentUser = $superAdmin;
            }
        }

        if ($currentUser) {
            session(['impersonator_superadmin_id' => $currentUser->id]);
        }

        session([
            'current_tenant_id' => $tenant->id,
            'current_tenant_slug' => $tenant->slug,
        ]);

        return redirect()->to("/admin/{$tenant->slug}");
    }

    /**
     * Salir del modo soporte de clínica y volver al SuperAdmin.
     */
    public function stopImpersonating()
    {
        $superAdminId = session('impersonator_superadmin_id');
        session()->forget(['impersonator_superadmin_id', 'current_tenant_id', 'current_tenant_slug']);

        $superAdmin = $superAdminId
            ? User::find($superAdminId)
            : User::where('role', 'super_admin')->orWhere('email', 'contacto@avipetapp.com')->first();

        if ($superAdmin && (!Auth::check() || Auth::id() !== $superAdmin->id)) {
            Auth::guard('web')->login($superAdmin, true);
            session()->regenerate();
        }

        return redirect()->to('/super-admin/tenants');
    }
}
