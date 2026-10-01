<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title inertia>{{ config('app.name', 'Vet-Pet Patitas · Portal Veterinario') }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @php
        $tenantSlug = request()->route('slug') ?? session('current_tenant_slug') ?? 'vet-pet-patitas';
        $currentTenant = \App\Models\Tenant::where('slug', $tenantSlug)->first() ?? \App\Models\Tenant::first();
        $favIcon = $currentTenant?->branding['logo_url'] ?? '/logo.svg';
    @endphp
    <link rel="icon" type="image/webp" href="{{ $favIcon }}">

    @viteReactRefresh
    @vite(['resources/js/app.tsx'])
    @inertiaHead
</head>
<body class="h-full font-sans antialiased bg-[#edf0f7] text-slate-900 selection:bg-cyan-500 selection:text-white">
    @inertia
</body>
</html>
