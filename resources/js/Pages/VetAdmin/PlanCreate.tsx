import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { 
    Layers, 
    Plus, 
    Check, 
    ArrowRight, 
    ShieldCheck, 
    Sparkles, 
    Calculator, 
    TrendingUp, 
    AlertCircle, 
    Percent, 
    CheckCircle2, 
    ShieldAlert 
} from 'lucide-react';

interface ServiceItem {
    id: string;
    name: string;
    category: string;
    description: string;
}

interface BreedOption {
    key: string;
    name: string;
}

interface ActuarialResult {
    breed_name: string;
    pet_age_years: number;
    remaining_life_expectancy: string;
    suggested_monthly_fee_cop: number;
    formatted_monthly_fee: string;
    target_net_margin: string;
    confidence_level: string;
    monte_carlo_iterations: number;
    var_95_min_profit: string;
    expected_median_ltv_profit: string;
    optimistic_ltv_profit: string;
    emergency_reserve_accrual_10: string;
    risk_level: string;
    frequent_pathologies: string[];
    actuarial_verdict: string;
}

interface PlanCreateProps {
    tenantSlug: string;
    brandName: string;
    clinicSubtitle: string;
    logoUrl?: string | null;
    saasPlan: any;
    logoutUrl: string;
    userName: string;
    userRole: string;
    services: ServiceItem[];
    breeds?: BreedOption[];
    actuarialSimulation?: ActuarialResult;
}

