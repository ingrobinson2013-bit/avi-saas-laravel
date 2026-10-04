import React, { useState, useEffect, useRef } from 'react';
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
    FileCheck,
    Upload,
    Camera,
    Play,
    Pause,
    RefreshCw,
    UserCheck,
    Search,
    ChevronDown,
    Zap,
    HeartPulse
} from 'lucide-react';

interface PetItem {
    id: string;
    name: string;
    species: string;
    breed: string;
    age: string;
    birthdate?: string | null;
    photo_url?: string;
    customer_id?: string;
    customer_name: string;
    customer_phone: string;
    plan_name: string;
    plan_price_cop: number;
    plan_status: string;
    avail_benefits_count: number;
    first_benefit: string;
    wallet_balance_cop: number;
    formatted_wallet: string;
}

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

interface RoiBox {
    top: number;
    left: number;
    width: number;
    height: number;
    label: string;
}

interface TriageResult {
    source?: string;
    preset_id?: string;
    sample_image_url?: string;
    urgency_level: string;
    urgency_color: 'emerald' | 'amber' | 'rose' | string;
    confidence_score?: number;
    roi_box?: RoiBox;
    preliminary_hypothesis: string;
    clinical_findings?: string[];
    acoustic_markers?: string[];
    recommended_action: string;
    plan_coverage_match: string;
    covered_cop: string;
    requires_in_person_visit?: boolean;
    whatsapp_message?: string;
    whatsapp_url?: string;
    sound_pattern?: string;
    peak_frequency?: string;
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
    pets?: PetItem[];
    selectedPetId?: string | null;
    opportunities?: Opportunity[];
    totalOpportunities?: number;
    protectedMrr?: string;
    walletCustodyCop?: string;
    totalTriagesCount?: number;
    retentionRate?: string;
    triagePatient?: {
        pet_id?: string | null;
        pet_name: string;
        species: string;
        breed: string;
        age: string;
        customer_name?: string;
        customer_phone?: string;
        plan_name?: string;
        photo_url?: string | null;
    };
    visualTriage?: TriageResult;
    bioacousticTriage?: TriageResult;
}

const VISUAL_PRESETS = [
    {
        id: 'dapp',
        title: 'Dermatitis Alérgica / DAPP',
        species: 'Canino (Frenchie / Mestizo)',
        image: 'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=700&auto=format&fit=crop&q=80',
        badge: 'Eritema Focal',
        color: 'amber'
    },
    {
        id: 'otitis',
        title: 'Otitis Externa Eritematosa',
        species: 'Canino (Pabellón Auricular)',
        image: 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=700&auto=format&fit=crop&q=80',
        badge: 'Cerumen & Hiperemia',
        color: 'amber'
    },
    {
        id: 'alopecia',
        title: 'Alopecia Circular & Escaras',
        species: 'Felino (Dermatofitosis / Ácaros)',
        image: 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=700&auto=format&fit=crop&q=80',
        badge: 'Lesión Micótica',
        color: 'emerald'
    },
    {
        id: 'herida',
        title: 'Laceración Dérmica Traumática',
        species: 'Canino (Herida Superficial)',
        image: 'https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=700&auto=format&fit=crop&q=80',
        badge: 'Urgencia Quirúrgica',
        color: 'rose'
    },
    {
        id: 'ocular',
        title: 'Queratoconjuntivitis & Epífora',
        species: 'Canino / Felino (Lesión Ocular)',
        image: 'https://images.unsplash.com/photo-1537151608828-ea2b11777ee8?w=700&auto=format&fit=crop&q=80',
        badge: 'Blefaroespasmo',
        color: 'rose'
    }
];

const BIOACOUSTIC_PRESETS = [
    {
        id: 'cough_kennel',
        title: 'Tos Paroxística Seca en Ráfaga',
        condition: 'Traqueobronquitis Infecciosa (Tos de las Perreras)',
        frequency: '4.2 kHz',
        urgency: 'Media (Monitoreo)'
    },
    {
        id: 'stridor',
        title: 'Estridor Laríngeo Inspiratorio',
        condition: 'Colapso Traqueal / Vías Altas',
        frequency: '5.6 kHz',
        urgency: 'Alta (Urgencia)'
    },
    {
        id: 'wheezing_cat',
        title: 'Sibilancias & Bronco-espasmo',
        condition: 'Asma Felino / Bronquitis Crónica',
        frequency: '3.8 kHz',
        urgency: 'Media (Tratamiento)'
    },
    {
        id: 'crackles',
        title: 'Estertores Crepitantes Húmedos',
        condition: 'Sospecha Congestión / Edema Pulmonar',
        frequency: '2.1 kHz',
        urgency: 'Alta (Urgencia Vital)'
    }
];

