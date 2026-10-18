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
    HeartPulse,
    Flame,
    Gift,
    Lock,
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
    badge?: string;
    badgeColor?: string;
    icon: 'single' | 'fire' | 'trophy';
    name: string;
    subtitle: string;
    bags: number;
    grams: string;
    price: number;
    formattedPrice: string;
    compareAtPrice: number;
    formattedCompareAt: string;
    savings: string;
    unitPriceText: string;
    dailyCostText: string;
    durationText: string;
    recommendedFor: string;
    vipBonus?: string;
}

const BUNDLES: BundleOption[] = [
    {
        id: '1_bolsa',
        badge: 'PRECIO DE LANZAMIENTO',
        badgeColor: 'bg-[#0E7490] text-white',
        icon: 'single',
        name: '1 Bolsa — Precio de Lanzamiento (250g)',
        subtitle: 'Tratamiento para 25 a 50 días según el peso',
        bags: 1,
        grams: '250g',
        price: 69900,
        formattedPrice: '$69.900 COP',
        compareAtPrice: 87700,
        formattedCompareAt: '$87.700 COP',
        savings: 'Ahorras $17.800 COP frente a tarros tradicionales de solo Omega 3',
        unitPriceText: '$69.900 c/u',
        dailyCostText: 'Desde $1.398 COP / día',
        durationText: '25 a 50 días',
        recommendedFor: 'Ideal para Gatos y Perros Pequeños (1 a 10 kg)',
    },
    {
        id: '2_bolsas',
        badge: '🔥 OFERTA DÚO CLÍNICO • MÁS ELEGIDO EN COLOMBIA',
        badgeColor: 'bg-gradient-to-r from-[#6D28D9] to-[#A855F7] text-white',
        icon: 'fire',
        name: 'Oferta Dúo Clínico (2 Bolsas - 500g)',
        subtitle: 'Recomendado para Perros Medianos/Grandes',
        bags: 2,
        grams: '500g',
        price: 124900,
        formattedPrice: '$124.900 COP',
        compareAtPrice: 175400,
        formattedCompareAt: '$175.400 COP',
        savings: 'Ahorras $14.900 COP — Te sale a $62.450 c/u',
        unitPriceText: '$62.450 c/u',
        dailyCostText: 'Desde $1.249 COP / día',
        durationText: '50 a 100 días',
        recommendedFor: 'Ideal para Perros Medianos (11 a 25 kg) o regeneración dérmica profunda',
        vipBonus: '🎁 Incluye Guía Digital Clínica Dermo-Digestiva + Despacho Prioritario',
    },
    {
        id: '3_bolsas',
        badge: '🏆 TRATAMIENTO COMPLETO 90 DÍAS • MÁXIMO AHORRO CLÍNICO',
        badgeColor: 'bg-[#0F9F9A] text-white',
        icon: 'trophy',
        name: 'Tratamiento Completo 90 Días (3 Bolsas - 750g)',
        subtitle: 'Regeneración inmunológica, cutánea y digestiva total',
        bags: 3,
        grams: '750g',
        price: 169900,
        formattedPrice: '$169.900 COP',
        compareAtPrice: 263100,
        formattedCompareAt: '$263.100 COP',
        savings: 'Ahorras $39.800 COP — Te sale a $56.633 c/u',
        unitPriceText: '$56.633 c/u',
        dailyCostText: 'Desde $1.132 COP / día',
        durationText: '75 a 150 días',
        recommendedFor: 'Ideal para Perros Grandes (+25 kg), hogares multi-mascota o alergia crónica',
        vipBonus: '🎁 Incluye Guía Digital Clínica + Prioridad de Laboratorio + Máximo Ahorro',
    },
];

const GALLERY_IMAGES = [
    {
        src: '/images/biolab/empaque-frente-250g.jpg',
        alt: 'AVIPET BioLab® — Dermo & Gut Superboost (250g) Empaque Oficial Doypack',
        tag: 'Empaque Oficial 250g',
        caption: 'AVIPET BioLab® — Dermo & Gut Superboost (250g): Micro-Proteína Novel + Ácido Láurico.',
        fit: 'object-contain bg-white',
    },
    {
        src: '/images/biolab/empaque-frente-reverso.jpg',
        alt: 'AVIPET BioLab® — Frente y Reverso del Empaque con Tabla Nutricional y Dosis',
        tag: 'Frente y Reverso (Ficha)',
        caption: 'Empaque Doypack Zipper hermético: Composición garantizada, tabla nutricional y dosis.',
        fit: 'object-contain bg-white',
    },
    {
        src: '/images/biolab/banner-hero-oficial.jpg',
        alt: 'AVIPET BioLab® — Nutrición Clínica Dermo-Digestiva para Perros y Gatos',
        tag: 'Perros y Gatos (3 en 1)',
        caption: 'Nutrición Clínica Dermo-Digestiva: Alivia picazón, hongos y caída de pelo.',
        fit: 'object-cover bg-[#080B20]',
    },
    {
        src: '/images/biolab/afiche-beneficios-dermatitis.jpg',
        alt: 'AVIPET BioLab® — La Revolución contra la Dermatitis y la Picazón ($69.900 Envío Gratis)',
        tag: 'Acción Dermo-Activa',
        caption: 'Corta la picazón desde la raíz, combate hongos y bacterias con Ácido Láurico natural.',
        fit: 'object-contain bg-white',
    },
    {
        src: '/images/biolab/logo-avipet-biolab.jpg',
        alt: 'Sello Oficial AviPet BioLab® — Nutrición Clínica Dermo-Digestiva',
        tag: 'Sello AviPet BioLab®',
        caption: 'División especializada en Biotecnología Nutricional Veterinaria de AviPetApp.',
        fit: 'object-contain bg-[#080B20]',
    },
];

const CLINICAL_TIMELINE = [
    {
        phase: 'FASE 1 • DÍAS 1 A 7',
        title: 'Equilibrio Microbiótico, Heces Firmes y Aliento Fresco',
        badge: 'Resultados desde la 1.ª Semana',
        accent: 'border-[#35DDF5]/40 text-[#35DDF5] bg-[#35DDF5]/10',
        description:
            'La pectina prebiótica de ahuyama, los MOS/Betaglucanos de Saccharomyces cerevisiae y la clorofila activa de perejil colonizan el tracto gastrointestinal, compactando las heces, reduciendo flatulencias y neutralizando compuestos sulfurados del mal aliento.',
        metrics: ['+88% consistencia fecal', 'Reducción de halitosis estomacal', '98.4% aceptación umami'],
    },
    {
        phase: 'FASE 2 • SEMANAS 2 A 3',
        title: 'Bloqueo Histamínico y Control de Malassezia (Patas y Oídos)',
        badge: 'Alivio de Picazón y Enrojecimiento',
        accent: 'border-[#A855F7]/40 text-[#A855F7] bg-[#A855F7]/10',
        description:
            'Al recibir péptidos limpios de Hermetia illucens sin memoria alérgica junto con Ácido Láurico (C12:0 al 4.5%) y curcumina bioactiva, disminuye la cascada inflamatoria cutánea, frenando el rascado compulsivo, el mal olor seborreico y el lamido oxidativo de patas.',
        metrics: ['Disminución del prurito', 'Control de levaduras y bacterias', 'Piel menos roja e irritada'],
    },
    {
        phase: 'FASE 3 • SEMANA 4 EN ADELANTE',
        title: 'Regeneración Folicular y Blindaje Inmunológico Dermo-Digestivo',
        badge: 'Pelaje Denso, Fuerte y Brillante',
        accent: 'border-emerald-400/40 text-emerald-300 bg-emerald-500/10',
        description:
            'Los ácidos grasos esenciales Omega 3, 6 y 9 de la linaza dorada junto a la Biotina natural restauran la capa lipídica de la epidermis, frenando la caída excesiva y estimulando el crecimiento de pelo nuevo en zonas alopécicas.',
        metrics: ['Frenado de caída excesiva', 'Brillo espejo en el manto', 'Inmunidad intestinal blindada'],
    },
];

const BIO_ACTIVES_BENTO = [
    {
        code: 'BIO-01',
        name: 'Micro-Proteína Novel Purificada',
        scientific: 'Hermetia illucens (40.0% Proteína Pura)',
        role: 'Inmunomodulación Hipoalergénica',
        badge: 'MATRIZ DERMO-ACTIVA',
        badgeStyle: 'bg-[#35DDF5]/15 text-[#35DDF5] border-[#35DDF5]/30',
        description:
            'Estructura de aminoácidos esenciales de bajo peso molecular que el sistema inmunológico del perro y gato no reconoce como alérgeno, evitando los brotes causados por el pollo o la res.',
    },
    {
        code: 'BIO-02',
        name: 'Ácido Láurico Natural (C12:0)',
        scientific: '4.5% Garantizado en Matriz Lipídica',
        role: 'Antihongos (Malassezia) y Antibacteriano',
        badge: 'ACCIÓN ANTIMICROBIANA',
        badgeStyle: 'bg-[#A855F7]/15 text-[#A855F7] border-[#A855F7]/30',
        description:
            'Ácido graso de cadena media que se transforma en monolaurina, destruyendo la membrana lipídica de hongos (Malassezia pachydermatis) y bacterias causantes del mal olor y lamido de patas.',
    },
    {
        code: 'BIO-03',
        name: 'Semilla de Linaza Dorada Molida',
        scientific: 'Linum usitatissimum (Omega 3, 6 y 9)',
        role: 'Regeneración de Barrera Cutánea y Folicular',
        badge: 'OMEGA BIO-ESTABLE',
        badgeStyle: 'bg-amber-400/15 text-amber-300 border-amber-400/30',
        description:
            'Aporta ácido alfa-linolénico (ALA) protegido dentro del empaque Doypack Zipper anti-oxidación para nutrir el folículo piloso, frenar la caída del pelo y devolver la elasticidad dérmica.',
    },
    {
        code: 'BIO-04',
        name: 'Levadura Nutricional Inactiva',
        scientific: 'Saccharomyces cerevisiae (MOS + Betaglucanos)',
        role: 'Blindaje de Flora Intestinal y Biotina',
        badge: 'COMPLEJO GUT-CARE',
        badgeStyle: 'bg-emerald-400/15 text-emerald-300 border-emerald-400/30',
        description:
            'Rica en Manano-Oligosacáridos (MOS), Betaglucanos inmunomoduladores y vitaminas del complejo B (Biotina). Aporta además un exquisito sabor umami natural sin usar saborizantes de pollo.',
    },
    {
        code: 'BIO-05',
        name: 'Fibra Soluble de Ahuyama',
        scientific: 'Cucurbita moschata (Pectina Prebiótica)',
        role: 'Compactación de Heces y Tránsito Digestivo',
        badge: 'PREBIÓTICO CLÍNICO',
        badgeStyle: 'bg-[#35DDF5]/15 text-[#35DDF5] border-[#35DDF5]/30',
        description:
            'Regula la absorción de agua en el colon, nutriendo las bacterias benéficas (Lactobacillus y Bifidobacterium) para lograr heces firmes y sin diarreas desde la primera semana.',
    },
    {
        code: 'BIO-06',
        name: 'Extracto de Cúrcuma + Perejil Activo',
        scientific: 'Curcuma longa + Petroselinum crispum',
        role: 'Antiinflamatorio Celular y Detox de Aliento',
        badge: 'FITOTERAPIA DUAL',
        badgeStyle: 'bg-[#A855F7]/15 text-[#A855F7] border-[#A855F7]/30',
        description:
            'Los curcuminoides modulan las citoquinas proinflamatorias en piel y articulaciones, mientras la clorofila activa del perejil deshidratado captura toxinas estomacales y bucales.',
    },
];

