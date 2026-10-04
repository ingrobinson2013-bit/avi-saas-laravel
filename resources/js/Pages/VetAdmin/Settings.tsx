import React, { useState } from 'react';
import { Head, router } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { 
    Building2, 
    CreditCard, 
    Check, 
    Save, 
    Image as ImageIcon, 
    Video as VideoIcon,
    Palette, 
    RotateCcw, 
    ExternalLink,
    ShieldCheck,
    PlayCircle,
    Eye
} from 'lucide-react';

interface SettingsData {
    name: string;
    city: string;
    address: string;
    phone: string;
    email: string;
    logo_url?: string;
    tagline?: string;
    hero_image_url?: string;
    banner_image_url?: string;
    banner_video_url?: string;
    hero_title?: string;
    hero_subtitle?: string;
    hero_price_badge?: string;
    primary_color?: string;
    secondary_color?: string;
    payment_nequi: string;
    payment_bank_info: string;
    payment_bold_link: string;
    auto_enrollment?: boolean;
}

interface SettingsProps {
    tenantSlug: string;
    brandName: string;
    clinicSubtitle: string;
    logoUrl?: string | null;
    saasPlan: any;
    logoutUrl: string;
    userName: string;
    userRole: string;
    settings: SettingsData;
}

const DEFAULT_OFFICIAL_LOGO = 'https://pub-9b11349c37334765ad3e31861c78458f.r2.dev/tenants/logos/01M1WM7VP4PYQVQ7P0GBWK1RPW.webp';
const DEFAULT_HERO_IMAGE = 'https://pub-9b11349c37334765ad3e31861c78458f.r2.dev/tenants/heroes/01M1FEY7TJ5HDAE20YXX3X46G4.webp';
const DEFAULT_BANNER_IMAGE = 'https://pub-9b11349c37334765ad3e31861c78458f.r2.dev/tenants/banners/01M1WMMT19GBVFKCHN2BWNNMF4.webp';
const DEFAULT_BANNER_VIDEO = 'https://pub-9b11349c37334765ad3e31861c78458f.r2.dev/tenants/videos/01M1WMMTC4TCADMGJPNSESE0GR.mp4';

const BRAND_COLOR_PRESETS = [
    { label: 'Azul Veterinario', hex: '#0080ff' },
    { label: 'Turquesa Clínico', hex: '#0D9488' },
    { label: 'Índigo Moderno', hex: '#4F46E5' },
    { label: 'Violeta Premium', hex: '#7C3AED' },
    { label: 'Verde Salud', hex: '#059669' },
];

const ACCENT_COLOR_PRESETS = [
    { label: 'Magenta Acento', hex: '#D437B5' },
    { label: 'Ámbar Cálido', hex: '#F59E0B' },
    { label: 'Rosa Coral', hex: '#F43F5E' },
    { label: 'Cian Fresco', hex: '#06B6D4' },
    { label: 'Verde Neón', hex: '#10B981' },
];

