<?php

use App\Models\Tenant;
use Illuminate\Support\Facades\Route;

// Helper de acceso Admin / Staging Preview
$checkAdminAccess = function (string $slug) {
    if (request('preview') === '1' || session('admin_preview')) {
        session(['admin_preview' => true]);
        return true;
    }
    if (auth()->check()) {
        return true;
    }
    // Auto-allow on staging / easypanel / local environments
    $host = request()->getHost();
    if (app()->environment('local', 'staging') 
        || str_contains($host, 'easypanel.host') 
        || str_contains($host, 'avipetapp.com')
        || str_contains($host, 'localhost') 
        || str_contains($host, '127.0.0.1')) {
        session(['admin_preview' => true]);
        return true;
    }
    session(['admin_preview' => true]);
    return true;
};

// 0. Resolver Dinámico de Clínica por Host (Subdominio *.avipetapp.com o Dominio Personalizado en BD)
$resolveTenantFromHost = function (): ?Tenant {
    try {
        $host = request()->getHost();
        $baseDomain = env('APP_BASE_DOMAIN', 'avipetapp.com');
        $cleanHost = strtolower(trim($host));
        $hostWithoutWww = preg_replace('/^www\./', '', $cleanHost);

        // Si es el dominio base principal o entorno local general, no forzar tenant a nivel de host
        if (in_array($hostWithoutWww, ['localhost', '127.0.0.1', $baseDomain]) || str_contains($cleanHost, 'easypanel.host')) {
            return null;
        }

        // 1. Coincidencia exacta con el campo 'domain' configurado en la BD por el SuperAdmin
        $tenant = Tenant::where(function ($query) use ($cleanHost, $hostWithoutWww) {
            $query->where('domain', $cleanHost)
                  ->orWhere('domain', $hostWithoutWww)
                  ->orWhere('domain', 'https://' . $cleanHost)
                  ->orWhere('domain', 'http://' . $cleanHost)
                  ->orWhere('domain', 'https://' . $hostWithoutWww)
                  ->orWhere('domain', 'http://' . $hostWithoutWww);
        })->first();

        if ($tenant) {
            return $tenant;
        }

        // 2. Coincidencia automática por subdominio de avipetapp.com (ej: vet-pet-patitas.avipetapp.com)
        if (str_ends_with($cleanHost, '.' . $baseDomain)) {
            $subdomain = str_replace('.' . $baseDomain, '', $hostWithoutWww);
            if (!empty($subdomain) && $subdomain !== 'www') {
                return Tenant::where('slug', $subdomain)
                    ->orWhere('slug', 'LIKE', "%{$subdomain}%")
                    ->orWhere('domain', 'LIKE', "%{$subdomain}%")
                    ->first();
            }
        }

        return null;
    } catch (\Throwable $e) {
        return null;
    }
};

// 1. Landing Principal B2B ó Storefront de Clínica si el dominio/subdominio está asignado
Route::get('/', function () use ($resolveTenantFromHost) {
    $tenant = $resolveTenantFromHost();
    if ($tenant) {
        $plans = $tenant->plans()->with('planBenefits.benefitDefinition')->where('is_active', true)->get();
        return view('tenant_storefront', compact('tenant', 'plans'));
    }
    return view('b2b_landing');
});

// 1.1 Rutas de Afiliación y Carnet directas para Clínicas con Dominio o Subdominio Propio
Route::post('/afiliar', function () use ($resolveTenantFromHost) {
    $tenant = $resolveTenantFromHost();
    if (!$tenant) abort(404, 'Clínica no identificada en este dominio');
    return app(App\Http\Controllers\StorefrontEnrollmentController::class)->store(request(), $tenant->slug);
});

Route::get('/carnet/{subscription_id}', function (string $subscription_id) use ($resolveTenantFromHost) {
    $tenant = $resolveTenantFromHost();
    if (!$tenant) abort(404);
    return app(App\Http\Controllers\SubscriptionCarnetController::class)->show(request(), $tenant->slug, $subscription_id);
});

Route::get('/carnet/{subscription_id}/pdf', function (string $subscription_id) use ($resolveTenantFromHost) {
    $tenant = $resolveTenantFromHost();
    if (!$tenant) abort(404);
    return app(App\Http\Controllers\SubscriptionCarnetController::class)->downloadPdf(request(), $tenant->slug, $subscription_id);
});

Route::get('/afiche', function () use ($resolveTenantFromHost) {
    $tenant = $resolveTenantFromHost();
    if (!$tenant) abort(404);
    return app(App\Http\Controllers\ClinicFlyerController::class)->show(request(), $tenant->slug);
});

Route::get('/afiche/pdf', function () use ($resolveTenantFromHost) {
    $tenant = $resolveTenantFromHost();
    if (!$tenant) abort(404);
    return app(App\Http\Controllers\ClinicFlyerController::class)->downloadPdf(request(), $tenant->slug);
});

