<?php

use App\Models\Tenant;
use Illuminate\Support\Facades\Route;

// 1. Landing B2B para vender la Marca Blanca SaaS de AVI-Plan a Veterinarias
Route::get('/', function () {
    return view('b2b_landing');
});

// 2. Portal B2C de Pacientes de la Clínica (ej. /v/vet-pet-patitas)
Route::get('/v/{tenant:slug}', function (Tenant $tenant) {
    $plans = $tenant->plans()->with('planBenefits.benefitDefinition')->where('is_active', true)->get();
    return view('tenant_storefront', compact('tenant', 'plans'));
})->name('tenant.storefront');

// 3. Redirección amigable al Admin de cada clínica (ej. /v/vet-pet-patitas/admin -> /admin)
Route::get('/v/{tenant:slug}/admin', function (Tenant $tenant) {
    session(['current_tenant_id' => $tenant->id]);
    return redirect('/admin/login');
})->name('tenant.admin.redirect');
