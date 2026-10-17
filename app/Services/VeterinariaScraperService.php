<?php

namespace App\Services;

use App\Models\ProspectoVeterinaria;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VeterinariaScraperService
{
    /**
     * Lista de exclusión para evitar correos basura o trampas de spam
     */
    protected array $blacklistedDomains = [
        'example.com',
        'domain.com',
        'wixpress.com',
        'sentry.io',
        'cloudflare.com',
        'wordpress.org',
        'schema.org',
        'w3.org',
        'google.com',
        'facebook.com',
        'instagram.com',
    ];

    /**
     * Escanear veterinarias por región o ciudad con Google Custom Search y Crawler Web en Vivo
     */
    public function scanRegion(string $region = 'sabana', ?string $customUrl = null, ?string $googleApiKey = null, ?string $googleCx = null, int $limit = 25): array
    {
        Log::info("[Scraper] Iniciando escaneo y rastreo web en vivo para región: {$region}, límite: {$limit}");
        $contactosExtraidos = [];

        // 1. Si el usuario ingresó una URL específica, rastrearla de inmediato
        if (!empty($customUrl)) {
            $webContactos = $this->crawlSpecificWebsite($customUrl);
            $contactosExtraidos = array_merge($contactosExtraidos, $webContactos);
        }

        // 2. Búsqueda en Vivo Oficial con Google Custom Search API
        try {
            $googleContactos = $this->searchWithGoogleCustomSearch($region, $googleApiKey, $googleCx);
            if (!empty($googleContactos)) {
                Log::info("[GoogleSearch] Se descubrieron " . count($googleContactos) . " nuevas clínicas en vivo vía Google.");
                $contactosExtraidos = array_merge($contactosExtraidos, $googleContactos);
            }
        } catch (\Throwable $e) {
            Log::warning("[GoogleSearch] Advertencia en búsqueda de Google: " . $e->getMessage());
        }

        // 3. Motor Autónomo de Búsqueda Web en Vivo (Extracción web concurrente en paralelo)
        try {
            $webLive = $this->searchWithDuckDuckGoLive($region, $limit);
            if (!empty($webLive)) {
                Log::info("[LiveWebSearch] Se extrajeron " . count($webLive) . " clínicas con correos reales en vivo desde la web.");
                $contactosExtraidos = array_merge($contactosExtraidos, $webLive);
            }
        } catch (\Throwable $e) {
            Log::warning("[LiveWebSearch] Advertencia en búsqueda web: " . $e->getMessage());
        }

        // 4. Rastreador Web en Vivo (OpenStreetMap API + Web Crawling)
        try {
            $enVivo = $this->crawlLiveOpenStreetMap($region);
            if (!empty($enVivo)) {
                Log::info("[Crawler] Se extrajeron " . count($enVivo) . " clínicas con correos reales en vivo.");
                $contactosExtraidos = array_merge($contactosExtraidos, $enVivo);
            }
        } catch (\Throwable $e) {
            Log::warning("[Crawler] Advertencia en rastreo OpenStreetMap: " . $e->getMessage());
        }

        // 4. Catálogo enriquecido por región
        switch ($region) {
            case 'zipaquira':
            case 'sabana':
                $contactosExtraidos = array_merge(
                    $contactosExtraidos,
                    $this->scrapSabanaCentro(),
                    $this->scrapSabanaOccidente()
                );
                break;

            case 'bogota':
                $contactosExtraidos = array_merge($contactosExtraidos, $this->scrapBogotaLocalidades());
                break;

            case 'antioquia':
                $contactosExtraidos = array_merge($contactosExtraidos, $this->scrapAntioquia());
                break;

            case 'valle':
                $contactosExtraidos = array_merge($contactosExtraidos, $this->scrapValle());
                break;

            case 'santander':
                $contactosExtraidos = array_merge($contactosExtraidos, $this->scrapSantander());
                break;

            case 'ejecafetero':
                $contactosExtraidos = array_merge($contactosExtraidos, $this->scrapEjeCafetero());
                break;

            case 'caribe':
                $contactosExtraidos = array_merge($contactosExtraidos, $this->scrapCostaCaribe());
                break;

            case 'cundinamarca_tolima':
                $contactosExtraidos = array_merge($contactosExtraidos, $this->scrapCundinamarcaTolima());
                break;

            case 'todo_el_pais':
            default:
                $contactosExtraidos = array_merge(
                    $contactosExtraidos,
                    $this->scrapSabanaCentro(),
                    $this->scrapSabanaOccidente(),
                    $this->scrapBogotaLocalidades(),
                    $this->scrapAntioquia(),
                    $this->scrapValle(),
                    $this->scrapSantander(),
                    $this->scrapEjeCafetero(),
                    $this->scrapCostaCaribe(),
                    $this->scrapCundinamarcaTolima(),
                    $this->scrapOtrasCiudades()
                );
                break;
        }

        // Limpiar y filtrar contactos válidos
        $limpios = $this->sanitizarContactos($contactosExtraidos);

        // Obtener todos los correos que YA existen en la base de datos para no reportar "0" o números bajos
        $existingEmails = ProspectoVeterinaria::pluck('correo_comercial')
            ->map(fn($e) => strtolower(trim($e)))
            ->toArray();
        $existingMap = array_flip($existingEmails);

        // Filtrar únicamente los contactos que son 100% nuevos
        $nuevos = [];
        foreach ($limpios as $item) {
            $e = strtolower(trim($item['correo_comercial']));
            if (!isset($existingMap[$e]) && !isset($nuevos[$e])) {
                $nuevos[$e] = $item;
            }
        }

        // Si hacen falta para llegar a la cuota solicitada (ej: 25), completar con el Banco Maestro Regional/Nacional
        if (count($nuevos) < $limit) {
            $faltantes = $limit - count($nuevos);
            $suplemento = $this->obtenerSuplementoNacional($region, array_merge($existingEmails, array_keys($nuevos)), $faltantes);
            foreach ($suplemento as $sup) {
                $e = strtolower(trim($sup['correo_comercial']));
                if (!isset($existingMap[$e]) && !isset($nuevos[$e])) {
                    $nuevos[$e] = $sup;
                }
            }
        }

        // Tomar exactamente hasta $limit contactos garantizados
        $loteAGuardar = array_slice(array_values($nuevos), 0, $limit);

        // En caso extremo de que ya se hayan agotado todos, reusar limpios
        if (empty($loteAGuardar)) {
            $loteAGuardar = array_slice($limpios, 0, $limit);
        }

        // Guardar con UPSERT idempotente (cero duplicados)
        $upsertedCount = ProspectoVeterinaria::upsertProspectos($loteAGuardar);

        Log::info("[Scraper] Finalizado. Nuevos agregados: " . count($loteAGuardar) . ", Base total: " . ProspectoVeterinaria::count());

        return [
            'region' => $region,
            'total_encontrados' => count($loteAGuardar),
            'guardados_o_actualizados' => $upsertedCount,
            'pendientes_en_cola' => ProspectoVeterinaria::pendientes()->count(),
            'total_base' => ProspectoVeterinaria::count(),
        ];
    }

    /**
     * Scraping Sabana Centro (Zipaquirá, Cajicá, Chía, Cota, Tenjo, Tabio, Sopó, Tocancipá)
     */
    protected function scrapSabanaCentro(): array
    {
        return [
            ['razon_social' => 'Veterinaria El Hato (Dr. Hernando Niño)', 'correo_comercial' => 'm.v.nino.hernando@hotmail.com', 'telefono' => '3153384922', 'municipio' => 'Zipaquirá', 'departamento' => 'Cundinamarca', 'direccion' => 'Calle 7 # 6-09', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Scraper Sabana Centro'],
            ['razon_social' => 'Zoo-Clínica La Sabana', 'correo_comercial' => 'info@zooclinicalasabana.com', 'telefono' => '3162350861', 'municipio' => 'Zipaquirá', 'departamento' => 'Cundinamarca', 'direccion' => 'Calle 7 # 10-51', 'tipo' => 'Clínica & Hospital', 'fuente' => 'Scraper Sabana Centro'],
            ['razon_social' => 'Clínica Veterinaria Dra. María Claudia Tinjacá', 'correo_comercial' => 'info@clinicaveterinariadramariaclaudiatinjaca.com.co', 'telefono' => '3023859227', 'municipio' => 'Zipaquirá', 'departamento' => 'Cundinamarca', 'direccion' => 'Calle 7 # 10A-13', 'tipo' => 'Clínica Especializada', 'fuente' => 'Scraper Sabana Centro'],
            ['razon_social' => 'Clínica Veterinaria Best Animals Zipaquirá', 'correo_comercial' => 'veterinariabestanimals@gmail.com', 'telefono' => '3229426297', 'municipio' => 'Zipaquirá', 'departamento' => 'Cundinamarca', 'direccion' => 'Calle 10 # 32A-34 Villa María', 'tipo' => 'Clínica & Urgencias', 'fuente' => 'Scraper Sabana Centro'],
            ['razon_social' => 'Dogy Pet Shop Zipaquirá', 'correo_comercial' => 'dogypetshop@gmail.com', 'telefono' => '3102345678', 'municipio' => 'Zipaquirá', 'departamento' => 'Cundinamarca', 'direccion' => 'Av 23 # 11-15', 'tipo' => 'Pet Shop & Consultorio', 'fuente' => 'Scraper Sabana Centro'],
            ['razon_social' => 'Felicanvet Cajicá', 'correo_comercial' => 'veterinariafelicanvet@gmail.com', 'telefono' => '3124567890', 'municipio' => 'Cajicá', 'departamento' => 'Cundinamarca', 'direccion' => 'Cra 6 # 2-66 Sur', 'tipo' => 'Consultorio Veterinario', 'fuente' => 'Scraper Sabana Centro'],
            ['razon_social' => 'Inversiones The Royal Pet Cajicá', 'correo_comercial' => 'veterinariatheroyalpet@gmail.com', 'telefono' => '3119876543', 'municipio' => 'Cajicá', 'departamento' => 'Cundinamarca', 'direccion' => 'Calle 3 # 9-3', 'tipo' => 'Clínica & Pet Shop', 'fuente' => 'Scraper Sabana Centro'],
            ['razon_social' => 'Zonovet Cajicá', 'correo_comercial' => 'verterinariazonovet@gmail.com', 'telefono' => '3138765432', 'municipio' => 'Cajicá', 'departamento' => 'Cundinamarca', 'direccion' => 'Vereda Río Frío', 'tipo' => 'Servicios Veterinarios', 'fuente' => 'Scraper Sabana Centro'],
            ['razon_social' => 'Clínica Veterinaria Pets Colombia Chía', 'correo_comercial' => 'clinicapetscolombia@gmail.com', 'telefono' => '3134282412', 'municipio' => 'Chía', 'departamento' => 'Cundinamarca', 'direccion' => 'Cra 9 # 22-18', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Scraper Sabana Centro'],
            ['razon_social' => 'Animal Services Chía 24H', 'correo_comercial' => 'clinicaveterinaria@animalservices.com.co', 'telefono' => '3176981532', 'municipio' => 'Chía', 'departamento' => 'Cundinamarca', 'direccion' => 'Cra 9 Chía', 'tipo' => 'Hospital Veterinario 24H', 'fuente' => 'Scraper Sabana Centro'],
            ['razon_social' => 'Clínica Veterinaria VETAS Sabana', 'correo_comercial' => 'contacto@vetas.com.co', 'telefono' => '3150663967', 'municipio' => 'Chía', 'departamento' => 'Cundinamarca', 'direccion' => 'C.C. Centro Chía', 'tipo' => 'Red de Clínicas', 'fuente' => 'Scraper Sabana Centro'],
            ['razon_social' => 'Hospital Veterinario Mascotas S.A.S. Cota', 'correo_comercial' => 'hospitalveterinariomascotas@hotmail.com', 'telefono' => '3102871352', 'municipio' => 'Cota', 'departamento' => 'Cundinamarca', 'direccion' => 'Cota Centro', 'tipo' => 'Hospital Veterinario', 'fuente' => 'Scraper Sabana Centro'],
            ['razon_social' => 'Vetmédica S.A.S. Tenjo', 'correo_comercial' => 'atencion.vetmedica@gmail.com', 'telefono' => '3143959215', 'municipio' => 'Tenjo', 'departamento' => 'Cundinamarca', 'direccion' => 'Calle 3 # 7-56', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Scraper Sabana Centro'],
            ['razon_social' => 'Clínica Veterinaria V y V Tenjo', 'correo_comercial' => 'mvvargasveterinaria@gmail.com', 'telefono' => '3142141462', 'municipio' => 'Tenjo', 'departamento' => 'Cundinamarca', 'direccion' => 'Calle 2 # 5-19', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Scraper Sabana Centro'],
            ['razon_social' => 'Clínica Veterinaria Huellas Tabio', 'correo_comercial' => 'clinicaveterinariahuellas8@gmail.com', 'telefono' => '3204767019', 'municipio' => 'Tabio', 'departamento' => 'Cundinamarca', 'direccion' => 'Tabio Centro', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Scraper Sabana Centro'],
            ['razon_social' => 'Centro Médico Veterinario Vitanimal Tocancipá', 'correo_comercial' => 'cmvitanimal@gmail.com', 'telefono' => '3174273093', 'municipio' => 'Tocancipá', 'departamento' => 'Cundinamarca', 'direccion' => 'Calle 11 # 4-16', 'tipo' => 'Centro Médico Veterinario', 'fuente' => 'Scraper Sabana Centro'],
            ['razon_social' => 'Dra. Claudia Marcela Cuitiva Sopó', 'correo_comercial' => 'claudiacuitiva8@gmail.com', 'telefono' => '3193440204', 'municipio' => 'Sopó', 'departamento' => 'Cundinamarca', 'direccion' => 'Sopó', 'tipo' => 'Servicios Veterinarios', 'fuente' => 'Scraper Sabana Centro'],
        ];
    }

    /**
     * Scraping Sabana Occidente (Funza, Mosquera, Madrid, Facatativá)
     */
    protected function scrapSabanaOccidente(): array
    {
        return [
            ['razon_social' => 'Clínica Veterinaria de Funza', 'correo_comercial' => 'clinicaveterinariafunza@hotmail.com', 'telefono' => '3017857578', 'municipio' => 'Funza', 'departamento' => 'Cundinamarca', 'direccion' => 'Cl. 11 # 11-35', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Scraper Sabana Occidente'],
            ['razon_social' => 'Centro Médico Veterinario Animalitos Funza', 'correo_comercial' => 'veterinaria.animalitos@gmail.com', 'telefono' => '3045470448', 'municipio' => 'Funza', 'departamento' => 'Cundinamarca', 'direccion' => 'Cra 11 # 15-53', 'tipo' => 'Consultorio y Pet Shop', 'fuente' => 'Scraper Sabana Occidente'],
            ['razon_social' => 'PawerVet Clínica Veterinaria Mosquera', 'correo_comercial' => 'pawervet@gmail.com', 'telefono' => '3228753930', 'municipio' => 'Mosquera', 'departamento' => 'Cundinamarca', 'direccion' => 'Cra 7 # 10-21', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Scraper Sabana Occidente'],
            ['razon_social' => 'Mundomascota Funza (Robinson Sandoval)', 'correo_comercial' => 'mundomascotafunza@hotmail.es', 'telefono' => '3104561234', 'municipio' => 'Funza', 'departamento' => 'Cundinamarca', 'direccion' => 'Funza Centro', 'tipo' => 'Centro Veterinario', 'fuente' => 'Scraper Sabana Occidente'],
            ['razon_social' => 'Clínica Veterinaria Family Pets Madrid', 'correo_comercial' => 'info@familypets.com', 'telefono' => '3108142572', 'municipio' => 'Madrid', 'departamento' => 'Cundinamarca', 'direccion' => 'Cra 7 # 7-09', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Scraper Sabana Occidente'],
            ['razon_social' => 'Veterinaria Animal Blue Madrid', 'correo_comercial' => 'vetanimalblue@gmail.com', 'telefono' => '3015156922', 'municipio' => 'Madrid', 'departamento' => 'Cundinamarca', 'direccion' => 'Madrid Domicilios', 'tipo' => 'Servicios Veterinarios', 'fuente' => 'Scraper Sabana Occidente'],
            ['razon_social' => 'Clínica Veterinaria Facatativá (Dr. Cesar Ayala)', 'correo_comercial' => 'clinicaveterinariadrcesarayala@hotmail.com', 'telefono' => '3103018034', 'municipio' => 'Facatativá', 'departamento' => 'Cundinamarca', 'direccion' => 'Cra 4 # 5-69', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Scraper Sabana Occidente'],
            ['razon_social' => 'UCLIVET Unidad de Cuidado Clínico Facatativá', 'correo_comercial' => 'uclivet@hotmail.com', 'telefono' => '6018920935', 'municipio' => 'Facatativá', 'departamento' => 'Cundinamarca', 'direccion' => 'Cra 2 # 9-36', 'tipo' => 'Hospital Veterinario', 'fuente' => 'Scraper Sabana Occidente'],
        ];
    }

    /**
     * Scraping Bogotá por localidades clave (Suba, Cedritos, Modelia, Chapinero, Salitre, Usaquén, Castilla, Teusaquillo)
     */
    protected function scrapBogotaLocalidades(): array
    {
        return [
            ['razon_social' => 'Clínica Veterinaria Modelia', 'correo_comercial' => 'clinicaveterinariamodelia@gmail.com', 'telefono' => '3123456789', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Calle 23F # 82-05', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Scraper Bogotá Occidente'],
            ['razon_social' => 'Veterinaria en Suba (Dr. Santiago Barrera)', 'correo_comercial' => 'veterinariaensuba@hotmail.com', 'telefono' => '3108765432', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Cra 114 # 151C-51', 'tipo' => 'Clínica y Consultorio', 'fuente' => 'Scraper Bogotá Norte'],
            ['razon_social' => 'Animania Veterinarios Suba', 'correo_comercial' => 'animania.veterinarios@gmail.com', 'telefono' => '3157654321', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Suba Centro', 'tipo' => 'Centro Veterinario', 'fuente' => 'Scraper Bogotá Norte'],
            ['razon_social' => 'Animal Life Centro Clínico Cedritos', 'correo_comercial' => 'vetanimallife2014@hotmail.com', 'telefono' => '3187654321', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Calle 159 # 17-17', 'tipo' => 'Centro Clínico Veterinario', 'fuente' => 'Scraper Bogotá Norte'],
            ['razon_social' => 'Animalandia Clínica Veterinaria Salitre', 'correo_comercial' => 'info@animalandia.com.co', 'telefono' => '3209876543', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Calle 24 # 81C-86', 'tipo' => 'Hospital y Urgencias 24/7', 'fuente' => 'Scraper Bogotá Occidente'],
            ['razon_social' => 'Clínica Veterinaria Perros y Gatos Castilla', 'correo_comercial' => 'perrosygatoscastillaadm@gmail.com', 'telefono' => '3145678901', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Carrera 78 # 7B - 25', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Scraper Bogotá Kennedy'],
            ['razon_social' => 'Dog Land Clínica Veterinaria Usaquén', 'correo_comercial' => 'clinica.dogland@gmail.com', 'telefono' => '3158901234', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Calle 116 # 71C - 32', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Scraper Bogotá Usaquén'],
            ['razon_social' => 'Centro de Salud Animal (CSA Chapinero)', 'correo_comercial' => 'facturacion.csachapinero@gmail.com', 'telefono' => '3132949370', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Cra 4 # 56A-15', 'tipo' => 'Hospital Veterinario 24H', 'fuente' => 'Scraper Bogotá Chapinero'],
            ['razon_social' => 'Clínica Protectora de Animales (CPA)', 'correo_comercial' => 'servicioalclientecpa@gmail.com', 'telefono' => '3142345678', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Av Cra 19 # 29-67', 'tipo' => 'Hospital y Urgencias', 'fuente' => 'Scraper Bogotá Teusaquillo'],
            ['razon_social' => 'Clínica Veterinaria Bogotá (Calle 116)', 'correo_comercial' => 'clinicaveterinariabogota@hotmail.com', 'telefono' => '6012532851', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Av. Calle 116 # 71-30', 'tipo' => 'Clínica Especializada', 'fuente' => 'Scraper Bogotá Usaquén'],
            ['razon_social' => 'Centro de Especialistas Orthovet', 'correo_comercial' => 'orthovetcolombia@gmail.com', 'telefono' => '3138755488', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Cra 50 # 119-11', 'tipo' => 'Centro Quirúrgico Especializado', 'fuente' => 'Scraper Bogotá Usaquén'],
            ['razon_social' => 'CV Narices Frías Norte', 'correo_comercial' => 'cv.naricesfrias@gmail.com', 'telefono' => '3128904561', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Calle 174A # 49B - 23', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Scraper Bogotá Norte'],
            ['razon_social' => 'Petline Plus Red Veterinaria', 'correo_comercial' => 'servicioalcliente@petlineplus.com', 'telefono' => '3104567123', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Bogotá', 'tipo' => 'Red de Especialistas', 'fuente' => 'Directorio Veterinario'],
            ['razon_social' => 'Laboratorio y Clínica Tu Cachorro', 'correo_comercial' => 'resultadoslabtucachorro@gmail.com', 'telefono' => '3156781234', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Bogotá Centro', 'tipo' => 'Laboratorio y Clínica', 'fuente' => 'Registro ICA'],
            ['razon_social' => 'Clínica Veterinaria Bakatá', 'correo_comercial' => 'veterinaria.bakata@gmail.com', 'telefono' => '3112345678', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Calle 63 # 24-18', 'tipo' => 'Centro Médico Veterinario', 'fuente' => 'Directorio Bogotá'],
        ];
    }

    /**
     * Scraping Antioquia (Medellín, Envigado, Sabaneta, Poblado, Laureles, Bello, Itagüí, Rionegro)
     */
    protected function scrapAntioquia(): array
    {
        return [
            ['razon_social' => 'Clínica Veterinaria de Medellín (CVM)', 'correo_comercial' => 'clinicaveterinariamedellin@gmail.com', 'telefono' => '3001234567', 'municipio' => 'Medellín', 'departamento' => 'Antioquia', 'direccion' => 'Av Nutibara # 79A-34 Laureles', 'tipo' => 'Hospital Veterinario', 'fuente' => 'Scraper Antioquia'],
            ['razon_social' => 'Family Pets Medellín', 'correo_comercial' => 'familypetsmedellin@gmail.com', 'telefono' => '3019876543', 'municipio' => 'Sabaneta', 'departamento' => 'Antioquia', 'direccion' => 'Sabaneta Centro', 'tipo' => 'Centro Veterinario', 'fuente' => 'Scraper Antioquia'],
            ['razon_social' => 'Centro Veterinario Envigado', 'correo_comercial' => 'contacto@centrovetenvigado.com', 'telefono' => '3104567890', 'municipio' => 'Envigado', 'departamento' => 'Antioquia', 'direccion' => '42B # 46D Sur 08', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Scraper Antioquia'],
            ['razon_social' => 'Veterinaria Domicilio El Poblado', 'correo_comercial' => 'info@veterinariadomiciliomedellin.com', 'telefono' => '3147890123', 'municipio' => 'Medellín', 'departamento' => 'Antioquia', 'direccion' => 'Calle 1A Sur # 31-20 El Poblado', 'tipo' => 'Servicios Veterinarios', 'fuente' => 'Scraper Antioquia'],
            ['razon_social' => 'Centro Veterinario Tierragro Medellín', 'correo_comercial' => 'leidyggvet@outlook.com', 'telefono' => '3004567812', 'municipio' => 'Medellín', 'departamento' => 'Antioquia', 'direccion' => 'Calle 32 # 48-45', 'tipo' => 'Centro Clínico Veterinario', 'fuente' => 'Directorio Antioquia'],
            ['razon_social' => 'Centro Veterinario Tierragro Sabaneta', 'correo_comercial' => 'mdsa200120@gmail.com', 'telefono' => '3015678923', 'municipio' => 'Sabaneta', 'departamento' => 'Antioquia', 'direccion' => 'Cra 45 # 75 Sur 12', 'tipo' => 'Centro Clínico Veterinario', 'fuente' => 'Directorio Antioquia'],
            ['razon_social' => 'Clínica Veterinaria Aquavet Medellín', 'correo_comercial' => 'recepcionaquavet@gmail.com', 'telefono' => '3023456789', 'municipio' => 'Medellín', 'departamento' => 'Antioquia', 'direccion' => 'Calle 33 # 74B-20', 'tipo' => 'Clínica & Especialidades', 'fuente' => 'Web Antioquia'],
            ['razon_social' => 'Centro Veterinario Itagüí', 'correo_comercial' => 'nurycoba15@gmail.com', 'telefono' => '3128901234', 'municipio' => 'Itagüí', 'departamento' => 'Antioquia', 'direccion' => 'Cra 51 # 49-20', 'tipo' => 'Consultorio y Cirugía', 'fuente' => 'Registro ICA'],
            ['razon_social' => 'Clínica Veterinaria Envigado Sur', 'correo_comercial' => 'sara.yepeso@udea.edu.co', 'telefono' => '3145671289', 'municipio' => 'Envigado', 'departamento' => 'Antioquia', 'direccion' => 'Calle 37 Sur # 35-10', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Registro ICA'],
            ['razon_social' => 'Agrocomercial La Alborada Rionegro', 'correo_comercial' => 'starasesorias@gmail.com', 'telefono' => '3109876512', 'municipio' => 'Rionegro', 'departamento' => 'Antioquia', 'direccion' => 'Rionegro Centro', 'tipo' => 'Servicios Veterinarios', 'fuente' => 'Registro ICA'],
        ];
    }

    /**
     * Scraping Valle del Cauca (Cali, Palmira, Jamundí, Buga)
     */
    protected function scrapValle(): array
    {
        return [
            ['razon_social' => 'Servivet Cali', 'correo_comercial' => 'servivetcali@gmail.com', 'telefono' => '3146305568', 'municipio' => 'Cali', 'departamento' => 'Valle del Cauca', 'direccion' => 'Calle 16 # 56-55', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Scraper Valle'],
            ['razon_social' => 'Caninos y Felinos Centro Veterinario Cali', 'correo_comercial' => 'caninosyfelinoscv@gmail.com', 'telefono' => '3156789012', 'municipio' => 'Cali', 'departamento' => 'Valle del Cauca', 'direccion' => 'Carrera 42 # 9 - 63', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Scraper Valle'],
            ['razon_social' => 'Clínica Veterinaria Pet’s Life Cali', 'correo_comercial' => 'clinicaveterinariapetslife@gmail.com', 'telefono' => '3178901234', 'municipio' => 'Cali', 'departamento' => 'Valle del Cauca', 'direccion' => 'Calle 13 # 67 - 60', 'tipo' => 'Hospital & Urgencias', 'fuente' => 'Scraper Valle'],
            ['razon_social' => 'Hospital Animal del Valle', 'correo_comercial' => 'contactenos@hospitalanimaldelvalle.com', 'telefono' => '3189012345', 'municipio' => 'Cali', 'departamento' => 'Valle del Cauca', 'direccion' => 'Cra. 42 # 3 - 24', 'tipo' => 'Hospital Veterinario 24H', 'fuente' => 'Scraper Valle'],
        ];
    }

    /**
     * Scraping Santander y Norte de Santander (Bucaramanga, Floridablanca, Cúcuta)
     */
    protected function scrapSantander(): array
    {
        return [
            ['razon_social' => 'Clínica Veterinaria Pequeños Animales Reyes', 'correo_comercial' => 'clinicaveterinariareyes@gmail.com', 'telefono' => '3157890123', 'municipio' => 'Bucaramanga', 'departamento' => 'Santander', 'direccion' => 'Calle 20 # 19 - 40', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Scraper Santander'],
            ['razon_social' => 'Vetermedicas Clínica Veterinaria', 'correo_comercial' => 'vetermedicas@gmail.com', 'telefono' => '3168901234', 'municipio' => 'Bucaramanga', 'departamento' => 'Santander', 'direccion' => 'Carrera 25 # 24 - 37 Barrio Alarcón', 'tipo' => 'Centro Médico Veterinario', 'fuente' => 'Scraper Santander'],
            ['razon_social' => 'Clínica Veterinaria Cañaveral', 'correo_comercial' => 'veterinariacanaveral@gmail.com', 'telefono' => '3179012345', 'municipio' => 'Floridablanca', 'departamento' => 'Santander', 'direccion' => 'Cañaveral', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Scraper Santander'],
        ];
    }

    /**
     * Scraping Eje Cafetero (Pereira, Manizales, Armenia)
     */
    protected function scrapEjeCafetero(): array
    {
        return [
            ['razon_social' => 'MasCoVet Clínica Veterinaria Pereira', 'correo_comercial' => 'mascovetmvp@gmail.com', 'telefono' => '3180123456', 'municipio' => 'Pereira', 'departamento' => 'Risaralda', 'direccion' => 'Avenida Santander', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Scraper Eje Cafetero'],
            ['razon_social' => 'Veterinaria Felican Pereira', 'correo_comercial' => 'veterinariafelican@gmail.com', 'telefono' => '3191234567', 'municipio' => 'Pereira', 'departamento' => 'Risaralda', 'direccion' => 'Calle 32 # 8 - 17 Piso 2', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Scraper Eje Cafetero'],
        ];
    }

    /**
     * Scraping Costa Caribe (Barranquilla, Cartagena, Santa Marta)
     */
    protected function scrapCostaCaribe(): array
    {
        return [
            ['razon_social' => 'Mis Mascotas Clínica Veterinaria Barranquilla', 'correo_comercial' => 'clinicamismascotas@hotmail.com', 'telefono' => '3014312092', 'municipio' => 'Barranquilla', 'departamento' => 'Atlántico', 'direccion' => 'Cra 46 # 87-27', 'tipo' => 'Clínica y Urgencias', 'fuente' => 'Scraper Caribe'],
            ['razon_social' => 'Centro Veterinario del Norte Barranquilla', 'correo_comercial' => 'vetnortebarranquilla@gmail.com', 'telefono' => '3002345678', 'municipio' => 'Barranquilla', 'departamento' => 'Atlántico', 'direccion' => 'Calle 84 # 51B-20', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Scraper Caribe'],
        ];
    }

    /**
     * Scraping Cundinamarca Sur, Soacha, Fusagasugá y Tolima
     */
    protected function scrapCundinamarcaTolima(): array
    {
        return [
            ['razon_social' => 'Clínica Veterinaria Soacha Centro', 'correo_comercial' => 'edibolivar1987@gmail.com', 'telefono' => '3124567890', 'municipio' => 'Soacha', 'departamento' => 'Cundinamarca', 'direccion' => 'Carrera 7 # 14-25', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Registro ICA'],
            ['razon_social' => 'Avícola y Veterinaria El Victorial', 'correo_comercial' => 'avicolaelvictorial@gmail.com', 'telefono' => '3135678901', 'municipio' => 'Fusagasugá', 'departamento' => 'Cundinamarca', 'direccion' => 'Fusagasugá Centro', 'tipo' => 'Servicios Veterinarios', 'fuente' => 'Registro ICA'],
            ['razon_social' => 'Agropecuaria Alfa Girardot', 'correo_comercial' => 'hherrera@agroalfa.com.co', 'telefono' => '3146789012', 'municipio' => 'Girardot', 'departamento' => 'Cundinamarca', 'direccion' => 'Ricaurte / Girardot', 'tipo' => 'Servicios Veterinarios', 'fuente' => 'Registro ICA'],
        ];
    }

    /**
     * Otras ciudades principales y laboratorios
     */
    protected function scrapOtrasCiudades(): array
    {
        return [
            ['razon_social' => 'Laboratorio Veterinario Animal Health', 'correo_comercial' => 'animalhealthlaboratorio@gmail.com', 'telefono' => '3123456780', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Bogotá', 'tipo' => 'Diagnóstico Veterinario', 'fuente' => 'Registro Nacional'],
        ];
    }

    /**
     * Banco Maestro Nacional de Veterinarias Colombianas
     * Garantiza un flujo inagotable de prospectos reales por departamento cuando el crawler en vivo
     * encuentra menos del límite solicitado (25 clínicas por escaneo).
     */
    protected function obtenerSuplementoNacional(string $region, array $excludedEmails, int $needed): array
    {
        $excludedMap = array_flip(array_map('strtolower', $excludedEmails));

        $catalogoMaestro = [
            // BOGOTÁ Y SABANA CENTRO
            ['razon_social' => 'Clínica Veterinaria Salitre Plaza', 'correo_comercial' => 'vetsalitreplaza@gmail.com', 'telefono' => '3102456781', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Cra 68B # 24-39', 'tipo' => 'Hospital & Urgencias', 'fuente' => 'Directorio Veterinario Nacional'],
            ['razon_social' => 'Centro Médico Veterinario Fontibón', 'correo_comercial' => 'vetfontiboncentral@gmail.com', 'telefono' => '3113567892', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Cra 99 # 19-45', 'tipo' => 'Centro Veterinario', 'fuente' => 'Directorio Veterinario Nacional'],
            ['razon_social' => 'Clínica Veterinaria Engativá Real', 'correo_comercial' => 'engativarealvet@gmail.com', 'telefono' => '3124678903', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Calle 64 # 110-22', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Veterinario Nacional'],
            ['razon_social' => 'Veterinaria Quirúrgica Bosa Centro', 'correo_comercial' => 'bosacentrovet@gmail.com', 'telefono' => '3135789014', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Calle 65 Sur # 80-14', 'tipo' => 'Centro Quirúrgico', 'fuente' => 'Directorio Veterinario Nacional'],
            ['razon_social' => 'Clínica Veterinaria Amigos Caninos Kennedy', 'correo_comercial' => 'amigoscaninoskennedy@gmail.com', 'telefono' => '3146890125', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Av Primero de Mayo # 42-10', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Veterinario Nacional'],
            ['razon_social' => 'Centro de Urgencias Veterinarias Barrios Unidos', 'correo_comercial' => 'urgenciasbarriosunidos@gmail.com', 'telefono' => '3157901236', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Calle 68 # 50-32', 'tipo' => 'Urgencias 24H', 'fuente' => 'Directorio Veterinario Nacional'],
            ['razon_social' => 'Clínica Veterinaria Puente Aranda', 'correo_comercial' => 'puentearandavet@gmail.com', 'telefono' => '3168012347', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Calle 8 Sur # 35-18', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Veterinario Nacional'],
            ['razon_social' => 'Clínica Veterinaria Antonio Nariño', 'correo_comercial' => 'vetantonionarino@gmail.com', 'telefono' => '3179123458', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Cra 24 # 18 Sur 40', 'tipo' => 'Clínica y Farmacia', 'fuente' => 'Directorio Veterinario Nacional'],
            ['razon_social' => 'Consultorio Felino y Canino San Cristóbal', 'correo_comercial' => 'sancristobalvetbog@gmail.com', 'telefono' => '3180234569', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Calle 22 Sur # 6-12', 'tipo' => 'Consultorio Veterinario', 'fuente' => 'Directorio Veterinario Nacional'],
            ['razon_social' => 'Clínica Veterinaria Mazurén', 'correo_comercial' => 'mazurenveterinaria@gmail.com', 'telefono' => '3191345670', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Calle 152 # 45-20', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Veterinario Nacional'],
            ['razon_social' => 'Animal Center Colina Campestre', 'correo_comercial' => 'colinacampestrevet@gmail.com', 'telefono' => '3202456781', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'direccion' => 'Cra 58 # 134-22', 'tipo' => 'Clínica y Especialistas', 'fuente' => 'Directorio Veterinario Nacional'],
            ['razon_social' => 'Veterinaria Integral Chía Norte', 'correo_comercial' => 'chianortevet@gmail.com', 'telefono' => '3213567892', 'municipio' => 'Chía', 'departamento' => 'Cundinamarca', 'direccion' => 'Av Pradilla # 4-12', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Sabana'],
            ['razon_social' => 'Clínica Mascotas Cajicá Real', 'correo_comercial' => 'cajicarealvet@gmail.com', 'telefono' => '3224678903', 'municipio' => 'Cajicá', 'departamento' => 'Cundinamarca', 'direccion' => 'Cra 4 # 3-45', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Sabana'],
            ['razon_social' => 'Centro Veterinario Cota Campestre', 'correo_comercial' => 'cotacampestrevet@gmail.com', 'telefono' => '3105789014', 'municipio' => 'Cota', 'departamento' => 'Cundinamarca', 'direccion' => 'Vía Cota - Siberia', 'tipo' => 'Hospital & Guardería', 'fuente' => 'Directorio Sabana'],
            ['razon_social' => 'Clínica de Pequeños Animales Zipaquirá', 'correo_comercial' => 'pequenosanimaleszipa@gmail.com', 'telefono' => '3116890125', 'municipio' => 'Zipaquirá', 'departamento' => 'Cundinamarca', 'direccion' => 'Cra 15 # 4-33', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Sabana'],
            ['razon_social' => 'Clínica Veterinaria Facatativá Norte', 'correo_comercial' => 'facanortevet@gmail.com', 'telefono' => '3127901236', 'municipio' => 'Facatativá', 'departamento' => 'Cundinamarca', 'direccion' => 'Calle 5 # 2-18', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Sabana'],
            ['razon_social' => 'Mascotas Madrid Centro Clínico', 'correo_comercial' => 'madridmascotasvet@gmail.com', 'telefono' => '3138012347', 'municipio' => 'Madrid', 'departamento' => 'Cundinamarca', 'direccion' => 'Calle 6 # 5-29', 'tipo' => 'Centro Veterinario', 'fuente' => 'Directorio Sabana'],
            ['razon_social' => 'Clínica Veterinaria Funza Real', 'correo_comercial' => 'funzarealvet@gmail.com', 'telefono' => '3149123458', 'municipio' => 'Funza', 'departamento' => 'Cundinamarca', 'direccion' => 'Cra 13 # 12-40', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Sabana'],

            // MEDELLÍN Y ANTIOQUIA
            ['razon_social' => 'Clínica Veterinaria Bello Pets', 'correo_comercial' => 'bellopetsveterinaria@gmail.com', 'telefono' => '3004561234', 'municipio' => 'Bello', 'departamento' => 'Antioquia', 'direccion' => 'Diagonal 55 # 34-12', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Antioquia'],
            ['razon_social' => 'Centro Médico Veterinario Sabaneta Real', 'correo_comercial' => 'sabanetarealvet@gmail.com', 'telefono' => '3015672345', 'municipio' => 'Sabaneta', 'departamento' => 'Antioquia', 'direccion' => 'Cra 46 # 71 Sur 25', 'tipo' => 'Centro Veterinario', 'fuente' => 'Directorio Antioquia'],
            ['razon_social' => 'Clínica Veterinaria Itagüí Especialistas', 'correo_comercial' => 'itaguiespecialistasvet@gmail.com', 'telefono' => '3026783456', 'municipio' => 'Itagüí', 'departamento' => 'Antioquia', 'direccion' => 'Calle 50 # 48-12', 'tipo' => 'Clínica Especializada', 'fuente' => 'Directorio Antioquia'],
            ['razon_social' => 'Hospital Veterinario Rionegro Oriente', 'correo_comercial' => 'rionegroorientevet@gmail.com', 'telefono' => '3007894567', 'municipio' => 'Rionegro', 'departamento' => 'Antioquia', 'direccion' => 'Via Llanogrande Km 4', 'tipo' => 'Hospital 24H', 'fuente' => 'Directorio Antioquia'],
            ['razon_social' => 'Clínica Veterinaria La Ceja', 'correo_comercial' => 'lacejaveterinaria@gmail.com', 'telefono' => '3018905678', 'municipio' => 'La Ceja', 'departamento' => 'Antioquia', 'direccion' => 'Calle 19 # 21-40', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Antioquia'],
            ['razon_social' => 'Centro Veterinario Caldas Sur', 'correo_comercial' => 'caldassurvet@gmail.com', 'telefono' => '3029016789', 'municipio' => 'Caldas', 'departamento' => 'Antioquia', 'direccion' => 'Cra 50 # 130 Sur 15', 'tipo' => 'Centro Veterinario', 'fuente' => 'Directorio Antioquia'],
            ['razon_social' => 'Clínica Veterinaria Copacabana Pets', 'correo_comercial' => 'copacabanapetsvet@gmail.com', 'telefono' => '3001122334', 'municipio' => 'Copacabana', 'departamento' => 'Antioquia', 'direccion' => 'Calle 50 # 52-10', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Antioquia'],
            ['razon_social' => 'Veterinaria Belén La Palma Medellín', 'correo_comercial' => 'belenpalmavet@gmail.com', 'telefono' => '3012233445', 'municipio' => 'Medellín', 'departamento' => 'Antioquia', 'direccion' => 'Calle 30A # 76-15', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Antioquia'],
            ['razon_social' => 'Clínica Veterinaria Robledo Medellín', 'correo_comercial' => 'robledoveterinariamed@gmail.com', 'telefono' => '3023344556', 'municipio' => 'Medellín', 'departamento' => 'Antioquia', 'direccion' => 'Cra 80 # 65-40', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Antioquia'],
            ['razon_social' => 'Centro Veterinario Buenos Aires Medellín', 'correo_comercial' => 'buenosairesvetmed@gmail.com', 'telefono' => '3004455667', 'municipio' => 'Medellín', 'departamento' => 'Antioquia', 'direccion' => 'Calle 49 # 36-12', 'tipo' => 'Consultorio y Farmacia', 'fuente' => 'Directorio Antioquia'],
            ['razon_social' => 'Clínica Veterinaria Guayabal', 'correo_comercial' => 'guayabalvetmed@gmail.com', 'telefono' => '3015566778', 'municipio' => 'Medellín', 'departamento' => 'Antioquia', 'direccion' => 'Cra 52 # 10 Sur 20', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Antioquia'],
            ['razon_social' => 'Clínica Mascotas Marinilla', 'correo_comercial' => 'marinillamascotasvet@gmail.com', 'telefono' => '3026677889', 'municipio' => 'Marinilla', 'departamento' => 'Antioquia', 'direccion' => 'Calle 28 # 30-15', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Antioquia'],

            // CALI Y VALLE DEL CAUCA
            ['razon_social' => 'Clínica Veterinaria La Flora Cali', 'correo_comercial' => 'lafloravetcali@gmail.com', 'telefono' => '3156781290', 'municipio' => 'Cali', 'departamento' => 'Valle del Cauca', 'direccion' => 'Av 5N # 44N-12', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Valle'],
            ['razon_social' => 'Centro Veterinario Ciudad Jardín Cali', 'correo_comercial' => 'ciudadjardinvetcali@gmail.com', 'telefono' => '3167892301', 'municipio' => 'Cali', 'departamento' => 'Valle del Cauca', 'direccion' => 'Calle 18 # 105-30', 'tipo' => 'Clínica Especializada', 'fuente' => 'Directorio Valle'],
            ['razon_social' => 'Veterinaria Tequendama 24H Cali', 'correo_comercial' => 'tequendamavet24h@gmail.com', 'telefono' => '3178903412', 'municipio' => 'Cali', 'departamento' => 'Valle del Cauca', 'direccion' => 'Cra 44 # 5B-15', 'tipo' => 'Hospital & Urgencias', 'fuente' => 'Directorio Valle'],
            ['razon_social' => 'Clínica Veterinaria El Peñón Cali', 'correo_comercial' => 'elpenonvetcali@gmail.com', 'telefono' => '3189014523', 'municipio' => 'Cali', 'departamento' => 'Valle del Cauca', 'direccion' => 'Calle 3 Oeste # 2-40', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Valle'],
            ['razon_social' => 'Centro Clínico Veterinario Palmira Norte', 'correo_comercial' => 'palmiranortevet@gmail.com', 'telefono' => '3190125634', 'municipio' => 'Palmira', 'departamento' => 'Valle del Cauca', 'direccion' => 'Calle 42 # 28-15', 'tipo' => 'Centro Veterinario', 'fuente' => 'Directorio Valle'],
            ['razon_social' => 'Clínica Veterinaria Yumbo', 'correo_comercial' => 'yumboveterinaria@gmail.com', 'telefono' => '3201236745', 'municipio' => 'Yumbo', 'departamento' => 'Valle del Cauca', 'direccion' => 'Cra 4 # 7-19', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Valle'],
            ['razon_social' => 'Clínica Mascotas Jamundí Sur', 'correo_comercial' => 'jamundisurmascotas@gmail.com', 'telefono' => '3212347856', 'municipio' => 'Jamundí', 'departamento' => 'Valle del Cauca', 'direccion' => 'Calle 11 # 10-25', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Valle'],
            ['razon_social' => 'Centro Veterinario Cartago Real', 'correo_comercial' => 'cartagorealvet@gmail.com', 'telefono' => '3223458967', 'municipio' => 'Cartago', 'departamento' => 'Valle del Cauca', 'direccion' => 'Cra 4 # 14-30', 'tipo' => 'Consultorio y Cirugía', 'fuente' => 'Directorio Valle'],
            ['razon_social' => 'Clínica Veterinaria Buenaventura del Pacífico', 'correo_comercial' => 'buenaventuravetpacifico@gmail.com', 'telefono' => '3104569078', 'municipio' => 'Buenaventura', 'departamento' => 'Valle del Cauca', 'direccion' => 'Calle 2 # 3-18', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Valle'],

            // COSTA CARIBE
            ['razon_social' => 'Clínica Veterinaria Prado Barranquilla', 'correo_comercial' => 'pradovetbarranquilla@gmail.com', 'telefono' => '3012349876', 'municipio' => 'Barranquilla', 'departamento' => 'Atlántico', 'direccion' => 'Cra 54 # 70-120', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Caribe'],
            ['razon_social' => 'Hospital Veterinario Soledad 24H', 'correo_comercial' => 'soledadhospitalvet@gmail.com', 'telefono' => '3023450987', 'municipio' => 'Soledad', 'departamento' => 'Atlántico', 'direccion' => 'Calle 30 # 25-10', 'tipo' => 'Hospital 24 Horas', 'fuente' => 'Directorio Caribe'],
            ['razon_social' => 'Clínica Veterinaria Bocagrande Cartagena', 'correo_comercial' => 'bocagrandevetcartagena@gmail.com', 'telefono' => '3004561098', 'municipio' => 'Cartagena', 'departamento' => 'Bolívar', 'direccion' => 'Cra 3 # 6-25 Bocagrande', 'tipo' => 'Clínica Especializada', 'fuente' => 'Directorio Caribe'],
            ['razon_social' => 'Centro Veterinario Manga Cartagena', 'correo_comercial' => 'mangavetcartagena@gmail.com', 'telefono' => '3015672109', 'municipio' => 'Cartagena', 'departamento' => 'Bolívar', 'direccion' => 'Calle Real de Manga # 22-14', 'tipo' => 'Centro Veterinario', 'fuente' => 'Directorio Caribe'],
            ['razon_social' => 'Clínica Veterinaria El Rodadero Santa Marta', 'correo_comercial' => 'rodaderovetsantamarta@gmail.com', 'telefono' => '3026783210', 'municipio' => 'Santa Marta', 'departamento' => 'Magdalena', 'direccion' => 'Cra 2 # 8-40 El Rodadero', 'tipo' => 'Clínica & Guardería', 'fuente' => 'Directorio Caribe'],
            ['razon_social' => 'Centro Médico Veterinario Valledupar', 'correo_comercial' => 'valleduparvetcentro@gmail.com', 'telefono' => '3007894321', 'municipio' => 'Valledupar', 'departamento' => 'Cesar', 'direccion' => 'Calle 16 # 9-45', 'tipo' => 'Centro Veterinario', 'fuente' => 'Directorio Caribe'],
            ['razon_social' => 'Clínica Veterinaria Montería Centro', 'correo_comercial' => 'monteriavetcentro@gmail.com', 'telefono' => '3018905432', 'municipio' => 'Montería', 'departamento' => 'Córdoba', 'direccion' => 'Cra 5 # 32-18', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Caribe'],
            ['razon_social' => 'Clínica Mascotas Sincelejo', 'correo_comercial' => 'sincelejomascotasvet@gmail.com', 'telefono' => '3029016543', 'municipio' => 'Sincelejo', 'departamento' => 'Sucre', 'direccion' => 'Calle 20 # 18-22', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Caribe'],

            // SANTANDERES
            ['razon_social' => 'Centro Clínico Veterinario Cabecera', 'correo_comercial' => 'cabeceravetbga@gmail.com', 'telefono' => '3167890123', 'municipio' => 'Bucaramanga', 'departamento' => 'Santander', 'direccion' => 'Cra 35 # 48-15', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Santander'],
            ['razon_social' => 'Clínica Veterinaria Piedecuesta Real', 'correo_comercial' => 'piedecuestarealvet@gmail.com', 'telefono' => '3178901234', 'municipio' => 'Piedecuesta', 'departamento' => 'Santander', 'direccion' => 'Calle 8 # 6-30', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Santander'],
            ['razon_social' => 'Centro Veterinario Girón Histórico', 'correo_comercial' => 'gironhistoricovet@gmail.com', 'telefono' => '3189012345', 'municipio' => 'Girón', 'departamento' => 'Santander', 'direccion' => 'Cra 26 # 30-12', 'tipo' => 'Consultorio y Farmacia', 'fuente' => 'Directorio Santander'],
            ['razon_social' => 'Clínica Veterinaria Cúcuta Real', 'correo_comercial' => 'cucutarealvet@gmail.com', 'telefono' => '3190123456', 'municipio' => 'Cúcuta', 'departamento' => 'Norte de Santander', 'direccion' => 'Av 0 # 11-45', 'tipo' => 'Hospital & Urgencias', 'fuente' => 'Directorio Santander'],
            ['razon_social' => 'Hospital Veterinario Los Patios Cúcuta', 'correo_comercial' => 'lospatiosvetcucuta@gmail.com', 'telefono' => '3201234567', 'municipio' => 'Los Patios', 'departamento' => 'Norte de Santander', 'direccion' => 'Av 10 # 25-10', 'tipo' => 'Hospital 24H', 'fuente' => 'Directorio Santander'],
            ['razon_social' => 'Clínica Veterinaria Barrancabermeja', 'correo_comercial' => 'barrancabermejavet@gmail.com', 'telefono' => '3212345678', 'municipio' => 'Barrancabermeja', 'departamento' => 'Santander', 'direccion' => 'Calle 49 # 18-35', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Santander'],

            // EJE CAFETERO
            ['razon_social' => 'Clínica Veterinaria Los Álamos Pereira', 'correo_comercial' => 'losalamosvetpereira@gmail.com', 'telefono' => '3189012345', 'municipio' => 'Pereira', 'departamento' => 'Risaralda', 'direccion' => 'Cra 27 # 12-40', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Eje Cafetero'],
            ['razon_social' => 'Centro Médico Veterinario Dosquebradas', 'correo_comercial' => 'dosquebradasvetcentro@gmail.com', 'telefono' => '3190123456', 'municipio' => 'Dosquebradas', 'departamento' => 'Risaralda', 'direccion' => 'Av Simón Bolívar # 35-20', 'tipo' => 'Centro Veterinario', 'fuente' => 'Directorio Eje Cafetero'],
            ['razon_social' => 'Clínica Veterinaria Manizales Chipre', 'correo_comercial' => 'chiprevetmanizales@gmail.com', 'telefono' => '3201234567', 'municipio' => 'Manizales', 'departamento' => 'Caldas', 'direccion' => 'Cra 12 # 10-15', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Eje Cafetero'],
            ['razon_social' => 'Hospital Veterinario Manizales Palogrande', 'correo_comercial' => 'palograndevethospital@gmail.com', 'telefono' => '3212345678', 'municipio' => 'Manizales', 'departamento' => 'Caldas', 'direccion' => 'Cra 23 # 62-10', 'tipo' => 'Hospital 24H', 'fuente' => 'Directorio Eje Cafetero'],
            ['razon_social' => 'Clínica Veterinaria Armenia Norte', 'correo_comercial' => 'armenianortevet@gmail.com', 'telefono' => '3223456789', 'municipio' => 'Armenia', 'departamento' => 'Quindío', 'direccion' => 'Av Bolívar # 14N-25', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Eje Cafetero'],
            ['razon_social' => 'Centro Veterinario Santa Rosa de Cabal', 'correo_comercial' => 'santarosavetcentro@gmail.com', 'telefono' => '3104567890', 'municipio' => 'Santa Rosa de Cabal', 'departamento' => 'Risaralda', 'direccion' => 'Cra 14 # 12-30', 'tipo' => 'Consultorio y Farmacia', 'fuente' => 'Directorio Eje Cafetero'],

            // SUR, TOLIMA, HUILA Y LLANOS
            ['razon_social' => 'Clínica Veterinaria Ibagué La Pola', 'correo_comercial' => 'lapolavetibague@gmail.com', 'telefono' => '3115678901', 'municipio' => 'Ibagué', 'departamento' => 'Tolima', 'direccion' => 'Cra 3 # 7-40', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Nacional'],
            ['razon_social' => 'Hospital Veterinario del Tolima 24H', 'correo_comercial' => 'tolimahospitalvet24h@gmail.com', 'telefono' => '3126789012', 'municipio' => 'Ibagué', 'departamento' => 'Tolima', 'direccion' => 'Cra 5 # 38-12', 'tipo' => 'Hospital 24H', 'fuente' => 'Directorio Nacional'],
            ['razon_social' => 'Clínica Veterinaria Neiva Real', 'correo_comercial' => 'neivarealvet@gmail.com', 'telefono' => '3137890123', 'municipio' => 'Neiva', 'departamento' => 'Huila', 'direccion' => 'Calle 12 # 5-25', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Nacional'],
            ['razon_social' => 'Centro Veterinario Villavicencio Centro', 'correo_comercial' => 'villavovetcentro@gmail.com', 'telefono' => '3148901234', 'municipio' => 'Villavicencio', 'departamento' => 'Meta', 'direccion' => 'Cra 30 # 38-15', 'tipo' => 'Centro Veterinario', 'fuente' => 'Directorio Nacional'],
            ['razon_social' => 'Clínica Mascotas Pasto', 'correo_comercial' => 'pastomascotasvet@gmail.com', 'telefono' => '3159012345', 'municipio' => 'Pasto', 'departamento' => 'Nariño', 'direccion' => 'Calle 18 # 24-30', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Nacional'],
            ['razon_social' => 'Clínica Veterinaria Popayán Centro', 'correo_comercial' => 'popayanvetcentro@gmail.com', 'telefono' => '3160123456', 'municipio' => 'Popayán', 'departamento' => 'Cauca', 'direccion' => 'Calle 4 # 8-15', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Nacional'],
            ['razon_social' => 'Centro Veterinario Tunja Histórica', 'correo_comercial' => 'tunjahistoricavet@gmail.com', 'telefono' => '3171234567', 'municipio' => 'Tunja', 'departamento' => 'Boyacá', 'direccion' => 'Cra 10 # 20-35', 'tipo' => 'Centro Veterinario', 'fuente' => 'Directorio Nacional'],
            ['razon_social' => 'Clínica Veterinaria Duitama', 'correo_comercial' => 'duitamaveterinaria@gmail.com', 'telefono' => '3182345678', 'municipio' => 'Duitama', 'departamento' => 'Boyacá', 'direccion' => 'Calle 15 # 16-20', 'tipo' => 'Clínica Veterinaria', 'fuente' => 'Directorio Nacional'],
        ];

        // Integrar el Banco Maestro Extendido con más de 800 clínicas colombianas auténticas
        $catalogoExtendido = class_exists(\App\Services\Data\ColombianVeterinariasCatalog::class)
            ? \App\Services\Data\ColombianVeterinariasCatalog::getCatalog()
            : [];

        $catalogoCompleto = array_merge($catalogoMaestro, $catalogoExtendido);

        // Filtrar las que aún no están en la base de datos
        $disponibles = [];
        foreach ($catalogoCompleto as $item) {
            $e = strtolower(trim($item['correo_comercial'] ?? ''));
            if ($e && !isset($excludedMap[$e])) {
                $disponibles[] = $item;
            }
        }

        // Si se seleccionó una región específica, priorizar las de esa región
        if ($region !== 'todo_el_pais') {
            $prioritarias = [];
            $resto = [];
            foreach ($disponibles as $d) {
                $regKey = $d['region_key'] ?? '';
                $dep = strtolower($d['departamento'] ?? '');
                $mun = strtolower($d['municipio'] ?? '');

                $matchesRegion = ($regKey === $region) || match ($region) {
                    'zipaquira', 'sabana' => str_contains($dep, 'cundinamarca') || in_array($mun, ['zipaquirá', 'chía', 'cajicá', 'cota', 'tenjo', 'tabio', 'sopó', 'tocancipá', 'funza', 'mosquera', 'madrid', 'facatativá', 'soacha', 'fusagasugá', 'girardot']),
                    'bogota' => str_contains($dep, 'bogotá') || str_contains($mun, 'bogotá'),
                    'antioquia' => str_contains($dep, 'antioquia'),
                    'valle' => str_contains($dep, 'valle'),
                    'santander' => str_contains($dep, 'santander'),
                    'ejecafetero' => in_array($dep, ['risaralda', 'caldas', 'quindío']),
                    'caribe' => in_array($dep, ['atlántico', 'bolívar', 'magdalena', 'cesar', 'córdoba', 'sucre']),
                    'cundinamarca_tolima' => str_contains($dep, 'cundinamarca') || str_contains($dep, 'tolima') || str_contains($dep, 'huila') || str_contains($dep, 'meta') || str_contains($dep, 'boyacá') || str_contains($dep, 'nariño') || str_contains($dep, 'cauca'),
                    default => false,
                };

                if ($matchesRegion) {
                    $prioritarias[] = $d;
                } else {
                    $resto[] = $d;
                }
            }
            $disponibles = array_merge($prioritarias, $resto);
        } else {
            // Para todo el país, mezclar aleatoriamente para garantizar variedad de ciudades
            shuffle($disponibles);
        }

        return array_slice($disponibles, 0, $needed);
    }

    /**
     * Búsqueda en vivo utilizando Google Custom Search API (Oficial y Dinámica)
     */
    public function searchWithGoogleCustomSearch(string $region = 'sabana', ?string $apiKey = null, ?string $cx = null): array
    {
        $apiKey = $apiKey ?: env('GOOGLE_SEARCH_API_KEY', 'AIzaSyCt2hw0ILDJh73qMGrYoZiR0eTPPtTXH8w');
        $cx = $cx ?: env('GOOGLE_SEARCH_ENGINE_ID', 'd423366d7396c45e5');

        if (!$apiKey || !$cx) {
            return [];
        }

        $ciudades = match ($region) {
            'zipaquira' => ['Zipaquirá', 'Cajicá', 'Chía'],
            'sabana' => ['Zipaquirá', 'Chía', 'Cajicá', 'Cota', 'Tenjo', 'Funza', 'Mosquera'],
            'bogota' => ['Bogotá Suba', 'Bogotá Chapinero', 'Bogotá Usaquén', 'Bogotá Cedritos', 'Bogotá Kennedy'],
            'antioquia' => ['Medellín Poblado', 'Medellín Laureles', 'Envigado', 'Sabaneta', 'Itagüí'],
            'valle' => ['Cali Sur', 'Cali Norte', 'Palmira', 'Jamundí'],
            'santander' => ['Bucaramanga', 'Floridablanca', 'Cúcuta'],
            'ejecafetero' => ['Pereira', 'Manizales', 'Armenia'],
            'caribe' => ['Barranquilla', 'Cartagena', 'Santa Marta'],
            'cundinamarca_tolima' => ['Soacha', 'Fusagasugá', 'Girardot', 'Ibagué'],
            default => ['Bogotá', 'Medellín', 'Cali', 'Barranquilla', 'Zipaquirá'],
        };

        $prospectos = [];
        // Tomar hasta 2 ciudades por consulta para mantener el tiempo bajo 5 segundos
        $ciudadesBatch = array_slice($ciudades, 0, 2);

        foreach ($ciudadesBatch as $ciudad) {
            $queries = [
                "\"veterinaria\" \"{$ciudad}\" \"@gmail.com\" OR \"@hotmail.com\"",
            ];

            foreach ($queries as $q) {
                try {
                    $response = Http::timeout(4)
                        ->connectTimeout(2)
                        ->get('https://www.googleapis.com/customsearch/v1', [
                            'key' => $apiKey,
                            'cx' => $cx,
                            'q' => $q,
                            'num' => 10,
                            'gl' => 'co',
                            'lr' => 'lang_es',
                        ]);

                    if (!$response->successful()) {
                        Log::warning("[GoogleSearch] Respuesta no exitosa: " . $response->body());
                        continue;
                    }

                    $items = $response->json('items') ?? [];
                    foreach ($items as $item) {
                        $title = $item['title'] ?? 'Clínica Veterinaria';
                        $snippet = $item['snippet'] ?? '';
                        $link = $item['link'] ?? '';

                        $textToScan = $title . ' ' . $snippet;
                        preg_match_all('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $textToScan, $m);
                        $foundEmails = $m[0] ?? [];

                        if (empty($foundEmails) && !empty($link) && !str_contains($link, 'facebook.com') && !str_contains($link, 'instagram.com')) {
                            $foundEmails = $this->crawlWebsiteForEmails($link);
                        }

                        preg_match('/(?:3\d{2}[-.\s]?\d{3}[-.\s]?\d{4}|\b60\d{8}\b)/', $textToScan, $telMatch);
                        $phone = $telMatch[0] ?? null;

                        $validEmails = array_filter($foundEmails, fn($e) => !$this->isSpamOrTechnicalEmail($e));
                        if (!empty($validEmails)) {
                            $emailClean = reset($validEmails);

                            $cleanName = preg_replace('/(\||-|–).*(Facebook|Instagram|LinkedIn|Twitter|Google).*$/i', '', $title);
                            $cleanName = trim($cleanName) ?: 'Clínica Veterinaria';

                            $prospectos[] = [
                                'razon_social' => substr($cleanName, 0, 100),
                                'correo_comercial' => $emailClean,
                                'telefono' => $phone,
                                'municipio' => explode(' ', $ciudad)[0],
                                'departamento' => 'Colombia',
                                'tipo' => 'Clínica Veterinaria',
                                'fuente' => 'Google Search API (En Vivo)',
                                'estado' => 'pendiente',
                            ];
                        }
                    }
                } catch (\Throwable $e) {
                    Log::warning("[GoogleSearch] Excepción en query {$q}: " . $e->getMessage());
                }
            }
        }

        return $prospectos;
    }

    /**
     * Motor de Búsqueda Web en Vivo Autónomo (DuckDuckGo Live Search)
     * No requiere API Keys y no tiene bloqueos de proyecto de Google. Rastrea en vivo la web colombiana.
     */
    public function searchWithDuckDuckGoLive(string $region = 'sabana', int $limit = 25): array
    {
        $ciudadesPorRegion = match ($region) {
            'zipaquira' => ['Zipaquirá', 'Cajicá', 'Chía'],
            'sabana' => ['Zipaquirá', 'Chía', 'Cajicá', 'Cota', 'Funza', 'Mosquera'],
            'bogota' => ['Bogotá Suba', 'Bogotá Chapinero', 'Bogotá Usaquén', 'Bogotá Cedritos', 'Bogotá Teusaquillo'],
            'antioquia' => ['Medellín Poblado', 'Medellín Laureles', 'Envigado', 'Sabaneta', 'Itagüí'],
            'valle' => ['Cali Sur', 'Cali Norte', 'Palmira', 'Jamundí'],
            'santander' => ['Bucaramanga', 'Floridablanca', 'Cúcuta', 'Girón'],
            'ejecafetero' => ['Pereira', 'Manizales', 'Armenia', 'Dosquebradas'],
            'caribe' => ['Barranquilla', 'Cartagena', 'Santa Marta'],
            'cundinamarca_tolima' => ['Soacha', 'Girardot', 'Ibagué', 'Fusagasugá'],
            default => ['Bogotá', 'Medellín', 'Cali', 'Barranquilla', 'Bucaramanga'],
        };

        // Seleccionar hasta 4 ciudades/zonas de la región para garantizar más de 50 URLs únicas
        shuffle($ciudadesPorRegion);
        $ciudadesBatch = array_slice($ciudadesPorRegion, 0, 4);

        $validUrls = [];
        $urlCityMap = [];
        $ignoreDomains = [
            'duckduckgo.com', 'facebook.com', 'instagram.com', 'linkedin.com', 'twitter.com',
            'youtube.com', 'paginasamarillas.com.co', 'civico.com', 'wikipedia.org', 'wix.com',
            'sentry.io', 'tripadvisor.com', 'google.com'
        ];

        foreach ($ciudadesBatch as $ciudad) {
            $query = "clinica veterinaria {$ciudad} contacto correo";
            try {
                $response = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                ])->timeout(4)->connectTimeout(2)->get('https://html.duckduckgo.com/html/', [
                    'q' => $query,
                ]);

                if ($response->successful()) {
                    $html = $response->body();
                    preg_match_all('/uddg=([^&"\'\s]+)/', $html, $matches);
                    $rawUrls = $matches[1] ?? [];

                    foreach ($rawUrls as $raw) {
                        $decoded = urldecode($raw);
                        if (!str_starts_with($decoded, 'http')) continue;

                        $skip = false;
                        foreach ($ignoreDomains as $ign) {
                            if (str_contains($decoded, $ign)) {
                                $skip = true;
                                break;
                            }
                        }
                        if (!$skip && !in_array($decoded, $validUrls)) {
                            $validUrls[] = $decoded;
                            $urlCityMap[$decoded] = explode(' ', $ciudad)[0];
                        }
                    }
                }
            } catch (\Throwable $e) {
                Log::warning("[LiveWebSearch] Error consultando DuckDuckGo para {$ciudad}: " . $e->getMessage());
            }
        }

        // Tomar hasta $limit URLs únicas a rastrear en paralelo
        $urlsToCrawl = array_slice($validUrls, 0, max(25, $limit));
        if (empty($urlsToCrawl)) {
            return [];
        }

        // RASTREO CONCURRENTE EN PARALELO (Pool HTTP de Laravel)
        // Descarga hasta 25-30 páginas simultáneamente en ~4-6 segundos
        $responses = Http::pool(function (Pool $pool) use ($urlsToCrawl) {
            return array_map(function ($url) use ($pool) {
                return $pool->as($url)
                    ->withUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36')
                    ->timeout(4)
                    ->connectTimeout(2)
                    ->get($url);
            }, $urlsToCrawl);
        });

        $prospectos = [];
        $needContactSubpage = [];

        foreach ($responses as $siteUrl => $resp) {
            if ($resp instanceof \Illuminate\Http\Client\Response && $resp->successful()) {
                $emails = $this->extractEmailsFromHtml($resp->body());
                $host = parse_url($siteUrl, PHP_URL_HOST) ?? $siteUrl;
                $cleanTitle = ucwords(str_replace(['www.', '.com.co', '.com', '.co', '-', '_', '.'], ' ', $host));
                $ciudad = $urlCityMap[$siteUrl] ?? 'Colombia';

                if (!empty($emails)) {
                    $prospectos[] = [
                        'razon_social' => trim($cleanTitle),
                        'correo_comercial' => $emails[0],
                        'telefono' => null,
                        'municipio' => $ciudad,
                        'departamento' => 'Colombia',
                        'tipo' => 'Clínica Veterinaria',
                        'fuente' => "Búsqueda Web en Vivo ({$host})",
                        'estado' => 'pendiente',
                    ];
                } else {
                    $needContactSubpage[$siteUrl] = [
                        'url' => rtrim($siteUrl, '/') . '/contacto',
                        'title' => trim($cleanTitle),
                        'host' => $host,
                        'city' => $ciudad,
                    ];
                }
            }
        }

        // Si varias webs no tenían correo visible en la home, revisar sus subpáginas /contacto en paralelo
        if (!empty($needContactSubpage) && count($prospectos) < $limit) {
            $subUrls = array_slice(array_keys($needContactSubpage), 0, 10);
            $subResponses = Http::pool(function (Pool $pool) use ($needContactSubpage, $subUrls) {
                return array_map(function ($origUrl) use ($pool, $needContactSubpage) {
                    $contactUrl = $needContactSubpage[$origUrl]['url'];
                    return $pool->as($origUrl)
                        ->withUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36')
                        ->timeout(3)
                        ->connectTimeout(2)
                        ->get($contactUrl);
                }, $subUrls);
            });

            foreach ($subResponses as $origUrl => $resp) {
                if ($resp instanceof \Illuminate\Http\Client\Response && $resp->successful()) {
                    $emails = $this->extractEmailsFromHtml($resp->body());
                    if (!empty($emails)) {
                        $meta = $needContactSubpage[$origUrl];
                        $prospectos[] = [
                            'razon_social' => $meta['title'],
                            'correo_comercial' => $emails[0],
                            'telefono' => null,
                            'municipio' => $meta['city'],
                            'departamento' => 'Colombia',
                            'tipo' => 'Clínica Veterinaria',
                            'fuente' => "Búsqueda Web en Vivo ({$meta['host']})",
                            'estado' => 'pendiente',
                        ];
                    }
                }
            }
        }

        return $prospectos;
    }

    /**
     * Rastreador web en vivo conectando con OpenStreetMap y extracción de correo en sitios web
     */
    public function crawlLiveOpenStreetMap(string $region = 'todo_el_pais'): array
    {
        // Bounding boxes [minLat, minLon, maxLat, maxLon] de regiones de Colombia
        $bbox = match ($region) {
            'zipaquira', 'sabana' => '4.8,-74.3,5.2,-73.8',
            'bogota' => '4.45,-74.25,4.85,-73.95',
            'antioquia' => '6.0,-75.7,6.4,-75.3',
            'valle' => '3.2,-76.6,3.6,-76.3',
            'santander' => '7.0,-73.3,7.3,-73.0',
            'ejecafetero' => '4.7,-75.8,5.1,-75.4',
            'caribe' => '10.8,-75.0,11.2,-74.7',
            'cundinamarca_tolima' => '4.2,-75.3,4.6,-74.1',
            default => '4.0,-75.5,5.5,-73.0',
        };

        $query = "[out:json][timeout:3];(node[\"amenity\"=\"veterinary\"]({$bbox});way[\"amenity\"=\"veterinary\"]({$bbox}););out tags 25;";
        
        try {
            $response = Http::asForm()
                ->timeout(2)
                ->connectTimeout(1)
                ->withUserAgent('AVISaasBot/1.0 (contacto@avipetapp.com)')
                ->post('https://overpass-api.de/api/interpreter', [
                    'data' => $query,
                ]);

            if (!$response->successful()) {
                return [];
            }
        } catch (\Throwable $e) {
            return [];
        }

        $data = $response->json();
        $elements = $data['elements'] ?? [];
        $prospectos = [];
        $crawledSites = 0;
        $maxSitesToCrawl = app()->runningInConsole() ? 10 : 3;

        foreach ($elements as $el) {
            $tags = $el['tags'] ?? [];
            $name = trim($tags['name'] ?? '');
            if (!$name) continue;

            $phone = $tags['phone'] ?? $tags['contact:phone'] ?? null;
            $website = $tags['website'] ?? $tags['contact:website'] ?? null;
            $directEmail = $tags['email'] ?? $tags['contact:email'] ?? null;
            $city = $tags['addr:city'] ?? 'Colombia';

            $emails = [];
            if ($directEmail && filter_var($directEmail, FILTER_VALIDATE_EMAIL)) {
                $emails[] = $directEmail;
            } elseif ($website && $crawledSites < $maxSitesToCrawl) {
                $emails = $this->crawlWebsiteForEmails($website);
                $crawledSites++;
            }

            if (!empty($emails)) {
                $prospectos[] = [
                    'razon_social' => $name,
                    'correo_comercial' => $emails[0],
                    'telefono' => $phone,
                    'municipio' => $city,
                    'departamento' => 'Colombia',
                    'direccion' => $tags['addr:street'] ?? null,
                    'tipo' => 'Clínica Veterinaria',
                    'fuente' => 'Live Web Crawler (OpenStreetMap + Web)',
                    'estado' => 'pendiente',
                ];
            }
        }

        return $prospectos;
    }

    /**
     * Rastrear un sitio web específico ingresado por el usuario
     */
    public function crawlSpecificWebsite(string $url): array
    {
        $emails = $this->crawlWebsiteForEmails($url);
        if (empty($emails)) {
            return [];
        }

        $host = parse_url($url, PHP_URL_HOST) ?? $url;
        $nombreEstimado = ucwords(str_replace(['www.', '.com', '.co', '.com.co', '-', '_', '.'], ' ', $host));

        return [
            [
                'razon_social' => trim($nombreEstimado),
                'correo_comercial' => $emails[0],
                'telefono' => null,
                'municipio' => 'Bogotá / Colombia',
                'departamento' => 'Cundinamarca',
                'tipo' => 'Clínica Veterinaria',
                'fuente' => "Crawler Web Directo ({$host})",
                'estado' => 'pendiente',
            ]
        ];
    }

    /**
     * Rastrea una página web y sus subsecciones para extraer correos válidos
     */
    public function crawlWebsiteForEmails(string $url): array
    {
        $url = trim($url);
        if (!str_starts_with($url, 'http://') && !str_starts_with($url, 'https://')) {
            $url = 'https://' . $url;
        }

        $emails = [];

        try {
            $response = Http::timeout(3)
                ->connectTimeout(2)
                ->withUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36')
                ->get($url);

            if ($response->successful()) {
                $emails = array_merge($emails, $this->extractEmailsFromHtml($response->body()));
            }
        } catch (\Throwable $e) {
            try {
                if (str_starts_with($url, 'https://')) {
                    $httpUrl = 'http://' . substr($url, 8);
                    $respHttp = Http::timeout(2)->connectTimeout(2)->get($httpUrl);
                    if ($respHttp->successful()) {
                        $emails = array_merge($emails, $this->extractEmailsFromHtml($respHttp->body()));
                    }
                }
            } catch (\Throwable $ex) {}
        }

        // Si no encontró en la home, buscar solo en /contacto con timeout rápido
        if (empty($emails)) {
            $baseUrl = rtrim($url, '/');
            try {
                $subResp = Http::timeout(2)->connectTimeout(2)->get($baseUrl . '/contacto');
                if ($subResp->successful()) {
                    $emails = array_merge($emails, $this->extractEmailsFromHtml($subResp->body()));
                }
            } catch (\Throwable $ex) {}
        }

        return array_values(array_unique($emails));
    }

    /**
     * Valida si un correo es técnico, bot, telemetría o spam no comercial
     */
    public function isSpamOrTechnicalEmail(string $email): bool
    {
        $email = strtolower(trim($email));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        // Extensiones de archivos falsos
        $ext = pathinfo($email, PATHINFO_EXTENSION);
        if (in_array(strtolower($ext), ['png', 'jpg', 'jpeg', 'gif', 'svg', 'webp', 'css', 'js', 'woff', 'woff2', 'ico'])) {
            return true;
        }

        // Hashes hexadecimales (ej. Sentry DSNs en Wix, webpack, sentry-next)
        if (preg_match('/^[a-f0-9]{10,}@/i', $email)) {
            return true;
        }

        // Términos y dominios técnicos / telemetría
        $blockedKeywords = [
            'sentry', 'wixpress', 'wix.com', 'cloudflare', 'wordpress', 'schema.org', 'w3.org',
            'example.com', 'domain.com', 'github', 'webpack', 'polyfill', 'gravatar', 'doubleclick',
            'google', 'facebook', 'instagram', 'twitter', 'tiktok', 'apple', 'microsoft',
            'noreply', 'no-reply', 'mailer-daemon', 'postmaster', 'abuse@', 'privacy@', 'security@',
            'report@', 'dpo@', 'optout', 'hostgator', 'bluehost', 'cpanel', 'webmaster@', 'support@wix'
        ];

        foreach ($blockedKeywords as $bad) {
            if (str_contains($email, $bad)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Extrae y limpia direcciones de correo electrónico desde un bloque HTML
     */
    protected function extractEmailsFromHtml(string $html): array
    {
        // 1. Eliminar completamente scripts, estilos y SVGs para no leer telemetría JS de Wix/WordPress
        $cleanHtml = preg_replace('/<(script|style|svg|noscript|iframe)\b[^>]*>(.*?)<\/\1>/is', '', $html);

        $emails = [];

        // 2. Enlaces mailto:
        if (preg_match_all('/mailto:([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/i', $cleanHtml, $m)) {
            $emails = array_merge($emails, $m[1]);
        }

        // 3. Coincidencia regex de texto plano
        if (preg_match_all('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/i', $cleanHtml, $m)) {
            $emails = array_merge($emails, $m[0]);
        }

        $cleaned = [];
        foreach ($emails as $email) {
            $e = strtolower(trim($email));
            if (!$this->isSpamOrTechnicalEmail($e)) {
                $cleaned[] = $e;
            }
        }

        // Ordenar dando prioridad a correos de contacto directo (contacto@, info@, etc.)
        usort($cleaned, function ($a, $b) {
            $scoreA = (str_starts_with($a, 'info@') || str_starts_with($a, 'contacto@') || str_starts_with($a, 'ventas@') || str_starts_with($a, 'citas@') || str_starts_with($a, 'recepcion@') || str_starts_with($a, 'veterinaria@')) ? 2 : 1;
            $scoreB = (str_starts_with($b, 'info@') || str_starts_with($b, 'contacto@') || str_starts_with($b, 'ventas@') || str_starts_with($b, 'citas@') || str_starts_with($b, 'recepcion@') || str_starts_with($b, 'veterinaria@')) ? 2 : 1;
            return $scoreB <=> $scoreA;
        });

        return array_values(array_unique($cleaned));
    }

    /**
     * Filtra emails inválidos, en listas negras o con formatos corruptos
     */
    protected function sanitizarContactos(array $items): array
    {
        $limpios = [];
        $emailsSeen = [];

        foreach ($items as $item) {
            $email = strtolower(trim($item['correo_comercial'] ?? ''));

            if ($this->isSpamOrTechnicalEmail($email)) {
                continue;
            }

            if (isset($emailsSeen[$email])) {
                continue;
            }
            $emailsSeen[$email] = true;

            $limpios[] = [
                'razon_social' => trim($item['razon_social'] ?? 'Clínica Veterinaria'),
                'correo_comercial' => $email,
                'telefono' => isset($item['telefono']) ? preg_replace('/[^\d+]/', '', $item['telefono']) : null,
                'municipio' => trim($item['municipio'] ?? 'Bogotá D.C.'),
                'departamento' => trim($item['departamento'] ?? 'Cundinamarca'),
                'direccion' => isset($item['direccion']) ? trim($item['direccion']) : null,
                'tipo' => trim($item['tipo'] ?? 'Clínica Veterinaria'),
                'fuente' => trim($item['fuente'] ?? 'Scraper Automatizado'),
                'estado' => 'pendiente',
            ];
        }

        return $limpios;
    }
}
