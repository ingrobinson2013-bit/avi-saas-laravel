import React, { ReactNode, useState, useEffect } from 'react';
import { Link, router } from '@inertiajs/react';
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
    History,
    X,
    ArrowRight,
    Sparkles,
    Zap
} from 'lucide-react';

interface VetAdminLayoutProps {
    children: ReactNode;
    tenantSlug?: string;
    brandName?: string;
    clinicSubtitle?: string;
    logoUrl?: string | null;
    primaryColor?: string;
    secondaryColor?: string;
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
    primaryColor = '#0080ff',
    secondaryColor = '#d437b5',
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

    // Estado del buscador interactivo (Command Palette / ⌘K)
    const [isCommandOpen, setIsCommandOpen] = useState(false);
    const [searchQuery, setSearchQuery] = useState('');

    useEffect(() => {
        const handleKeyDown = (e: KeyboardEvent) => {
            if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
                e.preventDefault();
                setIsCommandOpen(prev => !prev);
            } else if (e.key === 'Escape') {
                setIsCommandOpen(false);
            }
        };
        window.addEventListener('keydown', handleKeyDown);
        return () => window.removeEventListener('keydown', handleKeyDown);
    }, []);

    const quickActions = [
        { title: 'Inicio / Resumen Clínico', category: 'Navegación', href: `/admin/${tenantSlug}`, icon: Home, badge: 'Dashboard' },
        { title: 'Terminal Mostrador & Canje Clínico', category: 'Recepción', href: `/admin/${tenantSlug}/counter-redeem`, icon: Tag, badge: 'Mostrador' },
        { title: 'Historial de Canjes & Auditoría', category: 'Recepción', href: `/admin/${tenantSlug}/historial-canjes`, icon: History, badge: 'Auditoría' },
        { title: 'Citas Médicas & Agenda Google', category: 'Recepción', href: `/admin/${tenantSlug}/citas`, icon: Calendar, badge: 'Google Sync' },
        { title: 'Mascotas y Pacientes', category: 'Clientes', href: `/admin/${tenantSlug}/pets`, icon: PawPrint, badge: 'Directorio' },
        { title: 'Tutores y Propietarios', category: 'Clientes', href: `/admin/${tenantSlug}/customers`, icon: User, badge: 'WhatsApp' },
        { title: 'Membresías & Coberturas Activas', category: 'Clientes', href: `/admin/${tenantSlug}/subscriptions`, icon: Shield, badge: 'Contratos' },
        { title: 'Planes de Salud Preventiva', category: 'Planes', href: `/admin/${tenantSlug}/plans`, icon: Heart, badge: 'Tarifas' },
        { title: 'Constructor de Planes (Simulador Monte Carlo)', category: 'Planes', href: `/admin/${tenantSlug}/plans/create`, icon: Layers, badge: 'Actuarial' },
        { title: 'Fidelización de Clientes, WhatsApp & Anti-Churn', category: 'Clientes', href: `/admin/${tenantSlug}/inteligencia`, icon: MessageSquare, badge: 'Copilot' },
        { title: 'Configuración de Marca, Logo y Medios de Pago', category: 'Configuración', href: `/admin/${tenantSlug}/clinic-settings`, icon: Settings, badge: 'Marca Blanca' },
        { title: 'Portal Público de Afiliación B2C', category: 'Enlaces Web', href: `/v/${tenantSlug}`, icon: QrCode, badge: 'Web Pacientes' },
        { title: 'Afiche Imprimible Mostrador con Código QR', category: 'Enlaces Web', href: `/v/${tenantSlug}/afiche`, icon: FileText, badge: 'QR Afiche' },
    ];

    const filteredActions = quickActions.filter(action =>
        action.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
        action.category.toLowerCase().includes(searchQuery.toLowerCase()) ||
        action.badge.toLowerCase().includes(searchQuery.toLowerCase())
    );

    const handleSelectAction = (href: string) => {
        setIsCommandOpen(false);
        setSearchQuery('');
        router.visit(getHref(href));
    };

    // Estado de Notificaciones
    const [isNotificationsOpen, setIsNotificationsOpen] = useState(false);
    const [notifications, setNotifications] = useState([
        {
            id: 'notif-1',
            title: 'Clínica Lista para Afiliar Pacientes',
            description: 'El portal de auto-afiliación y el mostrador están activos para registrar tutores y emitir carnets digitales.',
            time: 'Hace 5 min',
            type: 'system',
            unread: true,
            actionUrl: `/admin/${tenantSlug}/plans`,
            actionLabel: 'Ver Planes'
        },
        {
            id: 'notif-2',
            title: 'Google Calendar Sincronizado',
            description: 'El motor de citas médicas está conectado con verificación de disponibilidad en tiempo real.',
            time: 'Hace 1 hora',
            type: 'calendar',
            unread: true,
            actionUrl: `/admin/${tenantSlug}/citas`,
            actionLabel: 'Ver Agenda'
        },
        {
            id: 'notif-3',
            title: 'Asistente IA Gemini 3.8 Activo',
            description: 'Inteligencia clínica lista para responder preguntas veterinarias y triaje.',
            time: 'Hace 3 horas',
            type: 'ai',
            unread: true,
            actionUrl: `/admin/${tenantSlug}/inteligencia`,
            actionLabel: 'Probar IA'
        },
    ]);

    const unreadCount = notifications.filter(n => n.unread).length;

    const markAllNotificationsAsRead = () => {
        setNotifications(prev => prev.map(n => ({ ...n, unread: false })));
    };

    const markNotificationAsRead = (id: string) => {
        setNotifications(prev => prev.map(n => n.id === id ? { ...n, unread: false } : n));
    };

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
                        style={activeItem === 'Inicio' ? { backgroundColor: primaryColor } : undefined}
                        className={`flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold transition-all duration-150 ${
                            activeItem === 'Inicio'
                                ? 'text-white shadow-sm'
                                : 'text-slate-300 hover:text-white hover:bg-slate-800/60'
                        }`}
                    >
                        <Home className={`w-4 h-4 shrink-0 ${activeItem === 'Inicio' ? 'text-white' : 'text-slate-400'}`} />
                        <span className="flex-1 truncate">Inicio</span>
                    </Link>

                    {/* Fidelización & WhatsApp */}
                    <Link
                        href={getHref(`/admin/${tenantSlug}/inteligencia`)}
                        preserveScroll
                        style={(activeItem === 'Fidelización & WhatsApp' || activeItem === 'Inteligencia Artificial') ? { backgroundColor: primaryColor } : undefined}
                        className={`flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold transition-all duration-150 ${
                            (activeItem === 'Fidelización & WhatsApp' || activeItem === 'Inteligencia Artificial')
                                ? 'text-white shadow-sm'
                                : 'text-slate-300 hover:text-white hover:bg-slate-800/60'
                        }`}
                    >
                        <MessageSquare className={`w-4 h-4 shrink-0 ${(activeItem === 'Fidelización & WhatsApp' || activeItem === 'Inteligencia Artificial') ? 'text-white' : 'text-slate-400'}`} />
                        <span className="flex-1 truncate">Fidelización & WhatsApp</span>
                        <span className="text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full bg-emerald-500/25 text-emerald-300 border border-emerald-500/30">
                            Copilot
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
                                    href={getHref(`/admin/${tenantSlug}/citas`)}
                                    preserveScroll
                                    className={`flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-[11.5px] transition ${
                                        activeItem === 'Citas & Agenda' ? 'text-white font-bold bg-slate-800' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'
                                    }`}
                                >
                                    <Calendar className="w-3.5 h-3.5 text-slate-500" />
                                    <span>Citas & Agenda</span>
                                    <span className="ml-auto text-[8.5px] font-bold px-1.5 py-0.2 rounded bg-emerald-500/20 text-emerald-300">
                                        Google
                                    </span>
                                </Link>
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
                                    href={getHref(`/admin/${tenantSlug}/historial-canjes`)}
                                    preserveScroll
                                    className={`flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-[11.5px] transition ${
                                        activeItem === 'Historial de Canjes' ? 'text-white font-bold bg-slate-800' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'
                                    }`}
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
                            style={activeItem === 'Logística & Envíos' ? { backgroundColor: primaryColor } : undefined}
                            className={`flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold transition-all duration-150 ${
                                activeItem === 'Logística & Envíos'
                                    ? 'text-white shadow-sm'
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
                        <button
                            type="button"
                            onClick={() => setIsCommandOpen(true)}
                            className="w-full relative flex items-center text-left py-2 px-3.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white hover:border-blue-400 focus:outline-hidden focus:ring-2 focus:ring-blue-500/30 transition shadow-2xs group cursor-pointer"
                        >
                            <Search className="w-4 h-4 text-slate-400 group-hover:text-blue-500 transition shrink-0 mr-2.5" />
                            <span className="text-xs text-slate-400 flex-1 truncate">
                                Buscar módulo, paciente, tutor, plan o servicio...
                            </span>
                            <div className="flex items-center gap-1 shrink-0 ml-2">
                                <kbd className="text-[10px] font-bold text-slate-500 bg-white border border-slate-200 px-1.5 py-0.5 rounded shadow-2xs">⌘ K</kbd>
                            </div>
                        </button>
                    </div>

                    {/* Right User Bar */}
                    <div className="flex items-center gap-3">
                        {/* Notification Bell Dropdown */}
                        <div className="relative">
                            <button
                                type="button"
                                onClick={() => setIsNotificationsOpen(prev => !prev)}
                                aria-label="Notificaciones"
                                className={`relative w-9 h-9 rounded-xl border flex items-center justify-center transition cursor-pointer ${
                                    isNotificationsOpen ? 'bg-blue-50 border-blue-300 text-blue-600' : 'border-slate-200 text-slate-600 hover:bg-slate-50'
                                }`}
                            >
                                <Bell className="w-4 h-4" />
                                {unreadCount > 0 && (
                                    <span className="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-rose-500 text-white text-[9px] font-black flex items-center justify-center animate-pulse">
                                        {unreadCount}
                                    </span>
                                )}
                            </button>

                            {/* Dropdown Panel */}
                            {isNotificationsOpen && (
                                <div className="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-slate-200 z-50 overflow-hidden animate-scale-in">
                                    <div className="p-3.5 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                                        <div className="flex items-center gap-2">
                                            <span className="text-xs font-black text-slate-900">Notificaciones Clínicas</span>
                                            {unreadCount > 0 && (
                                                <span className="text-[10px] font-bold px-2 py-0.5 rounded-full bg-rose-100 text-rose-700">
                                                    {unreadCount} nuevas
                                                </span>
                                            )}
                                        </div>
                                        {unreadCount > 0 && (
                                            <button
                                                type="button"
                                                onClick={markAllNotificationsAsRead}
                                                className="text-[10.5px] font-bold text-blue-600 hover:text-blue-800 transition"
                                            >
                                                Marcar leídas
                                            </button>
                                        )}
                                    </div>

                                    <div className="divide-y divide-slate-100 max-h-80 overflow-y-auto">
                                        {notifications.map((n) => (
                                            <div 
                                                key={n.id} 
                                                className={`p-3.5 hover:bg-slate-50/80 transition flex gap-3 ${n.unread ? 'bg-blue-50/30' : ''}`}
                                            >
                                                <div className={`w-8 h-8 rounded-xl flex items-center justify-center shrink-0 ${
                                                    n.type === 'system' ? 'bg-emerald-100 text-emerald-700' :
                                                    n.type === 'calendar' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700'
                                                }`}>
                                                    {n.type === 'system' ? <Shield className="w-4 h-4" /> :
                                                     n.type === 'calendar' ? <Calendar className="w-4 h-4" /> : <Bot className="w-4 h-4" />}
                                                </div>
                                                <div className="flex-1 min-w-0">
                                                    <div className="flex items-center justify-between gap-1">
                                                        <div className="text-xs font-bold text-slate-900 truncate">{n.title}</div>
                                                        <span className="text-[9.5px] text-slate-400 shrink-0">{n.time}</span>
                                                    </div>
                                                    <p className="text-[11px] text-slate-500 mt-0.5 leading-snug">
                                                        {n.description}
                                                    </p>
                                                    <div className="mt-2 flex items-center justify-between">
                                                        <Link
                                                            href={getHref(n.actionUrl)}
                                                            onClick={() => {
                                                                markNotificationAsRead(n.id);
                                                                setIsNotificationsOpen(false);
                                                            }}
                                                            className="inline-flex items-center gap-1 text-[10.5px] font-bold text-blue-600 hover:text-blue-800"
                                                        >
                                                            <span>{n.actionLabel}</span>
                                                            <ArrowRight className="w-3 h-3" />
                                                        </Link>
                                                        {n.unread && (
                                                            <button
                                                                type="button"
                                                                onClick={() => markNotificationAsRead(n.id)}
                                                                className="text-[9.5px] text-slate-400 hover:text-slate-600"
                                                            >
                                                                Descartar
                                                            </button>
                                                        )}
                                                    </div>
                                                </div>
                                            </div>
                                        ))}
                                    </div>

                                    <div className="p-2.5 bg-slate-50 border-t border-slate-100 text-center">
                                        <span className="text-[10px] text-slate-400 font-medium">
                                            Centro de Alertas Clínicas · AVI-Plan Staging
                                        </span>
                                    </div>
                                </div>
                            )}
                        </div>

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

            {/* =========================================================
                 COMMAND PALETTE MODAL (SPOTLIGHT / ⌘K)
                 ========================================================= */}
            {isCommandOpen && (
                <div className="fixed inset-0 z-50 flex items-start justify-center pt-20 px-4 bg-slate-900/60 backdrop-blur-xs animate-fade-in">
                    <div 
                        className="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-xl overflow-hidden flex flex-col max-h-[80vh] animate-scale-in"
                        onClick={(e) => e.stopPropagation()}
                    >
                        {/* Search Input Bar */}
                        <div className="relative flex items-center px-4 py-3.5 border-b border-slate-100 bg-slate-50/50">
                            <Search className="w-5 h-5 text-blue-600 shrink-0 mr-3" />
                            <input
                                autoFocus
                                type="text"
                                value={searchQuery}
                                onChange={(e) => setSearchQuery(e.target.value)}
                                placeholder="Escribe para buscar o navegar (ej. Canje, Mascotas, Citas, Planes)..."
                                className="w-full bg-transparent border-0 text-sm font-semibold text-slate-900 placeholder:text-slate-400 focus:outline-hidden focus:ring-0"
                            />
                            {searchQuery ? (
                                <button 
                                    type="button" 
                                    onClick={() => setSearchQuery('')}
                                    className="p-1 text-slate-400 hover:text-slate-600 rounded-lg"
                                >
                                    <X className="w-4 h-4" />
                                </button>
                            ) : (
                                <kbd className="text-[10px] font-bold text-slate-400 bg-white border border-slate-200 px-1.5 py-0.5 rounded shadow-2xs">ESC</kbd>
                            )}
                        </div>

                        {/* Search Results List */}
                        <div className="overflow-y-auto p-2 space-y-1 max-h-96">
                            {filteredActions.length === 0 ? (
                                <div className="py-10 text-center text-slate-400 text-xs">
                                    No se encontraron acciones o módulos para "<span className="font-bold text-slate-600">{searchQuery}</span>".
                                </div>
                            ) : (
                                filteredActions.map((action, idx) => {
                                    const IconComp = action.icon;
                                    return (
                                        <button
                                            key={idx}
                                            type="button"
                                            onClick={() => handleSelectAction(action.href)}
                                            className="w-full flex items-center justify-between p-2.5 rounded-xl hover:bg-blue-50 text-left transition group cursor-pointer"
                                        >
                                            <div className="flex items-center gap-3 min-w-0">
                                                <div className="w-8 h-8 rounded-lg bg-slate-100 group-hover:bg-blue-600 group-hover:text-white text-slate-600 flex items-center justify-center transition shrink-0">
                                                    <IconComp className="w-4 h-4" />
                                                </div>
                                                <div className="min-w-0 flex-1">
                                                    <div className="text-xs font-bold text-slate-900 group-hover:text-blue-700 truncate">
                                                        {action.title}
                                                    </div>
                                                    <div className="text-[10px] text-slate-400 font-medium truncate">
                                                        {action.category}
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="flex items-center gap-2 shrink-0">
                                                <span className="text-[9.5px] font-bold px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 group-hover:bg-blue-100 group-hover:text-blue-800 transition">
                                                    {action.badge}
                                                </span>
                                                <ArrowRight className="w-3.5 h-3.5 text-slate-300 group-hover:text-blue-600 group-hover:translate-x-0.5 transition" />
                                            </div>
                                        </button>
                                    );
                                })
                            )}
                        </div>

                        {/* Command Palette Footer */}
                        <div className="px-4 py-2.5 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-[10.5px] text-slate-400">
                            <span>Navegación Rápida con <b>Enter</b></span>
                            <div className="flex items-center gap-2">
                                <span>Cerrar con</span>
                                <kbd className="px-1.5 py-0.5 bg-white border border-slate-200 rounded font-bold text-slate-500">Esc</kbd>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
}
