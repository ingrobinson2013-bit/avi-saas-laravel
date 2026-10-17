import React, { useState, useEffect } from 'react';
import { Head } from '@inertiajs/react';
import {
    Sparkles,
    ShieldCheck,
    QrCode,
    Heart,
    PawPrint,
    CheckCircle2,
    Clock,
    AlertCircle,
    Stethoscope,
    MessageSquare,
    Globe,
    Printer,
    CreditCard,
    Zap,
    Bot,
    Building2,
    Lock,
    ArrowRight,
    ExternalLink,
    ChevronDown,
    Menu,
    X,
    Eye,
    EyeOff,
    Copy,
    Check,
    TrendingUp,
    Users,
    Calendar,
    Syringe,
    Smartphone,
    Layers,
    BookOpen,
    MapPin,
    Link2,
    Ban,
    FileSpreadsheet,
    Bell,
    Sliders,
    HelpCircle
} from 'lucide-react';

type PlanTier = 'pay_per_pet' | 'starter' | 'pro' | 'enterprise';

interface LiveActivityItem {
    id: number;
    petName: string;
    breed: string;
    action: string;
    badge: string;
    time: string;
}

const LIVE_ACTIVITIES: LiveActivityItem[] = [
    {
        id: 1,
        petName: 'Luna',
        breed: 'Golden Retriever',
        action: 'Canjeó Vacuna Séxtuple en recepción',
        badge: 'Canje QR',
        time: 'Hace 12 seg'
    },
    {
        id: 2,
        petName: 'Simba',
        breed: 'Gato Mestizo',
        action: 'Nuevo afiliado desde el Afiche QR de sala de espera',
        badge: 'Auto-afiliación',
        time: 'Hace 1 min'
    },
    {
        id: 3,
        petName: 'Max',
        breed: 'Poodle Toy',
        action: 'Renovó Plan Bienestar por $65.000 COP / mes',
        badge: 'Renovación',
        time: 'Hace 3 min'
    },
    {
        id: 4,
        petName: 'Rocky',
        breed: 'Bulldog Francés',
        action: 'Completó chequeo médico y desparasitación trimestral',
        badge: 'Consulta',
        time: 'Hace 5 min'
    },
    {
        id: 5,
        petName: 'Mía',
        breed: 'Felino Persa',
        action: 'Recordatorio preventivo enviado por WhatsApp',
        badge: 'IA Supervisada',
        time: 'Hace 8 min'
    }
];

const FAQ_ITEMS = [
    {
        question: '¿En qué momento se paga el servicio? ¿Mes anticipado o mes vencido?',
        answer: 'Siempre es mes anticipado (prepago), garantizando cero deudas acumuladas y total claridad. Tienes tus primeros 15 días 100 % gratuitos para probar todo sin tarjeta de crédito. Al finalizar la prueba, tú decides cómo continuar: puedes recargar un paquete prepago de 10 mascotas por solo $50.000 COP ($5.000 por mascota), o activar tu mensualidad plana (Starter por $99.000 o Profesional por $229.000). Nunca acumulas deudas a mes vencido.'
    },
    {
        question: '¿Tengo que reemplazar mi software actual de historia clínica?',
        answer: 'No. AviPetApp convive con tu software actual de historia médica o inventarios (SoftVet, Gesvet, Vetlogy, Excel, etc.) o puede operar como tu centro especializado en planes de salud para mascotas, carnets digitales con código QR y seguimiento preventivo.'
    },
    {
        question: '¿AviPetApp cobra comisión por cada plan vendido en mi clínica?',
        answer: 'No. El 100 % del dinero cobrado a tus clientes ingresa directo a tus cuentas o medios de pago. No retenemos tu dinero ni cobramos porcentajes por transacción. Tú solo pagas el acceso al software: ya sea tu paquete de cupos prepago ($50.000 por 10 mascotas) o tu tarifa plana mensual fija.'
    },
    {
        question: '¿Cómo funciona la modalidad de paquetes de $5.000 COP por mascota?',
        answer: 'Es la modalidad de cero riesgo para empezar sin costo fijo alto. Funciona mediante paquetes prepago desde 10 mascotas por $50.000 COP ($5.000 por mascota activa al mes). Si cobras $65.000/mes a 10 tutores, tu clínica recauda $650.000 COP y el costo del software es de solo $50.000 COP (92 % de margen directo). Cuando alcances 20 o más mascotas, te conviene pasarte al plan Starter ($99.000 COP) para pagar aún menos por mascota.'
    },
    {
        question: '¿Puedo crear mis propios planes, beneficios y precios?',
        answer: 'Sí, con total libertad. Puedes definir el nombre de tus planes, qué servicios incluye cada uno (número de consultas, vacunas, desparasitaciones, baños o profilaxis) y la cuota mensual en pesos colombianos.'
    },
    {
        question: '¿Cómo pagan las membresías los tutores de las mascotas?',
        answer: 'Puedes configurar tus medios de recaudo habituales: Nequi, Daviplata, transferencia Bancolombia, datáfono en recepción o enlazar botones de pago digitales como Bold o Wompi.'
    },
    {
        question: '¿Puedo utilizar el dominio o subdominio de mi veterinaria?',
        answer: 'Desde el primer día cuentas con tu portal web propio (ej: tu-clinica.avipetapp.com y avipetapp.com/v/tu-clinica). En el plan Enterprise también puedes conectar directamente tu propio dominio corporativo.'
    },
    {
        question: '¿Qué ocurre cuando terminan los 15 días de prueba gratuita?',
        answer: 'No solicitamos tarjeta de crédito para iniciar. Al finalizar tu prueba de 15 días, eliges el modelo que prefieras: paquete prepago de 10 mascotas por $50.000 COP o tarifa mensual fija (Starter $99.000 o Profesional $229.000). Si decides no continuar, tu cuenta se pausa sin cobros automáticos ni penalidades.'
    }
];

function formatCOP(num: number): string {
    return '$' + num.toLocaleString('es-CO');
}

