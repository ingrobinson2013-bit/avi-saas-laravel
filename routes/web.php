<?php

use App\Models\Tenant;
use Illuminate\Support\Facades\Route;

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

// Helper de acceso Admin Multi-Tenant / Autenticación Obligatoria
$checkAdminAccess = function (?string $slug = null) use ($resolveTenantFromHost) {
    // Si viene parámetro explícito de demo para demostraciones comerciales
    if (request('demo') === '1' || session('admin_demo')) {
        session(['admin_demo' => true]);
        return true;
    }
    // Si el usuario está autenticado en el sistema
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->role === 'super_admin') {
            return true;
        }
        $targetSlug = $slug ?: $resolveTenantFromHost()?->slug;
        if ($user->tenant && $targetSlug && $user->tenant->slug === $targetSlug) {
            return true;
        }
    }
    return false;
};

// Helper de redirección al Login de Marca Blanca de la Clínica
$redirectToLogin = function (?string $slug = null) use ($resolveTenantFromHost) {
    $tenantHost = $resolveTenantFromHost();
    $loginUrl = $tenantHost ? '/admin/login' : ($slug ? "/admin/{$slug}/login" : '/admin/login');
    if (request()->expectsJson()) {
        return response()->json(['error' => 'Unauthenticated', 'login_url' => $loginUrl], 401);
    }
    session(['url.intended' => request()->fullUrl()]);
    return redirect($loginUrl);
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

// 2. Panel Administrativo / Dashboard de la Clínica
Route::get('/admin', function () use ($resolveTenantFromHost, $checkAdminAccess, $redirectToLogin) {
    $tenantHost = $resolveTenantFromHost();

    // Caso A: La petición proviene del subdominio o dominio propio de la clínica
    if ($tenantHost) {
        if (!$checkAdminAccess($tenantHost->slug)) {
            return $redirectToLogin($tenantHost->slug);
        }
        return app(App\Http\Controllers\VetAdmin\DashboardController::class)->index(request(), $tenantHost->slug);
    }

    // Caso B: La petición proviene del dominio central (avipetapp.com)
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->role === 'super_admin') {
            $tenant = Tenant::where('slug', 'vet-pet-patitas')->first() ?? Tenant::first();
            return redirect('/admin/' . ($tenant?->slug ?? 'vet-pet-patitas'));
        }
        if ($user->tenant) {
            $baseDomain = env('APP_BASE_DOMAIN', 'avipetapp.com');
            return redirect("https://{$user->tenant->slug}.{$baseDomain}/admin");
        }
    }

    return redirect('/admin/login');
});

// Rutas de Login / Autenticación de Marca Blanca
Route::get('/admin/login', [App\Http\Controllers\ClinicAuthController::class, 'showLoginForm']);
Route::post('/admin/login', [App\Http\Controllers\ClinicAuthController::class, 'login']);

Route::get('/admin/{slug}/login', function (string $slug) use ($resolveTenantFromHost) {
    $tenantHost = $resolveTenantFromHost();
    if ($tenantHost && $slug === $tenantHost->slug) {
        return redirect('/admin/login', 301);
    }
    return app(App\Http\Controllers\ClinicAuthController::class)->showLoginForm(request(), $slug);
});
Route::post('/admin/{slug}/login', [App\Http\Controllers\ClinicAuthController::class, 'login']);

// 2.0 Rutas de Salida / Logout
Route::match(['get', 'post'], '/logout', [App\Http\Controllers\ClinicAuthController::class, 'logout'])->name('logout');
Route::match(['get', 'post'], '/admin/logout', [App\Http\Controllers\ClinicAuthController::class, 'logout']);
Route::match(['get', 'post'], '/admin/{slug}/logout', function (string $slug) use ($resolveTenantFromHost) {
    $tenantHost = $resolveTenantFromHost();
    if ($tenantHost && $slug === $tenantHost->slug) {
        return app(App\Http\Controllers\ClinicAuthController::class)->logout(request());
    }
    return app(App\Http\Controllers\ClinicAuthController::class)->logout(request(), $slug);
});

