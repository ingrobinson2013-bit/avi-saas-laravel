import React, { useState } from 'react';
import { Head, router } from '@inertiajs/react';
import SuperAdminLayout from '@/Layouts/SuperAdminLayout';
import {
    Users as UsersIcon,
    Search,
    Plus,
    Stethoscope,
    Building2,
    UserCheck,
    Crown,
    Edit2,
    Trash2,
    LogIn,
    X,
    ChevronLeft,
    ChevronRight,
    ShieldCheck,
    Eye,
    EyeOff,
    Copy,
    Check,
    MessageCircle,
    KeyRound
} from 'lucide-react';

interface UserItem {
    id: string;
    name: string;
    email: string;
    role: string;
    tenant_id: string | null;
    tenant_name: string;
    tenant_slug: string;
    tenant_phone?: string | null;
    login_url?: string;
    is_protected?: boolean;
    created_at: string | null;
}

interface TenantOption {
    id: string;
    name: string;
    slug: string;
}

interface UsersProps {
    users: {
        data: UserItem[];
        current_page: number;
        last_page: number;
        total: number;
        prev_page_url: string | null;
        next_page_url: string | null;
    };
    filters: {
        search: string;
        role: string;
    };
    stats: {
        total: number;
        superAdmins: number;
        clinicStaff: number;
        reception: number;
    };
    tenantsList: TenantOption[];
    currentUserId?: string;
    userName?: string;
    userEmail?: string;
}

