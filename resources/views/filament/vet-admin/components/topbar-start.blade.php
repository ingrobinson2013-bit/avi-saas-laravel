@php
    $tenant = \Filament\Facades\Filament::getTenant() ?? auth()->user()?->tenant ?? \App\Models\Tenant::first();
    $slug = $tenant?->slug ?? 'vet-pet-patitas';
@endphp

{{-- Central Search Bar matching PetSalud+ Mockup --}}
<div class="flex items-center justify-center w-full max-w-lg mx-auto">
    <div class="relative w-full">
        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-xs">
            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <form action="/admin/{{ $slug }}/pets" method="GET" class="w-full">
            <input type="text" 
                   name="tableSearch" 
                   placeholder="Buscar cliente, mascota o plan..." 
                   class="w-full pl-9 pr-4 py-2 text-xs rounded-full border border-slate-200/80 dark:border-slate-700 bg-slate-50/80 dark:bg-slate-800 text-slate-800 dark:text-slate-200 focus:outline-hidden focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition placeholder:text-slate-400 shadow-2xs" />
        </form>
    </div>
</div>
