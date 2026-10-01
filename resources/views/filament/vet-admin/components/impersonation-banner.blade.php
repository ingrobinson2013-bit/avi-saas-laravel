@if(session()->has('impersonator_superadmin_id'))
    <div class="w-full bg-gradient-to-r from-amber-500 via-orange-600 to-rose-600 text-white px-4 py-2.5 shadow-md flex items-center justify-between text-xs font-bold z-50 sticky top-0">
        <div class="flex items-center gap-2">
            <span class="text-base animate-bounce">👑</span>
            <span>MODO SOPORTE SUPERADMIN: Estás administrando la clínica <u>{{ \Filament\Facades\Filament::getTenant()?->name }}</u></span>
        </div>

        <a href="/super-admin/stop-impersonating" 
           class="inline-flex items-center gap-1.5 px-3 py-1 bg-white text-orange-700 hover:bg-orange-50 font-extrabold rounded-lg shadow-sm transition-all transform hover:scale-105">
            <span>↩️ Salir y Volver al SuperAdmin</span>
        </a>
    </div>
@endif
