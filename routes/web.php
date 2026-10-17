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
        $selectedTheme = request('theme') ?: ($tenant->branding['storefront_theme'] ?? 'classic');
        if ($selectedTheme === 'modern') {
            return view('tenant_storefront_modern', compact('tenant', 'plans'));
        }
        return view('tenant_storefront', compact('tenant', 'plans'));
    }
    return \Inertia\Inertia::render('Landing/B2BLanding');
});

// 1.0.1 Favicon First-Party Dinámico en el mismo Subdominio para Google Search (Google-Favicon)
Route::get('/clinic-favicon.webp', function () use ($resolveTenantFromHost) {
    $tenant = $resolveTenantFromHost();
    $slug = request('slug') ?: $tenant?->slug;
    if (!$tenant && $slug) {
        $tenant = Tenant::where('slug', $slug)->first();
    }

    if ($tenant && $tenant->slug === 'vet-pet-patitas' && file_exists(public_path('images/tenants/vet-pet-patitas-logo.webp'))) {
        return response()->file(public_path('images/tenants/vet-pet-patitas-logo.webp'), [
            'Content-Type' => 'image/webp',
            'Cache-Control' => 'public, max-age=2592000',
        ]);
    }

    $logoUrl = $tenant?->branding['logo_url'] ?? null;
    if ($logoUrl && str_starts_with($logoUrl, 'http')) {
        try {
            $imageContent = @file_get_contents($logoUrl);
            if ($imageContent !== false) {
                $mime = str_ends_with(strtolower($logoUrl), '.png') ? 'image/png' : 'image/webp';
                return response($imageContent, 200, [
                    'Content-Type' => $mime,
                    'Cache-Control' => 'public, max-age=2592000',
                ]);
            }
        } catch (\Throwable $e) {}
    }

    return response()->file(public_path('favicon.png'), [
        'Content-Type' => 'image/png',
        'Cache-Control' => 'public, max-age=86400',
    ]);
});

// 1.1 Rutas de Afiliación y Carnet directas para Clínicas con Dominio o Subdominio Propio
Route::post('/afiliar', function () use ($resolveTenantFromHost) {
    $tenant = $resolveTenantFromHost();
    if (!$tenant) abort(404, 'Clínica no identificada en este dominio');
    return app(App\Http\Controllers\StorefrontEnrollmentController::class)->store(request(), $tenant->slug);
});

Route::get('/carnet/{subscription_id}', function (string $subscription_id) use ($resolveTenantFromHost) {
    $tenant = $resolveTenantFromHost() ?? Tenant::where('slug', 'vet-pet-patitas')->first() ?? Tenant::first();
    $slug = $tenant?->slug ?? 'vet-pet-patitas';
    return app(App\Http\Controllers\SubscriptionCarnetController::class)->show($slug, $subscription_id);
});

Route::get('/carnet/{subscription_id}/pdf', function (string $subscription_id) use ($resolveTenantFromHost) {
    $tenant = $resolveTenantFromHost() ?? Tenant::where('slug', 'vet-pet-patitas')->first() ?? Tenant::first();
    $slug = $tenant?->slug ?? 'vet-pet-patitas';
    return app(App\Http\Controllers\SubscriptionCarnetController::class)->downloadPdf($slug, $subscription_id);
});

Route::get('/afiche', function () use ($resolveTenantFromHost) {
    $tenant = $resolveTenantFromHost();
    if (!$tenant) abort(404);
    return app(App\Http\Controllers\ClinicFlyerController::class)->show($tenant->slug);
});

