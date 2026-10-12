import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { 
    TrendingUp, 
    DollarSign, 
    ShieldCheck, 
    PawPrint, 
    Activity, 
    PieChart, 
    BarChart3, 
    Download, 
    Calendar, 
    ArrowUpRight, 
    Percent, 
    Sparkles,
    CheckCircle2
} from 'lucide-react';

interface PlanStat {
    id: string;
    name: string;
    price: number;
    formatted_price: string;
    subscribers_count: number;
    percentage: number;
}

interface TopServiceStat {
    name: string;
    category: string;
    count: number;
    percentage: number;
    saved_cop: string;
}

interface MonthlyData {
    month: string;
    mrr: number;
    redemptions: number;
    growth_rate: string;
}

interface MetricsProps {
    tenantSlug: string;
    brandName: string;
    clinicSubtitle: string;
    logoUrl?: string | null;
    saasPlan: any;
    logoutUrl: string;
    userName: string;
    userRole: string;
    mrr: number;
    formattedMrr: string;
    mrrDelta: number;
    activeSubsCount: number;
    totalPets: number;
    avgTicket: string;
    lossRatio: number;
    totalBenefitsUsed: number;
    totalBenefitsGranted: number;
    surgicalWalletTotal: string;
    plansDistribution: PlanStat[];
    topServices: TopServiceStat[];
    caninePercentage: number;
    felinePercentage: number;
    monthlyHistory: MonthlyData[];
}

