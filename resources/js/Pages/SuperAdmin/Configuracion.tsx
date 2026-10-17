import React, { useState } from 'react';
import { Head, router } from '@inertiajs/react';
import SuperAdminLayout from '@/Layouts/SuperAdminLayout';
import { 
    Settings, 
    CreditCard, 
    ShieldCheck, 
    Server, 
    Copy, 
    Check, 
    Eye, 
    EyeOff, 
    Database, 
    Mail, 
    Phone, 
    Globe, 
    Save, 
    Sliders,
    Sparkles,
    CheckCircle2
} from 'lucide-react';

interface ConfigProps {
    config: {
        bold_identity_key: string;
        bold_secret_key: string;
        bold_webhook_url: string;
        bold_mode: string;
        trial_days: number;
        default_saas_fee: number;
        enterprise_saas_fee: number;
        platform_name: string;
        support_email: string;
        support_phone: string;
        base_domain: string;
        system: {
            db_status: string;
            php_version: string;
            laravel_version: string;
            server_ip: string;
            environment: string;
            tenants_count: number;
            users_count: number;
            prospectos_count: number;
        };
    };
    userName?: string;
    userEmail?: string;
}

export default function Configuracion({
    config,
    userName = 'Robinson Naranjo',
    userEmail = 'superadmin@avipetapp.com'
}: ConfigProps) {
    const [copiedKey, setCopiedKey] = useState<string | null>(null);
    const [showSecret, setShowSecret] = useState(false);
    const [isSaving, setIsSaving] = useState(false);
    const [saveSuccess, setSaveSuccess] = useState(false);

    const [form, setForm] = useState({
        trial_days: config.trial_days,
        default_saas_fee: config.default_saas_fee,
        enterprise_saas_fee: config.enterprise_saas_fee,
        support_email: config.support_email,
        support_phone: config.support_phone,
    });

    const handleCopy = (text: string, label: string) => {
        navigator.clipboard.writeText(text);
        setCopiedKey(label);
        setTimeout(() => setCopiedKey(null), 2000);
    };

    const handleSave = (e: React.FormEvent) => {
        e.preventDefault();
        setIsSaving(true);
        router.post('/super-admin/configuracion', form, {
            onSuccess: () => {
                setIsSaving(false);
                setSaveSuccess(true);
                setTimeout(() => setSaveSuccess(false), 3000);
            },
            onError: () => setIsSaving(false)
        });
    };

    return (
        <SuperAdminLayout
            userName={userName}
            userEmail={userEmail}
            activeItem="Configuración"
        >
            <Head title="Configuración Global - SuperAdmin" />

            <div className="space-y-6 max-w-full">
                {/* HEADER */}
                <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 className="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                            <Settings className="w-7 h-7 text-teal-600" />
                            Configuración del Sistema
                        </h1>
                        <p className="text-sm text-slate-500 mt-1">
                            Ajustes globales de la plataforma AviPetApp, llaves de recaudo Bold y parámetros de suscripción SaaS.
                        </p>
                    </div>

                    {saveSuccess && (
                        <div className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold animate-in fade-in">
                            <CheckCircle2 className="w-4 h-4 text-emerald-600" />
                            Cambios guardados con éxito
                        </div>
                    )}
                </div>

                <form onSubmit={handleSave} className="space-y-6">
                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        {/* TARJETA 1: PASARELA BOLD */}
                        <div className="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
                            <div className="flex items-center justify-between pb-3 border-b border-slate-100">
                                <div className="flex items-center gap-3">
                                    <div className="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                                        <CreditCard className="w-5 h-5" />
                                    </div>
                                    <div>
                                        <h3 className="text-sm font-bold text-slate-900">Pasarela de Recaudo Bold</h3>
                                        <p className="text-xs text-slate-500">Credenciales maestras API para cobro de mensualidades</p>
                                    </div>
                                </div>
                                <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <ShieldCheck className="w-3.5 h-3.5 text-emerald-600" />
                                    Producción
                                </span>
                            </div>

                            <div className="space-y-3 pt-1">
                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">
                                        Llave de Identidad (Identity Key)
                                    </label>
                                    <div className="relative flex items-center">
                                        <input
                                            type="text"
                                            readOnly
                                            value={config.bold_identity_key}
                                            className="w-full text-xs font-mono bg-slate-50 border border-slate-200 rounded-xl pl-3 pr-10 py-2.5 text-slate-800 select-all"
                                        />
                                        <button
                                            type="button"
                                            onClick={() => handleCopy(config.bold_identity_key, 'identity')}
                                            className="absolute right-2 p-1.5 text-slate-400 hover:text-teal-600 cursor-pointer"
                                            title="Copiar llave"
                                        >
                                            {copiedKey === 'identity' ? (
                                                <Check className="w-4 h-4 text-emerald-600" />
                                            ) : (
                                                <Copy className="w-4 h-4" />
                                            )}
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">
                                        Llave Secreta (Secret Key)
                                    </label>
                                    <div className="relative flex items-center">
                                        <input
                                            type={showSecret ? 'text' : 'password'}
                                            readOnly
                                            value={config.bold_secret_key}
                                            className="w-full text-xs font-mono bg-slate-50 border border-slate-200 rounded-xl pl-3 pr-20 py-2.5 text-slate-800"
                                        />
                                        <div className="absolute right-2 flex items-center gap-1">
                                            <button
                                                type="button"
                                                onClick={() => setShowSecret(!showSecret)}
                                                className="p-1.5 text-slate-400 hover:text-slate-600 cursor-pointer"
                                                title={showSecret ? 'Ocultar' : 'Ver'}
                                            >
                                                {showSecret ? <EyeOff className="w-4 h-4" /> : <Eye className="w-4 h-4" />}
                                            </button>
                                            <button
                                                type="button"
                                                onClick={() => handleCopy(config.bold_secret_key, 'secret')}
                                                className="p-1.5 text-slate-400 hover:text-teal-600 cursor-pointer"
                                                title="Copiar secreta"
                                            >
                                                {copiedKey === 'secret' ? (
                                                    <Check className="w-4 h-4 text-emerald-600" />
                                                ) : (
                                                    <Copy className="w-4 h-4" />
                                                )}
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">
                                        Webhook URL de Retorno
                                    </label>
                                    <div className="relative flex items-center">
                                        <input
                                            type="text"
                                            readOnly
                                            value={config.bold_webhook_url}
                                            className="w-full text-xs font-mono bg-slate-50 border border-slate-200 rounded-xl pl-3 pr-10 py-2.5 text-slate-600 select-all"
                                        />
                                        <button
                                            type="button"
                                            onClick={() => handleCopy(config.bold_webhook_url, 'webhook')}
                                            className="absolute right-2 p-1.5 text-slate-400 hover:text-teal-600 cursor-pointer"
                                            title="Copiar URL de webhook"
                                        >
                                            {copiedKey === 'webhook' ? (
                                                <Check className="w-4 h-4 text-emerald-600" />
                                            ) : (
                                                <Copy className="w-4 h-4" />
                                            )}
                                        </button>
                                    </div>
                                    <p className="text-[11px] text-slate-400 mt-1">Configurar en el panel de desarrollador de Bold para conciliación automática.</p>
                                </div>
                            </div>
                        </div>

                        {/* TARJETA 2: PARÁMETROS SAAS */}
                        <div className="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
                            <div className="flex items-center gap-3 pb-3 border-b border-slate-100">
                                <div className="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                                    <Sliders className="w-5 h-5" />
                                </div>
                                <div>
                                    <h3 className="text-sm font-bold text-slate-900">Parámetros de Suscripción</h3>
                                    <p className="text-xs text-slate-500">Valores por defecto para nuevas clínicas veterinarias</p>
                                </div>
                            </div>

                            <div className="space-y-3 pt-1">
                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">
                                        Días de Prueba Gratuita (Trial)
                                    </label>
                                    <input
                                        type="number"
                                        value={form.trial_days}
                                        onChange={(e) => setForm({ ...form, trial_days: parseInt(e.target.value) || 0 })}
                                        className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                    />
                                    <p className="text-[11px] text-slate-400 mt-1">Período de gracia inicial sin cobro obligatorio.</p>
                                </div>

                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">
                                        Canon Mensual Estándar / Starter (COP)
                                    </label>
                                    <input
                                        type="number"
                                        value={form.default_saas_fee}
                                        onChange={(e) => setForm({ ...form, default_saas_fee: parseFloat(e.target.value) || 0 })}
                                        className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                    />
                                </div>

                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">
                                        Canon Mensual Enterprise (COP)
                                    </label>
                                    <input
                                        type="number"
                                        value={form.enterprise_saas_fee}
                                        onChange={(e) => setForm({ ...form, enterprise_saas_fee: parseFloat(e.target.value) || 0 })}
                                        className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                    />
                                </div>
                            </div>
                        </div>

                        {/* TARJETA 3: CONTACTO Y SOPORTE */}
                        <div className="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
                            <div className="flex items-center gap-3 pb-3 border-b border-slate-100">
                                <div className="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                    <Globe className="w-5 h-5" />
                                </div>
                                <div>
                                    <h3 className="text-sm font-bold text-slate-900">Contacto y Canales Oficiales</h3>
                                    <p className="text-xs text-slate-500">Datos públicos para soporte a clínicas y tutores</p>
                                </div>
                            </div>

                            <div className="space-y-3 pt-1">
                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">
                                        Nombre de Plataforma
                                    </label>
                                    <input
                                        type="text"
                                        readOnly
                                        value={config.platform_name}
                                        className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-700 select-all"
                                    />
                                </div>

                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">
                                        Correo de Soporte Técnico
                                    </label>
                                    <input
                                        type="email"
                                        value={form.support_email}
                                        onChange={(e) => setForm({ ...form, support_email: e.target.value })}
                                        className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                    />
                                </div>

                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">
                                        WhatsApp Oficial de Soporte
                                    </label>
                                    <input
                                        type="text"
                                        value={form.support_phone}
                                        onChange={(e) => setForm({ ...form, support_phone: e.target.value })}
                                        className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                    />
                                </div>
                            </div>
                        </div>

                        {/* TARJETA 4: TELEMETRÍA Y SERVIDOR */}
                        <div className="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
                            <div className="flex items-center gap-3 pb-3 border-b border-slate-100">
                                <div className="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                    <Server className="w-5 h-5" />
                                </div>
                                <div>
                                    <h3 className="text-sm font-bold text-slate-900">Telemetría de Infraestructura</h3>
                                    <p className="text-xs text-slate-500">Estado de servicios, base de datos y servidor</p>
                                </div>
                            </div>

                            <div className="grid grid-cols-2 gap-3 pt-1 text-xs">
                                <div className="p-3 bg-slate-50 rounded-xl">
                                    <span className="text-[10px] font-bold uppercase text-slate-400 block">Base de Datos</span>
                                    <div className="font-bold text-slate-800 mt-0.5 flex items-center gap-1.5">
                                        <span className="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                        PostgreSQL (Supabase)
                                    </div>
                                </div>

                                <div className="p-3 bg-slate-50 rounded-xl">
                                    <span className="text-[10px] font-bold uppercase text-slate-400 block">PHP Runtime</span>
                                    <div className="font-bold text-slate-800 mt-0.5">{config.system.php_version}</div>
                                </div>

                                <div className="p-3 bg-slate-50 rounded-xl">
                                    <span className="text-[10px] font-bold uppercase text-slate-400 block">Framework</span>
                                    <div className="font-bold text-slate-800 mt-0.5">Laravel {config.system.laravel_version}</div>
                                </div>

                                <div className="p-3 bg-slate-50 rounded-xl">
                                    <span className="text-[10px] font-bold uppercase text-slate-400 block">Frontend Stack</span>
                                    <div className="font-bold text-teal-700 mt-0.5">React + Inertia + Tailwind</div>
                                </div>

                                <div className="p-3 bg-slate-50 rounded-xl col-span-2">
                                    <span className="text-[10px] font-bold uppercase text-slate-400 block">Servidor VPS</span>
                                    <div className="font-bold text-slate-800 mt-0.5">{config.system.server_ip}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* SUBMIT BUTTON */}
                    <div className="flex items-center justify-end">
                        <button
                            type="submit"
                            disabled={isSaving}
                            className="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white font-bold text-sm shadow-sm transition-all shadow-teal-600/20 hover:shadow-teal-600/30 disabled:opacity-50 cursor-pointer"
                        >
                            <Save className="w-4 h-4" />
                            {isSaving ? 'Guardando...' : 'Guardar Parámetros'}
                        </button>
                    </div>
                </form>
            </div>
        </SuperAdminLayout>
    );
}