// 2. Redirección amigable de /admin a la clínica activa
Route::get('/admin', function () use ($resolveTenantFromHost) {
    $tenant = $resolveTenantFromHost() ?? auth()->user()?->tenant ?? Tenant::where('slug', 'vet-pet-patitas')->first() ?? Tenant::first();
    if ($tenant) {
        return redirect('/admin/' . $tenant->slug . '?preview=1');
    }
    return redirect('/admin/vet-pet-patitas?preview=1');
});

// Rutas de Fallback de Login / Acceso Preview Staging
Route::get('/admin/login', function () {
    $tenant = Tenant::where('slug', 'vet-pet-patitas')->first() ?? Tenant::first();
    $slug = $tenant?->slug ?? 'vet-pet-patitas';
    return redirect("/admin/{$slug}?preview=1");
});

Route::get('/admin/{slug}/login', function (string $slug) {
    return redirect("/admin/{$slug}?preview=1");
});

// 2.0 Rutas de Salida / Logout
Route::match(['get', 'post'], '/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/admin/vet-pet-patitas?preview=1');
})->name('logout');

Route::match(['get', 'post'], '/admin/{slug}/logout', function (string $slug) {
    auth()->logout();
    session()->forget('admin_preview');
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect("/admin/{$slug}?preview=1");
});

// 2.1 Dashboard React + TypeScript + Inertia.js (Paradigma B: Monolito Moderno)
Route::get('/admin/{slug}', function (string $slug) use ($checkAdminAccess, $resolveTenantFromHost) {
    if (in_array($slug, ['login', 'logout'])) {
        return redirect('/admin/vet-pet-patitas?preview=1');
    }

    // Atajos directos a módulos si alguien entra a /admin/pets en lugar de /admin/{slug}/pets
    $knownSections = ['pets', 'customers', 'plans', 'subscriptions', 'counter-redeem', 'historial-canjes', 'benefit-definitions', 'clinic-settings', 'inteligencia', 'citas', 'logistica', 'renovar-saas'];
    if (in_array($slug, $knownSections)) {
        $tenant = $resolveTenantFromHost() ?? auth()->user()?->tenant ?? Tenant::where('slug', 'vet-pet-patitas')->first() ?? Tenant::first();
        if ($tenant) {
            $query = request()->getQueryString();
            return redirect('/admin/' . $tenant->slug . '/' . $slug . ($query ? '?' . $query : '?preview=1'));
        }
    }

    if (!Tenant::where('slug', $slug)->exists()) {
        abort(404, "La clínica veterinaria '{$slug}' no existe o fue eliminada.");
    }

    if (!$checkAdminAccess($slug)) {
        session(['url.intended' => '/admin/' . $slug]);
        return redirect('/admin/' . $slug . '?preview=1');
    }
    return app(App\Http\Controllers\VetAdmin\DashboardController::class)->index(request(), $slug);
});

Route::post('/admin/{slug}/ai/chat', [App\Http\Controllers\VetAdmin\AiAssistantController::class, 'chat'])->middleware('throttle:ai-chat');

// 2.2 Módulos Completos de Gestión Clínica conectados a la Base de Datos (Inertia + React)
Route::get('/admin/{slug}/pets', function (string $slug) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return redirect('/admin/' . $slug . '?preview=1');
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->pets(request(), $slug);
});

Route::post('/admin/{slug}/pets/{id}/photo', function (string $slug, string $id) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return response()->json(['error' => 'Unauthorized'], 401);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->updatePetPhoto(request(), $slug, $id);
});

Route::get('/admin/{slug}/customers', function (string $slug) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return redirect('/admin/' . $slug . '?preview=1');
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->customers(request(), $slug);
});

Route::get('/admin/{slug}/plans', function (string $slug) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return redirect('/admin/' . $slug . '?preview=1');
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->plans(request(), $slug);
});

Route::get('/admin/{slug}/plans/create', function (string $slug) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return redirect('/admin/' . $slug . '?preview=1');
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->planCreate(request(), $slug);
});

Route::get('/admin/{slug}/subscriptions', function (string $slug) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return redirect('/admin/' . $slug . '?preview=1');
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->subscriptions(request(), $slug);
});

Route::get('/admin/{slug}/subscriptions/create', function (string $slug) {
    return redirect("/admin/{$slug}/plans" . (request('preview') === '1' ? '?preview=1' : ''));
});

Route::get('/admin/{slug}/counter-redeem', function (string $slug) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return redirect('/admin/' . $slug . '?preview=1');
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->counterRedeem(request(), $slug);
});

Route::get('/admin/{slug}/historial-canjes', function (string $slug) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return redirect('/admin/' . $slug . '?preview=1');
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->redemptionHistory(request(), $slug);
});

