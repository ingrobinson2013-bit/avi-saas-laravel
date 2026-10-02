import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { 
    PawPrint,
    HeartPulse,
    Users,
    BrainCircuit,
    CreditCard,
    CalendarDays,
    TrendingUp,
    ChevronRight,
    Sparkles,
    Building2,
    QrCode,
    MessageCircle,
    Send,
    Eye,
    MessageSquare
} from 'lucide-react';

interface DashboardProps {
    mrr?: number;
    petsCount?: number;
    activeSubsCount?: number;
    newSubsThisMonth?: number;
    expiring15Days?: number;
    totalGranted?: number;
    totalUsed?: number;
    usagePercent?: number;
    greetingName?: string;
    userName?: string;
    userRole?: string;
    brandName?: string;
    clinicSubtitle?: string;
    logoUrl?: string | null;
    saasPlan?: {
        tier?: string;
        name?: string;
        status?: string;
        statusLabel?: string;
        paidUntil?: string;
        manageUrl?: string;
    };
    logoutUrl?: string;
    cleanCity?: string;
    formattedDate?: string;
    tenantSlug?: string;
    redeemUrl?: string;
    newSubUrl?: string;
    portalUrl?: string;
    qrUrl?: string;
    recommendation?: {
        type?: string;
        badge?: string;
        impact_text?: string;
        title?: string;
        whatsapp_url?: string;
        pet_url?: string;
        customer_name?: string;
        pet_name?: string;
    };
}

function SectionTitle({ children }: { children: React.ReactNode }) {
    return (
        <h2 className="mb-4 flex items-center gap-2 text-sm font-bold text-slate-800">
            {children}
        </h2>
    );
}

