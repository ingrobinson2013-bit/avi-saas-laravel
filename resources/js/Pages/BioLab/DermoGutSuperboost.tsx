import React, { useState, useEffect } from 'react';
import { Head, Link } from '@inertiajs/react';
import axios from 'axios';

interface PackageItem {
    id: '1_bolsa' | '2_bolsas' | '3_bolsas';
    name: string;
    subtitle: string;
    bags: number;
    weight: string;
    doses: number;
    price: number;
    compareAt: number;
    unitPrice: number;
    savings: number;
    badge?: string;
    popular?: boolean;
    bestValue?: boolean;
    perks: string[];
}

interface Props {
    product: {
        name: string;
        brand: string;
        tagline: string;
        weight: string;
        servings: number;
        serving_size: string;
        price_single: number;
        price_Anchor: number;
        packages: PackageItem[];
    };
}

const COLOMBIA_DEPARTMENTS = [
    'Antioquia',
    'Atlántico',
    'Bogotá D.C.',
    'Bolívar',
    'Boyacá',
    'Caldas',
    'Caquetá',
    'Casanare',
    'Cauca',
    'Cesar',
    'Chocó',
    'Córdoba',
    'Cundinamarca',
    'Huila',
    'La Guajira',
    'Magdalena',
    'Meta',
    'Nariño',
    'Norte de Santander',
    'Quindío',
    'Risaralda',
    'Santander',
    'Sucre',
    'Tolima',
    'Valle del Cauca',
    'Otro departamento',
];

const GALLERY_IMAGES = [
    {
        src: '/images/biolab/funnel-frente-reverso.jpg',
        thumbLabel: 'Frente y Reverso',
        badge: '✨ EMPAQUE OFICIAL 250g • FRENTE Y TABLA NUTRICIONAL',
        caption: 'Presentación Doypack con cierre hermético Zipper (250g / 50 dosis) — Frente y reverso nutricional garantizado.',
    },
    {
        src: '/images/biolab/biolab-demo-accion.gif',
        thumbLabel: '🎬 Video GIF',
        badge: '🎬 DEMO EN VIVO • MIRA CÓMO ACTÚA EN 4 PASOS',
        caption: 'De la picazón y caída de pelo a una piel sana, heces firmes y pelaje brillante en semanas.',
    },
    {
        src: '/images/biolab/funnel-pack-trio.jpg',
        thumbLabel: 'Pack Ahorro',
        badge: '🔥 OFERTA MULTIPACK • TRATAMIENTO COMPLETO',
        caption: 'Lleva el Pack Dúo (2 bolsas) o Tratamiento 90 Días (3 bolsas) con máximo descuento y envío gratis.',
    },
    {
        src: '/images/biolab/funnel-modo-uso.jpg',
        thumbLabel: 'Modo de Uso',
        badge: '🥄 FÁCIL DE DAR • ALTA PALATABILIDAD NATURAL',
        caption: 'Solo espolvorea 1 cuchara dosificadora (5g) al día sobre su concentrado, dieta BARF o comida húmeda.',
    },
    {
        src: '/images/biolab/funnel-antes-despues.jpg',
        thumbLabel: 'Antes y Después',
        badge: '🐾 CAMBIO VISIBLE DESDE LA 1.ª A 3.ª SEMANA',
        caption: 'Alivio progresivo del enrojecimiento interdigital, lamido de patas, dermatitis y caída excesiva de pelo.',
    },
    {
        src: '/images/biolab/review-ugc-bulldog.jpg',
        thumbLabel: 'Clientes Reales',
        badge: '📦 ENTREGAS REALES CONTRAENTREGA EN COLOMBIA',
        caption: 'Más de 340 dueños de perros y gatos en Colombia ya reciben su pedido en casa y pagan al recibir.',
    },
];

const LIVE_SALES_NOTIFICATIONS = [
    {
        buyer: 'Marcela V.',
        location: 'El Poblado, Medellín',
        pkg: 'Pack Dúo Clínico (2 Bolsas)',
        price: '$124.900',
        timeAgo: 'Hace 1 minuto',
        pet: '🐕 Bulldog Francés',
        img: '/images/biolab/review-ugc-bulldog.jpg',
    },
    {
        buyer: 'Carlos Eduardo R.',
        location: 'Chapinero, Bogotá D.C.',
        pkg: 'Tratamiento 90 Días (3 Bolsas)',
        price: '$169.900',
        timeAgo: 'Hace 3 minutos',
        pet: '🐕 Golden Retriever',
        img: '/images/biolab/review-ugc-golden.jpg',
    },
    {
        buyer: 'Diana Carolina L.',
        location: 'Ciudad Jardín, Cali',
        pkg: 'Pack Dúo Clínico (2 Bolsas)',
        price: '$124.900',
        timeAgo: 'Hace 2 minutos',
        pet: '🐾 Pug y Gata Persa',
        img: '/images/biolab/review-ugc-pug-cat.jpg',
    },
    {
        buyer: 'Jorge Hernán M.',
        location: 'Cabecera, Bucaramanga',
        pkg: 'Pack Dúo Clínico (2 Bolsas)',
        price: '$124.900',
        timeAgo: 'Hace 4 minutos',
        pet: '🐕 Pastor Alemán',
        img: '/images/biolab/funnel-frente-reverso.jpg',
    },
    {
        buyer: 'Natalia S.',
        location: 'Alto Prado, Barranquilla',
        pkg: '1 Bolsa Inicial (250g)',
        price: '$69.900',
        timeAgo: 'Hace 1 minuto',
        pet: '🐕 Shih Tzu',
        img: '/images/biolab/review-ugc-vet.jpg',
    },
    {
        buyer: 'Camilo Andrés P.',
        location: 'Cerritos, Pereira',
        pkg: 'Tratamiento 90 Días (3 Bolsas)',
        price: '$169.900',
        timeAgo: 'Hace 5 minutos',
        pet: '🐕 Labrador + Beagle',
        img: '/images/biolab/funnel-pack-trio.jpg',
    },
];

const CLINICAL_STATS = [
    {
        percentage: 96,
        title: 'Menos picazón, rascado y lamido de patas',
        detail: 'Reportado entre el día 10 y 21 gracias a la nutrición 0% pollo / 0% res y al poder antimicrobiano del Ácido Láurico (4.5%).',
    },
    {
        percentage: 98,
        title: 'Heces más firmes, menos gases y mejor aliento',
        detail: 'Visible desde la primera semana por la acción sinérgica de la fibra prebiótica (Quitina + Pectina de Ahuyama) y clorofila de Perejil.',
    },
    {
        percentage: 94,
        title: 'Freno en la caída de pelo y mayor brillo dérmico',
        detail: 'Al día 30 de suplementación continua con péptidos bioactivos de alta biodisponibilidad y ácidos grasos Omega 3, 6 y 9.',
    },
];

const REVIEWS = [
    {
        name: 'Carolina M.',
        city: 'Medellín, Antioquia',
        pet: 'Bulldog Francés • 4 años',
        packageBought: 'Compró Pack Dúo (2 Bolsas)',
        daysAgo: 'Hace 3 días',
        rating: 5,
        title: '¡Dejó de lamerse las patas hasta sangrar!',
        text: 'Mi gordito llevaba más de un año con las patas rojas y rascándose las orejas. Gastamos muchísimo en cremas y pastillas que solo le quitaban la picazón por unos días. Al día 12 con Dermo & Gut Superboost las paticas ya estaban secas, sin mal olor y sus heces súper firmes. Lo pedí contraentrega y llegó en 2 días.',
        image: '/images/biolab/review-ugc-bulldog.jpg',
    },
    {
        name: 'Andrés Felipe R.',
        city: 'Bogotá D.C.',
        pet: 'Golden Retriever • 6 años',
        packageBought: 'Compró Tratamiento 3 Bolsas',
        daysAgo: 'Hace 5 días',
        rating: 5,
        title: 'Cero caída de pelo y le encanta el sabor',
        text: 'Simba soltaba mechones de pelo por toda la casa y tenía el estómago muy sensible con cualquier concentrado de pollo. Apenas le espolvoreo la cucharadita sobre las croquetas se las come de inmediato. Llevamos 1 mes, el pelo le brilla impresionante y el aliento le mejoró al 100%.',
        image: '/images/biolab/review-ugc-golden.jpg',
    },
    {
        name: 'Dra. Valentina G.',
        city: 'Cali, Valle del Cauca',
        pet: 'Médica Veterinaria • Práctica Clínica',
        packageBought: 'Especialista Verificada',
        daysAgo: 'Hace 1 semana',
        rating: 5,
        title: 'Excelente perfil hipoalergénico y prebiótico',
        text: 'El mayor reto en pacientes atópicos es la inflamación intestinal cruzada por proteínas convencionales (pollo/res). La matriz de Hermetia illucens desgrasada al 40% junto con 4.5% de ácido láurico, linaza dorada y cúrcuma ofrece una modulación dermo-digestiva limpia, segura y sin efectos adversos.',
        image: '/images/biolab/review-ugc-vet.jpg',
    },
    {
        name: 'Laura Sofía P.',
        city: 'Bucaramanga, Santander',
        pet: 'Pug + Gata Persa',
        packageBought: 'Compró Pack Dúo (2 Bolsas)',
        daysAgo: 'Hace 1 semana',
        rating: 5,
        title: 'Sirve tanto para mi perro como para mi gata',
        text: 'Me encantó que es para perros y gatos. Mi Pug sufría de gases horribles y caspa en el lomo, y mi gata tenía bolas de pelo y pelo opaco. En la primera semana el cambio en la digestión fue total. El pago contraentrega fue súper serio y rápido.',
        image: '/images/biolab/review-ugc-pug-cat.jpg',
    },
];