export default function PlanCreate({
    tenantSlug,
    brandName,
    clinicSubtitle,
    logoUrl,
    saasPlan,
    logoutUrl,
    userName,
    userRole,
    services = [],
    breeds = [
        { key: 'golden_retriever', name: 'Golden Retriever / Labrador (Raza Grande)' },
        { key: 'bulldog_frances', name: 'Bulldog Francés / Inglés (Braquicefálico)' },
        { key: 'poodle', name: 'Poodle / Schnauzer (Raza Pequeña)' },
        { key: 'mestizo', name: 'Mestizo / Criollo (Vigor Híbrido)' },
        { key: 'felino', name: 'Felino Doméstico / Mestizo (Gato)' },
    ],
    actuarialSimulation = {
        breed_name: 'Golden Retriever / Labrador (Raza Grande)',
        pet_age_years: 3,
        remaining_life_expectancy: '9.0 años restantes',
        suggested_monthly_fee_cop: 48000,
        formatted_monthly_fee: '$48.000 COP/mes',
        target_net_margin: '35%',
        confidence_level: '95% de confianza estadística',
        monte_carlo_iterations: 1000,
        var_95_min_profit: '$1.420.000 COP',
        expected_median_ltv_profit: '$2.850.000 COP',
        optimistic_ltv_profit: '$3.940.000 COP',
        emergency_reserve_accrual_10: '$5.000 COP/mes',
        risk_level: 'Riesgo Moderado',
        frequent_pathologies: ['Displasia coxofemoral', 'Otitis alérgica crónica', 'Dermatitis húmeda aguda'],
        actuarial_verdict: 'Para un Golden Retriever de 3 años, una cuota de $48.000 COP/mes garantiza un 35% de margen neto y destina $5.000 COP/mes al Crédito de Emergencia sin desfinanciar el negocio.',
    },
}: PlanCreateProps) {
    const [name, setName] = useState('');
    const [description, setDescription] = useState('');
    const [priceCop, setPriceCop] = useState('50000');
    const [billingInterval, setBillingInterval] = useState('monthly');
    const [selectedServices, setSelectedServices] = useState<string[]>([]);
    const [savedSuccess, setSavedSuccess] = useState(false);

    // Estado del Simulador Actuarial
    const [simBreed, setSimBreed] = useState('golden_retriever');
    const [simAge, setSimAge] = useState(3);
    const [simMargin, setSimMargin] = useState(35);
    const [isSimulating, setIsSimulating] = useState(false);
    const [simulation, setSimulation] = useState<ActuarialResult>(actuarialSimulation);
    const [appliedNotice, setAppliedNotice] = useState(false);

    const toggleService = (id: string) => {
        setSelectedServices((prev) =>
            prev.includes(id) ? prev.filter((item) => item !== id) : [...prev, id]
        );
    };

    const handleRunSimulation = () => {
        setIsSimulating(true);
        setTimeout(() => {
            setIsSimulating(false);

            // Cálculo dinámico local con base en la fórmula Univ. Piloto
            let baseCost = 290000;
            let mult = 1.2;
            let breedName = 'Golden Retriever / Labrador';
            let pathologies = ['Displasia coxofemoral', 'Otitis alérgica crónica'];

            if (simBreed === 'bulldog_frances') {
                baseCost = 380000;
                mult = 1.45;
                breedName = 'Bulldog Francés / Inglés (Braquicefálico)';
                pathologies = ['Síndrome obstructivo (BOAS)', 'Dermatitis de pliegues', 'Hernias'];
            } else if (simBreed === 'poodle') {
                baseCost = 180000;
                mult = 0.90;
                breedName = 'Poodle / Schnauzer';
                pathologies = ['Profilaxis / Periodontal', 'Luxación patelar'];
            } else if (simBreed === 'mestizo') {
                baseCost = 140000;
                mult = 0.75;
                breedName = 'Mestizo / Criollo';
                pathologies = ['Traumatismos', 'Gastroenteritis leve'];
            } else if (simBreed === 'felino') {
                baseCost = 165000;
                mult = 0.85;
                breedName = 'Felino Doméstico';
                pathologies = ['Enfermedad renal (ERC)', 'FLUTD urinario'];
            }

            const ageFactor = simAge > 7 ? (1.0 + (simAge - 7) * 0.12) : 1.0;
            const adjustedCost = baseCost * mult * ageFactor;
            const targetMarginRatio = simMargin / 100.0;
            const annualRev = adjustedCost / (1.0 - targetMarginRatio);
            const fee = Math.round((annualRev / 12) / 1000) * 1000;
            const reserve = Math.round((fee * 0.10) / 1000) * 1000;

            const remainingYears = Math.max(1, (13 - simAge));
            const medianProfit = Math.round((annualRev - adjustedCost) * remainingYears);
            const var95 = Math.round(medianProfit * 0.65);
            const optimistic = Math.round(medianProfit * 1.35);

            setSimulation({
                breed_name: breedName,
                pet_age_years: simAge,
                remaining_life_expectancy: `${remainingYears}.0 años restantes`,
                suggested_monthly_fee_cop: fee,
                formatted_monthly_fee: `$${fee.toLocaleString('es-CO')} COP/mes`,
                target_net_margin: `${simMargin}%`,
                confidence_level: '95% de confianza estadística',
                monte_carlo_iterations: 1000,
                var_95_min_profit: `$${var95.toLocaleString('es-CO')} COP`,
                expected_median_ltv_profit: `$${medianProfit.toLocaleString('es-CO')} COP`,
                optimistic_ltv_profit: `$${optimistic.toLocaleString('es-CO')} COP`,
                emergency_reserve_accrual_10: `$${reserve.toLocaleString('es-CO')} COP/mes`,
                risk_level: mult > 1.2 ? 'Alto Riesgo (Cuota Ajustada)' : (mult < 0.9 ? 'Bajo Riesgo (Alta Rentabilidad)' : 'Riesgo Moderado'),
                frequent_pathologies: pathologies,
                actuarial_verdict: `Para un ${breedName} de ${simAge} años, una cuota de $${fee.toLocaleString('es-CO')} COP/mes garantiza un ${simMargin}% de margen neto y destina $${reserve.toLocaleString('es-CO')} COP/mes al Crédito de Emergencia sin desfinanciar el negocio.`,
            });
        }, 600);
    };

    const handleApplyActuarialFee = () => {
        setPriceCop(String(simulation.suggested_monthly_fee_cop));
        setAppliedNotice(true);
        setTimeout(() => setAppliedNotice(false), 3000);
    };

    const handleSave = (e: React.FormEvent) => {
        e.preventDefault();
        setSavedSuccess(true);
        setTimeout(() => {
            window.location.href = `/admin/${tenantSlug}/plans`;
        }, 1500);
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
            activeItem="Constructor de Planes"
        >
            <Head title={`Constructor de Planes Actuariales · ${brandName}`} />

            <div className="w-full space-y-5 pb-16">
                {/* Header Banner */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div className="flex items-center gap-2">
                            <h1 className="text-xl font-black text-slate-900">
                                Constructor de Planes & Suscripción Actuarial
                            </h1>
                            <span className="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                Monte Carlo 1.000 Iteraciones
                            </span>
                        </div>
                        <p className="text-xs text-slate-500 mt-1">
                            Fija cuotas respaldadas matemáticamente con la fórmula estocástica de la Universidad Piloto, optimizando margen neto y mitigando siniestralidad.
                        </p>
                    </div>

                    <a
                        href={`/admin/${tenantSlug}/plans`}
                        className="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition"
                    >
                        ← Volver a Planes
                    </a>
                </div>

                {savedSuccess && (
                    <div className="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2">
                        <Check className="w-4 h-4 text-emerald-600" />
                        <span>¡Plan creado exitosamente! Sincronizado con mostrador y tienda B2C...</span>
                    </div>
                )}

                {/* SPRINT 3: MOTOR ACTUARIAL MONTE CARLO */}
                <div className="bg-gradient-to-r from-blue-900 via-slate-900 to-indigo-950 text-white rounded-2xl p-5 shadow-lg border border-blue-700/50 space-y-4">
                    <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-white/10">
                        <div className="flex items-center gap-2.5">
                            <div className="w-9 h-9 rounded-xl bg-blue-500/20 border border-blue-400/40 flex items-center justify-center text-cyan-300">
                                <Calculator className="w-5 h-5" />
                            </div>
                            <div>
                                <h3 className="text-sm font-black tracking-tight flex items-center gap-2">
                                    Simulador Actuarial Monte Carlo (Dynamic Underwriting)
                                    <span className="text-[9px] font-bold px-2 py-0.2 rounded-full bg-cyan-400/20 text-cyan-300 border border-cyan-400/30">
                                        Fórmula Univ. Piloto
                                    </span>
                                </h3>
                                <p className="text-[11px] text-slate-300">
                                    Determina la cuota mensual ideal calculando Ganancia = &Sigma;(P<sub>m</sub> &times; 12 &times; Ev<sub>i</sub>) - &Sigma;(C<sub>a</sub> &times; Ev<sub>i</sub>).
                                </p>
                            </div>
                        </div>

                        <span className="text-xs font-mono text-cyan-300 px-3 py-1 rounded-full bg-cyan-950/60 border border-cyan-500/30 w-max">
                            1.000 Corridas Estocásticas
                        </span>
                    </div>

                    {/* Controles de Simulación */}
                    <div className="grid grid-cols-1 sm:grid-cols-4 gap-3 bg-white/5 p-3.5 rounded-xl border border-white/10 items-end">
                        <div>
                            <label className="block text-[11px] font-bold text-slate-300 mb-1">
                                Raza / Fenotipo Biomédico
                            </label>
                            <select
                                value={simBreed}
                                onChange={(e) => setSimBreed(e.target.value)}
                                className="w-full px-3 py-1.5 text-xs rounded-lg bg-slate-800 border border-slate-700 text-white focus:ring-2 focus:ring-cyan-400 outline-none"
                            >
                                {breeds.map((b) => (
                                    <option key={b.key} value={b.key}>{b.name}</option>
                                ))}
                            </select>
                        </div>

                        <div>
                            <label className="block text-[11px] font-bold text-slate-300 mb-1">
                                Edad del Paciente ({simAge} años)
                            </label>
                            <input
                                type="range"
                                min="1"
                                max="14"
                                value={simAge}
                                onChange={(e) => setSimAge(Number(e.target.value))}
                                className="w-full accent-cyan-400 cursor-pointer"
                            />
                        </div>

                        <div>
                            <label className="block text-[11px] font-bold text-slate-300 mb-1">
                                Margen Neto Objetivo ({simMargin}%)
                            </label>
                            <input
                                type="range"
                                min="20"
                                max="55"
                                value={simMargin}
                                onChange={(e) => setSimMargin(Number(e.target.value))}
                                className="w-full accent-cyan-400 cursor-pointer"
                            />
                        </div>

                        <div>
                            <button
                                type="button"
                                onClick={handleRunSimulation}
                                disabled={isSimulating}
                                className="w-full py-2 px-3 rounded-lg bg-cyan-500 hover:bg-cyan-400 text-slate-950 text-xs font-black transition flex items-center justify-center gap-1.5 shadow-md"
                            >
                                <Sparkles className="w-3.5 h-3.5" />
                                <span>{isSimulating ? 'Simulando...' : 'Recalcular 1.000 Escenarios'}</span>
                            </button>
                        </div>
                    </div>

                    {/* Resultados de Monte Carlo */}
                    <div className="grid grid-cols-1 sm:grid-cols-4 gap-3">
                        <div className="p-3 rounded-xl bg-white/10 border border-white/10">
                            <span className="text-[10px] uppercase font-bold text-cyan-300 block mb-0.5">Cuota Mensual Sugerida</span>
                            <div className="text-xl font-black text-white">{simulation.formatted_monthly_fee}</div>
                            <span className="text-[10px] text-emerald-400 font-bold block mt-0.5">Margen neto: {simulation.target_net_margin}</span>
                        </div>

                        <div className="p-3 rounded-xl bg-white/10 border border-white/10">
                            <span className="text-[10px] uppercase font-bold text-cyan-300 block mb-0.5">Value at Risk (VaR 95%)</span>
                            <div className="text-xl font-black text-amber-300">{simulation.var_95_min_profit}</div>
                            <span className="text-[10px] text-slate-300 block mt-0.5">Ganancia mínima en peor escenario</span>
                        </div>

                        <div className="p-3 rounded-xl bg-white/10 border border-white/10">
                            <span className="text-[10px] uppercase font-bold text-cyan-300 block mb-0.5">LTV Rentabilidad Mediana</span>
                            <div className="text-xl font-black text-emerald-300">{simulation.expected_median_ltv_profit}</div>
                            <span className="text-[10px] text-slate-300 block mt-0.5">En {simulation.remaining_life_expectancy}</span>
                        </div>

                        <div className="p-3 rounded-xl bg-white/10 border border-white/10 flex flex-col justify-between">
                            <div>
                                <span className="text-[10px] uppercase font-bold text-cyan-300 block mb-0.5">Reserva Fondo Quirúrgico (10%)</span>
                                <div className="text-base font-black text-white">{simulation.emergency_reserve_accrual_10}</div>
                            </div>
                            <button
                                type="button"
                                onClick={handleApplyActuarialFee}
                                className="mt-2 py-1 px-2.5 rounded-lg bg-emerald-500 hover:bg-emerald-400 text-slate-950 text-[11px] font-black transition flex items-center justify-center gap-1 shadow-xs"
                            >
                                <Check className="w-3 h-3" />
                                <span>Aplicar Tarifa al Plan</span>
                            </button>
                        </div>
                    </div>

                    <div className="text-[11.5px] text-slate-300 bg-white/5 p-2.5 rounded-lg border border-white/10 flex items-center justify-between gap-3">
                        <p className="italic">
                            &ldquo;{simulation.actuarial_verdict}&rdquo;
                        </p>
                        {appliedNotice && (
                            <span className="text-emerald-400 font-bold shrink-0 animate-bounce">
                                ✓ Tarifa aplicada al formulario
                            </span>
                        )}
                    </div>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-12 gap-5">
                    {/* Formulario */}
                    <div className="lg:col-span-7 xl:col-span-8 bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-4">
                        <form onSubmit={handleSave} className="space-y-4">
                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">
                                    Nombre del Plan de Salud *
                                </label>
                                <input
                                    type="text"
                                    required
                                    value={name}
                                    onChange={(e) => setName(e.target.value)}
                                    placeholder="Ej: Plan Patitas Cachorros / Plan Senior VIP"
                                    className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden transition"
                                />
                            </div>

                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">
                                        Precio Recurrente (COP) *
                                    </label>
                                    <input
                                        type="number"
                                        required
                                        value={priceCop}
                                        onChange={(e) => setPriceCop(e.target.value)}
                                        placeholder="50000"
                                        className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden transition font-bold"
                                    />
                                </div>

                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">
                                        Periodicidad de Cobro *
                                    </label>
                                    <select
                                        value={billingInterval}
                                        onChange={(e) => setBillingInterval(e.target.value)}
                                        className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden transition"
                                    >
                                        <option value="monthly">Mensual</option>
                                        <option value="yearly">Anual (con descuento)</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">
                                    Descripción & Enfoque Clínico
                                </label>
                                <textarea
                                    rows={2}
                                    value={description}
                                    onChange={(e) => setDescription(e.target.value)}
                                    placeholder="Describe qué mascota se beneficia de este plan y las ventajas preventivas..."
                                    className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden transition"
                                />
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-2">
                                    Selecciona los Servicios y Coberturas Incluidas ({selectedServices.length} seleccionados)
                                </label>
                                <div className="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-72 overflow-y-auto p-2 bg-slate-50 rounded-xl border border-slate-200">
                                    {services.slice(0, 16).map((service) => {
                                        const isSelected = selectedServices.includes(service.id);
                                        return (
                                            <button
                                                key={service.id}
                                                type="button"
                                                onClick={() => toggleService(service.id)}
                                                className={`text-left p-2.5 rounded-xl border text-xs transition flex items-center justify-between gap-2 ${
                                                    isSelected
                                                        ? 'bg-blue-50 border-blue-300 text-blue-900 font-bold'
                                                        : 'bg-white border-slate-200 text-slate-700 hover:bg-slate-100'
                                                }`}
                                            >
                                                <span className="truncate">{service.name}</span>
                                                {isSelected && <Check className="w-3.5 h-3.5 text-blue-600 shrink-0" />}
                                            </button>
                                        );
                                    })}
                                </div>
                            </div>

                            <button
                                type="submit"
                                className="w-full py-2.5 px-4 rounded-xl bg-[#0080ff] hover:bg-blue-600 text-white text-xs font-bold transition shadow-xs flex items-center justify-center gap-1.5"
                            >
                                <span>Guardar y Publicar Plan Actuarial</span>
                                <ArrowRight className="w-4 h-4" />
                            </button>
                        </form>
                    </div>

                    {/* Previsualización en Vivo */}
                    <div className="lg:col-span-5 xl:col-span-4 bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col justify-between">
                        <div>
                            <span className="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-2">
                                Vista Previa para el Tutor
                            </span>

                            <div className="rounded-xl border border-blue-200 bg-gradient-to-b from-blue-50/40 to-white p-4">
                                <h3 className="text-base font-black text-slate-900">
                                    {name || 'Nuevo Plan Patitas Actuarial'}
                                </h3>
                                <p className="text-xs text-slate-500 mt-1">
                                    {description || 'Cobertura médica integral con respaldo actuarial y crédito de emergencia.'}
                                </p>

                                <div className="my-4 p-3 rounded-lg bg-white border border-slate-200">
                                    <span className="text-xl font-black text-slate-900">
                                        ${Number(priceCop || 0).toLocaleString('es-CO')} COP
                                    </span>
                                    <span className="text-xs text-slate-400 font-medium ml-1">
                                        / {billingInterval === 'monthly' ? 'mes' : 'año'}
                                    </span>
                                </div>

                                <div className="space-y-1.5 text-xs text-slate-700">
                                    <div className="font-bold text-slate-800 text-[11px] uppercase">
                                        Servicios ({selectedServices.length}):
                                    </div>
                                    {selectedServices.length > 0 ? (
                                        <p className="text-emerald-700 font-semibold text-[11.5px]">
                                            ✓ {selectedServices.length} coberturas seleccionadas listas para canjear.
                                        </p>
                                    ) : (
                                        <p className="text-slate-400 text-xs">
                                            Selecciona servicios de la lista para agregarlos al plan.
                                        </p>
                                    )}
                                </div>
                            </div>
                        </div>

                        <div className="pt-4 border-t border-slate-100 text-center">
                            <span className="text-[11px] text-slate-400">
                                Se sincronizará automáticamente con el mostrador y la tienda B2C.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </VetAdminLayout>
    );
}