Route::get('/afiche/pdf', function () use ($resolveTenantFromHost) {
    $tenant = $resolveTenantFromHost();
    if (!$tenant) abort(404);
    return app(App\Http\Controllers\ClinicFlyerController::class)->downloadPdf($tenant->slug);
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
    $knownSections = ['pets', 'customers', 'plans', 'subscriptions', 'counter-redeem', 'historial-canjes', 'benefit-definitions', 'clinic-settings', 'inteligencia', 'citas', 'logistica', 'renovar-saas', 'reportes', 'metricas', 'crecimiento'];
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

Route::post('/admin/{slug}/plans', function (string $slug) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return response()->json(['error' => 'Unauthorized'], 401);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->storePlan(request(), $slug);
});

Route::post('/admin/{slug}/plans/{id}/toggle', function (string $slug, string $id) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return response()->json(['error' => 'Unauthorized'], 401);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->togglePlan(request(), $slug, $id);
});

Route::delete('/admin/{slug}/plans/{id}', function (string $slug, string $id) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return response()->json(['error' => 'Unauthorized'], 401);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->destroyPlan(request(), $slug, $id);
});

Route::get('/admin/{slug}/plans/create', function (string $slug) use ($checkAdminAccess, $redirectToLogin) {
    if (!$checkAdminAccess($slug)) return $redirectToLogin($slug);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->planCreate(request(), $slug);
});

Route::get('/admin/{slug}/subscriptions', function (string $slug) use ($checkAdminAccess, $redirectToLogin) {
    if (!$checkAdminAccess($slug)) return $redirectToLogin($slug);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->subscriptions(request(), $slug);
});

Route::post('/admin/{slug}/subscriptions/{id}/approve-payment', function (string $slug, string $id) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return response()->json(['error' => 'Unauthorized'], 401);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->approveSubscriptionPayment(request(), $slug, $id);
});

Route::post('/admin/{slug}/subscriptions/{id}/send-reminder', function (string $slug, string $id) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return response()->json(['error' => 'Unauthorized'], 401);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->sendRenewalReminder(request(), $slug, $id);
});

Route::post('/admin/{slug}/subscriptions/{id}/send-preventive', function (string $slug, string $id) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return response()->json(['error' => 'Unauthorized'], 401);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->sendPreventiveReminder(request(), $slug, $id);
});

Route::get('/v/{slug}/pagar/{contract_id}', function (string $slug, string $contract_id) {
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->redirectToB2CPayment(request(), $slug, $contract_id);
});

Route::get('/pagar/{contract_id}', function (string $contract_id) use ($resolveTenantFromHost) {
    $tenant = $resolveTenantFromHost();
    if (!$tenant) abort(404);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->redirectToB2CPayment(request(), $tenant->slug, $contract_id);
});

Route::get('/admin/{slug}/subscriptions/create', function (string $slug) {
    return redirect("/admin/{$slug}/plans");
});

// Rutas directas para Mostrador / Counter Redeem (Tanto con Slug como directo en Subdominio)
Route::get('/admin/counter-redeem', function () use ($resolveTenantFromHost, $checkAdminAccess, $redirectToLogin) {
    $tenant = $resolveTenantFromHost() ?? auth()->user()?->tenant ?? Tenant::where('slug', 'vet-pet-patitas')->first();
    if (!$tenant) return redirect('/admin/login');
    if (!$checkAdminAccess($tenant->slug)) return $redirectToLogin($tenant->slug);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->counterRedeem(request(), $tenant->slug);
});

Route::post('/admin/counter-redeem', function () use ($resolveTenantFromHost, $checkAdminAccess) {
    $tenant = $resolveTenantFromHost() ?? auth()->user()?->tenant ?? Tenant::where('slug', 'vet-pet-patitas')->first();
    if (!$tenant || !$checkAdminAccess($tenant->slug)) return response()->json(['error' => 'Unauthorized'], 401);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->storeCounterRedeem(request(), $tenant->slug);
});

Route::post('/admin/plans', function () use ($resolveTenantFromHost, $checkAdminAccess) {
    $tenant = $resolveTenantFromHost() ?? auth()->user()?->tenant ?? Tenant::where('slug', 'vet-pet-patitas')->first();
    if (!$tenant || !$checkAdminAccess($tenant->slug)) return response()->json(['error' => 'Unauthorized'], 401);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->storePlan(request(), $tenant->slug);
});

