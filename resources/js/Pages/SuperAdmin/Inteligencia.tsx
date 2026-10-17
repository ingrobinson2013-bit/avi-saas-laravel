import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/react';
import SuperAdminLayout from '@/Layouts/SuperAdminLayout';
import {
    Sparkles,
    TrendingUp,
    Building2,
    PawPrint,
    ShieldCheck,
    AlertTriangle,
    CheckCircle2,
    Clock,
    MessageCircle,
    Copy,
    Check,
    Bot,
    MapPin,
    ArrowRight,
    Zap,
    Activity,
    ExternalLink,
    Send
} from 'lucide-react';

interface ClinicInsight {
    id: string;
    name: string;
    slug: string;
    city: string;
    doctor_name: string;
    status: string;
    plan_tier: string;
    monthly_fee: number;
    pets_count: number;
    subscriptions_count: number;
    plans_count: number;
    health_score: number;
    category: 'cleanup' | 'onboarding' | 'upsell' | 'healthy';
    priority: 'warning' | 'success' | 'error';
    badge: string;
    diagnosis: string;
    action_label: string;
    action_url: string;
    storefront_url: string;
}

interface CityStat {
    city: string;
    total: number;
    pending: number;
}

interface InteligenciaProps {
    metrics: {
        mrr: number;
        gmv: number;
        activeClinics: number;
        totalClinics: number;
        totalPets: number;
        totalSubscriptions: number;
        totalRedemptions: number;
        totalProspectos: number;
        contactadosCount: number;
        interesadosCount: number;
    };
    clinicInsights: ClinicInsight[];
    topCities: CityStat[];
    aiEngine: {
        geminiReady: boolean;
        geminiModel: string;
        fastApiUrl: string;
    };
    userName?: string;
    userEmail?: string;
}

const COPILOT_PRESETS = [
    {
        id: 'whatsapp_socias',
        label: 'Invitación Veterinaria Socia (WhatsApp)',
        desc: 'Primer contacto en frío para dueños de clínica con propuesta de exclusividad zonal y 15 días gratis.',
        defaultText: `Hola Dr(a)., te saluda Robinson Naranjo de AviPetApp.\n\nEstamos seleccionando 1 clínica veterinaria socia en tu zona para activar su propio programa de planes de salud para mascotas (con carnets digitales QR, recordatorios por WhatsApp y 0 % de comisión sobre tus cobros).\n\nLa clínica piloto en Cajicá (Vet-Pet Patitas) ya genera ingresos recurrentes todos los meses con sus propios pacientes. Tienes 15 días de prueba sin costo y el modelo de arranque de cero riesgo ($5.000 COP por mascota activa).\n\n¿Te comparto el enlace de cómo se vería la vitrina con el logo de tu clínica?`
    },
    {
        id: 'objecion_software',
        label: 'Objeción: "Ya tengo software médico"',
        desc: 'Explica cómo AviPetApp convive con SoftVet, Gesvet o Vetlogy sin migrar historias clínicas.',
        defaultText: `Excelente que ya tengas software de historia clínica, Doctor(a). Precisamente AviPetApp NO te obliga a cambiar tu sistema actual ni migrar historias médicas.\n\nAviPetApp funciona en paralelo como tu vitrina comercial de membresías y carnet digital QR en recepción: el tutor escanea el afiche en sala de espera, se afilia a tu plan preventivo y tu recepción valida en 3 segundos qué vacunas o consultas tiene disponibles. Así conviertes pacientes ocasionales en ingresos mensuales predecibles sin tocar tu historia clínica actual.`
    },
    {
        id: 'objecion_riesgo',
        label: 'Objeción: "No quiero otro gasto fijo mensual"',
        desc: 'Presenta el modelo prepago de $5.000 COP por mascota activa (paquete de $50.000 por 10 mascotas).',
        defaultText: `Totalmente comprensible, Doctor(a). Por eso diseñamos la modalidad de Cero Riesgo de AviPetApp:\n\n1. Tienes 15 días gratis sin tarjeta de crédito para configurar tus planes y tu Afiche QR.\n2. Al terminar la prueba, no estás obligado a pagar una mensualidad alta: puedes activar un paquete prepago de 10 mascotas por solo $50.000 COP ($5.000 por mascota).\n3. Con solo 2 mascotas afiliadas a un plan de $50.000/mes, tu clínica recauda $100.000 COP (100 % directo a tu Nequi o Bancolombia) y el software se paga solo desde el primer día.`
    },
    {
        id: 'reactivacion_base',
        label: 'Plantilla para que la Clínica reactive su base de clientes',
        desc: 'Mensaje listo para que la veterinaria socia envíe por difusión de WhatsApp a sus tutores.',
        defaultText: `Hola [Nombre del Tutor], te escribimos de [Nombre de la Clínica] 🐾.\n\nRevisando el historial preventivo de [Nombre de la Mascota], queremos invitarte a conocer nuestro nuevo Plan de Salud Preventiva: incluye sus consultas del año, esquema de vacunación anual, desparasitaciones trimestrales y carnet digital con descuentos exclusivos por solo $50.000 COP al mes.\n\nPuedes ver los beneficios y activar el carnet digital de [Nombre de la Mascota] aquí: https://tu-clinica.avipetapp.com`
    }
];