// 2.1 Dashboard React + TypeScript + Inertia.js (Paradigma B: Monolito Moderno)
Route::get('/admin/{slug}', function (string $slug) use ($checkAdminAccess, $resolveTenantFromHost, $redirectToLogin) {
    if ($slug === 'login') {
        return app(App\Http\Controllers\ClinicAuthController::class)->showLoginForm(request());
    }
    if ($slug === 'logout') {
        return app(App\Http\Controllers\ClinicAuthController::class)->logout(request());
    }

    $tenantHost = $resolveTenantFromHost();
    // Si ya estamos en el subdominio de la clínica y el slug coincide, redirigir limpiamente a /admin
    if ($tenantHost && $slug === $tenantHost->slug) {
        $query = request()->getQueryString();
        return redirect('/admin' . ($query ? '?' . $query : ''), 301);
    }

    // Atajos directos a módulos si alguien entra a /admin/pets en lugar de /admin/{slug}/pets
    $knownSections = ['pets', 'customers', 'plans', 'subscriptions', 'counter-redeem', 'historial-canjes', 'benefit-definitions', 'clinic-settings', 'inteligencia', 'citas', 'logistica', 'renovar-saas'];
    if (in_array($slug, $knownSections)) {
        $tenant = $tenantHost ?? auth()->user()?->tenant ?? Tenant::where('slug', 'vet-pet-patitas')->first() ?? Tenant::first();
        if ($tenant) {
            $query = request()->getQueryString();
            return redirect('/admin/' . $tenant->slug . '/' . $slug . ($query ? '?' . $query : ''));
        }
    }

    if (!Tenant::where('slug', $slug)->exists()) {
        abort(404, "La clínica veterinaria '{$slug}' no existe o fue eliminada.");
    }

    if (!$checkAdminAccess($slug)) {
        return $redirectToLogin($slug);
    }
    return app(App\Http\Controllers\VetAdmin\DashboardController::class)->index(request(), $slug);
});

Route::post('/admin/{slug}/ai/chat', [App\Http\Controllers\VetAdmin\AiAssistantController::class, 'chat'])->middleware('throttle:ai-chat');

// 2.2 Módulos Completos de Gestión Clínica conectados a la Base de Datos (Inertia + React)
Route::get('/admin/{slug}/pets', function (string $slug) use ($checkAdminAccess, $redirectToLogin) {
    if (!$checkAdminAccess($slug)) return $redirectToLogin($slug);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->pets(request(), $slug);
});

Route::post('/admin/{slug}/pets/{id}/photo', function (string $slug, string $id) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return response()->json(['error' => 'Unauthorized'], 401);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->updatePetPhoto(request(), $slug, $id);
});

Route::get('/admin/{slug}/customers', function (string $slug) use ($checkAdminAccess, $redirectToLogin) {
    if (!$checkAdminAccess($slug)) return $redirectToLogin($slug);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->customers(request(), $slug);
});

Route::get('/admin/{slug}/plans', function (string $slug) use ($checkAdminAccess, $redirectToLogin) {
    if (!$checkAdminAccess($slug)) return $redirectToLogin($slug);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->plans(request(), $slug);
});

Route::get('/admin/{slug}/plans/create', function (string $slug) use ($checkAdminAccess, $redirectToLogin) {
    if (!$checkAdminAccess($slug)) return $redirectToLogin($slug);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->planCreate(request(), $slug);
});

Route::get('/admin/{slug}/subscriptions', function (string $slug) use ($checkAdminAccess, $redirectToLogin) {
    if (!$checkAdminAccess($slug)) return $redirectToLogin($slug);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->subscriptions(request(), $slug);
});

Route::get('/admin/{slug}/subscriptions/create', function (string $slug) {
    return redirect("/admin/{$slug}/plans");
});

Route::get('/admin/{slug}/counter-redeem', function (string $slug) use ($checkAdminAccess, $redirectToLogin) {
    if (!$checkAdminAccess($slug)) return $redirectToLogin($slug);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->counterRedeem(request(), $slug);
});

Route::get('/admin/{slug}/historial-canjes', function (string $slug) use ($checkAdminAccess, $redirectToLogin) {
    if (!$checkAdminAccess($slug)) return $redirectToLogin($slug);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->redemptionHistory(request(), $slug);
});

