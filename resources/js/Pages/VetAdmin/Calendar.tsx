import React, { useState } from 'react';
import { Head, router, useForm } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import { 
    Calendar as CalendarIcon, 
    Clock, 
    User, 
    PawPrint, 
    CheckCircle2, 
    XCircle, 
    Plus, 
    ChevronLeft, 
    ChevronRight, 
    ExternalLink, 
    MessageCircle, 
    Sparkles, 
    ShieldCheck, 
    AlertCircle, 
    CalendarDays,
    Stethoscope,
    Phone,
    FileText,
    Check,
    X
} from 'lucide-react';

interface AppointmentItem {
    id: string;
    title: string;
    doctor_name: string;
    scheduled_at: string;
    time_formatted: string;
    end_time_formatted: string;
    duration_minutes: number;
    status: string;
    status_label: string;
    service_type: string;
    notes: string | null;
    pet_id: string;
    pet_name: string;
    pet_species: string;
    pet_breed: string;
    customer_name: string;
    customer_phone: string;
    google_calendar_url: string;
    whatsapp_reminder_url: string;
    sync_status: string;
}

interface PetOption {
    id: string;
    name: string;
    species: string;
    breed: string;
    customer_id: string;
    customer_name: string;
    customer_phone: string;
    plan_name: string;
}

interface ServiceOption {
    id: string;
    name: string;
    category: string;
}

interface SlotOption {
    time: string;
    label: string;
    end_time: string;
    is_available: boolean;
    reason: string;
}

interface CalendarProps {
    tenant: any;
    tenantSlug: string;
    brandName: string;
    clinicSubtitle: string;
    logoUrl: string | null;
    primaryColor: string;
    secondaryColor: string;
    saasPlan: any;
    logoutUrl: string;
    userName: string;
    userRole: string;
    greetingName: string;
    selectedDate: string;
    appointments: AppointmentItem[];
    metrics: {
        todayCount: number;
        upcomingCount: number;
        completedThisMonth: number;
        googleSyncedCount: number;
    };
    pets: PetOption[];
    services: ServiceOption[];
    availableSlots: SlotOption[];
    doctors: Array<{ name: string; role: string }>;
}

