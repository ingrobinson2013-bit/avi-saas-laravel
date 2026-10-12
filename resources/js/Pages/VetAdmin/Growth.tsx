import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { 
    BarChart3, 
    TrendingUp, 
    Users, 
    ArrowUpRight, 
    Target, 
    Sparkles, 
    Zap, 
    QrCode, 
    Store, 
    ChevronRight, 
    ShieldCheck, 
    Heart, 
    Clock, 
    Flame,
    Share2,
    Calendar
} from 'lucide-react';

interface GrowthProps {
    tenantSlug: string;
    brandName: string;
    clinicSubtitle: string;
    logoUrl?: string | null;
    saasPlan: any;
    logoutUrl: string;
    userName: string;
    userRole: string;
    newSubsThisMonth: number;
    newSubsLastMonth: number;
    growthMoM: string;
    retentionRate: number;
    churnRate: number;
    estimatedLtv: string;
    paybackMonths: number;
    webChannelPercent: number;
    counterChannelPercent: number;
    projected3Months: string;
    projected6Months: string;
    projected12Months: string;
    currentMrr: string;
    growthInsights: {
        id: string;
        title: string;
        impact: 'ALTO' | 'MEDIO' | 'CRÍTICO';
        description: string;
        actionLabel: string;
        actionUrl: string;
        badgeColor: string;
    }[];
}