export default function B2BLanding() {
    // Navegación móvil
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

    // Selector interactivo en el Hero: Vista Recepción vs Vista Carnet Tutor
    const [heroTab, setHeroTab] = useState<'recepcion' | 'carnet'>('recepcion');
    const [activityIndex, setActivityIndex] = useState(0);

    // Simulador Financiero (Calculadora MRR)
    const [petsCount, setPetsCount] = useState<number>(50);
    const [planPrice, setPlanPrice] = useState<number>(65000);

    // Flujo Operativo de 6 Pasos
    const [activeStep, setActiveStep] = useState<number>(1);
    const [autoPlaySteps, setAutoPlaySteps] = useState<boolean>(true);

    // Demo Escáner QR en Sala de Espera
    const [qrScanned, setQrScanned] = useState<boolean>(false);
    const [qrScanning, setQrScanning] = useState<boolean>(false);

    // Demo Carnet Interactivo (Canje de Vacuna)
    const [vaccineRedeemed, setVaccineRedeemed] = useState<boolean>(false);

    // Demo AVI Intelligence (Sugerencias IA con supervisión humana)
    const [aiCompletedActions, setAiCompletedActions] = useState<Record<string, boolean>>({});
    const [aiToastMessage, setAiToastMessage] = useState<string | null>(null);

    // Acordeón FAQ
    const [openFaqIndex, setOpenFaqIndex] = useState<number | null>(0);

    // Modal de Registro Express (POST /registro-clinica)
    const [registerModalOpen, setRegisterModalOpen] = useState<boolean>(false);
    const [selectedTier, setSelectedTier] = useState<PlanTier>('pro');
    const [clinicName, setClinicName] = useState<string>('');
    const [doctorName, setDoctorName] = useState<string>('');
    const [city, setCity] = useState<string>('');
    const [phone, setPhone] = useState<string>('');
    const [email, setEmail] = useState<string>('');
    const [password, setPassword] = useState<string>('');
    const [showPassword, setShowPassword] = useState<boolean>(false);
    const [submitting, setSubmitting] = useState<boolean>(false);
    const [formError, setFormError] = useState<string | null>(null);
    const [registrationSuccess, setRegistrationSuccess] = useState<{
        storefrontUrl: string;
        adminUrl: string;
        redirectUrl: string;
    } | null>(null);
    const [countdown, setCountdown] = useState<number>(6);
    const [copiedField, setCopiedField] = useState<'storefront' | 'admin' | null>(null);

    // Rotación de actividad en vivo en el Hero
    useEffect(() => {
        const interval = setInterval(() => {
            setActivityIndex((prev) => (prev + 1) % LIVE_ACTIVITIES.length);
        }, 4000);
        return () => clearInterval(interval);
    }, []);

    // Auto-avance de los 6 pasos operativos
    useEffect(() => {
        if (!autoPlaySteps) return;
        const timer = setInterval(() => {
            setActiveStep((prev) => (prev % 6) + 1);
        }, 5500);
        return () => clearInterval(timer);
    }, [autoPlaySteps]);

    // Apertura automática del modal si la URL trae ?registro=1 o #onboarding
    useEffect(() => {
        if (typeof window === 'undefined') return;
        const params = new URLSearchParams(window.location.search);
        if (
            params.get('registro') === '1' ||
            window.location.hash === '#onboarding' ||
            window.location.hash === '#registro'
        ) {
            const tierParam = (params.get('tier') as PlanTier) || 'pro';
            setSelectedTier(tierParam);
            setRegisterModalOpen(true);
        }
    }, []);

    // Conteo regresivo tras crear la clínica
    useEffect(() => {
        if (!registrationSuccess) return;
        const timer = setInterval(() => {
            setCountdown((prev) => {
                if (prev <= 1) {
                    clearInterval(timer);
                    window.location.href = registrationSuccess.redirectUrl;
                    return 0;
                }
                return prev - 1;
            });
        }, 1000);
        return () => clearInterval(timer);
    }, [registrationSuccess]);

    // Cálculos de la Calculadora MRR
    const monthlyMRR = petsCount * planPrice;
    const annualMRR = monthlyMRR * 12;
    const perPetCost = petsCount * 5000;
    const fixedTierCost = petsCount <= 60 ? 99000 : petsCount <= 250 ? 229000 : 489000;
    const fixedTierName = petsCount <= 60 ? 'Starter' : petsCount <= 250 ? 'Profesional' : 'Enterprise';
    const bestCost = Math.min(perPetCost, fixedTierCost);
    const netMarginPct = Math.max(0, Math.round(((monthlyMRR - bestCost) / monthlyMRR) * 100));
    const netMonthlyProfit = monthlyMRR - bestCost;

    // Vista previa del slug de la clínica
    const slugPreview = clinicName
        .toLowerCase()
        .trim()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .replace(/[^a-z0-9]/g, '-')
        .replace(/-+/g, '-')
        .replace(/^-|-$/g, '') || 'tu-clinica';

    const openRegisterModal = (tier: PlanTier = 'pro') => {
        setSelectedTier(tier);
        setFormError(null);
        setRegisterModalOpen(true);
    };

    const handleTriggerQrScan = () => {
        if (qrScanning) return;
        if (qrScanned) {
            setQrScanned(false);
            return;
        }
        setQrScanning(true);
        setTimeout(() => {
            setQrScanning(false);
            setQrScanned(true);
        }, 850);
    };

    const handleAiAction = (key: string, toastText: string) => {
        setAiCompletedActions((prev) => ({ ...prev, [key]: true }));
        setAiToastMessage(toastText);
        setTimeout(() => {
            setAiToastMessage(null);
        }, 3500);
    };

    const handleCopyUrl = (url: string, field: 'storefront' | 'admin') => {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(url);
            setCopiedField(field);
            setTimeout(() => setCopiedField(null), 2500);
        }
    };

    const handleOnboardingSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setFormError(null);
        setSubmitting(true);

        const csrfToken =
            document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        const formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('saas_plan_tier', selectedTier);
        formData.append('clinic_name', clinicName);
        formData.append('doctor_name', doctorName);
        formData.append('city', city);
        formData.append('phone', phone);
        formData.append('email', email);
        formData.append('password', password);

        try {
            const response = await fetch('/registro-clinica', {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            });

            const data = await response.json();

            if (!response.ok) {
                let errorMsg = data.message || 'No fue posible completar el registro. Verifica los datos.';
                if (data.errors) {
                    const firstErr = Object.values(data.errors)[0];
                    if (Array.isArray(firstErr) && firstErr.length > 0) {
                        errorMsg = String(firstErr[0]);
                    }
                }
                throw new Error(errorMsg);
            }

            const sfUrl = data.storefront_url || `https://avipetapp.com/v/${data.tenant_slug}`;
            const admUrl = data.admin_url || `https://avipetapp.com/admin/${data.tenant_slug}`;

            setRegistrationSuccess({
                storefrontUrl: sfUrl,
                adminUrl: admUrl,
                redirectUrl: data.redirect_url || admUrl
            });
            setCountdown(6);
        } catch (err: any) {
            setFormError(err.message || 'Ocurrió un error inesperado al crear tu clínica.');
        } finally {
            setSubmitting(false);
        }
    };

    const currentActivity = LIVE_ACTIVITIES[activityIndex];

    const tierBadgeMeta: Record<PlanTier, { label: string; className: string }> = {
        pay_per_pet: {
            label: 'Paquete 10 Mascotas ($50.000)',
            className: 'bg-[#0E7490]/15 text-[#0E7490] border-[#0E7490]/30'
        },
        starter: {
            label: 'Plan Starter ($99.000/mes)',
            className: 'bg-[#F4F7FC] text-[#15213B] border-[#D9E2F2]'
        },
        pro: {
            label: 'Plan Profesional ($229.000/mes)',
            className: 'bg-[#6D28D9]/10 text-[#6D28D9] border-[#6D28D9]/25'
        },
        enterprise: {
            label: 'Plan Enterprise ($489.000/mes)',
            className: 'bg-[#080B20] text-[#35DDF5] border-[#1E2B58]'
        }
    };

    return (
        <div className="min-h-screen flex flex-col justify-between bg-[#F4F7FC] text-[#15213B] font-sans antialiased selection:bg-[#6D28D9] selection:text-white overflow-x-hidden">
            <Head title="AviPetApp — Software con IA para veterinarias | Planes de salud para mascotas" />

            {/* =====================================================================
                1. HEADER / NAVBAR OFICIAL AVIPETAPP (Págs. 5, 6 y 9 Manual v1.1)
               ===================================================================== */}
            <header className="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-[#D9E2F2] transition-all">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
                    {/* Logo Horizontal Oficial sobre fondo claro (mínimo >= 140px con margen libre X) */}
                    <a
                        href="/"
                        className="flex items-center py-3 shrink-0 group"
                        aria-label="AviPetApp — Inicio"
                    >
                        <img
                            src="/brand/svg/avipetapp-horizontal-fondo-claro.svg"
                            alt="AviPetApp"
                            className="h-8 sm:h-9 w-auto min-w-[148px] object-contain transition-transform duration-200 group-hover:scale-[1.02]"
                        />
                    </a>

                    {/* Navegación en 1 sola línea (Pág. 9: visible desde lg:flex sin saltos de renglón) */}
                    <nav className="hidden lg:flex items-center gap-5 xl:gap-6 text-[14px] font-medium text-[#5C6B85]">
                        <a
                            href="#veterinarias-socias"
                            className="text-[#0E7490] font-semibold hover:text-[#6D28D9] transition-colors whitespace-nowrap"
                        >
                            Para clínicas
                        </a>
                        <a
                            href="#como-funciona"
                            className="hover:text-[#15213B] transition-colors whitespace-nowrap"
                        >
                            Planes de salud
                        </a>
                        <a
                            href="#recibes"
                            className="hover:text-[#15213B] transition-colors whitespace-nowrap"
                        >
                            Módulos e IA
                        </a>
                        <a
                            href="#calculadora"
                            className="hover:text-[#15213B] transition-colors whitespace-nowrap"
                        >
                            Calculadora
                        </a>
                        <a
                            href="#scanner-demo"
                            className="hover:text-[#15213B] transition-colors inline-flex items-center gap-1.5 whitespace-nowrap"
                        >
                            <span>Demo QR</span>
                            <span className="px-2 py-0.5 text-[11px] font-semibold bg-[#6D28D9]/10 text-[#6D28D9] rounded-full">
                                Vivo
                            </span>
                        </a>
                        <a
                            href="#precios"
                            className="hover:text-[#15213B] transition-colors whitespace-nowrap"
                        >
                            Precios
                        </a>
                        <a
                            href="#faq"
                            className="hover:text-[#15213B] transition-colors whitespace-nowrap"
                        >
                            FAQ
                        </a>
                        <a
                            href="/blog"
                            className="text-[#6D28D9] font-semibold hover:text-[#5B21B6] transition-colors whitespace-nowrap"
                        >
                            Blog
                        </a>
                    </nav>

                    {/* Acciones Derecha */}
                    <div className="flex items-center gap-2.5 sm:gap-3 shrink-0">
                        <a
                            href="/admin"
                            className="hidden sm:inline-flex items-center px-4 py-2.5 text-[14px] font-semibold text-[#15213B] hover:text-[#6D28D9] transition-colors rounded-xl border border-transparent hover:border-[#D9E2F2] whitespace-nowrap"
                        >
                            Iniciar sesión
                        </a>
                        <button
                            type="button"
                            onClick={() => openRegisterModal('pro')}
                            className="px-4 sm:px-5 py-2.5 text-[14px] font-semibold leading-none text-white bg-[#6D28D9] hover:bg-[#5B21B6] rounded-xl shadow-xs transition-all transform hover:-translate-y-0.5 active:translate-y-0 inline-flex items-center gap-2 whitespace-nowrap cursor-pointer"
                        >
                            <span className="w-2 h-2 rounded-full bg-[#35DDF5]" />
                            <span>Crear mi clínica</span>
                        </button>
                        <button
                            type="button"
                            onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                            className="lg:hidden p-2 rounded-xl text-[#15213B] hover:text-[#6D28D9] hover:bg-[#F4F7FC] transition focus:outline-hidden"
                            aria-label="Abrir menú de navegación"
                        >
                            {mobileMenuOpen ? (
                                <X className="w-6 h-6" strokeWidth={2} />
                            ) : (
                                <Menu className="w-6 h-6" strokeWidth={2} />
                            )}
                        </button>
                    </div>
                </div>

                {/* Menú Móvil Desplegable */}
                {mobileMenuOpen && (
                    <div className="lg:hidden bg-white border-b border-[#D9E2F2] px-4 pt-3 pb-6 space-y-3 shadow-xl">
                        <nav className="flex flex-col space-y-1 text-[14px] font-medium text-[#15213B]">
                            <a
                                href="#veterinarias-socias"
                                onClick={() => setMobileMenuOpen(false)}
                                className="px-3.5 py-2.5 rounded-xl bg-[#0F9F9A]/10 text-[#0E7490] font-semibold transition flex items-center justify-between"
                            >
                                <span>Para clínicas · Veterinarias Socias</span>
                                <span className="text-[11px] bg-[#0F9F9A] text-white px-2 py-0.5 rounded-full font-semibold">
                                    Red Colombia
                                </span>
                            </a>
                            <a
                                href="#como-funciona"
                                onClick={() => setMobileMenuOpen(false)}
                                className="px-3.5 py-2.5 rounded-xl hover:bg-[#F4F7FC] hover:text-[#6D28D9] transition flex items-center justify-between"
                            >
                                <span>Planes de salud · Cómo funciona</span>
                                <ArrowRight className="w-4 h-4 text-[#5C6B85]" strokeWidth={2} />
                            </a>
                            <a
                                href="#recibes"
                                onClick={() => setMobileMenuOpen(false)}
                                className="px-3.5 py-2.5 rounded-xl hover:bg-[#F4F7FC] hover:text-[#6D28D9] transition flex items-center justify-between"
                            >
                                <span>Módulos e IA · Lo que recibes</span>
                                <ArrowRight className="w-4 h-4 text-[#5C6B85]" strokeWidth={2} />
                            </a>
                            <a
                                href="#calculadora"
                                onClick={() => setMobileMenuOpen(false)}
                                className="px-3.5 py-2.5 rounded-xl hover:bg-[#F4F7FC] hover:text-[#6D28D9] transition flex items-center justify-between"
                            >
                                <span>Calculadora de ingresos</span>
                                <ArrowRight className="w-4 h-4 text-[#5C6B85]" strokeWidth={2} />
                            </a>
                            <a
                                href="#scanner-demo"
                                onClick={() => setMobileMenuOpen(false)}
                                className="px-3.5 py-2.5 rounded-xl hover:bg-[#F4F7FC] hover:text-[#6D28D9] transition flex items-center justify-between"
                            >
                                <span>Demo de escáner QR en mostrador</span>
                                <span className="px-2 py-0.5 text-[11px] font-semibold bg-[#6D28D9]/10 text-[#6D28D9] rounded-full">
                                    Interactivo
                                </span>
                            </a>
                            <a
                                href="#precios"
                                onClick={() => setMobileMenuOpen(false)}
                                className="px-3.5 py-2.5 rounded-xl hover:bg-[#F4F7FC] hover:text-[#6D28D9] transition flex items-center justify-between"
                            >
                                <span>Precios y planes</span>
                                <ArrowRight className="w-4 h-4 text-[#5C6B85]" strokeWidth={2} />
                            </a>
                            <a
                                href="#faq"
                                onClick={() => setMobileMenuOpen(false)}
                                className="px-3.5 py-2.5 rounded-xl hover:bg-[#F4F7FC] hover:text-[#6D28D9] transition flex items-center justify-between"
                            >
                                <span>Preguntas frecuentes</span>
                                <ArrowRight className="w-4 h-4 text-[#5C6B85]" strokeWidth={2} />
                            </a>
                            <a
                                href="/blog"
                                className="px-3.5 py-2.5 rounded-xl bg-[#6D28D9]/10 text-[#6D28D9] font-semibold transition flex items-center justify-between"
                            >
                                <span>Blog y guías para clínicas</span>
                                <span className="text-[11px] bg-[#6D28D9] text-white px-2 py-0.5 rounded-full font-semibold">
                                    Guías
                                </span>
                            </a>
                        </nav>

                        <div className="pt-3 border-t border-[#D9E2F2] flex flex-col gap-2.5">
                            <a
                                href="/admin"
                                className="w-full py-2.5 px-4 text-center rounded-xl border border-[#6D28D9] text-[#6D28D9] font-semibold text-[14px] hover:bg-[#6D28D9]/5 transition"
                            >
                                Iniciar sesión en mi clínica
                            </a>
                            <a
                                href="https://wa.me/573235813942?text=Hola%20AviPetApp,%20quiero%20solicitar%20una%20demo%20para%20mi%20cl%C3%ADnica%20veterinaria"
                                target="_blank"
                                rel="noreferrer"
                                className="w-full py-2.5 px-4 text-center rounded-xl bg-[#0F9F9A] hover:bg-[#0E7490] text-white font-semibold text-[14px] transition shadow-xs"
                            >
                                Hablar con el equipo (WhatsApp)
                            </a>
                        </div>
                    </div>
                )}
            </header>

            <main className="flex-grow">
                {/* =====================================================================
                    2. HERO PRINCIPAL CON VISTA INTERACTIVA DE PRODUCTO (Págs. 3, 7, 8, 9, 10)
                   ===================================================================== */}
                <section className="relative pt-10 sm:pt-14 pb-16 sm:pb-24 overflow-hidden bg-gradient-to-b from-white via-[#F4F7FC] to-[#F4F7FC] border-b border-[#D9E2F2]">
                    <div className="absolute -top-24 left-1/4 w-96 h-96 bg-[#A855F7]/10 rounded-full blur-3xl pointer-events-none" />
                    <div className="absolute top-1/2 -right-24 w-80 h-80 bg-[#35DDF5]/10 rounded-full blur-3xl pointer-events-none" />

                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                        <div className="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
                            {/* COLUMNA IZQUIERDA: JERARQUÍA DE MENSAJES OFICIAL */}
                            <div className="lg:col-span-7 space-y-6 text-left">
                                <div className="inline-flex flex-wrap items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#6D28D9]/10 border border-[#6D28D9]/20 text-[#6D28D9] text-[13px] font-semibold">
                                    <Sparkles className="w-3.5 h-3.5 text-[#6D28D9]" strokeWidth={2} />
                                    <span>Software con IA para veterinarias · 15 días de prueba sin tarjeta</span>
                                </div>

                                <h1 className="text-4xl sm:text-5xl lg:text-[54px] font-bold tracking-tight text-[#15213B] leading-[1.1]">
                                    Tu clínica, conectada con el{' '}
                                    <span className="gradient-headline">futuro del bienestar animal.</span>
                                </h1>

                                <p className="text-[15px] sm:text-[16px] text-[#5C6B85] leading-[1.5] font-normal max-w-[62ch]">
                                    <strong className="text-[#15213B] font-semibold">
                                        Planes de salud, clientes e IA en una sola plataforma.
                                    </strong>{' '}
                                    AviPetApp ayuda a tu clínica a gestionar planes de salud para mascotas, organizar la relación con tus clientes y aprovechar herramientas inteligentes desde un solo lugar.
                                </p>

                                <div className="inline-flex items-center gap-2 text-[13px] font-semibold text-[#0E7490] bg-[#0E7490]/10 border border-[#0E7490]/20 px-3.5 py-2 rounded-xl">
                                    <ShieldCheck className="w-4 h-4 text-[#0E7490] shrink-0" strokeWidth={2} />
                                    <span>Tu marca · Tus planes de salud · Tus precios · Tus clientes</span>
                                </div>

                                {/* Botones de Acción Oficiales (Págs. 8, 9 y 12) */}
                                <div className="pt-1 flex flex-col sm:flex-row items-stretch sm:items-center gap-3.5">
                                    <button
                                        type="button"
                                        onClick={() => openRegisterModal('pro')}
                                        className="px-7 py-4 rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-semibold text-[15px] leading-none shadow-md shadow-[#6D28D9]/20 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 cursor-pointer"
                                    >
                                        <span>Crear mi clínica (15 días gratis)</span>
                                        <ArrowRight className="w-4 h-4" strokeWidth={2} />
                                    </button>
                                    <a
                                        href="#como-funciona"
                                        className="px-6 py-4 rounded-xl bg-white hover:bg-[#6D28D9]/5 text-[#6D28D9] font-semibold text-[15px] leading-none border-2 border-[#6D28D9] transition-all flex items-center justify-center gap-2 text-center"
                                    >
                                        <span>Conocer los planes</span>
                                    </a>
                                </div>

                                {/* Escenario Ilustrativo con Regla de Datos Clara (Pág. 9) */}
                                <div className="p-4 rounded-2xl bg-white border border-[#D9E2F2] shadow-2xs max-w-xl">
                                    <div className="flex items-center justify-between text-[13px] font-semibold text-[#15213B]">
                                        <span className="text-[#5C6B85]">Escenario ilustrativo de operación:</span>
                                        <span className="text-[#6D28D9] font-bold tabular-nums">
                                            50 mascotas × $65.000 COP/mes
                                        </span>
                                    </div>
                                    <div className="flex items-baseline justify-between mt-1.5 pt-2 border-t border-[#F4F7FC]">
                                        <span className="text-[12px] text-[#5C6B85]">
                                            Recaudo mensual estimado directo a tu clínica:
                                        </span>
                                        <span className="text-[16px] font-bold text-[#0E7490] tabular-nums">
                                            $3.250.000 COP / mes
                                        </span>
                                    </div>
                                </div>

                                {/* Pilares rápidos con iconografía 2px */}
                                <div className="flex flex-wrap items-center gap-5 text-[13px] text-[#5C6B85] font-medium">
                                    <div className="flex items-center gap-1.5">
                                        <CheckCircle2 className="w-4 h-4 text-[#0F9F9A] shrink-0" strokeWidth={2} />
                                        <span>Afiche QR para recepción</span>
                                    </div>
                                    <div className="flex items-center gap-1.5">
                                        <CheckCircle2 className="w-4 h-4 text-[#0F9F9A] shrink-0" strokeWidth={2} />
                                        <span>Canje en mostrador con auditoría</span>
                                    </div>
                                    <div className="flex items-center gap-1.5">
                                        <CheckCircle2 className="w-4 h-4 text-[#0F9F9A] shrink-0" strokeWidth={2} />
                                        <span>100 % recaudo directo a tu clínica</span>
                                    </div>
                                </div>
                            </div>

                            {/* COLUMNA DERECHA: VISTA REAL INTERACTIVA DEL PRODUCTO CON 2 PESTAÑAS (Págs. 9 y 10) */}
                            <div className="lg:col-span-5">
                                <div className="relative w-full max-w-md mx-auto">
                                    <div className="absolute -inset-1 bg-gradient-to-r from-[#6D28D9] to-[#0E7490] rounded-3xl blur-md opacity-15 pointer-events-none" />

                                    <div className="relative bg-white rounded-2xl border border-[#D9E2F2] shadow-xl p-5 sm:p-6 space-y-4">
                                        {/* Selector de Vista Interactiva (Recepción Clínica vs Carnet Tutor) */}
                                        <div className="flex items-center justify-between gap-2 bg-[#F4F7FC] p-1 rounded-xl border border-[#D9E2F2]">
                                            <button
                                                type="button"
                                                onClick={() => setHeroTab('recepcion')}
                                                className={`flex-1 py-2 px-3 rounded-lg text-xs font-semibold transition-all flex items-center justify-center gap-1.5 cursor-pointer ${
                                                    heroTab === 'recepcion'
                                                        ? 'bg-white text-[#6D28D9] shadow-2xs border border-[#D9E2F2]'
                                                        : 'text-[#5C6B85] hover:text-[#15213B]'
                                                }`}
                                            >
                                                <Stethoscope className="w-3.5 h-3.5" strokeWidth={2} />
                                                <span>Panel Recepción</span>
                                            </button>
                                            <button
                                                type="button"
                                                onClick={() => setHeroTab('carnet')}
                                                className={`flex-1 py-2 px-3 rounded-lg text-xs font-semibold transition-all flex items-center justify-center gap-1.5 cursor-pointer ${
                                                    heroTab === 'carnet'
                                                        ? 'bg-white text-[#6D28D9] shadow-2xs border border-[#D9E2F2]'
                                                        : 'text-[#5C6B85] hover:text-[#15213B]'
                                                }`}
                                            >
                                                <QrCode className="w-3.5 h-3.5" strokeWidth={2} />
                                                <span>Carnet QR Tutor</span>
                                            </button>
                                        </div>

                                        {heroTab === 'recepcion' ? (
                                            <div className="space-y-4">
                                                {/* Header del Widget Demo */}
                                                <div className="flex items-center justify-between border-b border-[#F4F7FC] pb-3">
                                                    <div className="flex items-center gap-2.5">
                                                        <span className="relative flex h-2.5 w-2.5">
                                                            <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#0F9F9A] opacity-75" />
                                                            <span className="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#0F9F9A]" />
                                                        </span>
                                                        <div>
                                                            <h3 className="text-[13px] font-bold text-[#15213B]">
                                                                Consultorio Demo · Vista de Recepción
                                                            </h3>
                                                            <p className="text-[11px] text-[#5C6B85]">
                                                                Valores ilustrativos · Periodo: Mes actual
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <span className="px-2.5 py-1 rounded-full bg-[#ECFDF5] text-[#065F46] text-[11px] font-semibold inline-flex items-center gap-1 border border-[#0F9F9A]/30">
                                                        <CheckCircle2 className="w-3.5 h-3.5 text-[#0F9F9A]" strokeWidth={2} />
                                                        <span>Activa</span>
                                                    </span>
                                                </div>

                                                {/* Indicadores con periodo y definición visibles */}
                                                <div className="grid grid-cols-2 gap-3">
                                                    <div className="bg-[#F4F7FC] p-3.5 rounded-xl border border-[#D9E2F2]">
                                                        <span className="text-[11px] font-semibold text-[#5C6B85] block">
                                                            Mascotas con membresía
                                                        </span>
                                                        <div className="text-2xl font-bold text-[#15213B] tabular-nums mt-1">
                                                            127
                                                        </div>
                                                        <span className="text-[11px] font-medium text-[#0E7490]">
                                                            Planes activos este mes
                                                        </span>
                                                    </div>

                                                    <div className="bg-[#F4F7FC] p-3.5 rounded-xl border border-[#D9E2F2]">
                                                        <span className="text-[11px] font-semibold text-[#5C6B85] block">
                                                            Recaudo de la clínica
                                                        </span>
                                                        <div className="text-xl font-bold text-[#6D28D9] tabular-nums mt-1">
                                                            $8.255.000
                                                        </div>
                                                        <span className="text-[11px] font-medium text-[#5C6B85]">
                                                            COP · Directo a la clínica
                                                        </span>
                                                    </div>

                                                    {/* Estado Semántico Oficial: Pendiente (#FEF3C7 / #92400E) */}
                                                    <div className="bg-[#FEF3C7]/60 p-3 rounded-xl border border-[#B45309]/25">
                                                        <div className="flex items-center gap-1.5 text-[11px] font-semibold text-[#92400E]">
                                                            <Clock className="w-3.5 h-3.5 shrink-0 text-[#B45309]" strokeWidth={2} />
                                                            <span>Pendiente renovar</span>
                                                        </div>
                                                        <span className="text-[13px] font-bold text-[#15213B] block mt-1 tabular-nums">
                                                            6 planes esta semana
                                                        </span>
                                                    </div>

                                                    {/* Estado Semántico Oficial: Confirmado (#ECFDF5 / #065F46) */}
                                                    <div className="bg-[#ECFDF5] p-3 rounded-xl border border-[#0F9F9A]/30">
                                                        <div className="flex items-center gap-1.5 text-[11px] font-semibold text-[#065F46]">
                                                            <CheckCircle2 className="w-3.5 h-3.5 text-[#0F9F9A] shrink-0" strokeWidth={2} />
                                                            <span>Canjes del día</span>
                                                        </div>
                                                        <span className="text-[13px] font-bold text-[#15213B] block mt-1 tabular-nums">
                                                            3 vacunas · 9 consultas
                                                        </span>
                                                    </div>
                                                </div>

                                                {/* Barra de Continuidad */}
                                                <div className="space-y-1.5 bg-[#F4F7FC] p-3.5 rounded-xl border border-[#D9E2F2]">
                                                    <div className="flex justify-between text-[12px] font-semibold text-[#15213B]">
                                                        <span>Continuidad de planes (12 meses)</span>
                                                        <span className="text-[#6D28D9] tabular-nums">82 %</span>
                                                    </div>
                                                    <div className="w-full bg-[#D9E2F2] rounded-full h-2 overflow-hidden">
                                                        <div
                                                            className="bg-gradient-to-r from-[#6D28D9] to-[#0F9F9A] h-2 rounded-full shimmer-effect"
                                                            style={{ width: '82%' }}
                                                        />
                                                    </div>
                                                </div>

                                                {/* Actividad de Mostrador en Tiempo Real */}
                                                <div className="space-y-2 border-t border-[#F4F7FC] pt-2">
                                                    <div className="flex items-center justify-between text-[11px] font-semibold text-[#5C6B85]">
                                                        <span>Último registro en recepción</span>
                                                        <span className="text-[#0E7490]">{currentActivity.time}</span>
                                                    </div>
                                                    <div className="p-3 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2] text-xs text-[#15213B] transition-all duration-300 flex items-center gap-3">
                                                        <div className="w-9 h-9 rounded-xl bg-[#6D28D9]/10 text-[#6D28D9] flex items-center justify-center shrink-0">
                                                            <PawPrint className="w-4 h-4" strokeWidth={2} />
                                                        </div>
                                                        <div className="min-w-0 flex-1">
                                                            <div className="flex items-center justify-between gap-2">
                                                                <strong className="text-[#15213B] font-semibold truncate">
                                                                    {currentActivity.petName} ({currentActivity.breed})
                                                                </strong>
                                                                <span className="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-white border border-[#D9E2F2] text-[#0E7490] shrink-0">
                                                                    {currentActivity.badge}
                                                                </span>
                                                            </div>
                                                            <span className="text-[#5C6B85] block text-[11px] truncate mt-0.5">
                                                                {currentActivity.action}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        ) : (
                                            /* PESTAÑA 2: CARNET DIGITAL QR DEL TUTOR */
                                            <div className="space-y-3.5">
                                                <div className="rounded-2xl p-4 bg-gradient-to-br from-[#6D28D9] via-[#111936] to-[#080B20] text-white border border-[#A855F7]/30 space-y-3">
                                                    <div className="flex items-center justify-between border-b border-white/15 pb-2.5">
                                                        <div className="flex items-center gap-2">
                                                            <div className="w-7 h-7 rounded-lg bg-white p-1 flex items-center justify-center">
                                                                <img
                                                                    src="/brand/svg/avipetapp-icono-app.svg"
                                                                    alt="Icono"
                                                                    className="w-full h-full object-contain"
                                                                />
                                                            </div>
                                                            <div>
                                                                <span className="text-xs font-bold block leading-tight">
                                                                    Vet-Pet Patitas
                                                                </span>
                                                                <span className="text-[10px] text-[#35DDF5]">
                                                                    Carnet Digital Oficial
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <span className="px-2.5 py-0.5 rounded-full bg-[#0F9F9A]/25 border border-[#0F9F9A]/50 text-[#35DDF5] text-[10px] font-semibold inline-flex items-center gap-1">
                                                            <CheckCircle2 className="w-3 h-3" strokeWidth={2} />
                                                            <span>Activa</span>
                                                        </span>
                                                    </div>

                                                    <div className="flex items-center justify-between">
                                                        <div>
                                                            <div className="text-base font-bold text-white">
                                                                Luna · Golden Retriever
                                                            </div>
                                                            <div className="text-[11px] text-slate-300">
                                                                Tutor: Carlos Mendoza · Plan Premium
                                                            </div>
                                                        </div>
                                                        <div className="text-right tabular-nums">
                                                            <span className="text-xs font-bold text-[#35DDF5] block">
                                                                #VP-2026-0881
                                                            </span>
                                                            <span className="text-[10px] text-slate-300">
                                                                5/8 disponibles
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div className="space-y-2">
                                                    <div className="p-2.5 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2] flex items-center justify-between text-xs">
                                                        <div className="flex items-center gap-2 font-semibold text-[#15213B]">
                                                            <Stethoscope className="w-4 h-4 text-[#0E7490]" strokeWidth={2} />
                                                            <span>Consultas Preventivas</span>
                                                        </div>
                                                        <span className="px-2 py-0.5 rounded-md bg-[#ECFDF5] text-[#065F46] font-bold text-[11px] tabular-nums">
                                                            2 / 2 Disp.
                                                        </span>
                                                    </div>
                                                    <div className="p-2.5 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2] flex items-center justify-between text-xs">
                                                        <div className="flex items-center gap-2 font-semibold text-[#15213B]">
                                                            <Syringe className="w-4 h-4 text-[#6D28D9]" strokeWidth={2} />
                                                            <span>Vacuna Séxtuple Anual</span>
                                                        </div>
                                                        <span className="px-2 py-0.5 rounded-md bg-[#6D28D9]/10 text-[#6D28D9] font-bold text-[11px] tabular-nums">
                                                            Aplicada ✓
                                                        </span>
                                                    </div>
                                                    <div className="p-2.5 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2] flex items-center justify-between text-xs">
                                                        <div className="flex items-center gap-2 font-semibold text-[#15213B]">
                                                            <ShieldCheck className="w-4 h-4 text-[#0F9F9A]" strokeWidth={2} />
                                                            <span>Desparasitación Trimestral</span>
                                                        </div>
                                                        <span className="px-2 py-0.5 rounded-md bg-[#ECFDF5] text-[#065F46] font-bold text-[11px] tabular-nums">
                                                            3 / 3 Disp.
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        )}

                                        {/* Acción Secundaria Oficial (Borde #6D28D9) */}
                                        <a
                                            href="/v/vet-pet-patitas"
                                            target="_blank"
                                            rel="noreferrer"
                                            className="w-full py-2.5 px-4 text-center rounded-xl bg-white hover:bg-[#6D28D9]/5 text-[#6D28D9] font-semibold text-[13px] border border-[#6D28D9] transition flex items-center justify-center gap-1.5"
                                        >
                                            <span>Explorar clínica piloto en vivo</span>
                                            <ExternalLink className="w-3.5 h-3.5" strokeWidth={2} />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* =====================================================================
                    3. SECCIÓN DE COLABORACIÓN: COMPLEMENTA TU SOFTWARE ACTUAL
                   ===================================================================== */}
                <section className="py-8 bg-white border-b border-[#D9E2F2]">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="p-6 sm:p-8 rounded-2xl bg-[#F4F7FC] border border-[#D9E2F2] flex flex-col md:flex-row items-center justify-between gap-6">
                            <div className="flex items-start sm:items-center gap-4">
                                <div className="w-12 h-12 rounded-xl bg-[#6D28D9]/10 text-[#6D28D9] flex items-center justify-center shrink-0 border border-[#6D28D9]/20">
                                    <Link2 className="w-6 h-6" strokeWidth={2} />
                                </div>
                                <div className="space-y-1">
                                    <h2 className="text-[18px] sm:text-[20px] font-bold text-[#15213B] leading-[1.3]">
                                        AviPetApp complementa tu software de historia clínica actual
                                    </h2>
                                    <p className="text-[14px] text-[#5C6B85] max-w-[68ch] leading-[1.5]">
                                        Si ya utilizas <strong>Vetlogy, SoftVet, Gesvet o Excel</strong> para expedientes médicos e inventario, puedes seguir usándolos. AviPetApp organiza los{' '}
                                        <strong>planes de salud para mascotas, membresías, carnets digitales y recordatorios</strong>{' '}
                                        desde una plataforma conectada con tu recepción.
                                    </p>
                                </div>
                            </div>
                            <div className="shrink-0 inline-flex items-center gap-2 text-[13px] font-semibold text-[#065F46] bg-[#ECFDF5] border border-[#0F9F9A]/30 px-4 py-2.5 rounded-xl">
                                <CheckCircle2 className="w-4 h-4 text-[#0F9F9A]" strokeWidth={2} />
                                <span>100 % Complementario</span>
                            </div>
                        </div>
                    </div>
                </section>

                {/* =====================================================================
                    3.5 PIEZA DE MARCA OSCURA: CLÍNICAS SOCIÁS (Midnight #080B20 + Deep Navy #111936)
                   ===================================================================== */}
                <section
                    id="veterinarias-socias"
                    className="py-16 sm:py-20 bg-[#080B20] text-white border-b border-[#111936] relative overflow-hidden"
                >
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-10">
                        <div className="text-center max-w-3xl mx-auto space-y-3">
                            <span className="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#111936] border border-[#35DDF5]/30 text-[#35DDF5] text-[12px] font-semibold uppercase tracking-wider">
                                <span className="w-2 h-2 rounded-full bg-[#35DDF5]" />
                                <span>Para clínicas · Red AviPetApp Colombia</span>
                            </span>
                            <h2 className="text-2xl sm:text-4xl font-bold tracking-tight text-white leading-[1.2]">
                                Programa de <span className="text-[#35DDF5]">Clínicas Veterinarias Socias</span> en Colombia
                            </h2>
                            <p className="text-[15px] sm:text-[16px] text-slate-300 leading-[1.5] max-w-[65ch] mx-auto">
                                Digitaliza los planes de salud para mascotas en tu ciudad con tu propia identidad clínica, recordatorios oportunos y herramientas inteligentes para tu equipo.
                            </p>
                        </div>

                        {/* 4 Pilares de Comunicación Oficiales (Pág. 12 Manual v1.1) */}
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                            <div className="bg-[#111936] border border-white/10 hover:border-[#35DDF5]/50 rounded-2xl p-6 space-y-2.5 transition">
                                <div className="w-10 h-10 rounded-xl bg-[#35DDF5]/15 text-[#35DDF5] flex items-center justify-center">
                                    <Layers className="w-5 h-5" strokeWidth={2} />
                                </div>
                                <h3 className="text-[16px] font-bold text-white">1. Gestión más simple</h3>
                                <p className="text-[13px] text-slate-300 leading-[1.5]">
                                    Planes, membresías, clientes y operación en orden desde tu propio portal (
                                    <code className="text-[#35DDF5]">tu-clinica.avipetapp.com</code>).
                                </p>
                            </div>

                            <div className="bg-[#111936] border border-white/10 hover:border-[#A855F7]/50 rounded-2xl p-6 space-y-2.5 transition">
                                <div className="w-10 h-10 rounded-xl bg-[#A855F7]/15 text-[#A855F7] flex items-center justify-center">
                                    <CreditCard className="w-5 h-5" strokeWidth={2} />
                                </div>
                                <h3 className="text-[16px] font-bold text-white">2. Recaudo 100 % directo</h3>
                                <p className="text-[13px] text-slate-300 leading-[1.5]">
                                    Cero comisiones por mascota afiliada. Tus clientes pagan directamente a tu Nequi, Bancolombia o enlace Bold/Wompi.
                                </p>
                            </div>

                            <div className="bg-[#111936] border border-white/10 hover:border-[#35DDF5]/50 rounded-2xl p-6 space-y-2.5 transition">
                                <div className="w-10 h-10 rounded-xl bg-[#35DDF5]/15 text-[#35DDF5] flex items-center justify-center">
                                    <QrCode className="w-5 h-5" strokeWidth={2} />
                                </div>
                                <h3 className="text-[16px] font-bold text-white">3. Relación continua</h3>
                                <p className="text-[13px] text-slate-300 leading-[1.5]">
                                    Afiche QR para recepción, carnet digital en el celular del tutor y recordatorios oportunos de vacunación y controles.
                                </p>
                            </div>

                            <div className="bg-[#111936] border border-white/10 hover:border-[#A855F7]/50 rounded-2xl p-6 space-y-2.5 transition">
                                <div className="w-10 h-10 rounded-xl bg-[#A855F7]/15 text-[#A855F7] flex items-center justify-center">
                                    <Sparkles className="w-5 h-5" strokeWidth={2} />
                                </div>
                                <h3 className="text-[16px] font-bold text-white">4. Inteligencia aplicada</h3>
                                <p className="text-[13px] text-slate-300 leading-[1.5]">
                                    Automatizaciones para tareas repetitivas con supervisión profesional, manteniendo siempre el criterio clínico de tu equipo.
                                </p>
                            </div>
                        </div>

                        {/* Caso Real + CTA de Demo */}
                        <div className="bg-[#111936] border border-[#A855F7]/30 rounded-2xl p-6 sm:p-8 flex flex-col lg:flex-row items-center justify-between gap-6 shadow-xl">
                            <div className="space-y-3 max-w-2xl">
                                <div className="flex flex-wrap items-center gap-2.5">
                                    <span className="px-2.5 py-0.5 rounded-full bg-[#0F9F9A]/20 border border-[#0F9F9A]/40 text-[#35DDF5] text-[11px] font-semibold">
                                        Clínica Piloto en Operación
                                    </span>
                                    <span className="text-[12px] text-slate-300 font-medium inline-flex items-center gap-1">
                                        <MapPin className="w-3.5 h-3.5 text-[#35DDF5]" strokeWidth={2} />
                                        <span>Cajicá, Cundinamarca</span>
                                    </span>
                                </div>
                                <h3 className="text-xl sm:text-2xl font-bold text-white leading-[1.3]">
                                    Conoce la experiencia real de{' '}
                                    <span className="text-[#35DDF5]">Vet-Pet Patitas Consultorio Veterinario</span>
                                </h3>
                                <p className="text-[14px] text-slate-300 leading-[1.5]">
                                    Organiza sus planes de salud para mascotas con AviPetApp, entrega carnets digitales con código QR en recepción y facilita el seguimiento preventivo para las familias.
                                </p>
                            </div>

                            <div className="flex flex-col sm:flex-row lg:flex-col gap-3 w-full lg:w-auto shrink-0">
                                <button
                                    type="button"
                                    onClick={() => openRegisterModal('pro')}
                                    className="px-6 py-3.5 rounded-xl bg-[#35DDF5] hover:bg-[#22d3ee] text-[#080B20] font-semibold text-[14px] leading-none shadow-md transition text-center cursor-pointer"
                                >
                                    Solicitar una demo (15 días gratis)
                                </button>
                                <a
                                    href="https://wa.me/573235813942?text=Hola%20AviPetApp,%20quiero%20informaci%C3%B3n%20para%20mi%20cl%C3%ADnica%20veterinaria"
                                    target="_blank"
                                    rel="noreferrer"
                                    className="px-6 py-3.5 rounded-xl bg-white/10 hover:bg-white/15 text-white font-semibold text-[14px] leading-none border border-white/20 transition text-center"
                                >
                                    Hablar con el equipo por WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                {/* =====================================================================
                    4. CALCULADORA MRR EN REACT (Cloud White #F4F7FC · Violet Deep #6D28D9)
                   ===================================================================== */}
                <section id="calculadora" className="py-16 sm:py-24 bg-[#F4F7FC] border-b border-[#D9E2F2]">
                    <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center max-w-2xl mx-auto mb-12 space-y-2.5">
                            <span className="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-[#6D28D9] bg-[#6D28D9]/10 px-3.5 py-1 rounded-full border border-[#6D28D9]/20">
                                <Sliders className="w-3.5 h-3.5" strokeWidth={2} />
                                <span>Simulador Financiero en Tiempo Real</span>
                            </span>
                            <h2 className="text-3xl sm:text-4xl font-bold text-[#15213B] tracking-tight mt-2">
                                ¿Cuánto podría generar tu veterinaria?
                            </h2>
                            <p className="text-sm text-[#5C6B85]">
                                Desliza el control para proyectar tus ingresos recurrentes mensuales con planes de salud preventiva.
                            </p>
                        </div>

                        <div className="p-6 sm:p-10 rounded-2xl bg-white border border-[#D9E2F2] shadow-md">
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                                {/* Controles Reactivos */}
                                <div className="space-y-6">
                                    <div>
                                        <div className="flex justify-between items-baseline mb-2">
                                            <label
                                                htmlFor="pets-range"
                                                className="text-xs font-bold text-[#15213B] uppercase tracking-wide"
                                            >
                                                Mascotas activas en planes:
                                            </label>
                                            <div className="flex items-baseline gap-1.5">
                                                <span className="text-3xl font-bold text-[#6D28D9] tabular-nums">
                                                    {petsCount}
                                                </span>
                                                <span className="text-xs font-semibold text-[#5C6B85]">mascotas</span>
                                            </div>
                                        </div>
                                        <input
                                            id="pets-range"
                                            type="range"
                                            min={10}
                                            max={300}
                                            step={5}
                                            value={petsCount}
                                            onChange={(e) => setPetsCount(Number(e.target.value))}
                                            className="w-full h-3 bg-[#E2E8F0] rounded-lg appearance-none cursor-pointer accent-[#6D28D9] hover:accent-[#5B21B6] transition"
                                        />
                                        <div className="flex justify-between text-[11px] text-[#5C6B85] font-semibold mt-1.5 tabular-nums">
                                            <span>10</span>
                                            <span>75</span>
                                            <span>150</span>
                                            <span>225</span>
                                            <span>300</span>
                                        </div>
                                    </div>

                                    <div>
                                        <span className="text-xs font-bold text-[#15213B] uppercase tracking-wide block mb-2">
                                            Tarifa promedio mensual del plan:
                                        </span>
                                        <div className="grid grid-cols-3 gap-2">
                                            {[
                                                { price: 49000, label: 'Básico' },
                                                { price: 65000, label: 'Recomendado' },
                                                { price: 89000, label: 'Premium' }
                                            ].map((opt) => {
                                                const active = planPrice === opt.price;
                                                return (
                                                    <button
                                                        key={opt.price}
                                                        type="button"
                                                        onClick={() => setPlanPrice(opt.price)}
                                                        className={`py-2.5 px-2 sm:px-3 rounded-xl text-xs transition tabular-nums cursor-pointer ${
                                                            active
                                                                ? 'border-2 border-[#6D28D9] bg-[#6D28D9]/10 font-bold text-[#6D28D9] shadow-2xs'
                                                                : 'border border-[#D9E2F2] bg-white font-semibold text-[#15213B] hover:border-[#6D28D9]'
                                                        }`}
                                                    >
                                                        {formatCOP(opt.price)}
                                                        <span
                                                            className={`block text-[10px] ${
                                                                active
                                                                    ? 'text-[#6D28D9] font-medium'
                                                                    : 'text-[#5C6B85] font-normal'
                                                            }`}
                                                        >
                                                            {opt.label}
                                                        </span>
                                                    </button>
                                                );
                                            })}
                                        </div>
                                    </div>

                                    <div className="p-4 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2] text-xs text-[#5C6B85] space-y-1.5">
                                        <div className="font-bold text-[#15213B] flex items-center gap-1.5">
                                            <Stethoscope className="w-4 h-4 text-[#0E7490] shrink-0" strokeWidth={2} />
                                            <span>Referencia operativa para tu clínica:</span>
                                        </div>
                                        <p className="text-xs leading-relaxed">
                                            Un plan promedio de $65.000/mes incluye 2 consultas preventivas al año, vacuna séxtuple, rabia y desparasitaciones periódicas. El tutor organiza su gasto y tu clínica mantiene al paciente activo todo el año.
                                        </p>
                                    </div>
                                </div>

                                {/* Resultados Estimados */}
                                <div className="bg-[#F4F7FC] p-6 sm:p-7 rounded-2xl border-2 border-[#6D28D9]/35 space-y-4 text-center shadow-xs">
                                    <div className="space-y-1">
                                        <span className="text-[11px] font-bold uppercase tracking-wider text-[#6D28D9]">
                                            Ingreso recurrente mensual estimado
                                        </span>
                                        <div className="text-4xl sm:text-5xl font-bold text-[#15213B] tabular-nums tracking-tight">
                                            {formatCOP(monthlyMRR)}
                                        </div>
                                        <span className="text-[11px] text-[#5C6B85] block pt-1">
                                            Proyección anual:{' '}
                                            <strong className="text-[#15213B] tabular-nums">
                                                {formatCOP(annualMRR)}
                                            </strong>{' '}
                                            COP / año
                                        </span>
                                    </div>

                                    <hr className="border-[#D9E2F2]" />

                                    <div className="grid grid-cols-2 gap-3 text-left">
                                        <div className="bg-white p-3 rounded-xl border border-[#D9E2F2]">
                                            <span className="text-[10px] uppercase font-bold text-[#5C6B85] block">
                                                A $5.000 / Mascota
                                            </span>
                                            <span className="text-sm sm:text-base font-bold text-[#15213B] tabular-nums">
                                                {formatCOP(perPetCost)}
                                                <span className="text-[10px] font-normal text-[#5C6B85]">/mes</span>
                                            </span>
                                        </div>
                                        <div className="bg-white p-3 rounded-xl border border-[#0E7490]/35 bg-[#0E7490]/5">
                                            <span className="text-[10px] uppercase font-bold text-[#0E7490] block">
                                                Plan {fixedTierName} (Fijo)
                                            </span>
                                            <span className="text-sm sm:text-base font-bold text-[#0E7490] tabular-nums">
                                                {formatCOP(fixedTierCost)}
                                                <span className="text-[10px] font-normal text-[#5C6B85]">/mes</span>
                                            </span>
                                        </div>
                                    </div>

                                    <div className="bg-[#ECFDF5] p-3 rounded-xl border border-[#0F9F9A]/30 text-xs font-bold text-[#065F46] flex justify-between items-center">
                                        <span>Margen que retiene tu clínica:</span>
                                        <span className="tabular-nums text-sm">
                                            ~{netMarginPct}% neto ({formatCOP(netMonthlyProfit)}/mes)
                                        </span>
                                    </div>

                                    <div className="pt-1">
                                        <button
                                            type="button"
                                            onClick={() => openRegisterModal('pro')}
                                            className="w-full py-3.5 bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-semibold text-sm rounded-xl shadow-md transition transform hover:-translate-y-0.5 active:translate-y-0 inline-flex items-center justify-center gap-2 cursor-pointer"
                                        >
                                            <span>Comenzar mi programa de bienestar</span>
                                            <ArrowRight className="w-4 h-4" strokeWidth={2} />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* =====================================================================
                    5. FLUJO INTERACTIVO EN 6 PASOS (Product Light + Midnight Frame)
                   ===================================================================== */}
                <section id="como-funciona" className="py-16 sm:py-24 bg-white border-b border-[#D9E2F2]">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center max-w-2xl mx-auto mb-14 space-y-2.5">
                            <span className="inline-block text-xs font-semibold uppercase tracking-wider text-[#0E7490] bg-[#0E7490]/10 px-3.5 py-1.5 rounded-full border border-[#0E7490]/25">
                                Flujo Operativo Simple
                            </span>
                            <h2 className="text-3xl sm:text-4xl font-bold text-[#15213B] tracking-tight mt-2">
                                Así funciona en tu clínica
                            </h2>
                            <p className="text-sm text-[#5C6B85]">
                                Selecciona cada etapa para explorar cómo opera el sistema en tiempo real.
                            </p>
                        </div>

                        <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                            {/* Lista de 6 etapas */}
                            <div className="lg:col-span-6 space-y-3">
                                {[
                                    {
                                        step: 1,
                                        title: 'Crea tus planes de salud',
                                        desc: 'Define consultas, vacunas, desparasitaciones y fija tu tarifa mensual con total libertad.'
                                    },
                                    {
                                        step: 2,
                                        title: 'Escaneo del Afiche QR en Mostrador',
                                        desc: 'El tutor escanea el afiche oficial en la sala de espera o entra a tu enlace web desde WhatsApp.'
                                    },
                                    {
                                        step: 3,
                                        title: 'Afiliación Digital en 2 Minutos',
                                        desc: 'El tutor registra a su mascota y adquiere su membresía sin papeles ni trámites manuales.'
                                    },
                                    {
                                        step: 4,
                                        title: 'Carnet Digital en el Celular',
                                        desc: 'Recibe al instante su carnet interactivo con código QR y barras para consultar sus saldos.'
                                    },
                                    {
                                        step: 5,
                                        title: 'Canje en Recepción en 3 Segundos',
                                        desc: 'La recepcionista digita la cédula o escanea el QR y descuenta cupos con auditoría.'
                                    },
                                    {
                                        step: 6,
                                        title: 'Renovaciones y Seguimiento con IA',
                                        desc: 'El sistema identifica vencimientos próximos y prepara recordatorios con supervisión humana.'
                                    }
                                ].map((item) => {
                                    const isActive = activeStep === item.step;
                                    return (
                                        <button
                                            key={item.step}
                                            type="button"
                                            onClick={() => {
                                                setActiveStep(item.step);
                                                setAutoPlaySteps(false);
                                            }}
                                            className={`w-full text-left p-4 rounded-2xl transition-all flex items-start gap-3.5 cursor-pointer ${
                                                isActive
                                                    ? 'border-2 border-[#6D28D9] bg-[#6D28D9]/5 shadow-xs'
                                                    : 'border border-[#D9E2F2] bg-white hover:border-[#6D28D9]/50'
                                            }`}
                                        >
                                            <span
                                                className={`w-10 h-10 rounded-xl flex items-center justify-center font-bold tabular-nums text-sm shrink-0 ${
                                                    isActive
                                                        ? 'bg-[#6D28D9] text-white'
                                                        : 'bg-[#F4F7FC] text-[#15213B]'
                                                }`}
                                            >
                                                0{item.step}
                                            </span>
                                            <div>
                                                <h4 className="text-sm font-bold text-[#15213B]">{item.title}</h4>
                                                <p className="text-xs text-[#5C6B85] mt-0.5">{item.desc}</p>
                                            </div>
                                        </button>
                                    );
                                })}
                            </div>

                            {/* Ventana de Simulación Interactiva (Midnight #080B20 + Deep Navy #111936) */}
                            <div className="lg:col-span-6">
                                <div className="relative bg-[#080B20] text-white rounded-2xl p-5 sm:p-7 shadow-2xl border border-[#1E2B58] min-h-[450px] flex flex-col justify-between overflow-hidden">
                                    <div className="absolute -top-20 -right-20 w-64 h-64 bg-[#A855F7]/15 rounded-full blur-3xl pointer-events-none" />

                                    {/* Barra Superior de Ventana */}
                                    <div className="flex items-center justify-between border-b border-[#1E2B58] pb-3 relative z-10">
                                        <div className="flex items-center gap-2">
                                            <span className="w-3 h-3 rounded-full bg-[#B91C1C]" />
                                            <span className="w-3 h-3 rounded-full bg-[#B45309]" />
                                            <span className="w-3 h-3 rounded-full bg-[#0F9F9A]" />
                                        </div>
                                        <div className="hidden sm:flex items-center gap-1.5 px-3 py-1 rounded-lg bg-[#111936] border border-[#1E2B58] text-[11px] text-slate-300">
                                            <Lock className="w-3 h-3 text-[#0F9F9A]" strokeWidth={2} />
                                            <span>avipetapp.com/v/vet-pet-patitas</span>
                                        </div>
                                        <span className="text-xs text-[#35DDF5] font-bold uppercase tracking-wider tabular-nums">
                                            Paso 0{activeStep}
                                        </span>
                                    </div>

                                    {/* Contenido Dinámico de cada Paso */}
                                    <div className="py-6 relative z-10 min-h-[280px] flex flex-col justify-center">
                                        {activeStep === 1 && (
                                            <div className="space-y-4">
                                                <div className="flex items-center justify-between">
                                                    <span className="text-xs text-[#35DDF5] font-bold flex items-center gap-1.5">
                                                        <Layers className="w-4 h-4" strokeWidth={2} />
                                                        <span>Constructor de Planes de Salud</span>
                                                    </span>
                                                    <span className="text-[10px] px-2.5 py-0.5 rounded-full bg-[#A855F7]/20 text-[#35DDF5] border border-[#A855F7]/30 font-semibold">
                                                        100 % Personalizable
                                                    </span>
                                                </div>
                                                <div className="bg-[#111936] p-4 rounded-2xl border border-[#1E2B58] space-y-3">
                                                    <div className="flex justify-between items-center">
                                                        <div>
                                                            <h5 className="font-bold text-white text-sm">
                                                                Plan Premium Patitas
                                                            </h5>
                                                            <span className="text-[11px] text-slate-400">
                                                                Caninos adultos (1 a 7 años)
                                                            </span>
                                                        </div>
                                                        <div className="text-right">
                                                            <span className="tabular-nums text-[#35DDF5] font-bold text-base">
                                                                $65.000
                                                            </span>
                                                            <span className="text-[10px] text-slate-400 block">
                                                                COP / mes
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div className="grid grid-cols-2 gap-2 text-[11px] text-slate-200">
                                                        {[
                                                            '2 Consultas / año',
                                                            '1 Vacuna Séxtuple',
                                                            '3 Desparasitaciones',
                                                            '2 Baños Preventivos'
                                                        ].map((b) => (
                                                            <div
                                                                key={b}
                                                                className="bg-[#080B20]/80 p-2.5 rounded-xl border border-[#1E2B58] flex items-center gap-1.5"
                                                            >
                                                                <CheckCircle2
                                                                    className="w-3.5 h-3.5 text-[#0F9F9A] shrink-0"
                                                                    strokeWidth={2}
                                                                />
                                                                <span>{b}</span>
                                                            </div>
                                                        ))}
                                                    </div>
                                                </div>
                                                <p className="text-xs text-slate-300">
                                                    Tú decides los beneficios, cupos anuales y tarifas mensuales de tu clínica.
                                                </p>
                                            </div>
                                        )}

                                        {activeStep === 2 && (
                                            <div className="space-y-4">
                                                <div className="flex items-center justify-between">
                                                    <span className="text-xs text-[#35DDF5] font-bold flex items-center gap-1.5">
                                                        <QrCode className="w-4 h-4" strokeWidth={2} />
                                                        <span>Afiche QR en Sala de Espera</span>
                                                    </span>
                                                    <span className="text-[10px] px-2.5 py-0.5 rounded-full bg-[#0F9F9A]/20 text-[#35DDF5] border border-[#0F9F9A]/40 font-semibold">
                                                        Auto-atención
                                                    </span>
                                                </div>
                                                <div className="bg-[#111936] p-4 rounded-2xl border border-[#1E2B58] flex items-center gap-4">
                                                    <div className="w-16 h-16 bg-white rounded-xl p-2 flex items-center justify-center shrink-0 border-2 border-[#35DDF5]">
                                                        <img
                                                            src="/brand/svg/avipetapp-isotipo-color.svg"
                                                            alt="QR"
                                                            className="w-full h-full object-contain"
                                                        />
                                                    </div>
                                                    <div className="space-y-1">
                                                        <h5 className="text-sm font-bold text-white">
                                                            El tutor escanea mientras espera su consulta
                                                        </h5>
                                                        <p className="text-xs text-[#35DDF5] font-semibold">
                                                            tu-clinica.avipetapp.com
                                                        </p>
                                                        <span className="inline-block text-[10px] bg-[#A855F7]/20 text-white px-2 py-0.5 rounded border border-[#A855F7]/30">
                                                            Sin filas ni carga operativa en recepción
                                                        </span>
                                                    </div>
                                                </div>
                                                <p className="text-xs text-slate-300">
                                                    El afiche tamaño Carta se genera listo para imprimir desde tu panel en 1 clic.
                                                </p>
                                            </div>
                                        )}

                                        {activeStep === 3 && (
                                            <div className="space-y-4">
                                                <div className="flex items-center justify-between">
                                                    <span className="text-xs text-[#35DDF5] font-bold flex items-center gap-1.5">
                                                        <Smartphone className="w-4 h-4" strokeWidth={2} />
                                                        <span>Formulario Express en Celular</span>
                                                    </span>
                                                    <span className="text-[10px] px-2.5 py-0.5 rounded-full bg-[#A855F7]/20 text-[#35DDF5] border border-[#A855F7]/30 font-semibold">
                                                        2 Minutos
                                                    </span>
                                                </div>
                                                <div className="bg-[#111936] p-4 rounded-2xl border border-[#1E2B58] space-y-2.5 text-xs">
                                                    <div className="flex justify-between border-b border-[#1E2B58] pb-2">
                                                        <span className="text-slate-400">Tutor:</span>
                                                        <span className="text-white font-bold">
                                                            Carlos Mendoza (CC 1.020.345.***)
                                                        </span>
                                                    </div>
                                                    <div className="flex justify-between border-b border-[#1E2B58] pb-2">
                                                        <span className="text-slate-400">Mascota:</span>
                                                        <span className="text-[#35DDF5] font-bold">
                                                            Luna · Golden Retriever
                                                        </span>
                                                    </div>
                                                    <div className="flex justify-between items-center pt-0.5">
                                                        <span className="text-slate-400">Recaudo directo:</span>
                                                        <span className="px-2.5 py-0.5 rounded bg-[#0F9F9A]/25 text-[#35DDF5] font-bold text-[11px]">
                                                            Bancolombia / Nequi / Bold
                                                        </span>
                                                    </div>
                                                </div>
                                                <p className="text-xs text-slate-300">
                                                    Sin formatos de papel: la afiliación queda registrada en tu clínica al instante.
                                                </p>
                                            </div>
                                        )}

                                        {activeStep === 4 && (
                                            <div className="space-y-4">
                                                <div className="flex items-center justify-between">
                                                    <span className="text-xs text-[#35DDF5] font-bold flex items-center gap-1.5">
                                                        <ShieldCheck className="w-4 h-4" strokeWidth={2} />
                                                        <span>Carnet Digital Oficial</span>
                                                    </span>
                                                    <span className="text-[10px] px-2.5 py-0.5 rounded-full bg-[#0F9F9A]/20 text-[#35DDF5] border border-[#0F9F9A]/40 font-semibold">
                                                        Directo al Celular
                                                    </span>
                                                </div>
                                                <div className="bg-gradient-to-br from-[#6D28D9] via-[#111936] to-[#080B20] p-4 rounded-2xl border border-[#A855F7]/40 space-y-3">
                                                    <div className="flex justify-between items-center">
                                                        <div className="flex items-center gap-2">
                                                            <PawPrint className="w-4 h-4 text-[#35DDF5]" strokeWidth={2} />
                                                            <span className="text-xs font-bold text-white">
                                                                LUNA · CARNET DE BIENESTAR
                                                            </span>
                                                        </div>
                                                        <span className="px-2 py-0.5 rounded-full bg-[#0F9F9A]/30 text-[#35DDF5] text-[10px] font-bold">
                                                            ACTIVA ✓
                                                        </span>
                                                    </div>
                                                    <div className="p-2 bg-white rounded-lg text-center tabular-nums text-[11px] text-[#15213B] font-bold tracking-widest">
                                                        ||| | |||| | ||| || VP-PAT-2026-0881
                                                    </div>
                                                    <div className="text-xs text-slate-300 flex justify-between">
                                                        <span>Coberturas disponibles:</span>
                                                        <span className="text-[#35DDF5] font-bold tabular-nums">
                                                            5 de 8 Servicios
                                                        </span>
                                                    </div>
                                                </div>
                                                <p className="text-xs text-slate-300">
                                                    El tutor consulta vigencias y saldos 24/7 desde su teléfono móvil.
                                                </p>
                                            </div>
                                        )}

                                        {activeStep === 5 && (
                                            <div className="space-y-4">
                                                <div className="flex items-center justify-between">
                                                    <span className="text-xs text-[#35DDF5] font-bold flex items-center gap-1.5">
                                                        <Zap className="w-4 h-4" strokeWidth={2} />
                                                        <span>Canje Rápido en Mostrador</span>
                                                    </span>
                                                    <span className="text-[10px] px-2.5 py-0.5 rounded-full bg-[#A855F7]/20 text-[#35DDF5] border border-[#A855F7]/30 font-semibold">
                                                        Auditoría 100 %
                                                    </span>
                                                </div>
                                                <div className="bg-[#111936] p-4 rounded-2xl border border-[#1E2B58] space-y-3">
                                                    <div className="flex justify-between items-center text-xs">
                                                        <span className="text-slate-400">Servicio Canjeado:</span>
                                                        <strong className="text-white">Vacuna Séxtuple Anual</strong>
                                                    </div>
                                                    <div className="p-3 rounded-xl bg-[#0F9F9A]/20 border border-[#0F9F9A]/50 flex items-center gap-2.5 text-xs text-white">
                                                        <CheckCircle2
                                                            className="w-4 h-4 text-[#35DDF5] shrink-0"
                                                            strokeWidth={2}
                                                        />
                                                        <span>
                                                            Cupo descontado. Auditoría registrada por Dra. Vicky Naranjo.
                                                        </span>
                                                    </div>
                                                </div>
                                                <p className="text-xs text-slate-300">
                                                    Búsqueda por cédula, nombre o código QR en 3 segundos en recepción.
                                                </p>
                                            </div>
                                        )}

                                        {activeStep === 6 && (
                                            <div className="space-y-4">
                                                <div className="flex items-center justify-between">
                                                    <span className="text-xs text-[#35DDF5] font-bold flex items-center gap-1.5">
                                                        <Sparkles className="w-4 h-4" strokeWidth={2} />
                                                        <span>Seguimiento Preventivo con IA</span>
                                                    </span>
                                                    <span className="text-[10px] px-2.5 py-0.5 rounded-full bg-[#A855F7]/25 text-[#E879F9] border border-[#A855F7]/40 font-semibold">
                                                        Supervisión Humana
                                                    </span>
                                                </div>
                                                <div className="bg-[#111936] p-4 rounded-2xl border border-[#A855F7]/40 space-y-2.5 text-xs">
                                                    <div className="text-[#35DDF5] font-bold flex items-center gap-1.5">
                                                        <Bell className="w-4 h-4" strokeWidth={2} />
                                                        <span>Aviso Preventivo de Renovación:</span>
                                                    </div>
                                                    <p className="text-slate-300 text-xs leading-relaxed">
                                                        El plan de Luna vence en 5 días. Mensaje de renovación por WhatsApp listo para revisión y envío en 1 clic.
                                                    </p>
                                                    <div className="pt-2 flex items-center justify-between text-[11px] tabular-nums text-[#35DDF5] border-t border-[#1E2B58]">
                                                        <span>Continuidad promedio anual:</span>
                                                        <strong>82 % de retención</strong>
                                                    </div>
                                                </div>
                                                <p className="text-xs text-slate-300">
                                                    La IA organiza alertas; tu equipo veterinario mantiene siempre el control.
                                                </p>
                                            </div>
                                        )}
                                    </div>

                                    {/* Barra de Progreso */}
                                    <div className="space-y-2 border-t border-[#1E2B58] pt-3 relative z-10">
                                        <div className="flex justify-between text-[11px] text-slate-400">
                                            <span>
                                                Etapa{' '}
                                                <strong className="text-white tabular-nums">{activeStep}</strong> de 6
                                            </span>
                                            <span className="text-[#35DDF5] text-[10px] font-semibold uppercase tracking-wider flex items-center gap-1.5">
                                                <span className="w-1.5 h-1.5 rounded-full bg-[#35DDF5] animate-ping" />
                                                <span>Simulación Interactiva</span>
                                            </span>
                                        </div>
                                        <div className="w-full bg-[#111936] h-1.5 rounded-full overflow-hidden">
                                            <div
                                                className="bg-gradient-to-r from-[#A855F7] to-[#35DDF5] h-1.5 transition-all duration-500"
                                                style={{ width: `${(activeStep / 6) * 100}%` }}
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* =====================================================================
                    6. DEMO INTERACTIVA: ESCÁNER QR DEL MOSTRADOR EN VIVO
                   ===================================================================== */}
                <section id="scanner-demo" className="py-16 sm:py-24 bg-[#F4F7FC] border-b border-[#D9E2F2]">
                    <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center max-w-2xl mx-auto mb-12 space-y-2.5">
                            <span className="inline-block text-xs font-semibold uppercase tracking-wider text-[#6D28D9] bg-[#6D28D9]/10 px-3.5 py-1.5 rounded-full border border-[#6D28D9]/20">
                                Experiencia en Sala de Espera
                            </span>
                            <h2 className="text-3xl sm:text-4xl font-bold text-[#15213B] tracking-tight mt-2">
                                Pruébalo: Simula el escaneo de recepción
                            </h2>
                            <p className="text-sm text-[#5C6B85]">
                                Mira lo que experimenta un tutor cuando escanea el afiche físico en el mostrador de tu clínica.
                            </p>
                        </div>

                        <div className="p-6 sm:p-10 rounded-2xl bg-white border border-[#D9E2F2] shadow-lg">
                            <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                                {/* Columna Izquierda: Afiche Físico en Acrílico */}
                                <div className="lg:col-span-5 space-y-5 text-center">
                                    <div className="relative inline-block w-full max-w-[280px] p-4 bg-gradient-to-b from-white via-[#F4F7FC] to-slate-100 rounded-2xl border-2 border-[#D9E2F2] shadow-lg mx-auto">
                                        <div className="w-16 h-1 bg-slate-300 rounded-full mx-auto mb-3" />

                                        <div className="absolute left-4 right-4 h-1 bg-gradient-to-r from-transparent via-[#35DDF5] to-transparent shadow-[0_0_12px_#35DDF5] animate-laser z-20 pointer-events-none opacity-80" />

                                        <div className="p-4 bg-white rounded-xl border border-[#D9E2F2] space-y-3 shadow-inner">
                                            <div className="flex items-center justify-center gap-2">
                                                <img
                                                    src="/brand/svg/avipetapp-icono-app.svg"
                                                    alt="Icono AviPetApp"
                                                    className="w-6 h-6 rounded-md object-contain"
                                                />
                                                <span className="text-xs font-bold text-[#15213B]">
                                                    Vet-Pet Patitas
                                                </span>
                                            </div>

                                            <div className="bg-[#6D28D9]/10 py-1 px-2 rounded-md border border-[#6D28D9]/20">
                                                <span className="text-[10px] font-bold uppercase tracking-wider text-[#6D28D9]">
                                                    Plan de Bienestar Mascotas
                                                </span>
                                            </div>

                                            {/* QR Vectorial con Colores Oficiales (#15213B / #6D28D9 / #0E7490) */}
                                            <div className="relative w-36 h-36 mx-auto bg-white p-2 rounded-xl border-2 border-[#15213B] shadow-2xs flex items-center justify-center">
                                                <svg
                                                    className="w-full h-full text-[#15213B]"
                                                    viewBox="0 0 100 100"
                                                    fill="currentColor"
                                                >
                                                    <rect x="0" y="0" width="28" height="28" rx="4" fill="#15213B" />
                                                    <rect x="4" y="4" width="20" height="20" rx="2" fill="#FFFFFF" />
                                                    <rect x="8" y="8" width="12" height="12" rx="1" fill="#6D28D9" />

                                                    <rect x="72" y="0" width="28" height="28" rx="4" fill="#15213B" />
                                                    <rect x="76" y="4" width="20" height="20" rx="2" fill="#FFFFFF" />
                                                    <rect x="80" y="8" width="12" height="12" rx="1" fill="#6D28D9" />

                                                    <rect x="0" y="72" width="28" height="28" rx="4" fill="#15213B" />
                                                    <rect x="4" y="76" width="20" height="20" rx="2" fill="#FFFFFF" />
                                                    <rect x="8" y="80" width="12" height="12" rx="1" fill="#6D28D9" />

                                                    <rect x="34" y="6" width="6" height="6" rx="1" />
                                                    <rect x="46" y="6" width="6" height="6" rx="1" />
                                                    <rect x="58" y="6" width="6" height="6" rx="1" />
                                                    <rect x="34" y="18" width="6" height="6" rx="1" fill="#0E7490" />
                                                    <rect x="46" y="18" width="6" height="6" rx="1" />
                                                    <rect x="58" y="18" width="6" height="6" rx="1" fill="#0E7490" />

                                                    <rect x="6" y="34" width="6" height="6" rx="1" />
                                                    <rect x="18" y="34" width="6" height="6" rx="1" />
                                                    <rect x="6" y="46" width="6" height="6" rx="1" />
                                                    <rect x="18" y="46" width="6" height="6" rx="1" />
                                                    <rect x="6" y="58" width="6" height="6" rx="1" />
                                                    <rect x="18" y="58" width="6" height="6" rx="1" />

                                                    <rect x="34" y="34" width="32" height="32" rx="6" fill="#15213B" />
                                                    <circle cx="50" cy="50" r="10" fill="#FFFFFF" />
                                                    <circle cx="50" cy="50" r="6" fill="#6D28D9" />

                                                    <rect x="72" y="34" width="6" height="6" rx="1" />
                                                    <rect x="84" y="34" width="6" height="6" rx="1" />
                                                    <rect x="72" y="46" width="6" height="6" rx="1" />
                                                    <rect x="84" y="46" width="6" height="6" rx="1" fill="#0E7490" />
                                                    <rect x="72" y="58" width="6" height="6" rx="1" />
                                                    <rect x="84" y="58" width="6" height="6" rx="1" />

                                                    <rect x="34" y="72" width="6" height="6" rx="1" />
                                                    <rect x="46" y="72" width="6" height="6" rx="1" />
                                                    <rect x="58" y="72" width="6" height="6" rx="1" />
                                                    <rect x="34" y="84" width="6" height="6" rx="1" fill="#0E7490" />
                                                    <rect x="46" y="84" width="6" height="6" rx="1" />
                                                    <rect x="58" y="84" width="6" height="6" rx="1" />
                                                </svg>
                                            </div>

                                            <p className="text-[10px] text-[#5C6B85] font-semibold leading-tight">
                                                Escanea con tu celular para afiliar a tu mascota desde{' '}
                                                <strong className="text-[#6D28D9] tabular-nums">$50.000/mes</strong>
                                            </p>
                                        </div>

                                        <div className="w-full h-3 bg-gradient-to-r from-slate-300 via-slate-200 to-slate-300 rounded-b-xl mt-1 shadow-2xs" />
                                    </div>

                                    <div>
                                        <button
                                            type="button"
                                            onClick={handleTriggerQrScan}
                                            className="px-6 py-3.5 rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-semibold text-xs shadow-md transition-all transform hover:scale-105 active:scale-95 inline-flex items-center justify-center gap-2 mx-auto cursor-pointer"
                                        >
                                            <Smartphone className="w-4 h-4" strokeWidth={2} />
                                            <span>
                                                {qrScanning
                                                    ? 'Escaneando código QR...'
                                                    : qrScanned
                                                    ? 'Reiniciar Simulación de Escaneo'
                                                    : 'Simular Escaneo con Celular'}
                                            </span>
                                        </button>
                                        <span className="text-[11px] text-[#5C6B85] block mt-1.5">
                                            Haz clic para ver la apertura del portal móvil en el teléfono
                                        </span>
                                    </div>
                                </div>

                                {/* Columna Derecha: Teléfono Interactivo (Mockup iPhone) */}
                                <div className="lg:col-span-7">
                                    <div className="relative max-w-sm mx-auto bg-[#080B20] rounded-[40px] p-3.5 shadow-2xl border-4 border-[#111936] ring-1 ring-[#1E2B58]">
                                        <div className="w-24 h-5 bg-black rounded-full mx-auto mb-2 flex items-center justify-center gap-2">
                                            <span className="w-2 h-2 rounded-full bg-[#6D28D9]/60" />
                                            <span className="w-1.5 h-1.5 rounded-full bg-slate-800" />
                                        </div>

                                        <div className="bg-white rounded-[30px] p-4 text-[#15213B] min-h-[430px] flex flex-col justify-between overflow-hidden relative shadow-inner">
                                            {!qrScanned ? (
                                                <div className="absolute inset-0 bg-[#080B20] text-white p-6 flex flex-col justify-between items-center text-center z-20">
                                                    <div className="w-full flex justify-between items-center text-[10px] text-slate-400 font-semibold">
                                                        <span>CÁMARA QR</span>
                                                        <span className="text-[#0F9F9A] flex items-center gap-1">
                                                            <span className="w-1.5 h-1.5 rounded-full bg-[#0F9F9A] animate-ping" />
                                                            <span>LISTO PARA ESCANEAR</span>
                                                        </span>
                                                    </div>

                                                    <div className="relative w-44 h-44 border-2 border-dashed border-[#35DDF5]/80 rounded-2xl flex items-center justify-center p-4">
                                                        <div className="absolute left-2 right-2 h-0.5 bg-[#35DDF5] shadow-[0_0_8px_#35DDF5] animate-laser" />
                                                        <span className="text-xs text-[#35DDF5] font-semibold">
                                                            {qrScanning
                                                                ? 'Detectando clínica...'
                                                                : 'Apunta al afiche QR'}
                                                        </span>
                                                    </div>

                                                    <div className="space-y-2">
                                                        <button
                                                            type="button"
                                                            onClick={handleTriggerQrScan}
                                                            className="px-4 py-2 rounded-xl bg-[#35DDF5] text-[#080B20] font-semibold text-xs cursor-pointer"
                                                        >
                                                            Escanear ahora
                                                        </button>
                                                        <p className="text-[10px] text-slate-400">
                                                            Abre el portal de tu clínica en 1 segundo
                                                        </p>
                                                    </div>
                                                </div>
                                            ) : (
                                                <div className="space-y-3.5 my-auto">
                                                    <div className="flex items-center justify-between border-b border-[#D9E2F2] pb-2.5">
                                                        <div className="flex items-center gap-2">
                                                            <img
                                                                src="/brand/svg/avipetapp-icono-app.svg"
                                                                alt="Logo"
                                                                className="w-7 h-7 rounded-md object-contain"
                                                            />
                                                            <div>
                                                                <h4 className="text-xs font-bold text-[#15213B] leading-tight">
                                                                    Vet-Pet Patitas
                                                                </h4>
                                                                <span className="text-[10px] text-[#0F9F9A] font-semibold">
                                                                    ● Clínica Verificada
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <span className="px-2 py-0.5 rounded-full bg-[#6D28D9]/10 text-[#6D28D9] font-bold text-[10px]">
                                                            Portal Tutor
                                                        </span>
                                                    </div>

                                                    <div className="p-3.5 rounded-2xl bg-gradient-to-br from-[#080B20] to-[#111936] text-white shadow-md space-y-1.5 border border-[#1E2B58]">
                                                        <div className="flex justify-between items-center">
                                                            <span className="text-[10px] font-bold uppercase tracking-wider text-[#A855F7]">
                                                                Plan Seleccionado
                                                            </span>
                                                            <span className="px-1.5 py-0.5 rounded bg-white/15 text-white text-[9px] font-bold">
                                                                Recomendado
                                                            </span>
                                                        </div>
                                                        <div className="text-base font-bold">Plan Premium Patitas</div>
                                                        <div className="text-xs font-bold text-[#35DDF5] tabular-nums">
                                                            $65.000 COP / mes
                                                        </div>
                                                    </div>

                                                    <div className="p-3 bg-[#F4F7FC] rounded-2xl border border-[#D9E2F2] space-y-2 text-xs">
                                                        <div className="text-[10px] font-bold text-[#15213B] uppercase">
                                                            Datos de la mascota:
                                                        </div>
                                                        <div className="flex items-center justify-between text-[11px] bg-white p-2 rounded-lg border border-[#D9E2F2]">
                                                            <span className="text-[#5C6B85]">Mascota:</span>
                                                            <strong className="text-[#15213B]">
                                                                Luna (Golden Retriever)
                                                            </strong>
                                                        </div>
                                                        <div className="flex items-center justify-between text-[11px] bg-white p-2 rounded-lg border border-[#D9E2F2]">
                                                            <span className="text-[#5C6B85]">Medio de pago:</span>
                                                            <span className="text-[#6D28D9] font-bold">
                                                                Bancolombia / Nequi
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <a
                                                        href="/v/vet-pet-patitas"
                                                        target="_blank"
                                                        rel="noreferrer"
                                                        className="w-full py-2.5 rounded-xl bg-[#0F9F9A] hover:bg-[#0E7490] text-white font-semibold text-xs shadow-md transition flex items-center justify-center gap-1.5"
                                                    >
                                                        <CheckCircle2 className="w-4 h-4" strokeWidth={2} />
                                                        <span>Confirmar y Activar Carnet</span>
                                                    </a>
                                                </div>
                                            )}
                                        </div>

                                        <div className="w-28 h-1 bg-slate-700 rounded-full mx-auto mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* =====================================================================
                    7. ESTRATEGIA COMERCIAL PRÁCTICA (3 CANALES CON ICONOS 2PX)
                   ===================================================================== */}
                <section className="py-16 sm:py-20 bg-white border-b border-[#D9E2F2]">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center max-w-2xl mx-auto mb-12 space-y-2.5">
                            <span className="inline-block text-xs font-semibold uppercase tracking-wider text-[#0E7490] bg-[#0E7490]/10 px-3.5 py-1 rounded-full border border-[#0E7490]/25">
                                Estrategia Comercial Práctica
                            </span>
                            <h2 className="text-3xl sm:text-4xl font-bold text-[#15213B] tracking-tight mt-2">
                                Cómo ofrecerlo a tus clientes actuales
                            </h2>
                            <p className="text-sm text-[#5C6B85]">
                                Aprovecha las visitas diarias que ya recibe tu consultorio para construir recurrencia.
                            </p>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div className="p-6 rounded-2xl bg-white border border-[#D9E2F2] hover:border-[#6D28D9]/40 transition space-y-3 shadow-2xs">
                                <div className="w-11 h-11 rounded-xl bg-[#6D28D9]/10 text-[#6D28D9] flex items-center justify-center border border-[#6D28D9]/20">
                                    <Printer className="w-5 h-5" strokeWidth={2} />
                                </div>
                                <h3 className="text-base font-bold text-[#15213B]">1. Afiche en la Sala de Espera</h3>
                                <p className="text-xs text-[#5C6B85] leading-relaxed">
                                    El tutor espera su turno y ve el afiche en recepción:{' '}
                                    <em>"Organiza las vacunas y controles de tu mascota con nuestro Plan de Bienestar"</em>
                                    . Escanea con su celular y se afilia en 2 minutos.
                                </p>
                            </div>

                            <div className="p-6 rounded-2xl bg-white border border-[#D9E2F2] hover:border-[#0E7490]/40 transition space-y-3 shadow-2xs">
                                <div className="w-11 h-11 rounded-xl bg-[#0E7490]/10 text-[#0E7490] flex items-center justify-center border border-[#0E7490]/20">
                                    <Stethoscope className="w-5 h-5" strokeWidth={2} />
                                </div>
                                <h3 className="text-base font-bold text-[#15213B]">2. En el Momento de la Consulta</h3>
                                <p className="text-xs text-[#5C6B85] leading-relaxed">
                                    Al atender al paciente, el médico veterinario recomienda el plan preventivo mensual para mantener el esquema de vacunación y desparasitación al día durante todo el año.
                                </p>
                            </div>

                            <div className="p-6 rounded-2xl bg-white border border-[#D9E2F2] hover:border-[#0F9F9A]/40 transition space-y-3 shadow-2xs">
                                <div className="w-11 h-11 rounded-xl bg-[#0F9F9A]/10 text-[#0F9F9A] flex items-center justify-center border border-[#0F9F9A]/25">
                                    <MessageSquare className="w-5 h-5" strokeWidth={2} />
                                </div>
                                <h3 className="text-base font-bold text-[#15213B]">3. Enlace Directo por WhatsApp</h3>
                                <p className="text-xs text-[#5C6B85] leading-relaxed">
                                    Comparte el enlace de tu vitrina web con los clientes que ya confían en tu clínica. El tutor elige el plan desde su teléfono y recibe su carnet digital al instante.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                {/* =====================================================================
                    8. LO QUE TU VETERINARIA RECIBE (MÓDULOS E IA — ICONOGRAFÍA 2PX)
                   ===================================================================== */}
                <section id="recibes" className="py-20 sm:py-24 bg-[#F4F7FC] border-b border-[#D9E2F2]">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center max-w-3xl mx-auto mb-16 space-y-2.5">
                            <span className="inline-block text-xs font-semibold uppercase tracking-wider text-[#6D28D9] bg-[#6D28D9]/10 px-3.5 py-1 rounded-full border border-[#6D28D9]/20">
                                Módulos e Inteligencia
                            </span>
                            <h2 className="text-3xl sm:text-4xl font-bold text-[#15213B] tracking-tight mt-2">
                                Lo que tu veterinaria recibe desde el primer día
                            </h2>
                            <p className="text-sm sm:text-base text-[#5C6B85]">
                                Herramientas completas para organizar tus planes de salud y la atención en recepción.
                            </p>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div className="p-7 rounded-2xl bg-white border border-[#D9E2F2] space-y-3 shadow-2xs">
                                <div className="w-12 h-12 rounded-xl bg-[#6D28D9]/10 text-[#6D28D9] flex items-center justify-center border border-[#6D28D9]/20">
                                    <Globe className="w-6 h-6" strokeWidth={2} />
                                </div>
                                <h3 className="text-lg font-bold text-[#15213B]">Portal Web con tu Marca</h3>
                                <p className="text-xs text-[#5C6B85] leading-relaxed">
                                    Tu propia vitrina digital con tu logo y colores (ej:{' '}
                                    <code className="text-[#6D28D9] bg-[#6D28D9]/10 px-1.5 py-0.5 rounded font-semibold">
                                        avipetapp.com/v/tu-clinica
                                    </code>
                                    ). Tus clientes consultan planes y se afilian en línea.
                                </p>
                            </div>

                            <div className="p-7 rounded-2xl bg-white border border-[#D9E2F2] space-y-3 shadow-2xs">
                                <div className="w-12 h-12 rounded-xl bg-[#0E7490]/10 text-[#0E7490] flex items-center justify-center border border-[#0E7490]/20">
                                    <Printer className="w-6 h-6" strokeWidth={2} />
                                </div>
                                <h3 className="text-lg font-bold text-[#15213B]">Afiche de Mostrador con QR</h3>
                                <p className="text-xs text-[#5C6B85] leading-relaxed">
                                    Generado en tamaño Carta listo para imprimir en 1 clic. Colócalo en recepción para que los tutores en sala de espera conozcan tus planes desde su celular.
                                </p>
                            </div>

                            <div className="p-7 rounded-2xl bg-white border border-[#D9E2F2] space-y-3 shadow-2xs">
                                <div className="w-12 h-12 rounded-xl bg-[#0F9F9A]/10 text-[#0F9F9A] flex items-center justify-center border border-[#0F9F9A]/25">
                                    <QrCode className="w-6 h-6" strokeWidth={2} />
                                </div>
                                <h3 className="text-lg font-bold text-[#15213B]">Carnet Digital Oficial</h3>
                                <p className="text-xs text-[#5C6B85] leading-relaxed">
                                    Cada mascota recibe un carnet interactivo con código QR y barras en el celular del tutor. Muestra datos del paciente, vigencia y saldos disponibles.
                                </p>
                            </div>

                            <div className="p-7 rounded-2xl bg-white border border-[#D9E2F2] space-y-3 shadow-2xs">
                                <div className="w-12 h-12 rounded-xl bg-[#F4F7FC] text-[#15213B] flex items-center justify-center border border-[#D9E2F2]">
                                    <Zap className="w-6 h-6 text-[#6D28D9]" strokeWidth={2} />
                                </div>
                                <h3 className="text-lg font-bold text-[#15213B]">Mostrador de Canje en Vivo</h3>
                                <p className="text-xs text-[#5C6B85] leading-relaxed">
                                    Búsqueda instantánea por cédula, teléfono o lector QR. Tu recepcionista visualiza de inmediato a qué servicios tiene derecho la mascota y descuenta cupos con auditoría.
                                </p>
                            </div>

                            <div className="p-7 rounded-2xl lg:col-span-2 space-y-3 border-2 border-[#6D28D9]/35 bg-white shadow-xs">
                                <div className="flex items-center gap-3">
                                    <div className="w-12 h-12 rounded-xl bg-[#6D28D9] text-white flex items-center justify-center shadow-xs">
                                        <Bot className="w-6 h-6" strokeWidth={2} />
                                    </div>
                                    <div>
                                        <span className="text-[10px] font-bold uppercase tracking-wider text-[#6D28D9]">
                                            Inteligencia con Supervisión Humana
                                        </span>
                                        <h3 className="text-lg font-bold text-[#15213B]">
                                            Asistente de IA (AVI Intelligence)
                                        </h3>
                                    </div>
                                </div>
                                <p className="text-xs text-[#5C6B85] leading-relaxed">
                                    Organiza información operativa, identifica vencimientos próximos y sugiere recordatorios preventivos para que tu equipo veterinario tome mejores decisiones:
                                </p>
                                <div className="grid grid-cols-1 sm:grid-cols-3 gap-2.5 pt-1 text-xs font-medium">
                                    <div className="bg-[#F4F7FC] p-3 rounded-xl border border-[#D9E2F2] text-[#15213B] flex items-center gap-2">
                                        <Bell className="w-4 h-4 text-[#B45309] shrink-0" strokeWidth={2} />
                                        <span>"12 planes vencen en los próximos 7 días."</span>
                                    </div>
                                    <div className="bg-[#F4F7FC] p-3 rounded-xl border border-[#D9E2F2] text-[#15213B] flex items-center gap-2">
                                        <Stethoscope className="w-4 h-4 text-[#0E7490] shrink-0" strokeWidth={2} />
                                        <span>"8 clientes tienen chequeo preventivo disponible."</span>
                                    </div>
                                    <div className="bg-[#F4F7FC] p-3 rounded-xl border border-[#D9E2F2] text-[#15213B] flex items-center gap-2">
                                        <Syringe className="w-4 h-4 text-[#0F9F9A] shrink-0" strokeWidth={2} />
                                        <span>"5 mascotas tienen refuerzo de vacuna este mes."</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* =====================================================================
                    9. CARNET DIGITAL INTERACTIVO (EXPERIENCIA DEL TUTOR)
                   ===================================================================== */}
                <section id="carnet-interactivo" className="py-20 sm:py-24 bg-white border-b border-[#D9E2F2]">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                            <div className="lg:col-span-6 space-y-6">
                                <span className="inline-block text-xs font-semibold uppercase tracking-wider text-[#0E7490] bg-[#0E7490]/10 px-3.5 py-1.5 rounded-full border border-[#0E7490]/25">
                                    Experiencia del Tutor
                                </span>
                                <h2 className="text-3xl sm:text-4xl font-bold text-[#15213B] tracking-tight leading-tight">
                                    Tu cliente lleva su carnet interactivo en el celular
                                </h2>
                                <p className="text-sm sm:text-base text-[#5C6B85] leading-relaxed">
                                    Una experiencia móvil clara para el tutor de la mascota. Accede a su carnet digital, consulta los beneficios incluidos y conoce con exactitud qué servicios preventivos ya utilizó y cuáles tiene disponibles en tiempo real.
                                </p>

                                <div className="space-y-3 text-xs sm:text-sm text-[#15213B] font-medium">
                                    <div className="flex items-center gap-3 p-3 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2]">
                                        <CheckCircle2 className="w-5 h-5 text-[#0F9F9A] shrink-0" strokeWidth={2} />
                                        <span>
                                            <strong>Sin carnets de papel</strong> deteriorados o extraviados antes de la consulta.
                                        </span>
                                    </div>
                                    <div className="flex items-center gap-3 p-3 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2]">
                                        <CheckCircle2 className="w-5 h-5 text-[#0E7490] shrink-0" strokeWidth={2} />
                                        <span>
                                            <strong>Claridad total</strong> en saldos, fechas de vacunación y días de renovación.
                                        </span>
                                    </div>
                                    <div className="flex items-center gap-3 p-3 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2]">
                                        <CheckCircle2 className="w-5 h-5 text-[#6D28D9] shrink-0" strokeWidth={2} />
                                        <span>
                                            <strong>Fidelización continua</strong> con la identidad visual de tu clínica veterinaria.
                                        </span>
                                    </div>
                                </div>

                                <div className="pt-2 flex flex-wrap items-center gap-3">
                                    <a
                                        href="/v/vet-pet-patitas/carnet/VP-2026-0001"
                                        target="_blank"
                                        rel="noreferrer"
                                        className="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white text-xs sm:text-sm font-semibold shadow-md transition-all transform hover:-translate-y-0.5"
                                    >
                                        <span>Ver Carnet Real en Pantalla Completa</span>
                                        <ExternalLink className="w-4 h-4" strokeWidth={2} />
                                    </a>
                                    <button
                                        type="button"
                                        onClick={() => setVaccineRedeemed(!vaccineRedeemed)}
                                        className="inline-flex items-center gap-2 px-5 py-3.5 rounded-xl bg-[#F4F7FC] hover:bg-[#E2E8F0] text-[#15213B] text-xs sm:text-sm font-semibold border border-[#D9E2F2] transition cursor-pointer"
                                    >
                                        <Zap className="w-4 h-4 text-[#6D28D9]" strokeWidth={2} />
                                        <span>
                                            {vaccineRedeemed ? 'Restaurar Saldo de Vacuna' : 'Probar Canje de Vacuna'}
                                        </span>
                                    </button>
                                </div>
                            </div>

                            {/* Mockup iPhone con Carnet Digital VIP */}
                            <div className="lg:col-span-6 flex justify-center">
                                <div className="relative w-full max-w-[360px] bg-[#080B20] rounded-[44px] p-3.5 shadow-2xl border-4 border-[#111936] ring-1 ring-[#1E2B58]">
                                    <div className="w-28 h-5 bg-black rounded-full mx-auto mb-2 flex items-center justify-center gap-2">
                                        <span className="w-2 h-2 rounded-full bg-[#6D28D9]/60" />
                                        <span className="w-1.5 h-1.5 rounded-full bg-slate-800" />
                                    </div>

                                    <div className="bg-gradient-to-b from-[#080B20] via-[#111936] to-[#080B20] rounded-[32px] p-4 text-white min-h-[470px] flex flex-col justify-between overflow-hidden relative shadow-inner border border-[#1E2B58]">
                                        <div className="relative rounded-2xl p-4 bg-gradient-to-br from-[#6D28D9] via-[#111936] to-[#080B20] border border-[#A855F7]/40 shadow-xl space-y-3.5 overflow-hidden">
                                            <div className="flex items-center justify-between border-b border-white/15 pb-2.5">
                                                <div className="flex items-center gap-2">
                                                    <div className="w-7 h-7 rounded-lg bg-white/95 p-1 flex items-center justify-center">
                                                        <img
                                                            src="/brand/svg/avipetapp-icono-app.svg"
                                                            alt="Logo"
                                                            className="w-full h-full object-contain"
                                                        />
                                                    </div>
                                                    <div>
                                                        <span className="text-[11px] font-bold tracking-tight text-white block leading-tight">
                                                            Vet-Pet Patitas
                                                        </span>
                                                        <span className="text-[9px] font-medium text-[#35DDF5]">
                                                            Sede Principal · Cajicá
                                                        </span>
                                                    </div>
                                                </div>
                                                <span className="px-2 py-0.5 rounded-full bg-[#0F9F9A]/25 border border-[#0F9F9A]/50 text-[#35DDF5] text-[9px] font-bold uppercase">
                                                    ● Activa
                                                </span>
                                            </div>

                                            <div className="flex items-center gap-3">
                                                <div className="relative w-14 h-14 rounded-2xl bg-gradient-to-tr from-[#A855F7] to-[#35DDF5] p-0.5 shadow-md shrink-0">
                                                    <div className="w-full h-full rounded-[14px] bg-[#080B20] flex items-center justify-center">
                                                        <PawPrint className="w-7 h-7 text-[#35DDF5]" strokeWidth={2} />
                                                    </div>
                                                </div>
                                                <div className="space-y-0.5 min-w-0 flex-1">
                                                    <div className="flex items-center gap-1.5">
                                                        <h4 className="text-base font-bold text-white leading-tight">
                                                            Luna
                                                        </h4>
                                                        <span className="text-[10px] text-[#35DDF5] font-bold">
                                                            ★ Plan Activo
                                                        </span>
                                                    </div>
                                                    <p className="text-[11px] text-slate-200 font-medium truncate">
                                                        Golden Retriever · 2 años
                                                    </p>
                                                    <div className="text-[10px] tabular-nums text-[#35DDF5]">
                                                        ID: #VP-2026-0881
                                                    </div>
                                                </div>
                                            </div>

                                            <div className="grid grid-cols-2 gap-2 bg-black/30 p-2.5 rounded-xl border border-white/10 text-[10px]">
                                                <div>
                                                    <span className="text-slate-400 block text-[9px] uppercase">
                                                        Plan de Salud
                                                    </span>
                                                    <strong className="text-white font-bold truncate block">
                                                        Plan Premium
                                                    </strong>
                                                </div>
                                                <div>
                                                    <span className="text-slate-400 block text-[9px] uppercase">
                                                        Tutor Responsable
                                                    </span>
                                                    <span className="text-slate-200 font-medium truncate block">
                                                        Carlos Mendoza
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        {/* Coberturas del Carnet */}
                                        <div className="bg-[#080B20]/90 rounded-2xl p-3 border border-[#1E2B58] space-y-2 text-xs">
                                            <div className="flex justify-between items-center text-[10px] font-bold text-slate-300 uppercase tracking-wider">
                                                <span>Coberturas Incluidas</span>
                                                <span className="text-[#35DDF5] tabular-nums">
                                                    {vaccineRedeemed ? '6 de 8 Utilizados' : '5 de 8 Utilizados'}
                                                </span>
                                            </div>

                                            <div className="space-y-1.5">
                                                <div className="p-2 rounded-xl bg-[#111936] border border-[#1E2B58] flex justify-between items-center text-[11px]">
                                                    <div className="flex items-center gap-2">
                                                        <Stethoscope
                                                            className="w-3.5 h-3.5 text-[#35DDF5]"
                                                            strokeWidth={2}
                                                        />
                                                        <span className="text-slate-200 font-medium">
                                                            Consultas Médicas
                                                        </span>
                                                    </div>
                                                    <span className="px-2 py-0.5 rounded-md bg-[#0E7490]/40 border border-[#35DDF5]/30 text-[#35DDF5] text-[10px] tabular-nums font-bold">
                                                        2/2 Disp.
                                                    </span>
                                                </div>

                                                <div
                                                    className={`p-2 rounded-xl border flex justify-between items-center text-[11px] transition-all ${
                                                        vaccineRedeemed
                                                            ? 'bg-[#0F9F9A]/25 border-[#35DDF5]'
                                                            : 'bg-[#111936] border-[#1E2B58]'
                                                    }`}
                                                >
                                                    <div className="flex items-center gap-2">
                                                        <Syringe
                                                            className="w-3.5 h-3.5 text-[#A855F7]"
                                                            strokeWidth={2}
                                                        />
                                                        <span className="text-slate-200 font-medium">
                                                            Vacuna Séxtuple
                                                        </span>
                                                    </div>
                                                    <span className="px-2 py-0.5 rounded-md bg-[#0F9F9A]/30 border border-[#0F9F9A]/50 text-[#35DDF5] text-[10px] tabular-nums font-bold">
                                                        {vaccineRedeemed ? '¡Canjeada ahora! ✓' : '1/1 Disp.'}
                                                    </span>
                                                </div>

                                                <div className="p-2 rounded-xl bg-[#111936] border border-[#1E2B58] flex justify-between items-center text-[11px]">
                                                    <div className="flex items-center gap-2">
                                                        <ShieldCheck
                                                            className="w-3.5 h-3.5 text-[#0F9F9A]"
                                                            strokeWidth={2}
                                                        />
                                                        <span className="text-slate-200 font-medium">
                                                            Desparasitación
                                                        </span>
                                                    </div>
                                                    <span className="px-2 py-0.5 rounded-md bg-[#0E7490]/40 border border-[#35DDF5]/30 text-[#35DDF5] text-[10px] tabular-nums font-bold">
                                                        3/3 Disp.
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        {/* Código de Barras Vectorial */}
                                        <div className="p-2.5 bg-white rounded-xl text-center space-y-1 shadow-2xs">
                                            <div className="h-7 flex items-center justify-center gap-1 px-2">
                                                {[2, 1, 3, 1, 4, 1, 2, 4, 1, 3, 2, 1, 4, 2, 1, 3].map((w, idx) => (
                                                    <div
                                                        key={idx}
                                                        className="h-full bg-[#080B20]"
                                                        style={{ width: `${w * 2}px` }}
                                                    />
                                                ))}
                                            </div>
                                            <div className="text-[9px] tabular-nums font-bold text-[#15213B] tracking-widest">
                                                VP-PAT-2026-0881
                                            </div>
                                        </div>
                                    </div>

                                    <div className="w-28 h-1 bg-slate-700 rounded-full mx-auto mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* =====================================================================
                    10. AVI INTELLIGENCE: IA CON SUPERVISIÓN HUMANA (Pág. 4 Manual v1.1)
                   ===================================================================== */}
                <section id="inteligencia" className="py-20 bg-[#F4F7FC] border-b border-[#D9E2F2]">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center max-w-3xl mx-auto mb-14 space-y-2.5">
                            <span className="inline-block text-xs font-semibold uppercase tracking-wider text-[#6D28D9] bg-[#6D28D9]/10 px-3.5 py-1 rounded-full border border-[#6D28D9]/20">
                                IA Práctica con Supervisión Humana
                            </span>
                            <h2 className="text-3xl sm:text-4xl font-bold text-[#15213B] tracking-tight mt-2">
                                Tu asistente de IA organiza el seguimiento preventivo
                            </h2>
                            <p className="text-sm text-[#5C6B85]">
                                AVI Intelligence detecta oportunidades de renovación y chequeos pendientes para que tu equipo actúe a tiempo.
                            </p>
                        </div>

                        <div className="max-w-4xl mx-auto p-6 sm:p-8 rounded-2xl border-2 border-[#6D28D9]/35 bg-white space-y-6 shadow-md">
                            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-[#D9E2F2] pb-4">
                                <div className="flex items-center gap-3">
                                    <div className="w-10 h-10 rounded-xl bg-[#6D28D9] text-white flex items-center justify-center shadow-2xs">
                                        <Bot className="w-5 h-5" strokeWidth={2} />
                                    </div>
                                    <div>
                                        <h3 className="text-base font-bold text-[#15213B]">
                                            Simulación: Resumen operativo del día
                                        </h3>
                                        <p className="text-xs text-[#5C6B85]">
                                            Oportunidades de seguimiento detectadas hoy
                                        </p>
                                    </div>
                                </div>
                                <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#6D28D9]/10 text-[#6D28D9] text-xs font-bold tabular-nums">
                                    <span className="w-2 h-2 rounded-full bg-[#6D28D9] animate-pulse" />
                                    <span>3 Sugerencias Operativas</span>
                                </span>
                            </div>

                            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                                {[
                                    {
                                        key: 'renew',
                                        badge: 'Pendiente',
                                        badgeClass: 'bg-[#FEF3C7] text-[#92400E]',
                                        period: 'Próximos 7 días',
                                        title: '12 planes por vencer este fin de mes.',
                                        btnLabel: 'Preparar WhatsApp con 1 Clic',
                                        toast: 'Recordatorio de renovación listo para revisión'
                                    },
                                    {
                                        key: 'checkup',
                                        badge: 'Preventivo',
                                        badgeClass: 'bg-[#0E7490]/15 text-[#0E7490]',
                                        period: 'Sin uso > 6 meses',
                                        title: '8 tutores no han usado su chequeo incluido.',
                                        btnLabel: 'Invitar a Chequeo Preventivo',
                                        toast: 'Invitación a chequeo preventivo preparada'
                                    },
                                    {
                                        key: 'vaccine',
                                        badge: 'Esquema',
                                        badgeClass: 'bg-[#ECFDF5] text-[#065F46]',
                                        period: 'Refuerzo Anual',
                                        title: '5 mascotas tienen refuerzo disponible.',
                                        btnLabel: 'Notificar por WhatsApp',
                                        toast: 'Aviso de refuerzo de vacunación preparado'
                                    }
                                ].map((card) => {
                                    const done = !!aiCompletedActions[card.key];
                                    return (
                                        <div
                                            key={card.key}
                                            className="bg-[#F4F7FC] p-4 rounded-xl border border-[#D9E2F2] space-y-3 flex flex-col justify-between"
                                        >
                                            <div className="space-y-2.5">
                                                <div className="flex items-center justify-between text-xs">
                                                    <span
                                                        className={`px-2 py-0.5 rounded-full font-semibold text-[11px] ${card.badgeClass}`}
                                                    >
                                                        {card.badge}
                                                    </span>
                                                    <span className="tabular-nums text-[11px] text-[#5C6B85]">
                                                        {card.period}
                                                    </span>
                                                </div>
                                                <p className="text-xs text-[#15213B] font-medium leading-snug">
                                                    {card.title}
                                                </p>
                                            </div>
                                            <button
                                                type="button"
                                                onClick={() => handleAiAction(card.key, card.toast)}
                                                className={`w-full py-2.5 px-3 rounded-xl text-xs font-semibold border transition text-center cursor-pointer flex items-center justify-center gap-1.5 ${
                                                    done
                                                        ? 'bg-[#ECFDF5] text-[#065F46] border-[#0F9F9A]/40'
                                                        : 'bg-white hover:bg-[#6D28D9] hover:text-white text-[#6D28D9] border-[#6D28D9]/30'
                                                }`}
                                            >
                                                {done ? (
                                                    <>
                                                        <CheckCircle2 className="w-3.5 h-3.5" strokeWidth={2} />
                                                        <span>Listo para enviar</span>
                                                    </>
                                                ) : (
                                                    <span>{card.btnLabel}</span>
                                                )}
                                            </button>
                                        </div>
                                    );
                                })}
                            </div>

                            {/* Aviso Obligatorio de IA del Manual de Marca (Pág. 4) */}
                            <div className="p-3.5 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2] flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-[11px] text-[#5C6B85]">
                                <span>
                                    <strong className="text-[#15213B]">Aviso de supervisión:</strong> Sugerencia generada con IA. Revísala antes de usarla en una decisión clínica.
                                </span>
                                <span className="text-[#6D28D9] font-semibold shrink-0">
                                    La IA organiza información; el criterio clínico es de tu equipo veterinario.
                                </span>
                            </div>

                            {aiToastMessage && (
                                <div className="p-3 rounded-xl bg-[#6D28D9] text-white text-xs font-semibold text-center flex items-center justify-center gap-2">
                                    <CheckCircle2 className="w-4 h-4 text-[#35DDF5]" strokeWidth={2} />
                                    <span>{aiToastMessage}</span>
                                </div>
                            )}
                        </div>
                    </div>
                </section>

                {/* =====================================================================
                    11. COMPARATIVA: DE VISITAS OCASIONALES A RELACIÓN TODO EL AÑO
                   ===================================================================== */}
                <section className="py-20 bg-white border-b border-[#D9E2F2]">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center max-w-3xl mx-auto mb-14 space-y-2.5">
                            <span className="inline-block text-xs font-semibold uppercase tracking-wider text-[#0E7490] bg-[#0E7490]/10 px-3.5 py-1 rounded-full border border-[#0E7490]/25">
                                Modelo de Atención
                            </span>
                            <h2 className="text-3xl sm:text-4xl font-bold text-[#15213B] tracking-tight mt-2">
                                De visitas ocasionales a una relación todo el año
                            </h2>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {/* Sin Planes */}
                            <div className="p-6 sm:p-8 rounded-2xl border border-[#B91C1C]/25 bg-[#FEE2E2]/25 space-y-4">
                                <div className="flex items-center gap-3">
                                    <div className="w-10 h-10 rounded-xl bg-[#FEE2E2] text-[#991B1B] flex items-center justify-center">
                                        <AlertCircle className="w-5 h-5" strokeWidth={2} />
                                    </div>
                                    <div>
                                        <h3 className="text-lg font-bold text-[#15213B]">Sin planes de salud</h3>
                                        <p className="text-xs text-[#991B1B] font-semibold">
                                            Ingresos dependientes de cada visita puntual
                                        </p>
                                    </div>
                                </div>
                                <ul className="space-y-3 text-xs sm:text-sm text-[#5C6B85]">
                                    {[
                                        'El cliente acude únicamente cuando se presenta una urgencia o enfermedad.',
                                        'Las visitas preventivas se pierden o se posponen indefinidamente.',
                                        'El seguimiento depende de llamadas o apuntes manuales en recepción.',
                                        'La relación con el tutor se interrumpe al terminar la consulta.'
                                    ].map((item) => (
                                        <li key={item} className="flex items-start gap-2.5">
                                            <X className="w-4 h-4 text-[#B91C1C] shrink-0 mt-0.5" strokeWidth={2} />
                                            <span>{item}</span>
                                        </li>
                                    ))}
                                </ul>
                            </div>

                            {/* Con AviPetApp */}
                            <div className="p-6 sm:p-8 rounded-2xl border-2 border-[#6D28D9] bg-[#F4F7FC] space-y-4 shadow-md">
                                <div className="flex items-center gap-3">
                                    <div className="w-10 h-10 rounded-xl bg-[#ECFDF5] text-[#065F46] flex items-center justify-center">
                                        <CheckCircle2 className="w-5 h-5 text-[#0F9F9A]" strokeWidth={2} />
                                    </div>
                                    <div>
                                        <h3 className="text-lg font-bold text-[#15213B]">Con AviPetApp</h3>
                                        <p className="text-xs text-[#6D28D9] font-bold">
                                            Un programa estructurado para acompañar al paciente todo el año
                                        </p>
                                    </div>
                                </div>
                                <ul className="space-y-3 text-xs sm:text-sm text-[#15213B]">
                                    {[
                                        'El tutor adquiere un plan preventivo con cobertura clara y programada.',
                                        'Los beneficios incluidos impulsan la asistencia a chequeos y vacunación.',
                                        'La clínica comunica renovaciones y vencimientos de forma oportuna.',
                                        'Fortaleces la confianza y la recurrencia en cada visita a tu veterinaria.'
                                    ].map((item) => (
                                        <li key={item} className="flex items-start gap-2.5">
                                            <CheckCircle2
                                                className="w-4 h-4 text-[#0F9F9A] shrink-0 mt-0.5"
                                                strokeWidth={2}
                                            />
                                            <span>{item}</span>
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>

                {/* =====================================================================
                    12. TRANSPARENCIA Y CUENTAS CLARAS (ICONOGRAFÍA 2PX)
                   ===================================================================== */}
                <section className="py-16 bg-[#F4F7FC] border-b border-[#D9E2F2]">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="p-8 sm:p-10 rounded-2xl bg-white border border-[#D9E2F2] space-y-6 shadow-2xs">
                            <div className="max-w-2xl space-y-2">
                                <span className="inline-block text-xs font-semibold uppercase tracking-wider text-[#0E7490] bg-[#0E7490]/10 px-3.5 py-1 rounded-full border border-[#0E7490]/25">
                                    Transparencia y Cuentas Claras
                                </span>
                                <h2 className="text-2xl sm:text-3xl font-bold text-[#15213B] tracking-tight">
                                    ¿Dónde ingresa el dinero de los planes?
                                </h2>
                                <p className="text-sm text-[#5C6B85]">
                                    El 100 % de los cobros de tus planes ingresa directamente a las cuentas bancarias o medios de pago de tu veterinaria.
                                </p>
                            </div>

                            <div className="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-2">
                                <div className="bg-[#F4F7FC] p-5 rounded-xl border border-[#D9E2F2] space-y-2.5">
                                    <div className="w-10 h-10 rounded-xl bg-[#0E7490]/10 text-[#0E7490] flex items-center justify-center">
                                        <Building2 className="w-5 h-5" strokeWidth={2} />
                                    </div>
                                    <h4 className="text-sm font-bold text-[#15213B]">Tus Medios de Pago Habituales</h4>
                                    <p className="text-xs text-[#5C6B85] leading-relaxed">
                                        Cobra por Bancolombia, Nequi, Daviplata, datáfono o pasarelas en línea como Bold y Wompi.
                                    </p>
                                </div>

                                <div className="bg-[#F4F7FC] p-5 rounded-xl border border-[#D9E2F2] space-y-2.5">
                                    <div className="w-10 h-10 rounded-xl bg-[#6D28D9]/10 text-[#6D28D9] flex items-center justify-center">
                                        <Ban className="w-5 h-5" strokeWidth={2} />
                                    </div>
                                    <h4 className="text-sm font-bold text-[#15213B]">Cero Comisión por Venta</h4>
                                    <p className="text-xs text-[#5C6B85] leading-relaxed">
                                        AviPetApp no retiene tu dinero ni cobra porcentajes sobre tus ingresos. Solo pagas $5.000 por mascota activa o una suscripción mensual fija.
                                    </p>
                                </div>

                                <div className="bg-[#F4F7FC] p-5 rounded-xl border border-[#D9E2F2] space-y-2.5">
                                    <div className="w-10 h-10 rounded-xl bg-[#0F9F9A]/10 text-[#0F9F9A] flex items-center justify-center">
                                        <Lock className="w-5 h-5" strokeWidth={2} />
                                    </div>
                                    <h4 className="text-sm font-bold text-[#15213B]">Tus Datos son de tu Clínica</h4>
                                    <p className="text-xs text-[#5C6B85] leading-relaxed">
                                        Tu base de datos de tutores y mascotas es 100 % privada e intransferible, protegida con arquitectura multi-tenant aislada.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* =====================================================================
                    13. PRECIOS TRANSPARENTES (PLAN PROFESIONAL DESTACADO EN #6D28D9)
                   ===================================================================== */}
                <section id="precios" className="py-20 sm:py-24 bg-white border-b border-[#D9E2F2]">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center max-w-3xl mx-auto mb-14 space-y-3">
                            <span className="inline-block text-xs font-semibold uppercase tracking-wider text-[#6D28D9] bg-[#6D28D9]/10 px-3.5 py-1 rounded-full border border-[#6D28D9]/20">
                                Precios Flexibles y Transparentes
                            </span>
                            <h2 className="text-3xl sm:text-4xl font-bold text-[#15213B] tracking-tight mt-2">
                                Prueba gratuita de 15 días
                            </h2>
                            <p className="text-sm sm:text-base text-[#5C6B85]">
                                Sin tarjeta de crédito requerida. Luego tú decides: paquetes prepago desde $50.000 COP (10 mascotas) o tarifa plana mensual anticipada:
                            </p>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">
                            {/* 1. Por Mascota (Prepago) */}
                            <div className="p-6 sm:p-7 rounded-2xl flex flex-col justify-between bg-[#F4F7FC] border-2 border-[#0E7490]/40 shadow-2xs">
                                <div className="space-y-4">
                                    <span className="inline-block px-2.5 py-0.5 rounded-full bg-[#0E7490]/15 text-[#0E7490] text-[10px] font-bold uppercase tracking-wider">
                                        Cero Riesgo · Prepago
                                    </span>
                                    <h3 className="text-xl font-bold text-[#15213B]">Por Mascota</h3>
                                    <div className="flex items-baseline gap-1">
                                        <span className="text-3xl sm:text-4xl font-bold text-[#0E7490] tabular-nums">
                                            $5.000
                                        </span>
                                        <span className="text-[#5C6B85] text-xs font-semibold">COP / mascota</span>
                                    </div>
                                    <div className="text-[11px] font-bold text-[#0E7490] bg-white px-2.5 py-1.5 rounded-lg border border-[#0E7490]/25">
                                        Paquetes prepago desde 10 mascotas = $50.000 COP
                                    </div>
                                    <p className="text-xs text-[#5C6B85] leading-relaxed">
                                        Sin deudas a mes vencido. Recargas cupos prepago a medida que tu clínica afilia mascotas.
                                    </p>
                                    <hr className="border-[#D9E2F2]" />
                                    <ul className="space-y-2 text-xs text-[#15213B] font-medium">
                                        {[
                                            'Paquete de 10 mascotas = $50.000 mes',
                                            'Recaudas ~$650.000 y pagas solo $50.000 (92 % margen)',
                                            'Con 20+ mascotas pasas a Starter ($99k) y ahorras',
                                            'Mes anticipado: cero cartera ni sorpresas',
                                            'Portal web propio con tu marca',
                                            'Afiche de mostrador con QR oficial',
                                            'Carnet digital para tutores y mostrador'
                                        ].map((feat) => (
                                            <li key={feat} className="flex items-start gap-2">
                                                <CheckCircle2
                                                    className="w-4 h-4 text-[#0F9F9A] shrink-0 mt-0.5"
                                                    strokeWidth={2}
                                                />
                                                <span>{feat}</span>
                                            </li>
                                        ))}
                                    </ul>
                                </div>
                                <button
                                    type="button"
                                    onClick={() => openRegisterModal('pay_per_pet')}
                                    className="mt-6 w-full py-3 text-center rounded-xl bg-white hover:bg-[#0E7490] hover:text-white text-[#0E7490] font-semibold text-xs border border-[#0E7490]/40 transition cursor-pointer"
                                >
                                    Elegir Paquete 10 Mascotas ($50.000)
                                </button>
                            </div>

                            {/* 2. Starter */}
                            <div className="p-6 sm:p-7 rounded-2xl flex flex-col justify-between bg-white border border-[#D9E2F2] shadow-2xs">
                                <div className="space-y-4">
                                    <span className="inline-block px-2.5 py-0.5 rounded-full bg-[#F4F7FC] text-[#5C6B85] text-[10px] font-bold uppercase tracking-wider border border-[#D9E2F2]">
                                        Consultorios
                                    </span>
                                    <h3 className="text-xl font-bold text-[#15213B]">Starter</h3>
                                    <div className="flex items-baseline gap-1">
                                        <span className="text-3xl sm:text-4xl font-bold text-[#15213B] tabular-nums">
                                            $99.000
                                        </span>
                                        <span className="text-[#5C6B85] text-xs">COP / mes anticipado</span>
                                    </div>
                                    <p className="text-xs text-[#5C6B85] leading-relaxed">
                                        Hasta 60 mascotas activas*. Te sale a solo{' '}
                                        <strong>$1.650 por mascota</strong>.
                                    </p>
                                    <hr className="border-[#D9E2F2]" />
                                    <ul className="space-y-2 text-xs text-[#15213B] font-medium">
                                        {[
                                            'Ahorro de hasta el 67 % frente a $5.000/mascota',
                                            'Mes anticipado sin permanencia forzosa',
                                            'Portal web propio con tu marca',
                                            'Afiche de mostrador con QR oficial',
                                            '1 Usuario para recepción',
                                            'Mostrador de canje en vivo',
                                            'Soporte por WhatsApp'
                                        ].map((feat) => (
                                            <li key={feat} className="flex items-start gap-2">
                                                <CheckCircle2
                                                    className="w-4 h-4 text-[#0F9F9A] shrink-0 mt-0.5"
                                                    strokeWidth={2}
                                                />
                                                <span>{feat}</span>
                                            </li>
                                        ))}
                                    </ul>
                                </div>
                                <button
                                    type="button"
                                    onClick={() => openRegisterModal('starter')}
                                    className="mt-6 w-full py-3 text-center rounded-xl bg-white hover:bg-[#F4F7FC] text-[#15213B] font-semibold text-xs border border-[#D9E2F2] transition cursor-pointer"
                                >
                                    Elegir Starter
                                </button>
                            </div>

                            {/* 3. Profesional (Más Elegido en #6D28D9) */}
                            <div className="p-6 sm:p-7 rounded-2xl flex flex-col justify-between border-2 border-[#6D28D9] shadow-xl relative transform lg:-translate-y-2 bg-white">
                                <div className="absolute -top-3 left-1/2 -translate-x-1/2 px-3.5 py-0.5 rounded-full bg-[#6D28D9] text-white font-bold text-[10px] uppercase tracking-wider shadow-2xs">
                                    MÁS ELEGIDO
                                </div>
                                <div className="space-y-4">
                                    <span className="inline-block px-2.5 py-0.5 rounded-full bg-[#6D28D9]/10 text-[#6D28D9] text-[10px] font-bold uppercase tracking-wider">
                                        En Crecimiento
                                    </span>
                                    <h3 className="text-xl font-bold text-[#15213B]">Profesional</h3>
                                    <div className="flex items-baseline gap-1">
                                        <span className="text-3xl sm:text-4xl font-bold text-[#6D28D9] tabular-nums">
                                            $229.000
                                        </span>
                                        <span className="text-[#5C6B85] text-xs">COP / mes</span>
                                    </div>
                                    <p className="text-xs text-[#5C6B85] leading-relaxed">
                                        Hasta 250 mascotas activas*. Te sale a menos de{' '}
                                        <strong>$916 por mascota</strong>.
                                    </p>
                                    <hr className="border-[#D9E2F2]" />
                                    <ul className="space-y-2 text-xs text-[#15213B] font-medium">
                                        {[
                                            'Todo lo del plan Starter',
                                            'Usuarios ilimitados para tu equipo',
                                            'AVI Intelligence: Seguimiento preventivo',
                                            'Reportes de facturación recurrente',
                                            'Soporte prioritario'
                                        ].map((feat) => (
                                            <li key={feat} className="flex items-start gap-2">
                                                <CheckCircle2
                                                    className="w-4 h-4 text-[#6D28D9] shrink-0 mt-0.5"
                                                    strokeWidth={2}
                                                />
                                                <span>{feat}</span>
                                            </li>
                                        ))}
                                    </ul>
                                </div>
                                <button
                                    type="button"
                                    onClick={() => openRegisterModal('pro')}
                                    className="mt-6 w-full py-3.5 text-center rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-semibold text-xs shadow-md transition inline-flex items-center justify-center gap-1.5 cursor-pointer"
                                >
                                    <span>Comenzar Prueba Gratuita</span>
                                    <ArrowRight className="w-3.5 h-3.5" strokeWidth={2} />
                                </button>
                            </div>

                            {/* 4. Enterprise */}
                            <div className="p-6 sm:p-7 rounded-2xl flex flex-col justify-between bg-white border border-[#D9E2F2] shadow-2xs">
                                <div className="space-y-4">
                                    <span className="inline-block px-2.5 py-0.5 rounded-full bg-[#F4F7FC] text-[#5C6B85] text-[10px] font-bold uppercase tracking-wider border border-[#D9E2F2]">
                                        Redes y Hospitales
                                    </span>
                                    <h3 className="text-xl font-bold text-[#15213B]">Enterprise</h3>
                                    <div className="flex items-baseline gap-1">
                                        <span className="text-3xl sm:text-4xl font-bold text-[#15213B] tabular-nums">
                                            $489.000
                                        </span>
                                        <span className="text-[#5C6B85] text-xs">COP / mes</span>
                                    </div>
                                    <p className="text-xs text-[#5C6B85] leading-relaxed">
                                        Mascotas ilimitadas + Multi-sucursal + Dominio Propio.
                                    </p>
                                    <hr className="border-[#D9E2F2]" />
                                    <ul className="space-y-2 text-xs text-[#15213B] font-medium">
                                        {[
                                            'Mascotas y afiliados ilimitados',
                                            'Múltiples sedes y sucursales',
                                            'Dominio propio (tuclinica.com)',
                                            'Integración WhatsApp y soporte dedicado'
                                        ].map((feat) => (
                                            <li key={feat} className="flex items-start gap-2">
                                                <CheckCircle2
                                                    className="w-4 h-4 text-[#0F9F9A] shrink-0 mt-0.5"
                                                    strokeWidth={2}
                                                />
                                                <span>{feat}</span>
                                            </li>
                                        ))}
                                    </ul>
                                </div>
                                <a
                                    href="https://wa.me/573235813942?text=Hola%20AviPetApp,%20me%20interesa%20el%20plan%20Enterprise"
                                    target="_blank"
                                    rel="noreferrer"
                                    className="mt-6 w-full py-3 text-center rounded-xl bg-white hover:bg-[#F4F7FC] text-[#15213B] font-semibold text-xs border border-[#D9E2F2] transition"
                                >
                                    Contactar Asesor
                                </a>
                            </div>
                        </div>

                        <div className="mt-8 text-center text-xs text-[#5C6B85] max-w-2xl mx-auto">
                            * <strong className="text-[#15213B]">Modalidad Prepago / Mes Anticipado:</strong> Todo paquete o mensualidad se activa por mes anticipado. Así nunca tienes cobros sorpresa a mes vencido ni permanencias obligatorias.
                        </div>
                    </div>
                </section>

                {/* =====================================================================
                    14. PREGUNTAS FRECUENTES (ACORDEÓN REACT)
                   ===================================================================== */}
                <section id="faq" className="py-16 sm:py-20 bg-[#F4F7FC] border-b border-[#D9E2F2]">
                    <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                        <div className="text-center space-y-2.5">
                            <span className="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-[#0E7490] bg-[#0E7490]/10 px-3.5 py-1 rounded-full border border-[#0E7490]/25">
                                <HelpCircle className="w-3.5 h-3.5" strokeWidth={2} />
                                <span>Dudas Frecuentes</span>
                            </span>
                            <h2 className="text-3xl font-bold text-[#15213B] tracking-tight mt-2">
                                Preguntas Frecuentes
                            </h2>
                        </div>

                        <div className="space-y-3">
                            {FAQ_ITEMS.map((faq, idx) => {
                                const isOpen = openFaqIndex === idx;
                                return (
                                    <div
                                        key={faq.question}
                                        className="rounded-2xl bg-white border border-[#D9E2F2] overflow-hidden shadow-2xs"
                                    >
                                        <button
                                            type="button"
                                            onClick={() => setOpenFaqIndex(isOpen ? null : idx)}
                                            className="w-full p-5 text-left font-bold text-sm sm:text-base text-[#15213B] flex justify-between items-center gap-4 hover:bg-[#F4F7FC]/60 transition cursor-pointer"
                                        >
                                            <span>{faq.question}</span>
                                            <ChevronDown
                                                className={`w-5 h-5 text-[#6D28D9] shrink-0 transition-transform duration-200 ${
                                                    isOpen ? 'rotate-180' : ''
                                                }`}
                                                strokeWidth={2}
                                            />
                                        </button>
                                        {isOpen && (
                                            <div className="px-5 pb-5 text-xs sm:text-sm text-[#5C6B85] leading-relaxed border-t border-[#F4F7FC] pt-3">
                                                {faq.answer}
                                            </div>
                                        )}
                                    </div>
                                );
                            })}
                        </div>
                    </div>
                </section>

                {/* =====================================================================
                    15. CTA FINAL SOBRE SUPERFICIE DE MARCA (#080B20)
                   ===================================================================== */}
                <section className="py-20 bg-white">
                    <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="p-8 sm:p-14 rounded-2xl bg-[#080B20] border border-[#1E2B58] text-center space-y-6 shadow-2xl relative overflow-hidden">
                            <div className="absolute -top-24 -right-24 w-72 h-72 bg-[#A855F7]/20 rounded-full blur-3xl pointer-events-none" />
                            <div className="absolute -bottom-24 -left-24 w-72 h-72 bg-[#35DDF5]/15 rounded-full blur-3xl pointer-events-none" />

                            <div className="relative z-10 inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#111936] border border-[#A855F7]/35 text-[#35DDF5] text-xs font-semibold">
                                <Sparkles className="w-3.5 h-3.5" strokeWidth={2} />
                                <span>Software con IA para veterinarias</span>
                            </div>
                            <h2 className="relative z-10 text-3xl sm:text-5xl font-bold text-white tracking-tight">
                                Crea el programa de salud preventiva de tu veterinaria hoy mismo
                            </h2>
                            <p className="relative z-10 text-sm sm:text-lg text-slate-300 max-w-2xl mx-auto font-normal">
                                Más inteligencia. Más bienestar. Más futuro.
                            </p>
                            <div className="relative z-10 pt-2 flex flex-col sm:flex-row items-center justify-center gap-4">
                                <button
                                    type="button"
                                    onClick={() => openRegisterModal('pro')}
                                    className="w-full sm:w-auto px-8 py-4 rounded-xl bg-[#35DDF5] hover:bg-[#22d3ee] text-[#080B20] font-semibold text-base shadow-lg transition transform hover:-translate-y-0.5 active:translate-y-0 inline-flex items-center justify-center gap-2 cursor-pointer"
                                >
                                    <span>Solicitar una demo (15 días gratis)</span>
                                    <ArrowRight className="w-4 h-4" strokeWidth={2} />
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

            {/* =====================================================================
                FOOTER OFICIAL AVIPETAPP (Midnight #080B20 · Manual Maestro v1.1)
               ===================================================================== */}
            <footer className="border-t border-[#111936] py-14 bg-[#080B20] text-slate-300 text-xs">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-8 pb-8 border-b border-[#111936]">
                        <div className="space-y-3.5">
                            <div className="flex flex-col items-start gap-1.5">
                                <img
                                    src="/brand/svg/avipetapp-horizontal-fondo-oscuro.svg"
                                    alt="AviPetApp"
                                    className="h-9 w-auto min-w-[148px] object-contain"
                                />
                                <span className="text-[11px] font-semibold text-[#35DDF5] tracking-wide">
                                    Software con IA para veterinarias
                                </span>
                            </div>
                            <p className="text-xs text-slate-300 leading-relaxed">
                                AviPetApp ayuda a tu clínica a gestionar planes de salud para mascotas, organizar la relación con tus clientes y aprovechar herramientas inteligentes desde una sola plataforma.
                            </p>
                            <p className="text-xs font-semibold text-[#A855F7]">
                                Más inteligencia. Más bienestar. Más futuro.
                            </p>
                        </div>

                        <div className="space-y-2.5">
                            <h4 className="font-bold text-white uppercase tracking-wider text-[11px]">
                                Guías de Rentabilidad Veterinaria
                            </h4>
                            <ul className="space-y-2 font-medium text-slate-300">
                                <li>
                                    <a
                                        href="/blog/planes-de-salud-preventiva-veterinaria-ingresos-recurrentes"
                                        className="hover:text-[#35DDF5] transition-colors inline-flex items-center gap-1.5"
                                    >
                                        <ArrowRight className="w-3.5 h-3.5 text-[#35DDF5]" strokeWidth={2} />
                                        <span>Cómo crear Planes de Salud Preventiva en tu Veterinaria</span>
                                    </a>
                                </li>
                                <li>
                                    <a
                                        href="/blog/fidelizacion-clientes-veterinaria-retencion-mascotas"
                                        className="hover:text-[#35DDF5] transition-colors inline-flex items-center gap-1.5"
                                    >
                                        <ArrowRight className="w-3.5 h-3.5 text-[#35DDF5]" strokeWidth={2} />
                                        <span>Retención de Clientes en Clínica Veterinaria (+80 % Fidelidad)</span>
                                    </a>
                                </li>
                                <li>
                                    <a
                                        href="/blog/como-calcular-precio-planes-salud-veterinaria-plantilla-costos"
                                        className="hover:text-[#35DDF5] transition-colors inline-flex items-center gap-1.5"
                                    >
                                        <ArrowRight className="w-3.5 h-3.5 text-[#35DDF5]" strokeWidth={2} />
                                        <span>Calculadora y Plantilla de Costos para Planes de Mascotas</span>
                                    </a>
                                </li>
                                <li>
                                    <a
                                        href="/blog/mejores-software-veterinarios-colombia-comparativa-2026"
                                        className="hover:text-[#35DDF5] transition-colors inline-flex items-center gap-1.5"
                                    >
                                        <ArrowRight className="w-3.5 h-3.5 text-[#35DDF5]" strokeWidth={2} />
                                        <span>Comparativa de Software Veterinario en Colombia (2026)</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div className="space-y-2.5">
                            <h4 className="font-bold text-white uppercase tracking-wider text-[11px]">
                                Accesos Directos
                            </h4>
                            <ul className="space-y-2.5 font-semibold text-slate-300">
                                <li>
                                    <a
                                        href="/blog"
                                        className="hover:text-[#35DDF5] transition-colors inline-flex items-center gap-2"
                                    >
                                        <BookOpen className="w-4 h-4 text-[#35DDF5]" strokeWidth={2} />
                                        <span>Blog para Clínicas Veterinarias</span>
                                    </a>
                                </li>
                                <li>
                                    <a
                                        href="/admin"
                                        className="hover:text-[#35DDF5] transition-colors inline-flex items-center gap-2"
                                    >
                                        <Lock className="w-4 h-4 text-[#A855F7]" strokeWidth={2} />
                                        <span>Iniciar Sesión / Acceso Mostrador</span>
                                    </a>
                                </li>
                                <li>
                                    <a
                                        href="https://vet-pet-patitas.avipetapp.com/"
                                        target="_blank"
                                        rel="noreferrer"
                                        className="hover:text-[#35DDF5] transition-colors inline-flex items-center gap-2"
                                    >
                                        <PawPrint className="w-4 h-4 text-[#0F9F9A]" strokeWidth={2} />
                                        <span>Ver Clínica Piloto (Vet-Pet Patitas Cajicá)</span>
                                    </a>
                                </li>
                                <li>
                                    <a
                                        href="https://wa.me/573235813942"
                                        target="_blank"
                                        rel="noreferrer"
                                        className="hover:text-[#35DDF5] transition-colors inline-flex items-center gap-2"
                                    >
                                        <MessageSquare className="w-4 h-4 text-[#35DDF5]" strokeWidth={2} />
                                        <span>Soporte WhatsApp (+57 323 581 3942)</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div className="flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px] text-slate-400">
                        <p>
                            © {new Date().getFullYear()} AviPetApp · Software con IA para veterinarias · Todos los derechos reservados · Colombia & LATAM.
                        </p>
                        <a href="/sitemap.xml" className="hover:text-[#35DDF5] transition-colors">
                            Mapa del Sitio (XML)
                        </a>
                    </div>
                </div>
            </footer>

            {/* =====================================================================
                MODAL DE REGISTRO EXPRESS CLÍNICO (REACT + POST /registro-clinica)
               ===================================================================== */}
            {registerModalOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-[#080B20]/70 backdrop-blur-xs p-3 sm:p-4 overflow-y-auto">
                    <div className="relative w-full max-w-lg bg-white border border-[#D9E2F2] rounded-2xl p-5 sm:p-8 shadow-2xl space-y-5 text-[#15213B] max-h-[92vh] overflow-y-auto my-auto">
                        <button
                            type="button"
                            onClick={() => setRegisterModalOpen(false)}
                            className="absolute top-4 right-4 text-[#5C6B85] hover:text-[#15213B] p-2 rounded-xl bg-[#F4F7FC] hover:bg-[#E2E8F0] transition cursor-pointer"
                            aria-label="Cerrar modal"
                        >
                            <X className="w-5 h-5" strokeWidth={2} />
                        </button>

                        {!registrationSuccess ? (
                            <>
                                <div className="space-y-1.5">
                                    <div className="flex flex-wrap items-center gap-2">
                                        <span className="inline-flex items-center px-2.5 py-0.5 rounded-full bg-[#ECFDF5] text-[#065F46] text-[10px] font-bold uppercase border border-[#0F9F9A]/30">
                                            Prueba Gratuita de 15 Días
                                        </span>
                                        <span
                                            className={`inline-flex items-center px-2.5 py-0.5 rounded-full border text-[10px] font-bold ${tierBadgeMeta[selectedTier].className}`}
                                        >
                                            {tierBadgeMeta[selectedTier].label}
                                        </span>
                                    </div>
                                    <h3 className="text-2xl font-bold text-[#15213B] tracking-tight">
                                        Crea tu Clínica Veterinaria
                                    </h3>
                                    <p className="text-xs text-[#5C6B85] font-medium">
                                        Empieza a configurar tus planes y tu afiche QR en 60 segundos.
                                    </p>
                                </div>

                                <form onSubmit={handleOnboardingSubmit} className="space-y-4">
                                    <div>
                                        <label className="block text-xs font-bold text-[#15213B] uppercase mb-1">
                                            Nombre de tu Veterinaria <span className="text-[#6D28D9]">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            required
                                            value={clinicName}
                                            onChange={(e) => setClinicName(e.target.value)}
                                            placeholder="Ej. Veterinaria San Roque"
                                            className="w-full bg-[#F4F7FC] border border-[#D9E2F2] rounded-xl px-4 py-2.5 text-sm text-[#15213B] focus:outline-hidden focus:border-[#6D28D9] focus:bg-white transition placeholder:text-[#5C6B85]/60"
                                        />
                                        <p className="text-[11px] text-[#5C6B85] mt-1">
                                            Tu web será:{' '}
                                            <span className="text-[#6D28D9] font-bold">
                                                avipetapp.com/v/{slugPreview}
                                            </span>
                                        </p>
                                    </div>

                                    <div>
                                        <label className="block text-xs font-bold text-[#15213B] uppercase mb-1 flex items-center justify-between">
                                            <span>Nombre de la Doctora / Médico Veterinario</span>
                                            <span className="text-[10px] text-[#5C6B85] lowercase font-medium">
                                                (opcional)
                                            </span>
                                        </label>
                                        <input
                                            type="text"
                                            value={doctorName}
                                            onChange={(e) => setDoctorName(e.target.value)}
                                            placeholder="Ej. Dra. Vicky Naranjo o Dr. Carlos Méndez"
                                            className="w-full bg-[#F4F7FC] border border-[#D9E2F2] rounded-xl px-4 py-2.5 text-sm text-[#15213B] focus:outline-hidden focus:border-[#6D28D9] focus:bg-white transition placeholder:text-[#5C6B85]/60"
                                        />
                                    </div>

                                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div>
                                            <label className="block text-xs font-bold text-[#15213B] uppercase mb-1">
                                                Ciudad <span className="text-[#6D28D9]">*</span>
                                            </label>
                                            <input
                                                type="text"
                                                required
                                                value={city}
                                                onChange={(e) => setCity(e.target.value)}
                                                placeholder="Ej. Bogotá / Medellín"
                                                className="w-full bg-[#F4F7FC] border border-[#D9E2F2] rounded-xl px-4 py-2.5 text-sm text-[#15213B] focus:outline-hidden focus:border-[#6D28D9] focus:bg-white transition placeholder:text-[#5C6B85]/60"
                                            />
                                        </div>
                                        <div>
                                            <label className="block text-xs font-bold text-[#15213B] uppercase mb-1">
                                                WhatsApp de Contacto <span className="text-[#6D28D9]">*</span>
                                            </label>
                                            <input
                                                type="tel"
                                                required
                                                value={phone}
                                                onChange={(e) => setPhone(e.target.value)}
                                                placeholder="Ej. 3101234567"
                                                className="w-full bg-[#F4F7FC] border border-[#D9E2F2] rounded-xl px-4 py-2.5 text-sm text-[#15213B] focus:outline-hidden focus:border-[#6D28D9] focus:bg-white transition placeholder:text-[#5C6B85]/60"
                                            />
                                        </div>
                                    </div>

                                    <div>
                                        <label className="block text-xs font-bold text-[#15213B] uppercase mb-1">
                                            Correo Electrónico (Tu usuario) <span className="text-[#6D28D9]">*</span>
                                        </label>
                                        <input
                                            type="email"
                                            required
                                            value={email}
                                            onChange={(e) => setEmail(e.target.value)}
                                            placeholder="doctor@tuclinica.com"
                                            className="w-full bg-[#F4F7FC] border border-[#D9E2F2] rounded-xl px-4 py-2.5 text-sm text-[#15213B] focus:outline-hidden focus:border-[#6D28D9] focus:bg-white transition placeholder:text-[#5C6B85]/60"
                                        />
                                    </div>

                                    <div>
                                        <div className="flex items-center justify-between mb-1">
                                            <label className="block text-xs font-bold text-[#15213B] uppercase">
                                                Contraseña <span className="text-[#6D28D9]">*</span>
                                            </label>
                                            <button
                                                type="button"
                                                onClick={() => setShowPassword(!showPassword)}
                                                className="text-[11px] font-semibold text-[#6D28D9] hover:text-[#5B21B6] transition flex items-center gap-1 cursor-pointer"
                                            >
                                                {showPassword ? (
                                                    <>
                                                        <EyeOff className="w-3.5 h-3.5" strokeWidth={2} />
                                                        <span>Ocultar</span>
                                                    </>
                                                ) : (
                                                    <>
                                                        <Eye className="w-3.5 h-3.5" strokeWidth={2} />
                                                        <span>Ver contraseña</span>
                                                    </>
                                                )}
                                            </button>
                                        </div>
                                        <input
                                            type={showPassword ? 'text' : 'password'}
                                            required
                                            minLength={6}
                                            value={password}
                                            onChange={(e) => setPassword(e.target.value)}
                                            placeholder="Mínimo 6 caracteres"
                                            className="w-full bg-[#F4F7FC] border border-[#D9E2F2] rounded-xl px-4 py-2.5 text-sm text-[#15213B] focus:outline-hidden focus:border-[#6D28D9] focus:bg-white transition placeholder:text-[#5C6B85]/60"
                                        />
                                    </div>

                                    <div className="p-3 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2] text-[#5C6B85] text-[11px] flex items-start gap-2">
                                        <MessageSquare
                                            className="w-4 h-4 text-[#6D28D9] shrink-0 mt-0.5"
                                            strokeWidth={2}
                                        />
                                        <p className="leading-relaxed">
                                            ¿Necesitas soporte con tu cuenta? Escríbenos a WhatsApp al{' '}
                                            <a
                                                href="https://wa.me/573235813942?text=Hola,%20necesito%20ayuda%20con%20mi%20cuenta%20de%20AviPetApp"
                                                target="_blank"
                                                rel="noreferrer"
                                                className="font-bold text-[#6D28D9] hover:underline"
                                            >
                                                3235813942
                                            </a>{' '}
                                            o a{' '}
                                            <a
                                                href="mailto:contacto@avipetapp.com"
                                                className="font-bold text-[#6D28D9] hover:underline"
                                            >
                                                contacto@avipetapp.com
                                            </a>
                                            .
                                        </p>
                                    </div>

                                    {formError && (
                                        <div className="p-3 rounded-xl bg-[#FEE2E2] border border-[#B91C1C]/30 text-[#991B1B] text-xs font-medium flex items-center gap-2">
                                            <AlertCircle className="w-4 h-4 shrink-0" strokeWidth={2} />
                                            <span>{formError}</span>
                                        </div>
                                    )}

                                    <button
                                        type="submit"
                                        disabled={submitting}
                                        className="w-full py-3.5 rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] disabled:opacity-60 text-white font-semibold text-sm shadow-md transition flex items-center justify-center gap-2 cursor-pointer"
                                    >
                                        <span>
                                            {submitting
                                                ? 'Creando tu plataforma y afiche QR...'
                                                : 'Activar mi Clínica Gratis'}
                                        </span>
                                        {!submitting && <ArrowRight className="w-4 h-4" strokeWidth={2} />}
                                    </button>

                                    <p className="text-[10px] text-center text-[#5C6B85]">
                                        Sin tarjeta de crédito requerida. Acceso inmediato.
                                    </p>
                                </form>
                            </>
                        ) : (
                            <div className="space-y-4">
                                <div className="text-center space-y-1.5 pt-2">
                                    <div className="w-14 h-14 mx-auto rounded-2xl bg-[#ECFDF5] text-[#065F46] flex items-center justify-center border border-[#0F9F9A]/30">
                                        <CheckCircle2 className="w-8 h-8 text-[#0F9F9A]" strokeWidth={2} />
                                    </div>
                                    <h3 className="text-xl font-bold text-[#15213B]">
                                        ¡Tu Clínica fue Creada con Éxito!
                                    </h3>
                                    <p className="text-xs text-[#5C6B85] font-medium">
                                        Tus 15 días de prueba gratis ya están activos. Guarda tus accesos oficiales:
                                    </p>
                                </div>

                                <div className="bg-[#F4F7FC] border border-[#D9E2F2] rounded-2xl p-3.5 space-y-3">
                                    <div className="space-y-1">
                                        <span className="text-[10px] font-bold uppercase tracking-wider text-[#5C6B85]">
                                            Vitrina Pública para tus Tutores:
                                        </span>
                                        <div className="flex items-center justify-between bg-white border border-[#D9E2F2] rounded-xl px-3 py-2">
                                            <span className="text-xs font-bold text-[#6D28D9] truncate">
                                                {registrationSuccess.storefrontUrl}
                                            </span>
                                            <button
                                                type="button"
                                                onClick={() =>
                                                    handleCopyUrl(
                                                        registrationSuccess.storefrontUrl,
                                                        'storefront'
                                                    )
                                                }
                                                className="text-[10px] font-bold bg-[#6D28D9]/10 text-[#6D28D9] px-2.5 py-1 rounded-lg hover:bg-[#6D28D9]/20 transition shrink-0 ml-2 inline-flex items-center gap-1 cursor-pointer"
                                            >
                                                {copiedField === 'storefront' ? (
                                                    <>
                                                        <Check className="w-3 h-3" strokeWidth={2} />
                                                        <span>Copiado</span>
                                                    </>
                                                ) : (
                                                    <>
                                                        <Copy className="w-3 h-3" strokeWidth={2} />
                                                        <span>Copiar</span>
                                                    </>
                                                )}
                                            </button>
                                        </div>
                                    </div>

                                    <div className="space-y-1">
                                        <span className="text-[10px] font-bold uppercase tracking-wider text-[#5C6B85]">
                                            Tu Panel Administrativo de Control:
                                        </span>
                                        <div className="flex items-center justify-between bg-white border border-[#D9E2F2] rounded-xl px-3 py-2">
                                            <span className="text-xs font-bold text-[#15213B] truncate">
                                                {registrationSuccess.adminUrl}
                                            </span>
                                            <button
                                                type="button"
                                                onClick={() =>
                                                    handleCopyUrl(registrationSuccess.adminUrl, 'admin')
                                                }
                                                className="text-[10px] font-bold bg-[#F4F7FC] text-[#15213B] px-2.5 py-1 rounded-lg hover:bg-[#E2E8F0] transition shrink-0 ml-2 inline-flex items-center gap-1 cursor-pointer"
                                            >
                                                {copiedField === 'admin' ? (
                                                    <>
                                                        <Check className="w-3 h-3" strokeWidth={2} />
                                                        <span>Copiado</span>
                                                    </>
                                                ) : (
                                                    <>
                                                        <Copy className="w-3 h-3" strokeWidth={2} />
                                                        <span>Copiar</span>
                                                    </>
                                                )}
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div className="space-y-2 pt-1">
                                    <a
                                        href={registrationSuccess.redirectUrl}
                                        className="w-full py-3.5 rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-semibold text-sm shadow-md transition flex items-center justify-center gap-2"
                                    >
                                        <span>Configurar mi Marca y Logotipo</span>
                                        <span className="text-white/80 text-xs font-normal tabular-nums">
                                            (entrando en {countdown}s...)
                                        </span>
                                    </a>
                                </div>
                            </div>
                        )}
                    </div>
                </div>
            )}
        </div>
    );
}
