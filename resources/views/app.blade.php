<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    @php
        $gaId = env('GOOGLE_TAG_ID', 'G-YRPKPVXZ2T') ?: env('GOOGLE_ANALYTICS_ID', 'G-YRPKPVXZ2T');
    @endphp
    @if($gaId)
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ $gaId }}');
    </script>
    @endif
    <title inertia>{{ config('app.name', 'AviPetApp · Software con IA para veterinarias') }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @php
        $host = request()->getHost();
        $cleanHost = strtolower(trim($host));
        $hostNoWww = preg_replace('/^www\./', '', $cleanHost);
        $baseDomain = env('APP_BASE_DOMAIN', 'avipetapp.com');

        $tenantSlug = request()->route('slug') ?? request()->route('subdomain') ?? session('current_tenant_slug');
        $currentTenant = null;

        if ($tenantSlug) {
            $currentTenant = \App\Models\Tenant::where('slug', $tenantSlug)
                ->orWhere('domain', 'LIKE', "%{$tenantSlug}%")
                ->first();
        }

        if (!$currentTenant && !in_array($hostNoWww, ['localhost', '127.0.0.1', $baseDomain])) {
            $currentTenant = \App\Models\Tenant::where('domain', $cleanHost)
                ->orWhere('domain', $hostNoWww)
                ->first();

            if (!$currentTenant && str_ends_with($cleanHost, '.' . $baseDomain)) {
                $sub = str_replace('.' . $baseDomain, '', $hostNoWww);
                if ($sub !== 'www') {
                    $currentTenant = \App\Models\Tenant::where('slug', $sub)->first();
                }
            }
        }

        if (!$currentTenant) {
            $currentTenant = \App\Models\Tenant::where('slug', 'vet-pet-patitas')->first() ?? \App\Models\Tenant::first();
        }

        if (request()->is('super-admin*')) {
            $clinicPageTitle = 'Centro de control · AviPetApp Superadmin';
            $favIcon = '/brand/favicons/favicon.svg';
        } else {
            $favIcon = $currentTenant?->branding['logo_url'] ?? '/brand/favicons/favicon.svg';
            $clinicPageTitle = $currentTenant ? ($currentTenant->name . ' · AviPetApp') : 'AviPetApp · Software con IA para veterinarias';
        }
    @endphp
    <title inertia>{{ $clinicPageTitle }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ $favIcon }}">
    <link rel="icon" type="image/png" sizes="32x32" href="/brand/favicons/favicon-32.png">
    <link rel="shortcut icon" href="{{ $favIcon }}">
    <link rel="apple-touch-icon" sizes="180x180" href="/brand/favicons/favicon-180.png">

    @viteReactRefresh
    @vite(['resources/js/app.tsx'])
    @inertiaHead
</head>
<body class="h-full font-sans antialiased bg-[#F4F7FC] text-[#15213B] selection:bg-[#6D28D9] selection:text-white">
    @inertia
</body>
</html>
