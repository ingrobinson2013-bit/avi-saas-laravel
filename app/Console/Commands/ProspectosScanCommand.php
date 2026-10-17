<?php

namespace App\Console\Commands;

use App\Models\ProspectoVeterinaria;
use App\Services\VeterinariaScraperService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProspectosScanCommand extends Command
{
    protected $signature = 'avi:prospectos-scan 
                            {--region=todo_el_pais : Región de Colombia a escanear} 
                            {--limit=50 : Cantidad de nuevas clínicas a encontrar y registrar}';

    protected $description = 'Rastrea y descubre nuevas clínicas veterinarias en Colombia, actualizando la cola de prospectos en tiempo real';

    public function handle(): int
    {
        $region = (string) $this->option('region');
        $limit = min(max((int) $this->option('limit'), 1), 100);

        $this->info("============================================================");
        $this->info("🔍 AVI-PLAN: MOTOR INTELIGENTE DE RASTREO Y PROSPECCIÓN");
        $this->info("============================================================");
        $this->info("- Región objetivo: {$region}");
        $this->info("- Cuota a descubrir: {$limit}");

        Cache::put('avi_scan_progress', [
            'status' => 'running',
            'total' => $limit,
            'encontrados' => 0,
            'percent' => 15,
            'region' => $region,
            'current_step' => 'Conectando con registros y directorios veterinarios...',
            'started_at' => now()->format('H:i:s'),
        ], 600);

        try {
            $this->line("Rastreando clínicas en {$region}...");

            Cache::put('avi_scan_progress', [
                'status' => 'running',
                'total' => $limit,
                'encontrados' => (int) round($limit * 0.3),
                'percent' => 45,
                'region' => $region,
                'current_step' => 'Extrayendo datos de contacto y verificando emails únicos...',
                'started_at' => now()->format('H:i:s'),
            ], 600);

            $scraper = app(VeterinariaScraperService::class);
            $res = $scraper->scanRegion($region, null, null, null, $limit);

            $guardados = $res['guardados_o_actualizados'] ?? count($res['encontrados'] ?? []);
            $totalPendientes = $res['pendientes_en_cola'] ?? ProspectoVeterinaria::pendientes()->count();

            Cache::put('avi_scan_progress', [
                'status' => 'completed',
                'total' => $limit,
                'encontrados' => $guardados,
                'percent' => 100,
                'region' => $region,
                'current_step' => "¡Escaneo completado! {$guardados} nuevas clínicas listas en cola de pendientes (Total: {$totalPendientes}).",
                'finished_at' => now()->format('H:i:s'),
            ], 300);

            $this->info("✓ Finalizado con éxito: {$guardados} clínicas agregadas.");
            $this->info("✓ Total prospectos pendientes en base: {$totalPendientes}");
            Log::info("[AVI-Prospectos] Escaneo exitoso ({$region}): {$guardados} nuevas clínicas añadidas.");

            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $this->error("❌ Error en escaneo: " . $e->getMessage());
            Log::error("[AVI-Prospectos] Error en escaneo ({$region}): " . $e->getMessage());

            Cache::put('avi_scan_progress', [
                'status' => 'error',
                'total' => $limit,
                'encontrados' => 0,
                'percent' => 100,
                'region' => $region,
                'current_step' => 'Error durante el escaneo: ' . $e->getMessage(),
                'finished_at' => now()->format('H:i:s'),
            ], 300);

            return Command::FAILURE;
        }
    }
}
