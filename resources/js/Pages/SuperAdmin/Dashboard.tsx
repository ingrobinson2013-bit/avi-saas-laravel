import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/react';
import SuperAdminLayout from '@/Layouts/SuperAdminLayout';
import { 
    Building2, 
    PawPrint, 
    DollarSign, 
    BarChart3, 
    Filter, 
    Calendar, 
    CreditCard, 
    Clock, 
    ChevronDown, 
    TrendingUp,
    UserCheck,
    CheckCircle2,
    Users,
    FileText,
    Plus,
    ArrowRight
} from 'lucide-react';

interface ActivityItem {
    id: string;
    type: 'clinic' | 'user' | 'payment';
    title: string;
    description: string;
    time: string;
}

interface PlanDistItem {
    name: string;
    count: number;
    percentage: number;
    color: string;
}

interface MrrPoint {
    month: string;
    revenue: number;
}

interface DashboardProps {
    clinicasActivas?: number;
    clinicasTrend?: number;
    mascotasConMembresia?: number;
    petsTrend?: number;
    mrr?: number;
    mrrTrend?: number;
    gmv?: number;
    gmvTrend?: number;
    totalProspectos?: number;
    demosProximas?: number;
    cobrosPendientes?: number;
    mrrHistory?: MrrPoint[];
    planDistribution?: PlanDistItem[];
    totalAfiliados?: number;
    recentActivities?: ActivityItem[];
    userName?: string;
    userEmail?: string;
}