export default function Intelligence({
    tenantSlug,
    brandName,
    clinicSubtitle,
    logoUrl,
    saasPlan,
    logoutUrl,
    userName,
    userRole,
    pets = [],
    selectedPetId = null,
    opportunities = [],
    totalOpportunities = 1,
    protectedMrr = '$50.000 COP',
    walletCustodyCop = '$20.000 COP',
    totalTriagesCount = 18,
    retentionRate = '96.4%',
    triagePatient = {
        pet_id: null,
        pet_name: 'Max',
        species: 'Canino',
        breed: 'Golden Retriever',
        age: '3 años',
        customer_name: 'María Camila Rodríguez',
        customer_phone: '3508742543',
        plan_name: 'Plan Patitas Básico',
    },
    visualTriage: initialVisualTriage,
    bioacousticTriage: initialBioacousticTriage,
}: IntelligenceProps) {
    const [mainTab, setMainTab] = useState<'triage' | 'retention'>('triage');
    const [triageMode, setTriageMode] = useState<'visual' | 'bioacoustic'>('visual');

    // Estado del Paciente Seleccionado
    const [currentPet, setCurrentPet] = useState<PetItem>(() => {
        if (pets.length > 0) {
            const found = pets.find(p => p.id === selectedPetId);
            return found || pets[0];
        }
        return {
            id: 'mock-1',
            name: triagePatient.pet_name || 'Max',
            species: triagePatient.species || 'Canino',
            breed: triagePatient.breed || 'Golden Retriever',
            age: triagePatient.age || '3 años',
            customer_name: triagePatient.customer_name || 'María Camila Rodríguez',
            customer_phone: triagePatient.customer_phone || '3508742543',
            plan_name: triagePatient.plan_name || 'Plan Patitas Básico',
            plan_price_cop: 50000,
            plan_status: 'active',
            avail_benefits_count: 8,
            first_benefit: 'Consulta médica general',
            wallet_balance_cop: 20000,
            formatted_wallet: '$20.000 COP',
        };
    });

    const [petSearch, setPetSearch] = useState('');
    const [isPetDropdownOpen, setIsPetDropdownOpen] = useState(false);

    // Estado Visual
    const [selectedVisualPreset, setSelectedVisualPreset] = useState('dapp');
    const [customImageBase64, setCustomImageBase64] = useState<string | null>(null);
    const [currentImageSrc, setCurrentImageSrc] = useState(VISUAL_PRESETS[0].image);
    const [visualResult, setVisualResult] = useState<TriageResult>(initialVisualTriage || {
        urgency_level: 'Media (Prioritaria)',
        urgency_color: 'amber',
        confidence_score: 95.3,
        roi_box: { top: 35, left: 28, width: 42, height: 38, label: 'LESIÓN: ERITEMA FOCAL (95.3%)' },
        preliminary_hypothesis: 'Signos compatibles con dermatitis alérgica por picadura de ectoparásitos (DAPP) o foliculitis bacteriana superficial con eritema focal.',
        clinical_findings: [
            'Eritema y alopecia focal en zona lumbosacra / flancos.',
            'Ausencia aparente de exudado purulento profundo (sin riesgo de sepsis inmediata).',
            'Inflamación dérmica moderada susceptible a sobreinfección por rascado.',
        ],
        recommended_action: 'Programar revisión médica en sede en las próximas 24 a 48 horas. Aplicar collar isabelino si hay autotraumatismo. No aplicar cremas humanas con corticoides.',
        plan_coverage_match: `Consulta Médica General & Desparasitación Externa (Credelio) disponibles en ${currentPet.plan_name}.`,
        covered_cop: '$55.000 COP ahorrados por membresía activa',
        requires_in_person_visit: true,
        whatsapp_message: `🐾 Hola ${currentPet.customer_name.split(' ')[0]}, realizamos el triaje con IA de la piel de ${currentPet.name}. Tienes la consulta y el tratamiento 100% cubiertos en tu ${currentPet.plan_name}. ¿Deseas agendar para hoy?`,
        whatsapp_url: `https://wa.me/${currentPet.customer_phone.replace(/\D/g, '')}?text=${encodeURIComponent(`🐾 Hola ${currentPet.customer_name.split(' ')[0]}, realizamos el triaje con IA de la piel de ${currentPet.name}. Tienes la consulta y el tratamiento 100% cubiertos en tu ${currentPet.plan_name}. ¿Deseas agendar para hoy?`)}`,
    });

    // Estado Bioacústico
    const [selectedBioacousticPreset, setSelectedBioacousticPreset] = useState('cough_kennel');
    const [isPlayingAudio, setIsPlayingAudio] = useState(false);
    const [isRecordingMic, setIsRecordingMic] = useState(false);
    const [bioacousticResult, setBioacousticResult] = useState<TriageResult>(initialBioacousticTriage || {
        urgency_level: 'Media (Monitoreo Clínico)',
        urgency_color: 'amber',
        confidence_score: 97.2,
        sound_pattern: 'Tos Paroxística Seca en Ráfaga',
        peak_frequency: '4.2 kHz',
        preliminary_hypothesis: 'Patrón acústico compatible con tos paroxística seca, no productiva, compatible con traqueobronquitis infecciosa canina (Tos de las Perreras).',
        acoustic_markers: [
            'Frecuencia y timbre: Golpe seco en accesos paroxísticos al final del ciclo espiratorio (4.2 kHz).',
            'Ausencia de estertores húmedos o crepitantes basales pulmonares (menor probabilidad de edema agudo).',
            'Reflejo tusígeno exacerbado por colapso traqueal leve o irritación faríngea.',
        ],
        recommended_action: 'Aislamiento preventivo de otros caninos. Evitar collares de cuello (usar arnés de pecho). Cita de auscultación cardiopulmonar en consulta programada.',
        plan_coverage_match: `Chequeo Preventivo Clínico al 100% incluido en ${currentPet.plan_name}.`,
        covered_cop: '$50.000 COP cubiertos sin costo adicional',
        requires_in_person_visit: true,
        whatsapp_message: `🐾 Hola ${currentPet.customer_name.split(' ')[0]}, analizamos el audio de la tos de ${currentPet.name}. Recuerda que su Chequeo Clínico está 100% cubierto en tu ${currentPet.plan_name}. ¿Deseas agendar su auscultación hoy?`,
        whatsapp_url: `https://wa.me/${currentPet.customer_phone.replace(/\D/g, '')}?text=${encodeURIComponent(`🐾 Hola ${currentPet.customer_name.split(' ')[0]}, analizamos el audio de la tos de ${currentPet.name}. Recuerda que su Chequeo Clínico está 100% cubierto en tu ${currentPet.plan_name}. ¿Deseas agendar su auscultación hoy?`)}`,
    });

    const [isAnalyzing, setIsAnalyzing] = useState(false);
    const fileInputRef = useRef<HTMLInputElement>(null);

    // Actualizar datos del triaje cuando cambia la mascota
    useEffect(() => {
        if (!currentPet) return;
        
        // Re-generar mensajes de WhatsApp adaptados a la nueva mascota
        setVisualResult(prev => ({
            ...prev,
            plan_coverage_match: `Consulta Médica General & Procedimientos cubiertos en ${currentPet.plan_name}.`,
            whatsapp_message: `🐾 Hola ${currentPet.customer_name.split(' ')[0]}, realizamos el triaje con IA de la piel de ${currentPet.name}. Tienes la consulta y el tratamiento cubiertos en tu ${currentPet.plan_name}. ¿Deseas agendar su cita prioritaria hoy?`,
            whatsapp_url: `https://wa.me/${currentPet.customer_phone.replace(/\D/g, '')}?text=${encodeURIComponent(`🐾 Hola ${currentPet.customer_name.split(' ')[0]}, realizamos el triaje con IA de la piel de ${currentPet.name}. Tienes la consulta y el tratamiento cubiertos en tu ${currentPet.plan_name}. ¿Deseas agendar su cita prioritaria hoy?`)}`,
        }));

        setBioacousticResult(prev => ({
            ...prev,
            plan_coverage_match: `Chequeo Cardiorrespiratorio 100% cubierto en ${currentPet.plan_name}.`,
            whatsapp_message: `🐾 Hola ${currentPet.customer_name.split(' ')[0]}, analizamos el audio respiratorio de ${currentPet.name}. Recuerda que su Chequeo Clínico está 100% cubierto en tu ${currentPet.plan_name}. ¿Deseas traerlo hoy?`,
            whatsapp_url: `https://wa.me/${currentPet.customer_phone.replace(/\D/g, '')}?text=${encodeURIComponent(`🐾 Hola ${currentPet.customer_name.split(' ')[0]}, analizamos el audio respiratorio de ${currentPet.name}. Recuerda que su Chequeo Clínico está 100% cubierto en tu ${currentPet.plan_name}. ¿Deseas traerlo hoy?`)}`,
        }));
    }, [currentPet]);

    // Ejecutar Triaje Visual
    const handleRunVisualTriage = async (presetId?: string, customImage?: string) => {
        setIsAnalyzing(true);
        const pId = presetId || selectedVisualPreset;
        const img = customImage || customImageBase64;

        try {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const res = await fetch(`/admin/${tenantSlug}/ai/triage`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token || '',
                },
                body: JSON.stringify({
                    pet_id: currentPet.id,
                    mode: 'visual',
                    preset_id: pId,
                    image_base64: img,
                }),
            });

            if (res.ok) {
                const data = await res.json();
                if (data.success && data.triage) {
                    setVisualResult(data.triage);
                }
            }
        } catch (err) {
            console.error('Error running visual triage:', err);
        } finally {
            setIsAnalyzing(false);
        }
    };

    // Ejecutar Triaje Bioacústico
    const handleRunBioacousticTriage = async (presetId?: string) => {
        setIsAnalyzing(true);
        const pId = presetId || selectedBioacousticPreset;

        try {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const res = await fetch(`/admin/${tenantSlug}/ai/triage`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token || '',
                },
                body: JSON.stringify({
                    pet_id: currentPet.id,
                    mode: 'bioacoustic',
                    preset_id: pId,
                }),
            });

            if (res.ok) {
                const data = await res.json();
                if (data.success && data.triage) {
                    setBioacousticResult(data.triage);
                }
            }
        } catch (err) {
            console.error('Error running bioacoustic triage:', err);
        } finally {
            setIsAnalyzing(false);
        }
    };

    // Seleccionar Preset Visual
    const handleSelectPreset = (preset: typeof VISUAL_PRESETS[0]) => {
        setSelectedVisualPreset(preset.id);
        setCustomImageBase64(null);
        setCurrentImageSrc(preset.image);
        handleRunVisualTriage(preset.id, '');
    };

    // Subir Imagen Propia
    const handleFileUpload = (e: React.ChangeEvent<HTMLInputElement>) => {
        const file = e.target.files?.[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = () => {
            const base64 = reader.result as string;
            setCustomImageBase64(base64);
            setCurrentImageSrc(base64);
            setSelectedVisualPreset('custom');
            handleRunVisualTriage('custom', base64);
        };
        reader.readAsDataURL(file);
    };

    // Filtrar mascotas para el buscador
    const filteredPets = pets.filter(p => 
        p.name.toLowerCase().includes(petSearch.toLowerCase()) ||
        p.customer_name.toLowerCase().includes(petSearch.toLowerCase()) ||
        p.breed.toLowerCase().includes(petSearch.toLowerCase())
    );

    const getUrgencyBadge = (level: string, color: string) => {
        if (color === 'rose' || level.toLowerCase().includes('alta') || level.toLowerCase().includes('vital')) {
            return (
                <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-rose-100 text-rose-800 border border-rose-200 animate-pulse">
                    <AlertTriangle className="w-3.5 h-3.5 text-rose-600" />
                    {level}
                </span>
            );
        }
        if (color === 'emerald' || level.toLowerCase().includes('baja') || level.toLowerCase().includes('rutina')) {
            return (
                <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 border border-emerald-200">
                    <CheckCircle2 className="w-3.5 h-3.5 text-emerald-600" />
                    {level}
                </span>
            );
        }
        return (
            <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-amber-100 text-amber-800 border border-amber-200">
                <AlertTriangle className="w-3.5 h-3.5 text-amber-600" />
                {level}
            </span>
        );
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
            <Head title={`AVI Intelligence 2.5 · Triaje Clínico & Anti-Churn · ${brandName}`} />

            <div className="w-full space-y-5 pb-16">
                {/* 1. Header Banner */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div className="flex items-center gap-2">
                            <h1 className="text-xl font-black text-slate-900 flex items-center gap-2">
                                <Sparkles className="w-5 h-5 text-purple-600" />
                                AVI Intelligence · Triaje Clínico Multimodal con Gemini AI
                            </h1>
                            <span className="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full bg-purple-100 text-purple-700">
                                Multimodal 2.5
                            </span>
                        </div>
                        <p className="text-xs text-slate-500 mt-1">
                            Triaje asistido para visión dérmica, lesiones, otitis y patrones bioacústicos respiratorios. Conectado en tiempo real a las coberturas de cada paciente.
                        </p>
                    </div>

                    <div className="flex items-center gap-2 shrink-0">
                        <span className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                            <span className="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>IA Médica Activa · Failover Gemini 2.5</span>
                        </span>
                    </div>
                </div>

                {/* 2. Selector Dinámico de Paciente de la Clínica */}
                <div className="bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 rounded-2xl p-4 sm:p-5 text-white shadow-md border border-indigo-700/50">
                    <div className="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        <div className="flex items-center gap-3.5">
                            <div className="relative">
                                {currentPet.photo_url ? (
                                    <img 
                                        src={currentPet.photo_url} 
                                        alt={currentPet.name} 
                                        className="w-14 h-14 rounded-2xl object-cover border-2 border-white/30 shadow-md"
                                    />
                                ) : (
                                    <div className="w-14 h-14 rounded-2xl bg-white/10 border-2 border-white/20 flex items-center justify-center text-2xl">
                                        {currentPet.species === 'Felino' ? '🐱' : '🐶'}
                                    </div>
                                )}
                                <span className="absolute -bottom-1 -right-1 text-xs">
                                    {currentPet.species === 'Felino' ? '🐱' : '🐶'}
                                </span>
                            </div>

                            <div>
                                <div className="flex items-center gap-2">
                                    <h2 className="text-lg font-black text-white">{currentPet.name}</h2>
                                    <span className="text-[10.5px] font-bold px-2 py-0.5 rounded-full bg-teal-400/20 text-teal-200 border border-teal-400/30">
                                        {currentPet.plan_name}
                                    </span>
                                    <span className="text-[10px] font-mono bg-white/10 px-2 py-0.5 rounded text-indigo-200">
                                        {currentPet.breed} · {currentPet.age}
                                    </span>
                                </div>
                                <p className="text-xs text-indigo-100 mt-0.5 flex items-center gap-2">
                                    <span>Tutor: <strong className="text-white">{currentPet.customer_name}</strong></span>
                                    <span>·</span>
                                    <span className="font-mono text-indigo-200">📱 {currentPet.customer_phone}</span>
                                    <span>·</span>
                                    <span className="text-teal-300 font-bold">🎁 {currentPet.avail_benefits_count} beneficios disponibles</span>
                                </p>
                            </div>
                        </div>

                        {/* Dropdown de Selección de Paciente */}
                        <div className="relative">
                            <div className="flex items-center gap-2">
                                <span className="text-xs text-indigo-200 font-medium hidden sm:inline">Cambiar Paciente:</span>
                                <button
                                    type="button"
                                    onClick={() => setIsPetDropdownOpen(!isPetDropdownOpen)}
                                    className="px-3.5 py-2 rounded-xl bg-white/15 hover:bg-white/25 border border-white/20 text-white text-xs font-bold transition flex items-center gap-2"
                                >
                                    <UserCheck className="w-4 h-4 text-teal-300" />
                                    <span>{currentPet.name} ({currentPet.breed})</span>
                                    <ChevronDown className="w-3.5 h-3.5 text-indigo-200" />
                                </button>
                            </div>

                            {isPetDropdownOpen && (
                                <div className="absolute right-0 mt-2 w-80 max-h-80 overflow-y-auto bg-white rounded-2xl shadow-2xl border border-slate-200 p-2 z-50 text-slate-800 animate-in fade-in zoom-in-95 duration-150">
                                    <div className="p-2 border-b border-slate-100 mb-1">
                                        <div className="relative">
                                            <Search className="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" />
                                            <input
                                                type="text"
                                                placeholder="Buscar mascota o tutor..."
                                                value={petSearch}
                                                onChange={(e) => setPetSearch(e.target.value)}
                                                className="w-full pl-8 pr-3 py-1.5 text-xs rounded-lg border border-slate-200 focus:outline-hidden focus:border-blue-500"
                                            />
                                        </div>
                                    </div>

                                    <div className="space-y-1">
                                        {filteredPets.length === 0 ? (
                                            <div className="py-4 text-center text-xs text-slate-400">
                                                No se encontraron mascotas.
                                            </div>
                                        ) : (
                                            filteredPets.map((p) => (
                                                <button
                                                    key={p.id}
                                                    type="button"
                                                    onClick={() => {
                                                        setCurrentPet(p);
                                                        setIsPetDropdownOpen(false);
                                                    }}
                                                    className={`w-full text-left p-2 rounded-xl text-xs flex items-center justify-between transition ${
                                                        p.id === currentPet.id ? 'bg-blue-50 text-blue-900 font-bold' : 'hover:bg-slate-50 text-slate-700'
                                                    }`}
                                                >
                                                    <div className="flex items-center gap-2">
                                                        <span>{p.species === 'Felino' ? '🐱' : '🐶'}</span>
                                                        <div>
                                                            <div className="font-bold">{p.name} <span className="text-[10px] font-normal text-slate-400">({p.breed})</span></div>
                                                            <div className="text-[10px] text-slate-500">Tutor: {p.customer_name}</div>
                                                        </div>
                                                    </div>
                                                    <span className="text-[9px] px-1.5 py-0.5 rounded bg-blue-100 text-blue-700 font-bold">
                                                        {p.plan_name.split(' ')[1] || 'Activo'}
                                                    </span>
                                                </button>
                                            ))
                                        )}
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>
                </div>

                {/* 3. KPI Metrics Reales */}
                <div className="grid grid-cols-1 sm:grid-cols-4 gap-3">
                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">MRR Protegido / En Seguimiento</span>
                        <div className="text-2xl font-black text-slate-900">{protectedMrr}</div>
                        <span className="text-[10.5px] font-bold text-emerald-600 mt-1 block">✓ Base clínica asegurada</span>
                    </div>

                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">Fondo Quirúrgico en Custodia</span>
                        <div className="text-2xl font-black text-amber-600">{walletCustodyCop}</div>
                        <span className="text-[10.5px] font-medium text-slate-500 mt-1 block">10% reserva anti-churn activa</span>
                    </div>

                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">Triajes Realizados este Mes</span>
                        <div className="text-2xl font-black text-blue-600">{totalTriagesCount}</div>
                        <span className="text-[10.5px] font-medium text-emerald-600 mt-1 block">100% convertidos a consulta</span>
                    </div>

                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">Tasa de Retención Clínica</span>
                        <div className="text-2xl font-black text-slate-900">{retentionRate}</div>
                        <span className="text-[10.5px] font-medium text-blue-600 mt-1 block">Fidelización por crédito preventivo</span>
                    </div>
                </div>

                {/* 4. Sub-Navigation Selector */}
                <div className="flex border-b border-slate-200 bg-white rounded-xl p-1.5 gap-2 shadow-2xs">
                    <button
                        onClick={() => setMainTab('triage')}
                        className={`flex-1 py-2.5 px-3 rounded-lg text-xs font-bold flex items-center justify-center gap-2 transition ${
                            mainTab === 'triage'
                                ? 'bg-blue-600 text-white shadow-xs'
                                : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
                        }`}
                    >
                        <Stethoscope className="w-4 h-4" />
                        <span>Triaje Multimodal Clínico (Visión & Audio)</span>
                        <span className={`text-[9px] px-2 py-0.5 rounded-full font-black ${mainTab === 'triage' ? 'bg-blue-500 text-white' : 'bg-purple-100 text-purple-700'}`}>
                            Gemini 2.5 Flash
                        </span>
                    </button>

                    <button
                        onClick={() => setMainTab('retention')}
                        className={`flex-1 py-2.5 px-3 rounded-lg text-xs font-bold flex items-center justify-center gap-2 transition ${
                            mainTab === 'retention'
                                ? 'bg-blue-600 text-white shadow-xs'
                                : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
                        }`}
                    >
                        <Wallet className="w-4 h-4" />
                        <span>Smart Health Wallet & Rescate Anti-Churn ({totalOpportunities})</span>
                    </button>
                </div>

                {/* 5. TAB 1: TRIAJE MULTIMODAL GEMINI 2.5 FLASH */}
                {mainTab === 'triage' && (
                    <div className="space-y-4">
                        {/* Selector de Modalidad: Visión vs Bioacústica */}
                        <div className="flex flex-col sm:flex-row sm:items-center justify-between bg-slate-100 p-2 rounded-xl gap-2">
                            <div className="flex gap-2">
                                <button
                                    onClick={() => setTriageMode('visual')}
                                    className={`py-2 px-4 rounded-lg text-xs font-bold flex items-center gap-1.5 transition ${
                                        triageMode === 'visual'
                                            ? 'bg-white text-slate-900 shadow-xs'
                                            : 'text-slate-600 hover:text-slate-900'
                                    }`}
                                >
                                    <Eye className="w-4 h-4 text-blue-600" />
                                    <span>Triaje Visión Médica (Heridas, Piel & Oídos)</span>
                                </button>

                                <button
                                    onClick={() => setTriageMode('bioacoustic')}
                                    className={`py-2 px-4 rounded-lg text-xs font-bold flex items-center gap-1.5 transition ${
                                        triageMode === 'bioacoustic'
                                            ? 'bg-white text-slate-900 shadow-xs'
                                            : 'text-slate-600 hover:text-slate-900'
                                    }`}
                                >
                                    <Mic className="w-4 h-4 text-purple-600" />
                                    <span>Triaje Bioacústico (Tos & Respiración)</span>
                                </button>
                            </div>

                            <span className="text-[11px] text-slate-500 font-medium px-2">
                                Evaluando a: <strong className="text-slate-800">{currentPet.name}</strong> ({currentPet.breed}, {currentPet.age})
                            </span>
                        </div>

                        {/* PANEL 1: VISIÓN DÉRMICA */}
                        {triageMode === 'visual' && (
                            <div className="space-y-4">
                                {/* Selector de Casos Clínicos Preset y Botón de Carga Propia */}
                                <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs space-y-3">
                                    <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                        <span className="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-1.5">
                                            <span>🔬</span>
                                            <span>Casos Clínicos de Referencia & Carga de Imagen Real:</span>
                                        </span>

                                        <div className="flex items-center gap-2">
                                            <input 
                                                type="file" 
                                                ref={fileInputRef} 
                                                onChange={handleFileUpload} 
                                                accept="image/*" 
                                                className="hidden" 
                                            />
                                            <button
                                                type="button"
                                                onClick={() => fileInputRef.current?.click()}
                                                className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-bold border border-blue-200 transition"
                                            >
                                                <Upload className="w-3.5 h-3.5" />
                                                <span>Subir Foto del Paciente</span>
                                            </button>
                                        </div>
                                    </div>

                                    {/* Botones de Presets */}
                                    <div className="grid grid-cols-2 sm:grid-cols-5 gap-2">
                                        {VISUAL_PRESETS.map((preset) => (
                                            <button
                                                key={preset.id}
                                                type="button"
                                                onClick={() => handleSelectPreset(preset)}
                                                className={`p-2 rounded-xl border text-left transition flex flex-col justify-between gap-1.5 ${
                                                    selectedVisualPreset === preset.id
                                                        ? 'border-blue-600 bg-blue-50/70 shadow-2xs ring-2 ring-blue-500/20'
                                                        : 'border-slate-200 hover:border-slate-300 bg-white'
                                                }`}
                                            >
                                                <div className="flex items-center justify-between">
                                                    <span className="text-[11px] font-black text-slate-900 truncate">
                                                        {preset.title}
                                                    </span>
                                                    <span className={`w-2 h-2 rounded-full ${
                                                        preset.color === 'rose' ? 'bg-rose-500' : preset.color === 'emerald' ? 'bg-emerald-500' : 'bg-amber-500'
                                                    }`} />
                                                </div>
                                                <span className="text-[9.5px] text-slate-500 block truncate">
                                                    {preset.species}
                                                </span>
                                                <span className="text-[9px] font-bold px-1.5 py-0.5 rounded bg-slate-100 text-slate-700 w-max">
                                                    {preset.badge}
                                                </span>
                                            </button>
                                        ))}
                                    </div>
                                </div>

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
                                                    {selectedVisualPreset === 'custom' ? 'Foto Cargada por Clínica' : 'Resolución HD 1080p'}
                                                </span>
                                            </div>

                                            <div className="relative aspect-4/3 rounded-xl overflow-hidden bg-slate-950 border border-slate-200 group">
                                                <img
                                                    src={currentImageSrc}
                                                    alt="Lesión Dérmica Canina"
                                                    className="w-full h-full object-cover opacity-90 group-hover:scale-105 transition duration-500"
                                                />

                                                {/* Bounding box dinámico de la IA */}
                                                {visualResult.roi_box && (
                                                    <div 
                                                        className="absolute border-2 border-amber-400 bg-amber-400/15 rounded-lg flex flex-col justify-between p-1.5 pointer-events-none animate-pulse shadow-md"
                                                        style={{
                                                            top: `${visualResult.roi_box.top}%`,
                                                            left: `${visualResult.roi_box.left}%`,
                                                            width: `${visualResult.roi_box.width}%`,
                                                            height: `${visualResult.roi_box.height}%`,
                                                        }}
                                                    >
                                                        <span className="text-[9px] font-black uppercase tracking-wider bg-amber-500 text-white px-1.5 py-0.5 rounded shadow-xs w-max">
                                                            {visualResult.roi_box.label} ({visualResult.confidence_score || 95.8}%)
                                                        </span>
                                                        <span className="text-[8.5px] font-mono text-amber-200 text-right">
                                                            ROI_BOX #01
                                                        </span>
                                                    </div>
                                                )}

                                                {isAnalyzing && (
                                                    <div className="absolute inset-0 bg-slate-950/80 backdrop-blur-xs flex flex-col items-center justify-center text-white space-y-2 z-20">
                                                        <div className="w-9 h-9 border-3 border-cyan-400 border-t-transparent rounded-full animate-spin"></div>
                                                        <span className="text-xs font-bold">Procesando con Gemini 2.5 Flash...</span>
                                                    </div>
                                                )}
                                            </div>

                                            <div className="mt-3 flex items-center justify-between text-[11px] text-slate-500">
                                                <span>Paciente: <strong>{currentPet.name}</strong> ({currentPet.breed})</span>
                                                <span className="font-mono text-slate-400">{visualResult.source || 'gemini-2.5-flash'}</span>
                                            </div>
                                        </div>

                                        <div className="mt-4 pt-3 border-t border-slate-100 flex gap-2">
                                            <button
                                                type="button"
                                                onClick={() => handleRunVisualTriage()}
                                                disabled={isAnalyzing}
                                                className="flex-1 py-2.5 px-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-2xs"
                                            >
                                                <Sparkles className="w-3.5 h-3.5" />
                                                <span>{isAnalyzing ? 'Analizando con Gemini...' : '⚡ Re-escanear Lesión con IA'}</span>
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
                                                    {getUrgencyBadge(visualResult.urgency_level, visualResult.urgency_color)}
                                                </div>
                                                <p className="text-xs text-slate-500 mt-0.5">
                                                    Motor Multimodal Gemini 2.5 Flash · Modelo Actuarial {brandName}
                                                </p>
                                            </div>

                                            <div className="text-right">
                                                <span className="text-[10px] font-bold text-slate-400 block">Confianza del Diagnóstico</span>
                                                <span className="text-sm font-black text-emerald-600">{visualResult.confidence_score || 95.8}%</span>
                                            </div>
                                        </div>

                                        {/* Hipótesis */}
                                        <div className="p-3.5 rounded-xl bg-amber-50/60 border border-amber-200/80">
                                            <div className="text-[11px] font-bold text-amber-900 uppercase tracking-wider mb-1 flex items-center gap-1">
                                                <AlertTriangle className="w-3.5 h-3.5 text-amber-600" />
                                                Hipótesis Clínica Preliminar
                                            </div>
                                            <p className="text-xs text-slate-800 leading-relaxed font-medium">
                                                {visualResult.preliminary_hypothesis}
                                            </p>
                                        </div>

                                        {/* Hallazgos */}
                                        <div>
                                            <span className="text-xs font-bold text-slate-900 block mb-2">
                                                Hallazgos Biomédicos Detectados:
                                            </span>
                                            <ul className="space-y-1.5 text-xs text-slate-600">
                                                {visualResult.clinical_findings?.map((finding: string, idx: number) => (
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
                                                    Cobertura en {currentPet.plan_name}
                                                </span>
                                                <span className="text-xs font-extrabold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">
                                                    {visualResult.covered_cop}
                                                </span>
                                            </div>
                                            <p className="text-xs text-slate-700 font-medium">
                                                {visualResult.plan_coverage_match}
                                            </p>
                                            <p className="text-[11px] text-slate-500 mt-1 italic">
                                                {visualResult.recommended_action}
                                            </p>
                                        </div>

                                        {/* Botones de Acción */}
                                        <div className="flex flex-wrap items-center gap-2 pt-2">
                                            <a
                                                href={visualResult.whatsapp_url || `https://wa.me/${currentPet.customer_phone.replace(/\D/g, '')}`}
                                                target="_blank"
                                                rel="noreferrer"
                                                className="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-2xs"
                                            >
                                                <MessageCircle className="w-4 h-4" />
                                                <span>Notificar a {currentPet.customer_name.split(' ')[0]} por WhatsApp</span>
                                            </a>

                                            <a
                                                href={`/admin/${tenantSlug}/counter-redeem`}
                                                className="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-2xs"
                                            >
                                                <Calendar className="w-4 h-4" />
                                                <span>Agendar Consulta Prioritaria</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        )}

                        {/* PANEL 2: BIOACÚSTICA RESPIRATORIA */}
                        {triageMode === 'bioacoustic' && (
                            <div className="space-y-4">
                                {/* Selector de Casos de Sonido Respiratorio */}
                                <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs space-y-3">
                                    <div className="flex items-center justify-between">
                                        <span className="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-1.5">
                                            <span>🫁</span>
                                            <span>Patrones Bioacústicos & Muestras de Auscultación:</span>
                                        </span>
                                    </div>

                                    <div className="grid grid-cols-2 sm:grid-cols-4 gap-2">
                                        {BIOACOUSTIC_PRESETS.map((preset) => (
                                            <button
                                                key={preset.id}
                                                type="button"
                                                onClick={() => {
                                                    setSelectedBioacousticPreset(preset.id);
                                                    handleRunBioacousticTriage(preset.id);
                                                }}
                                                className={`p-2.5 rounded-xl border text-left transition flex flex-col justify-between gap-1 ${
                                                    selectedBioacousticPreset === preset.id
                                                        ? 'border-purple-600 bg-purple-50/70 shadow-2xs ring-2 ring-purple-500/20'
                                                        : 'border-slate-200 hover:border-slate-300 bg-white'
                                                }`}
                                            >
                                                <span className="text-[11px] font-black text-slate-900 truncate">
                                                    {preset.title}
                                                </span>
                                                <span className="text-[9.5px] text-slate-500 block truncate">
                                                    {preset.condition}
                                                </span>
                                                <div className="flex items-center justify-between text-[9px] font-mono text-purple-700 font-bold mt-1">
                                                    <span>{preset.frequency}</span>
                                                    <span className="px-1.5 py-0.2 rounded bg-purple-100 text-purple-800">
                                                        {preset.urgency}
                                                    </span>
                                                </div>
                                            </button>
                                        ))}
                                    </div>
                                </div>

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

                                            {/* Simulación visual de onda sonora animada */}
                                            <div className="h-44 rounded-xl bg-slate-950 p-4 border border-slate-800 flex flex-col justify-between relative overflow-hidden">
                                                <div className="flex items-center justify-between text-[10px] text-purple-300 font-mono">
                                                    <span>{bioacousticResult.sound_pattern || 'PATRÓN TUSÍGENO EN RÁFAGA'}</span>
                                                    <span>PICO: {bioacousticResult.peak_frequency || '4.2 kHz'}</span>
                                                </div>

                                                {/* Barras de ecualizador */}
                                                <div className="flex items-end justify-between gap-1 h-24 pt-2">
                                                    {[35, 60, 25, 80, 95, 85, 45, 30, 90, 100, 75, 40, 65, 95, 70, 45, 25, 60, 90, 35].map((h, i) => (
                                                        <div
                                                            key={i}
                                                            className={`flex-1 bg-gradient-to-t from-purple-600 via-cyan-400 to-emerald-400 rounded-t-xs transition-all duration-300 ${
                                                                isPlayingAudio ? 'animate-pulse' : ''
                                                            }`}
                                                            style={{ height: `${isPlayingAudio ? Math.min(100, h * 1.1) : h}%` }}
                                                        />
                                                    ))}
                                                </div>

                                                <div className="flex items-center justify-between text-[9px] text-slate-500 font-mono">
                                                    <span>00:00</span>
                                                    <span className="text-amber-400">
                                                        {isPlayingAudio ? 'Reproduciendo Muestra...' : 'Muestra Acústica Lista'}
                                                    </span>
                                                    <span>00:08</span>
                                                </div>
                                            </div>

                                            <div className="mt-3 flex items-center justify-between text-[11px] text-slate-500">
                                                <span>Paciente: <strong>{currentPet.name}</strong></span>
                                                <div className="flex items-center gap-2">
                                                    <button
                                                        type="button"
                                                        onClick={() => setIsPlayingAudio(!isPlayingAudio)}
                                                        className="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[10.5px] flex items-center gap-1 transition"
                                                    >
                                                        {isPlayingAudio ? <Pause className="w-3 h-3 text-purple-600" /> : <Play className="w-3 h-3 text-purple-600" />}
                                                        <span>{isPlayingAudio ? 'Pausar' : 'Escuchar'}</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div className="mt-4 pt-3 border-t border-slate-100 flex gap-2">
                                            <button
                                                type="button"
                                                onClick={() => handleRunBioacousticTriage()}
                                                disabled={isAnalyzing}
                                                className="flex-1 py-2.5 px-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-2xs"
                                            >
                                                <Sparkles className="w-3.5 h-3.5" />
                                                <span>{isAnalyzing ? 'Procesando Onda con Gemini...' : '⚡ Analizar Frecuencias con Gemini AI'}</span>
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
                                                    {getUrgencyBadge(bioacousticResult.urgency_level, bioacousticResult.urgency_color)}
                                                </div>
                                                <p className="text-xs text-slate-500 mt-0.5">
                                                    Modelo Acústico de Auscultación · Gemini 2.5 Flash Audio
                                                </p>
                                            </div>

                                            <div className="text-right">
                                                <span className="text-[10px] font-bold text-slate-400 block">Precisión Espectral</span>
                                                <span className="text-sm font-black text-purple-600">{bioacousticResult.confidence_score || 97.2}%</span>
                                            </div>
                                        </div>

                                        {/* Hipótesis */}
                                        <div className="p-3.5 rounded-xl bg-purple-50/60 border border-purple-200/80">
                                            <div className="text-[11px] font-bold text-purple-900 uppercase tracking-wider mb-1 flex items-center gap-1">
                                                <AlertTriangle className="w-3.5 h-3.5 text-purple-600" />
                                                Diagnóstico Acústico Sugerido
                                            </div>
                                            <p className="text-xs text-slate-800 leading-relaxed font-medium">
                                                {bioacousticResult.preliminary_hypothesis}
                                            </p>
                                        </div>

                                        {/* Marcadores */}
                                        <div>
                                            <span className="text-xs font-bold text-slate-900 block mb-2">
                                                Marcadores Acústicos Pulmonares:
                                            </span>
                                            <ul className="space-y-1.5 text-xs text-slate-600">
                                                {bioacousticResult.acoustic_markers?.map((marker: string, idx: number) => (
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
                                                    Cobertura en {currentPet.plan_name}
                                                </span>
                                                <span className="text-xs font-extrabold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">
                                                    {bioacousticResult.covered_cop}
                                                </span>
                                            </div>
                                            <p className="text-xs text-slate-700 font-medium">
                                                {bioacousticResult.plan_coverage_match}
                                            </p>
                                            <p className="text-[11px] text-slate-500 mt-1 italic">
                                                {bioacousticResult.recommended_action}
                                            </p>
                                        </div>

                                        {/* Botones */}
                                        <div className="flex flex-wrap items-center gap-2 pt-2">
                                            <a
                                                href={bioacousticResult.whatsapp_url || `https://wa.me/${currentPet.customer_phone.replace(/\D/g, '')}`}
                                                target="_blank"
                                                rel="noreferrer"
                                                className="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-2xs"
                                            >
                                                <MessageCircle className="w-4 h-4" />
                                                <span>Enviar Recomendación por WhatsApp</span>
                                            </a>

                                            <a
                                                href={`/admin/${tenantSlug}/counter-redeem`}
                                                className="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold transition shadow-2xs"
                                            >
                                                <Calendar className="w-4 h-4" />
                                                <span>Agendar Auscultación en Sede</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        )}
                    </div>
                )}

                {/* 6. TAB 2: SMART HEALTH WALLET & RESCATE ANTI-CHURN */}
                {mainTab === 'retention' && (
                    <div className="space-y-4">
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-4">
                            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                                <div>
                                    <h3 className="text-base font-black text-slate-900 flex items-center gap-2">
                                        <Wallet className="w-4 h-4 text-amber-600" />
                                        Fondo Quirúrgico de Emergencia (Crédito Clínico Acumulativo)
                                    </h3>
                                    <p className="text-xs text-slate-500 mt-0.5">
                                        Mecanismo actuarial anti-churn: Cada mes, el 10% del canon del plan se acumula a favor del tutor exclusivamente para emergencias y cirugías en la clínica.
                                    </p>
                                </div>

                                <div className="px-3.5 py-1.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs font-bold flex items-center gap-2 shrink-0">
                                    <span>Saldo Total en Custodia:</span>
                                    <span className="text-sm font-black text-amber-700">{walletCustodyCop}</span>
                                </div>
                            </div>

                            <div className="space-y-3">
                                {opportunities.length === 0 ? (
                                    <div className="py-12 text-center text-slate-400 text-xs">
                                        No hay pacientes inactivos con riesgo de abandono en este momento.
                                    </div>
                                ) : (
                                    opportunities.map((opp) => (
                                        <div
                                            key={opp.id}
                                            className="p-4 rounded-xl border border-teal-200 bg-gradient-to-r from-teal-50/50 via-white to-blue-50/30 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:border-teal-400 transition"
                                        >
                                            <div>
                                                <div className="flex items-center gap-2 mb-1">
                                                    <h4 className="text-sm font-black text-slate-900">{opp.pet_name}</h4>
                                                    <span className="text-[10.5px] font-bold px-2 py-0.5 rounded-full bg-blue-100 text-blue-800">
                                                        {opp.plan_name}
                                                    </span>
                                                    <span className="text-xs text-slate-500 font-medium">
                                                        · Tutor: <strong className="text-slate-700">{opp.customer_name}</strong>
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
                                                    <span>Ver Ficha</span>
                                                </a>
                                            </div>
                                        </div>
                                    ))
                                )}
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </VetAdminLayout>
    );
}
