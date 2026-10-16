import React from 'react';
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
    Users
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
    petsTrend = 14,
    mrr = 198000,
    mrrTrend = 100,
    gmv = 520000,
    gmvTrend = 18,
    totalProspectos = 237,
    demosProximas = 0,
    cobrosPendientes = 0,
    mrrHistory = [],
    planDistribution = [],
    totalAfiliados = 8,
    recentActivities = [],
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
    const maxRev = Math.max(...mrrHistory.map(p => p.revenue), 200000);
    const yMax = Math.ceil((maxRev * 1.25) / 50000) * 50000;
    const yGridTicks = [
        { label: formatCurrency(yMax), y: 20 },
        { label: formatCurrency(Math.round(yMax * 0.75)), y: 65 },
        { label: formatCurrency(Math.round(yMax * 0.5)), y: 110 },
        { label: formatCurrency(Math.round(yMax * 0.25)), y: 155 },
        { label: '$0', y: 200 },
    ];

    const chartPoints = mrrHistory.map((pt, idx) => {
        const x = 85 + idx * 95;
        // Scale y between 200 (bottom, revenue=0) and 20 (top, revenue=yMax)
        const normalized = yMax > 0 ? pt.revenue / yMax : 0;
        const y = Math.round(200 - normalized * 180);
        return { ...pt, x, y };
    });

    const pathData = chartPoints.reduce((acc, curr, idx, arr) => {
        if (idx === 0) return `M ${curr.x} ${curr.y}`;
        const prev = arr[idx - 1];
        const midX = (prev.x + curr.x) / 2;
        return `${acc} C ${midX} ${prev.y}, ${midX} ${curr.y}, ${curr.x} ${curr.y}`;
    }, '');

    const lastPoint = chartPoints[chartPoints.length - 1] || { x: 550, y: 57, revenue: mrr };
    const firstPoint = chartPoints[0] || { x: 85, y: 200 };
    const areaPath = pathData ? `${pathData} L ${lastPoint.x} 200 L ${firstPoint.x} 200 Z` : '';

    // Dynamic Donut Segments
    const circumference = 345.57; // 2 * Math.PI * 55
    let currentDonutOffset = 0;
    const donutSegments = planDistribution.map((item) => {
        const strokeDash = `${(item.percentage / 100) * circumference} ${circumference}`;
        const strokeOffset = -currentDonutOffset;
        currentDonutOffset += (item.percentage / 100) * circumference;
        return {
            ...item,
            strokeDash,
            strokeOffset
        };
    });

    return (
        <SuperAdminLayout userName={userName} userEmail={userEmail} activeItem="Escritorio">
            <Head title="Centro de Control · AVI Pet Superadmin" />

            <div className="space-y-6 w-full">

                {/* 1. HEADER */}
                <div>
                    <h1 className="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Centro de control
                    </h1>
                    <p className="text-sm text-slate-500 mt-0.5">
                        Resumen de la red AVI Pet en tiempo real
                    </p>
                </div>

                {/* 2. ROW 1: 4 METRIC CARDS */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 w-full">
                    
                    {/* Card 1: Clínicas Activas */}
                    <div className="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs hover:shadow-md transition">
                        <div className="flex items-center gap-3.5">
                            <div className="w-12 h-12 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                                <Building2 className="w-6 h-6" />
                            </div>
                            <div>
                                <div className="text-xs font-semibold text-slate-500">
                                    Clínicas activas
                                </div>
                                <div className="text-2xl font-black text-slate-900 leading-tight mt-0.5">
                                    {clinicasActivas}
                                </div>
                                <div className="flex items-center gap-1 text-[11px] font-bold text-teal-600 mt-1">
                                    <span>↑ {clinicasTrend}%</span>
                                    <span className="text-slate-400 font-normal">vs. mes anterior</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Card 2: Mascotas con membresía */}
                    <div className="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs hover:shadow-md transition">
                        <div className="flex items-center gap-3.5">
                            <div className="w-12 h-12 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                                <PawPrint className="w-6 h-6" />
                            </div>
                            <div>
                                <div className="text-xs font-semibold text-slate-500">
                                    Mascotas con membresía
                                </div>
                                <div className="text-2xl font-black text-slate-900 leading-tight mt-0.5">
                                    {mascotasConMembresia}
                                </div>
                                <div className="flex items-center gap-1 text-[11px] font-bold text-teal-600 mt-1">
                                    <span>↑ {petsTrend}%</span>
                                    <span className="text-slate-400 font-normal">vs. mes anterior</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Card 3: MRR */}
                    <div className="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs hover:shadow-md transition">
                        <div className="flex items-center gap-3.5">
                            <div className="w-12 h-12 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                                <DollarSign className="w-6 h-6" />
                            </div>
                            <div>
                                <div className="text-xs font-semibold text-slate-500">
                                    MRR
                                </div>
                                <div className="text-2xl font-black text-slate-900 leading-tight mt-0.5">
                                    {formatCurrency(mrr)} <span className="text-xs font-bold text-slate-500">COP</span>
                                </div>
                                <div className="flex items-center gap-1 text-[11px] font-bold text-teal-600 mt-1">
                                    <span>↑ {mrrTrend}%</span>
                                    <span className="text-slate-400 font-normal">vs. mes anterior</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Card 4: GMV mensual */}
                    <div className="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs hover:shadow-md transition">
                        <div className="flex items-center gap-3.5">
                            <div className="w-12 h-12 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                                <BarChart3 className="w-6 h-6" />
                            </div>
                            <div>
                                <div className="text-xs font-semibold text-slate-500">
                                    GMV mensual
                                </div>
                                <div className="text-2xl font-black text-slate-900 leading-tight mt-0.5">
                                    {formatCurrency(gmv)} <span className="text-xs font-bold text-slate-500">COP</span>
                                </div>
                                <div className="flex items-center gap-1 text-[11px] font-bold text-teal-600 mt-1">
                                    <span>↑ {gmvTrend}%</span>
                                    <span className="text-slate-400 font-normal">vs. mes anterior</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {/* 3. ROW 2: TWO ANALYTICS CHARTS */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-5 w-full">

                    {/* Left Chart: Ingresos Recurrentes (MRR Dinámico 6 Meses) */}
                    <div className="bg-white rounded-2xl border border-slate-200/90 p-5 sm:p-6 shadow-xs flex flex-col justify-between">
                        <div className="flex items-center justify-between mb-4">
                            <div className="flex items-center gap-2.5">
                                <div className="w-7 h-7 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                                    <TrendingUp className="w-4 h-4" />
                                </div>
                                <div>
                                    <h3 className="text-sm font-bold text-slate-900 leading-tight">
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

                        {/* Area Chart SVG dinámico */}
                        <div className="w-full pt-2">
                            <svg viewBox="0 0 600 240" className="w-full h-auto overflow-visible" preserveAspectRatio="none">
                                <defs>
                                    <linearGradient id="reactMrrTealGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                        <stop offset="0%" stopColor="#0d9488" stopOpacity="0.22" />
                                        <stop offset="100%" stopColor="#0d9488" stopOpacity="0.01" />
                                    </linearGradient>
                                </defs>

                                {/* Dynamic Grid Lines & Labels */}
                                {yGridTicks.map((tick, i) => (
                                    <g key={i}>
                                        <text x="50" y={tick.y + 4} fill="#94a3b8" fontSize="10.5" textAnchor="end" fontWeight="500">
                                            {tick.label}
                                        </text>
                                        <line 
                                            x1="60" 
                                            y1={tick.y} 
                                            x2="580" 
                                            y2={tick.y} 
                                            stroke={i === yGridTicks.length - 1 ? "#e2e8f0" : "#f1f5f9"} 
                                            strokeWidth="1" 
                                            strokeDasharray={i === yGridTicks.length - 1 ? "0" : "3 3"} 
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
                                        stroke="#0d9488" 
                                        strokeWidth="2.8" 
                                        strokeLinecap="round" 
                                        strokeLinejoin="round" 
                                    />
                                )}

                                {/* Points */}
                                {chartPoints.map((pt, i) => (
                                    <circle key={i} cx={pt.x} cy={pt.y} r={i === chartPoints.length - 1 ? 5 : 4} fill="#0d9488" stroke="#ffffff" strokeWidth={i === chartPoints.length - 1 ? 2.5 : 2} />
                                ))}

                                {/* Current value tooltip badge */}
                                <g transform={`translate(${lastPoint.x - 35}, ${lastPoint.y - 35})`}>
                                    <rect x="0" y="0" width="70" height="24" rx="6" fill="#0f766e" />
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

                    {/* Right Chart: Distribución de Membresías por Plan (Donut) */}
                    <div className="bg-white rounded-2xl border border-slate-200/90 p-5 sm:p-6 shadow-xs flex flex-col justify-between">
                        <div className="flex items-center justify-between mb-4">
                            <div className="flex items-center gap-2.5">
                                <div className="w-7 h-7 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                                    <BarChart3 className="w-4 h-4" />
                                </div>
                                <div>
                                    <h3 className="text-sm font-bold text-slate-900 leading-tight">
                                        Distribución de membresías por plan
                                    </h3>
                                    <p className="text-xs text-slate-400 mt-0.5">
                                        Participación de afiliados en cada plan
                                    </p>
                                </div>
                            </div>

                            <span className="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold text-slate-600 bg-slate-50 border border-slate-200 rounded-lg">
                                <span>{totalAfiliados} afiliados · {clinicasActivas} clínicas</span>
                            </span>
                        </div>

                        {/* Donut + Legend */}
                        <div className="grid grid-cols-1 sm:grid-cols-2 items-center gap-6 py-2">
                            {/* Donut SVG */}
                            <div className="flex items-center justify-center">
                                <div className="relative w-44 h-44">
                                    <svg viewBox="0 0 160 160" className="w-full h-full transform -rotate-90">
                                        {donutSegments.map((seg, i) => (
                                            <circle 
                                                key={i}
                                                cx="80" cy="80" r="55"
                                                fill="transparent"
                                                stroke={seg.color}
                                                strokeWidth="24"
                                                strokeDasharray={seg.strokeDash}
                                                strokeDashoffset={seg.strokeOffset} 
                                            />
                                        ))}
                                    </svg>

                                    <div className="absolute inset-0 flex flex-col items-center justify-center text-center pointer-events-none">
                                        <span className="text-2xl font-black text-slate-900 leading-tight">
                                            {totalAfiliados}
                                        </span>
                                        <span className="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                                            afiliados
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {/* Legend */}
                            <div className="space-y-2.5">
                                {planDistribution.map((item, idx) => (
                                    <div key={idx} className="flex items-center justify-between text-xs py-1 border-b border-slate-50 last:border-0">
                                        <div className="flex items-center gap-2">
                                            <span className="w-2.5 h-2.5 rounded-full shrink-0" style={{ backgroundColor: item.color }} />
                                            <span className="font-semibold text-slate-700 truncate max-w-[110px]">{item.name}</span>
                                        </div>
                                        <div className="flex items-center gap-2">
                                            <span className="text-slate-400 font-mono text-[11px]">{item.count} afil.</span>
                                            <span className="font-bold text-slate-900">{item.percentage}%</span>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>

                </div>

                {/* 5. ROW 4: ACTIVIDAD RECIENTE REAL */}
                <div className="space-y-3 w-full">
                    <div className="flex items-center justify-between">
                        <div className="flex items-center gap-2">
                            <div className="w-6 h-6 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                                <Clock className="w-3.5 h-3.5" />
                            </div>
                            <div>
                                <h3 className="text-sm font-bold text-slate-900 leading-tight">
                                    Actividad reciente
                                </h3>
                                <p className="text-xs text-slate-400">
                                    Eventos reales registrados en la plataforma
                                </p>
                            </div>
                        </div>

                        <a href="/super-admin/tenants" className="text-xs font-bold text-teal-600 hover:text-teal-700 inline-flex items-center gap-1 transition">
                            <span>Ver todas</span>
                            <span>&rarr;</span>
                        </a>
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-3 gap-4 w-full">
                        {recentActivities.map((act) => (
                            <div key={act.id} className="bg-white rounded-xl border border-slate-200/90 p-4 shadow-xs flex items-start gap-3 transition hover:shadow-sm">
                                {act.type === 'clinic' && (
                                    <div className="w-9 h-9 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                                        <Building2 className="w-5 h-5" />
                                    </div>
                                )}
                                {act.type === 'user' && (
                                    <div className="w-9 h-9 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                                        <UserCheck className="w-5 h-5" />
                                    </div>
                                )}
                                {act.type === 'payment' && (
                                    <div className="w-9 h-9 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                                        <CreditCard className="w-5 h-5" />
                                    </div>
                                )}

                                <div className="flex-1 min-w-0">
                                    <h4 className="text-xs font-bold text-slate-800 truncate">
                                        {act.title}
                                    </h4>
                                    <p className="text-xs text-slate-500 mt-0.5 line-clamp-2">
                                        {act.description}
                                    </p>
                                    <span className="text-[10.5px] text-slate-400 mt-1 block">
                                        {act.time}
                                    </span>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>

            </div>
        </SuperAdminLayout>
    );
}
