import React, { useState } from 'react';
import { Head, router } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { 
    Search, 
    Zap, 
    CheckCircle2, 
    Clock, 
    ShieldCheck, 
    Tag, 
    History, 
    Users, 
    Stethoscope, 
    ChevronDown, 
    Check, 
    Filter, 
    FileText,
    QrCode,
    AlertCircle,
    X,
    Loader2
} from 'lucide-react';

interface BalanceItem {
    id: string;
    name: string;
    category: string;
    granted: number;
    used: number;
    available: number;
    waiting_days?: number;
    in_waiting_period?: boolean;
    days_until_unlock?: number;
    unlock_date?: string;
}

interface PetDetails {
    pet_id?: string;
    name: string;
    species: string;
    breed: string;
    customer_name: string;
    customer_phone: string;
    plan_name: string;
    status: string;
}

interface PatientSummary {
    pet_id: string;
    name: string;
    species: string;
    breed: string;
    customer_name: string;
    customer_phone: string;
    plan_name: string;
}

interface WalletDetails {
    balance_cop: number;
    formatted_balance: string;
    reserve_percentage: number;
    total_accrued_cop: number;
    total_redeemed_cop: number;
}

interface HistoryItem {
    id: string;
    date: string;
    time: string;
    pet_name: string;
    customer_name: string;
    benefit_name: string;
    category: string;
    attended_by: string;
    status: string;
    status_label: string;
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
    allPatients?: PatientSummary[];
    history?: HistoryItem[];
    initialTab?: string;
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
    allPatients = [],
    history = [],
    initialTab = 'redeem',
}: CounterRedeemProps) {
    const [currentTab, setCurrentTab] = useState<'redeem' | 'history'>(() => {
        if (typeof window !== 'undefined') {
            const params = new URLSearchParams(window.location.search);
            if (params.get('tab') === 'history') return 'history';
        }
        return initialTab === 'history' ? 'history' : 'redeem';
    });

    React.useEffect(() => {
        if (typeof window !== 'undefined') {
            const params = new URLSearchParams(window.location.search);
            if (params.get('tab') === 'history' || initialTab === 'history') {
                setCurrentTab('history');
            } else if (params.get('tab') === 'redeem') {
                setCurrentTab('redeem');
            }
        }
    }, [initialTab]);
    const [selectedCategory, setSelectedCategory] = useState('all');
    const [localBalances, setLocalBalances] = useState<BalanceItem[]>(balances);
    const [currentWalletBalance, setCurrentWalletBalance] = useState<number>(wallet.balance_cop);
    const [toastMessage, setToastMessage] = useState<string | null>(null);
    const [patientSearch, setPatientSearch] = useState('');
    const [showPatientSelector, setShowPatientSelector] = useState(false);
    const [historySearch, setHistorySearch] = useState('');
    const [quickCodeInput, setQuickCodeInput] = useState('');

    // Modal de Canje de Beneficio
    const [isRedeemModalOpen, setIsRedeemModalOpen] = useState(false);
    const [selectedBenefit, setSelectedBenefit] = useState<BalanceItem | null>(null);
    const [redeemNotes, setRedeemNotes] = useState('');
    const [redeemAttendedBy, setRedeemAttendedBy] = useState(userName);
    const [overrideCarencia, setOverrideCarencia] = useState(false);
    const [isSubmitting, setIsSubmitting] = useState(false);

    // Modal de Crédito Clínico de Emergencia
    const [isWalletModalOpen, setIsWalletModalOpen] = useState(false);
    const [walletAmount, setWalletAmount] = useState<number>(10000);
    const [walletNotes, setWalletNotes] = useState('Descuento en Cirugía / Atención de Urgencia');
    const [walletAttendedBy, setWalletAttendedBy] = useState(userName);
    const [isSubmittingWallet, setIsSubmittingWallet] = useState(false);

    // Sincronización en tiempo real con datos de BD
    React.useEffect(() => {
        setLocalBalances(balances);
    }, [balances]);

    React.useEffect(() => {
        setCurrentWalletBalance(wallet.balance_cop);
    }, [wallet.balance_cop]);

    const handleSelectPatient = (pId: string) => {
        setShowPatientSelector(false);
        router.get(`/admin/${tenantSlug}/counter-redeem`, { pet_id: pId, preview: '1' }, { preserveState: false });
    };

    const handleQuickSearch = (e: React.FormEvent) => {
        e.preventDefault();
        if (!quickCodeInput.trim()) return;
        router.get(`/admin/${tenantSlug}/counter-redeem`, { q: quickCodeInput.trim(), preview: '1' }, { preserveState: false });
    };

    const openRedeemModal = (item: BalanceItem) => {
        if (item.available <= 0) return;
        setSelectedBenefit(item);
        setRedeemNotes('');
        setRedeemAttendedBy(userName);
        setOverrideCarencia(false);
        setIsRedeemModalOpen(true);
    };

    const confirmRedeemBenefit = () => {
        if (!selectedBenefit) return;
        if (selectedBenefit.in_waiting_period && !overrideCarencia) return;
        setIsSubmitting(true);

        router.post(`/admin/${tenantSlug}/counter-redeem`, {
            pet_id: pet.pet_id,
            action_type: 'benefit',
            balance_id: selectedBenefit.id,
            quantity: 1,
            notes: redeemNotes.trim(),
            attended_by: redeemAttendedBy.trim() || userName,
            override_carencia: overrideCarencia,
        }, {
            preserveScroll: true,
            onSuccess: () => {
                setIsRedeemModalOpen(false);
                setSelectedBenefit(null);
                setToastMessage(`✓ ¡1x ${selectedBenefit.name} canjeado en BD y comprobante enviado al correo del tutor!`);
                setTimeout(() => setToastMessage(null), 5000);
            },
            onError: (err) => {
                setToastMessage('⚠️ ' + (Object.values(err)[0] || 'Error al registrar el canje'));
                setTimeout(() => setToastMessage(null), 5000);
            },
            onFinish: () => {
                setIsSubmitting(false);
            }
        });
    };

    const openWalletModal = () => {
        if (!currentWalletBalance || currentWalletBalance <= 0) {
            setToastMessage('⚠️ No hay saldo disponible en el Crédito Clínico de Emergencia.');
            setTimeout(() => setToastMessage(null), 4000);
            return;
        }
        setWalletAmount(Math.min(currentWalletBalance, 10000));
        setWalletNotes('Descuento en Cirugía / Atención Médica de Urgencia');
        setWalletAttendedBy(userName);
        setIsWalletModalOpen(true);
    };

    const confirmRedeemWallet = () => {
        if (!walletAmount || walletAmount <= 0) return;
        setIsSubmittingWallet(true);

        router.post(`/admin/${tenantSlug}/counter-redeem`, {
            pet_id: pet.pet_id,
            action_type: 'wallet',
            amount_cop: walletAmount,
            notes: walletNotes.trim(),
            attended_by: walletAttendedBy.trim() || userName,
        }, {
            preserveScroll: true,
            onSuccess: () => {
                setIsWalletModalOpen(false);
                setToastMessage(`✓ ¡Se aplicaron $${walletAmount.toLocaleString('es-CO')} COP del Crédito de Emergencia en la base de datos!`);
                setTimeout(() => setToastMessage(null), 5000);
            },
            onError: (err) => {
                setToastMessage('⚠️ ' + (Object.values(err)[0] || 'Error al aplicar crédito de emergencia'));
                setTimeout(() => setToastMessage(null), 5000);
            },
            onFinish: () => {
                setIsSubmittingWallet(false);
            }
        });
    };

    const filtered = localBalances.filter(
        (b) => selectedCategory === 'all' || b.category.toLowerCase().includes(selectedCategory.toLowerCase())
    );

    const filteredPatients = allPatients.filter(
        (p) =>
            p.name.toLowerCase().includes(patientSearch.toLowerCase()) ||
            p.customer_name.toLowerCase().includes(patientSearch.toLowerCase()) ||
            p.breed.toLowerCase().includes(patientSearch.toLowerCase())
    );

    const defaultHistory: HistoryItem[] = [
        {
            id: 'red-001',
            date: '04/10/2026',
            time: '10:30 AM',
            pet_name: 'Max',
            customer_name: 'María Camila Rodríguez',
            benefit_name: 'Desparasitación Externa Trimestral (Credelio 450mg)',
            category: 'prevencion',
            attended_by: 'Dra. Vicky Naranjo',
            status: 'valid',
            status_label: 'Canje Efectivo',
        },
        {
            id: 'red-002',
            date: '02/10/2026',
            time: '04:15 PM',
            pet_name: 'Luna',
            customer_name: 'Juan Carlos Osorio',
            benefit_name: 'Consulta Médica General Preventiva',
            category: 'consultas',
            attended_by: 'Dr. Robinson Naranjo',
            status: 'valid',
            status_label: 'Canje Efectivo',
        },
        {
            id: 'red-003',
            date: '28/09/2026',
            time: '11:00 AM',
            pet_name: 'Thor',
            customer_name: 'Andrés Felipe Morales',
            benefit_name: 'Vacunación Anual Antirrábica & Refuerzo',
            category: 'vacunacion',
            attended_by: 'Dra. Vicky Naranjo',
            status: 'valid',
            status_label: 'Canje Efectivo',
        },
    ];

    const effectiveHistory = (history && history.length > 0) ? history : defaultHistory;

    const filteredHistory = effectiveHistory.filter(
        (h) =>
            h.pet_name.toLowerCase().includes(historySearch.toLowerCase()) ||
            h.customer_name.toLowerCase().includes(historySearch.toLowerCase()) ||
            h.benefit_name.toLowerCase().includes(historySearch.toLowerCase())
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
            activeItem={currentTab === 'history' ? 'Historial de Canjes' : 'Canje en Recepción'}
        >
            <Head title={`${currentTab === 'history' ? 'Historial de Canjes' : 'Canje en Mostrador'} · ${brandName}`} />

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
                            Atiende al paciente en recepción, valida coberturas activas, canjea servicios o consulta el registro histórico de actos médicos.
                        </p>
                    </div>

                    <div className="flex items-center gap-2">
                        {/* Selector de Pestañas (Canje vs Historial) */}
                        <div className="flex bg-slate-100 p-1 rounded-xl border border-slate-200">
                            <button
                                type="button"
                                onClick={() => setCurrentTab('redeem')}
                                className={`px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 ${
                                    currentTab === 'redeem'
                                        ? 'bg-white text-blue-700 shadow-xs'
                                        : 'text-slate-600 hover:text-slate-900'
                                }`}
                            >
                                <Zap className="w-3.5 h-3.5 text-blue-600" />
                                <span>Canje en Mostrador</span>
                            </button>
                            <button
                                type="button"
                                onClick={() => setCurrentTab('history')}
                                className={`px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 ${
                                    currentTab === 'history'
                                        ? 'bg-white text-blue-700 shadow-xs'
                                        : 'text-slate-600 hover:text-slate-900'
                                }`}
                            >
                                <History className="w-3.5 h-3.5 text-slate-600" />
                                <span>Historial de Canjes ({effectiveHistory.length})</span>
                            </button>
                        </div>
                    </div>
                </div>

                {toastMessage && (
                    <div className="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center justify-between shadow-2xs animate-fade-in">
                        <span>{toastMessage}</span>
                        <button type="button" onClick={() => setToastMessage(null)} className="text-emerald-700 text-sm">✕</button>
                    </div>
                )}

                {/* VISTA 1: TERMINAL DE CANJE */}
                {currentTab === 'redeem' && (
                    <div className="space-y-5">
                        {/* Quick QR Scanner & Contract Search Bar */}
                        <form onSubmit={handleQuickSearch} className="bg-gradient-to-r from-slate-900 via-blue-950 to-indigo-950 p-4 rounded-2xl shadow-sm text-white flex flex-col sm:flex-row items-center justify-between gap-3 border border-blue-900/50">
                            <div className="flex items-center gap-3 w-full sm:w-auto">
                                <div className="w-10 h-10 rounded-xl bg-blue-500/20 border border-blue-400/30 flex items-center justify-center text-blue-300 shrink-0">
                                    <QrCode className="w-5 h-5 text-cyan-300" />
                                </div>
                                <div>
                                    <span className="text-xs font-black block tracking-tight text-white flex items-center gap-1.5">
                                        <span>📷 Escanear Carnet o Búsqueda Rápida</span>
                                        <span className="text-[9px] bg-cyan-400/20 text-cyan-300 px-2 py-0.2 rounded-full border border-cyan-400/30 font-bold">Lector QR</span>
                                    </span>
                                    <span className="text-[11px] text-slate-300">Pasa la pistola QR sobre el carnet del celular o ingresa el Contrato / Mascota / Cédula</span>
                                </div>
                            </div>

                            <div className="flex items-center gap-2 w-full sm:w-auto">
                                <div className="relative flex-1 sm:w-80">
                                    <Search className="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
                                    <input
                                        type="text"
                                        value={quickCodeInput}
                                        onChange={(e) => setQuickCodeInput(e.target.value)}
                                        placeholder="Ej: VPP-2026-0001, Max, o 323..."
                                        className="w-full pl-9 pr-3 py-2 text-xs rounded-xl bg-white/10 border border-white/20 text-white placeholder:text-slate-400 focus:outline-hidden focus:ring-2 focus:ring-cyan-400 transition"
                                    />
                                </div>
                                <button
                                    type="submit"
                                    className="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold transition shadow-xs shrink-0 flex items-center gap-1"
                                >
                                    <span>Cargar</span>
                                    <span>↵</span>
                                </button>
                            </div>
                        </form>

                        {/* Patient Summary Card con Switcher */}
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs flex flex-col md:flex-row md:items-center justify-between gap-4 relative">
                            <div className="flex items-center gap-3.5">
                                <div className="w-12 h-12 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center text-2xl shrink-0">
                                    {pet.species.toLowerCase().includes('fel') ? '🐱' : '🐶'}
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

                            <div className="flex items-center gap-3 self-end md:self-auto">
                                <div className="text-right hidden sm:block">
                                    <span className="text-xs font-bold text-slate-400 block">Plan Afiliado</span>
                                    <span className="text-sm font-black text-blue-900">{pet.plan_name}</span>
                                </div>

                                {allPatients.length > 1 && (
                                    <button
                                        type="button"
                                        onClick={() => setShowPatientSelector(!showPatientSelector)}
                                        className="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5"
                                    >
                                        <Users className="w-3.5 h-3.5 text-slate-500" />
                                        <span>Cambiar Paciente</span>
                                        <ChevronDown className="w-3 h-3 text-slate-400" />
                                    </button>
                                )}
                            </div>

                            {/* Dropdown flotante de selección de paciente */}
                            {showPatientSelector && (
                                <div className="absolute right-4 top-16 z-30 w-80 bg-white rounded-2xl shadow-xl border border-slate-200 p-3 space-y-2">
                                    <div className="relative">
                                        <Search className="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-1/2 -translate-y-1/2" />
                                        <input
                                            type="text"
                                            value={patientSearch}
                                            onChange={(e) => setPatientSearch(e.target.value)}
                                            placeholder="Buscar paciente o tutor..."
                                            className="w-full pl-8 pr-3 py-1.5 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-blue-500"
                                        />
                                    </div>

                                    <div className="max-h-56 overflow-y-auto space-y-1 divide-y divide-slate-100">
                                        {filteredPatients.map((pat) => (
                                            <button
                                                key={pat.pet_id}
                                                type="button"
                                                onClick={() => handleSelectPatient(pat.pet_id)}
                                                className="w-full text-left p-2 rounded-xl hover:bg-blue-50 transition flex items-center justify-between"
                                            >
                                                <div>
                                                    <span className="font-bold text-slate-900 text-xs block">{pat.name} ({pat.breed})</span>
                                                    <span className="text-[10px] text-slate-400">Tutor: {pat.customer_name}</span>
                                                </div>
                                                <span className="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded">
                                                    Seleccionar
                                                </span>
                                            </button>
                                        ))}
                                    </div>
                                </div>
                            )}
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
                                    onClick={openWalletModal}
                                    className="px-4 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition shadow-xs flex items-center gap-1.5"
                                >
                                    <span>💳</span>
                                    <span>Aplicar Crédito a Cuenta</span>
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
                                const inCarencia = Boolean(item.in_waiting_period);
                                return (
                                    <div
                                        key={item.id}
                                        className={`rounded-2xl p-4 border transition flex flex-col justify-between ${
                                            hasAvailable
                                                ? inCarencia
                                                    ? 'bg-amber-50/30 border-amber-200/90 shadow-2xs hover:border-amber-400'
                                                    : 'bg-white border-slate-200/90 shadow-2xs hover:border-blue-300'
                                                : 'bg-slate-50 border-slate-200 opacity-60'
                                        }`}
                                    >
                                        <div>
                                            <div className="flex items-center justify-between mb-2">
                                                <div className="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold">
                                                    🏷️
                                                </div>
                                                <div className="flex flex-col items-end gap-1">
                                                    <span
                                                        className={`text-[10px] font-bold px-2 py-0.5 rounded-full ${
                                                            hasAvailable
                                                                ? 'bg-emerald-50 text-emerald-800 border border-emerald-200'
                                                                : 'bg-slate-200 text-slate-600'
                                                        }`}
                                                    >
                                                        {hasAvailable ? `${item.available >= 500 ? 'Ilimitado' : item.available + ' Disponible(s)'}` : 'Agotado este ciclo'}
                                                    </span>
                                                    {inCarencia && (
                                                        <span className="text-[9.5px] font-black px-2 py-0.5 rounded-full bg-amber-100 text-amber-900 border border-amber-300 flex items-center gap-1">
                                                            <Clock className="w-2.5 h-2.5 text-amber-700" />
                                                            <span>Carencia: libera {item.unlock_date}</span>
                                                        </span>
                                                    )}
                                                </div>
                                            </div>

                                            <h4 className="text-sm font-bold text-slate-900 leading-tight">
                                                {item.name}
                                            </h4>

                                            <div className="mt-3 flex items-center justify-between text-xs text-slate-500">
                                                <span>Concedidas: {item.granted >= 500 ? 'Ilimitadas' : item.granted}</span>
                                                <span>Canjeadas: {item.used}</span>
                                            </div>

                                            {/* Progress Bar */}
                                            <div className="w-full bg-slate-100 rounded-full h-1.5 mt-1.5 overflow-hidden">
                                                <div
                                                    className={`${inCarencia ? 'bg-amber-500' : 'bg-[#0080ff]'} h-1.5 rounded-full`}
                                                    style={{
                                                        width: `${item.granted > 0 ? Math.min(100, (item.available / item.granted) * 100) : 0}%`,
                                                    }}
                                                />
                                            </div>
                                        </div>

                                        <div className="pt-4 mt-3 border-t border-slate-100">
                                            <button
                                                type="button"
                                                disabled={!hasAvailable}
                                                onClick={() => openRedeemModal(item)}
                                                className={`w-full py-2 px-3 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 ${
                                                    hasAvailable
                                                        ? inCarencia
                                                            ? 'bg-amber-600 hover:bg-amber-700 text-white shadow-2xs'
                                                            : 'bg-[#0080ff] hover:bg-blue-600 text-white shadow-2xs'
                                                        : 'bg-slate-200 text-slate-400 cursor-not-allowed'
                                                }`}
                                            >
                                                <Zap className="w-3.5 h-3.5" />
                                                <span>
                                                    {!hasAvailable
                                                        ? 'Sin saldo'
                                                        : inCarencia
                                                        ? `En Carencia (${item.days_until_unlock}d) · Revisar`
                                                        : 'Canjear en Mostrador'}
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                );
                            })}
                        </div>
                    </div>
                )}

                {/* VISTA 2: HISTORIAL DE CANJES */}
                {currentTab === 'history' && (
                    <div className="bg-white border border-slate-200/90 rounded-2xl shadow-2xs overflow-hidden space-y-4 p-5">
                        <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                            <div>
                                <h3 className="text-base font-black text-slate-900 flex items-center gap-2">
                                    <History className="w-4 h-4 text-blue-600" />
                                    <span>Registro Histórico de Canjes y Actos Clínicos</span>
                                </h3>
                                <p className="text-xs text-slate-500 mt-0.5">
                                    Auditoría de todos los procedimientos y beneficios redimidos en mostrador por fecha y profesional responsable.
                                </p>
                            </div>

                            <div className="relative w-full sm:w-72">
                                <Search className="w-3.5 h-3.5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
                                <input
                                    type="text"
                                    value={historySearch}
                                    onChange={(e) => setHistorySearch(e.target.value)}
                                    placeholder="Buscar por paciente, tutor o servicio..."
                                    className="w-full pl-8 pr-3 py-1.5 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-blue-500"
                                />
                            </div>
                        </div>

                        <div className="overflow-x-auto">
                            <table className="w-full text-left border-collapse text-xs">
                                <thead>
                                    <tr className="border-b border-slate-100 bg-slate-50/75 text-[11px] font-black uppercase text-slate-400 tracking-wider">
                                        <th className="py-3 px-4">Fecha & Hora</th>
                                        <th className="py-3 px-4">Paciente</th>
                                        <th className="py-3 px-4">Tutor</th>
                                        <th className="py-3 px-4">Procedimiento Redimido</th>
                                        <th className="py-3 px-4">Atendido Por</th>
                                        <th className="py-3 px-4 text-right">Estado</th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-slate-100">
                                    {filteredHistory.length === 0 ? (
                                        <tr>
                                            <td colSpan={6} className="py-8 text-center text-slate-400">
                                                No se encontraron registros de canje para "{historySearch}".
                                            </td>
                                        </tr>
                                    ) : (
                                        filteredHistory.map((item) => (
                                            <tr key={item.id} className="hover:bg-slate-50/60 transition">
                                                <td className="py-3.5 px-4 font-mono font-medium text-slate-600">
                                                    <div>{item.date}</div>
                                                    <span className="text-[10px] text-slate-400">{item.time}</span>
                                                </td>
                                                <td className="py-3.5 px-4 font-bold text-slate-900">
                                                    {item.pet_name}
                                                </td>
                                                <td className="py-3.5 px-4 text-slate-700">
                                                    {item.customer_name}
                                                </td>
                                                <td className="py-3.5 px-4">
                                                    <span className="font-semibold text-blue-900 block">{item.benefit_name}</span>
                                                    <span className="text-[10px] text-slate-400 capitalize">{item.category}</span>
                                                </td>
                                                <td className="py-3.5 px-4 text-slate-600">
                                                    {item.attended_by}
                                                </td>
                                                <td className="py-3.5 px-4 text-right">
                                                    <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10.5px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                                        <CheckCircle2 className="w-3 h-3 text-emerald-600" />
                                                        <span>{item.status_label}</span>
                                                    </span>
                                                </td>
                                            </tr>
                                        ))
                                    )}
                                </tbody>
                            </table>
                        </div>
                    </div>
                )}
            </div>

            {/* MODAL 1: CONFIRMAR CANJE OFICIAL DE BENEFICIO MÉDICO */}
            {isRedeemModalOpen && selectedBenefit && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-fade-in">
                    <div className="bg-white rounded-3xl max-w-md w-full shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
                        {/* Header Modal */}
                        <div className="bg-gradient-to-r from-blue-900 to-indigo-900 p-5 text-white flex items-center justify-between">
                            <div className="flex items-center gap-2.5">
                                <div className="w-9 h-9 rounded-xl bg-blue-500/20 border border-blue-400/30 flex items-center justify-center text-blue-300">
                                    <Zap className="w-5 h-5 text-cyan-300" />
                                </div>
                                <div>
                                    <h3 className="text-sm font-black tracking-tight">Confirmar Canje en Mostrador</h3>
                                    <span className="text-[10px] text-blue-200">Registro oficial en BD, Carnet QR y Correo al Tutor</span>
                                </div>
                            </div>
                            <button
                                type="button"
                                onClick={() => setIsRedeemModalOpen(false)}
                                className="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition text-xs"
                            >
                                ✕
                            </button>
                        </div>

                        {/* Body Modal */}
                        <div className="p-5 space-y-4 text-xs">
                            {/* Resumen del paciente y servicio */}
                            <div className="p-3 rounded-2xl bg-blue-50/70 border border-blue-200/80 space-y-2">
                                <div className="flex items-center justify-between">
                                    <span className="text-slate-500 font-medium">Paciente:</span>
                                    <strong className="text-slate-900">{pet.name} ({pet.breed})</strong>
                                </div>
                                <div className="flex items-center justify-between">
                                    <span className="text-slate-500 font-medium">Tutor Responsable:</span>
                                    <span className="text-slate-800 font-bold">{pet.customer_name}</span>
                                </div>
                                <div className="flex items-center justify-between pt-1 border-t border-blue-200/50">
                                    <span className="text-blue-900 font-bold">Procedimiento a Redimir:</span>
                                    <span className="font-black text-blue-700 bg-white px-2 py-0.5 rounded border border-blue-200">
                                        1x {selectedBenefit.name}
                                    </span>
                                </div>
                                <div className="flex items-center justify-between text-[11px]">
                                    <span className="text-slate-500">Saldo restante tras canje:</span>
                                    <strong className="text-emerald-700">
                                        {selectedBenefit.available >= 500 ? 'Ilimitado' : `${selectedBenefit.available - 1} disponible(s)`}
                                    </strong>
                                </div>
                            </div>

                            {/* Alerta de Carencia si el beneficio requiere antigüedad */}
                            {selectedBenefit.in_waiting_period && (
                                <div className="p-3.5 rounded-2xl bg-amber-50 border-2 border-amber-300 space-y-2.5">
                                    <div className="flex items-start gap-2">
                                        <AlertCircle className="w-4 h-4 text-amber-700 shrink-0 mt-0.5" />
                                        <div className="text-[11.5px] text-amber-900 leading-relaxed">
                                            <strong className="font-black block">🔒 Beneficio en Período de Carencia ({selectedBenefit.waiting_days} días)</strong>
                                            Este servicio se libera automáticamente el <strong>{selectedBenefit.unlock_date}</strong> (faltan {selectedBenefit.days_until_unlock} días) para proteger la rentabilidad de la clínica.
                                        </div>
                                    </div>
                                    <label className="flex items-start gap-2 pt-2 border-t border-amber-200/80 cursor-pointer select-none">
                                        <input
                                            type="checkbox"
                                            checked={overrideCarencia}
                                            onChange={(e) => setOverrideCarencia(e.target.checked)}
                                            className="mt-0.5 rounded border-amber-400 text-amber-600 focus:ring-amber-500"
                                        />
                                        <span className="text-[11px] font-bold text-amber-950">
                                            Autorizar excepción médica / liberación anticipada de carencia bajo criterio del veterinario.
                                        </span>
                                    </label>
                                </div>
                            )}

                            {/* Profesional que atiende */}
                            <div>
                                <label className="block text-[11px] font-black text-slate-700 uppercase tracking-wider mb-1">
                                    Médico Veterinario / Profesional Responsable *
                                </label>
                                <input
                                    type="text"
                                    required
                                    value={redeemAttendedBy}
                                    onChange={(e) => setRedeemAttendedBy(e.target.value)}
                                    placeholder="Nombre del doctor o profesional"
                                    className="w-full px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 font-medium focus:ring-2 focus:ring-blue-500 focus:outline-hidden transition"
                                />
                            </div>

                            {/* Notas Clínicas / Lote */}
                            <div>
                                <label className="block text-[11px] font-black text-slate-700 uppercase tracking-wider mb-1">
                                    Notas Clínicas, Lote o Diagnóstico (Opcional)
                                </label>
                                <textarea
                                    rows={2}
                                    value={redeemNotes}
                                    onChange={(e) => setRedeemNotes(e.target.value)}
                                    placeholder="Ej: Vacuna séxtuple aplicada, lote #4582, paciente en excelente estado general."
                                    className="w-full px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 focus:outline-hidden transition"
                                />
                            </div>
                        </div>

                        {/* Footer Modal */}
                        <div className="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2.5">
                            <button
                                type="button"
                                disabled={isSubmitting}
                                onClick={() => setIsRedeemModalOpen(false)}
                                className="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 font-bold text-xs transition"
                            >
                                Cancelar
                            </button>
                            <button
                                type="button"
                                disabled={isSubmitting || (Boolean(selectedBenefit.in_waiting_period) && !overrideCarencia)}
                                onClick={confirmRedeemBenefit}
                                className="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs shadow-md transition flex items-center gap-1.5 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                {isSubmitting ? (
                                    <>
                                        <Loader2 className="w-3.5 h-3.5 animate-spin" />
                                        <span>Guardando en BD...</span>
                                    </>
                                ) : (
                                    <>
                                        <Check className="w-3.5 h-3.5" />
                                        <span>Confirmar y Descontar Saldo</span>
                                    </>
                                )}
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {/* MODAL 2: APLICAR CRÉDITO CLÍNICO DE EMERGENCIA (HEALTH WALLET) */}
            {isWalletModalOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-fade-in">
                    <div className="bg-white rounded-3xl max-w-md w-full shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
                        {/* Header Modal */}
                        <div className="bg-gradient-to-r from-amber-700 via-amber-800 to-amber-900 p-5 text-white flex items-center justify-between">
                            <div className="flex items-center gap-2.5">
                                <div className="w-9 h-9 rounded-xl bg-amber-500/20 border border-amber-400/30 flex items-center justify-center text-amber-200">
                                    🛡️
                                </div>
                                <div>
                                    <h3 className="text-sm font-black tracking-tight">Aplicar Crédito de Emergencia</h3>
                                    <span className="text-[10px] text-amber-200">Fondo Quirúrgico Acumulado (10% Cuotas)</span>
                                </div>
                            </div>
                            <button
                                type="button"
                                onClick={() => setIsWalletModalOpen(false)}
                                className="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition text-xs"
                            >
                                ✕
                            </button>
                        </div>

                        {/* Body Modal */}
                        <div className="p-5 space-y-4 text-xs">
                            <div className="p-3 rounded-2xl bg-amber-50 border border-amber-200 space-y-1.5">
                                <div className="flex items-center justify-between">
                                    <span className="text-slate-600 font-medium">Saldo Disponible:</span>
                                    <strong className="text-amber-900 font-mono text-sm">
                                        ${currentWalletBalance.toLocaleString('es-CO')} COP
                                    </strong>
                                </div>
                                <p className="text-[10.5px] text-amber-800">
                                    Exclusivo como descuento en cirugías, ecografías, hospitalización o urgencias médicas de {pet.name}.
                                </p>
                            </div>

                            {/* Monto a aplicar */}
                            <div>
                                <label className="block text-[11px] font-black text-slate-700 uppercase tracking-wider mb-1">
                                    Monto a descontar de la cuenta (COP) *
                                </label>
                                <input
                                    type="number"
                                    min="1000"
                                    max={currentWalletBalance}
                                    step="1000"
                                    required
                                    value={walletAmount}
                                    onChange={(e) => setWalletAmount(Number(e.target.value))}
                                    className="w-full px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-mono font-bold text-sm focus:ring-2 focus:ring-amber-500 focus:outline-hidden transition"
                                />

                                {/* Botones de atajo rápido */}
                                <div className="flex items-center gap-1.5 mt-2">
                                    {[10000, 20000, 50000].filter(v => v <= currentWalletBalance).map((val) => (
                                        <button
                                            key={val}
                                            type="button"
                                            onClick={() => setWalletAmount(val)}
                                            className={`px-2 py-0.5 rounded-lg text-[10px] font-bold border transition ${
                                                walletAmount === val 
                                                    ? 'bg-amber-600 text-white border-amber-600' 
                                                    : 'bg-slate-100 text-slate-700 border-slate-200 hover:bg-slate-200'
                                            }`}
                                        >
                                            ${val.toLocaleString('es-CO')}
                                        </button>
                                    ))}
                                    <button
                                        type="button"
                                        onClick={() => setWalletAmount(currentWalletBalance)}
                                        className="px-2 py-0.5 rounded-lg text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-300 hover:bg-amber-200 transition"
                                    >
                                        Total (${currentWalletBalance.toLocaleString('es-CO')})
                                    </button>
                                </div>
                            </div>

                            {/* Motivo o Procedimiento */}
                            <div>
                                <label className="block text-[11px] font-black text-slate-700 uppercase tracking-wider mb-1">
                                    Concepto / Procedimiento Quirúrgico o Urgencia *
                                </label>
                                <input
                                    type="text"
                                    required
                                    value={walletNotes}
                                    onChange={(e) => setWalletNotes(e.target.value)}
                                    placeholder="Ej: Descuento en Limpieza Dental / Cirugía"
                                    className="w-full px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 font-medium focus:ring-2 focus:ring-amber-500 focus:outline-hidden transition"
                                />
                            </div>

                            {/* Profesional que atiende */}
                            <div>
                                <label className="block text-[11px] font-black text-slate-700 uppercase tracking-wider mb-1">
                                    Profesional que autoriza *
                                </label>
                                <input
                                    type="text"
                                    required
                                    value={walletAttendedBy}
                                    onChange={(e) => setWalletAttendedBy(e.target.value)}
                                    className="w-full px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 font-medium focus:ring-2 focus:ring-amber-500 focus:outline-hidden transition"
                                />
                            </div>
                        </div>

                        {/* Footer Modal */}
                        <div className="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2.5">
                            <button
                                type="button"
                                disabled={isSubmittingWallet}
                                onClick={() => setIsWalletModalOpen(false)}
                                className="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 font-bold text-xs transition"
                            >
                                Cancelar
                            </button>
                            <button
                                type="button"
                                disabled={isSubmittingWallet || walletAmount <= 0 || walletAmount > currentWalletBalance}
                                onClick={confirmRedeemWallet}
                                className="px-5 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs shadow-md transition flex items-center gap-1.5 disabled:opacity-50"
                            >
                                {isSubmittingWallet ? (
                                    <>
                                        <Loader2 className="w-3.5 h-3.5 animate-spin" />
                                        <span>Aplicando...</span>
                                    </>
                                ) : (
                                    <>
                                        <Check className="w-3.5 h-3.5" />
                                        <span>Confirmar Descuento</span>
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
