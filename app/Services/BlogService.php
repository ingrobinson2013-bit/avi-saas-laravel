<?php

namespace App\Services;

class BlogService
{
    /**
     * Catálogo maestro de artículos optimizados para SEO B2B Veterinario en Colombia y LATAM.
     */
    public static function getAllPosts(): array
    {
        return [
            [
                'slug' => 'planes-de-salud-preventiva-veterinaria-ingresos-recurrentes',
                'title' => 'Cómo crear Planes de Salud Preventiva en tu Clínica Veterinaria y Facturar Ingresos Recurrentes',
                'excerpt' => 'Aprende paso a paso a diseñar planes de bienestar para perros y gatos que generen ingresos fijos mes a mes, blinden tu flujo de caja y aumenten la fidelidad de los tutores de mascotas.',
                'category' => 'Rentabilidad & Negocio',
                'read_time' => '7 min de lectura',
                'author' => 'Robinson R. & Equipo Médico AVI',
                'author_role' => 'Ingeniero en Telecomunicaciones & Estratega SaaS',
                'published_at' => '2026-10-01',
                'updated_at' => '2026-10-08',
                'image' => 'https://images.unsplash.com/photo-1576201836106-db1758fd1c97?auto=format&fit=crop&w=1200&q=80',
                'keywords' => [
                    'planes de salud veterinaria',
                    'ingresos recurrentes veterinaria colombia',
                    'membresias para mascotas',
                    'rentabilidad clinica veterinaria',
                    'software planes bienestar mascotas'
                ],
                'content' => <<<'HTML'
<p class="lead text-lg text-slate-700 leading-relaxed font-medium mb-6">
El modelo tradicional de facturación en las clínicas veterinarias de Colombia y América Latina sufre de una debilidad crítica: <strong>la alta volatilidad de ingresos</strong>. Depender exclusivamente de que las mascotas se enfermen o sufran accidentes para facturar crea meses de altos ingresos seguidos de meses críticos donde el flujo de caja apenas cubre el arriendo y la nómina.
</p>

<div class="bg-blue-50 border-l-4 border-blue-600 p-5 rounded-r-xl my-6">
    <p class="text-blue-900 font-semibold mb-1">Dato Clave del Sector Veterinario:</p>
    <p class="text-blue-800 text-sm">
        Las clínicas veterinarias que implementan planes de salud preventiva registran un incremento promedio del <strong>42% en el valor de vida del cliente (LTV)</strong> y reducen la deserción de pacientes en más del 60% durante el primer año.
    </p>
</div>

<h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">1. ¿Qué es un Plan de Salud Preventiva para Mascotas?</h2>
<p class="text-slate-700 leading-relaxed mb-4">
A diferencia de un seguro médico para mascotas (que cubre imprevistos quirúrgicos o accidentes mayores), un <strong>plan de salud preventiva</strong> es un programa de suscripción recurrente mensual que cubre la medicina preventiva que toda mascota necesita a lo largo del año para mantenerse sana:
</p>
<ul class="list-disc pl-6 space-y-2 text-slate-700 mb-6">
    <li>Esquema vacunal anual completo (Rabia, Séxtuple, KC en caninos; Triple felina y Leucemia en felinos).</li>
    <li>Desparasitación interna y externa periódica (trimestral o bimestral).</li>
    <li>Consultas médicas veterinarias de control ilimitadas o con cupo programado.</li>
    <li>Exámenes de laboratorio preventivos (coprológico, hemograma anual, perfil renal/hepático en pacientes senior).</li>
    <li>Descuentos exclusivos en farmacia, profilaxis dental, ecografías y estética canina.</li>
</ul>

<h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">2. Cómo Estructurar tus Niveles de Planes (Básico vs Premium)</h2>
<p class="text-slate-700 leading-relaxed mb-4">
El error más común de los médicos veterinarios es crear una lista interminable de planes que confunde al tutor. La mejor práctica de negocio probada en AVI-Plan es estructurar únicamente <strong>dos o máximo tres planes claros</strong>:
</p>

<div class="grid md:grid-cols-2 gap-4 my-6">
    <div class="border border-slate-200 rounded-xl p-5 bg-white shadow-sm">
        <span class="inline-block bg-emerald-100 text-emerald-800 text-xs font-bold px-2.5 py-1 rounded-full mb-2">Nivel 1: Plan Cachorro / Bienestar Básico</span>
        <h3 class="text-lg font-bold text-slate-900 mb-2">Cuota Sugerida: $39.000 a $49.000 COP / mes</h3>
        <p class="text-sm text-slate-600 mb-3">Enfocado en prevención esencial para pacientes jóvenes y familias que cuidan su presupuesto.</p>
        <ul class="text-xs text-slate-600 space-y-1">
            <li>✓ Vacunación anual al día</li>
            <li>✓ Desparasitación interna cada 3 meses</li>
            <li>✓ 2 Consultas de revisión médica al año</li>
            <li>✓ 10% de descuento en estética y accesorios</li>
        </ul>
    </div>
    <div class="border-2 border-blue-500 rounded-xl p-5 bg-blue-50/50 shadow-sm relative">
        <span class="inline-block bg-blue-600 text-white text-xs font-bold px-2.5 py-1 rounded-full mb-2">Nivel 2: Plan Integral / Senior VIP</span>
        <h3 class="text-lg font-bold text-slate-900 mb-2">Cuota Sugerida: $69.000 a $89.000 COP / mes</h3>
        <p class="text-sm text-slate-600 mb-3">Cobertura médica superior con exámenes diagnósticos para tutores altamente comprometidos.</p>
        <ul class="text-xs text-slate-600 space-y-1">
            <li>✓ Todas las vacunas y desparasitación premium</li>
            <li>✓ Consultas médicas veterinarias ilimitadas</li>
            <li>✓ 1 Hemograma completo y coprológico anual</li>
            <li>✓ 1 Profilaxis dental con 20% de descuento</li>
            <li>✓ Carnet digital prioritario con soporte por WhatsApp</li>
        </ul>
    </div>
</div>

<h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">3. La Matemática del Negocio: Margen del 65% y Retención</h2>
<p class="text-slate-700 leading-relaxed mb-4">
Hagamos un ejercicio real con una clínica veterinaria mediana en Colombia con <strong>150 mascotas suscritas</strong> a un plan promedio de <strong>$49.000 COP/mes</strong>:
</p>
<ul class="list-disc pl-6 space-y-2 text-slate-700 mb-6">
    <li><strong>Facturación Mensual Recurrente Fija (MRR):</strong> $7.350.000 COP mensuales que ingresan automáticamente el primer día de cada mes.</li>
    <li><strong>Costo Directo de Insumos (Biológicos y Antiparasitarios):</strong> ~$17.000 COP por mascota al mes.</li>
    <li><strong>Margen Bruto de la Clínica:</strong> ~$32.000 COP por mascota/mes (<strong>65.3% de margen</strong>).</li>
    <li><strong>Ganancia Neta Anual Adicional:</strong> Más de <strong>$57.600.000 COP libres</strong> al año, sin contar las cirugías, alimentos y medicamentos adicionales que el cliente compra en tu clínica porque ya no va a la competencia.</li>
</ul>

<h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">4. Por qué el Cobro Manual por Transferencia Fracasa</h2>
<p class="text-slate-700 leading-relaxed mb-4">
Muchos veterinarios intentan vender membresías cobrando por Nequi o transferencia bancaria en una libreta de Excel. <strong>A los tres meses el sistema colapsa</strong>:
</p>
<ol class="list-decimal pl-6 space-y-2 text-slate-700 mb-6">
    <li>El recepcionista olvida recordarle el pago a los tutores.</li>
    <li>El cliente viene a pedir una consulta gratuita habiendo dejado de pagar hace dos meses.</li>
    <li>No hay forma de validar si una vacuna ya fue aplicada o sigue disponible en el saldo.</li>
</ol>
<p class="text-slate-700 leading-relaxed mb-6">
Por esta razón, la tecnología SaaS como <strong>AVI-Plan</strong> automatiza el débito bancario recurrente (vía pasarelas como Bold o tarjetas de crédito), genera un <strong>Carnet Digital interactivo</strong> con código QR y actualiza en tiempo real el saldo de servicios en mostrador con un solo clic.
</p>

<div class="bg-gradient-to-r from-blue-900 to-indigo-900 text-white rounded-2xl p-8 my-8 text-center shadow-xl">
    <h3 class="text-2xl font-extrabold mb-3">Empieza a Cobrar Planes de Salud en tu Veterinaria</h3>
    <p class="text-blue-200 text-sm max-w-xl mx-auto mb-6">
        Configura tus planes de salud con tu propio logo y marca en menos de 10 minutos. Prueba AVI-Plan completamente gratis durante 15 días sin ingresar tarjeta de crédito.
    </p>
    <a href="/registro-clinica" class="inline-flex items-center px-6 py-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black rounded-xl shadow-lg transition transform hover:-translate-y-0.5">
        Crear mi Cuenta Gratis (15 Días) →
    </a>
</div>
HTML,
            ],
            [
                'slug' => 'fidelizacion-clientes-veterinaria-retencion-mascotas',
                'title' => 'Fidelización en Clínicas Veterinarias: Cómo Evitar que los Tutores de Mascotas Vayan a la Competencia',
                'excerpt' => 'Estrategias probadas para aumentar la retención de clientes en más del 80%: carnet digital en WhatsApp, recordatorios automatizados de vacunas y terminal de canje en mostrador.',
                'category' => 'Fidelización & Marketing',
                'read_time' => '6 min de lectura',
                'author' => 'Robinson R. & Equipo Médico AVI',
                'author_role' => 'Ingeniero en Telecomunicaciones & Estratega SaaS',
                'published_at' => '2026-10-03',
                'updated_at' => '2026-10-08',
                'image' => 'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?auto=format&fit=crop&w=1200&q=80',
                'keywords' => [
                    'fidelizacion clientes veterinaria',
                    'retencion tutores mascotas',
                    'carnet digital mascotas whatsapp',
                    'marketing para veterinarias colombia',
                    'atencion al cliente clinica veterinaria'
                ],
                'content' => <<<'HTML'
<p class="lead text-lg text-slate-700 leading-relaxed font-medium mb-6">
Captar un nuevo cliente para tu clínica veterinaria cuesta <strong>entre 5 y 7 veces más</strong> que retener a uno que ya confía en tu equipo médico. Sin embargo, más del 70% de las veterinarias en Colombia no tienen ningún sistema activo para evitar que el tutor de una mascota compre sus vacunas o medicamentos en el pet shop de la esquina.
</p>

<h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">1. El Carnet Físico de Cartón está Muerto</h2>
<p class="text-slate-700 leading-relaxed mb-4">
Durante décadas, las veterinarias entregaron libretas o carnets de cartulina sellados a mano. Hoy en día, los tutores de mascotas (principalmente millennials y centennials) <strong>pierden el carnet físico, lo dejan en casa o se olvidan de la fecha exacta del refuerzo vacunal</strong>.
</p>
<p class="text-slate-700 leading-relaxed mb-6">
La solución moderna es el <strong>Carnet Digital en el Smartphone</strong>:
</p>
<ul class="list-disc pl-6 space-y-2 text-slate-700 mb-6">
    <li>Accesible las 24 horas desde WhatsApp sin instalar aplicaciones pesadas.</li>
    <li>Muestra foto de la mascota, raza, microchip y coberturas vigentes.</li>
    <li>Código QR dinámico que el veterinario o recepcionista escanea en 2 segundos para validar el estado del plan.</li>
</ul>

<h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">2. Recordatorios Preventivos Automatizados (El Secreto de la Asistencia)</h2>
<p class="text-slate-700 leading-relaxed mb-4">
Cuando un tutor olvida la desparasitación trimestral o la vacuna anual de la rabia, no lo hace por negligencia: lo hace por falta de tiempo y sobrecarga diaria.
</p>
<p class="text-slate-700 leading-relaxed mb-4">
Un sistema automatizado de notificaciones vía WhatsApp y correo electrónico con <strong>7 días de anticipación</strong> y un recordatorio <strong>24 horas antes</strong> incrementa la tasa de asistencia a citas preventivas del 48% a más del <strong>89%</strong>.
</p>

<h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">3. La Experiencia de Canje en Mostrador: Transparencia Total</h2>
<p class="text-slate-700 leading-relaxed mb-4">
La mayor fricción en los modelos de membresía ocurre cuando el cliente llega a la veterinaria y pregunta: <em>"¿A mí todavía me queda una vacuna gratis este mes?"</em>.
</p>
<p class="text-slate-700 leading-relaxed mb-6">
Tener una <strong>Terminal de Canje Digital</strong> en la recepción de tu clínica permite:
</p>
<ul class="list-disc pl-6 space-y-2 text-slate-700 mb-6">
    <li>Digitar la cédula del tutor o el nombre de la mascota y ver al instante qué beneficios le quedan (ej: 1 Consulta disponible, 0 Profilaxis restantes).</li>
    <li>Hacer clic en "Canjear Servicio" y descontarlo automáticamente del historial con fecha, hora y nombre del médico tratante.</li>
    <li>Enviar un recibo de atención al WhatsApp del tutor al instante.</li>
</ul>

<div class="bg-blue-50 border border-blue-200 rounded-xl p-6 my-8">
    <h3 class="text-xl font-bold text-blue-900 mb-2">Convierte a tu Clínica en un Hábito, no en una Emergencia</h3>
    <p class="text-blue-800 text-sm leading-relaxed mb-4">
        Cuando los clientes tienen un plan activo en tu veterinaria, asisten entre 4 y 6 veces al año a tus instalaciones, en lugar de 1 vez cada dos años. Cada visita adicional genera ventas cruzadas de alimentación medicada, juguetes y aseo.
    </p>
    <a href="/registro-clinica" class="text-blue-700 hover:text-blue-900 font-bold text-sm underline">
        Activa tu Terminal de Canje con AVI-Plan hoy mismo →
    </a>
</div>
HTML,
            ],
            [
                'slug' => 'mejores-software-veterinarios-colombia-comparativa-2026',
                'title' => 'Los 5 Mejores Software Veterinarios en Colombia (2026): Comparativa, Precios y Funcionalidades',
                'excerpt' => 'Guía imparcial y comparativa de los principales programas de gestión veterinaria en Colombia: historias clínicas, facturación DIAN, planes de salud preventiva y apps móviles.',
                'category' => 'Tecnología & Software',
                'read_time' => '8 min de lectura',
                'author' => 'Robinson R. & Equipo de Arquitectura SaaS',
                'author_role' => 'Ingeniero en Telecomunicaciones & CEO NODIA',
                'published_at' => '2026-10-05',
                'updated_at' => '2026-10-08',
                'image' => 'https://images.unsplash.com/photo-1516715094483-75da7dee9758?auto=format&fit=crop&w=1200&q=80',
                'keywords' => [
                    'software veterinario colombia',
                    'programa gestion veterinaria bogota medellin',
                    'software para clinicas veterinarias',
                    'sistema historiales clinicos veterinaria',
                    'precio software veterinario colombia'
                ],
                'content' => <<<'HTML'
<p class="lead text-lg text-slate-700 leading-relaxed font-medium mb-6">
Elegir el software adecuado para tu clínica veterinaria en Colombia es una de las decisiones más estratégicas para el crecimiento de tu negocio. Una herramienta obsoleta genera demoras en recepción, pérdida de pacientes y falta de control sobre los ingresos mensuales.
</p>

<p class="text-slate-700 leading-relaxed mb-6">
En esta comparativa analizamos las opciones líderes del mercado colombiano en 2026 según su enfoque: <strong>Historias Clínicas, Facturación Electrónica DIAN y Planes de Salud Preventiva Recurrente</strong>.
</p>

<h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">1. AVI-Plan: El Especialista en Ingresos Recurrentes y Planes Preventivos</h2>
<div class="border border-blue-200 bg-blue-50/40 rounded-xl p-5 mb-6">
    <p class="text-sm text-slate-700 mb-2"><strong>Lo mejor:</strong> Diseñado específicamente para convertir clientes ocasionales en ingresos mensuales fijos automáticos.</p>
    <p class="text-sm text-slate-700 mb-2"><strong>Funciones estrella:</strong> Motor actuarial de planes de salud, cobro recurrente con Bold / tarjetas, carnet digital con QR para tutores, terminal de canje en mostrador y triage con Inteligencia Artificial.</p>
    <p class="text-sm text-slate-700 mb-0"><strong>Precio:</strong> Desde $129.000 COP/mes (15 días de prueba gratis, sin tarjeta de crédito).</p>
</div>

<h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">2. Vetsoft / Q-Vet: Gestión Clínica y Hospitalización Tradicional</h2>
<p class="text-slate-700 leading-relaxed mb-4">
Sistemas veteranos con amplia trayectoria en historia clínica completa, hospitalización y control de inventarios farmacéuticos. Su fortaleza radica en el expediente clínico tradicional, aunque su interfaz y adaptabilidad móvil suelen ser más pesadas para el usuario moderno.
</p>

<h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">3. Provet Cloud: Solución Enterprise para Grandes Hospitales</h2>
<p class="text-slate-700 leading-relaxed mb-4">
Una de las plataformas en la nube más avanzadas a nivel global. Ideal para hospitales veterinarios de más de 20 consultorios y clínicas universitarias. Su costo en dólares y complejidad de implementación la hacen poco accesible para veterinarias de barrio o clínicas medianas.
</p>

<h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">4. Cuadro Comparativo de Funcionalidades Clave</h2>

<div class="overflow-x-auto my-6">
    <table class="w-full text-left text-sm border-collapse border border-slate-200">
        <thead>
            <tr class="bg-slate-100 text-slate-800 font-bold border-b border-slate-200">
                <th class="p-3 border-r border-slate-200">Criterio / Software</th>
                <th class="p-3 border-r border-slate-200 text-blue-700 font-extrabold">AVI-Plan</th>
                <th class="p-3 border-r border-slate-200">Software Tradicional</th>
                <th class="p-3">Excel / Libretas</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 text-slate-600">
            <tr>
                <td class="p-3 font-medium text-slate-900 border-r border-slate-200">Ingresos Recurrentes Automáticos</td>
                <td class="p-3 font-bold text-emerald-600 border-r border-slate-200">✓ Nativo (Bold/Débito)</td>
                <td class="p-3 text-red-500 border-r border-slate-200">✗ No incluye</td>
                <td class="p-3 text-red-500">✗ No incluye</td>
            </tr>
            <tr>
                <td class="p-3 font-medium text-slate-900 border-r border-slate-200">Carnet Digital en WhatsApp para Tutor</td>
                <td class="p-3 font-bold text-emerald-600 border-r border-slate-200">✓ Con QR y Saldo</td>
                <td class="p-3 text-slate-400 border-r border-slate-200">Opcional / PDF</td>
                <td class="p-3 text-red-500">✗ Cartulina física</td>
            </tr>
            <tr>
                <td class="p-3 font-medium text-slate-900 border-r border-slate-200">Terminal de Canje Rápido en Recepción</td>
                <td class="p-3 font-bold text-emerald-600 border-r border-slate-200">✓ 1-Clic</td>
                <td class="p-3 text-slate-400 border-r border-slate-200">Manual en factura</td>
                <td class="p-3 text-red-500">✗ Manual</td>
            </tr>
            <tr>
                <td class="p-3 font-medium text-slate-900 border-r border-slate-200">Tiempo de Puesta en Marcha</td>
                <td class="p-3 font-bold text-emerald-600 border-r border-slate-200">10 minutos</td>
                <td class="p-3 text-slate-400 border-r border-slate-200">1 a 3 semanas</td>
                <td class="p-3 text-slate-400">Inmediato</td>
            </tr>
        </tbody>
    </table>
</div>

<h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">¿Cuál es la Mejor Opción para tu Clínica?</h2>
<p class="text-slate-700 leading-relaxed mb-4">
Si tu prioridad exclusiva es archivar historias clínicas de urgencias, un software clínico clásico te servirá. Pero <strong>si tu objetivo es hacer crecer tu negocio, garantizar que todos los meses tengas un ingreso fijo garantizado y fidelizar a tus clientes para que nunca vayan a otra clínica</strong>, la arquitectura de planes preventivos de <strong>AVI-Plan</strong> es el complemento perfecto para tu operación médica.
</p>

<div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-2xl p-8 my-8 text-center shadow-lg">
    <h3 class="text-2xl font-extrabold mb-2">Comprueba la Diferencia en tu Propia Clínica</h3>
    <p class="text-blue-100 text-sm max-w-xl mx-auto mb-6">
        Únete a las veterinarias que ya están cobrando planes de bienestar mensuales en Colombia.
    </p>
    <a href="/registro-clinica" class="inline-flex items-center px-6 py-3 bg-white hover:bg-slate-100 text-blue-900 font-extrabold rounded-xl shadow-lg transition">
        Iniciar Prueba Gratuita de 15 Días →
    </a>
</div>
HTML,
            ],
            [
                'slug' => 'como-calcular-precio-planes-salud-veterinaria-plantilla-costos',
                'title' => 'Cómo Calcular el Precio de los Planes de Salud para Mascotas: Plantilla de Costos y Margen para Veterinarias',
                'excerpt' => 'Guía actuarial práctica para clínicas veterinarias en Colombia: cómo calcular el costo unitario de insumos biológicos, horas médicas y fijar cuotas mensuales con un 65% de margen neto real.',
                'category' => 'Finanzas & Rentabilidad',
                'read_time' => '9 min de lectura',
                'author' => 'Robinson R. & Equipo Actuarial AVI',
                'author_role' => 'Ingeniero en Telecomunicaciones & Director Técnico',
                'published_at' => '2026-10-08',
                'updated_at' => '2026-10-08',
                'image' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=1200&q=80',
                'keywords' => [
                    'como calcular precios veterinaria',
                    'plantilla costos clinica veterinaria',
                    'margen ganancia planes salud mascotas',
                    'fijacion precios veterinaria colombia',
                    'costo vacunas desparasitacion perros gatos'
                ],
                'content' => <<<'HTML'
<p class="lead text-lg text-slate-700 leading-relaxed font-medium mb-6">
Uno de los mayores temores de un director médico veterinario al lanzar planes de bienestar es: <em>"¿Y si pongo un precio muy bajo y termino perdiendo dinero en insumos o tiempo médico?"</em>. Fijar precios por intuición o copiando a la clínica del frente sin conocer tus costos reales es la receta perfecta para el fracaso financiero.
</p>

<!-- Índice de Contenidos Interactivo (Google Sitelinks) -->
<div class="bg-blue-50/60 border border-blue-200 rounded-2xl p-5 mb-8">
    <div class="flex items-center gap-2 font-black text-slate-900 text-sm mb-3">
        <span>📖</span>
        <span>Índice del Artículo (Haz clic para saltar a la sección)</span>
    </div>
    <ul class="text-xs sm:text-sm text-slate-700 space-y-2">
        <li><a href="#costos-biologicos" class="text-blue-600 hover:text-blue-800 font-semibold hover:underline">1. Desglose de Costos Directos Anuales en Colombia →</a></li>
        <li><a href="#formula-precio" class="text-blue-600 hover:text-blue-800 font-semibold hover:underline">2. Fórmula Actuarial para Fijar la Cuota Mensual →</a></li>
        <li><a href="#simulador-actuarial" class="text-emerald-700 hover:text-emerald-900 font-extrabold hover:underline">3. ⚡ Simulador Actuarial en Vivo (Calcula tu clínica aquí) →</a></li>
        <li><a href="#psicologia-precio" class="text-blue-600 hover:text-blue-800 font-semibold hover:underline">4. La Psicología de Precio para el Tutor de la Mascota →</a></li>
        <li><a href="#ingresos-reales" class="text-blue-600 hover:text-blue-800 font-semibold hover:underline">5. Proyección de Ingresos Anuales Reales →</a></li>
    </ul>
</div>

<div class="bg-emerald-50 border-l-4 border-emerald-600 p-5 rounded-r-xl my-6">
    <p class="text-emerald-950 font-bold mb-1">Regla de Oro Actuarial en AVI-Plan:</p>
    <p class="text-emerald-900 text-sm">
        Un plan de salud preventiva bien estructurado debe arrojar entre un <strong>60% y un 70% de margen bruto sobre insumos</strong>, asumiendo una tasa de redención (uso real) del 75% al 85% a lo largo de los 12 meses del año.
    </p>
</div>

<h2 id="costos-biologicos" class="text-2xl font-bold text-slate-900 mt-8 mb-4 scroll-mt-24">1. Desglose de Costos Directos Anuales (Ejemplo Real Canino en Colombia)</h2>
<p class="text-slate-700 leading-relaxed mb-4">
Calculemos el costo de adquisición de insumos al por mayor (precios de distribuidor veterinario en Colombia para un perro adulto de 10 a 20 kg):
</p>

<div class="overflow-x-auto my-6">
    <table class="w-full text-left text-sm border-collapse border border-slate-200">
        <thead>
            <tr class="bg-slate-100 text-slate-800 font-bold border-b border-slate-200">
                <th class="p-3 border-r border-slate-200">Servicio / Insumo</th>
                <th class="p-3 border-r border-slate-200">Frecuencia Anual</th>
                <th class="p-3 border-r border-slate-200">Costo Unitario Distribuidor</th>
                <th class="p-3">Costo Total Anual</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 text-slate-600">
            <tr>
                <td class="p-3 font-medium text-slate-900 border-r border-slate-200">Vacuna Séxtuple / Polivalente</td>
                <td class="p-3 border-r border-slate-200">1 al año</td>
                <td class="p-3 border-r border-slate-200">$22.000 COP</td>
                <td class="p-3 font-semibold text-slate-900">$22.000 COP</td>
            </tr>
            <tr>
                <td class="p-3 font-medium text-slate-900 border-r border-slate-200">Vacuna Antirrábica</td>
                <td class="p-3 border-r border-slate-200">1 al año</td>
                <td class="p-3 border-r border-slate-200">$8.500 COP</td>
                <td class="p-3 font-semibold text-slate-900">$8.500 COP</td>
            </tr>
            <tr>
                <td class="p-3 font-medium text-slate-900 border-r border-slate-200">Vacuna Traqueobronquitis (KC / Tos de las Perreras)</td>
                <td class="p-3 border-r border-slate-200">1 al año</td>
                <td class="p-3 border-r border-slate-200">$18.000 COP</td>
                <td class="p-3 font-semibold text-slate-900">$18.000 COP</td>
            </tr>
            <tr>
                <td class="p-3 font-medium text-slate-900 border-r border-slate-200">Desparasitación Interna (Pastillas amplio espectro)</td>
                <td class="p-3 border-r border-slate-200">4 dosis (trimestral)</td>
                <td class="p-3 border-r border-slate-200">$9.000 COP c/u</td>
                <td class="p-3 font-semibold text-slate-900">$36.000 COP</td>
            </tr>
            <tr>
                <td class="p-3 font-medium text-slate-900 border-r border-slate-200">Material Médico Menor (Jeringas, agujas, alcohol, algodón)</td>
                <td class="p-3 border-r border-slate-200">7 aplicaciones</td>
                <td class="p-3 border-r border-slate-200">$1.500 COP c/u</td>
                <td class="p-3 font-semibold text-slate-900">$10.500 COP</td>
            </tr>
            <tr class="bg-blue-50/50 font-bold text-slate-900">
                <td class="p-3 border-r border-slate-200" colspan="3">COSTO TOTAL ANUAL DE INSUMOS POR PACIENTE:</td>
                <td class="p-3 text-blue-700 text-base">$95.000 COP</td>
            </tr>
        </tbody>
    </table>
</div>

<h2 id="formula-precio" class="text-2xl font-bold text-slate-900 mt-8 mb-4 scroll-mt-24">2. Fijando la Cuota Mensual con la Fórmula AVI-Plan</h2>
<p class="text-slate-700 leading-relaxed mb-4">
Si el costo anual directo de biológicos es de <strong>$95.000 COP</strong>, significa que el costo mensual de insumos es de apenas:
<br>
<span class="inline-block bg-slate-100 font-mono text-slate-900 font-bold px-3 py-1.5 rounded-lg my-2">$95.000 COP ÷ 12 meses = $7.916 COP al mes por mascota</span>
</p>

<p class="text-slate-700 leading-relaxed mb-4">
Ahora aplicamos la fórmula de precio con un <strong>margen bruto objetivo del 65%</strong> para cubrir el tiempo médico de las consultas de control y generar rentabilidad neta:
</p>

<div class="bg-slate-900 text-emerald-400 font-mono p-5 rounded-2xl my-4 text-sm sm:text-base leading-relaxed">
    Cuota Mensual Sugerida = (Costo Mensual Insumos) ÷ (1 - Margen Deseado) + Margen Clínico<br>
    Cuota Mensual = ($7.916) ÷ (1 - 0.65) = $22.617 COP<br>
    + Asignación de 2 Consultas Médicas Preventivas al Año ($25.000/mes)<br>
    <strong>= $47.617 COP / mes (Redondeado a $49.000 COP / mes)</strong>
</div>

<!-- 3. SIMULADOR ACTUARIAL EN VIVO (INTERACTIVO) -->
<div id="simulador-actuarial" class="bg-gradient-to-br from-slate-900 via-indigo-950 to-blue-950 text-white rounded-3xl p-6 sm:p-8 my-10 shadow-2xl border border-blue-900/50 scroll-mt-24">
    <div class="flex items-center gap-2 text-emerald-400 text-xs font-mono font-bold uppercase tracking-wider mb-2">
        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
        Simulador Actuarial en Vivo
    </div>
    <h3 class="text-xl sm:text-2xl font-black text-white mb-2">Calcula la Rentabilidad de tu Veterinaria</h3>
    <p class="text-slate-300 text-xs sm:text-sm mb-6">Mueve los controles para ver el recaudo mensual, el costo de insumos y la ganancia neta anual garantizada en pesos colombianos.</p>

    <div class="grid sm:grid-cols-2 gap-6 mb-6">
        <div class="bg-white/5 border border-white/10 rounded-2xl p-4">
            <div class="flex justify-between items-center text-xs font-bold text-slate-300 mb-2">
                <span>Número de Mascotas Activas:</span>
                <span id="sim-pets-val" class="text-emerald-400 font-mono text-base font-extrabold">100 mascotas</span>
            </div>
            <input type="range" id="sim-pets" min="20" max="500" step="10" value="100" class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-emerald-400" oninput="updateSim()">
            <div class="flex justify-between text-[10px] text-slate-400 mt-1">
                <span>20 mascotas</span>
                <span>500 mascotas</span>
            </div>
        </div>

        <div class="bg-white/5 border border-white/10 rounded-2xl p-4">
            <div class="flex justify-between items-center text-xs font-bold text-slate-300 mb-2">
                <span>Cuota Mensual Sugerida:</span>
                <span id="sim-fee-val" class="text-blue-400 font-mono text-base font-extrabold">$49.000 COP</span>
            </div>
            <input type="range" id="sim-fee" min="35000" max="99000" step="1000" value="49000" class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-blue-400" oninput="updateSim()">
            <div class="flex justify-between text-[10px] text-slate-400 mt-1">
                <span>$35.000</span>
                <span>$99.000</span>
            </div>
        </div>
    </div>

    <!-- Resultados en vivo -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-center mb-6">
        <div class="bg-white/10 rounded-xl p-3 border border-white/10">
            <div class="text-[10px] text-slate-400 uppercase font-semibold">Recaudo Mensual (MRR)</div>
            <div id="sim-mrr" class="text-sm sm:text-base font-black text-white font-mono mt-1">$4.900.000</div>
        </div>
        <div class="bg-white/10 rounded-xl p-3 border border-white/10">
            <div class="text-[10px] text-slate-400 uppercase font-semibold">Costo Insumos / Mes</div>
            <div id="sim-costs" class="text-sm sm:text-base font-black text-rose-300 font-mono mt-1">$791.600</div>
        </div>
        <div class="bg-white/10 rounded-xl p-3 border border-white/10">
            <div class="text-[10px] text-slate-400 uppercase font-semibold">Margen Bruto</div>
            <div id="sim-margin" class="text-sm sm:text-base font-black text-amber-300 font-mono mt-1">83.8%</div>
        </div>
        <div class="bg-emerald-500/20 rounded-xl p-3 border border-emerald-500/40">
            <div class="text-[10px] text-emerald-300 uppercase font-bold">Ganancia Libre Anual</div>
            <div id="sim-net-annual" class="text-sm sm:text-base font-black text-emerald-400 font-mono mt-1">+$49.300.800</div>
        </div>
    </div>

    <!-- Lead Magnet Button -->
    <div class="bg-white/10 border border-white/15 rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <div class="font-bold text-white text-sm">¿Quieres la Plantilla de Excel con todas las fórmulas?</div>
            <div class="text-xs text-slate-300">Incluye listas de precios de biológicos en Colombia y calculadora de punto de equilibrio.</div>
        </div>
        <a id="sim-whatsapp-lead" href="https://wa.me/573508742543?text=Hola%20Robinson,%20calcul%C3%A9%20mis%20costos%20con%20el%20simulador%20de%20AVI-Plan%20para%20100%20mascotas%20y%20quiero%20la%20Plantilla%20de%20Excel%20gratuita." target="_blank" class="w-full sm:w-auto px-5 py-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs uppercase tracking-wider rounded-xl shadow-lg transition transform hover:-translate-y-0.5 shrink-0 text-center flex items-center justify-center gap-2">
            <span>📊 Descargar Plantilla Excel (Gratis)</span>
        </a>
    </div>

    <script>
      function updateSim() {
        const pets = parseInt(document.getElementById('sim-pets').value);
        const fee = parseInt(document.getElementById('sim-fee').value);
        const costPerPetMonth = 7916; // $95.000 / 12

        const mrr = pets * fee;
        const totalCosts = pets * costPerPetMonth;
        const netMonth = mrr - totalCosts;
        const netAnnual = netMonth * 12;
        const marginPct = ((netMonth / mrr) * 100).toFixed(1);

        document.getElementById('sim-pets-val').innerText = pets + ' mascotas';
        document.getElementById('sim-fee-val').innerText = '$' + fee.toLocaleString('es-CO') + ' COP';
        document.getElementById('sim-mrr').innerText = '$' + mrr.toLocaleString('es-CO');
        document.getElementById('sim-costs').innerText = '$' + totalCosts.toLocaleString('es-CO');
        document.getElementById('sim-margin').innerText = marginPct + '%';
        document.getElementById('sim-net-annual').innerText = '+$' + netAnnual.toLocaleString('es-CO');

        const waText = encodeURIComponent(`Hola Robinson, calculé mis costos con el simulador de AVI-Plan para ${pets} mascotas a $${fee.toLocaleString('es-CO')} y quiero recibir la Plantilla de Excel de Costos.`);
        document.getElementById('sim-whatsapp-lead').href = `https://wa.me/573508742543?text=${waText}`;
      }
    </script>
</div>

<h2 id="psicologia-precio" class="text-2xl font-bold text-slate-900 mt-8 mb-4 scroll-mt-24">4. La Psicología de Precio para el Tutor de la Mascota</h2>
<p class="text-slate-700 leading-relaxed mb-4">
Cuando le dices a un cliente: <em>"Las vacunas anuales y controles te cuestan $380.000 COP de golpe hoy"</em>, muchos tutores postergan la visita o solo pagan la rabia.
</p>
<p class="text-slate-700 leading-relaxed mb-4">
Pero cuando le dices: <em>"Por solo <strong>$49.000 COP al mes</strong> (menos de lo que cuesta una pizza), tu peludo tiene todas sus vacunas del año cubiertas, desparasitación cada 3 meses, carnet digital en tu celular y 2 consultas médicas gratis cuando lo veas decaído"</em>, <strong>más del 35% de los clientes en sala de espera dicen que SÍ inmediatamente</strong>.
</p>

<h2 id="ingresos-reales" class="text-2xl font-bold text-slate-900 mt-8 mb-4 scroll-mt-24">5. Los Ingresos Anuales Reales de tu Clínica</h2>
<p class="text-slate-700 leading-relaxed mb-4">
Con solo 100 pacientes afiliados a este plan de $49.000 COP:
</p>
<ul class="list-disc pl-6 space-y-2 text-slate-700 mb-6">
    <li><strong>Recaudo Total Anual:</strong> $58.800.000 COP.</li>
    <li><strong>Gasto Total en Insumos Biológicos:</strong> $9.500.000 COP.</li>
    <li><strong>Ganancia Bruta Libre para la Clínica:</strong> <strong class="text-emerald-700">$49.300.000 COP</strong> todos los años.</li>
</ul>

<div class="bg-gradient-to-r from-blue-900 to-indigo-900 text-white rounded-2xl p-8 my-8 text-center shadow-xl">
    <h3 class="text-2xl font-extrabold mb-3">Calcula y Activa los Planes de tu Veterinaria</h3>
    <p class="text-blue-200 text-sm max-w-xl mx-auto mb-6">
        No dejes el dinero sobre la mesa. Con AVI-Plan puedes personalizar tus servicios, precios y emitir carnets con código QR en minutos. 15 días gratis.
    </p>
    <a href="/registro-clinica" class="inline-flex items-center px-6 py-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black rounded-xl shadow-lg transition transform hover:-translate-y-0.5">
        Crear mi Cuenta Gratis (15 Días) →
    </a>
</div>
HTML,
            ]
        ];
    }

    public static function getPostBySlug(string $slug): ?array
    {
        $posts = self::getAllPosts();
        foreach ($posts as $post) {
            if ($post['slug'] === $slug) {
                return $post;
            }
        }
        return null;
    }

    public static function getRelatedPosts(string $slug, int $limit = 2): array
    {
        $posts = self::getAllPosts();
        $related = [];
        foreach ($posts as $post) {
            if ($post['slug'] !== $slug) {
                $related[] = $post;
            }
            if (count($related) >= $limit) {
                break;
            }
        }
        return $related;
    }
}
