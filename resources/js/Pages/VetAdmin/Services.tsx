import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import {
    BookOpen,
    Search,
    CheckCircle2,
    Plus,
    X,
    Trash2,
    Sparkles,
    Shield,
    AlertCircle,
    Loader2,
    Layers,
    Calendar,
    Stethoscope,
    Syringe,
    Pill,
    Droplet,
    FlaskConical,
    AlertTriangle,
    Home,
    Gift,
    Tag,
    Clock,
    FileText,
} from 'lucide-react';

interface ServiceItem {
    id: string;
    tenant_id?: string | null;
    name: string;
    category: string;
    description: string;
    default_validity_days?: number;
    plan_benefits_count?: number;
    is_custom?: boolean;
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

const CATEGORY_META: Record<string, { label: string; icon: string; badgeClass: string }> = {
    consulta: {
        label: 'Consulta Médica',
        icon: '🩺',
        badgeClass: 'bg-blue-50 text-blue-700 border-blue-200',
    },
    vacuna: {
        label: 'Vacunación',
        icon: '💉',
        badgeClass: 'bg-emerald-50 text-emerald-700 border-emerald-200',
    },
    desparasitacion: {
        label: 'Desparasitación',
        icon: '💊',
        badgeClass: 'bg-amber-50 text-amber-700 border-amber-200',
    },
    bano: {
        label: 'Baño & Estética',
        icon: '🛁',
        badgeClass: 'bg-cyan-50 text-cyan-700 border-cyan-200',
    },
    laboratorio: {
        label: 'Exámenes & Laboratorio',
        icon: '🔬',
        badgeClass: 'bg-purple-50 text-purple-700 border-purple-200',
    },
    urgencia: {
        label: 'Urgencias / Prioritaria',
        icon: '🚨',
        badgeClass: 'bg-rose-50 text-rose-700 border-rose-200',
    },
    odontologia: {
        label: 'Odontología & Profilaxis',
        icon: '🦷',
        badgeClass: 'bg-teal-50 text-teal-700 border-teal-200',
    },
    cirugia: {
        label: 'Quirúrgico / Esterilización',
        icon: '✂️',
        badgeClass: 'bg-orange-50 text-orange-700 border-orange-200',
    },
    guarderia: {
        label: 'Guardería / Hotel',
        icon: '🏠',
        badgeClass: 'bg-indigo-50 text-indigo-700 border-indigo-200',
    },
    bienvenida: {
        label: 'Kit Bienvenida',
        icon: '🎁',
        badgeClass: 'bg-pink-50 text-pink-700 border-pink-200',
    },
    descuento: {
        label: 'Descuento Especial',
        icon: '🏷️',
        badgeClass: 'bg-yellow-50 text-yellow-800 border-yellow-200',
    },
    funerario: {
        label: 'Previsión Exequial',
        icon: '🕊️',
        badgeClass: 'bg-slate-100 text-slate-700 border-slate-300',
    },
};

const SUGGESTIONS = [
    { name: 'Profilaxis Dental con Ultrasonido', category: 'odontologia', days: 365, desc: 'Limpieza dental integral bajo sedación asistida con pulido de esmalte y revisión periodontal.' },
    { name: 'Ecografía Abdominal Completa', category: 'laboratorio', days: 365, desc: 'Exploración ultrasonográfica abdominal con entrega de informe médico digital de alta resolución.' },
    { name: 'Vacuna Antirrábica Refuerzo Anual', category: 'vacuna', days: 365, desc: 'Aplicación de inmunización antirrábica con registro de certificación en libreta sanitaria.' },
    { name: 'Control Geriátrico & Renal Semestral', category: 'consulta', days: 180, desc: 'Consulta médica especializada para pacientes sénior con medición de tensión y perfil bioquímico.' },
];

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
    const [serviceList, setServiceList] = useState<ServiceItem[]>(services);
    const [search, setSearch] = useState('');
    const [selectedCat, setSelectedCat] = useState('all');
    const [filterCustomOnly, setFilterCustomOnly] = useState(false);

