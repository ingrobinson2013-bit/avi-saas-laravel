import React, { useState } from 'react';
import { Head, router } from '@inertiajs/react';
import SuperAdminLayout from '@/Layouts/SuperAdminLayout';
import { 
    Users as UsersIcon, 
    Search, 
    Plus, 
    Shield, 
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
    Key,
    Mail,
    CheckCircle2
} from 'lucide-react';

interface UserItem {
    id: string;
    name: string;
    email: string;
    role: string;
    tenant_id: string | null;
    tenant_name: string;
    tenant_slug: string;
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
    userEmail = 'superadmin@avipetapp.com'
}: UsersProps) {
    const [searchTerm, setSearchTerm] = useState(filters.search || '');
    const [selectedRole, setSelectedRole] = useState(filters.role || 'all');
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [editingUser, setEditingUser] = useState<UserItem | null>(null);

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
        setFormData({
            name: '',
            email: '',
            role: 'clinic_admin',
            tenant_id: tenantsList[0]?.id || '',
            password: ''
        });
        setIsModalOpen(true);
    };

    const handleOpenEditModal = (user: UserItem) => {
        setEditingUser(user);
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
        if (editingUser) {
            router.post(`/super-admin/users/${editingUser.id}/update`, formData, {
                onSuccess: () => setIsModalOpen(false)
            });
        } else {
            router.post('/super-admin/users', formData, {
                onSuccess: () => setIsModalOpen(false)
            });
        }
    };

    const handleDeleteUser = (id: string, name: string) => {
        if (confirm(`¿Estás seguro de que deseas eliminar al usuario "${name}"? Esta acción no se puede deshacer.`)) {
            router.post(`/super-admin/users/${id}/delete`);
        }
    };

    const getRoleBadge = (role: string) => {
        switch (role) {
            case 'super_admin':
                return (
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-purple-50 text-purple-700 border border-purple-200">
                        <Crown className="w-3.5 h-3.5 text-purple-600" />
                        SuperAdmin
                    </span>
                );
            case 'clinic_admin':
                return (
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-teal-50 text-teal-700 border border-teal-200">
                        <Building2 className="w-3.5 h-3.5 text-teal-600" />
                        Director de Clínica
                    </span>
                );
            case 'vet_doctor':
                return (
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <Stethoscope className="w-3.5 h-3.5 text-emerald-600" />
                        Médico Veterinario
                    </span>
                );
            case 'reception':
                return (
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                        <UserCheck className="w-3.5 h-3.5 text-amber-600" />
                        Recepción
                    </span>
                );
            default:
                return (
                    <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                        {role}
                    </span>
                );
        }
    };

    const getInitials = (name: string) => {
        return name
            .split(' ')
            .filter(Boolean)
            .slice(0, 2)
            .map(w => w[0].toUpperCase())
            .join('') || 'U';
    };

    return (
        <SuperAdminLayout
            userName={userName}
            userEmail={userEmail}
            activeItem="Usuarios y doctores"
        >
            <Head title="Usuarios y Doctores - SuperAdmin" />

            <div className="space-y-6 max-w-full">
                {/* HEADER */}
                <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 className="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                            <UsersIcon className="w-7 h-7 text-teal-600" />
                            Usuarios y Doctores
                        </h1>
                        <p className="text-sm text-slate-500 mt-1">
                            Gestión centralizada de credenciales de acceso para SuperAdministradores, directores médicos y recepcionistas.
                        </p>
                    </div>

                    <button
                        onClick={handleOpenCreateModal}
                        className="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white font-bold text-sm shadow-sm transition-all shadow-teal-600/20 hover:shadow-teal-600/30 self-start sm:self-auto cursor-pointer"
                    >
                        <Plus className="w-4 h-4" />
                        Nuevo Usuario
                    </button>
                </div>

                {/* 4 KPI CARDS */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div className="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
                        <div>
                            <span className="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Usuarios</span>
                            <div className="text-2xl font-black text-slate-900 mt-1">{stats.total}</div>
                            <div className="text-xs font-medium text-slate-500 mt-1">Cuentas con credenciales</div>
                        </div>
                        <div className="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                            <UsersIcon className="w-6 h-6" />
                        </div>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
                        <div>
                            <span className="text-xs font-semibold uppercase tracking-wider text-slate-500">SuperAdministradores</span>
                            <div className="text-2xl font-black text-purple-600 mt-1">{stats.superAdmins}</div>
                            <div className="text-xs font-medium text-purple-600 mt-1">Control maestro NODIA</div>
                        </div>
                        <div className="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                            <Crown className="w-6 h-6" />
                        </div>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
                        <div>
                            <span className="text-xs font-semibold uppercase tracking-wider text-slate-500">Médicos y Directores</span>
                            <div className="text-2xl font-black text-teal-600 mt-1">{stats.clinicStaff}</div>
                            <div className="text-xs font-medium text-teal-600 mt-1">Personal en clínicas</div>
                        </div>
                        <div className="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                            <Stethoscope className="w-6 h-6" />
                        </div>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
                        <div>
                            <span className="text-xs font-semibold uppercase tracking-wider text-slate-500">Recepción / Mostrador</span>
                            <div className="text-2xl font-black text-amber-600 mt-1">{stats.reception}</div>
                            <div className="text-xs font-medium text-amber-600 mt-1">Canje y validación</div>
                        </div>
                        <div className="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                            <UserCheck className="w-6 h-6" />
                        </div>
                    </div>
                </div>

                {/* FILTERS & SEARCH */}
                <div className="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs flex flex-col md:flex-row gap-4 justify-between items-stretch md:items-center">
                    {/* Role Filter Tabs */}
                    <div className="flex items-center gap-1 overflow-x-auto pb-1 md:pb-0 scrollbar-none">
                        <button
                            type="button"
                            onClick={() => handleRoleFilter('all')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                                selectedRole === 'all'
                                    ? 'bg-teal-600 text-white shadow-xs'
                                    : 'text-slate-600 hover:bg-slate-100'
                            }`}
                        >
                            Todos ({users.total})
                        </button>
                        <button
                            type="button"
                            onClick={() => handleRoleFilter('super_admin')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                                selectedRole === 'super_admin'
                                    ? 'bg-purple-600 text-white shadow-xs'
                                    : 'text-slate-600 hover:bg-slate-100'
                            }`}
                        >
                            SuperAdmin
                        </button>
                        <button
                            type="button"
                            onClick={() => handleRoleFilter('clinic_admin')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                                selectedRole === 'clinic_admin'
                                    ? 'bg-teal-600 text-white shadow-xs'
                                    : 'text-slate-600 hover:bg-slate-100'
                            }`}
                        >
                            Director Clínica
                        </button>
                        <button
                            type="button"
                            onClick={() => handleRoleFilter('vet_doctor')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                                selectedRole === 'vet_doctor'
                                    ? 'bg-emerald-600 text-white shadow-xs'
                                    : 'text-slate-600 hover:bg-slate-100'
                            }`}
                        >
                            Veterinarios
                        </button>
                        <button
                            type="button"
                            onClick={() => handleRoleFilter('reception')}
                            className={`px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                                selectedRole === 'reception'
                                    ? 'bg-amber-600 text-white shadow-xs'
                                    : 'text-slate-600 hover:bg-slate-100'
                            }`}
                        >
                            Recepción
                        </button>
                    </div>

                    {/* Search */}
                    <form onSubmit={handleSearch} className="relative w-full md:w-72">
                        <Search className="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
                        <input
                            type="text"
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                            placeholder="Buscar por nombre o correo..."
                            className="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500"
                        />
                    </form>
                </div>

                {/* USERS TABLE */}
                <div className="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left text-xs text-slate-600">
                            <thead className="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[11px]">
                                <tr>
                                    <th className="py-3.5 px-4">Usuario</th>
                                    <th className="py-3.5 px-4">Correo Electrónico</th>
                                    <th className="py-3.5 px-4">Rol en el Sistema</th>
                                    <th className="py-3.5 px-4">Clínica Asociada</th>
                                    <th className="py-3.5 px-4">Fecha Creación</th>
                                    <th className="py-3.5 px-4 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100">
                                {users.data.length === 0 ? (
                                    <tr>
                                        <td colSpan={6} className="text-center py-12 text-slate-400">
                                            <UsersIcon className="w-10 h-10 mx-auto text-slate-300 mb-2" />
                                            No se encontraron usuarios con los filtros aplicados.
                                        </td>
                                    </tr>
                                ) : (
                                    users.data.map((u) => (
                                        <tr key={u.id} className="hover:bg-slate-50/70 transition-colors">
                                            <td className="py-3.5 px-4">
                                                <div className="flex items-center gap-3">
                                                    <div className="w-9 h-9 rounded-xl bg-teal-50 text-teal-700 font-black flex items-center justify-center shrink-0 border border-teal-200 text-xs">
                                                        {getInitials(u.name)}
                                                    </div>
                                                    <div>
                                                        <div className="font-bold text-slate-900">{u.name}</div>
                                                        <div className="text-[10px] text-slate-400 font-mono">ID: {u.id.substring(0, 8)}</div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td className="py-3.5 px-4">
                                                <div className="font-medium text-slate-800">{u.email}</div>
                                            </td>

                                            <td className="py-3.5 px-4">
                                                {getRoleBadge(u.role)}
                                            </td>

                                            <td className="py-3.5 px-4">
                                                <div className="font-semibold text-slate-800 flex items-center gap-1.5">
                                                    {u.tenant_id ? (
                                                        <>
                                                            <Building2 className="w-3.5 h-3.5 text-teal-600 shrink-0" />
                                                            <span>{u.tenant_name}</span>
                                                        </>
                                                    ) : (
                                                        <span className="text-purple-700 font-bold">👑 Central AviPetApp</span>
                                                    )}
                                                </div>
                                            </td>

                                            <td className="py-3.5 px-4 text-slate-500">
                                                {u.created_at || 'N/A'}
                                            </td>

                                            <td className="py-3.5 px-4 text-right">
                                                <div className="flex items-center justify-end gap-1.5">
                                                    {u.tenant_id && (
                                                        <a
                                                            href={`/impersonate-clinic/${u.tenant_id}`}
                                                            title="Impersonar panel de esta clínica"
                                                            className="p-1.5 rounded-lg text-slate-500 hover:text-teal-600 hover:bg-teal-50 transition-colors"
                                                        >
                                                            <LogIn className="w-4 h-4" />
                                                        </a>
                                                    )}

                                                    <button
                                                        onClick={() => handleOpenEditModal(u)}
                                                        title="Editar datos del usuario"
                                                        className="p-1.5 rounded-lg text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition-colors cursor-pointer"
                                                    >
                                                        <Edit2 className="w-4 h-4" />
                                                    </button>

                                                    {currentUserId !== u.id && u.role !== 'super_admin' && u.email !== 'contacto@avipetapp.com' && (
                                                        <button
                                                            onClick={() => handleDeleteUser(u.id, u.name)}
                                                            title="Eliminar usuario"
                                                            className="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer"
                                                        >
                                                            <Trash2 className="w-4 h-4" />
                                                        </button>
                                                    )}
                                                </div>
                                            </td>
                                        </tr>
                                    ))
                                )}
                            </tbody>
                        </table>
                    </div>

                    {/* PAGINATION */}
                    {users.last_page > 1 && (
                        <div className="p-4 border-t border-slate-200 flex items-center justify-between">
                            <span className="text-xs text-slate-500">
                                Página {users.current_page} de {users.last_page} ({users.total} usuarios)
                            </span>
                            <div className="flex items-center gap-2">
                                {users.prev_page_url && (
                                    <button
                                        onClick={() => router.get(users.prev_page_url!)}
                                        className="p-1.5 rounded-lg border border-slate-200 hover:bg-slate-100 text-slate-600 cursor-pointer"
                                    >
                                        <ChevronLeft className="w-4 h-4" />
                                    </button>
                                )}
                                {users.next_page_url && (
                                    <button
                                        onClick={() => router.get(users.next_page_url!)}
                                        className="p-1.5 rounded-lg border border-slate-200 hover:bg-slate-100 text-slate-600 cursor-pointer"
                                    >
                                        <ChevronRight className="w-4 h-4" />
                                    </button>
                                )}
                            </div>
                        </div>
                    )}
                </div>

                {/* MODAL: CREAR / EDITAR USUARIO */}
                {isModalOpen && (
                    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
                        <div className="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4 animate-in fade-in zoom-in-95 duration-150">
                            <div className="flex items-center justify-between border-b border-slate-100 pb-3">
                                <h3 className="text-base font-bold text-slate-900 flex items-center gap-2">
                                    <UsersIcon className="w-5 h-5 text-teal-600" />
                                    {editingUser ? 'Editar Usuario' : 'Nuevo Usuario'}
                                </h3>
                                <button
                                    onClick={() => setIsModalOpen(false)}
                                    className="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 cursor-pointer"
                                >
                                    <X className="w-5 h-5" />
                                </button>
                            </div>

                            <form onSubmit={handleSubmit} className="space-y-3.5">
                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">Nombre Completo</label>
                                    <input
                                        type="text"
                                        value={formData.name}
                                        onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                                        placeholder="Ej. Dr. Robinson Naranjo"
                                        className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                        required
                                    />
                                </div>

                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">Correo Electrónico (Login)</label>
                                    <input
                                        type="email"
                                        value={formData.email}
                                        onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                                        placeholder="doctor@clinica.com"
                                        className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                        required
                                    />
                                </div>

                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">Rol en el Sistema</label>
                                    <select
                                        value={formData.role}
                                        onChange={(e) => setFormData({ ...formData, role: e.target.value })}
                                        className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                    >
                                        <option value="super_admin">👑 SuperAdministrador (Central)</option>
                                        <option value="clinic_admin">🏥 Director de Clínica</option>
                                        <option value="vet_doctor">🩺 Médico Veterinario</option>
                                        <option value="reception">💼 Recepcionista / Mostrador</option>
                                    </select>
                                </div>

                                {formData.role !== 'super_admin' && (
                                    <div>
                                        <label className="block text-xs font-bold text-slate-700 mb-1">Clínica Veterinaria Asociada</label>
                                        <select
                                            value={formData.tenant_id}
                                            onChange={(e) => setFormData({ ...formData, tenant_id: e.target.value })}
                                            className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                            required={formData.role !== 'super_admin'}
                                        >
                                            <option value="">Selecciona una clínica...</option>
                                            {tenantsList.map((t) => (
                                                <option key={t.id} value={t.id}>{t.name} ({t.slug})</option>
                                            ))}
                                        </select>
                                    </div>
                                )}

                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">
                                        Contraseña {editingUser && <span className="font-normal text-slate-400">(dejar vacío para no cambiar)</span>}
                                    </label>
                                    <input
                                        type="password"
                                        value={formData.password}
                                        onChange={(e) => setFormData({ ...formData, password: e.target.value })}
                                        placeholder={editingUser ? '••••••••' : 'Mínimo 6 caracteres'}
                                        className="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                        required={!editingUser}
                                    />
                                </div>

                                <div className="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                                    <button
                                        type="button"
                                        onClick={() => setIsModalOpen(false)}
                                        className="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 cursor-pointer"
                                    >
                                        Cancelar
                                    </button>
                                    <button
                                        type="submit"
                                        className="px-4 py-2 rounded-xl text-xs font-bold bg-teal-600 hover:bg-teal-700 text-white shadow-xs cursor-pointer"
                                    >
                                        {editingUser ? 'Actualizar Usuario' : 'Crear Usuario'}
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