const FAQS = [
    {
        q: '¿Cómo funciona el Pago Contraentrega y cuánto tarda el envío?',
        a: '¡Cero riesgo para ti! Haces tu pedido hoy en el formulario rápido de esta página sin necesidad de tarjeta de crédito. Despachamos tu orden en menos de 24 horas hábiles con envío 100% GRATIS y le pagas en efectivo (o transferencia al transportador) únicamente cuando tengas el producto en tus manos. Ciudades principales tardan de 1 a 3 días hábiles; resto del país de 3 a 5 días hábiles.',
    },
    {
        q: '¿Cómo recibo el Bono Gratis (Guía Clínica Hipoalergénica en PDF)?',
        a: 'Apenas confirmas tu pedido contraentrega en el popup, se habilita de inmediato el botón de descarga directa de tu Guía Clínica de Nutrición Hipoalergénica y Protocolo de 30 Días (Manual PDF de 6 páginas valorado en $29.900 COP), y además te la enviamos a tu WhatsApp junto con la confirmación de tu despacho prioritario.',
    },
    {
        q: '¿En cuánto tiempo veré resultados en la piel y digestión de mi mascota?',
        a: '• Día 5 a 7 (Fase Digestiva): Notarás heces más firmes, reducción de gases y aliento mucho más fresco gracias a los prebióticos, la ahuyama y la clorofila del perejil.\n• Día 14 a 21 (Fase Dermo-Calma): Disminuye notoriamente el rascado constante, el lamido de patas (pododermatitis) y el mal olor en la piel.\n• Día 30 en adelante (Fase Regeneración): Freno visible en la caída de pelo, cierre de zonas sin pelaje y manto grueso y brillante.',
    },
    {
        q: '¿Por qué funciona cuando otros suplementos o concentrados fallan?',
        a: 'Más del 80% de las alergias alimentarias en perros y gatos son provocadas por las proteínas de pollo, res, lácteos o cereales presentes en premios y suplementos comunes. DERMO & GUT SUPERBOOST® utiliza un 40% de Micro-Proteína Novel de Hermetia illucens que el sistema inmune de tu mascota no reconoce como alérgeno, combinada con Ácido Láurico (4.5%) que combate hongos y levaduras desde adentro.',
    },
    {
        q: '¿Tiene efectos secundarios o contraindicaciones?',
        a: 'Ninguno. Es un suplemento nutricional biotecnológico 100% natural, libre de corticoides, antibióticos, químicos, gluten, soya y conservantes artificiales. Puede administrarse de forma continua en cachorros (desde los 3 meses), adultos y mascotas senior.',
    },
];

