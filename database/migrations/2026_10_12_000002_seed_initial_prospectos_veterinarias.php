<?php

use App\Models\ProspectoVeterinaria;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Los 32 contactos que ya fueron despachados exitosamente en la primera tanda
        $enviadosTanda1 = [
            ['razon_social' => 'Clínica Veterinaria Bogotá (Pet Company)', 'correo_comercial' => 'clinicaveterinariabogota@hotmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Clínica Especializada'],
            ['razon_social' => 'OrthoVet Centro de Especialistas Veterinarios', 'correo_comercial' => 'orthovetcolombia@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Centro Quirúrgico'],
            ['razon_social' => "Animal's Care Center", 'correo_comercial' => 'carecenter1853@hotmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Hospital Veterinario'],
            ['razon_social' => 'Clínica Veterinaria VETAS', 'correo_comercial' => 'contacto@vetas.com.co', 'municipio' => 'Chía / Sabana', 'departamento' => 'Cundinamarca', 'tipo' => 'Red de Clínicas'],
            ['razon_social' => 'Dra. Alejandra Cataño Servicios Veterinarios', 'correo_comercial' => 'vetcatano@gmail.com', 'municipio' => 'Chía / Cajicá', 'departamento' => 'Cundinamarca', 'tipo' => 'Servicios Veterinarios'],
            ['razon_social' => 'Centro de Salud Animal (CSA Chapinero)', 'correo_comercial' => 'facturacion.csachapinero@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Hospital Veterinario 24H'],
            ['razon_social' => 'Clínica Protectora de Animales (CPA)', 'correo_comercial' => 'servicioalclientecpa@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Hospital y Urgencias'],
            ['razon_social' => 'YENNY PATRICIA ORTEGA (Dogy Pet Shop)', 'correo_comercial' => 'dogypetshop@gmail.com', 'municipio' => 'Zipaquirá', 'departamento' => 'Cundinamarca', 'tipo' => 'Pet Shop & Consultorio'],
            ['razon_social' => 'SPEEDOGPET SAS', 'correo_comercial' => 'speedpetshop373@gmail.com', 'municipio' => 'Chía', 'departamento' => 'Cundinamarca', 'tipo' => 'Centro Veterinario'],
            ['razon_social' => 'VETERINARIAS ANGELUS (Luis Martinez)', 'correo_comercial' => 'veterinariasangelus@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Clínica Veterinaria'],
            ['razon_social' => 'ANIMAUMASCOTAS (Silvia Jimenez)', 'correo_comercial' => 'animaumascotas@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Centro Veterinario'],
            ['razon_social' => 'MUNDOMASCOTAFUNZA (Robinson Sandoval)', 'correo_comercial' => 'mundomascotafunza@hotmail.es', 'municipio' => 'Funza / Mosquera', 'departamento' => 'Cundinamarca', 'tipo' => 'Centro Veterinario'],
            ['razon_social' => 'SAGON SAS (Dra. Camila Saavedra)', 'correo_comercial' => 'direccioncomercial@sagon.co', 'municipio' => 'Chía', 'departamento' => 'Cundinamarca', 'tipo' => 'Servicios Veterinarios'],
            ['razon_social' => 'KANYANA PET NUTRITION SAS', 'correo_comercial' => 'kanyanapetnutrition@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Salud & Nutrición'],
            ['razon_social' => 'MI MASCOTA FRUTOS DEL CAMPO S.A.S', 'correo_comercial' => 'pilaralvarez1977@outlook.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Consultorio y Pet Shop'],
            ['razon_social' => 'MAIDA CATALINA FONSECA BERNAL', 'correo_comercial' => 'cata_fonseca@hotmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Consultorio Veterinario'],
            ['razon_social' => 'CLAUDIA MARCELA POLANCO ARENAS', 'correo_comercial' => 'marcelapolancoarenas@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Servicios Veterinarios'],
            ['razon_social' => 'PAULA ANDREA ROZO LONDOÑO', 'correo_comercial' => 'paulaarl@hotmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Consultorio y Farmacia'],
            ['razon_social' => 'HERNANDEZ SANTAMARIA DORA INES', 'correo_comercial' => 'doraihs@yahoo.com', 'municipio' => 'Madrid', 'departamento' => 'Cundinamarca', 'tipo' => 'Consultorio Veterinario'],
            ['razon_social' => 'ROSAS CARDENAS LUISA FERNANDA', 'correo_comercial' => 'unilui.123@gmail.com', 'municipio' => 'Girardot', 'departamento' => 'Cundinamarca', 'tipo' => 'Farmacia Veterinaria'],
            ['razon_social' => 'DRA. ROSALBA GORDILLO (MV)', 'correo_comercial' => 'nebenavidesmv@gmail.com', 'municipio' => 'Pacho', 'departamento' => 'Cundinamarca', 'tipo' => 'Servicios Médicos'],
            ['razon_social' => 'JENNY ROCIO FRANCO PULIDO', 'correo_comercial' => 'angelyroderiguez@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Servicios Veterinarios'],
            ['razon_social' => 'FLOREZ DURAN LAURA DANIELA', 'correo_comercial' => 'luzmflorezd@hotmail.com', 'municipio' => 'Girardot', 'departamento' => 'Cundinamarca', 'tipo' => 'Servicios Veterinarios'],
            ['razon_social' => 'ANDRES EDUARDO GIRALDO VARGAS', 'correo_comercial' => 'agiraldo2009@live.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Servicios Veterinarios'],
            ['razon_social' => 'ANA LILIA ABRIL', 'correo_comercial' => 'lilianna-abril@hotmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Servicios Veterinarios'],
            ['razon_social' => 'LAURA VALENTINA ROMERO PENAGOS', 'correo_comercial' => 'eddarovish1@hotmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Servicios Veterinarios'],
            ['razon_social' => 'MARY SOL DIAZ LOPEZ', 'correo_comercial' => 'marysoldiazlopez@gmail.com', 'municipio' => 'Ubalá', 'departamento' => 'Cundinamarca', 'tipo' => 'Servicios Veterinarios'],
            ['razon_social' => 'MONICA ANDREA VASQUEZ PIÑEROS', 'correo_comercial' => 'mandreavasquez@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Servicios Veterinarios'],
            ['razon_social' => 'RAUL FERNANDO LAVADO GOMEZ', 'correo_comercial' => 'raulavado1@hotmail.com', 'municipio' => 'Fúquene', 'departamento' => 'Cundinamarca', 'tipo' => 'Servicios Veterinarios'],
            ['razon_social' => 'OPERACIONES ESPECIALES MB S A S', 'correo_comercial' => 'operacionesespecialesmb@gmail.com', 'municipio' => 'Fusagasugá', 'departamento' => 'Cundinamarca', 'tipo' => 'Servicios Veterinarios'],
            ['razon_social' => 'DAGAL SOCIEDAD POR ACCIONES SIMPLIFICADA', 'correo_comercial' => 'dagalsas@outlook.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Servicios Veterinarios'],
            ['razon_social' => 'ALVEIRO QUINTERO MARTINEZ', 'correo_comercial' => 'alveiro1@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Servicios Veterinarios'],
        ];

        foreach ($enviadosTanda1 as $item) {
            $email = strtolower(trim($item['correo_comercial']));
            ProspectoVeterinaria::firstOrCreate(
                ['correo_comercial' => $email],
                [
                    'razon_social' => $item['razon_social'],
                    'municipio' => $item['municipio'],
                    'departamento' => $item['departamento'],
                    'tipo' => $item['tipo'],
                    'estado' => 'enviado',
                    'intentos_envio' => 1,
                    'ultimo_envio_at' => now(),
                    'fuente' => 'Campaña Inicial Octubre',
                ]
            );
        }

        // 2. Clínicas de Zipaquirá y la Sabana listas en estado PENDIENTE
        $pendientesSabana = [
            ['razon_social' => 'Veterinaria El Hato (Dr. Hernando Niño)', 'correo_comercial' => 'm.v.nino.hernando@hotmail.com', 'municipio' => 'Zipaquirá', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica Veterinaria'],
            ['razon_social' => 'Zoo-Clínica La Sabana', 'correo_comercial' => 'info@zooclinicalasabana.com', 'municipio' => 'Zipaquirá', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica & Hospital'],
            ['razon_social' => 'Clínica Veterinaria Dra. María Claudia Tinjacá', 'correo_comercial' => 'info@clinicaveterinariadramariaclaudiatinjaca.com.co', 'municipio' => 'Zipaquirá', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica Especializada'],
            ['razon_social' => 'Clínica Veterinaria Best Animals (Sede Zipaquirá)', 'correo_comercial' => 'veterinariabestanimals@gmail.com', 'municipio' => 'Zipaquirá', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica & Urgencias'],
            ['razon_social' => 'Felicanvet Cajicá', 'correo_comercial' => 'veterinariafelicanvet@gmail.com', 'municipio' => 'Cajicá', 'departamento' => 'Cundinamarca', 'tipo' => 'Consultorio Veterinario'],
            ['razon_social' => 'Inversiones The Royal Pet', 'correo_comercial' => 'veterinariatheroyalpet@gmail.com', 'municipio' => 'Cajicá', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica & Pet Shop'],
            ['razon_social' => 'Zonovet Cajicá', 'correo_comercial' => 'verterinariazonovet@gmail.com', 'municipio' => 'Cajicá', 'departamento' => 'Cundinamarca', 'tipo' => 'Servicios Veterinarios'],
            ['razon_social' => 'Clínica Veterinaria Pets Colombia', 'correo_comercial' => 'clinicapetscolombia@gmail.com', 'municipio' => 'Chía', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica Veterinaria'],
            ['razon_social' => 'Animal Services Chía', 'correo_comercial' => 'clinicaveterinaria@animalservices.com.co', 'municipio' => 'Chía', 'departamento' => 'Cundinamarca', 'tipo' => 'Hospital 24/7'],
            ['razon_social' => 'Hospital Veterinario Mascotas S.A.S.', 'correo_comercial' => 'hospitalveterinariomascotas@hotmail.com', 'municipio' => 'Cota', 'departamento' => 'Cundinamarca', 'tipo' => 'Hospital Veterinario'],
            ['razon_social' => 'Consultorio Dra. Mónica Camargo', 'correo_comercial' => 'mmonicamargo@gmail.com', 'municipio' => 'Cota', 'departamento' => 'Cundinamarca', 'tipo' => 'Consultorio Veterinario'],
            ['razon_social' => 'Vetmédica S.A.S. / Vetxotic', 'correo_comercial' => 'atencion.vetmedica@gmail.com', 'municipio' => 'Tenjo', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica Veterinaria'],
            ['razon_social' => 'Clínica Veterinaria V y V', 'correo_comercial' => 'mvvargasveterinaria@gmail.com', 'municipio' => 'Tenjo', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica Veterinaria'],
            ['razon_social' => 'Clínica Veterinaria Huellas', 'correo_comercial' => 'clinicaveterinariahuellas8@gmail.com', 'municipio' => 'Tabio', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica Veterinaria'],
            ['razon_social' => 'Centro Médico Veterinario Vitanimal', 'correo_comercial' => 'cmvitanimal@gmail.com', 'municipio' => 'Tocancipá', 'departamento' => 'Cundinamarca', 'tipo' => 'Centro Médico Veterinario'],
            ['razon_social' => 'Amigos del Campo MR', 'correo_comercial' => 'deysimr@hotmail.com', 'municipio' => 'Tocancipá', 'departamento' => 'Cundinamarca', 'tipo' => 'Servicios Veterinarios'],
            ['razon_social' => 'Dra. Claudia Marcela Cuitiva', 'correo_comercial' => 'claudiacuitiva8@gmail.com', 'municipio' => 'Sopó', 'departamento' => 'Cundinamarca', 'tipo' => 'Servicios Veterinarios'],
            ['razon_social' => 'Dra. Liliana Marcela Durán (MV)', 'correo_comercial' => 'lilianaduranvet@yahoo.com', 'municipio' => 'Sopó', 'departamento' => 'Cundinamarca', 'tipo' => 'Servicios Veterinarios'],
            ['razon_social' => 'Clínica Veterinaria de Funza', 'correo_comercial' => 'clinicaveterinariafunza@hotmail.com', 'municipio' => 'Funza', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica Veterinaria'],
            ['razon_social' => 'Centro Médico Veterinario Animalitos', 'correo_comercial' => 'veterinaria.animalitos@gmail.com', 'municipio' => 'Funza', 'departamento' => 'Cundinamarca', 'tipo' => 'Consultorio y Pet Shop'],
            ['razon_social' => 'PawerVet Clínica Veterinaria', 'correo_comercial' => 'pawervet@gmail.com', 'municipio' => 'Mosquera', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica Veterinaria'],
            ['razon_social' => 'Clínica Veterinaria Family Pets', 'correo_comercial' => 'info@familypets.com', 'municipio' => 'Madrid', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica Veterinaria'],
            ['razon_social' => 'Veterinaria Animal Blue', 'correo_comercial' => 'vetanimalblue@gmail.com', 'municipio' => 'Madrid', 'departamento' => 'Cundinamarca', 'tipo' => 'Servicios Veterinarios'],
            ['razon_social' => 'Clínica Veterinaria Facatativá', 'correo_comercial' => 'clinicaveterinariadrcesarayala@hotmail.com', 'municipio' => 'Facatativá', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica Veterinaria'],
            ['razon_social' => 'UCLIVET Unidad de Cuidado Clínico', 'correo_comercial' => 'uclivet@hotmail.com', 'municipio' => 'Facatativá', 'departamento' => 'Cundinamarca', 'tipo' => 'Hospital Veterinario'],
        ];

        foreach ($pendientesSabana as $item) {
            $email = strtolower(trim($item['correo_comercial']));
            ProspectoVeterinaria::firstOrCreate(
                ['correo_comercial' => $email],
                [
                    'razon_social' => $item['razon_social'],
                    'municipio' => $item['municipio'],
                    'departamento' => $item['departamento'],
                    'tipo' => $item['tipo'],
                    'estado' => 'pendiente',
                    'fuente' => 'Google Maps Sabana',
                ]
            );
        }
    }

    public function down(): void
    {
        // Safe down
    }
};
