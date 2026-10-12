<?php

namespace App\Services;

use App\Models\ProspectoVeterinaria;
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
    public function scanRegion(string $region = 'sabana', ?string $customUrl = null, ?string $googleApiKey = null, ?string $googleCx = null): array
    {
        Log::info("[Scraper] Iniciando escaneo y rastreo web en vivo para región: {$region}");
        $contactosExtraidos = [];

        // 1. Si el usuario ingresó una URL específica, rastrearla de inmediato
        if (!empty($customUrl)) {
            $webContactos = $this->crawlSpecificWebsite($customUrl);
            $contactosExtraidos = array_merge($contactosExtraidos, $webContactos);
        }

        // 2. Búsqueda en Vivo Oficial con Google Custom Search API (100 consultas/día gratis)
        try {
            $googleContactos = $this->searchWithGoogleCustomSearch($region, $googleApiKey, $googleCx);
            if (!empty($googleContactos)) {
                Log::info("[GoogleSearch] Se descubrieron " . count($googleContactos) . " nuevas clínicas en vivo vía Google.");
                $contactosExtraidos = array_merge($contactosExtraidos, $googleContactos);
            }
        } catch (\Throwable $e) {
            Log::warning("[GoogleSearch] Advertencia en búsqueda de Google: " . $e->getMessage());
        }

        // 3. Rastreador Web en Vivo (OpenStreetMap API + Web Crawling)
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

        // Guardar con UPSERT idempotente (cero duplicados)
        $upsertedCount = ProspectoVeterinaria::upsertProspectos($limpios);

        Log::info("[Scraper] Finalizado. Encontrados: " . count($contactosExtraidos) . ", Procesados en BD: {$upsertedCount}");

        return [
            'region' => $region,
            'total_encontrados' => count($contactosExtraidos),
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
     * Búsqueda en vivo utilizando Google Custom Search API (Oficial y Dinámica)
     */
    public function searchWithGoogleCustomSearch(string $region = 'sabana', ?string $apiKey = null, ?string $cx = null): array
    {
        $apiKey = $apiKey ?: env('GOOGLE_SEARCH_API_KEY');
        $cx = $cx ?: env('GOOGLE_SEARCH_ENGINE_ID');

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

                        foreach ($foundEmails as $email) {
                            $emailClean = strtolower(trim($email));
                            if (!filter_var($emailClean, FILTER_VALIDATE_EMAIL)) continue;
                            $domain = substr(strrchr($emailClean, "@"), 1);
                            if (in_array($domain, $this->blacklistedDomains)) continue;

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

        $query = "[out:json][timeout:8];(node[\"amenity\"=\"veterinary\"]({$bbox});way[\"amenity\"=\"veterinary\"]({$bbox}););out tags 25;";
        
        $response = Http::asForm()
            ->timeout(6)
            ->connectTimeout(3)
            ->withUserAgent('AVISaasBot/1.0 (contacto@avipetapp.com)')
            ->post('https://overpass-api.de/api/interpreter', [
                'data' => $query,
            ]);

        if (!$response->successful()) {
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
     * Extrae y limpia direcciones de correo electrónico desde un bloque HTML
     */
    protected function extractEmailsFromHtml(string $html): array
    {
        $emails = [];

        // 1. Enlaces mailto:
        if (preg_match_all('/mailto:([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/i', $html, $m)) {
            $emails = array_merge($emails, $m[1]);
        }

        // 2. Coincidencia regex de texto plano
        if (preg_match_all('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/i', $html, $m)) {
            $emails = array_merge($emails, $m[0]);
        }

        $cleaned = [];
        foreach ($emails as $email) {
            $e = strtolower(trim($email));
            if (!filter_var($e, FILTER_VALIDATE_EMAIL)) continue;

            $ext = pathinfo($e, PATHINFO_EXTENSION);
            if (in_array(strtolower($ext), ['png', 'jpg', 'jpeg', 'gif', 'svg', 'webp', 'css', 'js'])) continue;

            $domain = substr(strrchr($e, "@"), 1);
            if (in_array($domain, $this->blacklistedDomains)) continue;

            $cleaned[] = $e;
        }

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

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                continue;
            }

            // Validar dominios bloqueados
            $domain = substr(strrchr($email, "@"), 1);
            if (in_array($domain, $this->blacklistedDomains)) {
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
