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

// 2.0 Rutas de Salida / Logout
Route::match(['get', 'post'], '/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/admin/login');
})->name('logout');

Route::match(['get', 'post'], '/admin/{slug}/logout', function (string $slug) {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect("/admin/{$slug}/login");
});

// 2.1 Dashboard React + TypeScript + Inertia.js (Paradigma B: Monolito Moderno)
Route::get('/admin/{slug}', function (string $slug) {
    if (in_array($slug, ['login', 'logout'])) {
        return redirect('/admin/vet-pet-patitas/login');
    }
    if (!auth()->check() && request('preview') !== '1') {
        session(['url.intended' => '/admin/' . $slug]);
        return redirect('/admin/' . $slug . '/login');
    }
    return app(App\Http\Controllers\VetAdmin\DashboardController::class)->index(request(), $slug);
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

// 7. Afiche Oficial de Mostrador con Código QR para Impresión / PDF
Route::get('/v/{slug}/afiche', [App\Http\Controllers\ClinicFlyerController::class, 'show'])->name('clinic.flyer');
Route::get('/v/{slug}/afiche/pdf', [App\Http\Controllers\ClinicFlyerController::class, 'downloadPdf'])->name('clinic.flyer.pdf');

// 8. Onboarding Express B2B en 60 Segundos (15 Días Gratis)
Route::post('/registro-clinica', [App\Http\Controllers\ClinicOnboardingController::class, 'register'])->name('clinic.register');

// 9. Pasarela B2B: Checkout Oficial Bold para Pago del Canon SaaS de Veterinarias
Route::get('/admin/{slug}/renovar-saas', [App\Http\Controllers\SaaSPaymentController::class, 'showCheckout'])->name('saas.checkout');
Route::get('/v/{slug}/renovar-saas', [App\Http\Controllers\SaaSPaymentController::class, 'showCheckout']);

// 10. Impersonation de Clínicas (Soporte 1-Clic desde SuperAdmin)
Route::get('/impersonate-clinic/{tenant_id}', [App\Http\Controllers\ImpersonationController::class, 'impersonateTenant'])->name('superadmin.impersonate');
Route::get('/impersonate-clinic-stop', [App\Http\Controllers\ImpersonationController::class, 'stopImpersonating'])->name('superadmin.stop-impersonating');






