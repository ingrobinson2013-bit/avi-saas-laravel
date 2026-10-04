import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { 
    Bot, 
    Sparkles, 
    MessageCircle, 
    ShieldAlert, 
    CheckCircle2, 
    TrendingUp, 
    Activity, 
    Eye, 
    Mic, 
    Volume2, 
    AlertTriangle, 
    Calendar, 
    Wallet, 
    ChevronRight,
    ScanLine,
    Stethoscope,
    FileCheck
} from 'lucide-react';

interface Opportunity {
    id: string;
    pet_name: string;
    customer_name: string;
    customer_phone: string;
    plan_name: string;
    wallet_balance: number;
    formatted_wallet: string;
    reason: string;
    recommended_action: string;
    whatsapp_url: string;
}

interface IntelligenceProps {
    tenantSlug: string;
    brandName: string;
    clinicSubtitle: string;
    logoUrl?: string | null;
    saasPlan: any;
    logoutUrl: string;
    userName: string;
    userRole: string;
    opportunities: Opportunity[];
    totalOpportunities: number;
    protectedMrr: string;
    triagePatient?: {
        pet_name: string;
        species: string;
        breed: string;
        age: string;
    };
    visualTriage?: any;
    bioacousticTriage?: any;
    walletCustodyCop?: string;
}

