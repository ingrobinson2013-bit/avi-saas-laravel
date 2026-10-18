import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import {
    ShieldCheck,
    Sparkles,
    Truck,
    CheckCircle2,
    XCircle,
    AlertTriangle,
    ShoppingBag,
    MessageCircle,
    ChevronDown,
    Star,
    FlaskConical,
    BadgeCheck,
    X,
    Check,
    Microscope,
    Leaf,
    ZoomIn,
    ChevronLeft,
    ChevronRight,
    Award,
    Clock,
    Lock,
    ArrowRight,
    PhoneCall,
    MapPin,
    User,
    Heart,
} from 'lucide-react';

interface BioLabProps {
    whatsappNumber?: string;
    canonicalUrl?: string;
    mainDomainUrl?: string;
    isSubdomain?: boolean;
}

type BundleId = '1_bolsa' | '2_bolsas' | '3_bolsas';

interface BundleOption {
    id: BundleId;
    tag?: string;
    tagStyle?: string;
    popular?: boolean;
    name: string;
    shortTitle: string;
    subtitle: string;
    bags: number;
    grams: string;
    price: number;
    formattedPrice: string;
    compareAtPrice: number;
    formattedCompareAt: string;
    savingsAmount: string;
    savingsText: string;
    unitPriceText: string;
    dailyCostText: string;
    durationText: string;
    recommendedFor: string;
    perks: string[];
}

const BUNDLES: BundleOption[] = [
    {
        id: '1_bolsa',
        tag: 'PRECIO DE LANZAMIENTO • AHORRAS $17.800',
        tagStyle: 'bg-[#0E8A9E] text-white',
        name: '1 Bolsa — Precio de Lanzamiento (250g)',
        shortTitle: '1 Bolsa (250g) — Tratamiento Inicial',
        subtitle: 'Tratamiento para 25 a 50 días según el peso',
        bags: 1,
        grams: '250g',
        price: 69900,
        formattedPrice: '$69.900',
        compareAtPrice: 87700,
        formattedCompareAt: '$87.700',
        savingsAmount: '$17.800 COP',
        savingsText: 'Ahorras $17.800 COP frente a tarros tradicionales de solo Omega 3',
        unitPriceText: '$69.900 c/u',
        dailyCostText: '$1.398 / día',
        durationText: '25 a 50 días',
        recommendedFor: 'Ideal para Gatos y Perros Pequeños (1 a 10 kg)',
        perks: ['🚚 Envío Gratis + Pago Contraentrega'],
    },
    {
        id: '2_bolsas',
        tag: '🔥 OFERTA DÚO CLÍNICO • EL MÁS VENDIDO',
        tagStyle: 'bg-gradient-to-r from-[#D97706] to-[#B45309] text-white',
        popular: true,
        name: 'Oferta Dúo Clínico (2 Bolsas - 500g)',
        shortTitle: '2 Bolsas (500g) — Oferta Dúo Clínico',
        subtitle: 'Recomendado para Perros Medianos/Grandes',
        bags: 2,
        grams: '500g',
        price: 124900,
        formattedPrice: '$124.900',
        compareAtPrice: 175400,
        formattedCompareAt: '$175.400',
        savingsAmount: '$50.500 COP',
        savingsText: 'Ahorras $14.900 COP adicionales — Te sale a $62.450 c/u',
        unitPriceText: '$62.450 c/u',
        dailyCostText: '$1.249 / día',
        durationText: '50 a 100 días',
        recommendedFor: 'Recomendado para Perros Medianos/Grandes (11 a 25 kg)',
        perks: [
            '🚚 Envío Gratis Prioritario + Pago Contraentrega',
            '🎁 Bono Gratis: Guía Digital de Nutrición Clínica Dermo-Digestiva',
        ],
    },
    {
        id: '3_bolsas',
        tag: '🏆 TRATAMIENTO COMPLETO 90 DÍAS • MÁXIMO AHORRO',
        tagStyle: 'bg-[#311457] text-[#FDE68A]',
        name: 'Tratamiento Completo 90 Días (3 Bolsas - 750g)',
        shortTitle: '3 Bolsas (750g) — Tratamiento 90 Días',
        subtitle: 'Regeneración inmunológica, cutánea y digestiva total',
        bags: 3,
        grams: '750g',
        price: 169900,
        formattedPrice: '$169.900',
        compareAtPrice: 263100,
        formattedCompareAt: '$263.100',
        savingsAmount: '$93.200 COP',
        savingsText: 'Ahorras $39.800 COP adicionales — Te sale a $56.633 c/u',
        unitPriceText: '$56.633 c/u',
        dailyCostText: '$1.132 / día',
        durationText: '75 a 150 días',
        recommendedFor: 'Ideal para Perros Grandes (+25 kg), 2+ mascotas o dermatitis crónica',
        perks: [
            '🚚 Envío Gratis VIP + Pago Contraentrega',
            '🎁 Bono Gratis: Guía Clínica + Asesoría Nutricional por WhatsApp',
        ],
    },
];

const GALLERY_IMAGES = [
    {
        src: '/images/biolab/empaque-frente-250g.jpg',
        alt: 'AVIPET BioLab® — Dermo & Gut Superboost (250g) Empaque Oficial',
        tag: 'Empaque 250g',
        caption: 'Empaque Doypack Zipper con barrera anti-oxidación (Contenido Neto: 250g).',
    },
    {
        src: '/images/biolab/banner-panoramico.jpg',
        alt: 'AVIPET BioLab® — Nutrición Clínica Dermo-Digestiva para Perros y Gatos',
        tag: 'Perros y Gatos',
        caption: 'Fórmula biotecnológica 3 en 1 para perros y gatos: Piel, Digestión y Aliento.',
    },
    {
        src: '/images/biolab/banner-hero-oficial.jpg',
        alt: 'AVIPET BioLab® — Resultados visibles desde la 1.ª semana',
        tag: 'Beneficios 3 en 1',
        caption: 'Alivia picazón, hongos y caída de pelo con Micro-Proteína Novel + Ácido Láurico.',
    },
    {
        src: '/images/biolab/logo-avipet-biolab.jpg',
        alt: 'Sello Oficial AviPet BioLab® — Nutrición Clínica Dermo-Digestiva',
        tag: 'Sello BioLab®',
        caption: 'Sello de Garantía Clínica AviPet BioLab® — 100% Hipoalergénico.',
    },
];

const COLOMBIAN_DEPARTMENTS = [
    'Bogotá D.C.',
    'Antioquia',
    'Cundinamarca',
    'Valle del Cauca',
    'Atlántico',
    'Santander',
    'Bolívar',
    'Risaralda',
    'Caldas',
    'Quindío',
    'Tolima',
    'Huila',
    'Meta',
    'Boyacá',
    'Nariño',
    'Cauca',
    'Norte de Santander',
    'Magdalena',
    'Cesar',
    'Córdoba',
    'Sucre',
    'Casanare',
    'Otro Departamento',
];

const COMPARISON_ROWS = [
    {
        feature: 'Base de Proteína Novel Hipoalergénica (Hermetia illucens)',
        biolab: 'Sí (39% - 40% Proteína Pura)',
        biolabStatus: 'yes',
        others: 'No (Suelen usar harinas de relleno o sabor a pollo/hígado)',
        othersStatus: 'no',
    },
    {
        feature: 'Ácido Láurico Activo (Antihongos y Antibacteriano)',
        biolab: 'Sí (4.5% Garantizado)',
        biolabStatus: 'yes',
        others: 'No contiene',
        othersStatus: 'no',
    },
    {
        feature: 'Omega 3, 6 y 9 + Biotina Regeneradora',
        biolab: 'Sí (Semilla de linaza dorada + Levadura)',
        biolabStatus: 'yes',
        others: 'Sí (Suele ser su único ingrediente activo)',
        othersStatus: 'partial',
    },
    {
        feature: 'Complejo Prebiótico + Aliento Fresco (3 en 1)',
        biolab: 'Sí (Ahuyama, Levadura, Cúrcuma y Perejil)',
        biolabStatus: 'yes',
        others: 'No (Enfocados en una sola función)',
        othersStatus: 'no',
    },
    {
        feature: '100% Libre de Gluten, Pollo, Res y Soya',
        biolab: 'Garantizado',
        biolabStatus: 'yes',
        others: 'Muchos contienen trazas de cereales o subproductos',
        othersStatus: 'warn',
    },
    {
        feature: 'Empaque con Barrera Anti-Oxidación (Doypack Zipper)',
        biolab: 'Cierre hermético que extrae el aire',
        biolabStatus: 'yes',
        others: 'Tarro de boca ancha que oxida los Omegas al abrirlo',
        othersStatus: 'no',
    },
    {
        feature: 'Precio por 250 gramos',
        biolab: '$69.900 COP (Envío Gratis)',
        biolabStatus: 'price',
        others: '$87.700 COP o más',
        othersStatus: 'no',
    },
];

const NUTRITIONAL_TABLE = [
    {
        nutrient: 'Proteína Cruda (Mín.)',
        value: '40.0%',
        detail: 'Micro-proteína purificada de Hermetia illucens (péptidos hipoalergénicos)',
    },
    {
        nutrient: 'Grasa Cruda (Mín.)',
        value: '10.0% (Ácido Láurico: 4.5% | Omega 3 y 6: 3.7%)',
        detail: 'Ácido Láurico C12:0 antimicrobiano + ácidos grasos esenciales de linaza dorada',
    },
    {
        nutrient: 'Fibra Prebiótica (Máx.)',
        value: '9.8% (Quitina prebiótica + Pectina)',
        detail: 'Restaura la microbiota intestinal y compacta las heces desde la 1.ª semana',
    },
    {
        nutrient: 'Calcio (Mín.)',
        value: '2.4%',
        detail: 'Mineral biodisponible natural para soporte óseo y metabólico',
    },
    {
        nutrient: 'Humedad (Máx.)',
        value: '7.5%',
        detail: 'Baja humedad que preserva la frescura y estabilidad en empaque Doypack Zipper',
    },
];

const DOSAGE_ROWS = [
    {
        id: 'small',
        icon: '🐱🐶',
        group: 'Gatos y Perros Pequeños (1 a 10 kg)',
        dose: '1 cuchara dosificadora rasa (5g) al día',
        duration: '50 días de tratamiento',
        recommendedBundle: '1_bolsa' as BundleId,
        recommendedLabel: '1 Bolsa (250g)',
    },
    {
        id: 'medium',
        icon: '🐕',
        group: 'Perros Medianos (11 a 25 kg)',
        dose: '1 a 2 cucharas dosificadoras (5g a 10g) al día',
        duration: '25 a 50 días de tratamiento',
        recommendedBundle: '2_bolsas' as BundleId,
        recommendedLabel: 'Oferta Dúo (2 Bolsas)',
    },
    {
        id: 'large',
        icon: '🐕‍🦺',
        group: 'Perros Grandes (+25 kg)',
        dose: '2 cucharas dosificadoras (10g) al día',
        duration: '25 días de tratamiento',
        recommendedBundle: '3_bolsas' as BundleId,
        recommendedLabel: 'Kit 90 Días (3 Bolsas)',
    },
];