export default function DermoGutSuperboost({ product }: Props) {
    const packages: PackageItem[] = [
        {
            id: '1_bolsa',
            name: '1 Bolsa • Prueba Inicial (30-50 Días)',
            subtitle: '250g en Polvo (50 cucharadas de 5g)',
            bags: 1,
            weight: '250g',
            doses: 50,
            price: 69900,
            compareAt: 87700,
            unitPrice: 69900,
            savings: 17800,
            badge: 'AHORRAS $17.800',
            popular: false,
            perks: ['1 Bolsa de 250g (50 dosis)', 'Envío GRATIS + Pago Contraentrega'],
        },
        {
            id: '2_bolsas',
            name: 'Pack Dúo Clínico • 2 Bolsas (60-100 Días)',
            subtitle: '500g en Polvo (100 cucharadas de 5g)',
            bags: 2,
            weight: '500g',
            doses: 100,
            price: 124900,
            compareAt: 175400,
            unitPrice: 62450,
            savings: 50500,
            badge: '🔥 MÁS VENDIDO • 78% ELIGE ESTE PACK',
            popular: true,
            perks: [
                '2 Bolsas de 250g ($62.450 c/u)',
                'Ahorras $50.500 COP vs. precio regular',
                'Ciclo completo de regeneración de piel y pelaje',
            ],
        },
        {
            id: '3_bolsas',
            name: 'Tratamiento 90 Días • 3 Bolsas (Máximo Ahorro)',
            subtitle: '750g en Polvo (150 cucharadas de 5g)',
            bags: 3,
            weight: '750g',
            doses: 150,
            price: 169900,
            compareAt: 263100,
            unitPrice: 56633,
            savings: 93200,
            badge: '🏆 MEJOR PRECIO • AHORRAS $93.200',
            popular: false,
            bestValue: true,
            perks: [
                '3 Bolsas de 250g ($56.633 c/u)',
                'Ahorras $93.200 COP (Máximo Descuento)',
                'Ideal para razas medianas/grandes o varias mascotas',
            ],
        },
    ];

    const [selectedPkgId, setSelectedPkgId] = useState<'1_bolsa' | '2_bolsas' | '3_bolsas'>('2_bolsas');
    const selectedPkg = packages.find((p) => p.id === selectedPkgId) || packages[1];

    const [activeImageIdx, setActiveImageIdx] = useState<number>(0);
    const [orderBump, setOrderBump] = useState<boolean>(true);
    const [petWeightRange, setPetWeightRange] = useState<'small' | 'medium' | 'large'>('small');
    const [openFaqIndex, setOpenFaqIndex] = useState<number | null>(0);

    // Mental Triggers State (Scarcity, Live Viewers, Countdown, Live Purchase Simulator)
    const [liveViewers, setLiveViewers] = useState<number>(31);
    const [stockLeft, setStockLeft] = useState<number>(11);
    const [stockFlash, setStockFlash] = useState<boolean>(false);
    const [secondsLeft, setSecondsLeft] = useState<number>(2 * 3600 + 18 * 60 + 42);

    // Live Sales Toast Simulator State
    const [activeSaleIdx, setActiveSaleIdx] = useState<number>(0);
    const [showSaleToast, setShowSaleToast] = useState<boolean>(false);
    const [dismissedToast, setDismissedToast] = useState<boolean>(false);

    // Shopify Releasit COD Popup Modal State
    const [isCodModalOpen, setIsCodModalOpen] = useState<boolean>(false);

    // Releasit COD Form Inputs
    const [customerName, setCustomerName] = useState('');
    const [customerPhone, setCustomerPhone] = useState('');
    const [customerEmail, setCustomerEmail] = useState('');
    const [department, setDepartment] = useState('');
    const [city, setCity] = useState('');
    const [address, setAddress] = useState('');
    const [neighborhood, setNeighborhood] = useState('');
    const [petType, setPetType] = useState<'Perro' | 'Gato' | 'Ambos'>('Perro');
    const [petName, setPetName] = useState('');
    const [notes, setNotes] = useState('');

    const [isSubmitting, setIsSubmitting] = useState(false);
    const [formError, setFormError] = useState<string | null>(null);
    const [orderSuccess, setOrderSuccess] = useState<{
        order_code: string;
        bundle_title: string;
        formatted_price: string;
        whatsapp_url: string;
        guide_pdf_url: string;
    } | null>(null);

    // Countdown + Live Viewers
    useEffect(() => {
        const timer = setInterval(() => {
            setSecondsLeft((prev) => (prev > 60 ? prev - 1 : 2 * 3600 + 15 * 60));
        }, 1000);

        const viewerTimer = setInterval(() => {
            setLiveViewers((prev) => {
                const delta = Math.floor(Math.random() * 5) - 2;
                return Math.min(46, Math.max(22, prev + delta));
            });
        }, 5500);

        return () => {
            clearInterval(timer);
            clearInterval(viewerTimer);
        };
    }, []);

    // Live Purchase Toast Simulator (Every 12s shows a purchase for 5.5s and decrements stock down to 6)
    useEffect(() => {
        if (dismissedToast || isCodModalOpen) return;

        const initialTimeout = setTimeout(() => {
            setShowSaleToast(true);
        }, 4000);

        const cycleInterval = setInterval(() => {
            setShowSaleToast(false);
            setTimeout(() => {
                setActiveSaleIdx((prev) => (prev + 1) % LIVE_SALES_NOTIFICATIONS.length);
                setShowSaleToast(true);
                setStockLeft((prevStock) => {
                    if (prevStock > 6) {
                        setStockFlash(true);
                        setTimeout(() => setStockFlash(false), 1200);
                        return prevStock - 1;
                    }
                    return prevStock;
                });
            }, 3500);
        }, 13000);

        return () => {
            clearTimeout(initialTimeout);
            clearInterval(cycleInterval);
        };
    }, [dismissedToast, isCodModalOpen]);

    const formatTime = (totalSecs: number) => {
        const hrs = Math.floor(totalSecs / 3600);
        const mins = Math.floor((totalSecs % 3600) / 60);
        const secs = totalSecs % 60;
        return {
            hrs: String(hrs).padStart(2, '0'),
            mins: String(mins).padStart(2, '0'),
            secs: String(secs).padStart(2, '0'),
        };
    };

    const countdown = formatTime(secondsLeft);

    const formatCOP = (amount: number) => {
        return '$' + amount.toLocaleString('es-CO');
    };

    const openCodModal = (pkgId?: '1_bolsa' | '2_bolsas' | '3_bolsas') => {
        if (pkgId) {
            setSelectedPkgId(pkgId);
        }
        setShowSaleToast(false);
        setIsCodModalOpen(true);
    };

    const handleOrderSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setFormError(null);

        if (!customerName.trim() || !customerPhone.trim() || !department || !city.trim() || !address.trim()) {
            setFormError('Por favor completa tu nombre, WhatsApp, departamento, ciudad y dirección exacta para despachar tu pedido.');
            return;
        }

        setIsSubmitting(true);
        try {
            const response = await axios.post('/biolab/order', {
                bundle_id: selectedPkgId,
                customer_name: customerName.trim(),
                customer_phone: customerPhone.trim(),
                customer_email: customerEmail.trim() || null,
                department,
                city: city.trim(),
                address: address.trim(),
                neighborhood: neighborhood.trim() || null,
                pet_type: petType,
                pet_name: petName.trim() || null,
                notes: notes.trim() || null,
                order_bump: orderBump,
            });

            if (response.data?.success) {
                setOrderSuccess({
                    order_code: response.data.order_code,
                    bundle_title: response.data.order?.bundle_title || selectedPkg.name,
                    formatted_price: response.data.order?.formatted_price || formatCOP(selectedPkg.price),
                    whatsapp_url: response.data.whatsapp_url,
                    guide_pdf_url:
                        response.data.guide_pdf_url ||
                        '/guias/guia-nutricion-clinica-hipoalergenica-avipet-biolab.pdf',
                });
            } else {
                setFormError('No pudimos procesar tu solicitud. Intenta nuevamente.');
            }
        } catch (err: any) {
            const msg =
                err?.response?.data?.message ||
                'Verifica que todos los campos obligatorios estén completos e intenta de nuevo.';
            setFormError(msg);
        } finally {
            setIsSubmitting(false);
        }
    };

    const currentSale = LIVE_SALES_NOTIFICATIONS[activeSaleIdx];

    return (
        <>
            <Head title="DERMO & GUT SUPERBOOST® | Oferta Oficial Contraentrega — AVIPET BioLab®">
                <meta
                    name="description"
                    content="Alivia la picazón, lamido de patas, caída de pelo y heces blandas desde la raíz. Suplemento biotecnológico 3 en 1 con 40% Micro-Proteína Novel y 4.5% Ácido Láurico. Envío GRATIS y Pago Contraentrega en Colombia."
                />
            </Head>

            <div className="min-h-screen bg-[#F8FAFC] text-slate-900 font-sans selection:bg-indigo-600 selection:text-white pb-28 lg:pb-12">
                {/* 1. TOP FUNNELISH URGENCY BAR */}
                <div className="bg-gradient-to-r from-[#1E1446] via-[#2D1B69] to-[#1E1446] text-white text-center py-2.5 px-3 border-b border-indigo-400/20 sticky top-0 z-40 shadow-md">
                    <div className="max-w-7xl mx-auto flex flex-wrap items-center justify-center gap-x-4 gap-y-1 text-xs sm:text-sm font-bold tracking-wide">
                        <span className="inline-flex items-center gap-1.5 text-emerald-300">
                            <span className="h-2 w-2 rounded-full bg-emerald-400 animate-ping" />
                            🇨🇴 ENVÍO GRATIS HOY A TODA COLOMBIA
                        </span>
                        <span className="hidden sm:inline text-indigo-300">•</span>
                        <span className="text-amber-300">🤝 PAGO CONTRAENTREGA (PAGAS AL RECIBIR EN CASA)</span>
                        <span className="hidden md:inline text-indigo-300">•</span>
                        <span className="hidden md:inline text-cyan-200">
                            ⏱ DESPACHO HOY SI PIDES EN: {countdown.hrs}:{countdown.mins}:{countdown.secs}
                        </span>
                    </div>
                </div>

                {/* 2. MINIMALIST ZERO-DISTRACTION FUNNEL HEADER */}
                <header className="bg-white border-b border-slate-200">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-3">
                        <Link href="/" className="flex items-center gap-3 group">
                            <img
                                src="/images/biolab/logo-avipet-biolab.jpg"
                                alt="AVIPET BioLab"
                                className="h-11 w-11 rounded-xl object-cover border border-slate-200 shadow-sm"
                            />
                            <div>
                                <div className="flex items-center gap-1.5">
                                    <span className="text-lg font-black tracking-tight text-[#1E1446]">AVIPET</span>
                                    <span className="text-lg font-extrabold tracking-tight text-cyan-600">BioLab®</span>
                                </div>
                                <p className="text-[11px] font-semibold text-slate-500 -mt-1">
                                    División de Biotecnología Nutricional Veterinaria
                                </p>
                            </div>
                        </Link>

                        <div className="hidden md:flex items-center gap-2 bg-emerald-50 border border-emerald-200 px-3.5 py-1.5 rounded-full text-xs font-bold text-emerald-800">
                            <span className="h-2.5 w-2.5 rounded-full bg-emerald-500 animate-pulse" />
                            <span>👀 {liveViewers} dueños de mascotas en Colombia están viendo esta oferta</span>
                        </div>

                        <button
                            type="button"
                            onClick={() => openCodModal()}
                            className="bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-xs sm:text-sm px-4 py-2.5 rounded-xl shadow-md transition cursor-pointer flex items-center gap-1.5"
                        >
                            <span>🚚 Pedir Contraentrega</span>
                        </button>
                    </div>
                </header>

                {/* 3. HERO BUY-BOX FUNNEL (ABOVE THE FOLD) */}
                <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-14">
                    <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">
                        {/* LEFT COLUMN: STICKY PRODUCT GALLERY + GIF DEMO + VISUAL STATS */}
                        <div className="lg:col-span-6 lg:sticky lg:top-16 space-y-4">
                            {/* Main 1:1 Image / GIF Frame */}
                            <div className="relative bg-white rounded-3xl border-2 border-slate-200 shadow-xl overflow-hidden">
                                {/* Top Floating Badges */}
                                <div className="absolute top-3.5 left-3.5 right-3.5 z-10 flex items-center justify-between gap-2 pointer-events-none">
                                    <span className="bg-[#1E1446]/90 backdrop-blur-md text-white text-[11px] sm:text-xs font-extrabold px-3 py-1.5 rounded-full shadow-md">
                                        {GALLERY_IMAGES[activeImageIdx].badge}
                                    </span>
                                    <span className="bg-amber-400 text-slate-950 text-xs font-black px-3 py-1.5 rounded-full shadow-md">
                                        ★ 4.9/5 (342)
                                    </span>
                                </div>

                                <div className="aspect-square w-full bg-slate-50 flex items-center justify-center overflow-hidden">
                                    <img
                                        src={GALLERY_IMAGES[activeImageIdx].src}
                                        alt={GALLERY_IMAGES[activeImageIdx].caption}
                                        className="w-full h-full object-cover transition-all duration-300"
                                    />
                                </div>

                                {/* Bottom Caption Strip */}
                                <div className="bg-slate-900 text-white px-4 py-2.5 flex items-center justify-between gap-3 text-xs">
                                    <span className="font-medium text-slate-200 line-clamp-1">
                                        {GALLERY_IMAGES[activeImageIdx].caption}
                                    </span>
                                    <span className="shrink-0 text-cyan-300 font-bold">
                                        {activeImageIdx + 1}/{GALLERY_IMAGES.length}
                                    </span>
                                </div>
                            </div>

                            {/* 6 Thumbnail Selector Strip (Includes 🎬 Video GIF) */}
                            <div className="grid grid-cols-6 gap-2">
                                {GALLERY_IMAGES.map((img, idx) => (
                                    <button
                                        key={idx}
                                        type="button"
                                        onClick={() => setActiveImageIdx(idx)}
                                        className={`group relative rounded-xl overflow-hidden border-2 transition cursor-pointer bg-white ${
                                            activeImageIdx === idx
                                                ? 'border-indigo-600 ring-2 ring-indigo-600/30 scale-[1.02]'
                                                : 'border-slate-200 opacity-80 hover:opacity-100'
                                        }`}
                                    >
                                        <div className="aspect-square w-full overflow-hidden">
                                            <img
                                                src={img.src}
                                                alt={img.thumbLabel}
                                                className="w-full h-full object-cover"
                                            />
                                        </div>
                                        <div
                                            className={`text-[10px] font-bold py-1 text-center truncate px-1 ${
                                                activeImageIdx === idx
                                                    ? 'bg-indigo-600 text-white'
                                                    : 'bg-slate-100 text-slate-700'
                                            }`}
                                        >
                                            {img.thumbLabel}
                                        </div>
                                    </button>
                                ))}
                            </div>

                            {/* Trust Badges Under Gallery */}
                            <div className="grid grid-cols-4 gap-2 bg-white p-3.5 rounded-2xl border border-slate-200 shadow-sm text-center">
                                <div className="space-y-0.5">
                                    <div className="text-lg">🐔🚫</div>
                                    <p className="text-[11px] font-extrabold text-slate-800 leading-tight">0% Pollo / Res</p>
                                    <p className="text-[10px] text-slate-500">Hipoalergénico</p>
                                </div>
                                <div className="space-y-0.5">
                                    <div className="text-lg">🌾🚫</div>
                                    <p className="text-[11px] font-extrabold text-slate-800 leading-tight">Sin Granos</p>
                                    <p className="text-[10px] text-slate-500">100% Sin Gluten</p>
                                </div>
                                <div className="space-y-0.5">
                                    <div className="text-lg">🔬✨</div>
                                    <p className="text-[11px] font-extrabold text-slate-800 leading-tight">Ácido Láurico</p>
                                    <p className="text-[10px] text-slate-500">4.5% Dermo-Activo</p>
                                </div>
                                <div className="space-y-0.5">
                                    <div className="text-lg">🇨🇴🚚</div>
                                    <p className="text-[11px] font-extrabold text-slate-800 leading-tight">Contraentrega</p>
                                    <p className="text-[10px] text-slate-500">Envío Gratis</p>
                                </div>
                            </div>

                            {/* Desktop Clinical Percentage Proof Box */}
                            <div className="hidden lg:block bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-3.5">
                                <div className="flex items-center justify-between">
                                    <h3 className="text-sm font-black uppercase tracking-wider text-[#1E1446]">
                                        📊 Resultados Reportados por Dueños en Colombia
                                    </h3>
                                    <span className="text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full">
                                        Estudio de Uso 30 Días
                                    </span>
                                </div>
                                <div className="space-y-3">
                                    {CLINICAL_STATS.map((stat, i) => (
                                        <div key={i} className="space-y-1">
                                            <div className="flex items-center justify-between text-xs font-bold">
                                                <span className="text-slate-800">{stat.title}</span>
                                                <span className="text-indigo-700 font-black">{stat.percentage}%</span>
                                            </div>
                                            <div className="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                                <div
                                                    className="h-full bg-gradient-to-r from-indigo-600 to-cyan-500 rounded-full"
                                                    style={{ width: `${stat.percentage}%` }}
                                                />
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </div>

                        {/* RIGHT COLUMN: FUNNELISH BUY BOX + KACHING BUNDLES + POPUP TRIGGER */}
                        <div className="lg:col-span-6 space-y-5">
                            {/* Social Proof & Live Viewers Pill */}
                            <div className="space-y-2">
                                <div className="flex flex-wrap items-center gap-2">
                                    <div className="inline-flex items-center gap-1 bg-amber-100 border border-amber-300 text-amber-900 px-3 py-1 rounded-full text-xs font-extrabold">
                                        <span className="text-amber-500">★★★★★</span>
                                        <span>4.9/5 • +340 Clientes Verificados en Colombia</span>
                                    </div>
                                    <span className="bg-emerald-100 text-emerald-900 text-xs font-extrabold px-3 py-1 rounded-full inline-flex items-center gap-1.5">
                                        <span className="h-2 w-2 rounded-full bg-emerald-600 animate-ping" />
                                        {liveViewers} personas viendo ahora
                                    </span>
                                </div>

                                <h1 className="text-2xl sm:text-3xl lg:text-[34px] font-black text-[#1E1446] leading-[1.15] tracking-tight">
                                    DERMO & GUT SUPERBOOST® — Alivia la Picazón, el Lamido de Patas, la Caída de Pelo y las Heces Blandas desde la Raíz
                                </h1>

                                <p className="text-sm sm:text-base text-slate-600 font-medium leading-relaxed">
                                    Suplemento Nutricional Biotecnológico <strong className="text-slate-900">3 en 1 en Polvo (250g • 50 Dosis)</strong> con{' '}
                                    <strong className="text-indigo-700">40% Micro-Proteína Novel Hipoalergénica</strong> +{' '}
                                    <strong className="text-indigo-700">4.5% Ácido Láurico + Omega 3-6-9 + Prebióticos</strong>.
                                </p>
                            </div>

                            {/* Price Anchor + Veterinary Cost Comparison Mental Trigger */}
                            <div className="bg-white rounded-2xl border-2 border-indigo-100 p-4 space-y-3 shadow-sm">
                                <div className="flex flex-wrap items-center justify-between gap-3">
                                    <div>
                                        <span className="text-xs font-bold uppercase tracking-wider text-slate-400 block">
                                            Precio Oferta de Lanzamiento Hoy:
                                        </span>
                                        <div className="flex items-baseline gap-2.5 mt-0.5">
                                            <span className="text-3xl sm:text-4xl font-black text-emerald-600">
                                                {formatCOP(selectedPkg.price)}
                                            </span>
                                            <span className="text-base sm:text-lg text-slate-400 line-through font-bold">
                                                {formatCOP(selectedPkg.compareAt)}
                                            </span>
                                            <span className="bg-rose-100 text-rose-700 text-xs font-black px-2.5 py-1 rounded-full">
                                                AHORRAS {formatCOP(selectedPkg.savings)}
                                            </span>
                                        </div>
                                    </div>
                                    <div className="text-right">
                                        <span className="inline-flex items-center gap-1 text-xs font-extrabold text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-xl">
                                            ✅ Envío Gratis + Contraentrega
                                        </span>
                                        <p className="text-[11px] text-slate-600 font-bold mt-1">
                                            ☕ Solo <strong>{formatCOP(Math.round(selectedPkg.price / selectedPkg.doses))} al día</strong> por dosis
                                        </p>
                                    </div>
                                </div>

                                {/* Mental Trigger: Cost Comparison vs Vet Visits */}
                                <div className="bg-indigo-50/80 border border-indigo-200/80 rounded-xl px-3.5 py-2 text-xs text-indigo-950 flex items-center justify-between gap-2">
                                    <span>
                                        💡 <strong>Ahorro Inteligente:</strong> Una sola consulta dermatológica + exámenes y cremas cuesta <strong>+$280.000 COP</strong>.
                                    </span>
                                </div>
                            </div>

                            {/* Dynamic Stock Scarcity & Countdown Strip */}
                            <div
                                className={`rounded-2xl p-3.5 space-y-2 border-2 transition-all duration-300 ${
                                    stockFlash
                                        ? 'bg-rose-100 border-rose-500 scale-[1.01]'
                                        : 'bg-amber-50 border-amber-300'
                                }`}
                            >
                                <div className="flex items-center justify-between gap-2 text-xs sm:text-sm font-extrabold text-amber-950">
                                    <span className="flex items-center gap-1.5 flex-wrap">
                                        <span>🔥 ¡Alta demanda hoy! Solo quedan</span>
                                        <span className="bg-rose-600 text-white px-2.5 py-0.5 rounded-md font-black animate-pulse">
                                            {stockLeft} unidades
                                        </span>
                                        <span>del lote fresco con Envío Gratis</span>
                                    </span>
                                    <span className="font-mono bg-slate-900 text-amber-300 px-2.5 py-1 rounded-lg text-xs font-black shrink-0">
                                        ⏱ {countdown.hrs}:{countdown.mins}:{countdown.secs}
                                    </span>
                                </div>
                                <div className="w-full h-2.5 bg-amber-200 rounded-full overflow-hidden">
                                    <div
                                        className="h-full bg-gradient-to-r from-rose-600 to-amber-500 rounded-full transition-all duration-500"
                                        style={{ width: `${Math.max(18, stockLeft * 7)}%` }}
                                    />
                                </div>
                            </div>

                            {/* =========================================================
                                PASO 1: KACHING-STYLE BUNDLE SELECTOR (RADIO CARDS)
                               ========================================================= */}
                            <div className="bg-white rounded-3xl border-2 border-slate-200 p-4 sm:p-5 shadow-lg space-y-4">
                                <div className="flex items-center justify-between">
                                    <div className="flex items-center gap-2">
                                        <span className="bg-[#1E1446] text-white text-xs font-black px-2.5 py-1 rounded-lg">
                                            PASO 1
                                        </span>
                                        <h2 className="text-base sm:text-lg font-black text-slate-900">
                                            ELIGE TU OFERTA CON ENVÍO GRATIS
                                        </h2>
                                    </div>
                                    <span className="text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full">
                                        Pagas en Casa
                                    </span>
                                </div>

                                <div className="space-y-3">
                                    {packages.map((pkg) => {
                                        const isSelected = selectedPkgId === pkg.id;
                                        return (
                                            <div
                                                key={pkg.id}
                                                onClick={() => setSelectedPkgId(pkg.id)}
                                                className={`relative rounded-2xl border-2 p-4 transition-all cursor-pointer ${
                                                    isSelected
                                                        ? 'border-indigo-600 bg-indigo-50/50 ring-2 ring-indigo-600/20 shadow-md'
                                                        : 'border-slate-200 bg-white hover:border-slate-300'
                                                }`}
                                            >
                                                {pkg.badge && (
                                                    <div
                                                        className={`absolute -top-3 right-3 px-3 py-0.5 rounded-full text-[11px] font-black tracking-wide shadow-sm ${
                                                            pkg.popular
                                                                ? 'bg-gradient-to-r from-rose-600 to-orange-500 text-white'
                                                                : pkg.bestValue
                                                                ? 'bg-gradient-to-r from-[#1E1446] to-indigo-700 text-amber-300'
                                                                : 'bg-emerald-100 text-emerald-800 border border-emerald-300'
                                                        }`}
                                                    >
                                                        {pkg.badge}
                                                    </div>
                                                )}

                                                <div className="flex items-center justify-between gap-3">
                                                    <div className="flex items-start gap-3">
                                                        <div
                                                            className={`mt-1 h-5 w-5 rounded-full border-2 flex items-center justify-center shrink-0 ${
                                                                isSelected
                                                                    ? 'border-indigo-600 bg-indigo-600'
                                                                    : 'border-slate-300 bg-white'
                                                            }`}
                                                        >
                                                            {isSelected && (
                                                                <div className="h-2 w-2 rounded-full bg-white" />
                                                            )}
                                                        </div>

                                                        <div>
                                                            <span className="font-black text-sm sm:text-base text-slate-900 block">
                                                                {pkg.name}
                                                            </span>
                                                            <p className="text-xs font-semibold text-slate-500 mt-0.5">
                                                                {pkg.subtitle} •{' '}
                                                                <span className="text-indigo-700 font-bold">
                                                                    Sale a {formatCOP(pkg.unitPrice)} por bolsa
                                                                </span>
                                                            </p>
                                                            <div className="flex flex-wrap gap-1.5 mt-2">
                                                                {pkg.perks.map((perk, idx) => (
                                                                    <span
                                                                        key={idx}
                                                                        className="text-[11px] font-bold bg-white border border-slate-200 text-slate-700 px-2 py-0.5 rounded-md"
                                                                    >
                                                                        ✓ {perk}
                                                                    </span>
                                                                ))}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div className="text-right shrink-0">
                                                        <div className="text-lg sm:text-xl font-black text-slate-900">
                                                            {formatCOP(pkg.price)}
                                                        </div>
                                                        <div className="text-xs text-slate-400 line-through font-bold">
                                                            {formatCOP(pkg.compareAt)}
                                                        </div>
                                                        <div className="text-[11px] font-extrabold text-emerald-700 mt-0.5">
                                                            Envío Gratis
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        );
                                    })}
                                </div>

                                {/* =========================================================
                                    PASO 2: FUNNELISH 1-CLICK ORDER BUMP (BONO PDF 6 PÁGINAS)
                                   ========================================================= */}
                                <div
                                    onClick={() => setOrderBump(!orderBump)}
                                    className="rounded-2xl border-2 border-dashed border-amber-500 bg-amber-50/90 p-3.5 cursor-pointer transition hover:bg-amber-100/70"
                                >
                                    <div className="flex items-start gap-3">
                                        <input
                                            type="checkbox"
                                            checked={orderBump}
                                            onChange={(e) => setOrderBump(e.target.checked)}
                                            onClick={(e) => e.stopPropagation()}
                                            className="mt-1 h-5 w-5 rounded border-amber-500 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                        />
                                        <div className="text-xs sm:text-sm">
                                            <div className="flex flex-wrap items-center gap-1.5 font-black text-slate-900">
                                                <span className="bg-amber-400 text-slate-950 px-2 py-0.5 rounded text-[11px]">
                                                    🎁 BONO EXCLUSIVO HOY (PDF 6 PÁGINAS)
                                                </span>
                                                <span>
                                                    ¡SÍ! Incluir Guía Digital de Nutrición Clínica Hipoalergénica + Despacho Prioritario
                                                </span>
                                            </div>
                                            <p className="text-xs text-slate-700 mt-1 leading-relaxed">
                                                Descarga inmediata al pedir + envío a tu WhatsApp del Manual Clínico de 6 páginas (Semáforo de alérgenos, 3 recetas caseras y bitácora de 30 días).{' '}
                                                <span className="line-through text-slate-400 font-bold">$29.900</span>{' '}
                                                <strong className="text-emerald-700 font-black">¡HOY GRATIS ($0 COP)!</strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {/* =========================================================
                                    GIANT SHOPIFY RELEASIT COD POPUP TRIGGER BUTTON
                                   ========================================================= */}
                                <div className="pt-1 space-y-2.5">
                                    <button
                                        type="button"
                                        onClick={() => openCodModal()}
                                        className="w-full py-4 sm:py-5 px-6 rounded-2xl bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-black text-base sm:text-xl shadow-xl shadow-emerald-600/30 border-b-4 border-emerald-800 transition transform hover:-translate-y-0.5 active:translate-y-0 cursor-pointer flex flex-col items-center justify-center gap-0.5"
                                    >
                                        <span className="flex items-center gap-2">
                                            <span>🚚 ¡PEDIR AHORA Y PAGAR EN CASA! — {formatCOP(selectedPkg.price)}</span>
                                        </span>
                                        <span className="text-[11px] sm:text-xs font-bold text-emerald-100 tracking-wide">
                                            🔒 Clic aquí para ingresar tu dirección en 30 segundos • Envío 100% Gratis
                                        </span>
                                    </button>

                                    <div className="flex flex-wrap items-center justify-center gap-3 text-[11px] font-bold text-slate-500 text-center">
                                        <span>💵 Pagas en Efectivo o Nequi/Bancolombia al recibir</span>
                                        <span>•</span>
                                        <span>📦 Despacho Prioritario 24h</span>
                                    </div>
                                </div>
                            </div>

                            {/* =========================================================
                                ANIMATED GIF DEMO CARD RIGHT IN THE BUY FLOW
                               ========================================================= */}
                            <div className="bg-slate-900 text-white rounded-3xl p-4 sm:p-5 border-2 border-indigo-500/30 shadow-xl">
                                <div className="grid grid-cols-1 sm:grid-cols-12 gap-4 items-center">
                                    <div className="sm:col-span-5">
                                        <div className="rounded-2xl overflow-hidden border-2 border-cyan-400/40 aspect-square relative">
                                            <img
                                                src="/images/biolab/biolab-demo-accion.gif"
                                                alt="Demostración en acción Dermo & Gut Superboost"
                                                className="w-full h-full object-cover"
                                            />
                                            <span className="absolute top-2 left-2 bg-rose-600 text-white text-[10px] font-black px-2 py-0.5 rounded-full animate-pulse">
                                                ● GIF EN VIVO
                                            </span>
                                        </div>
                                    </div>
                                    <div className="sm:col-span-7 space-y-2.5">
                                        <span className="text-[11px] font-black uppercase tracking-wider text-cyan-300">
                                            🎬 MIRA LO FÁCIL QUE ES TRANSFORMAR SU SALUD
                                        </span>
                                        <h3 className="text-base sm:text-lg font-black leading-snug">
                                            Sin peleas con pastillas amargas ni cremas pegajosas que tu mascota se lame
                                        </h3>
                                        <ul className="space-y-1.5 text-xs text-slate-300">
                                            <li>✅ <strong>40% Micro-Proteína Novel:</strong> No dispara alergia como el pollo o la res.</li>
                                            <li>✅ <strong>4.5% Ácido Láurico:</strong> Combate hongos, levaduras y patas rojas desde adentro.</li>
                                            <li>✅ <strong>Alta Palatabilidad:</strong> Sabor natural tostado que perros y gatos aman.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* =================================================================
                    4. SECTION: ANTES VS DESPUÉS + ROMPE EL CICLO DE LA ALERGIA
                   ================================================================= */}
                <section className="bg-white border-y border-slate-200 py-14 sm:py-20">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center max-w-3xl mx-auto space-y-3 mb-12">
                            <span className="inline-block bg-rose-100 text-rose-800 text-xs font-black uppercase tracking-wider px-3.5 py-1 rounded-full">
                                ¿POR QUÉ TU MASCOTA NO DEJA DE RASCARSE NI LAMERSE LAS PATAS?
                            </span>
                            <h2 className="text-2xl sm:text-4xl font-black text-[#1E1446] tracking-tight">
                                Las cremas y pastillas solo apagan el síntoma por unos días. La verdadera causa está en su intestino y en las proteínas comerciales.
                            </h2>
                            <p className="text-sm sm:text-base text-slate-600">
                                El 80% de los perros y gatos con dermatitis, otitis recurrente, patas rojas y heces blandas sufren de{' '}
                                <strong>inflamación inmunológica causada por el pollo, la res y los cereales</strong>.
                            </p>
                        </div>

                        <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                            <div className="lg:col-span-6">
                                <div className="bg-slate-900 rounded-3xl p-3 sm:p-4 shadow-2xl border border-slate-800">
                                    <div className="rounded-2xl overflow-hidden aspect-square">
                                        <img
                                            src="/images/biolab/funnel-antes-despues.jpg"
                                            alt="Antes y Después Dermo & Gut Superboost"
                                            className="w-full h-full object-cover"
                                        />
                                    </div>
                                    <div className="grid grid-cols-2 gap-3 mt-3 text-xs sm:text-sm">
                                        <div className="bg-rose-950/80 border border-rose-500/40 rounded-xl p-3 text-rose-100">
                                            <span className="font-black text-rose-400 block uppercase">❌ ANTES (Día 1)</span>
                                            Patas rojas por lamido constante, picazón desesperante, caspa, mal olor y heces blandas.
                                        </div>
                                        <div className="bg-emerald-950/80 border border-emerald-500/40 rounded-xl p-3 text-emerald-100">
                                            <span className="font-black text-emerald-400 block uppercase">✅ DESPUÉS (Día 21-30)</span>
                                            Piel sana sin enrojecimiento, pelaje tupido y brillante, digestión firme y aliento fresco.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div className="lg:col-span-6 space-y-5">
                                <h3 className="text-xl sm:text-2xl font-black text-[#1E1446]">
                                    Cronología Clínica de Transformación con DERMO & GUT SUPERBOOST®:
                                </h3>

                                <div className="space-y-4">
                                    <div className="bg-slate-50 rounded-2xl border border-slate-200 p-5 flex items-start gap-4">
                                        <div className="h-12 w-12 rounded-2xl bg-indigo-600 text-white font-black text-sm flex flex-col items-center justify-center shrink-0">
                                            <span>DÍA</span>
                                            <span className="text-base leading-none">5-7</span>
                                        </div>
                                        <div>
                                            <h4 className="font-black text-base text-slate-900">
                                                Fase 1: Equilibrio de Microbiota, Heces Firmes y Aliento Fresco
                                            </h4>
                                            <p className="text-xs sm:text-sm text-slate-600 mt-1 leading-relaxed">
                                                La fibra prebiótica (Quitina + Pectina de Ahuyama) junto a los Beta-glucanos y el Perejil deshidratado regulan el tránsito intestinal, compactan las heces y eliminan los gases y el mal aliento desde el estómago.
                                            </p>
                                        </div>
                                    </div>

                                    <div className="bg-slate-50 rounded-2xl border border-slate-200 p-5 flex items-start gap-4">
                                        <div className="h-12 w-12 rounded-2xl bg-cyan-600 text-white font-black text-sm flex flex-col items-center justify-center shrink-0">
                                            <span>DÍA</span>
                                            <span className="text-base leading-none">14-21</span>
                                        </div>
                                        <div>
                                            <h4 className="font-black text-base text-slate-900">
                                                Fase 2: Alivio de Picazón, Patas Rojas y Control de Levaduras
                                            </h4>
                                            <p className="text-xs sm:text-sm text-slate-600 mt-1 leading-relaxed">
                                                El <strong>Ácido Láurico natural (4.5%)</strong> y los curcumoides biodisponibles actúan como escudo antimicrobiano y antiinflamatorio natural, frenando el rascado y el lamido obsesivo de patas.
                                            </p>
                                        </div>
                                    </div>

                                    <div className="bg-slate-50 rounded-2xl border border-slate-200 p-5 flex items-start gap-4">
                                        <div className="h-12 w-12 rounded-2xl bg-emerald-600 text-white font-black text-sm flex flex-col items-center justify-center shrink-0">
                                            <span>DÍA</span>
                                            <span className="text-base leading-none">30+</span>
                                        </div>
                                        <div>
                                            <h4 className="font-black text-base text-slate-900">
                                                Fase 3: Freno a la Caída de Pelo y Pelaje de Exposición
                                            </h4>
                                            <p className="text-xs sm:text-sm text-slate-600 mt-1 leading-relaxed">
                                                El 40% de Micro-Proteína Novel junto a los ácidos grasos <strong>Omega 3, 6 y 9 de la Linaza Dorada</strong> nutren el folículo piloso, detienen la caída excesiva y devuelven un brillo sedoso.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <button
                                    type="button"
                                    onClick={() => openCodModal()}
                                    className="w-full sm:w-auto px-8 py-4 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-sm sm:text-base shadow-lg transition cursor-pointer"
                                >
                                    🚚 PEDIR AHORA CON PAGO CONTRAENTREGA →
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

                {/* =================================================================
                    5. SECTION: TABLA COMPARATIVA AGRESIVA (GATILLO DE AUTORIDAD)
                   ================================================================= */}
                <section className="py-14 sm:py-20 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center max-w-3xl mx-auto space-y-3 mb-10">
                        <span className="inline-block bg-indigo-100 text-indigo-800 text-xs font-black uppercase tracking-wider px-3.5 py-1 rounded-full">
                            COMPARATIVA CLÍNICA
                        </span>
                        <h2 className="text-2xl sm:text-4xl font-black text-[#1E1446] tracking-tight">
                            ¿Por qué DERMO & GUT SUPERBOOST® supera a los tratamientos tradicionales?
                        </h2>
                    </div>

                    <div className="bg-white rounded-3xl border-2 border-slate-200 shadow-xl overflow-hidden">
                        <div className="overflow-x-auto">
                            <table className="w-full text-left border-collapse text-xs sm:text-sm">
                                <thead>
                                    <tr className="bg-[#1E1446] text-white">
                                        <th className="p-4 sm:p-5 font-black">Característica / Beneficio</th>
                                        <th className="p-4 sm:p-5 font-black bg-emerald-600 text-white text-center">
                                            🏆 DERMO & GUT SUPERBOOST®
                                        </th>
                                        <th className="p-4 sm:p-5 font-bold text-slate-300 text-center">
                                            Pastillas / Corticoides
                                        </th>
                                        <th className="p-4 sm:p-5 font-bold text-slate-300 text-center">
                                            Aceites Líquidos Comunes
                                        </th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-slate-200 font-medium">
                                    <tr>
                                        <td className="p-4 font-bold text-slate-900">Ataca la raíz intestinal y alérgica</td>
                                        <td className="p-4 text-center bg-emerald-50 font-black text-emerald-700">✅ SÍ (3 en 1 Completo)</td>
                                        <td className="p-4 text-center text-slate-500">❌ Solo apaga el síntoma</td>
                                        <td className="p-4 text-center text-slate-500">❌ No contiene prebióticos</td>
                                    </tr>
                                    <tr>
                                        <td className="p-4 font-bold text-slate-900">40% Micro-Proteína Novel (0% Pollo/Res)</td>
                                        <td className="p-4 text-center bg-emerald-50 font-black text-emerald-700">✅ SÍ (Hipoalergénica)</td>
                                        <td className="p-4 text-center text-slate-500">❌ No aporta nutrición</td>
                                        <td className="p-4 text-center text-slate-500">❌ 0% Proteína</td>
                                    </tr>
                                    <tr>
                                        <td className="p-4 font-bold text-slate-900">Ácido Láurico Antihongos (4.5%)</td>
                                        <td className="p-4 text-center bg-emerald-50 font-black text-emerald-700">✅ SÍ (Escudo Dermo-Activo)</td>
                                        <td className="p-4 text-center text-slate-500">❌ No</td>
                                        <td className="p-4 text-center text-slate-500">❌ No</td>
                                    </tr>
                                    <tr>
                                        <td className="p-4 font-bold text-slate-900">No se oxida ni huele a pescado rancio</td>
                                        <td className="p-4 text-center bg-emerald-50 font-black text-emerald-700">✅ Polvo Estable (Doypack Zipper)</td>
                                        <td className="p-4 text-center text-slate-500">⚪ Pastilla difícil de dar</td>
                                        <td className="p-4 text-center text-rose-600 font-bold">❌ Se oxida al abrir el tarro</td>
                                    </tr>
                                    <tr>
                                        <td className="p-4 font-bold text-slate-900">Seguro para uso continuo (Hígado y Riñón)</td>
                                        <td className="p-4 text-center bg-emerald-50 font-black text-emerald-700">✅ 100% Natural y Seguro</td>
                                        <td className="p-4 text-center text-rose-600 font-bold">❌ Riesgo hepático/renal</td>
                                        <td className="p-4 text-center text-slate-500">⚪ Puede dar diarrea</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                {/* =================================================================
                    6. SECTION: MODO DE USO EN 3 SEGUNDOS + CALCULADORA DE DOSIS
                   ================================================================= */}
                <section className="py-12 sm:py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                        <div className="lg:col-span-6 space-y-6">
                            <span className="inline-block bg-indigo-100 text-indigo-800 text-xs font-black uppercase tracking-wider px-3.5 py-1 rounded-full">
                                CERO ESTRÉS • SIN PASTILLAS DIFÍCILES DE TRAGAR
                            </span>
                            <h2 className="text-2xl sm:text-4xl font-black text-[#1E1446] tracking-tight">
                                Tan fácil como espolvorear 1 cucharadita (5g) sobre su comida favorita
                            </h2>
                            <p className="text-sm sm:text-base text-slate-600 leading-relaxed">
                                Olvídate de pelear con tu perro o gato para darle pastillas o jarabes amargos.{' '}
                                <strong>DERMO & GUT SUPERBOOST®</strong> tiene un aroma y sabor natural tostado que transforma su plato diario en un superalimento clínico.
                            </p>

                            {/* Interactive Dosage Calculator */}
                            <div className="bg-white rounded-3xl border-2 border-indigo-100 p-5 sm:p-6 shadow-md space-y-4">
                                <h3 className="text-sm font-black uppercase tracking-wider text-indigo-900">
                                    ⚖️ Calcula cuánto te dura según el peso de tu mascota:
                                </h3>
                                <div className="grid grid-cols-3 gap-2">
                                    <button
                                        type="button"
                                        onClick={() => setPetWeightRange('small')}
                                        className={`py-3 px-2 rounded-xl font-black text-xs sm:text-sm border-2 transition cursor-pointer ${
                                            petWeightRange === 'small'
                                                ? 'border-indigo-600 bg-indigo-600 text-white'
                                                : 'border-slate-200 bg-slate-50 text-slate-700'
                                        }`}
                                    >
                                        🐾 1 a 10 kg
                                        <span className="block text-[10px] font-medium opacity-80">Pequeños / Gatos</span>
                                    </button>
                                    <button
                                        type="button"
                                        onClick={() => setPetWeightRange('medium')}
                                        className={`py-3 px-2 rounded-xl font-black text-xs sm:text-sm border-2 transition cursor-pointer ${
                                            petWeightRange === 'medium'
                                                ? 'border-indigo-600 bg-indigo-600 text-white'
                                                : 'border-slate-200 bg-slate-50 text-slate-700'
                                        }`}
                                    >
                                        🐕 11 a 25 kg
                                        <span className="block text-[10px] font-medium opacity-80">Razas Medianas</span>
                                    </button>
                                    <button
                                        type="button"
                                        onClick={() => setPetWeightRange('large')}
                                        className={`py-3 px-2 rounded-xl font-black text-xs sm:text-sm border-2 transition cursor-pointer ${
                                            petWeightRange === 'large'
                                                ? 'border-indigo-600 bg-indigo-600 text-white'
                                                : 'border-slate-200 bg-slate-50 text-slate-700'
                                        }`}
                                    >
                                        🦮 +25 kg
                                        <span className="block text-[10px] font-medium opacity-80">Razas Grandes</span>
                                    </button>
                                </div>

                                {petWeightRange === 'small' && (
                                    <div className="bg-indigo-50/70 rounded-2xl p-4 border border-indigo-200 space-y-2 text-xs sm:text-sm">
                                        <p className="font-black text-indigo-950">
                                            🥄 Dosis diaria: 1 cuchara dosificadora (5g) al día.
                                        </p>
                                        <p className="text-slate-700">
                                            • <strong>1 Bolsa (250g)</strong> te rinde para <strong>50 días completos</strong>.
                                        </p>
                                        <button
                                            type="button"
                                            onClick={() => openCodModal('2_bolsas')}
                                            className="mt-1 inline-flex items-center gap-1.5 bg-emerald-600 text-white font-black text-xs px-4 py-2 rounded-xl cursor-pointer"
                                        >
                                            👉 Pedir Pack Dúo para 100 Días ($124.900)
                                        </button>
                                    </div>
                                )}
                                {petWeightRange === 'medium' && (
                                    <div className="bg-indigo-50/70 rounded-2xl p-4 border border-indigo-200 space-y-2 text-xs sm:text-sm">
                                        <p className="font-black text-indigo-950">
                                            🥄 Dosis diaria: 1 a 2 cucharas (5g a 10g) al día.
                                        </p>
                                        <p className="text-slate-700">
                                            • <strong>Pack Dúo (500g)</strong> te rinde de <strong>50 a 100 días completos</strong>.
                                        </p>
                                        <button
                                            type="button"
                                            onClick={() => openCodModal('2_bolsas')}
                                            className="mt-1 inline-flex items-center gap-1.5 bg-emerald-600 text-white font-black text-xs px-4 py-2 rounded-xl cursor-pointer"
                                        >
                                            👉 Pedir Pack Dúo Recomendado ($124.900)
                                        </button>
                                    </div>
                                )}
                                {petWeightRange === 'large' && (
                                    <div className="bg-indigo-50/70 rounded-2xl p-4 border border-indigo-200 space-y-2 text-xs sm:text-sm">
                                        <p className="font-black text-indigo-950">
                                            🥄 Dosis diaria: 2 cucharas dosificadoras (10g) al día.
                                        </p>
                                        <p className="text-slate-700">
                                            • <strong>Pack Trío (750g)</strong> te rinde para <strong>75 días de tratamiento continuo</strong>.
                                        </p>
                                        <button
                                            type="button"
                                            onClick={() => openCodModal('3_bolsas')}
                                            className="mt-1 inline-flex items-center gap-1.5 bg-emerald-600 text-white font-black text-xs px-4 py-2 rounded-xl cursor-pointer"
                                        >
                                            👉 Pedir Tratamiento 3 Bolsas ($169.900)
                                        </button>
                                    </div>
                                )}
                            </div>
                        </div>

                        <div className="lg:col-span-6">
                            <div className="bg-white rounded-3xl border-2 border-slate-200 p-3 sm:p-4 shadow-xl">
                                <div className="rounded-2xl overflow-hidden aspect-square">
                                    <img
                                        src="/images/biolab/funnel-modo-uso.jpg"
                                        alt="Modo de uso Dermo & Gut Superboost"
                                        className="w-full h-full object-cover"
                                    />
                                </div>
                                <div className="grid grid-cols-3 gap-2 mt-3 text-center">
                                    <div className="bg-slate-50 rounded-xl p-2.5 border border-slate-200">
                                        <span className="text-xs font-black text-indigo-700 block">PASO 1</span>
                                        <p className="text-[11px] font-bold text-slate-800 mt-0.5">Sirve su comida habitual</p>
                                    </div>
                                    <div className="bg-slate-50 rounded-xl p-2.5 border border-slate-200">
                                        <span className="text-xs font-black text-indigo-700 block">PASO 2</span>
                                        <p className="text-[11px] font-bold text-slate-800 mt-0.5">Espolvorea 1 cuchara (5g)</p>
                                    </div>
                                    <div className="bg-slate-50 rounded-xl p-2.5 border border-slate-200">
                                        <span className="text-xs font-black text-indigo-700 block">PASO 3</span>
                                        <p className="text-[11px] font-bold text-slate-800 mt-0.5">¡Disfruta ver su mejoría!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* =================================================================
                    7. SECTION: TRANSPARENCIA NUTRICIONAL + TABLA GARANTIZADA
                   ================================================================= */}
                <section className="bg-[#1E1446] text-white py-14 sm:py-20">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center max-w-3xl mx-auto space-y-3 mb-12">
                            <span className="inline-block bg-cyan-400/20 text-cyan-300 border border-cyan-400/30 text-xs font-black uppercase tracking-wider px-3.5 py-1 rounded-full">
                                FÓRMULA BIOTECNOLÓGICA EXCLUSIVA • 100% TRANSPARENCIA
                            </span>
                            <h2 className="text-2xl sm:text-4xl font-black tracking-tight">
                                Mira exactamente lo que hay dentro de cada bolsa de 250g
                            </h2>
                            <p className="text-sm sm:text-base text-indigo-200">
                                Cero rellenos baratos, cero harinas de subproductos avícolas, cero conservantes artificiales.
                            </p>
                        </div>

                        <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                            <div className="lg:col-span-6">
                                <div className="bg-white/10 backdrop-blur-md rounded-3xl p-3 border border-white/15 shadow-2xl">
                                    <img
                                        src="/images/biolab/funnel-frente-reverso.jpg"
                                        alt="Empaque Frente y Reverso AVIPET BioLab"
                                        className="w-full rounded-2xl object-cover"
                                    />
                                </div>
                            </div>

                            <div className="lg:col-span-6 space-y-5">
                                <div className="bg-white/10 backdrop-blur-md rounded-3xl p-6 border border-white/15 space-y-4">
                                    <h3 className="text-lg font-black text-cyan-300 uppercase tracking-wide">
                                        📋 Tabla Nutricional Garantizada (Por cada 100g)
                                    </h3>
                                    <div className="divide-y divide-white/10 text-xs sm:text-sm">
                                        <div className="py-2.5 flex justify-between">
                                            <span className="font-semibold text-indigo-100">Proteína Cruda Novel (Mín.)</span>
                                            <span className="font-black text-white">40.0%</span>
                                        </div>
                                        <div className="py-2.5 flex justify-between">
                                            <span className="font-semibold text-indigo-100">Grasa Cruda Funcional (Mín.)</span>
                                            <span className="font-black text-white">10.0%</span>
                                        </div>
                                        <div className="py-2.5 flex justify-between">
                                            <span className="font-semibold text-cyan-200">• Ácido Láurico Dermo-Activo</span>
                                            <span className="font-black text-cyan-300">4.5%</span>
                                        </div>
                                        <div className="py-2.5 flex justify-between">
                                            <span className="font-semibold text-cyan-200">• Ácidos Grasos Omega 3 y 6</span>
                                            <span className="font-black text-cyan-300">3.1%</span>
                                        </div>
                                        <div className="py-2.5 flex justify-between">
                                            <span className="font-semibold text-indigo-100">Fibra Prebiótica (Quitina + Pectina) (Máx.)</span>
                                            <span className="font-black text-white">9.8%</span>
                                        </div>
                                        <div className="py-2.5 flex justify-between">
                                            <span className="font-semibold text-indigo-100">Calcio Biodisponible (Mín.)</span>
                                            <span className="font-black text-white">2.4%</span>
                                        </div>
                                        <div className="py-2.5 flex justify-between">
                                            <span className="font-semibold text-indigo-100">Humedad (Máx.)</span>
                                            <span className="font-black text-white">7.5%</span>
                                        </div>
                                    </div>
                                    <p className="text-xs text-indigo-200 leading-relaxed pt-2">
                                        <strong>Composición:</strong> Matriz Proteica y Lipídica Dermo-Activa (micro-proteína purificada y desgrasada de <em>Hermetia illucens</em> y Semilla de linaza dorada molida) y Complejo Prebiótico y Fitoterapéutico Gut-Care (Fibra soluble de ahuyama deshidratada, Pared celular de levadura nutricional inactiva, Extracto de raíz de cúrcuma y Hojas de perejil deshidratado).
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* =================================================================
                    8. SECTION: LOOX / JUDGE.ME STYLE VERIFIED UGC PHOTO REVIEWS
                   ================================================================= */}
                <section className="py-14 sm:py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center max-w-3xl mx-auto space-y-3 mb-10">
                        <div className="inline-flex items-center gap-2 bg-amber-100 border border-amber-300 text-amber-900 px-4 py-1.5 rounded-full text-xs font-black">
                            <span>★★★★★</span>
                            <span>4.9 DE 5 ESTRELLAS • +340 FOTOS REALES DE CLIENTES EN COLOMBIA</span>
                        </div>
                        <h2 className="text-2xl sm:text-4xl font-black text-[#1E1446] tracking-tight">
                            Dueños reales en toda Colombia que ya recibieron su pedido Contraentrega
                        </h2>
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        {REVIEWS.map((rev, idx) => (
                            <div
                                key={idx}
                                className="bg-white rounded-3xl border border-slate-200 shadow-md overflow-hidden flex flex-col justify-between hover:shadow-xl transition"
                            >
                                <div>
                                    <div className="aspect-square w-full bg-slate-100 overflow-hidden relative">
                                        <img
                                            src={rev.image}
                                            alt={rev.title}
                                            className="w-full h-full object-cover"
                                        />
                                        <span className="absolute bottom-2.5 left-2.5 bg-slate-900/85 backdrop-blur-sm text-white text-[11px] font-bold px-2.5 py-1 rounded-lg">
                                            🐾 {rev.pet}
                                        </span>
                                    </div>
                                    <div className="p-5 space-y-2.5">
                                        <div className="flex items-center justify-between">
                                            <span className="text-amber-500 font-black text-sm">★★★★★</span>
                                            <span className="text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">
                                                ✓ Recibido en Casa
                                            </span>
                                        </div>
                                        <h3 className="font-black text-sm text-slate-900 leading-snug">{rev.title}</h3>
                                        <p className="text-xs text-slate-600 leading-relaxed">"{rev.text}"</p>
                                    </div>
                                </div>
                                <div className="px-5 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-[11px]">
                                    <div>
                                        <span className="font-black text-slate-900 block">{rev.name}</span>
                                        <span className="text-slate-500">{rev.city}</span>
                                    </div>
                                    <span className="font-bold text-indigo-700">{rev.packageBought}</span>
                                </div>
                            </div>
                        ))}
                    </div>
                </section>

                {/* =================================================================
                    9. SECTION: PREGUNTAS FRECUENTES (FAQ) + GARANTÍA 30 DÍAS
                   ================================================================= */}
                <section className="bg-white border-t border-slate-200 py-14 sm:py-20">
                    <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
                        <div className="bg-gradient-to-r from-indigo-50 via-white to-cyan-50 rounded-3xl border-2 border-indigo-200 p-6 sm:p-8 flex flex-col sm:flex-row items-center gap-6 shadow-sm">
                            <div className="h-20 w-20 rounded-3xl bg-[#1E1446] text-amber-300 flex items-center justify-center text-4xl shrink-0 shadow-md">
                                🛡️
                            </div>
                            <div className="space-y-1.5 text-center sm:text-left">
                                <span className="text-xs font-black uppercase tracking-wider text-indigo-700">
                                    COMPRA SIN RIESGO • GARANTÍA AVIPET BIOLAB®
                                </span>
                                <h3 className="text-xl font-black text-slate-900">
                                    Pagas al recibir en casa + Guía Clínica PDF de 6 Páginas GRATIS
                                </h3>
                                <p className="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                    No adelantas ni un solo peso hoy. Recibes tu paquete sellado en la puerta de tu casa y descargas de inmediato nuestro Manual Clínico de Nutrición Hipoalergénica.
                                </p>
                            </div>
                        </div>

                        <div className="space-y-4">
                            <h2 className="text-2xl sm:text-3xl font-black text-center text-[#1E1446]">
                                Preguntas Frecuentes antes de Pedir
                            </h2>
                            <div className="space-y-3">
                                {FAQS.map((faq, idx) => {
                                    const isOpen = openFaqIndex === idx;
                                    return (
                                        <div
                                            key={idx}
                                            className="rounded-2xl border border-slate-200 bg-slate-50 overflow-hidden"
                                        >
                                            <button
                                                type="button"
                                                onClick={() => setOpenFaqIndex(isOpen ? null : idx)}
                                                className="w-full px-5 py-4 text-left flex items-center justify-between gap-4 font-black text-sm sm:text-base text-slate-900 cursor-pointer hover:bg-slate-100/80 transition"
                                            >
                                                <span>{faq.q}</span>
                                                <span className="text-indigo-600 text-xl font-black shrink-0">
                                                    {isOpen ? '−' : '+'}
                                                </span>
                                            </button>
                                            {isOpen && (
                                                <div className="px-5 pb-4 text-xs sm:text-sm text-slate-600 whitespace-pre-line leading-relaxed border-t border-slate-200/60 pt-3 bg-white">
                                                    {faq.a}
                                                </div>
                                            )}
                                        </div>
                                    );
                                })}
                            </div>
                        </div>

                        <div className="text-center pt-4">
                            <button
                                type="button"
                                onClick={() => openCodModal()}
                                className="w-full sm:w-auto px-10 py-4 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-black text-base shadow-xl transition cursor-pointer"
                            >
                                🚚 PEDIR AHORA CON PAGO CONTRAENTREGA ({formatCOP(selectedPkg.price)}) →
                            </button>
                        </div>
                    </div>
                </section>

                {/* =================================================================
                    10. LIVE PURCHASE SIMULATOR TOAST (FOMO SOCIAL PROOF POPUP)
                   ================================================================= */}
                {showSaleToast && !dismissedToast && !isCodModalOpen && (
                    <div className="fixed bottom-20 lg:bottom-5 left-3 sm:left-5 z-40 max-w-xs sm:max-w-sm bg-white rounded-2xl border-2 border-emerald-500/80 shadow-2xl p-3 flex items-center gap-3 animate-bounce">
                        <img
                            src={currentSale.img}
                            alt={currentSale.buyer}
                            className="h-14 w-14 rounded-xl object-cover border border-slate-200 shrink-0"
                        />
                        <div className="text-xs leading-snug pr-4">
                            <div className="flex items-center gap-1 text-[10px] font-black text-emerald-700 uppercase">
                                <span className="h-2 w-2 rounded-full bg-emerald-500" />
                                <span>Pedido Contraentrega Reciente</span>
                            </div>
                            <p className="font-extrabold text-slate-900 mt-0.5">
                                {currentSale.buyer} en <span className="text-indigo-700">{currentSale.location}</span>
                            </p>
                            <p className="text-[11px] text-slate-600 font-semibold">
                                Pidió <strong>{currentSale.pkg}</strong> ({currentSale.pet})
                            </p>
                            <span className="text-[10px] font-bold text-slate-400 block mt-0.5">
                                ⏱ {currentSale.timeAgo} • Envío Gratis Activado
                            </span>
                        </div>
                        <button
                            type="button"
                            onClick={() => setDismissedToast(true)}
                            className="absolute top-1.5 right-2 text-slate-400 hover:text-slate-700 text-xs font-black cursor-pointer"
                            aria-label="Cerrar notificación"
                        >
                            ✕
                        </button>
                    </div>
                )}

                {/* =================================================================
                    11. STICKY MOBILE CONVERSION BAR
                   ================================================================= */}
                <div className="fixed bottom-0 left-0 right-0 z-40 lg:hidden bg-white/95 backdrop-blur-md border-t-2 border-slate-200 px-4 py-3 shadow-2xl">
                    <div className="max-w-md mx-auto flex items-center justify-between gap-3">
                        <div>
                            <span className="text-[10px] font-extrabold uppercase text-emerald-700 block">
                                🚚 Envío Gratis • Pagas al Recibir
                            </span>
                            <div className="flex items-baseline gap-1.5">
                                <span className="text-lg font-black text-slate-900">{formatCOP(selectedPkg.price)}</span>
                                <span className="text-xs text-slate-400 line-through font-bold">
                                    {formatCOP(selectedPkg.compareAt)}
                                </span>
                            </div>
                        </div>
                        <button
                            type="button"
                            onClick={() => openCodModal()}
                            className="bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs sm:text-sm px-5 py-3 rounded-xl shadow-lg cursor-pointer shrink-0"
                        >
                            🚚 Pedir Contraentrega →
                        </button>
                    </div>
                </div>

                {/* =================================================================
                    12. SHOPIFY RELEASIT-STYLE 1-STEP COD POPUP MODAL
                   ================================================================= */}
                {isCodModalOpen && (
                    <div className="fixed inset-0 z-50 flex items-center justify-center p-2 sm:p-4 bg-slate-950/75 backdrop-blur-sm overflow-y-auto">
                        <div className="relative w-full max-w-lg bg-white rounded-3xl border-2 border-emerald-600 shadow-2xl overflow-hidden my-auto max-h-[94vh] flex flex-col">
                            {/* Sticky Popup Header */}
                            <div className="bg-gradient-to-r from-[#1E1446] via-[#2D1B69] to-emerald-800 text-white px-5 py-3.5 flex items-center justify-between gap-2 shrink-0">
                                <div>
                                    <span className="text-[10px] font-black uppercase tracking-wider text-amber-300 block">
                                        🇨🇴 ENVÍO GRATIS + PAGO CONTRAENTREGA EN CASA
                                    </span>
                                    <h3 className="text-sm sm:text-base font-black">
                                        Completa tus datos de entrega (Sin tarjeta)
                                    </h3>
                                </div>
                                <button
                                    type="button"
                                    onClick={() => setIsCodModalOpen(false)}
                                    className="h-8 w-8 rounded-full bg-white/15 hover:bg-white/25 text-white font-black flex items-center justify-center cursor-pointer"
                                >
                                    ✕
                                </button>
                            </div>

                            {/* Scrollable Modal Body */}
                            <div className="p-4 sm:p-5 overflow-y-auto space-y-4">
                                {orderSuccess ? (
                                    /* CONFIRMATION + INSTANT PDF DOWNLOAD + 1-CLICK WHATSAPP OTO */
                                    <div className="space-y-4">
                                        <div className="bg-emerald-50 border-2 border-emerald-500 rounded-2xl p-4 text-center space-y-2">
                                            <div className="mx-auto h-12 w-12 rounded-full bg-emerald-600 text-white flex items-center justify-center text-2xl font-black">
                                                ✓
                                            </div>
                                            <span className="inline-block bg-emerald-200 text-emerald-950 text-xs font-black px-3 py-0.5 rounded-full">
                                                ORDEN CONFIRMADA #{orderSuccess.order_code}
                                            </span>
                                            <h4 className="text-lg font-black text-slate-900">
                                                ¡Gracias {customerName}! Tu paquete está en alistamiento
                                            </h4>
                                            <p className="text-xs text-slate-600">
                                                Elegiste: <strong>{orderSuccess.bundle_title}</strong> • Pagas{' '}
                                                <strong className="text-emerald-700">{orderSuccess.formatted_price}</strong> al recibir en {city} ({department}).
                                            </p>
                                        </div>

                                        {/* INSTANT 1-CLICK PDF GUIDE DOWNLOAD */}
                                        <div className="bg-indigo-950 text-white rounded-2xl p-4 border-2 border-amber-400 space-y-2.5 shadow-md">
                                            <div className="flex items-center justify-between">
                                                <span className="bg-amber-400 text-slate-950 text-[10px] font-black px-2.5 py-0.5 rounded-full">
                                                    🎁 TU BONO VIP ESTÁ LISTO ($29.900 → GRATIS)
                                                </span>
                                                <span className="text-[11px] text-cyan-300 font-bold">PDF • 6 Páginas</span>
                                            </div>
                                            <h5 className="text-sm font-black">
                                                Guía de Nutrición Clínica Hipoalergénica y Protocolo 30 Días
                                            </h5>
                                            <a
                                                href={orderSuccess.guide_pdf_url}
                                                target="_blank"
                                                rel="noreferrer"
                                                download="Guia-Nutricion-Clinica-Hipoalergenica-AVIPET-BioLab.pdf"
                                                className="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-amber-400 to-yellow-300 hover:from-amber-300 hover:to-yellow-200 text-slate-950 font-black text-xs sm:text-sm flex items-center justify-center gap-2 shadow transition"
                                            >
                                                <span>📥 DESCARGAR AHORA MI GUÍA CLÍNICA EN PDF →</span>
                                            </a>
                                        </div>

                                        {/* 1-CLICK WHATSAPP CONFIRMATION / OTO UPSELL */}
                                        {selectedPkgId === '1_bolsa' ? (
                                            <div className="bg-amber-50 border-2 border-amber-400 rounded-2xl p-4 space-y-2.5">
                                                <span className="bg-rose-600 text-white text-[10px] font-black px-2.5 py-0.5 rounded-full">
                                                    🔥 OFERTA ÚNICA PARA TU ORDEN #{orderSuccess.order_code}
                                                </span>
                                                <h5 className="text-sm font-black text-slate-900">
                                                    ¿Quieres agregar una 2.ª bolsa en el mismo envío gratis por solo $55.000 adicionales?
                                                </h5>
                                                <a
                                                    href={`https://wa.me/573235813942?text=${encodeURIComponent(
                                                        `Hola AVIPET BioLab! Acabo de registrar mi orden #${orderSuccess.order_code} y quiero actualizarla al PACK DÚO (2 Bolsas por $124.900 contraentrega) + recibir mi Guía PDF en WhatsApp.`
                                                    )}`}
                                                    target="_blank"
                                                    rel="noreferrer"
                                                    className="w-full py-3 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs sm:text-sm flex items-center justify-center gap-2 shadow transition"
                                                >
                                                    <span>📲 SÍ, ACTUALIZAR A 2 BOLSAS POR WHATSAPP →</span>
                                                </a>
                                            </div>
                                        ) : (
                                            <a
                                                href={orderSuccess.whatsapp_url}
                                                target="_blank"
                                                rel="noreferrer"
                                                className="w-full py-3.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs sm:text-sm flex items-center justify-center gap-2 shadow transition"
                                            >
                                                <span>📲 RECIBIR GUÍA DE DESPACHO EN MI WHATSAPP →</span>
                                            </a>
                                        )}
                                    </div>
                                ) : (
                                    <form onSubmit={handleOrderSubmit} className="space-y-3.5">
                                        {/* Quick Bundle Switcher inside Modal (Releasit Style) */}
                                        <div className="bg-slate-50 rounded-2xl p-3 border border-slate-200 space-y-2">
                                            <div className="flex items-center justify-between text-xs font-extrabold text-slate-700">
                                                <span>📦 Paquete seleccionado:</span>
                                                <span className="text-emerald-700">Envío Gratis Incluido</span>
                                            </div>
                                            <div className="grid grid-cols-3 gap-1.5">
                                                {packages.map((p) => (
                                                    <button
                                                        key={p.id}
                                                        type="button"
                                                        onClick={() => setSelectedPkgId(p.id)}
                                                        className={`py-2 px-2 rounded-xl border-2 text-center transition cursor-pointer ${
                                                            selectedPkgId === p.id
                                                                ? 'border-indigo-600 bg-indigo-600 text-white font-black'
                                                                : 'border-slate-200 bg-white text-slate-700 font-bold'
                                                        }`}
                                                    >
                                                        <span className="block text-[11px]">
                                                            {p.bags === 1 ? '1 Bolsa' : p.bags === 2 ? '🔥 2 Bolsas' : '🏆 3 Bolsas'}
                                                        </span>
                                                        <span className="block text-xs">{formatCOP(p.price)}</span>
                                                    </button>
                                                ))}
                                            </div>
                                        </div>

                                        {formError && (
                                            <div className="bg-rose-50 border-2 border-rose-300 text-rose-800 text-xs font-bold p-3 rounded-xl">
                                                ⚠️ {formError}
                                            </div>
                                        )}

                                        {/* Nombre Completo */}
                                        <div>
                                            <label className="block text-xs font-extrabold text-slate-700 mb-1">
                                                👤 Nombre y Apellido *
                                            </label>
                                            <input
                                                type="text"
                                                required
                                                value={customerName}
                                                onChange={(e) => setCustomerName(e.target.value)}
                                                placeholder="Ej: Carolina Martínez"
                                                className="w-full rounded-xl border-2 border-slate-300 focus:border-emerald-600 px-3.5 py-2.5 text-sm font-semibold text-slate-900"
                                            />
                                        </div>

                                        {/* WhatsApp + Tipo de Mascota */}
                                        <div className="grid grid-cols-1 sm:grid-cols-12 gap-2.5">
                                            <div className="sm:col-span-7">
                                                <label className="block text-xs font-extrabold text-slate-700 mb-1">
                                                    📱 WhatsApp / Celular *
                                                </label>
                                                <input
                                                    type="tel"
                                                    required
                                                    value={customerPhone}
                                                    onChange={(e) => setCustomerPhone(e.target.value)}
                                                    placeholder="Ej: 300 123 4567"
                                                    className="w-full rounded-xl border-2 border-slate-300 focus:border-emerald-600 px-3.5 py-2.5 text-sm font-semibold text-slate-900"
                                                />
                                            </div>
                                            <div className="sm:col-span-5">
                                                <label className="block text-xs font-extrabold text-slate-700 mb-1">
                                                    🐾 Tu Mascota:
                                                </label>
                                                <select
                                                    value={petType}
                                                    onChange={(e) => setPetType(e.target.value as any)}
                                                    className="w-full rounded-xl border-2 border-slate-300 focus:border-emerald-600 px-3 py-2.5 text-sm font-bold text-slate-900 bg-white"
                                                >
                                                    <option value="Perro">🐕 Perro</option>
                                                    <option value="Gato">🐈 Gato</option>
                                                    <option value="Ambos">🐾 Perro y Gato</option>
                                                </select>
                                            </div>
                                        </div>

                                        {/* Departamento + Ciudad */}
                                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                            <div>
                                                <label className="block text-xs font-extrabold text-slate-700 mb-1">
                                                    📍 Departamento *
                                                </label>
                                                <select
                                                    required
                                                    value={department}
                                                    onChange={(e) => setDepartment(e.target.value)}
                                                    className="w-full rounded-xl border-2 border-slate-300 focus:border-emerald-600 px-3 py-2.5 text-sm font-semibold text-slate-900 bg-white"
                                                >
                                                    <option value="">Selecciona...</option>
                                                    {COLOMBIA_DEPARTMENTS.map((dep) => (
                                                        <option key={dep} value={dep}>
                                                            {dep}
                                                        </option>
                                                    ))}
                                                </select>
                                            </div>
                                            <div>
                                                <label className="block text-xs font-extrabold text-slate-700 mb-1">
                                                    🏙️ Ciudad o Municipio *
                                                </label>
                                                <input
                                                    type="text"
                                                    required
                                                    value={city}
                                                    onChange={(e) => setCity(e.target.value)}
                                                    placeholder="Ej: Medellín / Bogotá"
                                                    className="w-full rounded-xl border-2 border-slate-300 focus:border-emerald-600 px-3.5 py-2.5 text-sm font-semibold text-slate-900"
                                                />
                                            </div>
                                        </div>

                                        {/* Dirección + Barrio */}
                                        <div className="grid grid-cols-1 sm:grid-cols-12 gap-2.5">
                                            <div className="sm:col-span-7">
                                                <label className="block text-xs font-extrabold text-slate-700 mb-1">
                                                    🏠 Dirección Exacta *
                                                </label>
                                                <input
                                                    type="text"
                                                    required
                                                    value={address}
                                                    onChange={(e) => setAddress(e.target.value)}
                                                    placeholder="Ej: Calle 45 # 12-34 Apto 502"
                                                    className="w-full rounded-xl border-2 border-slate-300 focus:border-emerald-600 px-3.5 py-2.5 text-sm font-semibold text-slate-900"
                                                />
                                            </div>
                                            <div className="sm:col-span-5">
                                                <label className="block text-xs font-extrabold text-slate-700 mb-1">
                                                    🏘️ Barrio / Conjunto
                                                </label>
                                                <input
                                                    type="text"
                                                    value={neighborhood}
                                                    onChange={(e) => setNeighborhood(e.target.value)}
                                                    placeholder="Ej: El Poblado / Cedritos"
                                                    className="w-full rounded-xl border-2 border-slate-300 focus:border-emerald-600 px-3.5 py-2.5 text-sm font-semibold text-slate-900"
                                                />
                                            </div>
                                        </div>

                                        {/* Order Summary Receipt inside Modal */}
                                        <div className="bg-emerald-50/70 rounded-2xl border border-emerald-200 p-3.5 space-y-1.5 text-xs">
                                            <div className="flex justify-between font-bold text-slate-700">
                                                <span>{selectedPkg.name}</span>
                                                <span>{formatCOP(selectedPkg.price)}</span>
                                            </div>
                                            <div className="flex justify-between text-emerald-700 font-bold">
                                                <span>🎁 Bono Guía Clínica PDF (6 Páginas) + Prioridad</span>
                                                <span>GRATIS ($0)</span>
                                            </div>
                                            <div className="flex justify-between text-emerald-700 font-bold">
                                                <span>🚚 Envío Asegurado a Domicilio</span>
                                                <span>GRATIS ($0)</span>
                                            </div>
                                            <div className="border-t border-emerald-200 pt-1.5 flex justify-between text-sm sm:text-base font-black text-slate-900">
                                                <span>Total a Pagar en Casa al Recibir:</span>
                                                <span className="text-emerald-700">{formatCOP(selectedPkg.price)} COP</span>
                                            </div>
                                        </div>

                                        <button
                                            type="submit"
                                            disabled={isSubmitting}
                                            className="w-full py-4 px-5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-black text-sm sm:text-base shadow-xl border-b-4 border-emerald-800 cursor-pointer disabled:opacity-60"
                                        >
                                            {isSubmitting
                                                ? '⏳ REGISTRANDO TU PEDIDO...'
                                                : `✅ CONFIRMAR PEDIDO CONTRAENTREGA (${formatCOP(selectedPkg.price)})`}
                                        </button>
                                    </form>
                                )}
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </>
    );
}
