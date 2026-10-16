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
    LogOut
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
    userEmail = 'superadmin@avipetapp.com',
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
            active: activeItem === 'Clínicas veterinarias'
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
            active: activeItem === 'Usuarios y doctores'
        },
        {
            name: 'Prospección B2B',
            href: '/super-admin/prospecto-veterinarias',
            icon: TrendingUp,
            active: activeItem === 'Prospección B2B'
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
        <div className="min-h-screen bg-[#f8fafc] text-slate-800 font-sans antialiased flex flex-col md:flex-row">
            
            {/* MOBILE HEADER */}
            <div className="md:hidden bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-between sticky top-0 z-40">
                <Link href="/super-admin" className="flex items-center gap-2">
                    <svg className="w-7 h-7 text-teal-600" viewBox="0 0 24 24" fill="currentColor">
                        <ellipse cx="6.5" cy="7.5" rx="2" ry="2.7" />
                        <ellipse cx="11" cy="5" rx="2" ry="2.7" />
                        <ellipse cx="16" cy="5.5" rx="2" ry="2.7" />
                        <ellipse cx="19.5" cy="8.5" rx="1.8" ry="2.5" />
                        <path d="M12 10.5c-3.2 0-5.8 2.2-5.8 5.2 0 2.2 1.6 3.8 3.5 3.8 1.1 0 1.8-.6 2.3-.6.5 0 1.2.6 2.3.6 1.9 0 3.5-1.6 3.5-3.8 0-3-2.6-5.2-5.8-5.2z" />
                    </svg>
                    <span className="font-black text-xl tracking-tight text-slate-900">
                        AVI<span className="text-teal-600">Pet</span>
                    </span>
                </Link>

                <button 
                    onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
                    className="p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition"
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
                    {/* Brand Logo matching mockup */}
                    <div className="px-6 py-5 border-b border-slate-100 flex items-center gap-2.5">
                        <svg className="w-8 h-8 text-teal-600 shrink-0" viewBox="0 0 24 24" fill="currentColor">
                            <ellipse cx="6.5" cy="7.5" rx="2" ry="2.7" />
                            <ellipse cx="11" cy="5" rx="2" ry="2.7" />
                            <ellipse cx="16" cy="5.5" rx="2" ry="2.7" />
                            <ellipse cx="19.5" cy="8.5" rx="1.8" ry="2.5" />
                            <path d="M12 10.5c-3.2 0-5.8 2.2-5.8 5.2 0 2.2 1.6 3.8 3.5 3.8 1.1 0 1.8-.6 2.3-.6.5 0 1.2.6 2.3.6 1.9 0 3.5-1.6 3.5-3.8 0-3-2.6-5.2-5.8-5.2z" />
                        </svg>
                        <span className="font-extrabold text-2xl tracking-tight text-slate-900">
                            AVI<span className="text-teal-600">Pet</span>
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
                                            ? 'bg-teal-50 text-teal-800 shadow-2xs font-bold' 
                                            : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50'
                                        }
                                    `}
                                >
                                    <Icon className={`w-4 h-4 shrink-0 ${item.active ? 'text-teal-700' : 'text-slate-400'}`} />
                                    <span>{item.name}</span>
                                </a>
                            );
                        })}
                    </nav>
                </div>

                {/* Bottom Watermark matching mockup */}
                <div className="p-4 m-3 rounded-2xl bg-gradient-to-br from-teal-50/60 via-slate-50 to-emerald-50/40 border border-teal-100/70 relative overflow-hidden">
                    <div className="absolute -bottom-6 -left-6 w-20 h-20 bg-teal-200/30 rounded-full blur-xl pointer-events-none" />
                    
                    <div className="relative flex items-center gap-2.5">
                        <div className="w-8 h-8 rounded-lg bg-teal-600/10 flex items-center justify-center shrink-0">
                            <svg className="w-4 h-4 text-teal-600" viewBox="0 0 24 24" fill="currentColor">
                                <ellipse cx="6.5" cy="7.5" rx="2" ry="2.7" />
                                <ellipse cx="11" cy="5" rx="2" ry="2.7" />
                                <ellipse cx="16" cy="5.5" rx="2" ry="2.7" />
                                <ellipse cx="19.5" cy="8.5" rx="1.8" ry="2.5" />
                                <path d="M12 10.5c-3.2 0-5.8 2.2-5.8 5.2 0 2.2 1.6 3.8 3.5 3.8 1.1 0 1.8-.6 2.3-.6.5 0 1.2.6 2.3.6 1.9 0 3.5-1.6 3.5-3.8 0-3-2.6-5.2-5.8-5.2z" />
                            </svg>
                        </div>
                        <div className="leading-tight overflow-hidden">
                            <div className="font-bold text-xs text-slate-900 flex items-center gap-1">
                                <span>AVI Pet</span>
                                <span className="w-1.5 h-1.5 rounded-full bg-teal-500 inline-block" />
                            </div>
                            <div className="text-[10.5px] text-slate-500 mt-0.5 truncate">
                                Red preventiva de clínicas
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            {/* MAIN CONTENT AREA */}
            <div className="flex-1 flex flex-col min-w-0">
                
                {/* TOP NAVBAR */}
                <header className="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between gap-4 sticky top-0 z-20">
                    
                    {/* Breadcrumbs matching mockup */}
                    <div className="flex items-center gap-2 text-xs font-semibold text-slate-500">
                        <Home className="w-3.5 h-3.5 text-slate-400" />
                        <span>Superadmin</span>
                        <span className="text-slate-300">/</span>
                        <span className="text-slate-800 font-bold">{activeItem}</span>
                    </div>

                    {/* Center Search Bar matching mockup */}
                    <div className="flex-1 max-w-md mx-auto hidden sm:block">
                        <form onSubmit={handleSearchSubmit} className="relative">
                            <Search className="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                            <input
                                type="text"
                                value={searchQuery}
                                onChange={(e) => setSearchQuery(e.target.value)}
                                placeholder="Buscar clínicas, usuarios, planes..."
                                className="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50/70 text-slate-800 placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-teal-500 focus:bg-white transition shadow-2xs"
                            />
                        </form>
                    </div>

                    {/* Right Actions: Bell + User Badge */}
                    <div className="flex items-center gap-3">
                        {/* Notification Bell with Blue Dot matching mockup */}
                        <a 
                            href="/super-admin/prospecto-veterinarias"
                            className="relative p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-full transition"
                            title="Notificaciones"
                        >
                            <Bell className="w-4 h-4" />
                            <span className="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-blue-500 ring-2 ring-white" />
                        </a>

                        {/* User Badge matching mockup */}
                        <div className="relative">
                            <button
                                onClick={() => setIsUserMenuOpen(!isUserMenuOpen)}
                                className="flex items-center gap-2.5 p-1 rounded-full hover:bg-slate-50 transition"
                            >
                                <div className="w-8 h-8 rounded-full bg-teal-800 text-teal-100 text-xs font-bold flex items-center justify-center shrink-0 shadow-2xs">
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
                                    <form method="POST" action="/super-admin/logout" className="border-t border-slate-100">
                                        <button type="submit" className="w-full text-left flex items-center gap-2 px-3 py-2 text-rose-600 hover:bg-rose-50">
                                            <LogOut className="w-3.5 h-3.5" />
                                            <span>Cerrar sesión</span>
                                        </button>
                                    </form>
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