const FAQS = [
    {
        question: '¿En cuánto tiempo veré resultados en mi mascota?',
        answerParts: [
            {
                badge: 'Días 3 a 7',
                text: 'Notarás heces más firmes, menos gases y reducción del mal aliento gracias a la fibra prebiótica y la clorofila.',
            },
            {
                badge: 'Semanas 2 a 3',
                text: 'Disminución notable del enrojecimiento en piel, menor picazón y reducción del lamido de patas por el efecto del Ácido Láurico y la cúrcuma.',
            },
            {
                badge: 'Semana 4 en adelante',
                text: 'Frenado de la caída excesiva de pelo y crecimiento de pelaje nuevo, fuerte y brillante.',
            },
        ],
    },
    {
        question: '¿Sirve tanto para perros como para gatos?',
        answer: '¡Sí! Su perfil de aminoácidos esenciales y ácidos grasos está formulado para la fisiología digestiva y cutánea tanto de perros como de gatos de todas las razas y edades (a partir de los 3 meses de vida).',
    },
    {
        question: '¿Se lo puedo dar si mi perro toma medicamentos o come concentrado medicado?',
        answer: 'Totalmente. Al ser un suplemento nutricional 100% natural libre de alérgenos y fármacos químicos, actúa como coadyuvante perfecto junto a cualquier dieta veterinaria o tratamiento clínico sin generar interacciones.',
    },
    {
        question: '¿Cómo funciona el envío y el pago contraentrega?',
        answer: 'Despachamos a toda Colombia. Solo registras tus datos de entrega y pagas en efectivo o transferencia únicamente cuando el transportador te entregue el paquete en la puerta de tu casa.',
    },
];

const REVIEWS = [
    {
        name: 'Carolina Restrepo',
        city: 'Medellín, Antioquia',
        pet: 'Bruno • Bulldog Francés (13 kg)',
        kit: 'Oferta Dúo Clínico (2 Bolsas)',
        days: 'Resultados en 12 días',
        text: '“Bruno se lamía las patas todo el día hasta ponérselas rojas y olía fuerte a pesar de bañarlo con champú medicado. A la primera semana con Dermo & Gut Superboost las heces se pusieron duritas y a la segunda semana dejó de rascarse. Además le encanta el sabor sobre el concentrado.”',
    },
    {
        name: 'Andrés Felipe Vargas',
        city: 'Bogotá D.C.',
        pet: 'Luna • Golden Retriever (28 kg)',
        kit: 'Tratamiento 90 Días (3 Bolsas)',
        days: 'Resultados en 3 semanas',
        text: '“Había gastado muchísimo en tarros de Omega 3 que se ponían rancios. Este polvo en bolsa hermética huele súper natural, cero olor a pescado, le quitó el mal aliento a Luna y le frenó la caída de pelo impresionante. Pagué contraentrega en Cedritos súper rápido.”',
    },
    {
        name: 'Dra. Natalia Gómez, MVZ',
        city: 'Cali, Valle del Cauca',
        pet: 'Médica Veterinaria — Consulta Dermatológica',
        kit: 'Aliada Clínica BioLab®',
        days: 'Verificación Profesional',
        text: '“El gran error en pacientes atópicos es darles suplementos saborizados con hígado de pollo. La matriz de Hermetia illucens (40% proteína novel) combinada con 4.5% de Ácido Láurico y prebióticos hace que Dermo & Gut Superboost sea hoy mi primera elección coadyuvante.”',
    },
];

