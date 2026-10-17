@php
    $seoBlogPosts = \App\Services\BlogService::getAllPosts();
@endphp
<div class="min-h-screen flex flex-col justify-between bg-[#F4F7FC] text-[#15213B] font-sans antialiased">
    <!-- Header Oficial AviPetApp (Pre-renderizado Semántico SEO & FCP) -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-[#D9E2F2]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
            <a href="https://avipetapp.com/" class="flex items-center py-3 shrink-0" aria-label="AviPetApp — Software con IA para veterinarias">
                <img
                    src="/brand/svg/avipetapp-horizontal-fondo-claro.svg"
                    alt="AviPetApp — Software con IA para veterinarias"
                    width="180"
                    height="36"
                    class="h-8 sm:h-9 w-auto min-w-[148px] object-contain"
                />
            </a>
            <nav aria-label="Navegación principal de AviPetApp" class="hidden lg:flex items-center gap-6 text-[14px] font-medium text-[#5C6B85]">
                <a href="#veterinarias-socias" class="text-[#0E7490] font-semibold">Para clínicas</a>
                <a href="#como-funciona">Planes de salud</a>
                <a href="#recibes">Módulos e IA</a>
                <a href="#calculadora">Calculadora</a>
                <a href="#precios">Precios</a>
                <a href="#faq">Preguntas frecuentes</a>
                <a href="/blog">Blog Veterinario</a>
            </nav>
            <div class="hidden lg:flex items-center gap-3">
                <a href="/admin/login" class="px-4 py-2.5 rounded-xl border border-[#CBD5E1] bg-white text-[#15213B] text-[14px] font-semibold">
                    Iniciar sesión
                </a>
                <a href="/registro-clinica" class="px-5 py-2.5 rounded-xl bg-[#6D28D9] text-white text-[14px] font-semibold">
                    Probar 15 días gratis
                </a>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Principal B2B -->
        <section class="relative bg-[#080B20] text-white py-16 lg:py-24 border-b border-[#1E2B58]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    <p class="text-xs font-semibold uppercase tracking-wider text-[#35DDF5] mb-4">
                        AviPetApp · Software con IA para veterinarias · Red de Clínicas Veterinarias Socias
                    </p>
                    <h1 class="text-4xl sm:text-5xl lg:text-[54px] font-bold tracking-tight leading-[1.1] text-white mb-6">
                        Planes de salud, clientes e IA en una sola plataforma.
                    </h1>
                    <p class="text-base sm:text-lg text-[#C9D4F0] leading-relaxed mb-8">
                        <strong>AviPetApp</strong> ayuda a tu clínica veterinaria a gestionar <strong>planes de salud para mascotas</strong>, emitir carnets digitales con código QR, organizar la relación con tus clientes y aprovechar herramientas inteligentes desde una sola plataforma.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="/registro-clinica" class="px-6 py-3.5 rounded-xl bg-[#6D28D9] text-white font-semibold text-base">
                            Crear mi clínica gratis (15 días)
                        </a>
                        <a href="#como-funciona" class="px-6 py-3.5 rounded-xl bg-[#111936] border border-[#29386B] text-white font-semibold text-base">
                            Ver cómo funciona
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Programa de Clínicas Veterinarias Socias y Propuesta de Valor -->
        <section id="veterinarias-socias" class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-[#15213B] mb-4">
                Software para Clínicas Veterinarias en Colombia y Latinoamérica
            </h2>
            <p class="text-base text-[#5C6B85] max-w-3xl mb-8 leading-relaxed">
                Digitaliza la operación preventiva de tu veterinaria sin reemplazar tu sistema de historia clínica actual. Crea membresías y planes de salud personalizados con tu propio logo, subdominio exclusivo y control transparente de beneficios en recepción.
            </p>
            <div class="grid md:grid-cols-3 gap-6">
                <article class="bg-white p-6 rounded-2xl border border-[#D9E2F2]">
                    <h3 class="text-lg font-bold text-[#15213B] mb-2">1. Planes de Salud para Mascotas y Membresías</h3>
                    <p class="text-sm text-[#5C6B85] leading-relaxed">
                        Diseña planes preventivos para perros y gatos (vacunación anual, desparasitación trimestral, consultas de control, profilaxis y laboratorio) con cálculo de costos e ingresos recurrentes mensuales en pesos colombianos.
                    </p>
                </article>
                <article class="bg-white p-6 rounded-2xl border border-[#D9E2F2]">
                    <h3 class="text-lg font-bold text-[#15213B] mb-2">2. Carnet Digital con Código QR y Terminal de Canje</h3>
                    <p class="text-sm text-[#5C6B85] leading-relaxed">
                        Cada mascota afiliada recibe su carnet digital interactivo accesible desde el celular o WhatsApp. En recepción, tu equipo escanea el código QR o busca por cédula para validar cupos y registrar el canje de servicios en segundos.
                    </p>
                </article>
                <article class="bg-white p-6 rounded-2xl border border-[#D9E2F2]">
                    <h3 class="text-lg font-bold text-[#15213B] mb-2">3. Herramientas con Inteligencia Artificial Supervisada</h3>
                    <p class="text-sm text-[#5C6B85] leading-relaxed">
                        Automatiza recordatorios preventivos de vacunación y renovación, organiza el seguimiento de tutores y recibe sugerencias operativas. La IA organiza información; el criterio clínico es de tu equipo veterinario.
                    </p>
                </article>
            </div>
        </section>

        <!-- Cómo funciona en 6 pasos -->
        <section id="como-funciona" class="py-12 bg-white border-y border-[#D9E2F2]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl sm:text-3xl font-bold text-[#15213B] mb-6">
                    Cómo gestionar planes de salud en tu clínica veterinaria con AviPetApp
                </h2>
                <ol class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 text-sm text-[#5C6B85]">
                    <li class="p-4 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2]">
                        <strong class="text-[#15213B] block mb-1">Paso 1: Configura tus planes de salud</strong>
                        Define el nombre de tus planes, los servicios incluidos (consultas, vacunas, baños, exámenes) y la tarifa mensual.
                    </li>
                    <li class="p-4 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2]">
                        <strong class="text-[#15213B] block mb-1">Paso 2: Comparte tu vitrina y afiche QR</strong>
                        Imprime tu afiche QR oficial de sala de espera o comparte el enlace de tu clínica por WhatsApp e Instagram.
                    </li>
                    <li class="p-4 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2]">
                        <strong class="text-[#15213B] block mb-1">Paso 3: Afiliación digital de mascotas</strong>
                        Registra al tutor y su mascota desde recepción o permite el registro desde el celular en menos de un minuto.
                    </li>
                    <li class="p-4 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2]">
                        <strong class="text-[#15213B] block mb-1">Paso 4: Emisión del carnet digital QR</strong>
                        El cliente recibe al instante su carnet digital con código QR único y el saldo actualizado de sus beneficios.
                    </li>
                    <li class="p-4 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2]">
                        <strong class="text-[#15213B] block mb-1">Paso 5: Canje en mostrador en 1 clic</strong>
                        Cuando la mascota asiste a consulta o vacunación, descuentas el beneficio usado con trazabilidad completa.
                    </li>
                    <li class="p-4 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2]">
                        <strong class="text-[#15213B] block mb-1">Paso 6: Seguimiento preventivo con IA</strong>
                        Envía recordatorios oportunos de próximas dosis y renovaciones para fortalecer la fidelización de tus clientes.
                    </li>
                </ol>
            </div>
        </section>

        <!-- Precios y Planes SaaS Transparentes -->
        <section id="precios" class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-[#15213B] mb-4">
                Precios transparentes para clínicas veterinarias (0% de comisión por venta)
            </h2>
            <p class="text-base text-[#5C6B85] mb-8">
                Empieza con 15 días de prueba gratuita sin tarjeta de crédito. El 100% del recaudo de tus planes de salud va directo a las cuentas de tu veterinaria.
            </p>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl border border-[#D9E2F2]">
                    <h3 class="font-bold text-[#15213B] text-lg">Paquete Prepago 10 Mascotas</h3>
                    <p class="text-2xl font-extrabold text-[#0E7490] my-2">$50.000 COP / mes</p>
                    <p class="text-xs text-[#5C6B85]">Ideal para iniciar sin costo fijo alto ($5.000 COP por mascota activa). Incluye vitrina web, carnet QR y terminal de canje.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-[#D9E2F2]">
                    <h3 class="font-bold text-[#15213B] text-lg">Plan Starter</h3>
                    <p class="text-2xl font-extrabold text-[#15213B] my-2">$99.000 COP / mes</p>
                    <p class="text-xs text-[#5C6B85]">Hasta 80 mascotas activas, planes de salud ilimitados, afiche QR de sala de espera y soporte por WhatsApp.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border-2 border-[#6D28D9]">
                    <h3 class="font-bold text-[#6D28D9] text-lg">Plan Profesional</h3>
                    <p class="text-2xl font-extrabold text-[#15213B] my-2">$229.000 COP / mes</p>
                    <p class="text-xs text-[#5C6B85]">Hasta 300 mascotas activas, asistente con IA supervisada, reportes financieros y múltiples usuarios de recepción.</p>
                </div>
                <div class="bg-[#080B20] text-white p-6 rounded-2xl border border-[#1E2B58]">
                    <h3 class="font-bold text-[#35DDF5] text-lg">Plan Enterprise</h3>
                    <p class="text-2xl font-extrabold text-white my-2">$489.000 COP / mes</p>
                    <p class="text-xs text-[#C9D4F0]">Mascotas ilimitadas, multisucursal, conexión de dominio propio corporativo y acompañamiento prioritario.</p>
                </div>
            </div>
        </section>

        <!-- Preguntas Frecuentes (FAQ) -->
        <section id="faq" class="py-12 bg-white border-t border-[#D9E2F2]">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl sm:text-3xl font-bold text-[#15213B] mb-6">
                    Preguntas frecuentes sobre AviPetApp
                </h2>
                <div class="space-y-4">
                    <article class="p-5 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2]">
                        <h3 class="font-bold text-[#15213B] mb-1">¿Tengo que reemplazar mi software actual de historia clínica?</h3>
                        <p class="text-sm text-[#5C6B85]">No. AviPetApp convive con tu software actual de historia médica o inventarios y opera como tu plataforma especializada en planes de salud para mascotas, carnets digitales con código QR y relación con clientes.</p>
                    </article>
                    <article class="p-5 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2]">
                        <h3 class="font-bold text-[#15213B] mb-1">¿AviPetApp cobra comisión por cada plan vendido en mi clínica?</h3>
                        <p class="text-sm text-[#5C6B85]">No. El 100% del dinero cobrado a tus clientes ingresa directo a tus cuentas o medios de pago (Nequi, Daviplata, Bancolombia, datáfono o pasarelas). Tú solo pagas tu paquete prepago o mensualidad fija.</p>
                    </article>
                    <article class="p-5 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2]">
                        <h3 class="font-bold text-[#15213B] mb-1">¿En qué momento se paga el servicio?</h3>
                        <p class="text-sm text-[#5C6B85]">Siempre es mes anticipado (prepago), garantizando cero deudas acumuladas. Cuentas con 15 días de prueba gratuita sin tarjeta de crédito.</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- Enlaces Directos al Blog Veterinario (Enlazado Interno SEO para Sitelinks) -->
        <section class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-t border-[#D9E2F2]">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl sm:text-2xl font-bold text-[#15213B]">
                    Guías y Recursos del Blog para Clínicas Veterinarias
                </h2>
                <a href="/blog" class="text-sm font-semibold text-[#6D28D9] hover:underline">
                    Ver todos los artículos →
                </a>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($seoBlogPosts as $post)
                <article class="bg-white p-5 rounded-xl border border-[#D9E2F2]">
                    <span class="text-xs font-semibold text-[#0E7490] block mb-1">{{ $post['category'] }}</span>
                    <h3 class="text-sm font-bold text-[#15213B] mb-2">
                        <a href="/blog/{{ $post['slug'] }}" class="hover:text-[#6D28D9]">{{ $post['title'] }}</a>
                    </h3>
                    <p class="text-xs text-[#5C6B85] line-clamp-3">{{ $post['excerpt'] }}</p>
                </article>
                @endforeach
            </div>
        </section>
    </main>

    <!-- Footer Oficial AviPetApp -->
    <footer class="bg-[#080B20] text-[#C9D4F0] py-12 border-t border-[#1E2B58]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div>
                <img src="/brand/svg/avipetapp-horizontal-fondo-oscuro.svg" alt="AviPetApp" width="160" height="32" class="h-8 w-auto mb-2" />
                <p class="text-xs text-[#94A3B8]">Software con IA para veterinarias · Más inteligencia. Más bienestar. Más futuro.</p>
            </div>
            <div class="flex flex-wrap gap-5 text-xs">
                <a href="https://avipetapp.com/" class="hover:text-white">Inicio</a>
                <a href="https://avipetapp.com/blog" class="hover:text-white">Blog Veterinario</a>
                <a href="https://avipetapp.com/registro-clinica" class="hover:text-white">Registrar Clínica</a>
                <a href="https://avipetapp.com/admin/login" class="hover:text-white">Acceso Clínicas</a>
            </div>
        </div>
    </footer>
</div>