const VERIFIED_REVIEWS = [
    {
        name: 'Dra. Valentina Restrepo, MVZ',
        city: 'Medellín, Antioquia',
        pet: 'Práctica Clínica Dermatológica',
        bundle: 'Recomendación Profesional',
        quote:
            '“Muchos pacientes alérgicos recaían porque los suplementos de piel venían saborizados con hígado de pollo o subproductos. Con Dermo & Gut Superboost de AVIPET BioLab® tenemos una proteína novel real (Hermetia illucens) con 4.5% de Ácido Láurico que ataca el eje intestino-piel sin disparar histamina.”',
        highlight: 'Criterio Médico Veterinario',
    },
    {
        name: 'Camilo Andrés Gómez',
        city: 'Bogotá D.C.',
        pet: 'Bruno • Bulldog Francés (14 kg)',
        bundle: 'Compró Oferta Dúo Clínico (2 Bolsas)',
        quote:
            '“Bruno se lamía las patas hasta dejárselas rojas y tenía heces blandas casi todas las semanas. Al quinto día de espolvorearle el polvo sobre su comida las heces se compactaron, y a la tercera semana dejó de rascarse las orejas. Pagué contraentrega en Chapinero sin problema.”',
        highlight: 'Alivio de lamido de patas y digestión',
    },
    {
        name: 'Laura Sofía Domínguez',
        city: 'Cali, Valle del Cauca',
        pet: 'Mia (Golden Retriever) y Theo (Gato)',
        bundle: 'Compró Tratamiento 90 Días (3 Bolsas)',
        quote:
            '“Había probado tarros de Omega 3 que se oxidaban y olían a pescado rancio a los 15 días. El empaque Doypack de AVIPET BioLab mantiene el polvo súper fresco, les encanta el sabor y el pelo de Mia dejó de caerse por mechones. Además el aliento le cambió por completo.”',
        highlight: 'Frenó caída de pelo y mal aliento',
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
        biolab: 'Sí',
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
        group: 'Gatos y Perros Pequeños (1 a 10 kg)',
        dose: '1 cuchara dosificadora rasa (5g) al día',
        duration: '50 días de tratamiento',
        recommendedBundle: '1_bolsa' as BundleId,
    },
    {
        id: 'medium',
        group: 'Perros Medianos (11 a 25 kg)',
        dose: '1 a 2 cucharas dosificadoras (5g a 10g) al día',
        duration: '25 a 50 días de tratamiento',
        recommendedBundle: '2_bolsas' as BundleId,
    },
    {
        id: 'large',
        group: 'Perros Grandes (+25 kg)',
        dose: '2 cucharas dosificadoras (10g) al día',
        duration: '25 días de tratamiento',
        recommendedBundle: '3_bolsas' as BundleId,
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

    // Estado del formulario de Pedido Contraentrega
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
            `💰 *Valor:* ${bundle.formattedPrice} (Envío Gratis)\n\n` +
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
                formatted_total: activeBundle.formattedPrice,
                bundle_title: activeBundle.name,
            });
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

            <div className="min-h-screen bg-[#F4F7FC] text-[#15213B] font-sans pb-24 selection:bg-[#6D28D9] selection:text-white">
                {/* 0. BARRA EJECUTIVA DE TELEMETRÍA Y LANZAMIENTO DE MARCA */}
                <div className="bg-[#080B20] border-b border-white/10 text-white text-xs py-2.5 px-4">
                    <div className="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-x-6 gap-y-1.5">
                        <div className="flex items-center gap-2 mx-auto lg:mx-0">
                            <span className="inline-flex h-2 w-2 rounded-full bg-emerald-400 animate-pulse" />
                            <span className="font-bold tracking-wider uppercase text-[11px] text-emerald-300">
                                LOTE CLÍNICO FRESCO #BL-2026-10 • DISPONIBLE EN COLOMBIA
                            </span>
                        </div>
                        <div className="flex flex-wrap items-center justify-center gap-x-5 gap-y-1 mx-auto lg:mx-0 font-medium">
                            <span className="inline-flex items-center gap-1.5 text-[#35DDF5] font-semibold">
                                <Truck className="w-3.5 h-3.5 shrink-0" />
                                🚚 ENVÍO GRATIS + PAGO CONTRAENTREGA NACIONAL
                            </span>
                            <span className="hidden md:inline text-white/25">|</span>
                            <span className="hidden sm:inline-flex items-center gap-1.5 text-slate-200">
                                <Microscope className="w-3.5 h-3.5 text-[#A855F7] shrink-0" />
                                0% Pollo • 0% Res • 0% Soya • 100% Libre de Gluten
                            </span>
                        </div>
                    </div>
                </div>

                {/* 1. CABECERA OFICIAL AVIPET BioLab® */}
                <header className="sticky top-0 z-40 bg-[#080B20]/95 backdrop-blur-xl border-b border-white/10 shadow-lg">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between gap-4">
                        <div className="flex items-center gap-3">
                            <a href={storeHomeUrl} className="flex items-center gap-3 group">
                                <img
                                    src="/images/biolab/logo-avipet-biolab.jpg"
                                    alt="AviPet BioLab®"
                                    className="w-11 h-11 rounded-full object-cover border-2 border-[#35DDF5]/50 shadow-md group-hover:border-[#35DDF5] transition"
                                />
                                <div className="flex flex-col">
                                    <div className="flex items-center gap-1.5">
                                        <span className="text-base sm:text-lg font-extrabold tracking-tight text-white">
                                            AviPet
                                        </span>
                                        <span className="text-base sm:text-lg font-extrabold tracking-tight text-[#35DDF5]">
                                            BioLab®
                                        </span>
                                        <span className="hidden sm:inline-block ml-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-widest bg-[#6D28D9]/30 border border-[#A855F7]/40 text-[#35DDF5]">
                                            FLAGSHIP LAUNCH
                                        </span>
                                    </div>
                                    <span className="text-[11px] text-slate-300 font-medium">
                                        Nutrición Clínica Dermo-Digestiva
                                    </span>
                                </div>
                            </a>
                        </div>

                        <nav className="hidden xl:flex items-center gap-5 text-xs font-semibold uppercase tracking-wider text-slate-300">
                            <a
                                href={storeHomeUrl}
                                className="px-3 py-1.5 rounded-lg bg-white/5 hover:bg-white/10 text-white border border-white/10 transition"
                            >
                                ← Tienda General
                            </a>
                            <a href="#cronologia" className="hover:text-[#35DDF5] transition">
                                Cronología 30 Días
                            </a>
                            <a href="#bioactivos" className="hover:text-[#35DDF5] transition">
                                6 Bio-Activos
                            </a>
                            <a href="#comparativa" className="hover:text-[#35DDF5] transition">
                                Comparativa
                            </a>
                            <a href="#ficha-tecnica" className="hover:text-[#35DDF5] transition">
                                Ficha y Dosis
                            </a>
                            <a href="#testimonios" className="hover:text-[#35DDF5] transition">
                                Casos Reales
                            </a>
                        </nav>

                        <div className="flex items-center gap-2.5">
                            <a
                                href={buildDirectWhatsAppUrl(activeBundle)}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="hidden sm:inline-flex items-center gap-2 px-3.5 py-2 rounded-xl border border-emerald-400/40 bg-emerald-500/10 text-emerald-300 hover:bg-emerald-500/20 text-xs sm:text-sm font-semibold transition"
                            >
                                <MessageCircle className="w-4 h-4" />
                                WhatsApp Clínico
                            </a>
                            <button
                                type="button"
                                onClick={() => handleOpenCheckout()}
                                className="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-[#6D28D9] to-[#7C3AED] hover:from-[#5B21B6] hover:to-[#6D28D9] text-white text-xs sm:text-sm font-bold shadow-lg shadow-[#6D28D9]/30 transition cursor-pointer"
                            >
                                <ShoppingBag className="w-4 h-4" />
                                <span>Pedir Contraentrega</span>
                            </button>
                        </div>
                    </div>
                </header>

                {/* 2. BLOQUE PRINCIPAL ("ABOVE THE FOLD" — HERO DE LANZAMIENTO DE MARCA PREMIUM) */}
                <section
                    id="top"
                    className="relative bg-gradient-to-b from-[#080B20] via-[#111936] to-[#080B20] text-white pt-6 pb-16 lg:py-12 overflow-hidden"
                >
                    {/* Luces ambientales de laboratorio biotecnológico */}
                    <div className="pointer-events-none absolute -top-32 -left-32 w-[28rem] h-[28rem] rounded-full bg-[#A855F7]/15 blur-3xl" />
                    <div className="pointer-events-none absolute top-1/4 -right-32 w-[28rem] h-[28rem] rounded-full bg-[#35DDF5]/15 blur-3xl" />

                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                        {/* Etiqueta Superior (Badge Oficial) + Breadcrumb de Tienda */}
                        <div className="mb-6 flex flex-wrap items-center justify-between gap-3">
                            <div className="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#111936] border border-[#35DDF5]/40 text-[#35DDF5] text-xs sm:text-sm font-bold shadow-md">
                                <Sparkles className="w-4 h-4 text-[#A855F7] shrink-0" />
                                <span>
                                    🔬 BIOTECNOLOGÍA CLÍNICA VETERINARIA • RESULTADOS VISIBLES DESDE LA 1.ª SEMANA
                                </span>
                            </div>
                            <div className="hidden md:flex items-center gap-3 text-xs text-slate-300">
                                <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/5 border border-white/10">
                                    <Award className="w-3.5 h-3.5 text-[#35DDF5]" />
                                    Grado Nutracéutico Veterinario
                                </span>
                                <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-400/30 text-emerald-300 font-semibold">
                                    ● En Stock • Despacho Hoy
                                </span>
                            </div>
                        </div>

                        <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                            {/* COLUMNA IZQUIERDA: GALERÍA DE ESTUDIO CLÍNICO (STICKY) */}
                            <div className="lg:col-span-6 lg:sticky lg:top-24">
                                <div className="relative rounded-2xl bg-gradient-to-b from-[#111936] to-[#080B20] border border-white/15 p-3 sm:p-5 shadow-2xl">
                                    {/* Badges flotantes sobre el visor */}
                                    <div className="relative aspect-[4/4] sm:aspect-[10/9] rounded-xl overflow-hidden bg-white flex items-center justify-center group">
                                        <div className="absolute top-3 left-3 z-10 flex flex-wrap items-center gap-1.5">
                                            <span className="px-3 py-1 rounded-full bg-[#080B20]/90 backdrop-blur-md text-[#35DDF5] border border-[#35DDF5]/40 text-[11px] font-extrabold uppercase tracking-wider shadow">
                                                Fórmula 3 en 1 • 250g
                                            </span>
                                            <span className="px-2.5 py-1 rounded-full bg-[#0F9F9A] text-white text-[11px] font-extrabold shadow">
                                                40% Proteína Novel
                                            </span>
                                        </div>

                                        <img
                                            src={GALLERY_IMAGES[activeImageIdx].src}
                                            alt={GALLERY_IMAGES[activeImageIdx].alt}
                                            onClick={() => setIsZoomOpen(true)}
                                            className={`w-full h-full ${GALLERY_IMAGES[activeImageIdx].fit} transition-transform duration-500 cursor-zoom-in`}
                                        />

                                        {/* Botones Anterior / Siguiente */}
                                        <button
                                            type="button"
                                            onClick={prevImage}
                                            aria-label="Imagen anterior"
                                            className="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-[#080B20]/80 hover:bg-[#080B20] text-white flex items-center justify-center border border-white/20 shadow-lg transition cursor-pointer"
                                        >
                                            <ChevronLeft className="w-5 h-5" />
                                        </button>
                                        <button
                                            type="button"
                                            onClick={nextImage}
                                            aria-label="Siguiente imagen"
                                            className="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-[#080B20]/80 hover:bg-[#080B20] text-white flex items-center justify-center border border-white/20 shadow-lg transition cursor-pointer"
                                        >
                                            <ChevronRight className="w-5 h-5" />
                                        </button>

                                        {/* Botón de Zoom */}
                                        <button
                                            type="button"
                                            onClick={() => setIsZoomOpen(true)}
                                            className="absolute top-3 right-3 px-3 py-1.5 rounded-xl bg-[#080B20]/85 hover:bg-[#080B20] text-white text-xs font-semibold flex items-center gap-1.5 border border-white/15 shadow cursor-pointer"
                                        >
                                            <ZoomIn className="w-3.5 h-3.5 text-[#35DDF5]" />
                                            <span>Zoom HD</span>
                                        </button>

                                        <div className="absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#080B20]/95 via-[#080B20]/75 to-transparent p-3.5 flex items-center justify-between gap-2">
                                            <p className="text-xs sm:text-sm text-white font-medium">
                                                {GALLERY_IMAGES[activeImageIdx].caption}
                                            </p>
                                            <button
                                                type="button"
                                                onClick={() => setActiveImageIdx(activeImageIdx === 1 ? 0 : 1)}
                                                className="shrink-0 px-2.5 py-1 rounded-lg bg-[#35DDF5]/20 hover:bg-[#35DDF5]/30 border border-[#35DDF5]/40 text-[#35DDF5] text-[11px] font-bold transition cursor-pointer"
                                            >
                                                {activeImageIdx === 1 ? 'Ver Frente' : 'Ver Reverso / Tabla'}
                                            </button>
                                        </div>
                                    </div>

                                    {/* Miniaturas de las 5 Imágenes Oficiales */}
                                    <div className="grid grid-cols-5 gap-2 mt-3">
                                        {GALLERY_IMAGES.map((img, idx) => (
                                            <button
                                                key={idx}
                                                type="button"
                                                onClick={() => setActiveImageIdx(idx)}
                                                className={`group relative rounded-xl overflow-hidden border-2 transition cursor-pointer text-left ${
                                                    activeImageIdx === idx
                                                        ? 'border-[#35DDF5] ring-2 ring-[#35DDF5]/30'
                                                        : 'border-white/15 opacity-75 hover:opacity-100'
                                                }`}
                                            >
                                                <div className="aspect-square bg-white overflow-hidden">
                                                    <img
                                                        src={img.src}
                                                        alt={img.alt}
                                                        className="w-full h-full object-cover group-hover:scale-105 transition"
                                                    />
                                                </div>
                                                <div className="p-1.5 bg-[#080B20]">
                                                    <p className="text-[10px] font-semibold text-slate-200 truncate text-center">
                                                        {img.tag}
                                                    </p>
                                                </div>
                                            </button>
                                        ))}
                                    </div>
                                </div>

                                {/* Sellos de Garantía de Laboratorio debajo de la Galería */}
                                <div className="grid grid-cols-3 gap-3 mt-4">
                                    <div className="rounded-xl bg-[#111936]/90 border border-white/10 p-3.5 text-center">
                                        <p className="text-xs font-extrabold text-[#35DDF5] tracking-wide">
                                            0% ALÉRGENOS
                                        </p>
                                        <p className="text-[11px] text-slate-300 mt-0.5">
                                            Sin Pollo, Res, Soya ni Gluten
                                        </p>
                                    </div>
                                    <div className="rounded-xl bg-[#111936]/90 border border-white/10 p-3.5 text-center">
                                        <p className="text-xs font-extrabold text-[#A855F7] tracking-wide">
                                            DOYPACK ZIPPER
                                        </p>
                                        <p className="text-[11px] text-slate-300 mt-0.5">
                                            Barrera hermética anti-oxidación
                                        </p>
                                    </div>
                                    <div className="rounded-xl bg-[#111936]/90 border border-white/10 p-3.5 text-center">
                                        <p className="text-xs font-extrabold text-emerald-400 tracking-wide">
                                            PAGO EN CASA
                                        </p>
                                        <p className="text-[11px] text-slate-300 mt-0.5">
                                            Envío Gratis a toda Colombia
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {/* COLUMNA DERECHA: BUY BOX DE LANZAMIENTO DE MARCA (ALTA CONVERSIÓN) */}
                            <div className="lg:col-span-6 space-y-6">
                                {/* H1 & H2 Oficiales */}
                                <div>
                                    <div className="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-[#A855F7] mb-1.5">
                                        <span>DIVISIÓN CLÍNICA AVIPET BIOLAB® • FÓRMULA MAESTRA</span>
                                    </div>
                                    <h1 className="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-white leading-[1.15]">
                                        AVIPET BioLab® — DERMO &amp; GUT SUPERBOOST (250g)
                                    </h1>
                                    <h2 className="mt-2.5 text-base sm:text-lg font-medium text-slate-200 leading-snug">
                                        Suplemento Nutricional Biotecnológico 3 en 1 en Polvo para Perros y Gatos:{' '}
                                        <span className="text-[#35DDF5] font-bold">
                                            Piel • Digestión • Aliento
                                        </span>
                                    </h2>

                                    {/* Calificación Social (Estrellas) + Palatabilidad */}
                                    <div className="mt-3.5 flex flex-wrap items-center gap-2.5 text-sm bg-white/5 border border-white/10 rounded-xl px-3.5 py-2">
                                        <div className="flex items-center text-amber-400">
                                            <Star className="w-4 h-4 fill-amber-400" />
                                            <Star className="w-4 h-4 fill-amber-400" />
                                            <Star className="w-4 h-4 fill-amber-400" />
                                            <Star className="w-4 h-4 fill-amber-400" />
                                            <Star className="w-4 h-4 fill-amber-400" />
                                        </div>
                                        <span className="font-extrabold text-white tabular-nums">4.9 / 5.0</span>
                                        <span className="text-slate-300 text-xs">
                                            (Basado en dueños de mascotas y médicos veterinarios aliados en Colombia)
                                        </span>
                                    </div>
                                </div>

                                {/* Bloque Ejecutivo de Precio Ancla + Precio de Lanzamiento + Costo Diario */}
                                <div className="rounded-2xl bg-gradient-to-br from-[#111936] via-[#15213B] to-[#080B20] border border-[#35DDF5]/30 p-5 shadow-xl">
                                    <div className="flex flex-wrap items-start justify-between gap-3">
                                        <div>
                                            <div className="flex flex-wrap items-center gap-2">
                                                <span className="text-xs sm:text-sm text-slate-400 line-through tabular-nums">
                                                    Precio Ancla: $87.700 COP
                                                </span>
                                                <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">
                                                    Ahorras $17.800 COP
                                                </span>
                                            </div>
                                            <div className="mt-1.5 flex items-baseline gap-2.5">
                                                <span className="text-3xl sm:text-4xl font-extrabold text-white tabular-nums tracking-tight">
                                                    {activeBundle.formattedPrice}
                                                </span>
                                                <span className="text-xs sm:text-sm font-semibold text-[#35DDF5] tabular-nums">
                                                    ({activeBundle.grams} • {activeBundle.durationText})
                                                </span>
                                            </div>
                                        </div>
                                        <div className="flex flex-col items-start sm:items-end gap-1.5">
                                            <span className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-[#0F9F9A]/25 border border-[#0F9F9A]/60 text-emerald-300 text-xs font-extrabold">
                                                <Truck className="w-4 h-4" />
                                                🚚 Envío Gratis + Contraentrega
                                            </span>
                                            <span className="text-[11px] font-bold text-[#35DDF5] tabular-nums">
                                                ⚡ Inversión clínica: {activeBundle.dailyCostText}
                                            </span>
                                        </div>
                                    </div>
                                    <p className="mt-3 pt-2.5 border-t border-white/10 text-xs text-slate-300">
                                        Precio de Lanzamiento (1 Bolsa - 250g):{' '}
                                        <strong className="text-white">$69.900 COP</strong> (Tratamiento para 25 a 50
                                        días según el peso • Ahorras $17.800 COP frente a tarros tradicionales de solo
                                        Omega 3).
                                    </p>
                                </div>

                                {/* SELECTOR INTERACTIVO DE OFERTA ESCALONADA (BUNDLES PARA SUBIR EL TICKET PROMEDIO) */}
                                <div className="space-y-3">
                                    <div className="flex items-center justify-between">
                                        <span className="text-xs sm:text-sm font-extrabold uppercase tracking-wider text-[#35DDF5]">
                                            Selecciona el Tratamiento para tu Mascota:
                                        </span>
                                        <span className="text-xs text-emerald-300 font-semibold flex items-center gap-1">
                                            <BadgeCheck className="w-4 h-4" />
                                            Pagas al recibir
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
                                                            ? 'bg-[#111936] border-[#35DDF5] shadow-xl shadow-[#35DDF5]/15 scale-[1.01]'
                                                            : 'bg-[#080B20]/70 border-white/15 hover:border-white/35'
                                                    }`}
                                                >
                                                    {bundle.badge && (
                                                        <div className="mb-2 flex items-center justify-between gap-2">
                                                            <span
                                                                className={`inline-block px-3 py-0.5 rounded-full text-[11px] font-extrabold tracking-wide shadow ${bundle.badgeColor}`}
                                                            >
                                                                {bundle.badge}
                                                            </span>
                                                            <span className="text-[11px] font-bold text-slate-300 tabular-nums">
                                                                {bundle.bags}x Doypack ({bundle.grams})
                                                            </span>
                                                        </div>
                                                    )}

                                                    <div className="flex items-start justify-between gap-3">
                                                        <div className="flex items-start gap-3">
                                                            <div
                                                                className={`mt-1 w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0 ${
                                                                    isSelected
                                                                        ? 'border-[#35DDF5] bg-[#35DDF5]'
                                                                        : 'border-slate-400'
                                                                }`}
                                                            >
                                                                {isSelected && (
                                                                    <Check className="w-3.5 h-3.5 text-[#080B20] stroke-[3]" />
                                                                )}
                                                            </div>
                                                            <div>
                                                                <p className="font-extrabold text-white text-sm sm:text-base">
                                                                    {bundle.name}
                                                                </p>
                                                                <p className="text-xs text-slate-300 mt-0.5">
                                                                    {bundle.savings}
                                                                </p>
                                                                <p className="text-[11px] text-[#35DDF5] mt-1 font-semibold">
                                                                    {bundle.recommendedFor}
                                                                </p>
                                                                {bundle.vipBonus && (
                                                                    <p className="mt-1.5 inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md bg-white/10 text-[11px] font-bold text-amber-300">
                                                                        {bundle.vipBonus}
                                                                    </p>
                                                                )}
                                                            </div>
                                                        </div>

                                                        <div className="text-right shrink-0 tabular-nums">
                                                            <p className="text-xs text-slate-400 line-through">
                                                                {bundle.formattedCompareAt}
                                                            </p>
                                                            <p className="text-lg sm:text-xl font-extrabold text-white">
                                                                {bundle.formattedPrice}
                                                            </p>
                                                            <span className="inline-block text-[11px] font-bold text-emerald-300">
                                                                {bundle.unitPriceText}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            );
                                        })}
                                    </div>
                                </div>

                                {/* VIÑETAS DE IMPACTO RÁPIDO (5 BULLETS OFICIALES DEBAJO DEL PRECIO) */}
                                <div
                                    id="beneficios"
                                    className="rounded-2xl bg-[#111936]/95 border border-white/15 p-5 space-y-3 shadow-lg"
                                >
                                    <p className="text-xs font-extrabold uppercase tracking-wider text-[#35DDF5]">
                                        5 Mecanismos Clínicos en Cada Cucharada (5g):
                                    </p>
                                    <ul className="space-y-2.5 text-sm text-slate-200 leading-relaxed">
                                        <li className="flex items-start gap-3">
                                            <span className="text-lg leading-none select-none">🛡️</span>
                                            <span>
                                                <strong className="text-white">
                                                    Alivio de Picazón y Alergias de Raíz:
                                                </strong>{' '}
                                                Con Micro-Proteína Novel de insecto de cultivo (
                                                <em className="text-[#35DDF5]">Hermetia illucens</em>) que no genera
                                                memoria alérgica.
                                            </span>
                                        </li>
                                        <li className="flex items-start gap-3">
                                            <span className="text-lg leading-none select-none">🧪</span>
                                            <span>
                                                <strong className="text-white">
                                                    Acción Antimicrobiana y Antihongos:
                                                </strong>{' '}
                                                Rico en Ácido Láurico natural (4.5%), que combate bacterias y hongos (
                                                <em className="text-[#35DDF5]">Malassezia</em>) causantes del mal olor y
                                                lamido de patas.
                                            </span>
                                        </li>
                                        <li className="flex items-start gap-3">
                                            <span className="text-lg leading-none select-none">🦠</span>
                                            <span>
                                                <strong className="text-white">
                                                    Heces Firmes y Flora Intestinal Blindada:
                                                </strong>{' '}
                                                Fibra prebiótica soluble, MOS y Betaglucanos que restauran la microbiota
                                                desde la primera semana.
                                            </span>
                                        </li>
                                        <li className="flex items-start gap-3">
                                            <span className="text-lg leading-none select-none">🦷</span>
                                            <span>
                                                <strong className="text-white">Elimina el Mal Aliento:</strong>{' '}
                                                Clorofila activa de perejil deshidratado que neutraliza toxinas
                                                estomacales y bucales.
                                            </span>
                                        </li>
                                        <li className="flex items-start gap-3">
                                            <span className="text-lg leading-none select-none">🚫</span>
                                            <span>
                                                <strong className="text-white">100% Hipoalergénico Real:</strong> 0%
                                                Pollo • 0% Res • 0% Soya • Sin Granos • 100% Libre de Gluten.
                                            </span>
                                        </li>
                                    </ul>
                                </div>

                                {/* BOTONES DE LLAMADO A LA ACCIÓN (CTA OFICIALES) */}
                                <div className="space-y-3 pt-1">
                                    <button
                                        type="button"
                                        onClick={() => handleOpenCheckout()}
                                        className="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-[#6D28D9] via-[#7C3AED] to-[#6D28D9] hover:from-[#5B21B6] hover:to-[#5B21B6] active:scale-[0.99] text-white font-extrabold text-base sm:text-lg shadow-2xl shadow-[#6D28D9]/50 border border-[#A855F7]/40 flex items-center justify-center gap-3 transition cursor-pointer"
                                    >
                                        <ShoppingBag className="w-5 h-5 shrink-0" />
                                        <span>🛒 ¡PEDIR AHORA Y PAGAR EN CASA! (ENVÍO GRATIS)</span>
                                    </button>

                                    <a
                                        href={buildDirectWhatsAppUrl(activeBundle)}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="w-full py-3.5 px-6 rounded-2xl bg-white/10 hover:bg-white/15 border border-white/20 text-white font-bold text-sm sm:text-base flex items-center justify-center gap-2.5 transition"
                                    >
                                        <MessageCircle className="w-5 h-5 text-emerald-400 shrink-0" />
                                        <span>📲 Comprar o Consultar por WhatsApp</span>
                                    </a>

                                    {/* Sellos de Confianza de Pago Contraentrega Colombia */}
                                    <div className="pt-2 flex flex-wrap items-center justify-center gap-x-4 gap-y-1.5 text-[11px] text-slate-300">
                                        <span className="inline-flex items-center gap-1">
                                            <Lock className="w-3.5 h-3.5 text-emerald-400" />
                                            Cero Riesgo: Pagas al Recibir
                                        </span>
                                        <span>•</span>
                                        <span>Efectivo / Nequi / Bancolombia</span>
                                        <span>•</span>
                                        <span>Cobertura Nacional en Colombia</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* 2.5 BARRA EJECUTIVA DE BIOMARCADORES Y CIFRAS CLÍNICAS */}
                <section className="bg-[#080B20] border-y border-white/10 py-8 text-white">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="grid grid-cols-2 lg:grid-cols-4 gap-6 text-center divide-y lg:divide-y-0 lg:divide-x divide-white/10">
                            <div className="pt-3 lg:pt-0">
                                <p className="text-2xl sm:text-4xl font-extrabold text-[#35DDF5] tabular-nums">
                                    40.0%
                                </p>
                                <p className="text-xs sm:text-sm font-bold text-white mt-1">
                                    Micro-Proteína Novel Pura
                                </p>
                                <p className="text-[11px] text-slate-400">
                                    Hermetia illucens sin memoria alérgica
                                </p>
                            </div>
                            <div className="pt-3 lg:pt-0">
                                <p className="text-2xl sm:text-4xl font-extrabold text-[#A855F7] tabular-nums">
                                    4.5%
                                </p>
                                <p className="text-xs sm:text-sm font-bold text-white mt-1">
                                    Ácido Láurico Activo (C12:0)
                                </p>
                                <p className="text-[11px] text-slate-400">
                                    Combate hongos (Malassezia) y bacterias
                                </p>
                            </div>
                            <div className="pt-3 lg:pt-0">
                                <p className="text-2xl sm:text-4xl font-extrabold text-emerald-400 tabular-nums">
                                    9.8%
                                </p>
                                <p className="text-xs sm:text-sm font-bold text-white mt-1">
                                    Fibra Prebiótica + MOS
                                </p>
                                <p className="text-[11px] text-slate-400">
                                    Heces firmes desde la 1.ª semana
                                </p>
                            </div>
                            <div className="pt-3 lg:pt-0">
                                <p className="text-2xl sm:text-4xl font-extrabold text-white tabular-nums">
                                    0.0%
                                </p>
                                <p className="text-xs sm:text-sm font-bold text-[#35DDF5] mt-1">
                                    Pollo, Res, Soya y Gluten
                                </p>
                                <p className="text-[11px] text-slate-400">
                                    Fórmula hipoalergénica limpia
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                {/* 3. SECCIÓN DEL PROBLEMA VS. SOLUCIÓN (CUERPO DE LA PÁGINA) */}
                <section id="ciencia" className="py-16 lg:py-24 bg-[#F4F7FC]">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        {/* Bloque El Problema + Afiche Visual */}
                        <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center bg-white rounded-3xl border border-slate-200/90 shadow-lg p-6 sm:p-10">
                            <div className="lg:col-span-7">
                                <div className="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-red-50 border border-red-200 text-[#B91C1C] text-xs font-extrabold uppercase tracking-wide">
                                    <AlertTriangle className="w-4 h-4" />
                                    Diagnóstico Clínico: El Origen Oculto de la Alergia
                                </div>

                                <h2 className="mt-4 text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#15213B] leading-tight">
                                    ¿Tu peludo se rasca sin parar, se lame las patas, pierde pelo o sufre del estómago?
                                </h2>

                                <p className="mt-4 text-base sm:text-lg text-[#5C6B85] leading-relaxed">
                                    El <strong className="text-[#15213B]">80% de las dermatitis crónicas</strong>,
                                    otitis recurrentes y problemas digestivos en perros y gatos son provocados por la
                                    inflamación que generan las proteínas tradicionales (como el pollo o la res) y los
                                    cereales de relleno (trigo, maíz, soya) presentes en los concentrados comerciales y
                                    suplementos convencionales.
                                </p>

                                <div className="mt-6 rounded-2xl bg-amber-50/90 border-l-4 border-[#B45309] p-5">
                                    <p className="text-sm sm:text-base font-semibold text-[#15213B] leading-relaxed">
                                        💡 Darle un tarro que solo contiene Omega 3 es intentar{' '}
                                        <span className="underline decoration-[#B45309] decoration-2">
                                            apagar un incendio sin cerrar la llave del gas
                                        </span>
                                        : alivia por unos días, pero la alergia vuelve.
                                    </p>
                                </div>

                                <div className="mt-6 grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs font-bold text-[#15213B]">
                                    <div className="p-3 rounded-xl bg-[#F4F7FC] border border-slate-200 flex items-center gap-2">
                                        <XCircle className="w-4 h-4 text-[#B91C1C] shrink-0" />
                                        <span>Sin Harinas de Pollo</span>
                                    </div>
                                    <div className="p-3 rounded-xl bg-[#F4F7FC] border border-slate-200 flex items-center gap-2">
                                        <XCircle className="w-4 h-4 text-[#B91C1C] shrink-0" />
                                        <span>Sin Proteína de Res</span>
                                    </div>
                                    <div className="p-3 rounded-xl bg-[#F4F7FC] border border-slate-200 flex items-center gap-2 col-span-2 sm:col-span-1">
                                        <XCircle className="w-4 h-4 text-[#B91C1C] shrink-0" />
                                        <span>Sin Trigo, Maíz ni Soya</span>
                                    </div>
                                </div>
                            </div>

                            <div className="lg:col-span-5">
                                <div className="rounded-2xl overflow-hidden border border-slate-200 shadow-xl bg-[#080B20]">
                                    <img
                                        src="/images/biolab/afiche-beneficios-dermatitis.jpg"
                                        alt="AVIPET BioLab® — ¿Tiene dermatitis o se rasca sin parar?"
                                        className="w-full h-auto object-cover"
                                    />
                                </div>
                            </div>
                        </div>

                        {/* Banner Panorámico Oficial de Marca */}
                        <div className="mt-10 rounded-3xl overflow-hidden border border-slate-200 shadow-xl bg-[#080B20]">
                            <img
                                src="/images/biolab/banner-panoramico.jpg"
                                alt="AVIPET BioLab® — Nutrición Clínica Dermo-Digestiva"
                                className="w-full h-auto object-cover"
                            />
                        </div>

                        {/* Bloque La Solución Biotecnológica (Doble Matriz Activa) */}
                        <div className="mt-16">
                            <div className="text-center max-w-3xl mx-auto">
                                <span className="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#6D28D9]/10 text-[#6D28D9] text-xs font-extrabold uppercase tracking-wider">
                                    <FlaskConical className="w-4 h-4" />
                                    Ingeniería Nutricional de Doble Matriz
                                </span>
                                <h2 className="mt-3 text-2xl sm:text-4xl font-extrabold text-[#15213B]">
                                    La Revolución Biotecnológica de AVIPET BioLab®
                                </h2>
                                <p className="mt-3 text-base sm:text-lg text-[#5C6B85]">
                                    <strong className="text-[#15213B]">DERMO &amp; GUT SUPERBOOST</strong> ataca el
                                    problema desde su origen inmunológico y digestivo gracias a su doble matriz activa:
                                </p>
                            </div>

                            <div className="mt-10 grid grid-cols-1 lg:grid-cols-2 gap-8">
                                {/* Tarjeta 1: Matriz Proteica y Lipídica Dermo-Activa */}
                                <div className="rounded-3xl bg-[#080B20] text-white p-7 sm:p-9 border border-white/10 shadow-xl relative overflow-hidden">
                                    <div className="w-12 h-12 rounded-2xl bg-[#35DDF5]/15 border border-[#35DDF5]/40 flex items-center justify-center text-[#35DDF5] mb-5">
                                        <Microscope className="w-6 h-6" />
                                    </div>
                                    <span className="text-xs font-extrabold uppercase tracking-wider text-[#35DDF5]">
                                        1. Inmunología Cutánea y Barrera Dérmica
                                    </span>
                                    <h3 className="mt-1 text-xl sm:text-2xl font-extrabold text-white">
                                        Matriz Proteica y Lipídica Dermo-Activa
                                    </h3>
                                    <p className="mt-4 text-slate-200 text-sm sm:text-base leading-relaxed">
                                        Utilizamos micro-proteína purificada y desgrasada de{' '}
                                        <em className="text-[#35DDF5] font-semibold">Hermetia illucens</em>. Al ser una{' '}
                                        <strong className="text-white">Proteína Novel</strong> (una estructura de
                                        aminoácidos limpia que el sistema inmune de tu mascota no reconoce como
                                        amenaza), frena la respuesta histamínica, detiene la picazón y aporta{' '}
                                        <strong className="text-white">Ácido Láurico (C12:0)</strong> junto con{' '}
                                        <strong className="text-white">
                                            Omega 3, 6 y 9 de semilla de linaza dorada
                                        </strong>{' '}
                                        para regenerar la barrera cutánea y devolverle el brillo al pelaje.
                                    </p>
                                    <div className="mt-6 pt-5 border-t border-white/10 flex flex-wrap gap-2">
                                        <span className="px-3 py-1 rounded-full bg-white/10 text-xs font-semibold text-[#35DDF5]">
                                            Hermetia illucens 40% Proteína
                                        </span>
                                        <span className="px-3 py-1 rounded-full bg-white/10 text-xs font-semibold text-slate-200">
                                            Ácido Láurico C12:0 (4.5%)
                                        </span>
                                        <span className="px-3 py-1 rounded-full bg-white/10 text-xs font-semibold text-slate-200">
                                            Linaza Dorada (Omega 3-6-9)
                                        </span>
                                    </div>
                                </div>

                                {/* Tarjeta 2: Complejo Prebiótico y Fitoterapéutico Gut-Care */}
                                <div className="rounded-3xl bg-[#111936] text-white p-7 sm:p-9 border border-white/10 shadow-xl relative overflow-hidden">
                                    <div className="w-12 h-12 rounded-2xl bg-[#A855F7]/20 border border-[#A855F7]/40 flex items-center justify-center text-[#A855F7] mb-5">
                                        <Leaf className="w-6 h-6" />
                                    </div>
                                    <span className="text-xs font-extrabold uppercase tracking-wider text-[#A855F7]">
                                        2. Eje Intestino-Piel y Aliento Fresco
                                    </span>
                                    <h3 className="mt-1 text-xl sm:text-2xl font-extrabold text-white">
                                        Complejo Prebiótico y Fitoterapéutico Gut-Care
                                    </h3>
                                    <p className="mt-4 text-slate-200 text-sm sm:text-base leading-relaxed">
                                        La salud de la piel nace en el intestino. Nuestra combinación de{' '}
                                        <strong className="text-white">fibra soluble de ahuyama deshidratada</strong>,
                                        pared celular de levadura nutricional inactiva (
                                        <em className="text-[#35DDF5]">Saccharomyces cerevisiae</em>),{' '}
                                        <strong className="text-white">extracto de cúrcuma</strong> (antiinflamatorio
                                        celular) y <strong className="text-white">hojas de perejil deshidratado</strong>{' '}
                                        restaura la flora intestinal, compacta las heces y refresca el aliento de forma
                                        100% natural.
                                    </p>
                                    <div className="mt-6 pt-5 border-t border-white/10 flex flex-wrap gap-2">
                                        <span className="px-3 py-1 rounded-full bg-white/10 text-xs font-semibold text-[#A855F7]">
                                            MOS + Betaglucanos + Biotina
                                        </span>
                                        <span className="px-3 py-1 rounded-full bg-white/10 text-xs font-semibold text-slate-200">
                                            Curcumina Antiinflamatoria
                                        </span>
                                        <span className="px-3 py-1 rounded-full bg-white/10 text-xs font-semibold text-slate-200">
                                            Clorofila Activa de Perejil
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* 3.5 NUEVA SECCIÓN DE LANZAMIENTO: CRONOLOGÍA CLÍNICA DE 30 DÍAS */}
                <section
                    id="cronologia"
                    className="py-16 lg:py-24 bg-gradient-to-b from-[#080B20] via-[#111936] to-[#080B20] text-white border-t border-white/10"
                >
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center max-w-3xl mx-auto mb-12">
                            <span className="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#35DDF5]/15 border border-[#35DDF5]/40 text-[#35DDF5] text-xs font-extrabold uppercase tracking-wider">
                                <Clock className="w-4 h-4" />
                                Cronología de Transformación Biológica
                            </span>
                            <h2 className="mt-3 text-2xl sm:text-4xl font-extrabold text-white">
                                ¿Qué ocurre en el cuerpo de tu mascota durante los primeros 30 días?
                            </h2>
                            <p className="mt-3 text-sm sm:text-base text-slate-300">
                                A diferencia de los paliativos químicos que ocultan el síntoma por unas horas,{' '}
                                <strong className="text-white">Dermo &amp; Gut Superboost</strong> reconstruye la barrera
                                intestinal y cutánea semana a semana.
                            </p>
                        </div>

                        <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            {CLINICAL_TIMELINE.map((step, idx) => (
                                <div
                                    key={idx}
                                    className="rounded-3xl bg-[#111936]/90 border border-white/15 p-6 sm:p-8 flex flex-col justify-between shadow-2xl relative overflow-hidden"
                                >
                                    <div>
                                        <div className="flex items-center justify-between gap-2 mb-4">
                                            <span
                                                className={`px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider border ${step.accent}`}
                                            >
                                                {step.phase}
                                            </span>
                                            <span className="text-xs font-bold text-slate-400">
                                                Paso 0{idx + 1}
                                            </span>
                                        </div>
                                        <h3 className="text-xl font-extrabold text-white leading-snug">
                                            {step.title}
                                        </h3>
                                        <p className="mt-3 text-sm text-slate-300 leading-relaxed">
                                            {step.description}
                                        </p>
                                    </div>

                                    <div className="mt-6 pt-4 border-t border-white/10 space-y-2">
                                        {step.metrics.map((m, mIdx) => (
                                            <div
                                                key={mIdx}
                                                className="flex items-center gap-2 text-xs font-semibold text-slate-200"
                                            >
                                                <CheckCircle2 className="w-4 h-4 text-[#0F9F9A] shrink-0" />
                                                <span>{m}</span>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>

                {/* 3.8 NUEVA SECCIÓN DE LANZAMIENTO: ANATOMÍA DE LOS 6 BIO-ACTIVOS PUROS (BENTO GRID) */}
                <section id="bioactivos" className="py-16 lg:py-24 bg-[#F4F7FC]">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center max-w-3xl mx-auto mb-12">
                            <span className="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#15213B] text-[#35DDF5] text-xs font-extrabold uppercase tracking-wider">
                                <Microscope className="w-4 h-4" />
                                Trazabilidad de Ingredientes • Grado Clínico
                            </span>
                            <h2 className="mt-3 text-2xl sm:text-4xl font-extrabold text-[#15213B]">
                                Anatomía de los 6 Bio-Activos de AVIPET BioLab®
                            </h2>
                            <p className="mt-2 text-sm sm:text-base text-[#5C6B85]">
                                Cero rellenos baratos. Cada gramo cumple una función inmunológica, antimicrobiana o
                                prebiótica específica en perros y gatos.
                            </p>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {BIO_ACTIVES_BENTO.map((item) => (
                                <div
                                    key={item.code}
                                    className="rounded-2xl bg-[#080B20] text-white p-6 border border-white/10 shadow-xl flex flex-col justify-between hover:border-[#35DDF5]/40 transition"
                                >
                                    <div>
                                        <div className="flex items-center justify-between gap-2 mb-4">
                                            <span
                                                className={`px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider border ${item.badgeStyle}`}
                                            >
                                                {item.badge}
                                            </span>
                                            <span className="text-xs font-mono text-slate-400">{item.code}</span>
                                        </div>
                                        <h3 className="text-lg font-extrabold text-white">{item.name}</h3>
                                        <p className="text-xs font-semibold text-[#35DDF5] mt-0.5 italic">
                                            {item.scientific}
                                        </p>
                                        <p className="mt-3 text-sm text-slate-300 leading-relaxed">
                                            {item.description}
                                        </p>
                                    </div>
                                    <div className="mt-5 pt-3.5 border-t border-white/10 flex items-center justify-between text-xs">
                                        <span className="text-slate-400">Función Diana:</span>
                                        <span className="font-bold text-emerald-300">{item.role}</span>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>

                {/* 4. TABLA COMPARATIVA (POR QUÉ ELEGIR AVIPET BioLab®) */}
                <section id="comparativa" className="py-16 lg:py-20 bg-white border-y border-slate-200">
                    <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center max-w-3xl mx-auto mb-10">
                            <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#0E7490]/10 text-[#0E7490] text-xs font-bold uppercase tracking-wider">
                                Tabla Comparativa
                            </span>
                            <h2 className="mt-3 text-2xl sm:text-3xl font-extrabold text-[#15213B]">
                                ¿Por qué elegir AVIPET BioLab®?
                            </h2>
                            <p className="mt-2 text-sm sm:text-base text-[#5C6B85]">
                                Compara nuestra fórmula biotecnológica 3 en 1 en empaque Doypack Zipper frente a los
                                suplementos tradicionales en tarro.
                            </p>
                        </div>

                        <div className="overflow-x-auto rounded-2xl border border-slate-200 shadow-lg">
                            <table className="w-full text-left border-collapse">
                                <thead>
                                    <tr className="bg-[#080B20] text-white">
                                        <th className="py-4 px-4 sm:px-6 text-xs sm:text-sm font-bold uppercase tracking-wider w-2/5">
                                            Característica
                                        </th>
                                        <th className="py-4 px-4 sm:px-6 text-xs sm:text-sm font-bold uppercase tracking-wider bg-[#111936] border-x border-white/10 text-[#35DDF5] w-3/10">
                                            🔬 AVIPET BioLab® Superboost
                                        </th>
                                        <th className="py-4 px-4 sm:px-6 text-xs sm:text-sm font-bold uppercase tracking-wider text-slate-300 w-3/10">
                                            Otros Suplementos en Tarro
                                        </th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-slate-200 text-sm">
                                    {COMPARISON_ROWS.map((row, index) => (
                                        <tr
                                            key={index}
                                            className={index % 2 === 0 ? 'bg-white' : 'bg-[#F4F7FC]/60'}
                                        >
                                            <td className="py-4 px-4 sm:px-6 font-semibold text-[#15213B]">
                                                {row.feature}
                                            </td>
                                            <td className="py-4 px-4 sm:px-6 bg-[#6D28D9]/[0.04] border-x border-slate-200 font-semibold text-[#15213B]">
                                                <div className="flex items-start gap-2.5">
                                                    {row.biolabStatus === 'price' ? (
                                                        <span className="inline-flex items-center px-3 py-1 rounded-lg bg-[#0F9F9A] text-white font-extrabold tabular-nums">
                                                            {row.biolab}
                                                        </span>
                                                    ) : (
                                                        <>
                                                            <CheckCircle2 className="w-5 h-5 text-[#0F9F9A] shrink-0 mt-0.5" />
                                                            <span>✅ {row.biolab}</span>
                                                        </>
                                                    )}
                                                </div>
                                            </td>
                                            <td className="py-4 px-4 sm:px-6 text-[#5C6B85]">
                                                <div className="flex items-start gap-2.5">
                                                    {row.othersStatus === 'no' && (
                                                        <>
                                                            <XCircle className="w-5 h-5 text-[#B91C1C] shrink-0 mt-0.5" />
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
                                                            <AlertTriangle className="w-5 h-5 text-[#B45309] shrink-0 mt-0.5" />
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

                        <div className="mt-8 text-center">
                            <button
                                type="button"
                                onClick={() => handleOpenCheckout()}
                                className="inline-flex items-center gap-2.5 px-7 py-4 rounded-2xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-bold text-base shadow-lg shadow-[#6D28D9]/25 transition cursor-pointer"
                            >
                                <ShoppingBag className="w-5 h-5" />
                                <span>🛒 ¡Pedir Ahora con Envío Gratis + Pago Contraentrega!</span>
                            </button>
                        </div>
                    </div>
                </section>

                {/* 5. FICHA TÉCNICA Y COMPOSICIÓN (ACORDEONES DESPLEGABLES + EMPAQUE FRENTE Y REVERSO) */}
                <section id="ficha-tecnica" className="py-16 lg:py-24 bg-[#F4F7FC]">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center max-w-3xl mx-auto mb-10">
                            <span className="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#15213B] text-[#35DDF5] text-xs font-bold uppercase tracking-wider">
                                Ficha Técnica y Composición
                            </span>
                            <h2 className="mt-3 text-2xl sm:text-3xl font-extrabold text-[#15213B]">
                                Transparencia Clínica Total: Composición, Tabla Nutricional y Dosis
                            </h2>
                            <p className="mt-2 text-sm sm:text-base text-[#5C6B85]">
                                Revisa el respaldo nutricional por cada 100g y el modo de uso diario según el peso de
                                tu perro o gato.
                            </p>
                        </div>

                        <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                            {/* Imagen del Empaque Frente y Reverso */}
                            <div className="lg:col-span-5">
                                <div className="rounded-2xl bg-white border border-slate-200 p-4 shadow-md">
                                    <div className="rounded-xl overflow-hidden border border-slate-100">
                                        <img
                                            src="/images/biolab/empaque-frente-reverso.jpg"
                                            alt="Frente y Reverso del Empaque AVIPET BioLab® Dermo & Gut Superboost 250g"
                                            onClick={() => {
                                                setActiveImageIdx(1);
                                                setIsZoomOpen(true);
                                            }}
                                            className="w-full h-auto object-contain cursor-zoom-in hover:scale-[1.02] transition"
                                        />
                                    </div>
                                    <div className="mt-3 flex items-center justify-between text-xs text-[#5C6B85]">
                                        <span>Vista frontal y trasera del Doypack (250g)</span>
                                        <button
                                            type="button"
                                            onClick={() => {
                                                setActiveImageIdx(1);
                                                setIsZoomOpen(true);
                                            }}
                                            className="text-[#6D28D9] font-bold flex items-center gap-1 hover:underline cursor-pointer"
                                        >
                                            <ZoomIn className="w-3.5 h-3.5" />
                                            Ver en alta resolución
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {/* Acordeones Desplegables */}
                            <div className="lg:col-span-7 space-y-4">
                                {/* ACORDEÓN 1: COMPOSICIÓN GARANTIZADA */}
                                <div className="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
                                    <button
                                        type="button"
                                        onClick={() =>
                                            setOpenAccordion(openAccordion === 'composicion' ? '' : 'composicion')
                                        }
                                        className="w-full p-5 sm:p-6 flex items-center justify-between text-left hover:bg-slate-50 transition cursor-pointer"
                                    >
                                        <div className="flex items-center gap-3">
                                            <span className="text-2xl">🧬</span>
                                            <div>
                                                <h3 className="text-base sm:text-lg font-bold text-[#15213B]">
                                                    Composición Garantizada (Fórmula Biotecnológica Exclusiva)
                                                </h3>
                                                <p className="text-xs sm:text-sm text-[#5C6B85]">
                                                    Doble matriz activa Dermo-Activa &amp; Gut-Care
                                                </p>
                                            </div>
                                        </div>
                                        <ChevronDown
                                            className={`w-5 h-5 text-[#5C6B85] transition-transform ${
                                                openAccordion === 'composicion' ? 'rotate-180 text-[#6D28D9]' : ''
                                            }`}
                                        />
                                    </button>

                                    {openAccordion === 'composicion' && (
                                        <div className="px-5 pb-6 sm:px-6 sm:pb-6 pt-2 border-t border-slate-100 space-y-4 text-sm sm:text-base text-[#15213B]">
                                            <div className="rounded-xl bg-[#F4F7FC] p-4 border border-slate-200">
                                                <p className="font-bold text-[#6D28D9]">
                                                    Matriz Proteica y Lipídica Dermo-Activa:
                                                </p>
                                                <p className="mt-1 text-[#5C6B85] leading-relaxed">
                                                    Micro-proteína purificada y desgrasada de{' '}
                                                    <em className="font-semibold text-[#15213B]">Hermetia illucens</em>{' '}
                                                    (fuente natural de Ácido Láurico C12:0 y péptidos hipoalergénicos)
                                                    y Semilla de linaza dorada molida (
                                                    <em className="font-semibold text-[#15213B]">
                                                        Linum usitatissimum
                                                    </em>{' '}
                                                    — fuente de Omega 3, 6 y 9).
                                                </p>
                                            </div>

                                            <div className="rounded-xl bg-[#F4F7FC] p-4 border border-slate-200">
                                                <p className="font-bold text-[#0E7490]">
                                                    Complejo Prebiótico y Fitoterapéutico Gut-Care:
                                                </p>
                                                <p className="mt-1 text-[#5C6B85] leading-relaxed">
                                                    Fibra soluble de ahuyama deshidratada (
                                                    <em className="font-semibold text-[#15213B]">Cucurbita moschata</em>
                                                    ), Pared celular de levadura nutricional inactiva (
                                                    <em className="font-semibold text-[#15213B]">
                                                        Saccharomyces cerevisiae
                                                    </em>{' '}
                                                    — fuente de MOS, Betaglucanos y Biotina), Extracto de raíz de
                                                    cúrcuma (
                                                    <em className="font-semibold text-[#15213B]">Curcuma longa</em>) y
                                                    Hojas de perejil deshidratado (
                                                    <em className="font-semibold text-[#15213B]">
                                                        Petroselinum crispum
                                                    </em>{' '}
                                                    — rico en clorofila activa).
                                                </p>
                                            </div>

                                            <div className="rounded-xl bg-emerald-50 border border-emerald-200 p-4 flex items-center gap-3">
                                                <ShieldCheck className="w-6 h-6 text-[#0F9F9A] shrink-0" />
                                                <p className="text-xs sm:text-sm font-semibold text-[#15213B]">
                                                    Libre de alérgenos: 0% Pollo, 0% Res, 0% Lácteos, 0% Soya, 0%
                                                    Trigo, 0% Maíz, 100% Libre de Gluten y sin conservantes
                                                    artificiales.
                                                </p>
                                            </div>
                                        </div>
                                    )}
                                </div>

                                {/* ACORDEÓN 2: TABLA NUTRICIONAL GARANTIZADA (POR CADA 100G) */}
                                <div className="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
                                    <button
                                        type="button"
                                        onClick={() =>
                                            setOpenAccordion(openAccordion === 'nutricional' ? '' : 'nutricional')
                                        }
                                        className="w-full p-5 sm:p-6 flex items-center justify-between text-left hover:bg-slate-50 transition cursor-pointer"
                                    >
                                        <div className="flex items-center gap-3">
                                            <span className="text-2xl">📊</span>
                                            <div>
                                                <h3 className="text-base sm:text-lg font-bold text-[#15213B]">
                                                    Tabla Nutricional Garantizada (Por cada 100g)
                                                </h3>
                                                <p className="text-xs sm:text-sm text-[#5C6B85]">
                                                    Proteína Cruda 40.0% • Ácido Láurico 4.5% • Omega 3 y 6: 3.7%
                                                </p>
                                            </div>
                                        </div>
                                        <ChevronDown
                                            className={`w-5 h-5 text-[#5C6B85] transition-transform ${
                                                openAccordion === 'nutricional' ? 'rotate-180 text-[#6D28D9]' : ''
                                            }`}
                                        />
                                    </button>

                                    {openAccordion === 'nutricional' && (
                                        <div className="px-5 pb-6 sm:px-6 sm:pb-6 pt-2 border-t border-slate-100">
                                            <div className="overflow-x-auto rounded-xl border border-slate-200">
                                                <table className="w-full text-left border-collapse">
                                                    <thead>
                                                        <tr className="bg-[#111936] text-white text-xs uppercase tracking-wider">
                                                            <th className="py-3.5 px-4">
                                                                Nutriente / Componente Activo
                                                            </th>
                                                            <th className="py-3.5 px-4">Valor Garantizado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody className="divide-y divide-slate-200 text-sm">
                                                        {NUTRITIONAL_TABLE.map((item, i) => (
                                                            <tr key={i} className="bg-white">
                                                                <td className="py-3.5 px-4 font-bold text-[#15213B]">
                                                                    {item.nutrient}
                                                                </td>
                                                                <td className="py-3.5 px-4 font-extrabold text-[#6D28D9] tabular-nums">
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
                                <div className="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
                                    <button
                                        type="button"
                                        onClick={() => setOpenAccordion(openAccordion === 'dosis' ? '' : 'dosis')}
                                        className="w-full p-5 sm:p-6 flex items-center justify-between text-left hover:bg-slate-50 transition cursor-pointer"
                                    >
                                        <div className="flex items-center gap-3">
                                            <span className="text-2xl">🥄</span>
                                            <div>
                                                <h3 className="text-base sm:text-lg font-bold text-[#15213B]">
                                                    Dosis Diaria y Modo de Uso (¿Cuánto dura una bolsa de 250g?)
                                                </h3>
                                                <p className="text-xs sm:text-sm text-[#5C6B85]">
                                                    Sabor umami natural • Rendimiento de 25 a 50 días por bolsa
                                                </p>
                                            </div>
                                        </div>
                                        <ChevronDown
                                            className={`w-5 h-5 text-[#5C6B85] transition-transform ${
                                                openAccordion === 'dosis' ? 'rotate-180 text-[#6D28D9]' : ''
                                            }`}
                                        />
                                    </button>

                                    {openAccordion === 'dosis' && (
                                        <div className="px-5 pb-6 sm:px-6 sm:pb-6 pt-2 border-t border-slate-100 space-y-5">
                                            <p className="text-sm sm:text-base text-[#5C6B85] leading-relaxed">
                                                Espolvorear directamente sobre su alimento habitual (concentrado seco,
                                                comida húmeda o dieta BARF/natural) una vez al día. Su{' '}
                                                <strong className="text-[#15213B]">sabor umami natural</strong> (gracias
                                                a la levadura nutricional y la ahuyama) les encanta a perros y gatos.
                                            </p>

                                            {/* Simulador Rápido por Peso */}
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
                                                                    ? 'border-[#6D28D9] bg-[#6D28D9]/5'
                                                                    : 'border-slate-200 bg-[#F4F7FC] hover:border-slate-300'
                                                            }`}
                                                        >
                                                            <p className="text-xs font-bold uppercase text-[#6D28D9]">
                                                                {row.group}
                                                            </p>
                                                            <p className="mt-1 text-xs sm:text-sm font-bold text-[#15213B]">
                                                                {row.dose}
                                                            </p>
                                                            <p className="mt-1 text-xs font-semibold text-[#0F9F9A]">
                                                                ⏱️ {row.duration}
                                                            </p>
                                                        </div>
                                                    );
                                                })}
                                            </div>

                                            <div className="overflow-x-auto rounded-xl border border-slate-200">
                                                <table className="w-full text-left border-collapse">
                                                    <thead>
                                                        <tr className="bg-[#080B20] text-white text-xs uppercase tracking-wider">
                                                            <th className="py-3.5 px-4">Peso de la Mascota</th>
                                                            <th className="py-3.5 px-4">Dosis Diaria Recomendada</th>
                                                            <th className="py-3.5 px-4">Duración de 1 Bolsa (250g)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody className="divide-y divide-slate-200 text-sm">
                                                        {DOSAGE_ROWS.map((r) => (
                                                            <tr key={r.id} className="bg-white">
                                                                <td className="py-3.5 px-4 font-bold text-[#15213B]">
                                                                    {r.group}
                                                                </td>
                                                                <td className="py-3.5 px-4 text-[#5C6B85] font-medium">
                                                                    {r.dose}
                                                                </td>
                                                                <td className="py-3.5 px-4 font-bold text-[#0F9F9A] tabular-nums">
                                                                    {r.duration}
                                                                </td>
                                                            </tr>
                                                        ))}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    )}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* 5.5 NUEVA SECCIÓN: RESPALDO VETERINARIO Y CASOS REALES VERIFICADOS EN COLOMBIA */}
                <section id="testimonios" className="py-16 lg:py-24 bg-[#080B20] text-white border-t border-white/10">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center max-w-3xl mx-auto mb-12">
                            <span className="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/15 border border-emerald-400/30 text-emerald-300 text-xs font-extrabold uppercase tracking-wider">
                                <BadgeCheck className="w-4 h-4" />
                                Evidencia y Confianza en Colombia
                            </span>
                            <h2 className="mt-3 text-2xl sm:text-4xl font-extrabold text-white">
                                Lo que dicen los Médicos Veterinarios y Tutores que ya probaron Dermo &amp; Gut Superboost
                            </h2>
                            <p className="mt-2 text-sm sm:text-base text-slate-300">
                                Calificación promedio de <strong className="text-amber-400">4.9 / 5.0 estrellas</strong>{' '}
                                en resultados digestivos y dermatológicos.
                            </p>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                            {VERIFIED_REVIEWS.map((rev, idx) => (
                                <div
                                    key={idx}
                                    className="rounded-3xl bg-[#111936] border border-white/15 p-6 sm:p-7 flex flex-col justify-between shadow-xl"
                                >
                                    <div>
                                        <div className="flex items-center justify-between gap-2 mb-4">
                                            <div className="flex items-center text-amber-400">
                                                <Star className="w-4 h-4 fill-amber-400" />
                                                <Star className="w-4 h-4 fill-amber-400" />
                                                <Star className="w-4 h-4 fill-amber-400" />
                                                <Star className="w-4 h-4 fill-amber-400" />
                                                <Star className="w-4 h-4 fill-amber-400" />
                                            </div>
                                            <span className="px-2.5 py-0.5 rounded-full bg-emerald-500/15 text-emerald-300 text-[11px] font-bold">
                                                ✓ Verificado
                                            </span>
                                        </div>

                                        <span className="inline-block px-2.5 py-1 rounded-lg bg-white/10 text-[#35DDF5] text-xs font-bold mb-3">
                                            {rev.highlight}
                                        </span>

                                        <p className="text-sm text-slate-200 leading-relaxed italic">{rev.quote}</p>
                                    </div>

                                    <div className="mt-6 pt-4 border-t border-white/10">
                                        <p className="font-bold text-white text-sm">{rev.name}</p>
                                        <p className="text-xs text-[#35DDF5] font-medium">{rev.pet}</p>
                                        <div className="mt-1 flex items-center justify-between text-[11px] text-slate-400">
                                            <span>📍 {rev.city}</span>
                                            <span>{rev.bundle}</span>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>

                {/* 6. PREGUNTAS FRECUENTES (FAQ PARA DERRIBAR OBJECIONES EN LA PÁGINA) */}
                <section id="faq" className="py-16 lg:py-24 bg-white border-t border-slate-200">
                    <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center mb-10">
                            <span className="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#6D28D9]/10 text-[#6D28D9] text-xs font-bold uppercase tracking-wider">
                                Preguntas Frecuentes (FAQ)
                            </span>
                            <h2 className="mt-3 text-2xl sm:text-3xl font-extrabold text-[#15213B]">
                                Resolvemos tus dudas sobre AVIPET BioLab® — Dermo &amp; Gut Superboost
                            </h2>
                        </div>

                        <div className="space-y-4">
                            {FAQS.map((faq, idx) => {
                                const isOpen = openFaqIdx === idx;
                                return (
                                    <div
                                        key={idx}
                                        className="rounded-2xl border border-slate-200 bg-[#F4F7FC]/70 overflow-hidden"
                                    >
                                        <button
                                            type="button"
                                            onClick={() => setOpenFaqIdx(isOpen ? -1 : idx)}
                                            className="w-full p-5 sm:p-6 flex items-center justify-between text-left hover:bg-slate-100/70 transition cursor-pointer"
                                        >
                                            <span className="text-base sm:text-lg font-bold text-[#15213B] pr-4">
                                                {faq.question}
                                            </span>
                                            <ChevronDown
                                                className={`w-5 h-5 text-[#5C6B85] shrink-0 transition-transform ${
                                                    isOpen ? 'rotate-180 text-[#6D28D9]' : ''
                                                }`}
                                            />
                                        </button>

                                        {isOpen && (
                                            <div className="px-5 pb-6 sm:px-6 sm:pb-6 pt-2 border-t border-slate-200/70 bg-white">
                                                {faq.answerParts ? (
                                                    <div className="space-y-3 mt-2">
                                                        {faq.answerParts.map((part, pIdx) => (
                                                            <div
                                                                key={pIdx}
                                                                className="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 p-3 rounded-xl bg-[#F4F7FC] border border-slate-200"
                                                            >
                                                                <span className="inline-flex items-center px-3 py-1 rounded-lg bg-[#080B20] text-[#35DDF5] text-xs font-bold shrink-0">
                                                                    {part.badge}:
                                                                </span>
                                                                <p className="text-sm text-[#15213B]">{part.text}</p>
                                                            </div>
                                                        ))}
                                                    </div>
                                                ) : (
                                                    <p className="text-sm sm:text-base text-[#5C6B85] leading-relaxed mt-2">
                                                        {faq.answer}
                                                    </p>
                                                )}
                                            </div>
                                        )}
                                    </div>
                                );
                            })}
                        </div>

                        {/* CTA Final en Página */}
                        <div className="mt-12 rounded-3xl bg-gradient-to-r from-[#080B20] via-[#111936] to-[#080B20] text-white p-8 sm:p-10 text-center border border-white/10 shadow-2xl">
                            <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#35DDF5]/15 text-[#35DDF5] text-xs font-bold">
                                🚚 ENVÍO GRATIS + PAGO CONTRAENTREGA EN TODA COLOMBIA
                            </span>
                            <h3 className="mt-4 text-2xl sm:text-3xl font-extrabold">
                                Pide hoy tu AVIPET BioLab® — Dermo &amp; Gut Superboost y paga al recibir en casa
                            </h3>
                            <p className="mt-2 text-slate-300 text-sm sm:text-base max-w-2xl mx-auto">
                                Sin riesgos ni pagos anticipados obligatorios: registras tus datos de entrega en 30
                                segundos y pagas en efectivo o transferencia cuando el transportador te entregue el
                                paquete.
                            </p>
                            <div className="mt-6 flex flex-col sm:flex-row items-center justify-center gap-3">
                                <button
                                    type="button"
                                    onClick={() => handleOpenCheckout()}
                                    className="w-full sm:w-auto px-8 py-4 rounded-2xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-extrabold text-base shadow-xl shadow-[#6D28D9]/40 transition cursor-pointer"
                                >
                                    🛒 ¡PEDIR AHORA Y PAGAR EN CASA! (ENVÍO GRATIS)
                                </button>
                                <a
                                    href={buildDirectWhatsAppUrl(activeBundle)}
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="w-full sm:w-auto px-6 py-4 rounded-2xl bg-white/10 hover:bg-white/15 border border-white/20 text-white font-bold text-sm sm:text-base flex items-center justify-center gap-2 transition"
                                >
                                    <MessageCircle className="w-5 h-5 text-emerald-400" />
                                    <span>📲 Comprar o Consultar por WhatsApp</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                {/* FOOTER OFICIAL AVIPET BioLab® / AviPetApp */}
                <footer className="bg-[#080B20] text-slate-400 py-12 border-t border-white/10 text-xs sm:text-sm">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-6">
                        <div className="flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
                            <img
                                src="/images/biolab/logo-avipet-biolab.jpg"
                                alt="AviPet BioLab®"
                                className="w-12 h-12 rounded-full object-cover border border-[#35DDF5]/40"
                            />
                            <div>
                                <p className="text-white font-semibold">
                                    AVIPET BioLab® — Nutrición Clínica Dermo-Digestiva
                                </p>
                                <p className="text-xs text-slate-400">
                                    Una marca de AviPetApp • Más inteligencia. Más bienestar. Más futuro.
                                </p>
                            </div>
                        </div>
                        <div className="flex flex-wrap items-center justify-center gap-4 text-xs">
                            <a href={storeHomeUrl} className="text-[#35DDF5] hover:underline font-semibold">
                                ← Volver a la Tienda General AVIPET BioLab®
                            </a>
                            <span>•</span>
                            <a href="https://avipetapp.com" className="hover:text-white transition">
                                Plataforma Veterinaria AviPetApp
                            </a>
                        </div>
                    </div>
                </footer>

                {/* BARRA FIJA INFERIOR DE CONVERSIÓN (STICKY CONVERSION BAR) */}
                <div className="fixed bottom-0 inset-x-0 z-40 bg-[#080B20]/95 backdrop-blur-md border-t border-white/15 py-3 px-4 shadow-2xl">
                    <div className="max-w-7xl mx-auto flex items-center justify-between gap-3">
                        <div className="flex items-center gap-3 min-w-0">
                            <img
                                src="/images/biolab/empaque-frente-250g.jpg"
                                alt="Dermo & Gut Superboost 250g"
                                className="w-11 h-11 rounded-xl object-contain bg-white border border-white/20 hidden sm:block shrink-0"
                            />
                            <div className="min-w-0">
                                <p className="text-xs sm:text-sm font-bold text-white truncate">
                                    {activeBundle.name}
                                </p>
                                <div className="flex items-center gap-2 text-xs">
                                    <span className="font-extrabold text-[#35DDF5] tabular-nums">
                                        {activeBundle.formattedPrice}
                                    </span>
                                    <span className="text-slate-400 line-through tabular-nums hidden sm:inline">
                                        {activeBundle.formattedCompareAt}
                                    </span>
                                    <span className="text-emerald-300 font-semibold">
                                        • Envío Gratis + Contraentrega
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div className="flex items-center gap-2 shrink-0">
                            <button
                                type="button"
                                onClick={() => handleOpenCheckout()}
                                className="px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-extrabold text-xs sm:text-sm shadow-lg shadow-[#6D28D9]/40 flex items-center gap-2 transition cursor-pointer"
                            >
                                <ShoppingBag className="w-4 h-4" />
                                <span>¡Pedir y Pagar en Casa!</span>
                            </button>
                        </div>
                    </div>
                </div>

                {/* LIGHTBOX DE ZOOM EN ALTA RESOLUCIÓN PARA LAS IMÁGENES OFICIALES */}
                {isZoomOpen && (
                    <div
                        className="fixed inset-0 z-50 bg-[#080B20]/95 backdrop-blur-md flex items-center justify-center p-4"
                        onClick={() => setIsZoomOpen(false)}
                    >
                        <div
                            className="relative max-w-4xl w-full max-h-[90vh] flex flex-col items-center"
                            onClick={(e) => e.stopPropagation()}
                        >
                            <button
                                type="button"
                                onClick={() => setIsZoomOpen(false)}
                                className="absolute -top-3 -right-3 z-10 w-10 h-10 rounded-full bg-[#6D28D9] text-white flex items-center justify-center shadow-lg cursor-pointer"
                            >
                                <X className="w-5 h-5" />
                            </button>
                            <img
                                src={GALLERY_IMAGES[activeImageIdx].src}
                                alt={GALLERY_IMAGES[activeImageIdx].alt}
                                className="max-h-[80vh] w-auto rounded-2xl object-contain bg-white shadow-2xl"
                            />
                            <p className="mt-3 text-sm text-white font-medium text-center">
                                {GALLERY_IMAGES[activeImageIdx].caption}
                            </p>
                        </div>
                    </div>
                )}

                {/* MODAL DE PEDIDO CONTRAENTREGA */}
                {isCheckoutModalOpen && (
                    <div className="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-[#080B20]/80 backdrop-blur-sm overflow-y-auto">
                        <div className="relative w-full max-w-xl rounded-2xl bg-white text-[#15213B] shadow-2xl border border-slate-200 overflow-hidden my-8">
                            {/* Cabecera del Modal */}
                            <div className="bg-[#080B20] text-white px-6 py-4 flex items-center justify-between">
                                <div className="flex items-center gap-3">
                                    <img
                                        src="/images/biolab/logo-avipet-biolab.jpg"
                                        alt="AviPet BioLab®"
                                        className="w-10 h-10 rounded-full object-cover border border-[#35DDF5]/40"
                                    />
                                    <div>
                                        <span className="text-[11px] font-bold uppercase tracking-wider text-[#35DDF5] flex items-center gap-1.5">
                                            <Truck className="w-3.5 h-3.5" />
                                            Envío Gratis + Pago Contraentrega en Colombia
                                        </span>
                                        <h3 className="text-base sm:text-lg font-bold text-white">
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
                                    className="p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-white/10 transition cursor-pointer"
                                >
                                    <X className="w-5 h-5" />
                                </button>
                            </div>

                            {orderSuccess ? (
                                <div className="p-6 sm:p-8 text-center space-y-5">
                                    <div className="w-16 h-16 rounded-full bg-emerald-100 text-[#0F9F9A] flex items-center justify-center mx-auto">
                                        <CheckCircle2 className="w-10 h-10" />
                                    </div>
                                    <div>
                                        <span className="inline-block px-3 py-1 rounded-full bg-emerald-50 text-[#0F9F9A] text-xs font-bold">
                                            ORDEN REGISTRADA • {orderSuccess.order_code}
                                        </span>
                                        <h4 className="mt-2 text-2xl font-bold text-[#15213B]">
                                            ¡Tu pedido contraentrega está listo!
                                        </h4>
                                        <p className="mt-1 text-sm text-[#5C6B85]">
                                            Hemos registrado tu despacho de{' '}
                                            <strong className="text-[#15213B]">{orderSuccess.bundle_title}</strong> por{' '}
                                            <strong className="text-[#6D28D9]">{orderSuccess.formatted_total}</strong>{' '}
                                            (Envío Gratis).
                                        </p>
                                    </div>

                                    <div className="rounded-xl bg-[#F4F7FC] p-4 border border-slate-200 text-left text-xs sm:text-sm space-y-1.5">
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
                                        className="w-full py-4 px-6 rounded-xl bg-[#0F9F9A] hover:bg-[#0d8a86] text-white font-extrabold text-base flex items-center justify-center gap-2.5 shadow-lg transition"
                                    >
                                        <MessageCircle className="w-5 h-5" />
                                        <span>Confirmar Despacho Prioritario por WhatsApp</span>
                                    </a>

                                    <button
                                        type="button"
                                        onClick={() => {
                                            setIsCheckoutModalOpen(false);
                                            setOrderSuccess(null);
                                        }}
                                        className="text-xs text-[#5C6B85] hover:text-[#15213B] underline cursor-pointer"
                                    >
                                        Volver a la página del producto
                                    </button>
                                </div>
                            ) : (
                                <form
                                    onSubmit={handleSubmitOrder}
                                    className="p-5 sm:p-6 space-y-4 max-h-[82vh] overflow-y-auto"
                                >
                                    {/* Selector rápido de Kit dentro del Checkout */}
                                    <div className="rounded-xl bg-[#F4F7FC] p-3.5 border border-slate-200">
                                        <label className="block text-xs font-bold uppercase text-[#5C6B85] mb-2">
                                            1. Confirma tu Kit con Envío Gratis:
                                        </label>
                                        <div className="grid grid-cols-3 gap-2">
                                            {BUNDLES.map((b) => (
                                                <button
                                                    key={b.id}
                                                    type="button"
                                                    onClick={() => setSelectedBundleId(b.id)}
                                                    className={`p-2.5 rounded-xl border text-left transition cursor-pointer ${
                                                        selectedBundleId === b.id
                                                            ? 'border-[#6D28D9] bg-[#6D28D9]/10 text-[#15213B]'
                                                            : 'border-slate-200 bg-white text-[#5C6B85]'
                                                    }`}
                                                >
                                                    <p className="text-xs font-extrabold text-[#15213B]">
                                                        {b.bags} {b.bags === 1 ? 'Bolsa' : 'Bolsas'} ({b.grams})
                                                    </p>
                                                    <p className="text-xs font-bold text-[#6D28D9] tabular-nums mt-0.5">
                                                        {b.formattedPrice}
                                                    </p>
                                                </button>
                                            ))}
                                        </div>
                                    </div>

                                    {orderError && (
                                        <div className="rounded-xl bg-red-50 border border-red-200 p-3 text-xs font-semibold text-[#B91C1C]">
                                            {orderError}
                                        </div>
                                    )}

                                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                        <div>
                                            <label className="block text-xs font-bold text-[#15213B] mb-1">
                                                Nombre Completo *
                                            </label>
                                            <input
                                                type="text"
                                                required
                                                value={customerName}
                                                onChange={(e) => setCustomerName(e.target.value)}
                                                placeholder="Ej: Carolina Martínez"
                                                className="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#6D28D9] focus:outline-none"
                                            />
                                        </div>
                                        <div>
                                            <label className="block text-xs font-bold text-[#15213B] mb-1">
                                                WhatsApp / Celular *
                                            </label>
                                            <input
                                                type="tel"
                                                required
                                                value={customerPhone}
                                                onChange={(e) => setCustomerPhone(e.target.value)}
                                                placeholder="Ej: 300 123 4567"
                                                className="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#6D28D9] focus:outline-none"
                                            />
                                        </div>
                                    </div>

                                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                        <div>
                                            <label className="block text-xs font-bold text-[#15213B] mb-1">
                                                Departamento *
                                            </label>
                                            <select
                                                value={department}
                                                onChange={(e) => setDepartment(e.target.value)}
                                                className="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm bg-white focus:border-[#6D28D9] focus:outline-none"
                                            >
                                                {COLOMBIAN_DEPARTMENTS.map((dep) => (
                                                    <option key={dep} value={dep}>
                                                        {dep}
                                                    </option>
                                                ))}
                                            </select>
                                        </div>
                                        <div>
                                            <label className="block text-xs font-bold text-[#15213B] mb-1">
                                                Ciudad / Municipio *
                                            </label>
                                            <input
                                                type="text"
                                                required
                                                value={city}
                                                onChange={(e) => setCity(e.target.value)}
                                                placeholder="Ej: Medellín, Bogotá, Cali..."
                                                className="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#6D28D9] focus:outline-none"
                                            />
                                        </div>
                                    </div>

                                    <div className="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                                        <div className="sm:col-span-2">
                                            <label className="block text-xs font-bold text-[#15213B] mb-1">
                                                Dirección Exacta de Entrega *
                                            </label>
                                            <input
                                                type="text"
                                                required
                                                value={address}
                                                onChange={(e) => setAddress(e.target.value)}
                                                placeholder="Calle / Carrera, Número, Apto / Casa"
                                                className="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#6D28D9] focus:outline-none"
                                            />
                                        </div>
                                        <div>
                                            <label className="block text-xs font-bold text-[#15213B] mb-1">
                                                Barrio
                                            </label>
                                            <input
                                                type="text"
                                                value={neighborhood}
                                                onChange={(e) => setNeighborhood(e.target.value)}
                                                placeholder="Ej: El Poblado"
                                                className="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-[#6D28D9] focus:outline-none"
                                            />
                                        </div>
                                    </div>

                                    <div className="grid grid-cols-1 sm:grid-cols-3 gap-3.5 pt-1">
                                        <div>
                                            <label className="block text-xs font-bold text-[#15213B] mb-1">
                                                Mascota
                                            </label>
                                            <select
                                                value={petType}
                                                onChange={(e) => setPetType(e.target.value)}
                                                className="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm bg-white"
                                            >
                                                <option value="Perro">🐶 Perro</option>
                                                <option value="Gato">🐱 Gato</option>
                                                <option value="Perro y Gato">🐾 Perro y Gato</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label className="block text-xs font-bold text-[#15213B] mb-1">
                                                Peso Aprox.
                                            </label>
                                            <select
                                                value={petWeight}
                                                onChange={(e) => setPetWeight(e.target.value)}
                                                className="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm bg-white"
                                            >
                                                <option value="1 a 10 kg (Pequeño / Gato)">1 a 10 kg</option>
                                                <option value="11 a 25 kg (Mediano)">11 a 25 kg</option>
                                                <option value="+25 kg (Grande)">+25 kg</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label className="block text-xs font-bold text-[#15213B] mb-1">
                                                Nombre de tu Peludo
                                            </label>
                                            <input
                                                type="text"
                                                value={petName}
                                                onChange={(e) => setPetName(e.target.value)}
                                                placeholder="Ej: Max / Luna"
                                                className="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm"
                                            />
                                        </div>
                                    </div>

                                    {/* Resumen de Total Contraentrega */}
                                    <div className="rounded-xl bg-[#080B20] text-white p-4 flex items-center justify-between">
                                        <div>
                                            <p className="text-xs text-[#35DDF5] font-bold">
                                                {activeBundle.name}
                                            </p>
                                            <p className="text-[11px] text-slate-300">
                                                🚚 Envío Gratis • Pagas en casa al recibir
                                            </p>
                                        </div>
                                        <div className="text-right tabular-nums">
                                            <p className="text-xs text-slate-400 line-through">
                                                {activeBundle.formattedCompareAt}
                                            </p>
                                            <p className="text-lg font-extrabold text-white">
                                                {activeBundle.formattedPrice}
                                            </p>
                                        </div>
                                    </div>

                                    <button
                                        type="submit"
                                        disabled={isSubmitting}
                                        className="w-full py-4 px-6 rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] disabled:opacity-60 text-white font-extrabold text-base shadow-lg shadow-[#6D28D9]/30 flex items-center justify-center gap-2 transition cursor-pointer"
                                    >
                                        <ShoppingBag className="w-5 h-5" />
                                        <span>
                                            {isSubmitting
                                                ? 'Registrando tu despacho...'
                                                : `Confirmar Pedido Contraentrega (${activeBundle.formattedPrice})`}
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
