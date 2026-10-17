import React, { useState, useEffect } from 'react';
import { Head, router } from '@inertiajs/react';
import SuperAdminLayout from '@/Layouts/SuperAdminLayout';
import { 
    TrendingUp, 
    Search, 
    Plus, 
    Mail, 
    Phone, 
    MessageCircle, 
    MapPin, 
    Eye, 
    Send, 
    CheckCircle2, 
    Clock, 
    AlertTriangle, 
    Building2, 
    X,
    ChevronLeft,
    ChevronRight,
    Copy,
    Check,
    Filter,
    Loader2,
    Sparkles,
    Compass,
    UploadCloud
} from 'lucide-react';

interface ProspectoItem {
    id: number;
    razon_social: string;
    correo_comercial: string;
    telefono: string | null;
    departamento: string;
    municipio: string;
    direccion: string | null;
    tipo: string;
    estado: string;
    intentos_envio: number;
    ultimo_envio_at: string | null;
    abierto_at: string | null;
    aperturas_count: number;
    fuente: string;
    wa_link: string | null;
}

interface ProspectosProps {
    prospectos: {
        data: ProspectoItem[];
        current_page: number;
        last_page: number;
        total: number;
        prev_page_url: string | null;
        next_page_url: string | null;
    };
    filters: {
        search: string;
        estado: string;
        municipio: string;
    };
    stats: {
        total: number;
        pendientes: number;
        enviados: number;
        abiertos: number;
        conTelefono: number;
    };
    municipiosList: string[];
    userName?: string;
    userEmail?: string;
    initialCampaign?: CampaignProgress;
    initialScan?: ScanProgress;
}

export interface CampaignProgress {
    status: 'idle' | 'running' | 'completed' | 'error';
    total: number;
    enviados: number;
    fallidos: number;
    current_lead?: string | null;
    percent: number;
    started_at?: string;
    finished_at?: string;
}

export interface ScanProgress {
    status: 'idle' | 'running' | 'completed' | 'error';
    total: number;
    encontrados: number;
    percent: number;
    region?: string | null;
    current_step?: string | null;
    started_at?: string;
    finished_at?: string;
}