export default function DermoGutSuperboost({
    whatsappNumber = '573235813942',
    isSubdomain = true,
}: BioLabProps) {
    const [selectedBundleId, setSelectedBundleId] = useState<BundleId>('2_bolsas');
    const [activeImageIdx, setActiveImageIdx] = useState<number>(0);
    const [isZoomOpen, setIsZoomOpen] = useState<boolean>(false);
    const [openAccordion, setOpenAccordion] = useState<string>('composicion');
    const [openFaqIdx, setOpenFaqIdx] = useState<number>(0);
    const [selectedWeightGuide, setSelectedWeightGuide] = useState<string>('medium');
    const [isCheckoutModalOpen, setIsCheckoutModalOpen] = useState<boolean>(false);

    // Estado del formulario de Pedido Contraentrega (compartido entre el Formulario Rápido en Página y el Modal)
    const [customerName, setCustomerName] = useState('');
    const [customerPhone, setCustomerPhone] = useState('');
    const [department, setDepartment] = useState('Bogotá D.C.');
    const [city, setCity] = useState('');
    const [address, setAddress] = useState('');
    const [neighborhood, setNeighborhood] = useState('');
    const [petType, setPetType] = useState('Perro');
    const [petName, setPetName] = useState('');
    const [petWeight, setPetWeight] = useState('11 a 25 kg (Mediano)');
    const [paymentMethod, setPaymentMethod] = useState('Efectivo al recibir en casa');
    const [notes, setNotes] = useState('');
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [orderError, setOrderError] = useState<string | null>(null);
    const [orderSuccess, setOrderSuccess] = useState<{
        order_code: string;
        whatsapp_url: string;
        formatted_total: string;
        bundle_title: string;
    } | null>(null);

    const activeBundle = BUNDLES.find((b) => b.id === selectedBundleId) || BUNDLES[1];
    const storeHomeUrl = isSubdomain ? '/' : '/biolab';

    const buildDirectWhatsAppUrl = (bundle: BundleOption) => {
        const text =
            `Hola *AVIPET BioLab®* 🔬🐾\n` +
            `Quiero pedir o consultar sobre *DERMO & GUT SUPERBOOST (250g)* con *Envío Gratis y Pago Contraentrega*:\n\n` +
            `👉 *Opción seleccionada:* ${bundle.name}\n` +
            `💰 *Valor:* ${bundle.formattedPrice} COP (Envío Gratis)\n\n` +
            `¿Me ayudan a coordinar el despacho a mi ciudad?`;
        return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(text)}`;
    };

    const handleOpenCheckout = (bundleId?: BundleId) => {
        if (bundleId) {
            setSelectedBundleId(bundleId);
        }
        setOrderError(null);
        setIsCheckoutModalOpen(true);
    };

    const handleSubmitOrder = async (e: React.FormEvent) => {
        e.preventDefault();
        setOrderError(null);

        if (!customerName.trim() || !customerPhone.trim() || !city.trim() || !address.trim()) {
            setOrderError('Por favor completa tu nombre, WhatsApp, ciudad y dirección exacta para el despacho.');
            return;
        }

        setIsSubmitting(true);
        try {
            const csrfToken =
                document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            const response = await fetch('/biolab/order', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    bundle_id: selectedBundleId,
                    customer_name: customerName,
                    customer_phone: customerPhone,
                    department,
                    city,
                    address,
                    neighborhood,
                    pet_type: petType,
                    pet_name: petName,
                    pet_weight: petWeight,
                    payment_method: paymentMethod,
                    notes,
                }),
            });

            const data = await response.json();
            if (!response.ok || !data.success) {
                throw new Error(data.message || 'No pudimos procesar el pedido. Intenta nuevamente.');
            }

            setOrderSuccess({
                order_code: data.order_code,
                whatsapp_url: data.whatsapp_url,
                formatted_total: `${activeBundle.formattedPrice} COP`,
                bundle_title: activeBundle.name,
            });
            setIsCheckoutModalOpen(true);
        } catch (err: any) {
            setOrderError(
                err?.message || 'Ocurrió un error al registrar tu pedido. Puedes finalizarlo directamente por WhatsApp.'
            );
        } finally {
            setIsSubmitting(false);
        }
    };

    const nextImage = () => setActiveImageIdx((prev) => (prev + 1) % GALLERY_IMAGES.length);
    const prevImage = () =>
        setActiveImageIdx((prev) => (prev - 1 + GALLERY_IMAGES.length) % GALLERY_IMAGES.length);

    return (
        <>
            <Head>
                <title>
                    Dermo &amp; Gut Superboost (250g) | Alivio de Dermatitis, Picazón y Digestión — AVIPET BioLab®
                </title>
                <meta
                    name="description"
                    content="Suplemento biotecnológico 3 en 1 en polvo para perros y gatos. Con Micro-Proteína Novel de Hermetia illucens y Ácido Láurico natural. Corta la picazón, hongos, caída de pelo y regula la digestión. 100% libre de gluten, pollo y res. Envíos gratis y pago contraentrega en toda Colombia."
                />
            </Head>

            <div className="min-h-screen bg-[#FAF8FF] text-[#1E1035] font-sans pb-24 selection:bg-[#311457] selection:text-white">
                {/* 0. TOP BAR DE URGENCIA Y CONVERSIÓN (CONTRAENTREGA COLOMBIA) */}
                <div className="bg-gradient-to-r from-[#240B46] via-[#311457] to-[#134E5E] text-white text-xs sm:text-sm py-2.5 px-4 shadow-sm">
                    <div className="max-w-7xl mx-auto flex flex-wrap items-center justify-center sm:justify-between gap-2 text-center">
                        <div className="flex items-center gap-2 font-extrabold tracking-wide text-[#FDE68A]">
                            <span>🇨🇴 ENVÍO GRATIS A TODA COLOMBIA + PAGO CONTRAENTREGA EN CASA</span>
                        </div>
                        <div className="hidden md:flex items-center gap-4 text-xs font-semibold text-white/95">
                            <span className="inline-flex items-center gap-1.5">
                                <span className="w-2 h-2 rounded-full bg-emerald-400 animate-pulse" />
                                Despacho Inmediato Hoy
                            </span>
                            <span className="text-white/40">|</span>
                            <span>Pagas en Efectivo, Nequi o Bancolombia al recibir</span>
                        </div>
                    </div>
                </div>

                {/* 1. CABECERA CLÍNICA LUMINOSA (ESTILO NATIVE PET / PETLAB CO.) */}
                <header className="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-purple-100 shadow-sm">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between gap-4">
                        <a href={storeHomeUrl} className="flex items-center gap-3 group">
                            <img
                                src="/images/biolab/logo-avipet-biolab.jpg"
                                alt="AVIPET BioLab®"
                                className="w-11 h-11 rounded-full object-cover border-2 border-[#311457]/20 shadow-sm"
                            />
                            <div className="flex flex-col">
                                <div className="flex items-center gap-1">
                                    <span className="text-lg sm:text-xl font-black tracking-tight text-[#311457]">
                                        AviPet
                                    </span>
                                    <span className="text-lg sm:text-xl font-black tracking-tight text-[#0E8A9E]">
                                        BioLab®
                                    </span>
                                </div>
                                <span className="text-[11px] text-slate-500 font-semibold -mt-0.5">
                                    Nutrición Clínica Dermo-Digestiva
                                </span>
                            </div>
                        </a>

                        <nav className="hidden lg:flex items-center gap-6 text-sm font-bold text-[#311457]/80">
                            <a href={storeHomeUrl} className="text-[#0E8A9E] hover:text-[#311457] transition">
                                ← Tienda Oficial
                            </a>
                            <a href="#problema-solucion" className="hover:text-[#311457] transition">
                                ¿Por qué Funciona?
                            </a>
                            <a href="#comparativa" className="hover:text-[#311457] transition">
                                Comparativa
                            </a>
                            <a href="#ficha-tecnica" className="hover:text-[#311457] transition">
                                Tabla Nutricional y Dosis
                            </a>
                            <a href="#opiniones" className="hover:text-[#311457] transition">
                                Opiniones (4.9★)
                            </a>
                            <a href="#faq" className="hover:text-[#311457] transition">
                                Preguntas Frecuentes
                            </a>
                        </nav>

                        <div className="flex items-center gap-2.5">
                            <a
                                href={buildDirectWhatsAppUrl(activeBundle)}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border-2 border-emerald-600/20 bg-emerald-50 text-emerald-800 hover:bg-emerald-100 text-xs sm:text-sm font-extrabold transition"
                            >
                                <MessageCircle className="w-4 h-4 text-emerald-600" />
                                WhatsApp
                            </a>
                            <button
                                type="button"
                                onClick={() => handleOpenCheckout()}
                                className="inline-flex items-center gap-2 px-4 sm:px-5 py-2.5 rounded-xl bg-[#059669] hover:bg-[#047857] text-white text-xs sm:text-sm font-black shadow-md shadow-emerald-600/25 transition cursor-pointer"
                            >
                                <ShoppingBag className="w-4 h-4" />
                                <span>¡Pedir Contraentrega!</span>
                            </button>
                        </div>
                    </div>
                </header>

                {/* 2. HERO ABOVE-THE-FOLD DE ALTA CONVERSIÓN (PALETA CLÍNICA BLANCA + LAVANDA + PURPURA REAL + TEAL + ORO) */}
                <section className="relative bg-gradient-to-b from-white via-[#FAF8FF] to-[#F3EFFB] pt-5 pb-14 lg:py-10 border-b border-purple-100">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        {/* Badge Superior Oficial */}
                        <div className="mb-5 flex flex-wrap items-center justify-between gap-2">
                            <div className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#311457] text-white text-xs sm:text-sm font-extrabold shadow-sm">
                                <span className="text-[#FDE68A]">🔬 BIOTECNOLOGÍA CLÍNICA VETERINARIA</span>
                                <span className="text-white/40">•</span>
                                <span>RESULTADOS VISIBLES DESDE LA 1.ª SEMANA</span>
                            </div>

                            <div className="hidden md:flex items-center gap-2 text-xs font-bold text-[#0E8A9E] bg-[#0E8A9E]/10 px-3.5 py-1.5 rounded-full">
                                <ShieldCheck className="w-4 h-4" />
                                <span>100% Libre de Pollo, Res, Soya y Gluten</span>
                            </div>
                        </div>

                        <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">
                            {/* COLUMNA IZQUIERDA: GALERÍA VERTICAL 4:5 (SIN BORDES NEGROS NI ESPACIOS VACÍOS) */}
                            <div className="lg:col-span-6 lg:sticky lg:top-20">
                                <div className="bg-white rounded-3xl border-2 border-purple-100/90 shadow-xl shadow-purple-950/5 p-3 sm:p-5">
                                    {/* Imagen Principal en proporción vertical limpia */}
                                    <div className="relative aspect-[4/5] rounded-2xl overflow-hidden bg-gradient-to-b from-[#FAF8FF] to-[#F3EFFB] flex items-center justify-center group">
                                        {/* Sello Flotante Superior Izquierdo */}
                                        <div className="absolute top-3 left-3 z-10 flex flex-col gap-1.5">
                                            <span className="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-[#311457] text-white text-xs font-black shadow-md">
                                                ✨ 3 EN 1: PIEL • DIGESTIÓN • ALIENTO
                                            </span>
                                            <span className="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-amber-500 text-white text-xs font-black shadow-md w-fit">
                                                ⏱️ RESULTADOS EN 7 DÍAS
                                            </span>
                                        </div>

                                        {/* Botón Zoom */}
                                        <button
                                            type="button"
                                            onClick={() => setIsZoomOpen(true)}
                                            className="absolute top-3 right-3 z-10 px-3 py-1.5 rounded-full bg-white/90 hover:bg-white text-[#311457] text-xs font-bold flex items-center gap-1.5 shadow-md border border-purple-100 cursor-pointer"
                                        >
                                            <ZoomIn className="w-3.5 h-3.5 text-[#0E8A9E]" />
                                            <span>Ampliar</span>
                                        </button>

                                        <img
                                            src={GALLERY_IMAGES[activeImageIdx].src}
                                            alt={GALLERY_IMAGES[activeImageIdx].alt}
                                            onClick={() => setIsZoomOpen(true)}
                                            className="w-full h-full object-contain cursor-zoom-in transition-transform duration-500 group-hover:scale-[1.02]"
                                        />

                                        {/* Flechas de navegación */}
                                        <button
                                            type="button"
                                            onClick={prevImage}
                                            aria-label="Anterior"
                                            className="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/95 hover:bg-white text-[#311457] flex items-center justify-center shadow-lg border border-purple-100 cursor-pointer"
                                        >
                                            <ChevronLeft className="w-5 h-5" />
                                        </button>
                                        <button
                                            type="button"
                                            onClick={nextImage}
                                            aria-label="Siguiente"
                                            className="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/95 hover:bg-white text-[#311457] flex items-center justify-center shadow-lg border border-purple-100 cursor-pointer"
                                        >
                                            <ChevronRight className="w-5 h-5" />
                                        </button>

                                        {/* Leyenda inferior */}
                                        <div className="absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#311457]/90 via-[#311457]/60 to-transparent px-4 py-3 text-white">
                                            <p className="text-xs sm:text-sm font-semibold text-center">
                                                {GALLERY_IMAGES[activeImageIdx].caption}
                                            </p>
                                        </div>
                                    </div>

                                    {/* Miniaturas de Galería */}
                                    <div className="grid grid-cols-4 gap-2.5 mt-3">
                                        {GALLERY_IMAGES.map((img, idx) => (
                                            <button
                                                key={idx}
                                                type="button"
                                                onClick={() => setActiveImageIdx(idx)}
                                                className={`rounded-xl overflow-hidden border-2 transition cursor-pointer bg-white ${
                                                    activeImageIdx === idx
                                                        ? 'border-[#311457] ring-2 ring-[#311457]/20 shadow-sm'
                                                        : 'border-slate-200 opacity-70 hover:opacity-100'
                                                }`}
                                            >
                                                <div className="aspect-square bg-[#FAF8FF] p-1">
                                                    <img
                                                        src={img.src}
                                                        alt={img.alt}
                                                        className="w-full h-full object-contain"
                                                    />
                                                </div>
                                                <div className="bg-[#311457] text-white py-1 px-1 text-center">
                                                    <p className="text-[10px] font-bold truncate">{img.tag}</p>
                                                </div>
                                            </button>
                                        ))}
                                    </div>

                                    {/* 4 Íconos de Confianza Rápida debajo de la Foto */}
                                    <div className="grid grid-cols-4 gap-2 mt-4 pt-4 border-t border-purple-100 text-center">
                                        <div className="p-2 rounded-xl bg-[#FAF8FF]">
                                            <p className="text-xs font-black text-[#311457]">40% PROTEÍNA</p>
                                            <p className="text-[10px] text-slate-600 font-medium">Novel Hipoalergénica</p>
                                        </div>
                                        <div className="p-2 rounded-xl bg-[#FAF8FF]">
                                            <p className="text-xs font-black text-[#0E8A9E]">4.5% LÁURICO</p>
                                            <p className="text-[10px] text-slate-600 font-medium">Antihongos Natural</p>
                                        </div>
                                        <div className="p-2 rounded-xl bg-[#FAF8FF]">
                                            <p className="text-xs font-black text-[#311457]">0% ALÉRGENOS</p>
                                            <p className="text-[10px] text-slate-600 font-medium">Sin Pollo ni Gluten</p>
                                        </div>
                                        <div className="p-2 rounded-xl bg-emerald-50">
                                            <p className="text-xs font-black text-emerald-700">PAGO EN CASA</p>
                                            <p className="text-[10px] text-emerald-800 font-medium">Envío Gratis 🇨🇴</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* COLUMNA DERECHA: BUY BOX E-COMMERCE DE ALTA CONVERSIÓN */}
                            <div className="lg:col-span-6 space-y-5">
                                {/* Calificación Social (Estrellas) */}
                                <div className="inline-flex flex-wrap items-center gap-2 bg-white px-3.5 py-1.5 rounded-full border border-purple-200 shadow-xs text-xs sm:text-sm">
                                    <div className="flex items-center text-amber-400">
                                        <Star className="w-4 h-4 fill-amber-400" />
                                        <Star className="w-4 h-4 fill-amber-400" />
                                        <Star className="w-4 h-4 fill-amber-400" />
                                        <Star className="w-4 h-4 fill-amber-400" />
                                        <Star className="w-4 h-4 fill-amber-400" />
                                    </div>
                                    <span className="font-black text-[#311457]">4.9 / 5.0</span>
                                    <span className="text-slate-600 font-medium">
                                        (Basado en dueños de mascotas y médicos veterinarios aliados en Colombia)
                                    </span>
                                </div>

                                {/* H1 y H2 Oficiales */}
                                <div>
                                    <h1 className="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-[#311457] leading-[1.12]">
                                        AVIPET BioLab® — DERMO &amp; GUT SUPERBOOST (250g)
                                    </h1>
                                    <h2 className="mt-2 text-base sm:text-lg font-bold text-[#0E8A9E] leading-snug">
                                        Suplemento Nutricional Biotecnológico 3 en 1 en Polvo para Perros y Gatos:{' '}
                                        <span className="text-[#311457] underline decoration-[#D97706] decoration-2">
                                            Piel • Digestión • Aliento
                                        </span>
                                    </h2>
                                </div>

                                {/* Bloque de Precio Ancla + Precio de Lanzamiento Destacado */}
                                <div className="bg-white rounded-2xl border-2 border-[#311457]/15 p-4 sm:p-5 shadow-sm">
                                    <div className="flex flex-wrap items-center justify-between gap-2">
                                        <div>
                                            <div className="flex items-center gap-2">
                                                <span className="text-sm text-slate-400 line-through font-bold tabular-nums">
                                                    Precio Normal: {activeBundle.formattedCompareAt} COP
                                                </span>
                                                <span className="px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-700 text-xs font-black">
                                                    AHORRAS {activeBundle.savingsAmount}
                                                </span>
                                            </div>
                                            <div className="mt-1 flex items-baseline gap-2">
                                                <span className="text-3xl sm:text-4xl font-black text-[#311457] tabular-nums">
                                                    {activeBundle.formattedPrice} COP
                                                </span>
                                                <span className="text-xs sm:text-sm font-bold text-slate-500">
                                                    ({activeBundle.grams} • {activeBundle.durationText})
                                                </span>
                                            </div>
                                        </div>

                                        <div className="flex flex-col items-start sm:items-end">
                                            <span className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-black">
                                                <Truck className="w-4 h-4 text-emerald-600" />
                                                🚚 Envío Gratis + Contraentrega
                                            </span>
                                            <span className="text-[11px] text-slate-500 font-semibold mt-1">
                                                Pagas únicamente al recibir en tu puerta
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {/* VIÑETAS DE IMPACTO RÁPIDO (5 BULLETS ESCANEABLES) */}
                                <div className="bg-white rounded-2xl border border-purple-100 p-4 sm:p-5 shadow-xs space-y-2.5">
                                    <div className="flex items-start gap-3">
                                        <span className="text-lg leading-none mt-0.5">🛡️</span>
                                        <p className="text-xs sm:text-sm text-slate-700 leading-relaxed">
                                            <strong className="text-[#311457]">
                                                Alivio de Picazón y Alergias de Raíz:
                                            </strong>{' '}
                                            Con Micro-Proteína Novel de insecto de cultivo (
                                            <em className="font-semibold text-[#0E8A9E]">Hermetia illucens</em>) que no
                                            genera memoria alérgica.
                                        </p>
                                    </div>
                                    <div className="flex items-start gap-3">
                                        <span className="text-lg leading-none mt-0.5">🧪</span>
                                        <p className="text-xs sm:text-sm text-slate-700 leading-relaxed">
                                            <strong className="text-[#311457]">
                                                Acción Antimicrobiana y Antihongos:
                                            </strong>{' '}
                                            Rico en Ácido Láurico natural (4.5%), que combate bacterias y hongos (
                                            <em className="font-semibold text-[#0E8A9E]">Malassezia</em>) causantes del
                                            mal olor y lamido de patas.
                                        </p>
                                    </div>
                                    <div className="flex items-start gap-3">
                                        <span className="text-lg leading-none mt-0.5">🦠</span>
                                        <p className="text-xs sm:text-sm text-slate-700 leading-relaxed">
                                            <strong className="text-[#311457]">
                                                Heces Firmes y Flora Intestinal Blindada:
                                            </strong>{' '}
                                            Fibra prebiótica soluble, MOS y Betaglucanos que restauran la microbiota
                                            desde la primera semana.
                                        </p>
                                    </div>
                                    <div className="flex items-start gap-3">
                                        <span className="text-lg leading-none mt-0.5">🦷</span>
                                        <p className="text-xs sm:text-sm text-slate-700 leading-relaxed">
                                            <strong className="text-[#311457]">Elimina el Mal Aliento:</strong>{' '}
                                            Clorofila activa de perejil deshidratado que neutraliza toxinas estomacales
                                            y bucales.
                                        </p>
                                    </div>
                                    <div className="flex items-start gap-3">
                                        <span className="text-lg leading-none mt-0.5">🚫</span>
                                        <p className="text-xs sm:text-sm text-slate-700 leading-relaxed">
                                            <strong className="text-[#311457]">100% Hipoalergénico Real:</strong> 0%
                                            Pollo • 0% Res • 0% Soya • Sin Granos • 100% Libre de Gluten.
                                        </p>
                                    </div>
                                </div>

                                {/* SELECTOR DE BUNDLES ESTILO KACHING SHOPIFY PLUS (SUBE EL TICKET PROMEDIO) */}
                                <div className="space-y-3">
                                    <div className="flex items-center justify-between">
                                        <span className="text-xs sm:text-sm font-black uppercase tracking-wider text-[#311457]">
                                            👇 Elige tu Oferta con Envío Gratis:
                                        </span>
                                        <span className="text-xs font-extrabold text-emerald-700">
                                            ¡Ahorra hasta $39.800!
                                        </span>
                                    </div>

                                    <div className="space-y-3">
                                        {BUNDLES.map((bundle) => {
                                            const isSelected = selectedBundleId === bundle.id;
                                            return (
                                                <div
                                                    key={bundle.id}
                                                    onClick={() => setSelectedBundleId(bundle.id)}
                                                    className={`relative rounded-2xl p-4 transition-all cursor-pointer border-2 ${
                                                        isSelected
                                                            ? 'bg-white border-[#311457] ring-4 ring-[#311457]/10 shadow-lg'
                                                            : 'bg-white/80 border-slate-200 hover:border-purple-300'
                                                    }`}
                                                >
                                                    {bundle.tag && (
                                                        <div className="mb-2.5 flex items-center justify-between gap-2">
                                                            <span
                                                                className={`inline-block px-3 py-0.5 rounded-full text-[11px] font-black tracking-wide shadow-xs ${bundle.tagStyle}`}
                                                            >
                                                                {bundle.tag}
                                                            </span>
                                                            <span className="text-[11px] font-extrabold text-[#0E8A9E] tabular-nums">
                                                                Sale a {bundle.unitPriceText}
                                                            </span>
                                                        </div>
                                                    )}

                                                    <div className="flex items-center justify-between gap-3">
                                                        <div className="flex items-center gap-3">
                                                            {/* Radio Button Visual */}
                                                            <div
                                                                className={`w-6 h-6 rounded-full border-2 flex items-center justify-center shrink-0 ${
                                                                    isSelected
                                                                        ? 'border-[#311457] bg-[#311457]'
                                                                        : 'border-slate-300 bg-white'
                                                                }`}
                                                            >
                                                                {isSelected && (
                                                                    <Check className="w-4 h-4 text-white stroke-[3]" />
                                                                )}
                                                            </div>

                                                            {/* Miniatura del Empaque con contador */}
                                                            <div className="relative w-12 h-14 rounded-xl bg-[#FAF8FF] border border-purple-100 p-1 shrink-0 hidden sm:flex items-center justify-center">
                                                                <img
                                                                    src="/images/biolab/empaque-frente-250g.jpg"
                                                                    alt={bundle.name}
                                                                    className="w-full h-full object-contain"
                                                                />
                                                                <span className="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full bg-[#D97706] text-white text-[10px] font-black flex items-center justify-center shadow">
                                                                    {bundle.bags}x
                                                                </span>
                                                            </div>

                                                            <div>
                                                                <p className="font-black text-[#311457] text-sm sm:text-base leading-tight">
                                                                    {bundle.name}
                                                                </p>
                                                                <p className="text-xs text-emerald-700 font-bold mt-0.5">
                                                                    {bundle.savingsText}
                                                                </p>
                                                                <p className="text-[11px] text-slate-500 font-medium mt-0.5">
                                                                    {bundle.recommendedFor}
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div className="text-right shrink-0 tabular-nums">
                                                            <p className="text-xs text-slate-400 line-through font-bold">
                                                                {bundle.formattedCompareAt}
                                                            </p>
                                                            <p className="text-xl sm:text-2xl font-black text-[#311457]">
                                                                {bundle.formattedPrice}
                                                            </p>
                                                            <span className="inline-block px-2 py-0.5 rounded bg-emerald-50 text-[10px] font-extrabold text-emerald-700">
                                                                Envío Gratis
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            );
                                        })}
                                    </div>
                                </div>

                                {/* BOTONES DE LLAMADO A LA ACCIÓN (CTA DE ALTA CONVERSIÓN) */}
                                <div className="space-y-3 pt-1">
                                    <button
                                        type="button"
                                        onClick={() => handleOpenCheckout()}
                                        className="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-[#059669] via-[#10B981] to-[#059669] hover:from-[#047857] hover:to-[#047857] active:scale-[0.99] text-white shadow-xl shadow-emerald-600/30 border-b-4 border-[#047857] flex flex-col items-center justify-center transition cursor-pointer"
                                    >
                                        <span className="flex items-center gap-2.5 font-black text-base sm:text-xl tracking-tight">
                                            <ShoppingBag className="w-6 h-6 shrink-0" />
                                            <span>🛒 ¡PEDIR AHORA Y PAGAR EN CASA! (ENVÍO GRATIS)</span>
                                        </span>
                                        <span className="text-[11px] sm:text-xs font-bold text-emerald-50 mt-0.5">
                                            Seleccionado: {activeBundle.shortTitle} — {activeBundle.formattedPrice} COP
                                            • Pagas al recibir
                                        </span>
                                    </button>

                                    <a
                                        href={buildDirectWhatsAppUrl(activeBundle)}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="w-full py-3.5 px-6 rounded-2xl bg-white hover:bg-purple-50 border-2 border-[#311457]/20 text-[#311457] font-extrabold text-sm sm:text-base flex items-center justify-center gap-2.5 shadow-xs transition"
                                    >
                                        <MessageCircle className="w-5 h-5 text-emerald-600 shrink-0" />
                                        <span>📲 Comprar o Consultar por WhatsApp</span>
                                    </a>

                                    {/* Sellos de Pago Seguro Contraentrega */}
                                    <div className="bg-white rounded-xl border border-purple-100 p-3 flex flex-wrap items-center justify-center gap-x-4 gap-y-1 text-xs font-bold text-slate-600">
                                        <span className="inline-flex items-center gap-1 text-[#311457]">
                                            <Lock className="w-3.5 h-3.5 text-emerald-600" />
                                            Compra 100% Segura sin Pago Anticipado
                                        </span>
                                        <span className="text-slate-300">•</span>
                                        <span>Efectivo / Nequi / Bancolombia / Daviplata</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* 2.5 FRANJA DE AUTORIDAD Y RESULTADOS EN 7 DÍAS */}
                <section className="bg-[#311457] text-white py-8 border-b-4 border-[#D97706]">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="grid grid-cols-2 lg:grid-cols-4 gap-6 text-center divide-y lg:divide-y-0 lg:divide-x divide-white/15">
                            <div className="pt-3 lg:pt-0">
                                <p className="text-2xl sm:text-4xl font-black text-[#FDE68A] tabular-nums">40.0%</p>
                                <p className="text-xs sm:text-sm font-bold text-white mt-1">
                                    Micro-Proteína Novel Pura
                                </p>
                                <p className="text-[11px] text-purple-200">
                                    Hermetia illucens hipoalergénica
                                </p>
                            </div>
                            <div className="pt-3 lg:pt-0">
                                <p className="text-2xl sm:text-4xl font-black text-[#35DDF5] tabular-nums">4.5%</p>
                                <p className="text-xs sm:text-sm font-bold text-white mt-1">
                                    Ácido Láurico Activo (C12:0)
                                </p>
                                <p className="text-[11px] text-purple-200">
                                    Combate hongos (Malassezia) y bacterias
                                </p>
                            </div>
                            <div className="pt-3 lg:pt-0">
                                <p className="text-2xl sm:text-4xl font-black text-emerald-300 tabular-nums">
                                    7 DÍAS
                                </p>
                                <p className="text-xs sm:text-sm font-bold text-white mt-1">
                                    Resultados Digestivos y Aliento
                                </p>
                                <p className="text-[11px] text-purple-200">
                                    Heces firmes y flora intestinal blindada
                                </p>
                            </div>
                            <div className="pt-3 lg:pt-0">
                                <p className="text-2xl sm:text-4xl font-black text-[#FDE68A] tabular-nums">0% Pollo</p>
                                <p className="text-xs sm:text-sm font-bold text-white mt-1">
                                    0% Res • 0% Soya • 0% Gluten
                                </p>
                                <p className="text-[11px] text-purple-200">
                                    Sin cereales ni saborizantes artificiales
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                {/* 3. SECCIÓN DEL PROBLEMA VS. SOLUCIÓN (DISEÑO VISUAL DE ALTO IMPACTO) */}
                <section id="problema-solucion" className="py-16 lg:py-20 bg-white">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="max-w-3xl mx-auto text-center mb-12">
                            <span className="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-rose-100 text-rose-800 text-xs font-black uppercase tracking-wider">
                                <AlertTriangle className="w-4 h-4" />
                                El Verdadero Origen de la Alergia
                            </span>
                            <h2 className="mt-3 text-2xl sm:text-4xl font-black text-[#311457] leading-tight">
                                ¿Tu peludo se rasca sin parar, se lame las patas, pierde pelo o sufre del estómago?
                            </h2>
                            <p className="mt-4 text-base sm:text-lg text-slate-600 leading-relaxed">
                                El <strong className="text-[#311457]">80% de las dermatitis crónicas</strong>, otitis
                                recurrentes y problemas digestivos en perros y gatos son provocados por la inflamación
                                que generan las proteínas tradicionales (como el pollo o la res) y los cereales de
                                relleno (trigo, maíz, soya) presentes en los concentrados comerciales y suplementos
                                convencionales.
                            </p>
                        </div>

                        {/* Comparación Visual Antes (Problema) vs. Ahora (Solución AVIPET BioLab) */}
                        <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch mb-14">
                            {/* Tarjeta Problema */}
                            <div className="rounded-3xl bg-rose-50/60 border-2 border-rose-200 p-6 sm:p-8 flex flex-col justify-between">
                                <div>
                                    <span className="inline-block px-3 py-1 rounded-full bg-rose-600 text-white text-xs font-black uppercase">
                                        ❌ EL ERROR DE LOS TARROS TRADICIONALES
                                    </span>
                                    <h3 className="mt-4 text-xl sm:text-2xl font-black text-rose-950">
                                        “Darle un tarro que solo contiene Omega 3 es intentar apagar un incendio sin
                                        cerrar la llave del gas”
                                    </h3>
                                    <p className="mt-3 text-sm sm:text-base text-rose-900/80 leading-relaxed">
                                        Alivia por unos días, pero la alergia vuelve porque no corrige la inflamación
                                        intestinal ni detiene al hongo <em>Malassezia</em> en sus patas y orejas.
                                    </p>

                                    <ul className="mt-5 space-y-2.5 text-sm text-rose-950 font-medium">
                                        <li className="flex items-start gap-2.5">
                                            <XCircle className="w-5 h-5 text-rose-600 shrink-0 mt-0.5" />
                                            <span>
                                                Suelen usar saborizantes de <strong>pollo o hígado</strong> que disparan
                                                más picazón.
                                            </span>
                                        </li>
                                        <li className="flex items-start gap-2.5">
                                            <XCircle className="w-5 h-5 text-rose-600 shrink-0 mt-0.5" />
                                            <span>
                                                Los tarros de boca ancha dejan entrar oxígeno y{' '}
                                                <strong>oxidan los Omegas</strong> en pocos días.
                                            </span>
                                        </li>
                                        <li className="flex items-start gap-2.5">
                                            <XCircle className="w-5 h-5 text-rose-600 shrink-0 mt-0.5" />
                                            <span>
                                                No contienen Ácido Láurico antihongos ni prebióticos para el intestino.
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            {/* Tarjeta Solución */}
                            <div className="rounded-3xl bg-gradient-to-br from-[#311457] to-[#1E0B38] text-white border-2 border-[#D97706] p-6 sm:p-8 flex flex-col justify-between shadow-xl">
                                <div>
                                    <span className="inline-block px-3 py-1 rounded-full bg-[#D97706] text-white text-xs font-black uppercase">
                                        ✅ LA REVOLUCIÓN BIOTECNOLÓGICA AVIPET BIOLAB®
                                    </span>
                                    <h3 className="mt-4 text-xl sm:text-2xl font-black text-white">
                                        Ataca el problema desde su origen inmunológico y digestivo con Doble Matriz
                                        Activa
                                    </h3>
                                    <p className="mt-3 text-sm sm:text-base text-purple-100 leading-relaxed">
                                        <strong className="text-[#FDE68A]">DERMO &amp; GUT SUPERBOOST</strong> combina
                                        proteína novel hipoalergénica, ácido láurico antimicrobiano y prebióticos
                                        clínicos en polvo palatable.
                                    </p>

                                    <ul className="mt-5 space-y-2.5 text-sm text-white font-medium">
                                        <li className="flex items-start gap-2.5">
                                            <CheckCircle2 className="w-5 h-5 text-emerald-400 shrink-0 mt-0.5" />
                                            <span>
                                                <strong>Matriz Proteica y Lipídica Dermo-Activa:</strong> Micro-proteína
                                                purificada de <em className="text-[#35DDF5]">Hermetia illucens</em>{' '}
                                                (40%), Ácido Láurico C12:0 (4.5%) y Omega 3, 6 y 9 de linaza dorada.
                                            </span>
                                        </li>
                                        <li className="flex items-start gap-2.5">
                                            <CheckCircle2 className="w-5 h-5 text-emerald-400 shrink-0 mt-0.5" />
                                            <span>
                                                <strong>Complejo Prebiótico y Fitoterapéutico Gut-Care:</strong> Fibra
                                                soluble de ahuyama, levadura nutricional (
                                                <em className="text-[#35DDF5]">Saccharomyces cerevisiae</em>), extracto
                                                de cúrcuma y clorofila de perejil.
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {/* Banner Oficial Panorámico */}
                        <div className="rounded-3xl overflow-hidden border-2 border-purple-100 shadow-xl">
                            <img
                                src="/images/biolab/banner-panoramico.jpg"
                                alt="AVIPET BioLab® — Nutrición Clínica Dermo-Digestiva"
                                className="w-full h-auto object-cover"
                            />
                        </div>
                    </div>
                </section>

                {/* 4. TABLA COMPARATIVA (POR QUÉ ELEGIR AVIPET BioLab®) */}
                <section id="comparativa" className="py-16 lg:py-20 bg-[#FAF8FF] border-t border-purple-100">
                    <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center max-w-3xl mx-auto mb-10">
                            <span className="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-[#0E8A9E]/15 text-[#0E8A9E] text-xs font-black uppercase tracking-wider">
                                Comparativa Clínica
                            </span>
                            <h2 className="mt-3 text-2xl sm:text-4xl font-black text-[#311457]">
                                ¿Por qué elegir AVIPET BioLab®?
                            </h2>
                            <p className="mt-2 text-sm sm:text-base text-slate-600">
                                Compara nuestra fórmula biotecnológica 3 en 1 frente a los suplementos tradicionales en
                                tarro.
                            </p>
                        </div>

                        <div className="overflow-x-auto rounded-3xl border-2 border-purple-200 bg-white shadow-xl">
                            <table className="w-full text-left border-collapse">
                                <thead>
                                    <tr className="bg-[#311457] text-white">
                                        <th className="py-4 px-4 sm:px-6 text-xs sm:text-sm font-black uppercase tracking-wider w-2/5">
                                            Característica
                                        </th>
                                        <th className="py-4 px-4 sm:px-6 text-xs sm:text-sm font-black uppercase tracking-wider bg-[#0E8A9E] text-white w-3/10">
                                            🔬 AVIPET BioLab® Superboost
                                        </th>
                                        <th className="py-4 px-4 sm:px-6 text-xs sm:text-sm font-black uppercase tracking-wider text-purple-200 w-3/10">
                                            Otros Suplementos en Tarro
                                        </th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-purple-100 text-sm">
                                    {COMPARISON_ROWS.map((row, index) => (
                                        <tr
                                            key={index}
                                            className={index % 2 === 0 ? 'bg-white' : 'bg-[#FAF8FF]'}
                                        >
                                            <td className="py-4 px-4 sm:px-6 font-bold text-[#311457]">
                                                {row.feature}
                                            </td>
                                            <td className="py-4 px-4 sm:px-6 bg-emerald-50/50 border-x border-purple-100 font-bold text-[#1E1035]">
                                                <div className="flex items-start gap-2">
                                                    {row.biolabStatus === 'price' ? (
                                                        <span className="inline-flex items-center px-3 py-1 rounded-lg bg-[#059669] text-white font-black tabular-nums">
                                                            {row.biolab}
                                                        </span>
                                                    ) : (
                                                        <>
                                                            <CheckCircle2 className="w-5 h-5 text-[#059669] shrink-0 mt-0.5" />
                                                            <span>✅ {row.biolab}</span>
                                                        </>
                                                    )}
                                                </div>
                                            </td>
                                            <td className="py-4 px-4 sm:px-6 text-slate-600 font-medium">
                                                <div className="flex items-start gap-2">
                                                    {row.othersStatus === 'no' && (
                                                        <>
                                                            <XCircle className="w-5 h-5 text-rose-600 shrink-0 mt-0.5" />
                                                            <span>❌ {row.others}</span>
                                                        </>
                                                    )}
                                                    {row.othersStatus === 'partial' && (
                                                        <>
                                                            <CheckCircle2 className="w-5 h-5 text-slate-400 shrink-0 mt-0.5" />
                                                            <span>✅ {row.others}</span>
                                                        </>
                                                    )}
                                                    {row.othersStatus === 'warn' && (
                                                        <>
                                                            <AlertTriangle className="w-5 h-5 text-amber-600 shrink-0 mt-0.5" />
                                                            <span>⚠️ {row.others}</span>
                                                        </>
                                                    )}
                                                </div>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                {/* 5. FICHA TÉCNICA, TABLA NUTRICIONAL Y DOSIS DIARIA */}
                <section id="ficha-tecnica" className="py-16 lg:py-20 bg-white border-t border-purple-100">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center max-w-3xl mx-auto mb-12">
                            <span className="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#311457] text-[#FDE68A] text-xs font-black uppercase tracking-wider">
                                Ficha Técnica Oficial y Dosificación
                            </span>
                            <h2 className="mt-3 text-2xl sm:text-4xl font-black text-[#311457]">
                                Composición Garantizada, Tabla Nutricional y Modo de Uso
                            </h2>
                            <p className="mt-2 text-sm sm:text-base text-slate-600">
                                Fórmula 100% transparente por cada 100g. Incluye cuchara medidora de 5g.
                            </p>
                        </div>

                        <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                            {/* Tarjeta Visual del Empaque Oficial + Resumen de Rendimiento */}
                            <div className="lg:col-span-5">
                                <div className="rounded-3xl bg-[#FAF8FF] border-2 border-purple-100 p-6 shadow-md text-center">
                                    <img
                                        src="/images/biolab/empaque-frente-250g.jpg"
                                        alt="AVIPET BioLab® — Dermo & Gut Superboost 250g"
                                        className="w-full max-h-80 object-contain mx-auto"
                                    />
                                    <div className="mt-4 pt-4 border-t border-purple-200/60 text-left space-y-2 text-xs sm:text-sm">
                                        <div className="flex justify-between">
                                            <span className="text-slate-500 font-semibold">Presentación:</span>
                                            <span className="font-black text-[#311457]">
                                                Doypack Zipper Hermético 250g
                                            </span>
                                        </div>
                                        <div className="flex justify-between">
                                            <span className="text-slate-500 font-semibold">Textura y Sabor:</span>
                                            <span className="font-black text-[#0E8A9E]">
                                                Polvo Fino • Umami Natural
                                            </span>
                                        </div>
                                        <div className="flex justify-between">
                                            <span className="text-slate-500 font-semibold">Especies:</span>
                                            <span className="font-black text-[#311457]">
                                                Perros y Gatos (+3 meses)
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* Acordeones Desplegables */}
                            <div className="lg:col-span-7 space-y-4">
                                {/* ACORDEÓN 1: COMPOSICIÓN GARANTIZADA */}
                                <div className="rounded-2xl bg-white border-2 border-purple-100 shadow-xs overflow-hidden">
                                    <button
                                        type="button"
                                        onClick={() =>
                                            setOpenAccordion(openAccordion === 'composicion' ? '' : 'composicion')
                                        }
                                        className="w-full p-5 sm:p-6 flex items-center justify-between text-left hover:bg-[#FAF8FF] transition cursor-pointer"
                                    >
                                        <div className="flex items-center gap-3">
                                            <span className="text-2xl">🧬</span>
                                            <div>
                                                <h3 className="text-base sm:text-lg font-black text-[#311457]">
                                                    Composición Garantizada (Fórmula Biotecnológica Exclusiva)
                                                </h3>
                                                <p className="text-xs sm:text-sm text-slate-500 font-medium">
                                                    Matriz Dermo-Activa + Complejo Prebiótico Gut-Care
                                                </p>
                                            </div>
                                        </div>
                                        <ChevronDown
                                            className={`w-5 h-5 text-[#311457] transition-transform ${
                                                openAccordion === 'composicion' ? 'rotate-180' : ''
                                            }`}
                                        />
                                    </button>

                                    {openAccordion === 'composicion' && (
                                        <div className="px-5 pb-6 sm:px-6 sm:pb-6 pt-2 border-t border-purple-100 space-y-4 text-sm sm:text-base">
                                            <div className="rounded-xl bg-[#FAF8FF] p-4 border border-purple-100">
                                                <p className="font-black text-[#311457]">
                                                    Matriz Proteica y Lipídica Dermo-Activa:
                                                </p>
                                                <p className="mt-1 text-slate-600 leading-relaxed">
                                                    Micro-proteína purificada y desgrasada de{' '}
                                                    <em className="font-bold text-[#311457]">Hermetia illucens</em>{' '}
                                                    (fuente natural de Ácido Láurico C12:0 y péptidos hipoalergénicos)
                                                    y Semilla de linaza dorada molida (
                                                    <em className="font-bold text-[#311457]">Linum usitatissimum</em> —
                                                    fuente de Omega 3, 6 y 9).
                                                </p>
                                            </div>

                                            <div className="rounded-xl bg-[#FAF8FF] p-4 border border-purple-100">
                                                <p className="font-black text-[#0E8A9E]">
                                                    Complejo Prebiótico y Fitoterapéutico Gut-Care:
                                                </p>
                                                <p className="mt-1 text-slate-600 leading-relaxed">
                                                    Fibra soluble de ahuyama deshidratada (
                                                    <em className="font-bold text-[#311457]">Cucurbita moschata</em>),
                                                    Pared celular de levadura nutricional inactiva (
                                                    <em className="font-bold text-[#311457]">
                                                        Saccharomyces cerevisiae
                                                    </em>{' '}
                                                    — fuente de MOS, Betaglucanos y Biotina), Extracto de raíz de
                                                    cúrcuma (<em className="font-bold text-[#311457]">Curcuma longa</em>
                                                    ) y Hojas de perejil deshidratado (
                                                    <em className="font-bold text-[#311457]">Petroselinum crispum</em> —
                                                    rico en clorofila activa).
                                                </p>
                                            </div>

                                            <div className="rounded-xl bg-emerald-50 border border-emerald-200 p-4 flex items-center gap-3">
                                                <ShieldCheck className="w-6 h-6 text-emerald-600 shrink-0" />
                                                <p className="text-xs sm:text-sm font-bold text-emerald-950">
                                                    Libre de alérgenos: 0% Pollo, 0% Res, 0% Lácteos, 0% Soya, 0%
                                                    Trigo, 0% Maíz, 100% Libre de Gluten y sin conservantes
                                                    artificiales.
                                                </p>
                                            </div>
                                        </div>
                                    )}
                                </div>

                                {/* ACORDEÓN 2: TABLA NUTRICIONAL GARANTIZADA */}
                                <div className="rounded-2xl bg-white border-2 border-purple-100 shadow-xs overflow-hidden">
                                    <button
                                        type="button"
                                        onClick={() =>
                                            setOpenAccordion(openAccordion === 'nutricional' ? '' : 'nutricional')
                                        }
                                        className="w-full p-5 sm:p-6 flex items-center justify-between text-left hover:bg-[#FAF8FF] transition cursor-pointer"
                                    >
                                        <div className="flex items-center gap-3">
                                            <span className="text-2xl">📊</span>
                                            <div>
                                                <h3 className="text-base sm:text-lg font-black text-[#311457]">
                                                    Tabla Nutricional Garantizada (Por cada 100g)
                                                </h3>
                                                <p className="text-xs sm:text-sm text-slate-500 font-medium">
                                                    Proteína Cruda 40.0% • Ácido Láurico 4.5% • Omega 3 y 6: 3.7%
                                                </p>
                                            </div>
                                        </div>
                                        <ChevronDown
                                            className={`w-5 h-5 text-[#311457] transition-transform ${
                                                openAccordion === 'nutricional' ? 'rotate-180' : ''
                                            }`}
                                        />
                                    </button>

                                    {openAccordion === 'nutricional' && (
                                        <div className="px-5 pb-6 sm:px-6 sm:pb-6 pt-2 border-t border-purple-100">
                                            <div className="overflow-x-auto rounded-xl border border-purple-100">
                                                <table className="w-full text-left border-collapse">
                                                    <thead>
                                                        <tr className="bg-[#311457] text-white text-xs uppercase tracking-wider">
                                                            <th className="py-3.5 px-4">
                                                                Nutriente / Componente Activo
                                                            </th>
                                                            <th className="py-3.5 px-4">Valor Garantizado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody className="divide-y divide-purple-100 text-sm">
                                                        {NUTRITIONAL_TABLE.map((item, i) => (
                                                            <tr key={i} className="bg-white">
                                                                <td className="py-3.5 px-4 font-bold text-[#311457]">
                                                                    {item.nutrient}
                                                                </td>
                                                                <td className="py-3.5 px-4 font-black text-[#0E8A9E] tabular-nums">
                                                                    {item.value}
                                                                </td>
                                                            </tr>
                                                        ))}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    )}
                                </div>

                                {/* ACORDEÓN 3: DOSIS DIARIA Y MODO DE USO */}
                                <div className="rounded-2xl bg-white border-2 border-purple-100 shadow-xs overflow-hidden">
                                    <button
                                        type="button"
                                        onClick={() => setOpenAccordion(openAccordion === 'dosis' ? '' : 'dosis')}
                                        className="w-full p-5 sm:p-6 flex items-center justify-between text-left hover:bg-[#FAF8FF] transition cursor-pointer"
                                    >
                                        <div className="flex items-center gap-3">
                                            <span className="text-2xl">🥄</span>
                                            <div>
                                                <h3 className="text-base sm:text-lg font-black text-[#311457]">
                                                    Dosis Diaria y Modo de Uso (¿Cuánto dura una bolsa de 250g?)
                                                </h3>
                                                <p className="text-xs sm:text-sm text-slate-500 font-medium">
                                                    Rinde de 25 a 50 días por bolsa según el peso
                                                </p>
                                            </div>
                                        </div>
                                        <ChevronDown
                                            className={`w-5 h-5 text-[#311457] transition-transform ${
                                                openAccordion === 'dosis' ? 'rotate-180' : ''
                                            }`}
                                        />
                                    </button>

                                    {openAccordion === 'dosis' && (
                                        <div className="px-5 pb-6 sm:px-6 sm:pb-6 pt-2 border-t border-purple-100 space-y-4">
                                            <p className="text-sm sm:text-base text-slate-600 leading-relaxed">
                                                Espolvorear directamente sobre su alimento habitual (concentrado seco,
                                                comida húmeda o dieta BARF/natural) una vez al día. Su{' '}
                                                <strong className="text-[#311457]">sabor umami natural</strong> (gracias
                                                a la levadura nutricional y la ahuyama) les encanta a perros y gatos.
                                            </p>

                                            <div className="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                                {DOSAGE_ROWS.map((row) => {
                                                    const isActive = selectedWeightGuide === row.id;
                                                    return (
                                                        <div
                                                            key={row.id}
                                                            onClick={() => {
                                                                setSelectedWeightGuide(row.id);
                                                                setSelectedBundleId(row.recommendedBundle);
                                                            }}
                                                            className={`rounded-xl p-3.5 border-2 transition cursor-pointer ${
                                                                isActive
                                                                    ? 'border-[#311457] bg-[#FAF8FF]'
                                                                    : 'border-slate-200 bg-white hover:border-purple-200'
                                                            }`}
                                                        >
                                                            <p className="text-xs font-black text-[#311457]">
                                                                {row.icon} {row.group}
                                                            </p>
                                                            <p className="mt-1 text-xs font-bold text-slate-700">
                                                                {row.dose}
                                                            </p>
                                                            <p className="mt-1 text-xs font-black text-emerald-700">
                                                                ⏱️ {row.duration}
                                                            </p>
                                                        </div>
                                                    );
                                                })}
                                            </div>
                                        </div>
                                    )}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* 5.5 OPINIONES DE CLIENTES Y VETERINARIOS EN COLOMBIA */}
                <section id="opiniones" className="py-16 lg:py-20 bg-[#FAF8FF] border-t border-purple-100">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center max-w-3xl mx-auto mb-12">
                            <span className="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-black uppercase tracking-wider">
                                ⭐⭐⭐⭐⭐ 4.9 / 5.0 Estrellas en Colombia
                            </span>
                            <h2 className="mt-3 text-2xl sm:text-4xl font-black text-[#311457]">
                                Dueños de Mascotas y Veterinarios que ya comprobaron el cambio
                            </h2>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                            {REVIEWS.map((rev, idx) => (
                                <div
                                    key={idx}
                                    className="rounded-3xl bg-white border-2 border-purple-100 p-6 shadow-md flex flex-col justify-between"
                                >
                                    <div>
                                        <div className="flex items-center justify-between mb-3">
                                            <div className="flex items-center text-amber-400">
                                                <Star className="w-4 h-4 fill-amber-400" />
                                                <Star className="w-4 h-4 fill-amber-400" />
                                                <Star className="w-4 h-4 fill-amber-400" />
                                                <Star className="w-4 h-4 fill-amber-400" />
                                                <Star className="w-4 h-4 fill-amber-400" />
                                            </div>
                                            <span className="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-black">
                                                ✓ Compra Verificada
                                            </span>
                                        </div>
                                        <p className="text-sm text-slate-700 leading-relaxed italic">{rev.text}</p>
                                    </div>
                                    <div className="mt-5 pt-4 border-t border-purple-100">
                                        <p className="font-black text-[#311457] text-sm">{rev.name}</p>
                                        <p className="text-xs font-bold text-[#0E8A9E]">{rev.pet}</p>
                                        <p className="text-[11px] text-slate-500 mt-0.5">
                                            📍 {rev.city} • {rev.kit}
                                        </p>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>

                {/* 6. FORMULARIO DIRECTO DE PEDIDO CONTRAENTREGA EN PÁGINA (CONVERSIÓN DIRECTA SIN FRICCIÓN) */}
                <section id="pedir-contraentrega" className="py-16 lg:py-20 bg-white border-t border-purple-100">
                    <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="rounded-3xl bg-white border-4 border-[#311457] shadow-2xl overflow-hidden">
                            <div className="bg-gradient-to-r from-[#311457] via-[#431B75] to-[#0E8A9E] text-white p-6 sm:p-8 text-center">
                                <span className="inline-block px-3.5 py-1 rounded-full bg-[#FDE68A] text-[#311457] text-xs font-black uppercase tracking-wider">
                                    🚚 ENVÍO GRATIS + PAGO CONTRAENTREGA EN TODA COLOMBIA
                                </span>
                                <h2 className="mt-3 text-2xl sm:text-3xl font-black">
                                    Haz tu Pedido en 30 Segundos y Paga al Recibir en Casa
                                </h2>
                                <p className="mt-1 text-sm sm:text-base text-purple-100">
                                    No necesitas tarjeta de crédito. Pagas en efectivo o transferencia cuando el
                                    transportador te entregue el producto.
                                </p>
                            </div>

                            <form onSubmit={handleSubmitOrder} className="p-6 sm:p-8 space-y-5">
                                {/* Selector de Kit */}
                                <div>
                                    <label className="block text-xs sm:text-sm font-black uppercase tracking-wider text-[#311457] mb-2.5">
                                        1. Selecciona tu Kit con Envío Gratis:
                                    </label>
                                    <div className="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                        {BUNDLES.map((b) => {
                                            const active = selectedBundleId === b.id;
                                            return (
                                                <button
                                                    key={b.id}
                                                    type="button"
                                                    onClick={() => setSelectedBundleId(b.id)}
                                                    className={`p-3.5 rounded-2xl border-2 text-left transition cursor-pointer ${
                                                        active
                                                            ? 'border-[#311457] bg-[#FAF8FF] ring-2 ring-[#311457]/15'
                                                            : 'border-slate-200 bg-white hover:border-purple-200'
                                                    }`}
                                                >
                                                    <div className="flex items-center justify-between">
                                                        <span className="text-xs font-black text-[#311457]">
                                                            {b.bags} {b.bags === 1 ? 'Bolsa' : 'Bolsas'} ({b.grams})
                                                        </span>
                                                        {b.popular && (
                                                            <span className="px-2 py-0.5 rounded bg-amber-500 text-white text-[10px] font-black">
                                                                MÁS VENDIDO
                                                            </span>
                                                        )}
                                                    </div>
                                                    <p className="text-lg font-black text-[#059669] tabular-nums mt-1">
                                                        {b.formattedPrice} COP
                                                    </p>
                                                    <p className="text-[11px] text-slate-500 font-semibold">
                                                        {b.unitPriceText} • Envío Gratis
                                                    </p>
                                                </button>
                                            );
                                        })}
                                    </div>
                                </div>

                                {orderError && (
                                    <div className="rounded-xl bg-rose-50 border border-rose-200 p-3.5 text-xs sm:text-sm font-bold text-rose-700">
                                        {orderError}
                                    </div>
                                )}

                                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label className="block text-xs font-black text-[#311457] mb-1">
                                            Nombre Completo *
                                        </label>
                                        <input
                                            type="text"
                                            required
                                            value={customerName}
                                            onChange={(e) => setCustomerName(e.target.value)}
                                            placeholder="Ej: Carolina Martínez"
                                            className="w-full rounded-xl border-2 border-slate-200 px-4 py-3 text-sm font-medium focus:border-[#311457] focus:outline-none"
                                        />
                                    </div>
                                    <div>
                                        <label className="block text-xs font-black text-[#311457] mb-1">
                                            WhatsApp / Celular *
                                        </label>
                                        <input
                                            type="tel"
                                            required
                                            value={customerPhone}
                                            onChange={(e) => setCustomerPhone(e.target.value)}
                                            placeholder="Ej: 300 123 4567"
                                            className="w-full rounded-xl border-2 border-slate-200 px-4 py-3 text-sm font-medium focus:border-[#311457] focus:outline-none"
                                        />
                                    </div>
                                </div>

                                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label className="block text-xs font-black text-[#311457] mb-1">
                                            Departamento *
                                        </label>
                                        <select
                                            value={department}
                                            onChange={(e) => setDepartment(e.target.value)}
                                            className="w-full rounded-xl border-2 border-slate-200 px-4 py-3 text-sm font-medium bg-white focus:border-[#311457] focus:outline-none"
                                        >
                                            {COLOMBIAN_DEPARTMENTS.map((dep) => (
                                                <option key={dep} value={dep}>
                                                    {dep}
                                                </option>
                                            ))}
                                        </select>
                                    </div>
                                    <div>
                                        <label className="block text-xs font-black text-[#311457] mb-1">
                                            Ciudad / Municipio *
                                        </label>
                                        <input
                                            type="text"
                                            required
                                            value={city}
                                            onChange={(e) => setCity(e.target.value)}
                                            placeholder="Ej: Medellín, Bogotá, Cali..."
                                            className="w-full rounded-xl border-2 border-slate-200 px-4 py-3 text-sm font-medium focus:border-[#311457] focus:outline-none"
                                        />
                                    </div>
                                </div>

                                <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div className="sm:col-span-2">
                                        <label className="block text-xs font-black text-[#311457] mb-1">
                                            Dirección Exacta de Entrega (Calle/Carrera, #, Apto/Casa) *
                                        </label>
                                        <input
                                            type="text"
                                            required
                                            value={address}
                                            onChange={(e) => setAddress(e.target.value)}
                                            placeholder="Ej: Calle 85 # 15-24 Apto 402"
                                            className="w-full rounded-xl border-2 border-slate-200 px-4 py-3 text-sm font-medium focus:border-[#311457] focus:outline-none"
                                        />
                                    </div>
                                    <div>
                                        <label className="block text-xs font-black text-[#311457] mb-1">
                                            Barrio / Conjunto
                                        </label>
                                        <input
                                            type="text"
                                            value={neighborhood}
                                            onChange={(e) => setNeighborhood(e.target.value)}
                                            placeholder="Ej: El Poblado"
                                            className="w-full rounded-xl border-2 border-slate-200 px-4 py-3 text-sm font-medium focus:border-[#311457] focus:outline-none"
                                        />
                                    </div>
                                </div>

                                <button
                                    type="submit"
                                    disabled={isSubmitting}
                                    className="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-[#059669] via-[#10B981] to-[#059669] hover:from-[#047857] hover:to-[#047857] text-white font-black text-base sm:text-xl shadow-xl shadow-emerald-600/30 border-b-4 border-[#047857] flex items-center justify-center gap-3 transition cursor-pointer"
                                >
                                    <ShoppingBag className="w-6 h-6" />
                                    <span>
                                        {isSubmitting
                                            ? 'Procesando tu pedido...'
                                            : `🛒 CONFIRMAR PEDIDO CONTRAENTREGA (${activeBundle.formattedPrice} COP)`}
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </section>

                {/* 7. PREGUNTAS FRECUENTES (FAQ) */}
                <section id="faq" className="py-16 lg:py-20 bg-[#FAF8FF] border-t border-purple-100">
                    <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center mb-10">
                            <span className="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#311457]/10 text-[#311457] text-xs font-black uppercase tracking-wider">
                                Preguntas Frecuentes (FAQ)
                            </span>
                            <h2 className="mt-3 text-2xl sm:text-3xl font-black text-[#311457]">
                                Resolvemos tus dudas sobre AVIPET BioLab® — Dermo &amp; Gut Superboost
                            </h2>
                        </div>

                        <div className="space-y-4">
                            {FAQS.map((faq, idx) => {
                                const isOpen = openFaqIdx === idx;
                                return (
                                    <div
                                        key={idx}
                                        className="rounded-2xl border-2 border-purple-100 bg-white overflow-hidden shadow-xs"
                                    >
                                        <button
                                            type="button"
                                            onClick={() => setOpenFaqIdx(isOpen ? -1 : idx)}
                                            className="w-full p-5 sm:p-6 flex items-center justify-between text-left hover:bg-[#FAF8FF] transition cursor-pointer"
                                        >
                                            <span className="text-base sm:text-lg font-black text-[#311457] pr-4">
                                                {faq.question}
                                            </span>
                                            <ChevronDown
                                                className={`w-5 h-5 text-[#311457] shrink-0 transition-transform ${
                                                    isOpen ? 'rotate-180' : ''
                                                }`}
                                            />
                                        </button>

                                        {isOpen && (
                                            <div className="px-5 pb-6 sm:px-6 sm:pb-6 pt-2 border-t border-purple-50 bg-white">
                                                {faq.answerParts ? (
                                                    <div className="space-y-3 mt-2">
                                                        {faq.answerParts.map((part, pIdx) => (
                                                            <div
                                                                key={pIdx}
                                                                className="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 p-3.5 rounded-xl bg-[#FAF8FF] border border-purple-100"
                                                            >
                                                                <span className="inline-flex items-center px-3 py-1 rounded-lg bg-[#311457] text-[#FDE68A] text-xs font-black shrink-0">
                                                                    {part.badge}:
                                                                </span>
                                                                <p className="text-sm text-slate-700 font-medium">
                                                                    {part.text}
                                                                </p>
                                                            </div>
                                                        ))}
                                                    </div>
                                                ) : (
                                                    <p className="text-sm sm:text-base text-slate-600 leading-relaxed mt-2">
                                                        {faq.answer}
                                                    </p>
                                                )}
                                            </div>
                                        )}
                                    </div>
                                );
                            })}
                        </div>
                    </div>
                </section>

                {/* FOOTER OFICIAL */}
                <footer className="bg-[#240B46] text-purple-200 py-12 border-t border-white/10 text-xs sm:text-sm">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-6">
                        <div className="flex items-center gap-3.5">
                            <img
                                src="/images/biolab/logo-avipet-biolab.jpg"
                                alt="AviPet BioLab®"
                                className="w-12 h-12 rounded-full object-cover border-2 border-[#FDE68A]"
                            />
                            <div>
                                <p className="text-white font-black text-base">
                                    AVIPET BioLab® — Nutrición Clínica Dermo-Digestiva
                                </p>
                                <p className="text-xs text-purple-200">
                                    Envíos Gratis y Pago Contraentrega en toda Colombia • División de AviPetApp
                                </p>
                            </div>
                        </div>
                        <div className="flex flex-wrap items-center justify-center gap-4 text-xs font-bold">
                            <a href={storeHomeUrl} className="text-[#FDE68A] hover:underline">
                                ← Tienda General AVIPET BioLab®
                            </a>
                            <span>•</span>
                            <a href="https://avipetapp.com" className="hover:text-white transition">
                                Software Veterinario AviPetApp
                            </a>
                        </div>
                    </div>
                </footer>

                {/* BARRA FIJA INFERIOR DE CONVERSIÓN (STICKY BAR) */}
                <div className="fixed bottom-0 inset-x-0 z-40 bg-white/95 backdrop-blur-md border-t-2 border-purple-200 py-3 px-4 shadow-2xl">
                    <div className="max-w-7xl mx-auto flex items-center justify-between gap-3">
                        <div className="flex items-center gap-3 min-w-0">
                            <img
                                src="/images/biolab/empaque-frente-250g.jpg"
                                alt="Dermo & Gut Superboost 250g"
                                className="w-12 h-12 rounded-xl object-contain bg-[#FAF8FF] border border-purple-200 hidden sm:block shrink-0"
                            />
                            <div className="min-w-0">
                                <p className="text-xs sm:text-sm font-black text-[#311457] truncate">
                                    {activeBundle.name}
                                </p>
                                <div className="flex items-center gap-2 text-xs">
                                    <span className="font-black text-[#059669] text-sm sm:text-base tabular-nums">
                                        {activeBundle.formattedPrice} COP
                                    </span>
                                    <span className="text-slate-400 line-through tabular-nums hidden sm:inline font-bold">
                                        {activeBundle.formattedCompareAt}
                                    </span>
                                    <span className="text-[#0E8A9E] font-extrabold">
                                        • Envío Gratis + Contraentrega
                                    </span>
                                </div>
                            </div>
                        </div>

                        <button
                            type="button"
                            onClick={() => handleOpenCheckout()}
                            className="px-5 sm:px-7 py-3 rounded-xl bg-[#059669] hover:bg-[#047857] text-white font-black text-xs sm:text-sm shadow-lg shadow-emerald-600/30 flex items-center gap-2 transition cursor-pointer shrink-0"
                        >
                            <ShoppingBag className="w-4 h-4" />
                            <span>¡Pedir y Pagar en Casa!</span>
                        </button>
                    </div>
                </div>

                {/* LIGHTBOX DE ZOOM */}
                {isZoomOpen && (
                    <div
                        className="fixed inset-0 z-50 bg-black/85 backdrop-blur-sm flex items-center justify-center p-4"
                        onClick={() => setIsZoomOpen(false)}
                    >
                        <div
                            className="relative max-w-3xl w-full flex flex-col items-center"
                            onClick={(e) => e.stopPropagation()}
                        >
                            <button
                                type="button"
                                onClick={() => setIsZoomOpen(false)}
                                className="absolute -top-3 -right-3 z-10 w-10 h-10 rounded-full bg-[#311457] text-white flex items-center justify-center shadow-lg cursor-pointer"
                            >
                                <X className="w-5 h-5" />
                            </button>
                            <img
                                src={GALLERY_IMAGES[activeImageIdx].src}
                                alt={GALLERY_IMAGES[activeImageIdx].alt}
                                className="max-h-[82vh] w-auto rounded-2xl object-contain bg-white shadow-2xl"
                            />
                        </div>
                    </div>
                )}

                {/* MODAL DE PEDIDO CONTRAENTREGA */}
                {isCheckoutModalOpen && (
                    <div className="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-black/75 backdrop-blur-xs overflow-y-auto">
                        <div className="relative w-full max-w-xl rounded-3xl bg-white text-[#1E1035] shadow-2xl border-2 border-purple-200 overflow-hidden my-8">
                            <div className="bg-gradient-to-r from-[#311457] to-[#0E8A9E] text-white px-6 py-4 flex items-center justify-between">
                                <div className="flex items-center gap-3">
                                    <img
                                        src="/images/biolab/logo-avipet-biolab.jpg"
                                        alt="AviPet BioLab®"
                                        className="w-10 h-10 rounded-full object-cover border border-[#FDE68A]"
                                    />
                                    <div>
                                        <span className="text-[11px] font-black uppercase tracking-wider text-[#FDE68A] flex items-center gap-1">
                                            <Truck className="w-3.5 h-3.5" />
                                            Envío Gratis + Pago Contraentrega
                                        </span>
                                        <h3 className="text-base sm:text-lg font-black text-white">
                                            Pedir Ahora y Pagar en Casa
                                        </h3>
                                    </div>
                                </div>
                                <button
                                    type="button"
                                    onClick={() => {
                                        setIsCheckoutModalOpen(false);
                                        setOrderSuccess(null);
                                    }}
                                    className="p-1.5 rounded-lg text-white/80 hover:text-white hover:bg-white/10 transition cursor-pointer"
                                >
                                    <X className="w-5 h-5" />
                                </button>
                            </div>

                            {orderSuccess ? (
                                <div className="p-6 sm:p-8 text-center space-y-5">
                                    <div className="w-16 h-16 rounded-full bg-emerald-100 text-[#059669] flex items-center justify-center mx-auto">
                                        <CheckCircle2 className="w-10 h-10" />
                                    </div>
                                    <div>
                                        <span className="inline-block px-3 py-1 rounded-full bg-emerald-50 text-[#059669] text-xs font-black">
                                            ORDEN REGISTRADA • {orderSuccess.order_code}
                                        </span>
                                        <h4 className="mt-2 text-2xl font-black text-[#311457]">
                                            ¡Tu pedido contraentrega está listo!
                                        </h4>
                                        <p className="mt-1 text-sm text-slate-600">
                                            Hemos registrado tu despacho de{' '}
                                            <strong className="text-[#311457]">{orderSuccess.bundle_title}</strong> por{' '}
                                            <strong className="text-[#059669]">{orderSuccess.formatted_total}</strong>{' '}
                                            (Envío Gratis).
                                        </p>
                                    </div>

                                    <div className="rounded-2xl bg-[#FAF8FF] p-4 border border-purple-100 text-left text-xs sm:text-sm space-y-1.5">
                                        <p>
                                            <strong>Cliente:</strong> {customerName} ({customerPhone})
                                        </p>
                                        <p>
                                            <strong>Destino:</strong> {address}, {city} ({department})
                                        </p>
                                        <p>
                                            <strong>Pago:</strong> 100% Contraentrega al transportador (
                                            {orderSuccess.formatted_total})
                                        </p>
                                    </div>

                                    <a
                                        href={orderSuccess.whatsapp_url}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="w-full py-4 px-6 rounded-2xl bg-[#059669] hover:bg-[#047857] text-white font-black text-base flex items-center justify-center gap-2.5 shadow-lg transition"
                                    >
                                        <MessageCircle className="w-5 h-5" />
                                        <span>Confirmar Despacho Prioritario por WhatsApp</span>
                                    </a>
                                </div>
                            ) : (
                                <form
                                    onSubmit={handleSubmitOrder}
                                    className="p-5 sm:p-6 space-y-4 max-h-[80vh] overflow-y-auto"
                                >
                                    <div className="rounded-2xl bg-[#FAF8FF] p-3.5 border border-purple-100">
                                        <label className="block text-xs font-black uppercase text-[#311457] mb-2">
                                            1. Confirma tu Kit con Envío Gratis:
                                        </label>
                                        <div className="grid grid-cols-3 gap-2">
                                            {BUNDLES.map((b) => (
                                                <button
                                                    key={b.id}
                                                    type="button"
                                                    onClick={() => setSelectedBundleId(b.id)}
                                                    className={`p-2.5 rounded-xl border-2 text-left transition cursor-pointer ${
                                                        selectedBundleId === b.id
                                                            ? 'border-[#311457] bg-white shadow-xs'
                                                            : 'border-slate-200 bg-white/60 text-slate-500'
                                                    }`}
                                                >
                                                    <p className="text-xs font-black text-[#311457]">
                                                        {b.bags} {b.bags === 1 ? 'Bolsa' : 'Bolsas'} ({b.grams})
                                                    </p>
                                                    <p className="text-xs font-black text-[#059669] tabular-nums mt-0.5">
                                                        {b.formattedPrice}
                                                    </p>
                                                </button>
                                            ))}
                                        </div>
                                    </div>

                                    {orderError && (
                                        <div className="rounded-xl bg-rose-50 border border-rose-200 p-3 text-xs font-bold text-rose-700">
                                            {orderError}
                                        </div>
                                    )}

                                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                        <div>
                                            <label className="block text-xs font-black text-[#311457] mb-1">
                                                Nombre Completo *
                                            </label>
                                            <input
                                                type="text"
                                                required
                                                value={customerName}
                                                onChange={(e) => setCustomerName(e.target.value)}
                                                placeholder="Ej: Carolina Martínez"
                                                className="w-full rounded-xl border-2 border-slate-200 px-3.5 py-2.5 text-sm focus:border-[#311457] focus:outline-none"
                                            />
                                        </div>
                                        <div>
                                            <label className="block text-xs font-black text-[#311457] mb-1">
                                                WhatsApp / Celular *
                                            </label>
                                            <input
                                                type="tel"
                                                required
                                                value={customerPhone}
                                                onChange={(e) => setCustomerPhone(e.target.value)}
                                                placeholder="Ej: 300 123 4567"
                                                className="w-full rounded-xl border-2 border-slate-200 px-3.5 py-2.5 text-sm focus:border-[#311457] focus:outline-none"
                                            />
                                        </div>
                                    </div>

                                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                        <div>
                                            <label className="block text-xs font-black text-[#311457] mb-1">
                                                Departamento *
                                            </label>
                                            <select
                                                value={department}
                                                onChange={(e) => setDepartment(e.target.value)}
                                                className="w-full rounded-xl border-2 border-slate-200 px-3.5 py-2.5 text-sm bg-white focus:border-[#311457] focus:outline-none"
                                            >
                                                {COLOMBIAN_DEPARTMENTS.map((dep) => (
                                                    <option key={dep} value={dep}>
                                                        {dep}
                                                    </option>
                                                ))}
                                            </select>
                                        </div>
                                        <div>
                                            <label className="block text-xs font-black text-[#311457] mb-1">
                                                Ciudad / Municipio *
                                            </label>
                                            <input
                                                type="text"
                                                required
                                                value={city}
                                                onChange={(e) => setCity(e.target.value)}
                                                placeholder="Ej: Medellín, Bogotá, Cali..."
                                                className="w-full rounded-xl border-2 border-slate-200 px-3.5 py-2.5 text-sm focus:border-[#311457] focus:outline-none"
                                            />
                                        </div>
                                    </div>

                                    <div className="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                                        <div className="sm:col-span-2">
                                            <label className="block text-xs font-black text-[#311457] mb-1">
                                                Dirección Exacta de Entrega *
                                            </label>
                                            <input
                                                type="text"
                                                required
                                                value={address}
                                                onChange={(e) => setAddress(e.target.value)}
                                                placeholder="Calle / Carrera, Número, Apto / Casa"
                                                className="w-full rounded-xl border-2 border-slate-200 px-3.5 py-2.5 text-sm focus:border-[#311457] focus:outline-none"
                                            />
                                        </div>
                                        <div>
                                            <label className="block text-xs font-black text-[#311457] mb-1">
                                                Barrio
                                            </label>
                                            <input
                                                type="text"
                                                value={neighborhood}
                                                onChange={(e) => setNeighborhood(e.target.value)}
                                                placeholder="Ej: El Poblado"
                                                className="w-full rounded-xl border-2 border-slate-200 px-3.5 py-2.5 text-sm focus:border-[#311457] focus:outline-none"
                                            />
                                        </div>
                                    </div>

                                    <button
                                        type="submit"
                                        disabled={isSubmitting}
                                        className="w-full py-4 px-6 rounded-2xl bg-[#059669] hover:bg-[#047857] text-white font-black text-base shadow-lg flex items-center justify-center gap-2 transition cursor-pointer"
                                    >
                                        <ShoppingBag className="w-5 h-5" />
                                        <span>
                                            {isSubmitting
                                                ? 'Registrando tu despacho...'
                                                : `Confirmar Pedido Contraentrega (${activeBundle.formattedPrice} COP)`}
                                        </span>
                                    </button>
                                </form>
                            )}
                        </div>
                    </div>
                )}
            </div>
        </>
    );
}