    // Modal state
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [formError, setFormError] = useState<string | null>(null);

    // New service form
    const [name, setName] = useState('');
    const [category, setCategory] = useState('consulta');
    const [description, setDescription] = useState('');
    const [validityDays, setValidityDays] = useState(365);

    // Toast notification
    const [toast, setToast] = useState<{ type: 'success' | 'error'; message: string } | null>(null);

    // Delete confirmation modal
    const [serviceToDelete, setServiceToDelete] = useState<ServiceItem | null>(null);
    const [isDeleting, setIsDeleting] = useState(false);

    const showToast = (message: string, type: 'success' | 'error' = 'success') => {
        setToast({ type, message });
        setTimeout(() => setToast(null), 4000);
    };

    const categories = ['all', ...Array.from(new Set(serviceList.map((s) => s.category)))];

    const filtered = serviceList.filter((s) => {
        const matchesSearch =
            s.name.toLowerCase().includes(search.toLowerCase()) ||
            s.description.toLowerCase().includes(search.toLowerCase());
        const matchesCat = selectedCat === 'all' || s.category === selectedCat;
        const matchesCustom = !filterCustomOnly || s.is_custom;
        return matchesSearch && matchesCat && matchesCustom;
    });

    const customCount = serviceList.filter((s) => s.is_custom).length;

