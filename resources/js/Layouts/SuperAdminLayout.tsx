import React, { ReactNode, useState } from 'react';
import { Link } from '@inertiajs/react';
import { 
    Home, 
    Building2, 
    CreditCard, 
    Users, 
    TrendingUp, 
    Settings, 
    Search, 
    Bell, 
    ChevronDown, 
    Menu, 
    X,
    LogOut,
    Sparkles
} from 'lucide-react';

interface SuperAdminLayoutProps {
    children: ReactNode;
    userName?: string;
    userEmail?: string;
    activeItem?: string;
}

export default function SuperAdminLayout({
    children,
    userName = 'Robinson Naranjo',
    userEmail = 'contacto@avipetapp.com',
    activeItem = 'Escritorio'
}: SuperAdminLayoutProps) {
    const [searchQuery, setSearchQuery] = useState('');
    const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
    const [isUserMenuOpen, setIsUserMenuOpen] = useState(false);

    // Compute initials for the avatar (e.g. RN)
    const initials = userName
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map(w => w[0].toUpperCase())
        .join('') || 'RN';

    const navItems = [
        {
            name: 'Escritorio',
            href: '/super-admin',
            icon: Home,
            active: activeItem === 'Escritorio'
        },
        {
            name: 'Clínicas veterinarias',
            href: '/super-admin/tenants',
            icon: Building2,
            active: activeItem === 'Clínicas veterinarias' || activeItem === 'Clínicas'
        },
        {
            name: 'Suscripciones y pagos',
            href: '/super-admin/saas-payment-logs',
            icon: CreditCard,
            active: activeItem === 'Suscripciones y pagos'
        },
        {
            name: 'Usuarios y doctores',
            href: '/super-admin/users',
            icon: Users,
            active: activeItem === 'Usuarios y doctores' || activeItem === 'Usuarios'
        },
        {
            name: 'Prospección B2B',
            href: '/super-admin/prospecto-veterinarias',
            icon: TrendingUp,
            active: activeItem === 'Prospección B2B'
        },
        {
            name: 'Inteligencia',
            href: '/super-admin/inteligencia',
            icon: Sparkles,
            active: activeItem === 'Inteligencia'
        },
        {
            name: 'Configuración',
            href: '/super-admin/configuracion',
            icon: Settings,
            active: activeItem === 'Configuración'
        },
    ];

    const handleSearchSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        if (searchQuery.trim()) {
            window.location.href = `/super-admin/tenants?tableSearch=${encodeURIComponent(searchQuery.trim())}`;
        }
    };

    return (
        <div className="min-h-screen bg-[#F4F7FC] text-[#15213B] font-sans antialiased flex flex-col md:flex-row">
            
            {/* MOBILE HEADER */}
            <div className="md:hidden bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-between sticky top-0 z-40">
                <Link href="/super-admin" className="flex items-center gap-2 py-1">
                    <img
                        src="/brand/svg/avipetapp-horizontal-fondo-claro.svg"
                        alt="AviPetApp"
                        className="h-8 w-auto min-w-[140px] object-contain"
                    />
                </Link>

                <button 
                    onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
                    className="p-2 text-[#5C6B85] hover:text-[#15213B] hover:bg-slate-100 rounded-lg transition"
                >
                    {isMobileMenuOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
                </button>
            </div>

            {/* DESKTOP SIDEBAR */}
            <aside className={`
                fixed inset-y-0 left-0 z-30 w-64 bg-white border-r border-slate-200 flex flex-col justify-between transition-transform duration-200 ease-in-out
                md:static md:translate-x-0
                ${isMobileMenuOpen ? 'translate-x-0' : '-translate-x-full'}
            `}>
                <div>
                    {/* Brand Logo Oficial v1.1 (Horizontal sobre fondo claro, min 140px) */}
                    <div className="px-6 py-5 border-b border-slate-100 flex flex-col gap-1">
                        <a href="/super-admin" className="inline-flex items-center">
                            <img
                                src="/brand/svg/avipetapp-horizontal-fondo-claro.svg"
                                alt="AviPetApp"
                                className="h-9 w-auto min-w-[148px] object-contain"
                            />
                        </a>
                        <span className="text-[10.5px] font-medium text-[#5C6B85] tracking-tight">
                            Software con IA para veterinarias
                        </span>
                    </div>

                    {/* Navigation Menu */}
                    <nav className="p-3 space-y-1">
                        {navItems.map((item) => {
                            const Icon = item.icon;
                            return (
                                <a
                                    key={item.name}
                                    href={item.href}
                                    className={`
                                        flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all
                                        ${item.active 
                                            ? 'bg-[#6D28D9]/10 text-[#6D28D9] shadow-2xs font-bold' 
                                            : 'text-[#5C6B85] hover:text-[#15213B] hover:bg-slate-50'
                                        }
                                    `}
                                >
                                    <Icon className={`w-4 h-4 shrink-0 ${item.active ? 'text-[#6D28D9]' : 'text-[#5C6B85]'}`} />
                                    <span>{item.name}</span>
                                </a>
                            );
                        })}
                    </nav>
                </div>

                {/* Bottom Watermark con Isotipo Oficial y Eslogan de Marca v1.1 */}
                <div className="p-4 m-3 rounded-2xl bg-[#F4F7FC] border border-slate-200/80 relative overflow-hidden">
                    <div className="relative flex items-center gap-2.5">
                        <div className="w-8 h-8 rounded-lg bg-[#080B20] flex items-center justify-center shrink-0 p-1.5">
                            <img
                                src="/brand/svg/avipetapp-isotipo-fondo-oscuro.svg"
                                alt="AviPetApp Isotipo"
                                className="w-full h-full object-contain"
                            />
                        </div>
                        <div className="leading-tight">
                            <div className="font-bold text-xs text-[#15213B] flex items-center gap-1.5">
                                <span>AviPetApp</span>
                                <span className="w-1.5 h-1.5 rounded-full bg-[#0F9F9A] inline-block" />
                            </div>
                            <div className="text-[10px] text-[#5C6B85] mt-0.5 leading-tight">
                                Más inteligencia. Más bienestar. Más futuro.
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            {/* MAIN CONTENT AREA */}
            <div className="flex-1 flex flex-col min-w-0">
                
                {/* TOP NAVBAR */}
                <header className="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between gap-4 sticky top-0 z-20">
                    
                    {/* Breadcrumbs */}
                    <div className="flex items-center gap-2 text-xs font-semibold text-[#5C6B85]">
                        <Home className="w-3.5 h-3.5 text-[#5C6B85]" />
                        <span>AviPetApp Superadmin</span>
                        <span className="text-slate-300">/</span>
                        <span className="text-[#15213B] font-bold">{activeItem}</span>
                    </div>

                    {/* Center Search Bar */}
                    <div className="flex-1 max-w-md mx-auto hidden sm:block">
                        <form onSubmit={handleSearchSubmit} className="relative">
                            <Search className="w-4 h-4 text-[#5C6B85] absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                            <input
                                type="text"
                                value={searchQuery}
                                onChange={(e) => setSearchQuery(e.target.value)}
                                placeholder="Buscar clínicas, usuarios, planes..."
                                className="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-200 bg-[#F4F7FC] text-[#15213B] placeholder-[#5C6B85] focus:outline-hidden focus:ring-2 focus:ring-[#6D28D9] focus:bg-white transition shadow-2xs"
                            />
                        </form>
                    </div>

                    {/* Right Actions: Bell + User Badge */}
                    <div className="flex items-center gap-3">
                        <a 
                            href="/super-admin/prospecto-veterinarias"
                            className="relative p-2 text-[#5C6B85] hover:text-[#15213B] hover:bg-slate-100 rounded-full transition"
                            title="Notificaciones"
                        >
                            <Bell className="w-4 h-4" />
                            <span className="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-[#6D28D9] ring-2 ring-white" />
                        </a>

                        {/* User Badge */}
                        <div className="relative">
                            <button
                                onClick={() => setIsUserMenuOpen(!isUserMenuOpen)}
                                className="flex items-center gap-2.5 p-1 rounded-full hover:bg-slate-50 transition"
                            >
                                <div className="w-8 h-8 rounded-full bg-[#6D28D9] text-white text-xs font-bold flex items-center justify-center shrink-0 shadow-2xs">
                                    {initials}
                                </div>
                                <div className="text-left hidden lg:block leading-tight">
                                    <div className="text-xs font-bold text-slate-800">{userName}</div>
                                    <div className="text-[10.5px] text-slate-400 font-medium">Superadmin</div>
                                </div>
                                <ChevronDown className="w-3.5 h-3.5 text-slate-400" />
                            </button>

                            {isUserMenuOpen && (
                                <div className="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-1.5 z-50 text-xs">
                                    <div className="px-3 py-2 border-b border-slate-100">
                                        <div className="font-bold text-slate-800 truncate">{userName}</div>
                                        <div className="text-slate-400 truncate text-[11px]">{userEmail}</div>
                                    </div>
                                    <a href="/super-admin/configuracion" className="flex items-center gap-2 px-3 py-2 text-slate-700 hover:bg-slate-50">
                                        <Settings className="w-3.5 h-3.5 text-slate-400" />
                                        <span>Configuración</span>
                                    </a>
                                    <a href="/super-admin/logout" className="w-full text-left flex items-center gap-2 px-3 py-2 text-rose-600 hover:bg-rose-50 border-t border-slate-100">
                                        <LogOut className="w-3.5 h-3.5" />
                                        <span>Cerrar sesión</span>
                                    </a>
                                </div>
                            )}
                        </div>
                    </div>
                </header>

                {/* PAGE BODY - FULL WIDTH */}
                <main className="flex-1 p-6 sm:p-8 w-full">
                    {children}
                </main>
            </div>
        </div>
    );
}
