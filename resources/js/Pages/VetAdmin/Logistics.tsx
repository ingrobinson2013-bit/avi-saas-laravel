import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { 
    Truck, 
    Package, 
    Calendar, 
    CheckCircle2, 
    Clock, 
    Search, 
    MessageCircle, 
    ExternalLink, 
    AlertCircle, 
    ShieldCheck, 
    Sparkles, 
    MapPin, 
    Phone, 
    User,
    ArrowUpRight,
    RefreshCw
} from 'lucide-react';

interface DispatchItem {
    id: string;
    pet_name: string;
    pet_species: string;
    pet_breed: string;
    customer_name: string;
    recipient_phone: string;
    delivery_address: string;
    product_name: string;
    dosage: string;
    frequency_label: string;
    scheduled_date: string;
    status: string;
    status_label: string;
    courier_name: string;
    tracking_number: string;
    whatsapp_tracking_url: string;
}

interface LogisticsProps {
    tenantSlug: string;
    brandName: string;
    clinicSubtitle: string;
    logoUrl?: string | null;
    saasPlan: any;
    logoutUrl: string;
    userName: string;
    userRole: string;
    orders: DispatchItem[];
    stats: {
        total_scheduled: number;
        total_in_preparation: number;
        total_shipped: number;
        total_delivered: number;
        total_orders: number;
        adherence_rate: string;
    };
}

