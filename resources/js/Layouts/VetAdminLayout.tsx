import React, { ReactNode, useState } from 'react';
import { Link } from '@inertiajs/react';
import { 
    Home, 
    Bot, 
    Heart, 
    Users, 
    Settings, 
    CreditCard, 
    Bell, 
    Tag, 
    BarChart3, 
    Shield, 
    User, 
    FileText, 
    Layers, 
    BookOpen, 
    Search, 
    LogOut,
    Truck,
    QrCode,
    ChevronDown,
    PawPrint,
    Calendar,
    Stethoscope,
    TrendingUp,
    History
} from 'lucide-react';

interface VetAdminLayoutProps {
    children: ReactNode;
    tenantSlug?: string;
    brandName?: string;
    clinicSubtitle?: string;
    logoUrl?: string | null;
    saasPlan?: {
        tier?: string;
        name?: string;
        status?: string;
        statusLabel?: string;
        paidUntil?: string;
        manageUrl?: string;
    };
    logoutUrl?: string;
    userName?: string;
    userRole?: string;
    activeItem?: string;
}

export default function VetAdminLayout({
    children,
    tenantSlug = 'vet-pet-patitas',
    brandName = 'Vet-Pet Patitas',
    clinicSubtitle = 'Planes de salud para su mascota',
    logoUrl = 'https://pub-9b11349c37334765ad3e31861c78458f.r2.dev/tenants/logos/01M1WM7VP4PYQVQ7P0GBWK1RPW.webp',
    saasPlan = {
        name: 'Plan Profesional',
        statusLabel: 'Activo',
        paidUntil: '30/10/2026',
        manageUrl: `/admin/vet-pet-patitas/renovar-saas`
    },
    logoutUrl = `/admin/vet-pet-patitas/logout`,
    userName = 'Dra. Vicky Naranjo',
    userRole = 'Administradora',
    activeItem = 'Inicio'
}: VetAdminLayoutProps) {
    const isPreview = typeof window !== 'undefined' && (window.location.search.includes('preview=1') || window.location.href.includes('preview=1'));
    const getHref = (href: string) => (isPreview && !href.includes('preview=1')) ? `${href}${href.includes('?') ? '&' : '?'}preview=1` : href;

    // Estado de acordeones de menú
    const [openGroups, setOpenGroups] = useState<Record<string, boolean>>({
        clientes: true,
        planes: true,
        recepcion: true,
        reportes: true,
        configuracion: true,
    });

    const toggleGroup = (group: string) => {
        setOpenGroups(prev => ({ ...prev, [group]: !prev[group] }));
    };

    return (
        <div className="min-h-screen flex bg-[#F3F6FB] text-slate-800 font-sans antialiased selection:bg-blue-500 selection:text-white">
            
            {/* =========================================================
                 SIDEBAR FIJO (DARK NAVY THEME - IDENTICO A LA IMAGEN)
                 ========================================================= */}
            <aside className="w-[235px] 2xl:w-[250px] bg-[#0c1527] text-slate-300 flex flex-col shrink-0 min-h-screen sticky top-0 h-screen select-none z-40 border-r border-slate-800/80">
                
                {/* Brand Header (Marca Blanca Dinámica 100% de la Clínica) */}
                <div className="h-16 flex items-center gap-2.5 px-3.5 border-b border-slate-800/80 shrink-0">
                    {logoUrl ? (
                        <div className="w-10 h-10 rounded-xl bg-white border border-slate-700/80 shadow-xs p-1 flex items-center justify-center shrink-0 overflow-hidden">
                            <img 
                                src={logoUrl} 
                                alt={brandName} 
                                className="w-full h-full object-contain"
                            />
                        </div>
                    ) : (
                        <div className="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white text-base shadow-sm shrink-0 font-bold">
                            🐾
                        </div>
                    )}
                    <div className="flex flex-col min-w-0 flex-1">
                        <span className="text-[13.5px] font-black text-white leading-tight tracking-tight truncate" title={brandName}>
                            {brandName}
                        </span>
                        <span className="text-[9.5px] font-medium text-slate-400 truncate" title={clinicSubtitle}>
                            {clinicSubtitle}
                        </span>
                    </div>
                </div>

                {/* Nav Links con Acordeón Jerárquico */}
                <nav className="flex-1 overflow-y-auto px-3 py-3 space-y-1 scrollbar-thin scrollbar-thumb-slate-700">
                    
                    {/* Inicio */}
                    <Link
                        href={getHref(`/admin/${tenantSlug}`)}
                        preserveScroll
                        className={`flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold transition-all duration-150 ${
                            activeItem === 'Inicio'
                                ? 'bg-[#0080ff] text-white shadow-sm'
                                : 'text-slate-300 hover:text-white hover:bg-slate-800/60'
                        }`}
                    >
                        <Home className={`w-4 h-4 shrink-0 ${activeItem === 'Inicio' ? 'text-white' : 'text-slate-400'}`} />
                        <span className="flex-1 truncate">Inicio</span>
                    </Link>

                    {/* Inteligencia */}
                    <Link
                        href={getHref(`/admin/${tenantSlug}/inteligencia`)}
                        preserveScroll
                        className={`flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold transition-all duration-150 ${
                            activeItem === 'Inteligencia Artificial'
                                ? 'bg-[#0080ff] text-white shadow-sm'
                                : 'text-slate-300 hover:text-white hover:bg-slate-800/60'
                        }`}
                    >
                        <Bot className={`w-4 h-4 shrink-0 ${activeItem === 'Inteligencia Artificial' ? 'text-white' : 'text-slate-400'}`} />
                        <span className="flex-1 truncate">Inteligencia</span>
                        <span className="text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full bg-purple-500/25 text-purple-300 border border-purple-500/30">
                            IA
                        </span>
                    </Link>

                    {/* Grupo: Clientes */}
                    <div className="pt-2">
                        <button
                            type="button"
                            onClick={() => toggleGroup('clientes')}
                            className="w-full flex items-center justify-between px-3 py-1.5 text-xs font-bold text-slate-400 hover:text-slate-200 transition"
                        >
                            <span className="flex items-center gap-2 text-slate-300">
                                <Users className="w-4 h-4 text-slate-400" />
                                <span>Clientes</span>
                            </span>
                            <ChevronDown className={`w-3.5 h-3.5 transition-transform duration-200 ${openGroups.clientes ? 'rotate-0' : '-rotate-90'}`} />
                        </button>
                        {openGroups.clientes && (
                            <div className="pl-6 pr-1 py-1 space-y-0.5">
                                <Link
                                    href={getHref(`/admin/${tenantSlug}/pets`)}
                                    preserveScroll
                                    className={`flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-[11.5px] transition ${
                                        activeItem === 'Clientes y Mascotas' ? 'text-white font-bold bg-slate-800' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'
                                    }`}
                                >
                                    <PawPrint className="w-3.5 h-3.5 text-slate-500" />
                                    <span>Mascotas</span>
                                </Link>
                                <Link
                                    href={getHref(`/admin/${tenantSlug}/customers`)}
                                    preserveScroll
                                    className={`flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-[11.5px] transition ${
                                        activeItem === 'Tutores' ? 'text-white font-bold bg-slate-800' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'
                                    }`}
                                >
                                    <User className="w-3.5 h-3.5 text-slate-500" />
                                    <span>Tutores</span>
                                </Link>
                                <Link
                                    href={getHref(`/admin/${tenantSlug}/subscriptions`)}
                                    preserveScroll
                                    className={`flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-[11.5px] transition ${
                                        activeItem === 'Membresías & Afiliaciones' ? 'text-white font-bold bg-slate-800' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'
                                    }`}
                                >
                                    <Shield className="w-3.5 h-3.5 text-slate-500" />
                                    <span>Membresías</span>
                                </Link>
                            </div>
                        )}
                    </div>

                    {/* Grupo: Planes */}
                    <div className="pt-1">
                        <button
                            type="button"
                            onClick={() => toggleGroup('planes')}
                            className="w-full flex items-center justify-between px-3 py-1.5 text-xs font-bold text-slate-400 hover:text-slate-200 transition"
                        >
                            <span className="flex items-center gap-2 text-slate-300">
                                <Calendar className="w-4 h-4 text-slate-400" />
                                <span>Planes</span>
                            </span>
                            <ChevronDown className={`w-3.5 h-3.5 transition-transform duration-200 ${openGroups.planes ? 'rotate-0' : '-rotate-90'}`} />
                        </button>
                        {openGroups.planes && (
                            <div className="pl-6 pr-1 py-1 space-y-0.5">
                                <Link
                                    href={getHref(`/admin/${tenantSlug}/plans`)}
                                    preserveScroll
                                    className={`flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-[11.5px] transition ${
                                        activeItem === 'Planes de Salud' ? 'text-white font-bold bg-slate-800' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'
                                    }`}
                                >
                                    <Heart className="w-3.5 h-3.5 text-slate-500" />
                                    <span>Planes de Salud</span>
                                </Link>
                                <Link
                                    href={getHref(`/admin/${tenantSlug}/plans/create`)}
                                    preserveScroll
                                    className={`flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-[11.5px] transition ${
                                        activeItem === 'Constructor de Planes' ? 'text-white font-bold bg-slate-800' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'
                                    }`}
                                >
                                    <Layers className="w-3.5 h-3.5 text-slate-500" />
                                    <span>Constructor de Planes</span>
                                </Link>
                                <Link
                                    href={getHref(`/admin/${tenantSlug}/benefit-definitions`)}
                                    preserveScroll
                                    className={`flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-[11.5px] transition ${
                                        activeItem === 'Catálogo de Servicios' ? 'text-white font-bold bg-slate-800' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'
                                    }`}
                                >
                                    <BookOpen className="w-3.5 h-3.5 text-slate-500" />
                                    <span>Servicios y Beneficios</span>
                                </Link>
                            </div>
                        )}
                    </div>

                    {/* Grupo: Recepción */}
                    <div className="pt-1">
                        <button
                            type="button"
                            onClick={() => toggleGroup('recepcion')}
                            className="w-full flex items-center justify-between px-3 py-1.5 text-xs font-bold text-slate-400 hover:text-slate-200 transition"
                        >
                            <span className="flex items-center gap-2 text-slate-300">
                                <Stethoscope className="w-4 h-4 text-slate-400" />
                                <span>Recepción</span>
                            </span>
                            <ChevronDown className={`w-3.5 h-3.5 transition-transform duration-200 ${openGroups.recepcion ? 'rotate-0' : '-rotate-90'}`} />
                        </button>
                        {openGroups.recepcion && (
                            <div className="pl-6 pr-1 py-1 space-y-0.5">
                                <Link
                                    href={getHref(`/admin/${tenantSlug}/counter-redeem`)}
                                    preserveScroll
                                    className={`flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-[11.5px] transition ${
                                        activeItem === 'Canje en Recepción' ? 'text-white font-bold bg-slate-800' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'
                                    }`}
                                >
                                    <Tag className="w-3.5 h-3.5 text-slate-500" />
                                    <span>Canje en Recepción</span>
                                </Link>
                                <Link
                                    href={getHref(`/admin/${tenantSlug}/counter-redeem`)}
                                    preserveScroll
                                    className="flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-[11.5px] text-slate-400 hover:text-white hover:bg-slate-800/50 transition"
                                >
                                    <History className="w-3.5 h-3.5 text-slate-500" />
                                    <span>Historial de Canjes</span>
                                </Link>
                            </div>
                        )}
                    </div>

                    {/* Grupo: Reportes */}
                    <div className="pt-1">
                        <button
                            type="button"
                            onClick={() => toggleGroup('reportes')}
                            className="w-full flex items-center justify-between px-3 py-1.5 text-xs font-bold text-slate-400 hover:text-slate-200 transition"
                        >
                            <span className="flex items-center gap-2 text-slate-300">
                                <BarChart3 className="w-4 h-4 text-slate-400" />
                                <span>Reportes</span>
                            </span>
                            <ChevronDown className={`w-3.5 h-3.5 transition-transform duration-200 ${openGroups.reportes ? 'rotate-0' : '-rotate-90'}`} />
                        </button>
                        {openGroups.reportes && (
                            <div className="pl-6 pr-1 py-1 space-y-0.5">
                                <Link
                                    href={getHref(`/admin/${tenantSlug}/subscriptions`)}
                                    preserveScroll
                                    className="flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-[11.5px] text-slate-400 hover:text-white hover:bg-slate-800/50 transition"
                                >
                                    <TrendingUp className="w-3.5 h-3.5 text-slate-500" />
                                    <span>Métricas y Estadísticas</span>
                                </Link>
                                <Link
                                    href={getHref(`/admin/${tenantSlug}/subscriptions`)}
                                    preserveScroll
                                    className="flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-[11.5px] text-slate-400 hover:text-white hover:bg-slate-800/50 transition"
                                >
                                    <BarChart3 className="w-3.5 h-3.5 text-slate-500" />
                                    <span>Crecimiento</span>
                                </Link>
                            </div>
                        )}
                    </div>

                    {/* Grupo: Configuración */}
                    <div className="pt-1">
                        <button
                            type="button"
                            onClick={() => toggleGroup('configuracion')}
                            className="w-full flex items-center justify-between px-3 py-1.5 text-xs font-bold text-slate-400 hover:text-slate-200 transition"
                        >
                            <span className="flex items-center gap-2 text-slate-300">
                                <Settings className="w-4 h-4 text-slate-400" />
                                <span>Configuración</span>
                            </span>
                            <ChevronDown className={`w-3.5 h-3.5 transition-transform duration-200 ${openGroups.configuracion ? 'rotate-0' : '-rotate-90'}`} />
                        </button>
                        {openGroups.configuracion && (
                            <div className="pl-6 pr-1 py-1 space-y-0.5">
                                <Link
                                    href={getHref(`/admin/${tenantSlug}/clinic-settings`)}
                                    preserveScroll
                                    className={`flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-[11.5px] transition ${
                                        activeItem === 'Configuración' ? 'text-white font-bold bg-slate-800' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'
                                    }`}
                                >
                                    <CreditCard className="w-3.5 h-3.5 text-slate-500" />
                                    <span>Marca y Medios de Pago</span>
                                </Link>
                                <Link
                                    href={getHref(`/admin/${tenantSlug}/clinic-settings`)}
                                    preserveScroll
                                    className="flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-[11.5px] text-slate-400 hover:text-white hover:bg-slate-800/50 transition"
                                >
                                    <User className="w-3.5 h-3.5 text-slate-500" />
                                    <span>Usuarios</span>
                                </Link>
                                <Link
                                    href={getHref(`/admin/${tenantSlug}/renovar-saas`)}
                                    preserveScroll
                                    className="flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-[11.5px] text-slate-400 hover:text-white hover:bg-slate-800/50 transition"
                                >
                                    <Shield className="w-3.5 h-3.5 text-slate-500" />
                                    <span>Suscripción</span>
                                </Link>
                            </div>
                        )}
                    </div>

                    {/* Logística & Envíos */}
                    <div className="pt-1">
                        <Link
                            href={getHref(`/admin/${tenantSlug}/logistica`)}
                            preserveScroll
                            className={`flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold transition-all duration-150 ${
                                activeItem === 'Logística & Envíos'
                                    ? 'bg-[#0080ff] text-white shadow-sm'
                                    : 'text-slate-300 hover:text-white hover:bg-slate-800/60'
                            }`}
                        >
                            <Truck className={`w-4 h-4 shrink-0 ${activeItem === 'Logística & Envíos' ? 'text-white' : 'text-slate-400'}`} />
                            <span className="flex-1 truncate">Logística & Envíos</span>
                            <span className="text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full bg-purple-500/25 text-purple-300 border border-purple-500/30">
                                AUTO
                            </span>
                        </Link>
                    </div>

                    {/* Cerrar Sesión Link */}
                    <div className="pt-2">
                        <a
                            href={logoutUrl}
                            className="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold text-slate-400 hover:text-rose-400 hover:bg-slate-800/50 transition-all duration-150"
                        >
                            <LogOut className="w-4 h-4 shrink-0 text-slate-400" />
                            <span className="flex-1 truncate">Cerrar Sesión</span>
                        </a>
                    </div>
                </nav>

                {/* Footer Clinic Card & Estado del Plan SaaS */}
                <div className="p-3 border-t border-slate-800/80 shrink-0 bg-[#0c1527]">
                    <div className="rounded-xl border border-slate-800 bg-[#131f37] p-3 space-y-2.5">
                        <div className="flex items-center gap-2.5">
                            {logoUrl ? (
                                <img src={logoUrl} alt={brandName} className="w-8 h-8 rounded-lg object-contain bg-white p-0.5 shrink-0" />
                            ) : (
                                <div className="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white text-xs font-bold shrink-0">
                                    🐾
                                </div>
                            )}
                            <div className="min-w-0 flex-1">
                                <div className="text-xs font-black text-white truncate">{brandName}</div>
                                <div className="text-[10px] text-emerald-400 font-bold flex items-center gap-1">
                                    <span>Plan Profesional</span>
                                    <span>·</span>
                                    <span>Activo</span>
                                </div>
                                <div className="text-[9.5px] text-slate-400">
                                    Renueva: 30/10/2026
                                </div>
                            </div>
                        </div>

                        <a 
                            href={saasPlan?.manageUrl || `/admin/${tenantSlug}/renovar-saas`}
                            className="block w-full py-1.5 px-2 rounded-lg bg-[#1d4ed8] hover:bg-blue-600 text-white text-center text-xs font-bold transition shadow-xs"
                        >
                            Gestionar plan
                        </a>
                    </div>
                </div>
            </aside>

            {/* MAIN CONTENT AREA */}
            <div className="flex-1 flex flex-col min-w-0">
                
                {/* TOPBAR */}
                <header className="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 sticky top-0 z-30 shadow-2xs">
                    
                    {/* Centered Search Pill */}
                    <div className="flex-1 max-w-xl">
                        <div className="w-full relative">
                            <Search className="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                            <input 
                                type="text" 
                                placeholder="Buscar mascota, cliente, plan o servicio..." 
                                className="w-full pl-9 pr-14 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 placeholder:text-slate-400 focus:outline-hidden focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition"
                            />
                            <div className="absolute right-2.5 top-1/2 -translate-y-1/2 flex items-center gap-0.5">
                                <kbd className="text-[10px] font-bold text-slate-400 bg-white border border-slate-200 px-1.5 py-0.5 rounded shadow-2xs">⌘ K</kbd>
                            </div>
                        </div>
                    </div>

                    {/* Right User Bar */}
                    <div className="flex items-center gap-3">
                        <button
                            type="button"
                            aria-label="Notificaciones"
                            className="relative w-9 h-9 rounded-xl border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-50 transition"
                        >
                            <Bell className="w-4 h-4" />
                            <span className="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-rose-500 text-white text-[9px] font-black flex items-center justify-center">
                                3
                            </span>
                        </button>

                        <a
                            href={`/v/${tenantSlug}/afiche`}
                            target="_blank"
                            rel="noreferrer"
                            title="Ver Afiche QR Mostrador"
                            className="w-9 h-9 rounded-xl border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-50 transition"
                        >
                            <QrCode className="w-4 h-4" />
                        </a>

                        <div className="flex items-center gap-2.5 pl-2 border-l border-slate-200">
                            <img 
                                src="/images/dashboard/dra_vicky_hd.png" 
                                alt={userName} 
                                className="w-9 h-9 rounded-full object-cover border border-slate-200 shadow-2xs"
                            />
                            <div className="hidden sm:flex flex-col text-left">
                                <span className="text-xs font-bold text-slate-900 leading-tight">
                                    {userName}
                                </span>
                                <span className="text-[10px] text-slate-400 font-medium">
                                    {userRole}
                                </span>
                            </div>
                        </div>
                    </div>
                </header>

                {/* MAIN PAGE VIEW INJECTED HERE */}
                <main className="flex-1 p-6">
                    {children}
                </main>
            </div>
        </div>
    );
}
