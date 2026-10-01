import React, { useState } from 'react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { 
    ChevronRight, 
    Eye, 
    Zap, 
    Send, 
    Calendar 
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
    brandName = 'PetSalud+',
    cleanCity = 'Cajicá',
    formattedDate = 'Jueves 1 de octubre de 2026',
    tenantSlug = 'vet-pet-patitas',
    redeemUrl = `/admin/vet-pet-patitas/canje-mostrador`,
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

    // Interactive AI Chat State
    const [chatInput, setChatInput] = useState('');
    const [chatMessages, setChatMessages] = useState<Array<{ role: 'user' | 'assistant'; text: string }>>([]);

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
        <VetAdminLayout tenantSlug={tenantSlug} userName={userName} userRole={userRole}>
            
            <div className="flex flex-col xl:flex-row gap-4 items-start w-full max-w-[1440px] mx-auto">
                
                {/* =========================================================
                     COLUMNA IZQUIERDA: ÁREA DE OPERACIÓN PRINCIPAL
                     ========================================================= */}
                <div className="flex-1 min-w-0 flex flex-col gap-3.5 w-full">
                    
                    {/* 1. HERO WELCOME CARD (EXACTO AL MOCKUP) */}
                    <div className="bg-white border border-slate-200/90 rounded-2xl p-5 flex flex-col md:flex-row items-center justify-between gap-4 shadow-2xs relative overflow-hidden">
                        <div className="space-y-1 max-w-xl">
                            <p className="text-xs font-semibold text-slate-500">
                                ¡Hola, {greetingName}!
                            </p>
                            <h1 className="text-2xl lg:text-[27px] font-black text-slate-900 leading-tight tracking-tight">
                                Bienvenida a {brandName} 👋
                            </h1>
                            <p className="text-xs lg:text-[13px] font-medium text-slate-500">
                                Gestiona tus planes de salud, clientes y mascotas en un solo lugar.
                            </p>
                            
                            <div className="flex items-center gap-2 flex-wrap pt-2">
                                <span className="inline-flex items-center px-3 py-0.5 rounded-full text-[11px] font-semibold bg-white border border-slate-200 text-slate-600 shadow-2xs">
                                    📍 Sede {cleanCity} · {formattedDate}
                                </span>
                                <span className="inline-flex items-center px-3 py-0.5 rounded-full text-[11px] font-semibold bg-[#f0fdfa] border border-[#ccfbf1] text-[#0f766e]">
                                    ⏱ Modo Sincronizado
                                </span>
                                <span className="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-[11px] font-semibold bg-[#f0fdf4] border border-[#bbf7d0] text-[#15803d]">
                                    <span className="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span>Sistema en línea</span>
                                </span>
                            </div>
                        </div>

                        {/* Right Golden Retriever + Cat Cutout with Aura and Floating Heart */}
                        <div className="shrink-0 flex items-center justify-center">
                            <img 
                                src="/images/dashboard/hero_pets_2x.png" 
                                alt="Mascotas PetSalud" 
                                className="h-24 lg:h-28 w-auto object-contain"
                            />
                        </div>
                    </div>

                    {/* 2. 4 KPI CARDS (FILA HORIZONTAL DE 4 COLUMNAS) */}
                    <div className="grid grid-cols-2 lg:grid-cols-4 gap-3 w-full">
                        
                        {/* KPI 1: MRR */}
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-4 flex flex-col justify-between min-h-[125px] shadow-2xs hover:shadow-xs transition">
                            <div className="flex items-center gap-2">
                                <div className="w-7 h-7 rounded-full bg-[#1e3a8a] text-white flex items-center justify-center font-black text-xs shrink-0 shadow-2xs">
                                    $
                                </div>
                                <span className="text-xs font-bold text-slate-600">
                                    Ingresos recurrentes (MRR)
                                </span>
                            </div>

                            <div className="my-1">
                                <div className="text-2xl font-black text-slate-900 tracking-tight leading-none">
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
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-4 flex flex-col justify-between min-h-[125px] shadow-2xs hover:shadow-xs transition">
                            <div className="flex items-center gap-2">
                                <div className="w-7 h-7 rounded-full bg-[#0d9488] text-white flex items-center justify-center font-black text-xs shrink-0 shadow-2xs">
                                    🐾
                                </div>
                                <span className="text-xs font-bold text-slate-600">
                                    Mascotas activas
                                </span>
                            </div>

                            <div className="my-1">
                                <div className="text-2xl font-black text-slate-900 tracking-tight leading-none">
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
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-4 flex flex-col justify-between min-h-[125px] shadow-2xs hover:shadow-xs transition">
                            <div className="flex items-center gap-2">
                                <div className="w-7 h-7 rounded-full bg-[#7c3aed] text-white flex items-center justify-center font-black text-xs shrink-0 shadow-2xs">
                                    👥
                                </div>
                                <span className="text-xs font-bold text-slate-600">
                                    Nuevas afiliaciones
                                </span>
                            </div>

                            <div className="my-1">
                                <div className="text-2xl font-black text-slate-900 tracking-tight leading-none">
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
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-4 flex flex-col justify-between min-h-[125px] shadow-2xs hover:shadow-xs transition">
                            <div className="flex items-center gap-2">
                                <div className="w-7 h-7 rounded-full bg-[#f59e0b] text-white flex items-center justify-center font-black text-xs shrink-0 shadow-2xs">
                                    📅
                                </div>
                                <span className="text-xs font-bold text-slate-600">
                                    Renovaciones
                                </span>
                            </div>

                            <div className="my-1">
                                <div className="text-2xl font-black text-slate-900 tracking-tight leading-none">
                                    {expiring15Days}
                                </div>
                            </div>

                            <div className="flex items-center justify-between">
                                <span className="text-[11px] font-semibold text-slate-500">
                                    Próximos 15 días
                                </span>
                                <Calendar className="w-4 h-4 text-amber-500/80" />
                            </div>
                        </div>

                    </div>

                    {/* 3. ACCIONES RÁPIDAS (4 CARDS) */}
                    <div>
                        <div className="flex items-center justify-between mb-2 px-1">
                            <h3 className="text-xs font-black uppercase tracking-wider text-slate-700">
                                Acciones rápidas
                            </h3>
                            <span className="text-[11px] font-semibold text-slate-400">
                                Operación Diaria
                            </span>
                        </div>

                        <div className="grid grid-cols-2 lg:grid-cols-4 gap-3 w-full">
                            
                            {/* Card 1: Canjear Beneficio con Datáfono */}
                            <a 
                                href={redeemUrl} 
                                className="bg-gradient-to-br from-[#1e40af] to-[#2563eb] text-white rounded-2xl p-3 flex flex-col justify-between h-[86px] shadow-2xs hover:shadow-sm hover:-translate-y-0.5 transition duration-150 relative overflow-hidden group"
                            >
                                <div className="flex items-center justify-between">
                                    <div className="w-6 h-6 rounded-md bg-white/20 backdrop-blur-xs flex items-center justify-center text-xs font-black border border-white/30">
                                        🏷️
                                    </div>
                                </div>
                                <div className="flex items-center justify-between mt-auto">
                                    <div>
                                        <h4 className="text-[13px] font-black text-white leading-tight">Canjear beneficio</h4>
                                        <p className="text-[9.5px] text-blue-100 font-medium mt-0.5">Abre tu terminal y atiende a tus clientes</p>
                                    </div>
                                    <div className="flex items-center gap-1 shrink-0 pl-1">
                                        <img src="/images/dashboard/pos_terminal_2x.png" alt="POS" className="h-8 w-auto object-contain drop-shadow-md" />
                                        <ChevronRight className="w-4 h-4 text-white" />
                                    </div>
                                </div>
                            </a>

                            {/* Card 2: Afiliar Mascota */}
                            <a 
                                href={newSubUrl} 
                                className="bg-gradient-to-br from-[#059669] to-[#0d9488] text-white rounded-2xl p-3 flex flex-col justify-between h-[86px] shadow-2xs hover:shadow-sm hover:-translate-y-0.5 transition duration-150 relative overflow-hidden group"
                            >
                                <div className="flex items-center justify-between">
                                    <div className="w-6 h-6 rounded-md bg-white/20 backdrop-blur-xs flex items-center justify-center text-xs font-black border border-white/30">
                                        🐾
                                    </div>
                                </div>
                                <div className="flex items-center justify-between mt-auto">
                                    <div>
                                        <h4 className="text-[13px] font-black text-white leading-tight">Afiliar mascota</h4>
                                        <p className="text-[9.5px] text-emerald-100 font-medium mt-0.5">Nueva afiliación</p>
                                    </div>
                                    <div className="shrink-0 pl-1">
                                        <ChevronRight className="w-4 h-4 text-white" />
                                    </div>
                                </div>
                            </a>

                            {/* Card 3: Ver Portal */}
                            <a 
                                href={portalUrl} 
                                target="_blank" 
                                rel="noreferrer"
                                className="bg-white border border-slate-200/90 hover:border-blue-400 rounded-2xl p-3 flex flex-col justify-between h-[86px] shadow-2xs hover:shadow-2xs hover:-translate-y-0.5 transition duration-150 relative overflow-hidden group"
                            >
                                <div className="flex items-center justify-between">
                                    <div className="w-6 h-6 rounded-md bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-black border border-blue-200">
                                        🌐
                                    </div>
                                    <div className="flex flex-col items-end">
                                        <span className="text-[9px] font-bold text-blue-700 bg-blue-50 border border-blue-200 px-1.5 py-0.5 rounded-md">
                                            Web B2C
                                        </span>
                                        <span className="text-[8px] text-slate-400 mt-0.5">Abrir portal</span>
                                    </div>
                                </div>
                                <div className="flex items-center justify-between mt-auto">
                                    <div>
                                        <h4 className="text-[13px] font-black text-slate-900 leading-tight">Ver portal</h4>
                                        <p className="text-[9.5px] text-slate-400 font-medium mt-0.5">Abrir portal</p>
                                    </div>
                                </div>
                            </a>

                            {/* Card 4: Imprimir QR */}
                            <a 
                                href={qrUrl} 
                                target="_blank" 
                                rel="noreferrer"
                                className="bg-white border border-slate-200/90 hover:border-cyan-400 rounded-2xl p-3 flex flex-col justify-between h-[86px] shadow-2xs hover:shadow-2xs hover:-translate-y-0.5 transition duration-150 relative overflow-hidden group"
                            >
                                <div className="flex items-center justify-between">
                                    <div className="w-6 h-6 rounded-md bg-cyan-50 text-cyan-600 flex items-center justify-center text-xs font-black border border-cyan-200">
                                        🖨️
                                    </div>
                                    <div className="flex flex-col items-end">
                                        <span className="text-[9px] font-bold text-purple-700 bg-purple-50 border border-purple-200 px-1.5 py-0.5 rounded-md">
                                            Generar PDF
                                        </span>
                                        <span className="text-[8px] text-slate-400 mt-0.5">Generar PDF</span>
                                    </div>
                                </div>
                                <div className="flex items-center justify-between mt-auto">
                                    <div>
                                        <h4 className="text-[13px] font-black text-slate-900 leading-tight">Imprimir QR</h4>
                                        <p className="text-[9.5px] text-slate-400 font-medium mt-0.5">Generar PDF</p>
                                    </div>
                                </div>
                            </a>

                        </div>
                    </div>

                    {/* 4. FILA MEDIA: RENOVACIONES PRÓXIMAS & USO DE BENEFICIOS */}
                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-3 w-full">
                        
                        {/* Caja Izquierda: Renovaciones Próximas */}
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-5 flex flex-col justify-between min-h-[210px] shadow-2xs">
                            <div>
                                <div className="flex items-center justify-between mb-4 pb-2 border-b border-slate-100">
                                    <div className="flex items-center gap-2">
                                        <span className="text-amber-500 text-sm">🔔</span>
                                        <h3 className="text-sm font-black text-slate-900">
                                            Renovaciones próximas
                                        </h3>
                                    </div>
                                    <a href={`/admin/${tenantSlug}/subscriptions`} className="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                                        <span>Ver todas</span>
                                        <span>&rarr;</span>
                                    </a>
                                </div>

                                <div className="py-4 text-center flex flex-col items-center justify-center">
                                    <div className="w-11 h-11 rounded-full bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center text-lg mb-2 shadow-2xs">
                                        📅
                                    </div>
                                    <h4 className="text-sm font-black text-slate-900">
                                        Sin renovaciones pendientes
                                    </h4>
                                    <p className="text-xs text-slate-400 mt-1 max-w-xs leading-relaxed">
                                        No tienes renovaciones próximas. Sigue revisando automáticamente mañana.
                                    </p>
                                </div>
                            </div>

                            <div className="pt-2">
                                <a 
                                    href={`/admin/${tenantSlug}/plans`} 
                                    className="w-full py-2.5 px-4 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 text-xs font-bold text-slate-700 flex items-center justify-center gap-1.5 transition"
                                >
                                    <span>Ver planes activos</span>
                                </a>
                            </div>
                        </div>

                        {/* Caja Derecha: Uso de Beneficios Clínicos */}
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-5 flex flex-col justify-between min-h-[210px] shadow-2xs">
                            <div>
                                <div className="flex items-center justify-between mb-1">
                                    <div className="flex items-center gap-2">
                                        <span className="text-blue-600 text-sm">💙</span>
                                        <h3 className="text-sm font-black text-slate-900">
                                            Uso de beneficios clínicos
                                        </h3>
                                    </div>
                                    <span className="text-xs font-medium text-slate-500">
                                        {totalUsed} / {totalGranted} utilizados ({usagePercent}%)
                                    </span>
                                </div>

                                <div className="flex items-center justify-between pb-3 border-b border-slate-100">
                                    <span className="text-xs text-slate-400">
                                        Servicios canjeados este ciclo
                                    </span>
                                    <span className="text-[11px] font-bold text-cyan-800 bg-cyan-50 border border-cyan-200 px-2 py-0.5 rounded-md">
                                        Meta clínica: &gt; 70%
                                    </span>
                                </div>

                                <div className="py-4 text-center flex flex-col items-center justify-center">
                                    <div className="w-11 h-11 rounded-full bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center text-lg mb-2 shadow-2xs">
                                        📄
                                    </div>
                                    <h4 className="text-sm font-black text-slate-900">
                                        Sin canjes registrados todavía
                                    </h4>
                                    <p className="text-xs text-slate-400 mt-1 max-w-xs leading-relaxed">
                                        Cuando atiendas a un paciente en mostrador y le descuenten el servicio, aparecerá aquí en tiempo real.
                                    </p>
                                </div>
                            </div>

                            <div className="pt-2">
                                <a 
                                    href={redeemUrl} 
                                    className="w-full py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold flex items-center justify-center gap-1.5 transition shadow-sm"
                                >
                                    <span>⚡ Abrir Terminal de Canje</span>
                                </a>
                            </div>
                        </div>

                    </div>

                    {/* 5. TARJETA INFERIOR: OPORTUNIDAD DE FIDELIZACIÓN (EXACTA AL MOCKUP) */}
                    <div className="rounded-2xl border border-teal-200/90 bg-gradient-to-r from-teal-50/60 via-white to-cyan-50/40 p-4 shadow-2xs">
                        <div className="flex items-center justify-between mb-2.5 pb-2 border-b border-teal-100 flex-wrap gap-2">
                            <div className="flex items-center gap-2">
                                <span className="w-5 h-5 rounded-full bg-teal-500 text-white flex items-center justify-center text-[10px] font-bold">⭐</span>
                                <h3 className="text-sm font-black text-slate-900">
                                    Oportunidad de Fidelización
                                </h3>
                                <span className="text-[10px] font-bold px-2 py-0.5 rounded-full bg-teal-50 text-teal-700 border border-teal-200">
                                    {recommendation.badge || 'Recomendación'}
                                </span>
                            </div>
                            <span className="text-xs font-semibold text-slate-600">
                                💡 Impacto: {recommendation.impact_text || '1 oportunidad detectada'}
                            </span>
                        </div>

                        <div className="flex items-center justify-between gap-4 flex-wrap lg:flex-nowrap">
                            <p className="text-xs text-slate-600 leading-relaxed font-normal flex-1">
                                {recommendation.title}
                            </p>

                            <div className="flex items-center gap-2 shrink-0">
                                <a 
                                    href={recommendation.pet_url || '#'} 
                                    className="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-2xs"
                                >
                                    <Eye className="w-3.5 h-3.5" />
                                    <span>Ver Paciente</span>
                                </a>

                                <a 
                                    href={redeemUrl} 
                                    className="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 text-xs font-bold transition shadow-2xs"
                                >
                                    <Zap className="w-3.5 h-3.5 text-blue-600" />
                                    <span>Canje en Recepción</span>
                                </a>

                                <ChevronRight className="w-5 h-5 text-slate-400" />
                            </div>
                        </div>
                    </div>

                </div>

                {/* =========================================================
                     COLUMNA DERECHA: ASISTENTE IA BETA DEDICADO (EXACTO AL MOCKUP)
                     ========================================================= */}
                <div className="w-full xl:w-[325px] shrink-0 sticky top-20">
                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs flex flex-col justify-between min-h-[580px]">
                        
                        <div>
                            {/* Header Asistente IA */}
                            <div className="flex items-center justify-between pb-3 border-b border-slate-100">
                                <div className="flex items-center gap-2">
                                    <span className="w-6 h-6 rounded-full bg-[#1e3a8a] text-white flex items-center justify-center text-xs font-black tracking-tighter">
                                        iA
                                    </span>
                                    <h3 className="text-sm font-black text-slate-900">
                                        Asistente IA
                                    </h3>
                                    <span className="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full bg-purple-100 text-purple-700">
                                        Beta
                                    </span>
                                </div>
                                <span className="text-slate-400 text-sm font-bold tracking-widest cursor-pointer">•••</span>
                            </div>

                            {/* 3D Floating Robot Graphic */}
                            <div className="flex flex-col items-center text-center py-3">
                                <div className="relative w-32 h-20 flex items-center justify-center mb-1">
                                    <img 
                                        src="/images/dashboard/robot_ai_2x.png" 
                                        alt="Robot IA" 
                                        className="h-16 w-auto object-contain drop-shadow-md"
                                    />
                                </div>

                                <h4 className="text-sm font-black text-slate-900 mt-1">
                                    Hola, soy tu asistente de IA
                                </h4>
                                <p className="text-[11px] text-slate-400 mt-1 max-w-[250px] leading-relaxed">
                                    Puedo ayudarte a crear planes, responder dudas de tus clientes, analizar datos y recomendar la mejor opción de salud para cada mascota.
                                </p>
                            </div>

                            {/* 4 Quick Action Prompt Cards with Circle Icons */}
                            <div className="space-y-2 mt-2">
                                
                                <button 
                                    type="button" 
                                    onClick={() => handlePromptClick('Recomienda un plan ideal para un perro adulto')}
                                    className="w-full text-left p-2 rounded-xl border border-slate-200/80 hover:border-cyan-400 bg-white hover:bg-cyan-50/40 flex items-center gap-2.5 transition duration-150 group shadow-2xs"
                                >
                                    <div className="w-7 h-7 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs shrink-0 font-bold">
                                        👤
                                    </div>
                                    <span className="flex-1 text-[11px] font-semibold text-slate-700 text-left leading-tight">
                                        Recomienda un plan ideal para un perro adulto
                                    </span>
                                    <ChevronRight className="w-4 h-4 text-slate-400 group-hover:translate-x-0.5 transition" />
                                </button>

                                <button 
                                    type="button" 
                                    onClick={() => handlePromptClick('Responde dudas sobre coberturas y exclusiones')}
                                    className="w-full text-left p-2 rounded-xl border border-slate-200/80 hover:border-cyan-400 bg-white hover:bg-cyan-50/40 flex items-center gap-2.5 transition duration-150 group shadow-2xs"
                                >
                                    <div className="w-7 h-7 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs shrink-0 font-bold">
                                        💬
                                    </div>
                                    <span className="flex-1 text-[11px] font-semibold text-slate-700 text-left leading-tight">
                                        Responde dudas sobre coberturas y exclusiones
                                    </span>
                                    <ChevronRight className="w-4 h-4 text-slate-400 group-hover:translate-x-0.5 transition" />
                                </button>

                                <button 
                                    type="button" 
                                    onClick={() => handlePromptClick('Analiza la base de clientes y detecta oportunidades')}
                                    className="w-full text-left p-2 rounded-xl border border-slate-200/80 hover:border-cyan-400 bg-white hover:bg-cyan-50/40 flex items-center gap-2.5 transition duration-150 group shadow-2xs"
                                >
                                    <div className="w-7 h-7 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs shrink-0 font-bold">
                                        📊
                                    </div>
                                    <span className="flex-1 text-[11px] font-semibold text-slate-700 text-left leading-tight">
                                        Analiza la base de clientes y detecta oportunidades
                                    </span>
                                    <ChevronRight className="w-4 h-4 text-slate-400 group-hover:translate-x-0.5 transition" />
                                </button>

                                <button 
                                    type="button" 
                                    onClick={() => handlePromptClick('Genera un plan de fidelización para tus clientes')}
                                    className="w-full text-left p-2 rounded-xl border border-slate-200/80 hover:border-cyan-400 bg-white hover:bg-cyan-50/40 flex items-center gap-2.5 transition duration-150 group shadow-2xs"
                                >
                                    <div className="w-7 h-7 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs shrink-0 font-bold">
                                        💡
                                    </div>
                                    <span className="flex-1 text-[11px] font-semibold text-slate-700 text-left leading-tight">
                                        Genera un plan de fidelización para tus clientes
                                    </span>
                                    <ChevronRight className="w-4 h-4 text-slate-400 group-hover:translate-x-0.5 transition" />
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
                                                    ? 'bg-blue-600 text-white font-medium ml-auto max-w-[85%]' 
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
                                    className="w-full text-xs rounded-full border border-slate-200 bg-slate-50 text-slate-900 pr-9 pl-3.5 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition shadow-2xs placeholder:text-slate-400"
                                />
                                <button 
                                    type="submit" 
                                    className="absolute right-1 w-6 h-6 rounded-full bg-[#1e3a8a] hover:bg-blue-900 text-white flex items-center justify-center text-xs font-bold transition shadow-xs"
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
