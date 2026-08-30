<?php

use App\Models\Tenant;
use Illuminate\Support\Facades\Route;

// 1. Landing B2B para vender la Marca Blanca SaaS de AVI-Plan a Veterinarias
Route::get('/', function () {
    return view('b2b_landing');
});

// 2. Redirección amigable al Admin de cada clínica (ej. /v/{slug}/admin -> /admin)
Route::get('/v/{slug}/admin', function (string $slug) {
    $tenant = Tenant::where('slug', $slug)->first();
    if ($tenant) {
        session(['current_tenant_id' => $tenant->id]);
    }
    return redirect('/admin/login');
});

// 3. Portal B2C de Pacientes de la Clínica (ej. /v/vet-pet-patitas)
Route::get('/v/{slug}', function (string $slug) {
    $tenant = Tenant::where('slug', $slug)->firstOrFail();
    $plans = $tenant->plans()->with('planBenefits.benefitDefinition')->where('is_active', true)->get();
    return view('tenant_storefront', compact('tenant', 'plans'));
});
