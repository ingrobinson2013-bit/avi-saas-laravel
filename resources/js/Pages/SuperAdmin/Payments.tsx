import React, { useState } from 'react';
import { Head, router } from '@inertiajs/react';
import SuperAdminLayout from '@/Layouts/SuperAdminLayout';
import {
    CreditCard,
    Search,
    Plus,
    CheckCircle2,
    Clock,
    AlertTriangle,
    Building2,
    Calendar,
    DollarSign,
    FileText,
    X,
    ChevronLeft,
    ChevronRight,
    TrendingUp,
    ShieldCheck,
    Smartphone,
    Landmark,
    Banknote,
    Sliders,
    Trash2,
    MessageCircle,
    Settings2
} from 'lucide-react';

interface PaymentItem {
    id: string;
    order_id: string;
    tenant_id: string;
    tenant_name: string;
    tenant_slug: string;
    amount: number;
    currency: string;
    gateway: string;
    plan_tier: string;
    status: string;
    transaction_id: string | null;
    payer_name: string | null;
    payer_email: string | null;
    payer_phone: string | null;
    period_start: string | null;
    period_end: string | null;
    period_start_iso?: string | null;
    period_end_iso?: string | null;
    notes: string | null;
    paid_at: string | null;
    created_at: string | null;
}

interface TenantOption {
    id: string;
    name: string;
    slug: string;
    default_fee?: number;
    default_plan?: string;
}

interface PaymentsProps {
    payments: {
        data: PaymentItem[];
        current_page: number;
        last_page: number;
        total: number;
        prev_page_url: string | null;
        next_page_url: string | null;
    };
    filters: {
        search: string;
        status: string;
        gateway: string;
    };
    stats: {
        totalRecaudado: number;
        aprobadosCount: number;
        pendientesCount: number;
        pendientesMonto: number;
        fallidosCount?: number;
        mrr: number;
        activePaidClinics?: number;
    };
    tenantsList: TenantOption[];
    userName?: string;
    userEmail?: string;
}

