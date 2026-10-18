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
    BadgeCheck,
    CheckCircle2,
    Bone,
    Brain,
    Droplets,
    Award,
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
            code: 'LAB-02',
            badge: 'EN FASE CLÍNICA • PRÓXIMAMENTE',
            title: 'AVIPET BioLab® — ARTHRO & MOBILITY PRO',
            subtitle: 'Condroprotector Biotecnológico con Péptidos de Colágeno, Cúrcuma y Omega 3',
            description:
                'Soporte articular avanzado para displasia, artrosis, perros senior y razas predispuestas a desgaste osteoarticular.',
            icon: Bone,
            accent: 'text-amber-400 bg-amber-400/10 border-amber-400/30',
            presentation: 'Doypack Zipper • 250g',
        },
        {
            id: 'calm',
            category: 'calma' as CategoryFilter,
            code: 'LAB-03',
            badge: 'EN FASE CLÍNICA • PRÓXIMAMENTE',
            title: 'AVIPET BioLab® — CALM & NEURO BALANCE',
            subtitle: 'Fórmula Neuro-Botánica con L-Triptófano, Manzanilla, Valeriana y Magnesio',
            description:
                'Equilibrio del sistema nervioso para mascotas con ansiedad por separación, miedo a pólvora/tormentas o estrés en viajes.',
            icon: Brain,
            accent: 'text-[#A855F7] bg-[#A855F7]/10 border-[#A855F7]/30',
            presentation: 'Doypack Zipper • 250g',
        },
        {
            id: 'renal',
            category: 'renal' as CategoryFilter,
            code: 'LAB-04',
            badge: 'EN FASE CLÍNICA • PRÓXIMAMENTE',
            title: 'AVIPET BioLab® — RENAL & URINARY SHIELD',
            subtitle: 'Complejo Nefroprotector con Arándano Rojo, Quitosano y Prebióticos',
            description:
                'Cuidado especializado del tracto urinario y función renal en gatos y perros con tendencia a cristales o cistitis.',
            icon: Droplets,
            accent: 'text-[#35DDF5] bg-[#35DDF5]/10 border-[#35DDF5]/30',
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
                    AVIPET BioLab® | Tienda Oficial de Biotecnología Nutricional Veterinaria en Colombia
                </title>
                <meta
                    name="description"
                    content="Tienda oficial de AVIPET BioLab®. Suplementos nutricionales biotecnológicos 100% hipoalergénicos para perros y gatos. Descubre Dermo & Gut Superboost con Envío Gratis y Pago Contraentrega en toda Colombia."
                />
            </Head>

            <div className="min-h-screen bg-[#F4F7FC] text-[#15213B] font-sans selection:bg-[#6D28D9] selection:text-white">
                {/* 0. BARRA DE TELEMETRÍA Y ANUNCIO OFICIAL */}
                <div className="bg-[#080B20] border-b border-white/10 text-white text-xs py-2.5 px-4">
                    <div className="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-x-6 gap-y-1">
                        <div className="flex items-center gap-2 mx-auto lg:mx-0">
                            <span className="inline-flex h-2 w-2 rounded-full bg-emerald-400 animate-pulse" />
                            <span className="font-bold tracking-wider uppercase text-[11px] text-emerald-300">
                                TIENDA OFICIAL AVIPET BIOLAB® COLOMBIA • ENVÍO GRATIS NACIONAL
                            </span>
                        </div>
                        <div className="flex flex-wrap items-center justify-center gap-x-5 gap-y-1 mx-auto lg:mx-0 font-medium">
                            <span className="inline-flex items-center gap-1.5 text-[#35DDF5] font-semibold">
                                <Truck className="w-3.5 h-3.5 shrink-0" />
                                🚚 PAGO CONTRAENTREGA EN CASA (EFECTIVO O TRANSFERENCIA)
                            </span>
                            <span className="hidden md:inline text-white/25">|</span>
                            <span className="hidden sm:inline-flex items-center gap-1.5 text-slate-200">
                                <Microscope className="w-3.5 h-3.5 text-[#A855F7] shrink-0" />
                                0% Pollo • 0% Res • 0% Gluten
                            </span>
                        </div>
                    </div>
                </div>

                {/* 1. NAVBAR DE LA TIENDA GENERAL AVIPET BioLab® */}
                <header className="sticky top-0 z-40 bg-[#080B20]/95 backdrop-blur-xl border-b border-white/10 shadow-lg">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between gap-4">
                        <a href={storeUrl} className="flex items-center gap-3 group">
                            <img
                                src="/images/biolab/logo-avipet-biolab.jpg"
                                alt="AVIPET BioLab®"
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
                                    <span className="hidden sm:inline-block ml-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-widest bg-white/10 text-[#35DDF5] border border-[#35DDF5]/30">
                                        FLAGSHIP STORE
                                    </span>
                                </div>
                                <span className="text-[11px] text-slate-300 font-medium">
                                    Laboratorio de Nutrición Clínica Veterinaria
                                </span>
                            </div>
                        </a>

                        <nav className="hidden lg:flex items-center gap-6 text-xs font-bold uppercase tracking-wider text-slate-300">
                            <a href="#diagnostico-sintomas" className="hover:text-[#35DDF5] transition">
                                Diagnóstico por Síntoma
                            </a>
                            <a href="#catalogo" className="hover:text-[#35DDF5] transition">
                                Catálogo Oficial
                            </a>
                            <a
                                href={productUrl}
                                className="px-3 py-1.5 rounded-lg bg-[#6D28D9]/25 border border-[#A855F7]/40 text-[#35DDF5] hover:bg-[#6D28D9]/40 transition"
                            >
                                🔥 Dermo &amp; Gut Superboost
                            </a>
                            <a href="#ciencia-biolab" className="hover:text-[#35DDF5] transition">
                                Estándar Clínico
                            </a>
                        </nav>

                        <div className="flex items-center gap-2.5">
                            <a
                                href={whatsappStoreUrl}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="hidden sm:inline-flex items-center gap-2 px-3.5 py-2 rounded-xl border border-emerald-400/40 bg-emerald-500/10 text-emerald-300 hover:bg-emerald-500/20 text-xs sm:text-sm font-semibold transition"
                            >
                                <MessageCircle className="w-4 h-4" />
                                Asesoría WhatsApp
                            </a>
                            <a
                                href={productUrl}
                                className="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-[#6D28D9] to-[#7C3AED] hover:from-[#5B21B6] hover:to-[#6D28D9] text-white text-xs sm:text-sm font-bold shadow-lg shadow-[#6D28D9]/30 transition"
                            >
                                <ShoppingBag className="w-4 h-4" />
                                <span>Ver Producto Estrella</span>
                            </a>
                        </div>
                    </div>
                </header>

                {/* 2. HERO PRINCIPAL DE LA TIENDA OFICIAL AVIPET BioLab® */}
                <section className="relative bg-gradient-to-b from-[#080B20] via-[#111936] to-[#080B20] text-white py-12 lg:py-20 overflow-hidden">
                    <div className="pointer-events-none absolute -top-32 -left-32 w-96 h-96 rounded-full bg-[#A855F7]/15 blur-3xl" />
                    <div className="pointer-events-none absolute top-1/3 -right-32 w-96 h-96 rounded-full bg-[#35DDF5]/15 blur-3xl" />

                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                        <div className="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                            <div className="lg:col-span-6 space-y-6">
                                <div className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 border border-[#35DDF5]/40 text-[#35DDF5] text-xs sm:text-sm font-bold">
                                    <FlaskConical className="w-4 h-4 text-[#A855F7]" />
                                    <span>BIOTECNOLOGÍA NUTRICIONAL DE GRADO CLÍNICO</span>
                                </div>

                                <h1 className="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white leading-[1.12]">
                                    Nutrición clínica de raíz para la salud de tu{' '}
                                    <span className="text-transparent bg-clip-text bg-gradient-to-r from-[#35DDF5] to-[#A855F7]">
                                        perro y gato.
                                    </span>
                                </h1>

                                <p className="text-base sm:text-lg text-slate-200 leading-relaxed max-w-2xl">
                                    Bienvenido a la tienda oficial de <strong className="text-white">AVIPET BioLab®</strong>.
                                    Desarrollamos suplementos funcionales en polvo de alta palatabilidad con{' '}
                                    <strong className="text-[#35DDF5]">Micro-Proteína Novel hipoalergénica</strong>,
                                    ácidos grasos bioactivos, prebióticos y fitoterapia clínica. 100% libres de pollo,
                                    res, soya y gluten.
                                </p>

                                <div className="flex flex-col sm:flex-row items-stretch sm:items-center gap-3.5 pt-2">
                                    <a
                                        href={productUrl}
                                        className="inline-flex items-center justify-center gap-2.5 px-7 py-4 rounded-2xl bg-gradient-to-r from-[#6D28D9] to-[#7C3AED] hover:from-[#5B21B6] hover:to-[#6D28D9] text-white font-extrabold text-base shadow-xl shadow-[#6D28D9]/40 transition"
                                    >
                                        <span>Conocer Dermo &amp; Gut Superboost</span>
                                        <ArrowRight className="w-5 h-5" />
                                    </a>
                                    <a
                                        href="#diagnostico-sintomas"
                                        className="inline-flex items-center justify-center gap-2 px-6 py-4 rounded-2xl bg-white/10 hover:bg-white/15 border border-white/20 text-white font-bold text-sm sm:text-base transition"
                                    >
                                        <Stethoscope className="w-4 h-4 text-[#35DDF5]" />
                                        <span>Diagnóstico por Síntoma</span>
                                    </a>
                                </div>

                                <div className="grid grid-cols-3 gap-4 pt-4 border-t border-white/10">
                                    <div>
                                        <p className="text-lg sm:text-2xl font-extrabold text-[#35DDF5] tabular-nums">
                                            0.0%
                                        </p>
                                        <p className="text-xs text-slate-300">Pollo, Res, Soya y Gluten</p>
                                    </div>
                                    <div>
                                        <p className="text-lg sm:text-2xl font-extrabold text-white tabular-nums">
                                            ⭐⭐⭐⭐⭐ 4.9
                                        </p>
                                        <p className="text-xs text-slate-300">Tutores y Médicos Vets</p>
                                    </div>
                                    <div>
                                        <p className="text-lg sm:text-2xl font-extrabold text-emerald-400">
                                            Envío Gratis
                                        </p>
                                        <p className="text-xs text-slate-300">Pago Contraentrega Colombia</p>
                                    </div>
                                </div>
                            </div>

                            <div className="lg:col-span-6">
                                <a
                                    href={productUrl}
                                    className="block group relative rounded-3xl overflow-hidden border border-white/15 shadow-2xl bg-[#111936]"
                                >
                                    <div className="absolute top-4 left-4 z-10 flex items-center gap-2">
                                        <span className="px-3 py-1 rounded-full bg-[#080B20]/90 backdrop-blur-md border border-[#35DDF5]/40 text-[#35DDF5] text-xs font-extrabold uppercase tracking-wider">
                                            🔥 LANZAMIENTO OFICIAL #1
                                        </span>
                                    </div>
                                    <img
                                        src="/images/biolab/banner-hero-oficial.jpg"
                                        alt="AVIPET BioLab® — Dermo & Gut Superboost"
                                        className="w-full h-auto object-cover group-hover:scale-[1.02] transition-transform duration-500"
                                    />
                                    <div className="p-5 bg-[#080B20]/95 border-t border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                        <div>
                                            <span className="text-[11px] font-bold uppercase tracking-wider text-emerald-400">
                                                ● DISPONIBLE EN STOCK • ENVÍO GRATIS + CONTRAENTREGA HOY
                                            </span>
                                            <p className="text-base sm:text-lg font-extrabold text-white mt-0.5">
                                                DERMO &amp; GUT SUPERBOOST (250g) — $69.900 COP
                                            </p>
                                        </div>
                                        <span className="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 rounded-xl bg-[#6D28D9] text-white text-xs sm:text-sm font-extrabold shrink-0 group-hover:bg-[#5B21B6] transition">
                                            Ir a la Página del Producto
                                            <ArrowRight className="w-4 h-4" />
                                        </span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                {/* 2.5 BUSCADOR INTERACTIVO POR SÍNTOMA CLÍNICO */}
                <section id="diagnostico-sintomas" className="py-12 lg:py-16 bg-white border-b border-slate-200">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center max-w-3xl mx-auto mb-8">
                            <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#0E7490]/10 text-[#0E7490] text-xs font-extrabold uppercase tracking-wider">
                                <Stethoscope className="w-3.5 h-3.5" />
                                Selector Clínico Interactivo
                            </span>
                            <h2 className="mt-2 text-2xl sm:text-3xl font-extrabold text-[#15213B]">
                                ¿Qué síntoma presenta tu perro o gato hoy?
                            </h2>
                            <p className="mt-1 text-sm sm:text-base text-[#5C6B85]">
                                Haz clic en la necesidad principal de tu peludo para ver la recomendación de nuestro
                                laboratorio.
                            </p>
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
                                                ? 'bg-[#080B20] text-white border-[#35DDF5] shadow-lg'
                                                : 'bg-[#F4F7FC] text-[#15213B] border-slate-200 hover:border-slate-300'
                                        }`}
                                    >
                                        {symptomGuide[key].buttonLabel}
                                    </button>
                                );
                            })}
                        </div>

                        <div className="rounded-3xl bg-gradient-to-r from-[#080B20] via-[#111936] to-[#080B20] text-white p-6 sm:p-8 border border-white/10 shadow-xl">
                            <div className="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                                <div className="lg:col-span-8 space-y-2.5">
                                    <span className="inline-block px-3 py-0.5 rounded-full bg-[#35DDF5]/15 text-[#35DDF5] text-xs font-bold">
                                        Enfoque Nutricional Recomendado
                                    </span>
                                    <h3 className="text-xl sm:text-2xl font-extrabold text-white">
                                        {currentSymptom.diagnosisTitle}
                                    </h3>
                                    <p className="text-sm sm:text-base text-slate-300 leading-relaxed">
                                        {currentSymptom.diagnosisText}
                                    </p>
                                    <p className="text-xs sm:text-sm text-emerald-300 font-semibold pt-1">
                                        🧬 Bio-Activos Clave: {currentSymptom.activeIngredients}
                                    </p>
                                </div>
                                <div className="lg:col-span-4 flex flex-col items-stretch sm:items-end justify-center gap-2 border-t lg:border-t-0 lg:border-l border-white/10 pt-4 lg:pt-0 lg:pl-6">
                                    <p className="text-xs font-bold uppercase tracking-wider text-slate-300">
                                        Fórmula Indicada:
                                    </p>
                                    <p className="text-sm sm:text-base font-extrabold text-[#35DDF5] sm:text-right">
                                        {currentSymptom.recommendedProduct}
                                    </p>
                                    <p className="text-xs text-slate-300 sm:text-right">{currentSymptom.priceText}</p>
                                    {currentSymptom.available ? (
                                        <a
                                            href={productUrl}
                                            className="mt-2 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-extrabold text-xs sm:text-sm shadow-lg transition"
                                        >
                                            <span>Ver Fórmula y Pedir Contraentrega</span>
                                            <ArrowRight className="w-4 h-4" />
                                        </a>
                                    ) : (
                                        <a
                                            href={whatsappStoreUrl}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            className="mt-2 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs sm:text-sm transition"
                                        >
                                            <MessageCircle className="w-4 h-4 text-emerald-400" />
                                            <span>Unirme a Lista VIP por WhatsApp</span>
                                        </a>
                                    )}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* 3. CATÁLOGO GENERAL DE LA TIENDA Y LÍNEAS DE MARCA */}
                <section id="catalogo" className="py-16 lg:py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                        <div>
                            <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#6D28D9]/10 text-[#6D28D9] text-xs font-extrabold uppercase tracking-wider">
                                Catálogo Oficial AVIPET BioLab®
                            </span>
                            <h2 className="mt-2 text-2xl sm:text-4xl font-extrabold text-[#15213B]">
                                Nuestras Líneas y Fórmulas Biotecnológicas
                            </h2>
                            <p className="mt-1.5 text-sm sm:text-base text-[#5C6B85]">
                                Explora nuestro lanzamiento estrella disponible hoy y las próximas fórmulas en
                                desarrollo clínico.
                            </p>
                        </div>

                        {/* Filtros de Categoría */}
                        <div className="flex flex-wrap gap-2">
                            {[
                                { id: 'todos', label: 'Todas las Líneas' },
                                { id: 'dermo_gut', label: '🛡️ Piel, Picazón y Digestión (Disponible)' },
                                { id: 'articulaciones', label: '🦴 Articulaciones (Próximamente)' },
                                { id: 'calma', label: '🧠 Calma y Estrés (Próximamente)' },
                            ].map((tab) => (
                                <button
                                    key={tab.id}
                                    type="button"
                                    onClick={() => setActiveCategory(tab.id as CategoryFilter)}
                                    className={`px-3.5 py-2 rounded-xl text-xs sm:text-sm font-bold transition cursor-pointer ${
                                        activeCategory === tab.id
                                            ? 'bg-[#080B20] text-white shadow'
                                            : 'bg-white border border-slate-200 text-[#5C6B85] hover:text-[#15213B]'
                                    }`}
                                >
                                    {tab.label}
                                </button>
                            ))}
                        </div>
                    </div>

                    {/* PRODUCTO ESTRELLA #1 (DESTACADO EN CATÁLOGO) */}
                    {showDermoGut && (
                        <div className="rounded-3xl bg-white border-2 border-[#6D28D9]/30 shadow-2xl overflow-hidden mb-14">
                            <div className="bg-gradient-to-r from-[#080B20] via-[#111936] to-[#080B20] px-6 py-3.5 flex flex-wrap items-center justify-between gap-2 text-xs text-white">
                                <span className="inline-flex items-center gap-1.5 font-extrabold text-[#35DDF5]">
                                    <Sparkles className="w-4 h-4" />
                                    FÓRMULA INSIGNIA #1 • DISPONIBLE PARA DESPACHO INMEDIATO
                                </span>
                                <span className="text-emerald-300 font-bold">
                                    🚚 Envío Gratis + Pago Contraentrega en toda Colombia
                                </span>
                            </div>

                            <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 p-6 sm:p-8 lg:p-10 items-center">
                                {/* Imagen del Producto */}
                                <div className="lg:col-span-5">
                                    <a
                                        href={productUrl}
                                        className="block relative rounded-2xl bg-[#F4F7FC] border border-slate-200 p-4 overflow-hidden group"
                                    >
                                        <span className="absolute top-4 left-4 z-10 px-3 py-1 rounded-full bg-[#0F9F9A] text-white text-xs font-extrabold shadow">
                                            Ahorras $17.800 COP
                                        </span>
                                        <img
                                            src="/images/biolab/empaque-frente-250g.jpg"
                                            alt="AVIPET BioLab® — Dermo & Gut Superboost (250g)"
                                            className="w-full max-h-96 object-contain mx-auto group-hover:scale-105 transition-transform duration-500"
                                        />
                                    </a>
                                </div>

                                {/* Información y Botones hacia la Product Page (/dermo-gut-superboost) */}
                                <div className="lg:col-span-7 space-y-5">
                                    <div className="flex flex-wrap items-center gap-2 text-xs">
                                        <span className="px-3 py-1 rounded-full bg-[#6D28D9]/10 text-[#6D28D9] font-extrabold">
                                            PIEL • DIGESTIÓN • ALIENTO (3 EN 1)
                                        </span>
                                        <span className="px-3 py-1 rounded-full bg-emerald-50 text-[#0F9F9A] font-extrabold">
                                            PERROS Y GATOS • DOYPACK 250g
                                        </span>
                                    </div>

                                    <div>
                                        <a href={productUrl} className="hover:underline">
                                            <h3 className="text-2xl sm:text-3xl font-extrabold text-[#15213B]">
                                                AVIPET BioLab® — DERMO &amp; GUT SUPERBOOST (250g)
                                            </h3>
                                        </a>
                                        <p className="mt-2 text-sm sm:text-base text-[#5C6B85] leading-relaxed">
                                            Suplemento Nutricional Biotecnológico 3 en 1 en Polvo con Micro-Proteína
                                            Novel de <em>Hermetia illucens</em> (40%), Ácido Láurico natural (4.5%),
                                            Omega 3-6-9, Fibra Prebiótica, Cúrcuma y Clorofila activa.
                                        </p>
                                    </div>

                                    <div className="flex items-center gap-2 text-sm">
                                        <div className="flex items-center text-amber-400">
                                            <Star className="w-4 h-4 fill-amber-400" />
                                            <Star className="w-4 h-4 fill-amber-400" />
                                            <Star className="w-4 h-4 fill-amber-400" />
                                            <Star className="w-4 h-4 fill-amber-400" />
                                            <Star className="w-4 h-4 fill-amber-400" />
                                        </div>
                                        <span className="font-extrabold text-[#15213B]">4.9 / 5.0</span>
                                        <span className="text-[#5C6B85] text-xs sm:text-sm">
                                            (Resultados visibles desde la 1.ª semana)
                                        </span>
                                    </div>

                                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs sm:text-sm text-[#15213B] font-medium">
                                        <div className="flex items-center gap-2">
                                            <CheckCircle2 className="w-4 h-4 text-[#0F9F9A] shrink-0" />
                                            <span>Corta picazón, alergias y caída de pelo</span>
                                        </div>
                                        <div className="flex items-center gap-2">
                                            <CheckCircle2 className="w-4 h-4 text-[#0F9F9A] shrink-0" />
                                            <span>Combate hongos (Malassezia) y lamido de patas</span>
                                        </div>
                                        <div className="flex items-center gap-2">
                                            <CheckCircle2 className="w-4 h-4 text-[#0F9F9A] shrink-0" />
                                            <span>Compacta las heces y blinda la microbiota</span>
                                        </div>
                                        <div className="flex items-center gap-2">
                                            <CheckCircle2 className="w-4 h-4 text-[#0F9F9A] shrink-0" />
                                            <span>0% Pollo • 0% Res • 0% Soya • 0% Gluten</span>
                                        </div>
                                    </div>

                                    {/* Resumen de Kits Escalonados */}
                                    <div className="grid grid-cols-3 gap-2.5 pt-2">
                                        <a
                                            href={productUrl}
                                            className="p-3 rounded-xl bg-[#F4F7FC] border border-slate-200 hover:border-[#6D28D9] transition text-center"
                                        >
                                            <p className="text-[11px] font-bold text-[#5C6B85]">1 Bolsa (250g)</p>
                                            <p className="text-sm sm:text-base font-extrabold text-[#15213B] tabular-nums">
                                                $69.900
                                            </p>
                                        </a>
                                        <a
                                            href={productUrl}
                                            className="p-3 rounded-xl bg-[#6D28D9]/5 border-2 border-[#6D28D9] transition text-center"
                                        >
                                            <p className="text-[11px] font-extrabold text-[#6D28D9]">
                                                🔥 Dúo (500g)
                                            </p>
                                            <p className="text-sm sm:text-base font-extrabold text-[#15213B] tabular-nums">
                                                $124.900
                                            </p>
                                        </a>
                                        <a
                                            href={productUrl}
                                            className="p-3 rounded-xl bg-emerald-50/70 border border-emerald-200 hover:border-[#0F9F9A] transition text-center"
                                        >
                                            <p className="text-[11px] font-extrabold text-[#0F9F9A]">
                                                🏆 90 Días (750g)
                                            </p>
                                            <p className="text-sm sm:text-base font-extrabold text-[#15213B] tabular-nums">
                                                $169.900
                                            </p>
                                        </a>
                                    </div>

                                    {/* Precios y CTA hacia /dermo-gut-superboost */}
                                    <div className="pt-4 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                        <div className="tabular-nums">
                                            <span className="text-xs text-[#5C6B85] line-through block">
                                                Precio Ancla: $87.700 COP
                                            </span>
                                            <div className="flex items-baseline gap-2">
                                                <span className="text-2xl sm:text-3xl font-extrabold text-[#15213B]">
                                                    $69.900 COP
                                                </span>
                                                <span className="text-xs font-bold text-[#0F9F9A]">
                                                    • Envío Gratis + Contraentrega
                                                </span>
                                            </div>
                                        </div>

                                        <div className="flex flex-wrap items-center gap-3">
                                            <a
                                                href={productUrl}
                                                className="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-7 py-4 rounded-2xl bg-gradient-to-r from-[#6D28D9] to-[#7C3AED] hover:from-[#5B21B6] hover:to-[#6D28D9] text-white font-extrabold text-sm sm:text-base shadow-lg shadow-[#6D28D9]/30 transition"
                                            >
                                                <ShoppingBag className="w-5 h-5" />
                                                <span>Ver Ficha Completa y Pedir en Casa</span>
                                                <ArrowRight className="w-4 h-4" />
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    )}

                    {/* PRÓXIMAS LÍNEAS Y MARCAS EN EL ECOSISTEMA AVIPET BioLab® */}
                    {filteredUpcoming.length > 0 && (
                        <div>
                            <div className="mb-6 flex items-center justify-between">
                                <div>
                                    <h3 className="text-lg sm:text-2xl font-extrabold text-[#15213B]">
                                        Próximas Marcas y Fórmulas en Desarrollo Clínico
                                    </h3>
                                    <p className="text-xs sm:text-sm text-[#5C6B85]">
                                        Nuevas líneas especializadas que se integrarán próximamente a la tienda general{' '}
                                        <strong>biolab.avipetapp.com</strong>.
                                    </p>
                                </div>
                            </div>

                            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                                {filteredUpcoming.map((item) => {
                                    const IconComponent = item.icon;
                                    return (
                                        <div
                                            key={item.id}
                                            className="rounded-2xl bg-white border border-slate-200/90 p-6 shadow-sm flex flex-col justify-between hover:shadow-md transition"
                                        >
                                            <div>
                                                <div className="flex items-center justify-between gap-2 mb-4">
                                                    <div
                                                        className={`w-11 h-11 rounded-xl border flex items-center justify-center ${item.accent}`}
                                                    >
                                                        <IconComponent className="w-5 h-5" />
                                                    </div>
                                                    <span className="px-2.5 py-1 rounded-full bg-slate-100 text-[#5C6B85] text-[10px] font-extrabold uppercase tracking-wider">
                                                        {item.badge}
                                                    </span>
                                                </div>

                                                <h4 className="text-lg font-extrabold text-[#15213B]">{item.title}</h4>
                                                <p className="mt-1 text-xs font-bold text-[#6D28D9]">
                                                    {item.subtitle}
                                                </p>
                                                <p className="mt-3 text-sm text-[#5C6B85] leading-relaxed">
                                                    {item.description}
                                                </p>
                                            </div>

                                            <div className="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                                                <span className="font-bold text-[#15213B]">
                                                    {item.presentation}
                                                </span>
                                                <a
                                                    href={whatsappStoreUrl}
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    className="font-extrabold text-[#6D28D9] hover:underline"
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

                {/* 4. PILARES CIENTÍFICOS Y GARANTÍA CONTRAENTREGA EN COLOMBIA */}
                <section id="ciencia-biolab" className="py-16 bg-[#080B20] text-white border-t border-white/10">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center max-w-3xl mx-auto mb-12">
                            <span className="text-xs font-extrabold uppercase tracking-wider text-[#35DDF5]">
                                Estándar Clínico AVIPET BioLab®
                            </span>
                            <h2 className="mt-2 text-2xl sm:text-3xl font-extrabold">
                                ¿Por qué los médicos veterinarios y tutores confían en nuestra tienda oficial?
                            </h2>
                        </div>

                        <div
                            id="garantia-colombia"
                            className="grid grid-cols-1 md:grid-cols-3 gap-6"
                        >
                            <div className="rounded-2xl bg-[#111936] border border-white/10 p-6">
                                <Microscope className="w-8 h-8 text-[#35DDF5] mb-4" />
                                <h3 className="text-lg font-bold text-white">
                                    1. Biotecnología Hipoalergénica Real
                                </h3>
                                <p className="mt-2 text-sm text-slate-300 leading-relaxed">
                                    Formulamos sin pollo, sin res, sin gluten y sin harinas de relleno. Usamos
                                    Micro-Proteína Novel y fitonutrientes puros con trazabilidad clínica.
                                </p>
                            </div>

                            <div className="rounded-2xl bg-[#111936] border border-white/10 p-6">
                                <Truck className="w-8 h-8 text-[#0F9F9A] mb-4" />
                                <h3 className="text-lg font-bold text-white">
                                    2. Envío Gratis y Pago en Casa
                                </h3>
                                <p className="mt-2 text-sm text-slate-300 leading-relaxed">
                                    Despachamos a toda Colombia sin costo de envío. Pagas en efectivo o transferencia
                                    únicamente cuando recibes el producto en tus manos.
                                </p>
                            </div>

                            <div className="rounded-2xl bg-[#111936] border border-white/10 p-6">
                                <ShieldCheck className="w-8 h-8 text-[#A855F7] mb-4" />
                                <h3 className="text-lg font-bold text-white">
                                    3. Empaque Doypack Anti-Oxidación
                                </h3>
                                <p className="mt-2 text-sm text-slate-300 leading-relaxed">
                                    Nuestras bolsas con cierre hermético Zipper protegen los ácidos grasos Omega 3, 6 y
                                    9 de la luz y el oxígeno hasta la última cucharada.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                {/* FOOTER DE LA TIENDA GENERAL */}
                <footer className="bg-[#080B20] text-slate-400 py-10 border-t border-white/10 text-xs sm:text-sm">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-6">
                        <div className="flex items-center gap-3">
                            <img
                                src="/images/biolab/logo-avipet-biolab.jpg"
                                alt="AVIPET BioLab®"
                                className="w-10 h-10 rounded-full object-cover border border-[#35DDF5]/40"
                            />
                            <div>
                                <p className="text-white font-semibold">
                                    AVIPET BioLab® — Tienda Oficial Colombia
                                </p>
                                <p className="text-xs text-slate-400">
                                    Una división de AviPetApp • Más inteligencia. Más bienestar. Más futuro.
                                </p>
                            </div>
                        </div>
                        <div className="flex flex-wrap items-center justify-center gap-4 text-xs">
                            <a href={productUrl} className="text-[#35DDF5] hover:underline font-semibold">
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
