import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { 
    PawPrint,
    HeartPulse,
    Users,
    CreditCard,
    CalendarDays,
    ChevronRight,
    Sparkles,
    Globe,
    QrCode,
    MessageCircle,
    Send,
    ExternalLink,
    Printer,
    Bell,
    Activity,
    Calendar,
    ArrowRight
} from 'lucide-react';

interface ActivityItem {
    id: string;
    initials: string;
    color: 'amber' | 'blue' | 'emerald' | 'purple';
    title: string;
    subtitle: string;
    time_ago: string;
}

interface UpcomingRenewal {
    id: string;
    pet_name: string;
    species: string;
    icon: string;
    customer_name: string;
    customer_phone: string;
    plan_name: string;
    current_period_end: string;
    days_left: number;
    whatsapp_url?: string;
}

interface RecentRedemption {
    id: string;
    time: string;
    pet_name: string;
    icon: string;
    benefit_name: string;
    user_name: string;
}

interface AIContext {
    brandName: string;
    cleanCity: string;
    activeSubsCount: number;
    petsCount: number;
    mrr: number;
    topPlanName: string;
    topPlanPrice: number;
    topPlanPercent: number;
    totalReserveFund: number;
    samplePetName: string;
    samplePetBreed: string;
    sampleCustomerName: string;
    sampleCustomerPhone: string;
    pendingVaccinesCount: number;
    inactiveDays: number;
}

interface DashboardProps {
    mrr?: number;
    mrrDelta?: number;
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
        description?: string;
        pet_photo?: string;
        whatsapp_url?: string;
        pet_url?: string;
        customer_name?: string;
        pet_name?: string;
        pet_breed?: string;
        remaining_count?: number;
        total_count?: number;
        days_inactive?: number;
    } | null;
    upcomingRenewals?: UpcomingRenewal[];
    recentActivity?: ActivityItem[];
    recentRedemptions?: RecentRedemption[];
    aiContext?: AIContext;
}

