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
    HeartPulse,
    Send,
    MessageSquare,
    Copy,
    Check,
    X,
    Pill,
    HelpCircle,
    Info,
    Share2
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
    visualTriage?: TriageResult;
    bioacousticTriage?: TriageResult;
}

const VISUAL_PRESETS = [
    {
        id: 'dapp',
        title: 'Dermatitis Alérgica / DAPP',
        species: 'Canino (Dorso / Flancos)',
        symptoms: 'Prurito intenso en zona dorso-lumbar con eritema focal, costras y alopecia por rascado continuo.',
        image: 'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=700&auto=format&fit=crop&q=80',
        badge: 'Eritema Focal',
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
        title: 'Alopecia Circular & Escaras',
        species: 'Felino / Canino (Micosis)',
        symptoms: 'Placas alopécicas circulares con descamación y microcostras en extremidades o cara.',
        image: 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=700&auto=format&fit=crop&q=80',
        badge: 'Lesión Micótica',
        color: 'emerald'
    },
    {
        id: 'herida',
        title: 'Laceración Dérmica Traumática',
        species: 'Canino (Herida Superficial)',
        symptoms: 'Corte superficial con solución de continuidad dérmica, bordes eritematosos y sangrado leve controlado.',
        image: 'https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=700&auto=format&fit=crop&q=80',
        badge: 'Urgencia Quirúrgica',
        color: 'rose'
    },
    {
        id: 'ocular',
        title: 'Queratoconjuntivitis & Epífora',
        species: 'Canino / Felino (Ocular)',
        symptoms: 'Blefaroespasmo, lagrimeo excesivo (epífora), hiperemia conjuntival y molestia a la luz.',
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
    const [mainTab, setMainTab] = useState<'triage' | 'copilot' | 'bioacoustic' | 'retention'>('triage');

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

    // Estado del Triaje Clínico & Visual
    const [clinicalSymptoms, setClinicalSymptoms] = useState(
        'Prurito intenso en zona dorso-lumbar con eritema focal, costras y pérdida de pelo por rascado continuo.'
    );
    const [selectedVisualPreset, setSelectedVisualPreset] = useState<string | null>(null);
    const [showPresetsLibrary, setShowPresetsLibrary] = useState(false);
    const [customImageBase64, setCustomImageBase64] = useState<string | null>(null);
    const [currentImageSrc, setCurrentImageSrc] = useState<string | null>(null);

    const [visualResult, setVisualResult] = useState<TriageResult>(initialVisualTriage || {
        source: 'gemini-2.5-flash-live',
        urgency_level: 'Media (Prioritaria)',
        urgency_color: 'amber',
        confidence_score: 95.8,
        preliminary_hypothesis: `Signos compatibles con dermatitis alérgica por picadura de ectoparásitos (DAPP) con eritema focal e inflamación cutánea moderada en ${currentPet.name}.`,
        clinical_findings: [
            'Eritema y alopecia focal en flancos y zona lumbosacra.',
            'Reflejo de prurito activo con riesgo de sobreinfección bacteriana secundaria.',
            'Sin compromiso sistémico inmediato ni afectación respiratoria.',
        ],
        recommended_action: 'Programar revisión médica en sede en las próximas 24 a 48 horas. Instaurar control antiparasitario y evitar corticoides tópicos humanos.',
        plan_coverage_match: `Consulta Médica General & Desparasitación Externa cubiertas al 100% en ${currentPet.plan_name}.`,
        covered_cop: '$55.000 COP cubiertos por membresía activa',
        requires_in_person_visit: true,
        whatsapp_message: `🐾 Hola ${currentPet.customer_name.split(' ')[0]}, realizamos el triaje con IA de ${currentPet.name}. Tienes la consulta y el tratamiento 100% cubiertos en tu ${currentPet.plan_name}. ¿Deseas agendar para hoy?`,
        whatsapp_url: `https://wa.me/${currentPet.customer_phone.replace(/\D/g, '')}?text=${encodeURIComponent(`🐾 Hola ${currentPet.customer_name.split(' ')[0]}, realizamos el triaje con IA de ${currentPet.name}. Tienes la consulta y el tratamiento 100% cubiertos en tu ${currentPet.plan_name}. ¿Deseas agendar para hoy?`)}`,
    });

    // Estado Bioacústico
    const [selectedBioacousticPreset, setSelectedBioacousticPreset] = useState('cough_kennel');
    const [isPlayingAudio, setIsPlayingAudio] = useState(false);
    const [bioacousticResult, setBioacousticResult] = useState<TriageResult>(initialBioacousticTriage || {
        source: 'gemini-2.5-flash-live',
        urgency_level: 'Media (Monitoreo Clínico)',
        urgency_color: 'amber',
        confidence_score: 97.2,
        sound_pattern: 'Tos Paroxística Seca en Ráfaga',
        peak_frequency: '4.2 kHz',
        preliminary_hypothesis: `Patrón acústico compatible con tos paroxística seca no productiva, compatible con traqueobronquitis infecciosa canina (Tos de las Perreras) en ${currentPet.name}.`,
        acoustic_markers: [
            'Frecuencia y timbre: Golpe seco en accesos paroxísticos al final del ciclo espiratorio (4.2 kHz).',
            'Ausencia de estertores húmedos basales (menor probabilidad de edema agudo pulmonar).',
            'Reflejo tusígeno positivo por irritación traqueofaríngea.',
        ],
        recommended_action: 'Aislamiento de otros animales. Usar arnés de pecho en lugar de collar de cuello. Cita presencial para auscultación cardiopulmonar.',
        plan_coverage_match: `Chequeo Preventivo Clínico al 100% incluido en ${currentPet.plan_name}.`,
        covered_cop: '$50.000 COP cubiertos sin costo adicional',
        requires_in_person_visit: true,
        whatsapp_message: `🐾 Hola ${currentPet.customer_name.split(' ')[0]}, analizamos el audio de la tos de ${currentPet.name}. Su Chequeo Clínico está 100% cubierto en su ${currentPet.plan_name}. ¿Deseas agendar su auscultación?`,
        whatsapp_url: `https://wa.me/${currentPet.customer_phone.replace(/\D/g, '')}?text=${encodeURIComponent(`🐾 Hola ${currentPet.customer_name.split(' ')[0]}, analizamos el audio de la tos de ${currentPet.name}. Su Chequeo Clínico está 100% cubierto en su ${currentPet.plan_name}. ¿Deseas agendar su auscultación?`)}`,
    });

    // Estado del Copilot Chat Interactivo
    const [chatMessages, setChatMessages] = useState<ChatMessage[]>([
        {
            id: 'init-1',
            sender: 'assistant',
            text: `¡Hola! Soy tu Copilot Clínico impulsado por **Google Gemini 2.5 Flash** para **${brandName}**. Estoy conectado en tiempo real a los historiales y planes de tus pacientes. Actualmente estamos evaluando a **${currentPet.name}** (${currentPet.species}, ${currentPet.breed}) con membresía **${currentPet.plan_name}**.\n\n¿En qué te puedo apoyar hoy? Puedes consultarme dosificaciones de medicamentos, diagnósticos diferenciales, guías de vacunación o coberturas de su plan.`,
            source: 'gemini-2.5-flash-live',
            timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
        }
    ]);
    const [chatInput, setChatInput] = useState('');
    const [isChatSending, setIsChatSending] = useState(false);
    const chatEndRef = useRef<HTMLDivElement>(null);

    const [isAnalyzing, setIsAnalyzing] = useState(false);
    const [copiedWa, setCopiedWa] = useState(false);
    const fileInputRef = useRef<HTMLInputElement>(null);

    // Desplazamiento automático en el chat
    useEffect(() => {
        if (mainTab === 'copilot') {
            chatEndRef.current?.scrollIntoView({ behavior: 'smooth' });
        }
    }, [chatMessages, mainTab]);

    // Actualizar datos del triaje cuando cambia la mascota
    useEffect(() => {
        if (!currentPet) return;
        
        setVisualResult(prev => ({
            ...prev,
            plan_coverage_match: `Consulta Médica General & Procedimientos cubiertos en ${currentPet.plan_name}.`,
            whatsapp_message: `🐾 Hola ${currentPet.customer_name.split(' ')[0]}, realizamos el triaje con IA de ${currentPet.name}. Tienes la consulta y el tratamiento cubiertos en tu ${currentPet.plan_name}. ¿Deseas agendar su cita prioritaria hoy?`,
            whatsapp_url: `https://wa.me/${currentPet.customer_phone.replace(/\D/g, '')}?text=${encodeURIComponent(`🐾 Hola ${currentPet.customer_name.split(' ')[0]}, realizamos el triaje con IA de ${currentPet.name}. Tienes la consulta y el tratamiento cubiertos en tu ${currentPet.plan_name}. ¿Deseas agendar su cita prioritaria hoy?`)}`,
        }));

        setBioacousticResult(prev => ({
            ...prev,
            plan_coverage_match: `Chequeo Cardiorrespiratorio 100% cubierto en ${currentPet.plan_name}.`,
            whatsapp_message: `🐾 Hola ${currentPet.customer_name.split(' ')[0]}, analizamos el audio respiratorio de ${currentPet.name}. Su Chequeo Clínico está 100% cubierto en su ${currentPet.plan_name}. ¿Deseas agendar para hoy?`,
            whatsapp_url: `https://wa.me/${currentPet.customer_phone.replace(/\D/g, '')}?text=${encodeURIComponent(`🐾 Hola ${currentPet.customer_name.split(' ')[0]}, analizamos el audio respiratorio de ${currentPet.name}. Su Chequeo Clínico está 100% cubierto en su ${currentPet.plan_name}. ¿Deseas agendar para hoy?`)}`,
        }));
    }, [currentPet]);

    // Ejecutar Triaje Multimodal con Gemini 2.5 Flash
    const handleRunVisualTriage = async (presetIdParam?: string, customImageParam?: string, symptomsParam?: string) => {
        setIsAnalyzing(true);
        const pId = presetIdParam !== undefined ? presetIdParam : selectedVisualPreset;
        const img = customImageParam !== undefined ? customImageParam : customImageBase64;
        const sym = symptomsParam !== undefined ? symptomsParam : clinicalSymptoms;

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
                    symptoms: sym,
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

    // Enviar Mensaje al Copilot Chat
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
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const res = await fetch(`/admin/${tenantSlug}/ai/chat`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token || '',
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
                const errData = await res.json().catch(() => ({}));
                const botMsg: ChatMessage = {
                    id: `bot-${Date.now()}`,
                    sender: 'assistant',
                    text: errData.error || 'Disculpa, hubo un inconveniente al conectar con Gemini. Por favor intenta de nuevo en unos segundos.',
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

    // Subir Imagen Propia (Celular o Archivo)
    const handleFileUpload = (e: React.ChangeEvent<HTMLInputElement>) => {
        const file = e.target.files?.[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = () => {
            const base64 = reader.result as string;
            setCustomImageBase64(base64);
            setCurrentImageSrc(base64);
            setSelectedVisualPreset(null);
            handleRunVisualTriage(undefined, base64, clinicalSymptoms);
        };
        reader.readAsDataURL(file);
    };

    const handleClearImage = () => {
        setCustomImageBase64(null);
        setCurrentImageSrc(null);
        setSelectedVisualPreset(null);
        if (fileInputRef.current) fileInputRef.current.value = '';
    };

    const handleSelectPreset = (preset: typeof VISUAL_PRESETS[0]) => {
        setSelectedVisualPreset(preset.id);
        setClinicalSymptoms(preset.symptoms);
        setCurrentImageSrc(preset.image);
        setCustomImageBase64(null);
        handleRunVisualTriage(preset.id, '', preset.symptoms);
    };

    const copyToClipboard = (text: string) => {
        navigator.clipboard.writeText(text);
        setCopiedWa(true);
        setTimeout(() => setCopiedWa(false), 2000);
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
            <Head title={`AVI Intelligence · Copilot Clínico Gemini 2.5 · ${brandName}`} />

            <div className="w-full space-y-5 pb-16">
                {/* 1. Header Banner & Status */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div className="flex items-center gap-2">
                            <h1 className="text-xl font-black text-slate-900 flex items-center gap-2">
                                <Sparkles className="w-5 h-5 text-purple-600" />
                                AVI Intelligence · Copilot Clínico & Triaje Multimodal
                            </h1>
                            <span className="text-[10px] font-black uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-purple-100 text-purple-800 border border-purple-200">
                                Gemini 2.5 Flash Live
                            </span>
                        </div>
                        <p className="text-xs text-slate-500 mt-1">
                            Asistencia médica veterinaria en tiempo real, análisis de lesiones dérmicas y auscultación conectada a la cobertura de cada paciente.
                        </p>
                    </div>

                    <div className="flex items-center gap-2 shrink-0">
                        <span className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                            <span className="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Google Generative AI · Modelo Activo</span>
                        </span>
                    </div>
                </div>

                {/* 2. Selector Dinámico de Paciente de la Clínica */}
                <div className="bg-gradient-to-r from-slate-900 via-indigo-950 to-blue-950 rounded-2xl p-4 sm:p-5 text-white shadow-md border border-indigo-800/40">
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
                                    <span className="text-amber-300 font-bold">💰 {currentPet.formatted_wallet} custodia</span>
                                </p>
                            </div>
                        </div>

                        {/* Dropdown de Selección de Paciente */}
                        <div className="relative">
                            <div className="flex items-center gap-2">
                                <span className="text-xs text-indigo-200 font-medium hidden sm:inline">Paciente en Atención:</span>
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
                                                No se encontraron mascotas registradas.
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

                {/* 3. Sub-Navigation Tabs */}
                <div className="flex flex-wrap border-b border-slate-200 bg-white rounded-xl p-1.5 gap-2 shadow-2xs">
                    <button
                        onClick={() => setMainTab('triage')}
                        className={`flex-1 min-w-[200px] py-2.5 px-3 rounded-lg text-xs font-bold flex items-center justify-center gap-2 transition ${
                            mainTab === 'triage'
                                ? 'bg-blue-600 text-white shadow-xs'
                                : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
                        }`}
                    >
                        <Stethoscope className="w-4 h-4" />
                        <span>Triaje Multimodal Clínico (Visión & Síntomas)</span>
                        <span className={`text-[9px] px-2 py-0.5 rounded-full font-black ${mainTab === 'triage' ? 'bg-blue-500 text-white' : 'bg-purple-100 text-purple-700'}`}>
                            Gemini 2.5
                        </span>
                    </button>

                    <button
                        onClick={() => setMainTab('copilot')}
                        className={`flex-1 min-w-[180px] py-2.5 px-3 rounded-lg text-xs font-bold flex items-center justify-center gap-2 transition ${
                            mainTab === 'copilot'
                                ? 'bg-purple-600 text-white shadow-xs'
                                : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
                        }`}
                    >
                        <Bot className="w-4 h-4" />
                        <span>Copilot Clínico Interactivo (Chat)</span>
                        <span className={`text-[9px] px-2 py-0.5 rounded-full font-black ${mainTab === 'copilot' ? 'bg-purple-500 text-white' : 'bg-emerald-100 text-emerald-700'}`}>
                            En Vivo
                        </span>
                    </button>

                    <button
                        onClick={() => setMainTab('bioacoustic')}
                        className={`flex-1 min-w-[170px] py-2.5 px-3 rounded-lg text-xs font-bold flex items-center justify-center gap-2 transition ${
                            mainTab === 'bioacoustic'
                                ? 'bg-indigo-600 text-white shadow-xs'
                                : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
                        }`}
                    >
                        <Mic className="w-4 h-4" />
                        <span>Triaje Bioacústico (Tos & Pulmón)</span>
                    </button>

                    <button
                        onClick={() => setMainTab('retention')}
                        className={`flex-1 min-w-[180px] py-2.5 px-3 rounded-lg text-xs font-bold flex items-center justify-center gap-2 transition ${
                            mainTab === 'retention'
                                ? 'bg-blue-600 text-white shadow-xs'
                                : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
                        }`}
                    >
                        <Wallet className="w-4 h-4" />
                        <span>Smart Health Wallet & Rescate ({totalOpportunities})</span>
                    </button>
                </div>

                {/* 4. TAB 1: TRIAJE MULTIMODAL CLÍNICO (VISIÓN & SÍNTOMAS) */}
                {mainTab === 'triage' && (
                    <div className="space-y-4">
                        {/* Panel de Entrada Clínica Activa */}
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-4">
                            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-100">
                                <div>
                                    <h3 className="text-sm font-black text-slate-900 flex items-center gap-2">
                                        <Stethoscope className="w-4 h-4 text-blue-600" />
                                        Evaluación y Triaje Clínico en Vivo para: <span className="text-blue-600">{currentPet.name}</span>
                                    </h3>
                                    <p className="text-xs text-slate-500 mt-0.5">
                                        Ingresa los signos observados y/o sube una fotografía de la lesión para análisis multimodal instantáneo con Gemini 2.5 Flash.
                                    </p>
                                </div>

                                <button
                                    type="button"
                                    onClick={() => setShowPresetsLibrary(!showPresetsLibrary)}
                                    className="text-xs text-blue-600 hover:text-blue-800 font-bold flex items-center gap-1.5 transition self-start sm:self-auto"
                                >
                                    <Info className="w-3.5 h-3.5" />
                                    <span>{showPresetsLibrary ? 'Ocultar Casos de Referencia' : 'Ver Biblioteca de Casos Clínicos'}</span>
                                </button>
                            </div>

                            {/* Biblioteca de Casos de Referencia (Opcional / Desplegable) */}
                            {showPresetsLibrary && (
                                <div className="p-3.5 bg-slate-50 rounded-xl border border-slate-200 animate-in fade-in duration-200 space-y-2">
                                    <span className="text-[11px] font-bold text-slate-600 block uppercase tracking-wider">
                                        Casos de Referencia Dermatológica para Estudio / Demostración:
                                    </span>
                                    <div className="grid grid-cols-2 sm:grid-cols-5 gap-2">
                                        {VISUAL_PRESETS.map((preset) => (
                                            <button
                                                key={preset.id}
                                                type="button"
                                                onClick={() => handleSelectPreset(preset)}
                                                className={`p-2.5 rounded-xl border text-left transition flex flex-col justify-between gap-1.5 ${
                                                    selectedVisualPreset === preset.id
                                                        ? 'border-blue-600 bg-white shadow-2xs ring-2 ring-blue-500/20'
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
                            )}

                            {/* Signos Clínicos Frecuentes (Chips de Acceso Rápido) */}
                            <div>
                                <span className="text-xs font-bold text-slate-700 block mb-2">
                                    Seleccionar Motivo de Consulta Frecuente o Describir Libremente:
                                </span>
                                <div className="flex flex-wrap gap-2">
                                    {[
                                        { label: 'Prurito & Dermatitis DAPP', text: 'Prurito constante en lomo y flancos con eritema focal, pequeños puntos alopécicos y signos de rascado recurrente compatible con picadura de pulga.' },
                                        { label: 'Otitis & Sacudidas de Cabeza', text: 'Sacudidas frecuentes de cabeza, rascado de pabellón auricular, secreción ceruminosa parda y mal olor en conducto auditivo externo.' },
                                        { label: 'Alopecia Circular & Costras', text: 'Lesiones alopécicas circulares bien delimitadas con descamación y microcostras en extremidades o cara, sospecha de dermatofitosis.' },
                                        { label: 'Laceración Traumática', text: 'Laceración cutánea de origen traumático con solución de continuidad, bordes eritematosos y sangrado leve controlado.' },
                                        { label: 'Secreción Ocular / Blefaritis', text: 'Blefaroespasmo, epífora moderada, hiperemia conjuntival y molestia a la luz en ojo derecho.' },
                                        { label: 'Vómito & Inapetencia', text: 'Presenta dos episodios de vómito alimenticio/biliar en las últimas 12 horas, letargia leve y rechazo del alimento.' },
                                    ].map((chip, idx) => (
                                        <button
                                            key={idx}
                                            type="button"
                                            onClick={() => setClinicalSymptoms(chip.text)}
                                            className="px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-blue-50 hover:text-blue-700 text-slate-700 border border-slate-200 transition"
                                        >
                                            {chip.label}
                                        </button>
                                    ))}
                                </div>
                            </div>

                            {/* Textarea de Síntomas & Fotografía */}
                            <div className="grid grid-cols-1 lg:grid-cols-12 gap-4 pt-2">
                                {/* Campo de Texto de Síntomas */}
                                <div className="lg:col-span-7 space-y-2">
                                    <label className="text-xs font-bold text-slate-800 flex items-center justify-between">
                                        <span>Signos Clínicos, Síntomas & Observaciones:</span>
                                        <span className="text-[10px] text-slate-400 font-normal">Editable en tiempo real</span>
                                    </label>
                                    <textarea
                                        rows={4}
                                        value={clinicalSymptoms}
                                        onChange={(e) => setClinicalSymptoms(e.target.value)}
                                        placeholder="Ej: Prurito intenso en zona lumbosacra, eritema focal, sacudidas de cabeza..."
                                        className="w-full p-3 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-hidden focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition resize-none"
                                    />

                                    <div className="flex flex-wrap items-center justify-between gap-2 pt-1">
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
                                                className="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold border border-slate-200 transition"
                                            >
                                                <Camera className="w-3.5 h-3.5 text-blue-600" />
                                                <span>{currentImageSrc ? 'Cambiar Foto / Cámara' : 'Adjuntar Foto de la Lesión'}</span>
                                            </button>

                                            {currentImageSrc && (
                                                <button
                                                    type="button"
                                                    onClick={handleClearImage}
                                                    className="inline-flex items-center gap-1 px-2.5 py-2 rounded-xl bg-slate-100 hover:bg-rose-50 hover:text-rose-700 text-slate-600 text-xs font-bold transition"
                                                    title="Quitar imagen"
                                                >
                                                    <X className="w-3.5 h-3.5" />
                                                    <span>Quitar</span>
                                                </button>
                                            )}
                                        </div>

                                        <button
                                            type="button"
                                            onClick={() => handleRunVisualTriage()}
                                            disabled={isAnalyzing}
                                            className="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-xs font-black transition flex items-center gap-2 shadow-md hover:shadow-lg disabled:opacity-50"
                                        >
                                            {isAnalyzing ? (
                                                <>
                                                    <div className="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                                                    <span>Procesando con Gemini 2.5 Flash...</span>
                                                </>
                                            ) : (
                                                <>
                                                    <Zap className="w-4 h-4 text-amber-300" />
                                                    <span>⚡ Analizar Caso con Gemini 2.5 Flash</span>
                                                </>
                                            )}
                                        </button>
                                    </div>
                                </div>

                                {/* Visor / Escáner de Lesión */}
                                <div className="lg:col-span-5 bg-slate-900 rounded-xl p-3 flex flex-col justify-between border border-slate-800 text-white min-h-[170px]">
                                    <div className="flex items-center justify-between text-[11px] text-slate-400 pb-2 border-b border-slate-800">
                                        <span className="flex items-center gap-1.5 font-bold text-slate-300">
                                            <ScanLine className="w-3.5 h-3.5 text-blue-400" />
                                            {currentImageSrc ? 'Registro Visual de la Lesión' : 'Evaluación Clínica'}
                                        </span>
                                        <span className="text-[10px] font-mono text-emerald-400">
                                            {visualResult.source || 'gemini-2.5-flash-live'}
                                        </span>
                                    </div>

                                    {currentImageSrc ? (
                                        <div className="relative aspect-16/9 rounded-lg overflow-hidden my-2 group bg-black">
                                            <img 
                                                src={currentImageSrc} 
                                                alt="Lesión Paciente" 
                                                className="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                            />
                                            {visualResult.roi_box && (
                                                <div 
                                                    className="absolute border-2 border-amber-400 bg-amber-400/20 rounded-md flex flex-col justify-between p-1 pointer-events-none animate-pulse"
                                                    style={{
                                                        top: `${visualResult.roi_box.top}%`,
                                                        left: `${visualResult.roi_box.left}%`,
                                                        width: `${visualResult.roi_box.width}%`,
                                                        height: `${visualResult.roi_box.height}%`,
                                                    }}
                                                >
                                                    <span className="text-[8.5px] font-black uppercase bg-amber-500 text-white px-1 py-0.2 rounded w-max">
                                                        {visualResult.roi_box.label}
                                                    </span>
                                                </div>
                                            )}
                                        </div>
                                    ) : (
                                        <div className="py-6 flex flex-col items-center justify-center text-center space-y-2">
                                            <div className="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center text-xl text-blue-400">
                                                🩺
                                            </div>
                                            <div>
                                                <p className="text-xs font-bold text-slate-200">Análisis basado en signos clínicos reportados</p>
                                                <p className="text-[10px] text-slate-400">Puedes adjuntar una foto de la piel, orejas o herida para inspección visual.</p>
                                            </div>
                                        </div>
                                    )}

                                    <div className="flex items-center justify-between text-[10px] text-slate-400 pt-1">
                                        <span>Paciente: <strong className="text-white">{currentPet.name}</strong> ({currentPet.breed})</span>
                                        <span>Confianza: <strong className="text-emerald-400">{visualResult.confidence_score || 95.8}%</strong></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Resultados del Triaje Clínico & Cobertura Actuarial */}
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-4">
                            <div className="flex flex-col sm:flex-row sm:items-start justify-between pb-3 border-b border-slate-100 gap-2">
                                <div>
                                    <div className="flex items-center gap-2">
                                        <h3 className="text-base font-black text-slate-900">
                                            Dictamen Clínico Preliminar Asistido por IA
                                        </h3>
                                        {getUrgencyBadge(visualResult.urgency_level, visualResult.urgency_color)}
                                    </div>
                                    <p className="text-xs text-slate-500 mt-0.5">
                                        Generado por Google Gemini 2.5 Flash · Cruzado con las coberturas de {currentPet.plan_name}
                                    </p>
                                </div>

                                <div className="text-left sm:text-right">
                                    <span className="text-[10px] font-bold text-slate-400 block uppercase">Nivel de Confianza</span>
                                    <span className="text-sm font-black text-emerald-600">{visualResult.confidence_score || 95.8}%</span>
                                </div>
                            </div>

                            {/* Hipótesis Diagnóstica */}
                            <div className="p-4 rounded-xl bg-amber-50/70 border border-amber-200/90 space-y-1">
                                <div className="text-[11px] font-bold text-amber-900 uppercase tracking-wider flex items-center gap-1.5">
                                    <AlertTriangle className="w-3.5 h-3.5 text-amber-600" />
                                    <span>Hipótesis Diagnóstica Más Probable:</span>
                                </div>
                                <p className="text-xs text-slate-800 leading-relaxed font-semibold">
                                    {visualResult.preliminary_hypothesis}
                                </p>
                            </div>

                            {/* Hallazgos Clínicos & Conducta */}
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div className="p-3.5 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                                    <span className="text-xs font-black text-slate-900 flex items-center gap-1.5">
                                        <CheckCircle2 className="w-4 h-4 text-emerald-600" />
                                        <span>Hallazgos Biomédicos Detectados:</span>
                                    </span>
                                    <ul className="space-y-1.5 text-xs text-slate-600">
                                        {visualResult.clinical_findings?.map((finding: string, idx: number) => (
                                            <li key={idx} className="flex items-start gap-2">
                                                <span className="w-1.5 h-1.5 rounded-full bg-emerald-500 mt-1.5 shrink-0"></span>
                                                <span>{finding}</span>
                                            </li>
                                        ))}
                                    </ul>
                                </div>

                                <div className="p-3.5 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                                    <span className="text-xs font-black text-slate-900 flex items-center gap-1.5">
                                        <Activity className="w-4 h-4 text-blue-600" />
                                        <span>Conducta Médica Recomendada:</span>
                                    </span>
                                    <p className="text-xs text-slate-700 leading-relaxed font-medium">
                                        {visualResult.recommended_action}
                                    </p>
                                </div>
                            </div>

                            {/* Cobertura Actuarial del Plan de la Mascota */}
                            <div className="p-4 rounded-xl bg-gradient-to-r from-blue-50 via-teal-50 to-emerald-50 border border-teal-200/90">
                                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2">
                                    <span className="text-xs font-black text-blue-900 flex items-center gap-2">
                                        <FileCheck className="w-4 h-4 text-teal-700" />
                                        <span>Cobertura en {currentPet.plan_name} ({currentPet.avail_benefits_count} beneficios disponibles):</span>
                                    </span>
                                    <span className="text-xs font-extrabold text-emerald-800 bg-emerald-100 border border-emerald-300 px-3 py-1 rounded-full w-max">
                                        {visualResult.covered_cop}
                                    </span>
                                </div>
                                <p className="text-xs text-slate-700 font-medium">
                                    {visualResult.plan_coverage_match}
                                </p>
                            </div>

                            {/* Acciones Inmediatas: WhatsApp al Tutor & Agendar Cita */}
                            <div className="flex flex-wrap items-center gap-2 pt-2">
                                <a
                                    href={visualResult.whatsapp_url || `https://wa.me/${currentPet.customer_phone.replace(/\D/g, '')}`}
                                    target="_blank"
                                    rel="noreferrer"
                                    className="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm"
                                >
                                    <MessageCircle className="w-4 h-4" />
                                    <span>Notificar a {currentPet.customer_name.split(' ')[0]} por WhatsApp (3508742543)</span>
                                </a>

                                <button
                                    type="button"
                                    onClick={() => copyToClipboard(visualResult.whatsapp_message || '')}
                                    className="inline-flex items-center gap-1.5 px-3 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition border border-slate-200"
                                >
                                    {copiedWa ? <Check className="w-3.5 h-3.5 text-emerald-600" /> : <Copy className="w-3.5 h-3.5" />}
                                    <span>{copiedWa ? 'Mensaje Copiado' : 'Copiar Texto'}</span>
                                </button>

                                <a
                                    href={`/admin/${tenantSlug}/citas`}
                                    className="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-sm"
                                >
                                    <Calendar className="w-4 h-4" />
                                    <span>Agendar Consulta en Agenda de la Clínica</span>
                                </a>
                            </div>
                        </div>
                    </div>
                )}

                {/* 5. TAB 2: COPILOT CLÍNICO INTERACTIVO (CHAT CON GEMINI EN VIVO) */}
                {mainTab === 'copilot' && (
                    <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-4">
                        <div className="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-100 gap-2">
                            <div>
                                <h3 className="text-base font-black text-slate-900 flex items-center gap-2">
                                    <Bot className="w-5 h-5 text-purple-600" />
                                    Copilot Clínico Gemini 2.5 Flash · Chat en Tiempo Real
                                </h3>
                                <p className="text-xs text-slate-500 mt-0.5">
                                    Asistente conversacional con acceso al historial de <strong className="text-slate-700">{currentPet.name}</strong>, vademécum y planes de la clínica.
                                </p>
                            </div>

                            <span className="text-[10.5px] font-bold px-2.5 py-1 rounded-full bg-purple-50 text-purple-700 border border-purple-200 w-max">
                                Contexto: {currentPet.name} ({currentPet.breed}, {currentPet.age})
                            </span>
                        </div>

                        {/* Preguntas Frecuentes / Atajos Rápidos */}
                        <div>
                            <span className="text-xs font-bold text-slate-600 block mb-1.5">
                                Preguntas Rápidas para Evaluar con Gemini:
                            </span>
                            <div className="flex flex-wrap gap-2">
                                {[
                                    `¿Qué dosis de Amoxicilina + Ácido Clavulánico recomiendas para ${currentPet.name}?`,
                                    `¿Qué cobertura tiene ${currentPet.name} en su ${currentPet.plan_name}?`,
                                    `Diferenciales diagnósticos para dermatitis pruriginosa en ${currentPet.breed}`,
                                    `Redactar mensaje de WhatsApp para recordar vacunación anual a ${currentPet.customer_name}`,
                                ].map((promptText, idx) => (
                                    <button
                                        key={idx}
                                        type="button"
                                        onClick={() => handleSendChatMessage(promptText)}
                                        className="text-left px-3 py-1.5 rounded-lg text-xs font-medium bg-purple-50 hover:bg-purple-100 text-purple-800 border border-purple-200 transition"
                                    >
                                        💬 {promptText}
                                    </button>
                                ))}
                            </div>
                        </div>

                        {/* Ventana de Mensajes */}
                        <div className="h-96 overflow-y-auto p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
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
                                                ? 'bg-blue-600 text-white rounded-br-xs'
                                                : 'bg-white text-slate-800 border border-slate-200/90 rounded-bl-xs'
                                        }`}
                                    >
                                        <div className="font-semibold whitespace-pre-line leading-relaxed">
                                            {msg.text}
                                        </div>
                                        <div className="flex items-center justify-between gap-4 pt-1 text-[9.5px] opacity-70">
                                            <span>{msg.sender === 'assistant' ? 'Gemini 2.5 Flash' : 'Tú'}</span>
                                            <span>{msg.timestamp}</span>
                                        </div>
                                    </div>

                                    {msg.sender === 'user' && (
                                        <div className="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center shrink-0 text-xs font-bold shadow-xs">
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
                                        <span>Gemini 2.5 Flash está analizando...</span>
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
                                placeholder="Escribe tu consulta clínica, dosificación o cobertura a Gemini..."
                                disabled={isChatSending}
                                className="flex-1 px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:outline-hidden focus:border-purple-600 focus:ring-2 focus:ring-purple-100 transition"
                            />

                            <button
                                type="submit"
                                disabled={!chatInput.trim() || isChatSending}
                                className="px-5 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-xs disabled:opacity-50"
                            >
                                <Send className="w-3.5 h-3.5" />
                                <span>Enviar</span>
                            </button>
                        </form>
                    </div>
                )}

                {/* 6. TAB 3: TRIAJE BIOACÚSTICO (TOS & AUSCULTACIÓN) */}
                {mainTab === 'bioacoustic' && (
                    <div className="space-y-4">
                        {/* Selector de Casos de Sonido Respiratorio */}
                        <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs space-y-3">
                            <div className="flex items-center justify-between">
                                <span className="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-1.5">
                                    <span>🫁</span>
                                    <span>Patrones Bioacústicos & Muestras de Auscultación Respiratoria:</span>
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

                                    {/* Onda sonora */}
                                    <div className="h-44 rounded-xl bg-slate-950 p-4 border border-slate-800 flex flex-col justify-between relative overflow-hidden">
                                        <div className="flex items-center justify-between text-[10px] text-purple-300 font-mono">
                                            <span>{bioacousticResult.sound_pattern || 'PATRÓN TUSÍGENO EN RÁFAGA'}</span>
                                            <span>PICO: {bioacousticResult.peak_frequency || '4.2 kHz'}</span>
                                        </div>

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
                                        <span>{isAnalyzing ? 'Procesando con Gemini...' : '⚡ Re-analizar con Gemini 2.5 Flash'}</span>
                                    </button>
                                </div>
                            </div>

                            {/* Diagnóstico Bioacústico */}
                            <div className="lg:col-span-7 bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-4">
                                <div className="flex items-start justify-between pb-3 border-b border-slate-100">
                                    <div>
                                        <div className="flex items-center gap-2">
                                            <h3 className="text-base font-black text-slate-900">
                                                Análisis Acústico Cardiorrespiratorio
                                            </h3>
                                            {getUrgencyBadge(bioacousticResult.urgency_level, bioacousticResult.urgency_color)}
                                        </div>
                                        <p className="text-xs text-slate-500 mt-0.5">
                                            Modelo Acústico de Auscultación · Gemini 2.5 Flash
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
                                        href={`/admin/${tenantSlug}/citas`}
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

                {/* 7. TAB 4: SMART HEALTH WALLET & RESCATE ANTI-CHURN */}
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
