import React, { useState, useEffect, useRef } from 'react';
import { Head } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { 
    Bot, 
    Sparkles, 
    MessageCircle, 
    ShieldCheck, 
    CheckCircle2, 
    TrendingUp, 
    Activity, 
    Calendar, 
    Wallet, 
    UserCheck, 
    Search, 
    ChevronDown, 
    Zap, 
    HeartPulse, 
    Send, 
    Copy, 
    Check, 
    ArrowUpRight, 
    BellRing, 
    ShieldAlert, 
    FileCheck, 
    RefreshCw,
    Syringe,
    Pill,
    Gift,
    Stethoscope,
    Eye,
    ScanLine,
    AlertTriangle,
    Upload,
    Camera,
    Volume2,
    Play,
    Pause,
    MessageSquare,
    X,
    Loader2,
    ChevronRight,
    HelpCircle,
    Info,
    Layers,
    Share2,
    Clock
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

interface ChatMessage {
    id: string;
    sender: 'user' | 'assistant';
    text: string;
    source?: string;
    timestamp: string;
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
}

const VISUAL_PRESETS = [
    {
        id: 'dapp',
        title: 'Dermatitis Alérgica (DAPP)',
        species: 'Canino (Dorso / Lumbar)',
        symptoms: 'Prurito intenso en zona dorso-lumbar con eritema focal, costras y alopecia por rascado continuo.',
        image: 'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=700&auto=format&fit=crop&q=80',
        badge: 'Eritema & Costras',
        color: 'amber'
    },
    {
        id: 'otitis',
        title: 'Otitis Externa Eritematosa',
        species: 'Canino (Pabellón Auricular)',
        symptoms: 'Sacudidas constantes de cabeza, pabellón auricular eritematoso, presencia de cerumen oscuro e hipersensibilidad al tacto.',
        image: 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=700&auto=format&fit=crop&q=80',
        badge: 'Cerumen & Hiperemia',
        color: 'amber'
    },
    {
        id: 'alopecia',
        title: 'Alopecia Circular & Micosis',
        species: 'Felino / Canino (Facial)',
        symptoms: 'Placas alopécicas circulares con descamación y microcostras en extremidades o cara sin prurito severo.',
        image: 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=700&auto=format&fit=crop&q=80',
        badge: 'Sospecha Tiña',
        color: 'rose'
    },
    {
        id: 'herida',
        title: 'Laceración Dérmica Traumática',
        species: 'Canino (Extremidad)',
        symptoms: 'Herida abierta superficial por mordedura o raspón con sangrado leve controlado, eritema perilesional.',
        image: 'https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=700&auto=format&fit=crop&q=80',
        badge: 'Trauma Dérmico',
        color: 'rose'
    },
    {
        id: 'ocular',
        title: 'Blefaritis & Conjuntivitis',
        species: 'Canino / Felino (Ocular)',
        symptoms: 'Secreción conjuntival mucosa o purulenta, blefaroespasmo, epífora e inflamación de párpados.',
        image: 'https://images.unsplash.com/photo-1537151625747-768eb6cf92b2?w=700&auto=format&fit=crop&q=80',
        badge: 'Secreción Ocular',
        color: 'amber'
    }
];

const BIOACOUSTIC_PRESETS = [
    {
        id: 'cough_kennel',
        title: 'Tos Paroxística Seca en Ráfaga',
        condition: 'Traqueobronquitis Infecciosa (Tos de las Perreras)',
        frequency: '4.2 kHz',
        urgency: 'Media (Monitoreo)',
        description: 'Patrón espasmódico seco con náusea terminal luego de excitación o ejercicio.'
    },
    {
        id: 'stridor',
        title: 'Estridor Laríngeo Inspiratorio',
        condition: 'Colapso Traqueal / Síndrome Braquicefálico',
        frequency: '5.6 kHz',
        urgency: 'Alta (Prioritaria)',
        description: 'Sonido áspero agudo durante la inspiración con esfuerzo respiratorio torácico marcado.'
    },
    {
        id: 'wheezing_cat',
        title: 'Sibilancias & Bronco-espasmo',
        condition: 'Asma Felino / Bronquitis Crónica',
        frequency: '3.8 kHz',
        urgency: 'Media (Tratamiento)',
        description: 'Sonido musical continuo en espiración con postura ortopneica típica felina.'
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
    totalOpportunities = 2,
    protectedMrr = '$520.000 COP',
    walletCustodyCop = '$106.000 COP',
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
}: IntelligenceProps) {
    // 4 Modern Specialized Tabs
    const [mainTab, setMainTab] = useState<'triage' | 'generator' | 'retention' | 'copilot'>('triage');

    // Estado del Paciente Seleccionado Global
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
            first_benefit: 'Consulta médica preventiva',
            wallet_balance_cop: 20000,
            formatted_wallet: '$20.000 COP',
        };
    });

    const [petSearch, setPetSearch] = useState('');
    const [isPetDropdownOpen, setIsPetDropdownOpen] = useState(false);

    // ==========================================
    // ESTADO TAB 1: TRIAJE CLÍNICO MULTIMODAL
    // ==========================================
    const [selectedPreset, setSelectedPreset] = useState<string>('dapp');
    const [activeImage, setActiveImage] = useState<string>(VISUAL_PRESETS[0].image);
    const [symptomsInput, setSymptomsInput] = useState<string>(VISUAL_PRESETS[0].symptoms);
    const [customImageBase64, setCustomImageBase64] = useState<string | null>(null);
    const [isTriaging, setIsTriaging] = useState(false);
    const [triageResult, setTriageResult] = useState<TriageResult | null>({
        source: 'gemini-2.5-flash-live',
        preset_id: 'dapp',
        sample_image_url: VISUAL_PRESETS[0].image,
        urgency_level: 'Media (Prioritaria)',
        urgency_color: 'amber',
        confidence_score: 95.8,
        roi_box: { top: 28, left: 32, width: 38, height: 42, label: 'Eritema & Pioderma Superficial' },
        preliminary_hypothesis: 'Dermatopatía alérgica compatible con Dermatitis Alérgica por Picadura de Pulga (DAPP) con sobrecrecimiento bacteriano secundario.',
        clinical_findings: [
            'Eritema activo y lesiones costrosas en zona lumbo-sacra.',
            'Alopecia focal inducida por rascado y prurito persistente.',
            'Pioderma bacteriano superficial secundario a traumatismo cutáneo.'
        ],
        recommended_action: 'Raspado cutáneo para descartar ectoparásitos, citología de superficie y baño medicado con clorhexidina al 3%.',
        plan_coverage_match: `Consulta médico-veterinaria y raspado cutáneo cubiertos 100% en su ${currentPet.plan_name}.`,
        covered_cop: '$55.000 COP cubiertos por membresía activa',
        requires_in_person_visit: true
    });

    // Sub-modo de Triaje: Visual vs Bioacústico
    const [triageMode, setTriageMode] = useState<'visual' | 'bioacoustic'>('visual');
    const [selectedBioPreset, setSelectedBioPreset] = useState<string>('cough_kennel');
    const [isPlayingSound, setIsPlayingSound] = useState(false);

    const handleSelectPreset = (preset: typeof VISUAL_PRESETS[0]) => {
        setSelectedPreset(preset.id);
        setActiveImage(preset.image);
        setSymptomsInput(preset.symptoms);
        setCustomImageBase64(null);
    };

    const handleFileUpload = (e: React.ChangeEvent<HTMLInputElement>) => {
        const file = e.target.files?.[0];
        if (file) {
            const reader = new FileReader();
            reader.onloadend = () => {
                const b64 = reader.result as string;
                setCustomImageBase64(b64);
                setActiveImage(b64);
                setSelectedPreset('custom');
            };
            reader.readAsDataURL(file);
        }
    };

    const handleExecuteTriage = async () => {
        setIsTriaging(true);
        try {
            const payload: any = {
                mode: triageMode,
                pet_id: currentPet.id,
                preset_id: selectedPreset,
                symptoms: symptomsInput,
            };

            if (customImageBase64) {
                payload.image_base64 = customImageBase64;
            }

            const res = await fetch(`/admin/${tenantSlug}/ai/triage`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify(payload),
            });

            const data = await res.json();
            if (data.success && data.triage) {
                setTriageResult({
                    ...data.triage,
                    sample_image_url: activeImage
                });
            }
        } catch (err) {
            console.error('Error executing triage:', err);
        } finally {
            setIsTriaging(false);
        }
    };

    // ==========================================
    // ESTADO TAB 2: GENERADOR DE CAMPAÑAS WHATSAPP
    // ==========================================
    const [campaignType, setCampaignType] = useState<'vaccine' | 'benefits' | 'wallet' | 'followup'>('vaccine');
    const [generatedMessage, setGeneratedMessage] = useState<string>('');
    const [isGeneratingMessage, setIsGeneratingMessage] = useState(false);
    const [copiedWa, setCopiedWa] = useState(false);

    const buildDefaultMessage = (pet: PetItem, type: string) => {
        const custName = pet?.customer_name || 'Tutor';
        const firstName = custName.split(' ')[0] || 'Tutor';
        const petName = pet?.name || 'su mascota';
        const planName = pet?.plan_name || 'Plan de Salud';
        const benefitsCount = pet?.avail_benefits_count ?? 8;
        const firstBenefit = pet?.first_benefit || 'Consulta médica preventiva';
        const walletFormatted = pet?.formatted_wallet || '$20.000 COP';

        if (type === 'vaccine') {
            return `🐾 Hola ${firstName}, te saludamos de ${brandName}. Te recordamos que ${petName} tiene pendiente su refuerzo preventivo anual. Recuerda que su consulta y chequeo están 100% cubiertos en su ${planName}. ¿Deseas agendar su cita para esta semana?`;
        }
        if (type === 'benefits') {
            return `🎁 ¡Hola ${firstName}! En ${brandName} queremos consentir a ${petName}. Aún tienes ${benefitsCount} beneficios disponibles este mes en tu ${planName} (incluyendo ${firstBenefit}). ¡Aprovéchalos antes del cierre de mes agendando su visita!`;
        }
        if (type === 'wallet') {
            return `💰 Hola ${firstName}, te escribimos de ${brandName}. Queríamos contarte una excelente noticia: ${petName} ya tiene acumulados ${walletFormatted} en su Fondo Quirúrgico & Dental de Emergencia gracias a tu ${planName}. ¿Te gustaría usarlo en su próxima profilaxis?`;
        }
        return `🩺 Hola ${firstName}, te saludamos con mucho cariño de ${brandName}. ¿Cómo ha seguido ${petName}? Nos gustaría invitarte a su control de rutina incluido sin costo en tu ${planName}. ¿Qué día te queda mejor?`;
    };

    useEffect(() => {
        if (currentPet) {
            setGeneratedMessage(buildDefaultMessage(currentPet, campaignType));
        }
    }, [currentPet, campaignType]);

    const handleGenerateWithAI = async () => {
        setIsGeneratingMessage(true);
        try {
            const prompt = `Redacta un mensaje de WhatsApp amigable, cálido y persuasivo para enviar a ${currentPet.customer_name} (tutor de ${currentPet.name}, raza ${currentPet.breed}). `
                + `Motivo: ${campaignType === 'vaccine' ? 'Recordar refuerzo de vacunación y chequeo' : campaignType === 'benefits' ? 'Avisar que tiene beneficios disponibles por usar' : campaignType === 'wallet' ? 'Recordar que tiene ' + currentPet.formatted_wallet + ' acumulados en su fondo quirúrgico' : 'Seguimiento clínico de rutina'}. `
                + `Tiene el plan ${currentPet.plan_name}. Máximo 3 o 4 párrafos cortos con emojis y llamada a la acción para agendar cita.`;

            const res = await fetch(`/admin/${tenantSlug}/ai/chat`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ message: prompt, pet_id: currentPet.id }),
            });

            if (res.ok) {
                const data = await res.json();
                if (data.success && data.reply) {
                    setGeneratedMessage(data.reply);
                }
            }
        } catch (err) {
            console.error('Error generating AI message:', err);
        } finally {
            setIsGeneratingMessage(false);
        }
    };

    // ==========================================
    // ESTADO TAB 4: COPILOT CLÍNICO CHAT (GEMINI 2.5)
    // ==========================================
    const [chatMessages, setChatMessages] = useState<ChatMessage[]>([
        {
            id: 'init-1',
            sender: 'assistant',
            text: `¡Hola! Soy AVI Intelligence, tu Copilot Clínico y de Fidelización para **${brandName}**.\n\nEstoy conectado con la base de datos viva de la clínica y puedo ayudarte a:\n• Verificar coberturas de **${currentPet.plan_name}** para **${currentPet.name}**.\n• Calcular dosis de antibióticos y analgésicos veterinarios por peso.\n• Redactar mensajes de WhatsApp y promociones personalizadas para tutores.\n\n¿En qué caso o paciente te apoyo hoy?`,
            source: 'gemini-2.5-flash-live',
            timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
        }
    ]);
    const [chatInput, setChatInput] = useState('');
    const [isChatSending, setIsChatSending] = useState(false);
    const chatEndRef = useRef<HTMLDivElement>(null);

    useEffect(() => {
        if (mainTab === 'copilot') {
            chatEndRef.current?.scrollIntoView({ behavior: 'smooth' });
        }
    }, [chatMessages, mainTab]);

    const handleSendChatMessage = async (presetMessage?: string) => {
        const textToSend = (presetMessage || chatInput).trim();
        if (!textToSend || isChatSending) return;

        const userMsg: ChatMessage = {
            id: `usr-${Date.now()}`,
            sender: 'user',
            text: textToSend,
            timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
        };

        setChatMessages(prev => [...prev, userMsg]);
        if (!presetMessage) setChatInput('');
        setIsChatSending(true);

        try {
            const res = await fetch(`/admin/${tenantSlug}/ai/chat`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({
                    message: textToSend,
                    pet_id: currentPet.id,
                }),
            });

            if (res.ok) {
                const data = await res.json();
                if (data.success && data.reply) {
                    const botMsg: ChatMessage = {
                        id: `bot-${Date.now()}`,
                        sender: 'assistant',
                        text: data.reply,
                        source: data.source || 'gemini-2.5-flash-live',
                        timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
                    };
                    setChatMessages(prev => [...prev, botMsg]);
                }
            } else {
                const botMsg: ChatMessage = {
                    id: `bot-${Date.now()}`,
                    sender: 'assistant',
                    text: 'Hubo una breve demora en el servicio de IA. Por favor intenta de nuevo.',
                    timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
                };
                setChatMessages(prev => [...prev, botMsg]);
            }
        } catch (err) {
            console.error('Error sending chat message:', err);
        } finally {
            setIsChatSending(false);
        }
    };

    const copyToClipboard = (text: string) => {
        navigator.clipboard.writeText(text);
        setCopiedWa(true);
        setTimeout(() => setCopiedWa(false), 2000);
    };

    const getWhatsAppUrl = (phone?: string, text?: string) => {
        const clean = (phone || '3508742543').replace(/\D/g, '') || '3508742543';
        return `https://wa.me/${clean}?text=${encodeURIComponent(text || '')}`;
    };

    const filteredPets = pets.filter(p => 
        p.name.toLowerCase().includes(petSearch.toLowerCase()) ||
        p.customer_name.toLowerCase().includes(petSearch.toLowerCase()) ||
        p.breed.toLowerCase().includes(petSearch.toLowerCase())
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
            activeItem="AVI Intelligence"
        >
            <Head title={`AVI Intelligence · Copilot Clínico & Fidelización · ${brandName}`} />

            <div className="w-full space-y-5 pb-16">
                {/* 1. Header Banner & Status */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    <div>
                        <div className="flex flex-wrap items-center gap-2">
                            <h1 className="text-xl font-black text-slate-900 flex items-center gap-2 tracking-tight">
                                <Sparkles className="w-5 h-5 text-purple-600" />
                                AVI Intelligence · Copilot Clínico & Fidelización
                            </h1>
                            <span className="text-[10px] font-black uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-700 border border-purple-200 flex items-center gap-1">
                                <Bot className="w-3 h-3 text-purple-600" />
                                AI Native Hub
                            </span>
                        </div>
                        <p className="text-xs text-slate-500 mt-1 max-w-3xl">
                            Triaje asistido por Visión Computacional, Generador de Campañas WhatsApp de 1 clic, Rescate Anti-Churn con Fondo Quirúrgico y Copilot Gemini 2.5 Flash grounded con la base de datos de {brandName}.
                        </p>
                    </div>

                    <div className="flex items-center gap-2 shrink-0">
                        <span className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                            <span className="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Gemini 2.5 Flash Live Operativo</span>
                        </span>
                    </div>
                </div>

                {/* 2. Top KPI Cards de Inteligencia de Negocio & Retención */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">MRR Protegido / Mensual</span>
                        <div className="text-2xl font-black text-slate-900">{protectedMrr}</div>
                        <span className="text-[10.5px] font-bold text-emerald-600 mt-1 block">✓ Base de suscripciones activas</span>
                    </div>

                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">Fondo Quirúrgico en Custodia</span>
                        <div className="text-2xl font-black text-amber-600">{walletCustodyCop}</div>
                        <span className="text-[10.5px] font-medium text-slate-500 mt-1 block">10% acumulativo anti-cancelación</span>
                    </div>

                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">Pacientes en Riesgo (+60 días)</span>
                        <div className="text-2xl font-black text-rose-600">{totalOpportunities}</div>
                        <span className="text-[10.5px] font-medium text-rose-600 mt-1 block">Listos para rescate WhatsApp</span>
                    </div>

                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">Tasa de Fidelización Clínica</span>
                        <div className="text-2xl font-black text-blue-600">{retentionRate}</div>
                        <span className="text-[10.5px] font-medium text-slate-500 mt-1 block">Retención por crédito preventivo</span>
                    </div>
                </div>

                {/* 3. Selector Dinámico de Paciente Global */}
                <div className="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-2xl p-4 sm:p-5 text-white shadow-md border border-slate-800">
                    <div className="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        <div className="flex items-center gap-3.5">
                            <div className="relative">
                                {currentPet.photo_url ? (
                                    <img 
                                        src={currentPet.photo_url} 
                                        alt={currentPet.name} 
                                        className="w-14 h-14 rounded-2xl object-cover border-2 border-white/20 shadow-md"
                                    />
                                ) : (
                                    <div className="w-14 h-14 rounded-2xl bg-white/10 border-2 border-white/20 flex items-center justify-center text-2xl">
                                        {currentPet.species === 'Felino' ? '🐱' : '🐶'}
                                    </div>
                                )}
                            </div>

                            <div>
                                <div className="flex flex-wrap items-center gap-2">
                                    <h2 className="text-lg font-black text-white">{currentPet.name}</h2>
                                    <span className="text-[10.5px] font-bold px-2 py-0.5 rounded-full bg-teal-400/20 text-teal-200 border border-teal-400/30">
                                        {currentPet.plan_name}
                                    </span>
                                    <span className="text-[10px] font-mono bg-white/10 px-2 py-0.5 rounded text-indigo-200">
                                        {currentPet.breed} · {currentPet.age}
                                    </span>
                                </div>
                                <p className="text-xs text-indigo-100 mt-1 flex flex-wrap items-center gap-2">
                                    <span>Tutor: <strong className="text-white">{currentPet.customer_name}</strong></span>
                                    <span>·</span>
                                    <span className="font-mono text-teal-200">📱 {currentPet.customer_phone}</span>
                                    <span>·</span>
                                    <span className="text-teal-300 font-bold">🎁 {currentPet.avail_benefits_count} beneficios disponibles</span>
                                    <span>·</span>
                                    <span className="text-amber-300 font-bold">💰 {currentPet.formatted_wallet} en custodia</span>
                                </p>
                            </div>
                        </div>

                        {/* Dropdown de Selección */}
                        <div className="relative">
                            <div className="flex items-center gap-2">
                                <span className="text-xs text-indigo-200 font-medium hidden sm:inline">Cambiar Paciente:</span>
                                <button
                                    type="button"
                                    onClick={() => setIsPetDropdownOpen(!isPetDropdownOpen)}
                                    className="px-3.5 py-2 rounded-xl bg-white/15 hover:bg-white/25 border border-white/20 text-white text-xs font-bold transition flex items-center gap-2 cursor-pointer"
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
                                                value={petSearch}
                                                onChange={(e) => setPetSearch(e.target.value)}
                                                placeholder="Buscar por paciente, tutor o raza..."
                                                className="w-full pl-8 pr-3 py-1.5 text-xs rounded-lg border border-slate-200 focus:outline-hidden focus:ring-1 focus:ring-blue-500"
                                            />
                                        </div>
                                    </div>
                                    <div className="space-y-1">
                                        {filteredPets.length === 0 ? (
                                            <div className="p-3 text-center text-xs text-slate-400">
                                                No se encontraron pacientes
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
                                                    className={`w-full text-left p-2 rounded-xl text-xs flex items-center justify-between transition cursor-pointer ${
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
                                                        {(p.plan_name || 'Plan Activo').split(' ')[1] || p.plan_name || 'Activo'}
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

                {/* 4. Sub-Navigation: 4 Pestañas Especializadas */}
                <div className="grid grid-cols-2 md:grid-cols-4 border-b border-slate-200 bg-white rounded-2xl p-1.5 gap-2 shadow-2xs">
                    <button
                        onClick={() => setMainTab('triage')}
                        className={`py-2.5 px-3 rounded-xl text-xs font-bold flex items-center justify-center gap-2 transition cursor-pointer ${
                            mainTab === 'triage'
                                ? 'bg-blue-600 text-white shadow-xs'
                                : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
                        }`}
                    >
                        <Stethoscope className="w-4 h-4" />
                        <span>Triaje Visión IA</span>
                        <span className={`text-[9px] px-1.5 py-0.5 rounded-full font-black ${mainTab === 'triage' ? 'bg-blue-500 text-white' : 'bg-blue-100 text-blue-800'}`}>
                            Gemini 2.5
                        </span>
                    </button>

                    <button
                        onClick={() => setMainTab('generator')}
                        className={`py-2.5 px-3 rounded-xl text-xs font-bold flex items-center justify-center gap-2 transition cursor-pointer ${
                            mainTab === 'generator'
                                ? 'bg-emerald-600 text-white shadow-xs'
                                : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
                        }`}
                    >
                        <MessageCircle className="w-4 h-4" />
                        <span>Campañas WhatsApp</span>
                        <span className={`text-[9px] px-1.5 py-0.5 rounded-full font-black ${mainTab === 'generator' ? 'bg-emerald-700 text-white' : 'bg-emerald-100 text-emerald-800'}`}>
                            1 Clic
                        </span>
                    </button>

                    <button
                        onClick={() => setMainTab('retention')}
                        className={`py-2.5 px-3 rounded-xl text-xs font-bold flex items-center justify-center gap-2 transition cursor-pointer ${
                            mainTab === 'retention'
                                ? 'bg-amber-600 text-white shadow-xs'
                                : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
                        }`}
                    >
                        <Wallet className="w-4 h-4" />
                        <span>Rescate Anti-Churn</span>
                        <span className={`text-[9px] px-1.5 py-0.5 rounded-full font-black ${mainTab === 'retention' ? 'bg-amber-700 text-white' : 'bg-amber-100 text-amber-800'}`}>
                            {totalOpportunities}
                        </span>
                    </button>

                    <button
                        onClick={() => setMainTab('copilot')}
                        className={`py-2.5 px-3 rounded-xl text-xs font-bold flex items-center justify-center gap-2 transition cursor-pointer ${
                            mainTab === 'copilot'
                                ? 'bg-purple-600 text-white shadow-xs'
                                : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
                        }`}
                    >
                        <Bot className="w-4 h-4" />
                        <span>Copilot Gemini Chat</span>
                        <span className={`text-[9px] px-1.5 py-0.5 rounded-full font-black ${mainTab === 'copilot' ? 'bg-purple-700 text-white' : 'bg-purple-100 text-purple-700'}`}>
                            En Vivo
                        </span>
                    </button>
                </div>

                {/* ======================================================== */}
                {/* 5. TAB 1: TRIAJE CLÍNICO & VISIÓN COMPUTACIONAL GEMINI */}
                {/* ======================================================== */}
                {mainTab === 'triage' && (
                    <div className="space-y-4">
                        {/* Selector de Casos Presets o Carga de Foto */}
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-4">
                            <div className="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-100 gap-2">
                                <div>
                                    <h3 className="text-base font-black text-slate-900 flex items-center gap-2">
                                        <Eye className="w-4 h-4 text-blue-600" />
                                        Triaje Visual & Cruce Actuarial de Coberturas
                                    </h3>
                                    <p className="text-xs text-slate-500 mt-0.5">
                                        Evalúa fotos de lesiones dérmicas, otitis o laceraciones con Gemini 2.5 y cruza automáticamente con el plan <strong className="text-slate-800">{currentPet.plan_name}</strong> de {currentPet.name}.
                                    </p>
                                </div>

                                <div className="flex items-center gap-2">
                                    <label className="px-3.5 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-bold border border-blue-200 cursor-pointer flex items-center gap-1.5 transition">
                                        <Camera className="w-3.5 h-3.5" />
                                        <span>Subir Foto del Paciente</span>
                                        <input
                                            type="file"
                                            accept="image/*"
                                            className="hidden"
                                            onChange={handleFileUpload}
                                        />
                                    </label>
                                </div>
                            </div>

                            {/* Presets visuales frecuentes */}
                            <div>
                                <span className="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-2">
                                    Casos Clínicos Frecuentes (Presets Inmediatos):
                                </span>
                                <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2">
                                    {VISUAL_PRESETS.map((p) => (
                                        <button
                                            key={p.id}
                                            type="button"
                                            onClick={() => handleSelectPreset(p)}
                                            className={`p-2.5 rounded-xl border text-left transition flex flex-col justify-between gap-2 cursor-pointer ${
                                                selectedPreset === p.id && !customImageBase64
                                                    ? 'border-blue-500 bg-blue-50/80 ring-2 ring-blue-500/20'
                                                    : 'border-slate-200 hover:border-slate-300 bg-white'
                                            }`}
                                        >
                                            <div className="w-full h-20 rounded-lg overflow-hidden relative">
                                                <img src={p.image} alt={p.title} className="w-full h-full object-cover" />
                                                <span className="absolute bottom-1 left-1 text-[9px] font-bold px-1.5 py-0.5 rounded bg-slate-900/80 text-white">
                                                    {p.badge}
                                                </span>
                                            </div>
                                            <div>
                                                <div className="font-bold text-xs text-slate-900 leading-tight">{p.title}</div>
                                                <div className="text-[10px] text-slate-500 mt-0.5">{p.species}</div>
                                            </div>
                                        </button>
                                    ))}
                                </div>
                            </div>

                            {/* Descripción de síntomas / anamnesis */}
                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">
                                    Signos Clínicos Observados / Anamnesis:
                                </label>
                                <div className="flex gap-2">
                                    <input
                                        type="text"
                                        value={symptomsInput}
                                        onChange={(e) => setSymptomsInput(e.target.value)}
                                        placeholder="Describe los síntomas observados..."
                                        className="flex-1 px-3.5 py-2 text-xs rounded-xl border border-slate-200 focus:outline-hidden focus:ring-2 focus:ring-blue-500"
                                    />
                                    <button
                                        type="button"
                                        onClick={handleExecuteTriage}
                                        disabled={isTriaging}
                                        className="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition flex items-center gap-2 cursor-pointer disabled:opacity-50 shrink-0 shadow-xs"
                                    >
                                        {isTriaging ? (
                                            <>
                                                <Loader2 className="w-4 h-4 animate-spin" />
                                                <span>Analizando con Gemini...</span>
                                            </>
                                        ) : (
                                            <>
                                                <Sparkles className="w-4 h-4" />
                                                <span>Evaluar con Gemini AI</span>
                                            </>
                                        )}
                                    </button>
                                </div>
                            </div>
                        </div>

                        {/* Panel de Resultados del Triaje */}
                        {triageResult && (
                            <div className="grid grid-cols-1 lg:grid-cols-12 gap-4">
                                {/* Imagen con Bounding Box ROI */}
                                <div className="lg:col-span-5 bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs space-y-3">
                                    <div className="flex items-center justify-between">
                                        <span className="text-xs font-black text-slate-900 flex items-center gap-1.5">
                                            <ScanLine className="w-4 h-4 text-blue-600" />
                                            Detección de Región de Interés (ROI)
                                        </span>
                                        {triageResult.confidence_score && (
                                            <span className="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                {triageResult.confidence_score}% Coincidencia
                                            </span>
                                        )}
                                    </div>

                                    <div className="relative w-full aspect-4/3 rounded-xl overflow-hidden border border-slate-200 bg-slate-900">
                                        <img 
                                            src={triageResult.sample_image_url || activeImage} 
                                            alt="Lesión clínica" 
                                            className="w-full h-full object-cover"
                                        />

                                        {/* Overlay ROI Box */}
                                        {triageResult.roi_box && (
                                            <div
                                                style={{
                                                    top: `${triageResult.roi_box.top}%`,
                                                    left: `${triageResult.roi_box.left}%`,
                                                    width: `${triageResult.roi_box.width}%`,
                                                    height: `${triageResult.roi_box.height}%`,
                                                }}
                                                className="absolute border-2 border-amber-400 bg-amber-400/20 rounded-lg animate-pulse pointer-events-none"
                                            >
                                                <span className="absolute -top-6 left-0 text-[9.5px] font-black bg-amber-500 text-slate-900 px-2 py-0.5 rounded shadow-xs whitespace-nowrap">
                                                    {triageResult.roi_box.label}
                                                </span>
                                            </div>
                                        )}
                                    </div>

                                    <div className="p-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-600 text-[11px] leading-relaxed flex items-start gap-2">
                                        <Info className="w-4 h-4 text-slate-400 shrink-0 mt-0.5" />
                                        <span>
                                            El modelo detectó una región eritematosa perilesional activa compatible con signos inflamatorios.
                                        </span>
                                    </div>
                                </div>

                                {/* Informe Diagnóstico & Cruce con Plan */}
                                <div className="lg:col-span-7 space-y-4">
                                    {/* Nivel de Urgencia & Hipótesis */}
                                    <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-3">
                                        <div className="flex flex-wrap items-center justify-between gap-2 pb-3 border-b border-slate-100">
                                            <div className="flex items-center gap-2">
                                                <span className="text-xs font-bold text-slate-500">Nivel de Urgencia:</span>
                                                <span className={`px-2.5 py-1 rounded-full text-xs font-extrabold border ${
                                                    triageResult.urgency_color === 'rose'
                                                        ? 'bg-rose-50 text-rose-700 border-rose-200'
                                                        : triageResult.urgency_color === 'amber'
                                                        ? 'bg-amber-50 text-amber-800 border-amber-200'
                                                        : 'bg-emerald-50 text-emerald-700 border-emerald-200'
                                                }`}>
                                                    ● {triageResult.urgency_level}
                                                </span>
                                            </div>
                                            <span className="text-[10px] text-slate-400 font-mono">
                                                Modelo: Gemini 2.5 Flash Live
                                            </span>
                                        </div>

                                        <div>
                                            <span className="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                                Hipótesis Diagnóstica Preliminar:
                                            </span>
                                            <p className="text-sm font-extrabold text-slate-900 leading-snug">
                                                {triageResult.preliminary_hypothesis}
                                            </p>
                                        </div>

                                        {triageResult.clinical_findings && triageResult.clinical_findings.length > 0 && (
                                            <div>
                                                <span className="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                                    Hallazgos Clínicos Observados:
                                                </span>
                                                <ul className="space-y-1">
                                                    {triageResult.clinical_findings.map((f, idx) => (
                                                        <li key={idx} className="text-xs text-slate-700 flex items-start gap-2">
                                                            <span className="text-blue-500 font-bold">•</span>
                                                            <span>{f}</span>
                                                        </li>
                                                    ))}
                                                </ul>
                                            </div>
                                        )}

                                        <div>
                                            <span className="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                                Conducta Médica Inmediata:
                                            </span>
                                            <p className="text-xs text-slate-600 bg-slate-50 p-3 rounded-xl border border-slate-200 leading-relaxed">
                                                {triageResult.recommended_action}
                                            </p>
                                        </div>
                                    </div>

                                    {/* Cruce Actuarial con el Plan de Salud (La Magia de AVI) */}
                                    <div className="bg-gradient-to-br from-emerald-950 via-slate-900 to-indigo-950 rounded-2xl p-5 text-white shadow-md border border-emerald-800/40 space-y-3">
                                        <div className="flex items-center justify-between">
                                            <div className="flex items-center gap-2">
                                                <ShieldCheck className="w-5 h-5 text-emerald-400" />
                                                <h4 className="text-sm font-black text-white">
                                                    Cruce Actuarial: Cobertura en {currentPet.plan_name}
                                                </h4>
                                            </div>
                                            <span className="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-400/20 text-emerald-300 border border-emerald-400/30">
                                                100% Sin Costo Adicional
                                            </span>
                                        </div>

                                        <p className="text-xs text-emerald-100 leading-relaxed">
                                            {triageResult.plan_coverage_match}
                                        </p>

                                        <div className="p-3 rounded-xl bg-white/10 border border-white/15 flex items-center justify-between">
                                            <div>
                                                <span className="text-[10px] text-emerald-300 uppercase font-bold block">
                                                    Ahorro para el Tutor ({currentPet.customer_name}):
                                                </span>
                                                <span className="text-base font-black text-white">
                                                    {triageResult.covered_cop}
                                                </span>
                                            </div>
                                            <span className="text-2xl">🎉</span>
                                        </div>

                                        <div className="flex flex-wrap items-center gap-2 pt-1">
                                            <a
                                                href={getWhatsAppUrl(
                                                    currentPet.customer_phone,
                                                    `🐾 Hola ${currentPet.customer_name.split(' ')[0]}, evaluamos el caso de ${currentPet.name} con nuestro sistema clínico. La buena noticia es que la consulta médica y procedimiento están 100% CUBIERTOS en su ${currentPet.plan_name} ($0 COP para ti). ¿Te apartamos una cita de atención hoy mismo?`
                                                )}
                                                target="_blank"
                                                rel="noreferrer"
                                                className="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-black text-xs transition shadow-sm"
                                            >
                                                <MessageCircle className="w-4 h-4" />
                                                <span>Enviar Explicación al Tutor por WhatsApp</span>
                                            </a>

                                            <a
                                                href={`/admin/${tenantSlug}/citas`}
                                                className="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-white/15 hover:bg-white/25 text-white text-xs font-bold transition border border-white/20"
                                            >
                                                <Calendar className="w-3.5 h-3.5 text-teal-300" />
                                                <span>Agendar en Mostrador</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        )}
                    </div>
                )}

                {/* ======================================================== */}
                {/* 6. TAB 2: GENERADOR DE CAMPAÑAS WHATSAPP (1 CLIC) */}
                {/* ======================================================== */}
                {mainTab === 'generator' && (
                    <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-4">
                        <div className="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-100 gap-2">
                            <div>
                                <h3 className="text-base font-black text-slate-900 flex items-center gap-2">
                                    <MessageCircle className="w-5 h-5 text-emerald-600" />
                                    Generador de Mensajes Persuasivos de WhatsApp
                                </h3>
                                <p className="text-xs text-slate-500 mt-0.5">
                                    Genera mensajes personalizados para <strong className="text-slate-800">{currentPet.name}</strong> ({currentPet.customer_name}) listos para enviar en 1 clic.
                                </p>
                            </div>

                            <span className="text-[10.5px] font-bold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 w-max">
                                Destinatario: {currentPet.customer_phone}
                            </span>
                        </div>

                        {/* Tipo de Campaña / Mensaje */}
                        <div>
                            <label className="text-xs font-bold text-slate-700 block mb-2">
                                Selecciona el Objetivo del Mensaje:
                            </label>
                            <div className="grid grid-cols-2 sm:grid-cols-4 gap-2">
                                {[
                                    { id: 'vaccine', label: '💉 Vacunación & Refuerzo', desc: 'Recordar refuerzo anual pendiente' },
                                    { id: 'benefits', label: '🎁 Beneficios sin Usar', desc: `${currentPet.avail_benefits_count} servicios disponibles` },
                                    { id: 'wallet', label: '💰 Crédito Quirúrgico / Dental', desc: `${currentPet.formatted_wallet} acumulados` },
                                    { id: 'followup', label: '🩺 Control & Chequeo Preventivo', desc: 'Consulta médica incluida' },
                                ].map((type) => (
                                    <button
                                        key={type.id}
                                        type="button"
                                        onClick={() => setCampaignType(type.id as any)}
                                        className={`p-3 rounded-xl border text-left transition flex flex-col justify-between gap-1 cursor-pointer ${
                                            campaignType === type.id
                                                ? 'border-emerald-600 bg-emerald-50/70 shadow-2xs ring-2 ring-emerald-500/20'
                                                : 'border-slate-200 hover:border-slate-300 bg-white'
                                        }`}
                                    >
                                        <span className="text-xs font-black text-slate-900">{type.label}</span>
                                        <span className="text-[10px] text-slate-500">{type.desc}</span>
                                    </button>
                                ))}
                            </div>
                        </div>

                        {/* Vista Previa y Edición del Mensaje */}
                        <div className="grid grid-cols-1 lg:grid-cols-12 gap-4 pt-2">
                            <div className="lg:col-span-8 space-y-2">
                                <div className="flex items-center justify-between">
                                    <label className="text-xs font-bold text-slate-800">
                                        Texto del Mensaje (Editable antes de enviar):
                                    </label>
                                    <button
                                        type="button"
                                        onClick={handleGenerateWithAI}
                                        disabled={isGeneratingMessage}
                                        className="text-xs font-bold text-purple-700 hover:text-purple-900 flex items-center gap-1.5 transition cursor-pointer"
                                    >
                                        <Sparkles className="w-3.5 h-3.5 text-purple-600" />
                                        <span>{isGeneratingMessage ? 'Generando con Gemini...' : 'Re-generar con Copilot IA'}</span>
                                    </button>
                                </div>

                                <textarea
                                    rows={5}
                                    value={generatedMessage}
                                    onChange={(e) => setGeneratedMessage(e.target.value)}
                                    className="w-full p-3.5 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-hidden focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition resize-none leading-relaxed"
                                />

                                <div className="flex flex-wrap items-center gap-2 pt-1">
                                    <a
                                        href={getWhatsAppUrl(currentPet.customer_phone, generatedMessage)}
                                        target="_blank"
                                        rel="noreferrer"
                                        className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-xs"
                                    >
                                        <MessageCircle className="w-4 h-4" />
                                        <span>Enviar a WhatsApp ({currentPet.customer_phone})</span>
                                    </a>

                                    <button
                                        type="button"
                                        onClick={() => copyToClipboard(generatedMessage)}
                                        className="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition border border-slate-200 cursor-pointer"
                                    >
                                        {copiedWa ? <Check className="w-3.5 h-3.5 text-emerald-600" /> : <Copy className="w-3.5 h-3.5" />}
                                        <span>{copiedWa ? 'Mensaje Copiado' : 'Copiar Texto'}</span>
                                    </button>
                                </div>
                            </div>

                            {/* Tarjeta Visual Estilo WhatsApp */}
                            <div className="lg:col-span-4 bg-[#e5ddd5] p-3 rounded-2xl border border-slate-300 flex flex-col justify-between shadow-inner">
                                <div className="text-[10px] text-slate-500 font-bold uppercase tracking-wider mb-2 text-center">
                                    Simulación Pantalla WhatsApp
                                </div>

                                <div className="bg-white p-3 rounded-xl rounded-tr-xs shadow-xs text-xs text-slate-800 space-y-1.5 whitespace-pre-line leading-relaxed">
                                    {generatedMessage}
                                    <div className="text-[9px] text-slate-400 text-right font-mono">
                                        {new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })} ✓✓
                                    </div>
                                </div>

                                <div className="text-[10px] text-slate-500 text-center mt-2 font-medium">
                                    Enviado directamente desde tu número de clínica
                                </div>
                            </div>
                        </div>
                    </div>
                )}

                {/* ======================================================== */}
                {/* 7. TAB 3: RESCATE ANTI-CHURN & FONDO QUIRÚRGICO */}
                {/* ======================================================== */}
                {mainTab === 'retention' && (
                    <div className="space-y-4">
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-4">
                            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                                <div>
                                    <h3 className="text-base font-black text-slate-900 flex items-center gap-2">
                                        <Wallet className="w-4 h-4 text-amber-600" />
                                        Mecanismo de Retención: Fondo Quirúrgico & Dental en Custodia
                                    </h3>
                                    <p className="text-xs text-slate-500 mt-0.5">
                                        Cada mes que el tutor paga su suscripción, el 10% se acumula a su favor exclusivamente para cirugías, urgencias y profilaxis en {brandName}. Si cancela el plan, pierde el crédito acumulado.
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
                                            className="p-4 rounded-xl border border-teal-200 bg-gradient-to-r from-teal-50/40 via-white to-blue-50/20 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:border-teal-400 transition"
                                        >
                                            <div>
                                                <div className="flex flex-wrap items-center gap-2 mb-1">
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
                                                    className="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-xs"
                                                >
                                                    <MessageCircle className="w-3.5 h-3.5" />
                                                    <span>WhatsApp de Rescate</span>
                                                </a>
                                                <a
                                                    href={`/admin/${tenantSlug}/citas`}
                                                    className="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-xs"
                                                >
                                                    <Calendar className="w-3.5 h-3.5" />
                                                    <span>Agendar</span>
                                                </a>
                                            </div>
                                        </div>
                                    ))
                                )}
                            </div>
                        </div>
                    </div>
                )}

                {/* ======================================================== */}
                {/* 8. TAB 4: COPILOT CLÍNICO GEMINI 2.5 FLASH CHAT */}
                {/* ======================================================== */}
                {mainTab === 'copilot' && (
                    <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-4">
                        <div className="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-100 gap-2">
                            <div>
                                <h3 className="text-base font-black text-slate-900 flex items-center gap-2">
                                    <Bot className="w-5 h-5 text-purple-600" />
                                    Copilot Inteligente Gemini 2.5 Flash Live
                                </h3>
                                <p className="text-xs text-slate-500 mt-0.5">
                                    Asistente grounded con la base de datos viva de {brandName} para consultar vademécum, dosis veterinarias o coberturas de <strong className="text-slate-700">{currentPet.plan_name}</strong>.
                                </p>
                            </div>

                            <span className="text-[10.5px] font-bold px-2.5 py-1 rounded-full bg-purple-50 text-purple-700 border border-purple-200 w-max">
                                Paciente: {currentPet.name} ({currentPet.breed})
                            </span>
                        </div>

                        {/* Preguntas Rápidas */}
                        <div>
                            <span className="text-xs font-bold text-slate-600 block mb-1.5">
                                Preguntas Frecuentes:
                            </span>
                            <div className="flex flex-wrap gap-2">
                                {[
                                    `¿Qué cobertura tiene ${currentPet.name} en su ${currentPet.plan_name}?`,
                                    `Redactar promoción de profilaxis dental para el mes de las mascotas`,
                                    `¿Qué vacunas corresponden en el refuerzo anual para ${currentPet.breed}?`,
                                    `¿Cuál es la dosis sugerida de Amoxicilina para ${currentPet.name}?`,
                                ].map((promptText, idx) => (
                                    <button
                                        key={idx}
                                        type="button"
                                        onClick={() => handleSendChatMessage(promptText)}
                                        className="text-left px-3 py-1.5 rounded-lg text-xs font-medium bg-purple-50 hover:bg-purple-100 text-purple-800 border border-purple-200 transition cursor-pointer"
                                    >
                                        💬 {promptText}
                                    </button>
                                ))}
                            </div>
                        </div>

                        {/* Ventana de Mensajes */}
                        <div className="h-80 overflow-y-auto p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                            {chatMessages.map((msg) => (
                                <div
                                    key={msg.id}
                                    className={`flex gap-3 ${msg.sender === 'user' ? 'justify-end' : 'justify-start'}`}
                                >
                                    {msg.sender === 'assistant' && (
                                        <div className="w-8 h-8 rounded-full bg-purple-600 text-white flex items-center justify-center shrink-0 text-sm shadow-xs">
                                            🤖
                                        </div>
                                    )}

                                    <div
                                        className={`max-w-[85%] sm:max-w-[75%] p-3.5 rounded-2xl text-xs space-y-1 shadow-2xs ${
                                            msg.sender === 'user'
                                                ? 'bg-purple-600 text-white rounded-br-xs'
                                                : 'bg-white text-slate-800 border border-slate-200/90 rounded-bl-xs'
                                        }`}
                                    >
                                        <div className="font-semibold whitespace-pre-line leading-relaxed">
                                            {msg.text}
                                        </div>
                                        <div className="flex items-center justify-between gap-4 pt-1 text-[9.5px] opacity-70">
                                            <span>{msg.sender === 'assistant' ? 'Gemini 2.5 Flash Live' : 'Tú'}</span>
                                            <span>{msg.timestamp}</span>
                                        </div>
                                    </div>

                                    {msg.sender === 'user' && (
                                        <div className="w-8 h-8 rounded-full bg-purple-600 text-white flex items-center justify-center shrink-0 text-xs font-bold shadow-xs">
                                            {userName ? userName.charAt(0) : 'V'}
                                        </div>
                                    )}
                                </div>
                            ))}

                            {isChatSending && (
                                <div className="flex items-center gap-3">
                                    <div className="w-8 h-8 rounded-full bg-purple-600 text-white flex items-center justify-center shrink-0 text-sm shadow-xs animate-pulse">
                                        🤖
                                    </div>
                                    <div className="bg-white border border-slate-200 p-3 rounded-2xl rounded-bl-xs text-xs text-slate-500 flex items-center gap-2">
                                        <div className="w-3.5 h-3.5 border-2 border-purple-600 border-t-transparent rounded-full animate-spin"></div>
                                        <span>Gemini 2.5 Flash está procesando la respuesta...</span>
                                    </div>
                                </div>
                            )}

                            <div ref={chatEndRef} />
                        </div>

                        {/* Input del Chat */}
                        <form
                            onSubmit={(e) => {
                                e.preventDefault();
                                handleSendChatMessage();
                            }}
                            className="flex items-center gap-2"
                        >
                            <input
                                type="text"
                                value={chatInput}
                                onChange={(e) => setChatInput(e.target.value)}
                                placeholder="Escribe tu consulta o pide redactar un texto para clientes..."
                                disabled={isChatSending}
                                className="flex-1 px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:outline-hidden focus:border-purple-600 focus:ring-2 focus:ring-purple-100 transition"
                            />

                            <button
                                type="submit"
                                disabled={!chatInput.trim() || isChatSending}
                                className="px-5 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-xs disabled:opacity-50 cursor-pointer"
                            >
                                <Send className="w-3.5 h-3.5" />
                                <span>Enviar</span>
                            </button>
                        </form>
                    </div>
                )}
            </div>
        </VetAdminLayout>
    );
}
