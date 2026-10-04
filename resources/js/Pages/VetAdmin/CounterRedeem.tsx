import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { Search, Zap, CheckCircle2, AlertCircle, Clock, ShieldCheck, Tag } from 'lucide-react';

interface BalanceItem {
    id: string;
    name: string;
    category: string;
    granted: number;
    used: number;
    available: number;
}

interface PetDetails {
    name: string;
    species: string;
    breed: string;
    customer_name: string;
    customer_phone: string;
    plan_name: string;
    status: string;
}

interface WalletDetails {
    balance_cop: number;
    formatted_balance: string;
    reserve_percentage: number;
    total_accrued_cop: number;
    total_redeemed_cop: number;
}

interface CounterRedeemProps {
    tenantSlug: string;
    brandName: string;
    clinicSubtitle: string;
    logoUrl?: string | null;
    saasPlan: any;
    logoutUrl: string;
    userName: string;
    userRole: string;
    pet: PetDetails;
    balances: BalanceItem[];
    wallet?: WalletDetails;
}

export default function CounterRedeem({
    tenantSlug,
    brandName,
    clinicSubtitle,
    logoUrl,
    saasPlan,
    logoutUrl,
    userName,
    userRole,
    pet,
    balances = [],
    wallet = {
        balance_cop: 20000,
        formatted_balance: '$20.000 COP',
        reserve_percentage: 10,
        total_accrued_cop: 20000,
        total_redeemed_cop: 0,
    },
}: CounterRedeemProps) {
    const [selectedCategory, setSelectedCategory] = useState('all');
    const [localBalances, setLocalBalances] = useState<BalanceItem[]>(balances);
    const [currentWalletBalance, setCurrentWalletBalance] = useState<number>(wallet.balance_cop);
    const [toastMessage, setToastMessage] = useState<string | null>(null);

    const handleRedeemWallet = () => {
        if (!currentWalletBalance || currentWalletBalance <= 0) {
            setToastMessage('⚠️ No hay saldo disponible en el Crédito Clínico de Emergencia.');
            setTimeout(() => setToastMessage(null), 4000);
            return;
        }

        const deduct = Math.min(currentWalletBalance, 10000);
        setCurrentWalletBalance((prev) => prev - deduct);
        setToastMessage(`✓ ¡Se aplicaron $${deduct.toLocaleString('es-CO')} COP de Crédito de Emergencia a la cuenta de ${pet.name}! Saldo restante: $${(currentWalletBalance - deduct).toLocaleString('es-CO')} COP.`);
        setTimeout(() => setToastMessage(null), 5000);
    };

    const handleRedeem = (item: BalanceItem) => {
        if (item.available <= 0) return;

        setLocalBalances((prev) =>
            prev.map((b) =>
                b.id === item.id
                    ? { ...b, used: b.used + 1, available: b.available - 1 }
                    : b
            )
        );

        setToastMessage(`✓ ¡1x ${item.name} canjeado exitosamente para ${pet.name}! Saldo actualizado.`);
        setTimeout(() => setToastMessage(null), 4000);
    };

    const filtered = localBalances.filter(
        (b) => selectedCategory === 'all' || b.category.toLowerCase().includes(selectedCategory.toLowerCase())
    );

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
            activeItem="Canje en Recepción"
        >
            <Head title={`Canje en Mostrador · ${brandName}`} />

            <div className="w-full space-y-5 pb-16">
                {/* Header Banner */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div className="flex items-center gap-2">
                            <h1 className="text-xl font-black text-slate-900">
                                Terminal Mostrador & Canje Clínico
                            </h1>
                            <span className="text-[10px] font-bold px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                                Validación en Tiempo Real
                            </span>
                        </div>
                        <p className="text-xs text-slate-500 mt-1">
                            Atiende al paciente en recepción, valida coberturas activas y descuenta servicios de forma instantánea.
                        </p>
                    </div>

                    <div className="flex items-center gap-2">
                        <span className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                            <span className="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Mostrador Sincronizado</span>
                        </span>
                    </div>
                </div>

                {toastMessage && (
                    <div className="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center justify-between shadow-2xs animate-fade-in">
                        <span>{toastMessage}</span>
                        <button type="button" onClick={() => setToastMessage(null)} className="text-emerald-700 text-sm">✕</button>
                    </div>
                )}

                {/* Patient Summary Card */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div className="flex items-center gap-3.5">
                        <div className="w-12 h-12 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center text-2xl shrink-0">
                            🐶
                        </div>
                        <div>
                            <div className="flex items-center gap-2">
                                <h3 className="text-base font-black text-slate-900">{pet.name}</h3>
                                <span className="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    Membresía Activa
                                </span>
                            </div>
                            <p className="text-xs text-slate-500 mt-0.5">
                                {pet.breed} ({pet.species}) · Tutor: <strong className="text-slate-700">{pet.customer_name}</strong> (📱 {pet.customer_phone})
                            </p>
                        </div>
                    </div>

                    <div className="text-right">
                        <span className="text-xs font-bold text-slate-400 block">Plan Afiliado</span>
                        <span className="text-sm font-black text-blue-900">{pet.plan_name}</span>
                    </div>
                </div>

                {/* 🛡️ Smart Health Wallet Card (Crédito Clínico de Emergencia) */}
                <div className="bg-gradient-to-r from-amber-500/10 via-amber-400/5 to-teal-500/10 border-2 border-amber-300/80 rounded-2xl p-4 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div className="flex items-center gap-3.5">
                        <div className="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 text-white flex items-center justify-center text-xl shrink-0 shadow-xs font-black">
                            🛡️
                        </div>
                        <div>
                            <div className="flex items-center gap-2">
                                <h3 className="text-sm font-extrabold text-slate-900">
                                    Crédito Clínico de Emergencia (Fondo Quirúrgico 10%)
                                </h3>
                                <span className="text-[10px] font-black px-2 py-0.5 rounded-full bg-amber-100 text-amber-900 border border-amber-300">
                                    ${currentWalletBalance.toLocaleString('es-CO')} COP Disponible
                                </span>
                            </div>
                            <p className="text-xs text-slate-600 mt-1 max-w-xl">
                                Bono acumulativo por antigüedad de cuotas mensuales. <strong>Redimible exclusivamente como descuento en cirugías mayores, ecografías o urgencias no cubiertas al 100%.</strong> No canjeable por efectivo.
                            </p>
                        </div>
                    </div>

                    <div className="flex items-center gap-2 shrink-0">
                        <button
                            type="button"
                            onClick={handleRedeemWallet}
                            className="px-4 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition shadow-xs flex items-center gap-1.5"
                        >
                            <span>💳</span>
                            <span>Aplicar $10.000 a Cuenta</span>
                        </button>
                    </div>
                </div>

                {/* Category Filters */}
                <div className="flex items-center gap-2 overflow-x-auto pb-1">
                    {['all', 'consultas', 'vacunacion', 'prevencion', 'identificacion'].map((cat) => (
                        <button
                            key={cat}
                            type="button"
                            onClick={() => setSelectedCategory(cat)}
                            className={`px-3.5 py-1.5 rounded-xl text-xs font-bold whitespace-nowrap transition ${
                                selectedCategory === cat
                                    ? 'bg-[#0080ff] text-white shadow-xs'
                                    : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200'
                            }`}
                        >
                            {cat === 'all'
                                ? '⭐ Todos los Saldos'
                                : cat === 'consultas'
                                ? '🩺 Consultas'
                                : cat === 'vacunacion'
                                ? '💉 Vacunas'
                                : cat === 'prevencion'
                                ? '🛡️ Desparasitaciones'
                                : '🪪 Identificación & Kit'}
                        </button>
                    ))}
                </div>

                {/* Benefit Balances Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-4 gap-4">
                    {filtered.map((item) => {
                        const hasAvailable = item.available > 0;
                        return (
                            <div
                                key={item.id}
                                className={`rounded-2xl p-4 border transition flex flex-col justify-between ${
                                    hasAvailable
                                        ? 'bg-white border-slate-200/90 shadow-2xs hover:border-blue-300'
                                        : 'bg-slate-50 border-slate-200 opacity-60'
                                }`}
                            >
                                <div>
                                    <div className="flex items-center justify-between mb-2">
                                        <div className="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold">
                                            🏷️
                                        </div>
                                        <span
                                            className={`text-[10px] font-bold px-2 py-0.5 rounded-full ${
                                                hasAvailable
                                                    ? 'bg-emerald-50 text-emerald-800 border border-emerald-200'
                                                    : 'bg-slate-200 text-slate-600'
                                            }`}
                                        >
                                            {hasAvailable ? `${item.available} Disponible(s)` : 'Agotado este ciclo'}
                                        </span>
                                    </div>

                                    <h4 className="text-sm font-bold text-slate-900 leading-tight">
                                        {item.name}
                                    </h4>

                                    <div className="mt-3 flex items-center justify-between text-xs text-slate-500">
                                        <span>Concedidas: {item.granted}</span>
                                        <span>Canjeadas: {item.used}</span>
                                    </div>

                                    {/* Progress Bar */}
                                    <div className="w-full bg-slate-100 rounded-full h-1.5 mt-1.5 overflow-hidden">
                                        <div
                                            className="bg-[#0080ff] h-1.5 rounded-full"
                                            style={{
                                                width: `${item.granted > 0 ? (item.available / item.granted) * 100 : 0}%`,
                                            }}
                                        />
                                    </div>
                                </div>

                                <div className="pt-4 mt-3 border-t border-slate-100">
                                    <button
                                        type="button"
                                        disabled={!hasAvailable}
                                        onClick={() => handleRedeem(item)}
                                        className={`w-full py-2 px-3 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 ${
                                            hasAvailable
                                                ? 'bg-[#0080ff] hover:bg-blue-600 text-white shadow-2xs'
                                                : 'bg-slate-200 text-slate-400 cursor-not-allowed'
                                        }`}
                                    >
                                        <Zap className="w-3.5 h-3.5" />
                                        <span>{hasAvailable ? 'Canjear en Mostrador' : 'Sin saldo'}</span>
                                    </button>
                                </div>
                            </div>
                        );
                    })}
                </div>
            </div>
        </VetAdminLayout>
    );
}
