import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { Layers, Plus, Check, ArrowRight, ShieldCheck, Sparkles } from 'lucide-react';

interface ServiceItem {
    id: string;
    name: string;
    category: string;
    description: string;
}

interface PlanCreateProps {
    tenantSlug: string;
    brandName: string;
    clinicSubtitle: string;
    logoUrl?: string | null;
    saasPlan: any;
    logoutUrl: string;
    userName: string;
    userRole: string;
    services: ServiceItem[];
}

export default function PlanCreate({
    tenantSlug,
    brandName,
    clinicSubtitle,
    logoUrl,
    saasPlan,
    logoutUrl,
    userName,
    userRole,
    services = [],
}: PlanCreateProps) {
    const [name, setName] = useState('');
    const [description, setDescription] = useState('');
    const [priceCop, setPriceCop] = useState('50000');
    const [billingInterval, setBillingInterval] = useState('monthly');
    const [selectedServices, setSelectedServices] = useState<string[]>([]);
    const [savedSuccess, setSavedSuccess] = useState(false);

    const toggleService = (id: string) => {
        setSelectedServices((prev) =>
            prev.includes(id) ? prev.filter((item) => item !== id) : [...prev, id]
        );
    };

    const handleSave = (e: React.FormEvent) => {
        e.preventDefault();
        setSavedSuccess(true);
        setTimeout(() => {
            window.location.href = `/admin/${tenantSlug}/plans`;
        }, 1500);
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
            activeItem="Constructor de Planes"
        >
            <Head title={`Constructor de Planes · ${brandName}`} />

            <div className="space-y-4">
                {/* Header Banner */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div className="flex items-center gap-2">
                            <h1 className="text-xl font-black text-slate-900">
                                Constructor de Planes de Salud
                            </h1>
                            <span className="text-[10px] font-bold px-2 py-0.5 rounded-full bg-purple-50 text-purple-700 border border-purple-200">
                                Asistente Interactivo
                            </span>
                        </div>
                        <p className="text-xs text-slate-500 mt-1">
                            Estructura un nuevo plan de suscripción médica, define el canon recurrente y selecciona los servicios incluidos.
                        </p>
                    </div>

                    <a
                        href={`/admin/${tenantSlug}/plans`}
                        className="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition"
                    >
                        ← Volver a Planes
                    </a>
                </div>

                {savedSuccess && (
                    <div className="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2">
                        <Check className="w-4 h-4 text-emerald-600" />
                        <span>¡Plan creado exitosamente! Redirigiendo al catálogo de planes...</span>
                    </div>
                )}

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    {/* Formulario */}
                    <div className="lg:col-span-2 bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-4">
                        <form onSubmit={handleSave} className="space-y-4">
                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">
                                    Nombre del Plan de Salud *
                                </label>
                                <input
                                    type="text"
                                    required
                                    value={name}
                                    onChange={(e) => setName(e.target.value)}
                                    placeholder="Ej: Plan Patitas Cachorros / Plan Senior VIP"
                                    className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden transition"
                                />
                            </div>

                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">
                                        Precio Recurrente (COP) *
                                    </label>
                                    <input
                                        type="number"
                                        required
                                        value={priceCop}
                                        onChange={(e) => setPriceCop(e.target.value)}
                                        placeholder="50000"
                                        className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden transition"
                                    />
                                </div>

                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">
                                        Periodicidad de Cobro *
                                    </label>
                                    <select
                                        value={billingInterval}
                                        onChange={(e) => setBillingInterval(e.target.value)}
                                        className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden transition"
                                    >
                                        <option value="monthly">Mensual</option>
                                        <option value="yearly">Anual (con descuento)</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">
                                    Descripción & Enfoque Clínico
                                </label>
                                <textarea
                                    rows={2}
                                    value={description}
                                    onChange={(e) => setDescription(e.target.value)}
                                    placeholder="Describe qué mascota se beneficia de este plan y las ventajas preventivas..."
                                    className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden transition"
                                />
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-2">
                                    Selecciona los Servicios y Coberturas Incluidas ({selectedServices.length} seleccionados)
                                </label>
                                <div className="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-72 overflow-y-auto p-2 bg-slate-50 rounded-xl border border-slate-200">
                                    {services.slice(0, 16).map((service) => {
                                        const isSelected = selectedServices.includes(service.id);
                                        return (
                                            <button
                                                key={service.id}
                                                type="button"
                                                onClick={() => toggleService(service.id)}
                                                className={`text-left p-2.5 rounded-xl border text-xs transition flex items-center justify-between gap-2 ${
                                                    isSelected
                                                        ? 'bg-blue-50 border-blue-300 text-blue-900 font-bold'
                                                        : 'bg-white border-slate-200 text-slate-700 hover:bg-slate-100'
                                                }`}
                                            >
                                                <span className="truncate">{service.name}</span>
                                                {isSelected && <Check className="w-3.5 h-3.5 text-blue-600 shrink-0" />}
                                            </button>
                                        );
                                    })}
                                </div>
                            </div>

                            <button
                                type="submit"
                                className="w-full py-2.5 px-4 rounded-xl bg-[#0080ff] hover:bg-blue-600 text-white text-xs font-bold transition shadow-xs flex items-center justify-center gap-1.5"
                            >
                                <span>Guardar y Publicar Plan</span>
                                <ArrowRight className="w-4 h-4" />
                            </button>
                        </form>
                    </div>

                    {/* Previsualización en Vivo */}
                    <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col justify-between">
                        <div>
                            <span className="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-2">
                                Vista Previa para el Tutor
                            </span>

                            <div className="rounded-xl border border-blue-200 bg-gradient-to-b from-blue-50/40 to-white p-4">
                                <h3 className="text-base font-black text-slate-900">
                                    {name || 'Nuevo Plan Patitas'}
                                </h3>
                                <p className="text-xs text-slate-500 mt-1">
                                    {description || 'Cobertura médica integral para el bienestar continuo de tu mascota.'}
                                </p>

                                <div className="my-4 p-3 rounded-lg bg-white border border-slate-200">
                                    <span className="text-xl font-black text-slate-900">
                                        ${Number(priceCop || 0).toLocaleString('es-CO')} COP
                                    </span>
                                    <span className="text-xs text-slate-400 font-medium ml-1">
                                        / {billingInterval === 'monthly' ? 'mes' : 'año'}
                                    </span>
                                </div>

                                <div className="space-y-1.5 text-xs text-slate-700">
                                    <div className="font-bold text-slate-800 text-[11px] uppercase">
                                        Servicios ({selectedServices.length}):
                                    </div>
                                    {selectedServices.length > 0 ? (
                                        <p className="text-emerald-700 font-semibold text-[11.5px]">
                                            ✓ {selectedServices.length} coberturas seleccionadas listas para canjear.
                                        </p>
                                    ) : (
                                        <p className="text-slate-400 text-xs">
                                            Selecciona servicios de la lista para agregarlos al plan.
                                        </p>
                                    )}
                                </div>
                            </div>
                        </div>

                        <div className="pt-4 border-t border-slate-100 text-center">
                            <span className="text-[11px] text-slate-400">
                                Se sincronizará automáticamente con el mostrador y la tienda B2C.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </VetAdminLayout>
    );
}
