import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { Search, Plus, Filter, Heart, Eye, Edit2, ShieldCheck, Sparkles } from 'lucide-react';

interface PetItem {
    id: string;
    name: string;
    species: string;
    breed: string;
    birthdate: string;
    age: string;
    customer_name: string;
    customer_phone: string;
    plan_name: string;
    plan_status: string;
    photo_url: string;
    medical_notes: string;
}

interface PetsProps {
    tenantSlug: string;
    brandName: string;
    clinicSubtitle: string;
    logoUrl?: string | null;
    saasPlan: any;
    logoutUrl: string;
    userName: string;
    userRole: string;
    pets: PetItem[];
    totalCount: number;
    activePlansCount: number;
}

export default function Pets({
    tenantSlug,
    brandName,
    clinicSubtitle,
    logoUrl,
    saasPlan,
    logoutUrl,
    userName,
    userRole,
    pets = [],
    totalCount = 1,
    activePlansCount = 1,
}: PetsProps) {
    const [search, setSearch] = useState('');
    const [selectedSpecies, setSelectedSpecies] = useState('all');

    const filteredPets = pets.filter((p) => {
        const matchesSearch =
            p.name.toLowerCase().includes(search.toLowerCase()) ||
            p.breed.toLowerCase().includes(search.toLowerCase()) ||
            p.customer_name.toLowerCase().includes(search.toLowerCase());
        const matchesSpecies = selectedSpecies === 'all' || p.species.toLowerCase() === selectedSpecies.toLowerCase();
        return matchesSearch && matchesSpecies;
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
            activeItem="Clientes y Mascotas"
        >
            <Head title={`Pacientes y Mascotas · ${brandName}`} />

            <div className="space-y-4">
                {/* Header Banner */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div className="flex items-center gap-2">
                            <h1 className="text-xl font-black text-slate-900">
                                Clientes y Mascotas
                            </h1>
                            <span className="text-[10px] font-bold px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                                {totalCount} Pacientes Registrados
                            </span>
                        </div>
                        <p className="text-xs text-slate-500 mt-1">
                            Padrón clínico de mascotas con membresía activa y expediente médico en {brandName}.
                        </p>
                    </div>

                    <div className="flex items-center gap-2">
                        <a
                            href={`/admin/${tenantSlug}/subscriptions/create`}
                            className="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#0080ff] hover:bg-blue-600 text-white text-xs font-bold transition shadow-xs"
                        >
                            <Plus className="w-4 h-4" />
                            <span>Afiliar Paciente</span>
                        </a>
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
                            placeholder="Buscar por nombre, raza o tutor..."
                            className="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 placeholder:text-slate-400 focus:outline-hidden focus:ring-2 focus:ring-blue-500 transition"
                        />
                    </div>

                    <div className="flex items-center gap-2 w-full md:w-auto">
                        <button
                            type="button"
                            onClick={() => setSelectedSpecies('all')}
                            className={`px-3 py-1.5 rounded-xl text-xs font-bold transition ${
                                selectedSpecies === 'all'
                                    ? 'bg-[#0080ff] text-white shadow-xs'
                                    : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200'
                            }`}
                        >
                            Todos ({pets.length})
                        </button>
                        <button
                            type="button"
                            onClick={() => setSelectedSpecies('Canino')}
                            className={`px-3 py-1.5 rounded-xl text-xs font-bold transition ${
                                selectedSpecies === 'Canino'
                                    ? 'bg-[#0080ff] text-white shadow-xs'
                                    : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200'
                            }`}
                        >
                            🐶 Caninos
                        </button>
                        <button
                            type="button"
                            onClick={() => setSelectedSpecies('Felino')}
                            className={`px-3 py-1.5 rounded-xl text-xs font-bold transition ${
                                selectedSpecies === 'Felino'
                                    ? 'bg-[#0080ff] text-white shadow-xs'
                                    : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200'
                            }`}
                        >
                            🐱 Felinos
                        </button>
                    </div>
                </div>

                {/* Pets Data Table */}
                <div className="bg-white border border-slate-200/90 rounded-2xl shadow-2xs overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left border-collapse">
                            <thead>
                                <tr className="border-b border-slate-100 bg-slate-50/75 text-[11px] font-black uppercase text-slate-400 tracking-wider">
                                    <th className="py-3 px-4">Paciente</th>
                                    <th className="py-3 px-4">Especie & Raza</th>
                                    <th className="py-3 px-4">Tutor Responsable</th>
                                    <th className="py-3 px-4">Plan de Salud</th>
                                    <th className="py-3 px-4">Edad</th>
                                    <th className="py-3 px-4 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100 text-xs">
                                {filteredPets.map((pet) => (
                                    <tr key={pet.id} className="hover:bg-slate-50/60 transition group">
                                        <td className="py-3.5 px-4">
                                            <div className="flex items-center gap-3">
                                                <div className="w-10 h-10 rounded-full bg-blue-50 border border-blue-100 overflow-hidden flex items-center justify-center shrink-0">
                                                    <span className="text-xl">🐶</span>
                                                </div>
                                                <div>
                                                    <span className="font-bold text-slate-900 block text-sm">
                                                        {pet.name}
                                                    </span>
                                                    <span className="text-[10px] text-slate-400">
                                                        Expediente ID: #{pet.id.substring(0, 8)}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td className="py-3.5 px-4 font-medium text-slate-700">
                                            <div>{pet.breed}</div>
                                            <span className="text-[10.5px] text-slate-400 font-normal">{pet.species}</span>
                                        </td>
                                        <td className="py-3.5 px-4">
                                            <div className="font-semibold text-slate-900">{pet.customer_name}</div>
                                            <a
                                                href={`https://wa.me/${pet.customer_phone}`}
                                                target="_blank"
                                                rel="noreferrer"
                                                className="text-[11px] text-blue-600 hover:underline flex items-center gap-1"
                                            >
                                                <span>📱 {pet.customer_phone}</span>
                                            </a>
                                        </td>
                                        <td className="py-3.5 px-4">
                                            <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10.5px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                                <ShieldCheck className="w-3.5 h-3.5 text-emerald-600" />
                                                <span>{pet.plan_name}</span>
                                            </span>
                                        </td>
                                        <td className="py-3.5 px-4 text-slate-600 font-medium">
                                            {pet.age}
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
                                                    href={`/admin/${tenantSlug}/subscriptions`}
                                                    className="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 text-[11px] font-bold transition"
                                                >
                                                    Carnet
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