export default function CalendarPage({
    tenant,
    tenantSlug,
    brandName,
    clinicSubtitle,
    logoUrl,
    primaryColor = '#0080ff',
    secondaryColor = '#d437b5',
    saasPlan,
    logoutUrl,
    userName,
    userRole,
    greetingName,
    selectedDate,
    appointments = [],
    metrics,
    pets = [],
    services = [],
    availableSlots = [],
    doctors = [],
}: CalendarProps) {
    const isPreview = typeof window !== 'undefined' && (window.location.search.includes('preview=1') || window.location.href.includes('preview=1'));
    const formatLink = (url: string) => isPreview && !url.includes('preview=1') ? `${url}${url.includes('?') ? '&' : '?'}preview=1` : url;

    const [isModalOpen, setIsModalOpen] = useState(false);
    const [filterDoctor, setFilterDoctor] = useState('all');
    const [actionLoadingId, setActionLoadingId] = useState<string | null>(null);

    // Formulario de agendamiento
    const { data, setData, post, processing, errors, reset } = useForm({
        pet_id: pets[0]?.id || '',
        doctor_name: doctors[0]?.name || 'Dra. Vicky Naranjo',
        service_type: 'Consulta General',
        benefit_definition_id: services[0]?.id || '',
        date: selectedDate,
        time: availableSlots.find(s => s.is_available)?.time || '09:00',
        duration_minutes: 30,
        notes: '',
    });

    const selectedPet = pets.find(p => p.id === data.pet_id);

    const handleDateChange = (newDate: string) => {
        router.visit(formatLink(`/admin/${tenantSlug}/citas?date=${newDate}`), {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const handlePrevDay = () => {
        const d = new Date(selectedDate + 'T00:00:00');
        d.setDate(d.getDate() - 1);
        handleDateChange(d.toISOString().split('T')[0]);
    };

    const handleNextDay = () => {
        const d = new Date(selectedDate + 'T00:00:00');
        d.setDate(d.getDate() + 1);
        handleDateChange(d.toISOString().split('T')[0]);
    };

    const handleToday = () => {
        const today = new Date().toISOString().split('T')[0];
        handleDateChange(today);
    };

    const handleStatusUpdate = (appointmentId: string, status: string) => {
        setActionLoadingId(appointmentId);
        router.put(
            formatLink(`/admin/${tenantSlug}/citas/${appointmentId}/status`),
            { status },
            {
                preserveScroll: true,
                onFinish: () => setActionLoadingId(null),
            }
        );
    };

    const handleSubmitAppointment = (e: React.FormEvent) => {
        e.preventDefault();
        post(formatLink(`/admin/${tenantSlug}/citas`), {
            preserveScroll: true,
            onSuccess: () => {
                setIsModalOpen(false);
                reset('notes');
            },
        });
    };

    const filteredAppointments = appointments.filter(app => {
        if (filterDoctor !== 'all' && app.doctor_name !== filterDoctor) return false;
        return true;
    });

    // Formatear fecha para título amigable
    const formatDateHeader = (dateStr: string) => {
        try {
            const [y, m, d] = dateStr.split('-');
            const dateObj = new Date(parseInt(y), parseInt(m) - 1, parseInt(d));
            return dateObj.toLocaleDateString('es-ES', { 
                weekday: 'long', 
                day: 'numeric', 
                month: 'long', 
                year: 'numeric' 
            });
        } catch (e) {
            return dateStr;
        }
    };

    return (
        <VetAdminLayout
            tenantSlug={tenantSlug}
            brandName={brandName}
            clinicSubtitle={clinicSubtitle}
            logoUrl={logoUrl}
            primaryColor={primaryColor}
            secondaryColor={secondaryColor}
            saasPlan={saasPlan}
            logoutUrl={logoutUrl}
            userName={userName}
            userRole={userRole}
            activeItem="Citas & Agenda"
        >
            <Head title={`Citas & Agenda · Sincronización Google Calendar - ${brandName}`} />

            <div className="max-w-7xl mx-auto space-y-6 pb-12">
                
                {/* 1. Header con Selector de Fecha y Acciones Rápidas */}
                <div className="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
                    <div>
                        <div className="flex items-center gap-2">
                            <span className="p-2 rounded-xl bg-blue-50 text-blue-600 border border-blue-100">
                                <CalendarDays className="w-5 h-5" />
                            </span>
                            <h1 className="text-xl font-black text-slate-900 tracking-tight">
                                Agenda Médica & Citas
                            </h1>
                            <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span className="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Google Calendar Sync
                            </span>
                        </div>
                        <p className="text-xs text-slate-500 mt-1 capitalize">
                            {formatDateHeader(selectedDate)}
                        </p>
                    </div>

                    <div className="flex flex-wrap items-center gap-2">
                        {/* Navegación por fechas */}
                        <div className="flex items-center bg-slate-50 border border-slate-200 rounded-xl p-1 shadow-2xs">
                            <button
                                onClick={handlePrevDay}
                                title="Día anterior"
                                className="p-1.5 rounded-lg hover:bg-white text-slate-600 hover:text-slate-900 transition"
                            >
                                <ChevronLeft className="w-4 h-4" />
                            </button>
                            <button
                                onClick={handleToday}
                                className="px-3 py-1 text-xs font-bold text-slate-700 hover:bg-white rounded-lg transition"
                            >
                                Hoy
                            </button>
                            <button
                                onClick={handleNextDay}
                                title="Día siguiente"
                                className="p-1.5 rounded-lg hover:bg-white text-slate-600 hover:text-slate-900 transition"
                            >
                                <ChevronRight className="w-4 h-4" />
                            </button>
                        </div>

                        {/* Input date picker nativo */}
                        <input
                            type="date"
                            value={selectedDate}
                            onChange={(e) => handleDateChange(e.target.value)}
                            className="text-xs px-3 py-2 rounded-xl border border-slate-200 bg-white font-medium text-slate-700 shadow-2xs focus:ring-1 focus:ring-blue-500 outline-none"
                        />

                        {/* Botón Abrir Google Calendar Oficial */}
                        <a
                            href="https://calendar.google.com"
                            target="_blank"
                            rel="noopener noreferrer"
                            className="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition shadow-2xs border border-slate-200"
                        >
                            <ExternalLink className="w-3.5 h-3.5 text-slate-500" />
                            <span>Google Calendar</span>
                        </a>

                        {/* Botón Agendar Cita */}
                        <button
                            onClick={() => setIsModalOpen(true)}
                            className="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-xs hover:shadow"
                        >
                            <Plus className="w-4 h-4" />
                            <span>Agendar Cita Médica</span>
                        </button>
                    </div>
                </div>

                {/* 2. KPIs de Gestión de Citas */}
                <div className="grid grid-cols-2 md:grid-cols-4 gap-3.5">
                    <div className="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
                        <div className="flex items-center justify-between">
                            <span className="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Citas Hoy</span>
                            <span className="p-1.5 rounded-lg bg-blue-50 text-blue-600">
                                <Clock className="w-4 h-4" />
                            </span>
                        </div>
                        <div className="mt-2 flex items-baseline gap-2">
                            <span className="text-2xl font-black text-slate-900">{metrics.todayCount}</span>
                            <span className="text-[11px] text-slate-500 font-medium">programadas</span>
                        </div>
                    </div>

                    <div className="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
                        <div className="flex items-center justify-between">
                            <span className="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Próximas Citas</span>
                            <span className="p-1.5 rounded-lg bg-purple-50 text-purple-600">
                                <CalendarIcon className="w-4 h-4" />
                            </span>
                        </div>
                        <div className="mt-2 flex items-baseline gap-2">
                            <span className="text-2xl font-black text-purple-600">{metrics.upcomingCount}</span>
                            <span className="text-[11px] text-slate-500 font-medium">por atender</span>
                        </div>
                    </div>

                    <div className="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
                        <div className="flex items-center justify-between">
                            <span className="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Atendidas este Mes</span>
                            <span className="p-1.5 rounded-lg bg-emerald-50 text-emerald-600">
                                <CheckCircle2 className="w-4 h-4" />
                            </span>
                        </div>
                        <div className="mt-2 flex items-baseline gap-2">
                            <span className="text-2xl font-black text-emerald-600">{metrics.completedThisMonth}</span>
                            <span className="text-[11px] text-slate-500 font-medium">pacientes</span>
                        </div>
                    </div>

                    <div className="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
                        <div className="flex items-center justify-between">
                            <span className="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Sincronización</span>
                            <span className="p-1.5 rounded-lg bg-amber-50 text-amber-600">
                                <ShieldCheck className="w-4 h-4" />
                            </span>
                        </div>
                        <div className="mt-2 flex items-baseline gap-2">
                            <span className="text-2xl font-black text-slate-900">{metrics.googleSyncedCount}</span>
                            <span className="text-[11px] text-emerald-600 font-bold">100% en Google</span>
                        </div>
                    </div>
                </div>

                {/* 3. Filtro por Profesional */}
                <div className="flex items-center justify-between bg-white px-4 py-2.5 rounded-xl border border-slate-200 shadow-2xs">
                    <div className="flex items-center gap-2">
                        <Stethoscope className="w-4 h-4 text-slate-400" />
                        <span className="text-xs font-bold text-slate-700">Filtrar por Profesional:</span>
                        <div className="flex gap-1.5">
                            <button
                                onClick={() => setFilterDoctor('all')}
                                className={`px-2.5 py-1 rounded-lg text-xs font-bold transition ${
                                    filterDoctor === 'all' 
                                        ? 'bg-blue-600 text-white shadow-2xs' 
                                        : 'bg-slate-50 text-slate-600 hover:bg-slate-100'
                                }`}
                            >
                                Todos
                            </button>
                            {doctors.map((doc, idx) => (
                                <button
                                    key={idx}
                                    onClick={() => setFilterDoctor(doc.name)}
                                    className={`px-2.5 py-1 rounded-lg text-xs font-bold transition ${
                                        filterDoctor === doc.name 
                                            ? 'bg-blue-600 text-white shadow-2xs' 
                                            : 'bg-slate-50 text-slate-600 hover:bg-slate-100'
                                    }`}
                                >
                                    {doc.name.split(' ')[0]} {doc.name.split(' ')[1]}
                                </button>
                            ))}
                        </div>
                    </div>

                    <span className="text-xs text-slate-400 font-medium">
                        {filteredAppointments.length} cita{filteredAppointments.length === 1 ? '' : 's'} en esta fecha
                    </span>
                </div>

                {/* 4. Lista de Citas del Día */}
                <div className="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
                    <div className="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <div className="flex items-center gap-2">
                            <Clock className="w-4 h-4 text-blue-600" />
                            <h2 className="text-sm font-bold text-slate-800">
                                Citas Programadas para {selectedDate}
                            </h2>
                        </div>
                        <span className="text-[11px] text-slate-500 font-medium">
                            Horario de Atención: 8:00 AM – 6:00 PM
                        </span>
                    </div>

                    {filteredAppointments.length === 0 ? (
                        <div className="p-12 text-center space-y-3">
                            <div className="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto border border-blue-100">
                                <CalendarDays className="w-6 h-6" />
                            </div>
                            <h3 className="text-sm font-bold text-slate-800">No hay citas programadas para este día</h3>
                            <p className="text-xs text-slate-500 max-w-sm mx-auto">
                                Puedes agendar una consulta médica, vacunación o control para tus pacientes y sincronizarla en 1 clic con Google Calendar.
                            </p>
                            <button
                                onClick={() => setIsModalOpen(true)}
                                className="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-xs"
                            >
                                <Plus className="w-4 h-4" />
                                <span>Agendar Primera Cita</span>
                            </button>
                        </div>
                    ) : (
                        <div className="divide-y divide-slate-100">
                            {filteredAppointments.map((app) => (
                                <div key={app.id} className="p-4 sm:p-5 hover:bg-slate-50/70 transition flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    
                                    {/* Info Principal */}
                                    <div className="flex items-start gap-3.5">
                                        <div className="flex flex-col items-center justify-center w-16 h-16 rounded-xl bg-blue-50 border border-blue-100 shrink-0 text-blue-700">
                                            <span className="text-xs font-black leading-none">{app.time_formatted}</span>
                                            <span className="text-[9px] font-bold text-blue-500 mt-0.5">a {app.end_time_formatted}</span>
                                            <span className="text-[9px] text-slate-400 mt-0.5 font-medium">{app.duration_minutes} min</span>
                                        </div>

                                        <div className="space-y-1">
                                            <div className="flex items-center gap-2 flex-wrap">
                                                <h3 className="text-sm font-bold text-slate-900">
                                                    {app.title}
                                                </h3>
                                                
                                                {/* Badge de Estado */}
                                                <span className={`px-2 py-0.5 rounded-full text-[10px] font-bold border ${
                                                    app.status === 'completed'
                                                        ? 'bg-emerald-50 text-emerald-700 border-emerald-200'
                                                        : app.status === 'cancelled'
                                                        ? 'bg-rose-50 text-rose-700 border-rose-200'
                                                        : 'bg-blue-50 text-blue-700 border-blue-200'
                                                }`}>
                                                    {app.status_label}
                                                </span>

                                                {/* Badge Google Calendar */}
                                                <span className="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200 flex items-center gap-1">
                                                    <CalendarIcon className="w-2.5 h-2.5" />
                                                    Sincronizado
                                                </span>
                                            </div>

                                            <div className="flex flex-wrap items-center gap-3 text-xs text-slate-500">
                                                <span className="flex items-center gap-1 font-medium text-slate-700">
                                                    <PawPrint className="w-3.5 h-3.5 text-blue-500" />
                                                    {app.pet_name} ({app.pet_breed})
                                                </span>
                                                <span className="flex items-center gap-1">
                                                    <User className="w-3.5 h-3.5 text-slate-400" />
                                                    {app.customer_name}
                                                </span>
                                                <span className="flex items-center gap-1">
                                                    <Phone className="w-3.5 h-3.5 text-slate-400" />
                                                    {app.customer_phone}
                                                </span>
                                                <span className="flex items-center gap-1 text-slate-600 font-semibold">
                                                    <Stethoscope className="w-3.5 h-3.5 text-purple-500" />
                                                    {app.doctor_name}
                                                </span>
                                            </div>

                                            {app.notes && (
                                                <p className="text-[11px] text-slate-500 bg-slate-50 p-2 rounded-lg border border-slate-200/60 max-w-xl">
                                                    💬 <span className="italic">{app.notes}</span>
                                                </p>
                                            )}
                                        </div>
                                    </div>

                                    {/* Botones de Acción */}
                                    <div className="flex flex-wrap items-center gap-2 shrink-0 self-end md:self-center">
                                        {/* Sincronizar / Ver en Google Calendar */}
                                        <a
                                            href={app.google_calendar_url}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            title="Abrir o agregar en Google Calendar"
                                            className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition shadow-2xs border border-slate-200"
                                        >
                                            <CalendarIcon className="w-3.5 h-3.5 text-blue-600" />
                                            <span>Google Calendar</span>
                                        </a>

                                        {/* Enviar Recordatorio WhatsApp */}
                                        <a
                                            href={app.whatsapp_reminder_url}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            title="Enviar recordatorio y link de Google Calendar por WhatsApp"
                                            className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-bold transition shadow-2xs border border-emerald-200"
                                        >
                                            <MessageCircle className="w-3.5 h-3.5 text-emerald-600" />
                                            <span>WhatsApp</span>
                                        </a>

                                        {/* Acciones de Estado */}
                                        {app.status !== 'completed' && app.status !== 'cancelled' && (
                                            <>
                                                <button
                                                    onClick={() => handleStatusUpdate(app.id, 'completed')}
                                                    disabled={actionLoadingId === app.id}
                                                    title="Marcar como atendida"
                                                    className="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-2xs disabled:opacity-50"
                                                >
                                                    <Check className="w-3.5 h-3.5" />
                                                    <span>Atendida</span>
                                                </button>
                                                <button
                                                    onClick={() => handleStatusUpdate(app.id, 'cancelled')}
                                                    disabled={actionLoadingId === app.id}
                                                    title="Cancelar cita"
                                                    className="p-1.5 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition border border-transparent hover:border-rose-200"
                                                >
                                                    <X className="w-4 h-4" />
                                                </button>
                                            </>
                                        )}
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}
                </div>

                {/* 5. Tabla de Disponibilidad de Horarios del Día */}
                <div className="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs space-y-3">
                    <div className="flex items-center justify-between">
                        <div className="flex items-center gap-2">
                            <Clock className="w-4 h-4 text-blue-600" />
                            <h3 className="text-xs font-bold text-slate-800 uppercase tracking-wider">
                                Disponibilidad de Slots ({selectedDate})
                            </h3>
                        </div>
                        <span className="text-[11px] text-slate-500">
                            Bloques de 30 minutos sin colisiones
                        </span>
                    </div>

                    <div className="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-2 pt-1">
                        {availableSlots.map((slot, index) => (
                            <button
                                key={index}
                                disabled={!slot.is_available}
                                onClick={() => {
                                    setData('time', slot.time);
                                    setIsModalOpen(true);
                                }}
                                className={`p-2.5 rounded-xl border text-center transition flex flex-col items-center justify-between gap-1 ${
                                    slot.is_available
                                        ? 'bg-emerald-50/60 border-emerald-200/80 hover:bg-emerald-100 hover:border-emerald-300 text-emerald-900 cursor-pointer shadow-2xs'
                                        : 'bg-slate-50 border-slate-200 text-slate-400 cursor-not-allowed opacity-60'
                                }`}
                            >
                                <span className="text-xs font-bold">{slot.label}</span>
                                <span className={`text-[9px] font-semibold px-1.5 py-0.2 rounded ${
                                    slot.is_available ? 'bg-emerald-200/60 text-emerald-800' : 'bg-slate-200 text-slate-600'
                                }`}>
                                    {slot.is_available ? 'Libre ✓' : 'Ocupado'}
                                </span>
                            </button>
                        ))}
                    </div>
                </div>

            </div>

            {/* =========================================================
                 MODAL: AGENDAR CITA MÉDICA & GOOGLE CALENDAR SYNC
                 ========================================================= */}
            {isModalOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-200">
                    <div className="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 space-y-4 max-h-[90vh] overflow-y-auto">
                        
                        <div className="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div className="flex items-center gap-2">
                                <span className="p-2 rounded-xl bg-blue-50 text-blue-600 border border-blue-100">
                                    <CalendarDays className="w-5 h-5" />
                                </span>
                                <div>
                                    <h3 className="text-base font-black text-slate-900">Agendar Cita Médica</h3>
                                    <p className="text-[11px] text-slate-500">Sincronización instantánea con Google Calendar</p>
                                </div>
                            </div>
                            <button
                                onClick={() => setIsModalOpen(false)}
                                className="p-1.5 rounded-xl hover:bg-slate-100 text-slate-400 hover:text-slate-700 transition"
                            >
                                <X className="w-5 h-5" />
                            </button>
                        </div>

                        <form onSubmit={handleSubmitAppointment} className="space-y-4">
                            
                            {/* Paciente */}
                            <div className="space-y-1">
                                <label className="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <PawPrint className="w-3.5 h-3.5 text-blue-600" />
                                    <span>Seleccionar Paciente</span>
                                </label>
                                <select
                                    value={data.pet_id}
                                    onChange={(e) => setData('pet_id', e.target.value)}
                                    className="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-blue-500 outline-none"
                                >
                                    {pets.map((pet) => (
                                        <option key={pet.id} value={pet.id}>
                                            {pet.name} ({pet.breed}) — Tutor: {pet.customer_name}
                                        </option>
                                    ))}
                                </select>
                                {selectedPet && (
                                    <div className="text-[11px] text-slate-500 bg-blue-50/50 p-2 rounded-xl border border-blue-100/60 flex items-center justify-between">
                                        <span>📱 Tel: <strong>{selectedPet.customer_phone}</strong></span>
                                        <span className="text-blue-700 font-bold">{selectedPet.plan_name}</span>
                                    </div>
                                )}
                            </div>

                            {/* Tipo de Servicio / Beneficio */}
                            <div className="space-y-1">
                                <label className="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <FileText className="w-3.5 h-3.5 text-purple-600" />
                                    <span>Servicio o Beneficio</span>
                                </label>
                                <select
                                    value={data.service_type}
                                    onChange={(e) => setData('service_type', e.target.value)}
                                    className="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-blue-500 outline-none"
                                >
                                    <option value="Consulta General">Consulta Médica General</option>
                                    <option value="Vacunación Antirrábica">Vacunación Antirrábica</option>
                                    <option value="Vacunación Múltiple/Hexavalente">Vacunación Múltiple / Hexavalente</option>
                                    <option value="Desparasitación">Desparasitación Interna y Externa</option>
                                    <option value="Profilaxis Dental">Profilaxis Dental Básica</option>
                                    <option value="Control Posoperatorio">Control Posoperatorio</option>
                                    <option value="Urgencia Menor">Atención de Urgencia Menor</option>
                                </select>
                            </div>

                            {/* Profesional a Cargo */}
                            <div className="space-y-1">
                                <label className="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <Stethoscope className="w-3.5 h-3.5 text-emerald-600" />
                                    <span>Profesional a Cargo</span>
                                </label>
                                <select
                                    value={data.doctor_name}
                                    onChange={(e) => setData('doctor_name', e.target.value)}
                                    className="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-blue-500 outline-none"
                                >
                                    {doctors.map((doc, idx) => (
                                        <option key={idx} value={doc.name}>
                                            {doc.name} — {doc.role}
                                        </option>
                                    ))}
                                </select>
                            </div>

                            {/* Fecha y Hora */}
                            <div className="grid grid-cols-2 gap-3">
                                <div className="space-y-1">
                                    <label className="text-xs font-bold text-slate-700">Fecha</label>
                                    <input
                                        type="date"
                                        value={data.date}
                                        onChange={(e) => setData('date', e.target.value)}
                                        className="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-blue-500 outline-none"
                                    />
                                </div>
                                <div className="space-y-1">
                                    <label className="text-xs font-bold text-slate-700">Hora</label>
                                    <select
                                        value={data.time}
                                        onChange={(e) => setData('time', e.target.value)}
                                        className="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-blue-500 outline-none"
                                    >
                                        {availableSlots.map((slot, idx) => (
                                            <option key={idx} value={slot.time} disabled={!slot.is_available}>
                                                {slot.label} {slot.is_available ? '✓ Disponible' : '— (Ocupado)'}
                                            </option>
                                        ))}
                                    </select>
                                </div>
                            </div>

                            {/* Duración */}
                            <div className="space-y-1">
                                <label className="text-xs font-bold text-slate-700">Duración Estimada</label>
                                <div className="grid grid-cols-3 gap-2">
                                    {[30, 45, 60].map((mins) => (
                                        <button
                                            type="button"
                                            key={mins}
                                            onClick={() => setData('duration_minutes', mins)}
                                            className={`py-1.5 rounded-xl text-xs font-bold transition border ${
                                                data.duration_minutes === mins
                                                    ? 'bg-blue-600 text-white border-blue-600 shadow-2xs'
                                                    : 'bg-slate-50 text-slate-600 border-slate-200 hover:bg-slate-100'
                                            }`}
                                        >
                                            {mins} minutos
                                        </button>
                                    ))}
                                </div>
                            </div>

                            {/* Notas Clínicas */}
                            <div className="space-y-1">
                                <label className="text-xs font-bold text-slate-700">Notas / Motivo de Consulta</label>
                                <textarea
                                    value={data.notes}
                                    onChange={(e) => setData('notes', e.target.value)}
                                    placeholder="Ej: Paciente presenta prurito leve en oreja derecha, requiere revisión y refuerzo de vacuna."
                                    rows={2}
                                    className="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-blue-500 outline-none"
                                />
                            </div>

                            {/* Mensaje de error de validación */}
                            {errors.time && (
                                <div className="p-2.5 rounded-xl bg-rose-50 text-rose-700 border border-rose-200 text-xs flex items-center gap-2">
                                    <AlertCircle className="w-4 h-4 shrink-0 text-rose-600" />
                                    <span>{errors.time}</span>
                                </div>
                            )}

                            {/* Checkbox Sincronización Google */}
                            <div className="p-3 rounded-xl bg-amber-50/70 border border-amber-200/80 flex items-start gap-2.5 text-xs text-amber-900">
                                <CalendarIcon className="w-4 h-4 text-amber-600 shrink-0 mt-0.5" />
                                <div className="space-y-0.5">
                                    <p className="font-bold">Sincronización Instantánea con Google Calendar</p>
                                    <p className="text-[11px] text-amber-700">
                                        Al guardar, se generará el enlace directo para agregar el evento al Google Calendar del doctor y enviar la notificación automática al WhatsApp del tutor.
                                    </p>
                                </div>
                            </div>

                            {/* Botones de Envío */}
                            <div className="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                                <button
                                    type="button"
                                    onClick={() => setIsModalOpen(false)}
                                    className="px-4 py-2 text-xs font-bold text-slate-600 hover:text-slate-800 transition"
                                >
                                    Cancelar
                                </button>
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black transition shadow-xs disabled:opacity-50 flex items-center gap-2"
                                >
                                    {processing ? (
                                        <>
                                            <Sparkles className="w-3.5 h-3.5 animate-spin" />
                                            <span>Guardando...</span>
                                        </>
                                    ) : (
                                        <>
                                            <Check className="w-3.5 h-3.5" />
                                            <span>Confirmar y Sincronizar Cita</span>
                                        </>
                                    )}
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            )}

        </VetAdminLayout>
    );
}
