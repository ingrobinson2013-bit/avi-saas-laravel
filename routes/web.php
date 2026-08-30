<?php

use App\Models\Tenant;
use Illuminate\Support\Facades\Route;

// 1. Landing B2B para vender la Marca Blanca SaaS de AVI-Plan a Veterinarias
Route::get('/', function () {
    return view('b2b_landing');
});

// 2. Acceso amigable por Slug al Admin de la clínica (ej. /v/vet-pet-patitas/admin -> /admin/vet-pet-patitas)
Route::get('/v/{slug}/admin/{section?}', function (string $slug, ?string $section = null) {
    $tenant = Tenant::where('slug', $slug)->firstOrFail();
    $target = '/admin/' . $tenant->slug . ($section ? '/' . $section : '');

    if (auth()->check()) {
        return redirect($target);
    }

    session(['url.intended' => $target]);
    return redirect('/admin/' . $tenant->slug . '/login');
})->where('section', '.*');

// 3. Portal B2C de Pacientes de la Clínica (ej. /v/vet-pet-patitas)
Route::get('/v/{slug}', function (string $slug) {
    $tenant = Tenant::where('slug', $slug)->firstOrFail();
    $plans = $tenant->plans()->with('planBenefits.benefitDefinition')->where('is_active', true)->get();
    return view('tenant_storefront', compact('tenant', 'plans'));
});
