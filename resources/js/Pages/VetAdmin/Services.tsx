import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { BookOpen, Search, CheckCircle2, Tag } from 'lucide-react';

interface ServiceItem {
    id: string;
    name: string;
    category: string;
    description: string;
    is_active: boolean;
}

interface ServicesProps {
    tenantSlug: string;
    brandName: string;
    clinicSubtitle: string;
    logoUrl?: string | null;
    saasPlan: any;
    logoutUrl: string;
    userName: string;
    userRole: string;
    services: ServiceItem[];
    totalCount: number;
}

export default function Services({
    tenantSlug,
    brandName,
    clinicSubtitle,
    logoUrl,
    saasPlan,
    logoutUrl,
    userName,
    userRole,
    services = [],
    totalCount = 32,
}: ServicesProps) {
    const [search, setSearch] = useState('');
    const [selectedCat, setSelectedCat] = useState('all');

    const categories = ['all', ...Array.from(new Set(services.map((s) => s.category)))];

    const filtered = services.filter((s) => {
        const matchesSearch =
            s.name.toLowerCase().includes(search.toLowerCase()) ||
            s.description.toLowerCase().includes(search.toLowerCase());
        const matchesCat = selectedCat === 'all' || s.category === selectedCat;
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
            activeItem="Catálogo de Servicios"
        >
            <Head title={`Catálogo de Servicios · ${brandName}`} />

            <div className="space-y-4">
                {/* Header Banner */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div className="flex items-center gap-2">
                            <h1 className="text-xl font-black text-slate-900">
                                Catálogo Maestro de Servicios Clínicos
                            </h1>
                            <span className="text-[10px] font-bold px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                                {totalCount} Procedimientos Registrados
                            </span>
                        </div>
                        <p className="text-xs text-slate-500 mt-1">
                            Definiciones de actos clínicos, vacunas, desparasitaciones y beneficios asignables a los planes de salud.
                        </p>
                    </div>

                    <a
                        href={`/admin/${tenantSlug}/plans`}
                        className="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition"
                    >
                        Ver Planes Asociados →
                    </a>
                </div>

                {/* Filters */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs flex flex-col md:flex-row items-center justify-between gap-3">
                    <div className="w-full md:w-80 relative">
                        <Search className="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
                        <input
                            type="text"
                            value={search}
                            onChange={(e) => setSearch(e.target.value)}
                            placeholder="Buscar servicio clínico..."
                            className="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 placeholder:text-slate-400 focus:outline-hidden focus:ring-2 focus:ring-blue-500 transition"
                        />
                    </div>

                    <div className="flex items-center gap-1.5 overflow-x-auto w-full md:w-auto pb-1">
                        {categories.slice(0, 6).map((cat) => (
                            <button
                                key={cat}
                                type="button"
                                onClick={() => setSelectedCat(cat)}
                                className={`px-3 py-1.5 rounded-xl text-xs font-bold capitalize whitespace-nowrap transition ${
                                    selectedCat === cat
                                        ? 'bg-[#0080ff] text-white shadow-xs'
                                        : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200'
                                }`}
                            >
                                {cat === 'all' ? 'Todos los Servicios' : cat}
                            </button>
                        ))}
                    </div>
                </div>

                {/* Services Table */}
                <div className="bg-white border border-slate-200/90 rounded-2xl shadow-2xs overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left border-collapse">
                            <thead>
                                <tr className="border-b border-slate-100 bg-slate-50/75 text-[11px] font-black uppercase text-slate-400 tracking-wider">
                                    <th className="py-3 px-4">Procedimiento / Beneficio</th>
                                    <th className="py-3 px-4">Categoría Clínica</th>
                                    <th className="py-3 px-4">Descripción Operativa</th>
                                    <th className="py-3 px-4 text-right">Estado</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100 text-xs">
                                {filtered.map((s) => (
                                    <tr key={s.id} className="hover:bg-slate-50/60 transition">
                                        <td className="py-3.5 px-4 font-bold text-slate-900">
                                            <div className="flex items-center gap-2.5">
                                                <span className="text-base">🩺</span>
                                                <span>{s.name}</span>
                                            </div>
                                        </td>
                                        <td className="py-3.5 px-4">
                                            <span className="inline-flex items-center px-2 py-0.5 rounded-md text-[10.5px] font-bold bg-blue-50 text-blue-700 capitalize border border-blue-200">
                                                {s.category}
                                            </span>
                                        </td>
                                        <td className="py-3.5 px-4 text-slate-600 max-w-md">
                                            {s.description}
                                        </td>
                                        <td className="py-3.5 px-4 text-right">
                                            <span className="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700">
                                                <CheckCircle2 className="w-3.5 h-3.5" />
                                                <span>Habilitado</span>
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
