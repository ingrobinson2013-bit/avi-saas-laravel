import React, { ReactNode } from 'react';
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
    Headphones 
} from 'lucide-react';

interface VetAdminLayoutProps {
    children: ReactNode;
    tenantSlug?: string;
    userName?: string;
    userRole?: string;
    activeItem?: string;
}

export default function VetAdminLayout({
    children,
    tenantSlug = 'vet-pet-patitas',
    userName = 'Dra. Vicky Naranjo',
    userRole = 'Administradora de Sede',
    activeItem = 'Inicio'
}: VetAdminLayoutProps) {

    const navItems = [
        { label: 'Inicio', icon: Home, href: `/admin/${tenantSlug}`, active: activeItem === 'Inicio' },
        { label: 'Inteligencia Artificial', icon: Bot, href: `/admin/${tenantSlug}/ai`, badge: 'Beta', active: activeItem === 'Inteligencia Artificial' },
        { label: 'Planes de Salud', icon: Heart, href: `/admin/${tenantSlug}/plans`, active: activeItem === 'Planes de Salud' },
        { label: 'Clientes y Mascotas', icon: Users, href: `/admin/${tenantSlug}/pets`, active: activeItem === 'Clientes y Mascotas' },
        { label: 'Configuración', icon: Settings, href: `/admin/${tenantSlug}/configuracion-clinica`, active: activeItem === 'Configuración' },
        { label: 'Marca y Medios de Pago', icon: CreditCard, href: `/admin/${tenantSlug}/renovar-saas`, active: activeItem === 'Marca y Medios de Pago' },
        { label: 'Recepción', icon: Bell, href: `/admin/${tenantSlug}/recepcion`, active: activeItem === 'Recepción' },
        { label: 'Canje en Recepción', icon: Tag, href: `/admin/${tenantSlug}/canje-mostrador`, active: activeItem === 'Canje en Recepción' },
        { label: 'Reportes y Estadísticas', icon: BarChart3, href: `/admin/${tenantSlug}/reportes`, active: activeItem === 'Reportes y Estadísticas' },
        { label: 'Membresías & Afiliaciones', icon: Shield, href: `/admin/${tenantSlug}/subscriptions`, active: activeItem === 'Membresías & Afiliaciones' },
        { label: 'Tutores', icon: User, href: `/admin/${tenantSlug}/customers`, active: activeItem === 'Tutores' },
        { label: 'Planes y Beneficios', icon: FileText, href: `/admin/${tenantSlug}/plans`, active: activeItem === 'Planes y Beneficios' },
        { label: 'Constructor de Planes', icon: Layers, href: `/admin/${tenantSlug}/plans/create`, active: activeItem === 'Constructor de Planes' },
        { label: 'Catálogo de Servicios', icon: BookOpen, href: `/admin/${tenantSlug}/servicios`, active: activeItem === 'Catálogo de Servicios' },
    ];

    return (
        <div className="min-h-screen flex bg-[#edf0f7] text-slate-900 font-sans">
            
            {/* SIDEBAR FIJO (PETSALUD+ EXACTO AL MOCKUP) */}
            <aside className="w-[235px] bg-white border-r border-slate-200/80 flex flex-col shrink-0 min-h-screen sticky top-0 h-screen select-none z-40">
                
                {/* Brand Header */}
                <div className="h-16 flex items-center gap-3 px-4 border-b border-slate-100 shrink-0">
                    <div className="w-9 h-9 rounded-full bg-gradient-to-tr from-blue-600 via-sky-500 to-cyan-400 flex items-center justify-center text-white text-base shadow-sm shrink-0">
                        🐾
                    </div>
                    <div className="flex flex-col min-w-0">
                        <span className="text-sm font-black text-slate-900 leading-tight tracking-tight">
                            PetSalud<span className="text-cyan-500">+</span>
                        </span>
                        <span className="text-[10px] font-medium text-slate-400 truncate">
                            Planes de salud para su mascota
                        </span>
                    </div>
                </div>

                {/* Nav Links */}
                <nav className="flex-1 overflow-y-auto px-2.5 py-3 space-y-0.5 scrollbar-thin scrollbar-thumb-slate-200">
                    {navItems.map((item) => {
                        const Icon = item.icon;
                        return (
                            <a
                                key={item.label}
                                href={item.href}
                                className={`flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold transition-all duration-150 ${
                                    item.active
                                        ? 'bg-[#0284c7] text-white shadow-xs'
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
                            </a>
                        );
                    })}
                </nav>

                {/* Footer Pet Card (Mockup Exact) */}
                <div className="p-2.5 border-t border-slate-100 mt-auto shrink-0">
                    <div className="rounded-2xl overflow-hidden border border-slate-200/80 shadow-2xs bg-white">
                        <img 
                            src="/images/dashboard/sidebar_pet_2x.png" 
                            alt="Tu aliado en cada etapa de su vida" 
                            className="w-full h-auto object-cover block"
                        />
                    </div>
                </div>
            </aside>

            {/* MAIN CONTENT AREA */}
            <div className="flex-1 flex flex-col min-w-0">
                
                {/* TOPBAR (EXACTO AL MOCKUP) */}
                <header className="h-16 bg-white border-b border-slate-200/80 flex items-center justify-between px-6 sticky top-0 z-30 shadow-2xs">
                    
                    {/* Centered Search Pill */}
                    <div className="flex-1 flex justify-center px-4 max-w-xl mx-auto">
                        <div className="w-full relative">
                            <Search className="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                            <input 
                                type="text" 
                                placeholder="Buscar cliente, mascota o plan..." 
                                className="w-full pl-9 pr-4 py-2 text-xs rounded-full border border-slate-200 bg-slate-50 text-slate-800 placeholder:text-slate-400 focus:outline-hidden focus:ring-2 focus:ring-cyan-500/40 focus:border-cyan-500 transition shadow-2xs"
                            />
                        </div>
                    </div>

                    {/* Right Icons & User Profile */}
                    <div className="flex items-center gap-3.5 shrink-0">
                        
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
                                src="/images/dashboard/dra_vicky.png" 
                                alt={userName} 
                                className="w-8 h-8 rounded-full object-cover border border-slate-200 shadow-2xs"
                            />
                            <div className="flex flex-col text-left leading-tight">
                                <span className="text-xs font-black text-slate-900">
                                    {userName}
                                </span>
                                <span className="text-[10px] font-medium text-slate-400">
                                    {userRole}
                                </span>
                            </div>
                        </div>

                    </div>
                </header>

                {/* PAGE CANVAS */}
                <main className="flex-1 p-5 lg:p-6 overflow-y-auto">
                    {children}
                </main>

            </div>
        </div>
    );
}
