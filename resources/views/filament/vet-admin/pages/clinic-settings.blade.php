<x-filament-panels::page>
    @php
        $tenant = $this->getTenant();
        $branding = $tenant?->branding ?? [];
        $logoUrl = $branding['logo_url'] ?? null;
        $heroUrl = $branding['hero_image_url'] ?? null;
        $bannerUrl = $branding['banner_image_url'] ?? null;
    @endphp

    @if($logoUrl || $heroUrl || $bannerUrl)
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-5 shadow-sm space-y-3 mb-2">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-black uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <span>✨</span> Archivos y Marca Actualmente Activos en /v/{{ $tenant->slug }}
                </h3>
                <a href="/v/{{ $tenant->slug }}" target="_blank" class="text-xs font-bold text-teal-600 dark:text-teal-400 hover:underline flex items-center gap-1">
                    <span>Abrir Portal en Vivo</span>
                    <span>↗</span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-1">
                @if($logoUrl)
                    <div class="bg-gray-50 dark:bg-gray-800/60 p-3 rounded-xl border border-gray-100 dark:border-gray-700 flex items-center gap-3">
                        <img src="{{ $logoUrl }}" alt="Logo" class="h-12 w-12 object-contain bg-white rounded-lg p-1 border shadow-xs">
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-gray-900 dark:text-white truncate">Logo Oficial</p>
                            <p class="text-[10px] text-emerald-600 dark:text-emerald-400 font-semibold">● Activo en Web & Panel</p>
                        </div>
                    </div>
                @endif

                @if($heroUrl)
                    <div class="bg-gray-50 dark:bg-gray-800/60 p-3 rounded-xl border border-gray-100 dark:border-gray-700 flex items-center gap-3">
                        <img src="{{ $heroUrl }}" alt="Foto Hero" class="h-12 w-16 object-cover rounded-lg border shadow-xs">
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-gray-900 dark:text-white truncate">Foto de Pacientes</p>
                            <p class="text-[10px] text-emerald-600 dark:text-emerald-400 font-semibold">● Activa en Hero</p>
                        </div>
                    </div>
                @endif

                @if($bannerUrl)
                    <div class="bg-gray-50 dark:bg-gray-800/60 p-3 rounded-xl border border-gray-100 dark:border-gray-700 flex items-center gap-3">
                        <img src="{{ $bannerUrl }}" alt="Foto Portada" class="h-12 w-16 object-cover rounded-lg border shadow-xs">
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-gray-900 dark:text-white truncate">Foto Instalaciones</p>
                            <p class="text-[10px] text-emerald-600 dark:text-emerald-400 font-semibold">● Activa en Galería</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <form wire:submit="save" class="space-y-6">
        {{ $this->form }}

        <div class="flex items-center space-x-3 pt-4">
            <x-filament::button type="submit" size="lg" color="primary">
                💾 Guardar Cambios de Marca
            </x-filament::button>

            <a href="/v/{{ $this->getTenant()?->slug ?? 'vet-pet-patitas' }}" target="_blank" class="px-4 py-2.5 text-xs font-bold text-slate-700 dark:text-slate-300 border border-slate-300 dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all flex items-center space-x-1.5">
                <span>👀 Ver Portal en Vivo</span>
                <span>↗</span>
            </a>
        </div>
    </form>
</x-filament-panels::page>