export default function Prospectos({
    prospectos,
    filters,
    stats,
    municipiosList = [],
    userName = 'Robinson Naranjo',
    userEmail = 'superadmin@avipetapp.com',
    initialCampaign,
    initialScan
}: ProspectosProps) {
    const [searchTerm, setSearchTerm] = useState(filters.search || '');
    const [selectedEstado, setSelectedEstado] = useState(filters.estado || 'all');
    const [selectedMunicipio, setSelectedMunicipio] = useState(filters.municipio || 'all');
    const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
    const [statusModalProspecto, setStatusModalProspecto] = useState<ProspectoItem | null>(null);
    const [copiedEmail, setCopiedEmail] = useState<string | null>(null);
    const [sendingEmailId, setSendingEmailId] = useState<number | null>(null);

    // Live Campaign Banner & Polling State
    const [campaign, setCampaign] = useState<CampaignProgress | null>(
        initialCampaign && (initialCampaign.status === 'running' || initialCampaign.status === 'completed') ? initialCampaign : null
    );

    // Live Scan Banner & Polling State
    const [scanProgress, setScanProgress] = useState<ScanProgress | null>(
        initialScan && (initialScan.status === 'running' || initialScan.status === 'completed') ? initialScan : null
    );

    // Polling effect: queries server every 2 seconds while campaign is running
    useEffect(() => {
        if (!campaign || campaign.status !== 'running') return;

        const interval = setInterval(async () => {
            try {
                const res = await fetch('/super-admin/prospecto-veterinarias/campaign-status');
                if (res.ok) {
                    const data: CampaignProgress = await res.json();
                    setCampaign(data);

                    if (data.status === 'completed') {
                        router.reload({ only: ['prospectos', 'stats'] });
                    }
                }
            } catch (err) {
                console.error("Error consultando estado de campaña:", err);
            }
        }, 2000);

        return () => clearInterval(interval);
    }, [campaign?.status]);

    // Polling effect: queries server every 1.5 seconds while lead scan is running
    useEffect(() => {
        if (!scanProgress || scanProgress.status !== 'running') return;

        const interval = setInterval(async () => {
            try {
                const res = await fetch('/super-admin/prospecto-veterinarias/scan-status');
                if (res.ok) {
                    const data: ScanProgress = await res.json();
                    setScanProgress(data);

                    if (data.status === 'completed' || data.status === 'error') {
                        router.reload({ only: ['prospectos', 'stats'] });
                    }
                }
            } catch (err) {
                console.error("Error consultando estado de escaneo:", err);
            }
        }, 1500);

        return () => clearInterval(interval);
    }, [scanProgress?.status]);

    // Batch Campaign State
    const [isBatchModalOpen, setIsBatchModalOpen] = useState(false);
    const [batchLimit, setBatchLimit] = useState(50);
    const [isDispatchingBatch, setIsDispatchingBatch] = useState(false);

    // Live Web Scraper State
    const [isScanModalOpen, setIsScanModalOpen] = useState(false);
    const [scanRegion, setScanRegion] = useState('todo_el_pais');
    const [scanLimit, setScanLimit] = useState(50);
    const [isScanning, setIsScanning] = useState(false);

    // CSV Import State
    const [isImportModalOpen, setIsImportModalOpen] = useState(false);
    const [csvData, setCsvData] = useState('');
    const [isImporting, setIsImporting] = useState(false);

    const [newProspecto, setNewProspecto] = useState({
        razon_social: '',
        correo_comercial: '',
        telefono: '',
        municipio: 'Bogotá D.C.',
        departamento: 'Cundinamarca',
        tipo: 'Clínica Veterinaria',
        direccion: ''
    });

    const handleDispatchBatch = () => {
        setIsDispatchingBatch(true);
        // Desplegar de inmediato el banner de progreso visual reactivo
        setCampaign({
            status: 'running',
            total: batchLimit,
            enviados: 0,
            fallidos: 0,
            current_lead: 'Iniciando conexión con Resend SMTP...',
            percent: 2,
        });
        setIsBatchModalOpen(false);

        router.post('/super-admin/prospecto-veterinarias/dispatch-batch', { limit: batchLimit }, {
            onFinish: () => {
                setIsDispatchingBatch(false);
            },
            onError: () => {
                setCampaign(null);
            }
        });
    };

    const handleScanRegion = () => {
        setIsScanning(true);
        // Desplegar de inmediato el banner de progreso reactivo de escaneo
        setScanProgress({
            status: 'running',
            total: scanLimit,
            encontrados: 0,
            percent: 10,
            region: scanRegion,
            current_step: 'Iniciando rastreador inteligente en Colombia...',
        });
        setIsScanModalOpen(false);

        router.post('/super-admin/prospecto-veterinarias/scan-region', { region: scanRegion, limit: scanLimit }, {
            onFinish: () => {
                setIsScanning(false);
            },
            onError: () => {
                setScanProgress(null);
            }
        });
    };

    const handleImportCsv = (e: React.FormEvent) => {
        e.preventDefault();
        setIsImporting(true);
        router.post('/super-admin/prospecto-veterinarias/import-csv', { csv_data: csvData }, {
            onFinish: () => {
                setIsImporting(false);
                setIsImportModalOpen(false);
                setCsvData('');
            }
        });
    };

    const handleSearch = (e: React.FormEvent) => {
        e.preventDefault();
        router.get('/super-admin/prospecto-veterinarias', {
            search: searchTerm,
            estado: selectedEstado,
            municipio: selectedMunicipio
        }, { preserveState: true });
    };

    const handleFilterEstado = (estado: string) => {
        setSelectedEstado(estado);
        router.get('/super-admin/prospecto-veterinarias', {
            search: searchTerm,
            estado,
            municipio: selectedMunicipio
        }, { preserveState: true });
    };

    const handleFilterMunicipio = (municipio: string) => {
        setSelectedMunicipio(municipio);
        router.get('/super-admin/prospecto-veterinarias', {
            search: searchTerm,
            estado: selectedEstado,
            municipio
        }, { preserveState: true });
    };

    const handleCopyEmail = (email: string) => {
        navigator.clipboard.writeText(email);
        setCopiedEmail(email);
        setTimeout(() => setCopiedEmail(null), 2000);
    };

    const handleSendOutreach = (id: number) => {
        setSendingEmailId(id);
        router.post(`/super-admin/prospecto-veterinarias/${id}/send-outreach`, {}, {
            onFinish: () => setSendingEmailId(null)
        });
    };

    const handleUpdateStatus = (id: number, estado: string) => {
        router.post(`/super-admin/prospecto-veterinarias/${id}/update-estado`, { estado }, {
            onSuccess: () => setStatusModalProspecto(null)
        });
    };

    const handleCreateSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        router.post('/super-admin/prospecto-veterinarias', newProspecto, {
            onSuccess: () => {
                setIsCreateModalOpen(false);
                setNewProspecto({
                    razon_social: '',
                    correo_comercial: '',
                    telefono: '',
                    municipio: 'Bogotá D.C.',
                    departamento: 'Cundinamarca',
                    tipo: 'Clínica Veterinaria',
                    direccion: ''
                });
            }
        });
    };

    const getEstadoBadge = (item: ProspectoItem) => {
        if (item.aperturas_count > 0) {
            return (
                <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                    <Eye className="w-3.5 h-3.5 text-indigo-600" />
                    Abierto ({item.aperturas_count})
                </span>
            );
        }

        switch (item.estado) {
            case 'enviado':
                return (
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <CheckCircle2 className="w-3.5 h-3.5 text-emerald-600" />
                        Enviado
                    </span>
                );
            case 'pendiente':
                return (
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                        <Clock className="w-3.5 h-3.5 text-amber-600" />
                        Pendiente
                    </span>
                );
            case 'respondido':
                return (
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-teal-50 text-teal-700 border border-teal-200">
                        <MessageCircle className="w-3.5 h-3.5 text-teal-600" />
                        Respondido
                    </span>
                );
            case 'error':
                return (
                    <span 
                        title={item.error_mensaje || 'Correo o dominio sin servidores de correo'}
                        className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200"
                    >
                        <AlertTriangle className="w-3.5 h-3.5 text-rose-600" />
                        Correo Inválido
                    </span>
                );
            default:
                return (
                    <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                        {item.estado}
                    </span>
                );
        }
    };

    return (
        <SuperAdminLayout
            userName={userName}
            userEmail={userEmail}
            activeItem="Prospección B2B"
        >
            <Head title="Prospección B2B & Campañas - SuperAdmin" />

            <div className="space-y-6 max-w-full">
                {/* HEADER */}
                <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 className="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                            <TrendingUp className="w-7 h-7 text-teal-600" />
                            Prospección B2B & Campañas Comerciales
                        </h1>
                        <p className="text-sm text-slate-500 mt-1">
                            Directorio calificado de veterinarias en Colombia, captación por WhatsApp y seguimiento de aperturas de correo.
                        </p>
                    </div>

                    <div className="flex flex-wrap items-center gap-2 self-start sm:self-auto">
                        <button
                            type="button"
                            onClick={() => setIsBatchModalOpen(true)}
                            disabled={isDispatchingBatch || (campaign?.status === 'running')}
                            className="inline-flex items-center justify-center gap-2 px-3.5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-bold text-xs sm:text-sm shadow-sm transition-all shadow-indigo-600/20 hover:shadow-indigo-600/30 cursor-pointer disabled:opacity-50"
                        >
                            {campaign?.status === 'running' ? (
                                <>
                                    <Loader2 className="w-4 h-4 animate-spin" />
                                    <span>Enviando ({campaign.enviados}/{campaign.total})...</span>
                                </>
                            ) : (
                                <>
                                    <Send className="w-4 h-4" />
                                    <span>Despachar Campaña (50)</span>
                                </>
                            )}
                        </button>

                        <button
                            type="button"
                            onClick={() => setIsScanModalOpen(true)}
                            disabled={isScanning || (scanProgress?.status === 'running')}
                            className="inline-flex items-center justify-center gap-2 px-3.5 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white font-bold text-xs sm:text-sm shadow-sm transition-all shadow-teal-600/20 hover:shadow-teal-600/30 cursor-pointer disabled:opacity-50"
                        >
                            {scanProgress?.status === 'running' ? (
                                <>
                                    <Loader2 className="w-4 h-4 animate-spin" />
                                    <span>Escaneando ({scanProgress.encontrados}/{scanProgress.total})...</span>
                                </>
                            ) : (
                                <>
                                    <Search className="w-4 h-4" />
                                    <span>Escanear Nuevas (50+)</span>
                                </>
                            )}
                        </button>

                        <button
                            type="button"
                            onClick={() => setIsImportModalOpen(true)}
                            className="inline-flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold text-xs sm:text-sm shadow-2xs transition-all cursor-pointer"
                        >
                            <UploadCloud className="w-4 h-4 text-slate-500" />
                            <span>Importar CSV</span>
                        </button>

                        <button
                            type="button"
                            onClick={() => setIsCreateModalOpen(true)}
                            className="inline-flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 active:bg-slate-950 text-white font-bold text-xs sm:text-sm shadow-sm transition-all cursor-pointer"
                        >
                            <Plus className="w-4 h-4" />
                            <span>Nuevo</span>
                        </button>
                    </div>
                </div>

                {/* LIVE CAMPAIGN DISPATCH PROGRESS BANNER */}
                {campaign && campaign.status === 'running' && (
                    <div className="relative overflow-hidden bg-gradient-to-r from-indigo-900 via-indigo-800 to-teal-900 rounded-2xl p-5 text-white shadow-xl border border-indigo-500/40 animate-in fade-in slide-in-from-top-4 duration-300">
                        <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div className="flex items-start sm:items-center gap-3.5">
                                <div className="w-11 h-11 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center shrink-0">
                                    <Loader2 className="w-6 h-6 animate-spin text-teal-300" />
                                </div>
                                <div>
                                    <div className="flex items-center gap-2">
                                        <span className="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-teal-400 text-teal-950">
                                            En Ejecución
                                        </span>
                                        <h3 className="text-base font-black text-white">Despachando Campaña en Vivo</h3>
                                    </div>
                                    <p className="text-xs text-indigo-100 mt-1 flex items-center gap-1.5 flex-wrap">
                                        <span>Enviando ahora a:</span>
                                        <strong className="text-white truncate max-w-sm">{campaign.current_lead || 'Conectando con Resend SMTP...'}</strong>
                                    </p>
                                </div>
                            </div>

                            <div className="flex items-center gap-6 self-end md:self-center">
                                <div className="text-right">
                                    <div className="text-2xl font-black text-white tracking-tight">
                                        {campaign.enviados} <span className="text-sm font-semibold text-indigo-200">/ {campaign.total}</span>
                                    </div>
                                    <p className="text-[11px] font-medium text-teal-200">
                                        {campaign.percent}% completado {campaign.fallidos > 0 ? `(${campaign.fallidos} omitidos/error)` : ''}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {/* Animated Progress Bar */}
                        <div className="w-full bg-black/30 rounded-full h-2.5 mt-4 overflow-hidden p-0.5 border border-white/10">
                            <div 
                                className="bg-gradient-to-r from-teal-400 to-emerald-300 h-1.5 rounded-full transition-all duration-700 ease-out shadow-[0_0_12px_rgba(45,212,191,0.6)]"
                                style={{ width: `${Math.max(campaign.percent || 0, 4)}%` }}
                            />
                        </div>
                    </div>
                )}

                {campaign && campaign.status === 'completed' && (
                    <div className="bg-emerald-50 border border-emerald-300 rounded-2xl p-4 text-emerald-900 flex items-center justify-between shadow-sm animate-in fade-in duration-300">
                        <div className="flex items-center gap-3">
                            <div className="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0">
                                <CheckCircle2 className="w-5 h-5" />
                            </div>
                            <div>
                                <h4 className="text-sm font-black text-emerald-900">¡Campaña Completada Exitosamente!</h4>
                                <p className="text-xs text-emerald-700">
                                    Se despacharon {campaign.enviados} de {campaign.total} correos vía Resend SMTP {campaign.fallidos > 0 ? `(${campaign.fallidos} omitidos por dominio inactivo).` : '.'}
                                </p>
                            </div>
                        </div>
                        <button 
                            onClick={() => setCampaign(null)}
                            className="text-xs font-bold text-emerald-800 hover:text-emerald-950 px-3 py-1.5 rounded-lg hover:bg-emerald-100 cursor-pointer transition-colors"
                        >
                            Cerrar
                        </button>
                    </div>
                )}

                {/* LIVE SCAN PROGRESS BANNER */}
                {scanProgress && scanProgress.status === 'running' && (
                    <div className="relative overflow-hidden bg-gradient-to-r from-teal-950 via-emerald-900 to-teal-900 rounded-2xl p-5 text-white shadow-xl border border-teal-500/40 animate-in fade-in slide-in-from-top-4 duration-300">
                        <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div className="flex items-start sm:items-center gap-3.5">
                                <div className="w-11 h-11 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center shrink-0">
                                    <Loader2 className="w-6 h-6 animate-spin text-teal-300" />
                                </div>
                                <div>
                                    <div className="flex items-center gap-2">
                                        <span className="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-teal-400 text-teal-950">
                                            Rastreo en Vivo
                                        </span>
                                        <h3 className="text-base font-black text-white">Descubriendo Nuevas Clínicas en Colombia</h3>
                                    </div>
                                    <p className="text-xs text-teal-100 mt-1 flex items-center gap-1.5 flex-wrap">
                                        <span>Estado:</span>
                                        <strong className="text-white truncate max-w-sm">{scanProgress.current_step || 'Consultando directorios y extrayendo contactos...'}</strong>
                                    </p>
                                </div>
                            </div>

                            <div className="flex items-center gap-6 self-end md:self-center">
                                <div className="text-right">
                                    <div className="text-2xl font-black text-white tracking-tight">
                                        {scanProgress.encontrados} <span className="text-sm font-semibold text-teal-200">/ {scanProgress.total}</span>
                                    </div>
                                    <p className="text-[11px] font-medium text-emerald-200">
                                        {scanProgress.percent}% completado
                                    </p>
                                </div>
                            </div>
                        </div>

                        {/* Animated Progress Bar */}
                        <div className="w-full bg-black/30 rounded-full h-2.5 mt-4 overflow-hidden p-0.5 border border-white/10">
                            <div 
                                className="bg-gradient-to-r from-teal-400 to-emerald-300 h-1.5 rounded-full transition-all duration-700 ease-out shadow-[0_0_12px_rgba(45,212,191,0.6)]"
                                style={{ width: `${Math.max(scanProgress.percent || 0, 8)}%` }}
                            />
                        </div>
                    </div>
                )}

                {scanProgress && scanProgress.status === 'completed' && (
                    <div className="bg-teal-50 border border-teal-300 rounded-2xl p-4 text-teal-900 flex items-center justify-between shadow-sm animate-in fade-in duration-300">
                        <div className="flex items-center gap-3">
                            <div className="w-9 h-9 rounded-xl bg-teal-600 text-white flex items-center justify-center shrink-0">
                                <CheckCircle2 className="w-5 h-5" />
                            </div>
                            <div>
                                <h4 className="text-sm font-black text-teal-900">¡Escaneo Completado con Éxito!</h4>
                                <p className="text-xs text-teal-700">
                                    {scanProgress.current_step || `Se descubrieron y agregaron ${scanProgress.encontrados} nuevas clínicas a la cola de pendientes.`}
                                </p>
                            </div>
                        </div>
                        <button 
                            type="button"
                            onClick={() => setScanProgress(null)}
                            className="text-xs font-bold text-teal-800 hover:text-teal-950 px-3 py-1.5 rounded-lg hover:bg-teal-100 cursor-pointer transition-colors"
                        >
                            Cerrar
                        </button>
                    </div>
                )}

                {/* 5 KPI CARDS */}
                <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5">
                    <div className="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs">
                        <span className="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total en Base</span>
                        <div className="text-2xl font-black text-slate-900 mt-1">{stats.total}</div>
                        <div className="text-[11px] text-slate-500 mt-0.5">Clínicas registradas</div>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs">
                        <span className="text-[11px] font-bold uppercase tracking-wider text-slate-400">Pendientes</span>
                        <div className="text-2xl font-black text-amber-600 mt-1">{stats.pendientes}</div>
                        <div className="text-[11px] text-amber-600 mt-0.5">Por contactar</div>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs">
                        <span className="text-[11px] font-bold uppercase tracking-wider text-slate-400">Correos Enviados</span>
                        <div className="text-2xl font-black text-emerald-600 mt-1">{stats.enviados}</div>
                        <div className="text-[11px] text-emerald-600 mt-0.5">Outreach ejecutado</div>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs">
                        <span className="text-[11px] font-bold uppercase tracking-wider text-slate-400">Emails Abiertos</span>
                        <div className="text-2xl font-black text-indigo-600 mt-1">{stats.abiertos}</div>
                        <div className="text-[11px] text-indigo-600 mt-0.5">Lecturas confirmadas</div>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs col-span-2 sm:col-span-1">
                        <span className="text-[11px] font-bold uppercase tracking-wider text-slate-400">Con WhatsApp</span>
                        <div className="text-2xl font-black text-teal-600 mt-1">{stats.conTelefono}</div>
                        <div className="text-[11px] text-teal-600 mt-0.5">Listos para chat</div>
                    </div>
                </div>

                {/* FILTERS & SEARCH */}
                <div className="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs flex flex-col md:flex-row gap-4 justify-between items-stretch md:items-center">
                    {/* Status Tabs */}
                    <div className="flex items-center gap-1 overflow-x-auto pb-1 md:pb-0 scrollbar-none">
                        <button
                            type="button"
                            onClick={() => handleFilterEstado('all')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                                selectedEstado === 'all'
                                    ? 'bg-teal-600 text-white shadow-xs'
                                    : 'text-slate-600 hover:bg-slate-100'
                            }`}
                        >
                            Todos ({prospectos.total})
                        </button>
                        <button
                            type="button"
                            onClick={() => handleFilterEstado('pendiente')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                                selectedEstado === 'pendiente'
                                    ? 'bg-amber-600 text-white shadow-xs'
                                    : 'text-slate-600 hover:bg-slate-100'
                            }`}
                        >
                            Pendientes
                        </button>
                        <button
                            type="button"
                            onClick={() => handleFilterEstado('enviado')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                                selectedEstado === 'enviado'
                                    ? 'bg-emerald-600 text-white shadow-xs'
                                    : 'text-slate-600 hover:bg-slate-100'
                            }`}
                        >
                            Enviados
                        </button>
                        <button
                            type="button"
                            onClick={() => handleFilterEstado('abierto')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                                selectedEstado === 'abierto'
                                    ? 'bg-indigo-600 text-white shadow-xs'
                                    : 'text-slate-600 hover:bg-slate-100'
                            }`}
                        >
                            Con Apertura
                        </button>
                        <button
                            type="button"
                            onClick={() => handleFilterEstado('respondido')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                                selectedEstado === 'respondido'
                                    ? 'bg-teal-600 text-white shadow-xs'
                                    : 'text-slate-600 hover:bg-slate-100'
                            }`}
                        >
                            Respondidos
                        </button>
                        <button
                            type="button"
                            onClick={() => handleFilterEstado('error')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                                selectedEstado === 'error'
                                    ? 'bg-rose-600 text-white shadow-xs'
                                    : 'text-slate-600 hover:bg-slate-100'
                            }`}
                        >
                            Inválidos
                        </button>
                    </div>

                    {/* Municipality and Search */}
                    <div className="flex items-center gap-2">
                        {municipiosList.length > 0 && (
                            <select
                                value={selectedMunicipio}
                                onChange={(e) => handleFilterMunicipio(e.target.value)}
                                className="text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-500 max-w-[150px] truncate"
                            >
                                <option value="all">Todas las ciudades</option>
                                {municipiosList.map((m) => (
                                    <option key={m} value={m}>{m}</option>
                                ))}
                            </select>
                        )}

                        <form onSubmit={handleSearch} className="relative flex-1 sm:w-64">
                            <Search className="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
                            <input
                                type="text"
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                                placeholder="Buscar veterinaria..."
                                className="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500"
                            />
                        </form>
                    </div>
                </div>

                {/* TABLE */}
                <div className="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left text-xs text-slate-600">
                            <thead className="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[11px]">
                                <tr>
                                    <th className="py-3.5 px-4">Clínica / Veterinaria</th>
                                    <th className="py-3.5 px-4">Ubicación</th>
                                    <th className="py-3.5 px-4">Contacto Directo</th>
                                    <th className="py-3.5 px-4">Estado de Campaña</th>
                                    <th className="py-3.5 px-4">Historial / Apertura</th>
                                    <th className="py-3.5 px-4 text-right">Acción Rápida</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100">
                                {prospectos.data.length === 0 ? (
                                    <tr>
                                        <td colSpan={6} className="text-center py-12 text-slate-400">
                                            <Building2 className="w-10 h-10 mx-auto text-slate-300 mb-2" />
                                            No se encontraron clínicas veterinarias con los filtros seleccionados.
                                        </td>
                                    </tr>
                                ) : (
                                    prospectos.data.map((p) => (
                                        <tr key={p.id} className="hover:bg-slate-50/70 transition-colors">
                                            <td className="py-3.5 px-4">
                                                <div className="font-bold text-slate-900 text-sm">{p.razon_social}</div>
                                                <div className="text-[11px] text-teal-600 font-medium">{p.tipo}</div>
                                                {p.direccion && (
                                                    <div className="text-[11px] text-slate-400 truncate max-w-xs">{p.direccion}</div>
                                                )}
                                            </td>

                                            <td className="py-3.5 px-4">
                                                <div className="font-medium text-slate-800 flex items-center gap-1">
                                                    <MapPin className="w-3.5 h-3.5 text-slate-400 shrink-0" />
                                                    {p.municipio}
                                                </div>
                                                <div className="text-[11px] text-slate-400">{p.departamento}</div>
                                            </td>

                                            <td className="py-3.5 px-4">
                                                <div className="flex items-center gap-1.5 text-slate-800">
                                                    <Mail className="w-3.5 h-3.5 text-slate-400 shrink-0" />
                                                    <span className="font-medium">{p.correo_comercial}</span>
                                                    <button
                                                        type="button"
                                                        onClick={() => handleCopyEmail(p.correo_comercial)}
                                                        title="Copiar correo"
                                                        className="text-slate-400 hover:text-teal-600 cursor-pointer ml-0.5"
                                                    >
                                                        {copiedEmail === p.correo_comercial ? (
                                                            <Check className="w-3.5 h-3.5 text-emerald-600" />
                                                        ) : (
                                                            <Copy className="w-3.5 h-3.5" />
                                                        )}
                                                    </button>
                                                </div>
                                                {p.telefono && (
                                                    <div className="text-[11px] text-slate-500 flex items-center gap-1 mt-0.5">
                                                        <Phone className="w-3 h-3 text-slate-400" />
                                                        <span>{p.telefono}</span>
                                                    </div>
                                                )}
                                            </td>

                                            <td className="py-3.5 px-4">
                                                <button
                                                    onClick={() => setStatusModalProspecto(p)}
                                                    className="cursor-pointer hover:opacity-80 transition-opacity"
                                                    title="Clic para cambiar estado"
                                                >
                                                    {getEstadoBadge(p)}
                                                </button>
                                            </td>

                                            <td className="py-3.5 px-4">
                                                {p.ultimo_envio_at ? (
                                                    <div className="text-[11px] text-slate-600">
                                                        <div>Enviado: {p.ultimo_envio_at}</div>
                                                        {p.abierto_at && (
                                                            <div className="text-indigo-600 font-semibold">Leído: {p.abierto_at}</div>
                                                        )}
                                                    </div>
                                                ) : (
                                                    <span className="text-[11px] text-slate-400">Sin envíos</span>
                                                )}
                                            </td>

                                            <td className="py-3.5 px-4 text-right">
                                                <div className="flex items-center justify-end gap-1.5">
                                                    {p.wa_link && (
                                                        <a
                                                            href={p.wa_link}
                                                            target="_blank"
                                                            rel="noopener noreferrer"
                                                            title="Iniciar conversación en WhatsApp"
                                                            className="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition-colors"
                                                        >
                                                            <MessageCircle className="w-3.5 h-3.5" />
                                                            WhatsApp
                                                        </a>
                                                    )}

                                                    <button
                                                        onClick={() => handleSendOutreach(p.id)}
                                                        disabled={sendingEmailId === p.id}
                                                        title="Enviar correo de outreach"
                                                        className="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold text-teal-700 bg-teal-50 hover:bg-teal-100 transition-colors disabled:opacity-50 cursor-pointer"
                                                    >
                                                        <Send className="w-3.5 h-3.5" />
                                                        {sendingEmailId === p.id ? 'Enviando...' : 'Email'}
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    ))
                                )}
                            </tbody>
                        </table>
                    </div>

                    {/* PAGINATION */}
                    {prospectos.last_page > 1 && (
                        <div className="p-4 border-t border-slate-200 flex items-center justify-between">
                            <span className="text-xs text-slate-500">
                                Página {prospectos.current_page} de {prospectos.last_page} ({prospectos.total} clínicas)
                            </span>
                            <div className="flex items-center gap-2">
                                {prospectos.prev_page_url && (
                                    <button
                                        onClick={() => router.get(prospectos.prev_page_url!)}
                                        className="p-1.5 rounded-lg border border-slate-200 hover:bg-slate-100 text-slate-600 cursor-pointer"
                                    >
                                        <ChevronLeft className="w-4 h-4" />
                                    </button>
                                )}
                                {prospectos.next_page_url && (
                                    <button
                                        onClick={() => router.get(prospectos.next_page_url!)}
                                        className="p-1.5 rounded-lg border border-slate-200 hover:bg-slate-100 text-slate-600 cursor-pointer"
                                    >
                                        <ChevronRight className="w-4 h-4" />
                                    </button>
                                )}
                            </div>
                        </div>
                    )}
                </div>

                {/* MODAL: NUEVO PROSPECTO */}
                {isCreateModalOpen && (
                    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
                        <div className="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4 animate-in fade-in zoom-in-95 duration-150">
                            <div className="flex items-center justify-between border-b border-slate-100 pb-3">
                                <h3 className="text-base font-bold text-slate-900 flex items-center gap-2">
                                    <Plus className="w-5 h-5 text-teal-600" />
                                    Nuevo Prospecto Veterinario
                                </h3>
                                <button
                                    onClick={() => setIsCreateModalOpen(false)}
                                    className="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 cursor-pointer"
                                >
                                    <X className="w-5 h-5" />
                                </button>
                            </div>

                            <form onSubmit={handleCreateSubmit} className="space-y-3">
                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">Razón Social / Nombre Clínica</label>
                                    <input
                                        type="text"
                                        value={newProspecto.razon_social}
                                        onChange={(e) => setNewProspecto({ ...newProspecto, razon_social: e.target.value })}
                                        placeholder="Ej. Clínica Veterinaria El Portal"
                                        className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                        required
                                    />
                                </div>

                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">Correo Electrónico Comercial</label>
                                    <input
                                        type="email"
                                        value={newProspecto.correo_comercial}
                                        onChange={(e) => setNewProspecto({ ...newProspecto, correo_comercial: e.target.value })}
                                        placeholder="contacto@veterinaria.com"
                                        className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                        required
                                    />
                                </div>

                                <div className="grid grid-cols-2 gap-3">
                                    <div>
                                        <label className="block text-xs font-bold text-slate-700 mb-1">Teléfono / WhatsApp</label>
                                        <input
                                            type="text"
                                            value={newProspecto.telefono}
                                            onChange={(e) => setNewProspecto({ ...newProspecto, telefono: e.target.value })}
                                            placeholder="3201234567"
                                            className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                        />
                                    </div>

                                    <div>
                                        <label className="block text-xs font-bold text-slate-700 mb-1">Tipo</label>
                                        <select
                                            value={newProspecto.tipo}
                                            onChange={(e) => setNewProspecto({ ...newProspecto, tipo: e.target.value })}
                                            className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                        >
                                            <option value="Clínica Veterinaria">Clínica Veterinaria</option>
                                            <option value="Hospital Veterinario">Hospital Veterinario</option>
                                            <option value="Consultorio Veterinario">Consultorio Veterinario</option>
                                            <option value="Pet Shop & Consultorio">Pet Shop & Consultorio</option>
                                        </select>
                                    </div>
                                </div>

                                <div className="grid grid-cols-2 gap-3">
                                    <div>
                                        <label className="block text-xs font-bold text-slate-700 mb-1">Municipio / Ciudad</label>
                                        <input
                                            type="text"
                                            value={newProspecto.municipio}
                                            onChange={(e) => setNewProspecto({ ...newProspecto, municipio: e.target.value })}
                                            className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                            required
                                        />
                                    </div>

                                    <div>
                                        <label className="block text-xs font-bold text-slate-700 mb-1">Departamento</label>
                                        <input
                                            type="text"
                                            value={newProspecto.departamento}
                                            onChange={(e) => setNewProspecto({ ...newProspecto, departamento: e.target.value })}
                                            className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                            required
                                        />
                                    </div>
                                </div>

                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">Dirección Comercial</label>
                                    <input
                                        type="text"
                                        value={newProspecto.direccion}
                                        onChange={(e) => setNewProspecto({ ...newProspecto, direccion: e.target.value })}
                                        placeholder="Calle 100 # 15-20"
                                        className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                    />
                                </div>

                                <div className="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                                    <button
                                        type="button"
                                        onClick={() => setIsCreateModalOpen(false)}
                                        className="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 cursor-pointer"
                                    >
                                        Cancelar
                                    </button>
                                    <button
                                        type="submit"
                                        className="px-4 py-2 rounded-xl text-xs font-bold bg-teal-600 hover:bg-teal-700 text-white shadow-xs cursor-pointer"
                                    >
                                        Guardar Prospecto
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                )}

                {/* MODAL: CAMBIAR ESTADO */}
                {statusModalProspecto && (
                    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
                        <div className="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl space-y-4 animate-in fade-in zoom-in-95 duration-150">
                            <div className="flex items-center justify-between border-b border-slate-100 pb-3">
                                <div>
                                    <h3 className="text-sm font-bold text-slate-900">Actualizar Estado</h3>
                                    <p className="text-xs text-slate-500 truncate max-w-[200px]">{statusModalProspecto.razon_social}</p>
                                </div>
                                <button
                                    onClick={() => setStatusModalProspecto(null)}
                                    className="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 cursor-pointer"
                                >
                                    <X className="w-5 h-5" />
                                </button>
                            </div>

                            <div className="space-y-2">
                                {['pendiente', 'enviado', 'respondido', 'desuscrito', 'error'].map((st) => (
                                    <button
                                        key={st}
                                        type="button"
                                        onClick={() => handleUpdateStatus(statusModalProspecto.id, st)}
                                        className={`w-full text-left px-3 py-2 rounded-xl text-xs font-bold transition-colors capitalize flex items-center justify-between cursor-pointer ${
                                            statusModalProspecto.estado === st
                                                ? 'bg-teal-50 text-teal-700 border border-teal-200'
                                                : 'hover:bg-slate-50 text-slate-700'
                                        }`}
                                    >
                                        <span>{st}</span>
                                        {statusModalProspecto.estado === st && <Check className="w-4 h-4 text-teal-600" />}
                                    </button>
                                ))}
                            </div>
                        </div>
                    </div>
                )}

                {/* MODAL: DESPACHAR CAMPAÑA POR LOTE */}
                {isBatchModalOpen && (
                    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
                        <div className="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-5 animate-in fade-in zoom-in-95 duration-150">
                            <div className="flex items-center justify-between border-b border-slate-100 pb-3">
                                <div className="flex items-center gap-2.5">
                                    <div className="w-9 h-9 rounded-xl bg-indigo-50 border border-indigo-200 flex items-center justify-center text-indigo-600">
                                        <Send className="w-4 h-4" />
                                    </div>
                                    <div>
                                        <h3 className="text-base font-black text-slate-900">Despachar Campaña por Lote</h3>
                                        <p className="text-xs text-slate-500">Envío automático vía Resend SMTP</p>
                                    </div>
                                </div>
                                <button
                                    onClick={() => !isDispatchingBatch && setIsBatchModalOpen(false)}
                                    disabled={isDispatchingBatch}
                                    className="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 cursor-pointer disabled:opacity-50"
                                >
                                    <X className="w-5 h-5" />
                                </button>
                            </div>

                            <div className="bg-indigo-50/70 border border-indigo-100 rounded-xl p-3.5 text-xs text-indigo-900 space-y-1.5">
                                <div className="font-bold flex items-center gap-1.5 text-indigo-950">
                                    <Sparkles className="w-4 h-4 text-indigo-600" />
                                    <span>Motor Anti-Rebote con Verificación DNS MX</span>
                                </div>
                                <p className="text-indigo-800 leading-relaxed">
                                    El sistema tomará las siguientes clínicas en estado <strong>Pendiente</strong> con correo comercial válido y les enviará la propuesta oficial de membresías de AviPetApp firmada por <strong>@avipetapp.com</strong>.
                                </p>
                            </div>

                            <div className="space-y-3">
                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1.5">Tamaño del Lote a Enviar</label>
                                    <div className="grid grid-cols-4 gap-2">
                                        {[25, 50, 75, 100].map((num) => (
                                            <button
                                                key={num}
                                                type="button"
                                                onClick={() => setBatchLimit(num)}
                                                className={`py-2 text-xs font-bold rounded-xl border transition-all cursor-pointer ${
                                                    batchLimit === num
                                                        ? 'bg-indigo-600 text-white border-indigo-600 shadow-xs'
                                                        : 'bg-slate-50 text-slate-700 border-slate-200 hover:bg-slate-100'
                                                }`}
                                            >
                                                {num}
                                            </button>
                                        ))}
                                    </div>
                                </div>

                                <div className="flex items-center justify-between text-xs text-slate-500 px-1 pt-1">
                                    <span>Prospectos pendientes disponibles:</span>
                                    <span className="font-bold text-amber-600">{stats.pendientes}</span>
                                </div>
                            </div>

                            <div className="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                                <button
                                    type="button"
                                    onClick={() => setIsBatchModalOpen(false)}
                                    disabled={isDispatchingBatch}
                                    className="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 cursor-pointer disabled:opacity-50"
                                >
                                    Cancelar
                                </button>
                                <button
                                    type="button"
                                    onClick={handleDispatchBatch}
                                    disabled={isDispatchingBatch || stats.pendientes === 0}
                                    className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white shadow-sm transition-all cursor-pointer disabled:opacity-50"
                                >
                                    {isDispatchingBatch ? (
                                        <>
                                            <Loader2 className="w-4 h-4 animate-spin" />
                                            <span>Despachando correos...</span>
                                        </>
                                    ) : (
                                        <>
                                            <Send className="w-4 h-4" />
                                            <span>Disparar {batchLimit} Correos Ahora</span>
                                        </>
                                    )}
                                </button>
                            </div>
                        </div>
                    </div>
                )}

                {/* MODAL: ESCANEAR NUEVAS VETERINARIAS */}
                {isScanModalOpen && (
                    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
                        <div className="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-5 animate-in fade-in zoom-in-95 duration-150">
                            <div className="flex items-center justify-between border-b border-slate-100 pb-3">
                                <div className="flex items-center gap-2.5">
                                    <div className="w-9 h-9 rounded-xl bg-teal-50 border border-teal-200 flex items-center justify-center text-teal-600">
                                        <Search className="w-4 h-4" />
                                    </div>
                                    <div>
                                        <h3 className="text-base font-black text-slate-900">Escanear y Buscar Nuevas Clínicas</h3>
                                        <p className="text-xs text-slate-500">Rastreador web en vivo y OpenStreetMap</p>
                                    </div>
                                </div>
                                <button
                                    onClick={() => !isScanning && setIsScanModalOpen(false)}
                                    disabled={isScanning}
                                    className="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 cursor-pointer disabled:opacity-50"
                                >
                                    <X className="w-5 h-5" />
                                </button>
                            </div>

                            <div className="space-y-4">
                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1.5">Seleccionar Región a Explorar</label>
                                    <select
                                        value={scanRegion}
                                        onChange={(e) => setScanRegion(e.target.value)}
                                        className="w-full text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                    >
                                        <option value="todo_el_pais">🇨🇴 Barrido Nacional Completo (Todas las regiones)</option>
                                        <option value="bogota">🏙️ Bogotá D.C. (Suba, Usaquén, Chapinero, Salitre, etc.)</option>
                                        <option value="sabana">🐾 Zipaquirá y Sabana Centro (Chía, Cajicá, Cota, Tenjo, etc.)</option>
                                        <option value="antioquia">🏔️ Antioquia (Medellín, Envigado, Sabaneta, Rionegro)</option>
                                        <option value="valle">☀️ Valle del Cauca (Cali, Palmira, Jamundí, Tuluá)</option>
                                        <option value="santander">🦅 Santanderes (Bucaramanga, Floridablanca, Cúcuta)</option>
                                        <option value="ejecafetero">☕ Eje Cafetero (Pereira, Manizales, Armenia)</option>
                                        <option value="caribe">🏖️ Costa Caribe (Barranquilla, Cartagena, Santa Marta)</option>
                                        <option value="cundinamarca_tolima">🌄 Cundinamarca Sur & Tolima (Soacha, Fusagasugá, Girardot)</option>
                                    </select>
                                </div>

                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1.5">Cantidad Mínima de Prospectos a Extraer</label>
                                    <div className="grid grid-cols-3 gap-2">
                                        {[25, 50, 100].map((num) => (
                                            <button
                                                key={num}
                                                type="button"
                                                onClick={() => setScanLimit(num)}
                                                className={`py-2 text-xs font-bold rounded-xl border transition-all cursor-pointer ${
                                                    scanLimit === num
                                                        ? 'bg-teal-600 text-white border-teal-600 shadow-xs'
                                                        : 'bg-slate-50 text-slate-700 border-slate-200 hover:bg-slate-100'
                                                }`}
                                            >
                                                +{num} Clínicas
                                            </button>
                                        ))}
                                    </div>
                                </div>

                                <div className="bg-slate-50 border border-slate-200/80 rounded-xl p-3 text-[11px] text-slate-600 leading-relaxed">
                                    💡 <strong>Upsert Automático:</strong> El motor rastrea directorios y páginas web, extrae correos y números de WhatsApp reales, e inserta las clínicas nuevas descartando duplicados sin alterar las que ya recibieron correos.
                                </div>
                            </div>

                            <div className="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                                <button
                                    type="button"
                                    onClick={() => setIsScanModalOpen(false)}
                                    disabled={isScanning}
                                    className="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 cursor-pointer disabled:opacity-50"
                                >
                                    Cancelar
                                </button>
                                <button
                                    type="button"
                                    onClick={handleScanRegion}
                                    disabled={isScanning}
                                    className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white shadow-sm transition-all cursor-pointer disabled:opacity-50"
                                >
                                    {isScanning ? (
                                        <>
                                            <Loader2 className="w-4 h-4 animate-spin" />
                                            <span>Rastreando la web...</span>
                                        </>
                                    ) : (
                                        <>
                                            <Search className="w-4 h-4" />
                                            <span>Iniciar Escaneo (+{scanLimit})</span>
                                        </>
                                    )}
                                </button>
                            </div>
                        </div>
                    </div>
                )}

                {/* MODAL: IMPORTAR CSV / EXCEL */}
                {isImportModalOpen && (
                    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
                        <div className="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl space-y-4 animate-in fade-in zoom-in-95 duration-150">
                            <div className="flex items-center justify-between border-b border-slate-100 pb-3">
                                <div className="flex items-center gap-2.5">
                                    <div className="w-9 h-9 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-700">
                                        <UploadCloud className="w-4 h-4" />
                                    </div>
                                    <div>
                                        <h3 className="text-base font-black text-slate-900">Importar Filas de Excel o CSV</h3>
                                        <p className="text-xs text-slate-500">Carga masiva con protección Upsert</p>
                                    </div>
                                </div>
                                <button
                                    onClick={() => !isImporting && setIsImportModalOpen(false)}
                                    disabled={isImporting}
                                    className="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 cursor-pointer disabled:opacity-50"
                                >
                                    <X className="w-5 h-5" />
                                </button>
                            </div>

                            <form onSubmit={handleImportCsv} className="space-y-4">
                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">
                                        Pega aquí las filas (delimitado por <code>;</code> o <code>,</code>)
                                    </label>
                                    <textarea
                                        value={csvData}
                                        onChange={(e) => setCsvData(e.target.value)}
                                        rows={6}
                                        placeholder={"razon_social;correo_comercial;municipio;telefono\nClínica Animal Pets;contacto@animalpets.com;Bogotá D.C.;3201234567\nVeterinaria San Roque;ventas@sanroque.com;Medellín;3109876543"}
                                        className="w-full text-xs font-mono bg-slate-50 border border-slate-200 rounded-xl p-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                        required
                                    />
                                    <p className="text-[11px] text-slate-500 mt-1">
                                        Columnas admitidas: <code>razon_social</code>, <code>correo_comercial</code>, <code>municipio</code>, <code>telefono</code>, <code>departamento</code>.
                                    </p>
                                </div>

                                <div className="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                                    <button
                                        type="button"
                                        onClick={() => setIsImportModalOpen(false)}
                                        disabled={isImporting}
                                        className="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 cursor-pointer disabled:opacity-50"
                                    >
                                        Cancelar
                                    </button>
                                    <button
                                        type="submit"
                                        disabled={isImporting || !csvData.trim()}
                                        className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white shadow-sm transition-all cursor-pointer disabled:opacity-50"
                                    >
                                        {isImporting ? (
                                            <>
                                                <Loader2 className="w-4 h-4 animate-spin" />
                                                <span>Importando datos...</span>
                                            </>
                                        ) : (
                                            <>
                                                <UploadCloud className="w-4 h-4" />
                                                <span>Importar Filas</span>
                                            </>
                                        )}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                )}
            </div>
        </SuperAdminLayout>
    );
}