Route::get('/admin/{slug}/benefit-definitions', function (string $slug) use ($checkAdminAccess, $redirectToLogin) {
    if (!$checkAdminAccess($slug)) return $redirectToLogin($slug);
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

Route::get('/admin/{slug}/clinic-settings', function (string $slug) use ($checkAdminAccess, $redirectToLogin) {
    if (!$checkAdminAccess($slug)) return $redirectToLogin($slug);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->settings(request(), $slug);
});

Route::post('/admin/{slug}/clinic-settings', function (string $slug) use ($checkAdminAccess, $redirectToLogin) {
    if (!$checkAdminAccess($slug)) return $redirectToLogin($slug);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->updateSettings(request(), $slug);
});

Route::get('/admin/{slug}/inteligencia', function (string $slug) use ($checkAdminAccess, $redirectToLogin) {
    if (!$checkAdminAccess($slug)) return $redirectToLogin($slug);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->intelligence(request(), $slug);
});

Route::post('/admin/{slug}/ai/triage', function (string $slug) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return response()->json(['error' => 'Unauthorized'], 401);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->runTriage(request(), $slug);
});


Route::get('/admin/{slug}/logistica', function (string $slug) use ($checkAdminAccess, $redirectToLogin) {
    if (!$checkAdminAccess($slug)) return $redirectToLogin($slug);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->logistics(request(), $slug);
});

// 2.3 Módulo de Citas Médicas & Sincronización con Google Calendar
Route::get('/admin/{slug}/citas', function (string $slug) use ($checkAdminAccess, $redirectToLogin) {
    if (!$checkAdminAccess($slug)) return $redirectToLogin($slug);
    return app(App\Http\Controllers\VetAdmin\AppointmentController::class)->index(request(), $slug);
});
Route::post('/admin/{slug}/citas', function (string $slug) use ($checkAdminAccess, $redirectToLogin) {
    if (!$checkAdminAccess($slug)) return $redirectToLogin($slug);
    return app(App\Http\Controllers\VetAdmin\AppointmentController::class)->store(request(), $slug);
});
Route::put('/admin/{slug}/citas/{id}/status', function (string $slug, string $id) use ($checkAdminAccess, $redirectToLogin) {
    if (!$checkAdminAccess($slug)) return $redirectToLogin($slug);
    return app(App\Http\Controllers\VetAdmin\AppointmentController::class)->updateStatus(request(), $slug, $id);
});
Route::get('/admin/{slug}/citas/disponibilidad', function (string $slug) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return response()->json(['error' => 'Unauthorized'], 401);
    return app(App\Http\Controllers\VetAdmin\AppointmentController::class)->availableSlots(request(), $slug);
});

// Aliases amigables hacia los módulos conectados a la base de datos
Route::get('/admin/{slug}/canje-mostrador', fn(string $slug) => redirect("/admin/{$slug}/counter-redeem"));
Route::get('/admin/{slug}/configuracion-clinica', fn(string $slug) => redirect("/admin/{$slug}/clinic-settings"));
Route::get('/admin/{slug}/servicios', fn(string $slug) => redirect("/admin/{$slug}/benefit-definitions"));
Route::get('/admin/{slug}/ai', fn(string $slug) => redirect("/admin/{$slug}/inteligencia"));
Route::get('/admin/{slug}/recepcion', fn(string $slug) => redirect("/admin/{$slug}/counter-redeem"));
Route::get('/admin/{slug}/reportes', fn(string $slug) => redirect("/admin/{$slug}/subscriptions"));
Route::get('/admin/{slug}/despachos', fn(string $slug) => redirect("/admin/{$slug}/logistica"));
Route::get('/admin/{slug}/envios', fn(string $slug) => redirect("/admin/{$slug}/logistica"));
Route::get('/admin/{slug}/agenda', fn(string $slug) => redirect("/admin/{$slug}/citas"));
Route::get('/admin/{slug}/calendar', fn(string $slug) => redirect("/admin/{$slug}/citas"));
Route::get('/admin/{slug}/historial', fn(string $slug) => redirect("/admin/{$slug}/historial-canjes"));
Route::get('/admin/{slug}/canjes', fn(string $slug) => redirect("/admin/{$slug}/historial-canjes"));
Route::get('/admin/{slug}/historial-canje', fn(string $slug) => redirect("/admin/{$slug}/historial-canjes"));

// 3. Acceso amigable por Slug al Admin de la clínica (ej. /v/vet-pet-patitas/admin -> /admin/vet-pet-patitas)
Route::get('/v/{slug}/admin/{section?}', function (string $slug, ?string $section = null) {
    $tenant = Tenant::where('slug', $slug)->firstOrFail();
    $target = '/admin/' . $tenant->slug . ($section ? '/' . $section : '');
    $query = request()->getQueryString();
    return redirect($target . ($query ? '?' . $query : ''));
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

// 10. Impersonation de Clínicas y Accesos Directos (SuperAdmin Central)
Route::redirect('/superadmin', '/super-admin');
Route::redirect('/superadmin/login', '/super-admin/login');
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







