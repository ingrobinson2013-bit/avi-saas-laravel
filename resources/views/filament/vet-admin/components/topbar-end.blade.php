@php
    $tenant = \Filament\Facades\Filament::getTenant() ?? auth()->user()?->tenant ?? \App\Models\Tenant::first();
    $slug = $tenant?->slug ?? 'vet-pet-patitas';
    $user = auth()->user();
    $name = $user?->name ?? 'Usuario Conectado';
    
    // Mapeo claro de roles clínicos y administrativos
    $roleMap = [
        'super_admin' => 'Director General · NODIA',
        'clinic_admin' => 'Administradora de Sede',
        'vet_doctor' => 'Médica Veterinaria',
        'reception' => 'Recepción y Caja',
        'vet_staff' => 'Equipo Clínico',
    ];
    $cargo = $roleMap[$user?->role] ?? 'Personal Autorizado';
@endphp

<div class="flex items-center gap-3 shrink-0">
    <!-- Acceso Rápido: Imprimir Afiche QR Mostrador -->
    <a href="/v/{{ $slug }}/afiche" target="_blank" 
       title="Imprimir Afiche QR para mostrador" 
       class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-cyan-400 hover:bg-slate-100 dark:hover:bg-slate-800 text-xs font-bold border border-slate-200 dark:border-slate-700 transition shrink-0 shadow-2xs">
        <span>🖨️</span>
        <span>Afiche QR</span>
    </a>

    <!-- Divisor vertical -->
    <div class="hidden sm:block h-6 w-px bg-slate-200 dark:bg-slate-700"></div>

    <!-- Identidad: Nombre y Cargo de la Persona Conectada -->
    <div class="flex flex-col text-right leading-tight min-w-0 shrink-0">
        <span class="text-xs font-black text-slate-900 dark:text-white truncate max-w-[200px]" title="{{ $name }}">
            {{ $name }}
        </span>
        <span class="text-[10.5px] font-bold text-blue-600 dark:text-cyan-400 tracking-tight mt-0.5 truncate max-w-[200px]" title="{{ $cargo }}">
            {{ $cargo }}
        </span>
    </div>
</div>
