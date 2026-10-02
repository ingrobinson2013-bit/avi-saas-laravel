import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { Bot, Sparkles, MessageCircle, ArrowRight, ShieldAlert, CheckCircle2, TrendingUp } from 'lucide-react';

interface Opportunity {
    id: string;
    pet_name: string;
    customer_name: string;
    customer_phone: string;
    plan_name: string;
    reason: string;
    recommended_action: string;
    whatsapp_url: string;
}

interface IntelligenceProps {
    tenantSlug: string;
    brandName: string;
    clinicSubtitle: string;
    logoUrl?: string | null;
    saasPlan: any;
    logoutUrl: string;
    userName: string;
    userRole: string;
    opportunities: Opportunity[];
    totalOpportunities: number;
    protectedMrr: string;
}

export default function Intelligence({
    tenantSlug,
    brandName,
    clinicSubtitle,
    logoUrl,
    saasPlan,
    logoutUrl,
    userName,
    userRole,
    opportunities = [],
    totalOpportunities = 1,
    protectedMrr = '$50.000 COP',
}: IntelligenceProps) {
    const [activePrompt, setActivePrompt] = useState<string | null>(null);

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
            activeItem="Inteligencia Artificial"
        >
            <Head title={`AVI Intelligence · ${brandName}`} />

            <div className="space-y-4">
                {/* Header Banner */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div className="flex items-center gap-2">
                            <h1 className="text-xl font-black text-slate-900">
                                AVI Intelligence · Copiloto de Retención
                            </h1>
                            <span className="text-[10px] font-bold px-2 py-0.5 rounded-full bg-purple-100 text-purple-700">
                                Beta AI 2.0
                            </span>
                        </div>
                        <p className="text-xs text-slate-500 mt-1">
                            Análisis automático de historiales, detección de inactividad y rescate proactivo de pacientes para tu clínica.
                        </p>
                    </div>

                    <div className="flex items-center gap-2">
                        <span className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                            <span className="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>IA Activa Monitoreando</span>
                        </span>
                    </div>
                </div>

                {/* KPI Metrics */}
                <div className="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">MRR Protegido / En Seguimiento</span>
                        <div className="text-2xl font-black text-slate-900">{protectedMrr}</div>
                        <span className="text-[10.5px] font-bold text-emerald-600 mt-1 block">✓ 0 pacientes en mora</span>
                    </div>

                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">Oportunidades de Activación</span>
                        <div className="text-2xl font-black text-slate-900">{totalOpportunities}</div>
                        <span className="text-[10.5px] font-medium text-amber-600 mt-1 block">1 paciente sin redimir &gt; 60 días</span>
                    </div>

                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">Tasa de Fidelización Proyectada</span>
                        <div className="text-2xl font-black text-slate-900">92%</div>
                        <span className="text-[10.5px] font-medium text-blue-600 mt-1 block">Alta probabilidad de renovación</span>
                    </div>
                </div>

                {/* Inactive Patients Section */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-3">
                    <div className="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div className="flex items-center gap-2">
                            <span className="text-amber-500 text-lg">💡</span>
                            <div>
                                <h3 className="text-sm font-bold text-slate-900">
                                    Oportunidades de Activación & Rescate
                                </h3>
                                <p className="text-[11px] text-slate-400">
                                    Pacientes con servicios pagados que aún no se han presentado a control clínico.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div className="space-y-3 pt-2">
                        {opportunities.map((opp) => (
                            <div
                                key={opp.id}
                                className="p-4 rounded-xl border border-teal-200 bg-gradient-to-r from-teal-50/50 via-white to-blue-50/30 flex flex-col md:flex-row md:items-center justify-between gap-4"
                            >
                                <div>
                                    <div className="flex items-center gap-2 mb-1">
                                        <h4 className="text-sm font-black text-slate-900">{opp.pet_name}</h4>
                                        <span className="text-[10.5px] font-bold px-2 py-0.2 rounded-full bg-blue-100 text-blue-800">
                                            {opp.plan_name}
                                        </span>
                                        <span className="text-xs text-slate-400 font-medium">
                                            · Tutor: {opp.customer_name}
                                        </span>
                                    </div>
                                    <p className="text-xs text-slate-600">
                                        {opp.reason} <strong className="text-slate-800">Acción sugerida:</strong> {opp.recommended_action}
                                    </p>
                                </div>

                                <div className="flex items-center gap-2 shrink-0">
                                    <a
                                        href={opp.whatsapp_url}
                                        target="_blank"
                                        rel="noreferrer"
                                        className="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-2xs"
                                    >
                                        <MessageCircle className="w-3.5 h-3.5" />
                                        <span>Enviar WhatsApp</span>
                                    </a>
                                    <a
                                        href={`/admin/${tenantSlug}/counter-redeem`}
                                        className="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-2xs"
                                    >
                                        <span>Ver Saldos</span>
                                    </a>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>

                {/* AI Copilot Tools Grid */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs">
                    <h3 className="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                        <Sparkles className="w-4 h-4 text-purple-600" />
                        <span>Herramientas del Asistente para el Personal Clínico</span>
                    </h3>

                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        <div className="p-3.5 rounded-xl border border-slate-200 bg-slate-50/60 hover:bg-white hover:border-blue-300 transition">
                            <h4 className="text-xs font-bold text-slate-900 mb-1">Recomendador de Planes</h4>
                            <p className="text-[11px] text-slate-500 leading-relaxed">
                                Pregúntale a la IA qué plan conviene más a un cachorro o paciente geronte con base en su historial.
                            </p>
                        </div>

                        <div className="p-3.5 rounded-xl border border-slate-200 bg-slate-50/60 hover:bg-white hover:border-blue-300 transition">
                            <h4 className="text-xs font-bold text-slate-900 mb-1">Argumentario de Mostrador</h4>
                            <p className="text-[11px] text-slate-500 leading-relaxed">
                                Respuestas rápidas ante objeciones de precio para la recepcionista al momento del canje o venta.
                            </p>
                        </div>

                        <div className="p-3.5 rounded-xl border border-slate-200 bg-slate-50/60 hover:bg-white hover:border-blue-300 transition">
                            <h4 className="text-xs font-bold text-slate-900 mb-1">Análisis de Retención Anual</h4>
                            <p className="text-[11px] text-slate-500 leading-relaxed">
                                Proyección de ingresos y cálculo de LTV de cada tutor registrado en la sede {cleanCity}.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </VetAdminLayout>
    );
}
