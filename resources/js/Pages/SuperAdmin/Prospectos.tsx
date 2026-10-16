import React, { useState } from 'react';
import { Head, router } from '@inertiajs/react';
import SuperAdminLayout from '@/Layouts/SuperAdminLayout';
import { 
    TrendingUp, 
    Search, 
    Plus, 
    Mail, 
    Phone, 
    MessageCircle, 
    MapPin, 
    Eye, 
    Send, 
    CheckCircle2, 
    Clock, 
    AlertTriangle, 
    Building2, 
    X,
    ChevronLeft,
    ChevronRight,
    Copy,
    Check,
    Filter
} from 'lucide-react';

interface ProspectoItem {
    id: number;
    razon_social: string;
    correo_comercial: string;
    telefono: string | null;
    departamento: string;
    municipio: string;
    direccion: string | null;
    tipo: string;
    estado: string;
    intentos_envio: number;
    ultimo_envio_at: string | null;
    abierto_at: string | null;
    aperturas_count: number;
    fuente: string;
    wa_link: string | null;
}

interface ProspectosProps {
    prospectos: {
        data: ProspectoItem[];
        current_page: number;
        last_page: number;
        total: number;
        prev_page_url: string | null;
        next_page_url: string | null;
    };
    filters: {
        search: string;
        estado: string;
        municipio: string;
    };
    stats: {
        total: number;
        pendientes: number;
        enviados: number;
        abiertos: number;
        conTelefono: number;
    };
    municipiosList: string[];
    userName?: string;
    userEmail?: string;
}

