<x-filament-widgets::widget>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Red de Clínicas -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 shadow-xs border-b-4 border-b-indigo-500 flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-[11px] font-black text-slate-700 dark:text-slate-300 tracking-wider uppercase block">
                    RED DE CLÍNICAS:
                </span>
                <div class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                    {{ $totalTenants }} Clínicas
                </div>
                <div class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">
                    Detalle de Suscripciones:
                </div>
                <div class="text-xs font-bold text-indigo-600 dark:text-indigo-400">
                    {{ $paidTenants }} Oficiales Pagas, {{ $trialTenants }} En Prueba
                </div>
            </div>
            <div class="text-slate-300 dark:text-slate-700 shrink-0 ml-3">
                <svg class="w-10 h-10 stroke-[1.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
        </div>

        <!-- Card 2: Pacientes & Membresías -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 shadow-xs border-b-4 border-b-teal-500 flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-[11px] font-black text-slate-700 dark:text-slate-300 tracking-wider uppercase block">
                    PACIENTES & MEMBRESÍAS:
                </span>
                <div class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                    {{ $totalPets }} Mascotas
                </div>
                <div class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">
                    Distribución:
                </div>
                <div class="text-xs font-bold text-teal-600 dark:text-teal-400">
                    {{ $activeSubscriptions }} Planes Activos, {{ $totalCustomers }} Tutores
                </div>
            </div>
            <div class="text-slate-300 dark:text-slate-700 shrink-0 ml-3">
                <svg class="w-10 h-10 stroke-[1.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </div>
        </div>

        <!-- Card 3: Facturación SaaS (MRR) -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 shadow-xs border-b-4 border-b-amber-500 flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-[11px] font-black text-slate-700 dark:text-slate-300 tracking-wider uppercase block">
                    FACTURACIÓN SAAS (MRR):
                </span>
                <div class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                    {{ $monthlySaasRevenue }}
                </div>
                <div class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">
                    Detalle de Cobros:
                </div>
                <div class="text-xs font-bold text-amber-600 dark:text-amber-400">
                    Canon Mensual SuperAdmin
                </div>
            </div>
            <div class="text-slate-300 dark:text-slate-700 shrink-0 ml-3">
                <svg class="w-10 h-10 stroke-[1.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>

        <!-- Card 4: Volumen Manejado (GMV) -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 shadow-xs border-b-4 border-b-emerald-500 flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-[11px] font-black text-slate-700 dark:text-slate-300 tracking-wider uppercase block">
                    VOLUMEN MANEJADO (GMV):
                </span>
                <div class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                    {{ $totalGMV }}
                </div>
                <div class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">
                    Detalle de Transacciones:
                </div>
                <div class="text-xs font-bold text-emerald-600 dark:text-emerald-400">
                    Recaudo de las veterinarias
                </div>
            </div>
            <div class="text-slate-300 dark:text-slate-700 shrink-0 ml-3">
                <svg class="w-10 h-10 stroke-[1.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
