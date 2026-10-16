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
        { name: 'Plan Básico', count: 4, percentage: 50, color: '#0d9488' },
        { name: 'Plan Premium', count: 4, percentage: 50, color: '#7c3aed' },
    ],
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
    const chartPoints = mrrHistory.map((pt, idx) => {
        const x = 85 + idx * 95;
        // Scale y between 200 (bottom) and 60 (top)
        const normalized = pt.revenue / (maxRev * 1.25);
        const y = Math.round(200 - normalized * 140);
        return { ...pt, x, y };
    });

    const pathData = chartPoints.reduce((acc, curr, idx, arr) => {
        if (idx === 0) return `M ${curr.x} ${curr.y}`;
        const prev = arr[idx - 1];
        const midX = (prev.x + curr.x) / 2;
        return `${acc} C ${midX} ${prev.y}, ${midX} ${curr.y}, ${curr.x} ${curr.y}`;
    }, '');

    const lastPoint = chartPoints[chartPoints.length - 1] || { x: 550, y: 95, revenue: mrr };
    const firstPoint = chartPoints[0] || { x: 85, y: 190 };
    const areaPath = `${pathData} L ${lastPoint.x} 200 L ${firstPoint.x} 200 Z`;

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

                {/* 3. ROW 2: PIPELINE COMERCIAL CARD */}
                <div className="bg-white rounded-2xl border border-slate-200/90 p-6 shadow-xs w-full">
                    <div className="flex flex-col lg:flex-row items-center justify-between gap-6">

                        {/* Left Column: Header */}
                        <div className="w-full lg:w-1/4">
                            <div className="flex items-center gap-2.5">
                                <div className="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                                    <Filter className="w-5 h-5" />
                                </div>
                                <div>
                                    <h3 className="text-sm sm:text-base font-bold text-slate-900 leading-tight">
                                        Pipeline comercial
                                    </h3>
                                    <p className="text-xs text-slate-500 mt-0.5">
                                        Gestiona tus oportunidades y haz crecer la red de clínicas.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {/* Middle Column: State & Action */}
                        <div className="w-full lg:w-1/2 flex flex-col items-center text-center px-4">
                            {totalProspectos > 0 ? (
                                <div className="flex flex-col items-center">
                                    <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-50 text-teal-700 text-xs font-bold mb-2">
                                        <CheckCircle2 className="w-4 h-4 text-teal-600" />
                                        <span>{totalProspectos} veterinarias identificadas en base de datos</span>
                                    </div>
                                    <h4 className="text-sm font-bold text-slate-800">
                                        Base de prospección activa y lista para contacto
                                    </h4>
                                    <p className="text-xs text-slate-500 max-w-md mt-1 leading-relaxed">
                                        Tienes {totalProspectos} clínicas prospectadas en Colombia. Continúa gestionando llamadas, demos y cierres comerciales.
                                    </p>
                                    <a
                                        href="/super-admin/prospecto-veterinarias"
                                        className="mt-3.5 inline-flex items-center gap-1.5 px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white text-xs font-bold rounded-lg shadow-sm transition hover:scale-102"
                                    >
                                        <span>Gestionar prospección B2B</span>
                                        <span>&rarr;</span>
                                    </a>
                                </div>
                            ) : (
                                <div className="flex flex-col items-center">
                                    <div className="relative w-14 h-14 flex items-center justify-center mb-1">
                                        <div className="w-11 h-13 rounded-lg bg-slate-100 border border-slate-200 flex flex-col justify-center px-2 py-2 gap-1.5 shadow-2xs">
                                            <div className="h-1 bg-slate-300 rounded-sm w-3/4" />
                                            <div className="h-1 bg-slate-300 rounded-sm w-full" />
                                            <div className="h-1 bg-slate-300 rounded-sm w-2/3" />
                                        </div>
                                        <div className="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-teal-600 text-white flex items-center justify-center font-bold text-sm shadow-xs ring-2 ring-white">
                                            +
                                        </div>
                                    </div>
                                    <h4 className="text-sm font-bold text-slate-800 mt-2">
                                        No hay oportunidades registradas
                                    </h4>
                                    <p className="text-xs text-slate-500 max-w-sm mt-1 leading-relaxed">
                                        Aún no tienes demos, leads u oportunidades en el pipeline comercial. Empieza a generar nuevas oportunidades para hacer crecer AVI Pet.
                                    </p>
                                    <a
                                        href="/super-admin/prospecto-veterinarias/create"
                                        className="mt-3.5 inline-flex items-center gap-1.5 px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white text-xs font-bold rounded-lg shadow-sm transition hover:scale-102"
                                    >
                                        <span>Registrar oportunidad</span>
                                        <span>&rarr;</span>
                                    </a>
                                </div>
                            )}
                        </div>

                        {/* Right Column: Counters */}
                        <div className="w-full lg:w-1/4 flex items-center justify-around lg:justify-end gap-6 sm:gap-8 pt-4 lg:pt-0 border-t lg:border-t-0 lg:border-l border-slate-100 lg:pl-6">
                            {/* Demos Próximas */}
                            <div className="flex items-center gap-3">
                                <div className="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                                    <Calendar className="w-5 h-5" />
                                </div>
                                <div>
                                    <div className="text-xs text-slate-500">
                                        Demos próximas
                                    </div>
                                    <div className="text-2xl font-black text-slate-900 leading-tight">
                                        {demosProximas}
                                    </div>
                                </div>
                            </div>

                            {/* Cobros Pendientes */}
                            <div className="flex items-center gap-3">
                                <div className="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                                    <CreditCard className="w-5 h-5" />
                                </div>
                                <div>
                                    <div className="text-xs text-slate-500">
                                        Cobros pendientes
                                    </div>
                                    <div className="text-2xl font-black text-slate-900 leading-tight">
                                        {cobrosPendientes}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {/* 4. ROW 3: TWO ANALYTICS CHARTS */}
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

                                {/* Grid Lines & Labels */}
                                <text x="50" y="24" fill="#94a3b8" fontSize="10.5" textAnchor="end" fontWeight="500">$350.000</text>
                                <line x1="60" y1="20" x2="580" y2="20" stroke="#f1f5f9" strokeWidth="1" strokeDasharray="3 3" />

                                <text x="50" y="69" fill="#94a3b8" fontSize="10.5" textAnchor="end" fontWeight="500">$262.500</text>
                                <line x1="60" y1="65" x2="580" y2="65" stroke="#f1f5f9" strokeWidth="1" strokeDasharray="3 3" />

                                <text x="50" y="114" fill="#94a3b8" fontSize="10.5" textAnchor="end" fontWeight="500">$175.000</text>
                                <line x1="60" y1="110" x2="580" y2="110" stroke="#f1f5f9" strokeWidth="1" strokeDasharray="3 3" />

                                <text x="50" y="159" fill="#94a3b8" fontSize="10.5" textAnchor="end" fontWeight="500">$87.500</text>
                                <line x1="60" y1="155" x2="580" y2="155" stroke="#f1f5f9" strokeWidth="1" strokeDasharray="3 3" />

                                <text x="50" y="204" fill="#94a3b8" fontSize="10.5" textAnchor="end" fontWeight="500">$0</text>
                                <line x1="60" y1="200" x2="580" y2="200" stroke="#e2e8f0" strokeWidth="1" />

                                {/* Area Curve */}
                                <path 
                                    d={areaPath}
                                    fill="url(#reactMrrTealGradient)" 
                                />

                                {/* Spline Line */}
                                <path 
                                    d={pathData}
                                    fill="none" 
                                    stroke="#0d9488" 
                                    strokeWidth="2.8" 
                                    strokeLinecap="round" 
                                    strokeLinejoin="round" 
                                />

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

                    {/* Right Chart: Distribución de Clínicas por Plan (Donut) */}
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
                                        <circle 
                                            cx="80" cy="80" r="55"
                                            fill="transparent"
                                            stroke="#7c3aed"
                                            strokeWidth="24"
                                            strokeDasharray="172.8 172.8"
                                            strokeDashoffset="0" 
                                        />
                                        <circle 
                                            cx="80" cy="80" r="55"
                                            fill="transparent"
                                            stroke="#0d9488"
                                            strokeWidth="24"
                                            strokeDasharray="172.8 172.8"
                                            strokeDashoffset="172.8" 
                                        />
                                    </svg>

                                    <div className="absolute inset-0 flex items-center justify-between px-3 pointer-events-none">
                                        <span className="text-white font-bold text-xs pl-0.5">50%</span>
                                        <span className="text-white font-bold text-xs pr-0.5">50%</span>
                                    </div>

                                    <div className="absolute inset-0 flex flex-col items-center justify-center text-center pointer-events-none">
                                        <span className="text-2xl font-black text-slate-900 leading-tight">
                                            {clinicasActivas}
                                        </span>
                                        <span className="text-[11px] font-semibold text-slate-400">
                                            clínicas
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {/* Dynamic Legend */}
                            <div className="space-y-3">
                                {planDistribution.map((item, idx) => (
                                    <div key={idx} className="flex items-center justify-between text-xs py-1.5 border-b border-slate-100 last:border-0">
                                        <div className="flex items-center gap-2.5">
                                            <span className="w-2.5 h-2.5 rounded-full shrink-0" style={{ backgroundColor: item.color }} />
                                            <span className="font-semibold text-slate-800">{item.name}</span>
                                        </div>
                                        <div className="flex items-center gap-4">
                                            <span className="text-slate-500">{item.count} afs.</span>
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
