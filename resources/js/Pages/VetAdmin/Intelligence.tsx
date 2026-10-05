import React, { useState, useEffect, useRef } from 'react';
import { Head } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { 
    MessageSquare, 
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
    Bot, 
    RefreshCw,
    Syringe,
    Pill,
    Gift
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
    const [mainTab, setMainTab] = useState<'retention' | 'generator' | 'copilot'>('retention');

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

    // Estado del Generador de Mensajes de WhatsApp
    const [campaignType, setCampaignType] = useState<'vaccine' | 'benefits' | 'wallet' | 'followup'>('vaccine');
    const [customTone, setCustomTone] = useState<'warm' | 'urgent' | 'promo'>('warm');
    const [generatedMessage, setGeneratedMessage] = useState<string>('');
    const [isGeneratingMessage, setIsGeneratingMessage] = useState(false);
    const [copiedWa, setCopiedWa] = useState(false);

    // Función para generar mensaje inicial de WhatsApp según la mascota
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

    // Actualizar mensaje por defecto al cambiar de paciente o de tipo
    useEffect(() => {
        if (currentPet) {
            setGeneratedMessage(buildDefaultMessage(currentPet, campaignType));
        }
    }, [currentPet, campaignType]);

    // Generar con Copilot Gemini
    const handleGenerateWithAI = async () => {
        setIsGeneratingMessage(true);
        try {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const prompt = `Redacta un mensaje de WhatsApp amigable, cálido y persuasivo para enviar a ${currentPet.customer_name} (tutor de ${currentPet.name}, raza ${currentPet.breed}). `
                + `Motivo: ${campaignType === 'vaccine' ? 'Recordar refuerzo de vacunación y chequeo' : campaignType === 'benefits' ? 'Avisar que tiene beneficios disponibles por usar' : campaignType === 'wallet' ? 'Recordar que tiene ' + currentPet.formatted_wallet + ' acumulados en su fondo quirúrgico' : 'Seguimiento clínico de rutina'}. `
                + `Tiene el plan ${currentPet.plan_name}. Máximo 3 o 4 párrafos cortos con emojis y llamada a la acción para agendar cita.`;

            const res = await fetch(`/admin/${tenantSlug}/ai/chat`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token || '',
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

    // Estado del Copilot Chat Interactivo
    const [chatMessages, setChatMessages] = useState<ChatMessage[]>([
        {
            id: 'init-1',
            sender: 'assistant',
            text: `¡Hola! Soy tu Copilot de Fidelización y Soporte para **${brandName}**.\n\nPuedo ayudarte a:\n• Redactar promociones y mensajes de WhatsApp para tutores.\n• Resolver dudas sobre las coberturas de **${currentPet.plan_name}** para **${currentPet.name}**.\n• Sugerir estrategias para reactivar clientes que no visitan la clínica.\n\n¿En qué te puedo apoyar hoy?`,
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
                const botMsg: ChatMessage = {
                    id: `bot-${Date.now()}`,
                    sender: 'assistant',
                    text: 'Disculpa, hubo una demora al procesar tu solicitud. Por favor intenta de nuevo.',
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

    // Filtrar mascotas para el buscador
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
            activeItem="Fidelización & WhatsApp"
        >
            <Head title={`Fidelización & Asistente WhatsApp · ${brandName}`} />

            <div className="w-full space-y-5 pb-16">
                {/* 1. Header Banner & Status */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div className="flex items-center gap-2">
                            <h1 className="text-xl font-black text-slate-900 flex items-center gap-2">
                                <MessageSquare className="w-5 h-5 text-emerald-600" />
                                Centro de Fidelización, WhatsApp & Rescate Anti-Churn
                            </h1>
                            <span className="text-[10px] font-black uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                WhatsApp Copilot Activo
                            </span>
                        </div>
                        <p className="text-xs text-slate-500 mt-1">
                            Campañas de reactivación por WhatsApp, control del Fondo Quirúrgico en Custodia y mensajes inteligentes para fidelizar a los tutores.
                        </p>
                    </div>

                    <div className="flex items-center gap-2 shrink-0">
                        <span className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                            <span className="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>IA Generativa Operativa · Gemini 2.5</span>
                        </span>
                    </div>
                </div>

                {/* 2. Top KPI Cards de Fidelización y Negocio */}
                <div className="grid grid-cols-1 sm:grid-cols-4 gap-3">
                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">MRR Protegido / Mensual</span>
                        <div className="text-2xl font-black text-slate-900">{protectedMrr}</div>
                        <span className="text-[10.5px] font-bold text-emerald-600 mt-1 block">✓ Base recurrente asegurada</span>
                    </div>

                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">Fondo Quirúrgico en Custodia</span>
                        <div className="text-2xl font-black text-amber-600">{walletCustodyCop}</div>
                        <span className="text-[10.5px] font-medium text-slate-500 mt-1 block">10% acumulativo anti-cancelación</span>
                    </div>

                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">Pacientes en Riesgo de Abandono</span>
                        <div className="text-2xl font-black text-rose-600">{totalOpportunities}</div>
                        <span className="text-[10.5px] font-medium text-rose-600 mt-1 block">Sin visitas en últimos 60 días</span>
                    </div>

                    <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
                        <span className="text-xs font-bold text-slate-400 block mb-1">Tasa de Fidelización Clínica</span>
                        <div className="text-2xl font-black text-blue-600">{retentionRate}</div>
                        <span className="text-[10.5px] font-medium text-slate-500 mt-1 block">Retención por crédito preventivo</span>
                    </div>
                </div>

                {/* 3. Selector Dinámico de Paciente */}
                <div className="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-2xl p-4 sm:p-5 text-white shadow-md border border-slate-800">
                    <div className="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        <div className="flex items-center gap-3.5">
                            <div className="relative">
                                {currentPet.photo_url ? (
                                    <img 
                                        src={currentPet.photo_url} 
                                        alt={currentPet.name} 
                                        className="w-13 h-13 rounded-2xl object-cover border-2 border-white/20 shadow-md"
                                    />
                                ) : (
                                    <div className="w-13 h-13 rounded-2xl bg-white/10 border-2 border-white/20 flex items-center justify-center text-2xl">
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
                                    <span className="text-teal-300 font-bold">🎁 {currentPet.avail_benefits_count} beneficios por usar</span>
                                    <span>·</span>
                                    <span className="text-amber-300 font-bold">💰 {currentPet.formatted_wallet} acumulados</span>
                                </p>
                            </div>
                        </div>

                        {/* Dropdown de Selección */}
                        <div className="relative">
                            <div className="flex items-center gap-2">
                                <span className="text-xs text-indigo-200 font-medium hidden sm:inline">Seleccionar Paciente:</span>
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

                {/* 4. Sub-Navigation Tabs */}
                <div className="flex flex-wrap border-b border-slate-200 bg-white rounded-xl p-1.5 gap-2 shadow-2xs">
                    <button
                        onClick={() => setMainTab('retention')}
                        className={`flex-1 min-w-[200px] py-2.5 px-3 rounded-lg text-xs font-bold flex items-center justify-center gap-2 transition ${
                            mainTab === 'retention'
                                ? 'bg-emerald-600 text-white shadow-xs'
                                : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
                        }`}
                    >
                        <Wallet className="w-4 h-4" />
                        <span>Rescate Anti-Churn & Fondo Quirúrgico ({totalOpportunities})</span>
                    </button>

                    <button
                        onClick={() => setMainTab('generator')}
                        className={`flex-1 min-w-[200px] py-2.5 px-3 rounded-lg text-xs font-bold flex items-center justify-center gap-2 transition ${
                            mainTab === 'generator'
                                ? 'bg-emerald-600 text-white shadow-xs'
                                : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
                        }`}
                    >
                        <MessageCircle className="w-4 h-4" />
                        <span>Generador de Campañas WhatsApp</span>
                        <span className={`text-[9px] px-2 py-0.5 rounded-full font-black ${mainTab === 'generator' ? 'bg-emerald-700 text-white' : 'bg-emerald-100 text-emerald-800'}`}>
                            1 Clic
                        </span>
                    </button>

                    <button
                        onClick={() => setMainTab('copilot')}
                        className={`flex-1 min-w-[180px] py-2.5 px-3 rounded-lg text-xs font-bold flex items-center justify-center gap-2 transition ${
                            mainTab === 'copilot'
                                ? 'bg-emerald-600 text-white shadow-xs'
                                : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
                        }`}
                    >
                        <Bot className="w-4 h-4" />
                        <span>Copilot de Consultas Clínicas & Planes</span>
                        <span className={`text-[9px] px-2 py-0.5 rounded-full font-black ${mainTab === 'copilot' ? 'bg-emerald-700 text-white' : 'bg-purple-100 text-purple-700'}`}>
                            Gemini 2.5
                        </span>
                    </button>
                </div>

                {/* 5. TAB 1: RESCATE ANTI-CHURN & FONDO QUIRÚRGICO */}
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
                                        Cada mes que el tutor paga su suscripción, el 10% se acumula a su favor exclusivamente para cirugías, urgencias y profilaxis en la clínica. Si cancela el plan, pierde el crédito acumulado.
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

                {/* 6. TAB 2: GENERADOR DE CAMPAÑAS WHATSAPP */}
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
                                    { id: 'vaccine', label: '💉 Vacunación & Desparasitación', desc: 'Recordar refuerzo anual pendiente' },
                                    { id: 'benefits', label: '🎁 Beneficios sin Usar', desc: `${currentPet.avail_benefits_count} servicios disponibles` },
                                    { id: 'wallet', label: '💰 Crédito Quirúrgico / Dental', desc: `${currentPet.formatted_wallet} acumulados` },
                                    { id: 'followup', label: '🩺 Control & Chequeo Preventivo', desc: 'Consulta médica incluida' },
                                ].map((type) => (
                                    <button
                                        key={type.id}
                                        type="button"
                                        onClick={() => setCampaignType(type.id as any)}
                                        className={`p-3 rounded-xl border text-left transition flex flex-col justify-between gap-1 ${
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
                                        className="text-xs font-bold text-purple-700 hover:text-purple-900 flex items-center gap-1.5 transition"
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
                                        className="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition border border-slate-200"
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

                {/* 7. TAB 3: COPILOT DE CONSULTAS CLÍNICAS & PLANES */}
                {mainTab === 'copilot' && (
                    <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-4">
                        <div className="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-100 gap-2">
                            <div>
                                <h3 className="text-base font-black text-slate-900 flex items-center gap-2">
                                    <Bot className="w-5 h-5 text-purple-600" />
                                    Copilot Inteligente Gemini 2.5 Flash
                                </h3>
                                <p className="text-xs text-slate-500 mt-0.5">
                                    Asistente para redactar textos comerciales, calcular coberturas de <strong className="text-slate-700">{currentPet.plan_name}</strong> o consultar vademécum.
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
                                        className="text-left px-3 py-1.5 rounded-lg text-xs font-medium bg-purple-50 hover:bg-purple-100 text-purple-800 border border-purple-200 transition"
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
                                                ? 'bg-emerald-600 text-white rounded-br-xs'
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
                                        <div className="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center shrink-0 text-xs font-bold shadow-xs">
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
                                        <span>Gemini está redactando la respuesta...</span>
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
                                className="px-5 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-xs disabled:opacity-50"
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