    const handleCreateService = async (e: React.FormEvent) => {
        e.preventDefault();
        if (!name.trim()) {
            setFormError('Por favor ingresa el nombre del servicio o procedimiento.');
            return;
        }

        setIsSubmitting(true);
        setFormError(null);

        try {
            const res = await fetch(`/admin/${tenantSlug}/benefit-definitions`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({
                    name: name.trim(),
                    category: category,
                    description: description.trim() || undefined,
                    default_validity_days: validityDays,
                }),
            });

            const data = await res.json();

            if (!res.ok || !data.success) {
                throw new Error(data.message || 'No fue posible registrar el servicio clínico.');
            }

            // Append newly created service to the list
            const newService: ServiceItem = data.service || {
                id: data.id || `custom-${Date.now()}`,
                name: name.trim(),
                category: category,
                description: description.trim() || 'Procedimiento clínico habilitado para planes de salud.',
                default_validity_days: validityDays,
                is_custom: true,
                is_active: true,
                plan_benefits_count: 0,
            };

            setServiceList((prev) => [newService, ...prev]);
            showToast(`¡Servicio "${newService.name}" creado exitosamente! Ya está listo para añadirse a tus planes.`);

            // Reset and close
            setName('');
            setDescription('');
            setCategory('consulta');
            setValidityDays(365);
            setIsModalOpen(false);
        } catch (err: any) {
            setFormError(err.message || 'Error de conexión al guardar el servicio.');
        } finally {
            setIsSubmitting(false);
        }
    };

    const handleDeleteService = async () => {
        if (!serviceToDelete) return;
        setIsDeleting(true);

        try {
            const res = await fetch(`/admin/${tenantSlug}/benefit-definitions/${serviceToDelete.id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            const data = await res.json();

            if (!res.ok || !data.success) {
                throw new Error(data.message || 'No se pudo eliminar el servicio.');
            }

            setServiceList((prev) => prev.filter((s) => s.id !== serviceToDelete.id));
            showToast(`Servicio "${serviceToDelete.name}" eliminado correctamente.`);
            setServiceToDelete(null);
        } catch (err: any) {
            showToast(err.message || 'Error al eliminar el servicio.', 'error');
        } finally {
            setIsDeleting(false);
        }
    };

    const applySuggestion = (s: typeof SUGGESTIONS[0]) => {
        setName(s.name);
        setCategory(s.category);
        setDescription(s.desc);
        setValidityDays(s.days);
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
            activeItem="Catálogo de Servicios"
        >
            <Head title={`Catálogo de Servicios · ${brandName}`} />

            {/* Toast Feedback */}
            {toast && (
                <div
                    className={`fixed bottom-6 right-6 z-50 px-4 py-3 rounded-2xl shadow-xl border flex items-center gap-3 animate-in fade-in slide-in-from-bottom-4 duration-200 ${
                        toast.type === 'success'
                            ? 'bg-emerald-950 text-emerald-100 border-emerald-700/60'
                            : 'bg-rose-950 text-rose-100 border-rose-700/60'
                    }`}
                >
                    {toast.type === 'success' ? (
                        <CheckCircle2 className="w-5 h-5 text-emerald-400 shrink-0" />
                    ) : (
                        <AlertCircle className="w-5 h-5 text-rose-400 shrink-0" />
                    )}
                    <span className="text-xs font-semibold">{toast.message}</span>
                    <button
                        type="button"
                        onClick={() => setToast(null)}
                        className="ml-2 text-slate-400 hover:text-white"
                    >
                        <X className="w-4 h-4" />
                    </button>
                </div>
            )}

            <div className="w-full space-y-5 pb-16">
                {/* Header Banner */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    <div>
                        <div className="flex flex-wrap items-center gap-2">
                            <h1 className="text-xl font-black text-slate-900 tracking-tight">
                                Catálogo Maestro de Servicios Clínicos
                            </h1>
                            <span className="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200 flex items-center gap-1.5">
                                <Layers className="w-3 h-3 text-blue-500" />
                                {serviceList.length} Procedimientos Totales
                            </span>
                            {customCount > 0 && (
                                <span className="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-700 border border-purple-200 flex items-center gap-1.5">
                                    <Sparkles className="w-3 h-3 text-purple-500" />
                                    {customCount} Propios de la Sede
                                </span>
                            )}
                        </div>
                        <p className="text-xs text-slate-500 mt-1 max-w-2xl">
                            Define actos médicos, cirugías, exámenes diagnósticos y beneficios preventivos que tu clínica puede empaquetar en planes de salud y membresías de suscripción.
                        </p>
                    </div>

                    <div className="flex items-center gap-2.5 shrink-0">
                        <button
                            type="button"
                            onClick={() => setIsModalOpen(true)}
                            className="px-4 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-xs font-bold transition shadow-xs flex items-center gap-2 cursor-pointer active:scale-95"
                        >
                            <Plus className="w-4 h-4 stroke-[2.5]" />
                            <span>Nuevo Servicio Clínico</span>
                        </button>

                        <a
                            href={`/admin/${tenantSlug}/plans`}
                            className="px-3.5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5"
                        >
                            <span>Planes de Salud</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

                {/* Filters & Search */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs flex flex-col md:flex-row items-center justify-between gap-3">
                    <div className="w-full md:w-80 relative">
                        <Search className="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
                        <input
                            type="text"
                            value={search}
                            onChange={(e) => setSearch(e.target.value)}
                            placeholder="Buscar procedimiento, vacuna, examen..."
                            className="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 placeholder:text-slate-400 focus:outline-hidden focus:ring-2 focus:ring-blue-500 transition"
                        />
                    </div>

                    <div className="flex items-center gap-1.5 overflow-x-auto w-full md:w-auto pb-1">
                        <button
                            type="button"
                            onClick={() => {
                                setSelectedCat('all');
                                setFilterCustomOnly(false);
                            }}
                            className={`px-3 py-1.5 rounded-xl text-xs font-bold whitespace-nowrap transition cursor-pointer ${
                                selectedCat === 'all' && !filterCustomOnly
                                    ? 'bg-[#0080ff] text-white shadow-xs'
                                    : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200'
                            }`}
                        >
                            Todos ({serviceList.length})
                        </button>

                        {customCount > 0 && (
                            <button
                                type="button"
                                onClick={() => setFilterCustomOnly(!filterCustomOnly)}
                                className={`px-3 py-1.5 rounded-xl text-xs font-bold whitespace-nowrap transition flex items-center gap-1.5 cursor-pointer ${
                                    filterCustomOnly
                                        ? 'bg-purple-600 text-white shadow-xs'
                                        : 'bg-purple-50 text-purple-700 hover:bg-purple-100 border border-purple-200'
                                }`}
                            >
                                <Sparkles className="w-3 h-3" />
                                Propios ({customCount})
                            </button>
                        )}

                        {categories.filter((c) => c !== 'all').slice(0, 7).map((cat) => {
                            const meta = CATEGORY_META[cat];
                            return (
                                <button
                                    key={cat}
                                    type="button"
                                    onClick={() => {
                                        setSelectedCat(cat);
                                        setFilterCustomOnly(false);
                                    }}
                                    className={`px-3 py-1.5 rounded-xl text-xs font-bold capitalize whitespace-nowrap transition cursor-pointer flex items-center gap-1 ${
                                        selectedCat === cat && !filterCustomOnly
                                            ? 'bg-[#0080ff] text-white shadow-xs'
                                            : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200'
                                    }`}
                                >
                                    <span>{meta?.icon || '🐾'}</span>
                                    <span>{meta?.label || cat}</span>
                                </button>
                            );
                        })}
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
                                    <th className="py-3 px-4 text-center">Vigencia Base</th>
                                    <th className="py-3 px-4 text-center">Tipo / Origen</th>
                                    <th className="py-3 px-4 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100 text-xs">
                                {filtered.length === 0 ? (
                                    <tr>
                                        <td colSpan={6} className="py-12 text-center text-slate-400">
                                            <div className="max-w-xs mx-auto space-y-2">
                                                <Layers className="w-8 h-8 text-slate-300 mx-auto" />
                                                <p className="font-bold text-slate-700">No se encontraron servicios</p>
                                                <p className="text-[11px]">No hay procedimientos que coincidan con la búsqueda o filtro aplicado.</p>
                                                <button
                                                    type="button"
                                                    onClick={() => {
                                                        setSearch('');
                                                        setSelectedCat('all');
                                                        setFilterCustomOnly(false);
                                                    }}
                                                    className="mt-2 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 font-bold text-xs hover:bg-blue-100 transition cursor-pointer"
                                                >
                                                    Restablecer filtros
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ) : (
                                    filtered.map((s) => {
                                        const meta = CATEGORY_META[s.category] || {
                                            label: s.category,
                                            icon: '🩺',
                                            badgeClass: 'bg-slate-100 text-slate-700 border-slate-200',
                                        };

                                        return (
                                            <tr key={s.id} className="hover:bg-slate-50/70 transition">
                                                <td className="py-3.5 px-4 font-bold text-slate-900">
                                                    <div className="flex items-center gap-2.5">
                                                        <span className="text-lg shrink-0">{meta.icon}</span>
                                                        <div>
                                                            <div className="font-extrabold text-slate-900">{s.name}</div>
                                                            {s.plan_benefits_count !== undefined && s.plan_benefits_count > 0 && (
                                                                <span className="text-[10px] text-emerald-600 font-semibold">
                                                                    En {s.plan_benefits_count} plan{s.plan_benefits_count > 1 ? 'es' : ''} activo{s.plan_benefits_count > 1 ? 's' : ''}
                                                                </span>
                                                            )}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td className="py-3.5 px-4">
                                                    <span
                                                        className={`inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[11px] font-bold border ${meta.badgeClass}`}
                                                    >
                                                        <span>{meta.icon}</span>
                                                        <span>{meta.label}</span>
                                                    </span>
                                                </td>
                                                <td className="py-3.5 px-4 text-slate-600 max-w-sm">
                                                    <p className="line-clamp-2 leading-relaxed text-[11.5px]">{s.description}</p>
                                                </td>
                                                <td className="py-3.5 px-4 text-center">
                                                    <span className="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-600 bg-slate-100 px-2 py-0.5 rounded-md">
                                                        <Clock className="w-3 h-3 text-slate-400" />
                                                        {s.default_validity_days || 365} días
                                                    </span>
                                                </td>
                                                <td className="py-3.5 px-4 text-center">
                                                    {s.is_custom ? (
                                                        <span className="inline-flex items-center gap-1 text-[10.5px] font-bold px-2 py-0.5 rounded-full bg-purple-50 text-purple-700 border border-purple-200">
                                                            <Sparkles className="w-3 h-3" />
                                                            Sede Propio
                                                        </span>
                                                    ) : (
                                                        <span className="inline-flex items-center gap-1 text-[10.5px] font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 border border-slate-200">
                                                            <Shield className="w-3 h-3" />
                                                            Catálogo Base
                                                        </span>
                                                    )}
                                                </td>
                                                <td className="py-3.5 px-4 text-right">
                                                    {s.is_custom ? (
                                                        <button
                                                            type="button"
                                                            onClick={() => setServiceToDelete(s)}
                                                            className="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition cursor-pointer"
                                                            title="Eliminar servicio propio"
                                                        >
                                                            <Trash2 className="w-4 h-4" />
                                                        </button>
                                                    ) : (
                                                        <span className="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700">
                                                            <CheckCircle2 className="w-3.5 h-3.5" />
                                                            <span>Activo</span>
                                                        </span>
                                                    )}
                                                </td>
                                            </tr>
                                        );
                                    })
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {/* Modal: Crear Nuevo Servicio Clínico */}
            {isModalOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-150">
                    <div className="bg-white rounded-3xl max-w-xl w-full p-6 shadow-2xl border border-slate-200 space-y-5 animate-in zoom-in-95 duration-150">
                        <div className="flex items-start justify-between pb-3 border-b border-slate-100">
                            <div>
                                <h3 className="text-lg font-black text-slate-900 flex items-center gap-2">
                                    <span>🩺</span>
                                    <span>Nuevo Servicio Clínico para {brandName}</span>
                                </h3>
                                <p className="text-xs text-slate-500 mt-0.5">
                                    Registra un procedimiento o beneficio para incluirlo en los planes de salud de tu clínica.
                                </p>
                            </div>
                            <button
                                type="button"
                                onClick={() => setIsModalOpen(false)}
                                className="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition cursor-pointer"
                            >
                                <X className="w-5 h-5" />
                            </button>
                        </div>

                        {/* Quick Suggestions */}
                        <div>
                            <span className="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1.5">
                                Sugerencias Frecuentes de Procedimientos:
                            </span>
                            <div className="flex flex-wrap gap-1.5">
                                {SUGGESTIONS.map((item, idx) => (
                                    <button
                                        key={idx}
                                        type="button"
                                        onClick={() => applySuggestion(item)}
                                        className="text-[11px] px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200 font-medium transition cursor-pointer flex items-center gap-1"
                                    >
                                        <span>+</span>
                                        <span>{item.name}</span>
                                    </button>
                                ))}
                            </div>
                        </div>

                        <form onSubmit={handleCreateService} className="space-y-4">
                            {/* Error Alert */}
                            {formError && (
                                <div className="p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold flex items-center gap-2">
                                    <AlertTriangle className="w-4 h-4 shrink-0" />
                                    <span>{formError}</span>
                                </div>
                            )}

                            {/* Name */}
                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">
                                    Nombre del Procedimiento / Servicio Clínico *
                                </label>
                                <input
                                    type="text"
                                    required
                                    value={name}
                                    onChange={(e) => setName(e.target.value)}
                                    placeholder="Ej: Ecografía Abdominal Completa, Profilaxis Dental, etc."
                                    className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-blue-500 font-medium"
                                />
                            </div>

                            {/* Category */}
                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1.5">
                                    Categoría Clínica *
                                </label>
                                <div className="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                    {Object.entries(CATEGORY_META).map(([key, meta]) => {
                                        const isSelected = category === key;
                                        return (
                                            <button
                                                key={key}
                                                type="button"
                                                onClick={() => setCategory(key)}
                                                className={`p-2.5 rounded-xl border text-left flex items-center gap-2 transition cursor-pointer ${
                                                    isSelected
                                                        ? 'bg-blue-50/80 border-blue-500 text-blue-900 font-bold ring-2 ring-blue-500/20'
                                                        : 'bg-white border-slate-200 text-slate-700 hover:bg-slate-50'
                                                }`}
                                            >
                                                <span className="text-base shrink-0">{meta.icon}</span>
                                                <span className="text-xs truncate">{meta.label}</span>
                                            </button>
                                        );
                                    })}
                                </div>
                            </div>

                            {/* Description */}
                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">
                                    Descripción Operativa / Protocolo de Atención
                                </label>
                                <textarea
                                    rows={2}
                                    value={description}
                                    onChange={(e) => setDescription(e.target.value)}
                                    placeholder="Detalles de lo que incluye el procedimiento, preparación del paciente o condiciones clínicas..."
                                    className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-blue-500 font-medium leading-relaxed"
                                />
                            </div>

                            {/* Validity days */}
                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">
                                    Vigencia por Defecto del Beneficio (Días)
                                </label>
                                <div className="flex items-center gap-3">
                                    <input
                                        type="number"
                                        min={1}
                                        max={3650}
                                        value={validityDays}
                                        onChange={(e) => setValidityDays(Number(e.target.value))}
                                        className="w-32 px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-blue-500"
                                    />
                                    <span className="text-xs text-slate-500">
                                        (365 días = 1 año de vigencia al momento de emitirse en la suscripción)
                                    </span>
                                </div>
                            </div>

                            {/* Actions */}
                            <div className="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                                <button
                                    type="button"
                                    onClick={() => setIsModalOpen(false)}
                                    disabled={isSubmitting}
                                    className="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition cursor-pointer"
                                >
                                    Cancelar
                                </button>
                                <button
                                    type="submit"
                                    disabled={isSubmitting}
                                    className="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-xs font-bold transition shadow-xs flex items-center gap-2 cursor-pointer disabled:opacity-50"
                                >
                                    {isSubmitting ? (
                                        <>
                                            <Loader2 className="w-4 h-4 animate-spin" />
                                            <span>Guardando...</span>
                                        </>
                                    ) : (
                                        <>
                                            <CheckCircle2 className="w-4 h-4" />
                                            <span>Guardar Servicio Clínico</span>
                                        </>
                                    )}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}

            {/* Modal: Confirmar Eliminación */}
            {serviceToDelete && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-150">
                    <div className="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4 animate-in zoom-in-95 duration-150">
                        <div className="w-12 h-12 rounded-2xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600 mx-auto">
                            <Trash2 className="w-6 h-6" />
                        </div>

                        <div className="text-center space-y-1">
                            <h3 className="text-base font-extrabold text-slate-900">
                                ¿Eliminar Servicio Clínico?
                            </h3>
                            <p className="text-xs text-slate-500 leading-relaxed">
                                Estás a punto de eliminar el procedimiento <span className="font-bold text-slate-800">"{serviceToDelete.name}"</span>. Esta acción no se puede deshacer.
                            </p>
                        </div>

                        {serviceToDelete.plan_benefits_count !== undefined && serviceToDelete.plan_benefits_count > 0 && (
                            <div className="p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-semibold flex items-center gap-2">
                                <AlertTriangle className="w-4 h-4 shrink-0 text-amber-600" />
                                <span>Este servicio está asignado a {serviceToDelete.plan_benefits_count} plan(es) activo(s). No podrá ser eliminado mientras esté en uso.</span>
                            </div>
                        )}

                        <div className="flex items-center justify-center gap-2.5 pt-2">
                            <button
                                type="button"
                                onClick={() => setServiceToDelete(null)}
                                disabled={isDeleting}
                                className="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition cursor-pointer"
                            >
                                Cancelar
                            </button>
                            <button
                                type="button"
                                onClick={handleDeleteService}
                                disabled={isDeleting || (serviceToDelete.plan_benefits_count !== undefined && serviceToDelete.plan_benefits_count > 0)}
                                className="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition shadow-xs flex items-center gap-1.5 cursor-pointer disabled:opacity-50"
                            >
                                {isDeleting ? (
                                    <>
                                        <Loader2 className="w-4 h-4 animate-spin" />
                                        <span>Eliminando...</span>
                                    </>
                                ) : (
                                    <>
                                        <Trash2 className="w-4 h-4" />
                                        <span>Sí, Eliminar</span>
                                    </>
                                )}
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </VetAdminLayout>
    );
}
