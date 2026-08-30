<?php

use App\Models\Tenant;
use Illuminate\Support\Facades\Route;

// 1. Landing B2B para vender la Marca Blanca SaaS de AVI-Plan a Veterinarias
Route::get('/', function () {
    return view('b2b_landing');
});

// 2. Acceso y navegación al Admin dedicado de cada clínica (/v/{slug}/admin y subrutas)
Route::get('/v/{slug}/admin/{section?}', function (string $slug, ?string $section = null) {
    $tenant = Tenant::where('slug', $slug)->first();
    if ($tenant) {
        session([
            'current_tenant_id' => $tenant->id,
            'current_tenant_slug' => $tenant->slug,
        ]);
    }

    $target = $section ? '/admin/' . $section : '/admin';

    if (auth()->check()) {
        return redirect($target);
    }

    // Guardar la URL de destino para que al iniciar sesión lo lleve directo
    session(['url.intended' => $target]);
    return redirect('/admin/login');
})->where('section', '.*');

// 3. Portal B2C de Pacientes de la Clínica (ej. /v/vet-pet-patitas)
Route::get('/v/{slug}', function (string $slug) {
    $tenant = Tenant::where('slug', $slug)->firstOrFail();
    $plans = $tenant->plans()->with('planBenefits.benefitDefinition')->where('is_active', true)->get();
    return view('tenant_storefront', compact('tenant', 'plans'));
});
