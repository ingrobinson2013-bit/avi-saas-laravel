@php
    $tenant = \Filament\Facades\Filament::getTenant() ?? auth()->user()?->tenant ?? \App\Models\Tenant::first();
    $slug = $tenant?->slug ?? 'vet-pet-patitas';
    $user = auth()->user();
    $name = $user?->name ?? 'Dra. Vicky Naranjo';
    $cargo = 'Administradora de Sede';
@endphp

<div class="flex items-center gap-3 shrink-0">
    <!-- Notification Bell with Red Badge matching Mockup -->
    <div class="relative">
        <button type="button" 
                title="Notificaciones de la sede"
                class="relative p-2 rounded-full text-slate-500 hover:text-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
            <svg class="w-5 h-5 text-slate-600 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span class="absolute top-1.5 right-1.5 w-4 h-4 rounded-full bg-rose-500 text-white text-[9px] font-black flex items-center justify-center">1</span>
        </button>
    </div>

    <!-- Support Headphones Icon matching Mockup -->
    <a href="https://wa.me/573000000000?text=Hola%20Soporte%20NODIA%20PetSalud" target="_blank"
       title="Soporte técnico y mesa de ayuda"
       class="p-2 rounded-full text-slate-600 dark:text-slate-300 hover:text-slate-800 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 18v-6a9 9 0 0118 0v6M3 18a2 2 0 002 2h1a2 2 0 002-2v-3a2 2 0 00-2-2H4a1 1 0 00-1 1v3zm18 0a2 2 0 01-2 2h-1a2 2 0 01-2-2v-3a2 2 0 012-2h1a1 1 0 011 1v3z" />
        </svg>
    </a>

    <!-- Theme Toggle (Clean & Compact) -->
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
            }
        }"
        x-init="init()"
        x-on:click="toggle()"
        title="Modo Claro / Modo Oscuro"
        class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-500 dark:text-amber-300 transition cursor-pointer"
    >
        <span x-show="isDark">☀️</span>
        <span x-show="!isDark">🌙</span>
    </button>

    <!-- Dra. Vicky Naranjo Name & Role matching Mockup -->
    <div class="hidden sm:flex flex-col text-right leading-tight shrink-0 pl-1">
        <span class="text-xs font-black text-slate-900 dark:text-white truncate max-w-[180px]">
            {{ $name }}
        </span>
        <span class="text-[10.5px] font-medium text-slate-500 dark:text-slate-400 mt-0.5 truncate max-w-[180px]">
            {{ $cargo }}
        </span>
    </div>
</div>
