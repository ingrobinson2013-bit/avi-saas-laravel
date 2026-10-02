import React, { ReactNode } from 'react';
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
    Headphones,
    ExternalLink,
    LogOut 
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
    logoUrl = null,
    saasPlan = {
        name: 'Plan Pro',
        statusLabel: 'Activo',
        paidUntil: 'Al día',
        manageUrl: `/admin/vet-pet-patitas/renovar-saas`
    },
    logoutUrl = `/admin/vet-pet-patitas/logout`,
    userName = 'Dra. Vicky Naranjo',
    userRole = 'Administradora de Sede',
    activeItem = 'Inicio'
}: VetAdminLayoutProps) {

    const navItems = [
        { label: 'Inicio', icon: Home, href: `/admin/${tenantSlug}`, active: activeItem === 'Inicio' },
        { label: 'Inteligencia Artificial', icon: Bot, href: `/admin/${tenantSlug}/inteligencia`, badge: 'Beta', active: activeItem === 'Inteligencia Artificial' },
        { label: 'Planes de Salud', icon: Heart, href: `/admin/${tenantSlug}/plans`, active: activeItem === 'Planes de Salud' },
        { label: 'Clientes y Mascotas', icon: Users, href: `/admin/${tenantSlug}/pets`, hasChevron: true, active: activeItem === 'Clientes y Mascotas' },
        { label: 'Configuración', icon: Settings, href: `/admin/${tenantSlug}/clinic-settings`, hasDownChevron: true, active: activeItem === 'Configuración' },
        { label: 'Marca y Medios de Pago', icon: CreditCard, href: `/admin/${tenantSlug}/clinic-settings`, hasChevron: true, active: activeItem === 'Marca y Medios de Pago' },
        { label: 'Recepción', icon: Bell, href: `/admin/${tenantSlug}/counter-redeem`, hasChevron: true, active: activeItem === 'Recepción' },
        { label: 'Canje en Recepción', icon: Tag, href: `/admin/${tenantSlug}/counter-redeem`, active: activeItem === 'Canje en Recepción' },
        { label: 'Reportes y Estadísticas', icon: BarChart3, href: `/admin/${tenantSlug}/subscriptions`, hasChevron: true, active: activeItem === 'Reportes y Estadísticas' },
        { label: 'Membresías & Afiliaciones', icon: Shield, href: `/admin/${tenantSlug}/subscriptions`, hasChevron: true, active: activeItem === 'Membresías & Afiliaciones' },
        { label: 'Tutores', icon: User, href: `/admin/${tenantSlug}/customers`, active: activeItem === 'Tutores' },
        { label: 'Planes y Beneficios', icon: FileText, href: `/admin/${tenantSlug}/plans`, hasChevron: true, active: activeItem === 'Planes y Beneficios' },
        { label: 'Constructor de Planes', icon: Layers, href: `/admin/${tenantSlug}/plans/create`, active: activeItem === 'Constructor de Planes' },
        { label: 'Catálogo de Servicios', icon: BookOpen, href: `/admin/${tenantSlug}/benefit-definitions`, active: activeItem === 'Catálogo de Servicios' },
    ];

    const isPreview = typeof window !== 'undefined' && (window.location.search.includes('preview=1') || window.location.href.includes('preview=1'));
    const getHref = (href: string) => (isPreview && !href.includes('preview=1')) ? `${href}${href.includes('?') ? '&' : '?'}preview=1` : href;

    return (
        <div className="min-h-screen flex bg-[#F3F6FB] text-slate-800 font-sans antialiased">
            
            {/* SIDEBAR FIJO */}
            <aside className="w-[230px] 2xl:w-[245px] bg-white border-r border-slate-200/90 flex flex-col shrink-0 min-h-screen sticky top-0 h-screen select-none z-40">
                
                {/* Brand Header Dinámico con Logo de la Clínica */}
                <div className="h-16 flex items-center gap-2.5 px-3.5 border-b border-slate-100 shrink-0">
                    {logoUrl ? (
                        <div className="w-10 h-10 rounded-xl bg-white border border-slate-200/90 shadow-2xs p-1 flex items-center justify-center shrink-0 overflow-hidden group hover:border-cyan-500 transition">
                            <img 
                                src={logoUrl} 
                                alt={brandName} 
                                className="w-full h-full object-contain"
                            />
                        </div>
                    ) : (
                        <div className="w-10 h-10 rounded-full bg-[#0080ff] flex items-center justify-center text-white text-base shadow-sm shrink-0 font-bold">
                            🐾
                        </div>
                    )}
                    <div className="flex flex-col min-w-0 flex-1">
                        <span className="text-[13.5px] font-black text-slate-900 leading-tight tracking-tight truncate" title={brandName}>
                            {brandName}
                        </span>
                        <span className="text-[9.5px] font-medium text-slate-400 truncate" title={clinicSubtitle}>
                            {clinicSubtitle}
                        </span>
                    </div>
                </div>

                {/* Nav Links */}
                <nav className="flex-1 overflow-y-auto px-2.5 py-2.5 space-y-0.5 scrollbar-thin scrollbar-thumb-slate-200">
                    {navItems.map((item) => {
                        const Icon = item.icon;
                        const linkHref = getHref(item.href);
                        return (
                            <Link
                                key={item.label}
                                href={linkHref}
                                preserveScroll
                                className={`flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all duration-150 ${
                                    item.active
                                        ? 'bg-[#0080ff] text-white shadow-xs'
                                        : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80'
                                }`}
                            >
                                <Icon className={`w-4 h-4 shrink-0 ${item.active ? 'text-white' : 'text-slate-400'}`} />
                                <span className="flex-1 truncate">{item.label}</span>
                                {item.badge && (
                                    <span className="text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full bg-purple-100 text-purple-700">
                                        {item.badge}
                                    </span>
                                )}
                                {item.hasChevron && !item.badge && (
                                    <span className="text-slate-400 text-xs font-semibold">›</span>
                                )}
                                {item.hasDownChevron && !item.badge && (
                                    <span className="text-slate-400 text-xs font-semibold">⌄</span>
                                )}
                            </Link>
                        );
                    })}
                    {/* Cerrar Sesión Link */}
                    <a
                        href={logoutUrl}
                        className="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition-all duration-150 mt-1"
                    >
                        <LogOut className="w-4 h-4 shrink-0 text-slate-400" />
                        <span className="flex-1 truncate">Cerrar Sesión</span>
                    </a>
                </nav>

                {/* Footer Pet Card & Estado del Plan SaaS */}
                <div className="p-3 border-t border-slate-100 shrink-0 bg-white space-y-2">
                    <div className="rounded-2xl border border-slate-200/90 shadow-2xs bg-white p-2.5 relative overflow-hidden">
                        <div className="flex items-center gap-2 mb-2">
                            <div className="w-6 h-6 rounded-full bg-[#0080ff] text-white flex items-center justify-center text-xs shrink-0 font-bold">
                                🐾
                            </div>
                            <div className="flex flex-col min-w-0">
                                <span className="text-[10.5px] font-black text-slate-800 leading-tight">
                                    Tu aliado en cada etapa de su vida
                                </span>
                                <span className="text-[9px] font-medium text-slate-400">
                                    Salud · Bienestar · Amor
                                </span>
                            </div>
                        </div>

                        <div className="rounded-xl overflow-hidden relative">
                            <img 
                                src="/images/dashboard/sidebar_pet_hd.png" 
                                alt="Tu aliado en cada etapa de su vida" 
                                className="w-full h-auto object-cover block"
                            />
                            {/* Cyan Doodle Heart */}
                            <svg className="w-5 h-5 text-sky-400 stroke-current rotate-12 absolute right-2 bottom-2 drop-shadow-xs" viewBox="0 0 24 24" fill="none" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
                                <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                            </svg>
                        </div>
                    </div>

                    {/* Estado del Plan SaaS Card */}
                    <div className="p-2 rounded-xl bg-slate-50 border border-slate-200/90 shadow-2xs">
                        <div className="flex items-center justify-between mb-1">
                            <span className="text-[10.5px] font-black text-slate-900 truncate flex items-center gap-1">
                                <span className="text-amber-500">⭐</span>
                                <span>{saasPlan?.name || 'Plan Starter'}</span>
                            </span>
                            <span className="inline-flex items-center gap-1 px-1.5 py-0.2 rounded-full text-[8.5px] font-black bg-emerald-100 text-emerald-800 border border-emerald-200">
                                <span className="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                {saasPlan?.statusLabel || 'Activo'}
                            </span>
                        </div>
                        <div className="flex items-center justify-between">
                            <span className="text-[9px] text-slate-400 font-medium">
                                {saasPlan?.paidUntil ? `Hasta ${saasPlan.paidUntil}` : 'Licencia SaaS al día'}
                            </span>
                            <a 
                                href={saasPlan?.manageUrl || `/admin/${tenantSlug}/renovar-saas`}
                                className="text-[9.5px] font-bold text-blue-600 hover:text-blue-700 hover:underline"
                            >
                                Gestionar →
                            </a>
                        </div>
                    </div>
                </div>
            </aside>

            {/* MAIN CONTENT AREA (EXPANDE AL 100% SIN DESIERTOS GRISES) */}
            <div className="flex-1 flex flex-col min-w-0">
                
                {/* TOPBAR (EXACTO AL MOCKUP) */}
                <header className="h-16 bg-white border-b border-slate-200/90 flex items-center justify-between px-6 sticky top-0 z-30 shadow-2xs">
                    
                    {/* Centered Search Pill */}
                    <div className="flex-1 flex items-center justify-center px-4 max-w-2xl mx-auto">
                        <div className="w-full max-w-md relative">
                            <Search className="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                            <input 
                                type="text" 
                                placeholder="Buscar cliente, mascota o plan..." 
                                className="w-full pl-9 pr-14 py-2 text-xs rounded-full border border-slate-200 bg-slate-50 text-slate-800 placeholder:text-slate-400 focus:outline-hidden focus:ring-2 focus:ring-cyan-500/40 focus:border-cyan-500 transition shadow-2xs"
                            />
                            <div className="absolute right-2.5 top-1/2 -translate-y-1/2 flex items-center gap-0.5">
                                <kbd className="text-[10px] font-bold text-slate-400 bg-white border border-slate-200 px-1.5 py-0.5 rounded shadow-2xs">⌘K</kbd>
                            </div>
                        </div>
                    </div>

                    {/* Right Icons & User Profile */}
                    <div className="flex items-center gap-3 shrink-0">
                        {/* Notification Bell with Red Badge 1 */}
                        <button 
                            type="button" 
                            className="relative p-2 rounded-full text-slate-500 hover:text-slate-700 hover:bg-slate-100 transition"
                            title="Notificaciones"
                        >
                            <Bell className="w-5 h-5 text-slate-600" />
                            <span className="absolute top-1.5 right-1.5 w-4 h-4 rounded-full bg-rose-500 text-white text-[9px] font-black flex items-center justify-center">
                                1
                            </span>
                        </button>

                        {/* Support Headphones */}
                        <a 
                            href="https://wa.me/573508742543" 
                            target="_blank" 
                            rel="noreferrer"
                            className="p-2 rounded-full text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition"
                            title="Soporte y Mesa de Ayuda"
                        >
                            <Headphones className="w-5 h-5" />
                        </a>

                        {/* Doctor Avatar & Role */}
                        <div className="flex items-center gap-2.5 pl-2 border-l border-slate-200">
                            <img 
                                src="/images/dashboard/dra_vicky_hd.png" 
                                alt={userName} 
                                className="w-8 h-8 rounded-full object-cover border border-slate-200 shadow-2xs"
                            />
                            <div className="flex flex-col text-left leading-tight">
                                <span className="text-xs font-black text-slate-900 whitespace-nowrap">
                                    {userName}
                                </span>
                                <span className="text-[10px] font-medium text-slate-400 whitespace-nowrap">
                                    {userRole}
                                </span>
                            </div>

                            {/* Botón Salir / Logout sutil */}
                            <a 
                                href={logoutUrl}
                                className="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition ml-1"
                                title="Cerrar Sesión / Salir"
                            >
                                <LogOut className="w-4 h-4" />
                            </a>
                        </div>
                    </div>
                </header>

                {/* PAGE CANVAS - FULL WIDTH NATURAL */}
                <main className="flex-1 p-4 lg:p-5 overflow-y-auto">
                    {children}
                </main>

            </div>
        </div>
    );
}
