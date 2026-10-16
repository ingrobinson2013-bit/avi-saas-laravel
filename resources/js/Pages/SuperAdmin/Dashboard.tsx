import React from 'react';
import { Head } from '@inertiajs/react';
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
    UserCheck
} from 'lucide-react';

interface ActivityItem {
    id: string;
    type: 'clinic' | 'user' | 'payment';
    title: string;
    description: string;
    time: string;
}

interface DashboardProps {
    clinicasActivas?: number;
    mascotasConMembresia?: number;
    mrr?: number;
    gmv?: number;
    demosProximas?: number;
    cobrosPendientes?: number;
    recentActivities?: ActivityItem[];
    userName?: string;
    userEmail?: string;
}

export default function Dashboard({
    clinicasActivas = 2,
    mascotasConMembresia = 8,
    mrr = 198000,
    gmv = 520000,
    demosProximas = 0,
    cobrosPendientes = 0,
    recentActivities = [
        {
            id: '1',
            type: 'clinic',
            title: 'Nueva clínica',
            description: 'Clínica Vet Pet Patitas se registró en la plataforma',
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

    return (
        <SuperAdminLayout userName={userName} userEmail={userEmail} activeItem="Escritorio">
            <Head title="Centro de Control · AVI Pet Superadmin" />

            <div className="space-y-6">

                {/* 1. HEADER */}
                <div>
                    <h1 className="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Centro de control
                    </h1>
                    <p className="text-sm text-slate-500 mt-0.5">
                        Resumen de la red AVI Pet
                    </p>
                </div>

                {/* 2. ROW 1: 4 METRIC CARDS */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    
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
                                    <span>↑ 100%</span>
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
                                    <span>↑ 33%</span>
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
                                    <span>↑ 12%</span>
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
                                    <span>↑ 18%</span>
                                    <span className="text-slate-400 font-normal">vs. mes anterior</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {/* 3. ROW 2: PIPELINE COMERCIAL CARD */}
                <div className="bg-white rounded-2xl border border-slate-200/90 p-6 shadow-xs">
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

                        {/* Middle Column: Empty State & Action */}
                        <div className="w-full lg:w-1/2 flex flex-col items-center text-center px-4">
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
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-5">

                    {/* Left Chart: Ingresos Recurrentes (MRR 6 Meses) */}
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

                        {/* Area Chart SVG matching mockup */}
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
                                    d="M 85 190 Q 185 180 285 170 T 385 150 T 485 130 T 550 95 L 550 200 L 85 200 Z"
                                    fill="url(#reactMrrTealGradient)" 
                                />

                                {/* Spline Line */}
                                <path 
                                    d="M 85 190 Q 185 180 285 170 T 385 150 T 485 130 T 550 95"
                                    fill="none" 
                                    stroke="#0d9488" 
                                    strokeWidth="2.8" 
                                    strokeLinecap="round" 
                                    strokeLinejoin="round" 
                                />

                                {/* Points */}
                                <circle cx="85" cy="190" r="4" fill="#0d9488" stroke="#ffffff" strokeWidth="2" />
                                <circle cx="185" cy="180" r="4" fill="#0d9488" stroke="#ffffff" strokeWidth="2" />
                                <circle cx="285" cy="170" r="4" fill="#0d9488" stroke="#ffffff" strokeWidth="2" />
                                <circle cx="385" cy="150" r="4" fill="#0d9488" stroke="#ffffff" strokeWidth="2" />
                                <circle cx="485" cy="130" r="4" fill="#0d9488" stroke="#ffffff" strokeWidth="2" />
                                <circle cx="550" cy="95" r="5" fill="#0d9488" stroke="#ffffff" strokeWidth="2.5" />

                                {/* Current value tooltip badge */}
                                <g transform="translate(515, 60)">
                                    <rect x="0" y="0" width="70" height="24" rx="6" fill="#0f766e" />
                                    <text x="35" y="16" fill="#ffffff" fontSize="11" fontWeight="bold" textAnchor="middle">$198.000</text>
                                </g>

                                {/* Month labels */}
                                <text x="85" y="222" fill="#94a3b8" fontSize="10.5" textAnchor="middle" fontWeight="500">May 2025</text>
                                <text x="185" y="222" fill="#94a3b8" fontSize="10.5" textAnchor="middle" fontWeight="500">Jun 2025</text>
                                <text x="285" y="222" fill="#94a3b8" fontSize="10.5" textAnchor="middle" fontWeight="500">Jul 2025</text>
                                <text x="385" y="222" fill="#94a3b8" fontSize="10.5" textAnchor="middle" fontWeight="500">Ago 2025</text>
                                <text x="485" y="222" fill="#94a3b8" fontSize="10.5" textAnchor="middle" fontWeight="500">Sep 2025</text>
                                <text x="550" y="222" fill="#94a3b8" fontSize="10.5" textAnchor="middle" fontWeight="500">Oct 2025</text>
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
                                        Distribución de clínicas por plan
                                    </h3>
                                    <p className="text-xs text-slate-400 mt-0.5">
                                        Participación de clínicas en cada plan
                                    </p>
                                </div>
                            </div>

                            <span className="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold text-slate-600 bg-slate-50 border border-slate-200 rounded-lg cursor-pointer">
                                <span>2 clínicas</span>
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

                            {/* Legend */}
                            <div className="space-y-4">
                                <div className="flex items-center justify-between text-xs py-1.5 border-b border-slate-100">
                                    <div className="flex items-center gap-2.5">
                                        <span className="w-2.5 h-2.5 rounded-full bg-teal-600 shrink-0" />
                                        <span className="font-semibold text-slate-800">Plan Básico</span>
                                    </div>
                                    <div className="flex items-center gap-6">
                                        <span className="text-slate-500">1 clínica</span>
                                        <span className="font-bold text-slate-900">50%</span>
                                    </div>
                                </div>

                                <div className="flex items-center justify-between text-xs py-1.5 border-b border-slate-100">
                                    <div className="flex items-center gap-2.5">
                                        <span className="w-2.5 h-2.5 rounded-full bg-purple-600 shrink-0" />
                                        <span className="font-semibold text-slate-800">Plan Premium</span>
                                    </div>
                                    <div className="flex items-center gap-6">
                                        <span className="text-slate-500">1 clínica</span>
                                        <span className="font-bold text-slate-900">50%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {/* 5. ROW 4: ACTIVIDAD RECIENTE */}
                <div className="space-y-3">
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
                                    Últimos eventos en la plataforma
                                </p>
                            </div>
                        </div>

                        <a href="/super-admin/tenants" className="text-xs font-bold text-teal-600 hover:text-teal-700 inline-flex items-center gap-1 transition">
                            <span>Ver todas</span>
                            <span>&rarr;</span>
                        </a>
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
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