export default function Payments({
    payments,
    filters,
    stats,
    tenantsList = [],
    userName = 'Robinson Naranjo',
    userEmail = 'contacto@avipetapp.com'
}: PaymentsProps) {
    const [searchTerm, setSearchTerm] = useState(filters.search || '');
    const [selectedStatus, setSelectedStatus] = useState(filters.status || 'all');
    const [selectedGateway, setSelectedGateway] = useState(filters.gateway || 'all');

    // Modal Crear Pago Manual
    const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
    const [submittingCreate, setSubmittingCreate] = useState(false);
    const [formPayment, setFormPayment] = useState({
        tenant_id: tenantsList[0]?.id || '',
        amount: String(tenantsList[0]?.default_fee ?? 99000),
        gateway: 'bold',
        plan_tier: tenantsList[0]?.default_plan || 'starter',
        status: 'approved',
        period_start: new Date().toISOString().split('T')[0],
        period_end: new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toISOString().split('T')[0],
        notes: ''
    });

    // Modal Gestionar / Ver Detalle de Pago
    const [editingPayment, setEditingPayment] = useState<PaymentItem | null>(null);
    const [submittingUpdate, setSubmittingUpdate] = useState(false);
    const [confirmDeleteId, setConfirmDeleteId] = useState<string | null>(null);
    const [submittingDelete, setSubmittingDelete] = useState(false);
    const [editForm, setEditForm] = useState({
        amount: '99000',
        gateway: 'bold',
        plan_tier: 'starter',
        status: 'approved',
        period_start: '',
        period_end: '',
        payer_email: '',
        notes: ''
    });

    const formatCurrency = (val: number) => {
        return new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            maximumFractionDigits: 0
        }).format(val);
    };

    const openEditModal = (item: PaymentItem) => {
        setEditingPayment(item);
        setConfirmDeleteId(null);
        setEditForm({
            amount: String(item.amount || 99000),
            gateway: item.gateway === 'bold_wompi' ? 'bold' : (item.gateway || 'bold'),
            plan_tier: item.plan_tier || 'starter',
            status: item.status || 'approved',
            period_start: item.period_start_iso || new Date().toISOString().split('T')[0],
            period_end: item.period_end_iso || new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toISOString().split('T')[0],
            payer_email: item.payer_email || '',
            notes: item.notes || ''
        });
    };

    const handleSearch = (e: React.FormEvent) => {
        e.preventDefault();
        router.get(
            '/super-admin/saas-payment-logs',
            {
                search: searchTerm,
                status: selectedStatus,
                gateway: selectedGateway
            },
            { preserveState: true }
        );
    };

    const handleFilterStatus = (status: string) => {
        setSelectedStatus(status);
        router.get(
            '/super-admin/saas-payment-logs',
            {
                search: searchTerm,
                status,
                gateway: selectedGateway
            },
            { preserveState: true }
        );
    };

    const handleFilterGateway = (gateway: string) => {
        setSelectedGateway(gateway);
        router.get(
            '/super-admin/saas-payment-logs',
            {
                search: searchTerm,
                status: selectedStatus,
                gateway
            },
            { preserveState: true }
        );
    };

    const handleSubmitPayment = (e: React.FormEvent) => {
        e.preventDefault();
        setSubmittingCreate(true);
        router.post('/super-admin/saas-payment-logs', formPayment, {
            onSuccess: () => {
                setIsCreateModalOpen(false);
                setFormPayment({
                    tenant_id: tenantsList[0]?.id || '',
                    amount: '99000',
                    gateway: 'bold',
                    plan_tier: 'starter',
                    status: 'approved',
                    period_start: new Date().toISOString().split('T')[0],
                    period_end: new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toISOString().split('T')[0],
                    notes: ''
                });
            },
            onFinish: () => setSubmittingCreate(false)
        });
    };

    const handleUpdatePayment = (e: React.FormEvent) => {
        e.preventDefault();
        if (!editingPayment) return;
        setSubmittingUpdate(true);
        router.post(`/super-admin/saas-payment-logs/${editingPayment.id}/update`, editForm, {
            onSuccess: () => {
                setEditingPayment(null);
            },
            onFinish: () => setSubmittingUpdate(false)
        });
    };

    const handleDeletePayment = (id: string) => {
        setSubmittingDelete(true);
        router.post(
            `/super-admin/saas-payment-logs/${id}/delete`,
            {},
            {
                onSuccess: () => {
                    setConfirmDeleteId(null);
                    setEditingPayment(null);
                },
                onFinish: () => setSubmittingDelete(false)
            }
        );
    };

    // Estados verificados según Manual Maestro de Marca v1.1 (ícono + texto)
    const getStatusBadge = (status: string) => {
        switch (status) {
            case 'approved':
                return (
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#0F9F9A]/10 text-[#0F9F9A] border border-[#0F9F9A]/25">
                        <CheckCircle2 className="w-3.5 h-3.5" />
                        <span>Aprobado</span>
                    </span>
                );
            case 'pending':
                return (
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#B45309]/10 text-[#B45309] border border-[#B45309]/25">
                        <Clock className="w-3.5 h-3.5" />
                        <span>Pendiente</span>
                    </span>
                );
            case 'failed':
                return (
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#B91C1C]/10 text-[#B91C1C] border border-[#B91C1C]/25">
                        <AlertTriangle className="w-3.5 h-3.5" />
                        <span>Fallido</span>
                    </span>
                );
            default:
                return (
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-[#15213B] border border-slate-200">
                        {status}
                    </span>
                );
        }
    };

    const getGatewayBadge = (gateway: string) => {
        const normalized = (gateway || '').toLowerCase();
        if (normalized === 'bold' || normalized === 'bold_wompi' || normalized === 'wompi') {
            return (
                <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-[#0E7490]/10 text-[#0E7490] border border-[#0E7490]/20">
                    <CreditCard className="w-3.5 h-3.5" />
                    <span>Bold / PSE</span>
                </span>
            );
        }
        if (normalized === 'nequi') {
            return (
                <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-[#6D28D9]/10 text-[#6D28D9] border border-[#6D28D9]/20">
                    <Smartphone className="w-3.5 h-3.5" />
                    <span>Nequi / Daviplata</span>
                </span>
            );
        }
        if (normalized === 'bancolombia') {
            return (
                <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-[#B45309]/10 text-[#B45309] border border-[#B45309]/20">
                    <Landmark className="w-3.5 h-3.5" />
                    <span>Bancolombia</span>
                </span>
            );
        }
        if (normalized === 'cash') {
            return (
                <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-[#0F9F9A]/10 text-[#0F9F9A] border border-[#0F9F9A]/20">
                    <Banknote className="w-3.5 h-3.5" />
                    <span>Efectivo</span>
                </span>
            );
        }
        return (
            <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-[#15213B] border border-slate-200">
                <Sliders className="w-3.5 h-3.5 text-[#5C6B85]" />
                <span>Registro manual</span>
            </span>
        );
    };

    const getPlanLabel = (tier: string) => {
        switch ((tier || '').toLowerCase()) {
            case 'starter':
                return 'Plan Starter';
            case 'pro':
                return 'Plan Profesional';
            case 'enterprise':
                return 'Plan Enterprise';
            case 'pay_per_pet':
                return 'Paquete por Mascota';
            default:
                return `Plan ${tier}`;
        }
    };

    // Filtro instantáneo en cliente
    const visiblePayments = payments.data.filter((item) => {
        if (selectedStatus !== 'all' && item.status !== selectedStatus) {
            return false;
        }
        if (selectedGateway !== 'all') {
            if (selectedGateway === 'bold' && !['bold', 'bold_wompi'].includes(item.gateway)) {
                return false;
            } else if (selectedGateway !== 'bold' && item.gateway !== selectedGateway) {
                return false;
            }
        }
        if (searchTerm.trim() !== '') {
            const q = searchTerm.toLowerCase().trim();
            const haystack = [
                item.order_id,
                item.tenant_name,
                item.tenant_slug,
                item.payer_email,
                item.payer_name,
                item.transaction_id
            ]
                .filter(Boolean)
                .join(' ')
                .toLowerCase();
            return haystack.includes(q);
        }
        return true;
    });

    return (
        <SuperAdminLayout
            userName={userName}
            userEmail={userEmail}
            activeItem="Suscripciones y pagos"
        >
            <Head title="Suscripciones y pagos · AviPetApp Superadmin" />

            <div className="space-y-6 max-w-full text-[#15213B]">
                {/* HEADER */}
                <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 className="text-[28px] sm:text-[32px] font-bold text-[#15213B] tracking-tight leading-tight">
                            Suscripciones y pagos
                        </h1>
                        <p className="text-sm text-[#5C6B85] mt-1">
                            Control de recaudo mensual de clínicas veterinarias, pasarela Bold y conciliación de membresías SaaS.
                        </p>
                    </div>

                    <button
                        onClick={() => setIsCreateModalOpen(true)}
                        className="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-semibold text-sm shadow-xs transition self-start sm:self-auto cursor-pointer"
                    >
                        <Plus className="w-4 h-4" />
                        <span>Registrar pago manual</span>
                    </button>
                </div>

                {/* 4 SUMMARY STAT CARDS (Manual Maestro v1.1) */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 tabular-nums">
                    <div className="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-2xs flex items-center justify-between">
                        <div>
                            <span className="text-xs font-semibold uppercase tracking-wider text-[#5C6B85]">
                                Recaudo total histórico
                            </span>
                            <div className="text-2xl font-bold text-[#15213B] mt-1">
                                {formatCurrency(stats.totalRecaudado)}
                            </div>
                            <div className="text-xs font-medium text-[#0F9F9A] flex items-center gap-1 mt-1">
                                <CheckCircle2 className="w-3.5 h-3.5" />
                                <span>{stats.aprobadosCount} transacciones aprobadas</span>
                            </div>
                        </div>
                        <div className="w-12 h-12 rounded-xl bg-[#0F9F9A]/10 text-[#0F9F9A] flex items-center justify-center shrink-0">
                            <DollarSign className="w-6 h-6" />
                        </div>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-2xs flex items-center justify-between">
                        <div>
                            <span className="text-xs font-semibold uppercase tracking-wider text-[#5C6B85]">
                                MRR mensual SaaS
                            </span>
                            <div className="text-2xl font-bold text-[#0E7490] mt-1">
                                {formatCurrency(stats.mrr)}
                            </div>
                            <div className="text-xs font-medium text-[#5C6B85] mt-1">
                                Ingreso recurrente ({stats.activePaidClinics ?? 1} clínica activa)
                            </div>
                        </div>
                        <div className="w-12 h-12 rounded-xl bg-[#0E7490]/10 text-[#0E7490] flex items-center justify-center shrink-0">
                            <TrendingUp className="w-6 h-6" />
                        </div>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-2xs flex items-center justify-between">
                        <div>
                            <span className="text-xs font-semibold uppercase tracking-wider text-[#5C6B85]">
                                Cobros pendientes
                            </span>
                            <div className="text-2xl font-bold text-[#B45309] mt-1">
                                {formatCurrency(stats.pendientesMonto)}
                            </div>
                            <div className="text-xs font-medium text-[#B45309] flex items-center gap-1 mt-1">
                                <Clock className="w-3.5 h-3.5" />
                                <span>{stats.pendientesCount} órdenes en revisión</span>
                            </div>
                        </div>
                        <div className="w-12 h-12 rounded-xl bg-[#B45309]/10 text-[#B45309] flex items-center justify-center shrink-0">
                            <Clock className="w-6 h-6" />
                        </div>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-2xs flex items-center justify-between">
                        <div>
                            <span className="text-xs font-semibold uppercase tracking-wider text-[#5C6B85]">
                                Pasarela Bold
                            </span>
                            <div className="text-lg font-bold text-[#15213B] mt-1">100 % Tokenizado</div>
                            <div className="text-xs font-medium text-[#0F9F9A] flex items-center gap-1 mt-1">
                                <ShieldCheck className="w-3.5 h-3.5" />
                                <span>Webhooks activos</span>
                            </div>
                        </div>
                        <div className="w-12 h-12 rounded-xl bg-[#6D28D9]/10 text-[#6D28D9] flex items-center justify-center shrink-0">
                            <ShieldCheck className="w-6 h-6" />
                        </div>
                    </div>
                </div>

                {/* FILTERS & SEARCH BAR */}
                <div className="bg-white rounded-2xl border border-slate-200/90 p-4 shadow-2xs flex flex-col md:flex-row gap-4 justify-between items-stretch md:items-center">
                    {/* Status Tabs */}
                    <div className="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0 scrollbar-none">
                        <button
                            type="button"
                            onClick={() => handleFilterStatus('all')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-semibold transition-all cursor-pointer whitespace-nowrap ${
                                selectedStatus === 'all'
                                    ? 'bg-[#6D28D9] text-white shadow-2xs'
                                    : 'text-[#5C6B85] hover:bg-[#F4F7FC]'
                            }`}
                        >
                            Todos ({payments.total})
                        </button>
                        <button
                            type="button"
                            onClick={() => handleFilterStatus('approved')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-semibold transition-all cursor-pointer whitespace-nowrap ${
                                selectedStatus === 'approved'
                                    ? 'bg-[#0F9F9A] text-white shadow-2xs'
                                    : 'text-[#5C6B85] hover:bg-[#F4F7FC]'
                            }`}
                        >
                            Aprobados ({stats.aprobadosCount})
                        </button>
                        <button
                            type="button"
                            onClick={() => handleFilterStatus('pending')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-semibold transition-all cursor-pointer whitespace-nowrap ${
                                selectedStatus === 'pending'
                                    ? 'bg-[#B45309] text-white shadow-2xs'
                                    : 'text-[#5C6B85] hover:bg-[#F4F7FC]'
                            }`}
                        >
                            Pendientes ({stats.pendientesCount})
                        </button>
                        <button
                            type="button"
                            onClick={() => handleFilterStatus('failed')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-semibold transition-all cursor-pointer whitespace-nowrap ${
                                selectedStatus === 'failed'
                                    ? 'bg-[#B91C1C] text-white shadow-2xs'
                                    : 'text-[#5C6B85] hover:bg-[#F4F7FC]'
                            }`}
                        >
                            Fallidos ({stats.fallidosCount ?? 0})
                        </button>
                    </div>

                    {/* Search & Gateway Filter */}
                    <div className="flex items-center gap-2">
                        <select
                            value={selectedGateway}
                            onChange={(e) => handleFilterGateway(e.target.value)}
                            className="text-xs font-semibold bg-[#F4F7FC] border border-slate-200 rounded-xl px-3 py-2 text-[#15213B] focus:outline-hidden focus:ring-2 focus:ring-[#6D28D9]"
                        >
                            <option value="all">Todas las pasarelas</option>
                            <option value="bold">Bold / PSE / Tarjeta</option>
                            <option value="nequi">Nequi / Daviplata</option>
                            <option value="bancolombia">Bancolombia</option>
                            <option value="cash">Efectivo</option>
                            <option value="manual">Manual</option>
                        </select>

                        <form onSubmit={handleSearch} className="relative flex-1 sm:w-64">
                            <Search className="w-4 h-4 text-[#5C6B85] absolute left-3 top-1/2 -translate-y-1/2" />
                            <input
                                type="text"
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                                placeholder="Buscar orden, clínica o correo..."
                                className="w-full pl-9 pr-3 py-2 bg-[#F4F7FC] border border-slate-200 rounded-xl text-xs text-[#15213B] placeholder-[#5C6B85] focus:outline-hidden focus:ring-2 focus:ring-[#6D28D9] focus:bg-white transition"
                            />
                        </form>
                    </div>
                </div>

                {/* PAYMENTS TABLE */}
                <div className="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left text-xs text-[#5C6B85] tabular-nums">
                            <thead className="bg-[#F4F7FC] border-b border-slate-200 text-[#5C6B85] font-bold uppercase tracking-wider text-[11px]">
                                <tr>
                                    <th className="py-3.5 px-4">Referencia / Orden</th>
                                    <th className="py-3.5 px-4">Clínica veterinaria</th>
                                    <th className="py-3.5 px-4">Monto cobrado</th>
                                    <th className="py-3.5 px-4">Medio de pago</th>
                                    <th className="py-3.5 px-4">Período cobertura</th>
                                    <th className="py-3.5 px-4">Estado</th>
                                    <th className="py-3.5 px-4 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100">
                                {visiblePayments.length === 0 ? (
                                    <tr>
                                        <td colSpan={7} className="text-center py-12 text-[#5C6B85]">
                                            <CreditCard className="w-10 h-10 mx-auto text-slate-300 mb-2" />
                                            No se encontraron transacciones con los filtros actuales.
                                        </td>
                                    </tr>
                                ) : (
                                    visiblePayments.map((item) => (
                                        <tr key={item.id} className="hover:bg-[#F4F7FC]/70 transition-colors">
                                            <td className="py-3.5 px-4">
                                                <div className="font-mono font-bold text-[#15213B]">{item.order_id}</div>
                                                <div className="text-[11px] text-[#5C6B85]">
                                                    {item.paid_at || item.created_at}
                                                </div>
                                            </td>

                                            <td className="py-3.5 px-4">
                                                <div className="font-bold text-[#15213B] flex items-center gap-1.5">
                                                    <Building2 className="w-3.5 h-3.5 text-[#0E7490] shrink-0" />
                                                    <span>{item.tenant_name}</span>
                                                </div>
                                                <div className="text-[11px] text-[#5C6B85] mt-0.5">
                                                    {item.payer_email || `${item.tenant_slug}@avipetapp.com`}
                                                </div>
                                            </td>

                                            <td className="py-3.5 px-4">
                                                <div className="font-bold text-[#15213B] text-sm">
                                                    {formatCurrency(item.amount)}
                                                </div>
                                                <div className="text-[10px] uppercase font-bold text-[#0E7490]">
                                                    {getPlanLabel(item.plan_tier)}
                                                </div>
                                            </td>

                                            <td className="py-3.5 px-4">{getGatewayBadge(item.gateway)}</td>

                                            <td className="py-3.5 px-4">
                                                <div className="flex items-center gap-1.5 text-[#15213B]">
                                                    <Calendar className="w-3.5 h-3.5 text-[#5C6B85]" />
                                                    <span>
                                                        {item.period_start || 'N/A'} – {item.period_end || 'N/A'}
                                                    </span>
                                                </div>
                                            </td>

                                            <td className="py-3.5 px-4">{getStatusBadge(item.status)}</td>

                                            <td className="py-3.5 px-4 text-right">
                                                <button
                                                    onClick={() => openEditModal(item)}
                                                    className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-[#6D28D9] bg-white border border-[#6D28D9]/40 hover:bg-[#F4F7FC] transition cursor-pointer"
                                                >
                                                    <Settings2 className="w-3.5 h-3.5" />
                                                    <span>Gestionar</span>
                                                </button>
                                            </td>
                                        </tr>
                                    ))
                                )}
                            </tbody>
                        </table>
                    </div>

                    {/* PAGINATION */}
                    {payments.last_page > 1 && (
                        <div className="p-4 border-t border-slate-200 flex items-center justify-between">
                            <span className="text-xs text-[#5C6B85]">
                                Página {payments.current_page} de {payments.last_page} ({payments.total} registros)
                            </span>
                            <div className="flex items-center gap-2">
                                {payments.prev_page_url && (
                                    <button
                                        onClick={() => router.get(payments.prev_page_url!)}
                                        className="p-1.5 rounded-lg border border-slate-200 hover:bg-[#F4F7FC] text-[#15213B] cursor-pointer"
                                    >
                                        <ChevronLeft className="w-4 h-4" />
                                    </button>
                                )}
                                {payments.next_page_url && (
                                    <button
                                        onClick={() => router.get(payments.next_page_url!)}
                                        className="p-1.5 rounded-lg border border-slate-200 hover:bg-[#F4F7FC] text-[#15213B] cursor-pointer"
                                    >
                                        <ChevronRight className="w-4 h-4" />
                                    </button>
                                )}
                            </div>
                        </div>
                    )}
                </div>

                {/* MODAL 1: REGISTRAR PAGO MANUAL */}
                {isCreateModalOpen && (
                    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#080B20]/60 backdrop-blur-xs overflow-y-auto">
                        <div className="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 space-y-4">
                            <div className="flex items-center justify-between border-b border-slate-100 pb-3">
                                <h3 className="text-lg font-bold text-[#15213B] flex items-center gap-2">
                                    <CreditCard className="w-5 h-5 text-[#6D28D9]" />
                                    <span>Registrar pago SaaS manual</span>
                                </h3>
                                <button
                                    onClick={() => setIsCreateModalOpen(false)}
                                    className="p-1 rounded-lg text-[#5C6B85] hover:text-[#15213B] hover:bg-slate-100 cursor-pointer"
                                >
                                    <X className="w-5 h-5" />
                                </button>
                            </div>

                            <form onSubmit={handleSubmitPayment} className="space-y-3.5 text-xs">
                                <div>
                                    <label className="block font-semibold text-[#15213B] mb-1">
                                        Clínica veterinaria
                                    </label>
                                    <select
                                        value={formPayment.tenant_id}
                                        onChange={(e) => {
                                            const found = tenantsList.find((t) => t.id === e.target.value);
                                            setFormPayment({
                                                ...formPayment,
                                                tenant_id: e.target.value,
                                                amount: found?.default_fee ? String(found.default_fee) : formPayment.amount,
                                                plan_tier: found?.default_plan || formPayment.plan_tier
                                            });
                                        }}
                                        className="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-[#15213B] focus:outline-hidden focus:ring-2 focus:ring-[#6D28D9]"
                                        required
                                    >
                                        {tenantsList.map((t) => (
                                            <option key={t.id} value={t.id}>
                                                {t.name} ({t.slug}.avipetapp.com)
                                            </option>
                                        ))}
                                    </select>
                                </div>

                                <div className="grid grid-cols-2 gap-3">
                                    <div>
                                        <label className="block font-semibold text-[#15213B] mb-1">Monto (COP)</label>
                                        <input
                                            type="number"
                                            value={formPayment.amount}
                                            onChange={(e) =>
                                                setFormPayment({ ...formPayment, amount: e.target.value })
                                            }
                                            className="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-[#15213B] tabular-nums font-semibold focus:outline-hidden focus:ring-2 focus:ring-[#6D28D9]"
                                            required
                                        />
                                    </div>

                                    <div>
                                        <label className="block font-semibold text-[#15213B] mb-1">
                                            Medio / Pasarela
                                        </label>
                                        <select
                                            value={formPayment.gateway}
                                            onChange={(e) =>
                                                setFormPayment({ ...formPayment, gateway: e.target.value })
                                            }
                                            className="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-[#15213B] focus:outline-hidden focus:ring-2 focus:ring-[#6D28D9]"
                                        >
                                            <option value="bold">Bold / PSE / Tarjeta</option>
                                            <option value="nequi">Nequi / Daviplata</option>
                                            <option value="bancolombia">Bancolombia</option>
                                            <option value="cash">Efectivo / Directo</option>
                                            <option value="manual">Ajuste manual</option>
                                        </select>
                                    </div>
                                </div>

                                <div className="grid grid-cols-2 gap-3">
                                    <div>
                                        <label className="block font-semibold text-[#15213B] mb-1">Nivel de plan</label>
                                        <select
                                            value={formPayment.plan_tier}
                                            onChange={(e) => {
                                                const plan = e.target.value;
                                                const fee =
                                                    plan === 'starter'
                                                        ? '99000'
                                                        : plan === 'pro'
                                                        ? '229000'
                                                        : plan === 'enterprise'
                                                        ? '489000'
                                                        : '50000';
                                                setFormPayment({
                                                    ...formPayment,
                                                    plan_tier: plan,
                                                    amount: fee
                                                });
                                            }}
                                            className="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-[#15213B] focus:outline-hidden focus:ring-2 focus:ring-[#6D28D9]"
                                        >
                                            <option value="pay_per_pet">Paquete 10 mascotas ($50.000)</option>
                                            <option value="starter">Starter ($99.000/mes)</option>
                                            <option value="pro">Profesional ($229.000/mes)</option>
                                            <option value="enterprise">Enterprise ($489.000/mes)</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label className="block font-semibold text-[#15213B] mb-1">Estado</label>
                                        <select
                                            value={formPayment.status}
                                            onChange={(e) =>
                                                setFormPayment({ ...formPayment, status: e.target.value })
                                            }
                                            className="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-[#15213B] focus:outline-hidden focus:ring-2 focus:ring-[#6D28D9]"
                                        >
                                            <option value="approved">Aprobado (Activa 30 días)</option>
                                            <option value="pending">Pendiente</option>
                                            <option value="failed">Fallido</option>
                                        </select>
                                    </div>
                                </div>

                                <div className="grid grid-cols-2 gap-3">
                                    <div>
                                        <label className="block font-semibold text-[#15213B] mb-1">
                                            Inicio cobertura
                                        </label>
                                        <input
                                            type="date"
                                            value={formPayment.period_start}
                                            onChange={(e) =>
                                                setFormPayment({ ...formPayment, period_start: e.target.value })
                                            }
                                            className="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-[#15213B] focus:outline-hidden focus:ring-2 focus:ring-[#6D28D9]"
                                        />
                                    </div>

                                    <div>
                                        <label className="block font-semibold text-[#15213B] mb-1">
                                            Fin cobertura
                                        </label>
                                        <input
                                            type="date"
                                            value={formPayment.period_end}
                                            onChange={(e) =>
                                                setFormPayment({ ...formPayment, period_end: e.target.value })
                                            }
                                            className="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-[#15213B] focus:outline-hidden focus:ring-2 focus:ring-[#6D28D9]"
                                        />
                                    </div>
                                </div>

                                <div>
                                    <label className="block font-semibold text-[#15213B] mb-1">
                                        Notas / Comprobante
                                    </label>
                                    <textarea
                                        value={formPayment.notes}
                                        onChange={(e) =>
                                            setFormPayment({ ...formPayment, notes: e.target.value })
                                        }
                                        placeholder="Referencia bancaria, comprobante Nequi o detalle..."
                                        rows={2}
                                        className="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-[#15213B] focus:outline-hidden focus:ring-2 focus:ring-[#6D28D9]"
                                    />
                                </div>

                                <div className="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                                    <button
                                        type="button"
                                        onClick={() => setIsCreateModalOpen(false)}
                                        className="px-4 py-2 rounded-xl text-xs font-semibold text-[#6D28D9] border border-[#6D28D9] hover:bg-[#6D28D9]/5 cursor-pointer"
                                    >
                                        Cancelar
                                    </button>
                                    <button
                                        type="submit"
                                        disabled={submittingCreate}
                                        className="px-5 py-2 rounded-xl text-xs font-semibold bg-[#6D28D9] hover:bg-[#5B21B6] text-white shadow-xs cursor-pointer disabled:opacity-60"
                                    >
                                        {submittingCreate ? 'Guardando...' : 'Guardar'}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                )}

                {/* MODAL 2: GESTIONAR / EDITAR / ELIMINAR ORDEN DE PAGO */}
                {editingPayment && (
                    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#080B20]/60 backdrop-blur-xs overflow-y-auto">
                        <div className="bg-white rounded-2xl max-w-xl w-full p-6 shadow-2xl border border-slate-200 space-y-4 my-8">
                            <div className="flex items-start justify-between border-b border-slate-100 pb-3">
                                <div>
                                    <h3 className="text-base font-bold text-[#15213B] flex items-center gap-2">
                                        <FileText className="w-5 h-5 text-[#6D28D9]" />
                                        <span>Orden: {editingPayment.order_id}</span>
                                    </h3>
                                    <p className="text-xs text-[#5C6B85] mt-0.5">
                                        {editingPayment.tenant_name} · ID transacción:{' '}
                                        {editingPayment.transaction_id || 'Manual'}
                                    </p>
                                </div>
                                <button
                                    onClick={() => setEditingPayment(null)}
                                    className="p-1 rounded-lg text-[#5C6B85] hover:text-[#15213B] hover:bg-slate-100 cursor-pointer"
                                >
                                    <X className="w-5 h-5" />
                                </button>
                            </div>

                            <form onSubmit={handleUpdatePayment} className="space-y-4 text-xs">
                                <div className="grid grid-cols-2 sm:grid-cols-3 gap-3 p-3.5 bg-[#F4F7FC] rounded-xl border border-slate-200/80">
                                    <div>
                                        <label className="block font-semibold text-[#15213B] mb-1">Estado</label>
                                        <select
                                            value={editForm.status}
                                            onChange={(e) =>
                                                setEditForm({ ...editForm, status: e.target.value })
                                            }
                                            className="w-full p-2 border border-slate-200 rounded-lg bg-white font-semibold text-[#15213B] focus:ring-2 focus:ring-[#6D28D9] outline-hidden"
                                        >
                                            <option value="approved">Aprobado</option>
                                            <option value="pending">Pendiente</option>
                                            <option value="failed">Fallido</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label className="block font-semibold text-[#15213B] mb-1">
                                            Monto (COP)
                                        </label>
                                        <input
                                            type="number"
                                            value={editForm.amount}
                                            onChange={(e) =>
                                                setEditForm({ ...editForm, amount: e.target.value })
                                            }
                                            className="w-full p-2 border border-slate-200 rounded-lg bg-white font-bold tabular-nums text-[#15213B] focus:ring-2 focus:ring-[#6D28D9] outline-hidden"
                                        />
                                    </div>

                                    <div className="col-span-2 sm:col-span-1">
                                        <label className="block font-semibold text-[#15213B] mb-1">
                                            Pasarela / Medio
                                        </label>
                                        <select
                                            value={editForm.gateway}
                                            onChange={(e) =>
                                                setEditForm({ ...editForm, gateway: e.target.value })
                                            }
                                            className="w-full p-2 border border-slate-200 rounded-lg bg-white text-[#15213B] focus:ring-2 focus:ring-[#6D28D9] outline-hidden"
                                        >
                                            <option value="bold">Bold / PSE</option>
                                            <option value="nequi">Nequi / Daviplata</option>
                                            <option value="bancolombia">Bancolombia</option>
                                            <option value="cash">Efectivo</option>
                                            <option value="manual">Manual</option>
                                        </select>
                                    </div>
                                </div>

                                <div className="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <div>
                                        <label className="block font-semibold text-[#15213B] mb-1">Plan SaaS</label>
                                        <select
                                            value={editForm.plan_tier}
                                            onChange={(e) =>
                                                setEditForm({ ...editForm, plan_tier: e.target.value })
                                            }
                                            className="w-full p-2.5 border border-slate-200 rounded-xl bg-white text-[#15213B] focus:ring-2 focus:ring-[#6D28D9] outline-hidden"
                                        >
                                            <option value="pay_per_pet">Por mascota ($50k)</option>
                                            <option value="starter">Starter ($99k)</option>
                                            <option value="pro">Profesional ($229k)</option>
                                            <option value="enterprise">Enterprise ($489k)</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label className="block font-semibold text-[#15213B] mb-1">
                                            Inicio cobertura
                                        </label>
                                        <input
                                            type="date"
                                            value={editForm.period_start}
                                            onChange={(e) =>
                                                setEditForm({ ...editForm, period_start: e.target.value })
                                            }
                                            className="w-full p-2.5 border border-slate-200 rounded-xl bg-white text-[#15213B] focus:ring-2 focus:ring-[#6D28D9] outline-hidden"
                                        />
                                    </div>

                                    <div>
                                        <label className="block font-semibold text-[#15213B] mb-1">
                                            Fin cobertura
                                        </label>
                                        <input
                                            type="date"
                                            value={editForm.period_end}
                                            onChange={(e) =>
                                                setEditForm({ ...editForm, period_end: e.target.value })
                                            }
                                            className="w-full p-2.5 border border-slate-200 rounded-xl bg-white text-[#15213B] focus:ring-2 focus:ring-[#6D28D9] outline-hidden"
                                        />
                                    </div>
                                </div>

                                <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label className="block font-semibold text-[#15213B] mb-1">
                                            Correo registrado del pagador
                                        </label>
                                        <input
                                            type="email"
                                            value={editForm.payer_email}
                                            onChange={(e) =>
                                                setEditForm({ ...editForm, payer_email: e.target.value })
                                            }
                                            placeholder="correo@clinica.com"
                                            className="w-full p-2.5 border border-slate-200 rounded-xl bg-white text-[#15213B] focus:ring-2 focus:ring-[#6D28D9] outline-hidden"
                                        />
                                    </div>

                                    <div>
                                        <label className="block font-semibold text-[#15213B] mb-1">
                                            Notas / Soporte
                                        </label>
                                        <input
                                            type="text"
                                            value={editForm.notes}
                                            onChange={(e) =>
                                                setEditForm({ ...editForm, notes: e.target.value })
                                            }
                                            placeholder="Observaciones del cobro..."
                                            className="w-full p-2.5 border border-slate-200 rounded-xl bg-white text-[#15213B] focus:ring-2 focus:ring-[#6D28D9] outline-hidden"
                                        />
                                    </div>
                                </div>

                                {/* Zona Eliminar Registro */}
                                <div className="p-3.5 rounded-xl bg-[#B91C1C]/5 border border-[#B91C1C]/20 flex items-center justify-between gap-3">
                                    <span className="text-[11px] text-[#5C6B85]">
                                        ¿Deseas eliminar este registro del historial de cobros?
                                    </span>

                                    {confirmDeleteId === editingPayment.id ? (
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
                                                onClick={() => handleDeletePayment(editingPayment.id)}
                                                className="px-3 py-1.5 bg-[#B91C1C] hover:bg-[#991B1B] text-white rounded-lg font-semibold text-xs transition"
                                            >
                                                {submittingDelete ? 'Eliminando...' : 'Confirmar Eliminar'}
                                            </button>
                                        </div>
                                    ) : (
                                        <button
                                            type="button"
                                            onClick={() => setConfirmDeleteId(editingPayment.id)}
                                            className="inline-flex items-center gap-1 px-3 py-1.5 bg-[#B91C1C] hover:bg-[#991B1B] text-white rounded-lg font-semibold text-xs shrink-0 transition"
                                        >
                                            <Trash2 className="w-3.5 h-3.5" />
                                            <span>Eliminar</span>
                                        </button>
                                    )}
                                </div>

                                <div className="flex items-center justify-between pt-3 border-t border-slate-100">
                                    <div>
                                        {editingPayment.payer_phone && (
                                            <a
                                                href={`https://wa.me/57${editingPayment.payer_phone.replace(
                                                    /[^0-9]/g,
                                                    ''
                                                )}?text=${encodeURIComponent(
                                                    `Hola ${editingPayment.tenant_name}, confirmamos la recepción de tu pago SaaS en AviPetApp (${editingPayment.order_id}) por ${formatCurrency(
                                                        Number(editForm.amount)
                                                    )}.`
                                                )}`}
                                                target="_blank"
                                                rel="noreferrer"
                                                className="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-[#0F9F9A] hover:bg-[#0F9F9A]/10 rounded-xl transition"
                                            >
                                                <MessageCircle className="w-4 h-4" />
                                                <span>Enviar recibo WhatsApp</span>
                                            </a>
                                        )}
                                    </div>

                                    <div className="flex items-center gap-2.5">
                                        <button
                                            type="button"
                                            onClick={() => setEditingPayment(null)}
                                            className="px-4 py-2 rounded-xl text-xs font-semibold text-[#6D28D9] border border-[#6D28D9] hover:bg-[#6D28D9]/5 cursor-pointer"
                                        >
                                            Cancelar
                                        </button>
                                        <button
                                            type="submit"
                                            disabled={submittingUpdate}
                                            className="px-5 py-2 rounded-xl text-xs font-semibold bg-[#6D28D9] hover:bg-[#5B21B6] text-white shadow-xs cursor-pointer disabled:opacity-60"
                                        >
                                            {submittingUpdate ? 'Guardando...' : 'Guardar'}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                )}
            </div>
        </SuperAdminLayout>
    );
}
