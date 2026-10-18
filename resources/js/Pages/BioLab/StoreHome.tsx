import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import {
    Truck,
    ShieldCheck,
    Sparkles,
    Star,
    ArrowRight,
    ShoppingBag,
    MessageCircle,
    Microscope,
    FlaskConical,
    CheckCircle2,
    Bone,
    Brain,
    Droplets,
    Stethoscope,
} from 'lucide-react';

interface StoreHomeProps {
    whatsappNumber?: string;
    isSubdomain?: boolean;
}

type CategoryFilter = 'todos' | 'dermo_gut' | 'articulaciones' | 'calma' | 'renal';
type SymptomId = 'picazon' | 'pelo' | 'digestion' | 'articulaciones';

export default function StoreHome({
    whatsappNumber = '573235813942',
    isSubdomain = true,
}: StoreHomeProps) {
    const [activeCategory, setActiveCategory] = useState<CategoryFilter>('todos');
    const [activeSymptom, setActiveSymptom] = useState<SymptomId>('picazon');

    const productUrl = isSubdomain ? '/dermo-gut-superboost' : '/biolab/dermo-gut-superboost';
    const storeUrl = isSubdomain ? '/' : '/biolab';

    const whatsappStoreUrl = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(
        'Hola *AVIPET BioLab®* 🔬🐾 Quiero recibir asesoría sobre su catálogo de suplementos biotecnológicos con Envío Gratis y Pago Contraentrega.'
    )}`;

    const symptomGuide: Record<
        SymptomId,
        {
            buttonLabel: string;
            diagnosisTitle: string;
            diagnosisText: string;
            recommendedProduct: string;
            activeIngredients: string;
            available: boolean;
            priceText: string;
        }
    > = {
        picazon: {
            buttonLabel: '🐾 Se rasca, tiene piel roja o se lame las patas',
            diagnosisTitle: 'Dermatitis Alérgica y Sobrecrecimiento de Malassezia',
            diagnosisText:
                'El lamido de patas (manchas cafés/rojizas) y el rascado constante suelen ser disparados por alergia a la proteína de pollo/res y proliferación de hongos cutáneos.',
            recommendedProduct: 'AVIPET BioLab® — DERMO & GUT SUPERBOOST (250g)',
            activeIngredients: 'Micro-Proteína Novel (Hermetia illucens 40%) + Ácido Láurico Antihongos (4.5%) + Cúrcuma',
            available: true,
            priceText: '$69.900 COP • Envío Gratis + Pago Contraentrega',
        },
        pelo: {
            buttonLabel: '✨ Caída excesiva de pelo o pelaje opaco',
            diagnosisTitle: 'Debilidad Folicular y Deficiencia de Ácidos Grasos Bio-Estables',
            diagnosisText:
                'Los aceites líquidos en tarro se oxidan al abrirlos. Tu mascota necesita ácidos grasos protegidos junto con aminoácidos esenciales y Biotina natural.',
            recommendedProduct: 'AVIPET BioLab® — DERMO & GUT SUPERBOOST (250g)',
            activeIngredients: 'Semilla de Linaza Dorada (Omega 3, 6 y 9) + Biotina de Saccharomyces cerevisiae',
            available: true,
            priceText: '$69.900 COP • Envío Gratis + Pago Contraentrega',
        },
        digestion: {
            buttonLabel: '🦠 Heces blandas, gases o mal aliento',
            diagnosisTitle: 'Disbiosis Intestinal y Toxinas Estomacales',
            diagnosisText:
                'La salud de la piel y del sistema inmune nace en el intestino. Restaurar la microbiota compacta las heces y elimina el mal aliento desde la primera semana.',
            recommendedProduct: 'AVIPET BioLab® — DERMO & GUT SUPERBOOST (250g)',
            activeIngredients: 'Fibra Soluble de Ahuyama + MOS y Betaglucanos + Clorofila Activa de Perejil',
            available: true,
            priceText: '$69.900 COP • Envío Gratis + Pago Contraentrega',
        },
        articulaciones: {
            buttonLabel: '🦴 Dificultad al levantarse o desgaste articular',
            diagnosisTitle: 'Soporte Condroprotector y Antiinflamatorio Celular',
            diagnosisText:
                'Mientras lanzamos nuestra línea Arthro & Mobility Pro, la curcumina bioactiva y los ácidos grasos Omega 3 de Dermo & Gut Superboost aportan soporte antiinflamatorio natural.',
            recommendedProduct: 'AVIPET BioLab® — ARTHRO & MOBILITY PRO (En Desarrollo)',
            activeIngredients: 'Péptidos Bioactivos + Curcumina + Omega 3-6-9',
            available: false,
            priceText: 'Lanzamiento Próximamente • Reserva en Lista VIP',
        },
    };

    const upcomingProducts = [
        {
            id: 'arthro',
            category: 'articulaciones' as CategoryFilter,
            badge: 'PRÓXIMAMENTE EN LABORATORIO',
            title: 'AVIPET BioLab® — ARTHRO & MOBILITY PRO',
            subtitle: 'Condroprotector Biotecnológico con Péptidos de Colágeno, Cúrcuma y Omega 3',
            description:
                'Soporte articular avanzado para displasia, artrosis, perros senior y razas predispuestas a desgaste osteoarticular.',
            icon: Bone,
            accent: 'text-amber-700 bg-amber-50 border-amber-200',
            presentation: 'Doypack Zipper • 250g',
        },
        {
            id: 'calm',
            category: 'calma' as CategoryFilter,
            badge: 'PRÓXIMAMENTE EN LABORATORIO',
            title: 'AVIPET BioLab® — CALM & NEURO BALANCE',
            subtitle: 'Fórmula Neuro-Botánica con L-Triptófano, Manzanilla, Valeriana y Magnesio',
            description:
                'Equilibrio del sistema nervioso para mascotas con ansiedad por separación, miedo a pólvora/tormentas o estrés en viajes.',
            icon: Brain,
            accent: 'text-[#311457] bg-purple-50 border-purple-200',
            presentation: 'Doypack Zipper • 250g',
        },
        {
            id: 'renal',
            category: 'renal' as CategoryFilter,
            badge: 'PRÓXIMAMENTE EN LABORATORIO',
            title: 'AVIPET BioLab® — RENAL & URINARY SHIELD',
            subtitle: 'Complejo Nefroprotector con Arándano Rojo, Quitosano y Prebióticos',
            description:
                'Cuidado especializado del tracto urinario y función renal en gatos y perros con tendencia a cristales o cistitis.',
            icon: Droplets,
            accent: 'text-[#0E8A9E] bg-cyan-50 border-cyan-200',
            presentation: 'Doypack Zipper • 250g',
        },
    ];

    const filteredUpcoming =
        activeCategory === 'todos'
            ? upcomingProducts
            : upcomingProducts.filter((p) => p.category === activeCategory);

    const showDermoGut = activeCategory === 'todos' || activeCategory === 'dermo_gut';
    const currentSymptom = symptomGuide[activeSymptom];

    return (
        <>
            <Head>
                <title>
                    AVIPET BioLab® | Tienda Oficial de Nutrición Clínica y Biotecnología Veterinaria en Colombia
                </title>
                <meta
                    name="description"
                    content="Tienda oficial de AVIPET BioLab®. Suplementos nutricionales biotecnológicos 100% hipoalergénicos para perros y gatos. Descubre Dermo & Gut Superboost con Envío Gratis y Pago Contraentrega en toda Colombia."
                />
            </Head>

            <div className="min-h-screen bg-[#FAF8FF] text-[#1E1035] font-sans selection:bg-[#311457] selection:text-white">
                {/* 0. BARRA SUPERIOR DE ANUNCIO */}
                <div className="bg-gradient-to-r from-[#240B46] via-[#311457] to-[#134E5E] text-white text-xs sm:text-sm py-2.5 px-4 shadow-sm">
                    <div className="max-w-7xl mx-auto flex flex-wrap items-center justify-center sm:justify-between gap-2 text-center">
                        <span className="font-extrabold text-[#FDE68A]">
                            🇨🇴 TIENDA OFICIAL AVIPET BIOLAB® • ENVÍO GRATIS + PAGO CONTRAENTREGA EN TODA COLOMBIA
                        </span>
                        <span className="hidden md:inline text-xs font-semibold text-white/90">
                            Biotecnología Clínica Veterinaria • 0% Pollo • 0% Res • 0% Gluten
                        </span>
                    </div>
                </div>

                {/* 1. NAVBAR CLÍNICA LUMINOSA */}
                <header className="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-purple-100 shadow-sm">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between gap-4">
                        <a href={storeUrl} className="flex items-center gap-3">
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
                                    <span className="hidden sm:inline-block ml-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-purple-100 text-[#311457]">
                                        Tienda Oficial
                                    </span>
                                </div>
                                <span className="text-[11px] text-slate-500 font-semibold -mt-0.5">
                                    Nutrición Clínica Dermo-Digestiva &amp; Funcional
                                </span>
                            </div>
                        </a>

                        <nav className="hidden lg:flex items-center gap-6 text-sm font-bold text-[#311457]/80">
                            <a href="#diagnostico-sintomas" className="hover:text-[#311457] transition">
                                Diagnóstico por Síntoma
                            </a>
                            <a href="#catalogo" className="hover:text-[#311457] transition">
                                Catálogo Oficial
                            </a>
                            <a href={productUrl} className="text-[#0E8A9E] font-black hover:underline">
                                🔥 Dermo &amp; Gut Superboost
                            </a>
                            <a href="#garantia-colombia" className="hover:text-[#311457] transition">
                                Pago Contraentrega
                            </a>
                        </nav>

                        <div className="flex items-center gap-2.5">
                            <a
                                href={whatsappStoreUrl}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border-2 border-emerald-600/20 bg-emerald-50 text-emerald-800 hover:bg-emerald-100 text-xs sm:text-sm font-extrabold transition"
                            >
                                <MessageCircle className="w-4 h-4 text-emerald-600" />
                                Asesoría WhatsApp
                            </a>
                            <a
                                href={productUrl}
                                className="inline-flex items-center gap-2 px-4 sm:px-5 py-2.5 rounded-xl bg-[#059669] hover:bg-[#047857] text-white text-xs sm:text-sm font-black shadow-md shadow-emerald-600/25 transition"
                            >
                                <ShoppingBag className="w-4 h-4" />
                                <span>Ver Dermo &amp; Gut</span>
                            </a>
                        </div>
                    </div>
                </header>

                {/* 2. HERO PRINCIPAL DE LA TIENDA GENERAL */}
                <section className="bg-gradient-to-b from-white via-[#FAF8FF] to-[#F3EFFB] py-10 lg:py-16 border-b border-purple-100">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                            <div className="lg:col-span-6 space-y-5">
                                <div className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#311457] text-[#FDE68A] text-xs font-black uppercase tracking-wider">
                                    <FlaskConical className="w-4 h-4" />
                                    <span>LABORATORIO DE BIOTECNOLOGÍA NUTRICIONAL VETERINARIA</span>
                                </div>

                                <h1 className="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-[#311457] leading-[1.1]">
                                    Nutrición clínica de raíz para la salud de tu{' '}
                                    <span className="text-[#0E8A9E]">perro y gato.</span>
                                </h1>

                                <p className="text-base sm:text-lg text-slate-600 leading-relaxed">
                                    En <strong className="text-[#311457]">AVIPET BioLab®</strong> formulamos suplementos
                                    biotecnológicos en polvo con{' '}
                                    <strong className="text-[#0E8A9E]">Micro-Proteína Novel hipoalergénica</strong>,
                                    Ácido Láurico natural, Omegas 3-6-9 y prebióticos clínicos. 100% libres de pollo,
                                    res, soya y gluten.
                                </p>

                                <div className="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-1">
                                    <a
                                        href={productUrl}
                                        className="inline-flex items-center justify-center gap-2.5 px-7 py-4 rounded-2xl bg-[#059669] hover:bg-[#047857] text-white font-black text-base shadow-xl shadow-emerald-600/25 border-b-4 border-[#047857] transition"
                                    >
                                        <ShoppingBag className="w-5 h-5" />
                                        <span>Pedir Dermo &amp; Gut Superboost</span>
                                        <ArrowRight className="w-5 h-5" />
                                    </a>
                                    <a
                                        href="#catalogo"
                                        className="inline-flex items-center justify-center gap-2 px-6 py-4 rounded-2xl bg-white hover:bg-purple-50 border-2 border-[#311457]/20 text-[#311457] font-extrabold text-sm sm:text-base transition"
                                    >
                                        <span>Ver Catálogo BioLab®</span>
                                    </a>
                                </div>

                                <div className="grid grid-cols-3 gap-4 pt-4 border-t border-purple-200/70">
                                    <div>
                                        <p className="text-lg sm:text-2xl font-black text-[#311457]">0% Pollo</p>
                                        <p className="text-xs text-slate-600 font-medium">Sin Res, Soya ni Gluten</p>
                                    </div>
                                    <div>
                                        <p className="text-lg sm:text-2xl font-black text-amber-500">⭐⭐⭐⭐⭐ 4.9</p>
                                        <p className="text-xs text-slate-600 font-medium">Tutores y Veterinarios</p>
                                    </div>
                                    <div>
                                        <p className="text-lg sm:text-2xl font-black text-[#059669]">Envío Gratis</p>
                                        <p className="text-xs text-slate-600 font-medium">Contraentrega Colombia</p>
                                    </div>
                                </div>
                            </div>

                            <div className="lg:col-span-6">
                                <a
                                    href={productUrl}
                                    className="block group rounded-3xl overflow-hidden border-2 border-purple-200 shadow-2xl bg-white"
                                >
                                    <img
                                        src="/images/biolab/banner-panoramico.jpg"
                                        alt="AVIPET BioLab® — Dermo & Gut Superboost"
                                        className="w-full h-auto object-cover group-hover:scale-[1.02] transition-transform duration-500"
                                    />
                                    <div className="p-4 sm:p-5 bg-[#311457] text-white flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                        <div>
                                            <span className="text-[11px] font-black uppercase tracking-wider text-[#FDE68A]">
                                                ● DISPONIBLE EN STOCK • ENVÍO GRATIS HOY
                                            </span>
                                            <p className="text-base sm:text-lg font-black text-white">
                                                DERMO &amp; GUT SUPERBOOST (250g) — $69.900 COP
                                            </p>
                                        </div>
                                        <span className="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 rounded-xl bg-[#059669] text-white text-xs sm:text-sm font-black shrink-0 group-hover:bg-[#047857] transition">
                                            Ver Producto
                                            <ArrowRight className="w-4 h-4" />
                                        </span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                {/* 2.5 SELECTOR CLÍNICO POR SÍNTOMA */}
                <section id="diagnostico-sintomas" className="py-12 lg:py-16 bg-white border-b border-purple-100">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center max-w-3xl mx-auto mb-8">
                            <span className="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-[#0E8A9E]/15 text-[#0E8A9E] text-xs font-black uppercase tracking-wider">
                                <Stethoscope className="w-4 h-4" />
                                Diagnóstico Rápido por Síntoma
                            </span>
                            <h2 className="mt-2 text-2xl sm:text-3xl font-black text-[#311457]">
                                ¿Qué síntoma presenta tu perro o gato hoy?
                            </h2>
                        </div>

                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
                            {(Object.keys(symptomGuide) as SymptomId[]).map((key) => {
                                const isSelected = activeSymptom === key;
                                return (
                                    <button
                                        key={key}
                                        type="button"
                                        onClick={() => setActiveSymptom(key)}
                                        className={`p-4 rounded-2xl border-2 text-left font-bold text-xs sm:text-sm transition cursor-pointer ${
                                            isSelected
                                                ? 'bg-[#311457] text-white border-[#311457] shadow-md'
                                                : 'bg-[#FAF8FF] text-[#311457] border-purple-100 hover:border-purple-300'
                                        }`}
                                    >
                                        {symptomGuide[key].buttonLabel}
                                    </button>
                                );
                            })}
                        </div>

                        <div className="rounded-3xl bg-[#FAF8FF] border-2 border-purple-200 p-6 sm:p-8 shadow-md">
                            <div className="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                                <div className="lg:col-span-8 space-y-2">
                                    <span className="inline-block px-3 py-0.5 rounded-full bg-[#311457] text-[#FDE68A] text-xs font-black">
                                        Recomendación Clínica AVIPET BioLab®
                                    </span>
                                    <h3 className="text-xl sm:text-2xl font-black text-[#311457]">
                                        {currentSymptom.diagnosisTitle}
                                    </h3>
                                    <p className="text-sm sm:text-base text-slate-600 leading-relaxed">
                                        {currentSymptom.diagnosisText}
                                    </p>
                                    <p className="text-xs sm:text-sm text-[#0E8A9E] font-extrabold pt-1">
                                        🧬 Bio-Activos Clave: {currentSymptom.activeIngredients}
                                    </p>
                                </div>
                                <div className="lg:col-span-4 flex flex-col items-stretch sm:items-end justify-center gap-2 border-t lg:border-t-0 lg:border-l border-purple-200 pt-4 lg:pt-0 lg:pl-6">
                                    <p className="text-sm sm:text-base font-black text-[#311457] sm:text-right">
                                        {currentSymptom.recommendedProduct}
                                    </p>
                                    <p className="text-xs font-bold text-emerald-700 sm:text-right">
                                        {currentSymptom.priceText}
                                    </p>
                                    {currentSymptom.available ? (
                                        <a
                                            href={productUrl}
                                            className="mt-2 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-[#059669] hover:bg-[#047857] text-white font-black text-xs sm:text-sm shadow-md transition"
                                        >
                                            <span>Ver Producto y Pedir en Casa</span>
                                            <ArrowRight className="w-4 h-4" />
                                        </a>
                                    ) : (
                                        <a
                                            href={whatsappStoreUrl}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            className="mt-2 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-[#311457] text-white font-bold text-xs sm:text-sm transition"
                                        >
                                            <MessageCircle className="w-4 h-4 text-emerald-400" />
                                            <span>Notificarme por WhatsApp</span>
                                        </a>
                                    )}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* 3. CATÁLOGO GENERAL DE LA TIENDA */}
                <section id="catalogo" className="py-16 lg:py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                        <div>
                            <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-purple-100 text-[#311457] text-xs font-black uppercase tracking-wider">
                                Catálogo Oficial AVIPET BioLab®
                            </span>
                            <h2 className="mt-2 text-2xl sm:text-4xl font-black text-[#311457]">
                                Nuestras Fórmulas Biotecnológicas
                            </h2>
                        </div>

                        <div className="flex flex-wrap gap-2">
                            {[
                                { id: 'todos', label: 'Todos los Productos' },
                                { id: 'dermo_gut', label: '🛡️ Piel, Picazón y Digestión' },
                                { id: 'articulaciones', label: '🦴 Articulaciones (Próximamente)' },
                                { id: 'calma', label: '🧠 Calma y Estrés (Próximamente)' },
                            ].map((tab) => (
                                <button
                                    key={tab.id}
                                    type="button"
                                    onClick={() => setActiveCategory(tab.id as CategoryFilter)}
                                    className={`px-3.5 py-2 rounded-xl text-xs sm:text-sm font-bold transition cursor-pointer ${
                                        activeCategory === tab.id
                                            ? 'bg-[#311457] text-white shadow'
                                            : 'bg-white border border-purple-200 text-slate-600 hover:text-[#311457]'
                                    }`}
                                >
                                    {tab.label}
                                </button>
                            ))}
                        </div>
                    </div>

                    {showDermoGut && (
                        <div className="rounded-3xl bg-white border-2 border-[#311457] shadow-xl overflow-hidden mb-14">
                            <div className="bg-gradient-to-r from-[#311457] to-[#0E8A9E] px-6 py-3 flex flex-wrap items-center justify-between gap-2 text-xs text-white">
                                <span className="inline-flex items-center gap-1.5 font-black text-[#FDE68A]">
                                    <Sparkles className="w-4 h-4" />
                                    PRODUCTO ESTRELLA • DISPONIBLE PARA DESPACHO INMEDIATO
                                </span>
                                <span className="font-bold text-white">
                                    🚚 Envío Gratis + Pago Contraentrega en toda Colombia
                                </span>
                            </div>

                            <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 p-6 sm:p-8 lg:p-10 items-center">
                                <div className="lg:col-span-5">
                                    <a
                                        href={productUrl}
                                        className="block relative rounded-2xl bg-[#FAF8FF] border border-purple-100 p-4 overflow-hidden group"
                                    >
                                        <span className="absolute top-4 left-4 z-10 px-3 py-1 rounded-full bg-rose-600 text-white text-xs font-black shadow">
                                            Ahorras $17.800 COP
                                        </span>
                                        <img
                                            src="/images/biolab/empaque-frente-250g.jpg"
                                            alt="AVIPET BioLab® — Dermo & Gut Superboost (250g)"
                                            className="w-full max-h-96 object-contain mx-auto group-hover:scale-105 transition-transform duration-500"
                                        />
                                    </a>
                                </div>

                                <div className="lg:col-span-7 space-y-5">
                                    <div className="flex flex-wrap items-center gap-2 text-xs">
                                        <span className="px-3 py-1 rounded-full bg-purple-100 text-[#311457] font-black">
                                            PIEL • DIGESTIÓN • ALIENTO (3 EN 1)
                                        </span>
                                        <span className="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 font-black">
                                            PERROS Y GATOS • 250g
                                        </span>
                                    </div>

                                    <div>
                                        <a href={productUrl} className="hover:underline">
                                            <h3 className="text-2xl sm:text-3xl font-black text-[#311457]">
                                                AVIPET BioLab® — DERMO &amp; GUT SUPERBOOST (250g)
                                            </h3>
                                        </a>
                                        <p className="mt-1.5 text-sm sm:text-base text-slate-600">
                                            Suplemento Nutricional Biotecnológico 3 en 1 en Polvo con Micro-Proteína
                                            Novel de <em>Hermetia illucens</em> (40%), Ácido Láurico natural (4.5%),
                                            Omega 3-6-9, Fibra Prebiótica, Cúrcuma y Clorofila activa.
                                        </p>
                                    </div>

                                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs sm:text-sm text-[#311457] font-bold">
                                        <div className="flex items-center gap-2">
                                            <CheckCircle2 className="w-4 h-4 text-[#059669] shrink-0" />
                                            <span>Corta picazón, alergias y caída de pelo</span>
                                        </div>
                                        <div className="flex items-center gap-2">
                                            <CheckCircle2 className="w-4 h-4 text-[#059669] shrink-0" />
                                            <span>Combate hongos (Malassezia) y lamido de patas</span>
                                        </div>
                                        <div className="flex items-center gap-2">
                                            <CheckCircle2 className="w-4 h-4 text-[#059669] shrink-0" />
                                            <span>Compacta las heces y blinda la microbiota</span>
                                        </div>
                                        <div className="flex items-center gap-2">
                                            <CheckCircle2 className="w-4 h-4 text-[#059669] shrink-0" />
                                            <span>0% Pollo • 0% Res • 0% Soya • 0% Gluten</span>
                                        </div>
                                    </div>

                                    <div className="pt-4 border-t border-purple-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                        <div className="tabular-nums">
                                            <span className="text-xs text-slate-400 line-through font-bold block">
                                                Antes: $87.700 COP
                                            </span>
                                            <div className="flex items-baseline gap-2">
                                                <span className="text-2xl sm:text-3xl font-black text-[#311457]">
                                                    $69.900 COP
                                                </span>
                                                <span className="text-xs font-extrabold text-[#059669]">
                                                    • Kits Dúo y 90 Días con descuento
                                                </span>
                                            </div>
                                        </div>

                                        <a
                                            href={productUrl}
                                            className="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-7 py-4 rounded-2xl bg-[#059669] hover:bg-[#047857] text-white font-black text-sm sm:text-base shadow-lg shadow-emerald-600/25 transition"
                                        >
                                            <ShoppingBag className="w-5 h-5" />
                                            <span>Ver Producto y Pedir Contraentrega</span>
                                            <ArrowRight className="w-4 h-4" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    )}

                    {filteredUpcoming.length > 0 && (
                        <div>
                            <h3 className="text-lg sm:text-2xl font-black text-[#311457] mb-5">
                                Próximos Lanzamientos Clínicos en Laboratorio
                            </h3>
                            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                                {filteredUpcoming.map((item) => {
                                    const IconComponent = item.icon;
                                    return (
                                        <div
                                            key={item.id}
                                            className="rounded-2xl bg-white border-2 border-purple-100 p-6 shadow-xs flex flex-col justify-between"
                                        >
                                            <div>
                                                <div className="flex items-center justify-between gap-2 mb-4">
                                                    <div
                                                        className={`w-11 h-11 rounded-xl border flex items-center justify-center ${item.accent}`}
                                                    >
                                                        <IconComponent className="w-5 h-5" />
                                                    </div>
                                                    <span className="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-[10px] font-black uppercase">
                                                        {item.badge}
                                                    </span>
                                                </div>
                                                <h4 className="text-lg font-black text-[#311457]">{item.title}</h4>
                                                <p className="mt-1 text-xs font-bold text-[#0E8A9E]">
                                                    {item.subtitle}
                                                </p>
                                                <p className="mt-3 text-sm text-slate-600 leading-relaxed">
                                                    {item.description}
                                                </p>
                                            </div>
                                            <div className="mt-6 pt-4 border-t border-purple-50 flex items-center justify-between text-xs">
                                                <span className="font-bold text-[#311457]">{item.presentation}</span>
                                                <a
                                                    href={whatsappStoreUrl}
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    className="font-black text-[#0E8A9E] hover:underline"
                                                >
                                                    Notificarme lanzamiento →
                                                </a>
                                            </div>
                                        </div>
                                    );
                                })}
                            </div>
                        </div>
                    )}
                </section>

                {/* FOOTER */}
                <footer id="garantia-colombia" className="bg-[#240B46] text-purple-200 py-10 border-t border-white/10 text-xs sm:text-sm">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-6">
                        <div className="flex items-center gap-3">
                            <img
                                src="/images/biolab/logo-avipet-biolab.jpg"
                                alt="AVIPET BioLab®"
                                className="w-10 h-10 rounded-full object-cover border border-[#FDE68A]"
                            />
                            <div>
                                <p className="text-white font-black">AVIPET BioLab® — Tienda Oficial Colombia</p>
                                <p className="text-xs text-purple-200">
                                    Envíos Gratis y Pago Contraentrega • División de AviPetApp
                                </p>
                            </div>
                        </div>
                        <div className="flex flex-wrap items-center justify-center gap-4 text-xs font-bold">
                            <a href={productUrl} className="text-[#FDE68A] hover:underline">
                                Dermo &amp; Gut Superboost (250g)
                            </a>
                            <span>•</span>
                            <a href="https://avipetapp.com" className="hover:text-white transition">
                                Software Veterinario AviPetApp
                            </a>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}
