import React, { useState } from 'react';
import { Head, router } from '@inertiajs/react';
import SuperAdminLayout from '@/Layouts/SuperAdminLayout';
import { 
    CreditCard, 
    Search, 
    Plus, 
    Filter, 
    CheckCircle2, 
    Clock, 
    AlertTriangle, 
    Building2, 
    Calendar, 
    DollarSign, 
    FileText, 
    ArrowUpRight, 
    X,
    ExternalLink,
    ChevronLeft,
    ChevronRight,
    TrendingUp,
    ShieldCheck
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
    notes: string | null;
    paid_at: string | null;
    created_at: string | null;
}

interface TenantOption {
    id: string;
    name: string;
    slug: string;
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
        mrr: number;
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
    userEmail = 'superadmin@avipetapp.com'
}: PaymentsProps) {
    const [searchTerm, setSearchTerm] = useState(filters.search || '');
    const [selectedStatus, setSelectedStatus] = useState(filters.status || 'all');
    const [selectedGateway, setSelectedGateway] = useState(filters.gateway || 'all');
    const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
    const [selectedPaymentDetail, setSelectedPaymentDetail] = useState<PaymentItem | null>(null);

    const [formPayment, setFormPayment] = useState({
        tenant_id: tenantsList[0]?.id || '',
        amount: '99000',
        gateway: 'bold',
        plan_tier: 'pro',
        status: 'approved',
        period_start: new Date().toISOString().split('T')[0],
        period_end: new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toISOString().split('T')[0],
        notes: ''
    });

    const formatCurrency = (val: number) => {
        return new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            maximumFractionDigits: 0
        }).format(val);
    };

    const handleSearch = (e: React.FormEvent) => {
        e.preventDefault();
        router.get('/super-admin/saas-payment-logs', {
            search: searchTerm,
            status: selectedStatus,
            gateway: selectedGateway
        }, { preserveState: true });
    };

    const handleFilterStatus = (status: string) => {
        setSelectedStatus(status);
        router.get('/super-admin/saas-payment-logs', {
            search: searchTerm,
            status,
            gateway: selectedGateway
        }, { preserveState: true });
    };

    const handleFilterGateway = (gateway: string) => {
        setSelectedGateway(gateway);
        router.get('/super-admin/saas-payment-logs', {
            search: searchTerm,
            status: selectedStatus,
            gateway
        }, { preserveState: true });
    };

    const handleSubmitPayment = (e: React.FormEvent) => {
        e.preventDefault();
        router.post('/super-admin/saas-payment-logs', formPayment, {
            onSuccess: () => {
                setIsCreateModalOpen(false);
                setFormPayment({
                    tenant_id: tenantsList[0]?.id || '',
                    amount: '99000',
                    gateway: 'bold',
                    plan_tier: 'pro',
                    status: 'approved',
                    period_start: new Date().toISOString().split('T')[0],
                    period_end: new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toISOString().split('T')[0],
                    notes: ''
                });
            }
        });
    };

    const getStatusBadge = (status: string) => {
        switch (status) {
            case 'approved':
                return (
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <CheckCircle2 className="w-3.5 h-3.5 text-emerald-600" />
                        Aprobado
                    </span>
                );
            case 'pending':
                return (
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                        <Clock className="w-3.5 h-3.5 text-amber-600" />
                        Pendiente
                    </span>
                );
            case 'failed':
                return (
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                        <AlertTriangle className="w-3.5 h-3.5 text-rose-600" />
                        Fallido
                    </span>
                );
            default:
                return (
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                        {status}
                    </span>
                );
        }
    };

    const getGatewayBadge = (gateway: string) => {
        switch (gateway) {
            case 'bold':
                return (
                    <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-teal-50 text-teal-700 border border-teal-200">
                        💳 Bold (PSE / Tarjeta)
                    </span>
                );
            case 'nequi':
                return (
                    <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-purple-50 text-purple-700 border border-purple-200">
                        📱 Nequi / Daviplata
                    </span>
                );
            case 'bancolombia':
                return (
                    <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-yellow-50 text-yellow-800 border border-yellow-200">
                        🏦 Bancolombia
                    </span>
                );
            case 'cash':
                return (
                    <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        💵 Efectivo
                    </span>
                );
            default:
                return (
                    <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                        ⚙️ {gateway}
                    </span>
                );
        }
    };

    return (
        <SuperAdminLayout
            userName={userName}
            userEmail={userEmail}
            activeItem="Suscripciones y pagos"
        >
            <Head title="Suscripciones y Pagos SaaS - SuperAdmin" />

            <div className="space-y-6 max-w-full">
                {/* HEADER */}
                <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 className="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                            <CreditCard className="w-7 h-7 text-teal-600" />
                            Suscripciones y Recaudo SaaS
                        </h1>
                        <p className="text-sm text-slate-500 mt-1">
                            Auditoría de cobros mensuales a clínicas veterinarias, pasarela Bold y conciliación de suscripciones.
                        </p>
                    </div>

                    <button
                        onClick={() => setIsCreateModalOpen(true)}
                        className="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white font-bold text-sm shadow-sm transition-all shadow-teal-600/20 hover:shadow-teal-600/30 self-start sm:self-auto cursor-pointer"
                    >
                        <Plus className="w-4 h-4" />
                        Registrar Pago Manual
                    </button>
                </div>

                {/* 4 SUMMARY STAT CARDS */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div className="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
                        <div>
                            <span className="text-xs font-semibold uppercase tracking-wider text-slate-500">Recaudo Total Histórico</span>
                            <div className="text-2xl font-black text-slate-900 mt-1">{formatCurrency(stats.totalRecaudado)}</div>
                            <div className="text-xs font-medium text-emerald-600 flex items-center gap-1 mt-1">
                                <CheckCircle2 className="w-3.5 h-3.5" />
                                {stats.aprobadosCount} transacciones aprobadas
                            </div>
                        </div>
                        <div className="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                            <DollarSign className="w-6 h-6" />
                        </div>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
                        <div>
                            <span className="text-xs font-semibold uppercase tracking-wider text-slate-500">MRR Mensual SaaS</span>
                            <div className="text-2xl font-black text-teal-600 mt-1">{formatCurrency(stats.mrr)}</div>
                            <div className="text-xs font-medium text-slate-500 mt-1">
                                Ingreso recurrente estimado
                            </div>
                        </div>
                        <div className="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                            <TrendingUp className="w-6 h-6" />
                        </div>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
                        <div>
                            <span className="text-xs font-semibold uppercase tracking-wider text-slate-500">Cobros Pendientes</span>
                            <div className="text-2xl font-black text-amber-600 mt-1">{formatCurrency(stats.pendientesMonto)}</div>
                            <div className="text-xs font-medium text-amber-600 flex items-center gap-1 mt-1">
                                <Clock className="w-3.5 h-3.5" />
                                {stats.pendientesCount} órdenes en trámite
                            </div>
                        </div>
                        <div className="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                            <Clock className="w-6 h-6" />
                        </div>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
                        <div>
                            <span className="text-xs font-semibold uppercase tracking-wider text-slate-500">Seguridad Bold</span>
                            <div className="text-lg font-black text-slate-900 mt-1">100% Tokenizado</div>
                            <div className="text-xs font-medium text-emerald-600 flex items-center gap-1 mt-1">
                                <ShieldCheck className="w-3.5 h-3.5" />
                                Webhooks activos
                            </div>
                        </div>
                        <div className="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                            <ShieldCheck className="w-6 h-6" />
                        </div>
                    </div>
                </div>

                {/* FILTERS & SEARCH BAR */}
                <div className="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs flex flex-col md:flex-row gap-4 justify-between items-stretch md:items-center">
                    {/* Status Tabs */}
                    <div className="flex items-center gap-1 overflow-x-auto pb-1 md:pb-0 scrollbar-none">
                        <button
                            type="button"
                            onClick={() => handleFilterStatus('all')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                                selectedStatus === 'all'
                                    ? 'bg-teal-600 text-white shadow-xs'
                                    : 'text-slate-600 hover:bg-slate-100'
                            }`}
                        >
                            Todos ({payments.total})
                        </button>
                        <button
                            type="button"
                            onClick={() => handleFilterStatus('approved')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                                selectedStatus === 'approved'
                                    ? 'bg-emerald-600 text-white shadow-xs'
                                    : 'text-slate-600 hover:bg-slate-100'
                            }`}
                        >
                            Aprobados
                        </button>
                        <button
                            type="button"
                            onClick={() => handleFilterStatus('pending')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                                selectedStatus === 'pending'
                                    ? 'bg-amber-600 text-white shadow-xs'
                                    : 'text-slate-600 hover:bg-slate-100'
                            }`}
                        >
                            Pendientes
                        </button>
                        <button
                            type="button"
                            onClick={() => handleFilterStatus('failed')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                                selectedStatus === 'failed'
                                    ? 'bg-rose-600 text-white shadow-xs'
                                    : 'text-slate-600 hover:bg-slate-100'
                            }`}
                        >
                            Fallidos
                        </button>
                    </div>

                    {/* Search & Gateway Filter */}
                    <div className="flex items-center gap-2">
                        <select
                            value={selectedGateway}
                            onChange={(e) => handleFilterGateway(e.target.value)}
                            className="text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-500"
                        >
                            <option value="all">Todas las pasarelas</option>
                            <option value="bold">Bold (PSE / Tarjeta)</option>
                            <option value="nequi">Nequi</option>
                            <option value="bancolombia">Bancolombia</option>
                            <option value="cash">Efectivo</option>
                            <option value="manual">Manual</option>
                        </select>

                        <form onSubmit={handleSearch} className="relative flex-1 sm:w-64">
                            <Search className="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
                            <input
                                type="text"
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                                placeholder="Buscar orden o clínica..."
                                className="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500"
                            />
                        </form>
                    </div>
                </div>

                {/* PAYMENTS TABLE */}
                <div className="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left text-xs text-slate-600">
                            <thead className="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[11px]">
                                <tr>
                                    <th className="py-3.5 px-4">Referencia / Orden</th>
                                    <th className="py-3.5 px-4">Clínica Veterinaria</th>
                                    <th className="py-3.5 px-4">Monto Cobrado</th>
                                    <th className="py-3.5 px-4">Medio de Pago</th>
                                    <th className="py-3.5 px-4">Período Cobertura</th>
                                    <th className="py-3.5 px-4">Estado</th>
                                    <th className="py-3.5 px-4 text-right">Detalle</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100">
                                {payments.data.length === 0 ? (
                                    <tr>
                                        <td colSpan={7} className="text-center py-12 text-slate-400">
                                            <CreditCard className="w-10 h-10 mx-auto text-slate-300 mb-2" />
                                            No se encontraron transacciones con los filtros actuales.
                                        </td>
                                    </tr>
                                ) : (
                                    payments.data.map((item) => (
                                        <tr key={item.id} className="hover:bg-slate-50/70 transition-colors">
                                            <td className="py-3.5 px-4">
                                                <div className="font-mono font-bold text-slate-900">{item.order_id}</div>
                                                <div className="text-[11px] text-slate-400">{item.paid_at || item.created_at}</div>
                                            </td>

                                            <td className="py-3.5 px-4">
                                                <div className="font-bold text-slate-900 flex items-center gap-1.5">
                                                    <Building2 className="w-3.5 h-3.5 text-teal-600 shrink-0" />
                                                    {item.tenant_name}
                                                </div>
                                                <div className="text-[11px] text-slate-400">{item.payer_email || 'Sin correo registrado'}</div>
                                            </td>

                                            <td className="py-3.5 px-4">
                                                <div className="font-black text-slate-900 text-sm">{formatCurrency(item.amount)}</div>
                                                <div className="text-[10px] uppercase font-bold text-teal-600">Plan {item.plan_tier}</div>
                                            </td>

                                            <td className="py-3.5 px-4">
                                                {getGatewayBadge(item.gateway)}
                                            </td>

                                            <td className="py-3.5 px-4">
                                                <div className="flex items-center gap-1 text-slate-700">
                                                    <Calendar className="w-3 h-3 text-slate-400" />
                                                    <span>{item.period_start || 'N/A'} - {item.period_end || 'N/A'}</span>
                                                </div>
                                            </td>

                                            <td className="py-3.5 px-4">
                                                {getStatusBadge(item.status)}
                                            </td>

                                            <td className="py-3.5 px-4 text-right">
                                                <button
                                                    onClick={() => setSelectedPaymentDetail(item)}
                                                    className="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold text-teal-700 bg-teal-50 hover:bg-teal-100 transition-colors cursor-pointer"
                                                >
                                                    <FileText className="w-3.5 h-3.5" />
                                                    Ver
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
                            <span className="text-xs text-slate-500">
                                Página {payments.current_page} de {payments.last_page} ({payments.total} registros)
                            </span>
                            <div className="flex items-center gap-2">
                                {payments.prev_page_url && (
                                    <button
                                        onClick={() => router.get(payments.prev_page_url!)}
                                        className="p-1.5 rounded-lg border border-slate-200 hover:bg-slate-100 text-slate-600 cursor-pointer"
                                    >
                                        <ChevronLeft className="w-4 h-4" />
                                    </button>
                                )}
                                {payments.next_page_url && (
                                    <button
                                        onClick={() => router.get(payments.next_page_url!)}
                                        className="p-1.5 rounded-lg border border-slate-200 hover:bg-slate-100 text-slate-600 cursor-pointer"
                                    >
                                        <ChevronRight className="w-4 h-4" />
                                    </button>
                                )}
                            </div>
                        </div>
                    )}
                </div>

                {/* MODAL: REGISTRAR PAGO MANUAL */}
                {isCreateModalOpen && (
                    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
                        <div className="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl space-y-4 animate-in fade-in zoom-in-95 duration-150">
                            <div className="flex items-center justify-between border-b border-slate-100 pb-3">
                                <h3 className="text-lg font-bold text-slate-900 flex items-center gap-2">
                                    <CreditCard className="w-5 h-5 text-teal-600" />
                                    Registrar Pago SaaS Manual
                                </h3>
                                <button
                                    onClick={() => setIsCreateModalOpen(false)}
                                    className="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 cursor-pointer"
                                >
                                    <X className="w-5 h-5" />
                                </button>
                            </div>

                            <form onSubmit={handleSubmitPayment} className="space-y-3.5">
                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">Clínica Veterinaria</label>
                                    <select
                                        value={formPayment.tenant_id}
                                        onChange={(e) => setFormPayment({ ...formPayment, tenant_id: e.target.value })}
                                        className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                        required
                                    >
                                        {tenantsList.map((t) => (
                                            <option key={t.id} value={t.id}>{t.name} ({t.slug})</option>
                                        ))}
                                    </select>
                                </div>

                                <div className="grid grid-cols-2 gap-3">
                                    <div>
                                        <label className="block text-xs font-bold text-slate-700 mb-1">Monto (COP)</label>
                                        <input
                                            type="number"
                                            value={formPayment.amount}
                                            onChange={(e) => setFormPayment({ ...formPayment, amount: e.target.value })}
                                            className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                            required
                                        />
                                    </div>

                                    <div>
                                        <label className="block text-xs font-bold text-slate-700 mb-1">Medio / Pasarela</label>
                                        <select
                                            value={formPayment.gateway}
                                            onChange={(e) => setFormPayment({ ...formPayment, gateway: e.target.value })}
                                            className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                        >
                                            <option value="bold">💳 Pasarela Bold</option>
                                            <option value="nequi">📱 Nequi / Daviplata</option>
                                            <option value="bancolombia">🏦 Bancolombia</option>
                                            <option value="cash">💵 Efectivo / Directo</option>
                                            <option value="manual">⚙️ Ajuste Manual</option>
                                        </select>
                                    </div>
                                </div>

                                <div className="grid grid-cols-2 gap-3">
                                    <div>
                                        <label className="block text-xs font-bold text-slate-700 mb-1">Nivel de Plan</label>
                                        <select
                                            value={formPayment.plan_tier}
                                            onChange={(e) => setFormPayment({ ...formPayment, plan_tier: e.target.value })}
                                            className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                        >
                                            <option value="starter">Starter</option>
                                            <option value="pro">Profesional</option>
                                            <option value="enterprise">Enterprise</option>
                                            <option value="pay_per_pet">Por Mascota</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label className="block text-xs font-bold text-slate-700 mb-1">Estado</label>
                                        <select
                                            value={formPayment.status}
                                            onChange={(e) => setFormPayment({ ...formPayment, status: e.target.value })}
                                            className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                        >
                                            <option value="approved">✅ Aprobado</option>
                                            <option value="pending">⏳ Pendiente</option>
                                            <option value="failed">❌ Fallido</option>
                                        </select>
                                    </div>
                                </div>

                                <div className="grid grid-cols-2 gap-3">
                                    <div>
                                        <label className="block text-xs font-bold text-slate-700 mb-1">Inicio Cobertura</label>
                                        <input
                                            type="date"
                                            value={formPayment.period_start}
                                            onChange={(e) => setFormPayment({ ...formPayment, period_start: e.target.value })}
                                            className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                        />
                                    </div>

                                    <div>
                                        <label className="block text-xs font-bold text-slate-700 mb-1">Fin Cobertura</label>
                                        <input
                                            type="date"
                                            value={formPayment.period_end}
                                            onChange={(e) => setFormPayment({ ...formPayment, period_end: e.target.value })}
                                            className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                        />
                                    </div>
                                </div>

                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">Notas / Observaciones</label>
                                    <textarea
                                        value={formPayment.notes}
                                        onChange={(e) => setFormPayment({ ...formPayment, notes: e.target.value })}
                                        placeholder="Detalles de la consignación o soporte..."
                                        rows={2}
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
                                        Registrar Pago
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                )}

                {/* MODAL: DETALLE DE PAGO */}
                {selectedPaymentDetail && (
                    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
                        <div className="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl space-y-4 animate-in fade-in zoom-in-95 duration-150">
                            <div className="flex items-center justify-between border-b border-slate-100 pb-3">
                                <div>
                                    <h3 className="text-base font-bold text-slate-900 flex items-center gap-2">
                                        <FileText className="w-5 h-5 text-teal-600" />
                                        Orden: {selectedPaymentDetail.order_id}
                                    </h3>
                                    <p className="text-xs text-slate-500">ID BD: {selectedPaymentDetail.id}</p>
                                </div>
                                <button
                                    onClick={() => setSelectedPaymentDetail(null)}
                                    className="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 cursor-pointer"
                                >
                                    <X className="w-5 h-5" />
                                </button>
                            </div>

                            <div className="space-y-3 text-xs">
                                <div className="grid grid-cols-2 gap-3 p-3 bg-slate-50 rounded-xl">
                                    <div>
                                        <span className="text-slate-400 block text-[10px] uppercase font-bold">Clínica</span>
                                        <span className="font-bold text-slate-800">{selectedPaymentDetail.tenant_name}</span>
                                    </div>
                                    <div>
                                        <span className="text-slate-400 block text-[10px] uppercase font-bold">Monto</span>
                                        <span className="font-black text-slate-900 text-sm">{formatCurrency(selectedPaymentDetail.amount)}</span>
                                    </div>
                                    <div>
                                        <span className="text-slate-400 block text-[10px] uppercase font-bold">Pasarela</span>
                                        <span className="font-medium text-slate-700">{selectedPaymentDetail.gateway}</span>
                                    </div>
                                    <div>
                                        <span className="text-slate-400 block text-[10px] uppercase font-bold">Estado</span>
                                        <span>{getStatusBadge(selectedPaymentDetail.status)}</span>
                                    </div>
                                </div>

                                <div className="space-y-1.5">
                                    <div className="text-[11px] font-bold text-slate-500 uppercase">Datos del Pagador</div>
                                    <div className="text-slate-700"><strong>Nombre:</strong> {selectedPaymentDetail.payer_name || 'N/A'}</div>
                                    <div className="text-slate-700"><strong>Correo:</strong> {selectedPaymentDetail.payer_email || 'N/A'}</div>
                                    <div className="text-slate-700"><strong>ID Transacción:</strong> {selectedPaymentDetail.transaction_id || 'N/A'}</div>
                                </div>

                                {selectedPaymentDetail.notes && (
                                    <div className="p-3 bg-amber-50 rounded-xl border border-amber-100 text-amber-900">
                                        <strong className="block text-[10px] uppercase font-bold text-amber-700 mb-0.5">Notas</strong>
                                        {selectedPaymentDetail.notes}
                                    </div>
                                )}
                            </div>

                            <div className="flex justify-end pt-3 border-t border-slate-100">
                                <button
                                    onClick={() => setSelectedPaymentDetail(null)}
                                    className="px-4 py-2 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 cursor-pointer"
                                >
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </SuperAdminLayout>
    );
}
