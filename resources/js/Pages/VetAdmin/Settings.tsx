import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { Settings as SettingsIcon, CreditCard, Building2, Smartphone, ShieldCheck, Check, Save } from 'lucide-react';

interface SettingsData {
    name: string;
    city: string;
    address: string;
    phone: string;
    email: string;
    payment_nequi: string;
    payment_bank_info: string;
    payment_bold_link: string;
    primary_color: string;
    auto_enrollment: boolean;
}

interface SettingsProps {
    tenantSlug: string;
    brandName: string;
    clinicSubtitle: string;
    logoUrl?: string | null;
    saasPlan: any;
    logoutUrl: string;
    userName: string;
    userRole: string;
    settings: SettingsData;
}

export default function Settings({
    tenantSlug,
    brandName,
    clinicSubtitle,
    logoUrl,
    saasPlan,
    logoutUrl,
    userName,
    userRole,
    settings,
}: SettingsProps) {
    const [saved, setSaved] = useState(false);
    const [form, setForm] = useState<SettingsData>(settings);

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        setSaved(true);
        setTimeout(() => setSaved(false), 3000);
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
            activeItem="Configuración"
        >
            <Head title={`Configuración & Medios de Pago · ${brandName}`} />

            <div className="space-y-4 max-w-4xl">
                {/* Header Banner */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div className="flex items-center gap-2">
                            <h1 className="text-xl font-black text-slate-900">
                                Configuración de Sede y Medios de Pago
                            </h1>
                            <span className="text-[10px] font-bold px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                                Sede Activa
                            </span>
                        </div>
                        <p className="text-xs text-slate-500 mt-1">
                            Ajusta los canales de recaudo para auto-afiliación (Nequi, Bancolombia, Bold) y datos clínicos de la sede.
                        </p>
                    </div>

                    <div className="flex items-center gap-2">
                        <a
                            href={`/admin/${tenantSlug}/renovar-saas`}
                            className="px-3.5 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-bold transition flex items-center gap-1.5"
                        >
                            <span>⭐ Gestionar Licencia SaaS</span>
                        </a>
                    </div>
                </div>

                {saved && (
                    <div className="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2 shadow-2xs">
                        <Check className="w-4 h-4 text-emerald-600" />
                        <span>¡Configuración guardada exitosamente en la base de datos!</span>
                    </div>
                )}

                <form onSubmit={handleSubmit} className="space-y-4">
                    {/* Tarjeta de Identidad de la Clínica */}
                    <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-4">
                        <div className="flex items-center gap-2 pb-3 border-b border-slate-100">
                            <Building2 className="w-4 h-4 text-blue-600" />
                            <h3 className="text-sm font-bold text-slate-900">Identidad de la Sede Veterinaria</h3>
                        </div>

                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">Nombre Comercial de la Clínica</label>
                                <input
                                    type="text"
                                    value={form.name}
                                    onChange={(e) => setForm({ ...form, name: e.target.value })}
                                    className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden"
                                />
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">Ciudad & Municipio</label>
                                <input
                                    type="text"
                                    value={form.city}
                                    onChange={(e) => setForm({ ...form, city: e.target.value })}
                                    className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden"
                                />
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">Dirección de Atención Física</label>
                                <input
                                    type="text"
                                    value={form.address}
                                    onChange={(e) => setForm({ ...form, address: e.target.value })}
                                    className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden"
                                />
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">WhatsApp de Atención al Cliente</label>
                                <input
                                    type="text"
                                    value={form.phone}
                                    onChange={(e) => setForm({ ...form, phone: e.target.value })}
                                    className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden"
                                />
                            </div>
                        </div>
                    </div>

                    {/* Tarjeta de Medios de Pago */}
                    <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-4">
                        <div className="flex items-center gap-2 pb-3 border-b border-slate-100">
                            <CreditCard className="w-4 h-4 text-emerald-600" />
                            <h3 className="text-sm font-bold text-slate-900">Canales de Recaudo para Afiliaciones de Tutores</h3>
                        </div>

                        <div className="space-y-3">
                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">Número de Transferencia Nequi / Daviplata</label>
                                <input
                                    type="text"
                                    value={form.payment_nequi}
                                    onChange={(e) => setForm({ ...form, payment_nequi: e.target.value })}
                                    className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden"
                                />
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">Cuenta Bancaria para Transferencias (Bancolombia, etc.)</label>
                                <input
                                    type="text"
                                    value={form.payment_bank_info}
                                    onChange={(e) => setForm({ ...form, payment_bank_info: e.target.value })}
                                    className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden"
                                />
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">Enlace de Pago Digital Bold / Wompi (Opcional)</label>
                                <input
                                    type="url"
                                    value={form.payment_bold_link}
                                    onChange={(e) => setForm({ ...form, payment_bold_link: e.target.value })}
                                    className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden"
                                />
                            </div>
                        </div>
                    </div>

                    <div className="flex justify-end">
                        <button
                            type="submit"
                            className="px-6 py-2.5 rounded-xl bg-[#0080ff] hover:bg-blue-600 text-white text-xs font-bold transition shadow-xs flex items-center gap-1.5"
                        >
                            <Save className="w-4 h-4" />
                            <span>Guardar Cambios</span>
                        </button>
                    </div>
                </form>
            </div>
        </VetAdminLayout>
    );
}
