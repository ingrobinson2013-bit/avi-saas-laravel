<?php

namespace App\Http\Controllers;

use App\Services\BlogService;
use Illuminate\Http\Request;

class SaaSLandingController extends Controller
{
    public function show(Request $request, string $pageKey)
    {
        if (strtolower(trim($request->getHost())) === 'www.avipetapp.com') {
            return redirect()->to('https://avipetapp.com' . $request->getRequestUri(), 301);
        }

        $pages = self::getPages();
        if (!isset($pages[$pageKey])) {
            abort(404);
        }

        $page = $pages[$pageKey];
        $blogPosts = array_slice(BlogService::getAllPosts(), 0, 4);

        return view('saas.landing', [
            'pageKey' => $pageKey,
            'page' => $page,
            'allPages' => $pages,
            'blogPosts' => $blogPosts,
        ]);
    }

    public static function getPages(): array
    {
        return [
            'planes-salud' => [
                'slug' => 'software-planes-salud-veterinaria',
                'badge' => 'Software #1 en Colombia para Membresías Preventivas',
                'title' => 'Software para Planes de Salud Veterinarios en Colombia | Membresías y Carnet QR — AviPetApp',
                'meta_description' => 'Crea, vende y administra planes de salud veterinarios y membresías preventivas en tu clínica veterinaria con AviPetApp. Carnet digital QR, canje en mostrador en 1 clic y 0% de comisión. Prueba 15 días gratis.',
                'keywords' => 'planes de salud veterinarios, software planes de salud veterinaria, membresias veterinarias colombia, como crear planes de salud para mascotas, software planes preventivos veterinaria, ingresos recurrentes clinica veterinaria, avipetapp',
                'h1_prefix' => 'Software para crear y administrar',
                'h1_highlight' => 'Planes de Salud Veterinarios',
                'h1_suffix' => 'en tu propia clínica.',
                'lead' => 'Transforma consultas aisladas en ingresos recurrentes todos los meses. Con AviPetApp estructuras tus propios planes de salud preventiva para perros y gatos bajo tu marca, emites carnets digitales con código QR y controlas el canje de vacunas y consultas en recepción sin hojas de Excel.',
                'widget_type' => 'mrr_simulator',
                'pillars' => [
                    [
                        'title' => '100% Tu Marca, Tus Tarifas y 0% Comisión',
                        'desc' => 'Configura Plan Cachorro, Plan Bienestar Adulto, Plan Felino o Plan Senior con los precios de tu clínica. El 100% del dinero pagado por los tutores entra directo a tu Nequi, Bancolombia, datáfono o pasarela.',
                    ],
                    [
                        'title' => 'Control Exacto de Cupos y Carencias en Recepción',
                        'desc' => 'Olvídate del fraude o de regalar consultas a clientes en mora. Al escanear el código QR de la mascota, tu recepción ve al instante qué vacunas, baños o controles siguen disponibles y cuáles ya fueron usados.',
                    ],
                    [
                        'title' => 'Convive con tu Software de Historia Clínica',
                        'desc' => 'No tienes que migrar historias médicas ni cambiar tu facturador. AviPetApp se activa en 60 segundos como tu motor comercial de membresías, fidelización y recordatorios con IA supervisada.',
                    ],
                ],
                'steps' => [
                    ['step' => 'Paso 1', 'title' => 'Elige tus planes base', 'desc' => 'Tu cuenta nace con plantillas listas (Plan Básico y Plan Premium) con costos e insumos calculados para Colombia.'],
                    ['step' => 'Paso 2', 'title' => 'Imprime tu Afiche QR de Sala de Espera', 'desc' => 'AviPetApp genera en PDF el afiche oficial con el logo de tu veterinaria para que los tutores conozcan tus planes mientras esperan consulta.'],
                    ['step' => 'Paso 3', 'title' => 'Afilia en 45 segundos y emite Carnet QR', 'desc' => 'Registra al tutor y su mascota. Al instante recibe en su WhatsApp su Carnet Digital interactivo con saldo en vivo.'],
                    ['step' => 'Paso 4', 'title' => 'Descuenta servicios en 1 clic', 'desc' => 'Cada vacuna, desparasitación o consulta redimida queda auditada con fecha, hora y miembro del equipo.'],
                ],
                'faqs' => [
                    [
                        'question' => '¿Qué son los planes de salud veterinarios y por qué no son seguros?',
                        'answer' => 'Los planes de salud veterinarios son membresías de medicina preventiva administradas directamente por tu clínica veterinaria (vacunación anual, desparasitación trimestral, consultas programadas, exámenes de control y descuentos en estética o cirugía). No son seguros financieros de siniestros, por lo que el cliente utiliza sus beneficios desde el primer mes y tu clínica conserva un margen bruto promedio superior al 65%.',
                    ],
                    [
                        'question' => '¿Cuánto cobra AviPetApp por cada plan de salud veterinario que venda mi clínica?',
                        'answer' => 'Cero comisiones (0%). Todo el dinero que cobres por tus planes de salud va directamente a las cuentas bancarias, Nequi, Daviplata o datáfono de tu veterinaria. En AviPetApp solo eliges un paquete prepago desde $50.000 COP (10 mascotas) o tarifa plana mensual desde $99.000 COP después de tus 15 días gratis.',
                    ],
                    [
                        'question' => '¿Cuántos planes de salud veterinarios debo ofrecer en mi veterinaria?',
                        'answer' => 'La estructura más rentable en Colombia consiste en ofrecer 2 o 3 niveles claros: un Plan Esencial ($39.000 a $49.000 COP/mes) con vacunas, desparasitación y consultas de control, y un Plan Integral o Senior ($69.000 a $89.000 COP/mes) que añade cuadro hemático, perfil bioquímico y descuento en profilaxis dental.',
                    ],
                    [
                        'question' => '¿Puedo probar el software de planes de salud veterinarios gratis?',
                        'answer' => 'Sí. Tienes 15 días de prueba gratuita con acceso completo a tu vitrina pública, generador de afiche QR en PDF, carnets digitales ilimitados y terminal de canje en mostrador, sin ingresar tarjeta de crédito.',
                    ],
                ],
            ],

            'carnet-qr' => [
                'slug' => 'carnet-vacunacion-digital-mascotas-qr',
                'badge' => 'Adiós al Carnet de Cartón Perdido',
                'title' => 'Carnet de Vacunación Digital para Mascotas con Código QR | Software Veterinario — AviPetApp',
                'meta_description' => 'Emite carnets digitales para perros y gatos con código QR en WhatsApp y celular. Controla vacunas, desparasitación, planes de salud y recordatorios preventivos en tu clínica veterinaria. Prueba 15 días gratis.',
                'keywords' => 'carnet de vacunacion digital mascotas, carnet digital veterinario qr, carnet de vacunas para perros digital colombia, carnet virtual mascotas whatsapp, software carnet veterinario qr, avipetapp',
                'h1_prefix' => 'Carnet Digital para Mascotas con',
                'h1_highlight' => 'Código QR en WhatsApp',
                'h1_suffix' => 'con el logo de tu veterinaria.',
                'lead' => 'El 72% de los tutores pierde u olvida el carnet de cartón en casa y termina comprando refuerzos o antiparasitarios en otra parte. Con AviPetApp entregas un Carnet Digital interactivo con código QR que vive en el celular del cliente y lo conecta siempre con tu clínica.',
                'widget_type' => 'qr_preview',
                'pillars' => [
                    [
                        'title' => 'Accesible desde WhatsApp sin Descargar Apps',
                        'desc' => 'El tutor abre el enlace o PDF oficial de su mascota desde cualquier celular Android o iPhone sin contraseñas complicadas, viendo el logo, WhatsApp y botón de agendamiento de tu veterinaria.',
                    ],
                    [
                        'title' => 'Escaneo QR Instantáneo en Mostrador',
                        'desc' => 'Cuando la mascota llega a consulta, baño o vacunación, escaneas el código QR con la cámara o buscas por cédula del tutor para verificar estado activo y descontar beneficios en 2 segundos.',
                    ],
                    [
                        'title' => 'Recordatorios Preventivos con IA Supervisada',
                        'desc' => 'Organiza alertas de próximas vacunas, desparasitaciones y renovaciones de membresía para escribirle al tutor por WhatsApp antes de que olvide su cita. La IA organiza información; el criterio clínico es de tu equipo veterinario.',
                    ],
                ],
                'steps' => [
                    ['step' => 'Paso 1', 'title' => 'Personaliza el color y logo de tu clínica', 'desc' => 'Sube el logotipo de tu veterinaria para que cada carnet digital luzca 100% corporativo y profesional.'],
                    ['step' => 'Paso 2', 'title' => 'Registra al paciente y su plan preventivo', 'desc' => 'Ingresa nombre de la mascota, especie, raza y tutor en menos de un minuto desde recepción.'],
                    ['step' => 'Paso 3', 'title' => 'Envía el Carnet QR por WhatsApp en 1 clic', 'desc' => 'Comparte el link en vivo y su versión PDF descargable directamente al WhatsApp del propietario.'],
                    ['step' => 'Paso 4', 'title' => 'Escanea y fideliza todo el año', 'desc' => 'Cada visita actualiza el saldo de servicios en tiempo real, elevando la retención anual por encima del 85%.'],
                ],
                'faqs' => [
                    [
                        'question' => '¿El tutor de la mascota debe instalar alguna aplicación para ver su Carnet Digital QR?',
                        'answer' => 'No. El Carnet Digital de AviPetApp funciona instantáneamente en cualquier navegador móvil desde WhatsApp e incluye opción de descarga en PDF de alta resolución, eliminando cualquier barrera tecnológica para tus clientes.',
                    ],
                    [
                        'question' => '¿Necesito comprar lectores láser especiales para escanear el código QR en mi veterinaria?',
                        'answer' => 'No necesitas hardware adicional. Puedes escanear el código QR con la cámara de cualquier celular, tablet o computador en recepción, o buscar al paciente en 1 segundo por número de documento o teléfono del tutor.',
                    ],
                    [
                        'question' => '¿El carnet digital sale con el nombre de mi veterinaria o con el de AviPetApp?',
                        'answer' => 'Sale con la identidad visual, logotipo, colores, teléfono WhatsApp y dirección de tu propia clínica veterinaria bajo arquitectura de marca blanca.',
                    ],
                    [
                        'question' => '¿Cuánto cuesta activar los carnets digitales con código QR en mi clínica?',
                        'answer' => 'Puedes activarlos hoy mismo con 15 días de prueba totalmente gratis. Después puedes operar desde $50.000 COP en modalidad prepago para 10 mascotas o desde $99.000 COP/mes hasta 60 mascotas activas.',
                    ],
                ],
            ],

            'prueba-gratis' => [
                'slug' => 'crear-clinica-veterinaria-gratis',
                'badge' => 'Alta Instantánea en 60 Segundos · Sin Tarjeta de Crédito',
                'title' => 'Prueba Gratis Software para Clínicas Veterinarias en Colombia (15 Días) | AviPetApp',
                'meta_description' => 'Activa gratis por 15 días el software para clínicas veterinarias AviPetApp en Colombia. Crea tu vitrina de planes de salud, afiche QR de mostrador y carnets digitales en 60 segundos sin tarjeta de crédito.',
                'keywords' => 'software para clinicas veterinarias colombia, prueba gratis software veterinario, crear planes de salud veterinaria gratis, sistema para veterinarias bogota medellin cali, software con ia para veterinarias, avipetapp registro',
                'h1_prefix' => 'Activa en 60 segundos tu plataforma de',
                'h1_highlight' => 'Planes de Salud e IA Veterinaria',
                'h1_suffix' => '(15 días gratis).',
                'lead' => 'Diseñado para médicos veterinarios y administradores de clínicas en Bogotá, Medellín, Cali, Barranquilla, Bucaramanga, Sabana Norte y toda Colombia que buscan generar ingresos recurrentes y retener a sus pacientes todo el año.',
                'widget_type' => 'subdomain_preview',
                'pillars' => [
                    [
                        'title' => 'Tu Vitrina Web Propia Lista al Instante',
                        'desc' => 'Al registrarte recibes automáticamente tu portal público (tu-clinica.avipetapp.com) donde tus clientes consultan tus planes de salud para mascotas y solicitan afiliación en línea.',
                    ],
                    [
                        'title' => 'Cero Deudas Acumuladas (Modelo Prepago Transparente)',
                        'desc' => 'Prueba 15 días gratis sin tarjeta. Si decides continuar, recargas paquetes desde $50.000 COP o plan mensual desde $99.000 COP, siempre mes anticipado y sin cláusulas de permanencia.',
                    ],
                    [
                        'title' => 'Acceso Opcional a Red de Clínicas Socias AVIPET BioLab®',
                        'desc' => 'Complementa tus ingresos recurrentes distribuyendo en mostrador suplementación biotecnológica hipoalergénica (Dermo & Gut Superboost) con margen preferencial para veterinarias aliadas.',
                    ],
                ],
                'steps' => [
                    ['step' => 'Minuto 0:15', 'title' => 'Completa los datos básicos de tu veterinaria', 'desc' => 'Nombre comercial, ciudad, WhatsApp y correo electrónico en el formulario de esta página.'],
                    ['step' => 'Minuto 0:30', 'title' => 'Aprovisionamiento automático de planes', 'desc' => 'El sistema crea tu panel privado con beneficios veterinarios y 2 planes preventivos listos para ajustar precios.'],
                    ['step' => 'Minuto 0:45', 'title' => 'Sube tu logo y descarga tu Afiche QR', 'desc' => 'Imprime el hablador de recepción para que cada tutor que visite hoy tu consultorio pregunte por tu membresía.'],
                    ['step' => 'Día 1 a 15', 'title' => 'Afilia tus primeras mascotas reales', 'desc' => 'Con solo 2 o 3 mascotas afiliadas cubres el costo mensual de la plataforma y el resto del año es utilidad recurrente para tu clínica.'],
                ],
                'faqs' => [
                    [
                        'question' => '¿Qué pasa cuando terminan mis 15 días de prueba gratuita en AviPetApp?',
                        'answer' => 'No se realiza ningún cobro automático porque nunca te pedimos tarjeta de crédito para registrarte. Al finalizar los 15 días eliges libremente si activas un paquete prepago de 10 mascotas ($50.000 COP) o un plan mensual Starter ($99.000 COP).',
                    ],
                    [
                        'question' => '¿Funciona para consultorios veterinarios pequeños y veterinarias a domicilio?',
                        'answer' => 'Sí. Tanto clínicas grandes de 24 horas como consultorios de barrio o médicos veterinarios a domicilio en toda Colombia usan AviPetApp porque el paquete inicial cuesta apenas $50.000 COP y permite fidelizar desde tus primeros 10 pacientes fijos.',
                    ],
                    [
                        'question' => '¿Recibo acompañamiento para estructurar los precios de mis planes preventivos?',
                        'answer' => 'Sí. Al crear tu cuenta cuentas con nuestra calculadora actuarial integrada y soporte directo por WhatsApp (+57 323 581 3942) para ayudarte a calibrar tarifas y márgenes según tu ciudad.',
                    ],
                    [
                        'question' => '¿Mis datos y la base de clientes pertenecen a mi clínica veterinaria?',
                        'answer' => 'Al 100%. Tus clientes, mascotas, precios e historial de canjes son propiedad exclusiva de tu clínica veterinaria bajo estricto aislamiento multi-tenant.',
                    ],
                ],
            ],
        ];
    }
}
