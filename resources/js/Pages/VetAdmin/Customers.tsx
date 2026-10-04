import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { Search, UserPlus, Phone, Mail, MapPin, CheckCircle2 } from 'lucide-react';

interface CustomerItem {
    id: string;
    name: string;
    identification: string;
    phone: string;
    email: string;
    address: string;
    pets_count: number;
    pets_names: string;
    status: string;
    created_at: string;
}

interface CustomersProps {
    tenantSlug: string;
    brandName: string;
    clinicSubtitle: string;
    logoUrl?: string | null;
    saasPlan: any;
    logoutUrl: string;
    userName: string;
    userRole: string;
    customers: CustomerItem[];
    totalCount: number;
}

export default function Customers({
    tenantSlug,
    brandName,
    clinicSubtitle,
    logoUrl,
    saasPlan,
    logoutUrl,
    userName,
    userRole,
    customers = [],
    totalCount = 1,
}: CustomersProps) {
    const [search, setSearch] = useState('');

    const filtered = customers.filter(
        (c) =>
            c.name.toLowerCase().includes(search.toLowerCase()) ||
            c.phone.includes(search) ||
            c.identification.includes(search)
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
            activeItem="Tutores"
        >
            <Head title={`Directorio de Tutores · ${brandName}`} />

            <div className="w-full space-y-5 pb-16">
                {/* Header Banner */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div className="flex items-center gap-2">
                            <h1 className="text-xl font-black text-slate-900">
                                Tutores y Propietarios
                            </h1>
                            <span className="text-[10px] font-bold px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                                {totalCount} Titulares Registrados
                            </span>
                        </div>
                        <p className="text-xs text-slate-500 mt-1">
                            Directorio centralizado de tutores con información de contacto, WhatsApp y mascotas suscritas.
                        </p>
                    </div>

                    <div className="flex items-center gap-2">
                        <a
                            href={`https://wa.me/`}
                            target="_blank"
                            rel="noreferrer"
                            className="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-xs"
                        >
                            <span>WhatsApp Masivo</span>
                        </a>
                    </div>
                </div>

                {/* Search Bar */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                    <div className="w-full md:w-96 relative">
                        <Search className="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
                        <input
                            type="text"
                            value={search}
                            onChange={(e) => setSearch(e.target.value)}
                            placeholder="Buscar por nombre, cédula o WhatsApp..."
                            className="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 placeholder:text-slate-400 focus:outline-hidden focus:ring-2 focus:ring-blue-500 transition"
                        />
                    </div>
                </div>

                {/* Customers Table */}
                <div className="bg-white border border-slate-200/90 rounded-2xl shadow-2xs overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left border-collapse">
                            <thead>
                                <tr className="border-b border-slate-100 bg-slate-50/75 text-[11px] font-black uppercase text-slate-400 tracking-wider">
                                    <th className="py-3 px-4">Tutor</th>
                                    <th className="py-3 px-4">Documento</th>
                                    <th className="py-3 px-4">Contacto Directo</th>
                                    <th className="py-3 px-4">Ubicación</th>
                                    <th className="py-3 px-4">Mascotas Vinculadas</th>
                                    <th className="py-3 px-4">Estado</th>
                                    <th className="py-3 px-4 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100 text-xs">
                                {filtered.map((c) => (
                                    <tr key={c.id} className="hover:bg-slate-50/60 transition group">
                                        <td className="py-3.5 px-4">
                                            <div className="flex items-center gap-3">
                                                <div className="w-9 h-9 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center font-bold text-indigo-700 text-xs shrink-0">
                                                    {c.name.substring(0, 2).toUpperCase()}
                                                </div>
                                                <div>
                                                    <span className="font-bold text-slate-900 block text-sm">
                                                        {c.name}
                                                    </span>
                                                    <span className="text-[10px] text-slate-400">
                                                        Cliente desde {c.created_at}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td className="py-3.5 px-4 font-mono text-slate-700 font-semibold">
                                            CC {c.identification}
                                        </td>
                                        <td className="py-3.5 px-4">
                                            <a
                                                href={`https://wa.me/${c.phone}`}
                                                target="_blank"
                                                rel="noreferrer"
                                                className="text-emerald-700 font-semibold hover:underline flex items-center gap-1.5"
                                            >
                                                <span>💬 {c.phone}</span>
                                            </a>
                                            <span className="text-[10.5px] text-slate-400 block mt-0.5">{c.email}</span>
                                        </td>
                                        <td className="py-3.5 px-4 text-slate-600">
                                            {c.address}
                                        </td>
                                        <td className="py-3.5 px-4">
                                            <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-blue-800 border border-blue-200">
                                                <span>🐾 {c.pets_names}</span>
                                            </span>
                                        </td>
                                        <td className="py-3.5 px-4">
                                            <span className="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700">
                                                <CheckCircle2 className="w-3.5 h-3.5" />
                                                <span>Al día</span>
                                            </span>
                                        </td>
                                        <td className="py-3.5 px-4 text-right">
                                            <a
                                                href={`https://wa.me/${c.phone}?text=${encodeURIComponent(`Hola ${c.name}, te saludamos de ${brandName}.`)}`}
                                                target="_blank"
                                                rel="noreferrer"
                                                className="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-800 hover:bg-emerald-100 text-xs font-bold transition inline-flex items-center gap-1"
                                            >
                                                <span>Escribir</span>
                                            </a>
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
