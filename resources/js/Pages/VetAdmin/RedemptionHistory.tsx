import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { 
    History, 
    Search, 
    Zap, 
    CheckCircle2, 
    Clock, 
    Calendar, 
    User, 
    ShieldCheck, 
    ArrowLeft,
    Phone
} from 'lucide-react';

interface HistoryItem {
    id: string;
    date: string;
    time: string;
    pet_name: string;
    pet_breed?: string;
    customer_name: string;
    customer_phone?: string;
    benefit_name: string;
    category: string;
    attended_by: string;
    status: string;
    status_label: string;
}

interface RedemptionHistoryProps {
    tenantSlug: string;
    brandName: string;
    clinicSubtitle: string;
    logoUrl?: string | null;
    saasPlan: any;
    logoutUrl: string;
    userName: string;
    userRole: string;
    history: HistoryItem[];
    totalRedemptions: number;
}

export default function RedemptionHistory({
    tenantSlug,
    brandName,
    clinicSubtitle,
    logoUrl,
    saasPlan,
    logoutUrl,
    userName,
    userRole,
    history = [],
    totalRedemptions = 3,
}: RedemptionHistoryProps) {
    const [search, setSearch] = useState('');
    const [categoryFilter, setCategoryFilter] = useState('all');

    const filtered = history.filter((item) => {
        const matchesSearch =
            item.pet_name.toLowerCase().includes(search.toLowerCase()) ||
            item.customer_name.toLowerCase().includes(search.toLowerCase()) ||
            item.benefit_name.toLowerCase().includes(search.toLowerCase()) ||
            item.attended_by.toLowerCase().includes(search.toLowerCase());
        
        const matchesCat = categoryFilter === 'all' || item.category.toLowerCase().includes(categoryFilter.toLowerCase());
        return matchesSearch && matchesCat;
    });

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
            activeItem="Historial de Canjes"
        >
            <Head title={`Historial de Canjes · ${brandName}`} />

            <div className="w-full space-y-5 pb-16">
                {/* Header Banner */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div className="flex items-center gap-2">
                            <h1 className="text-xl font-black text-slate-900">
                                Historial de Canjes & Auditoría de Servicios
                            </h1>
                            <span className="text-[10px] font-bold px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                                {totalRedemptions} Actos Clínicos Registrados
                            </span>
                        </div>
                        <p className="text-xs text-slate-500 mt-1">
                            Auditoría de todos los procedimientos, vacunas y consultas redimidas en mostrador con fecha, hora y profesional responsable.
                        </p>
                    </div>

                    <div className="flex items-center gap-2">
                        <Link
                            href={`/admin/${tenantSlug}/counter-redeem`}
                            className="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#0080ff] hover:bg-blue-600 text-white text-xs font-bold transition shadow-xs"
                        >
                            <Zap className="w-4 h-4" />
                            <span>Ir a Terminal Mostrador</span>
                        </Link>
                    </div>
                </div>

                {/* Filter and Search Bar */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs flex flex-col md:flex-row items-center justify-between gap-3">
                    <div className="w-full md:w-80 relative">
                        <Search className="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
                        <input
                            type="text"
                            value={search}
                            onChange={(e) => setSearch(e.target.value)}
                            placeholder="Buscar por paciente, tutor o procedimiento..."
                            className="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 placeholder:text-slate-400 focus:outline-hidden focus:ring-2 focus:ring-blue-500 transition"
                        />
                    </div>

                    <div className="flex items-center gap-2 w-full md:w-auto overflow-x-auto pb-1">
                        {['all', 'consultas', 'vacunacion', 'prevencion'].map((cat) => (
                            <button
                                key={cat}
                                type="button"
                                onClick={() => setCategoryFilter(cat)}
                                className={`px-3 py-1.5 rounded-xl text-xs font-bold whitespace-nowrap transition ${
                                    categoryFilter === cat
                                        ? 'bg-[#0080ff] text-white shadow-xs'
                                        : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200'
                                }`}
                            >
                                {cat === 'all'
                                    ? 'Todos los Canjes'
                                    : cat === 'consultas'
                                    ? '🩺 Consultas'
                                    : cat === 'vacunacion'
                                    ? '💉 Vacunas'
                                    : '🛡️ Prevención'}
                            </button>
                        ))}
                    </div>
                </div>

                {/* Table */}
                <div className="bg-white border border-slate-200/90 rounded-2xl shadow-2xs overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr className="border-b border-slate-100 bg-slate-50/75 text-[11px] font-black uppercase text-slate-400 tracking-wider">
                                    <th className="py-3 px-4">Fecha & Hora</th>
                                    <th className="py-3 px-4">Paciente</th>
                                    <th className="py-3 px-4">Tutor</th>
                                    <th className="py-3 px-4">Procedimiento Redimido</th>
                                    <th className="py-3 px-4">Profesional Responsable</th>
                                    <th className="py-3 px-4 text-right">Estado</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100">
                                {filtered.map((item) => (
                                    <tr key={item.id} className="hover:bg-slate-50/60 transition">
                                        <td className="py-3.5 px-4 font-mono font-medium text-slate-600">
                                            <div className="font-bold text-slate-900">{item.date}</div>
                                            <span className="text-[10px] text-slate-400">{item.time}</span>
                                        </td>
                                        <td className="py-3.5 px-4">
                                            <div className="font-bold text-slate-900 flex items-center gap-1.5">
                                                <span>🐾 {item.pet_name}</span>
                                                {item.pet_breed && (
                                                    <span className="text-[10px] font-normal text-slate-400">({item.pet_breed})</span>
                                                )}
                                            </div>
                                        </td>
                                        <td className="py-3.5 px-4">
                                            <div className="font-semibold text-slate-800">{item.customer_name}</div>
                                            {item.customer_phone && (
                                                <a
                                                    href={`https://wa.me/${item.customer_phone}`}
                                                    target="_blank"
                                                    rel="noreferrer"
                                                    className="text-[10.5px] text-blue-600 hover:underline"
                                                >
                                                    📱 {item.customer_phone}
                                                </a>
                                            )}
                                        </td>
                                        <td className="py-3.5 px-4">
                                            <span className="font-bold text-blue-900 block">{item.benefit_name}</span>
                                            <span className="inline-flex items-center px-2 py-0.2 rounded text-[10px] font-bold bg-slate-100 text-slate-600 capitalize mt-0.5">
                                                {item.category}
                                            </span>
                                        </td>
                                        <td className="py-3.5 px-4 text-slate-700 font-medium">
                                            {item.attended_by}
                                        </td>
                                        <td className="py-3.5 px-4 text-right">
                                            <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10.5px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                                <CheckCircle2 className="w-3 h-3 text-emerald-600" />
                                                <span>{item.status_label}</span>
                                            </span>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>

                    {filtered.length === 0 && (
                        <div className="text-center py-10 text-slate-400 text-xs">
                            No se encontraron registros de canje con los términos buscados.
                        </div>
                    )}
                </div>
            </div>
        </VetAdminLayout>
    );
}
