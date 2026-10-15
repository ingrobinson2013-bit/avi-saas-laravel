<?php

namespace App\Console\Commands;

use App\Mail\ProspectoOutreachMail;
use App\Models\ProspectoVeterinaria;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProspectosScanAndSend extends Command
{
    protected $signature = 'avi:prospectos-scan-and-send 
                            {--limit=25 : Cantidad de correos a enviar en este lote}
                            {--scan : Ejecutar enriquecimiento y búsqueda de nuevas clínicas antes de enviar}
                            {--dry-run : Simular sin realizar envíos reales}
                            {--test= : Enviar un correo de prueba a esta dirección}';

    protected $description = 'Escanea veterinarias del país y despacha campañas automáticas de prospección vía Hostinger SMTP';

    public function handle(): int
    {
        $limit = (int) $this->option('limit');
        $dryRun = $this->option('dry-run');
        $testEmail = $this->option('test');
        $shouldScan = $this->option('scan');

        $this->info("============================================================");
        $this->info("🚀 AVI-PLAN: MOTOR AUTOMÁTICO DE PROSPECCIÓN Y DISPACHO");
        $this->info("============================================================");
        $this->info("- Modo: " . ($dryRun ? "[SIMULACIÓN]" : ($testEmail ? "[TEST: $testEmail]" : "[ENVÍO REAL]")));
        $this->info("- Límite de lote diario: $limit");

        // 1. Escaneo / Enriquecimiento si se solicitó
        if ($shouldScan) {
            $this->info("\n🔍 Iniciando escaneo de directorios y registros veterinarios de Colombia...");
            $res = app(\App\Services\VeterinariaScraperService::class)->scanRegion('todo_el_pais');
            $this->info("✓ Escaneo completado: {$res['guardados_o_actualizados']} prospectos procesados con Upsert (Total cola: {$res['pendientes_en_cola']}).");
        }

        // 2. Modo Test individual
        if ($testEmail) {
            $this->info("\nEnviando correo de prueba a: {$testEmail}...");
            $dummy = new ProspectoVeterinaria([
                'razon_social' => 'Clínica Veterinaria Demo de Prueba',
                'correo_comercial' => $testEmail,
                'municipio' => 'Bogotá / Sabana',
                'departamento' => 'Cundinamarca',
            ]);

            try {
                Mail::to($testEmail)->send(new ProspectoOutreachMail($dummy));
                $this->info("✓ Correo de prueba entregado a Hostinger SMTP con éxito.");
                return Command::SUCCESS;
            } catch (\Throwable $e) {
                $this->error("❌ Error enviando correo de prueba: " . $e->getMessage());
                return Command::FAILURE;
            }
        }

        // 3. Obtener lote de prospectos pendientes
        $prospectos = ProspectoVeterinaria::pendientes()
            ->orderBy('id', 'asc')
            ->take($limit)
            ->get();

        $totalPendientes = $prospectos->count();
        $this->info("\n📋 Prospectos pendientes a procesar en este lote: {$totalPendientes}");

        if ($totalPendientes === 0) {
            $this->info("No hay prospectos pendientes en la base de datos.");
            return Command::SUCCESS;
        }

        $enviados = 0;
        $fallidos = 0;

        foreach ($prospectos as $idx => $prospecto) {
            $num = $idx + 1;
            $email = $prospecto->correo_comercial;
            $clinica = substr($prospecto->razon_social, 0, 30);

            if ($dryRun) {
                $this->line("[$num/$totalPendientes] [SIMULADO] -> {$email} | {$clinica}");
                $enviados++;
                continue;
            }

            try {
                Mail::to($email)->send(new ProspectoOutreachMail($prospecto));

                $prospecto->update([
                    'estado' => 'enviado',
                    'ultimo_envio_at' => now(),
                    'intentos_envio' => $prospecto->intentos_envio + 1,
                    'error_mensaje' => null,
                ]);

                $enviados++;
                $this->info("[$num/$totalPendientes] [ENVIADO]   -> {$email} | {$clinica}");
                Log::info("[AVI-Outreach] Correo entregado con éxito a: {$email} ({$prospecto->razon_social})");

                // Pausa prudente para proteger reputación de dominio y evitar bloqueos (10 segundos por correo)
                if ($num < $totalPendientes) {
                    sleep(10);
                }
            } catch (\Throwable $e) {
                $fallidos++;
                $errorMsg = $e->getMessage();
                $prospecto->update([
                    'estado' => 'error',
                    'intentos_envio' => $prospecto->intentos_envio + 1,
                    'error_mensaje' => substr($errorMsg, 0, 1000),
                ]);

                $this->error("[$num/$totalPendientes] [ERROR]     -> {$email} | {$errorMsg}");
                Log::error("[AVI-Outreach] Error enviando a {$email}: {$errorMsg}");
            }
        }

        $this->info("\n============================================================");
        $this->info("RESUMEN DE EJECUCIÓN:");
        $this->info("- Total enviados: {$enviados}");
        $this->info("- Fallidos: {$fallidos}");
        $this->info("- Pendientes restantes en BD: " . ProspectoVeterinaria::pendientes()->count());
        $this->info("============================================================");

        return Command::SUCCESS;
    }

    /**
     * Enriquecimiento y catálogo de veterinarias de Colombia
     */
    protected function escanearVeterinariasColombia(): int
    {
        $catalogo = [
            // Antioquia
            ['razon_social' => 'Clínica Veterinaria de Medellín (CVM)', 'correo_comercial' => 'clinicaveterinariamedellin@gmail.com', 'municipio' => 'Medellín', 'departamento' => 'Antioquia', 'tipo' => 'Hospital Veterinario', 'fuente' => 'Directorio Antioquia'],
            ['razon_social' => 'Family Pets Medellín', 'correo_comercial' => 'familypetsmedellin@gmail.com', 'municipio' => 'Sabaneta', 'departamento' => 'Antioquia', 'tipo' => 'Centro Veterinario', 'fuente' => 'ICA / Directorio'],
            ['razon_social' => 'Centro Veterinario Envigado', 'correo_comercial' => 'contacto@centrovetenvigado.com', 'municipio' => 'Envigado', 'departamento' => 'Antioquia', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Google Maps'],
            ['razon_social' => 'Veterinaria Domicilio El Poblado', 'correo_comercial' => 'info@veterinariadomiciliomedellin.com', 'municipio' => 'Medellín', 'departamento' => 'Antioquia', 'tipo' => 'Servicios Veterinarios', 'fuente' => 'Web'],

            // Valle del Cauca
            ['razon_social' => 'Servivet Cali', 'correo_comercial' => 'servivetcali@gmail.com', 'municipio' => 'Cali', 'departamento' => 'Valle del Cauca', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Valle'],
            
            // Atlántico
            ['razon_social' => 'Mis Mascotas Clínica Veterinaria', 'correo_comercial' => 'clinicamismascotas@hotmail.com', 'municipio' => 'Barranquilla', 'departamento' => 'Atlántico', 'tipo' => 'Clínica y Urgencias', 'fuente' => 'ICA / Directorio'],

            // Bogotá / Occidente y Norte
            ['razon_social' => 'Clínica Veterinaria Modelia', 'correo_comercial' => 'clinicaveterinariamodelia@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Google Maps'],
            ['razon_social' => 'Veterinaria en Suba (Dr. Santiago Barrera)', 'correo_comercial' => 'veterinariaensuba@hotmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Clínica y Consultorio', 'fuente' => 'Web'],
            ['razon_social' => 'Animania Veterinarios', 'correo_comercial' => 'animania.veterinarios@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Centro Veterinario', 'fuente' => 'Google Maps'],
            ['razon_social' => 'Animal Life Centro Veterinario', 'correo_comercial' => 'vetanimallife2014@hotmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Centro Clínico Veterinario', 'fuente' => 'Google Maps'],
            ['razon_social' => 'Animalandia Clínica Veterinaria', 'correo_comercial' => 'info@animalandia.com.co', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Hospital y Urgencias 24/7', 'fuente' => 'Web'],
            ['razon_social' => 'Clínica Veterinaria Perros y Gatos', 'correo_comercial' => 'clinicaveterinariaperrosygatos@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio'],
            ['razon_social' => 'Clínica Veterinaria Bakatá', 'correo_comercial' => 'veterinaria.bakata@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Centro Médico Veterinario', 'fuente' => 'ICA / Registro'],

            // Zipaquirá y Sabana Centro
            ['razon_social' => 'Veterinaria El Hato', 'correo_comercial' => 'm.v.nino.hernando@hotmail.com', 'municipio' => 'Zipaquirá', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Google Maps Zipaquirá'],
            ['razon_social' => 'Zoo-Clínica La Sabana', 'correo_comercial' => 'info@zooclinicalasabana.com', 'municipio' => 'Zipaquirá', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica & Hospital Veterinario', 'fuente' => 'Google Maps Zipaquirá'],
            ['razon_social' => 'Clínica Veterinaria Dra. María Claudia Tinjacá', 'correo_comercial' => 'info@clinicaveterinariadramariaclaudiatinjaca.com.co', 'municipio' => 'Zipaquirá', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica Especializada', 'fuente' => 'Web Zipaquirá'],
            ['razon_social' => 'Clínica Veterinaria Best Animals', 'correo_comercial' => 'veterinariabestanimals@gmail.com', 'municipio' => 'Zipaquirá', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica & Urgencias', 'fuente' => 'Google Maps'],
            ['razon_social' => 'Felicanvet Cajicá', 'correo_comercial' => 'veterinariafelicanvet@gmail.com', 'municipio' => 'Cajicá', 'departamento' => 'Cundinamarca', 'tipo' => 'Consultorio Veterinario', 'fuente' => 'Google Maps Cajicá'],
            ['razon_social' => 'Inversiones The Royal Pet', 'correo_comercial' => 'veterinariatheroyalpet@gmail.com', 'municipio' => 'Cajicá', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica & Pet Shop', 'fuente' => 'Google Maps Cajicá'],
            ['razon_social' => 'Zonovet Cajicá', 'correo_comercial' => 'verterinariazonovet@gmail.com', 'municipio' => 'Cajicá', 'departamento' => 'Cundinamarca', 'tipo' => 'Servicios Veterinarios', 'fuente' => 'Google Maps Cajicá'],
            ['razon_social' => 'Clínica Veterinaria Pets Colombia', 'correo_comercial' => 'clinicapetscolombia@gmail.com', 'municipio' => 'Chía', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Google Maps Chía'],
            ['razon_social' => 'Animal Services Chía', 'correo_comercial' => 'clinicaveterinaria@animalservices.com.co', 'municipio' => 'Chía', 'departamento' => 'Cundinamarca', 'tipo' => 'Hospital Veterinario 24/7', 'fuente' => 'Google Maps Chía'],
            ['razon_social' => 'Hospital Veterinario Mascotas S.A.S.', 'correo_comercial' => 'hospitalveterinariomascotas@hotmail.com', 'municipio' => 'Cota', 'departamento' => 'Cundinamarca', 'tipo' => 'Hospital Veterinario', 'fuente' => 'ICA Cota'],
            ['razon_social' => 'Vetmédica S.A.S. / Vetxotic', 'correo_comercial' => 'atencion.vetmedica@gmail.com', 'municipio' => 'Tenjo', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Google Maps Tenjo'],
            ['razon_social' => 'Clínica Veterinaria V y V', 'correo_comercial' => 'mvvargasveterinaria@gmail.com', 'municipio' => 'Tenjo', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Google Maps Tenjo'],
            ['razon_social' => 'Clínica Veterinaria Huellas', 'correo_comercial' => 'clinicaveterinariahuellas8@gmail.com', 'municipio' => 'Tabio', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Google Maps Tabio'],
            ['razon_social' => 'Centro Médico Veterinario Vitanimal', 'correo_comercial' => 'cmvitanimal@gmail.com', 'municipio' => 'Tocancipá', 'departamento' => 'Cundinamarca', 'tipo' => 'Centro Médico Veterinario', 'fuente' => 'Google Maps Tocancipá'],
            ['razon_social' => 'Clínica Veterinaria de Funza', 'correo_comercial' => 'clinicaveterinariafunza@hotmail.com', 'municipio' => 'Funza', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Google Maps Funza'],
            ['razon_social' => 'Centro Médico Veterinario Animalitos', 'correo_comercial' => 'veterinaria.animalitos@gmail.com', 'municipio' => 'Funza', 'departamento' => 'Cundinamarca', 'tipo' => 'Consultorio y Pet Shop', 'fuente' => 'Google Maps Funza'],
            ['razon_social' => 'PawerVet Clínica Veterinaria', 'correo_comercial' => 'pawervet@gmail.com', 'municipio' => 'Mosquera', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Google Maps Mosquera'],
            ['razon_social' => 'Clínica Veterinaria Family Pets', 'correo_comercial' => 'info@familypets.com', 'municipio' => 'Madrid', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Google Maps Madrid'],
            ['razon_social' => 'Veterinaria Animal Blue', 'correo_comercial' => 'vetanimalblue@gmail.com', 'municipio' => 'Madrid', 'departamento' => 'Cundinamarca', 'tipo' => 'Servicios Veterinarios', 'fuente' => 'Google Maps Madrid'],
            ['razon_social' => 'Clínica Veterinaria Facatativá', 'correo_comercial' => 'clinicaveterinariadrcesarayala@hotmail.com', 'municipio' => 'Facatativá', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Google Maps Facatativá'],
            ['razon_social' => 'UCLIVET Unidad de Cuidado Clínico', 'correo_comercial' => 'uclivet@hotmail.com', 'municipio' => 'Facatativá', 'departamento' => 'Cundinamarca', 'tipo' => 'Hospital Veterinario', 'fuente' => 'Google Maps Facatativá'],
        ];

        return ProspectoVeterinaria::upsertProspectos($catalogo);
    }
}