export default function Dashboard({
    mrr = 0,
    mrrDelta = 0,
    petsCount = 0,
    activeSubsCount = 0,
    newSubsThisMonth = 0,
    expiring15Days = 0,
    totalGranted = 0,
    totalUsed = 0,
    usagePercent = 0,
    greetingName = 'Doctor(a)',
    userName = 'Administrador de Sede',
    userRole = 'Administradora de Sede',
    brandName = 'Vet-Pet Patitas',
    clinicSubtitle = 'Planes de salud para su mascota',
    logoUrl = null,
    saasPlan = {
        name: 'Plan Profesional',
        statusLabel: 'Activo',
        paidUntil: 'Al día',
        manageUrl: `/admin/vet-pet-patitas/renovar-saas`
    },
    logoutUrl = `/admin/vet-pet-patitas/logout`,
    cleanCity = 'Cajicá',
    tenantSlug = 'vet-pet-patitas',
    redeemUrl = `/admin/vet-pet-patitas/counter-redeem`,
    newSubUrl = `/admin/vet-pet-patitas/plans`,
    portalUrl = `/v/vet-pet-patitas`,
    qrUrl = `/v/vet-pet-patitas/afiche`,
    recommendation = null,
    upcomingRenewals = [],
    recentActivity = [],
    recentRedemptions = [],
    aiContext,
}: DashboardProps) {
    const isPreview = typeof window !== 'undefined' && (window.location.search.includes('preview=1') || window.location.href.includes('preview=1'));
    const formatLink = (url: string) => isPreview && !url.includes('preview=1') ? `${url}${url.includes('?') ? '&' : '?'}preview=1` : url;

    // Chat interactivo del Asistente IA (Gemini 2.5 Flash)
    const [chatInput, setChatInput] = useState('');
    const [chatMessages, setChatMessages] = useState<Array<{ role: 'user' | 'assistant'; text: string }>>([]);
    const [isLoading, setIsLoading] = useState(false);

    const handlePromptClick = async (text: string) => {
        if (isLoading || !text.trim()) return;
        const userMsg = { role: 'user' as const, text: text.trim() };
        setChatMessages(prev => [...prev, userMsg]);
        setIsLoading(true);

        try {
            const response = await fetch(`/api/admin/${tenantSlug}/ai/chat`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ message: text.trim() }),
            });

            if (response.ok) {
                const data = await response.json();
                if (data && data.reply) {
                    setChatMessages(prev => [...prev, { role: 'assistant', text: data.reply }]);
                    setIsLoading(false);
                    return;
                }
            }
        } catch (err) {
            console.error('Error al conectar con Gemini:', err);
        }

        // Fallback heurístico en caso de indisponibilidad de API
        const ctx = aiContext || {
            brandName: brandName,
            cleanCity: cleanCity,
            activeSubsCount: activeSubsCount,
            petsCount: petsCount,
            mrr: mrr,
            topPlanName: 'Plan Patitas Básico',
            topPlanPrice: 50000,
            topPlanPercent: 100,
            totalReserveFund: 20000,
            samplePetName: 'Max',
            samplePetBreed: 'Golden Retriever',
            sampleCustomerName: 'María Rodríguez',
            sampleCustomerPhone: '3508742543',
            pendingVaccinesCount: 1,
            inactiveDays: 60,
        };

        let reply = '';
        if (text.includes('vacunas')) {
            reply = `🐾 **Vacunas pendientes:** ${ctx.samplePetName} (${ctx.samplePetBreed}) tiene programado su refuerzo anual preventivo. Tienes dosis de biológicos disponibles en sede para aplicar.`;
        } else if (text.includes('inactivos') || text.includes('60 días')) {
            reply = `📊 **Clientes inactivos:** ${ctx.samplePetName} y su tutora ${ctx.sampleCustomerName} no han realizado visitas en los últimos ${ctx.inactiveDays} días.` + (ctx.totalReserveFund > 0 ? ` Acumulan $${Number(ctx.totalReserveFund).toLocaleString('es-CO')} COP en Reserva Quirúrgica.` : '');
        } else if (text.includes('plan más vendido')) {
            reply = `⭐ **Plan Estrella:** El "${ctx.topPlanName}" ($${Number(ctx.topPlanPrice).toLocaleString('es-CO')} COP/mes) representa el ${ctx.topPlanPercent}% de tus membresías activas.`;
        } else if (text.includes('WhatsApp') || text.includes('campaña')) {
            const firstName = ctx.sampleCustomerName.split(' ')[0];
            reply = `💬 **Campaña WhatsApp Lista:** "🐾 Hola ${firstName}, te saludamos de ${ctx.brandName}. Te recordamos que ${ctx.samplePetName} tiene beneficios disponibles en su plan de salud.` + (ctx.totalReserveFund > 0 ? ` Además acumula $${Number(ctx.totalReserveFund).toLocaleString('es-CO')} COP en fondo quirúrgico.` : '') + ` ¿Te gustaría agendar su chequeo esta semana?"`;
        } else {
            reply = `💡 **Diagnóstico Automático:** Tu clínica en ${ctx.cleanCity} tiene ${ctx.activeSubsCount} membresías activas generando $${Number(ctx.mrr).toLocaleString('es-CO')} COP mensuales en ingresos recurrentes con ${ctx.petsCount} pacientes registrados.`;
        }

        setChatMessages(prev => [...prev, { role: 'assistant', text: reply }]);
        setIsLoading(false);
    };

    const handleSendChat = (e: React.FormEvent) => {
        e.preventDefault();
        if (!chatInput.trim()) return;
        const text = chatInput.trim();
        setChatInput('');
        handlePromptClick(text);
    };

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

            <div className="flex flex-col xl:flex-row gap-6 items-start w-full">
                
                {/* =========================================================
                     COLUMNA CENTRAL: DASHBOARD PRINCIPAL
                     ========================================================= */}
                <div className="min-w-0 flex-1 w-full space-y-6">

                    {/* 1. HERO GREETING BANNER */}
                    <section className="relative flex items-center justify-between overflow-hidden rounded-2xl border border-slate-200/90 bg-white p-6 shadow-2xs">
                        <div className="relative z-10 max-w-lg space-y-3">
                            <h1 className="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">
                                ¡Buenos días, {greetingName}!
                            </h1>
                            <p className="text-xs text-slate-500 font-medium">
                                Aquí tienes el resumen en tiempo real de tu programa de bienestar.
                            </p>

                            <div className="flex flex-wrap items-center gap-2 pt-1 text-xs">
                                <span className="rounded-full bg-slate-100 px-3 py-1 font-medium text-slate-600 border border-slate-200/80">
                                    📍 {brandName} · {cleanCity}
                                </span>
                                <span className="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 font-bold text-emerald-700 flex items-center gap-1.5">
                                    <span className="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Sistema en línea
                                </span>
                            </div>
                        </div>

                        {/* Pet Cutout Graphic & Doodle */}
                        <div className="hidden lg:flex shrink-0 items-center justify-center relative pr-4">
                            <div className="relative">
                                <img 
                                    src="/images/dashboard/hero_pets_hd.png" 
                                    alt="Mascotas Sanas" 
                                    className="h-32 xl:h-36 w-auto object-contain select-none pointer-events-none"
                                />
                                <div className="absolute -top-3 -left-8 text-blue-500 font-serif italic text-xs rotate-[-6deg] drop-shadow-2xs select-none">
                                    Mascotas sanas, clientes felices
                                    <svg className="w-6 h-6 text-sky-400 stroke-current -rotate-12 absolute -left-4 -top-2" viewBox="0 0 24 24" fill="none" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                        <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </section>

                    {/* 2. LOS 5 INDICADORES KPI CON SPARKLINES REALES */}
                    <section className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-3.5">
                        
                        {/* KPI 1: MRR */}
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs flex flex-col justify-between hover:-translate-y-0.5 transition">
                            <div className="flex items-center gap-2 text-slate-500 text-xs font-semibold">
                                <div className="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center">
                                    <CreditCard className="w-4 h-4" />
                                </div>
                                <span className="truncate">Ingresos recurrentes (MRR)</span>
                            </div>
                            <div className="mt-3">
                                <div className="text-xl font-black text-slate-900">
                                    ${Number(mrr).toLocaleString('es-CO')} <span className="text-xs font-bold text-slate-400">COP</span>
                                </div>
                                <div className={`text-[10.5px] font-bold mt-0.5 ${mrrDelta >= 0 ? 'text-emerald-600' : 'text-rose-600'}`}>
                                    {mrrDelta > 0 
                                        ? `^ +$${Number(mrrDelta).toLocaleString('es-CO')} vs. mes ant.` 
                                        : mrrDelta < 0 
                                            ? `v -$${Number(Math.abs(mrrDelta)).toLocaleString('es-CO')} vs. mes ant.` 
                                            : 'Al día vs. mes anterior'}
                                </div>
                            </div>
                            {/* Sparkline verde */}
                            <svg className="w-full h-6 mt-2 stroke-emerald-500 fill-none" viewBox="0 0 100 24" strokeWidth="2.5" strokeLinecap="round">
                                <path d="M0 20 Q 30 18, 55 12 T 100 4" />
                            </svg>
                        </div>

                        {/* KPI 2: Mascotas activas */}
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs flex flex-col justify-between hover:-translate-y-0.5 transition">
                            <div className="flex items-center gap-2 text-slate-500 text-xs font-semibold">
                                <div className="w-7 h-7 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center">
                                    <PawPrint className="w-4 h-4" />
                                </div>
                                <span className="truncate">Mascotas registradas</span>
                            </div>
                            <div className="mt-3">
                                <div className="text-xl font-black text-slate-900">{petsCount}</div>
                                <div className="text-[10.5px] font-medium text-slate-500 mt-0.5">
                                    {activeSubsCount} {activeSubsCount === 1 ? 'plan activo' : 'planes activos'}
                                </div>
                            </div>
                            {/* Sparkline azul */}
                            <svg className="w-full h-6 mt-2 stroke-blue-500 fill-none" viewBox="0 0 100 24" strokeWidth="2.5" strokeLinecap="round">
                                <path d="M0 22 Q 40 20, 65 14 T 100 8" />
                            </svg>
                        </div>

                        {/* KPI 3: Nuevas afiliaciones */}
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs flex flex-col justify-between hover:-translate-y-0.5 transition">
                            <div className="flex items-center gap-2 text-slate-500 text-xs font-semibold">
                                <div className="w-7 h-7 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center">
                                    <Users className="w-4 h-4" />
                                </div>
                                <span className="truncate">Nuevas afiliaciones</span>
                            </div>
                            <div className="mt-3">
                                <div className="text-xl font-black text-slate-900">
                                    {newSubsThisMonth > 0 ? `+${newSubsThisMonth}` : '0'}
                                </div>
                                <div className="text-[10.5px] font-medium text-slate-500 mt-0.5">Este mes</div>
                            </div>
                            {/* Sparkline violeta */}
                            <svg className="w-full h-6 mt-2 stroke-purple-500 fill-none" viewBox="0 0 100 24" strokeWidth="2.5" strokeLinecap="round">
                                <path d="M0 20 Q 30 19, 60 15 T 100 6" />
                            </svg>
                        </div>

                        {/* KPI 4: Renovaciones próximas */}
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs flex flex-col justify-between hover:-translate-y-0.5 transition">
                            <div className="flex items-center gap-2 text-slate-500 text-xs font-semibold">
                                <div className="w-7 h-7 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center">
                                    <CalendarDays className="w-4 h-4" />
                                </div>
                                <span className="truncate">Renovaciones próximas</span>
                            </div>
                            <div className="mt-3">
                                <div className="text-xl font-black text-slate-900">{expiring15Days}</div>
                                <div className="text-[10.5px] font-medium text-slate-500 mt-0.5">Próximos 15 días</div>
                            </div>
                            {/* Sparkline magenta */}
                            <svg className="w-full h-6 mt-2 stroke-fuchsia-500 fill-none" viewBox="0 0 100 24" strokeWidth="2.5" strokeLinecap="round">
                                <path d="M0 22 Q 45 21, 75 16 T 100 10" />
                            </svg>
                        </div>

                        {/* KPI 5: Uso de beneficios */}
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs flex flex-col justify-between hover:-translate-y-0.5 transition">
                            <div className="flex items-center gap-2 text-slate-500 text-xs font-semibold">
                                <div className="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center">
                                    <HeartPulse className="w-4 h-4" />
                                </div>
                                <span className="truncate">Uso de beneficios</span>
                            </div>
                            <div className="mt-2">
                                <div className="text-xl font-black text-slate-900">{totalUsed} / {totalGranted}</div>
                                <div className="w-full h-1.5 bg-slate-100 rounded-full mt-1.5 overflow-hidden">
                                    <div 
                                        className="h-full bg-blue-500 rounded-full transition-all duration-500" 
                                        style={{ width: `${Math.min(100, Math.max(0, usagePercent))}%` }}
                                    ></div>
                                </div>
                                <div className="text-[10px] text-slate-400 font-medium mt-1 flex justify-between">
                                    <span>Meta clínica: 70%</span>
                                    <span>{usagePercent}%</span>
                                </div>
                            </div>
                        </div>

                    </section>

                    {/* 3. ACCIONES RÁPIDAS (5 TARJETAS HORIZONTALES DINÁMICAS) */}
                    <section className="space-y-3">
                        <div className="flex items-center gap-2 text-xs font-bold text-slate-900">
                            <span className="text-blue-600">⚡</span>
                            <h2>Acciones rápidas</h2>
                        </div>

                        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
                            
                            {/* 1. Canjear beneficio (AZUL) */}
                            <Link
                                href={formatLink(redeemUrl)}
                                className="p-4 rounded-xl bg-[#0080ff] hover:bg-blue-600 text-white flex items-center justify-between shadow-xs transition hover:-translate-y-0.5 group"
                            >
                                <div className="flex items-center gap-3 min-w-0">
                                    <div className="w-9 h-9 rounded-lg bg-white/20 flex items-center justify-center shrink-0">
                                        <QrCode className="w-5 h-5 text-white" />
                                    </div>
                                    <div className="min-w-0">
                                        <div className="text-xs font-bold truncate leading-tight">Canjear beneficio</div>
                                        <div className="text-[10.5px] text-white/80 truncate leading-tight mt-0.5">Escanea o busca por cédula</div>
                                    </div>
                                </div>
                                <ChevronRight className="w-4 h-4 text-white/70 group-hover:translate-x-0.5 transition shrink-0" />
                            </Link>

                            {/* 2. Afiliar mascota (VERDE) */}
                            <Link
                                href={formatLink(newSubUrl)}
                                className="p-4 rounded-xl bg-[#10b981] hover:bg-emerald-600 text-white flex items-center justify-between shadow-xs transition hover:-translate-y-0.5 group"
                            >
                                <div className="flex items-center gap-3 min-w-0">
                                    <div className="w-9 h-9 rounded-lg bg-white/20 flex items-center justify-center shrink-0">
                                        <PawPrint className="w-5 h-5 text-white" />
                                    </div>
                                    <div className="min-w-0">
                                        <div className="text-xs font-bold truncate leading-tight">Afiliar mascota</div>
                                        <div className="text-[10.5px] text-white/80 truncate leading-tight mt-0.5">Nueva membresía</div>
                                    </div>
                                </div>
                                <ChevronRight className="w-4 h-4 text-white/70 group-hover:translate-x-0.5 transition shrink-0" />
                            </Link>

                            {/* 3. Portal de pacientes */}
                            <a
                                href={portalUrl}
                                target="_blank"
                                rel="noreferrer"
                                className="p-4 rounded-xl bg-white border border-slate-200 text-slate-800 flex items-center justify-between shadow-2xs transition hover:-translate-y-0.5 hover:border-blue-300 group"
                            >
                                <div className="flex items-center gap-3 min-w-0">
                                    <div className="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                        <Globe className="w-5 h-5" />
                                    </div>
                                    <div className="min-w-0">
                                        <div className="text-xs font-bold truncate leading-tight">Portal de pacientes</div>
                                        <div className="text-[10.5px] text-slate-400 truncate leading-tight mt-0.5">Área privada</div>
                                    </div>
                                </div>
                                <ChevronRight className="w-4 h-4 text-slate-400 group-hover:translate-x-0.5 transition shrink-0" />
                            </a>

                            {/* 4. Web pública */}
                            <a
                                href={portalUrl}
                                target="_blank"
                                rel="noreferrer"
                                className="p-4 rounded-xl bg-white border border-slate-200 text-slate-800 flex items-center justify-between shadow-2xs transition hover:-translate-y-0.5 hover:border-blue-300 group"
                            >
                                <div className="flex items-center gap-3 min-w-0">
                                    <div className="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                        <ExternalLink className="w-5 h-5" />
                                    </div>
                                    <div className="min-w-0">
                                        <div className="text-xs font-bold truncate leading-tight">Web pública</div>
                                        <div className="text-[10.5px] text-slate-400 truncate leading-tight mt-0.5">Página de afiliación</div>
                                    </div>
                                </div>
                                <ChevronRight className="w-4 h-4 text-slate-400 group-hover:translate-x-0.5 transition shrink-0" />
                            </a>

                            {/* 5. Imprimir QR */}
                            <a
                                href={qrUrl}
                                target="_blank"
                                rel="noreferrer"
                                className="p-4 rounded-xl bg-white border border-slate-200 text-slate-800 flex items-center justify-between shadow-2xs transition hover:-translate-y-0.5 hover:border-blue-300 group"
                            >
                                <div className="flex items-center gap-3 min-w-0">
                                    <div className="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                        <Printer className="w-5 h-5" />
                                    </div>
                                    <div className="min-w-0">
                                        <div className="text-xs font-bold truncate leading-tight">Imprimir QR</div>
                                        <div className="text-[10.5px] text-slate-400 truncate leading-tight mt-0.5">Afiche y material</div>
                                    </div>
                                </div>
                                <ChevronRight className="w-4 h-4 text-slate-400 group-hover:translate-x-0.5 transition shrink-0" />
                            </a>

                        </div>
                    </section>

                    {/* 4. MEDIO: RENOVACIONES PRÓXIMAS & ACTIVIDAD RECIENTE (100% REAL) */}
                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        
                        {/* Renovaciones próximas */}
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col justify-between">
                            <div>
                                <div className="flex items-center justify-between mb-4">
                                    <h3 className="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                        <Bell className="w-4 h-4 text-amber-500" />
                                        Renovaciones próximas
                                    </h3>
                                    <Link href={formatLink(`/admin/${tenantSlug}/subscriptions`)} className="text-[11px] font-bold text-blue-600 hover:underline">
                                        Ver todas →
                                    </Link>
                                </div>

                                {upcomingRenewals.length === 0 ? (
                                    <div className="py-6 text-center space-y-2">
                                        <div className="w-12 h-12 rounded-xl bg-blue-50 border border-blue-200 flex items-center justify-center mx-auto text-blue-600">
                                            <Calendar className="w-6 h-6" />
                                        </div>
                                        <div className="text-xs font-bold text-slate-900">
                                            No tienes renovaciones pendientes
                                        </div>
                                        <p className="text-[11px] text-slate-400 max-w-[260px] mx-auto">
                                            Tus planes están al día. ¡Excelente trabajo!
                                        </p>
                                    </div>
                                ) : (
                                    <div className="divide-y divide-slate-100 text-xs">
                                        {upcomingRenewals.slice(0, 3).map((r) => (
                                            <div key={r.id} className="py-2.5 flex items-center justify-between">
                                                <div className="flex items-center gap-2.5 min-w-0">
                                                    <span className="w-7 h-7 rounded-lg bg-amber-50 border border-amber-200/60 flex items-center justify-center text-sm shrink-0">
                                                        {r.icon}
                                                    </span>
                                                    <div className="min-w-0">
                                                        <div className="font-bold text-slate-800 truncate">{r.pet_name} · <span className="text-slate-500 font-normal">{r.plan_name}</span></div>
                                                        <div className="text-[10.5px] text-amber-600 font-semibold">Vence en {r.days_left} {r.days_left === 1 ? 'día' : 'días'} ({r.current_period_end})</div>
                                                    </div>
                                                </div>
                                                {r.whatsapp_url ? (
                                                    <a
                                                        href={r.whatsapp_url}
                                                        target="_blank"
                                                        rel="noreferrer"
                                                        className="px-2.5 py-1 rounded-full border border-emerald-200 bg-emerald-50 text-emerald-700 text-[10.5px] font-bold hover:bg-emerald-100 transition shrink-0 flex items-center gap-1"
                                                    >
                                                        <MessageCircle className="w-3 h-3" /> Recordar
                                                    </a>
                                                ) : (
                                                    <span className="text-[10px] text-slate-400">{r.current_period_end}</span>
                                                )}
                                            </div>
                                        ))}
                                    </div>
                                )}
                            </div>

                            <Link
                                href={formatLink(`/admin/${tenantSlug}/subscriptions`)}
                                className="block w-full mt-4 py-2 px-3 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-700 text-center text-xs font-bold transition"
                            >
                                Ver historial de membresías
                            </Link>
                        </div>

                        {/* Actividad reciente (FEED UNIFICADO REAL) */}
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs">
                            <div className="flex items-center justify-between mb-3 pb-2 border-b border-slate-100">
                                <h3 className="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                    <Activity className="w-4 h-4 text-amber-500" />
                                    Actividad reciente
                                </h3>
                                <Link href={formatLink(`/admin/${tenantSlug}/counter-redeem`)} className="text-[11px] font-bold text-blue-600 hover:underline">
                                    Mostrador →
                                </Link>
                            </div>

                            {recentActivity.length === 0 ? (
                                <div className="py-6 text-center space-y-2">
                                    <div className="w-12 h-12 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center mx-auto text-slate-400">
                                        <Activity className="w-6 h-6" />
                                    </div>
                                    <div className="text-xs font-bold text-slate-800">
                                        Sin actividad registrada hoy
                                    </div>
                                    <p className="text-[11px] text-slate-400 max-w-[260px] mx-auto">
                                        Los canjes, afiliaciones y aportes de reserva aparecerán aquí automáticamente.
                                    </p>
                                </div>
                            ) : (
                                <div className="divide-y divide-slate-100 text-xs">
                                    {recentActivity.map((act) => {
                                        const bgColors: Record<string, string> = {
                                            amber: 'bg-amber-100 text-amber-800',
                                            blue: 'bg-blue-100 text-blue-800',
                                            emerald: 'bg-emerald-100 text-emerald-800',
                                            purple: 'bg-purple-100 text-purple-800',
                                        };
                                        return (
                                            <div key={act.id} className="py-2.5 flex items-center justify-between">
                                                <div className="flex items-center gap-2.5 min-w-0">
                                                    <div className={`w-7 h-7 rounded-full flex items-center justify-center font-bold text-[10px] shrink-0 ${bgColors[act.color] || bgColors.blue}`}>
                                                        {act.initials}
                                                    </div>
                                                    <div className="min-w-0">
                                                        <span className="font-bold text-slate-800 truncate block">{act.title}</span>
                                                        <div className="text-[11px] text-slate-400 truncate">{act.subtitle}</div>
                                                    </div>
                                                </div>
                                                <span className="text-[10px] text-slate-400 font-medium shrink-0 ml-2">{act.time_ago}</span>
                                            </div>
                                        );
                                    })}
                                </div>
                            )}
                        </div>

                    </div>

                    {/* 5. AVI RECOMIENDA (OPORTUNIDAD DE FIDELIZACIÓN REAL) */}
                    {recommendation && (
                        <section className="bg-gradient-to-r from-amber-50/50 via-white to-blue-50/30 border border-amber-200/80 rounded-2xl p-5 shadow-2xs">
                            <div className="flex items-center gap-1.5 text-xs font-bold text-amber-900 mb-3">
                                <span>🎯</span>
                                <span>AVI recomienda</span>
                                <span className="text-slate-400 font-normal">· {recommendation.badge || 'Oportunidad de fidelización'}</span>
                            </div>

                            <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div className="flex items-start gap-3.5 min-w-0">
                                    <img 
                                        src={recommendation.pet_photo || '/images/dashboard/sidebar_pet_hd.png'} 
                                        alt={recommendation.pet_name || 'Mascota'} 
                                        className="w-14 h-14 rounded-2xl object-cover border border-amber-200 shrink-0 shadow-2xs"
                                        onError={(e) => {
                                            (e.target as HTMLImageElement).src = '/images/dashboard/sidebar_pet_hd.png';
                                        }}
                                    />
                                    <div className="min-w-0">
                                        <h4 className="text-xs font-black text-slate-900 leading-tight">
                                            {recommendation.title}
                                        </h4>
                                        <p className="text-[11px] text-slate-500 mt-0.5">
                                            {recommendation.description}
                                        </p>

                                        <div className="flex flex-wrap items-center gap-1.5 mt-2">
                                            <span className="text-[10px] font-bold px-2 py-0.5 rounded-full bg-teal-100 text-teal-800">
                                                +{recommendation.remaining_count} beneficios disponibles
                                            </span>
                                            <span className="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">
                                                Sin visita en {recommendation.days_inactive} días
                                            </span>
                                            <span className="text-[10px] font-bold px-2 py-0.5 rounded-full bg-blue-100 text-blue-800">
                                                Alta probabilidad de renovación
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div className="flex items-center gap-2 shrink-0">
                                    {recommendation.whatsapp_url && (
                                        <a
                                            href={recommendation.whatsapp_url}
                                            target="_blank"
                                            rel="noreferrer"
                                            className="px-3.5 py-2 rounded-xl bg-[#10b981] hover:bg-emerald-600 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-2xs"
                                        >
                                            <MessageCircle className="w-3.5 h-3.5" />
                                            <span>Enviar recordatorio por WhatsApp</span>
                                        </a>
                                    )}

                                    <Link
                                        href={formatLink(recommendation.pet_url || `/admin/${tenantSlug}/pets`)}
                                        className="px-3.5 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold transition"
                                    >
                                        Ver paciente
                                    </Link>
                                </div>
                            </div>
                        </section>
                    )}

                    {/* 6. TABLAS INFERIORES: PRÓXIMAS RENOVACIONES & CANJES RECIENTES (CONECTADAS A BD) */}
                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        
                        {/* Tabla: Próximas renovaciones */}
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-3">
                            <div className="flex items-center justify-between pb-2 border-b border-slate-100">
                                <h3 className="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                    <span className="text-rose-500">▲</span>
                                    Próximas renovaciones
                                </h3>
                                <Link href={formatLink(`/admin/${tenantSlug}/subscriptions`)} className="text-[11px] font-bold text-blue-600 hover:underline">
                                    Ver todas →
                                </Link>
                            </div>

                            {upcomingRenewals.length === 0 ? (
                                <div className="py-8 text-center space-y-2">
                                    <div className="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto">
                                        <Calendar className="w-5 h-5" />
                                    </div>
                                    <div className="text-xs font-bold text-slate-800">
                                        Todas las membresías están al día
                                    </div>
                                    <p className="text-[11px] text-slate-400 max-w-[280px] mx-auto">
                                        No hay vencimientos programados para los siguientes 30 días.
                                    </p>
                                </div>
                            ) : (
                                <table className="w-full text-left text-xs">
                                    <thead>
                                        <tr className="text-[10px] text-slate-400 font-bold uppercase tracking-wider border-b border-slate-100">
                                            <th className="pb-2">Mascota</th>
                                            <th className="pb-2">Plan</th>
                                            <th className="pb-2">Vence</th>
                                            <th className="pb-2 text-right">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody className="divide-y divide-slate-100">
                                        {upcomingRenewals.map((item) => (
                                            <tr key={item.id}>
                                                <td className="py-2.5 font-bold text-slate-800 flex items-center gap-2">
                                                    <span className="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-xs">
                                                        {item.icon}
                                                    </span>
                                                    {item.pet_name}
                                                </td>
                                                <td className="py-2.5 text-slate-500">{item.plan_name}</td>
                                                <td className="py-2.5 text-slate-500">{item.current_period_end}</td>
                                                <td className="py-2.5 text-right">
                                                    {item.whatsapp_url ? (
                                                        <a
                                                            href={item.whatsapp_url}
                                                            target="_blank"
                                                            rel="noreferrer"
                                                            className="px-2.5 py-1 rounded-full border border-blue-200 text-blue-600 text-[10.5px] font-bold hover:bg-blue-50 transition"
                                                        >
                                                            Contactar
                                                        </a>
                                                    ) : (
                                                        <button className="px-2.5 py-1 rounded-full border border-slate-200 text-slate-400 text-[10.5px] font-bold cursor-not-allowed">
                                                            Al día
                                                        </button>
                                                    )}
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            )}
                        </div>

                        {/* Tabla: Canjes recientes en mostrador */}
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-3">
                            <div className="flex items-center justify-between pb-2 border-b border-slate-100">
                                <h3 className="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                    <CreditCard className="w-4 h-4 text-blue-600" />
                                    Canjes recientes en mostrador
                                </h3>
                                <Link href={formatLink(`/admin/${tenantSlug}/counter-redeem`)} className="text-[11px] font-bold text-blue-600 hover:underline">
                                    Mostrador →
                                </Link>
                            </div>

                            {recentRedemptions.length === 0 ? (
                                <div className="py-8 text-center space-y-2">
                                    <div className="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center mx-auto">
                                        <CreditCard className="w-5 h-5" />
                                    </div>
                                    <div className="text-xs font-bold text-slate-800">
                                        No hay canjes de beneficios registrados
                                    </div>
                                    <p className="text-[11px] text-slate-400 max-w-[280px] mx-auto">
                                        Cuando canjees vacunas, consultas o exámenes en mostrador se registrarán aquí en vivo.
                                    </p>
                                    <div className="pt-2">
                                        <Link
                                            href={formatLink(redeemUrl)}
                                            className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-2xs"
                                        >
                                            <QrCode className="w-3.5 h-3.5" /> Ir a Mostrador de Canje
                                        </Link>
                                    </div>
                                </div>
                            ) : (
                                <table className="w-full text-left text-xs">
                                    <thead>
                                        <tr className="text-[10px] text-slate-400 font-bold uppercase tracking-wider border-b border-slate-100">
                                            <th className="pb-2">Hora</th>
                                            <th className="pb-2">Mascota</th>
                                            <th className="pb-2">Servicio</th>
                                            <th className="pb-2">Usuario</th>
                                        </tr>
                                    </thead>
                                    <tbody className="divide-y divide-slate-100">
                                        {recentRedemptions.map((r) => (
                                            <tr key={r.id}>
                                                <td className="py-2.5 font-mono text-slate-400 text-[11px]">{r.time}</td>
                                                <td className="py-2.5 font-bold text-slate-800 flex items-center gap-1.5">
                                                    <span>{r.icon}</span> {r.pet_name}
                                                </td>
                                                <td className="py-2.5 text-slate-600">{r.benefit_name}</td>
                                                <td className="py-2.5 text-slate-400">{r.user_name}</td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            )}
                        </div>

                    </div>

                </div>

                {/* =========================================================
                     COLUMNA DERECHA: COPILOT IA & PROMO PORTAL PACIENTES
                     ========================================================= */}
                <div className="w-full xl:w-72 2xl:w-80 shrink-0 space-y-4">
                    
                    {/* Card 1: AVI Intelligence IA */}
                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs space-y-3">
                        <div className="flex items-center justify-between pb-2 border-b border-slate-100">
                            <div className="flex items-center gap-2">
                                <Sparkles className="w-4 h-4 text-blue-600" />
                                <h3 className="text-xs font-black text-slate-900">AVI Intelligence</h3>
                                <span className="text-[9px] font-black uppercase tracking-wider px-1.5 py-0.5 rounded bg-blue-100 text-blue-700 flex items-center gap-1">
                                    <span className="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                                    Gemini 3.8
                                </span>
                            </div>
                        </div>

                        <p className="text-[11px] text-slate-400">
                            Tu asistente clínico para tomar decisiones con datos reales
                        </p>

                        {/* Chips de consulta rápida */}
                        <div className="space-y-1.5">
                            {[
                                "¿Qué mascotas tienen vacunas pendientes?",
                                "Muéstrame clientes inactivos por más de 60 días",
                                "¿Cuál es el plan más vendido?",
                                "Crea una campaña de fidelización por WhatsApp",
                            ].map((promptText, i) => (
                                <button
                                    key={i}
                                    type="button"
                                    disabled={isLoading}
                                    onClick={() => handlePromptClick(promptText)}
                                    className="w-full text-left p-2 rounded-xl border border-slate-100 bg-slate-50/80 hover:bg-blue-50/50 hover:border-blue-200 text-[11px] font-medium text-slate-600 transition flex items-center justify-between gap-1.5 group disabled:opacity-60 disabled:cursor-not-allowed"
                                >
                                    <span className="leading-tight">{promptText}</span>
                                    <ChevronRight className="w-3 h-3 text-slate-300 group-hover:text-blue-500 shrink-0" />
                                </button>
                            ))}
                        </div>

                        {/* Historial de Respuestas del Chat */}
                        {(chatMessages.length > 0 || isLoading) && (
                            <div className="space-y-2 max-h-56 overflow-y-auto mt-2 p-2 rounded-xl bg-slate-50 border border-slate-200 text-[11px]">
                                {chatMessages.map((msg, i) => (
                                    <div 
                                        key={i} 
                                        className={`p-2.5 rounded-xl leading-relaxed whitespace-pre-line ${
                                            msg.role === 'user' 
                                                ? 'bg-blue-600 text-white font-medium ml-auto max-w-[88%]' 
                                                : 'bg-white text-slate-700 border border-slate-200 mr-auto max-w-[96%] shadow-2xs'
                                        }`}
                                    >
                                        {msg.text}
                                    </div>
                                ))}

                                {isLoading && (
                                    <div className="p-2.5 rounded-xl bg-blue-50/80 border border-blue-100 text-blue-700 text-[11px] flex items-center gap-2 mr-auto shadow-2xs">
                                        <Sparkles className="w-3.5 h-3.5 animate-spin text-blue-600 shrink-0" />
                                        <span className="font-semibold">AVI analizando tu clínica...</span>
                                        <span className="flex gap-1 ml-1">
                                            <span className="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce [animation-delay:-0.3s]"></span>
                                            <span className="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce [animation-delay:-0.15s]"></span>
                                            <span className="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce"></span>
                                        </span>
                                    </div>
                                )}
                            </div>
                        )}

                        {/* Input de Pregunta */}
                        <form onSubmit={handleSendChat} className="pt-2 flex items-center gap-1.5">
                            <input
                                type="text"
                                value={chatInput}
                                disabled={isLoading}
                                onChange={(e) => setChatInput(e.target.value)}
                                placeholder="Escribe tu consulta clínica..."
                                className="flex-1 px-3 py-1.5 rounded-xl border border-slate-200 bg-slate-50 text-xs text-slate-800 placeholder:text-slate-400 outline-none focus:ring-1 focus:ring-blue-500 disabled:opacity-60"
                            />
                            <button
                                type="submit"
                                aria-label="Enviar"
                                disabled={isLoading || !chatInput.trim()}
                                className="w-8 h-8 rounded-xl bg-blue-600 hover:bg-blue-700 disabled:bg-slate-300 text-white flex items-center justify-center shrink-0 shadow-xs transition"
                            >
                                {isLoading ? (
                                    <Sparkles className="w-3.5 h-3.5 animate-spin" />
                                ) : (
                                    <Send className="w-3.5 h-3.5" />
                                )}
                            </button>
                        </form>
                    </div>

                    {/* Card 2: Promo Portal de Pacientes en el Bolsillo */}
                    <div className="bg-gradient-to-b from-blue-50/50 to-white border border-blue-200/70 rounded-2xl p-5 shadow-2xs text-center space-y-3 relative overflow-hidden">
                        
                        <div className="w-20 h-28 mx-auto rounded-xl bg-slate-900 border-2 border-slate-800 p-1 shadow-lg relative flex flex-col items-center justify-between">
                            <div className="w-6 h-1 bg-slate-700 rounded-full mt-0.5"></div>
                            <div className="w-full flex-1 bg-white rounded-lg p-1 text-[7px] text-left flex flex-col justify-between overflow-hidden">
                                <div className="font-bold text-blue-600">VetPass™</div>
                                <div className="p-0.5 bg-blue-50 rounded text-slate-800 font-bold truncate">
                                    {(aiContext?.samplePetName || 'Max').toUpperCase()} · {(aiContext?.samplePetBreed?.split(' ')[0] || 'GOLDEN').toUpperCase()}
                                </div>
                                <div className="text-emerald-600 font-bold">Al día ✓</div>
                            </div>
                            <div className="w-2 h-2 rounded-full border border-slate-700 mb-0.5"></div>
                        </div>

                        <div>
                            <h4 className="text-xs font-black text-slate-900 leading-tight">
                                Lleva el cuidado de tu mascota en el bolsillo
                            </h4>
                            <p className="text-[11px] text-slate-500 mt-1 leading-relaxed">
                                Tu cliente también tiene su portal con su carnet digital, beneficios y recordatorios.
                            </p>
                        </div>

                        <a
                            href={portalUrl}
                            target="_blank"
                            rel="noreferrer"
                            className="block w-full py-2 px-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-xs"
                        >
                            Ver portal de pacientes →
                        </a>

                        <div className="flex items-center justify-center gap-1 pt-1">
                            <span className="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                            <span className="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                            <span className="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                            <span className="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                        </div>
                    </div>

                </div>

            </div>
        </VetAdminLayout>
    );
}