Route::get('/admin/{slug}/counter-redeem', function (string $slug) use ($checkAdminAccess, $redirectToLogin) {
    if (!$checkAdminAccess($slug)) return $redirectToLogin($slug);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->counterRedeem(request(), $slug);
});

Route::post('/admin/{slug}/counter-redeem', function (string $slug) use ($checkAdminAccess) {
    if (!$checkAdminAccess($slug)) return response()->json(['error' => 'Unauthorized'], 401);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->storeCounterRedeem(request(), $slug);
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

// 2.2.1 Módulo de Reportes Clínicos y Financieros (Métricas & Crecimiento)
Route::get('/admin/{slug}/reportes/metricas', function (string $slug) use ($checkAdminAccess, $redirectToLogin) {
    if (!$checkAdminAccess($slug)) return $redirectToLogin($slug);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->metrics(request(), $slug);
});

Route::get('/admin/{slug}/reportes/crecimiento', function (string $slug) use ($checkAdminAccess, $redirectToLogin) {
    if (!$checkAdminAccess($slug)) return $redirectToLogin($slug);
    return app(App\Http\Controllers\VetAdmin\VetPagesController::class)->growth(request(), $slug);
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
Route::post('/admin/{slug}/citas/google/connect', function (string $slug) use ($checkAdminAccess, $redirectToLogin) {
    if (!$checkAdminAccess($slug)) return $redirectToLogin($slug);
    return app(App\Http\Controllers\VetAdmin\AppointmentController::class)->connectGoogle(request(), $slug);
});
Route::post('/admin/{slug}/citas/google/disconnect', function (string $slug) use ($checkAdminAccess, $redirectToLogin) {
    if (!$checkAdminAccess($slug)) return $redirectToLogin($slug);
    return app(App\Http\Controllers\VetAdmin\AppointmentController::class)->disconnectGoogle(request(), $slug);
});
Route::post('/admin/{slug}/citas/google/sync-all', function (string $slug) use ($checkAdminAccess, $redirectToLogin) {
    if (!$checkAdminAccess($slug)) return $redirectToLogin($slug);
    return app(App\Http\Controllers\VetAdmin\AppointmentController::class)->syncAllGoogle(request(), $slug);
});

// Aliases amigables hacia los módulos conectados a la base de datos
Route::get('/admin/{slug}/canje-mostrador', fn(string $slug) => redirect("/admin/{$slug}/counter-redeem"));
Route::get('/admin/{slug}/configuracion-clinica', fn(string $slug) => redirect("/admin/{$slug}/clinic-settings"));
Route::get('/admin/{slug}/servicios', fn(string $slug) => redirect("/admin/{$slug}/benefit-definitions"));
Route::get('/admin/{slug}/ai', fn(string $slug) => redirect("/admin/{$slug}/inteligencia"));
Route::get('/admin/{slug}/recepcion', fn(string $slug) => redirect("/admin/{$slug}/counter-redeem"));
Route::get('/admin/{slug}/reportes', fn(string $slug) => redirect("/admin/{$slug}/reportes/metricas"));
Route::get('/admin/{slug}/metricas', fn(string $slug) => redirect("/admin/{$slug}/reportes/metricas"));
Route::get('/admin/{slug}/crecimiento', fn(string $slug) => redirect("/admin/{$slug}/reportes/crecimiento"));
Route::get('/admin/{slug}/reports/metrics', fn(string $slug) => redirect("/admin/{$slug}/reportes/metricas"));
Route::get('/admin/{slug}/reports/growth', fn(string $slug) => redirect("/admin/{$slug}/reportes/crecimiento"));
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
Route::get('/v/{slug}', function (string $slug) use ($resolveTenantFromHost) {
    $tenantHost = $resolveTenantFromHost();
    if ($tenantHost && $tenantHost->slug === $slug) {
        return redirect('/');
    }

    $tenant = Tenant::where('slug', $slug)->firstOrFail();
    $plans = $tenant->plans()->with('planBenefits.benefitDefinition')->where('is_active', true)->get();
    $selectedTheme = request('theme') ?: ($tenant->branding['storefront_theme'] ?? 'classic');
    if ($selectedTheme === 'modern') {
        return view('tenant_storefront_modern', compact('tenant', 'plans'));
    }
    return view('tenant_storefront', compact('tenant', 'plans'));
});

// 5. Endpoint de Auto-Afiliación Digital de Pacientes B2C
Route::post('/v/{slug}/afiliar', [App\Http\Controllers\StorefrontEnrollmentController::class, 'store'])->middleware('throttle:storefront-enrollment');

// 6. Carnet Digital y Certificado de Afiliación Imprimible / PDF
Route::get('/v/{slug}/carnet/{subscription_id}', function (string $slug, string $subscription_id) {
    return app(App\Http\Controllers\SubscriptionCarnetController::class)->show($slug, $subscription_id);
})->name('carnet.show');

Route::get('/v/{slug}/carnet/{subscription_id}/pdf', function (string $slug, string $subscription_id) {
    return app(App\Http\Controllers\SubscriptionCarnetController::class)->downloadPdf($slug, $subscription_id);
})->name('carnet.pdf');

// 7. Afiche Oficial de Mostrador con Código QR para Impresión / PDF
Route::get('/v/{slug}/afiche', function (string $slug) use ($resolveTenantFromHost) {
    $tenantHost = $resolveTenantFromHost();
    if ($tenantHost && $tenantHost->slug === $slug) {
        return redirect('/afiche');
    }
    return app(App\Http\Controllers\ClinicFlyerController::class)->show($slug);
})->name('clinic.flyer');

Route::get('/v/{slug}/afiche/pdf', function (string $slug) use ($resolveTenantFromHost) {
    $tenantHost = $resolveTenantFromHost();
    if ($tenantHost && $tenantHost->slug === $slug) {
        return redirect('/afiche/pdf');
    }
    return app(App\Http\Controllers\ClinicFlyerController::class)->downloadPdf($slug);
})->name('clinic.flyer.pdf');

// 8. Onboarding Express B2B en 60 Segundos (15 Días Gratis)
Route::post('/registro-clinica', [App\Http\Controllers\ClinicOnboardingController::class, 'register'])->name('clinic.register');
Route::get('/registro-clinica', fn() => redirect('https://' . env('APP_BASE_DOMAIN', 'avipetapp.com') . '/?registro=1#onboarding'));
Route::get('/onboarding', fn() => redirect('https://' . env('APP_BASE_DOMAIN', 'avipetapp.com') . '/?registro=1#onboarding'));

// 9. Pasarela B2B: Checkout Oficial Bold para Pago del Canon SaaS de Veterinarias
Route::get('/admin/{slug}/renovar-saas', [App\Http\Controllers\SaaSPaymentController::class, 'showCheckout'])->name('saas.checkout');
Route::get('/v/{slug}/renovar-saas', [App\Http\Controllers\SaaSPaymentController::class, 'showCheckout']);

// 10. Panel SuperAdmin Central (React + Inertia + Tailwind) & Impersonation
Route::redirect('/superadmin', '/super-admin');
Route::redirect('/superadmin/login', '/super-admin/login');

Route::prefix('super-admin')->middleware([\App\Http\Middleware\EnsureSuperAdminSession::class])->group(function () {
    // 1. Escritorio / Dashboard
    Route::get('/', [App\Http\Controllers\SuperAdmin\SuperAdminDashboardController::class, 'index'])->name('superadmin.dashboard');

    // 2. Clínicas Veterinarias (Tenants)
    Route::get('/tenants', [App\Http\Controllers\SuperAdmin\SuperAdminTenantController::class, 'index'])->name('superadmin.tenants');
    Route::post('/tenants', [App\Http\Controllers\SuperAdmin\SuperAdminTenantController::class, 'store'])->name('superadmin.tenants.store');
    Route::post('/tenants/{id}/update', [App\Http\Controllers\SuperAdmin\SuperAdminTenantController::class, 'update'])->name('superadmin.tenants.update');
    Route::post('/tenants/{id}/delete', [App\Http\Controllers\SuperAdmin\SuperAdminTenantController::class, 'destroy'])->name('superadmin.tenants.destroy');
    Route::get('/tenants/{id}/edit', fn (string $id) => redirect("/super-admin/tenants?manage={$id}"));

    // 3. Suscripciones y Pagos SaaS
    Route::get('/saas-payment-logs', [App\Http\Controllers\SuperAdmin\SuperAdminPaymentController::class, 'index'])->name('superadmin.payments');
    Route::post('/saas-payment-logs', [App\Http\Controllers\SuperAdmin\SuperAdminPaymentController::class, 'store'])->name('superadmin.payments.store');

    // 4. Usuarios y Doctores
    Route::get('/users', [App\Http\Controllers\SuperAdmin\SuperAdminUserController::class, 'index'])->name('superadmin.users');
    Route::post('/users', [App\Http\Controllers\SuperAdmin\SuperAdminUserController::class, 'store'])->name('superadmin.users.store');
    Route::post('/users/{id}/update', [App\Http\Controllers\SuperAdmin\SuperAdminUserController::class, 'update'])->name('superadmin.users.update');
    Route::post('/users/{id}/delete', [App\Http\Controllers\SuperAdmin\SuperAdminUserController::class, 'destroy'])->name('superadmin.users.destroy');

    // 5. Prospección B2B & Campañas
    Route::get('/prospecto-veterinarias', [App\Http\Controllers\SuperAdmin\SuperAdminProspectoController::class, 'index'])->name('superadmin.prospectos');
    Route::post('/prospecto-veterinarias', [App\Http\Controllers\SuperAdmin\SuperAdminProspectoController::class, 'store'])->name('superadmin.prospectos.store');
    Route::post('/prospecto-veterinarias/{id}/send-outreach', [App\Http\Controllers\SuperAdmin\SuperAdminProspectoController::class, 'sendOutreach'])->name('superadmin.prospectos.send');
    Route::post('/prospecto-veterinarias/{id}/update-estado', [App\Http\Controllers\SuperAdmin\SuperAdminProspectoController::class, 'updateEstado'])->name('superadmin.prospectos.update-estado');
    Route::post('/prospecto-veterinarias/dispatch-batch', [App\Http\Controllers\SuperAdmin\SuperAdminProspectoController::class, 'dispatchBatch'])->name('superadmin.prospectos.dispatch-batch');
    Route::get('/prospecto-veterinarias/campaign-status', [App\Http\Controllers\SuperAdmin\SuperAdminProspectoController::class, 'campaignStatus'])->name('superadmin.prospectos.campaign-status');
    Route::post('/prospecto-veterinarias/scan-region', [App\Http\Controllers\SuperAdmin\SuperAdminProspectoController::class, 'scanRegion'])->name('superadmin.prospectos.scan-region');
    Route::get('/prospecto-veterinarias/scan-status', [App\Http\Controllers\SuperAdmin\SuperAdminProspectoController::class, 'scanStatus'])->name('superadmin.prospectos.scan-status');
    Route::post('/prospecto-veterinarias/import-csv', [App\Http\Controllers\SuperAdmin\SuperAdminProspectoController::class, 'importCsv'])->name('superadmin.prospectos.import-csv');

    // 6. Configuración Global SaaS
    Route::get('/configuracion', [App\Http\Controllers\SuperAdmin\SuperAdminConfiguracionController::class, 'index'])->name('superadmin.configuracion');
    Route::post('/configuracion', [App\Http\Controllers\SuperAdmin\SuperAdminConfiguracionController::class, 'update'])->name('superadmin.configuracion.update');

    // 7. Cerrar Sesión SuperAdmin (Soporta GET y POST sin bloqueo 419 y preserva nombre de ruta Filament)
    $superAdminLogoutHandler = function (\Illuminate\Http\Request $request) {
        \Illuminate\Support\Facades\Auth::logout();
        session()->forget(['admin_preview', 'admin_demo', 'url.intended', 'impersonated_by']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/super-admin/login');
    };
    Route::get('/logout', $superAdminLogoutHandler)->name('superadmin.logout');
    Route::post('/logout', $superAdminLogoutHandler)->name('filament.super-admin.auth.logout');
});

Route::get('/impersonate-clinic/{tenant_id}', [App\Http\Controllers\ImpersonationController::class, 'impersonateTenant'])->name('superadmin.impersonate');
Route::get('/impersonate-clinic-stop', [App\Http\Controllers\ImpersonationController::class, 'stopImpersonating'])->name('superadmin.stop-impersonating');

// 11. SEO: Generador Dinámico de Sitemap XML para Google Search Console
Route::get('/sitemap.xml', function () {
    $baseUrl = 'https://avipetapp.com';

    $tenants = Tenant::query()
        ->where('is_active', true)
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

    // 2. Portada del Blog B2B
    $xml .= "  <url>\n";
    $xml .= "    <loc>{$baseUrl}/blog</loc>\n";
    $xml .= "    <lastmod>" . now()->toDateString() . "</lastmod>\n";
    $xml .= "    <changefreq>weekly</changefreq>\n";
    $xml .= "    <priority>0.90</priority>\n";
    $xml .= "  </url>\n";

    // 3. Vitrinas B2C Canónicas de cada Clínica Veterinaria activa (Sin duplicar /v/{slug})
    foreach ($tenants as $tenant) {
        $lastmod = $tenant->updated_at ? $tenant->updated_at->toDateString() : now()->toDateString();
        $canonicalTenantUrl = rtrim($tenant->base_url, '/') . '/';

        $xml .= "  <url>\n";
        $xml .= "    <loc>{$canonicalTenantUrl}</loc>\n";
        $xml .= "    <lastmod>{$lastmod}</lastmod>\n";
        $xml .= "    <changefreq>weekly</changefreq>\n";
        $xml .= "    <priority>0.90</priority>\n";
        $xml .= "  </url>\n";
    }

    // 4. Artículos Estratégicos del Blog de AVI-Plan (SEO B2B)
    $blogPosts = \App\Services\BlogService::getAllPosts();
    foreach ($blogPosts as $post) {
        $xml .= "  <url>\n";
        $xml .= "    <loc>{$baseUrl}/blog/{$post['slug']}</loc>\n";
        $xml .= "    <lastmod>{$post['updated_at']}</lastmod>\n";
        $xml .= "    <changefreq>weekly</changefreq>\n";
        $xml .= "    <priority>0.85</priority>\n";
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

// 13. Píxel de Seguimiento de Aperturas de Correo (Prospección AVI-Plan)
Route::get('/track/p/{id}.png', function ($id) {
    try {
        $prospecto = \App\Models\ProspectoVeterinaria::find($id);
        if ($prospecto) {
            $prospecto->update([
                'abierto_at' => $prospecto->abierto_at ?? now(),
                'aperturas_count' => ($prospecto->aperturas_count ?? 0) + 1,
            ]);
        }
    } catch (\Throwable $e) {}

    // Retorna GIF transparente de 1x1 píxel
    $gif = base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
    return response($gif, 200, [
        'Content-Type' => 'image/gif',
        'Cache-Control' => 'no-cache, no-store, must-revalidate, max-age=0',
        'Pragma' => 'no-cache',
        'Expires' => '0',
    ]);
})->name('prospecto.track.open');







