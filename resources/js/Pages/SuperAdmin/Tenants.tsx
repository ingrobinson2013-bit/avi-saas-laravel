import React, { useState } from 'react';
import { Head, router } from '@inertiajs/react';
import SuperAdminLayout from '@/Layouts/SuperAdminLayout';
import { 
    Building2, 
    Search, 
    Plus, 
    ExternalLink, 
    MessageCircle, 
    ShieldCheck, 
    Clock, 
    AlertTriangle, 
    CheckCircle2, 
    MapPin, 
    Phone, 
    Mail, 
    CreditCard, 
    Users, 
    PawPrint,
    LogIn,
    X,
    Filter
} from 'lucide-react';

interface TenantItem {
    id: string;
    name: string;
    slug: string;
    domain: string | null;
    city: string;
    phone: string | null;
    email: string | null;
    logo_url: string | null;
    doctor_name: string;
    saas_status: string;
    saas_plan: string;
    saas_monthly_fee: number;
    trial_ends_at: string | null;
    saas_next_payment_due: string | null;
    pets_count: number;
    subscriptions_count: number;
    plans_count: number;
    created_at: string | null;
}

interface TenantsProps {
    tenants?: TenantItem[];
    filters?: {
        search: string;
        status: string;
    };
    stats?: {
        total: number;
        paid: number;
        trial: number;
        suspended: number;
    };
    userName?: string;
    userEmail?: string;
}

