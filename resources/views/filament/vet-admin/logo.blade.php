@php
    $tenant = \Filament\Facades\Filament::getTenant() ?? auth()->user()?->tenant ?? \App\Models\Tenant::first();
    $logoUrl = $tenant?->branding['logo_url'] ?? null;
    $fullName = $tenant?->name ?? 'Clínica Veterinaria';
    $rawCity = $tenant?->branding['city'] ?? 'Sede Principal';
    $cleanCity = trim(explode(',', $rawCity)[0]);

    // Extraer el nombre de marca limpio sin palabras gigantes que desborden
    $brandName = $fullName;
    if (preg_match('/^(.*?)\s+(Consultorio Veterinario|Clínica Veterinaria|Hospital Veterinario|Veterinaria|Vet)(.*)$/i', $fullName, $matches)) {
        $extracted = trim($matches[1] . ' ' . $matches[3]);
        if (!empty($extracted)) {
            $brandName = $extracted;
        }
    }
@endphp

<div class="flex items-center gap-2.5 py-0.5 w-full min-w-0 overflow-hidden">
    @if(!empty($logoUrl))
        <div class="w-9 h-9 rounded-xl p-0.5 bg-white shadow-2xs border border-slate-200 dark:border-slate-700 shrink-0 flex items-center justify-center overflow-hidden">
            <img src="{{ $logoUrl }}" alt="{{ $fullName }}" class="w-full h-full object-contain" loading="lazy">
        </div>
    @else
        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-black text-base shadow-2xs shrink-0 bg-gradient-to-br from-blue-600 to-cyan-600">
            🐾
        </div>
    @endif
    <div class="flex flex-col min-w-0 flex-1 justify-center overflow-hidden">
        <span class="text-sm font-black text-slate-900 dark:text-white leading-tight tracking-tight truncate block" title="{{ $brandName }}">
            {{ $brandName }}
        </span>
        <span class="text-[11px] font-bold text-blue-600 dark:text-cyan-400 tracking-wide mt-0.5 truncate block" title="Sede {{ $cleanCity }} · AVI-Plan">
            Sede {{ $cleanCity }} · AVI-Plan
        </span>
    </div>
</div>
