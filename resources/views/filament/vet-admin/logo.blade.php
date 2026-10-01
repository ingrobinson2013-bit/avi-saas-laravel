@php
    $tenant = \Filament\Facades\Filament::getTenant() ?? auth()->user()?->tenant ?? \App\Models\Tenant::first();
    $logoUrl = $tenant?->branding['logo_url'] ?? null;
    $fullName = $tenant?->name ?? 'Clínica Veterinaria';
    $rawCity = $tenant?->branding['city'] ?? 'Sede Principal';
    $cleanCity = trim(explode(',', $rawCity)[0]);

    // Separar inteligentemente el nombre de marca del tipo de establecimiento
    $brandName = $fullName;
    $facilityType = 'Salud Veterinaria';

    if (preg_match('/^(.*?)\s+(Consultorio Veterinario|Clínica Veterinaria|Hospital Veterinario|Veterinaria|Vet)(.*)$/i', $fullName, $matches)) {
        $extractedBrand = trim($matches[1] . ' ' . $matches[3]);
        if (!empty($extractedBrand)) {
            $brandName = $extractedBrand;
            $facilityType = trim($matches[2]);
        }
    }
@endphp

<div class="flex items-center gap-3 py-1 w-full overflow-hidden">
    @if(!empty($logoUrl))
        <div class="w-10 h-10 rounded-xl p-1 bg-white shadow-xs border border-slate-200 dark:border-slate-700 shrink-0 flex items-center justify-center overflow-hidden">
            <img src="{{ $logoUrl }}" alt="{{ $fullName }}" class="w-full h-full object-contain" loading="lazy">
        </div>
    @else
        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-black text-lg shadow-xs shrink-0 bg-gradient-to-br from-blue-600 to-cyan-600">
            🐾
        </div>
    @endif
    <div class="flex flex-col min-w-0">
        <span class="text-sm font-black text-slate-900 dark:text-white leading-tight tracking-tight whitespace-nowrap">
            {{ $brandName }}
        </span>
        <span class="text-[11px] font-bold text-blue-600 dark:text-cyan-400 tracking-wide mt-0.5 whitespace-nowrap">
            {{ $facilityType }} · {{ $cleanCity }}
        </span>
    </div>
</div>
