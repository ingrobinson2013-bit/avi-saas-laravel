import React from 'react';
import { Head } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { Plus, Check, ShieldCheck, Sparkles, ExternalLink, Users } from 'lucide-react';

interface PlanBenefitItem {
    name: string;
    quantity: number;
    category: string;
}

interface PlanItem {
    id: string;
    name: string;
    description: string;
    price_cop: number;
    formatted_price: string;
    billing_interval: string;
    is_active: boolean;
    subscribers_count: number;
    benefits: PlanBenefitItem[];
}

interface PlansProps {
    tenantSlug: string;
    brandName: string;
    clinicSubtitle: string;
    logoUrl?: string | null;
    saasPlan: any;
    logoutUrl: string;
    userName: string;
    userRole: string;
    plans: PlanItem[];
    totalPlans: number;
}

export default function Plans({
    tenantSlug,
    brandName,
    clinicSubtitle,
    logoUrl,
    saasPlan,
    logoutUrl,
    userName,
    userRole,
    plans = [],
    totalPlans = 2,
}: PlansProps) {
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
            activeItem="Planes de Salud"
        >
            <Head title={`Planes de Salud · ${brandName}`} />

            <div className="w-full space-y-5 pb-16">
                {/* Header Banner */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div className="flex items-center gap-2">
                            <h1 className="text-xl font-black text-slate-900">
                                Planes de Salud Preventiva
                            </h1>
                            <span className="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                {totalPlans} Planes Activos
                            </span>
                        </div>
                        <p className="text-xs text-slate-500 mt-1">
                            Planes médicos veterinarios comercializados en mostrador y en la tienda web de auto-afiliación.
                        </p>
                    </div>

                    <div className="flex items-center gap-2">
                        <a
                            href={`/v/${tenantSlug}`}
                            target="_blank"
                            rel="noreferrer"
                            className="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition shadow-2xs"
                        >
                            <ExternalLink className="w-3.5 h-3.5" />
                            <span>Ver Tienda B2C</span>
                        </a>
                        <a
                            href={`/admin/${tenantSlug}/plans/create`}
                            className="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#0080ff] hover:bg-blue-600 text-white text-xs font-bold transition shadow-xs"
                        >
                            <Plus className="w-4 h-4" />
                            <span>Crear Nuevo Plan</span>
                        </a>
                    </div>
                </div>

                {/* Plans Cards Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-5">
                    {plans.map((plan, idx) => {
                        const isFeatured = idx === 0;
                        return (
                            <div
                                key={plan.id}
                                className={`rounded-2xl p-6 transition flex flex-col justify-between border ${
                                    isFeatured
                                        ? 'bg-gradient-to-b from-blue-50/50 via-white to-white border-blue-200 shadow-xs'
                                        : 'bg-white border-slate-200/90 shadow-2xs'
                                }`}
                            >
                                <div>
                                    <div className="flex items-center justify-between mb-3">
                                        <div className="flex items-center gap-2">
                                            <span className="text-lg">⭐</span>
                                            <h3 className="text-lg font-black text-slate-900">{plan.name}</h3>
                                        </div>
                                        <span className="inline-flex items-center gap-1 text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <Users className="w-3 h-3" />
                                            <span>{plan.subscribers_count} Suscriptor{plan.subscribers_count !== 1 ? 'es' : ''}</span>
                                        </span>
                                    </div>

                                    <p className="text-xs text-slate-500 leading-relaxed mb-4">
                                        {plan.description}
                                    </p>

                                    <div className="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 mb-5 flex items-baseline justify-between">
                                        <div>
                                            <span className="text-2xl font-black text-slate-900 tracking-tight">
                                                {plan.formatted_price}
                                            </span>
                                            <span className="text-xs text-slate-400 font-semibold ml-1">
                                                / {plan.billing_interval}
                                            </span>
                                        </div>
                                        <span className="text-[10.5px] font-bold text-emerald-700 bg-emerald-100/70 px-2 py-0.5 rounded">
                                            Cobro Recurrente
                                        </span>
                                    </div>

                                    <div className="space-y-2 mb-6">
                                        <h4 className="text-[11px] font-black uppercase tracking-wider text-slate-400">
                                            Coberturas y Servicios Incluidos:
                                        </h4>
                                        <ul className="space-y-1.5 text-xs text-slate-700">
                                            {plan.benefits.length > 0 ? (
                                                plan.benefits.map((b, bIdx) => (
                                                    <li key={bIdx} className="flex items-center gap-2">
                                                        <div className="w-4 h-4 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                                            <Check className="w-2.5 h-2.5 stroke-[3]" />
                                                        </div>
                                                        <span className="font-medium text-slate-800">
                                                            {b.quantity > 0 ? `${b.quantity}x ` : ''}{b.name}
                                                        </span>
                                                    </li>
                                                ))
                                            ) : (
                                                <>
                                                    <li className="flex items-center gap-2">
                                                        <div className="w-4 h-4 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                                            <Check className="w-2.5 h-2.5 stroke-[3]" />
                                                        </div>
                                                        <span className="font-medium text-slate-800">Consultas médicas veterinarias ilimitadas</span>
                                                    </li>
                                                    <li className="flex items-center gap-2">
                                                        <div className="w-4 h-4 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                                            <Check className="w-2.5 h-2.5 stroke-[3]" />
                                                        </div>
                                                        <span className="font-medium text-slate-800">Vacunación antirrábica y refuerzos anuales</span>
                                                    </li>
                                                    <li className="flex items-center gap-2">
                                                        <div className="w-4 h-4 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                                            <Check className="w-2.5 h-2.5 stroke-[3]" />
                                                        </div>
                                                        <span className="font-medium text-slate-800">Desparasitación interna y externa periódica</span>
                                                    </li>
                                                    <li className="flex items-center gap-2">
                                                        <div className="w-4 h-4 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                                            <Check className="w-2.5 h-2.5 stroke-[3]" />
                                                        </div>
                                                        <span className="font-medium text-slate-800">Kit de bienvenida + Carnet Digital QR</span>
                                                    </li>
                                                </>
                                            )}
                                        </ul>
                                    </div>
                                </div>

                                <div className="pt-4 border-t border-slate-100 flex items-center gap-2">
                                    <a
                                        href={`/admin/${tenantSlug}/subscriptions/create`}
                                        className="flex-1 py-2 px-3 rounded-xl bg-[#0080ff] hover:bg-blue-600 text-white text-xs font-bold text-center transition shadow-2xs"
                                    >
                                        Afiliar Mascota a este Plan
                                    </a>
                                    <a
                                        href={`/admin/${tenantSlug}/counter-redeem`}
                                        className="py-2 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition"
                                    >
                                        Ver Canjes
                                    </a>
                                </div>
                            </div>
                        );
                    })}
                </div>
            </div>
        </VetAdminLayout>
    );
}