export default function Settings({
    tenantSlug,
    brandName,
    clinicSubtitle,
    logoUrl,
    saasPlan,
    logoutUrl,
    userName,
    userRole,
    settings,
}: SettingsProps) {
    const [saved, setSaved] = useState(false);
    const [saving, setSaving] = useState(false);
    const [form, setForm] = useState<SettingsData>({
        ...settings,
        logo_url: settings.logo_url || logoUrl || DEFAULT_OFFICIAL_LOGO,
        tagline: settings.tagline || clinicSubtitle || 'Planes de salud para su mascota',
        hero_image_url: settings.hero_image_url || DEFAULT_HERO_IMAGE,
        banner_image_url: settings.banner_image_url || DEFAULT_BANNER_IMAGE,
        banner_video_url: settings.banner_video_url || DEFAULT_BANNER_VIDEO,
        hero_title: settings.hero_title || 'El cuidado de tu mascota, todo el año.',
        hero_subtitle: settings.hero_subtitle || 'Accede a servicios veterinarios y beneficios exclusivos con una membresía diseñada por Vet-Pet Patitas Consultorio Veterinario.',
        hero_price_badge: settings.hero_price_badge || 'Desde $50.000/mes',
        primary_color: settings.primary_color || '#0080ff',
        secondary_color: settings.secondary_color || '#d437b5',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        setSaving(true);
        router.post(`/admin/${tenantSlug}/clinic-settings`, form, {
            preserveScroll: true,
            onSuccess: () => {
                setSaving(false);
                setSaved(true);
                setTimeout(() => setSaved(false), 4000);
            },
            onError: () => {
                setSaving(false);
            },
        });
    };

    return (
        <VetAdminLayout
            tenantSlug={tenantSlug}
            brandName={form.name ? form.name.replace(/\s+(Consultorio Veterinario|Clínica Veterinaria|Hospital Veterinario)$/i, '') : brandName}
            clinicSubtitle={form.tagline || clinicSubtitle}
            logoUrl={form.logo_url || logoUrl}
            saasPlan={saasPlan}
            logoutUrl={logoutUrl}
            userName={userName}
            userRole={userRole}
            activeItem="Configuración"
        >
            <Head title={`Configuración, Fotos & Video · ${brandName}`} />

            <div className="space-y-4 max-w-4xl pb-16">
                {/* Header Banner */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div className="flex items-center gap-2">
                            <h1 className="text-xl font-black text-slate-900 tracking-tight">
                                Configuración de Sede, Multimedia & Marca Blanca
                            </h1>
                            <span className="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Sede Activa
                            </span>
                        </div>
                        <p className="text-xs text-slate-500 mt-1">
                            Ajusta el logotipo, fotos de portada, video institucional en 9:16, canales de recaudo y presencia de marca blanca.
                        </p>
                    </div>

                    <div className="flex items-center gap-2">
                        <a
                            href={`/v/${tenantSlug}`}
                            target="_blank"
                            rel="noopener noreferrer"
                            className="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5"
                        >
                            <Eye className="w-3.5 h-3.5 text-slate-500" />
                            <span>Ver Portal B2C</span>
                            <ExternalLink className="w-3 h-3 text-slate-400" />
                        </a>
                        <a
                            href={`/admin/${tenantSlug}/renovar-saas`}
                            className="px-3.5 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-bold transition flex items-center gap-1.5"
                        >
                            <span>⭐ Licencia SaaS</span>
                        </a>
                    </div>
                </div>

                {saved && (
                    <div className="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2.5 shadow-2xs animate-fadeIn">
                        <Check className="w-4 h-4 text-emerald-600 shrink-0" />
                        <span>¡Configuración, fotos, videos y medios de pago actualizados exitosamente en la base de datos!</span>
                    </div>
                )}

                <form onSubmit={handleSubmit} className="space-y-4">
                    {/* Tarjeta 1: Marca Blanca & Logotipo Oficial */}
                    <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-4">
                        <div className="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div className="flex items-center gap-2">
                                <div className="w-8 h-8 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                                    <ImageIcon className="w-4 h-4" />
                                </div>
                                <div>
                                    <h3 className="text-sm font-bold text-slate-900">Marca Blanca & Logotipo de la Clínica</h3>
                                    <p className="text-[11px] text-slate-500">Visible en barra lateral, recetas, carnets digitales y afiches QR</p>
                                </div>
                            </div>
                            <span className="text-[11px] font-bold px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 border border-blue-100">
                                White-Label
                            </span>
                        </div>

                        {/* Vista previa en vivo del Logotipo */}
                        <div className="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                            <div className="flex items-center gap-3">
                                <div className="w-20 h-20 rounded-2xl bg-white border-2 border-slate-200 shadow-xs p-1.5 flex items-center justify-center shrink-0 overflow-hidden">
                                    {form.logo_url ? (
                                        <img 
                                            src={form.logo_url} 
                                            alt={form.name} 
                                            className="w-full h-full object-contain"
                                            onError={(e) => {
                                                (e.target as HTMLImageElement).src = DEFAULT_OFFICIAL_LOGO;
                                            }}
                                        />
                                    ) : (
                                        <span className="text-2xl">🐾</span>
                                    )}
                                </div>
                                <div>
                                    <div className="flex items-center gap-1.5">
                                        <span className="text-xs font-bold text-slate-900">Logotipo Oficial Activo</span>
                                        <span className="text-[9.5px] font-bold px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800">Oficial</span>
                                    </div>
                                    <p className="text-[11px] text-slate-500 mt-0.5 max-w-sm">
                                        Alojado en Cloudflare R2 Edge Storage de alta disponibilidad.
                                    </p>
                                    <button
                                        type="button"
                                        onClick={() => setForm(prev => ({ ...prev, logo_url: DEFAULT_OFFICIAL_LOGO }))}
                                        className="mt-2 text-[11px] font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 transition"
                                    >
                                        <RotateCcw className="w-3 h-3" />
                                        <span>Restaurar Logo Oficial R2</span>
                                    </button>
                                </div>
                            </div>

                            <div className="sm:ml-auto w-full sm:w-auto flex flex-col gap-1 text-[11px] text-slate-600 bg-white p-3 rounded-xl border border-slate-200/60 shadow-2xs">
                                <span className="font-bold text-slate-800 flex items-center gap-1">
                                    <ShieldCheck className="w-3.5 h-3.5 text-blue-600" />
                                    <span>Presencia White-Label</span>
                                </span>
                                <span>• Encabezado de Navegación</span>
                                <span>• Carnet Digital & Certificado PDF</span>
                                <span>• Tienda Web de Afiliación de Tutores</span>
                            </div>
                        </div>

                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                            <div className="sm:col-span-2">
                                <label className="block text-xs font-bold text-slate-700 mb-1">
                                    URL del Logotipo (Cloudflare R2 / AWS S3 / URL pública)
                                </label>
                                <input
                                    type="url"
                                    value={form.logo_url}
                                    onChange={(e) => setForm({ ...form, logo_url: e.target.value })}
                                    placeholder="https://pub-...r2.dev/tenants/logos/...webp"
                                    className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden font-mono"
                                />
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">
                                    Lema o Slogan de Atención Clínica
                                </label>
                                <input
                                    type="text"
                                    value={form.tagline}
                                    onChange={(e) => setForm({ ...form, tagline: e.target.value })}
                                    placeholder="Planes de salud para su mascota"
                                    className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden"
                                />
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">
                                    Color Primario de la Marca
                                </label>
                                <div className="flex items-center gap-2">
                                    <input
                                        type="color"
                                        value={form.primary_color || '#0080ff'}
                                        onChange={(e) => setForm({ ...form, primary_color: e.target.value })}
                                        className="w-10 h-9 p-1 rounded-xl border border-slate-200 cursor-pointer bg-white"
                                    />
                                    <input
                                        type="text"
                                        value={form.primary_color || '#0080ff'}
                                        onChange={(e) => setForm({ ...form, primary_color: e.target.value })}
                                        className="w-28 px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 font-mono text-center font-bold"
                                    />
                                    <div className="flex items-center gap-1 ml-auto">
                                        {BRAND_COLOR_PRESETS.map((color) => (
                                            <button
                                                key={color.hex}
                                                type="button"
                                                title={color.label}
                                                onClick={() => setForm({ ...form, primary_color: color.hex })}
                                                className="w-6 h-6 rounded-full border-2 transition hover:scale-110"
                                                style={{ 
                                                    backgroundColor: color.hex,
                                                    borderColor: form.primary_color?.toLowerCase() === color.hex.toLowerCase() ? '#0f172a' : 'transparent' 
                                                }}
                                            />
                                        ))}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Tarjeta 2: Multimedia del Portal & Afiliaciones (Fotos y Video) */}
                    <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-5">
                        <div className="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div className="flex items-center gap-2">
                                <div className="w-8 h-8 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600">
                                    <VideoIcon className="w-4 h-4" />
                                </div>
                                <div>
                                    <h3 className="text-sm font-bold text-slate-900">Multimedia del Portal B2C (Fotos de Sede & Video)</h3>
                                    <p className="text-[11px] text-slate-500">Imágenes de portada, fachada de instalaciones y video institucional en vivo</p>
                                </div>
                            </div>
                            <span className="text-[11px] font-bold px-2 py-0.5 rounded-md bg-purple-50 text-purple-700 border border-purple-100">
                                Storefront B2C
                            </span>
                        </div>

                        {/* Grid de Fotos y Video */}
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                            {/* 1. Foto de Portada / Pacientes */}
                            <div className="bg-slate-50 border border-slate-200/80 rounded-xl p-3.5 space-y-2.5 flex flex-col">
                                <div className="flex items-center justify-between">
                                    <span className="text-xs font-bold text-slate-800">Foto Portada (Hero)</span>
                                    <span className="text-[9px] font-bold px-1.5 py-0.5 rounded bg-blue-100 text-blue-700">16:9</span>
                                </div>

                                <div className="w-full aspect-video rounded-lg overflow-hidden bg-slate-200 border border-slate-300/80 relative">
                                    {form.hero_image_url ? (
                                        <img 
                                            src={form.hero_image_url} 
                                            alt="Hero Portada" 
                                            className="w-full h-full object-cover"
                                            onError={(e) => { (e.target as HTMLImageElement).src = DEFAULT_HERO_IMAGE; }}
                                        />
                                    ) : (
                                        <div className="w-full h-full flex items-center justify-center text-xs text-slate-400">Sin foto</div>
                                    )}
                                </div>

                                <div className="space-y-1 mt-auto">
                                    <label className="block text-[10.5px] font-bold text-slate-600">URL Foto Portada</label>
                                    <input 
                                        type="url"
                                        value={form.hero_image_url}
                                        onChange={(e) => setForm({ ...form, hero_image_url: e.target.value })}
                                        placeholder="https://..."
                                        className="w-full px-2.5 py-1.5 text-[11px] rounded-lg border border-slate-200 bg-white font-mono"
                                    />
                                    <button
                                        type="button"
                                        onClick={() => setForm(prev => ({ ...prev, hero_image_url: DEFAULT_HERO_IMAGE }))}
                                        className="text-[10px] text-blue-600 font-bold hover:underline flex items-center gap-1 pt-0.5"
                                    >
                                        <RotateCcw className="w-2.5 h-2.5" />
                                        <span>Restaurar foto R2</span>
                                    </button>
                                </div>
                            </div>

                            {/* 2. Foto de Instalaciones / Fachada */}
                            <div className="bg-slate-50 border border-slate-200/80 rounded-xl p-3.5 space-y-2.5 flex flex-col">
                                <div className="flex items-center justify-between">
                                    <span className="text-xs font-bold text-slate-800">Foto Instalaciones</span>
                                    <span className="text-[9px] font-bold px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-700">Fachada</span>
                                </div>

                                <div className="w-full aspect-video rounded-lg overflow-hidden bg-slate-200 border border-slate-300/80 relative">
                                    {form.banner_image_url ? (
                                        <img 
                                            src={form.banner_image_url} 
                                            alt="Instalaciones" 
                                            className="w-full h-full object-cover"
                                            onError={(e) => { (e.target as HTMLImageElement).src = DEFAULT_BANNER_IMAGE; }}
                                        />
                                    ) : (
                                        <div className="w-full h-full flex items-center justify-center text-xs text-slate-400">Sin foto</div>
                                    )}
                                </div>

                                <div className="space-y-1 mt-auto">
                                    <label className="block text-[10.5px] font-bold text-slate-600">URL Foto Instalaciones</label>
                                    <input 
                                        type="url"
                                        value={form.banner_image_url}
                                        onChange={(e) => setForm({ ...form, banner_image_url: e.target.value })}
                                        placeholder="https://..."
                                        className="w-full px-2.5 py-1.5 text-[11px] rounded-lg border border-slate-200 bg-white font-mono"
                                    />
                                    <button
                                        type="button"
                                        onClick={() => setForm(prev => ({ ...prev, banner_image_url: DEFAULT_BANNER_IMAGE }))}
                                        className="text-[10px] text-blue-600 font-bold hover:underline flex items-center gap-1 pt-0.5"
                                    >
                                        <RotateCcw className="w-2.5 h-2.5" />
                                        <span>Restaurar foto R2</span>
                                    </button>
                                </div>
                            </div>

                            {/* 3. Video Institucional Vertical 9:16 (Reel / TikTok) */}
                            <div className="bg-slate-50 border border-slate-200/80 rounded-xl p-3.5 space-y-2.5 flex flex-col">
                                <div className="flex items-center justify-between">
                                    <span className="text-xs font-bold text-slate-800 flex items-center gap-1">
                                        <PlayCircle className="w-3.5 h-3.5 text-purple-600" />
                                        <span>Video Reel (9:16)</span>
                                    </span>
                                    <span className="text-[9px] font-bold px-1.5 py-0.5 rounded bg-purple-100 text-purple-700">MP4</span>
                                </div>

                                <div className="w-full aspect-video rounded-lg overflow-hidden bg-slate-900 border border-slate-300/80 relative flex items-center justify-center">
                                    {form.banner_video_url ? (
                                        <video 
                                            src={form.banner_video_url} 
                                            controls 
                                            playsInline 
                                            className="w-full h-full object-cover"
                                            poster={form.banner_image_url}
                                        >
                                            Tu navegador no soporta video.
                                        </video>
                                    ) : (
                                        <div className="text-xs text-slate-400">Sin video</div>
                                    )}
                                </div>

                                <div className="space-y-1 mt-auto">
                                    <label className="block text-[10.5px] font-bold text-slate-600">URL Video MP4 (Reel Vertical)</label>
                                    <input 
                                        type="url"
                                        value={form.banner_video_url}
                                        onChange={(e) => setForm({ ...form, banner_video_url: e.target.value })}
                                        placeholder="https://...mp4"
                                        className="w-full px-2.5 py-1.5 text-[11px] rounded-lg border border-slate-200 bg-white font-mono"
                                    />
                                    <button
                                        type="button"
                                        onClick={() => setForm(prev => ({ ...prev, banner_video_url: DEFAULT_BANNER_VIDEO }))}
                                        className="text-[10px] text-blue-600 font-bold hover:underline flex items-center gap-1 pt-0.5"
                                    >
                                        <RotateCcw className="w-2.5 h-2.5" />
                                        <span>Restaurar video R2</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {/* Textos y Acento del Portal */}
                        <div className="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2 border-t border-slate-100">
                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">Título de Portada B2C</label>
                                <input
                                    type="text"
                                    value={form.hero_title}
                                    onChange={(e) => setForm({ ...form, hero_title: e.target.value })}
                                    className="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800"
                                />
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">Badge de Precio Destacado</label>
                                <input
                                    type="text"
                                    value={form.hero_price_badge}
                                    onChange={(e) => setForm({ ...form, hero_price_badge: e.target.value })}
                                    className="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800"
                                />
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">Color Secundario / Acento</label>
                                <div className="flex items-center gap-2">
                                    <input
                                        type="color"
                                        value={form.secondary_color || '#d437b5'}
                                        onChange={(e) => setForm({ ...form, secondary_color: e.target.value })}
                                        className="w-9 h-8 p-0.5 rounded-lg border border-slate-200 cursor-pointer bg-white"
                                    />
                                    <input
                                        type="text"
                                        value={form.secondary_color || '#d437b5'}
                                        onChange={(e) => setForm({ ...form, secondary_color: e.target.value })}
                                        className="w-24 px-2 py-1.5 text-xs rounded-lg border border-slate-200 bg-slate-50 font-mono font-bold text-center"
                                    />
                                    <div className="flex items-center gap-1 ml-auto">
                                        {ACCENT_COLOR_PRESETS.map((color) => (
                                            <button
                                                key={color.hex}
                                                type="button"
                                                title={color.label}
                                                onClick={() => setForm({ ...form, secondary_color: color.hex })}
                                                className="w-5 h-5 rounded-full border-2 transition hover:scale-110"
                                                style={{ 
                                                    backgroundColor: color.hex,
                                                    borderColor: form.secondary_color?.toLowerCase() === color.hex.toLowerCase() ? '#0f172a' : 'transparent' 
                                                }}
                                            />
                                        ))}
                                    </div>
                                </div>
                            </div>

                            <div className="sm:col-span-3">
                                <label className="block text-xs font-bold text-slate-700 mb-1">Subtítulo Descriptivo de la Membresía</label>
                                <textarea
                                    rows={2}
                                    value={form.hero_subtitle}
                                    onChange={(e) => setForm({ ...form, hero_subtitle: e.target.value })}
                                    className="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 resize-none"
                                />
                            </div>
                        </div>
                    </div>

                    {/* Tarjeta 3: Identidad de la Sede Veterinaria */}
                    <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-4">
                        <div className="flex items-center gap-2 pb-3 border-b border-slate-100">
                            <Building2 className="w-4 h-4 text-blue-600" />
                            <h3 className="text-sm font-bold text-slate-900">Identidad de la Sede Veterinaria</h3>
                        </div>

                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">Nombre Comercial de la Clínica</label>
                                <input
                                    type="text"
                                    value={form.name}
                                    onChange={(e) => setForm({ ...form, name: e.target.value })}
                                    className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden"
                                />
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">Ciudad & Municipio</label>
                                <input
                                    type="text"
                                    value={form.city}
                                    onChange={(e) => setForm({ ...form, city: e.target.value })}
                                    className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden"
                                />
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">Dirección de Atención Física</label>
                                <input
                                    type="text"
                                    value={form.address}
                                    onChange={(e) => setForm({ ...form, address: e.target.value })}
                                    className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden"
                                />
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">WhatsApp de Atención al Cliente</label>
                                <input
                                    type="text"
                                    value={form.phone}
                                    onChange={(e) => setForm({ ...form, phone: e.target.value })}
                                    className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden"
                                />
                            </div>

                            <div className="sm:col-span-2">
                                <label className="block text-xs font-bold text-slate-700 mb-1">Correo Electrónico de Contacto</label>
                                <input
                                    type="email"
                                    value={form.email}
                                    onChange={(e) => setForm({ ...form, email: e.target.value })}
                                    className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden"
                                />
                            </div>
                        </div>
                    </div>

                    {/* Tarjeta 4: Canales de Recaudo */}
                    <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-4">
                        <div className="flex items-center gap-2 pb-3 border-b border-slate-100">
                            <CreditCard className="w-4 h-4 text-emerald-600" />
                            <h3 className="text-sm font-bold text-slate-900">Canales de Recaudo para Afiliaciones de Tutores</h3>
                        </div>

                        <div className="space-y-3">
                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">Número de Transferencia Nequi / Daviplata</label>
                                <input
                                    type="text"
                                    value={form.payment_nequi}
                                    onChange={(e) => setForm({ ...form, payment_nequi: e.target.value })}
                                    placeholder="3508742543"
                                    className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden"
                                />
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">Cuenta Bancaria para Transferencias (Bancolombia, etc.)</label>
                                <input
                                    type="text"
                                    value={form.payment_bank_info}
                                    onChange={(e) => setForm({ ...form, payment_bank_info: e.target.value })}
                                    placeholder="Bancolombia Ahorros # 123-456789-01 (Titular: Clínica Veterinaria)"
                                    className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden"
                                />
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">Enlace de Pago Digital Bold / Wompi (Opcional)</label>
                                <input
                                    type="url"
                                    value={form.payment_bold_link}
                                    onChange={(e) => setForm({ ...form, payment_bold_link: e.target.value })}
                                    placeholder="https://checkout.bold.co/payment/LNK_..."
                                    className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden"
                                />
                            </div>
                        </div>
                    </div>

                    <div className="flex justify-end gap-3 pt-2">
                        <button
                            type="submit"
                            disabled={saving}
                            className="px-6 py-2.5 rounded-xl bg-[#0080ff] hover:bg-blue-600 text-white text-xs font-bold transition shadow-xs flex items-center gap-1.5 disabled:opacity-50"
                        >
                            <Save className="w-4 h-4" />
                            <span>{saving ? 'Guardando en Base de Datos...' : 'Guardar Cambios'}</span>
                        </button>
                    </div>
                </form>
            </div>
        </VetAdminLayout>
    );
}