export default function Users({
    users,
    filters,
    stats,
    tenantsList = [],
    currentUserId,
    userName = 'Robinson Naranjo',
    userEmail = 'contacto@avipetapp.com'
}: UsersProps) {
    const [searchTerm, setSearchTerm] = useState(filters.search || '');
    const [selectedRole, setSelectedRole] = useState(filters.role || 'all');
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [editingUser, setEditingUser] = useState<UserItem | null>(null);
    const [submitting, setSubmitting] = useState(false);
    const [showPassword, setShowPassword] = useState(false);
    const [copiedCredentials, setCopiedCredentials] = useState(false);

    // Modal de confirmación para eliminar usuario (Reemplaza window.confirm)
    const [userToDelete, setUserToDelete] = useState<UserItem | null>(null);
    const [submittingDelete, setSubmittingDelete] = useState(false);

    const [formData, setFormData] = useState({
        name: '',
        email: '',
        role: 'clinic_admin',
        tenant_id: tenantsList[0]?.id || '',
        password: ''
    });

    const handleSearch = (e: React.FormEvent) => {
        e.preventDefault();
        router.get('/super-admin/users', { search: searchTerm, role: selectedRole }, { preserveState: true });
    };

    const handleRoleFilter = (role: string) => {
        setSelectedRole(role);
        router.get('/super-admin/users', { search: searchTerm, role }, { preserveState: true });
    };

    const handleOpenCreateModal = () => {
        setEditingUser(null);
        setShowPassword(true);
        setCopiedCredentials(false);
        setFormData({
            name: '',
            email: '',
            role: 'clinic_admin',
            tenant_id: tenantsList[0]?.id || '',
            password: 'AviPet2026*'
        });
        setIsModalOpen(true);
    };

    const handleOpenEditModal = (user: UserItem) => {
        setEditingUser(user);
        setShowPassword(false);
        setCopiedCredentials(false);
        setFormData({
            name: user.name,
            email: user.email,
            role: user.role,
            tenant_id: user.tenant_id || '',
            password: ''
        });
        setIsModalOpen(true);
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        setSubmitting(true);
        if (editingUser) {
            router.post(`/super-admin/users/${editingUser.id}/update`, formData, {
                onSuccess: () => setIsModalOpen(false),
                onFinish: () => setSubmitting(false)
            });
        } else {
            router.post('/super-admin/users', formData, {
                onSuccess: () => setIsModalOpen(false),
                onFinish: () => setSubmitting(false)
            });
        }
    };

    const confirmDeleteUser = () => {
        if (!userToDelete) return;
        setSubmittingDelete(true);
        router.post(
            `/super-admin/users/${userToDelete.id}/delete`,
            {},
            {
                onSuccess: () => setUserToDelete(null),
                onFinish: () => setSubmittingDelete(false)
            }
        );
    };

    const handleCopyCredentials = () => {
        const selectedTenant = tenantsList.find((t) => t.id === formData.tenant_id);
        const loginUrl =
            formData.role === 'super_admin'
                ? 'https://avipetapp.com/super-admin/login'
                : selectedTenant
                ? `https://${selectedTenant.slug}.avipetapp.com/admin/login`
                : 'https://avipetapp.com/admin/login';

        const text = `Hola ${formData.name || 'Dr(a).'}, estos son tus accesos a AviPetApp:\n🔗 Portal: ${loginUrl}\n📧 Usuario: ${formData.email}\n🔑 Contraseña: ${
            formData.password || '(Tu contraseña actual)'
        }`;
        navigator.clipboard.writeText(text);
        setCopiedCredentials(true);
        setTimeout(() => setCopiedCredentials(false), 2000);
    };

    const getRoleBadge = (role: string) => {
        switch (role) {
            case 'super_admin':
                return (
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#6D28D9]/10 text-[#6D28D9] border border-[#6D28D9]/25">
                        <Crown className="w-3.5 h-3.5 text-[#6D28D9]" />
                        <span>SuperAdmin</span>
                    </span>
                );
            case 'clinic_admin':
                return (
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#0E7490]/10 text-[#0E7490] border border-[#0E7490]/25">
                        <Building2 className="w-3.5 h-3.5 text-[#0E7490]" />
                        <span>Director de clínica</span>
                    </span>
                );
            case 'vet_doctor':
                return (
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#0F9F9A]/10 text-[#0F9F9A] border border-[#0F9F9A]/25">
                        <Stethoscope className="w-3.5 h-3.5 text-[#0F9F9A]" />
                        <span>Médico veterinario</span>
                    </span>
                );
            case 'reception':
                return (
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#B45309]/10 text-[#B45309] border border-[#B45309]/25">
                        <UserCheck className="w-3.5 h-3.5 text-[#B45309]" />
                        <span>Recepción</span>
                    </span>
                );
            default:
                return (
                    <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-[#15213B] border border-slate-200">
                        {role}
                    </span>
                );
        }
    };

    const getInitials = (name: string) => {
        return (
            name
                .split(' ')
                .filter(Boolean)
                .slice(0, 2)
                .map((w) => w[0].toUpperCase())
                .join('') || 'U'
        );
    };

    // Filtrado instantáneo en cliente
    const visibleUsers = users.data.filter((u) => {
        if (selectedRole !== 'all' && u.role !== selectedRole) {
            return false;
        }
        if (searchTerm.trim() !== '') {
            const q = searchTerm.toLowerCase().trim();
            const haystack = [u.name, u.email, u.tenant_name, u.tenant_slug]
                .filter(Boolean)
                .join(' ')
                .toLowerCase();
            return haystack.includes(q);
        }
        return true;
    });

    return (
        <SuperAdminLayout userName={userName} userEmail={userEmail} activeItem="Usuarios y doctores">
            <Head title="Usuarios y doctores · AviPetApp Superadmin" />

            <div className="space-y-6 max-w-full text-[#15213B]">
                {/* HEADER */}
                <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 className="text-[28px] sm:text-[32px] font-bold text-[#15213B] tracking-tight leading-tight">
                            Usuarios y doctores
                        </h1>
                        <p className="text-sm text-[#5C6B85] mt-1">
                            Gestión centralizada de credenciales de acceso para SuperAdministradores, directores médicos y recepcionistas.
                        </p>
                    </div>

                    <button
                        onClick={handleOpenCreateModal}
                        className="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-semibold text-sm shadow-xs transition self-start sm:self-auto cursor-pointer"
                    >
                        <Plus className="w-4 h-4" />
                        <span>Crear usuario</span>
                    </button>
                </div>

                {/* 4 KPI CARDS (Manual Maestro v1.1) */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 tabular-nums">
                    <div className="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-2xs flex items-center justify-between">
                        <div>
                            <span className="text-xs font-semibold uppercase tracking-wider text-[#5C6B85]">
                                Total usuarios
                            </span>
                            <div className="text-2xl font-bold text-[#15213B] mt-1">{stats.total}</div>
                            <div className="text-xs font-medium text-[#5C6B85] mt-1">
                                Cuentas con credenciales
                            </div>
                        </div>
                        <div className="w-12 h-12 rounded-xl bg-[#F4F7FC] text-[#15213B] flex items-center justify-center shrink-0">
                            <UsersIcon className="w-6 h-6" />
                        </div>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-2xs flex items-center justify-between">
                        <div>
                            <span className="text-xs font-semibold uppercase tracking-wider text-[#5C6B85]">
                                SuperAdministradores
                            </span>
                            <div className="text-2xl font-bold text-[#6D28D9] mt-1">{stats.superAdmins}</div>
                            <div className="text-xs font-medium text-[#6D28D9] mt-1">
                                Control maestro AviPetApp
                            </div>
                        </div>
                        <div className="w-12 h-12 rounded-xl bg-[#6D28D9]/10 text-[#6D28D9] flex items-center justify-center shrink-0">
                            <Crown className="w-6 h-6" />
                        </div>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-2xs flex items-center justify-between">
                        <div>
                            <span className="text-xs font-semibold uppercase tracking-wider text-[#5C6B85]">
                                Médicos y directores
                            </span>
                            <div className="text-2xl font-bold text-[#0E7490] mt-1">{stats.clinicStaff}</div>
                            <div className="text-xs font-medium text-[#0E7490] mt-1">
                                Personal en clínicas
                            </div>
                        </div>
                        <div className="w-12 h-12 rounded-xl bg-[#0E7490]/10 text-[#0E7490] flex items-center justify-center shrink-0">
                            <Stethoscope className="w-6 h-6" />
                        </div>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-2xs flex items-center justify-between">
                        <div>
                            <span className="text-xs font-semibold uppercase tracking-wider text-[#5C6B85]">
                                Recepción / Mostrador
                            </span>
                            <div className="text-2xl font-bold text-[#B45309] mt-1">{stats.reception}</div>
                            <div className="text-xs font-medium text-[#B45309] mt-1">
                                Canje y validación QR
                            </div>
                        </div>
                        <div className="w-12 h-12 rounded-xl bg-[#B45309]/10 text-[#B45309] flex items-center justify-center shrink-0">
                            <UserCheck className="w-6 h-6" />
                        </div>
                    </div>
                </div>

                {/* FILTERS & SEARCH */}
                <div className="bg-white rounded-2xl border border-slate-200/90 p-4 shadow-2xs flex flex-col md:flex-row gap-4 justify-between items-stretch md:items-center">
                    {/* Role Filter Tabs */}
                    <div className="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0 scrollbar-none">
                        <button
                            type="button"
                            onClick={() => handleRoleFilter('all')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-semibold transition-all cursor-pointer whitespace-nowrap ${
                                selectedRole === 'all'
                                    ? 'bg-[#6D28D9] text-white shadow-2xs'
                                    : 'text-[#5C6B85] hover:bg-[#F4F7FC]'
                            }`}
                        >
                            Todos ({users.total})
                        </button>
                        <button
                            type="button"
                            onClick={() => handleRoleFilter('super_admin')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-semibold transition-all cursor-pointer whitespace-nowrap ${
                                selectedRole === 'super_admin'
                                    ? 'bg-[#6D28D9] text-white shadow-2xs'
                                    : 'text-[#5C6B85] hover:bg-[#F4F7FC]'
                            }`}
                        >
                            SuperAdmin
                        </button>
                        <button
                            type="button"
                            onClick={() => handleRoleFilter('clinic_admin')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-semibold transition-all cursor-pointer whitespace-nowrap ${
                                selectedRole === 'clinic_admin'
                                    ? 'bg-[#0E7490] text-white shadow-2xs'
                                    : 'text-[#5C6B85] hover:bg-[#F4F7FC]'
                            }`}
                        >
                            Director clínico
                        </button>
                        <button
                            type="button"
                            onClick={() => handleRoleFilter('vet_doctor')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-semibold transition-all cursor-pointer whitespace-nowrap ${
                                selectedRole === 'vet_doctor'
                                    ? 'bg-[#0F9F9A] text-white shadow-2xs'
                                    : 'text-[#5C6B85] hover:bg-[#F4F7FC]'
                            }`}
                        >
                            Veterinarios
                        </button>
                        <button
                            type="button"
                            onClick={() => handleRoleFilter('reception')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-semibold transition-all cursor-pointer whitespace-nowrap ${
                                selectedRole === 'reception'
                                    ? 'bg-[#B45309] text-white shadow-2xs'
                                    : 'text-[#5C6B85] hover:bg-[#F4F7FC]'
                            }`}
                        >
                            Recepción
                        </button>
                    </div>

                    {/* Search Bar */}
                    <form onSubmit={handleSearch} className="relative w-full md:w-72">
                        <Search className="w-4 h-4 text-[#5C6B85] absolute left-3 top-1/2 -translate-y-1/2" />
                        <input
                            type="text"
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                            placeholder="Buscar por nombre, correo o clínica..."
                            className="w-full pl-9 pr-3 py-2 bg-[#F4F7FC] border border-slate-200 rounded-xl text-xs text-[#15213B] placeholder-[#5C6B85] focus:outline-hidden focus:ring-2 focus:ring-[#6D28D9] focus:bg-white transition"
                        />
                    </form>
                </div>

                {/* USERS TABLE */}
                <div className="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left text-xs text-[#5C6B85] tabular-nums">
                            <thead className="bg-[#F4F7FC] border-b border-slate-200 text-[#5C6B85] font-bold uppercase tracking-wider text-[11px]">
                                <tr>
                                    <th className="py-3.5 px-4">Usuario</th>
                                    <th className="py-3.5 px-4">Correo electrónico</th>
                                    <th className="py-3.5 px-4">Rol en el sistema</th>
                                    <th className="py-3.5 px-4">Clínica asociada</th>
                                    <th className="py-3.5 px-4">Fecha creación</th>
                                    <th className="py-3.5 px-4 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100">
                                {visibleUsers.length === 0 ? (
                                    <tr>
                                        <td colSpan={6} className="text-center py-12 text-[#5C6B85]">
                                            <UsersIcon className="w-10 h-10 mx-auto text-slate-300 mb-2" />
                                            No se encontraron usuarios con los filtros aplicados.
                                        </td>
                                    </tr>
                                ) : (
                                    visibleUsers.map((u) => {
                                        const isProtected =
                                            u.is_protected ||
                                            currentUserId === u.id ||
                                            u.role === 'super_admin' ||
                                            u.email === 'contacto@avipetapp.com' ||
                                            u.email === 'petmovilveterinario@gmail.com';

                                        return (
                                            <tr key={u.id} className="hover:bg-[#F4F7FC]/70 transition-colors">
                                                <td className="py-3.5 px-4">
                                                    <div className="flex items-center gap-3">
                                                        <div
                                                            className={`w-9 h-9 rounded-xl font-bold flex items-center justify-center shrink-0 border text-xs ${
                                                                u.role === 'super_admin'
                                                                    ? 'bg-[#6D28D9]/10 text-[#6D28D9] border-[#6D28D9]/25'
                                                                    : 'bg-[#0E7490]/10 text-[#0E7490] border-[#0E7490]/25'
                                                            }`}
                                                        >
                                                            {getInitials(u.name)}
                                                        </div>
                                                        <div>
                                                            <div className="font-bold text-[#15213B] flex items-center gap-1.5">
                                                                <span>{u.name}</span>
                                                                {isProtected && (
                                                                    <span
                                                                        title="Cuenta principal protegida"
                                                                        className="inline-flex items-center text-[#0F9F9A]"
                                                                    >
                                                                        <ShieldCheck className="w-3.5 h-3.5" />
                                                                    </span>
                                                                )}
                                                            </div>
                                                            <div className="text-[10px] text-[#5C6B85] font-mono">
                                                                ID: {u.id.substring(0, 8)}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td className="py-3.5 px-4">
                                                    <div className="font-medium text-[#15213B]">{u.email}</div>
                                                </td>

                                                <td className="py-3.5 px-4">{getRoleBadge(u.role)}</td>

                                                <td className="py-3.5 px-4">
                                                    <div className="font-semibold text-[#15213B] flex items-center gap-1.5">
                                                        {u.tenant_id ? (
                                                            <>
                                                                <Building2 className="w-3.5 h-3.5 text-[#0E7490] shrink-0" />
                                                                <span>{u.tenant_name}</span>
                                                            </>
                                                        ) : (
                                                            <span className="inline-flex items-center gap-1.5 text-[#6D28D9] font-bold">
                                                                <Crown className="w-3.5 h-3.5" />
                                                                <span>Central AviPetApp</span>
                                                            </span>
                                                        )}
                                                    </div>
                                                </td>

                                                <td className="py-3.5 px-4 text-[#5C6B85]">
                                                    {u.created_at || 'N/A'}
                                                </td>

                                                <td className="py-3.5 px-4 text-right">
                                                    <div className="flex items-center justify-end gap-1.5">
                                                        {u.tenant_id && (
                                                            <a
                                                                href={`/impersonate-clinic/${u.tenant_id}`}
                                                                title="Abrir panel de esta clínica"
                                                                className="p-1.5 rounded-lg text-[#5C6B85] hover:text-[#0F9F9A] hover:bg-[#0F9F9A]/10 transition-colors"
                                                            >
                                                                <LogIn className="w-4 h-4" />
                                                            </a>
                                                        )}

                                                        <button
                                                            onClick={() => handleOpenEditModal(u)}
                                                            title="Editar datos o contraseña del usuario"
                                                            className="p-1.5 rounded-lg text-[#5C6B85] hover:text-[#6D28D9] hover:bg-[#6D28D9]/10 transition-colors cursor-pointer"
                                                        >
                                                            <Edit2 className="w-4 h-4" />
                                                        </button>

                                                        {!isProtected && (
                                                            <button
                                                                onClick={() => setUserToDelete(u)}
                                                                title="Eliminar usuario"
                                                                className="p-1.5 rounded-lg text-[#5C6B85] hover:text-[#B91C1C] hover:bg-[#B91C1C]/10 transition-colors cursor-pointer"
                                                            >
                                                                <Trash2 className="w-4 h-4" />
                                                            </button>
                                                        )}
                                                    </div>
                                                </td>
                                            </tr>
                                        );
                                    })
                                )}
                            </tbody>
                        </table>
                    </div>

                    {/* PAGINATION */}
                    {users.last_page > 1 && (
                        <div className="p-4 border-t border-slate-200 flex items-center justify-between">
                            <span className="text-xs text-[#5C6B85]">
                                Página {users.current_page} de {users.last_page} ({users.total} usuarios)
                            </span>
                            <div className="flex items-center gap-2">
                                {users.prev_page_url && (
                                    <button
                                        onClick={() => router.get(users.prev_page_url!)}
                                        className="p-1.5 rounded-lg border border-slate-200 hover:bg-[#F4F7FC] text-[#15213B] cursor-pointer"
                                    >
                                        <ChevronLeft className="w-4 h-4" />
                                    </button>
                                )}
                                {users.next_page_url && (
                                    <button
                                        onClick={() => router.get(users.next_page_url!)}
                                        className="p-1.5 rounded-lg border border-slate-200 hover:bg-[#F4F7FC] text-[#15213B] cursor-pointer"
                                    >
                                        <ChevronRight className="w-4 h-4" />
                                    </button>
                                )}
                            </div>
                        </div>
                    )}
                </div>

                {/* MODAL 1: CREAR / EDITAR USUARIO */}
                {isModalOpen && (
                    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#080B20]/60 backdrop-blur-xs overflow-y-auto">
                        <div className="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
                            <div className="flex items-center justify-between border-b border-slate-100 pb-3">
                                <h3 className="text-base font-bold text-[#15213B] flex items-center gap-2">
                                    <KeyRound className="w-5 h-5 text-[#6D28D9]" />
                                    <span>{editingUser ? 'Editar usuario y credenciales' : 'Crear nuevo usuario'}</span>
                                </h3>
                                <button
                                    onClick={() => setIsModalOpen(false)}
                                    className="p-1 rounded-lg text-[#5C6B85] hover:text-[#15213B] hover:bg-slate-100 cursor-pointer"
                                >
                                    <X className="w-5 h-5" />
                                </button>
                            </div>

                            <form onSubmit={handleSubmit} className="space-y-3.5 text-xs">
                                <div>
                                    <label className="block font-semibold text-[#15213B] mb-1">
                                        Nombre completo *
                                    </label>
                                    <input
                                        type="text"
                                        value={formData.name}
                                        onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                                        placeholder="Ej. Dra. Camila Torres"
                                        className="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-[#15213B] focus:outline-hidden focus:ring-2 focus:ring-[#6D28D9]"
                                        required
                                    />
                                </div>

                                <div>
                                    <label className="block font-semibold text-[#15213B] mb-1">
                                        Correo electrónico (Login) *
                                    </label>
                                    <input
                                        type="email"
                                        value={formData.email}
                                        onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                                        placeholder="doctor@clinica.com"
                                        className="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-[#15213B] focus:outline-hidden focus:ring-2 focus:ring-[#6D28D9]"
                                        required
                                    />
                                </div>

                                <div>
                                    <label className="block font-semibold text-[#15213B] mb-1">
                                        Rol en el sistema
                                    </label>
                                    <select
                                        value={formData.role}
                                        onChange={(e) => setFormData({ ...formData, role: e.target.value })}
                                        className="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-[#15213B] focus:outline-hidden focus:ring-2 focus:ring-[#6D28D9]"
                                    >
                                        <option value="super_admin">SuperAdministrador (Central AviPetApp)</option>
                                        <option value="clinic_admin">Director de clínica</option>
                                        <option value="vet_doctor">Médico veterinario</option>
                                        <option value="reception">Recepcionista / Mostrador</option>
                                    </select>
                                </div>

                                {formData.role !== 'super_admin' && (
                                    <div>
                                        <label className="block font-semibold text-[#15213B] mb-1">
                                            Clínica veterinaria asociada
                                        </label>
                                        <select
                                            value={formData.tenant_id}
                                            onChange={(e) => setFormData({ ...formData, tenant_id: e.target.value })}
                                            className="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-[#15213B] focus:outline-hidden focus:ring-2 focus:ring-[#6D28D9]"
                                            required={formData.role !== 'super_admin'}
                                        >
                                            <option value="">Selecciona una clínica...</option>
                                            {tenantsList.map((t) => (
                                                <option key={t.id} value={t.id}>
                                                    {t.name} ({t.slug}.avipetapp.com)
                                                </option>
                                            ))}
                                        </select>
                                    </div>
                                )}

                                <div>
                                    <div className="flex items-center justify-between mb-1">
                                        <label className="font-semibold text-[#15213B]">
                                            Contraseña{' '}
                                            {editingUser && (
                                                <span className="font-normal text-[#5C6B85]">
                                                    (dejar vacío para no cambiar)
                                                </span>
                                            )}
                                        </label>
                                        <button
                                            type="button"
                                            onClick={() => {
                                                setShowPassword(true);
                                                setFormData({ ...formData, password: 'AviPet2026*' });
                                            }}
                                            className="text-[11px] font-semibold text-[#6D28D9] hover:underline"
                                        >
                                            Sugerir clave
                                        </button>
                                    </div>
                                    <div className="relative">
                                        <input
                                            type={showPassword ? 'text' : 'password'}
                                            value={formData.password}
                                            onChange={(e) => setFormData({ ...formData, password: e.target.value })}
                                            placeholder={editingUser ? '••••••••' : 'Mínimo 6 caracteres'}
                                            className="w-full bg-white border border-slate-200 rounded-xl pl-3 pr-10 py-2.5 text-[#15213B] font-mono focus:outline-hidden focus:ring-2 focus:ring-[#6D28D9]"
                                            required={!editingUser}
                                        />
                                        <button
                                            type="button"
                                            onClick={() => setShowPassword(!showPassword)}
                                            className="absolute right-3 top-1/2 -translate-y-1/2 text-[#5C6B85] hover:text-[#15213B]"
                                        >
                                            {showPassword ? (
                                                <EyeOff className="w-4 h-4" />
                                            ) : (
                                                <Eye className="w-4 h-4" />
                                            )}
                                        </button>
                                    </div>
                                </div>

                                <div className="flex items-center justify-between pt-3 border-t border-slate-100">
                                    <button
                                        type="button"
                                        onClick={handleCopyCredentials}
                                        className="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-[#0E7490] bg-[#0E7490]/10 hover:bg-[#0E7490]/15 transition cursor-pointer"
                                    >
                                        {copiedCredentials ? (
                                            <>
                                                <Check className="w-3.5 h-3.5 text-[#0F9F9A]" />
                                                <span>Accesos copiados</span>
                                            </>
                                        ) : (
                                            <>
                                                <Copy className="w-3.5 h-3.5" />
                                                <span>Copiar accesos</span>
                                            </>
                                        )}
                                    </button>

                                    <div className="flex items-center gap-2">
                                        <button
                                            type="button"
                                            onClick={() => setIsModalOpen(false)}
                                            className="px-4 py-2 rounded-xl text-xs font-semibold text-[#6D28D9] border border-[#6D28D9] hover:bg-[#6D28D9]/5 cursor-pointer"
                                        >
                                            Cancelar
                                        </button>
                                        <button
                                            type="submit"
                                            disabled={submitting}
                                            className="px-5 py-2 rounded-xl text-xs font-semibold bg-[#6D28D9] hover:bg-[#5B21B6] text-white shadow-xs cursor-pointer disabled:opacity-60"
                                        >
                                            {submitting ? 'Guardando...' : 'Guardar'}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                )}

                {/* MODAL 2: CONFIRMACIÓN DE ELIMINACIÓN (Manual Maestro v1.1 Error Red #B91C1C) */}
                {userToDelete && (
                    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#080B20]/60 backdrop-blur-xs">
                        <div className="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
                            <div className="flex items-start justify-between">
                                <div className="flex items-center gap-2.5">
                                    <div className="w-10 h-10 rounded-xl bg-[#B91C1C]/10 text-[#B91C1C] flex items-center justify-center shrink-0">
                                        <Trash2 className="w-5 h-5" />
                                    </div>
                                    <div>
                                        <h3 className="text-base font-bold text-[#15213B]">Eliminar usuario</h3>
                                        <p className="text-xs text-[#5C6B85]">{userToDelete.email}</p>
                                    </div>
                                </div>
                                <button
                                    onClick={() => setUserToDelete(null)}
                                    className="text-[#5C6B85] hover:text-[#15213B] p-1"
                                >
                                    <X className="w-5 h-5" />
                                </button>
                            </div>

                            <p className="text-xs text-[#5C6B85] leading-relaxed">
                                ¿Confirmas que deseas revocar el acceso y eliminar permanentemente al usuario{' '}
                                <b className="text-[#15213B]">{userToDelete.name}</b> ({userToDelete.tenant_name})?
                            </p>

                            <div className="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                                <button
                                    type="button"
                                    onClick={() => setUserToDelete(null)}
                                    className="px-4 py-2 rounded-xl text-xs font-semibold text-[#6D28D9] border border-[#6D28D9] hover:bg-[#6D28D9]/5 cursor-pointer"
                                >
                                    Cancelar
                                </button>
                                <button
                                    type="button"
                                    disabled={submittingDelete}
                                    onClick={confirmDeleteUser}
                                    className="px-5 py-2 rounded-xl text-xs font-semibold bg-[#B91C1C] hover:bg-[#991B1B] text-white shadow-xs cursor-pointer disabled:opacity-60"
                                >
                                    {submittingDelete ? 'Eliminando...' : 'Eliminar'}
                                </button>
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </SuperAdminLayout>
    );
}