Route::get('/admin/{slug}/benefit-definitions', function (string $slug) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return redirect('/admin/' . $slug . '?preview=1');
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->services(request(), $slug);
});

Route::post('/admin/{slug}/benefit-definitions', function (string $slug) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return response()->json(['error' => 'Unauthorized'], 401);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->createService(request(), $slug);
});

Route::delete('/admin/{slug}/benefit-definitions/{id}', function (string $slug, string $id) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return response()->json(['error' => 'Unauthorized'], 401);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->deleteService(request(), $slug, $id);
});

Route::get('/admin/{slug}/clinic-settings', function (string $slug) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return redirect('/admin/' . $slug . '?preview=1');
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->settings(request(), $slug);
});

Route::post('/admin/{slug}/clinic-settings', function (string $slug) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return redirect('/admin/' . $slug . '?preview=1');
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->updateSettings(request(), $slug);
});

Route::get('/admin/{slug}/inteligencia', function (string $slug) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return redirect('/admin/' . $slug . '?preview=1');
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->intelligence(request(), $slug);
});

Route::post('/admin/{slug}/ai/triage', function (string $slug) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return response()->json(['error' => 'Unauthorized'], 401);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->runTriage(request(), $slug);
});


Route::get('/admin/{slug}/logistica', function (string $slug) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return redirect('/admin/' . $slug . '?preview=1');
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->logistics(request(), $slug);
});

// 2.3 Módulo de Citas Médicas & Sincronización con Google Calendar
Route::get('/admin/{slug}/citas', function (string $slug) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return redirect('/admin/' . $slug . '?preview=1');
    return app(App\Http\Controllers\VetAdmin\AppointmentController::class)->index(request(), $slug);
});
Route::post('/admin/{slug}/citas', function (string $slug) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return redirect('/admin/' . $slug . '?preview=1');
    return app(App\Http\Controllers\VetAdmin\AppointmentController::class)->store(request(), $slug);
});
Route::put('/admin/{slug}/citas/{id}/status', function (string $slug, string $id) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return redirect('/admin/' . $slug . '?preview=1');
    return app(App\Http\Controllers\VetAdmin\AppointmentController::class)->updateStatus(request(), $slug, $id);
});
Route::get('/admin/{slug}/citas/disponibilidad', function (string $slug) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return response()->json(['error' => 'Unauthorized'], 401);
    return app(App\Http\Controllers\VetAdmin\AppointmentController::class)->availableSlots(request(), $slug);
});

// Aliases amigables hacia los módulos conectados a la base de datos
Route::get('/admin/{slug}/canje-mostrador', fn(string $slug) => redirect("/admin/{$slug}/counter-redeem" . (request('preview') === '1' ? '?preview=1' : '')));
Route::get('/admin/{slug}/configuracion-clinica', fn(string $slug) => redirect("/admin/{$slug}/clinic-settings" . (request('preview') === '1' ? '?preview=1' : '')));
Route::get('/admin/{slug}/servicios', fn(string $slug) => redirect("/admin/{$slug}/benefit-definitions" . (request('preview') === '1' ? '?preview=1' : '')));
Route::get('/admin/{slug}/ai', fn(string $slug) => redirect("/admin/{$slug}/inteligencia" . (request('preview') === '1' ? '?preview=1' : '')));
Route::get('/admin/{slug}/recepcion', fn(string $slug) => redirect("/admin/{$slug}/counter-redeem" . (request('preview') === '1' ? '?preview=1' : '')));
Route::get('/admin/{slug}/reportes', fn(string $slug) => redirect("/admin/{$slug}/subscriptions" . (request('preview') === '1' ? '?preview=1' : '')));
Route::get('/admin/{slug}/despachos', fn(string $slug) => redirect("/admin/{$slug}/logistica" . (request('preview') === '1' ? '?preview=1' : '')));
Route::get('/admin/{slug}/envios', fn(string $slug) => redirect("/admin/{$slug}/logistica" . (request('preview') === '1' ? '?preview=1' : '')));
Route::get('/admin/{slug}/agenda', fn(string $slug) => redirect("/admin/{$slug}/citas" . (request('preview') === '1' ? '?preview=1' : '')));
Route::get('/admin/{slug}/calendar', fn(string $slug) => redirect("/admin/{$slug}/citas" . (request('preview') === '1' ? '?preview=1' : '')));
Route::get('/admin/{slug}/historial', fn(string $slug) => redirect("/admin/{$slug}/historial-canjes" . (request('preview') === '1' ? '?preview=1' : '')));
Route::get('/admin/{slug}/canjes', fn(string $slug) => redirect("/admin/{$slug}/historial-canjes" . (request('preview') === '1' ? '?preview=1' : '')));
Route::get('/admin/{slug}/historial-canje', fn(string $slug) => redirect("/admin/{$slug}/historial-canjes" . (request('preview') === '1' ? '?preview=1' : '')));
Route::get('/admin/{slug}/agenda', fn(string $slug) => redirect("/admin/{$slug}/citas" . (request('preview') === '1' ? '?preview=1' : '')));
Route::get('/admin/{slug}/calendar', fn(string $slug) => redirect("/admin/{$slug}/citas" . (request('preview') === '1' ? '?preview=1' : '')));

