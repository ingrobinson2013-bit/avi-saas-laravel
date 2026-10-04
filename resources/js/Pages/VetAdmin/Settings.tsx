import React, { useState, useRef } from 'react';
import { Head, router } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { 
    Building2, 
    CreditCard, 
    Check, 
    Save, 
    Image as ImageIcon, 
    Video as VideoIcon,
    UploadCloud,
    Camera,
    RotateCcw, 
    ExternalLink,
    ShieldCheck,
    PlayCircle,
    Eye,
    FileCheck,
    Sliders,
    QrCode,
    Sparkles,
    CheckCircle2
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
    const [showAdvancedUrls, setShowAdvancedUrls] = useState(false);

    // Refs para selector de archivos
    const logoFileRef = useRef<HTMLInputElement>(null);
    const heroFileRef = useRef<HTMLInputElement>(null);
    const bannerFileRef = useRef<HTMLInputElement>(null);
    const videoFileRef = useRef<HTMLInputElement>(null);

    // Estado del formulario con previsualizaciones
    const [form, setForm] = useState<SettingsData & {
        logo_base64?: string;
        hero_base64?: string;
        banner_base64?: string;
        video_base64?: string;
        logoFileName?: string;
        heroFileName?: string;
        bannerFileName?: string;
        videoFileName?: string;
    }>({
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

    const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>, fieldBase64: string, fieldPreviewUrl: string, nameKey: string) => {
        const file = e.target.files?.[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onloadend = () => {
            const result = reader.result as string;
            setForm(prev => ({
                ...prev,
                [fieldBase64]: result,
                [fieldPreviewUrl]: result,
                [nameKey]: file.name
            }));
        };
        reader.readAsDataURL(file);
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        setSaving(true);

        router.post(`/admin/${tenantSlug}/clinic-settings`, form, {
            preserveScroll: true,
            onSuccess: () => {
                setSaving(false);
                setSaved(true);
                setTimeout(() => setSaved(false), 4500);
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

            {/* Inputs de archivo ocultos que se activan con los botones */}
            <input 
                type="file" 
                ref={logoFileRef} 
                accept="image/png,image/jpeg,image/webp,image/svg+xml" 
                className="hidden" 
                onChange={(e) => handleFileChange(e, 'logo_base64', 'logo_url', 'logoFileName')}
            />
            <input 
                type="file" 
                ref={heroFileRef} 
                accept="image/png,image/jpeg,image/webp" 
                className="hidden" 
                onChange={(e) => handleFileChange(e, 'hero_base64', 'hero_image_url', 'heroFileName')}
            />
            <input 
                type="file" 
                ref={bannerFileRef} 
                accept="image/png,image/jpeg,image/webp" 
                className="hidden" 
                onChange={(e) => handleFileChange(e, 'banner_base64', 'banner_image_url', 'bannerFileName')}
            />
            <input 
                type="file" 
                ref={videoFileRef} 
                accept="video/mp4,video/quicktime,video/webm" 
                className="hidden" 
                onChange={(e) => handleFileChange(e, 'video_base64', 'banner_video_url', 'videoFileName')}
            />

            {/* Layout Fluido que ocupa todo el ancho de pantalla de forma armónica */}
            <div className="w-full space-y-5 pb-20">
                
                {/* Header Banner Superior - Ancho Completo */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-2xs flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <div className="flex items-center gap-2.5">
                            <h1 className="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                                Configuración de Sede, Marca Blanca & Multimedia
                            </h1>
                            <span className="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Sede Activa
                            </span>
                        </div>
                        <p className="text-xs text-slate-500 mt-1 max-w-2xl">
                            Administra la identidad corporativa, logotipo oficial, fotos de portada y fachada, video institucional 9:16 y canales de recaudo para auto-afiliación.
                        </p>
                    </div>

                    <div className="flex flex-wrap items-center gap-2 shrink-0">
                        <a
                            href={`/v/${tenantSlug}`}
                            target="_blank"
                            rel="noopener noreferrer"
                            className="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5"
                        >
                            <Eye className="w-4 h-4 text-slate-500" />
                            <span>Ver Tienda B2C</span>
                            <ExternalLink className="w-3 h-3 text-slate-400" />
                        </a>
                        <a
                            href={`/v/${tenantSlug}/afiche`}
                            target="_blank"
                            rel="noopener noreferrer"
                            className="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5"
                        >
                            <QrCode className="w-4 h-4 text-slate-500" />
                            <span>Afiche QR</span>
                        </a>
                        <button
                            type="button"
                            onClick={() => setShowAdvancedUrls(!showAdvancedUrls)}
                            className="px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold transition flex items-center gap-1.5"
                        >
                            <Sliders className="w-3.5 h-3.5 text-slate-500" />
                            <span>{showAdvancedUrls ? 'Ocultar URLs' : 'URLs Cloud'}</span>
                        </button>
                    </div>
                </div>

                {saved && (
                    <div className="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2.5 shadow-2xs animate-fadeIn">
                        <Check className="w-4 h-4 text-emerald-600 shrink-0" />
                        <span>¡Todos los cambios de logotipo, fotos, videos y medios de pago se guardaron exitosamente en la base de datos!</span>
                    </div>
                )}

                {/* FORMULARIO EN GRID DE 12 COLUMNAS (Aprovecha 100% de la pantalla) */}
                <form onSubmit={handleSubmit}>
                    <div className="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
                        
                        {/* COLUMNA IZQUIERDA (7 columnas en LG, 8 en XL): Marca Blanca & Multimedia */}
                        <div className="lg:col-span-7 xl:col-span-8 space-y-5">
                            
                            {/* Tarjeta 1: Logotipo Oficial & Marca Blanca */}
                            <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-4">
                                <div className="flex items-center justify-between pb-3 border-b border-slate-100">
                                    <div className="flex items-center gap-2.5">
                                        <div className="w-8 h-8 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                                            <ImageIcon className="w-4 h-4" />
                                        </div>
                                        <div>
                                            <h3 className="text-sm font-bold text-slate-900">1. Logotipo Oficial de la Clínica (Marca Blanca)</h3>
                                            <p className="text-[11px] text-slate-500">Visible en la barra lateral, carnets digitales, certificados y tienda web</p>
                                        </div>
                                    </div>
                                    <span className="text-[11px] font-bold px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 border border-blue-100">
                                        White-Label
                                    </span>
                                </div>

                                {/* Caja del Logo con Botones de Acción */}
                                <div className="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                                    <div className="w-24 h-24 rounded-2xl bg-white border-2 border-slate-200 shadow-xs p-2 flex items-center justify-center shrink-0 overflow-hidden relative">
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
                                            <span className="text-3xl">🐾</span>
                                        )}
                                    </div>

                                    <div className="flex-1 space-y-2">
                                        <div className="flex items-center gap-2">
                                            <span className="text-xs font-bold text-slate-900">Logotipo en Uso</span>
                                            {form.logoFileName ? (
                                                <span className="text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 flex items-center gap-1">
                                                    <FileCheck className="w-3 h-3" />
                                                    <span>Nuevo archivo: {form.logoFileName}</span>
                                                </span>
                                            ) : (
                                                <span className="text-[9.5px] font-bold px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800">Oficial Cloudflare R2</span>
                                            )}
                                        </div>
                                        <p className="text-[11px] text-slate-500">
                                            Formatos recomendados: PNG o WEBP con fondo transparente (mínimo 300x300 px).
                                        </p>

                                        <div className="flex flex-wrap items-center gap-2 pt-1">
                                            <button
                                                type="button"
                                                onClick={() => logoFileRef.current?.click()}
                                                className="px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-2xs cursor-pointer"
                                            >
                                                <UploadCloud className="w-4 h-4" />
                                                <span>Subir / Cambiar Logo desde mi PC o Celular</span>
                                            </button>

                                            <button
                                                type="button"
                                                onClick={() => {
                                                    setForm(prev => ({
                                                        ...prev,
                                                        logo_url: DEFAULT_OFFICIAL_LOGO,
                                                        logo_base64: undefined,
                                                        logoFileName: undefined
                                                    }));
                                                }}
                                                className="px-3 py-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 text-xs font-semibold transition flex items-center gap-1"
                                            >
                                                <RotateCcw className="w-3.5 h-3.5 text-slate-500" />
                                                <span>Restaurar Logo Oficial R2</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div className="space-y-4 pt-1">
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

                                    {/* Combinación de 2 Colores de la Marca */}
                                    <div className="p-4 rounded-xl bg-slate-50/80 border border-slate-200/90 space-y-4">
                                        <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-2 border-b border-slate-200/80">
                                            <div>
                                                <h4 className="text-xs font-black text-slate-900 flex items-center gap-1.5">
                                                    <span>🎨</span>
                                                    <span>Paleta de la Plantilla: Combinación de 2 Colores de Marca</span>
                                                </h4>
                                                <p className="text-[11px] text-slate-500 mt-0.5">
                                                    Personaliza los 2 tonos clave con los que se diseñan tu portal web, botones y el carnet digital de tus pacientes.
                                                </p>
                                            </div>

                                            <button
                                                type="button"
                                                onClick={() => {
                                                    const temp = form.primary_color;
                                                    setForm({
                                                        ...form,
                                                        primary_color: form.secondary_color || '#d437b5',
                                                        secondary_color: temp || '#0080ff'
                                                    });
                                                }}
                                                className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 text-xs font-bold transition shadow-2xs self-start sm:self-auto cursor-pointer"
                                                title="Invertir color primario y secundario"
                                            >
                                                <span>🔄</span>
                                                <span>Invertir Colores</span>
                                            </button>
                                        </div>

                                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            {/* Color Primario */}
                                            <div className="p-3 bg-white rounded-xl border border-slate-200 space-y-2">
                                                <div className="flex items-center justify-between">
                                                    <label className="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                                        <span className="w-2.5 h-2.5 rounded-full" style={{ backgroundColor: form.primary_color || '#0080ff' }} />
                                                        <span>Color 1: Primario de la Marca</span>
                                                    </label>
                                                    <span className="text-[10px] font-bold text-slate-400">Botones, Headers & Links</span>
                                                </div>
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
                                                        className="w-24 px-2.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 font-mono text-center font-bold"
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

                                            {/* Color Secundario / Acento */}
                                            <div className="p-3 bg-white rounded-xl border border-slate-200 space-y-2">
                                                <div className="flex items-center justify-between">
                                                    <label className="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                                        <span className="w-2.5 h-2.5 rounded-full" style={{ backgroundColor: form.secondary_color || '#d437b5' }} />
                                                        <span>Color 2: Secundario / Acento</span>
                                                    </label>
                                                    <span className="text-[10px] font-bold text-slate-400">Degradados, Carnet & Badges</span>
                                                </div>
                                                <div className="flex items-center gap-2">
                                                    <input
                                                        type="color"
                                                        value={form.secondary_color || '#d437b5'}
                                                        onChange={(e) => setForm({ ...form, secondary_color: e.target.value })}
                                                        className="w-10 h-9 p-1 rounded-xl border border-slate-200 cursor-pointer bg-white"
                                                    />
                                                    <input
                                                        type="text"
                                                        value={form.secondary_color || '#d437b5'}
                                                        onChange={(e) => setForm({ ...form, secondary_color: e.target.value })}
                                                        className="w-24 px-2.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 font-mono text-center font-bold"
                                                    />
                                                    <div className="flex items-center gap-1 ml-auto">
                                                        {ACCENT_COLOR_PRESETS.map((color) => (
                                                            <button
                                                                key={color.hex}
                                                                type="button"
                                                                title={color.label}
                                                                onClick={() => setForm({ ...form, secondary_color: color.hex })}
                                                                className="w-6 h-6 rounded-full border-2 transition hover:scale-110"
                                                                style={{ 
                                                                    backgroundColor: color.hex,
                                                                    borderColor: form.secondary_color?.toLowerCase() === color.hex.toLowerCase() ? '#0f172a' : 'transparent' 
                                                                }}
                                                            />
                                                        ))}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {/* Previsualizador en Vivo de la Combinación */}
                                        <div className="p-3.5 rounded-xl bg-white border border-slate-200/90 flex flex-col sm:flex-row items-center justify-between gap-3 shadow-2xs">
                                            <div className="flex items-center gap-3">
                                                {/* Mini Carnet Muestra */}
                                                <div 
                                                    className="w-28 h-16 rounded-xl p-2 text-white shadow-xs flex flex-col justify-between relative overflow-hidden shrink-0 border border-white/20 select-none transition-all duration-300"
                                                    style={{ background: `linear-gradient(135deg, ${form.primary_color || '#0080ff'} 0%, ${form.secondary_color || '#d437b5'} 100%)` }}
                                                >
                                                    <div className="flex items-center justify-between text-[8px] font-black tracking-wider opacity-90">
                                                        <span>CARNET 🐾</span>
                                                        <span>ACTIVO</span>
                                                    </div>
                                                    <div>
                                                        <div className="text-[10px] font-black leading-none truncate">Max Pelusa</div>
                                                        <div className="text-[7.5px] opacity-80 mt-0.5">Plan Patitas VIP</div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <span className="text-xs font-black text-slate-900 block">
                                                        Previsualización en Vivo de la Combinación
                                                    </span>
                                                    <span className="text-[11px] text-slate-500 block">
                                                        Así se fusionan el Color 1 y Color 2 en el Carnet Digital y cabecera de la plantilla.
                                                    </span>
                                                </div>
                                            </div>

                                            {/* Muestra de Botón con la combinación */}
                                            <div className="flex items-center gap-2 shrink-0">
                                                <button
                                                    type="button"
                                                    className="px-4 py-2 rounded-xl text-white text-xs font-bold shadow-xs transition hover:brightness-110"
                                                    style={{ backgroundColor: form.primary_color || '#0080ff' }}
                                                >
                                                    Botón Principal
                                                </button>
                                                <span 
                                                    className="px-2.5 py-1 rounded-lg text-[10.5px] font-bold border"
                                                    style={{ 
                                                        color: form.secondary_color || '#d437b5', 
                                                        borderColor: `${form.secondary_color || '#d437b5'}40`,
                                                        backgroundColor: `${form.secondary_color || '#d437b5'}12` 
                                                    }}
                                                >
                                                    Badge Acento
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    {showAdvancedUrls && (
                                        <div className="sm:col-span-2 pt-2 border-t border-slate-100">
                                            <label className="block text-[11px] font-bold text-slate-600 mb-1">
                                                URL Manual del Logotipo (Cloudflare / S3)
                                            </label>
                                            <input
                                                type="url"
                                                value={form.logo_url}
                                                onChange={(e) => setForm({ ...form, logo_url: e.target.value })}
                                                placeholder="https://pub-...r2.dev/tenants/logos/...webp"
                                                className="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-200 bg-white text-slate-700 font-mono"
                                            />
                                        </div>
                                    )}
                                </div>
                            </div>

                            {/* Tarjeta 2: Multimedia del Portal B2C (Fotos de Sede & Video 9:16) */}
                            <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-5">
                                <div className="flex items-center justify-between pb-3 border-b border-slate-100">
                                    <div className="flex items-center gap-2.5">
                                        <div className="w-8 h-8 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600">
                                            <VideoIcon className="w-4 h-4" />
                                        </div>
                                        <div>
                                            <h3 className="text-sm font-bold text-slate-900">2. Fotos de la Clínica y Video Institucional (9:16)</h3>
                                            <p className="text-[11px] text-slate-500">Sube fotos reales de tus pacientes, consultorio y un video corto para la tienda web</p>
                                        </div>
                                    </div>
                                    <span className="text-[11px] font-bold px-2 py-0.5 rounded-md bg-purple-50 text-purple-700 border border-purple-100">
                                        Tienda B2C
                                    </span>
                                </div>

                                {/* 3 Columnas Amplias para los 3 Contenidos */}
                                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    {/* 1. Foto Portada (Hero) */}
                                    <div className="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 flex flex-col space-y-3">
                                        <div className="flex items-center justify-between">
                                            <span className="text-xs font-bold text-slate-900">Foto de Portada</span>
                                            <span className="text-[9.5px] font-bold px-1.5 py-0.5 rounded bg-blue-100 text-blue-700">Hero 16:9</span>
                                        </div>

                                        <div className="w-full aspect-video rounded-xl overflow-hidden bg-slate-200 border border-slate-300 relative group">
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

                                        {form.heroFileName && (
                                            <p className="text-[10.5px] font-bold text-amber-700 truncate">
                                                📁 Listo: {form.heroFileName}
                                            </p>
                                        )}

                                        <div className="space-y-1.5 mt-auto pt-1">
                                            <button
                                                type="button"
                                                onClick={() => heroFileRef.current?.click()}
                                                className="w-full py-2 px-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-2xs cursor-pointer"
                                            >
                                                <Camera className="w-3.5 h-3.5" />
                                                <span>Cambiar Foto Portada</span>
                                            </button>

                                            <button
                                                type="button"
                                                onClick={() => setForm(prev => ({ 
                                                    ...prev, 
                                                    hero_image_url: DEFAULT_HERO_IMAGE, 
                                                    hero_base64: undefined,
                                                    heroFileName: undefined 
                                                }))}
                                                className="w-full py-1 text-[11px] text-slate-500 hover:text-slate-800 font-medium text-center"
                                            >
                                                Restaurar foto R2
                                            </button>
                                        </div>

                                        {showAdvancedUrls && (
                                            <div className="pt-2 border-t border-slate-200/80">
                                                <label className="block text-[10px] font-bold text-slate-600 mb-0.5">URL Foto Portada</label>
                                                <input
                                                    type="url"
                                                    value={form.hero_image_url}
                                                    onChange={(e) => setForm({ ...form, hero_image_url: e.target.value })}
                                                    className="w-full px-2 py-1 text-[11px] rounded border border-slate-200 bg-white font-mono"
                                                />
                                            </div>
                                        )}
                                    </div>

                                    {/* 2. Foto Instalaciones / Fachada */}
                                    <div className="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 flex flex-col space-y-3">
                                        <div className="flex items-center justify-between">
                                            <span className="text-xs font-bold text-slate-900">Foto Instalaciones</span>
                                            <span className="text-[9.5px] font-bold px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-700">Fachada</span>
                                        </div>

                                        <div className="w-full aspect-video rounded-xl overflow-hidden bg-slate-200 border border-slate-300 relative group">
                                            {form.banner_image_url ? (
                                                <img 
                                                    src={form.banner_image_url} 
                                                    alt="Fachada" 
                                                    className="w-full h-full object-cover"
                                                    onError={(e) => { (e.target as HTMLImageElement).src = DEFAULT_BANNER_IMAGE; }}
                                                />
                                            ) : (
                                                <div className="w-full h-full flex items-center justify-center text-xs text-slate-400">Sin foto</div>
                                            )}
                                        </div>

                                        {form.bannerFileName && (
                                            <p className="text-[10.5px] font-bold text-amber-700 truncate">
                                                📁 Listo: {form.bannerFileName}
                                            </p>
                                        )}

                                        <div className="space-y-1.5 mt-auto pt-1">
                                            <button
                                                type="button"
                                                onClick={() => bannerFileRef.current?.click()}
                                                className="w-full py-2 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-2xs cursor-pointer"
                                            >
                                                <UploadCloud className="w-3.5 h-3.5" />
                                                <span>Cambiar Foto Fachada</span>
                                            </button>

                                            <button
                                                type="button"
                                                onClick={() => setForm(prev => ({ 
                                                    ...prev, 
                                                    banner_image_url: DEFAULT_BANNER_IMAGE, 
                                                    banner_base64: undefined,
                                                    bannerFileName: undefined 
                                                }))}
                                                className="w-full py-1 text-[11px] text-slate-500 hover:text-slate-800 font-medium text-center"
                                            >
                                                Restaurar foto R2
                                            </button>
                                        </div>

                                        {showAdvancedUrls && (
                                            <div className="pt-2 border-t border-slate-200/80">
                                                <label className="block text-[10px] font-bold text-slate-600 mb-0.5">URL Foto Fachada</label>
                                                <input
                                                    type="url"
                                                    value={form.banner_image_url}
                                                    onChange={(e) => setForm({ ...form, banner_image_url: e.target.value })}
                                                    className="w-full px-2 py-1 text-[11px] rounded border border-slate-200 bg-white font-mono"
                                                />
                                            </div>
                                        )}
                                    </div>

                                    {/* 3. Video Institucional 9:16 */}
                                    <div className="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 flex flex-col space-y-3">
                                        <div className="flex items-center justify-between">
                                            <span className="text-xs font-bold text-slate-900 flex items-center gap-1">
                                                <PlayCircle className="w-3.5 h-3.5 text-purple-600" />
                                                <span>Video Reel (9:16)</span>
                                            </span>
                                            <span className="text-[9.5px] font-bold px-1.5 py-0.5 rounded bg-purple-100 text-purple-700">Vertical MP4</span>
                                        </div>

                                        <div className="w-full aspect-video rounded-xl overflow-hidden bg-slate-900 border border-slate-300 relative flex items-center justify-center">
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

                                        {form.videoFileName && (
                                            <p className="text-[10.5px] font-bold text-amber-700 truncate">
                                                🎥 Listo: {form.videoFileName}
                                            </p>
                                        )}

                                        <div className="space-y-1.5 mt-auto pt-1">
                                            <button
                                                type="button"
                                                onClick={() => videoFileRef.current?.click()}
                                                className="w-full py-2 px-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-2xs cursor-pointer"
                                            >
                                                <PlayCircle className="w-3.5 h-3.5" />
                                                <span>Subir / Cambiar Video MP4</span>
                                            </button>

                                            <button
                                                type="button"
                                                onClick={() => setForm(prev => ({ 
                                                    ...prev, 
                                                    banner_video_url: DEFAULT_BANNER_VIDEO, 
                                                    video_base64: undefined,
                                                    videoFileName: undefined 
                                                }))}
                                                className="w-full py-1 text-[11px] text-slate-500 hover:text-slate-800 font-medium text-center"
                                            >
                                                Restaurar video R2
                                            </button>
                                        </div>

                                        {showAdvancedUrls && (
                                            <div className="pt-2 border-t border-slate-200/80">
                                                <label className="block text-[10px] font-bold text-slate-600 mb-0.5">URL Video MP4</label>
                                                <input
                                                    type="url"
                                                    value={form.banner_video_url}
                                                    onChange={(e) => setForm({ ...form, banner_video_url: e.target.value })}
                                                    className="w-full px-2 py-1 text-[11px] rounded border border-slate-200 bg-white font-mono"
                                                />
                                            </div>
                                        )}
                                    </div>
                                </div>

                                {/* Textos y Acento del Portal */}
                                <div className="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-3 border-t border-slate-100">
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
                                        <label className="block text-xs font-bold text-slate-700 mb-1">Paleta Sincronizada B2C</label>
                                        <div className="flex items-center gap-2 p-2 rounded-xl bg-slate-50 border border-slate-200 h-[38px]">
                                            <span className="w-5 h-5 rounded-full shrink-0 border border-slate-300 shadow-2xs" style={{ backgroundColor: form.primary_color || '#0080ff' }} title="Color Primario" />
                                            <span className="w-5 h-5 rounded-full shrink-0 border border-slate-300 shadow-2xs" style={{ backgroundColor: form.secondary_color || '#d437b5' }} title="Color Secundario / Acento" />
                                            <span className="text-[11px] font-bold text-slate-600 truncate">
                                                2 Colores activos (Bloque 1)
                                            </span>
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
                        </div>

                        {/* COLUMNA DERECHA (5 columnas en LG, 4 en XL): Datos Sede & Medios de Pago */}
                        <div className="lg:col-span-5 xl:col-span-4 space-y-5">
                            
                            {/* Tarjeta 3: Identidad de la Sede Veterinaria */}
                            <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-4">
                                <div className="flex items-center gap-2 pb-3 border-b border-slate-100">
                                    <Building2 className="w-4 h-4 text-blue-600" />
                                    <h3 className="text-sm font-bold text-slate-900">3. Datos de la Sede Clínica</h3>
                                </div>

                                <div className="space-y-3">
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
                                        <label className="block text-xs font-bold text-slate-700 mb-1">Dirección Física de Atención</label>
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

                                    <div>
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
                                    <h3 className="text-sm font-bold text-slate-900">4. Canales de Recaudo (Tutores)</h3>
                                </div>

                                <div className="space-y-3">
                                    <div>
                                        <label className="block text-xs font-bold text-slate-700 mb-1">Nequi / Daviplata</label>
                                        <input
                                            type="text"
                                            value={form.payment_nequi}
                                            onChange={(e) => setForm({ ...form, payment_nequi: e.target.value })}
                                            placeholder="3508742543"
                                            className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden"
                                        />
                                    </div>

                                    <div>
                                        <label className="block text-xs font-bold text-slate-700 mb-1">Cuenta Bancaria para Transferencias</label>
                                        <input
                                            type="text"
                                            value={form.payment_bank_info}
                                            onChange={(e) => setForm({ ...form, payment_bank_info: e.target.value })}
                                            placeholder="Bancolombia Ahorros # 123-456789-01"
                                            className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-hidden"
                                        />
                                    </div>

                                    <div>
                                        <label className="block text-xs font-bold text-slate-700 mb-1">Enlace Bold / Wompi (Opcional)</label>
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

                            {/* Botón Guardar - Destacado en Columna Derecha */}
                            <div className="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-5 text-white shadow-md space-y-3">
                                <div className="flex items-center gap-2">
                                    <Sparkles className="w-4 h-4 text-cyan-400" />
                                    <span className="text-xs font-bold">Publicación Inmediata</span>
                                </div>
                                <p className="text-[11.5px] text-slate-300">
                                    Al guardar, las fotos, videos, logotipo y colores se actualizan al instante en el portal de tutores y en la barra lateral.
                                </p>
                                <button
                                    type="submit"
                                    disabled={saving}
                                    className="w-full py-3 px-4 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold transition shadow-sm flex items-center justify-center gap-2 disabled:opacity-50 cursor-pointer"
                                >
                                    <Save className="w-4 h-4" />
                                    <span>{saving ? 'Guardando en Base de Datos...' : 'Guardar Todos los Cambios'}</span>
                                </button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </VetAdminLayout>
    );
}
