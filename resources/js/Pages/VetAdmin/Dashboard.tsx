import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { 
    ChevronRight, 
    Eye, 
    Zap, 
    Send, 
    Calendar,
    Copy,
    Check,
    ExternalLink,
    MessageCircle,
    CheckCircle2,
    Sparkles
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
    formattedDate = 'Jueves 1 de octubre de 2026',
    tenantSlug = 'vet-pet-patitas',
    redeemUrl = `/admin/vet-pet-patitas/counter-redeem`,
    newSubUrl = `/admin/vet-pet-patitas/subscriptions/create`,
    portalUrl = `/v/vet-pet-patitas`,
    qrUrl = `/v/vet-pet-patitas/afiche`,
    recommendation = {
        badge: 'Recomendación',
        impact_text: '1 oportunidad detectada',
        title: 'Te recomendamos contactar a María porque Max tiene 10/18 beneficios disponibles (como Kit Bienvenida, Cédula + Collar Placa + Carnet Digital) y no ha realizado una visita en los últimos 60 días.',
        whatsapp_url: 'https://wa.me/573508742543',
        pet_url: '/admin/vet-pet-patitas/pets',
        customer_name: 'María',
        pet_name: 'Max'
    }
}: DashboardProps) {

    // Interactive States
    const [copiedPortal, setCopiedPortal] = useState(false);
    const [chatInput, setChatInput] = useState('');
    const [chatMessages, setChatMessages] = useState<Array<{ role: 'user' | 'assistant'; text: string }>>([]);

    const handleCopyPortal = (e: React.MouseEvent) => {
        e.preventDefault();
        e.stopPropagation();
        const fullUrl = window.location.origin + portalUrl;
        navigator.clipboard.writeText(fullUrl);
        setCopiedPortal(true);
        setTimeout(() => setCopiedPortal(false), 2000);
    };

    const handlePromptClick = (text: string) => {
        const userMsg = { role: 'user' as const, text };
        let reply = '';

        if (text.includes('perro adulto')) {
            reply = '🐶 **Plan Recomendado:** Para perros adultos mayores a 3 años, el Plan Patitas Básico / Senior es ideal: incluye vacunación antirrábica y hexavalente, desparasitaciones periódicas trimestrales, 1 profilaxis con 20% de descuento y controles generales.';
        } else if (text.includes('coberturas')) {
            reply = '🛡️ **Coberturas y Exclusiones:** Incluye chequeos clínicos, vacunación anual y urgencias diurnas. Excluye patologías preexistentes no declaradas, cirugías estéticas y medicamentos crónicos de farmacia externa.';
        } else if (text.includes('analiza')) {
            reply = '📊 **Oportunidad Detectada:** El 80% de tus pacientes registrados aún no tienen débito automático activo. Afiliar 5 pacientes este mes elevará el MRR en $250.000 COP con 92% de retención anual.';
        } else {
            reply = '💡 **Plan de Fidelización:** 1) Envío de carnet digital con bienvenida. 2) Alerta automática a los 45 días si no han redimido su baño medicado o control preventivo. 3) Bono del 10% en tienda por renovación anual.';
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
        >
            <Head title={`Dashboard · ${brandName}`} />
            
            {/* CONTENEDOR FLUIDO QUE LLENA LA PANTALLA NATURALMENTE */}
            <div className="flex flex-col xl:flex-row gap-4 items-start w-full">
                
                {/* =========================================================
                     COLUMNA IZQUIERDA: ÁREA DE OPERACIÓN PRINCIPAL
                     ========================================================= */}
                <div className="flex-1 min-w-0 flex flex-col gap-3.5 w-full">
                    
                    {/* 1. HERO WELCOME CARD (EXACTO AL MOCKUP) */}
                    <div className="bg-white border border-slate-200/90 rounded-2xl p-5 lg:p-6 flex flex-col md:flex-row items-center justify-between gap-4 shadow-2xs relative overflow-hidden">
                        <div className="space-y-1.5 max-w-xl">
                            <p className="text-xs font-semibold text-slate-500">
                                ¡Hola, {greetingName}! 👋
                            </p>
                            <h1 className="text-2xl lg:text-[28px] font-black text-slate-900 leading-tight tracking-tight">
                                Bienvenida a {brandName}
                            </h1>
                            <p className="text-xs lg:text-[13.5px] font-medium text-slate-500">
                                Gestiona tus planes de salud, clientes y mascotas en un solo lugar.
                            </p>
                            
                            <div className="flex items-center gap-2 flex-wrap pt-2">
                                <span className="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-semibold bg-white border border-slate-200 text-slate-600 shadow-2xs">
                                    📍 Sede {cleanCity}
                                </span>
                                <span className="text-slate-300 text-xs">›</span>
                                <span className="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-semibold bg-white border border-slate-200 text-slate-600 shadow-2xs">
                                    📅 {formattedDate}
                                </span>
                                <span className="text-slate-300 text-xs">›</span>
                                <span className="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-semibold bg-[#f0fdfa] border border-[#ccfbf1] text-[#0f766e]">
                                    <span>⏱</span> Modo Sincronizado
                                </span>
                                <span className="text-slate-300 text-xs">›</span>
                                <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-[#f0fdf4] border border-[#bbf7d0] text-[#15803d]">
                                    <span className="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span>Sistema en línea</span>
                                </span>
                            </div>
                        </div>

                        {/* Hand drawn cyan heart doodle */}
                        <svg className="w-10 h-10 text-cyan-400 stroke-current -rotate-12 absolute right-52 top-6 hidden lg:block opacity-75" viewBox="0 0 24 24" fill="none" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
                            <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                        </svg>

                        {/* Right Golden Retriever + Cat Cutout with Aura and Floating Heart HD */}
                        <div className="shrink-0 flex items-center justify-center relative">
                            <div className="absolute inset-0 bg-gradient-to-tr from-cyan-100/50 to-sky-100/40 rounded-full blur-xl scale-110 pointer-events-none"></div>
                            <img 
                                src="/images/dashboard/hero_pets_hd.png" 
                                alt={`Mascotas ${brandName}`} 
                                className="h-28 lg:h-36 xl:h-40 w-auto object-contain drop-shadow-sm select-none pointer-events-none relative z-10"
                            />
                        </div>
                    </div>

                    {/* 2. 4 KPI CARDS (FILA HORIZONTAL DE 4 COLUMNAS) */}
                    <div className="grid grid-cols-2 lg:grid-cols-4 gap-3 w-full">
                        
                        {/* KPI 1: MRR */}
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-4 flex flex-col justify-between min-h-[130px] shadow-2xs hover:shadow-xs transition">
                            <div className="flex items-center gap-2.5">
                                <div className="w-7 h-7 rounded-full bg-[#1e3a8a] text-white flex items-center justify-center font-black text-xs shrink-0 shadow-2xs">
                                    $
                                </div>
                                <span className="text-xs font-bold text-slate-600">
                                    Ingresos recurrentes (MRR)
                                </span>
                            </div>

                            <div className="my-1.5">
                                <div className="text-2xl lg:text-[27px] font-black text-slate-900 tracking-tight leading-none">
                                    ${formattedMrr} <span className="text-sm font-black text-slate-800">COP</span>
                                </div>
                            </div>

                            <div className="flex items-center justify-between">
                                <span className="text-[11px] font-bold text-emerald-600 flex items-center gap-0.5">
                                    <span>↗</span> +50% vs. mes anterior
                                </span>
                                <svg className="w-14 h-5 text-emerald-500" viewBox="0 0 60 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
                                    <path d="M2 18 C 15 18, 25 14, 38 8 C 45 4, 52 4, 58 2" />
                                </svg>
                            </div>
                        </div>

                        {/* KPI 2: Mascotas Activas */}
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-4 flex flex-col justify-between min-h-[130px] shadow-2xs hover:shadow-xs transition">
                            <div className="flex items-center gap-2.5">
                                <div className="w-7 h-7 rounded-full bg-[#0d9488] text-white flex items-center justify-center font-black text-xs shrink-0 shadow-2xs">
                                    🐾
                                </div>
                                <span className="text-xs font-bold text-slate-600">
                                    Mascotas activas
                                </span>
                            </div>

                            <div className="my-1.5">
                                <div className="text-2xl lg:text-[27px] font-black text-slate-900 tracking-tight leading-none">
                                    {petsCount}
                                </div>
                            </div>

                            <div className="flex items-center justify-between">
                                <span className="text-[11px] font-semibold text-blue-600">
                                    {activeSubsCount} plan activo
                                </span>
                                <span className="text-lg text-cyan-400/80 leading-none">
                                    🐾
                                </span>
                            </div>
                        </div>

                        {/* KPI 3: Nuevas Afiliaciones */}
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-4 flex flex-col justify-between min-h-[130px] shadow-2xs hover:shadow-xs transition">
                            <div className="flex items-center gap-2.5">
                                <div className="w-7 h-7 rounded-full bg-[#7c3aed] text-white flex items-center justify-center font-black text-xs shrink-0 shadow-2xs">
                                    👥
                                </div>
                                <span className="text-xs font-bold text-slate-600">
                                    Nuevas afiliaciones
                                </span>
                            </div>

                            <div className="my-1.5">
                                <div className="text-2xl lg:text-[27px] font-black text-slate-900 tracking-tight leading-none">
                                    +{newSubsThisMonth}
                                </div>
                            </div>

                            <div className="flex items-center justify-between">
                                <span className="text-[11px] font-semibold text-slate-500">
                                    Este mes
                                </span>
                                <svg className="w-10 h-5 text-purple-500" viewBox="0 0 40 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
                                    <path d="M2 20 L 14 14 L 24 17 L 38 4" />
                                </svg>
                            </div>
                        </div>

                        {/* KPI 4: Renovaciones */}
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-4 flex flex-col justify-between min-h-[130px] shadow-2xs hover:shadow-xs transition">
                            <div className="flex items-center gap-2.5">
                                <div className="w-7 h-7 rounded-full bg-[#f59e0b] text-white flex items-center justify-center font-black text-xs shrink-0 shadow-2xs">
                                    📅
                                </div>
                                <span className="text-xs font-bold text-slate-600">
                                    Renovaciones
                                </span>
                            </div>

                            <div className="my-1.5">
                                <div className="text-2xl lg:text-[27px] font-black text-slate-900 tracking-tight leading-none">
                                    {expiring15Days}
                                </div>
                            </div>

                            <div className="flex items-center justify-between">
                                <span className="text-[11px] font-semibold text-slate-500">
                                    Próximos 15 días
                                </span>
                                <span className="text-sm text-amber-500 font-bold">↻</span>
                            </div>
                        </div>

                    </div>

                    {/* 3. ACCIONES RÁPIDAS (5 CARDS EXACTAS AL MOCKUP) */}
                    <div>
                        <div className="flex items-center justify-between mb-2 px-1">
                            <h3 className="text-sm font-bold text-slate-800">
                                Acciones rápidas
                            </h3>
                            <a href={`/admin/${tenantSlug}/servicios`} className="text-xs font-semibold text-blue-600 hover:text-blue-700">
                                Ver todas →
                            </a>
                        </div>

                        <div className="grid grid-cols-2 md:grid-cols-5 lg:grid-cols-12 gap-3 w-full">
                            
                            {/* Card 1: Canjear Beneficio */}
                            <a 
                                href={redeemUrl} 
                                className="col-span-2 md:col-span-2 lg:col-span-4 bg-[#1a56db] hover:bg-[#1e429f] text-white rounded-2xl p-3.5 flex flex-col justify-between h-[96px] shadow-2xs hover:shadow-md transition duration-150 relative overflow-hidden group"
                            >
                                <div className="flex items-center justify-between">
                                    <div className="w-6 h-6 rounded-md bg-white/20 flex items-center justify-center text-xs font-black">
                                        🏷️
                                    </div>
                                </div>
                                <div className="flex items-end justify-between mt-auto">
                                    <div>
                                        <h4 className="text-[13.5px] font-bold text-white leading-tight">Canjear Beneficio</h4>
                                        <p className="text-[10px] text-blue-100 mt-0.5">Abre tu terminal y atiende a tus clientes</p>
                                    </div>
                                    <div className="shrink-0 pl-1">
                                        <img src="/images/dashboard/pos_terminal_hd.png" alt="POS" className="h-10 w-auto object-contain drop-shadow-md group-hover:scale-105 transition-transform" />
                                    </div>
                                </div>
                            </a>

                            {/* Card 2: Afiliar Mascota */}
                            <a 
                                href={newSubUrl} 
                                className="col-span-1 md:col-span-1 lg:col-span-2 bg-[#059669] hover:bg-[#047857] text-white rounded-2xl p-3.5 flex flex-col justify-between h-[96px] shadow-2xs hover:shadow-md transition duration-150 relative overflow-hidden group"
                            >
                                <div className="w-6 h-6 rounded-md bg-white/20 flex items-center justify-center text-xs font-black">
                                    🐾
                                </div>
                                <div className="mt-auto">
                                    <h4 className="text-[13px] font-bold text-white leading-tight">Afiliar mascota</h4>
                                    <p className="text-[10px] text-emerald-100 mt-0.5">Nueva afiliación</p>
                                </div>
                            </a>

                            {/* Card 3: Portal Pacientes */}
                            <a 
                                href={portalUrl}
                                target="_blank"
                                rel="noreferrer"
                                className="col-span-1 md:col-span-1 lg:col-span-2 bg-white border border-slate-200 hover:border-blue-400 rounded-2xl p-3.5 flex flex-col justify-between h-[96px] shadow-2xs hover:shadow-sm transition duration-150 group"
                            >
                                <div className="w-6 h-6 rounded-md bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-black">
                                    📱
                                </div>
                                <div className="mt-auto">
                                    <h4 className="text-[12.5px] font-bold text-slate-800 leading-tight">Portal Pacientes</h4>
                                    <p className="text-[9.5px] text-slate-400 mt-0.5">Tienda web de auto-afiliación</p>
                                </div>
                            </a>

                            {/* Card 4: Web B2C */}
                            <a 
                                href={portalUrl}
                                target="_blank"
                                rel="noreferrer"
                                className="col-span-1 md:col-span-1 lg:col-span-2 bg-white border border-slate-200 hover:border-blue-400 rounded-2xl p-3.5 flex flex-col justify-between h-[96px] shadow-2xs hover:shadow-sm transition duration-150 group"
                            >
                                <div className="w-6 h-6 rounded-md bg-sky-50 text-sky-600 flex items-center justify-center text-xs font-black">
                                    🌐
                                </div>
                                <div className="mt-auto">
                                    <h4 className="text-[12.5px] font-bold text-slate-800 leading-tight">Web B2C</h4>
                                    <p className="text-[9.5px] text-slate-400 mt-0.5">Generar PDF</p>
                                </div>
                            </a>

                            {/* Card 5: Imprimir QR */}
                            <a 
                                href={qrUrl}
                                target="_blank"
                                rel="noreferrer"
                                className="col-span-1 md:col-span-1 lg:col-span-2 bg-white border border-slate-200 hover:border-blue-400 rounded-2xl p-3.5 flex flex-col justify-between h-[96px] shadow-2xs hover:shadow-sm transition duration-150 group"
                            >
                                <div className="w-6 h-6 rounded-md bg-cyan-50 text-cyan-600 flex items-center justify-center text-xs font-black">
                                    🖨️
                                </div>
                                <div className="mt-auto">
                                    <h4 className="text-[12.5px] font-bold text-slate-800 leading-tight">Imprimir QR</h4>
                                    <p className="text-[9.5px] text-slate-400 mt-0.5">Generar PDF</p>
                                </div>
                            </a>

                        </div>
                    </div>

                    {/* 4. FILA MEDIA: RENOVACIONES PRÓXIMAS & USO DE BENEFICIOS */}
                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-3 w-full">
                        
                        {/* Caja Izquierda: Renovaciones Próximas */}
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-5 flex flex-col justify-between min-h-[220px] shadow-2xs">
                            <div className="flex items-center justify-between pb-2 border-b border-slate-100">
                                <div className="flex items-center gap-2">
                                    <span className="text-amber-500 text-sm">🔔</span>
                                    <h3 className="text-sm font-bold text-slate-900">
                                        Renovaciones próximas
                                    </h3>
                                </div>
                                <a href={`/admin/${tenantSlug}/subscriptions`} className="text-xs font-semibold text-blue-600 hover:text-blue-700">
                                    Ver todas →
                                </a>
                            </div>

                            {/* Empty state centrado exacto a la imagen */}
                            <div className="flex flex-col items-center justify-center py-6 text-center">
                                <div className="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center mb-2.5">
                                    <Calendar className="w-5 h-5" />
                                </div>
                                <h4 className="text-xs font-bold text-slate-800">
                                    Sin renovaciones pendientes
                                </h4>
                                <p className="text-[11px] text-slate-400 mt-1 max-w-[280px]">
                                    No tienes renovaciones próximas. Sigue revisando automáticamente mañana.
                                </p>
                            </div>

                            <div></div>
                        </div>

                        {/* Caja Derecha: Uso de Beneficios Clínicos */}
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-5 flex flex-col justify-between min-h-[220px] shadow-2xs">
                            <div>
                                <div className="flex items-center justify-between mb-1">
                                    <div className="flex items-center gap-2">
                                        <span className="text-blue-600 text-sm">💙</span>
                                        <h3 className="text-sm font-bold text-slate-900">
                                            Uso de beneficios clínicos
                                        </h3>
                                    </div>
                                    <span className="text-xs text-slate-400 font-medium">
                                        0 / 19 realizados (0%)
                                    </span>
                                </div>

                                <div className="flex items-center justify-between pb-2 border-b border-slate-100">
                                    <span className="text-xs text-slate-500">
                                        Servicios canjeados este ciclo
                                    </span>
                                    <span className="text-xs font-bold text-slate-700">
                                        Meta clínica: &gt; 70%
                                    </span>
                                </div>
                            </div>

                            {/* Empty state centrado con botón exacto a la imagen */}
                            <div className="flex flex-col items-center justify-center py-3 text-center">
                                <div className="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center mb-2">
                                    <span className="text-lg">🪪</span>
                                </div>
                                <h4 className="text-xs font-bold text-slate-800">
                                    Sin canjes registrados todavía
                                </h4>
                                <p className="text-[11px] text-slate-400 mt-1 max-w-[340px]">
                                    Cuando atiendas a un paciente en mostrador y le descuenten el servicio, aparecerá aquí en tiempo real.
                                </p>
                                <a 
                                    href={redeemUrl}
                                    className="mt-3.5 inline-flex items-center px-4 py-2 rounded-xl bg-[#0080ff] hover:bg-blue-600 text-white text-xs font-bold transition shadow-xs"
                                >
                                    Abrir Terminal de Canje
                                </a>
                            </div>

                            <div></div>
                        </div>

                    </div>

                    {/* 5. TARJETA INFERIOR: OPORTUNIDAD DE FIDELIZACIÓN (EXACTA AL MOCKUP) */}
                    <div className="rounded-2xl border border-slate-200/90 bg-white p-4 shadow-2xs">
                        <div className="flex items-center justify-between mb-2.5 pb-2 border-b border-slate-100 flex-wrap gap-2">
                            <div className="flex items-center gap-2">
                                <span className="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs font-bold">⭐</span>
                                <h3 className="text-sm font-bold text-slate-900">
                                    Oportunidad de Fidelización
                                </h3>
                                <span className="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    {recommendation.badge || 'Recomendación'}
                                </span>
                            </div>
                            <span className="text-xs font-semibold text-slate-600 flex items-center gap-1">
                                <span>⚡</span> Impacto: {recommendation.impact_text || '1 oportunidad detectada'}
                            </span>
                        </div>

                        <div className="flex items-center justify-between gap-4 flex-wrap lg:flex-nowrap">
                            <p className="text-xs text-slate-600 leading-relaxed font-normal flex-1">
                                {recommendation.title}
                            </p>

                            <div className="flex items-center gap-2 shrink-0">
                                <a 
                                    href={recommendation.pet_url || '#'} 
                                    className="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-[#0080ff] hover:bg-blue-600 text-white text-xs font-bold transition shadow-xs"
                                >
                                    <Eye className="w-3.5 h-3.5" />
                                    <span>Ver Paciente</span>
                                </a>

                                <a 
                                    href={redeemUrl} 
                                    className="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-xs font-bold transition shadow-2xs"
                                >
                                    <Zap className="w-3.5 h-3.5 text-blue-600" />
                                    <span>Canje en Recepción</span>
                                </a>

                                <ChevronRight className="w-4 h-4 text-slate-400" />
                            </div>
                        </div>
                    </div>

                </div>

                {/* =========================================================
                     COLUMNA DERECHA: ASISTENTE IA BETA DEDICADO (EXACTO AL MOCKUP)
                     ========================================================= */}
                <div className="w-full xl:w-[340px] 2xl:w-[360px] shrink-0 sticky top-20">
                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs flex flex-col justify-between min-h-[580px]">
                        
                        <div>
                            {/* Header Asistente IA */}
                            <div className="flex items-center justify-between pb-3 border-b border-slate-100">
                                <div className="flex items-center gap-2">
                                    <div className="w-6 h-6 rounded-full bg-[#0080ff] text-white flex items-center justify-center text-xs font-bold">
                                        🐾
                                    </div>
                                    <h3 className="text-sm font-bold text-slate-900">
                                        Tu asistente de IA
                                    </h3>
                                    <span className="text-[9px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-purple-100 text-purple-700">
                                        Beta
                                    </span>
                                </div>
                                <span className="text-slate-400 text-sm font-bold tracking-widest cursor-pointer">···</span>
                            </div>

                            {/* 3D Floating Robot Graphic HD */}
                            <div className="flex flex-col items-center text-center py-2.5">
                                <div className="relative w-36 h-22 flex items-center justify-center mb-1">
                                    <img 
                                        src="/images/dashboard/robot_ai_hd.png" 
                                        alt="Robot IA" 
                                        className="h-20 w-auto object-contain drop-shadow-lg hover:scale-105 transition-transform duration-300 select-none pointer-events-none"
                                    />
                                </div>

                                <h4 className="text-base font-bold text-slate-900 mt-1">
                                    Hola, soy tu asistente de IA
                                </h4>
                                <p className="text-xs text-slate-400 mt-1 max-w-[260px] leading-relaxed">
                                    Puedo ayudarte a crear planes, responder dudas de tus clientes, analizar datos y recomendar la mejor opción de salud para cada mascota.
                                </p>
                            </div>

                            {/* 4 Quick Action Prompt Cards with Circle Icons & Chevrons */}
                            <div className="space-y-2 mt-2">
                                
                                <button 
                                    type="button" 
                                    onClick={() => handlePromptClick('Recomienda un plan ideal para un perro adulto')}
                                    className="w-full text-left p-2.5 rounded-xl border border-slate-200/80 hover:border-blue-400 bg-white hover:bg-blue-50/30 flex items-center gap-2.5 transition duration-150 group shadow-2xs"
                                >
                                    <div className="w-7 h-7 rounded-full bg-sky-50 text-sky-600 flex items-center justify-center text-xs shrink-0 font-bold">
                                        👤
                                    </div>
                                    <span className="flex-1 text-[11px] font-medium text-slate-700 text-left leading-tight">
                                        Recomienda un plan ideal para un perro adulto
                                    </span>
                                    <span className="text-slate-400 text-xs font-semibold group-hover:translate-x-0.5 transition">›</span>
                                </button>

                                <button 
                                    type="button" 
                                    onClick={() => handlePromptClick('Responde dudas sobre coberturas y exclusiones')}
                                    className="w-full text-left p-2.5 rounded-xl border border-slate-200/80 hover:border-blue-400 bg-white hover:bg-blue-50/30 flex items-center gap-2.5 transition duration-150 group shadow-2xs"
                                >
                                    <div className="w-7 h-7 rounded-full bg-sky-50 text-sky-600 flex items-center justify-center text-xs shrink-0 font-bold">
                                        ⏱
                                    </div>
                                    <span className="flex-1 text-[11px] font-medium text-slate-700 text-left leading-tight">
                                        Responde dudas sobre coberturas y exclusiones
                                    </span>
                                    <span className="text-slate-400 text-xs font-semibold group-hover:translate-x-0.5 transition">›</span>
                                </button>

                                <button 
                                    type="button" 
                                    onClick={() => handlePromptClick('Analiza la base de clientes y detecta oportunidades')}
                                    className="w-full text-left p-2.5 rounded-xl border border-slate-200/80 hover:border-blue-400 bg-white hover:bg-blue-50/30 flex items-center gap-2.5 transition duration-150 group shadow-2xs"
                                >
                                    <div className="w-7 h-7 rounded-full bg-sky-50 text-sky-600 flex items-center justify-center text-xs shrink-0 font-bold">
                                        🪟
                                    </div>
                                    <span className="flex-1 text-[11px] font-medium text-slate-700 text-left leading-tight">
                                        Analiza la base de clientes y detecta oportunidades
                                    </span>
                                    <span className="text-slate-400 text-xs font-semibold group-hover:translate-x-0.5 transition">›</span>
                                </button>

                                <button 
                                    type="button" 
                                    onClick={() => handlePromptClick('Genera un plan de fidelización para tus clientes')}
                                    className="w-full text-left p-2.5 rounded-xl border border-slate-200/80 hover:border-emerald-400 bg-white hover:bg-emerald-50/30 flex items-center gap-2.5 transition duration-150 group shadow-2xs"
                                >
                                    <div className="w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs shrink-0 font-bold">
                                        💡
                                    </div>
                                    <span className="flex-1 text-[11px] font-medium text-slate-700 text-left leading-tight">
                                        Genera un plan de fidelización para tus clientes
                                    </span>
                                    <span className="text-slate-400 text-xs font-semibold group-hover:translate-x-0.5 transition">›</span>
                                </button>

                            </div>

                            {/* Chat History */}
                            {chatMessages.length > 0 && (
                                <div className="space-y-2 max-h-36 overflow-y-auto mt-2.5 p-2 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                                    {chatMessages.map((msg, i) => (
                                        <div 
                                            key={i} 
                                            className={`p-2 rounded-lg ${
                                                msg.role === 'user' 
                                                    ? 'bg-[#0080ff] text-white font-medium ml-auto max-w-[85%]' 
                                                    : 'bg-white text-slate-700 border border-slate-200 mr-auto max-w-[95%]'
                                            }`}
                                        >
                                            {msg.text}
                                        </div>
                                    ))}
                                </div>
                            )}

                        </div>

                        {/* Interactive Input Form */}
                        <div className="pt-3 border-t border-slate-100 space-y-1.5 mt-3">
                            <form onSubmit={handleSendChat} className="relative flex items-center">
                                <input 
                                    type="text" 
                                    value={chatInput}
                                    onChange={(e) => setChatInput(e.target.value)}
                                    placeholder="Escribe tu consulta..."
                                    className="w-full text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-900 pr-9 pl-3.5 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition shadow-2xs placeholder:text-slate-400"
                                />
                                <button 
                                    type="submit" 
                                    className="absolute right-1.5 w-6 h-6 rounded-md bg-[#1a56db] hover:bg-blue-800 text-white flex items-center justify-center text-xs font-bold transition shadow-xs"
                                >
                                    <Send className="w-3 h-3" />
                                </button>
                            </form>

                            <div className="flex items-center gap-1.5 text-[10.5px] text-slate-400 justify-start pl-1">
                                <span>⏱</span>
                                <span>IA en preparación</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </VetAdminLayout>
    );
}