export default function Tenants({
    tenants = [],
    filters = { search: '', status: 'all' },
    stats = { total: 0, paid: 0, trial: 0, suspended: 0 },
    userName = 'Robinson Naranjo',
    userEmail = 'superadmin@avipetapp.com'
}: TenantsProps) {
    const [searchTerm, setSearchTerm] = useState(filters.search);
    const [selectedStatus, setSelectedStatus] = useState(filters.status);
    const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
    const [newClinic, setNewClinic] = useState({
        name: '',
        city: '',
        phone: '',
        email: '',
        saas_plan: 'starter',
        saas_status: 'paid'
    });

    const handleSearch = (e: React.FormEvent) => {
        e.preventDefault();
        router.get('/super-admin/tenants', { search: searchTerm, status: selectedStatus }, { preserveState: true });
    };

    const handleFilterStatus = (status: string) => {
        setSelectedStatus(status);
        router.get('/super-admin/tenants', { search: searchTerm, status }, { preserveState: true });
    };

    const handleCreateClinic = (e: React.FormEvent) => {
        e.preventDefault();
        router.post('/super-admin/tenants', newClinic, {
            onSuccess: () => {
                setIsCreateModalOpen(false);
                setNewClinic({ name: '', city: '', phone: '', email: '', saas_plan: 'starter', saas_status: 'paid' });
            }
        });
    };

    return (
        <SuperAdminLayout userName={userName} userEmail={userEmail} activeItem="Clínicas veterinarias">
            <Head title="Clínicas Veterinarias · AVI Pet Superadmin" />

            <div className="space-y-6 w-full">

                {/* Header */}
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 className="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                            Clínicas veterinarias
                        </h1>
                        <p className="text-sm text-slate-500 mt-0.5">
                            Red de consultorios y hospitales veterinarios en la plataforma AVI Pet
                        </p>
                    </div>

                    <button
                        onClick={() => setIsCreateModalOpen(true)}
                        className="inline-flex items-center gap-2 px-4 py-2.5 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-xs transition shrink-0"
                    >
                        <Plus className="w-4 h-4" />
                        <span>Nueva clínica</span>
                    </button>
                </div>

                {/* Quick Stats Pill Row */}
                <div className="grid grid-cols-2 sm:grid-cols-4 gap-3 w-full">
                    <button 
                        onClick={() => handleFilterStatus('all')}
                        className={`p-3.5 rounded-xl border text-left transition ${selectedStatus === 'all' ? 'bg-teal-50/80 border-teal-300 ring-2 ring-teal-500/20' : 'bg-white border-slate-200/90 hover:bg-slate-50'}`}
                    >
                        <div className="text-xs font-semibold text-slate-500">Total clínicas</div>
                        <div className="text-2xl font-black text-slate-900 mt-0.5">{stats.total}</div>
                    </button>

                    <button 
                        onClick={() => handleFilterStatus('paid')}
                        className={`p-3.5 rounded-xl border text-left transition ${selectedStatus === 'paid' ? 'bg-emerald-50/80 border-emerald-300 ring-2 ring-emerald-500/20' : 'bg-white border-slate-200/90 hover:bg-slate-50'}`}
                    >
                        <div className="text-xs font-semibold text-emerald-600 flex items-center gap-1">
                            <span className="w-2 h-2 rounded-full bg-emerald-500 inline-block" />
                            <span>Suscripción activa</span>
                        </div>
                        <div className="text-2xl font-black text-slate-900 mt-0.5">{stats.paid}</div>
                    </button>

                    <button 
                        onClick={() => handleFilterStatus('trial')}
                        className={`p-3.5 rounded-xl border text-left transition ${selectedStatus === 'trial' ? 'bg-amber-50/80 border-amber-300 ring-2 ring-amber-500/20' : 'bg-white border-slate-200/90 hover:bg-slate-50'}`}
                    >
                        <div className="text-xs font-semibold text-amber-600 flex items-center gap-1">
                            <Clock className="w-3.5 h-3.5" />
                            <span>Período de prueba</span>
                        </div>
                        <div className="text-2xl font-black text-slate-900 mt-0.5">{stats.trial}</div>
                    </button>

                    <button 
                        onClick={() => handleFilterStatus('suspended')}
                        className={`p-3.5 rounded-xl border text-left transition ${selectedStatus === 'suspended' ? 'bg-rose-50/80 border-rose-300 ring-2 ring-rose-500/20' : 'bg-white border-slate-200/90 hover:bg-slate-50'}`}
                    >
                        <div className="text-xs font-semibold text-rose-600 flex items-center gap-1">
                            <AlertTriangle className="w-3.5 h-3.5" />
                            <span>Suspendidas</span>
                        </div>
                        <div className="text-2xl font-black text-slate-900 mt-0.5">{stats.suspended}</div>
                    </button>
                </div>

                {/* Filter and Search Bar */}
                <div className="bg-white p-3.5 rounded-2xl border border-slate-200/90 flex flex-col sm:flex-row items-center justify-between gap-3 shadow-2xs w-full">
                    <form onSubmit={handleSearch} className="relative w-full sm:w-96">
                        <Search className="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                        <input
                            type="text"
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                            placeholder="Buscar por nombre, ciudad, slug, teléfono..."
                            className="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50/70 text-slate-800 placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-teal-500 focus:bg-white transition"
                        />
                    </form>

                    <div className="flex items-center gap-2 w-full sm:w-auto justify-end text-xs text-slate-500">
                        <span>Mostrando <b>{tenants.length}</b> clínicas</span>
                    </div>
                </div>

                {/* Clinics Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                    {tenants.map((t) => {
                        const isPaid = t.saas_status === 'paid';
                        const isTrial = t.saas_status === 'trial';
                        const isSuspended = t.saas_status === 'suspended';
                        const storefrontUrl = t.domain ? `https://${t.domain}` : `https://avipetapp.com/v/${t.slug}`;
                        const adminUrl = `/admin/${t.slug}`;
                        const impersonateUrl = `/impersonate-clinic/${t.id}`;
                        const cleanPhone = t.phone ? t.phone.replace(/[^0-9]/g, '') : '';
                        const waUrl = cleanPhone ? `https://wa.me/57${cleanPhone}?text=Hola%20${encodeURIComponent(t.name)},%20te%20saludamos%20desde%20la%20mesa%20de%20soporte%20de%20AVI%20Pet.` : null;

                        return (
                            <div key={t.id} className="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs hover:shadow-md transition flex flex-col justify-between gap-4">
                                <div>
                                    {/* Top row: Logo, Name, Status Badge */}
                                    <div className="flex items-start justify-between gap-3">
                                        <div className="flex items-start gap-3">
                                            <div className="w-12 h-12 rounded-xl bg-slate-50 border border-slate-200/70 overflow-hidden flex items-center justify-center shrink-0">
                                                {t.logo_url ? (
                                                    <img src={t.logo_url} alt={t.name} className="w-full h-full object-contain p-1" />
                                                ) : (
                                                    <Building2 className="w-6 h-6 text-teal-600" />
                                                )}
                                            </div>
                                            <div>
                                                <h3 className="font-extrabold text-slate-900 text-sm leading-snug">
                                                    {t.name}
                                                </h3>
                                                <div className="flex items-center gap-1.5 text-xs text-slate-500 mt-0.5">
                                                    <MapPin className="w-3.5 h-3.5 text-slate-400" />
                                                    <span>{t.city}</span>
                                                    <span>·</span>
                                                    <code className="text-[11px] text-teal-700 bg-teal-50 px-1.5 py-0.5 rounded font-mono">
                                                        /{t.slug}
                                                    </code>
                                                </div>
                                            </div>
                                        </div>

                                        {/* Status Badge */}
                                        <div>
                                            {isPaid && (
                                                <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-bold border border-emerald-200">
                                                    <span className="w-1.5 h-1.5 rounded-full bg-emerald-500" />
                                                    <span>Activo SaaS</span>
                                                </span>
                                            )}
                                            {isTrial && (
                                                <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 text-[11px] font-bold border border-amber-200">
                                                    <Clock className="w-3 h-3 text-amber-500" />
                                                    <span>Prueba</span>
                                                </span>
                                            )}
                                            {isSuspended && (
                                                <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-rose-50 text-rose-700 text-[11px] font-bold border border-rose-200">
                                                    <AlertTriangle className="w-3 h-3 text-rose-500" />
                                                    <span>Suspendida</span>
                                                </span>
                                            )}
                                        </div>
                                    </div>

                                    {/* Metrics summary */}
                                    <div className="grid grid-cols-3 gap-2 mt-4 pt-3 border-t border-slate-100 text-center">
                                        <div className="p-2 bg-slate-50/70 rounded-xl">
                                            <div className="text-[11px] text-slate-400 font-medium">Mascotas</div>
                                            <div className="text-base font-black text-slate-800">{t.pets_count}</div>
                                        </div>
                                        <div className="p-2 bg-slate-50/70 rounded-xl">
                                            <div className="text-[11px] text-slate-400 font-medium">Membresías</div>
                                            <div className="text-base font-black text-slate-800">{t.subscriptions_count}</div>
                                        </div>
                                        <div className="p-2 bg-slate-50/70 rounded-xl">
                                            <div className="text-[11px] text-slate-400 font-medium">Canon SaaS</div>
                                            <div className="text-xs font-black text-slate-800">${(t.saas_monthly_fee / 1000).toFixed(0)}k COP</div>
                                        </div>
                                    </div>
                                </div>

                                {/* Action Buttons matching mockup */}
                                <div className="flex flex-wrap items-center justify-between gap-2 pt-2 border-t border-slate-100">
                                    <div className="flex items-center gap-1.5">
                                        {waUrl && (
                                            <a
                                                href={waUrl}
                                                target="_blank"
                                                rel="noreferrer"
                                                className="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition"
                                                title="Contactar por WhatsApp"
                                            >
                                                <MessageCircle className="w-4 h-4" />
                                            </a>
                                        )}
                                        <a
                                            href={storefrontUrl}
                                            target="_blank"
                                            rel="noreferrer"
                                            className="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition"
                                            title="Ver portal público de afiliados"
                                        >
                                            <ExternalLink className="w-4 h-4" />
                                        </a>
                                    </div>

                                    <div className="flex items-center gap-2">
                                        <a
                                            href={impersonateUrl}
                                            className="inline-flex items-center gap-1.5 px-3 py-1.5 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-lg shadow-2xs transition"
                                        >
                                            <LogIn className="w-3.5 h-3.5" />
                                            <span>Acceso Panel</span>
                                        </a>

                                        <a
                                            href={`/super-admin/tenants/${t.id}/edit`}
                                            className="inline-flex items-center gap-1 px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition"
                                        >
                                            <span>Gestionar</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        );
                    })}
                </div>

                {tenants.length === 0 && (
                    <div className="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                        <Building2 className="w-12 h-12 text-slate-300 mx-auto mb-3" />
                        <h3 className="text-base font-bold text-slate-800">No se encontraron clínicas</h3>
                        <p className="text-xs text-slate-500 mt-1">Prueba con otros términos de búsqueda o elimina los filtros.</p>
                    </div>
                )}

            </div>

            {/* Create Clinic Modal */}
            {isCreateModalOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
                    <div className="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl border border-slate-100 space-y-4">
                        <div className="flex items-center justify-between pb-3 border-b border-slate-100">
                            <h3 className="font-extrabold text-slate-900 text-base">Registrar Nueva Clínica Veterinaria</h3>
                            <button onClick={() => setIsCreateModalOpen(false)} className="text-slate-400 hover:text-slate-700">
                                <X className="w-5 h-5" />
                            </button>
                        </div>

                        <form onSubmit={handleCreateClinic} className="space-y-3.5 text-xs">
                            <div>
                                <label className="block font-semibold text-slate-700 mb-1">Nombre Comercial de la Clínica *</label>
                                <input
                                    type="text"
                                    required
                                    value={newClinic.name}
                                    onChange={(e) => setNewClinic({ ...newClinic, name: e.target.value })}
                                    placeholder="Ej: Clínica Veterinaria San Roque"
                                    className="w-full p-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-hidden"
                                />
                            </div>

                            <div className="grid grid-cols-2 gap-3">
                                <div>
                                    <label className="block font-semibold text-slate-700 mb-1">Ciudad / Municipio</label>
                                    <input
                                        type="text"
                                        value={newClinic.city}
                                        onChange={(e) => setNewClinic({ ...newClinic, city: e.target.value })}
                                        placeholder="Ej: Bogotá, Cajicá, Cali"
                                        className="w-full p-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-hidden"
                                    />
                                </div>
                                <div>
                                    <label className="block font-semibold text-slate-700 mb-1">Teléfono / WhatsApp</label>
                                    <input
                                        type="text"
                                        value={newClinic.phone}
                                        onChange={(e) => setNewClinic({ ...newClinic, phone: e.target.value })}
                                        placeholder="300 000 0000"
                                        className="w-full p-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-hidden"
                                    />
                                </div>
                            </div>

                            <div>
                                <label className="block font-semibold text-slate-700 mb-1">Correo Electrónico de Contacto</label>
                                <input
                                    type="email"
                                    value={newClinic.email}
                                    onChange={(e) => setNewClinic({ ...newClinic, email: e.target.value })}
                                    placeholder="contacto@veterinaria.com"
                                    className="w-full p-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-hidden"
                                />
                            </div>

                            <div className="flex justify-end gap-2 pt-3 border-t border-slate-100">
                                <button
                                    type="button"
                                    onClick={() => setIsCreateModalOpen(false)}
                                    className="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-xl font-semibold transition"
                                >
                                    Cancelar
                                </button>
                                <button
                                    type="submit"
                                    className="px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl shadow-xs transition"
                                >
                                    Crear Clínica
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </SuperAdminLayout>
    );
}