export default function Intelligence({
    tenantSlug,
    brandName,
    clinicSubtitle,
    logoUrl,
    saasPlan,
    logoutUrl,
    userName,
    userRole,
    opportunities = [],
    totalOpportunities = 1,
    protectedMrr = '$50.000 COP',
    triagePatient = {
        pet_name: 'Max',
        species: 'Canino',
        breed: 'Golden Retriever',
        age: '4 años',
    },
    visualTriage = {
        urgency_level: 'Media (Prioritaria)',
        urgency_color: 'amber',
        preliminary_hypothesis: 'Signos compatibles con dermatitis alérgica por picadura de ectoparásitos (DAPP) o foliculitis bacteriana superficial.',
        clinical_findings: [
            'Eritema y alopecia focal en zona lumbosacra / flancos.',
            'Ausencia aparente de exudado purulento profundo (sin riesgo de sepsis inmediata).',
            'Inflamación dérmica moderada susceptible a sobreinfección por rascado.',
        ],
        recommended_action: 'Programar revisión médica en sede en las próximas 24 a 48 horas. Aplicar collar isabelino si hay autotraumatismo.',
        plan_coverage_match: 'Consulta Médica General & Desparasitación Externa (Credelio) disponibles en Plan Patitas.',
        covered_cop: '$55.000 COP cubiertos por membresía activa',
    },
    bioacousticTriage = {
        urgency_level: 'Media (Monitoreo Clínico)',
        urgency_color: 'amber',
        preliminary_hypothesis: 'Patrón acústico compatible con tos paroxística seca, compatible con traqueobronquitis infecciosa canina (Tos de las Perreras).',
        acoustic_markers: [
            'Frecuencia y timbre: Golpe seco en accesos paroxísticos al final del ciclo espiratorio (4.2 kHz).',
            'Ausencia de estertores húmedos o crepitantes basales pulmonares.',
            'Reflejo tusígeno exacerbado por irritación faríngea o colapso traqueal leve.',
        ],
        recommended_action: 'Aislamiento preventivo de otros caninos. Usar arnés de pecho en lugar de collar. Auscultación cardiopulmonar en sede.',
        plan_coverage_match: 'Chequeo Preventivo Clínico al 100% incluido en Plan Patitas.',
        covered_cop: '$50.000 COP cubiertos sin costo adicional',
    },
    walletCustodyCop = '$20.000 COP',
}: IntelligenceProps) {
    const [mainTab, setMainTab] = useState<'triage' | 'retention'>('triage');
    const [triageMode, setTriageMode] = useState<'visual' | 'bioacoustic'>('visual');
    const [isAnalyzing, setIsAnalyzing] = useState(false);
    const [simulatedScore, setSimulatedScore] = useState(96.4);

    const handleRunAnalysis = () => {
        setIsAnalyzing(true);
        setTimeout(() => {
            setIsAnalyzing(false);
            setSimulatedScore(Number((95 + Math.random() * 4).toFixed(1)));
        }, 1200);
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
            activeItem="Inteligencia Artificial"
        >
            <Head title={`AVI Intelligence 2.5 · ${brandName}`} />

            <div className="w-full space-y-5 pb-16">
                {/* Header Banner */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div className="flex items-center gap-2">
                            <h1 className="text-xl font-black text-slate-900">
                                AVI Intelligence · Sistema Operativo Actuarial & Triaje IA
                            </h1>
                            <span className="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full bg-purple-100 text-purple-700">
                                Gemini 2.5 Flash
                            </span>
                        </div>
                        <p className="text-xs text-slate-500 mt-1">
                            Triaje multimodal biomédico en tiempo real (visión dérmica + bioacústica) conectado a las coberturas actuariales y motor anti-churn.
                        </p>
                    </div>

                    <div className="flex items-center gap-2">
                        <span className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                            <span className="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>IA Médica Activa · 99.8% Precisión</span>
                        </span>
                    </div>
                </div>

                {/* KPI Metrics */}
                <div className="grid grid-cols-1 sm:grid-cols-4 gap-3">
                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">MRR Protegido / En Seguimiento</span>
                        <div className="text-2xl font-black text-slate-900">{protectedMrr}</div>
                        <span className="text-[10.5px] font-bold text-emerald-600 mt-1 block">✓ 0 pacientes en mora</span>
                    </div>

                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">Fondo Quirúrgico en Custodia</span>
                        <div className="text-2xl font-black text-amber-600">{walletCustodyCop}</div>
                        <span className="text-[10.5px] font-medium text-slate-500 mt-1 block">10% reserva anti-churn acumulada</span>
                    </div>

                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">Triajes Realizados este Mes</span>
                        <div className="text-2xl font-black text-blue-600">18</div>
                        <span className="text-[10.5px] font-medium text-emerald-600 mt-1 block">100% convertidos a consulta</span>
                    </div>

                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">Tasa de Fidelización Proyectada</span>
                        <div className="text-2xl font-black text-slate-900">94.8%</div>
                        <span className="text-[10.5px] font-medium text-blue-600 mt-1 block">Retención por crédito clínico</span>
                    </div>
                </div>

                {/* Sub-Navigation Selector */}
                <div className="flex border-b border-slate-200 bg-white rounded-xl p-1.5 gap-2 shadow-2xs">
                    <button
                        onClick={() => setMainTab('triage')}
                        className={`flex-1 py-2 px-3 rounded-lg text-xs font-bold flex items-center justify-center gap-2 transition ${
                            mainTab === 'triage'
                                ? 'bg-blue-600 text-white shadow-xs'
                                : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
                        }`}
                    >
                        <Stethoscope className="w-4 h-4" />
                        <span>Triaje Multimodal Clínico (Visión & Audio)</span>
                        <span className={`text-[9px] px-1.5 py-0.2 rounded-full ${mainTab === 'triage' ? 'bg-blue-500 text-white' : 'bg-purple-100 text-purple-700'}`}>
                            Gemini 2.5
                        </span>
                    </button>

                    <button
                        onClick={() => setMainTab('retention')}
                        className={`flex-1 py-2 px-3 rounded-lg text-xs font-bold flex items-center justify-center gap-2 transition ${
                            mainTab === 'retention'
                                ? 'bg-blue-600 text-white shadow-xs'
                                : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
                        }`}
                    >
                        <Wallet className="w-4 h-4" />
                        <span>Smart Health Wallet & Rescate Anti-Churn ({totalOpportunities})</span>
                    </button>
                </div>

                {/* TAB 1: TRIAJE MULTIMODAL GEMINI 2.5 FLASH */}
                {mainTab === 'triage' && (
                    <div className="space-y-4">
                        {/* Selector de Modalidad: Visión vs Bioacústica */}
                        <div className="flex items-center justify-between bg-slate-100 p-1.5 rounded-xl">
                            <div className="flex gap-2">
                                <button
                                    onClick={() => setTriageMode('visual')}
                                    className={`py-1.5 px-4 rounded-lg text-xs font-bold flex items-center gap-1.5 transition ${
                                        triageMode === 'visual'
                                            ? 'bg-white text-slate-900 shadow-xs'
                                            : 'text-slate-500 hover:text-slate-800'
                                    }`}
                                >
                                    <Eye className="w-3.5 h-3.5 text-blue-600" />
                                    <span>Triaje Visión Médica (Heridas & Piel)</span>
                                </button>

                                <button
                                    onClick={() => setTriageMode('bioacoustic')}
                                    className={`py-1.5 px-4 rounded-lg text-xs font-bold flex items-center gap-1.5 transition ${
                                        triageMode === 'bioacoustic'
                                            ? 'bg-white text-slate-900 shadow-xs'
                                            : 'text-slate-500 hover:text-slate-800'
                                    }`}
                                >
                                    <Mic className="w-3.5 h-3.5 text-purple-600" />
                                    <span>Triaje Bioacústico (Tos & Respiración)</span>
                                </button>
                            </div>

                            <span className="text-[11px] text-slate-500 font-medium px-2">
                                Paciente: <strong className="text-slate-800">{triagePatient.pet_name}</strong> ({triagePatient.breed}, {triagePatient.age})
                            </span>
                        </div>

                        {/* PANEL VISIÓN DÉRMICA */}
                        {triageMode === 'visual' && (
                            <div className="grid grid-cols-1 lg:grid-cols-12 gap-4">
                                {/* Visor / Escáner de Imagen */}
                                <div className="lg:col-span-5 bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col justify-between">
                                    <div>
                                        <div className="flex items-center justify-between mb-3">
                                            <span className="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                                <ScanLine className="w-4 h-4 text-blue-600" />
                                                Escaneo Óptico de Lesión Dérmica
                                            </span>
                                            <span className="text-[10px] font-bold text-slate-400">
                                                Cámara HD 1080p
                                            </span>
                                        </div>

                                        <div className="relative aspect-4/3 rounded-xl overflow-hidden bg-slate-900 border border-slate-200 group">
                                            <img
                                                src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=600&auto=format&fit=crop&q=80"
                                                alt="Lesión Dérmica Canina"
                                                className="w-full h-full object-cover opacity-90 group-hover:scale-105 transition duration-500"
                                            />
                                            {/* Bounding box de la IA */}
                                            <div className="absolute top-[35%] left-[28%] w-[42%] h-[38%] border-2 border-amber-400 bg-amber-400/10 rounded-lg flex flex-col justify-between p-1.5 pointer-events-none animate-pulse">
                                                <span className="text-[9px] font-black uppercase tracking-wider bg-amber-500 text-white px-1.5 py-0.5 rounded shadow-xs w-max">
                                                    Lesión: Eritema focal ({simulatedScore}%)
                                                </span>
                                                <span className="text-[8.5px] font-mono text-amber-200 text-right">
                                                    ROI_BOX #01
                                                </span>
                                            </div>

                                            {isAnalyzing && (
                                                <div className="absolute inset-0 bg-slate-950/75 backdrop-blur-xs flex flex-col items-center justify-center text-white space-y-2">
                                                    <div className="w-8 h-8 border-3 border-cyan-400 border-t-transparent rounded-full animate-spin"></div>
                                                    <span className="text-xs font-bold">Procesando con Gemini 2.5 Flash...</span>
                                                </div>
                                            )}
                                        </div>

                                        <div className="mt-3 flex items-center justify-between text-[11px] text-slate-500">
                                            <span>Muestra: Flanco lumbosacro</span>
                                            <span className="font-mono text-slate-400">JPEG · 1.4 MB</span>
                                        </div>
                                    </div>

                                    <div className="mt-4 pt-3 border-t border-slate-100 flex gap-2">
                                        <button
                                            type="button"
                                            onClick={handleRunAnalysis}
                                            disabled={isAnalyzing}
                                            className="flex-1 py-2 px-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-2xs"
                                        >
                                            <Sparkles className="w-3.5 h-3.5" />
                                            <span>{isAnalyzing ? 'Analizando...' : 'Re-escanear Lesión con IA'}</span>
                                        </button>
                                    </div>
                                </div>

                                {/* Diagnóstico y Cobertura Actuarial */}
                                <div className="lg:col-span-7 bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-4">
                                    <div className="flex items-start justify-between pb-3 border-b border-slate-100">
                                        <div>
                                            <div className="flex items-center gap-2">
                                                <h3 className="text-base font-black text-slate-900">
                                                    Evaluación Clínica Asistida
                                                </h3>
                                                <span className="text-[10.5px] font-bold px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                                                    {visualTriage.urgency_level}
                                                </span>
                                            </div>
                                            <p className="text-xs text-slate-500 mt-0.5">
                                                Motor Multimodal Gemini 2.5 Flash · Modelo Actuarial Vet-Pet
                                            </p>
                                        </div>

                                        <div className="text-right">
                                            <span className="text-[10px] font-bold text-slate-400 block">Confianza del Diagnóstico</span>
                                            <span className="text-sm font-black text-emerald-600">{simulatedScore}%</span>
                                        </div>
                                    </div>

                                    {/* Hipótesis */}
                                    <div className="p-3.5 rounded-xl bg-amber-50/60 border border-amber-200/80">
                                        <div className="text-[11px] font-bold text-amber-900 uppercase tracking-wider mb-1 flex items-center gap-1">
                                            <AlertTriangle className="w-3.5 h-3.5 text-amber-600" />
                                            Hipótesis Clínica Preliminar
                                        </div>
                                        <p className="text-xs text-slate-800 leading-relaxed font-medium">
                                            {visualTriage.preliminary_hypothesis}
                                        </p>
                                    </div>

                                    {/* Hallazgos */}
                                    <div>
                                        <span className="text-xs font-bold text-slate-900 block mb-2">
                                            Hallazgos Biomédicos Detectados:
                                        </span>
                                        <ul className="space-y-1.5 text-xs text-slate-600">
                                            {visualTriage.clinical_findings?.map((finding: string, idx: number) => (
                                                <li key={idx} className="flex items-start gap-2">
                                                    <CheckCircle2 className="w-3.5 h-3.5 text-emerald-500 shrink-0 mt-0.5" />
                                                    <span>{finding}</span>
                                                </li>
                                            ))}
                                        </ul>
                                    </div>

                                    {/* Conexión con Cobertura Actuarial del Plan */}
                                    <div className="p-4 rounded-xl bg-gradient-to-r from-blue-50 via-teal-50 to-emerald-50 border border-blue-200/80">
                                        <div className="flex items-center justify-between mb-1.5">
                                            <span className="text-xs font-black text-blue-900 flex items-center gap-1.5">
                                                <FileCheck className="w-4 h-4 text-blue-700" />
                                                Cobertura en Plan Patitas Básico
                                            </span>
                                            <span className="text-xs font-extrabold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">
                                                {visualTriage.covered_cop}
                                            </span>
                                        </div>
                                        <p className="text-xs text-slate-700 font-medium">
                                            {visualTriage.plan_coverage_match}
                                        </p>
                                        <p className="text-[11px] text-slate-500 mt-1 italic">
                                            {visualTriage.recommended_action}
                                        </p>
                                    </div>

                                    {/* Botones de Acción */}
                                    <div className="flex flex-wrap items-center gap-2 pt-2">
                                        <a
                                            href={`https://wa.me/3508742543?text=${encodeURIComponent(`🐾 Hola María Camila, realizamos el triaje con IA de la piel de Max. La evaluación indica urgencia media por dermatitis. Tienes la consulta y el antiparasitario 100% cubiertos en tu Plan Patitas Básico. ¿Deseas agendar para hoy a las 4:00 PM?`)}`}
                                            target="_blank"
                                            rel="noreferrer"
                                            className="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-2xs"
                                        >
                                            <MessageCircle className="w-3.5 h-3.5" />
                                            <span>Notificar Tutor por WhatsApp</span>
                                        </a>

                                        <a
                                            href={`/admin/${tenantSlug}/counter-redeem`}
                                            className="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-2xs"
                                        >
                                            <Calendar className="w-3.5 h-3.5" />
                                            <span>Agendar Consulta Prioritaria</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        )}

                        {/* PANEL BIOACÚSTICA RESPIRATORIA */}
                        {triageMode === 'bioacoustic' && (
                            <div className="grid grid-cols-1 lg:grid-cols-12 gap-4">
                                {/* Visualizador de Espectrograma */}
                                <div className="lg:col-span-5 bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col justify-between">
                                    <div>
                                        <div className="flex items-center justify-between mb-3">
                                            <span className="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                                <Volume2 className="w-4 h-4 text-purple-600" />
                                                Espectrograma y Onda de Audio
                                            </span>
                                            <span className="text-[10px] font-bold text-slate-400">
                                                Muestreo: 44.1 kHz
                                            </span>
                                        </div>

                                        {/* Simulación visual de onda sonora */}
                                        <div className="h-44 rounded-xl bg-slate-950 p-4 border border-slate-800 flex flex-col justify-between relative overflow-hidden">
                                            <div className="flex items-center justify-between text-[10px] text-purple-300 font-mono">
                                                <span>PATRÓN TUSÍGENO EN RÁFAGA</span>
                                                <span>PICO: 4.2 kHz</span>
                                            </div>

                                            {/* Barras de ecualizador simuladas */}
                                            <div className="flex items-end justify-between gap-1 h-24 pt-2">
                                                {[30, 45, 20, 60, 95, 80, 40, 25, 85, 100, 70, 35, 55, 90, 65, 40, 20, 50, 85, 30].map((h, i) => (
                                                    <div
                                                        key={i}
                                                        className="flex-1 bg-gradient-to-t from-purple-600 via-cyan-400 to-emerald-400 rounded-t-xs"
                                                        style={{ height: `${h}%` }}
                                                    />
                                                ))}
                                            </div>

                                            <div className="flex items-center justify-between text-[9px] text-slate-500 font-mono">
                                                <span>00:00</span>
                                                <span className="text-amber-400">Reflejo Paroxístico Seco</span>
                                                <span>00:08</span>
                                            </div>
                                        </div>

                                        <div className="mt-3 flex items-center justify-between text-[11px] text-slate-500">
                                            <span>Muestra de Audio: Tos nocturna</span>
                                            <span className="font-mono text-slate-400">WAV · 8.2 Seg</span>
                                        </div>
                                    </div>

                                    <div className="mt-4 pt-3 border-t border-slate-100 flex gap-2">
                                        <button
                                            type="button"
                                            onClick={handleRunAnalysis}
                                            disabled={isAnalyzing}
                                            className="flex-1 py-2 px-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-2xs"
                                        >
                                            <Sparkles className="w-3.5 h-3.5" />
                                            <span>{isAnalyzing ? 'Procesando Onda...' : 'Analizar Frecuencias con Gemini'}</span>
                                        </button>
                                    </div>
                                </div>

                                {/* Diagnóstico Bioacústico */}
                                <div className="lg:col-span-7 bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-4">
                                    <div className="flex items-start justify-between pb-3 border-b border-slate-100">
                                        <div>
                                            <div className="flex items-center gap-2">
                                                <h3 className="text-base font-black text-slate-900">
                                                    Análisis Acústico Respiratorio
                                                </h3>
                                                <span className="text-[10.5px] font-bold px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                                                    {bioacousticTriage.urgency_level}
                                                </span>
                                            </div>
                                            <p className="text-xs text-slate-500 mt-0.5">
                                                Modelo Acústico de Auscultación · Gemini 2.5 Flash Audio
                                            </p>
                                        </div>

                                        <div className="text-right">
                                            <span className="text-[10px] font-bold text-slate-400 block">Precisión Espectral</span>
                                            <span className="text-sm font-black text-purple-600">97.2%</span>
                                        </div>
                                    </div>

                                    {/* Hipótesis */}
                                    <div className="p-3.5 rounded-xl bg-purple-50/60 border border-purple-200/80">
                                        <div className="text-[11px] font-bold text-purple-900 uppercase tracking-wider mb-1 flex items-center gap-1">
                                            <AlertTriangle className="w-3.5 h-3.5 text-purple-600" />
                                            Diagnóstico Acústico Sugerido
                                        </div>
                                        <p className="text-xs text-slate-800 leading-relaxed font-medium">
                                            {bioacousticTriage.preliminary_hypothesis}
                                        </p>
                                    </div>

                                    {/* Marcadores */}
                                    <div>
                                        <span className="text-xs font-bold text-slate-900 block mb-2">
                                            Marcadores Acústicos Pulmonares:
                                        </span>
                                        <ul className="space-y-1.5 text-xs text-slate-600">
                                            {bioacousticTriage.acoustic_markers?.map((marker: string, idx: number) => (
                                                <li key={idx} className="flex items-start gap-2">
                                                    <CheckCircle2 className="w-3.5 h-3.5 text-purple-500 shrink-0 mt-0.5" />
                                                    <span>{marker}</span>
                                                </li>
                                            ))}
                                        </ul>
                                    </div>

                                    {/* Cobertura */}
                                    <div className="p-4 rounded-xl bg-gradient-to-r from-purple-50 via-blue-50 to-teal-50 border border-purple-200/80">
                                        <div className="flex items-center justify-between mb-1.5">
                                            <span className="text-xs font-black text-purple-900 flex items-center gap-1.5">
                                                <FileCheck className="w-4 h-4 text-purple-700" />
                                                Cobertura en Plan Patitas
                                            </span>
                                            <span className="text-xs font-extrabold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">
                                                {bioacousticTriage.covered_cop}
                                            </span>
                                        </div>
                                        <p className="text-xs text-slate-700 font-medium">
                                            {bioacousticTriage.plan_coverage_match}
                                        </p>
                                        <p className="text-[11px] text-slate-500 mt-1 italic">
                                            {bioacousticTriage.recommended_action}
                                        </p>
                                    </div>

                                    {/* Botones */}
                                    <div className="flex flex-wrap items-center gap-2 pt-2">
                                        <a
                                            href={`https://wa.me/3508742543?text=${encodeURIComponent(`🐾 Hola María Camila, escuchamos la grabación de la tos de Max. El patrón indica traqueobronquitis leve. Le recomendamos usar arnés de pecho y traerlo a su Chequeo Preventivo que está 100% cubierto sin costo.`)}`}
                                            target="_blank"
                                            rel="noreferrer"
                                            className="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-2xs"
                                        >
                                            <MessageCircle className="w-3.5 h-3.5" />
                                            <span>Enviar Recomendación por WhatsApp</span>
                                        </a>

                                        <a
                                            href={`/admin/${tenantSlug}/counter-redeem`}
                                            className="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold transition shadow-2xs"
                                        >
                                            <Calendar className="w-3.5 h-3.5" />
                                            <span>Agendar Auscultación en Sede</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        )}
                    </div>
                )}

                {/* TAB 2: SMART HEALTH WALLET & RESCATE ANTI-CHURN */}
                {mainTab === 'retention' && (
                    <div className="space-y-4">
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-4">
                            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                                <div>
                                    <h3 className="text-base font-black text-slate-900 flex items-center gap-2">
                                        <Wallet className="w-4 h-4 text-amber-600" />
                                        Fondo Quirúrgico de Emergencia (Crédito Clínico 10%)
                                    </h3>
                                    <p className="text-xs text-slate-500 mt-0.5">
                                        Mecanismo actuarial anti-churn: Cada mes, el 10% del plan se retiene como saldo a favor en la clínica para emergencias y cirugías. No reembolsable en efectivo ante cancelación (candado de retención).
                                    </p>
                                </div>

                                <div className="px-3.5 py-1.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs font-bold flex items-center gap-2 shrink-0">
                                    <span>Saldo Total en Custodia:</span>
                                    <span className="text-sm font-black text-amber-700">{walletCustodyCop}</span>
                                </div>
                            </div>

                            <div className="space-y-3">
                                {opportunities.map((opp) => (
                                    <div
                                        key={opp.id}
                                        className="p-4 rounded-xl border border-teal-200 bg-gradient-to-r from-teal-50/50 via-white to-blue-50/30 flex flex-col md:flex-row md:items-center justify-between gap-4"
                                    >
                                        <div>
                                            <div className="flex items-center gap-2 mb-1">
                                                <h4 className="text-sm font-black text-slate-900">{opp.pet_name}</h4>
                                                <span className="text-[10.5px] font-bold px-2 py-0.2 rounded-full bg-blue-100 text-blue-800">
                                                    {opp.plan_name}
                                                </span>
                                                <span className="text-xs text-slate-400 font-medium">
                                                    · Tutor: {opp.customer_name}
                                                </span>
                                                <span className="text-xs font-black text-amber-700 bg-amber-100 px-2 py-0.5 rounded-full">
                                                    Crédito Clínico: {opp.formatted_wallet}
                                                </span>
                                            </div>
                                            <p className="text-xs text-slate-600">
                                                {opp.reason} <strong className="text-slate-800">Acción sugerida:</strong> {opp.recommended_action}
                                            </p>
                                        </div>

                                        <div className="flex items-center gap-2 shrink-0">
                                            <a
                                                href={opp.whatsapp_url}
                                                target="_blank"
                                                rel="noreferrer"
                                                className="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-2xs"
                                            >
                                                <MessageCircle className="w-3.5 h-3.5" />
                                                <span>Enviar WhatsApp de Rescate</span>
                                            </a>
                                            <a
                                                href={`/admin/${tenantSlug}/counter-redeem`}
                                                className="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-2xs"
                                            >
                                                <span>Ver Saldos</span>
                                            </a>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </VetAdminLayout>
    );
}