export default function Growth({
    tenantSlug,
    brandName,
    clinicSubtitle,
    logoUrl,
    saasPlan,
    logoutUrl,
    userName,
    userRole,
    newSubsThisMonth = 4,
    newSubsLastMonth = 2,
    growthMoM = '+100%',
    retentionRate = 96.5,
    churnRate = 3.5,
    estimatedLtv = '$720.000 COP',
    paybackMonths = 1.2,
    webChannelPercent = 58,
    counterChannelPercent = 42,
    projected3Months = '$180.000 COP',
    projected6Months = '$350.000 COP',
    projected12Months = '$850.000 COP',
    currentMrr = '$50.000 COP',
    growthInsights = [],
}: GrowthProps) {
    const [projectedScenario, setProjectedScenario] = useState<'conservative' | 'moderate' | 'aggressive'>('moderate');

    const scenarioMultiplier = {
        conservative: 1.0,
        moderate: 1.35,
        aggressive: 1.85,
    }[projectedScenario];

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
            activeItem="Crecimiento"
        >
            <Head title={`Crecimiento & Expansión · ${brandName}`} />

            <div className="space-y-6">
                {/* Header Superior */}
                <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
                    <div>
                        <div className="flex items-center gap-2">
                            <span className="p-2 rounded-xl bg-indigo-50 text-indigo-600">
                                <BarChart3 className="w-5 h-5" />
                            </span>
                            <div>
                                <h1 className="text-xl font-black text-slate-900 tracking-tight">
                                    Crecimiento y Expansión de Pacientes
                                </h1>
                                <p className="text-xs font-medium text-slate-500">
                                    Embudo de adquisición, retención a largo plazo y proyecciones de ingresos recurrentes.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div className="flex items-center gap-2">
                        <Link
                            href={`/v/${tenantSlug}/afiche`}
                            className="inline-flex items-center gap-2 px-3.5 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 rounded-xl text-xs font-bold transition"
                        >
                            <QrCode className="w-3.5 h-3.5" />
                            <span>Ver Afiche QR Mostrador</span>
                        </Link>
                        <Link
                            href={`/v/${tenantSlug}`}
                            target="_blank"
                            className="inline-flex items-center gap-2 px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition shadow-xs"
                        >
                            <Store className="w-3.5 h-3.5" />
                            <span>Abrir Web Pública →</span>
                        </Link>
                    </div>
                </div>

                {/* 4 KPIs de Crecimiento */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    {/* Nuevas Afiliaciones */}
                    <div className="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-xs space-y-2">
                        <div className="flex items-center justify-between text-xs text-slate-500 font-bold">
                            <span>Nuevas Afiliaciones Este Mes</span>
                            <span className="p-1.5 rounded-lg bg-emerald-50 text-emerald-600">
                                <Users className="w-4 h-4" />
                            </span>
                        </div>
                        <div className="text-2xl font-black text-slate-900 tracking-tight">
                            +{newSubsThisMonth} <span className="text-sm font-semibold text-slate-400">pacientes</span>
                        </div>
                        <div className="flex items-center gap-1.5 text-[11px] text-emerald-600 font-bold">
                            <ArrowUpRight className="w-3.5 h-3.5" />
                            <span>{growthMoM} vs mes anterior ({newSubsLastMonth} altas)</span>
                        </div>
                    </div>

                    {/* Tasa de Retención */}
                    <div className="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-xs space-y-2">
                        <div className="flex items-center justify-between text-xs text-slate-500 font-bold">
                            <span>Tasa de Retención Mensual</span>
                            <span className="p-1.5 rounded-lg bg-blue-50 text-blue-600">
                                <ShieldCheck className="w-4 h-4" />
                            </span>
                        </div>
                        <div className="text-2xl font-black text-slate-900 tracking-tight">
                            {retentionRate}%
                        </div>
                        <div className="text-[11px] text-slate-500 font-medium">
                            Churn rate bajo de solo <strong className="text-slate-700">{churnRate}%</strong> mensual
                        </div>
                    </div>

                    {/* LTV */}
                    <div className="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-xs space-y-2">
                        <div className="flex items-center justify-between text-xs text-slate-500 font-bold">
                            <span>LTV Estimado (Vida del Cliente)</span>
                            <span className="p-1.5 rounded-lg bg-purple-50 text-purple-600">
                                <Target className="w-4 h-4" />
                            </span>
                        </div>
                        <div className="text-2xl font-black text-slate-900 tracking-tight">
                            {estimatedLtv}
                        </div>
                        <div className="text-[11px] text-purple-700 font-medium">
                            Basado en 14.4 meses de permanencia media
                        </div>
                    </div>

                    {/* Payback */}
                    <div className="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-xs space-y-2">
                        <div className="flex items-center justify-between text-xs text-slate-500 font-bold">
                            <span>Periodo de Retorno (Payback)</span>
                            <span className="p-1.5 rounded-lg bg-amber-50 text-amber-600">
                                <Clock className="w-4 h-4" />
                            </span>
                        </div>
                        <div className="text-2xl font-black text-slate-900 tracking-tight">
                            {paybackMonths} <span className="text-sm font-semibold text-slate-400">meses</span>
                        </div>
                        <div className="text-[11px] text-slate-500 font-medium">
                            Recuperación del costo de afiliación inmediata
                        </div>
                    </div>
                </div>

                {/* Bloque: Embudo de Captación y Proyecciones */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {/* Canales de Adquisición */}
                    <div className="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                        <div className="flex items-center justify-between">
                            <div>
                                <h2 className="text-sm font-bold text-slate-900">Canales de Captación de Tutores</h2>
                                <p className="text-xs text-slate-500">¿De dónde provienen las nuevas afiliaciones a planes?</p>
                            </div>
                            <span className="text-[11px] font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg">
                                Omnicanal Activo
                            </span>
                        </div>

                        <div className="space-y-4 pt-2">
                            {/* Canal Web / QR */}
                            <div className="p-4 rounded-xl bg-slate-50 border border-slate-200/60 space-y-2">
                                <div className="flex items-center justify-between text-xs font-bold">
                                    <span className="flex items-center gap-2 text-slate-800">
                                        <QrCode className="w-4 h-4 text-indigo-600" />
                                        <span>Web Pública + Afiche QR Mostrador</span>
                                    </span>
                                    <span className="text-indigo-600 font-black text-sm">{webChannelPercent}%</span>
                                </div>
                                <div className="w-full h-2 bg-slate-200 rounded-full overflow-hidden">
                                    <div className="h-full bg-indigo-600 rounded-full" style={{ width: `${webChannelPercent}%` }} />
                                </div>
                                <p className="text-[11px] text-slate-500">
                                    Tutores que escanean el afiche en recepción o se afilian desde casa en menos de 60 segundos.
                                </p>
                            </div>

                            {/* Canal Mostrador Directo */}
                            <div className="p-4 rounded-xl bg-slate-50 border border-slate-200/60 space-y-2">
                                <div className="flex items-center justify-between text-xs font-bold">
                                    <span className="flex items-center gap-2 text-slate-800">
                                        <Store className="w-4 h-4 text-emerald-600" />
                                        <span>Venta Directa en Consulta Médica</span>
                                    </span>
                                    <span className="text-emerald-600 font-black text-sm">{counterChannelPercent}%</span>
                                </div>
                                <div className="w-full h-2 bg-slate-200 rounded-full overflow-hidden">
                                    <div className="h-full bg-emerald-600 rounded-full" style={{ width: `${counterChannelPercent}%` }} />
                                </div>
                                <p className="text-[11px] text-slate-500">
                                    Recomendación del médico durante la consulta presencial para asegurar coberturas.
                                </p>
                            </div>
                        </div>

                        <div className="p-3.5 rounded-xl bg-blue-50/70 border border-blue-100 flex items-start gap-3">
                            <Zap className="w-4 h-4 text-blue-600 shrink-0 mt-0.5" />
                            <p className="text-xs text-blue-900 leading-relaxed">
                                <strong>Dato de Impacto:</strong> Las clínicas que colocan el <strong>Afiche con Código QR</strong> en la sala de espera y mostrador aumentan su tasa de afiliación en un <strong>+47%</strong> sin esfuerzo del personal.
                            </p>
                        </div>
                    </div>

                    {/* Proyecciones de Crecimiento */}
                    <div className="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                        <div className="flex items-center justify-between">
                            <div>
                                <h2 className="text-sm font-bold text-slate-900">Proyección de Ingresos Recurrentes</h2>
                                <p className="text-xs text-slate-500">Estimación de MRR según el ritmo de nuevas afiliaciones</p>
                            </div>
                            <div className="flex items-center bg-slate-100 p-0.5 rounded-lg text-[11px] font-bold text-slate-600">
                                <button
                                    onClick={() => setProjectedScenario('conservative')}
                                    className={`px-2 py-1 rounded-md transition ${projectedScenario === 'conservative' ? 'bg-white text-slate-900 shadow-xs' : ''}`}
                                >
                                    +10%
                                </button>
                                <button
                                    onClick={() => setProjectedScenario('moderate')}
                                    className={`px-2 py-1 rounded-md transition ${projectedScenario === 'moderate' ? 'bg-white text-slate-900 shadow-xs' : ''}`}
                                >
                                    +25%
                                </button>
                                <button
                                    onClick={() => setProjectedScenario('aggressive')}
                                    className={`px-2 py-1 rounded-md transition ${projectedScenario === 'aggressive' ? 'bg-white text-slate-900 shadow-xs' : ''}`}
                                >
                                    +40%
                                </button>
                            </div>
                        </div>

                        <div className="grid grid-cols-3 gap-3 pt-2">
                            <div className="p-4 rounded-xl bg-slate-50 border border-slate-200/60 text-center space-y-1">
                                <span className="text-[11px] font-bold text-slate-500 uppercase">A 3 Meses</span>
                                <div className="text-base font-black text-slate-900">{projected3Months}</div>
                                <span className="text-[10px] text-emerald-600 font-bold block">+3.6x del MRR</span>
                            </div>

                            <div className="p-4 rounded-xl bg-slate-50 border border-slate-200/60 text-center space-y-1">
                                <span className="text-[11px] font-bold text-slate-500 uppercase">A 6 Meses</span>
                                <div className="text-base font-black text-slate-900">{projected6Months}</div>
                                <span className="text-[10px] text-emerald-600 font-bold block">+7.0x del MRR</span>
                            </div>

                            <div className="p-4 rounded-xl bg-slate-50 border border-slate-200/60 text-center space-y-1">
                                <span className="text-[11px] font-bold text-slate-500 uppercase">A 12 Meses</span>
                                <div className="text-base font-black text-indigo-600">{projected12Months}</div>
                                <span className="text-[10px] text-indigo-600 font-bold block">Meta Escala</span>
                            </div>
                        </div>

                        <div className="p-4 rounded-xl bg-gradient-to-br from-slate-900 to-indigo-950 text-white space-y-2">
                            <div className="flex items-center gap-2 text-xs font-bold text-indigo-300">
                                <Sparkles className="w-4 h-4 text-indigo-400" />
                                <span>Potencial Anualizado de Cartera</span>
                            </div>
                            <p className="text-xs text-slate-300 leading-relaxed">
                                Con 50 mascotas afiliadas en un plan promedio de $50.000 COP/mes, tu clínica genera <strong>$30.000.000 COP al año</strong> en flujo de caja seguro y recurrente, independiente de consultas eventuales.
                            </p>
                        </div>
                    </div>
                </div>

                {/* Radar de Oportunidades de Crecimiento AVI (AI Insights) */}
                <div className="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                    <div className="flex items-center justify-between">
                        <div className="flex items-center gap-2">
                            <span className="p-2 rounded-xl bg-purple-50 text-purple-600">
                                <Sparkles className="w-5 h-5" />
                            </span>
                            <div>
                                <h2 className="text-sm font-bold text-slate-900">Radar de Crecimiento & Oportunidades AVI</h2>
                                <p className="text-xs text-slate-500">Acciones automatizadas recomendadas para multiplicar las afiliaciones</p>
                            </div>
                        </div>
                        <span className="text-[10.5px] font-black uppercase px-2.5 py-1 rounded-full bg-purple-100 text-purple-800">
                            IA Predictiva
                        </span>
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                        {growthInsights.map((insight) => (
                            <div key={insight.id} className="p-4 rounded-xl bg-slate-50 border border-slate-200/70 space-y-3 flex flex-col justify-between">
                                <div className="space-y-2">
                                    <div className="flex items-center justify-between">
                                        <span className={`text-[10px] font-black uppercase px-2 py-0.5 rounded-md ${
                                            insight.impact === 'ALTO' ? 'bg-emerald-100 text-emerald-800' :
                                            insight.impact === 'CRÍTICO' ? 'bg-rose-100 text-rose-800' : 'bg-blue-100 text-blue-800'
                                        }`}>
                                            Impacto {insight.impact}
                                        </span>
                                        <Flame className="w-3.5 h-3.5 text-amber-500" />
                                    </div>
                                    <h3 className="text-xs font-black text-slate-900">{insight.title}</h3>
                                    <p className="text-[11.5px] text-slate-600 leading-relaxed">
                                        {insight.description}
                                    </p>
                                </div>

                                <Link
                                    href={insight.actionUrl}
                                    className="inline-flex items-center justify-between w-full px-3 py-2 bg-white hover:bg-slate-100 text-slate-900 border border-slate-200 rounded-lg text-xs font-bold transition shadow-2xs"
                                >
                                    <span>{insight.actionLabel}</span>
                                    <ChevronRight className="w-3.5 h-3.5 text-slate-400" />
                                </Link>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </VetAdminLayout>
    );
}