export default function Inteligencia({
    metrics,
    clinicInsights = [],
    topCities = [],
    aiEngine,
    userName = 'Robinson Naranjo',
    userEmail = 'contacto@avipetapp.com'
}: InteligenciaProps) {
    const [selectedPreset, setSelectedPreset] = useState(COPILOT_PRESETS[0]);
    const [customContext, setCustomContext] = useState('');
    const [generatedText, setGeneratedText] = useState(COPILOT_PRESETS[0].defaultText);
    const [isGenerating, setIsGenerating] = useState(false);
    const [copiedScript, setCopiedScript] = useState(false);

    const formatCOP = (val: number) =>
        new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            maximumFractionDigits: 0
        }).format(val || 0);

    const handleSelectPreset = (preset: (typeof COPILOT_PRESETS)[0]) => {
        setSelectedPreset(preset);
        setGeneratedText(preset.defaultText);
        setCopiedScript(false);
    };

    const handleGenerateAI = async (e: React.FormEvent) => {
        e.preventDefault();
        setIsGenerating(true);
        setCopiedScript(false);

        try {
            const response = await fetch('/super-admin/inteligencia/ask', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json'
                },
                body: JSON.stringify({
                    prompt_type: selectedPreset.id,
                    custom_context: customContext
                })
            });

            if (response.ok) {
                const data = await response.json();
                if (data.suggestion) {
                    setGeneratedText(data.suggestion);
                }
            }
        } catch {
            // Mantiene el texto base si no hay red
        } finally {
            setIsGenerating(false);
        }
    };

    const handleCopyScript = () => {
        navigator.clipboard.writeText(generatedText);
        setCopiedScript(true);
        setTimeout(() => setCopiedScript(false), 2000);
    };

    return (
        <SuperAdminLayout userName={userName} userEmail={userEmail} activeItem="Inteligencia">
            <Head title="Inteligencia SaaS · AviPetApp Superadmin" />

            <div className="space-y-6 w-full text-[#15213B]">
                {/* HEADER */}
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#6D28D9]/10 text-[#6D28D9] text-xs font-semibold mb-2">
                            <Sparkles className="w-3.5 h-3.5" />
                            <span>Centro de Inteligencia B2B · AviPetApp</span>
                        </div>
                        <h1 className="text-[28px] sm:text-[32px] font-bold text-[#15213B] tracking-tight leading-tight">
                            Inteligencia y crecimiento de la red
                        </h1>
                        <p className="text-sm text-[#5C6B85] mt-1">
                            Radar de retención de clínicas, embudo comercial B2B y copiloto estratégico con supervisión humana.
                        </p>
                    </div>

                    <div className="flex items-center gap-2 shrink-0">
                        <span className="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs font-semibold text-[#15213B]">
                            <span className="w-2 h-2 rounded-full bg-[#0F9F9A]" />
                            <span>Motor IA: {aiEngine?.geminiModel || 'gemini-2.5-flash'}</span>
                        </span>
                    </div>
                </div>

                {/* AVISO ÉTICO OFICIAL DEL MANUAL MAESTRO DE MARCA v1.1 (Pág. 4) */}
                <div className="p-3.5 rounded-xl bg-white border border-[#6D28D9]/25 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs">
                    <div className="flex items-center gap-2 text-[#15213B]">
                        <Bot className="w-4 h-4 text-[#6D28D9] shrink-0" />
                        <span>
                            <b>Aviso de IA:</b> Sugerencia generada con IA. Revísala antes de usarla en una decisión comercial o clínica. La IA organiza información; el criterio profesional es de tu equipo.
                        </span>
                    </div>
                    <span className="text-[11px] font-semibold text-[#5C6B85] shrink-0">
                        Manual Maestro v1.1
                    </span>
                </div>

                {/* 4 KPI CARDS (Regla de datos Manual Maestro v1.1 Pág. 9: MRR vs GMV separados con definición visible) */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 tabular-nums">
                    <div className="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-2xs">
                        <div className="flex items-center justify-between">
                            <span className="text-xs font-semibold uppercase tracking-wider text-[#5C6B85]">
                                MRR Plataforma SaaS
                            </span>
                            <div className="w-9 h-9 rounded-xl bg-[#6D28D9]/10 text-[#6D28D9] flex items-center justify-center">
                                <TrendingUp className="w-4 h-4" />
                            </div>
                        </div>
                        <div className="text-2xl font-bold text-[#15213B] mt-2">
                            {formatCOP(metrics.mrr)}
                        </div>
                        <p className="text-[11px] text-[#5C6B85] mt-1">
                            Ingreso recurrente mensual de AviPetApp ({metrics.activeClinics} clínica activa)
                        </p>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-2xs">
                        <div className="flex items-center justify-between">
                            <span className="text-xs font-semibold uppercase tracking-wider text-[#5C6B85]">
                                GMV Gestionado Clínicas
                            </span>
                            <div className="w-9 h-9 rounded-xl bg-[#0E7490]/10 text-[#0E7490] flex items-center justify-center">
                                <Activity className="w-4 h-4" />
                            </div>
                        </div>
                        <div className="text-2xl font-bold text-[#0E7490] mt-2">
                            {formatCOP(metrics.gmv)}
                        </div>
                        <p className="text-[11px] text-[#5C6B85] mt-1">
                            Valor mensual de membresías cobrado por las clínicas ({metrics.totalSubscriptions} activas)
                        </p>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-2xs">
                        <div className="flex items-center justify-between">
                            <span className="text-xs font-semibold uppercase tracking-wider text-[#5C6B85]">
                                Mascotas & Canjes QR
                            </span>
                            <div className="w-9 h-9 rounded-xl bg-[#0F9F9A]/10 text-[#0F9F9A] flex items-center justify-center">
                                <PawPrint className="w-4 h-4" />
                            </div>
                        </div>
                        <div className="text-2xl font-bold text-[#15213B] mt-2">
                            {metrics.totalPets} mascotas
                        </div>
                        <p className="text-[11px] text-[#0F9F9A] font-medium mt-1">
                            {metrics.totalRedemptions} beneficios canjeados en recepción
                        </p>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-2xs">
                        <div className="flex items-center justify-between">
                            <span className="text-xs font-semibold uppercase tracking-wider text-[#5C6B85]">
                                Embudo Prospección B2B
                            </span>
                            <div className="w-9 h-9 rounded-xl bg-[#B45309]/10 text-[#B45309] flex items-center justify-center">
                                <Zap className="w-4 h-4" />
                            </div>
                        </div>
                        <div className="text-2xl font-bold text-[#15213B] mt-2">
                            {metrics.totalProspectos} clínicas
                        </div>
                        <p className="text-[11px] text-[#5C6B85] mt-1">
                            {metrics.contactadosCount} contactadas · {metrics.interesadosCount} en seguimiento
                        </p>
                    </div>
                </div>

                {/* SECCIÓN 1: RADAR DE SALUD Y RETENCIÓN DE CLÍNICAS */}
                <div className="bg-white rounded-2xl border border-slate-200/90 p-6 shadow-2xs space-y-4">
                    <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-100">
                        <div>
                            <h2 className="text-lg font-bold text-[#15213B] flex items-center gap-2">
                                <Building2 className="w-5 h-5 text-[#6D28D9]" />
                                <span>Radar de salud y diagnóstico por clínica</span>
                            </h2>
                            <p className="text-xs text-[#5C6B85] mt-0.5">
                                Evalúa la adopción real de cada veterinaria (planes activos, mascotas afiliadas y estado SaaS) y sugiere el siguiente paso.
                            </p>
                        </div>
                        <Link
                            href="/super-admin/tenants"
                            className="inline-flex items-center gap-1 text-xs font-semibold text-[#6D28D9] hover:underline"
                        >
                            <span>Ver todas las clínicas</span>
                            <ArrowRight className="w-3.5 h-3.5" />
                        </Link>
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {clinicInsights.map((c) => {
                            const isWarning = c.priority === 'warning';
                            return (
                                <div
                                    key={c.id}
                                    className="p-4 rounded-xl bg-[#F4F7FC] border border-slate-200/80 flex flex-col justify-between gap-3"
                                >
                                    <div className="space-y-2.5">
                                        <div className="flex items-start justify-between gap-2">
                                            <div>
                                                <div className="font-bold text-[#15213B] text-sm flex items-center gap-2">
                                                    <span>{c.name}</span>
                                                    <span className="text-[11px] font-mono text-[#0E7490] bg-[#0E7490]/10 px-2 py-0.5 rounded">
                                                        {c.slug}.avipetapp.com
                                                    </span>
                                                </div>
                                                <div className="text-xs text-[#5C6B85] mt-0.5">
                                                    {c.city} · {c.doctor_name}
                                                </div>
                                            </div>

                                            <span
                                                className={`inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold border shrink-0 ${
                                                    isWarning
                                                        ? 'bg-[#B45309]/10 text-[#B45309] border-[#B45309]/25'
                                                        : 'bg-[#0F9F9A]/10 text-[#0F9F9A] border-[#0F9F9A]/25'
                                                }`}
                                            >
                                                {isWarning ? (
                                                    <AlertTriangle className="w-3 h-3" />
                                                ) : (
                                                    <CheckCircle2 className="w-3 h-3" />
                                                )}
                                                <span>{c.badge}</span>
                                            </span>
                                        </div>

                                        {/* Barra de Índice de Salud Operativa */}
                                        <div className="space-y-1">
                                            <div className="flex items-center justify-between text-[11px] tabular-nums">
                                                <span className="font-semibold text-[#5C6B85]">
                                                    Índice de adopción operativa
                                                </span>
                                                <span className="font-bold text-[#15213B]">{c.health_score} / 100</span>
                                            </div>
                                            <div className="w-full h-2 bg-slate-200 rounded-full overflow-hidden">
                                                <div
                                                    className={`h-full rounded-full ${
                                                        c.health_score >= 70 ? 'bg-[#0F9F9A]' : 'bg-[#B45309]'
                                                    }`}
                                                    style={{ width: `${c.health_score}%` }}
                                                />
                                            </div>
                                        </div>

                                        <p className="text-xs text-[#15213B] bg-white p-3 rounded-lg border border-slate-200/70 leading-relaxed">
                                            {c.diagnosis}
                                        </p>
                                    </div>

                                    <div className="flex items-center justify-between pt-2 border-t border-slate-200/60 text-xs tabular-nums">
                                        <div className="text-[#5C6B85]">
                                            <b>{c.pets_count}</b> mascotas · <b>{c.subscriptions_count}</b> membresías ·{' '}
                                            <b>{c.plans_count}</b> planes
                                        </div>

                                        <a
                                            href={c.action_url}
                                            target={c.action_url.startsWith('http') ? '_blank' : undefined}
                                            rel={c.action_url.startsWith('http') ? 'noreferrer' : undefined}
                                            className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-semibold transition"
                                        >
                                            <span>{c.action_label}</span>
                                            <ArrowRight className="w-3.5 h-3.5" />
                                        </a>
                                    </div>
                                </div>
                            );
                        })}
                    </div>
                </div>

                {/* SECCIÓN 2: COPILOTO ESTRATÉGICO B2B + RADAR DE CIUDADES */}
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Copiloto B2B (2 columnas) */}
                    <div className="lg:col-span-2 bg-white rounded-2xl border border-slate-200/90 p-6 shadow-2xs space-y-4">
                        <div className="border-b border-slate-100 pb-3">
                            <h2 className="text-lg font-bold text-[#15213B] flex items-center gap-2">
                                <Sparkles className="w-5 h-5 text-[#6D28D9]" />
                                <span>Copiloto comercial B2B (Captación de Veterinarias Socias)</span>
                            </h2>
                            <p className="text-xs text-[#5C6B85] mt-0.5">
                                Genera mensajes persuasivos y respuestas a objeciones alineadas con el Manual Maestro de Marca v1.1.
                            </p>
                        </div>

                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                            {COPILOT_PRESETS.map((preset) => {
                                const active = selectedPreset.id === preset.id;
                                return (
                                    <button
                                        key={preset.id}
                                        type="button"
                                        onClick={() => handleSelectPreset(preset)}
                                        className={`p-3 rounded-xl border text-left transition cursor-pointer ${
                                            active
                                                ? 'bg-[#6D28D9]/5 border-[#6D28D9] ring-2 ring-[#6D28D9]/15'
                                                : 'bg-[#F4F7FC] border-slate-200/80 hover:bg-white'
                                        }`}
                                    >
                                        <div className="font-bold text-xs text-[#15213B]">{preset.label}</div>
                                        <div className="text-[11px] text-[#5C6B85] mt-0.5 line-clamp-2">
                                            {preset.desc}
                                        </div>
                                    </button>
                                );
                            })}
                        </div>

                        <form onSubmit={handleGenerateAI} className="flex flex-col sm:flex-row gap-2">
                            <input
                                type="text"
                                value={customContext}
                                onChange={(e) => setCustomContext(e.target.value)}
                                placeholder="Opcional: Ej. Es para el Dr. Andrés en Chía, tiene 2 sedes y usa Excel..."
                                className="flex-1 px-3.5 py-2.5 rounded-xl border border-slate-200 bg-[#F4F7FC] text-xs text-[#15213B] placeholder-[#5C6B85] focus:outline-hidden focus:ring-2 focus:ring-[#6D28D9] focus:bg-white"
                            />
                            <button
                                type="submit"
                                disabled={isGenerating}
                                className="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white text-xs font-semibold transition shrink-0 cursor-pointer disabled:opacity-60"
                            >
                                <Send className="w-3.5 h-3.5" />
                                <span>{isGenerating ? 'Preparando sugerencia...' : 'Adaptar con IA'}</span>
                            </button>
                        </form>

                        <div className="space-y-2">
                            <div className="flex items-center justify-between">
                                <span className="text-xs font-semibold text-[#5C6B85]">
                                    Guion listo para enviar o editar:
                                </span>
                                <button
                                    type="button"
                                    onClick={handleCopyScript}
                                    className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#0E7490]/10 hover:bg-[#0E7490]/15 text-[#0E7490] text-xs font-semibold transition cursor-pointer"
                                >
                                    {copiedScript ? (
                                        <>
                                            <Check className="w-3.5 h-3.5 text-[#0F9F9A]" />
                                            <span>Copiado al portapapeles</span>
                                        </>
                                    ) : (
                                        <>
                                            <Copy className="w-3.5 h-3.5" />
                                            <span>Copiar mensaje</span>
                                        </>
                                    )}
                                </button>
                            </div>

                            <textarea
                                rows={7}
                                value={generatedText}
                                onChange={(e) => setGeneratedText(e.target.value)}
                                className="w-full p-3.5 rounded-xl border border-slate-200 bg-[#F4F7FC] text-xs text-[#15213B] leading-relaxed focus:outline-hidden focus:ring-2 focus:ring-[#6D28D9] focus:bg-white"
                            />
                        </div>
                    </div>

                    {/* Oportunidades B2B por Ciudad (1 columna) */}
                    <div className="bg-white rounded-2xl border border-slate-200/90 p-6 shadow-2xs flex flex-col justify-between space-y-4">
                        <div className="space-y-4">
                            <div className="border-b border-slate-100 pb-3">
                                <h2 className="text-lg font-bold text-[#15213B] flex items-center gap-2">
                                    <MapPin className="w-5 h-5 text-[#0E7490]" />
                                    <span>Ciudades con mayor potencial B2B</span>
                                </h2>
                                <p className="text-xs text-[#5C6B85] mt-0.5">
                                    Directorio de clínicas veterinarias prospectadas para activar como Veterinarias Socias.
                                </p>
                            </div>

                            {topCities.length === 0 ? (
                                <div className="p-6 text-center text-xs text-[#5C6B85] bg-[#F4F7FC] rounded-xl">
                                    Explora o importa prospectos desde el módulo de Prospección B2B.
                                </div>
                            ) : (
                                <div className="space-y-2.5 tabular-nums">
                                    {topCities.map((item, idx) => (
                                        <div
                                            key={idx}
                                            className="p-3 rounded-xl bg-[#F4F7FC] border border-slate-200/70 flex items-center justify-between"
                                        >
                                            <div>
                                                <div className="font-bold text-xs text-[#15213B]">{item.city}</div>
                                                <div className="text-[11px] text-[#5C6B85]">
                                                    {item.pending} disponibles sin contactar
                                                </div>
                                            </div>
                                            <span className="px-2.5 py-1 rounded-lg bg-white border border-slate-200 text-xs font-bold text-[#0E7490]">
                                                {item.total} clínicas
                                            </span>
                                        </div>
                                    ))}
                                </div>
                            )}
                        </div>

                        <div className="pt-3 border-t border-slate-100 space-y-2">
                            <Link
                                href="/super-admin/prospecto-veterinarias"
                                className="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white text-xs font-semibold transition"
                            >
                                <span>Ir a Prospección B2B</span>
                                <ArrowRight className="w-3.5 h-3.5" />
                            </Link>
                            <a
                                href="/admin/vet-pet-patitas/inteligencia"
                                className="w-full inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-white border border-slate-200 hover:bg-[#F4F7FC] text-[#5C6B85] hover:text-[#15213B] text-xs font-semibold transition"
                            >
                                <span>Ver demo IA clínica (Vet-Pet Patitas)</span>
                                <ExternalLink className="w-3.5 h-3.5" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </SuperAdminLayout>
    );
}