export default function Dashboard({
    mrr = 50000,
    petsCount = 1,
    activeSubsCount = 1,
    newSubsThisMonth = 0,
    expiring15Days = 0,
    totalGranted = 19,
    totalUsed = 0,
    usagePercent = 0,
    greetingName = 'Dra. Vicky',
    userName = 'Dra. Vicky Naranjo',
    userRole = 'Administradora de Sede',
    brandName = 'Vet-Pet Patitas',
    clinicSubtitle = 'Planes de salud para su mascota',
    logoUrl = 'https://pub-9b11349c37334765ad3e31861c78458f.r2.dev/tenants/logos/01M1WM7VP4PYQVQ7P0GBWK1RPW.webp',
    saasPlan = {
        name: 'Plan Pro',
        statusLabel: 'Activo',
        paidUntil: 'Al día',
        manageUrl: `/admin/vet-pet-patitas/renovar-saas`
    },
    logoutUrl = `/admin/vet-pet-patitas/logout`,
    cleanCity = 'Cajicá',
    formattedDate = 'Viernes 2 de octubre de 2026',
    tenantSlug = 'vet-pet-patitas',
    redeemUrl = `/admin/vet-pet-patitas/counter-redeem`,
    newSubUrl = `/admin/vet-pet-patitas/plans`,
    portalUrl = `/v/vet-pet-patitas`,
    qrUrl = `/v/vet-pet-patitas/afiche`,
    recommendation = {
        badge: 'Recomendación',
        impact_text: '1 oportunidad detectada',
        title: 'Te recomendamos contactar a María porque Max tiene 10/18 beneficios disponibles (como Kit Bienvenida, Cédula + Collar Placa + Carnet Digital) y no ha realizado una visita en los últimos 60 días.',
        whatsapp_url: 'https://wa.me/573508742543?text=%F0%9F%90%BE+Hola+Mar%C3%ADa%2C+te+recordamos+que+Max+tiene+consultas+y+vacunas+disponibles+en+Vet-Pet+Patitas.',
        pet_url: '/admin/vet-pet-patitas/pets',
        customer_name: 'María',
        pet_name: 'Max'
    }
}: DashboardProps) {

    // Chat interactivo del Asistente IA
    const [chatInput, setChatInput] = useState('');
    const [chatMessages, setChatMessages] = useState<Array<{ role: 'user' | 'assistant'; text: string }>>([]);

    const handlePromptClick = (text: string) => {
        const userMsg = { role: 'user' as const, text };
        let reply = '';

        if (text.includes('perro adulto') || text.includes('coberturas')) {
            reply = '🐶 **Plan Recomendado:** Para perros adultos mayores a 3 años, el Plan Patitas Básico / Senior incluye vacunación anual, 3 desparasitaciones, consultas médicas preventivas y carnet digital oficial.';
        } else if (text.includes('afiliación') || text.includes('dudas')) {
            reply = '🛡️ **Afiliación Rápida:** El tutor puede ingresar al portal web B2C o escanear el afiche QR en mostrador para afiliar a su mascota en 2 minutos con pago por Nequi o Bold.';
        } else if (text.includes('comerciales') || text.includes('oportunidades') || text.includes('analiza')) {
            reply = '📊 **Oportunidad Detectada:** Max no asiste a la clínica hace más de 60 días y tiene 10 beneficios vigentes. Escríbele por WhatsApp para agendar su control trimestral.';
        } else {
            reply = '💡 **Plan de Fidelización:** 1) Envío de carnet digital con bienvenida. 2) Alerta a los 45 días si no ha redimido baño o vacunas. 3) 10% en tienda veterinaria por renovación.';
        }

        setChatMessages(prev => [...prev, userMsg, { role: 'assistant', text: reply }]);
    };

    const handleSendChat = (e: React.FormEvent) => {
        e.preventDefault();
        if (!chatInput.trim()) return;
        const text = chatInput.trim();
        setChatInput('');
        handlePromptClick(text);
    };

    const formattedMrr = new Intl.NumberFormat('es-CO').format(mrr);

    // Módulos de métricas dinámicas
    const metrics = [
        {
            title: 'Ingresos recurrentes',
            value: `$${formattedMrr}`,
            suffix: 'COP',
            note: '+5% vs. mes anterior',
            icon: CreditCard,
            color: 'blue' as const,
        },
        {
            title: 'Mascotas activas',
            value: `${petsCount}`,
            note: `${activeSubsCount} plan activo`,
            icon: PawPrint,
            color: 'teal' as const,
        },
        {
            title: 'Nuevas afiliaciones',
            value: `+${newSubsThisMonth}`,
            note: 'Este mes',
            icon: Users,
            color: 'violet' as const,
        },
        {
            title: 'Renovaciones',
            value: `${expiring15Days}`,
            note: 'Próximos 15 días',
            icon: CalendarDays,
            color: 'amber' as const,
        },
    ];

    // Acciones rápidas operativas con enlaces reales
    const actions = [
        {
            title: 'Canjear beneficio',
            subtitle: 'Terminal POS de atención',
            icon: CreditCard,
            style: 'primary' as const,
            href: redeemUrl,
            isExternal: false,
        },
        {
            title: 'Afiliar mascota',
            subtitle: 'Nueva membresía de salud',
            icon: PawPrint,
            style: 'teal' as const,
            href: newSubUrl,
            isExternal: false,
        },
        {
            title: 'Portal pacientes',
            subtitle: 'Tienda web de afiliación',
            icon: Building2,
            style: 'white' as const,
            href: portalUrl,
            isExternal: true,
        },
        {
            title: 'Ficha & QR',
            subtitle: 'Imprimir para recepción',
            icon: QrCode,
            style: 'white' as const,
            href: qrUrl,
            isExternal: true,
        },
    ];

    const isPreview = typeof window !== 'undefined' && (window.location.search.includes('preview=1') || window.location.href.includes('preview=1'));
    const formatLink = (url: string) => isPreview && !url.includes('preview=1') ? `${url}${url.includes('?') ? '&' : '?'}preview=1` : url;

    return (
        <VetAdminLayout 
            tenantSlug={tenantSlug} 
            brandName={brandName}
            clinicSubtitle={clinicSubtitle}
            logoUrl={logoUrl}
            saasPlan={saasPlan}
            logoutUrl={logoutUrl}
            userName={userName} 
            userRole={userRole}
            activeItem="Inicio"
        >
            <Head title={`Dashboard · ${brandName}`} />

            <div className="flex flex-col 2xl:flex-row gap-5 items-start w-full">
                
                {/* =========================================================
                     CONTENIDO PRINCIPAL
                     ========================================================= */}
                <div className="min-w-0 flex-1 w-full space-y-6">

                    {/* 1. BIENVENIDA HERO CARD */}
                    <section className="relative flex min-h-40 items-center justify-between overflow-hidden rounded-2xl border border-blue-100 bg-gradient-to-r from-white via-cyan-50 to-blue-100 p-6 shadow-xs">
                        <div className="relative z-10 max-w-xl">
                            <p className="text-sm font-semibold text-slate-500">
                                ¡Hola, {greetingName}! 👋
                            </p>
                            <h2 className="mt-1 text-2xl font-extrabold tracking-tight md:text-3xl text-slate-900">
                                Bienvenida a {brandName}
                            </h2>
                            <p className="mt-2 text-sm text-slate-600">
                                Gestiona tus planes de salud, clientes y mascotas en un solo lugar.
                            </p>

                            <div className="mt-4 flex flex-wrap items-center gap-2 text-xs">
                                <span className="rounded-full border border-slate-200 bg-white/90 px-3 py-1.5 font-medium text-slate-700 shadow-2xs">
                                    📍 Sede {cleanCity}
                                </span>
                                <span className="rounded-full border border-slate-200 bg-white/90 px-3 py-1.5 font-medium text-slate-700 shadow-2xs">
                                    📅 {formattedDate}
                                </span>
                                <span className="rounded-full border border-teal-200 bg-teal-50 px-3 py-1.5 font-medium text-teal-800">
                                    ◷ Modo sincronizado
                                </span>
                                <span className="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 font-semibold text-emerald-700 flex items-center gap-1.5">
                                    <span className="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Sistema en línea
                                </span>
                            </div>
                        </div>

                        {/* Pet Cutout Graphic */}
                        <div className="hidden md:flex shrink-0 items-center justify-center relative pr-4">
                            <div className="absolute inset-0 bg-gradient-to-tr from-cyan-100/60 to-blue-200/40 rounded-full blur-xl scale-110 pointer-events-none"></div>
                            <img 
                                src="/images/dashboard/hero_pets_hd.png" 
                                alt={`Mascotas ${brandName}`} 
                                className="h-32 xl:h-36 w-auto object-contain drop-shadow-sm select-none pointer-events-none relative z-10"
                            />
                        </div>
                    </section>

                    {/* 2. INDICADORES (METRICS) */}
                    <section className="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                        {metrics.map((metric) => {
                            const Icon = metric.icon;

                            const colors: Record<string, string> = {
                                blue: "bg-blue-100 text-blue-700",
                                teal: "bg-teal-100 text-teal-700",
                                violet: "bg-violet-100 text-violet-700",
                                amber: "bg-amber-100 text-amber-700",
                            };

                            return (
                                <article 
                                    key={metric.title}
                                    className="rounded-2xl border border-slate-200 bg-white p-5 shadow-2xs transition hover:-translate-y-0.5 hover:shadow-md"
                                >
                                    <div className="flex items-center justify-between">
                                        <div className="flex items-center gap-3">
                                            <div className={`rounded-xl p-3 ${colors[metric.color]}`}>
                                                <Icon size={20} />
                                            </div>
                                            <p className="text-sm font-semibold text-slate-500">
                                                {metric.title}
                                            </p>
                                        </div>
                                        <TrendingUp size={18} className="text-slate-300" />
                                    </div>

                                    <div className="mt-5 flex items-baseline gap-2">
                                        <p className="text-3xl font-extrabold tracking-tight text-slate-900">
                                            {metric.value}
                                        </p>
                                        {metric.suffix && (
                                            <span className="text-sm font-bold text-slate-600">
                                                {metric.suffix}
                                            </span>
                                        )}
                                    </div>

                                    <p className="mt-2 text-xs font-medium text-slate-500">
                                        {metric.note}
                                    </p>
                                </article>
                            );
                        })}
                    </section>

                    {/* 3. ACCIONES RÁPIDAS */}
                    <section className="rounded-2xl border border-slate-200 bg-white p-5 shadow-2xs">
                        <SectionTitle>⚡ Acciones rápidas</SectionTitle>

                        <div className="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
                            {actions.map((action) => {
                                const Icon = action.icon;
                                const primary = action.style === 'primary';
                                const teal = action.style === 'teal';

                                const cardContent = (
                                    <>
                                        <div className={`rounded-xl p-3 shrink-0 ${
                                            primary || teal ? 'bg-white/15' : 'bg-blue-50 text-blue-600'
                                        }`}>
                                            <Icon size={23} />
                                        </div>

                                        <div className="min-w-0 flex-1">
                                            <p className="text-sm font-bold leading-tight">
                                                {action.title}
                                            </p>
                                            <p className={`mt-1 text-xs leading-tight ${
                                                primary || teal ? 'text-white/75' : 'text-slate-500'
                                            }`}>
                                                {action.subtitle}
                                            </p>
                                        </div>

                                        <ChevronRight size={18} className="shrink-0 opacity-80" />
                                    </>
                                );

                                const cardClasses = `flex min-h-24 items-center gap-3 rounded-xl border p-4 text-left transition hover:-translate-y-0.5 hover:shadow-md ${
                                    primary
                                        ? 'border-blue-700 bg-gradient-to-r from-blue-700 to-blue-600 text-white'
                                        : teal
                                            ? 'border-teal-600 bg-gradient-to-r from-teal-600 to-emerald-600 text-white'
                                            : 'border-slate-200 bg-white hover:border-blue-300 text-slate-800'
                                }`;

                                if (action.isExternal) {
                                    return (
                                        <a 
                                            key={action.title}
                                            href={action.href}
                                            target="_blank"
                                            rel="noreferrer"
                                            className={cardClasses}
                                        >
                                            {cardContent}
                                        </a>
                                    );
                                }

                                return (
                                    <Link 
                                        key={action.title}
                                        href={formatLink(action.href)}
                                        preserveScroll
                                        className={cardClasses}
                                    >
                                        {cardContent}
                                    </Link>
                                );
                            })}
                        </div>
                    </section>

                    {/* 4. PANELES OPERATIVOS (RENOVACIONES & BENEFICIOS) */}
                    <section className="grid grid-cols-1 gap-5 xl:grid-cols-2">

                        {/* Renovaciones próximas */}
                        <article className="rounded-2xl border border-slate-200 bg-white p-5 shadow-2xs flex flex-col justify-between">
                            <div>
                                <div className="mb-5 flex items-center justify-between">
                                    <SectionTitle>🔔 Renovaciones próximas</SectionTitle>
                                    <Link 
                                        href={formatLink(`/admin/${tenantSlug}/subscriptions`)}
                                        preserveScroll
                                        className="text-sm font-semibold text-blue-600 hover:text-blue-700"
                                    >
                                        Ver todas →
                                    </Link>
                                </div>

                                <div className="rounded-xl border border-slate-200 bg-slate-50 p-4">
                                    <div className="flex items-center justify-between">
                                        <p className="text-sm font-semibold text-slate-800">
                                            Próximas renovaciones
                                        </p>
                                        <span className="rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-bold text-emerald-700">
                                            Al día
                                        </span>
                                    </div>
                                    <p className="mt-2 text-sm text-slate-500">
                                        No hay renovaciones pendientes en este momento.
                                    </p>
                                </div>
                            </div>

                            <Link 
                                href={formatLink(`/admin/${tenantSlug}/subscriptions`)}
                                preserveScroll
                                className="mt-5 block w-full rounded-xl border border-slate-200 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50 transition"
                            >
                                Ver planes y membresías activas
                            </Link>
                        </article>

                        {/* Uso de beneficios clínicos */}
                        <article className="rounded-2xl border border-slate-200 bg-white p-5 shadow-2xs flex flex-col justify-between">
                            <div>
                                <div className="mb-5 flex items-center justify-between">
                                    <SectionTitle>
                                        <HeartPulse size={18} className="text-blue-600"/>
                                        Uso de beneficios clínicos
                                    </SectionTitle>
                                    <span className="text-xs font-semibold text-slate-500">
                                        {totalUsed} / {totalGranted} utilizados ({usagePercent}%)
                                    </span>
                                </div>

                                <div className="mb-4 h-2 overflow-hidden rounded-full bg-slate-100">
                                    <div 
                                        className="h-full rounded-full bg-gradient-to-r from-blue-500 to-cyan-400 transition-all duration-500"
                                        style={{ width: `${Math.max(usagePercent, 8)}%` }}
                                    />
                                </div>

                                <div className="flex flex-wrap gap-2">
                                    {["Consultas clínicas", "Vacunación", "Kit de bienvenida", "Desparasitaciones"].map((benefit) => (
                                        <span 
                                            key={benefit}
                                            className="rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700"
                                        >
                                            {benefit}
                                        </span>
                                    ))}
                                </div>
                            </div>

                            <Link 
                                href={formatLink(redeemUrl)}
                                preserveScroll
                                className="mt-6 flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 py-3 text-sm font-bold text-white transition hover:bg-blue-700 shadow-xs"
                            >
                                <QrCode size={17}/>
                                Abrir terminal de canje
                            </Link>
                        </article>
                    </section>

                    {/* 5. OPORTUNIDAD DE FIDELIZACIÓN */}
                    <section className="flex flex-col justify-between gap-4 rounded-2xl border border-teal-200 bg-gradient-to-r from-white to-teal-50 p-5 lg:flex-row lg:items-center shadow-2xs">
                        <div className="max-w-3xl">
                            <div className="mb-2 flex items-center gap-2">
                                <Sparkles size={19} className="text-teal-600"/>
                                <h2 className="font-bold text-slate-900 text-sm">
                                    Oportunidad de fidelización
                                </h2>
                                <span className="rounded-full bg-teal-100 px-2 py-0.5 text-[10px] font-bold text-teal-800">
                                    {recommendation.badge || 'Recomendación'}
                                </span>
                            </div>
                            <p className="text-xs leading-5 text-slate-600 font-normal">
                                {recommendation.title || 'Identifica clientes que podrían aprovechar sus beneficios y programa un seguimiento personalizado.'}
                            </p>
                        </div>

                        <div className="flex flex-wrap items-center gap-2 shrink-0">
                            <Link 
                                href={formatLink(recommendation.pet_url || `/admin/${tenantSlug}/pets`)}
                                preserveScroll
                                className="inline-flex items-center gap-1.5 rounded-xl bg-blue-600 px-4 py-2.5 text-xs font-bold text-white hover:bg-blue-700 shadow-xs transition"
                            >
                                <Eye size={15} />
                                Ver paciente
                            </Link>

                            {recommendation.whatsapp_url && (
                                <a 
                                    href={recommendation.whatsapp_url}
                                    target="_blank"
                                    rel="noreferrer"
                                    className="inline-flex items-center gap-1.5 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 shadow-2xs transition"
                                >
                                    <MessageSquare size={15} className="text-emerald-600" />
                                    Contactar
                                </a>
                            )}
                        </div>
                    </section>

                </div>

                {/* =========================================================
                     BARRA LATERAL DERECHA: ASISTENTE IA (DEDICADO)
                     ========================================================= */}
                <aside className="w-full 2xl:w-80 shrink-0 sticky top-20">
                    <div className="rounded-2xl border border-slate-200 bg-white p-4 shadow-2xs flex flex-col justify-between min-h-[580px]">

                        <div>
                            {/* Cabecera IA */}
                            <div className="flex items-center justify-between pb-3 border-b border-slate-100">
                                <div className="flex items-center gap-2">
                                    <div className="rounded-lg bg-blue-600 p-2 text-white">
                                        <BrainCircuit size={19}/>
                                    </div>
                                    <h2 className="font-bold text-sm text-slate-900">Asistente IA</h2>
                                </div>
                                <span className="rounded-full bg-violet-100 px-2 py-0.5 text-[10px] font-bold text-violet-700">
                                    BETA
                                </span>
                            </div>

                            {/* Hero Card Asistente */}
                            <div className="my-6 text-center">
                                <div className="mx-auto mb-3 flex h-20 w-20 items-center justify-center rounded-3xl bg-gradient-to-br from-cyan-100 to-blue-100 shadow-2xs">
                                    <BrainCircuit size={40} className="text-blue-600"/>
                                </div>
                                <h3 className="font-bold text-sm text-slate-900">Hola, soy tu asistente</h3>
                                <p className="mt-1 text-xs leading-5 text-slate-500 max-w-[240px] mx-auto">
                                    Puedo ayudarte a consultar información y gestionar tus tareas.
                                </p>
                            </div>

                            {/* Sugerencias Rápidas */}
                            <div className="space-y-2">
                                {[
                                    "Consultar planes y coberturas",
                                    "Resolver dudas de afiliación",
                                    "Analizar oportunidades comerciales",
                                    "Preparar mensajes para clientes",
                                ].map((suggestion) => (
                                    <button 
                                        key={suggestion}
                                        type="button"
                                        onClick={() => handlePromptClick(suggestion)}
                                        className="flex w-full items-center gap-2.5 rounded-xl border border-slate-200/80 p-2.5 text-left text-xs transition hover:border-blue-300 hover:bg-blue-50/50 shadow-2xs group"
                                    >
                                        <MessageCircle size={16} className="shrink-0 text-blue-600"/>
                                        <span className="flex-1 font-medium text-slate-700 leading-tight">{suggestion}</span>
                                        <ChevronRight size={15} className="text-slate-400 group-hover:translate-x-0.5 transition"/>
                                    </button>
                                ))}
                            </div>

                            {/* Historial de Respuestas del Chat */}
                            {chatMessages.length > 0 && (
                                <div className="space-y-2 max-h-36 overflow-y-auto mt-3 p-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                                    {chatMessages.map((msg, i) => (
                                        <div 
                                            key={i} 
                                            className={`p-2 rounded-lg leading-relaxed ${
                                                msg.role === 'user' 
                                                    ? 'bg-blue-600 text-white font-medium ml-auto max-w-[85%]' 
                                                    : 'bg-white text-slate-700 border border-slate-200 mr-auto max-w-[95%] shadow-2xs'
                                            }`}
                                        >
                                            {msg.text}
                                        </div>
                                    ))}
                                </div>
                            )}
                        </div>

                        {/* Input de Consulta */}
                        <div className="pt-3 border-t border-slate-100 mt-4">
                            <form onSubmit={handleSendChat} className="flex gap-2">
                                <input
                                    type="text"
                                    value={chatInput}
                                    onChange={(e) => setChatInput(e.target.value)}
                                    placeholder="Escribe tu consulta..."
                                    className="min-w-0 flex-1 rounded-xl border border-slate-200 px-3 py-2 text-xs outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition shadow-2xs"
                                />
                                <button 
                                    type="submit"
                                    aria-label="Enviar consulta"
                                    className="rounded-xl bg-blue-600 px-3 text-white hover:bg-blue-700 flex items-center justify-center shadow-xs transition"
                                >
                                    <Send size={15}/>
                                </button>
                            </form>

                            <p className="mt-2.5 text-[10.5px] text-slate-400 flex items-center gap-1.5">
                                <span className="text-emerald-500">●</span>
                                Asistente de demostración
                            </p>
                        </div>

                    </div>
                </aside>

            </div>
        </VetAdminLayout>
    );
}
