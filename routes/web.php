<?php

use App\Models\Tenant;
use Illuminate\Support\Facades\Route;

// 1. Landing B2B para vender la Marca Blanca SaaS de AVI-Plan a Veterinarias
Route::get('/', function () {
    return view('b2b_landing');
});

// 2. Redirección amigable de /admin a la clínica activa
Route::get('/admin', function () {
    $tenant = auth()->user()?->tenant ?? Tenant::where('slug', 'vet-pet-patitas')->first() ?? Tenant::first();
    if ($tenant) {
        return redirect('/admin/' . $tenant->slug);
    }
    return redirect('/admin/login');
});

// 3. Acceso amigable por Slug al Admin de la clínica (ej. /v/vet-pet-patitas/admin -> /admin/vet-pet-patitas)
Route::get('/v/{slug}/admin/{section?}', function (string $slug, ?string $section = null) {
    $tenant = Tenant::where('slug', $slug)->firstOrFail();
    $target = '/admin/' . $tenant->slug . ($section ? '/' . $section : '');

    if (auth()->check()) {
        return redirect($target);
    }

    session(['url.intended' => $target]);
    return redirect('/admin/' . $tenant->slug . '/login');
})->where('section', '.*');

// 4. Portal B2C de Pacientes de la Clínica (ej. /v/vet-pet-patitas)
Route::get('/v/{slug}', function (string $slug) {
    $tenant = Tenant::where('slug', $slug)->firstOrFail();
    $plans = $tenant->plans()->with('planBenefits.benefitDefinition')->where('is_active', true)->get();
    return view('tenant_storefront', compact('tenant', 'plans'));
});

// 5. Endpoint de Auto-Afiliación Digital de Pacientes B2C
Route::post('/v/{slug}/afiliar', [App\Http\Controllers\StorefrontEnrollmentController::class, 'store']);

// 6. Carnet Digital y Certificado de Afiliación Imprimible / PDF
Route::get('/v/{slug}/carnet/{subscription_id}', [App\Http\Controllers\SubscriptionCarnetController::class, 'show'])->name('carnet.show');
Route::get('/v/{slug}/carnet/{subscription_id}/pdf', [App\Http\Controllers\SubscriptionCarnetController::class, 'downloadPdf'])->name('carnet.pdf');