export default function Logistics({
    tenantSlug,
    brandName,
    clinicSubtitle,
    logoUrl,
    saasPlan,
    logoutUrl,
    userName,
    userRole,
    orders = [],
    stats = {
        total_scheduled: 1,
        total_in_preparation: 1,
        total_shipped: 1,
        total_delivered: 0,
        total_orders: 3,
        adherence_rate: '98.5%',
    },
}: LogisticsProps) {
    const [searchTerm, setSearchTerm] = useState('');
    const [statusFilter, setStatusFilter] = useState('all');
    const [localOrders, setLocalOrders] = useState<DispatchItem[]>(orders);
    const [selectedGuide, setSelectedGuide] = useState<DispatchItem | null>(null);

    const filteredOrders = localOrders.filter((order) => {
        const matchesSearch = 
            order.pet_name.toLowerCase().includes(searchTerm.toLowerCase()) ||
            order.customer_name.toLowerCase().includes(searchTerm.toLowerCase()) ||
            order.product_name.toLowerCase().includes(searchTerm.toLowerCase()) ||
            order.delivery_address.toLowerCase().includes(searchTerm.toLowerCase());
        
        const matchesStatus = statusFilter === 'all' || order.status === statusFilter;
        return matchesSearch && matchesStatus;
    });

    const handleAdvanceStatus = (orderId: string) => {
        setLocalOrders(prev => prev.map(ord => {
            if (ord.id === orderId) {
                if (ord.status === 'scheduled') {
                    return { ...ord, status: 'in_preparation', status_label: 'En Empaque' };
                } else if (ord.status === 'in_preparation') {
                    return { ...ord, status: 'shipped', status_label: 'En Camino', tracking_number: 'CRD-' + Math.floor(1000000 + Math.random() * 9000000) + '-CO' };
                } else if (ord.status === 'shipped') {
                    return { ...ord, status: 'delivered', status_label: 'Entregado' };
                }
            }
            return ord;
        }));
    };

    const getStatusBadge = (status: string, label: string) => {
        switch (status) {
            case 'scheduled':
                return <span className="px-2.5 py-0.5 rounded-full text-[10.5px] font-bold bg-blue-100 text-blue-800 border border-blue-200">📅 {label}</span>;
            case 'in_preparation':
                return <span className="px-2.5 py-0.5 rounded-full text-[10.5px] font-bold bg-amber-100 text-amber-800 border border-amber-200">📦 {label}</span>;
            case 'shipped':
                return <span className="px-2.5 py-0.5 rounded-full text-[10.5px] font-bold bg-purple-100 text-purple-800 border border-purple-200 animate-pulse">🚚 {label}</span>;
            case 'delivered':
                return <span className="px-2.5 py-0.5 rounded-full text-[10.5px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">✓ {label}</span>;
            default:
                return <span className="px-2.5 py-0.5 rounded-full text-[10.5px] font-bold bg-slate-100 text-slate-800">{label}</span>;
        }
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
            activeItem="Logística & Envíos"
        >
            <Head title={`Logística & Despacho Preventivo · ${brandName}`} />

            <div className="w-full space-y-5 pb-16">
                {/* Header Banner */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div className="flex items-center gap-2">
                            <h1 className="text-xl font-black text-slate-900">
                                Logística & Despacho Preventivo Domiciliario
                            </h1>
                            <span className="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                Supply Auto-Replenish
                            </span>
                        </div>
                        <p className="text-xs text-slate-500 mt-1">
                            Envío recurrente automatizado de antiparasitarios (Credelio, NexGard, Bravecto) en la puerta del tutor. Cero olvidos, máxima adherencia.
                        </p>
                    </div>

                    <div className="flex items-center gap-2">
                        <span className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-800 border border-blue-200">
                            <Truck className="w-4 h-4 text-blue-600" />
                            <span>Post2Pet Logística Activa</span>
                        </span>
                    </div>
                </div>

                {/* KPI Metrics */}
                <div className="grid grid-cols-1 sm:grid-cols-4 gap-3">
                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">Despachos este Mes</span>
                        <div className="text-2xl font-black text-slate-900">{stats.total_orders}</div>
                        <span className="text-[10.5px] font-bold text-blue-600 mt-1 block">Antiparasitarios agendados</span>
                    </div>

                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">En Tránsito / Courier</span>
                        <div className="text-2xl font-black text-purple-600">{stats.total_shipped}</div>
                        <span className="text-[10.5px] font-medium text-slate-500 mt-1 block">Coordinadora / Servientrega</span>
                    </div>

                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">En Preparación / Empaque</span>
                        <div className="text-2xl font-black text-amber-600">{stats.total_in_preparation}</div>
                        <span className="text-[10.5px] font-medium text-slate-500 mt-1 block">Listos para rotular</span>
                    </div>

                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">Tasa de Adherencia Preventiva</span>
                        <div className="text-2xl font-black text-emerald-600">{stats.adherence_rate}</div>
                        <span className="text-[10.5px] font-bold text-emerald-600 mt-1 block">✓ Cero abandono por olvido</span>
                    </div>
                </div>

                {/* Table Card */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-4">
                    <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                        <div className="relative w-full sm:w-72">
                            <Search className="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
                            <input
                                type="text"
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                                placeholder="Buscar mascota, tutor, producto..."
                                className="w-full pl-8 pr-3 py-1.5 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 outline-none"
                            />
                        </div>

                        <div className="flex items-center gap-1.5 overflow-x-auto">
                            {[
                                { key: 'all', label: 'Todos' },
                                { key: 'scheduled', label: 'Programados' },
                                { key: 'in_preparation', label: 'En Empaque' },
                                { key: 'shipped', label: 'En Camino' },
                                { key: 'delivered', label: 'Entregados' },
                            ].map((f) => (
                                <button
                                    key={f.key}
                                    onClick={() => setStatusFilter(f.key)}
                                    className={`px-3 py-1 text-xs rounded-lg font-bold transition shrink-0 ${
                                        statusFilter === f.key
                                            ? 'bg-blue-600 text-white shadow-xs'
                                            : 'bg-slate-100 text-slate-600 hover:bg-slate-200'
                                    }`}
                                >
                                    {f.label}
                                </button>
                            ))}
                        </div>
                    </div>

                    {/* Orders Table */}
                    <div className="overflow-x-auto">
                        <table className="w-full text-left text-xs text-slate-600">
                            <thead>
                                <tr className="border-b border-slate-100 text-[10px] font-black uppercase tracking-wider text-slate-400">
                                    <th className="py-2.5 px-3">Mascota & Tutor</th>
                                    <th className="py-2.5 px-3">Fármaco Preventivo & Dosis</th>
                                    <th className="py-2.5 px-3">Periodicidad</th>
                                    <th className="py-2.5 px-3">Fecha Despacho</th>
                                    <th className="py-2.5 px-3">Estado</th>
                                    <th className="py-2.5 px-3">Dirección de Entrega</th>
                                    <th className="py-2.5 px-3 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100">
                                {filteredOrders.map((order) => (
                                    <tr key={order.id} className="hover:bg-slate-50/80 transition">
                                        <td className="py-3 px-3">
                                            <div className="font-black text-slate-900 flex items-center gap-1.5">
                                                <span>{order.pet_name}</span>
                                                <span className="text-[10px] font-bold text-slate-400">
                                                    ({order.pet_breed})
                                                </span>
                                            </div>
                                            <div className="text-[11px] text-slate-500">
                                                Tutor: {order.customer_name}
                                            </div>
                                        </td>

                                        <td className="py-3 px-3">
                                            <div className="font-bold text-slate-800">{order.product_name}</div>
                                            <div className="text-[11px] text-slate-500">{order.dosage}</div>
                                        </td>

                                        <td className="py-3 px-3">
                                            <span className="font-medium text-slate-700">{order.frequency_label}</span>
                                        </td>

                                        <td className="py-3 px-3">
                                            <span className="font-bold text-slate-900">{order.scheduled_date}</span>
                                        </td>

                                        <td className="py-3 px-3">
                                            {getStatusBadge(order.status, order.status_label)}
                                        </td>

                                        <td className="py-3 px-3 max-w-[200px]">
                                            <div className="truncate font-medium text-slate-700" title={order.delivery_address}>
                                                {order.delivery_address}
                                            </div>
                                            <div className="text-[10px] font-mono text-slate-400">
                                                Tel: {order.recipient_phone}
                                            </div>
                                        </td>

                                        <td className="py-3 px-3 text-right">
                                            <div className="flex items-center justify-end gap-1.5">
                                                <a
                                                    href={order.whatsapp_tracking_url}
                                                    target="_blank"
                                                    rel="noreferrer"
                                                    title="Notificar por WhatsApp"
                                                    className="p-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 transition"
                                                >
                                                    <MessageCircle className="w-3.5 h-3.5" />
                                                </a>

                                                <button
                                                    onClick={() => setSelectedGuide(order)}
                                                    title="Ver Guía de Despacho"
                                                    className="p-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 transition"
                                                >
                                                    <Package className="w-3.5 h-3.5" />
                                                </button>

                                                {order.status !== 'delivered' && (
                                                    <button
                                                        onClick={() => handleAdvanceStatus(order.id)}
                                                        title="Avanzar Estado"
                                                        className="px-2 py-1 rounded-lg bg-slate-800 hover:bg-slate-900 text-white text-[10.5px] font-bold transition flex items-center gap-1"
                                                    >
                                                        <span>Avanzar</span>
                                                        <ArrowUpRight className="w-3 h-3" />
                                                    </button>
                                                )}
                                            </div>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>

                    {filteredOrders.length === 0 && (
                        <div className="text-center py-8 text-slate-400 text-xs">
                            No se encontraron despachos con los filtros seleccionados.
                        </div>
                    )}
                </div>

                {/* MODAL DETALLE DE GUÍA DE ENVÍO */}
                {selectedGuide && (
                    <div className="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4">
                        <div className="bg-white rounded-2xl max-w-md w-full p-5 shadow-2xl space-y-4 border border-slate-200">
                            <div className="flex items-center justify-between pb-3 border-b border-slate-100">
                                <div className="flex items-center gap-2">
                                    <Package className="w-5 h-5 text-blue-600" />
                                    <h3 className="text-sm font-black text-slate-900">
                                        Rótulo de Envío · {selectedGuide.courier_name}
                                    </h3>
                                </div>
                                <button
                                    onClick={() => setSelectedGuide(null)}
                                    className="text-slate-400 hover:text-slate-700 text-xs font-bold"
                                >
                                    ✕
                                </button>
                            </div>

                            <div className="space-y-3 text-xs bg-slate-50 p-4 rounded-xl border border-slate-200 font-mono">
                                <div className="flex justify-between border-b border-slate-200 pb-2">
                                    <span className="text-slate-400">Guía Tracking:</span>
                                    <span className="font-bold text-slate-900">{selectedGuide.tracking_number}</span>
                                </div>
                                <div className="flex justify-between border-b border-slate-200 pb-2">
                                    <span className="text-slate-400">Destinatario:</span>
                                    <span className="font-bold text-slate-900">{selectedGuide.customer_name}</span>
                                </div>
                                <div className="flex justify-between border-b border-slate-200 pb-2">
                                    <span className="text-slate-400">Mascota Paciente:</span>
                                    <span className="font-bold text-slate-900">{selectedGuide.pet_name} ({selectedGuide.pet_breed})</span>
                                </div>
                                <div className="flex justify-between border-b border-slate-200 pb-2">
                                    <span className="text-slate-400">Fármaco:</span>
                                    <span className="font-bold text-emerald-700">{selectedGuide.product_name}</span>
                                </div>
                                <div>
                                    <span className="text-slate-400 block mb-1">Dirección de Entrega:</span>
                                    <span className="font-bold text-slate-900">{selectedGuide.delivery_address}</span>
                                </div>
                            </div>

                            <div className="flex items-center justify-end gap-2 pt-2">
                                <button
                                    type="button"
                                    onClick={() => window.print()}
                                    className="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition"
                                >
                                    Imprimir Rótulo
                                </button>
                                <button
                                    type="button"
                                    onClick={() => setSelectedGuide(null)}
                                    className="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-xs"
                                >
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </VetAdminLayout>
    );
}