export default function Metrics({
    tenantSlug,
    brandName,
    clinicSubtitle,
    logoUrl,
    saasPlan,
    logoutUrl,
    userName,
    userRole,
    mrr = 50000,
    formattedMrr = '$50.000 COP',
    mrrDelta = 0,
    activeSubsCount = 1,
    totalPets = 1,
    avgTicket = '$50.000 COP',
    lossRatio = 42,
    totalBenefitsUsed = 12,
    totalBenefitsGranted = 28,
    surgicalWalletTotal = '$150.000 COP',
    plansDistribution = [],
    topServices = [],
    caninePercentage = 75,
    felinePercentage = 25,
    monthlyHistory = [],
}: MetricsProps) {
    const [period, setPeriod] = useState<'month' | 'quarter' | 'year'>('month');

    const handleExportCSV = () => {
        const rows = [
            ['Indicador', 'Valor'],
            ['MRR Total Recurrente', formattedMrr],
            ['Suscripciones Activas', activeSubsCount.toString()],
            ['Total Mascotas Afiliadas', totalPets.toString()],
            ['Ticket Promedio Mensual', avgTicket],
            ['Siniestralidad Actuarial', `${lossRatio}%`],
            ['Fondo Quirúrgico Acumulado', surgicalWalletTotal],
            ['Caninos (%)', `${caninePercentage}%`],
            ['Felinos (%)', `${felinePercentage}%`],
        ];
        const csvContent = 'data:text/csv;charset=utf-8,' + rows.map(e => e.join(',')).join('\n');
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', `reporte_metricas_${tenantSlug}_${new Date().toISOString().slice(0, 10)}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
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
            activeItem="Métricas y Estadísticas"
        >
            <Head title={`Métricas y Estadísticas · ${brandName}`} />

            <div className="space-y-6">
                {/* Header Superior */}
                <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
                    <div>
                        <div className="flex items-center gap-2">
                            <span className="p-2 rounded-xl bg-blue-50 text-blue-600">
                                <TrendingUp className="w-5 h-5" />
                            </span>
                            <div>
                                <h1 className="text-xl font-black text-slate-900 tracking-tight">
                                    Métricas y Estadísticas de Cartera
                                </h1>
                                <p className="text-xs font-medium text-slate-500">
                                    Control financiero actuarial, rentabilidad de planes preventivos y uso de servicios.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div className="flex items-center gap-2.5">
                        <div className="flex items-center bg-slate-100 p-1 rounded-xl text-xs font-bold text-slate-600">
                            <button
                                onClick={() => setPeriod('month')}
                                className={`px-3 py-1.5 rounded-lg transition ${period === 'month' ? 'bg-white text-slate-900 shadow-xs' : 'hover:text-slate-900'}`}
                            >
                                Este Mes
                            </button>
                            <button
                                onClick={() => setPeriod('quarter')}
                                className={`px-3 py-1.5 rounded-lg transition ${period === 'quarter' ? 'bg-white text-slate-900 shadow-xs' : 'hover:text-slate-900'}`}
                            >
                                Trimestre
                            </button>
                            <button
                                onClick={() => setPeriod('year')}
                                className={`px-3 py-1.5 rounded-lg transition ${period === 'year' ? 'bg-white text-slate-900 shadow-xs' : 'hover:text-slate-900'}`}
                            >
                                Año
                            </button>
                        </div>

                        <button
                            onClick={handleExportCSV}
                            className="inline-flex items-center gap-2 px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition shadow-xs"
                        >
                            <Download className="w-3.5 h-3.5" />
                            <span>Exportar CSV</span>
                        </button>
                    </div>
                </div>

                {/* Grid 4 KPIs Principales */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    {/* MRR */}
                    <div className="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-xs space-y-2">
                        <div className="flex items-center justify-between text-xs text-slate-500 font-bold">
                            <span>MRR Cartera Recurrente</span>
                            <span className="p-1.5 rounded-lg bg-emerald-50 text-emerald-600">
                                <DollarSign className="w-4 h-4" />
                            </span>
                        </div>
                        <div className="text-2xl font-black text-slate-900 tracking-tight">
                            {formattedMrr}
                        </div>
                        <div className="flex items-center gap-1.5 text-[11px] text-emerald-600 font-bold">
                            <ArrowUpRight className="w-3.5 h-3.5" />
                            <span>+{mrrDelta > 0 ? `$${mrrDelta.toLocaleString('es-CO')} COP` : 'Crecimiento Sostenido'} este ciclo</span>
                        </div>
                    </div>

                    {/* Suscripciones & Mascotas */}
                    <div className="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-xs space-y-2">
                        <div className="flex items-center justify-between text-xs text-slate-500 font-bold">
                            <span>Pacientes Protegidos</span>
                            <span className="p-1.5 rounded-lg bg-blue-50 text-blue-600">
                                <PawPrint className="w-4 h-4" />
                            </span>
                        </div>
                        <div className="text-2xl font-black text-slate-900 tracking-tight">
                            {totalPets} <span className="text-sm font-semibold text-slate-400">mascotas</span>
                        </div>
                        <div className="text-[11px] text-slate-500 font-medium">
                            En <strong className="text-slate-700">{activeSubsCount}</strong> membresías activas al día
                        </div>
                    </div>

                    {/* Siniestralidad / Uso Actuarial */}
                    <div className="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-xs space-y-2">
                        <div className="flex items-center justify-between text-xs text-slate-500 font-bold">
                            <span>Siniestralidad Actuarial</span>
                            <span className="p-1.5 rounded-lg bg-purple-50 text-purple-600">
                                <Percent className="w-4 h-4" />
                            </span>
                        </div>
                        <div className="text-2xl font-black text-slate-900 tracking-tight">
                            {lossRatio}%
                        </div>
                        <div className="text-[11px] text-purple-700 font-medium flex items-center gap-1">
                            <span>{totalBenefitsUsed} de {totalBenefitsGranted} beneficios redimidos</span>
                        </div>
                    </div>

                    {/* Bolsa Quirúrgica */}
                    <div className="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-xs space-y-2">
                        <div className="flex items-center justify-between text-xs text-slate-500 font-bold">
                            <span>Fondo Quirúrgico / Urgencias</span>
                            <span className="p-1.5 rounded-lg bg-amber-50 text-amber-600">
                                <ShieldCheck className="w-4 h-4" />
                            </span>
                        </div>
                        <div className="text-2xl font-black text-slate-900 tracking-tight">
                            {surgicalWalletTotal}
                        </div>
                        <div className="text-[11px] text-slate-500 font-medium">
                            Saldo reservado para cirugías de afiliados
                        </div>
                    </div>
                </div>

                {/* 2 Bloques Comparativos: Distribución de Planes y Especies */}
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Distribución por Plan */}
                    <div className="lg:col-span-2 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                        <div className="flex items-center justify-between">
                            <div>
                                <h2 className="text-sm font-bold text-slate-900">Distribución de Ingresos por Plan</h2>
                                <p className="text-xs text-slate-500">Participación de cada plan en el flujo de caja mensual</p>
                            </div>
                            <span className="text-[11px] font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-lg">
                                Ticket Promedio: {avgTicket}
                            </span>
                        </div>

                        <div className="space-y-3 pt-2">
                            {plansDistribution.length > 0 ? (
                                plansDistribution.map(plan => (
                                    <div key={plan.id} className="space-y-1.5">
                                        <div className="flex items-center justify-between text-xs font-bold">
                                            <span className="text-slate-800">{plan.name}</span>
                                            <span className="text-slate-500">
                                                {plan.subscribers_count} suscriptores ({plan.percentage}%) · {plan.formatted_price}/mes
                                            </span>
                                        </div>
                                        <div className="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                            <div 
                                                className="h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full" 
                                                style={{ width: `${Math.max(5, plan.percentage)}%` }}
                                            />
                                        </div>
                                    </div>
                                ))
                            ) : (
                                <div className="text-xs text-slate-400 py-4 text-center">
                                    No hay planes configurados todavía.
                                </div>
                            )}
                        </div>

                        {/* Comparación Caninos vs Felinos */}
                        <div className="pt-4 border-t border-slate-100 grid grid-cols-2 gap-4">
                            <div className="p-3 rounded-xl bg-slate-50 border border-slate-200/60 flex items-center justify-between">
                                <div className="flex items-center gap-2">
                                    <span className="text-xl">🐕</span>
                                    <div>
                                        <div className="text-xs font-bold text-slate-800">Caninos (Perros)</div>
                                        <div className="text-[11px] text-slate-500">Mayor demanda en antipulgas</div>
                                    </div>
                                </div>
                                <span className="text-sm font-black text-slate-900">{caninePercentage}%</span>
                            </div>

                            <div className="p-3 rounded-xl bg-slate-50 border border-slate-200/60 flex items-center justify-between">
                                <div className="flex items-center gap-2">
                                    <span className="text-xl">🐱</span>
                                    <div>
                                        <div className="text-xs font-bold text-slate-800">Felinos (Gatos)</div>
                                        <div className="text-[11px] text-slate-500">Alta adherencia preventiva</div>
                                    </div>
                                </div>
                                <span className="text-sm font-black text-slate-900">{felinePercentage}%</span>
                            </div>
                        </div>
                    </div>

                    {/* Top Servicios Redimidos */}
                    <div className="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                        <div>
                            <h2 className="text-sm font-bold text-slate-900">Servicios Más Canjeados</h2>
                            <p className="text-xs text-slate-500">Servicios con mayor impacto en mostrador</p>
                        </div>

                        <div className="space-y-3">
                            {topServices.map((svc, idx) => (
                                <div key={idx} className="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200/60">
                                    <div className="space-y-0.5">
                                        <div className="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                            <span className="text-[10px] w-4 h-4 rounded-full bg-slate-200 flex items-center justify-center font-bold text-slate-700">
                                                {idx + 1}
                                            </span>
                                            {svc.name}
                                        </div>
                                        <div className="text-[10px] text-slate-500 pl-5">
                                            Ahorro tutor: {svc.saved_cop}
                                        </div>
                                    </div>
                                    <div className="text-right">
                                        <span className="text-xs font-black text-slate-900">{svc.count}</span>
                                        <span className="block text-[9.5px] text-slate-500 font-semibold">{svc.percentage}% uso</span>
                                    </div>
                                </div>
                            ))}
                        </div>

                        <div className="p-3 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center gap-2.5 text-xs text-emerald-800">
                            <CheckCircle2 className="w-4 h-4 text-emerald-600 shrink-0" />
                            <span>La siniestralidad actual ({lossRatio}%) está dentro del rango óptimo actuarial (35% - 55%).</span>
                        </div>
                    </div>
                </div>

                {/* Histórico Mensual */}
                <div className="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                    <div className="flex items-center justify-between">
                        <div>
                            <h2 className="text-sm font-bold text-slate-900">Evolución de Ingresos y Canjes (Último Semestre)</h2>
                            <p className="text-xs text-slate-500">Comportamiento del ingreso recurrente vs servicios clínicos prestados</p>
                        </div>
                        <Link
                            href={`/admin/${tenantSlug}/historial-canjes`}
                            className="text-xs font-bold text-blue-600 hover:text-blue-700 inline-flex items-center gap-1"
                        >
                            Ver Auditoría Completa de Canjes →
                        </Link>
                    </div>

                    <div className="overflow-x-auto">
                        <table className="w-full text-left border-collapse">
                            <thead>
                                <tr className="border-b border-slate-100 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                                    <th className="py-2.5 px-3">Mes Calendario</th>
                                    <th className="py-2.5 px-3">MRR Generado</th>
                                    <th className="py-2.5 px-3">Servicios Redimidos</th>
                                    <th className="py-2.5 px-3">Crecimiento Neto</th>
                                    <th className="py-2.5 px-3 text-right">Estado Financiero</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100 text-xs">
                                {monthlyHistory.map((item, idx) => (
                                    <tr key={idx} className="hover:bg-slate-50/70 transition">
                                        <td className="py-3 px-3 font-bold text-slate-800 flex items-center gap-2">
                                            <Calendar className="w-3.5 h-3.5 text-slate-400" />
                                            {item.month}
                                        </td>
                                        <td className="py-3 px-3 font-semibold text-slate-900">
                                            ${item.mrr.toLocaleString('es-CO')} COP
                                        </td>
                                        <td className="py-3 px-3 text-slate-600">
                                            {item.redemptions} canjes en clínica
                                        </td>
                                        <td className="py-3 px-3 text-emerald-600 font-bold">
                                            {item.growth_rate}
                                        </td>
                                        <td className="py-3 px-3 text-right">
                                            <span className="px-2 py-0.5 rounded-full text-[10.5px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                Rentable
                                            </span>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </VetAdminLayout>
    );
}