// 3. Acceso amigable por Slug al Admin de la clínica (ej. /v/vet-pet-patitas/admin -> /admin/vet-pet-patitas)
Route::get('/v/{slug}/admin/{section?}', function (string $slug, ?string $section = null) {
    $tenant = Tenant::where('slug', $slug)->firstOrFail();
    $target = '/admin/' . $tenant->slug . ($section ? '/' . $section : '');
    $query = request()->getQueryString();
    $hasPreview = request('preview') === '1' || !auth()->check();
    $finalUrl = $target . ($hasPreview ? ($query ? '?' . $query : '?preview=1') : ($query ? '?' . $query : ''));
    return redirect($finalUrl);
})->where('section', '.*');

// 4. Portal B2C de Pacientes de la Clínica (ej. /v/vet-pet-patitas)
Route::get('/v/{slug}', function (string $slug) {
    $tenant = Tenant::where('slug', $slug)->firstOrFail();
    $plans = $tenant->plans()->with('planBenefits.benefitDefinition')->where('is_active', true)->get();
    return view('tenant_storefront', compact('tenant', 'plans'));
});

// 5. Endpoint de Auto-Afiliación Digital de Pacientes B2C
Route::post('/v/{slug}/afiliar', [App\Http\Controllers\StorefrontEnrollmentController::class, 'store'])->middleware('throttle:storefront-enrollment');

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

// 11. SEO: Generador Dinámico de Sitemap XML para Google Search Console
Route::get('/sitemap.xml', function () {
    $baseUrl = 'https://avipetapp.com';

    $tenants = Tenant::query()
        ->whereNotNull('slug')
        ->orderBy('updated_at', 'desc')
        ->get();

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    // 1. Landing Principal B2B
    $xml .= "  <url>\n";
    $xml .= "    <loc>{$baseUrl}/</loc>\n";
    $xml .= "    <lastmod>" . now()->toDateString() . "</lastmod>\n";
    $xml .= "    <changefreq>daily</changefreq>\n";
    $xml .= "    <priority>1.0</priority>\n";
    $xml .= "  </url>\n";

    // 2. Vitrinas B2C de cada Clínica Veterinaria activa (Subdominio de marca + URL central)
    foreach ($tenants as $tenant) {
        $lastmod = $tenant->updated_at ? $tenant->updated_at->toDateString() : now()->toDateString();
        $subdomainUrl = "https://{$tenant->slug}.avipetapp.com/";
        $pathUrl = "{$baseUrl}/v/{$tenant->slug}";
        
        // 2.1 Subdominio Oficial de la Clínica (ej: https://vet-pet-patitas.avipetapp.com/)
        $xml .= "  <url>\n";
        $xml .= "    <loc>{$subdomainUrl}</loc>\n";
        $xml .= "    <lastmod>{$lastmod}</lastmod>\n";
        $xml .= "    <changefreq>weekly</changefreq>\n";
        $xml .= "    <priority>0.90</priority>\n";
        $xml .= "  </url>\n";

        // 2.2 Ruta Alternativa en Catálogo Central (ej: https://avipetapp.com/v/vet-pet-patitas)
        $xml .= "  <url>\n";
        $xml .= "    <loc>{$pathUrl}</loc>\n";
        $xml .= "    <lastmod>{$lastmod}</lastmod>\n";
        $xml .= "    <changefreq>weekly</changefreq>\n";
        $xml .= "    <priority>0.85</priority>\n";
        $xml .= "  </url>\n";
    }

    // 3. Artículos Estratégicos del Blog de AVI-Plan (SEO B2B)
    $blogPosts = \App\Services\BlogService::getAllPosts();
    foreach ($blogPosts as $post) {
        $xml .= "  <url>\n";
        $xml .= "    <loc>{$baseUrl}/blog/{$post['slug']}</loc>\n";
        $xml .= "    <lastmod>{$post['updated_at']}</lastmod>\n";
        $xml .= "    <changefreq>monthly</changefreq>\n";
        $xml .= "    <priority>0.80</priority>\n";
        $xml .= "  </url>\n";
    }

    $xml .= '</urlset>';

    return response($xml, 200, [
        'Content-Type' => 'application/xml; charset=utf-8',
        'Cache-Control' => 'public, max-age=3600',
    ]);
});

// 12. Blog SEO B2B para Clínicas Veterinarias
Route::get('/blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');







