<x-filament-panels::page>
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
