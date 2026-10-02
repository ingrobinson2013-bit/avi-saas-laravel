import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { Search, ShieldCheck, CheckCircle2, Calendar, FileText, ArrowUpRight, DollarSign } from 'lucide-react';

interface SubItem {
    id: string;
    pet_name: string;
    pet_breed: string;
    customer_name: string;
    customer_phone: string;
    plan_name: string;
    price_cop: number;
    formatted_price: string;
    status: string;
    status_label: string;
    start_date: string;
    end_date: string;
}

interface SubscriptionsProps {
    tenantSlug: string;
    brandName: string;
    clinicSubtitle: string;
    logoUrl?: string | null;
    saasPlan: any;
    logoutUrl: string;
    userName: string;
    userRole: string;
    subscriptions: SubItem[];
    totalCount: number;
    mrr: number;
    formattedMrr: string;
}

export default function Subscriptions({
    tenantSlug,
    brandName,
    clinicSubtitle,
    logoUrl,
    saasPlan,
    logoutUrl,
    userName,
    userRole,
    subscriptions = [],
    totalCount = 1,
    mrr = 50000,
    formattedMrr = '$50.000 COP',
}: SubscriptionsProps) {
    const [search, setSearch] = useState('');

    const filtered = subscriptions.filter(
        (s) =>
            s.pet_name.toLowerCase().includes(search.toLowerCase()) ||
            s.customer_name.toLowerCase().includes(search.toLowerCase()) ||
            s.plan_name.toLowerCase().includes(search.toLowerCase())
    );

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
            activeItem="Membresías & Afiliaciones"
        >
            <Head title={`Membresías & Recurrencia · ${brandName}`} />

            <div className="space-y-4">
                {/* Header Banner */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div className="flex items-center gap-2">
                            <h1 className="text-xl font-black text-slate-900">
                                Membresías & Recurrencia
                            </h1>
                            <span className="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                {totalCount} Activas
                            </span>
                        </div>
                        <p className="text-xs text-slate-500 mt-1">
                            Control de contratos médicos activos, recaudación recurrente y fechas de renovación periódica.
                        </p>
                    </div>

                    <div className="flex items-center gap-2">
                        <a
                            href={`/v/${tenantSlug}/afiche`}
                            target="_blank"
                            rel="noreferrer"
                            className="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition"
                        >
                            <span>Descargar QR Mostrador</span>
                        </a>
                    </div>
                </div>

                {/* KPI Metrics Summary */}
                <div className="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">MRR Recurrente Mensual</span>
                        <div className="text-2xl font-black text-slate-900">{formattedMrr}</div>
                        <span className="text-[10.5px] font-bold text-emerald-600 mt-1 block">↗ 100% Cartera al día</span>
                    </div>

                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">Suscripciones Activas</span>
                        <div className="text-2xl font-black text-slate-900">{totalCount}</div>
                        <span className="text-[10.5px] font-medium text-blue-600 mt-1 block">1 Paciente afiliado</span>
                    </div>

                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">Renovaciones Próximos 15 Días</span>
                        <div className="text-2xl font-black text-slate-900">0</div>
                        <span className="text-[10.5px] font-medium text-slate-500 mt-1 block">Sin riesgo de vencimiento</span>
                    </div>
                </div>

                {/* Subscriptions Table */}
                <div className="bg-white border border-slate-200/90 rounded-2xl shadow-2xs overflow-hidden">
                    <div className="p-4 border-b border-slate-100">
                        <div className="w-full sm:w-80 relative">
                            <Search className="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
                            <input
                                type="text"
                                value={search}
                                onChange={(e) => setSearch(e.target.value)}
                                placeholder="Buscar por paciente, tutor o plan..."
                                className="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 placeholder:text-slate-400 focus:outline-hidden focus:ring-2 focus:ring-blue-500 transition"
                            />
                        </div>
                    </div>

                    <div className="overflow-x-auto">
                        <table className="w-full text-left border-collapse">
                            <thead>
                                <tr className="border-b border-slate-100 bg-slate-50/75 text-[11px] font-black uppercase text-slate-400 tracking-wider">
                                    <th className="py-3 px-4">Contrato ID</th>
                                    <th className="py-3 px-4">Paciente</th>
                                    <th className="py-3 px-4">Tutor</th>
                                    <th className="py-3 px-4">Plan & Cuota</th>
                                    <th className="py-3 px-4">Vigencia Periodo</th>
                                    <th className="py-3 px-4">Estado</th>
                                    <th className="py-3 px-4 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100 text-xs">
                                {filtered.map((s) => (
                                    <tr key={s.id} className="hover:bg-slate-50/60 transition group">
                                        <td className="py-3.5 px-4 font-mono font-bold text-slate-800 text-[11px]">
                                            #{s.id.substring(0, 8)}
                                        </td>
                                        <td className="py-3.5 px-4">
                                            <div className="font-bold text-slate-900">{s.pet_name}</div>
                                            <span className="text-[10px] text-slate-400">{s.pet_breed}</span>
                                        </td>
                                        <td className="py-3.5 px-4">
                                            <div className="font-semibold text-slate-900">{s.customer_name}</div>
                                            <span className="text-[10px] text-slate-400">📱 {s.customer_phone}</span>
                                        </td>
                                        <td className="py-3.5 px-4">
                                            <div className="font-bold text-blue-900">{s.plan_name}</div>
                                            <span className="text-[11px] text-emerald-700 font-semibold">{s.formatted_price}</span>
                                        </td>
                                        <td className="py-3.5 px-4 text-slate-600 font-medium">
                                            {s.start_date} – {s.end_date}
                                        </td>
                                        <td className="py-3.5 px-4">
                                            <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10.5px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                                <CheckCircle2 className="w-3 h-3 text-emerald-600" />
                                                <span>{s.status_label}</span>
                                            </span>
                                        </td>
                                        <td className="py-3.5 px-4 text-right">
                                            <div className="inline-flex items-center gap-1.5">
                                                <a
                                                    href={`/admin/${tenantSlug}/counter-redeem`}
                                                    className="px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 text-[11px] font-bold transition"
                                                >
                                                    Canjear
                                                </a>
                                                <a
                                                    href={`/v/${tenantSlug}/carnet/${s.id}`}
                                                    target="_blank"
                                                    rel="noreferrer"
                                                    className="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 text-[11px] font-bold transition inline-flex items-center gap-1"
                                                >
                                                    <span>Carnet</span>
                                                    <ArrowUpRight className="w-3 h-3" />
                                                </a>
                                            </div>
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
