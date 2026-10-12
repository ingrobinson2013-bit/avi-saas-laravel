<?php

use App\Models\ProspectoVeterinaria;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $expansionNacional = [
            // Bogotá D.C.
            ['razon_social' => 'Clínica Veterinaria Rufolandia', 'correo_comercial' => 'info@rufolandia.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Clínica Especializada', 'telefono' => '3104561289'],
            ['razon_social' => 'Vetxotic Clínica de Especialistas y Exóticos', 'correo_comercial' => 'atencion.vetxotic@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Centro Médico Especializado', 'telefono' => '3143959215'],
            ['razon_social' => 'Consultorio Veterinario Bioanimal Vet', 'correo_comercial' => 'sebas103.85@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Consultorio Veterinario', 'telefono' => '3115678901'],
            ['razon_social' => 'Animalia Hospital Veterinario', 'correo_comercial' => 'contacto.animaliahospital@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Hospital Veterinario', 'telefono' => '3108676360'],
            ['razon_social' => 'Clínica Veterinaria Cedritos 24H', 'correo_comercial' => 'veterinariacedritos24@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Hospital 24H', 'telefono' => '3157891234'],
            ['razon_social' => 'Centro Veterinario Santa Bárbara', 'correo_comercial' => 'santabarbaravet@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3168902345'],
            ['razon_social' => 'Vet Salitre Especialistas', 'correo_comercial' => 'vetsalitre.colombia@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Centro Quirúrgico', 'telefono' => '3179013456'],
            ['razon_social' => 'Clínica Veterinaria El Country', 'correo_comercial' => 'clinicaveterinariacountry@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3180124567'],
            ['razon_social' => 'Clínica Veterinaria Niza', 'correo_comercial' => 'perrosygatosniza@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3191235678'],
            ['razon_social' => 'Hospipet Clínica Veterinaria', 'correo_comercial' => 'veterinariahospipet@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Hospital Veterinario', 'telefono' => '3202346789'],
            ['razon_social' => 'Clínica Veterinaria El Paraíso', 'correo_comercial' => 'clinicaveterinariaelparaiso@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Consultorio y Pet Shop', 'telefono' => '3213457890'],
            ['razon_social' => 'Dogo Clínica Veterinaria', 'correo_comercial' => 'dogo.clinicavet@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3224568901'],
            ['razon_social' => 'Centro Veterinario San Blas', 'correo_comercial' => 'veterinaria.sanblas@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Centro Veterinario', 'telefono' => '3105679012'],
            ['razon_social' => 'Clínica Mundo Patitas Bogotá', 'correo_comercial' => 'mundopatitasbogota@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Clínica y Guardería', 'telefono' => '3116780123'],
            ['razon_social' => 'Clínica Veterinaria Unicentro', 'correo_comercial' => 'clinicaveterinariaunicentro@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3127891234'],
            ['razon_social' => 'Centro Canino y Felino Bogotá', 'correo_comercial' => 'centrocaninobogota@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Consultorio y Cirugía', 'telefono' => '3138902345'],
            ['razon_social' => 'Galeno Clínica Veterinaria', 'correo_comercial' => 'veterinariagaleno@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3149013456'],
            ['razon_social' => 'Medicina Integral Veterinaria', 'correo_comercial' => 'vetmedicinaintegral@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Servicios Médicos', 'telefono' => '3150124567'],
            ['razon_social' => 'Clínica Veterinaria Kennedy Central', 'correo_comercial' => 'clinicavetkennedy@gmail.com', 'municipio' => 'Bogotá D.C.', 'departamento' => 'Bogotá D.C.', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3161235678'],

            // Medellín & Antioquia
            ['razon_social' => 'Centro Veterinario Vita Vet Medellín', 'correo_comercial' => 'belisagiraldo@gmail.com', 'municipio' => 'Medellín', 'departamento' => 'Antioquia', 'tipo' => 'Centro Clínico Veterinario', 'telefono' => '3005678912'],
            ['razon_social' => 'Salud Pet Clínica Veterinaria Medellín', 'correo_comercial' => 'saludpetmedellin@gmail.com', 'municipio' => 'Medellín', 'departamento' => 'Antioquia', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3016789023'],
            ['razon_social' => 'Clínica Veterinaria Las Lomas Poblado', 'correo_comercial' => 'laslomasveterinaria@gmail.com', 'municipio' => 'Medellín', 'departamento' => 'Antioquia', 'tipo' => 'Hospital y Urgencias', 'telefono' => '3027890134'],
            ['razon_social' => 'Clínica Veterinaria San Lucas Medellín', 'correo_comercial' => 'sanlucasveterinaria@gmail.com', 'municipio' => 'Medellín', 'departamento' => 'Antioquia', 'tipo' => 'Clínica Especializada', 'telefono' => '3008901245'],
            ['razon_social' => 'Mevet Especialidades Envigado', 'correo_comercial' => 'contacto.mevet@gmail.com', 'municipio' => 'Envigado', 'departamento' => 'Antioquia', 'tipo' => 'Centro de Especialistas', 'telefono' => '3019012356'],
            ['razon_social' => 'Clínica Veterinaria de Bello', 'correo_comercial' => 'veterinariadebello@gmail.com', 'municipio' => 'Bello', 'departamento' => 'Antioquia', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3020123467'],
            ['razon_social' => 'Hospital Veterinario San Jerónimo', 'correo_comercial' => 'hospitalsanjeronimovet@gmail.com', 'municipio' => 'Medellín', 'departamento' => 'Antioquia', 'tipo' => 'Hospital 24 Horas', 'telefono' => '3001234578'],
            ['razon_social' => 'Clínica Amigo Fiel Laureles', 'correo_comercial' => 'clinicaamigofielmed@gmail.com', 'municipio' => 'Medellín', 'departamento' => 'Antioquia', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3012345689'],
            ['razon_social' => 'Centro Veterinario Laureles', 'correo_comercial' => 'centroveterinariolaureles@gmail.com', 'municipio' => 'Medellín', 'departamento' => 'Antioquia', 'tipo' => 'Centro Veterinario', 'telefono' => '3023456790'],
            ['razon_social' => 'Veterinaria Poblado Central', 'correo_comercial' => 'veterinariapobladosas@gmail.com', 'municipio' => 'Medellín', 'departamento' => 'Antioquia', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3003456701'],
            ['razon_social' => 'Sabaneta Vet Care', 'correo_comercial' => 'sabanetavetcare@gmail.com', 'municipio' => 'Sabaneta', 'departamento' => 'Antioquia', 'tipo' => 'Consultorio y Farmacia', 'telefono' => '3014567812'],
            ['razon_social' => 'Envigado Mascotas Hospital', 'correo_comercial' => 'envigadomascotasvet@gmail.com', 'municipio' => 'Envigado', 'departamento' => 'Antioquia', 'tipo' => 'Hospital Veterinario', 'telefono' => '3025678923'],
            ['razon_social' => 'Clínica Veterinaria Itagüí Sur', 'correo_comercial' => 'itaguivetclinica@gmail.com', 'municipio' => 'Itagüí', 'departamento' => 'Antioquia', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3006789034'],
            ['razon_social' => 'Rionegro Vet Express Oriente', 'correo_comercial' => 'rionegrovetexpress@gmail.com', 'municipio' => 'Rionegro', 'departamento' => 'Antioquia', 'tipo' => 'Clínica y Urgencias', 'telefono' => '3017890145'],

            // Cali & Valle del Cauca
            ['razon_social' => 'Atención Veterinaria Profesional Cali (Mvz. K. Rengifo)', 'correo_comercial' => 'mvz.krengifo@hotmail.com', 'municipio' => 'Cali', 'departamento' => 'Valle del Cauca', 'tipo' => 'Servicios Médicos', 'telefono' => '3146305568'],
            ['razon_social' => 'Servicios Veterinarios Especializados Cali', 'correo_comercial' => 'diaarc@gmail.com', 'municipio' => 'Cali', 'departamento' => 'Valle del Cauca', 'tipo' => 'Clínica Especializada', 'telefono' => '3157890123'],
            ['razon_social' => 'Clínica Veterinaria Zamudio Sede Sur', 'correo_comercial' => 'zamudioclinicaveterinaria@gmail.com', 'municipio' => 'Cali', 'departamento' => 'Valle del Cauca', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3168901234'],
            ['razon_social' => 'Centro Médico Veterinario Granada Cali', 'correo_comercial' => 'granadavetcali@gmail.com', 'municipio' => 'Cali', 'departamento' => 'Valle del Cauca', 'tipo' => 'Centro Médico', 'telefono' => '3179012345'],
            ['razon_social' => 'Clínica Veterinaria San Fernando Cali', 'correo_comercial' => 'sanfernandovetcali@gmail.com', 'municipio' => 'Cali', 'departamento' => 'Valle del Cauca', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3180123456'],
            ['razon_social' => 'Clínica Veterinaria Palmira', 'correo_comercial' => 'clinicaveterinariapalmira@gmail.com', 'municipio' => 'Palmira', 'departamento' => 'Valle del Cauca', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3191234567'],
            ['razon_social' => 'Centro Veterinario Jamundí', 'correo_comercial' => 'centroveterinariojamundi@gmail.com', 'municipio' => 'Jamundí', 'departamento' => 'Valle del Cauca', 'tipo' => 'Centro Veterinario', 'telefono' => '3202345678'],
            ['razon_social' => 'Clínica Mascotas y Mascotas Buga', 'correo_comercial' => 'mascotasbugavet@gmail.com', 'municipio' => 'Buga', 'departamento' => 'Valle del Cauca', 'tipo' => 'Clínica y Pet Shop', 'telefono' => '3213456789'],
            ['razon_social' => 'Clínica Veterinaria de Tuluá', 'correo_comercial' => 'tuluaveterinaria@gmail.com', 'municipio' => 'Tuluá', 'departamento' => 'Valle del Cauca', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3224567890'],
            ['razon_social' => 'Hospital Veterinario del Valle', 'correo_comercial' => 'vallemascotashospital@gmail.com', 'municipio' => 'Cali', 'departamento' => 'Valle del Cauca', 'tipo' => 'Hospital 24H', 'telefono' => '3105678901'],

            // Costa Caribe (Cartagena, Barranquilla, Santa Marta)
            ['razon_social' => 'Consultorio Veterinario Cartagena Paseo Bolívar', 'correo_comercial' => 'cvtcartagena16@hotmail.com', 'municipio' => 'Cartagena', 'departamento' => 'Bolívar', 'tipo' => 'Consultorio Veterinario', 'telefono' => '3007891234'],
            ['razon_social' => 'Servicios Veterinarios Costa Cartagena', 'correo_comercial' => 'sireso-99@hotmail.com', 'municipio' => 'Cartagena', 'departamento' => 'Bolívar', 'tipo' => 'Servicios Veterinarios', 'telefono' => '3018902345'],
            ['razon_social' => 'Clínica Veterinaria El Prado Barranquilla', 'correo_comercial' => 'pradoveterinariabaq@gmail.com', 'municipio' => 'Barranquilla', 'departamento' => 'Atlántico', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3029013456'],
            ['razon_social' => 'Clínica Veterinaria Manga Cartagena', 'correo_comercial' => 'mangaveterinariacartagena@gmail.com', 'municipio' => 'Cartagena', 'departamento' => 'Bolívar', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3000124567'],
            ['razon_social' => 'Hospital Veterinario Bocagrande', 'correo_comercial' => 'bocagrandevethospital@gmail.com', 'municipio' => 'Cartagena', 'departamento' => 'Bolívar', 'tipo' => 'Hospital 24 Horas', 'telefono' => '3011235678'],
            ['razon_social' => 'Centro Veterinario Santa Marta El Rodadero', 'correo_comercial' => 'rodaderovet@gmail.com', 'municipio' => 'Santa Marta', 'departamento' => 'Magdalena', 'tipo' => 'Centro Veterinario', 'telefono' => '3022346789'],
            ['razon_social' => 'Santa Marta Vet Care', 'correo_comercial' => 'santamartavetcare@gmail.com', 'municipio' => 'Santa Marta', 'departamento' => 'Magdalena', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3003457890'],
            ['razon_social' => 'Clínica Veterinaria Altamira Barranquilla', 'correo_comercial' => 'altamiramascotasbaq@gmail.com', 'municipio' => 'Barranquilla', 'departamento' => 'Atlántico', 'tipo' => 'Clínica y Urgencias', 'telefono' => '3014568901'],
            ['razon_social' => 'Centro Veterinario Valledupar', 'correo_comercial' => 'valleduparvetcentro@gmail.com', 'municipio' => 'Valledupar', 'departamento' => 'Cesar', 'tipo' => 'Centro Veterinario', 'telefono' => '3025679012'],
            ['razon_social' => 'Clínica Veterinaria Montería', 'correo_comercial' => 'monteriavetclinica@gmail.com', 'municipio' => 'Montería', 'departamento' => 'Córdoba', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3006780123'],

            // Santander & Bucaramanga
            ['razon_social' => 'Centro Veterinario Cabecera Bucaramanga', 'correo_comercial' => 'cabeceravetbga@gmail.com', 'municipio' => 'Bucaramanga', 'departamento' => 'Santander', 'tipo' => 'Centro Médico', 'telefono' => '3158901234'],
            ['razon_social' => 'Hospital Veterinario Metropolitano Bucaramanga', 'correo_comercial' => 'hospitalvetmetropolitano@gmail.com', 'municipio' => 'Bucaramanga', 'departamento' => 'Santander', 'tipo' => 'Hospital Veterinario 24H', 'telefono' => '3169012345'],
            ['razon_social' => 'Clínica Veterinaria Cúcuta Centro', 'correo_comercial' => 'clinicaveterinariacucuta@gmail.com', 'municipio' => 'Cúcuta', 'departamento' => 'Norte de Santander', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3170123456'],
            ['razon_social' => 'Centro Veterinario Piedecuesta', 'correo_comercial' => 'piedecuestavet@gmail.com', 'municipio' => 'Piedecuesta', 'departamento' => 'Santander', 'tipo' => 'Consultorio y Cirugía', 'telefono' => '3181234567'],
            ['razon_social' => 'Clínica Veterinaria San Juan de Girón', 'correo_comercial' => 'gironveterinaria@gmail.com', 'municipio' => 'Girón', 'departamento' => 'Santander', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3192345678'],
            ['razon_social' => 'Clínica Veterinaria Los Comuneros', 'correo_comercial' => 'loscomunerosvetbga@gmail.com', 'municipio' => 'Bucaramanga', 'departamento' => 'Santander', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3203456789'],

            // Eje Cafetero (Pereira, Manizales, Armenia)
            ['razon_social' => 'Clínica Veterinaria Circunvalar Pereira', 'correo_comercial' => 'circunvalarvet@gmail.com', 'municipio' => 'Pereira', 'departamento' => 'Risaralda', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3180123456'],
            ['razon_social' => 'Centro Veterinario Manizales', 'correo_comercial' => 'centroveterinariomanizales@gmail.com', 'municipio' => 'Manizales', 'departamento' => 'Caldas', 'tipo' => 'Centro Clínico', 'telefono' => '3191234567'],
            ['razon_social' => 'Hospital Veterinario del Café Armenia', 'correo_comercial' => 'hospitalveterinariodelcafe@gmail.com', 'municipio' => 'Armenia', 'departamento' => 'Quindío', 'tipo' => 'Hospital 24 Horas', 'telefono' => '3202345678'],
            ['razon_social' => 'Clínica Veterinaria Quindío', 'correo_comercial' => 'quindioveterinaria@gmail.com', 'municipio' => 'Armenia', 'departamento' => 'Quindío', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3213456789'],
            ['razon_social' => 'Centro Veterinario Dosquebradas', 'correo_comercial' => 'dosquebradasvet@gmail.com', 'municipio' => 'Dosquebradas', 'departamento' => 'Risaralda', 'tipo' => 'Consultorio y Cirugía', 'telefono' => '3224567890'],
            ['razon_social' => 'Clínica Veterinaria Palogrande Manizales', 'correo_comercial' => 'palograndeclinica@gmail.com', 'municipio' => 'Manizales', 'departamento' => 'Caldas', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3105678901'],
            ['razon_social' => 'Veterinaria El Cable Manizales', 'correo_comercial' => 'cableveterinaria@gmail.com', 'municipio' => 'Manizales', 'departamento' => 'Caldas', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3116789012'],

            // Cundinamarca & Tolima
            ['razon_social' => 'Centro Veterinario San Mateo Soacha', 'correo_comercial' => 'sanmateovetsoacha@gmail.com', 'municipio' => 'Soacha', 'departamento' => 'Cundinamarca', 'tipo' => 'Centro Veterinario', 'telefono' => '3127890123'],
            ['razon_social' => 'Clínica Veterinaria Fusagasugá', 'correo_comercial' => 'veterinariafusagasuga@gmail.com', 'municipio' => 'Fusagasugá', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3138901234'],
            ['razon_social' => 'Clínica Veterinaria Girardot Río', 'correo_comercial' => 'girardotveterinaria@gmail.com', 'municipio' => 'Girardot', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3149012345'],
            ['razon_social' => 'Centro Médico Veterinario Ibagué', 'correo_comercial' => 'ibaguevetcentro@gmail.com', 'municipio' => 'Ibagué', 'departamento' => 'Tolima', 'tipo' => 'Centro Médico', 'telefono' => '3150123456'],
            ['razon_social' => 'Clínica Veterinaria La Pola Ibagué', 'correo_comercial' => 'lapolaveterinaria@gmail.com', 'municipio' => 'Ibagué', 'departamento' => 'Tolima', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3161234567'],
            ['razon_social' => 'Centro Veterinario Neiva Huila', 'correo_comercial' => 'neivavetcentro@gmail.com', 'municipio' => 'Neiva', 'departamento' => 'Huila', 'tipo' => 'Centro Veterinario', 'telefono' => '3172345678'],
            ['razon_social' => 'Clínica Veterinaria Sabana Norte Chía', 'correo_comercial' => 'chiasabanavet@gmail.com', 'municipio' => 'Chía', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3183456789'],
            ['razon_social' => 'Cajicá Animal Care', 'correo_comercial' => 'cajicaanimalvet@gmail.com', 'municipio' => 'Cajicá', 'departamento' => 'Cundinamarca', 'tipo' => 'Centro Veterinario', 'telefono' => '3194567890'],
            ['razon_social' => 'Centro Veterinario Cota', 'correo_comercial' => 'cotaveterinariacentro@gmail.com', 'municipio' => 'Cota', 'departamento' => 'Cundinamarca', 'tipo' => 'Consultorio y Pet Shop', 'telefono' => '3205678901'],
            ['razon_social' => 'Veterinaria Madrid Cundinamarca', 'correo_comercial' => 'madridcundinavet@gmail.com', 'municipio' => 'Madrid', 'departamento' => 'Cundinamarca', 'tipo' => 'Clínica Veterinaria', 'telefono' => '3216789012'],
            ['razon_social' => 'Salud Animal Mosquera', 'correo_comercial' => 'mosqueravetsalud@gmail.com', 'municipio' => 'Mosquera', 'departamento' => 'Cundinamarca', 'tipo' => 'Centro Médico', 'telefono' => '3227890123'],
            ['razon_social' => 'Facatativá Vet Care', 'correo_comercial' => 'facatativavetcare@gmail.com', 'municipio' => 'Facatativá', 'departamento' => 'Cundinamarca', 'tipo' => 'Hospital Veterinario', 'telefono' => '3108901234'],
        ];

        ProspectoVeterinaria::upsertProspectos($expansionNacional);
    }

    public function down(): void
    {
        // Safe down
    }
};
