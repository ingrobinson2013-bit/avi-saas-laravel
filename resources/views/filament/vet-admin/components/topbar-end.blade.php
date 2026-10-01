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

<div class="flex items-center gap-2.5 sm:gap-3 shrink-0">
    <!-- Acceso Rápido: Imprimir Afiche QR Mostrador -->
    <a href="/v/{{ $slug }}/afiche" target="_blank" 
       title="Imprimir Afiche QR para mostrador" 
       class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-cyan-400 hover:bg-slate-100 dark:hover:bg-slate-800 text-xs font-bold border border-slate-200 dark:border-slate-700 transition shrink-0 shadow-2xs">
        <span>🖨️</span>
        <span class="hidden md:inline">Afiche QR</span>
    </a>

    <!-- Divisor vertical -->
    <div class="hidden sm:block h-6 w-px bg-slate-200 dark:bg-slate-700"></div>

    <!-- BOTÓN PARA CAMBIAR DE COLOR / TEMA (MODO CLARO / MODO OSCURO) -->
    <button
        type="button"
        id="avi-theme-toggle-btn"
        x-data="{
            isDark: false,
            init() {
                this.sync();
                window.addEventListener('theme-changed', (e) => {
                    this.isDark = (e.detail === 'dark') || document.documentElement.classList.contains('dark');
                });
            },
            sync() {
                this.isDark = document.documentElement.classList.contains('dark') || 
                              localStorage.getItem('theme') === 'dark';
            },
            toggle() {
                const willBeDark = !this.isDark;
                this.isDark = willBeDark;
                const newMode = willBeDark ? 'dark' : 'light';
                
                if (willBeDark) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
                
                localStorage.setItem('theme', newMode);
                window.dispatchEvent(new CustomEvent('theme-changed', { detail: newMode }));
                
                if (window.Alpine && window.Alpine.store('theme')) {
                    window.Alpine.store('theme', newMode);
                }
            }
        }"
        x-init="init()"
        x-on:click="toggle()"
        title="Cambiar color de interfaz (Modo Claro / Modo Oscuro)"
        class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-amber-300 transition shadow-2xs cursor-pointer shrink-0 font-bold text-xs"
    >
        <!-- Vista cuando está en MODO OSCURO: muestra sol dorado para invitar a pasar a claro -->
        <span x-show="isDark" class="flex items-center gap-1.5 text-amber-300">
            <svg class="w-4 h-4 text-amber-400 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span class="hidden md:inline text-[11px] font-bold">Modo Claro</span>
        </span>

        <!-- Vista cuando está en MODO CLARO: muestra luna para invitar a pasar a oscuro -->
        <span x-show="!isDark" class="flex items-center gap-1.5 text-slate-700">
            <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
            <span class="hidden md:inline text-[11px] font-bold text-slate-700">Modo Oscuro</span>
        </span>
    </button>

    <!-- Divisor vertical -->
    <div class="hidden sm:block h-6 w-px bg-slate-200 dark:bg-slate-700"></div>

    <!-- Identidad: Nombre y Cargo de la Persona Conectada -->
    <div class="flex flex-col text-right leading-tight min-w-0 shrink-0">
        <span class="text-xs font-black text-slate-900 dark:text-white truncate max-w-[180px] sm:max-w-[220px]" title="{{ $name }}">
            {{ $name }}
        </span>
        <span class="text-[10.5px] font-bold text-blue-600 dark:text-cyan-400 tracking-tight mt-0.5 truncate max-w-[180px] sm:max-w-[220px]" title="{{ $cargo }}">
            {{ $cargo }}
        </span>
    </div>
</div>