export default function Dashboard({
    clinicasActivas = 2,
    clinicasTrend = 100,
    mascotasConMembresia = 8,
    petsTrend = 33,
    mrr = 198000,
    mrrTrend = 12,
    gmv = 520000,
    gmvTrend = 18,
    totalProspectos = 237,
    demosProximas = 0,
    cobrosPendientes = 0,
    mrrHistory = [
        { month: 'May 2025', revenue: 45000 },
        { month: 'Jun 2025', revenue: 75000 },
        { month: 'Jul 2025', revenue: 98000 },
        { month: 'Ago 2025', revenue: 125000 },
        { month: 'Sep 2025', revenue: 160000 },
        { month: 'Oct 2025', revenue: 198000 },
    ],
    planDistribution = [
        { name: 'Plan Básico', count: 1, percentage: 50, color: '#009e99' },
        { name: 'Plan Premium', count: 1, percentage: 50, color: '#784fe8' },
    ],
    totalAfiliados = 2,
    recentActivities = [
        {
            id: '1',
            type: 'clinic',
            title: 'Nueva clínica',
            description: 'Clínica Patitas Felices se registró en la plataforma',
            time: '12 oct 2025 · 10:24 a. m.'
        },
        {
            id: '2',
            type: 'user',
            title: 'Nuevo usuario',
            description: 'Dra. Camila Torres fue agregada como doctora',
            time: '11 oct 2025 · 4:32 p. m.'
        },
        {
            id: '3',
            type: 'payment',
            title: 'Pago recibido',
            description: 'Membresía Plan Premium - Clínica VetSalud',
            time: '10 oct 2025 · 9:15 a. m.'
        }
    ],
    userName = 'Robinson Naranjo',
    userEmail = 'superadmin@avipetapp.com'
}: DashboardProps) {

    const formatCurrency = (val: number) => {
        return new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            maximumFractionDigits: 0
        }).format(val);
    };

    // Calculate dynamic coordinates for 6 months MRR area curve
    // Scale matching the mockup ticks: $350k, $262.5k, $175k, $87.5k, $0
    const yMax = 350000;
    const yTicks = [
        { label: '$350.000', y: 20 },
        { label: '$262.500', y: 65 },
        { label: '$175.000', y: 110 },
        { label: '$87.500', y: 155 },
        { label: '$0', y: 200 },
    ];

    const chartPoints = mrrHistory.map((pt, idx) => {
        const x = 70 + idx * 95;
        // Scale y between 200 (bottom, revenue=0) and 20 (top, revenue=350k)
        const normalized = pt.revenue / yMax;
        const y = Math.round(200 - normalized * 180);
        return { ...pt, x, y };
    });

    const pathData = chartPoints.reduce((acc, curr, idx, arr) => {
        if (idx === 0) return `M ${curr.x} ${curr.y}`;
        const prev = arr[idx - 1];
        const midX = (prev.x + curr.x) / 2;
        return `${acc} C ${midX} ${prev.y}, ${midX} ${curr.y}, ${curr.x} ${curr.y}`;
    }, '');

    const lastPoint = chartPoints[chartPoints.length - 1] || { x: 545, y: 98, revenue: mrr };
    const firstPoint = chartPoints[0] || { x: 70, y: 177 };
    const areaPath = pathData ? `${pathData} L ${lastPoint.x} 200 L ${firstPoint.x} 200 Z` : '';

    return (
        <SuperAdminLayout userName={userName} userEmail={userEmail} activeItem="Escritorio">
            <Head title="Centro de control · AVI Pet Superadmin" />

            <div className="space-y-6 w-full max-w-full">

                {/* 1. HEADER */}
                <div>
                    <h1 className="text-2xl sm:text-3xl font-extrabold text-[#0f172a] tracking-tight">
                        Centro de control
                    </h1>
                    <p className="text-sm text-slate-500 mt-1">
                        Resumen de la red AVI Pet
                    </p>
                </div>

                {/* 2. ROW 1: 4 METRIC CARDS MATCHING REFERENCE MOCKUP */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 w-full">
                    
                    {/* Card 1: Clínicas Activas */}
                    <div className="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-[0_1px_3px_rgba(0,0,0,0.03)] hover:shadow-md transition">
                        <div className="flex items-center gap-4">
                            <div className="w-12 h-12 rounded-2xl bg-[#eafaf5] text-[#00a884] flex items-center justify-center shrink-0">
                                <Building2 className="w-6 h-6" />
                            </div>
                            <div>
                                <div className="text-xs font-semibold text-slate-500">
                                    Clínicas activas
                                </div>
                                <div className="text-2xl font-black text-[#0f172a] leading-tight mt-0.5">
                                    {clinicasActivas}
                                </div>
                                <div className="flex items-center gap-1.5 text-[11px] font-bold text-[#00a884] mt-1">
                                    <span>↑ {clinicasTrend}%</span>
                                    <span className="text-slate-400 font-normal">vs. mes anterior</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Card 2: Mascotas con membresía */}
                    <div className="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-[0_1px_3px_rgba(0,0,0,0.03)] hover:shadow-md transition">
                        <div className="flex items-center gap-4">
                            <div className="w-12 h-12 rounded-2xl bg-[#f2eefd] text-[#784fe8] flex items-center justify-center shrink-0">
                                <PawPrint className="w-6 h-6" />
                            </div>
                            <div>
                                <div className="text-xs font-semibold text-slate-500">
                                    Mascotas con membresía
                                </div>
                                <div className="text-2xl font-black text-[#0f172a] leading-tight mt-0.5">
                                    {mascotasConMembresia}
                                </div>
                                <div className="flex items-center gap-1.5 text-[11px] font-bold text-[#00a884] mt-1">
                                    <span>↑ {petsTrend}%</span>
                                    <span className="text-slate-400 font-normal">vs. mes anterior</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Card 3: MRR */}
                    <div className="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-[0_1px_3px_rgba(0,0,0,0.03)] hover:shadow-md transition">
                        <div className="flex items-center gap-4">
                            <div className="w-12 h-12 rounded-2xl bg-[#e6f7f6] text-[#009e99] flex items-center justify-center shrink-0">
                                <DollarSign className="w-6 h-6" />
                            </div>
                            <div>
                                <div className="text-xs font-semibold text-slate-500">
                                    MRR
                                </div>
                                <div className="text-2xl font-black text-[#0f172a] leading-tight mt-0.5">
                                    {formatCurrency(mrr)} <span className="text-xs font-bold text-slate-500">COP</span>
                                </div>
                                <div className="flex items-center gap-1.5 text-[11px] font-bold text-[#00a884] mt-1">
                                    <span>↑ {mrrTrend}%</span>
                                    <span className="text-slate-400 font-normal">vs. mes anterior</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Card 4: GMV mensual */}
                    <div className="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-[0_1px_3px_rgba(0,0,0,0.03)] hover:shadow-md transition">
                        <div className="flex items-center gap-4">
                            <div className="w-12 h-12 rounded-2xl bg-[#f1eefd] text-[#845ef7] flex items-center justify-center shrink-0">
                                <BarChart3 className="w-6 h-6" />
                            </div>
                            <div>
                                <div className="text-xs font-semibold text-slate-500">
                                    GMV mensual
                                </div>
                                <div className="text-2xl font-black text-[#0f172a] leading-tight mt-0.5">
                                    {formatCurrency(gmv)} <span className="text-xs font-bold text-slate-500">COP</span>
                                </div>
                                <div className="flex items-center gap-1.5 text-[11px] font-bold text-[#00a884] mt-1">
                                    <span>↑ {gmvTrend}%</span>
                                    <span className="text-slate-400 font-normal">vs. mes anterior</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {/* 3. ROW 2: PIPELINE COMERCIAL MATCHING REFERENCE MOCKUP */}
                <div className="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-[0_1px_3px_rgba(0,0,0,0.03)] w-full">
                    <div className="flex flex-col lg:flex-row items-center justify-between gap-6">

                        {/* Left Column: Header */}
                        <div className="w-full lg:w-1/4">
                            <div className="flex items-center gap-3">
                                <div className="w-9 h-9 rounded-xl bg-[#eafaf5] text-[#00a884] flex items-center justify-center shrink-0">
                                    <Filter className="w-5 h-5" />
                                </div>
                                <div>
                                    <h3 className="text-sm sm:text-base font-bold text-[#0f172a] leading-tight">
                                        Pipeline comercial
                                    </h3>
                                    <p className="text-xs text-slate-500 mt-0.5">
                                        Gestiona tus oportunidades y haz crecer la red de clínicas.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {/* Middle Column: Opportunity State */}
                        <div className="w-full lg:w-1/2 flex flex-col items-center text-center px-4">
                            <div className="flex flex-col items-center">
                                {/* Illustration icon with plus badge matching mockup */}
                                <div className="relative mb-2">
                                    <div className="w-10 h-12 rounded-lg bg-sky-50 border border-sky-200/80 flex flex-col justify-center px-2 py-1.5 gap-1.5 shadow-2xs">
                                        <div className="h-1 bg-sky-300 rounded-sm w-3/4" />
                                        <div className="h-1 bg-sky-300 rounded-sm w-full" />
                                        <div className="h-1 bg-sky-300 rounded-sm w-2/3" />
                                    </div>
                                    <div className="absolute -bottom-1 -right-1.5 w-5 h-5 rounded-full bg-[#008b82] text-white flex items-center justify-center font-black text-xs shadow-xs ring-2 ring-white">
                                        +
                                    </div>
                                </div>

                                <h4 className="text-sm font-bold text-[#0f172a]">
                                    No hay oportunidades registradas
                                </h4>
                                <p className="text-xs text-slate-500 max-w-sm mt-1 leading-relaxed">
                                    Aún no tienes demos, leads u oportunidades en el pipeline comercial. Empieza a generar nuevas oportunidades para hacer crecer AVI Pet.
                                </p>
                                <a
                                    href="/super-admin/prospecto-veterinarias"
                                    className="mt-3.5 inline-flex items-center gap-1.5 px-4 py-2 bg-[#00736e] hover:bg-[#005f5b] active:bg-[#004e4a] text-white text-xs font-bold rounded-lg shadow-sm transition hover:scale-102 cursor-pointer"
                                >
                                    <span>Registrar oportunidad</span>
                                    <span>&rarr;</span>
                                </a>
                            </div>
                        </div>

                        {/* Right Column: Counters with divider */}
                        <div className="w-full lg:w-1/4 flex items-center justify-around lg:justify-end gap-6 sm:gap-8 pt-4 lg:pt-0 border-t lg:border-t-0 lg:border-l border-slate-100 lg:pl-6">
                            {/* Demos Próximas */}
                            <div className="flex items-center gap-3">
                                <div className="w-10 h-10 rounded-xl bg-[#eafaf5] text-[#00a884] flex items-center justify-center shrink-0">
                                    <Calendar className="w-5 h-5" />
                                </div>
                                <div>
                                    <div className="text-xs text-slate-500">
                                        Demos próximas
                                    </div>
                                    <div className="text-2xl font-black text-[#0f172a] leading-tight">
                                        {demosProximas}
                                    </div>
                                </div>
                            </div>

                            {/* Cobros Pendientes */}
                            <div className="flex items-center gap-3">
                                <div className="w-10 h-10 rounded-xl bg-[#eafaf5] text-[#00a884] flex items-center justify-center shrink-0">
                                    <CreditCard className="w-5 h-5" />
                                </div>
                                <div>
                                    <div className="text-xs text-slate-500">
                                        Cobros pendientes
                                    </div>
                                    <div className="text-2xl font-black text-[#0f172a] leading-tight">
                                        {cobrosPendientes}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {/* 4. ROW 3: TWO ANALYTICS CHARTS MATCHING REFERENCE MOCKUP */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-5 w-full">

                    {/* Left Chart: Ingresos Recurrentes (MRR Spline) */}
                    <div className="bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 shadow-[0_1px_3px_rgba(0,0,0,0.03)] flex flex-col justify-between">
                        <div className="flex items-center justify-between mb-2">
                            <div className="flex items-center gap-2.5">
                                <div className="w-8 h-8 rounded-lg bg-[#eafaf5] text-[#00a884] flex items-center justify-center shrink-0">
                                    <TrendingUp className="w-4 h-4" />
                                </div>
                                <div>
                                    <h3 className="text-sm font-bold text-[#0f172a] leading-tight">
                                        Ingresos recurrentes
                                    </h3>
                                    <p className="text-xs text-slate-400 mt-0.5">
                                        MRR en los últimos 6 meses
                                    </p>
                                </div>
                            </div>

                            <span className="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold text-slate-600 bg-slate-50 border border-slate-200 rounded-lg cursor-pointer">
                                <span>Últimos 6 meses</span>
                                <ChevronDown className="w-3.5 h-3.5 text-slate-400" />
                            </span>
                        </div>

                        {/* Area Chart SVG */}
                        <div className="w-full pt-2">
                            <svg viewBox="0 0 600 240" className="w-full h-auto overflow-visible" preserveAspectRatio="none">
                                <defs>
                                    <linearGradient id="reactMrrTealGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                        <stop offset="0%" stopColor="#00a884" stopOpacity="0.22" />
                                        <stop offset="100%" stopColor="#00a884" stopOpacity="0.01" />
                                    </linearGradient>
                                </defs>

                                {/* Grid Lines & Labels matching mockup */}
                                {yTicks.map((tick, i) => (
                                    <g key={i}>
                                        <text x="50" y={tick.y + 4} fill="#94a3b8" fontSize="10.5" textAnchor="end" fontWeight="500">
                                            {tick.label}
                                        </text>
                                        <line 
                                            x1="60" 
                                            y1={tick.y} 
                                            x2="580" 
                                            y2={tick.y} 
                                            stroke={i === yTicks.length - 1 ? "#e2e8f0" : "#f1f5f9"} 
                                            strokeWidth="1" 
                                            strokeDasharray={i === yTicks.length - 1 ? "0" : "3 3"} 
                                        />
                                    </g>
                                ))}

                                {/* Area Curve */}
                                {areaPath && (
                                    <path 
                                        d={areaPath}
                                        fill="url(#reactMrrTealGradient)" 
                                    />
                                )}

                                {/* Spline Line */}
                                {pathData && (
                                    <path 
                                        d={pathData}
                                        fill="none" 
                                        stroke="#00a884" 
                                        strokeWidth="2.8" 
                                        strokeLinecap="round" 
                                        strokeLinejoin="round" 
                                    />
                                )}

                                {/* Points */}
                                {chartPoints.map((pt, i) => (
                                    <circle key={i} cx={pt.x} cy={pt.y} r={i === chartPoints.length - 1 ? 5 : 4} fill="#00a884" stroke="#ffffff" strokeWidth={i === chartPoints.length - 1 ? 2.5 : 2} />
                                ))}

                                {/* Current value tooltip badge matching mockup */}
                                <g transform={`translate(${lastPoint.x - 35}, ${lastPoint.y - 35})`}>
                                    <rect x="0" y="0" width="70" height="24" rx="6" fill="#00736e" />
                                    <text x="35" y="16" fill="#ffffff" fontSize="11" fontWeight="bold" textAnchor="middle">{formatCurrency(lastPoint.revenue)}</text>
                                </g>

                                {/* Month labels */}
                                {chartPoints.map((pt, i) => (
                                    <text key={i} x={pt.x} y="222" fill="#94a3b8" fontSize="10.5" textAnchor="middle" fontWeight="500">
                                        {pt.month}
                                    </text>
                                ))}
                            </svg>
                        </div>
                    </div>

                    {/* Right Chart: Distribución de clínicas por plan (Donut) matching mockup */}
                    <div className="bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 shadow-[0_1px_3px_rgba(0,0,0,0.03)] flex flex-col justify-between">
                        <div className="flex items-center justify-between mb-4">
                            <div className="flex items-center gap-2.5">
                                <div className="w-8 h-8 rounded-lg bg-[#eafaf5] text-[#00a884] flex items-center justify-center shrink-0">
                                    <BarChart3 className="w-4 h-4" />
                                </div>
                                <div>
                                    <h3 className="text-sm font-bold text-[#0f172a] leading-tight">
                                        Distribución de clínicas por plan
                                    </h3>
                                    <p className="text-xs text-slate-400 mt-0.5">
                                        Participación de clínicas en cada plan
                                    </p>
                                </div>
                            </div>

                            <span className="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold text-slate-600 bg-slate-50 border border-slate-200 rounded-lg cursor-pointer">
                                <span>{clinicasActivas} clínicas</span>
                                <ChevronDown className="w-3.5 h-3.5 text-slate-400" />
                            </span>
                        </div>

                        {/* Donut + Legend */}
                        <div className="grid grid-cols-1 sm:grid-cols-2 items-center gap-6 py-2">
                            {/* Donut SVG */}
                            <div className="flex items-center justify-center">
                                <div className="relative w-44 h-44">
                                    <svg viewBox="0 0 160 160" className="w-full h-full transform -rotate-90">
                                        {/* Purple segment */}
                                        <circle 
                                            cx="80" cy="80" r="55"
                                            fill="transparent"
                                            stroke="#784fe8"
                                            strokeWidth="24"
                                            strokeDasharray="172.8 172.8"
                                            strokeDashoffset="0" 
                                        />
                                        {/* Teal segment */}
                                        <circle 
                                            cx="80" cy="80" r="55"
                                            fill="transparent"
                                            stroke="#009e99"
                                            strokeWidth="24"
                                            strokeDasharray="172.8 172.8"
                                            strokeDashoffset="172.8" 
                                        />
                                    </svg>

                                    {/* Segment Percentage badges inside segments matching mockup */}
                                    <div className="absolute inset-0 flex items-center justify-between px-3 pointer-events-none">
                                        <span className="text-white font-bold text-xs pl-0.5">50%</span>
                                        <span className="text-white font-bold text-xs pr-0.5">50%</span>
                                    </div>

                                    {/* Donut Center */}
                                    <div className="absolute inset-0 flex flex-col items-center justify-center text-center pointer-events-none">
                                        <span className="text-2xl font-black text-[#0f172a] leading-tight">
                                            {clinicasActivas}
                                        </span>
                                        <span className="text-[11px] font-semibold text-slate-400">
                                            clínicas
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {/* Legend matching mockup */}
                            <div className="space-y-3">
                                <div className="flex items-center justify-between text-xs py-1.5 border-b border-slate-100">
                                    <div className="flex items-center gap-2.5">
                                        <span className="w-2.5 h-2.5 rounded-full shrink-0 bg-[#009e99]" />
                                        <span className="font-semibold text-slate-700">Plan Básico</span>
                                    </div>
                                    <div className="flex items-center gap-4">
                                        <span className="text-slate-400 font-medium">1 clínica</span>
                                        <span className="font-bold text-[#0f172a]">50%</span>
                                    </div>
                                </div>

                                <div className="flex items-center justify-between text-xs py-1.5">
                                    <div className="flex items-center gap-2.5">
                                        <span className="w-2.5 h-2.5 rounded-full shrink-0 bg-[#784fe8]" />
                                        <span className="font-semibold text-slate-700">Plan Premium</span>
                                    </div>
                                    <div className="flex items-center gap-4">
                                        <span className="text-slate-400 font-medium">1 clínica</span>
                                        <span className="font-bold text-[#0f172a]">50%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {/* 5. ROW 4: ACTIVIDAD RECIENTE MATCHING REFERENCE MOCKUP */}
                <div className="space-y-3 w-full">
                    <div className="flex items-center justify-between">
                        <div className="flex items-center gap-2.5">
                            <div className="w-7 h-7 rounded-full bg-[#eafaf5] text-[#00a884] flex items-center justify-center shrink-0">
                                <Clock className="w-4 h-4" />
                            </div>
                            <div>
                                <h3 className="text-sm font-bold text-[#0f172a] leading-tight">
                                    Actividad reciente
                                </h3>
                                <p className="text-xs text-slate-400 mt-0.5">
                                    Últimos eventos en la plataforma
                                </p>
                            </div>
                        </div>

                        <a 
                            href="/super-admin/tenants" 
                            className="text-xs font-bold text-[#00a884] hover:text-[#00736e] inline-flex items-center gap-1 transition"
                        >
                            <span>Ver todas</span>
                            <span>&rarr;</span>
                        </a>
                    </div>

                    {/* 3 Activity Cards matching mockup */}
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                        {/* Activity 1 */}
                        <div className="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-[0_1px_3px_rgba(0,0,0,0.03)] flex items-start gap-3.5 hover:shadow-md transition">
                            <div className="w-10 h-10 rounded-xl bg-[#eafaf5] text-[#00a884] flex items-center justify-center shrink-0">
                                <Building2 className="w-5 h-5" />
                            </div>
                            <div className="flex-1 min-w-0">
                                <div className="text-xs font-bold text-[#0f172a]">
                                    {recentActivities[0]?.title || 'Nueva clínica'}
                                </div>
                                <div className="text-xs text-slate-500 truncate mt-0.5">
                                    {recentActivities[0]?.description || 'Clínica Patitas Felices se registró en la plataforma'}
                                </div>
                                <div className="text-[10.5px] text-slate-400 mt-1">
                                    {recentActivities[0]?.time || '12 oct 2025 · 10:24 a. m.'}
                                </div>
                            </div>
                        </div>

                        {/* Activity 2 */}
                        <div className="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-[0_1px_3px_rgba(0,0,0,0.03)] flex items-start gap-3.5 hover:shadow-md transition">
                            <div className="w-10 h-10 rounded-xl bg-[#f2eefd] text-[#784fe8] flex items-center justify-center shrink-0">
                                <Users className="w-5 h-5" />
                            </div>
                            <div className="flex-1 min-w-0">
                                <div className="text-xs font-bold text-[#0f172a]">
                                    {recentActivities[1]?.title || 'Nuevo usuario'}
                                </div>
                                <div className="text-xs text-slate-500 truncate mt-0.5">
                                    {recentActivities[1]?.description || 'Dra. Camila Torres fue agregada como doctora'}
                                </div>
                                <div className="text-[10.5px] text-slate-400 mt-1">
                                    {recentActivities[1]?.time || '11 oct 2025 · 4:32 p. m.'}
                                </div>
                            </div>
                        </div>

                        {/* Activity 3 */}
                        <div className="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-[0_1px_3px_rgba(0,0,0,0.03)] flex items-start gap-3.5 hover:shadow-md transition">
                            <div className="w-10 h-10 rounded-xl bg-[#e6f7f6] text-[#009e99] flex items-center justify-center shrink-0">
                                <CreditCard className="w-5 h-5" />
                            </div>
                            <div className="flex-1 min-w-0">
                                <div className="text-xs font-bold text-[#0f172a]">
                                    {recentActivities[2]?.title || 'Pago recibido'}
                                </div>
                                <div className="text-xs text-slate-500 truncate mt-0.5">
                                    {recentActivities[2]?.description || 'Membresía Plan Premium - Clínica VetSalud'}
                                </div>
                                <div className="text-[10.5px] text-slate-400 mt-1">
                                    {recentActivities[2]?.time || '10 oct 2025 · 9:15 a. m.'}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </SuperAdminLayout>
    );
}