export default function Prospectos({
    prospectos,
    filters,
    stats,
    municipiosList = [],
    userName = 'Robinson Naranjo',
    userEmail = 'superadmin@avipetapp.com'
}: ProspectosProps) {
    const [searchTerm, setSearchTerm] = useState(filters.search || '');
    const [selectedEstado, setSelectedEstado] = useState(filters.estado || 'all');
    const [selectedMunicipio, setSelectedMunicipio] = useState(filters.municipio || 'all');
    const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
    const [statusModalProspecto, setStatusModalProspecto] = useState<ProspectoItem | null>(null);
    const [copiedEmail, setCopiedEmail] = useState<string | null>(null);
    const [sendingEmailId, setSendingEmailId] = useState<number | null>(null);

    const [newProspecto, setNewProspecto] = useState({
        razon_social: '',
        correo_comercial: '',
        telefono: '',
        municipio: 'Bogotá D.C.',
        departamento: 'Cundinamarca',
        tipo: 'Clínica Veterinaria',
        direccion: ''
    });

    const handleSearch = (e: React.FormEvent) => {
        e.preventDefault();
        router.get('/super-admin/prospecto-veterinarias', {
            search: searchTerm,
            estado: selectedEstado,
            municipio: selectedMunicipio
        }, { preserveState: true });
    };

    const handleFilterEstado = (estado: string) => {
        setSelectedEstado(estado);
        router.get('/super-admin/prospecto-veterinarias', {
            search: searchTerm,
            estado,
            municipio: selectedMunicipio
        }, { preserveState: true });
    };

    const handleFilterMunicipio = (municipio: string) => {
        setSelectedMunicipio(municipio);
        router.get('/super-admin/prospecto-veterinarias', {
            search: searchTerm,
            estado: selectedEstado,
            municipio
        }, { preserveState: true });
    };

    const handleCopyEmail = (email: string) => {
        navigator.clipboard.writeText(email);
        setCopiedEmail(email);
        setTimeout(() => setCopiedEmail(null), 2000);
    };

    const handleSendOutreach = (id: number) => {
        setSendingEmailId(id);
        router.post(`/super-admin/prospecto-veterinarias/${id}/send-outreach`, {}, {
            onFinish: () => setSendingEmailId(null)
        });
    };

    const handleUpdateStatus = (id: number, estado: string) => {
        router.post(`/super-admin/prospecto-veterinarias/${id}/update-estado`, { estado }, {
            onSuccess: () => setStatusModalProspecto(null)
        });
    };

    const handleCreateSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        router.post('/super-admin/prospecto-veterinarias', newProspecto, {
            onSuccess: () => {
                setIsCreateModalOpen(false);
                setNewProspecto({
                    razon_social: '',
                    correo_comercial: '',
                    telefono: '',
                    municipio: 'Bogotá D.C.',
                    departamento: 'Cundinamarca',
                    tipo: 'Clínica Veterinaria',
                    direccion: ''
                });
            }
        });
    };

    const getEstadoBadge = (item: ProspectoItem) => {
        if (item.aperturas_count > 0) {
            return (
                <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                    <Eye className="w-3.5 h-3.5 text-indigo-600" />
                    Abierto ({item.aperturas_count})
                </span>
            );
        }

        switch (item.estado) {
            case 'enviado':
                return (
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <CheckCircle2 className="w-3.5 h-3.5 text-emerald-600" />
                        Enviado
                    </span>
                );
            case 'pendiente':
                return (
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                        <Clock className="w-3.5 h-3.5 text-amber-600" />
                        Pendiente
                    </span>
                );
            case 'respondido':
                return (
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-teal-50 text-teal-700 border border-teal-200">
                        <MessageCircle className="w-3.5 h-3.5 text-teal-600" />
                        Respondido
                    </span>
                );
            case 'error':
                return (
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                        <AlertTriangle className="w-3.5 h-3.5 text-rose-600" />
                        Error
                    </span>
                );
            default:
                return (
                    <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                        {item.estado}
                    </span>
                );
        }
    };

    return (
        <SuperAdminLayout
            userName={userName}
            userEmail={userEmail}
            activeItem="Prospección B2B"
        >
            <Head title="Prospección B2B & Campañas - SuperAdmin" />

            <div className="space-y-6 max-w-full">
                {/* HEADER */}
                <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 className="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                            <TrendingUp className="w-7 h-7 text-teal-600" />
                            Prospección B2B & Campañas Comerciales
                        </h1>
                        <p className="text-sm text-slate-500 mt-1">
                            Directorio calificado de veterinarias en Colombia, captación por WhatsApp y seguimiento de aperturas de correo.
                        </p>
                    </div>

                    <button
                        onClick={() => setIsCreateModalOpen(true)}
                        className="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white font-bold text-sm shadow-sm transition-all shadow-teal-600/20 hover:shadow-teal-600/30 self-start sm:self-auto cursor-pointer"
                    >
                        <Plus className="w-4 h-4" />
                        Nuevo Prospecto
                    </button>
                </div>

                {/* 5 KPI CARDS */}
                <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5">
                    <div className="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs">
                        <span className="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total en Base</span>
                        <div className="text-2xl font-black text-slate-900 mt-1">{stats.total}</div>
                        <div className="text-[11px] text-slate-500 mt-0.5">Clínicas registradas</div>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs">
                        <span className="text-[11px] font-bold uppercase tracking-wider text-slate-400">Pendientes</span>
                        <div className="text-2xl font-black text-amber-600 mt-1">{stats.pendientes}</div>
                        <div className="text-[11px] text-amber-600 mt-0.5">Por contactar</div>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs">
                        <span className="text-[11px] font-bold uppercase tracking-wider text-slate-400">Correos Enviados</span>
                        <div className="text-2xl font-black text-emerald-600 mt-1">{stats.enviados}</div>
                        <div className="text-[11px] text-emerald-600 mt-0.5">Outreach ejecutado</div>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs">
                        <span className="text-[11px] font-bold uppercase tracking-wider text-slate-400">Emails Abiertos</span>
                        <div className="text-2xl font-black text-indigo-600 mt-1">{stats.abiertos}</div>
                        <div className="text-[11px] text-indigo-600 mt-0.5">Lecturas confirmadas</div>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs col-span-2 sm:col-span-1">
                        <span className="text-[11px] font-bold uppercase tracking-wider text-slate-400">Con WhatsApp</span>
                        <div className="text-2xl font-black text-teal-600 mt-1">{stats.conTelefono}</div>
                        <div className="text-[11px] text-teal-600 mt-0.5">Listos para chat</div>
                    </div>
                </div>

                {/* FILTERS & SEARCH */}
                <div className="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs flex flex-col md:flex-row gap-4 justify-between items-stretch md:items-center">
                    {/* Status Tabs */}
                    <div className="flex items-center gap-1 overflow-x-auto pb-1 md:pb-0 scrollbar-none">
                        <button
                            type="button"
                            onClick={() => handleFilterEstado('all')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                                selectedEstado === 'all'
                                    ? 'bg-teal-600 text-white shadow-xs'
                                    : 'text-slate-600 hover:bg-slate-100'
                            }`}
                        >
                            Todos ({prospectos.total})
                        </button>
                        <button
                            type="button"
                            onClick={() => handleFilterEstado('pendiente')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                                selectedEstado === 'pendiente'
                                    ? 'bg-amber-600 text-white shadow-xs'
                                    : 'text-slate-600 hover:bg-slate-100'
                            }`}
                        >
                            Pendientes
                        </button>
                        <button
                            type="button"
                            onClick={() => handleFilterEstado('enviado')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                                selectedEstado === 'enviado'
                                    ? 'bg-emerald-600 text-white shadow-xs'
                                    : 'text-slate-600 hover:bg-slate-100'
                            }`}
                        >
                            Enviados
                        </button>
                        <button
                            type="button"
                            onClick={() => handleFilterEstado('abierto')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                                selectedEstado === 'abierto'
                                    ? 'bg-indigo-600 text-white shadow-xs'
                                    : 'text-slate-600 hover:bg-slate-100'
                            }`}
                        >
                            Con Apertura
                        </button>
                        <button
                            type="button"
                            onClick={() => handleFilterEstado('respondido')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                                selectedEstado === 'respondido'
                                    ? 'bg-teal-600 text-white shadow-xs'
                                    : 'text-slate-600 hover:bg-slate-100'
                            }`}
                        >
                            Respondidos
                        </button>
                    </div>

                    {/* Municipality and Search */}
                    <div className="flex items-center gap-2">
                        {municipiosList.length > 0 && (
                            <select
                                value={selectedMunicipio}
                                onChange={(e) => handleFilterMunicipio(e.target.value)}
                                className="text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-500 max-w-[150px] truncate"
                            >
                                <option value="all">Todas las ciudades</option>
                                {municipiosList.map((m) => (
                                    <option key={m} value={m}>{m}</option>
                                ))}
                            </select>
                        )}

                        <form onSubmit={handleSearch} className="relative flex-1 sm:w-64">
                            <Search className="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
                            <input
                                type="text"
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                                placeholder="Buscar veterinaria..."
                                className="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500"
                            />
                        </form>
                    </div>
                </div>

                {/* TABLE */}
                <div className="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left text-xs text-slate-600">
                            <thead className="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[11px]">
                                <tr>
                                    <th className="py-3.5 px-4">Clínica / Veterinaria</th>
                                    <th className="py-3.5 px-4">Ubicación</th>
                                    <th className="py-3.5 px-4">Contacto Directo</th>
                                    <th className="py-3.5 px-4">Estado de Campaña</th>
                                    <th className="py-3.5 px-4">Historial / Apertura</th>
                                    <th className="py-3.5 px-4 text-right">Acción Rápida</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100">
                                {prospectos.data.length === 0 ? (
                                    <tr>
                                        <td colSpan={6} className="text-center py-12 text-slate-400">
                                            <Building2 className="w-10 h-10 mx-auto text-slate-300 mb-2" />
                                            No se encontraron clínicas veterinarias con los filtros seleccionados.
                                        </td>
                                    </tr>
                                ) : (
                                    prospectos.data.map((p) => (
                                        <tr key={p.id} className="hover:bg-slate-50/70 transition-colors">
                                            <td className="py-3.5 px-4">
                                                <div className="font-bold text-slate-900 text-sm">{p.razon_social}</div>
                                                <div className="text-[11px] text-teal-600 font-medium">{p.tipo}</div>
                                                {p.direccion && (
                                                    <div className="text-[11px] text-slate-400 truncate max-w-xs">{p.direccion}</div>
                                                )}
                                            </td>

                                            <td className="py-3.5 px-4">
                                                <div className="font-medium text-slate-800 flex items-center gap-1">
                                                    <MapPin className="w-3.5 h-3.5 text-slate-400 shrink-0" />
                                                    {p.municipio}
                                                </div>
                                                <div className="text-[11px] text-slate-400">{p.departamento}</div>
                                            </td>

                                            <td className="py-3.5 px-4">
                                                <div className="flex items-center gap-1.5 text-slate-800">
                                                    <Mail className="w-3.5 h-3.5 text-slate-400 shrink-0" />
                                                    <span className="font-medium">{p.correo_comercial}</span>
                                                    <button
                                                        type="button"
                                                        onClick={() => handleCopyEmail(p.correo_comercial)}
                                                        title="Copiar correo"
                                                        className="text-slate-400 hover:text-teal-600 cursor-pointer ml-0.5"
                                                    >
                                                        {copiedEmail === p.correo_comercial ? (
                                                            <Check className="w-3.5 h-3.5 text-emerald-600" />
                                                        ) : (
                                                            <Copy className="w-3.5 h-3.5" />
                                                        )}
                                                    </button>
                                                </div>
                                                {p.telefono && (
                                                    <div className="text-[11px] text-slate-500 flex items-center gap-1 mt-0.5">
                                                        <Phone className="w-3 h-3 text-slate-400" />
                                                        <span>{p.telefono}</span>
                                                    </div>
                                                )}
                                            </td>

                                            <td className="py-3.5 px-4">
                                                <button
                                                    onClick={() => setStatusModalProspecto(p)}
                                                    className="cursor-pointer hover:opacity-80 transition-opacity"
                                                    title="Clic para cambiar estado"
                                                >
                                                    {getEstadoBadge(p)}
                                                </button>
                                            </td>

                                            <td className="py-3.5 px-4">
                                                {p.ultimo_envio_at ? (
                                                    <div className="text-[11px] text-slate-600">
                                                        <div>Enviado: {p.ultimo_envio_at}</div>
                                                        {p.abierto_at && (
                                                            <div className="text-indigo-600 font-semibold">Leído: {p.abierto_at}</div>
                                                        )}
                                                    </div>
                                                ) : (
                                                    <span className="text-[11px] text-slate-400">Sin envíos</span>
                                                )}
                                            </td>

                                            <td className="py-3.5 px-4 text-right">
                                                <div className="flex items-center justify-end gap-1.5">
                                                    {p.wa_link && (
                                                        <a
                                                            href={p.wa_link}
                                                            target="_blank"
                                                            rel="noopener noreferrer"
                                                            title="Iniciar conversación en WhatsApp"
                                                            className="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition-colors"
                                                        >
                                                            <MessageCircle className="w-3.5 h-3.5" />
                                                            WhatsApp
                                                        </a>
                                                    )}

                                                    <button
                                                        onClick={() => handleSendOutreach(p.id)}
                                                        disabled={sendingEmailId === p.id}
                                                        title="Enviar correo de outreach"
                                                        className="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold text-teal-700 bg-teal-50 hover:bg-teal-100 transition-colors disabled:opacity-50 cursor-pointer"
                                                    >
                                                        <Send className="w-3.5 h-3.5" />
                                                        {sendingEmailId === p.id ? 'Enviando...' : 'Email'}
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    ))
                                )}
                            </tbody>
                        </table>
                    </div>

                    {/* PAGINATION */}
                    {prospectos.last_page > 1 && (
                        <div className="p-4 border-t border-slate-200 flex items-center justify-between">
                            <span className="text-xs text-slate-500">
                                Página {prospectos.current_page} de {prospectos.last_page} ({prospectos.total} clínicas)
                            </span>
                            <div className="flex items-center gap-2">
                                {prospectos.prev_page_url && (
                                    <button
                                        onClick={() => router.get(prospectos.prev_page_url!)}
                                        className="p-1.5 rounded-lg border border-slate-200 hover:bg-slate-100 text-slate-600 cursor-pointer"
                                    >
                                        <ChevronLeft className="w-4 h-4" />
                                    </button>
                                )}
                                {prospectos.next_page_url && (
                                    <button
                                        onClick={() => router.get(prospectos.next_page_url!)}
                                        className="p-1.5 rounded-lg border border-slate-200 hover:bg-slate-100 text-slate-600 cursor-pointer"
                                    >
                                        <ChevronRight className="w-4 h-4" />
                                    </button>
                                )}
                            </div>
                        </div>
                    )}
                </div>

                {/* MODAL: NUEVO PROSPECTO */}
                {isCreateModalOpen && (
                    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
                        <div className="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4 animate-in fade-in zoom-in-95 duration-150">
                            <div className="flex items-center justify-between border-b border-slate-100 pb-3">
                                <h3 className="text-base font-bold text-slate-900 flex items-center gap-2">
                                    <Plus className="w-5 h-5 text-teal-600" />
                                    Nuevo Prospecto Veterinario
                                </h3>
                                <button
                                    onClick={() => setIsCreateModalOpen(false)}
                                    className="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 cursor-pointer"
                                >
                                    <X className="w-5 h-5" />
                                </button>
                            </div>

                            <form onSubmit={handleCreateSubmit} className="space-y-3">
                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">Razón Social / Nombre Clínica</label>
                                    <input
                                        type="text"
                                        value={newProspecto.razon_social}
                                        onChange={(e) => setNewProspecto({ ...newProspecto, razon_social: e.target.value })}
                                        placeholder="Ej. Clínica Veterinaria El Portal"
                                        className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                        required
                                    />
                                </div>

                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">Correo Electrónico Comercial</label>
                                    <input
                                        type="email"
                                        value={newProspecto.correo_comercial}
                                        onChange={(e) => setNewProspecto({ ...newProspecto, correo_comercial: e.target.value })}
                                        placeholder="contacto@veterinaria.com"
                                        className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                        required
                                    />
                                </div>

                                <div className="grid grid-cols-2 gap-3">
                                    <div>
                                        <label className="block text-xs font-bold text-slate-700 mb-1">Teléfono / WhatsApp</label>
                                        <input
                                            type="text"
                                            value={newProspecto.telefono}
                                            onChange={(e) => setNewProspecto({ ...newProspecto, telefono: e.target.value })}
                                            placeholder="3201234567"
                                            className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                        />
                                    </div>

                                    <div>
                                        <label className="block text-xs font-bold text-slate-700 mb-1">Tipo</label>
                                        <select
                                            value={newProspecto.tipo}
                                            onChange={(e) => setNewProspecto({ ...newProspecto, tipo: e.target.value })}
                                            className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                        >
                                            <option value="Clínica Veterinaria">Clínica Veterinaria</option>
                                            <option value="Hospital Veterinario">Hospital Veterinario</option>
                                            <option value="Consultorio Veterinario">Consultorio Veterinario</option>
                                            <option value="Pet Shop & Consultorio">Pet Shop & Consultorio</option>
                                        </select>
                                    </div>
                                </div>

                                <div className="grid grid-cols-2 gap-3">
                                    <div>
                                        <label className="block text-xs font-bold text-slate-700 mb-1">Municipio / Ciudad</label>
                                        <input
                                            type="text"
                                            value={newProspecto.municipio}
                                            onChange={(e) => setNewProspecto({ ...newProspecto, municipio: e.target.value })}
                                            className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                            required
                                        />
                                    </div>

                                    <div>
                                        <label className="block text-xs font-bold text-slate-700 mb-1">Departamento</label>
                                        <input
                                            type="text"
                                            value={newProspecto.departamento}
                                            onChange={(e) => setNewProspecto({ ...newProspecto, departamento: e.target.value })}
                                            className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                            required
                                        />
                                    </div>
                                </div>

                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">Dirección Comercial</label>
                                    <input
                                        type="text"
                                        value={newProspecto.direccion}
                                        onChange={(e) => setNewProspecto({ ...newProspecto, direccion: e.target.value })}
                                        placeholder="Calle 100 # 15-20"
                                        className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                    />
                                </div>

                                <div className="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                                    <button
                                        type="button"
                                        onClick={() => setIsCreateModalOpen(false)}
                                        className="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 cursor-pointer"
                                    >
                                        Cancelar
                                    </button>
                                    <button
                                        type="submit"
                                        className="px-4 py-2 rounded-xl text-xs font-bold bg-teal-600 hover:bg-teal-700 text-white shadow-xs cursor-pointer"
                                    >
                                        Guardar Prospecto
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                )}

                {/* MODAL: CAMBIAR ESTADO */}
                {statusModalProspecto && (
                    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
                        <div className="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl space-y-4 animate-in fade-in zoom-in-95 duration-150">
                            <div className="flex items-center justify-between border-b border-slate-100 pb-3">
                                <div>
                                    <h3 className="text-sm font-bold text-slate-900">Actualizar Estado</h3>
                                    <p className="text-xs text-slate-500 truncate max-w-[200px]">{statusModalProspecto.razon_social}</p>
                                </div>
                                <button
                                    onClick={() => setStatusModalProspecto(null)}
                                    className="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 cursor-pointer"
                                >
                                    <X className="w-5 h-5" />
                                </button>
                            </div>

                            <div className="space-y-2">
                                {['pendiente', 'enviado', 'respondido', 'desuscrito', 'error'].map((st) => (
                                    <button
                                        key={st}
                                        type="button"
                                        onClick={() => handleUpdateStatus(statusModalProspecto.id, st)}
                                        className={`w-full text-left px-3 py-2 rounded-xl text-xs font-bold transition-colors capitalize flex items-center justify-between cursor-pointer ${
                                            statusModalProspecto.estado === st
                                                ? 'bg-teal-50 text-teal-700 border border-teal-200'
                                                : 'hover:bg-slate-50 text-slate-700'
                                        }`}
                                    >
                                        <span>{st}</span>
                                        {statusModalProspecto.estado === st && <Check className="w-4 h-4 text-teal-600" />}
                                    </button>
                                ))}
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </SuperAdminLayout>
    );
}
