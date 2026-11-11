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
                'title' => 'Planes de Salud Veterinarios: Cómo Crear Membresías Preventivas en tu Clínica y Facturar Ingresos Recurrentes',
                'excerpt' => 'Guía paso a paso para estructurar planes de salud veterinarios (perros y gatos) en Colombia: tablas de precios en pesos, margen del 65%, carnet digital QR y recaudo mensual recurrente.',
                'category' => 'Rentabilidad & Negocio',
                'read_time' => '7 min de lectura',
                'author' => 'Robinson R. & Equipo AviPetApp',
                'author_role' => 'Ingeniero en Telecomunicaciones & Estratega SaaS',
                'published_at' => '2026-10-01',
                'updated_at' => '2026-11-10',
                'image' => 'https://images.unsplash.com/photo-1576201836106-db1758fd1c97?auto=format&fit=crop&w=1200&q=80',
                'keywords' => [
                    'avipetapp',
                    'planes de salud veterinarios',
                    'planes de salud veterinaria',
                    'planes preventivos veterinaria colombia',
                    'membresias para mascotas',
                    'ingresos recurrentes veterinaria colombia',
                    'software planes bienestar mascotas'
                ],
                'faqs' => [
                    [
                        'question' => '¿Qué incluye un plan de salud veterinario preventivo en Colombia?',
                        'answer' => 'Un plan de salud preventivo para mascotas incluye el esquema anual de vacunación (Séxtuple, Rabia, KC en perros; Triple felina y Leucemia en gatos), desparasitación trimestral, consultas médicas de control programadas y descuentos exclusivos en laboratorio, profilaxis dental y peluquería.'
                    ],
                    [
                        'question' => '¿Cuánto cuesta un plan de salud para perros o gatos en Colombia?',
                        'answer' => 'Las clínicas veterinarias en Colombia estructuran sus planes básicos entre $39.000 y $49.000 COP al mes, y sus planes integrales o senior entre $69.000 y $89.000 COP mensuales, alcanzando márgenes brutos del 65% sobre el costo de insumos.'
                    ],
                    [
                        'question' => '¿Cuál es la diferencia entre un plan de salud veterinario y una póliza de accidentes?',
                        'answer' => 'Los planes de salud para mascotas son programas de bienestar y medicina preventiva administrados directamente por la clínica veterinaria con uso garantizado desde el primer mes, no seguros financieros de siniestros.'
                    ],
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

<nav aria-label="Tabla de contenidos" class="bg-slate-50 border border-slate-200 rounded-2xl p-5 my-6">
    <p class="text-xs font-extrabold uppercase tracking-wider text-violet-700 mb-3">Contenido de esta Guía Práctica (Colombia 2026)</p>
    <ol class="grid sm:grid-cols-2 gap-2 text-sm font-semibold text-slate-700 list-decimal pl-5">
        <li><a href="#que-es-plan-preventivo" class="hover:text-violet-700 underline">¿Qué incluyen los planes de salud veterinarios?</a></li>
        <li><a href="#armador-planes-interactivo" class="hover:text-violet-700 underline">Armador Interactivo de Planes (Cachorro / Adulto / Senior)</a></li>
        <li><a href="#niveles-planes-veterinarios" class="hover:text-violet-700 underline">Precios sugeridos en Colombia (Básico vs Integral)</a></li>
        <li><a href="#matematica-margen-65" class="hover:text-violet-700 underline">Matemática real: Margen del 65% y Carnet QR</a></li>
    </ol>
</nav>

<h2 id="que-es-plan-preventivo" class="text-2xl font-bold text-slate-900 mt-8 mb-4">1. ¿Qué es un Plan de Salud Preventiva para Mascotas?</h2>
<p class="text-slate-700 leading-relaxed mb-4">
A diferencia de una póliza de accidentes mayores, un <strong>plan de salud preventiva para mascotas</strong> es un programa de suscripción recurrente mensual que cubre la medicina preventiva que toda mascota necesita a lo largo del año para mantenerse sana:
</p>
<ul class="list-disc pl-6 space-y-2 text-slate-700 mb-6">
    <li>Esquema vacunal anual completo (Rabia, Séxtuple, KC en caninos; Triple felina y Leucemia en felinos).</li>
    <li>Desparasitación interna y externa periódica (trimestral o bimestral).</li>
    <li>Consultas médicas veterinarias de control ilimitadas o con cupo programado.</li>
    <li>Exámenes de laboratorio preventivos (coprológico, hemograma anual, perfil renal/hepático en pacientes senior).</li>
    <li>Descuentos exclusivos en farmacia, profilaxis dental, ecografías y estética canina.</li>
</ul>

<div id="armador-planes-interactivo" class="bg-slate-900 text-white rounded-2xl p-6 sm:p-7 my-8 border border-indigo-500/30 shadow-xl">
    <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
        <span class="px-3 py-1 rounded-full bg-violet-600/30 border border-violet-400/40 text-cyan-300 text-xs font-bold">Herramienta Interactiva Gratuita</span>
        <span class="text-xs text-slate-300">Precios de referencia Colombia 2026</span>
    </div>
    <h3 class="text-xl font-extrabold mb-2">Armador Rápido de Planes de Salud Veterinarios</h3>
    <p class="text-xs sm:text-sm text-slate-300 mb-4">Selecciona el tipo de paciente para ver la estructura recomendada de tarifa mensual, costo estimado de insumos y ganancia anual para tu clínica:</p>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mb-5">
        <button type="button" onclick="selectPlanPreset(45000, 15500, 'Plan Cachorro Sano (Vacunas + Desparasitación + 3 Controles)')" class="px-3 py-2.5 rounded-xl bg-violet-600 hover:bg-violet-500 text-white text-xs font-bold cursor-pointer">🐶 Cachorro</button>
        <button type="button" onclick="selectPlanPreset(49000, 17000, 'Plan Adulto Preventivo (Séxtuple + Rabia + KC + 4 Antiparasitarios + Consultas)')" class="px-3 py-2.5 rounded-xl bg-slate-800 hover:bg-violet-600 border border-slate-700 text-white text-xs font-bold cursor-pointer">🐕 Adulto</button>
        <button type="button" onclick="selectPlanPreset(44000, 15000, 'Plan Felino Indoor (Triple Felina + Leucemia + Rabia + Control Renal)')" class="px-3 py-2.5 rounded-xl bg-slate-800 hover:bg-violet-600 border border-slate-700 text-white text-xs font-bold cursor-pointer">🐱 Felino</button>
        <button type="button" onclick="selectPlanPreset(79000, 27000, 'Plan Senior +7 Años (Vacunas + Hemograma + Perfil Bioquímico + Ecografía Control)')" class="px-3 py-2.5 rounded-xl bg-slate-800 hover:bg-violet-600 border border-slate-700 text-white text-xs font-bold cursor-pointer">🩺 Senior VIP</button>
    </div>

    <div class="bg-slate-800/90 rounded-xl p-4 border border-slate-700 space-y-2 text-sm">
        <div id="preset-plan-name" class="font-bold text-cyan-300">Plan Adulto Preventivo (Séxtuple + Rabia + KC + 4 Antiparasitarios + Consultas)</div>
        <div class="grid sm:grid-cols-3 gap-3 pt-2">
            <div><span class="text-xs text-slate-400 block">Tarifa Mensual Sugerida:</span><strong id="preset-plan-price" class="text-lg text-white">$49.000 COP/mes</strong></div>
            <div><span class="text-xs text-slate-400 block">Costo Insumos Mes:</span><strong id="preset-plan-cost" class="text-lg text-amber-300">~$17.000 COP/mes</strong></div>
            <div><span class="text-xs text-slate-400 block">Utilidad c/ 100 Mascotas:</span><strong id="preset-plan-profit" class="text-lg text-emerald-400">$3.200.000 COP/mes</strong></div>
        </div>
    </div>

    <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
        <a href="/software-planes-salud-veterinaria" class="text-xs font-semibold text-cyan-300 hover:underline">Ver cómo funciona el Software de Planes de Salud Veterinarios →</a>
        <a href="/crear-clinica-veterinaria-gratis" class="px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs transition">Activar estos planes en mi clínica (15 días gratis) →</a>
    </div>
</div>
<script>
function selectPlanPreset(price, cost, label) {
    var fmt = function(n){ return '$' + Math.round(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'); };
    document.getElementById('preset-plan-name').textContent = label;
    document.getElementById('preset-plan-price').textContent = fmt(price) + ' COP/mes';
    document.getElementById('preset-plan-cost').textContent = '~' + fmt(cost) + ' COP/mes';
    document.getElementById('preset-plan-profit').textContent = fmt((price - cost) * 100) + ' COP/mes';
}
</script>

<h2 id="niveles-planes-veterinarios" class="text-2xl font-bold text-slate-900 mt-8 mb-4">2. Cómo Estructurar tus Niveles de Planes (Básico vs Premium)</h2>
<p class="text-slate-700 leading-relaxed mb-4">
El error más común de los médicos veterinarios es crear una lista interminable de planes que confunde al tutor. La mejor práctica de negocio probada en AviPetApp es estructurar únicamente <strong>dos o máximo tres planes claros</strong>:
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

<h2 id="matematica-margen-65" class="text-2xl font-bold text-slate-900 mt-8 mb-4">3. La Matemática del Negocio: Margen del 65% y Retención</h2>
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
Por esta razón, implementar un <a href="/software-planes-salud-veterinaria" class="text-violet-700 font-bold underline">software para planes de salud veterinarios</a> como <strong>AviPetApp</strong> organiza tus membresías, emite un <a href="/carnet-vacunacion-digital-mascotas-qr" class="text-violet-700 font-bold underline">Carnet Digital interactivo con código QR</a> y actualiza en tiempo real el saldo de servicios en mostrador con un solo clic.
</p>

<div class="bg-gradient-to-r from-blue-900 to-indigo-900 text-white rounded-2xl p-8 my-8 text-center shadow-xl">
    <h3 class="text-2xl font-extrabold mb-3">Empieza a Cobrar Planes de Salud en tu Veterinaria</h3>
    <p class="text-blue-200 text-sm max-w-xl mx-auto mb-6">
        Configura tus planes de salud con tu propio logo y marca en menos de 10 minutos. Prueba AviPetApp completamente gratis durante 15 días sin ingresar tarjeta de crédito.
    </p>
    <a href="/registro-clinica" class="inline-flex items-center px-6 py-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black rounded-xl shadow-lg transition transform hover:-translate-y-0.5">
        Crear mi Cuenta Gratis (15 Días) →
    </a>
</div>
HTML,
            ],
            [
                'slug' => 'fidelizacion-clientes-veterinaria-retencion-mascotas',
                'title' => 'Retención de Clientes en Clínica Veterinaria: 5 Estrategias Probadas para Fidelizar Tutores (Guía 2026)',
                'excerpt' => 'Cómo aumentar la retención de clientes en tu clínica veterinaria del 35% al 88%: carnet digital con QR en WhatsApp, recordatorios preventivos con IA, planes de salud y terminal de canje en recepción.',
                'category' => 'Fidelización & Retención',
                'read_time' => '6 min de lectura',
                'author' => 'Robinson R. & Equipo AviPetApp',
                'author_role' => 'Ingeniero en Telecomunicaciones & Estratega SaaS',
                'published_at' => '2026-10-03',
                'updated_at' => '2026-11-10',
                'image' => 'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?auto=format&fit=crop&w=1200&q=80',
                'keywords' => [
                    'retención de clientes en clínica veterinaria',
                    'fidelizacion clientes veterinaria',
                    'como fidelizar clientes en una veterinaria',
                    'retencion tutores mascotas',
                    'carnet digital mascotas whatsapp',
                    'marketing para veterinarias colombia',
                    'atencion al cliente clinica veterinaria'
                ],
                'faqs' => [
                    [
                        'question' => '¿Cómo mejorar la retención de clientes en una clínica veterinaria?',
                        'answer' => 'Las 3 acciones de mayor impacto para la retención de clientes en clínica veterinaria son: reemplazar el carnet de cartón por un Carnet Digital interactivo con código QR en WhatsApp, automatizar recordatorios preventivos 7 días y 24 horas antes de cada vacuna o desparasitación, y afiliar al paciente a un plan de salud mensual.'
                    ],
                    [
                        'question' => '¿Por qué los tutores de mascotas dejan de asistir a la misma clínica veterinaria?',
                        'answer' => 'Más del 68% de la deserción de clientes en veterinarias ocurre por olvido de fechas de refuerzo vacunal o desparasitación y por falta de vínculo recurrente entre consultas de urgencia.'
                    ],
                    [
                        'question' => '¿Cuántas veces al año visita la clínica un cliente afiliado a un plan de salud?',
                        'answer' => 'Un tutor con plan de salud preventivo activo y carnet digital visita la clínica entre 4 y 6 veces al año, frente a 1 visita cada 18 meses de un cliente ocasional, multiplicando por 3 el consumo en farmacia, nutrición y baños.'
                    ],
                ],
                'content' => <<<'HTML'
<p class="lead text-lg text-slate-700 leading-relaxed font-medium mb-6">
Captar un nuevo cliente para tu clínica veterinaria cuesta <strong>entre 5 y 7 veces más</strong> que retener a uno que ya confía en tu equipo médico. Sin embargo, más del 70% de las veterinarias en Colombia y Latinoamérica no tienen ningún sistema activo para evitar que el tutor de una mascota compre sus vacunas, antiparasitarios o baños en la competencia.
</p>

<!-- Índice de Contenidos Interactivo (Google Jump-to-Section Sitelinks) -->
<div class="bg-blue-50/60 border border-blue-200 rounded-2xl p-5 mb-8">
    <div class="flex items-center gap-2 font-black text-slate-900 text-sm mb-3">
        <span>📖</span>
        <span>Índice de la Guía de Retención Veterinaria (Haz clic para ir a la sección)</span>
    </div>
    <ul class="text-xs sm:text-sm text-slate-700 space-y-2">
        <li><a href="#carnet-digital" class="text-blue-600 hover:text-blue-800 font-semibold hover:underline">1. Del Carnet de Cartón al Carnet Digital con Código QR en WhatsApp →</a></li>
        <li><a href="#calculadora-retencion" class="text-emerald-700 hover:text-emerald-900 font-extrabold hover:underline">2. ⚡ Calculadora en Vivo: ¿Cuánto Dinero Pierde tu Veterinaria por Clientes Inactivos? →</a></li>
        <li><a href="#recordatorios-ia" class="text-blue-600 hover:text-blue-800 font-semibold hover:underline">3. Recordatorios Preventivos Automatizados (7 días y 24h antes) →</a></li>
        <li><a href="#plantillas-whatsapp" class="text-blue-600 hover:text-blue-800 font-semibold hover:underline">4. Plantillas de Mensajes de WhatsApp para Seguimiento y Reactivación →</a></li>
        <li><a href="#terminal-canje" class="text-blue-600 hover:text-blue-800 font-semibold hover:underline">5. Terminal de Canje en Mostrador y Planes de Salud como Candado de Fidelidad →</a></li>
    </ul>
</div>

<h2 id="carnet-digital" class="text-2xl font-bold text-slate-900 mt-8 mb-4 scroll-mt-24">1. El Carnet Físico de Cartón está Muerto</h2>
<p class="text-slate-700 leading-relaxed mb-4">
Durante décadas, las veterinarias entregaron libretas o carnets de cartulina sellados a mano. Hoy en día, los tutores de mascotas (principalmente millennials y centennials) <strong>pierden el carnet físico, lo dejan en casa o se olvidan de la fecha exacta del refuerzo vacunal</strong>.
</p>
<p class="text-slate-700 leading-relaxed mb-6">
La solución moderna para blindar la <strong>retención de clientes en clínica veterinaria</strong> es el <strong>Carnet Digital en el Smartphone</strong>:
</p>
<ul class="list-disc pl-6 space-y-2 text-slate-700 mb-6">
    <li>Accesible las 24 horas desde WhatsApp sin instalar aplicaciones pesadas.</li>
    <li>Muestra foto de la mascota, raza, microchip y coberturas vigentes con la marca y el logo de tu veterinaria.</li>
    <li>Código QR dinámico que el veterinario o recepcionista escanea en 2 segundos para validar el estado del plan.</li>
</ul>

<!-- 2. CALCULADORA EN VIVO DE RETENCIÓN Y FUGA DE PACIENTES -->
<div id="calculadora-retencion" class="bg-gradient-to-br from-slate-900 via-indigo-950 to-blue-950 text-white rounded-3xl p-6 sm:p-8 my-10 shadow-2xl border border-blue-900/50 scroll-mt-24">
    <div class="flex items-center gap-2 text-emerald-400 text-xs font-mono font-bold uppercase tracking-wider mb-2">
        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
        Simulador de Retención Clínica en Vivo
    </div>
    <h3 class="text-xl sm:text-2xl font-black text-white mb-2">Calcula Cuánto Dinero Pierde tu Veterinaria por Deserción de Pacientes</h3>
    <p class="text-slate-300 text-xs sm:text-sm mb-6">Ajusta cuántos pacientes atiendes al mes y el ticket promedio anual para descubrir cuánto ingreso recurrente puedes recuperar fidelizando con Carnet QR y Planes de Salud.</p>

    <div class="grid sm:grid-cols-2 gap-6 mb-6">
        <div class="bg-white/5 border border-white/10 rounded-2xl p-4">
            <div class="flex justify-between items-center text-xs font-bold text-slate-300 mb-2">
                <span>Pacientes Atendidos / Mes:</span>
                <span id="ret-pets-val" class="text-emerald-400 font-mono text-base font-extrabold">120 pacientes</span>
            </div>
            <input type="range" id="ret-pets" min="30" max="500" step="10" value="120" class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-emerald-400" oninput="updateRetSim()">
            <div class="flex justify-between text-[10px] text-slate-400 mt-1">
                <span>30 pacientes/mes</span>
                <span>500 pacientes/mes</span>
            </div>
        </div>

        <div class="bg-white/5 border border-white/10 rounded-2xl p-4">
            <div class="flex justify-between items-center text-xs font-bold text-slate-300 mb-2">
                <span>Gasto Anual por Mascota Fidelizada:</span>
                <span id="ret-ltv-val" class="text-blue-400 font-mono text-base font-extrabold">$580.000 COP</span>
            </div>
            <input type="range" id="ret-ltv" min="300000" max="1200000" step="20000" value="580000" class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-blue-400" oninput="updateRetSim()">
            <div class="flex justify-between text-[10px] text-slate-400 mt-1">
                <span>$300.000/año</span>
                <span>$1.200.000/año</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-center mb-6">
        <div class="bg-rose-500/15 rounded-xl p-3.5 border border-rose-500/30">
            <div class="text-[10px] text-rose-300 uppercase font-bold">Pacientes que No Regresan (65% Fuga)</div>
            <div id="ret-lost-pets" class="text-base sm:text-lg font-black text-rose-300 font-mono mt-1">78 mascotas / mes</div>
        </div>
        <div class="bg-white/10 rounded-xl p-3.5 border border-white/10">
            <div class="text-[10px] text-amber-300 uppercase font-bold">Dinero que se va a la Competencia</div>
            <div id="ret-lost-money" class="text-base sm:text-lg font-black text-amber-300 font-mono mt-1">-$45.240.000 / año</div>
        </div>
        <div class="bg-emerald-500/20 rounded-xl p-3.5 border border-emerald-500/40">
            <div class="text-[10px] text-emerald-300 uppercase font-bold">Ingreso Recuperable con AviPetApp</div>
            <div id="ret-recovered" class="text-base sm:text-lg font-black text-emerald-400 font-mono mt-1">+$36.192.000 / año</div>
        </div>
    </div>

    <div class="bg-white/10 border border-white/15 rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <div class="font-bold text-white text-sm">¿Quieres frenar la fuga de clientes en tu clínica esta misma semana?</div>
            <div class="text-xs text-slate-300">Activa tu Carnet Digital QR y planes preventivos en 10 minutos con 15 días de prueba gratis.</div>
        </div>
        <a href="/registro-clinica" class="w-full sm:w-auto px-5 py-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs uppercase tracking-wider rounded-xl shadow-lg transition transform hover:-translate-y-0.5 shrink-0 text-center">
            Activar mi Clínica Gratis →
        </a>
    </div>

    <script>
      function updateRetSim() {
        const pets = parseInt(document.getElementById('ret-pets').value);
        const ltv = parseInt(document.getElementById('ret-ltv').value);
        const lostPets = Math.round(pets * 0.65);
        const lostMoney = lostPets * ltv;
        const recoveredMoney = Math.round(lostMoney * 0.80);

        document.getElementById('ret-pets-val').innerText = pets + ' pacientes';
        document.getElementById('ret-ltv-val').innerText = '$' + ltv.toLocaleString('es-CO') + ' COP';
        document.getElementById('ret-lost-pets').innerText = lostPets + ' mascotas / mes';
        document.getElementById('ret-lost-money').innerText = '-$' + lostMoney.toLocaleString('es-CO') + ' / año';
        document.getElementById('ret-recovered').innerText = '+$' + recoveredMoney.toLocaleString('es-CO') + ' / año';
      }
    </script>
</div>

<h2 id="recordatorios-ia" class="text-2xl font-bold text-slate-900 mt-8 mb-4 scroll-mt-24">3. Recordatorios Preventivos Automatizados (El Secreto de la Asistencia)</h2>
<p class="text-slate-700 leading-relaxed mb-4">
Cuando un tutor olvida la desparasitación trimestral o la vacuna anual de la rabia, no lo hace por negligencia: lo hace por falta de tiempo y sobrecarga diaria.
</p>
<p class="text-slate-700 leading-relaxed mb-4">
Un sistema automatizado de notificaciones vía WhatsApp y correo electrónico con <strong>7 días de anticipación</strong> y un recordatorio <strong>24 horas antes</strong> incrementa la tasa de asistencia a citas preventivas del 48% a más del <strong>89%</strong>.
</p>

<h2 id="plantillas-whatsapp" class="text-2xl font-bold text-slate-900 mt-8 mb-4 scroll-mt-24">4. Plantillas de Mensajes de WhatsApp para Seguimiento Veterinario</h2>
<p class="text-slate-700 leading-relaxed mb-4">
Copia y aplica hoy mismo este protocolo de 3 mensajes en la recepción de tu clínica veterinaria (o automatízalo en 1 clic desde el panel de <strong>AviPetApp</strong>):
</p>
<div class="space-y-4 my-6">
    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
        <span class="inline-block bg-emerald-100 text-emerald-800 text-xs font-bold px-2.5 py-0.5 rounded-full mb-2">Plantilla 1 · Seguimiento 24 Horas Post-Consulta</span>
        <p class="text-xs sm:text-sm text-slate-700 font-mono bg-white p-3 rounded-lg border border-slate-200">
            "Hola [Nombre Tutor] 🐾 Te escribimos de [Nombre Veterinaria] para saber cómo amaneció hoy [Nombre Mascota] después de su consulta de ayer. Recuerda que aquí tienes su Carnet Digital actualizado con código QR: [Link Carnet]. ¡Cualquier síntoma nos avisas!"
        </p>
    </div>
    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-0.5 rounded-full mb-2">Plantilla 2 · Recordatorio Preventivo (7 Días Antes)</span>
        <p class="text-xs sm:text-sm text-slate-700 font-mono bg-white p-3 rounded-lg border border-slate-200">
            "Hola [Nombre Tutor] 👋 Nuestro sistema preventivo en [Nombre Veterinaria] nos avisa que en 7 días se cumple el refuerzo de [Vacuna / Desparasitación] de [Nombre Mascota]. Como tienes tu Plan de Salud activo, este beneficio ya está 100% cubierto ($0 en recepción). ¿Te agendamos para este sábado?"
        </p>
    </div>
</div>

<h2 id="terminal-canje" class="text-2xl font-bold text-slate-900 mt-8 mb-4 scroll-mt-24">5. La Experiencia de Canje en Mostrador: Transparencia Total</h2>
<p class="text-slate-700 leading-relaxed mb-4">
La mayor fricción en los modelos de membresía ocurre cuando el cliente llega a la veterinaria y pregunta: <em>"¿A mí todavía me queda una vacuna o consulta disponible este mes?"</em>.
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
        Activa tu Terminal de Canje con AviPetApp hoy mismo →
    </a>
</div>
HTML,
            ],
            [                'slug' => 'mejores-software-veterinarios-colombia-comparativa-2026',
                'title' => 'Los 5 Mejores Software Veterinarios en Colombia (2026): Comparativa de Precios y Funciones',
                'excerpt' => 'Comparativa actualizada de software veterinario en Colombia (2026): precios en pesos, historias clínicas, planes de salud para mascotas, carnet digital QR en WhatsApp y herramientas con IA.',
                'category' => 'Tecnología & Software',
                'read_time' => '8 min de lectura',
                'author' => 'Robinson R. & Equipo AviPetApp',
                'author_role' => 'Ingeniero en Telecomunicaciones & CEO NODIA',
                'published_at' => '2026-10-05',
                'updated_at' => '2026-11-11',
                'image' => 'https://images.unsplash.com/photo-1516715094483-75da7dee9758?auto=format&fit=crop&w=1200&q=80',
                'keywords' => [
                    'software veterinario',
                    'programa para veterinarias',
                    'software para clinicas veterinarias',
                    'software veterinario colombia',
                    'mejores software veterinarios colombia',
                    'software planes de salud veterinaria',
                    'carnet digital mascotas qr software',
                    'precio software veterinario colombia'
                ],
                'faqs' => [
                    [
                        'question' => '¿Cuál es el mejor software veterinario en Colombia para planes de salud y fidelización?',
                        'answer' => 'AviPetApp es la plataforma líder en Colombia especializada en planes de salud para mascotas, carnets digitales con código QR en WhatsApp, terminal de canje en mostrador y herramientas de IA supervisada, y puede operar junto a tu software actual de historia clínica.'
                    ],
                    [
                        'question' => '¿Cuánto cuesta un software para clínica veterinaria en Colombia?',
                        'answer' => 'En AviPetApp puedes iniciar con 15 días gratis sin tarjeta de crédito, paquetes prepago desde $50.000 COP al mes (para 10 mascotas activas) o planes mensuales desde $99.000 COP/mes con 0% de comisión por venta de membresías.'
                    ],
                    [
                        'question' => '¿Tengo que migrar mis historias clínicas de software para usar AviPetApp?',
                        'answer' => 'No. AviPetApp convive con cualquier software tradicional de historia médica o facturador DIAN. Se enfoca en la retención de clientes, venta recurrente de planes preventivos y control de beneficios en recepción.'
                    ],
                ],
                'content' => <<<'HTML'
<nav aria-label="Tabla de contenidos" class="bg-slate-50 border border-slate-200 rounded-2xl p-5 my-6">
    <p class="text-xs font-extrabold uppercase tracking-wider text-violet-700 mb-3">Índice de la Comparativa de Software Veterinario en Colombia</p>
    <ol class="grid sm:grid-cols-2 gap-2 text-sm font-semibold text-slate-700 list-decimal pl-5">
        <li><a href="#test-software-interactivo" class="hover:text-violet-700 underline">Test Interactivo: ¿Qué software necesita tu clínica?</a></li>
        <li><a href="#analisis-avipetapp" class="hover:text-violet-700 underline">1. AviPetApp: Planes de Salud e IA</a></li>
        <li><a href="#analisis-tradicionales" class="hover:text-violet-700 underline">2. Vetsoft / Q-Vet / Provet Cloud</a></li>
        <li><a href="#cuadro-comparativo-colombia" class="hover:text-violet-700 underline">3. Matriz Comparativa de Funciones y Precios</a></li>
        <li><a href="#veredicto-final" class="hover:text-violet-700 underline">4. Veredicto: Cómo elegir según tu modelo</a></li>
    </ol>
</nav>

<p class="lead text-lg text-slate-700 leading-relaxed font-medium mb-6">
Elegir el <strong>software veterinario</strong> adecuado para tu clínica en Colombia es una de las decisiones más estratégicas para la rentabilidad de tu negocio. Una herramienta obsoleta genera demoras en recepción, pérdida de pacientes y falta de control sobre los ingresos mensuales.
</p>

<!-- TEST INTERACTIVO DE EVALUACIÓN DE SOFTWARE -->
<div id="test-software-interactivo" class="bg-slate-900 text-white rounded-2xl p-6 sm:p-7 my-8 border border-violet-500/40 shadow-xl scroll-mt-24">
    <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
        <span class="px-3 py-1 rounded-full bg-violet-600/30 text-cyan-300 border border-violet-400/40 text-xs font-bold">Evaluador de Software en 30 Segundos</span>
        <span class="text-xs text-slate-300">Mercado Veterinario Colombiano</span>
    </div>
    <h3 class="text-xl font-extrabold mb-1">¿Qué tipo de programa para veterinarias necesita tu clínica hoy?</h3>
    <p class="text-xs sm:text-sm text-slate-300 mb-4">Selecciona tu principal objetivo de negocio para ver la recomendación técnica exacta:</p>

    <div class="grid sm:grid-cols-3 gap-3 mb-4">
        <button type="button" onclick="setSoftwareQuiz('planes')" id="sq-btn-planes" class="p-3.5 rounded-xl bg-violet-600 border border-violet-400 text-left cursor-pointer transition">
            <span class="block text-xs font-bold uppercase text-cyan-300 mb-1">Opción A</span>
            <strong class="text-xs sm:text-sm text-white block">Quiero facturar ingresos recurrentes con planes de salud y carnet digital</strong>
        </button>
        <button type="button" onclick="setSoftwareQuiz('historia')" id="sq-btn-historia" class="p-3.5 rounded-xl bg-slate-800 border border-slate-700 hover:border-slate-500 text-left cursor-pointer transition">
            <span class="block text-xs font-bold uppercase text-slate-400 mb-1">Opción B</span>
            <strong class="text-xs sm:text-sm text-white block">Solo necesito archivar historias clínicas de urgencias y recetas</strong>
        </button>
        <button type="button" onclick="setSoftwareQuiz('hospital')" id="sq-btn-hospital" class="p-3.5 rounded-xl bg-slate-800 border border-slate-700 hover:border-slate-500 text-left cursor-pointer transition">
            <span class="block text-xs font-bold uppercase text-slate-400 mb-1">Opción C</span>
            <strong class="text-xs sm:text-sm text-white block">Soy un hospital de más de 20 consultorios y quirófanos complejos</strong>
        </button>
    </div>

    <div id="sq-result" class="p-4 rounded-xl bg-slate-800/90 border border-slate-700 space-y-2 text-xs sm:text-sm">
        <div class="font-bold text-cyan-300">Diagnóstico para tu Clínica: Arquitectura Especializada en Membresías Preventivas</div>
        <p class="text-slate-300">Los software tradicionales no gestionan planes preventivos ni entregan carnet QR en WhatsApp. La mejor solución es implementar <a href="/software-planes-salud-veterinaria" class="text-cyan-300 font-bold underline">AviPetApp</a>, que convive con tu historia clínica actual y te da 15 días gratis sin comisión.</p>
        <div class="pt-2 flex flex-wrap items-center gap-3">
            <a href="/crear-clinica-veterinaria-gratis" class="px-4 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs transition">Probar AviPetApp 15 Días Gratis →</a>
            <a href="/carnet-vacunacion-digital-mascotas-qr" class="text-xs text-slate-300 hover:underline">Ver cómo funciona el Carnet QR</a>
        </div>
    </div>
</div>
<script>
function setSoftwareQuiz(type) {
    var bPlanes = document.getElementById('sq-btn-planes');
    var bHist = document.getElementById('sq-btn-historia');
    var bHosp = document.getElementById('sq-btn-hospital');
    var res = document.getElementById('sq-result');
    bPlanes.className = 'p-3.5 rounded-xl bg-slate-800 border border-slate-700 text-left cursor-pointer transition';
    bHist.className = 'p-3.5 rounded-xl bg-slate-800 border border-slate-700 text-left cursor-pointer transition';
    bHosp.className = 'p-3.5 rounded-xl bg-slate-800 border border-slate-700 text-left cursor-pointer transition';

    if (type === 'planes') {
        bPlanes.className = 'p-3.5 rounded-xl bg-violet-600 border border-violet-400 text-left cursor-pointer transition';
        res.innerHTML = '<div class="font-bold text-cyan-300">Diagnóstico: Arquitectura de Membresías Preventivas</div>' +
            '<p class="text-slate-300">Para generar ingresos mensuales fijos y fidelizar tutores, un software de historia clínica no basta. Necesitas <a href="/software-planes-salud-veterinaria" class="text-cyan-300 font-bold underline">AviPetApp</a> para emitir carnets con código QR, cobrar mes a mes y canjear servicios en recepción en 1 clic.</p>' +
            '<div class="pt-2 flex flex-wrap items-center gap-3">' +
            '<a href="/crear-clinica-veterinaria-gratis" class="px-4 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs transition">Crear mi clínica (15 días gratis) →</a>' +
            '<a href="/carnet-vacunacion-digital-mascotas-qr" class="text-xs text-slate-300 hover:underline">Ver Carnet QR en WhatsApp</a></div>';
    } else if (type === 'historia') {
        bHist.className = 'p-3.5 rounded-xl bg-violet-600 border border-violet-400 text-left cursor-pointer transition';
        res.innerHTML = '<div class="font-bold text-cyan-300">Diagnóstico: Enfoque Clínico Mixto</div>' +
            '<p class="text-slate-300">Puedes usar un software clínico tradicional (como Vetsoft o Q-Vet) para el historial médico, pero te recomendamos conectar <a href="/software-planes-salud-veterinaria" class="text-cyan-300 font-bold underline">AviPetApp</a> en recepción para que tus clientes no se vayan a la competencia por vacunas o desparasitaciones.</p>' +
            '<div class="pt-2"><a href="/crear-clinica-veterinaria-gratis" class="px-4 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs transition">Probar 15 días gratis sin compromiso →</a></div>';
    } else {
        bHosp.className = 'p-3.5 rounded-xl bg-violet-600 border border-violet-400 text-left cursor-pointer transition';
        res.innerHTML = '<div class="font-bold text-cyan-300">Diagnóstico: Nivel Hospitalario Enterprise</div>' +
            '<p class="text-slate-300">Hospitales con quirófanos múltiples suelen usar Provet Cloud o sistemas ERP. Aun así, para la unidad ambulatoria y programas de fidelización preventiva, el modelo de carnets QR de AviPetApp aligera la carga en mostrador.</p>' +
            '<div class="pt-2"><a href="/software-planes-salud-veterinaria" class="text-xs text-cyan-300 hover:underline">Conoce cómo se integran los planes de salud →</a></div>';
    }
}
</script>

<h2 id="analisis-avipetapp" class="text-2xl font-bold text-slate-900 mt-8 mb-4 scroll-mt-24">1. AviPetApp: Software con IA para Veterinarias y Planes de Salud</h2>
<div class="border border-blue-200 bg-blue-50/40 rounded-xl p-5 mb-6">
    <p class="text-sm text-slate-700 mb-2"><strong>Lo mejor:</strong> Diseñado específicamente para crear y gestionar <a href="/software-planes-salud-veterinaria" class="text-blue-700 font-bold underline">planes de salud para mascotas</a>, emitir <a href="/carnet-vacunacion-digital-mascotas-qr" class="text-blue-700 font-bold underline">carnets digitales con código QR</a> y aprovechar herramientas de IA supervisada desde una sola plataforma.</p>
    <p class="text-sm text-slate-700 mb-2"><strong>Funciones estrella:</strong> Motor de cálculo actuarial de tarifas, vitrina web propia para tu veterinaria (tu-clinica.avipetapp.com), afiche oficial en PDF para sala de espera y terminal de canje en mostrador en 1 clic.</p>
    <p class="text-sm text-slate-700 mb-0"><strong>Precio transparente:</strong> Paquetes prepago desde $50.000 COP / 10 mascotas o mensualidad plana desde $99.000 COP/mes con <strong>0% de comisión por venta</strong> (15 días de prueba gratis sin tarjeta de crédito).</p>
</div>

<h2 id="analisis-tradicionales" class="text-2xl font-bold text-slate-900 mt-8 mb-4 scroll-mt-24">2. Vetsoft / Q-Vet / Provet Cloud: Gestión Clínica Tradicional</h2>
<p class="text-slate-700 leading-relaxed mb-4">
Sistemas veteranos con amplia trayectoria en expedientes de hospitalización e inventario farmacéutico. Su fortaleza radica en el archivo médico histórico, pero carecen de módulos modernos de fidelización recurrente, carnets interactivos para el celular del tutor o cobro prepago simplificado en pesos colombianos.
</p>

<h2 id="cuadro-comparativo-colombia" class="text-2xl font-bold text-slate-900 mt-8 mb-4 scroll-mt-24">3. Cuadro Comparativo de Funcionalidades Clave (Colombia 2026)</h2>

<div class="overflow-x-auto my-6">
    <table class="w-full text-left text-sm border-collapse border border-slate-200">
        <thead>
            <tr class="bg-slate-100 text-slate-800 font-bold border-b border-slate-200">
                <th class="p-3 border-r border-slate-200">Criterio / Software</th>
                <th class="p-3 border-r border-slate-200 text-violet-700 font-extrabold bg-violet-50/50">AviPetApp</th>
                <th class="p-3 border-r border-slate-200">Software Clínico Tradicional</th>
                <th class="p-3">Excel / Libretas</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 text-slate-600">
            <tr>
                <td class="p-3 font-medium text-slate-900 border-r border-slate-200">Planes de Salud y Membresías</td>
                <td class="p-3 font-bold text-emerald-600 border-r border-slate-200 bg-violet-50/30">✓ Nativo (100% configurable)</td>
                <td class="p-3 text-red-500 border-r border-slate-200">✗ No incluye</td>
                <td class="p-3 text-red-500">✗ No incluye</td>
            </tr>
            <tr>
                <td class="p-3 font-medium text-slate-900 border-r border-slate-200">Carnet Digital QR en WhatsApp</td>
                <td class="p-3 font-bold text-emerald-600 border-r border-slate-200 bg-violet-50/30">✓ Con QR y Saldo en Vivo</td>
                <td class="p-3 text-slate-400 border-r border-slate-200">Opcional / PDF estático</td>
                <td class="p-3 text-red-500">✗ Cartulina física perdida</td>
            </tr>
            <tr>
                <td class="p-3 font-medium text-slate-900 border-r border-slate-200">Terminal de Canje en Mostrador</td>
                <td class="p-3 font-bold text-emerald-600 border-r border-slate-200 bg-violet-50/30">✓ 1-Clic por QR o Cédula</td>
                <td class="p-3 text-slate-400 border-r border-slate-200">Manual en factura</td>
                <td class="p-3 text-red-500">✗ Manual en papel</td>
            </tr>
            <tr>
                <td class="p-3 font-medium text-slate-900 border-r border-slate-200">Comisión por Cobro de Planes</td>
                <td class="p-3 font-bold text-emerald-600 border-r border-slate-200 bg-violet-50/30">0% (100% para tu clínica)</td>
                <td class="p-3 text-slate-400 border-r border-slate-200">N/A</td>
                <td class="p-3 text-slate-400">0%</td>
            </tr>
            <tr>
                <td class="p-3 font-medium text-slate-900 border-r border-slate-200">Tiempo de Puesta en Marcha</td>
                <td class="p-3 font-bold text-emerald-600 border-r border-slate-200 bg-violet-50/30">60 segundos (Inmediato)</td>
                <td class="p-3 text-slate-400 border-r border-slate-200">1 a 3 semanas de setup</td>
                <td class="p-3 text-slate-400">Inmediato pero caótico</td>
            </tr>
        </tbody>
    </table>
</div>

<h2 id="veredicto-final" class="text-2xl font-bold text-slate-900 mt-8 mb-4 scroll-mt-24">4. Veredicto: Cómo Elegir la Mejor Opción para tu Veterinaria</h2>
<p class="text-slate-700 leading-relaxed mb-4">
Si tu prioridad exclusiva es registrar expedientes médicos de urgencias, un software clásico cumple esa función. Pero <strong>si tu meta como director(a) de clínica es asegurar un flujo de caja predecible todos los meses, blindar a tus pacientes frente a la competencia y automatizar el mostrador</strong>, la mejor decisión en Colombia en 2026 es activar <a href="/software-planes-salud-veterinaria" class="text-violet-700 font-bold underline">AviPetApp</a>.
</p>

<div class="bg-gradient-to-r from-violet-900 via-indigo-900 to-[#080B20] text-white rounded-2xl p-8 my-8 text-center shadow-xl border border-violet-500/30">
    <span class="text-xs font-bold uppercase tracking-widest text-[#35DDF5] mb-2 block">Alta Inmediata · 0% Comisión</span>
    <h3 class="text-2xl font-black mb-2">Comprueba la Diferencia en tu Propia Veterinaria</h3>
    <p class="text-slate-300 text-sm max-w-xl mx-auto mb-6">
        Recibe tu vitrina con planes preconfigurados y tu afiche QR de sala de espera listo para imprimir.
    </p>
    <a href="/crear-clinica-veterinaria-gratis" class="inline-flex items-center px-7 py-3.5 bg-emerald-400 hover:bg-emerald-300 text-slate-950 font-black rounded-xl shadow-lg transition transform hover:-translate-y-0.5">
        Crear mi Clínica Gratis (15 Días Sin Tarjeta) →
    </a>
</div>
HTML,
            ],,
            [
                'slug' => 'como-calcular-precio-planes-salud-veterinaria-plantilla-costos',
                'title' => 'Cómo Calcular Precios en tu Veterinaria y Planes de Salud: Calculadora y Plantilla de Costos (Colombia 2026)',
                'excerpt' => 'Calculadora interactiva y plantilla en pesos colombianos para calcular precios en tu clínica veterinaria: costos reales de vacunas, desparasitación, consulta médica y margen neto del 65%.',
                'category' => 'Finanzas & Rentabilidad',
                'read_time' => '9 min de lectura',
                'author' => 'Robinson R. & Equipo AviPetApp',
                'author_role' => 'Ingeniero en Telecomunicaciones & Director Técnico',
                'published_at' => '2026-10-08',
                'updated_at' => '2026-11-10',
                'image' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=1200&q=80',
                'keywords' => [
                    'avipetapp',
                    'como calcular precios veterinaria',
                    'como calcular el precio de los planes de salud veterinaria',
                    'plantilla costos clinica veterinaria',
                    'margen ganancia planes salud mascotas',
                    'fijacion precios veterinaria colombia',
                    'costo vacunas desparasitacion perros gatos'
                ],
                'faqs' => [
                    [
                        'question' => '¿Cómo calcular los precios de servicios y planes de salud en una clínica veterinaria?',
                        'answer' => 'Suma el costo anual directo de insumos a precio de distribuidor (vacunas, antiparasitarios y jeringas, aprox. $95.000 COP/año en Colombia), divídelo entre 12 meses ($7.916 COP/mes) y divídelo por (1 - margen deseado del 65%), sumando el tiempo médico de consultas preventivas para obtener una cuota óptima entre $45.000 y $49.000 COP/mes.'
                    ],
                    [
                        'question' => '¿Cuál es el margen de rentabilidad ideal en una clínica veterinaria en Colombia?',
                        'answer' => 'En servicios preventivos y planes de salud para mascotas, el margen bruto recomendado sobre insumos biológicos es del 60% al 70%, lo que genera cerca de $49.300.000 COP de utilidad bruta anual por cada 100 mascotas afiliadas.'
                    ],
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
    <p class="text-emerald-950 font-bold mb-1">Regla de Oro Actuarial en AviPetApp:</p>
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

<h2 id="formula-precio" class="text-2xl font-bold text-slate-900 mt-8 mb-4 scroll-mt-24">2. Fijando la Cuota Mensual con la Fórmula AviPetApp</h2>
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
        <a id="sim-whatsapp-lead" href="https://wa.me/573235813942?text=Hola%20Robinson,%20calcul%C3%A9%20mis%20costos%20con%20el%20simulador%20de%20AviPetApp%20para%20100%20mascotas%20y%20quiero%20la%20Plantilla%20de%20Excel%20gratuita." target="_blank" class="w-full sm:w-auto px-5 py-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs uppercase tracking-wider rounded-xl shadow-lg transition transform hover:-translate-y-0.5 shrink-0 text-center flex items-center justify-center gap-2">
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

        const waText = encodeURIComponent(`Hola Robinson, calculé mis costos con el simulador de AviPetApp para ${pets} mascotas a $${fee.toLocaleString('es-CO')} y quiero recibir la Plantilla de Excel de Costos.`);
        document.getElementById('sim-whatsapp-lead').href = `https://wa.me/573235813942?text=${waText}`;
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
        No dejes el dinero sobre la mesa. Con AviPetApp puedes personalizar tus servicios, precios y emitir carnets con código QR en minutos. 15 días gratis.
    </p>
    <a href="/registro-clinica" class="inline-flex items-center px-6 py-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black rounded-xl shadow-lg transition transform hover:-translate-y-0.5">
        Crear mi Cuenta Gratis (15 Días) →
    </a>
</div>
HTML,
            ],
            [
                'slug' => 'alergia-dermatitis-picazon-perros-suplemento-hipoalergenico-colombia',
                'title' => 'Alergia, Dermatitis y Caída de Pelo en Perros: Guía del Eje Intestino-Piel y Suplemento Hipoalergénico en Colombia',
                'excerpt' => 'Descubre por qué el 80% de la picazón, alergias de piel y caída de pelo en perros nace en la microbiota intestinal, cómo funciona la Matriz de Micro-Proteína Novel Hipoalergénica y cómo pedir AVIPET BioLab® Dermo & Gut Superboost ($69.900 COP con Envío Gratis y Pago Contraentrega en Colombia).',
                'category' => 'Nutrición Clínica & BioLab®',
                'read_time' => '6 min de lectura',
                'author' => 'División Científica AVIPET BioLab®',
                'author_role' => 'Biotecnología Nutricional & Salud Dermo-Digestiva',
                'published_at' => '2026-10-25',
                'updated_at' => '2026-11-10',
                'image' => '/images/biolab/hero-estudio-1-bolsa.webp',
                'keywords' => [
                    'alergia en perros piel',
                    'dermatitis en perros tratamiento natural colombia',
                    'picazon en perros lamedura patas',
                    'suplemento hipoalergenico para perros colombia',
                    'caida de pelo en perros vitaminas',
                    'avipet biolab dermo gut superboost',
                    'microbiota intestinal perros alergia alimentaria'
                ],
                'faqs' => [
                    [
                        'question' => '¿Por qué mi perro se rasca tanto, se lame las patas y pierde pelo?',
                        'answer' => 'En más del 70% de los casos crónicos, el rascado constante, el enrojecimiento de orejas, la lamedura de patas y las heces blandas están conectados con la hipersensibilidad a proteínas convencionales (pollo, res, soya) y el desequilibrio del eje intestino-piel.'
                    ],
                    [
                        'question' => '¿Qué es AVIPET BioLab® Dermo & Gut Superboost y cómo se administra?',
                        'answer' => 'Es un super-suplemento funcional grado veterinario en polvo (Topper nutricional de 250g - 50 dosis) formulado con Matriz de Micro-Proteína Novel Hipoalergénica, Ácido Láurico Dermo-Activo (4.5%), Omega 3-6-9 de Linaza Dorada, Fibra Prebiótica, Cúrcuma y Clorofila. Se espolvorea diariamente sobre el concentrado o dieta actual de tu mascota.'
                    ],
                    [
                        'question' => '¿Cuánto vale AVIPET BioLab® Dermo & Gut Superboost en Colombia y tiene pago contraentrega?',
                        'answer' => 'Tiene un valor de $69.900 COP (1 Bolsa de 250g para 50 dosis) con Envío Gratis y Pago Contraentrega (pagas al recibir en casa) en toda Colombia. También están disponibles el Pack Dúo Clínico (2 bolsas por $124.900 COP) y el Tratamiento de 90 Días (3 bolsas por $169.900 COP), además de precios mayoristas para clínicas veterinarias.'
                    ],
                ],
                'content' => <<<'HTML'
<p class="lead text-lg text-slate-700 leading-relaxed font-medium mb-6">
En la consulta veterinaria diaria en Colombia, las <strong>dermatitis alérgicas, el prurito (picazón incesante), la otitis recurrente y las heces blandas</strong> representan más del 38% de los motivos de visita médica. Muchos tutores invierten cientos de miles de pesos en baños medicados que alivian el síntoma por pocos días, sin corregir la raíz biológica: <strong>la inflamación del eje intestino-piel</strong>.
</p>

<div class="bg-emerald-50 border-l-4 border-emerald-600 p-5 rounded-r-xl my-6">
    <p class="text-emerald-950 font-bold mb-1">Hallazgo Clínico Clave:</p>
    <p class="text-emerald-900 text-sm">
        El 70% del sistema inmunológico de perros y gatos reside en su barrera intestinal. Cuando el intestino reacciona a proteínas saturadas (como subproductos de pollo, res o cereales), libera mediadores inflamatorios que se manifiestan directamente en la piel, las almohadillas plantares y los folículos pilosos.
    </p>
</div>

<h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">1. Las 4 Señales de Alerta del Desequilibrio Dermo-Digestivo</h2>
<p class="text-slate-700 leading-relaxed mb-4">
Tanto médicos veterinarios como tutores deben identificar tempranamente los signos de intolerancia proteica y disbiosis intestinal:
</p>
<ul class="list-disc pl-6 space-y-2 text-slate-700 mb-6">
    <li><strong>Lamedura constante de patas y axilas:</strong> Coloración rojiza u oxidada entre los dedos por exceso de levaduras oportunistas.</li>
    <li><strong>Caída excesiva de pelo y pelaje opaco:</strong> Déficit de aminoácidos azufrados y ácidos grasos de cadena media biodisponibles.</li>
    <li><strong>Digestión sensible y gases:</strong> Heces blandas, pastosas o malolientes pese a usar concentrados comerciales costosos.</li>
    <li><strong>Sacudida de cabeza y cerumen oscuro:</strong> Inflamación del conducto auditivo vinculada a alergias alimentarias.</li>
</ul>

<h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">2. Biotecnología Nutricional: Matriz de Micro-Proteína Novel Hipoalergénica</h2>
<p class="text-slate-700 leading-relaxed mb-4">
Para romper el ciclo de reactividad inmunológica sin obligar al tutor a cambiar todo el bulto de concentrado, la división científica <strong>AVIPET BioLab®</strong> desarrolló <strong>Dermo &amp; Gut Superboost (250g)</strong>, un topper funcional 100% puro que se espolvorea sobre el alimento diario gracias a tres pilares bioactivos:
</p>

<div class="grid md:grid-cols-3 gap-4 my-6">
    <div class="border border-slate-200 rounded-xl p-5 bg-white shadow-sm">
        <span class="inline-block bg-teal-100 text-teal-800 text-xs font-bold px-2.5 py-1 rounded-full mb-2">Pilar 1 · 55% Proteína</span>
        <h3 class="text-base font-bold text-slate-900 mb-2">Péptidos Bioactivos Hipoalergénicos</h3>
        <p class="text-xs text-slate-600">Matriz de Micro-Proteína Novel de bajo peso molecular no reconocida como alérgeno por el sistema inmune canino ni felino.</p>
    </div>
    <div class="border border-slate-200 rounded-xl p-5 bg-white shadow-sm">
        <span class="inline-block bg-amber-100 text-amber-800 text-xs font-bold px-2.5 py-1 rounded-full mb-2">Pilar 2 · Barrera Dérmica</span>
        <h3 class="text-base font-bold text-slate-900 mb-2">Ácido Láurico + Omega 3, 6 y 9</h3>
        <p class="text-xs text-slate-600">Lípidos funcionales con acción calmante natural que nutren el folículo piloso, reducen el rascado y devuelven el brillo al manto.</p>
    </div>
    <div class="border border-slate-200 rounded-xl p-5 bg-white shadow-sm">
        <span class="inline-block bg-purple-100 text-purple-800 text-xs font-bold px-2.5 py-1 rounded-full mb-2">Pilar 3 · Microbiota</span>
        <h3 class="text-base font-bold text-slate-900 mb-2">Quitina Prebiótica Selectiva</h3>
        <p class="text-xs text-slate-600">Fibra prebiótica bioactiva que alimenta las bacterias benéficas del colon, logrando heces firmes y menor olor en 7 a 14 días.</p>
    </div>
</div>

<h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">3. Doble Oportunidad: Bienestar para Tutores y Rentabilidad para Veterinarias</h2>
<p class="text-slate-700 leading-relaxed mb-4">
<strong>Si eres tutor de una mascota:</strong> Puedes solicitar tu tratamiento de <strong>AVIPET BioLab® — Dermo &amp; Gut Superboost</strong> directamente en línea con <strong>Envío Gratis y Pago Contraentrega en toda Colombia</strong> (pagas en efectivo o transferencia cuando el mensajero entrega en tu puerta) por <strong>$69.900 COP</strong> (1 bolsa de 250g para 50 dosis), o aprovechar el <strong>Pack Dúo Clínico (2 bolsas por $124.900 COP)</strong> y el <strong>Tratamiento Completo 90 Días (3 bolsas por $169.900 COP)</strong>.
</p>
<p class="text-slate-700 leading-relaxed mb-6">
<strong>Si tienes una Clínica Veterinaria o Pet Shop:</strong> Puedes incorporar <strong>AVIPET BioLab®</strong> dentro de tus <strong>planes de salud dermatológicos en AviPetApp</strong> o distribuirlo en tu mostrador con margen mayorista preferencial para clínicas socias.
</p>

<div class="grid md:grid-cols-2 gap-6 my-8">
    <div class="bg-gradient-to-br from-emerald-950 via-teal-900 to-slate-900 text-white rounded-2xl p-6 shadow-xl border border-emerald-500/30 flex flex-col justify-between">
        <div>
            <span class="inline-block bg-emerald-400/20 text-emerald-300 text-xs font-bold px-3 py-1 rounded-full mb-3">🐾 Para Tutores de Mascotas · Envío Gratis + Contraentrega</span>
            <h3 class="text-xl font-black mb-2">Pide AVIPET BioLab® Dermo &amp; Gut Superboost</h3>
            <p class="text-emerald-100 text-xs leading-relaxed mb-5">
                Bolsa Doypack de 250g (50 dosis). Envío Gratis a toda Colombia y pago en casa al recibir por <strong>$69.900 COP</strong>.
            </p>
        </div>
        <a href="/biolab/dermo-gut-superboost" class="inline-flex items-center justify-center px-5 py-3 bg-emerald-400 hover:bg-emerald-300 text-slate-950 font-black text-sm rounded-xl shadow-lg transition">
            Pedir Contraentrega ($69.900) →
        </a>
    </div>

    <div class="bg-gradient-to-br from-[#080B20] via-[#111936] to-indigo-950 text-white rounded-2xl p-6 shadow-xl border border-purple-500/30 flex flex-col justify-between">
        <div>
            <span class="inline-block bg-purple-400/20 text-purple-300 text-xs font-bold px-3 py-1 rounded-full mb-3">🏥 Para Clínicas Veterinarias · SaaS + Mayorista</span>
            <h3 class="text-xl font-black mb-2">Activa tus Planes de Salud y Distribuye BioLab®</h3>
            <p class="text-slate-300 text-xs leading-relaxed mb-5">
                Crea planes de salud preventivos con Carnet QR en tu veterinaria (15 días gratis) o solicita precios mayoristas de BioLab® para tu clínica.
            </p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2.5">
            <a href="/registro-clinica" class="inline-flex items-center justify-center px-4 py-3 bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-bold text-xs rounded-xl shadow transition flex-1">
                Probar SaaS 15 Días Gratis →
            </a>
            <a href="https://wa.me/573235813942?text=Hola%20AviPetApp,%20tengo%20una%20veterinaria%20y%20quiero%20informaci%C3%B3n%20del%20Software%20y%20distribuci%C3%B3n%20mayorista%20de%20AVIPET%20BioLab" target="_blank" class="inline-flex items-center justify-center px-4 py-3 bg-white/10 hover:bg-white/20 text-white font-bold text-xs rounded-xl border border-white/20 transition">
                Tarifa Mayorista Clínicas
            </a>
        </div>
    </div>
</div>
HTML,
            ]

            [
                'slug' => 'perro-se-lame-las-patas-rojas-pododermatitis-alergia-solucion',
                'title' => 'Mi Perro Se Lame Mucho las Patas Rojas y Se Muerde: Causas, Pododermatitis y Tratamiento en Colombia (2026)',
                'excerpt' => '¿Tu perro se lame las patas sin parar y las tiene rojas o inflamadas? Conoce las verdaderas causas de la pododermatitis alérgica en Colombia, el papel de las levaduras y el suplemento 3 en 1 con Matriz Hipoalergénica y Ácido Láurico ($69.900 Contraentrega).',
                'category' => 'Dermatología Canina & BioLab®',
                'read_time' => '7 min de lectura',
                'author' => 'División Científica AVIPET BioLab®',
                'author_role' => 'Biotecnología Nutricional & Salud Dermo-Digestiva',
                'published_at' => '2026-11-11',
                'updated_at' => '2026-11-11',
                'image' => '/images/biolab/empaque-frente-reverso.jpg',
                'keywords' => [
                    'mi perro se lame mucho las patas',
                    'perro patas rojas pododermatitis',
                    'por que mi perro se muerde las patas',
                    'alergia en patas perros tratamiento colombia',
                    'hongos en patas de perros remedio',
                    'suplemento dermatitis perros colombia contraentrega',
                    'acido laurico perros picazon'
                ],
                'faqs' => [
                    [
                        'question' => '¿Por qué mi perro se lame compulsivamente las patas y las almohadillas?',
                        'answer' => 'En más del 80% de los casos en Colombia, el lamido compulsivo se debe a prurito alérgico ocasionado por hipersensibilidad alimentaria (alergia al pollo, res o cereales) o dermatitis atópica. La humedad de la saliva crea el ambiente perfecto para la proliferación de levaduras (Malassezia), tiñendo los pelos de color rojizo oxidado.'
                    ],
                    [
                        'question' => '¿Sirven las cremas o remedios caseros para las patas rojas en perros?',
                        'answer' => 'Las cremas tópicas suelen ser lamidas por el perro a los pocos segundos, pudiendo causarle irritación gástrica. El tratamiento más efectivo actúa desde el interior: modulando la respuesta inflamatoria en el intestino con Ácido Láurico dermo-activo y sustituyendo proteínas reactivas por una Matriz de Micro-Proteína Novel Hipoalergénica.'
                    ],
                    [
                        'question' => '¿Cómo ayuda AVIPET BioLab® Dermo & Gut Superboost en perros que se lamen las patas?',
                        'answer' => 'Su fórmula 3 en 1 contiene 4.5% de Ácido Láurico Dermo-Activo (potente antimicrobiano y antifúngico natural que corta la proliferación de levaduras), 40% de Micro-Proteína Novel 100% libre de pollo y res, y Omega 3-6-9 de Linaza Dorada que regenera la barrera epidérmica de las patas en 3 a 4 semanas.'
                    ],
                    [
                        'question' => '¿Cuál es el precio y tiempo de entrega en Colombia?',
                        'answer' => 'La bolsa de 250g (50 dosis) cuesta $69.900 COP con Envío Gratis y Pago Contraentrega (pagas en efectivo o transferencia al recibir en tu puerta). El tiempo promedio de entrega en Bogotá y Sabana Norte es de 24 a 48 horas, y 48 a 72 horas para el resto del país.'
                    ],
                ],
                'content' => <<<'HTML'
<nav aria-label="Tabla de contenidos" class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 my-6">
    <p class="text-xs font-extrabold uppercase tracking-wider text-emerald-800 mb-3">Guía Clínica de Alivio Dermo-Podal (Colombia 2026)</p>
    <ol class="grid sm:grid-cols-2 gap-2 text-sm font-semibold text-slate-700 list-decimal pl-5">
        <li><a href="#por-que-se-lame-las-patas" class="hover:text-emerald-700 underline">1. El ciclo del lamido y la Malassezia</a></li>
        <li><a href="#calculadora-dosis-patas" class="hover:text-emerald-700 underline">2. Calculadora de Dosis en Gramos por Peso</a></li>
        <li><a href="#como-actua-acido-laurico" class="hover:text-emerald-700 underline">3. Ácido Láurico Dermo-Activo vs Cremas</a></li>
        <li><a href="#pedido-contraentrega-patas" class="hover:text-emerald-700 underline">4. Cómo pedir Contraentrega ($69.900)</a></li>
    </ol>
</nav>

<p class="lead text-lg text-slate-700 leading-relaxed font-medium mb-6">
Ver a tu perro lamerse y morderse las patas día y noche es desesperante. Muchos tutores en Colombia notan que <strong>los pelos entre las almohadillas se tornan de un color rojizo o marrón oxidado</strong>, despiden un olor similar a queso o levadura y la piel se inflama al punto de causar cojera.
</p>

<h2 id="por-que-se-lame-las-patas" class="text-2xl font-bold text-slate-900 mt-8 mb-4 scroll-mt-24">1. La Verdad Detrás de las Patas Rojas: El Eje Intestino-Piel</h2>
<p class="text-slate-700 leading-relaxed mb-4">
El lamido constante no es "manía" ni "estrés" en la mayoría de los casos. Es <strong>pododermatitis alérgica</strong>:
</p>
<ul class="list-disc pl-6 space-y-2 text-slate-700 mb-6">
    <li><strong>Intolerancia a la proteína tradicional:</strong> El 70% del sistema inmune está en el intestino. Al digerir concentrados comerciales con harinas de pollo o res, el intestino permeable libera citoquinas inflamatorias que se acumulan en las extremidades.</li>
    <li><strong>Proliferación de Malassezia:</strong> La saliva del perro contiene porfirinas (que tiñen el pelo de rojo) y humedad constante, el caldo de cultivo ideal para levaduras y hongos que intensifican el picor en un 300%.</li>
</ul>

<!-- CALCULADORA DE DOSIS INTERACTIVA -->
<div id="calculadora-dosis-patas" class="bg-gradient-to-br from-slate-900 via-[#080B20] to-emerald-950 text-white rounded-2xl p-6 sm:p-8 my-8 border border-emerald-500/40 shadow-2xl scroll-mt-24">
    <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
        <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 text-xs font-bold">Calculadora de Dosis Oficial AVIPET BioLab®</span>
        <span class="text-xs text-slate-300">Dermo & Gut Superboost (250g)</span>
    </div>
    <h3 class="text-xl sm:text-2xl font-extrabold mb-1">Calcula la dosis diaria de alivio para tu perro</h3>
    <p class="text-xs sm:text-sm text-slate-300 mb-5">Desliza el peso de tu mascota para ver los gramos exactos, duración de la bolsa y modo de empleo:</p>

    <div class="space-y-4">
        <div>
            <div class="flex justify-between text-sm font-bold mb-1.5">
                <span>Peso de tu perro:</span>
                <span id="patas-weight-val" class="text-emerald-400 font-black text-base">15 kg (Mediano)</span>
            </div>
            <input type="range" id="patas-weight" min="2" max="50" step="1" value="15" oninput="calcPatasDose()" class="w-full accent-emerald-400">
        </div>

        <div class="grid sm:grid-cols-3 gap-3 pt-2">
            <div class="p-3.5 rounded-xl bg-white/5 border border-white/10">
                <span class="text-xs text-slate-400 block">Dosis Diaria Recomendada:</span>
                <strong id="patas-dose-out" class="text-lg text-emerald-300">5 g al día (1 cucharada)</strong>
            </div>
            <div class="p-3.5 rounded-xl bg-white/5 border border-white/10">
                <span class="text-xs text-slate-400 block">Duración de 1 Bolsa (250g):</span>
                <strong id="patas-days-out" class="text-lg text-white">50 días de tratamiento</strong>
            </div>
            <div class="p-3.5 rounded-xl bg-white/5 border border-white/10">
                <span class="text-xs text-slate-400 block">Inversión por Día:</span>
                <strong id="patas-cost-out" class="text-lg text-[#35DDF5]">$1.398 COP / día</strong>
            </div>
        </div>

        <div class="pt-3 flex flex-col sm:flex-row items-center gap-3">
            <a href="/biolab/dermo-gut-superboost" class="w-full sm:w-auto px-6 py-3.5 bg-emerald-400 hover:bg-emerald-300 text-slate-950 font-black text-sm rounded-xl shadow-lg transition text-center">
                Pedir con Pago Contraentrega ($69.900 COP) →
            </a>
            <span class="text-xs text-slate-300">🚚 Envío Gratis a toda Colombia · Pagas al recibir en tu casa</span>
        </div>
    </div>
</div>
<script>
function calcPatasDose() {
    var w = parseInt(document.getElementById('patas-weight').value, 10) || 15;
    var dose = 5;
    var label = w + ' kg';
    if (w <= 5) { dose = 2.5; label += ' (Miniatura / Toy)'; }
    else if (w <= 12) { dose = 3.5; label += ' (Pequeño)'; }
    else if (w <= 25) { dose = 5; label += ' (Mediano)'; }
    else if (w <= 40) { dose = 7.5; label += ' (Grande)'; }
    else { dose = 10; label += ' (Gigante)'; }

    var days = Math.round(250 / dose);
    var costPerDay = Math.round(69900 / days);

    document.getElementById('patas-weight-val').textContent = label;
    document.getElementById('patas-dose-out').textContent = dose + ' g al día (' + (dose <= 3.5 ? '1/2 cucharadita' : '1 cucharada medidora') + ')';
    document.getElementById('patas-days-out').textContent = days + ' días de alivio continuo';
    document.getElementById('patas-cost-out').textContent = '$' + costPerDay.toLocaleString('es-CO') + ' COP / día';
}
</script>

<h2 id="como-actua-acido-laurico" class="text-2xl font-bold text-slate-900 mt-8 mb-4 scroll-mt-24">2. Por Qué el Ácido Láurico Dermo-Activo Corta el Lamido de Raíz</h2>
<p class="text-slate-700 leading-relaxed mb-4">
A diferencia de los medicamentos corticoesteroides que deprimen el sistema inmunológico o las cremas tópicas que tu perro se come en 3 minutos, <strong>AVIPET BioLab® Dermo & Gut Superboost</strong> actúa desde adentro:
</p>
<ul class="list-disc pl-6 space-y-2 text-slate-700 mb-6">
    <li><strong>Ácido Láurico Dermo-Activo (4.5%):</strong> En el organismo se convierte en monolaurina, un lípido bioactivo que destruye la membrana lipídica de las levaduras (Malassezia) y bacterias oportunistas en las patas.</li>
    <li><strong>Matriz de Micro-Proteína Novel (40%):</strong> Cero pollo, res, soya o gluten. Fuente de aminoácidos puros que detienen la respuesta autoinmune cutánea.</li>
    <li><strong>Omega 3-6-9 de Linaza Dorada:</strong> Desinflama la dermis y repara la almohadilla plantar reseca.</li>
</ul>

<div id="pedido-contraentrega-patas" class="bg-slate-100 rounded-2xl p-6 sm:p-8 my-8 border border-slate-300 flex flex-col md:flex-row items-center justify-between gap-6">
    <div class="space-y-2 max-w-xl">
        <span class="text-xs font-bold uppercase text-emerald-700">Garantía y Confianza AVIPET BioLab®</span>
        <h3 class="text-xl font-black text-slate-900">Alivia la picazón de tu mascota sin arriesgar tu dinero</h3>
        <p class="text-xs sm:text-sm text-slate-600">
            Pide hoy tu bolsa de <strong>Dermo & Gut Superboost (250g) por solo $69.900 COP</strong>. El repartidor llega a tu dirección y pagas en efectivo o transferencia al recibirlo.
        </p>
    </div>
    <a href="/biolab/dermo-gut-superboost" class="px-6 py-4 bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-sm rounded-xl shadow-lg transition whitespace-nowrap text-center">
        Comprar con Envío Gratis ($69.900) →
    </a>
</div>
HTML,
            ],
            [
                'slug' => 'alergia-al-pollo-en-perros-sintomas-piel-que-darle',
                'title' => 'Alergia al Pollo en Perros: Síntomas en Piel, Qué Concentrado o Suplemento Darle y Proteína Novel (Colombia)',
                'excerpt' => '¿Sospechas que tu perro es alérgico al pollo? Descubre las 5 señales en piel y digestión, por qué los concentrados tradicionales fallan y cómo la Micro-Proteína Novel hipoalergénica de AVIPET BioLab® ($69.900 Contraentrega) elimina el picor sin cambiar de marca bruscamente.',
                'category' => 'Nutrición Clínica & Alergias',
                'read_time' => '6 min de lectura',
                'author' => 'División Científica AVIPET BioLab®',
                'author_role' => 'Biotecnología Nutricional & Salud Dermo-Digestiva',
                'published_at' => '2026-11-11',
                'updated_at' => '2026-11-11',
                'image' => '/images/biolab/funnel-antes-despues.png',
                'keywords' => [
                    'alergia al pollo en perros sintomas',
                    'perro alergico al pollo que darle',
                    'alimentos hipoalergenicos para perros sin pollo',
                    'dermatitis por pollo en perros colombia',
                    'sustituto de proteina para perros alergicos',
                    'suplemento hipoalergenico perros colombia',
                    'proteina novel hipoalergenica perros'
                ],
                'faqs' => [
                    [
                        'question' => '¿Cuáles son los síntomas más comunes de la alergia al pollo en perros?',
                        'answer' => 'Los síntomas principales son: rascado intenso en orejas, cuello y vientre; enrojecimiento de la piel; caída de pelo en parches; lamedura compulsiva de patas; y en el área digestiva: flatulencias constantes, heces pastosas o vómitos ocasionales de bilis.'
                    ],
                    [
                        'question' => '¿Por qué tantos perros en Colombia desarrollan alergia al pollo?',
                        'answer' => 'El pollo es la proteína más utilizada en la industria de alimentos balanceados. Al estar expuestos a la misma fuente proteica ultraprocesada durante años, el sistema inmunológico del perro reconoce la molécula como un alérgeno agresor, desencadenando una respuesta autoinmune inflamatoria crónica.'
                    ],
                    [
                        'question' => '¿Qué suplemento o topper darle a un perro con alergia al pollo?',
                        'answer' => 'Se debe utilizar un suplemento con Matriz de Micro-Proteína Novel Hipoalergénica 100% libre de pollo, res y soya, como AVIPET BioLab® Dermo & Gut Superboost. Aporta 40% de proteína limpia hipoalergénica que no genera reactividad cruzada y regenera la flora intestinal.'
                    ],
                ],
                'content' => <<<'HTML'
<p class="lead text-lg text-slate-700 leading-relaxed font-medium mb-6">
El pollo es el ingrediente principal en más del 85% de los concentrados comerciales en Colombia. Sin embargo, en la práctica clínica veterinaria, es también el <strong>alérgeno alimentario número uno</strong> responsable de otitis crónicas, barriga enrojecida y diarreas intermitentes.
</p>

<div class="bg-amber-50 border-l-4 border-amber-500 p-5 rounded-r-xl my-6">
    <p class="text-amber-950 font-bold mb-1">Cuidado con la "Trampa de las Etiquetas":</p>
    <p class="text-amber-900 text-sm">
        Muchos alimentos comerciales que dicen "Sabor a Cordero" o "Salmón" en la portada, contienen como primer o segundo ingrediente <em>"Harina de subproductos de ave"</em> o <em>"Grasa de pollo"</em>. Si tu perro es sensible, seguirá rascándose sin parar.
    </p>
</div>

<h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">Las 5 Señales Inequívocas de Alergia al Pollo</h2>
<ul class="list-disc pl-6 space-y-2 text-slate-700 mb-6">
    <li><strong>1. Otitis recurrente con cera oscura:</strong> Se sacude la cabeza y las orejas huelen a humedad.</li>
    <li><strong>2. Piel del abdomen caliente y enrojecida:</strong> Pequeños granitos o ronchas en axilas e ingle.</li>
    <li><strong>3. Lamido constante de patas y ano:</strong> Sensación de quemazón provocada por histaminas.</li>
    <li><strong>4. Heces inconsistentes:</strong> Días con popó firme seguidos de días con diarrea o heces pastosas.</li>
    <li><strong>5. Mal aliento persistente:</strong> Disbiosis gástrica por fermentación anormal de proteínas.</li>
</ul>

<div class="bg-gradient-to-r from-emerald-900 to-slate-900 text-white rounded-2xl p-7 my-8 border border-emerald-500/40">
    <h3 class="text-xl font-black text-emerald-300 mb-2">La Solución: Proteína Novel Hipoalergénica + Ácido Láurico</h3>
    <p class="text-xs sm:text-sm text-slate-300 mb-5">
        <strong>AVIPET BioLab® Dermo & Gut Superboost</strong> es 100% libre de pollo, res, soya y gluten. Espolvoreas una cucharada sobre su comida habitual y entregas aminoácidos puros que no activan los anticuerpos de la alergia.
    </p>
    <a href="/biolab/dermo-gut-superboost" class="inline-flex items-center px-6 py-3.5 bg-emerald-400 hover:bg-emerald-300 text-slate-950 font-extrabold text-sm rounded-xl shadow-lg transition">
        Pedir Dermo & Gut Superboost ($69.900 Contraentrega) →
    </a>
</div>
HTML,
            ],
            [
                'slug' => 'caida-de-pelo-perros-caspa-pelaje-opaco-vitaminas-colombia',
                'title' => 'Caída de Pelo Excesiva en Perros, Caspa y Pelaje Opaco: Causas, Vitaminas y Suplementos en Colombia',
                'excerpt' => '¿Tu perro bota demasiado pelo y deja la ropa y muebles llenos? Aprende la diferencia entre muda normal y alopecia nutricional, qué vitaminas necesita y cómo el Omega 3-6-9 de Linaza Dorada y Ácido Láurico ($69.900 Contraentrega) frenan la caída en 21 días.',
                'category' => 'Salud Capilar & Piel Canina',
                'read_time' => '6 min de lectura',
                'author' => 'División Científica AVIPET BioLab®',
                'author_role' => 'Biotecnología Nutricional & Salud Dermo-Digestiva',
                'published_at' => '2026-11-11',
                'updated_at' => '2026-11-11',
                'image' => '/images/biolab/funnel-pack-trio.png',
                'keywords' => [
                    'caida de pelo en perros que darle',
                    'vitaminas caida de pelo perros colombia',
                    'mi perro bota mucho pelo y tiene caspa',
                    'suplemento pelaje brillante perros',
                    'omega 3 para pelo de perros colombia',
                    'remedio natural para la caida de pelo perros',
                    'dermo gut superboost pelo y piel'
                ],
                'faqs' => [
                    [
                        'question' => '¿Por qué a mi perro se le cae tanto el pelo todo el año?',
                        'answer' => 'En climas como Colombia (sin estaciones marcadas), los perros no tienen mudas estacionales definidas. La caída excesiva con zonas calvas o pelo quebradizo se debe casi siempre a déficit de ácidos grasos esenciales (Omega 3 y 6) y aminoácidos azufrados como la metionina, vitales para sintetizar queratina.'
                    ],
                    [
                        'question' => '¿Qué vitamina o suplemento es el más efectivo para frenar la caída de pelo en perros?',
                        'answer' => 'Más que una vitamina aislada, el folículo piloso requiere una sinergia de Omega 3-6-9 de alta biodisponibilidad (como el aceite de Linaza Dorada), prebióticos para absorber nutrientes y Ácido Láurico para eliminar la caspa y microorganismos del cuero cabelludo.'
                    ],
                ],
                'content' => <<<'HTML'
<p class="lead text-lg text-slate-700 leading-relaxed font-medium mb-6">
Pasar la mano por el lomo de tu perro y quedarte con un mechón de pelo en la mano no es normal. La <strong>caída excesiva de pelaje, la caspa blanca visible y la textura seca y áspera</strong> son gritos de auxilio del folículo piloso por desnutrición celular.
</p>

<h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">Muda Fisiológica vs Caída Patológica</h2>
<p class="text-slate-700 leading-relaxed mb-4">
Mientras que la muda normal ocurre de forma homogénea, la caída patológica viene acompañada de:
</p>
<ul class="list-disc pl-6 space-y-2 text-slate-700 mb-6">
    <li>Caspa visible en el lomo al cepillar.</li>
    <li>Pelaje sin brillo, áspero al tacto como paja.</li>
    <li>Piel reseca que se descama con facilidad.</li>
    <li>Mal olor dérmico horas después del baño.</li>
</ul>

<div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white rounded-2xl p-7 my-8 border border-cyan-500/30">
    <span class="text-xs font-bold uppercase text-cyan-300 mb-1 block">Fórmula Dermatológica 3 en 1</span>
    <h3 class="text-2xl font-black mb-2">Devuélvele a tu perro un pelaje denso, brillante y sin caspa</h3>
    <p class="text-xs sm:text-sm text-slate-300 mb-5">
        <strong>AVIPET BioLab® Dermo & Gut Superboost (250g)</strong> aporta Omega 3-6-9 de Linaza Dorada, Cúrcuma antiinflamatoria y Clorofila desodorizante. Resultados visibles en suavidad y reducción de caída desde la tercera semana.
    </p>
    <a href="/biolab/dermo-gut-superboost" class="inline-flex items-center px-6 py-3.5 bg-emerald-400 hover:bg-emerald-300 text-slate-950 font-black text-sm rounded-xl shadow-lg transition">
        Pedir con Pago Contraentrega ($69.900 COP) →
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
