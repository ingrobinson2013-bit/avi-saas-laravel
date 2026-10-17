import React, { useState, useEffect } from 'react';
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
    Users,
    PawPrint,
    LogIn,
    X,
    Copy,
    Check,
    Trash2,
    Settings2,
    KeyRound,
    Globe,
    Stethoscope
} from 'lucide-react';

interface TenantItem {
    id: string;
    name: string;
    slug: string;
    domain: string | null;
    base_url?: string;
    is_active?: boolean;
    city: string;
    address?: string;
    phone: string | null;
    email: string | null;
    logo_url: string | null;
    primary_color?: string;
    doctor_name: string;
    saas_status: string;
    saas_plan: string;
    saas_monthly_fee: number;
    trial_ends_at: string | null;
    trial_ends_at_formatted?: string | null;
    saas_next_payment_due: string | null;
    pets_count: number;
    customers_count?: number;
    subscriptions_count: number;
    plans_count: number;
    admin_user_id?: string | null;
    admin_user_name?: string | null;
    admin_user_email?: string | null;
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
    userEmail = 'contacto@avipetapp.com'
}: TenantsProps) {
    const [searchTerm, setSearchTerm] = useState(filters.search);
    const [selectedStatus, setSelectedStatus] = useState(filters.status);
    const [copiedSlug, setCopiedSlug] = useState<string | null>(null);

    // Modal Crear Clínica
    const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
    const [submittingCreate, setSubmittingCreate] = useState(false);
    const [newClinic, setNewClinic] = useState({
        name: '',
        slug: '',
        city: '',
        address: '',
        phone: '',
        doctor_name: '',
        email: '',
        password: '',
        saas_plan: 'pro',
        saas_status: 'paid',
        saas_monthly_fee: 99000
    });

    // Modal Gestionar / Editar Clínica
    const [editingTenant, setEditingTenant] = useState<TenantItem | null>(null);
    const [submittingUpdate, setSubmittingUpdate] = useState(false);
    const [confirmDeleteId, setConfirmDeleteId] = useState<string | null>(null);
    const [submittingDelete, setSubmittingDelete] = useState(false);
    const [editForm, setEditForm] = useState({
        name: '',
        slug: '',
        domain: '',
        city: '',
        address: '',
        phone: '',
        email: '',
        doctor_name: '',
        logo_url: '',
        primary_color: '#0D9488',
        saas_plan: 'pro',
        saas_status: 'paid',
        saas_monthly_fee: 99000,
        trial_ends_at: '',
        saas_next_payment_due: '',
        new_password: ''
    });

    // Abrir modal automáticamente si viene ?manage={id} en la URL
    useEffect(() => {
        if (typeof window === 'undefined') return;
        const params = new URLSearchParams(window.location.search);
        const manageId = params.get('manage');
        if (manageId && tenants.length > 0) {
            const found = tenants.find((item) => item.id === manageId);
            if (found) {
                openManageModal(found);
            }
        }
    }, [tenants]);

    const openManageModal = (t: TenantItem) => {
        setEditingTenant(t);
        setConfirmDeleteId(null);
        setEditForm({
            name: t.name || '',
            slug: t.slug || '',
            domain: t.domain || '',
            city: t.city || 'Colombia',
            address: t.address || '',
            phone: t.phone || '',
            email: t.email || t.admin_user_email || '',
            doctor_name: t.doctor_name || t.admin_user_name || '',
            logo_url: t.logo_url || '',
            primary_color: t.primary_color || '#0D9488',
            saas_plan: t.saas_plan || 'pro',
            saas_status: t.saas_status || 'paid',
            saas_monthly_fee: t.saas_monthly_fee ?? 99000,
            trial_ends_at: t.trial_ends_at || '',
            saas_next_payment_due: t.saas_next_payment_due || '',
            new_password: ''
        });
    };

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
        setSubmittingCreate(true);
        router.post('/super-admin/tenants', newClinic, {
            onSuccess: () => {
                setIsCreateModalOpen(false);
                setNewClinic({
                    name: '',
                    slug: '',
                    city: '',
                    address: '',
                    phone: '',
                    doctor_name: '',
                    email: '',
                    password: '',
                    saas_plan: 'pro',
                    saas_status: 'paid',
                    saas_monthly_fee: 99000
                });
            },
            onFinish: () => setSubmittingCreate(false)
        });
    };

    const handleUpdateClinic = (e: React.FormEvent) => {
        e.preventDefault();
        if (!editingTenant) return;
        setSubmittingUpdate(true);
        router.post(`/super-admin/tenants/${editingTenant.id}/update`, editForm, {
            onSuccess: () => {
                setEditingTenant(null);
            },
            onFinish: () => setSubmittingUpdate(false)
        });
    };

    const handleDeleteClinic = (id: string) => {
        setSubmittingDelete(true);
        router.post(`/super-admin/tenants/${id}/delete`, {}, {
            onSuccess: () => {
                setConfirmDeleteId(null);
                setEditingTenant(null);
            },
            onFinish: () => setSubmittingDelete(false)
        });
    };

    const handleCopyUrl = (slug: string, url: string) => {
        navigator.clipboard.writeText(url);
        setCopiedSlug(slug);
        setTimeout(() => setCopiedSlug(null), 2000);
    };

    // Filtrado instantáneo en cliente combinado con filtro de estado
    const visibleTenants = tenants.filter((t) => {
        if (selectedStatus !== 'all' && t.saas_status !== selectedStatus) {
            return false;
        }
        if (searchTerm.trim() !== '') {
            const q = searchTerm.toLowerCase().trim();
            const haystack = [
                t.name,
                t.slug,
                t.domain,
                t.city,
                t.phone,
                t.email,
                t.doctor_name
            ]
                .filter(Boolean)
                .join(' ')
                .toLowerCase();
            return haystack.includes(q);
        }
        return true;
    });

    return (
        <SuperAdminLayout userName={userName} userEmail={userEmail} activeItem="Clínicas veterinarias">
            <Head title="Clínicas veterinarias · AviPetApp Superadmin" />

            <div className="space-y-6 w-full text-[#15213B]">
                {/* Header */}
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 className="text-[28px] sm:text-[32px] font-bold text-[#15213B] tracking-tight leading-tight">
                            Clínicas veterinarias
                        </h1>
                        <p className="text-sm text-[#5C6B85] mt-1">
                            Red de consultorios y hospitales veterinarios conectados en AviPetApp
                        </p>
                    </div>

                    <button
                        onClick={() => setIsCreateModalOpen(true)}
                        className="inline-flex items-center gap-2 px-4 py-2.5 bg-[#6D28D9] hover:bg-[#5B21B6] text-white text-sm font-semibold rounded-xl shadow-xs transition shrink-0"
                    >
                        <Plus className="w-4 h-4" />
                        <span>Crear clínica</span>
                    </button>
                </div>

                {/* Quick Stats Pill Row (Manual Maestro v1.1 states) */}
                <div className="grid grid-cols-2 sm:grid-cols-4 gap-3 w-full">
                    <button
                        onClick={() => handleFilterStatus('all')}
                        className={`p-4 rounded-xl border text-left transition ${
                            selectedStatus === 'all'
                                ? 'bg-white border-[#6D28D9] ring-2 ring-[#6D28D9]/15'
                                : 'bg-white border-slate-200/90 hover:bg-slate-50'
                        }`}
                    >
                        <div className="text-xs font-semibold text-[#5C6B85]">Total clínicas</div>
                        <div className="text-2xl font-bold text-[#15213B] mt-1 tabular-nums">{stats.total}</div>
                    </button>

                    <button
                        onClick={() => handleFilterStatus('paid')}
                        className={`p-4 rounded-xl border text-left transition ${
                            selectedStatus === 'paid'
                                ? 'bg-[#0F9F9A]/5 border-[#0F9F9A] ring-2 ring-[#0F9F9A]/20'
                                : 'bg-white border-slate-200/90 hover:bg-slate-50'
                        }`}
                    >
                        <div className="text-xs font-semibold text-[#0F9F9A] flex items-center gap-1.5">
                            <CheckCircle2 className="w-3.5 h-3.5" />
                            <span>Suscripción activa</span>
                        </div>
                        <div className="text-2xl font-bold text-[#15213B] mt-1 tabular-nums">{stats.paid}</div>
                    </button>

                    <button
                        onClick={() => handleFilterStatus('trial')}
                        className={`p-4 rounded-xl border text-left transition ${
                            selectedStatus === 'trial'
                                ? 'bg-[#B45309]/5 border-[#B45309] ring-2 ring-[#B45309]/20'
                                : 'bg-white border-slate-200/90 hover:bg-slate-50'
                        }`}
                    >
                        <div className="text-xs font-semibold text-[#B45309] flex items-center gap-1.5">
                            <Clock className="w-3.5 h-3.5" />
                            <span>Período de prueba</span>
                        </div>
                        <div className="text-2xl font-bold text-[#15213B] mt-1 tabular-nums">{stats.trial}</div>
                    </button>

                    <button
                        onClick={() => handleFilterStatus('suspended')}
                        className={`p-4 rounded-xl border text-left transition ${
                            selectedStatus === 'suspended'
                                ? 'bg-[#B91C1C]/5 border-[#B91C1C] ring-2 ring-[#B91C1C]/20'
                                : 'bg-white border-slate-200/90 hover:bg-slate-50'
                        }`}
                    >
                        <div className="text-xs font-semibold text-[#B91C1C] flex items-center gap-1.5">
                            <AlertTriangle className="w-3.5 h-3.5" />
                            <span>Suspendidas</span>
                        </div>
                        <div className="text-2xl font-bold text-[#15213B] mt-1 tabular-nums">{stats.suspended}</div>
                    </button>
                </div>

                {/* Filter and Search Bar */}
                <div className="bg-white p-3.5 rounded-2xl border border-slate-200/90 flex flex-col sm:flex-row items-center justify-between gap-3 shadow-2xs w-full">
                    <form onSubmit={handleSearch} className="relative w-full sm:w-96">
                        <Search className="w-4 h-4 text-[#5C6B85] absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                        <input
                            type="text"
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                            placeholder="Buscar por nombre, ciudad, subdominio, doctor o teléfono..."
                            className="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-200 bg-[#F4F7FC] text-[#15213B] placeholder-[#5C6B85] focus:outline-hidden focus:ring-2 focus:ring-[#6D28D9] focus:bg-white transition"
                        />
                    </form>

                    <div className="flex items-center gap-2 w-full sm:w-auto justify-end text-xs text-[#5C6B85]">
                        <span>
                            Mostrando <b className="text-[#15213B] tabular-nums">{visibleTenants.length}</b> clínicas
                        </span>
                    </div>
                </div>

                {/* Clinics Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                    {visibleTenants.map((t) => {
                        const isPaid = t.saas_status === 'paid';
                        const isTrial = t.saas_status === 'trial';
                        const isSuspended = t.saas_status === 'suspended';
                        const storefrontUrl = t.base_url || (t.domain ? `https://${t.domain}` : `https://${t.slug}.avipetapp.com`);
                        const impersonateUrl = `/impersonate-clinic/${t.id}`;
                        const cleanPhone = t.phone ? t.phone.replace(/[^0-9]/g, '') : '';
                        const waPrefix = cleanPhone.startsWith('57') ? cleanPhone : `57${cleanPhone}`;
                        const waUrl = cleanPhone
                            ? `https://wa.me/${waPrefix}?text=${encodeURIComponent(
                                  `Hola ${t.doctor_name || t.name}, te escribimos desde el equipo de AviPetApp.`
                              )}`
                            : null;
                        const isPilot = t.slug === 'vet-pet-patitas';

                        return (
                            <div
                                key={t.id}
                                className="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-2xs hover:shadow-md transition flex flex-col justify-between gap-4"
                            >
                                <div>
                                    {/* Top row: Logo, Name, Status Badge */}
                                    <div className="flex items-start justify-between gap-3">
                                        <div className="flex items-start gap-3 min-w-0">
                                            <div className="w-12 h-12 rounded-xl bg-[#F4F7FC] border border-slate-200/80 overflow-hidden flex items-center justify-center shrink-0">
                                                {t.logo_url ? (
                                                    <img
                                                        src={t.logo_url}
                                                        alt={t.name}
                                                        className="w-full h-full object-contain p-1"
                                                    />
                                                ) : (
                                                    <Building2 className="w-6 h-6 text-[#0E7490]" />
                                                )}
                                            </div>
                                            <div className="min-w-0">
                                                <div className="flex items-center gap-2 flex-wrap">
                                                    <h3 className="font-bold text-[#15213B] text-base leading-snug truncate">
                                                        {t.name}
                                                    </h3>
                                                    {isPilot && (
                                                        <span className="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-[#6D28D9]/10 text-[#6D28D9] text-[10px] font-semibold">
                                                            <ShieldCheck className="w-3 h-3" />
                                                            Clínica Piloto
                                                        </span>
                                                    )}
                                                </div>

                                                <div className="flex items-center gap-1.5 text-xs text-[#5C6B85] mt-1 flex-wrap">
                                                    <MapPin className="w-3.5 h-3.5 text-[#5C6B85] shrink-0" />
                                                    <span>{t.city}</span>
                                                    <span>·</span>
                                                    <a
                                                        href={storefrontUrl}
                                                        target="_blank"
                                                        rel="noreferrer"
                                                        className="text-[11px] text-[#0E7490] bg-[#0E7490]/10 hover:bg-[#0E7490]/15 px-2 py-0.5 rounded-md font-mono font-semibold transition"
                                                        title="Abrir vitrina pública"
                                                    >
                                                        {t.slug}.avipetapp.com
                                                    </a>
                                                </div>

                                                {/* Doctor & Contact Metadata */}
                                                <div className="flex items-center gap-3 text-[11px] text-[#5C6B85] mt-2 flex-wrap">
                                                    <span className="inline-flex items-center gap-1">
                                                        <Stethoscope className="w-3.5 h-3.5 text-[#6D28D9]" />
                                                        <span className="font-medium text-[#15213B]">
                                                            {t.doctor_name || 'Dirección Médica'}
                                                        </span>
                                                    </span>
                                                    {t.email && (
                                                        <span className="inline-flex items-center gap-1 truncate max-w-[200px]">
                                                            <Mail className="w-3 h-3 text-[#5C6B85]" />
                                                            <span className="truncate">{t.email}</span>
                                                        </span>
                                                    )}
                                                    {t.phone && (
                                                        <span className="inline-flex items-center gap-1 tabular-nums">
                                                            <Phone className="w-3 h-3 text-[#5C6B85]" />
                                                            <span>{t.phone}</span>
                                                        </span>
                                                    )}
                                                </div>
                                            </div>
                                        </div>

                                        {/* Status Badge (Manual Maestro v1.1: icon + text) */}
                                        <div className="shrink-0">
                                            {isPaid && (
                                                <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#0F9F9A]/10 text-[#0F9F9A] text-xs font-semibold border border-[#0F9F9A]/25">
                                                    <CheckCircle2 className="w-3.5 h-3.5" />
                                                    <span>Activa</span>
                                                </span>
                                            )}
                                            {isTrial && (
                                                <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#B45309]/10 text-[#B45309] text-xs font-semibold border border-[#B45309]/25">
                                                    <Clock className="w-3.5 h-3.5" />
                                                    <span>Pendiente</span>
                                                </span>
                                            )}
                                            {isSuspended && (
                                                <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#B91C1C]/10 text-[#B91C1C] text-xs font-semibold border border-[#B91C1C]/25">
                                                    <AlertTriangle className="w-3.5 h-3.5" />
                                                    <span>Suspendida</span>
                                                </span>
                                            )}
                                        </div>
                                    </div>

                                    {/* Metrics summary */}
                                    <div className="grid grid-cols-4 gap-2 mt-4 pt-3 border-t border-slate-100 text-center tabular-nums">
                                        <div className="p-2.5 bg-[#F4F7FC] rounded-xl">
                                            <div className="text-[11px] text-[#5C6B85] font-medium">Mascotas</div>
                                            <div className="text-base font-bold text-[#15213B] mt-0.5">
                                                {t.pets_count}
                                            </div>
                                        </div>
                                        <div className="p-2.5 bg-[#F4F7FC] rounded-xl">
                                            <div className="text-[11px] text-[#5C6B85] font-medium">Membresías</div>
                                            <div className="text-base font-bold text-[#15213B] mt-0.5">
                                                {t.subscriptions_count}
                                            </div>
                                        </div>
                                        <div className="p-2.5 bg-[#F4F7FC] rounded-xl">
                                            <div className="text-[11px] text-[#5C6B85] font-medium">Planes</div>
                                            <div className="text-base font-bold text-[#15213B] mt-0.5">
                                                {t.plans_count}
                                            </div>
                                        </div>
                                        <div className="p-2.5 bg-[#F4F7FC] rounded-xl">
                                            <div className="text-[11px] text-[#5C6B85] font-medium">Canon SaaS</div>
                                            <div className="text-sm font-bold text-[#15213B] mt-0.5">
                                                ${(t.saas_monthly_fee / 1000).toFixed(0)}k COP
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {/* Action Buttons */}
                                <div className="flex flex-wrap items-center justify-between gap-2 pt-2 border-t border-slate-100">
                                    <div className="flex items-center gap-1">
                                        {waUrl && (
                                            <a
                                                href={waUrl}
                                                target="_blank"
                                                rel="noreferrer"
                                                className="p-2 text-[#0F9F9A] hover:bg-[#0F9F9A]/10 rounded-lg transition"
                                                title="Contactar por WhatsApp"
                                            >
                                                <MessageCircle className="w-4 h-4" />
                                            </a>
                                        )}
                                        <a
                                            href={storefrontUrl}
                                            target="_blank"
                                            rel="noreferrer"
                                            className="p-2 text-[#5C6B85] hover:text-[#15213B] hover:bg-slate-100 rounded-lg transition"
                                            title="Ver vitrina pública de la clínica"
                                        >
                                            <ExternalLink className="w-4 h-4" />
                                        </a>
                                        <button
                                            type="button"
                                            onClick={() => handleCopyUrl(t.slug, storefrontUrl)}
                                            className="p-2 text-[#5C6B85] hover:text-[#15213B] hover:bg-slate-100 rounded-lg transition"
                                            title="Copiar enlace de la clínica"
                                        >
                                            {copiedSlug === t.slug ? (
                                                <Check className="w-4 h-4 text-[#0F9F9A]" />
                                            ) : (
                                                <Copy className="w-4 h-4" />
                                            )}
                                        </button>
                                        {!isPilot && (
                                            <button
                                                type="button"
                                                onClick={() => {
                                                    openManageModal(t);
                                                    setConfirmDeleteId(t.id);
                                                }}
                                                className="p-2 text-[#5C6B85] hover:text-[#B91C1C] hover:bg-[#B91C1C]/10 rounded-lg transition"
                                                title="Eliminar clínica"
                                            >
                                                <Trash2 className="w-4 h-4" />
                                            </button>
                                        )}
                                    </div>

                                    <div className="flex items-center gap-2">
                                        <a
                                            href={impersonateUrl}
                                            className="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#0F9F9A] hover:bg-[#0D8A85] text-white text-xs font-semibold rounded-lg shadow-2xs transition"
                                        >
                                            <LogIn className="w-3.5 h-3.5" />
                                            <span>Ver clínica</span>
                                        </a>

                                        <button
                                            type="button"
                                            onClick={() => openManageModal(t)}
                                            className="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-[#F4F7FC] text-[#6D28D9] border border-[#6D28D9]/40 text-xs font-semibold rounded-lg transition"
                                        >
                                            <Settings2 className="w-3.5 h-3.5" />
                                            <span>Gestionar</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        );
                    })}
                </div>

                {visibleTenants.length === 0 && (
                    <div className="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                        <Building2 className="w-12 h-12 text-slate-300 mx-auto mb-3" />
                        <h3 className="text-base font-bold text-[#15213B]">No se encontraron clínicas</h3>
                        <p className="text-xs text-[#5C6B85] mt-1">
                            Prueba con otros términos de búsqueda o crea una nueva clínica con el botón superior.
                        </p>
                    </div>
                )}
            </div>

            {/* MODAL 1: CREAR NUEVA CLÍNICA */}
            {isCreateModalOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#080B20]/60 backdrop-blur-xs overflow-y-auto">
                    <div className="bg-white rounded-2xl max-w-xl w-full p-6 shadow-xl border border-slate-200 space-y-4 my-8">
                        <div className="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div>
                                <h3 className="font-bold text-[#15213B] text-lg">Crear clínica veterinaria</h3>
                                <p className="text-xs text-[#5C6B85]">
                                    Crea el portal de la clínica, sus planes de salud base y el usuario administrador.
                                </p>
                            </div>
                            <button
                                onClick={() => setIsCreateModalOpen(false)}
                                className="text-[#5C6B85] hover:text-[#15213B] p-1 rounded-lg"
                            >
                                <X className="w-5 h-5" />
                            </button>
                        </div>

                        <form onSubmit={handleCreateClinic} className="space-y-4 text-xs">
                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div className="sm:col-span-2">
                                    <label className="block font-semibold text-[#15213B] mb-1">
                                        Nombre comercial de la clínica *
                                    </label>
                                    <input
                                        type="text"
                                        required
                                        value={newClinic.name}
                                        onChange={(e) => setNewClinic({ ...newClinic, name: e.target.value })}
                                        placeholder="Ej: Clínica Veterinaria San Roque"
                                        className="w-full p-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#6D28D9] outline-hidden"
                                    />
                                </div>

                                <div>
                                    <label className="block font-semibold text-[#15213B] mb-1">
                                        Subdominio (opcional)
                                    </label>
                                    <div className="flex items-center border border-slate-200 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-[#6D28D9]">
                                        <input
                                            type="text"
                                            value={newClinic.slug}
                                            onChange={(e) => setNewClinic({ ...newClinic, slug: e.target.value })}
                                            placeholder="san-roque"
                                            className="w-full p-2.5 outline-hidden font-mono text-xs"
                                        />
                                        <span className="bg-[#F4F7FC] text-[#5C6B85] px-2.5 py-2.5 text-[11px] font-mono border-l border-slate-200">
                                            .avipetapp.com
                                        </span>
                                    </div>
                                </div>

                                <div>
                                    <label className="block font-semibold text-[#15213B] mb-1">
                                        Ciudad / Municipio
                                    </label>
                                    <input
                                        type="text"
                                        value={newClinic.city}
                                        onChange={(e) => setNewClinic({ ...newClinic, city: e.target.value })}
                                        placeholder="Ej: Bogotá, Cajicá, Medellín"
                                        className="w-full p-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#6D28D9] outline-hidden"
                                    />
                                </div>

                                <div>
                                    <label className="block font-semibold text-[#15213B] mb-1">
                                        Nombre del Doctor(a) / Director
                                    </label>
                                    <input
                                        type="text"
                                        value={newClinic.doctor_name}
                                        onChange={(e) => setNewClinic({ ...newClinic, doctor_name: e.target.value })}
                                        placeholder="Ej: Dra. Camila Torres"
                                        className="w-full p-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#6D28D9] outline-hidden"
                                    />
                                </div>

                                <div>
                                    <label className="block font-semibold text-[#15213B] mb-1">
                                        Teléfono / WhatsApp
                                    </label>
                                    <input
                                        type="text"
                                        value={newClinic.phone}
                                        onChange={(e) => setNewClinic({ ...newClinic, phone: e.target.value })}
                                        placeholder="300 000 0000"
                                        className="w-full p-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#6D28D9] outline-hidden"
                                    />
                                </div>

                                <div>
                                    <label className="block font-semibold text-[#15213B] mb-1">
                                        Correo de acceso del Doctor
                                    </label>
                                    <input
                                        type="email"
                                        value={newClinic.email}
                                        onChange={(e) => setNewClinic({ ...newClinic, email: e.target.value })}
                                        placeholder="doctor@veterinaria.com"
                                        className="w-full p-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#6D28D9] outline-hidden"
                                    />
                                </div>

                                <div>
                                    <label className="block font-semibold text-[#15213B] mb-1">
                                        Contraseña inicial
                                    </label>
                                    <input
                                        type="text"
                                        value={newClinic.password}
                                        onChange={(e) => setNewClinic({ ...newClinic, password: e.target.value })}
                                        placeholder="Por defecto: AviPet2026*"
                                        className="w-full p-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#6D28D9] outline-hidden font-mono"
                                    />
                                </div>

                                <div>
                                    <label className="block font-semibold text-[#15213B] mb-1">Plan SaaS</label>
                                    <select
                                        value={newClinic.saas_plan}
                                        onChange={(e) => {
                                            const plan = e.target.value;
                                            const fee =
                                                plan === 'starter'
                                                    ? 99000
                                                    : plan === 'pro'
                                                    ? 229000
                                                    : plan === 'enterprise'
                                                    ? 489000
                                                    : 50000;
                                            setNewClinic({ ...newClinic, saas_plan: plan, saas_monthly_fee: fee });
                                        }}
                                        className="w-full p-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#6D28D9] outline-hidden bg-white"
                                    >
                                        <option value="pay_per_pet">Paquete 10 mascotas ($50.000 COP)</option>
                                        <option value="starter">Starter ($99.000 COP/mes)</option>
                                        <option value="pro">Profesional ($229.000 COP/mes)</option>
                                        <option value="enterprise">Enterprise ($489.000 COP/mes)</option>
                                    </select>
                                </div>

                                <div>
                                    <label className="block font-semibold text-[#15213B] mb-1">Estado inicial</label>
                                    <select
                                        value={newClinic.saas_status}
                                        onChange={(e) => setNewClinic({ ...newClinic, saas_status: e.target.value })}
                                        className="w-full p-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#6D28D9] outline-hidden bg-white"
                                    >
                                        <option value="paid">Activa (Suscripción al día)</option>
                                        <option value="trial">En prueba gratuita (15 días)</option>
                                    </select>
                                </div>
                            </div>

                            <div className="flex justify-end gap-2.5 pt-4 border-t border-slate-100">
                                <button
                                    type="button"
                                    onClick={() => setIsCreateModalOpen(false)}
                                    className="px-4 py-2 text-[#6D28D9] border border-[#6D28D9] hover:bg-[#6D28D9]/5 rounded-xl font-semibold transition"
                                >
                                    Cancelar
                                </button>
                                <button
                                    type="submit"
                                    disabled={submittingCreate}
                                    className="px-5 py-2 bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-semibold rounded-xl shadow-xs transition disabled:opacity-60"
                                >
                                    {submittingCreate ? 'Guardando...' : 'Guardar'}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}

            {/* MODAL 2: GESTIONAR / EDITAR / ELIMINAR CLÍNICA */}
            {editingTenant && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#080B20]/60 backdrop-blur-xs overflow-y-auto">
                    <div className="bg-white rounded-2xl max-w-2xl w-full p-6 shadow-xl border border-slate-200 space-y-5 my-8 max-h-[92vh] overflow-y-auto">
                        <div className="flex items-start justify-between pb-3 border-b border-slate-100">
                            <div>
                                <div className="flex items-center gap-2">
                                    <h3 className="font-bold text-[#15213B] text-lg">
                                        Gestionar clínica: {editingTenant.name}
                                    </h3>
                                </div>
                                <p className="text-xs text-[#5C6B85] mt-0.5">
                                    Configura subdominio, estado de suscripción SaaS, datos de contacto y credenciales del doctor.
                                </p>
                            </div>
                            <button
                                onClick={() => setEditingTenant(null)}
                                className="text-[#5C6B85] hover:text-[#15213B] p-1 rounded-lg"
                            >
                                <X className="w-5 h-5" />
                            </button>
                        </div>

                        <form onSubmit={handleUpdateClinic} className="space-y-5 text-xs">
                            {/* Bloque 1: Estado y Suscripción SaaS */}
                            <div className="p-4 rounded-xl bg-[#F4F7FC] border border-slate-200/80 space-y-3">
                                <div className="font-bold text-[#15213B] text-xs uppercase tracking-wider flex items-center gap-1.5">
                                    <ShieldCheck className="w-4 h-4 text-[#6D28D9]" />
                                    <span>Estado de suscripción y plan SaaS</span>
                                </div>
                                <div className="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <div>
                                        <label className="block font-semibold text-[#15213B] mb-1">Estado</label>
                                        <select
                                            value={editForm.saas_status}
                                            onChange={(e) =>
                                                setEditForm({ ...editForm, saas_status: e.target.value })
                                            }
                                            className="w-full p-2.5 border border-slate-200 rounded-xl bg-white focus:ring-2 focus:ring-[#6D28D9] outline-hidden font-semibold"
                                        >
                                            <option value="paid">Activa (Suscripción activa)</option>
                                            <option value="trial">Pendiente (Período de prueba)</option>
                                            <option value="suspended">Suspendida (Acceso pausado)</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label className="block font-semibold text-[#15213B] mb-1">Plan SaaS</label>
                                        <select
                                            value={editForm.saas_plan}
                                            onChange={(e) => {
                                                const plan = e.target.value;
                                                const fee =
                                                    plan === 'starter'
                                                        ? 99000
                                                        : plan === 'pro'
                                                        ? 229000
                                                        : plan === 'enterprise'
                                                        ? 489000
                                                        : 50000;
                                                setEditForm({
                                                    ...editForm,
                                                    saas_plan: plan,
                                                    saas_monthly_fee: fee
                                                });
                                            }}
                                            className="w-full p-2.5 border border-slate-200 rounded-xl bg-white focus:ring-2 focus:ring-[#6D28D9] outline-hidden"
                                        >
                                            <option value="pay_per_pet">Paquete 10 mascotas ($50k)</option>
                                            <option value="starter">Starter ($99k/mes)</option>
                                            <option value="pro">Profesional ($229k/mes)</option>
                                            <option value="enterprise">Enterprise ($489k/mes)</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label className="block font-semibold text-[#15213B] mb-1">
                                            Canon mensual (COP)
                                        </label>
                                        <input
                                            type="number"
                                            value={editForm.saas_monthly_fee}
                                            onChange={(e) =>
                                                setEditForm({
                                                    ...editForm,
                                                    saas_monthly_fee: Number(e.target.value)
                                                })
                                            }
                                            className="w-full p-2.5 border border-slate-200 rounded-xl bg-white focus:ring-2 focus:ring-[#6D28D9] outline-hidden tabular-nums font-semibold"
                                        />
                                    </div>
                                </div>
                            </div>

                            {/* Bloque 2: Identidad y Subdominio */}
                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div className="sm:col-span-2">
                                    <label className="block font-semibold text-[#15213B] mb-1">
                                        Nombre comercial de la clínica *
                                    </label>
                                    <input
                                        type="text"
                                        required
                                        value={editForm.name}
                                        onChange={(e) => setEditForm({ ...editForm, name: e.target.value })}
                                        className="w-full p-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#6D28D9] outline-hidden"
                                    />
                                </div>

                                <div>
                                    <label className="block font-semibold text-[#15213B] mb-1">
                                        Subdominio oficial (slug) *
                                    </label>
                                    <div className="flex items-center border border-slate-200 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-[#6D28D9]">
                                        <input
                                            type="text"
                                            required
                                            value={editForm.slug}
                                            onChange={(e) => setEditForm({ ...editForm, slug: e.target.value })}
                                            className="w-full p-2.5 outline-hidden font-mono text-xs"
                                        />
                                        <span className="bg-[#F4F7FC] text-[#5C6B85] px-2.5 py-2.5 text-[11px] font-mono border-l border-slate-200">
                                            .avipetapp.com
                                        </span>
                                    </div>
                                </div>

                                <div>
                                    <label className="block font-semibold text-[#15213B] mb-1">
                                        Dominio propio (opcional)
                                    </label>
                                    <div className="relative">
                                        <Globe className="w-3.5 h-3.5 text-[#5C6B85] absolute left-3 top-1/2 -translate-y-1/2" />
                                        <input
                                            type="text"
                                            value={editForm.domain}
                                            onChange={(e) => setEditForm({ ...editForm, domain: e.target.value })}
                                            placeholder="planes.miveterinaria.com"
                                            className="w-full pl-8 pr-3 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#6D28D9] outline-hidden font-mono"
                                        />
                                    </div>
                                </div>

                                <div>
                                    <label className="block font-semibold text-[#15213B] mb-1">
                                        Ciudad / Municipio
                                    </label>
                                    <input
                                        type="text"
                                        value={editForm.city}
                                        onChange={(e) => setEditForm({ ...editForm, city: e.target.value })}
                                        className="w-full p-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#6D28D9] outline-hidden"
                                    />
                                </div>

                                <div>
                                    <label className="block font-semibold text-[#15213B] mb-1">
                                        Teléfono / WhatsApp
                                    </label>
                                    <input
                                        type="text"
                                        value={editForm.phone}
                                        onChange={(e) => setEditForm({ ...editForm, phone: e.target.value })}
                                        className="w-full p-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#6D28D9] outline-hidden tabular-nums"
                                    />
                                </div>
                            </div>

                            {/* Bloque 3: Doctor Administrador y Acceso */}
                            <div className="p-4 rounded-xl bg-[#F4F7FC] border border-slate-200/80 space-y-3">
                                <div className="font-bold text-[#15213B] text-xs uppercase tracking-wider flex items-center gap-1.5">
                                    <KeyRound className="w-4 h-4 text-[#0E7490]" />
                                    <span>Doctor responsable y credenciales de acceso</span>
                                </div>

                                <div className="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <div>
                                        <label className="block font-semibold text-[#15213B] mb-1">
                                            Nombre del Doctor(a)
                                        </label>
                                        <input
                                            type="text"
                                            value={editForm.doctor_name}
                                            onChange={(e) =>
                                                setEditForm({ ...editForm, doctor_name: e.target.value })
                                            }
                                            placeholder="Dr(a). Titular"
                                            className="w-full p-2.5 border border-slate-200 rounded-xl bg-white focus:ring-2 focus:ring-[#6D28D9] outline-hidden"
                                        />
                                    </div>

                                    <div>
                                        <label className="block font-semibold text-[#15213B] mb-1">
                                            Correo de inicio de sesión
                                        </label>
                                        <input
                                            type="email"
                                            value={editForm.email}
                                            onChange={(e) => setEditForm({ ...editForm, email: e.target.value })}
                                            placeholder="correo@clinica.com"
                                            className="w-full p-2.5 border border-slate-200 rounded-xl bg-white focus:ring-2 focus:ring-[#6D28D9] outline-hidden"
                                        />
                                    </div>

                                    <div>
                                        <label className="block font-semibold text-[#15213B] mb-1">
                                            Nueva contraseña (opcional)
                                        </label>
                                        <input
                                            type="text"
                                            value={editForm.new_password}
                                            onChange={(e) =>
                                                setEditForm({ ...editForm, new_password: e.target.value })
                                            }
                                            placeholder="Dejar vacío para no cambiar"
                                            className="w-full p-2.5 border border-slate-200 rounded-xl bg-white focus:ring-2 focus:ring-[#6D28D9] outline-hidden font-mono"
                                        />
                                    </div>
                                </div>
                            </div>

                            {/* Zona de Eliminación Segura (Protegida en vet-pet-patitas) */}
                            {editingTenant.slug !== 'vet-pet-patitas' ? (
                                <div className="p-4 rounded-xl bg-[#B91C1C]/5 border border-[#B91C1C]/20 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div>
                                        <div className="font-bold text-[#B91C1C] text-xs flex items-center gap-1.5">
                                            <Trash2 className="w-4 h-4" />
                                            <span>Eliminar esta clínica de la plataforma</span>
                                        </div>
                                        <p className="text-[11px] text-[#5C6B85] mt-0.5">
                                            Borra permanentemente la clínica, sus planes, mascotas asociadas y el subdominio del Sitemap.
                                        </p>
                                    </div>

                                    {confirmDeleteId === editingTenant.id ? (
                                        <div className="flex items-center gap-2 shrink-0">
                                            <button
                                                type="button"
                                                onClick={() => setConfirmDeleteId(null)}
                                                className="px-3 py-1.5 bg-white border border-slate-300 text-[#15213B] rounded-lg font-semibold text-xs"
                                            >
                                                Cancelar
                                            </button>
                                            <button
                                                type="button"
                                                disabled={submittingDelete}
                                                onClick={() => handleDeleteClinic(editingTenant.id)}
                                                className="px-3.5 py-1.5 bg-[#B91C1C] hover:bg-[#991B1B] text-white rounded-lg font-semibold text-xs shadow-2xs transition disabled:opacity-60"
                                            >
                                                {submittingDelete ? 'Eliminando...' : 'Confirmar Eliminar'}
                                            </button>
                                        </div>
                                    ) : (
                                        <button
                                            type="button"
                                            onClick={() => setConfirmDeleteId(editingTenant.id)}
                                            className="px-3.5 py-2 bg-[#B91C1C] hover:bg-[#991B1B] text-white rounded-xl font-semibold text-xs shrink-0 transition"
                                        >
                                            Eliminar
                                        </button>
                                    )}
                                </div>
                            ) : (
                                <div className="p-3.5 rounded-xl bg-[#0F9F9A]/10 border border-[#0F9F9A]/25 text-xs text-[#15213B] flex items-center gap-2">
                                    <ShieldCheck className="w-4 h-4 text-[#0F9F9A] shrink-0" />
                                    <span>
                                        <b>Clínica Piloto Protegida:</b> Vet-Pet Patitas cuenta con bloqueo de seguridad contra eliminación accidental.
                                    </span>
                                </div>
                            )}

                            {/* Botones de Acción (Manual Maestro v1.1: Guardar en Violet Deep #6D28D9, Cancelar en borde #6D28D9) */}
                            <div className="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                                <button
                                    type="button"
                                    onClick={() => setEditingTenant(null)}
                                    className="px-4 py-2 text-[#6D28D9] border border-[#6D28D9] hover:bg-[#6D28D9]/5 rounded-xl font-semibold transition"
                                >
                                    Cancelar
                                </button>
                                <button
                                    type="submit"
                                    disabled={submittingUpdate}
                                    className="px-5 py-2 bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-semibold rounded-xl shadow-xs transition disabled:opacity-60"
                                >
                                    {submittingUpdate ? 'Guardando...' : 'Guardar'}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </SuperAdminLayout>
    );
}
