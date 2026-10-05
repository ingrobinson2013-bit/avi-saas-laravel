import React, { useState, useRef } from 'react';
import { Head, router } from '@inertiajs/react';
import VetAdminLayout from '@/Layouts/VetAdminLayout';
import {
    Search,
    Plus,
    Filter,
    ShieldCheck,
    Camera,
    Upload,
    Link as LinkIcon,
    X,
    Check,
    Loader2,
    Image as ImageIcon,
    Sparkles,
} from 'lucide-react';

interface PetItem {
    id: string;
    name: string;
    species: string;
    breed: string;
    birthdate: string;
    age: string;
    customer_name: string;
    customer_phone: string;
    plan_name: string;
    plan_status: string;
    photo_url?: string | null;
    medical_notes: string;
}

interface PetsProps {
    tenantSlug: string;
    brandName: string;
    clinicSubtitle: string;
    logoUrl?: string | null;
    saasPlan: any;
    logoutUrl: string;
    userName: string;
    userRole: string;
    pets: PetItem[];
    totalCount: number;
    activePlansCount: number;
}

export default function Pets({
    tenantSlug,
    brandName,
    clinicSubtitle,
    logoUrl,
    saasPlan,
    logoutUrl,
    userName,
    userRole,
    pets = [],
    totalCount = 1,
    activePlansCount = 1,
}: PetsProps) {
    const [search, setSearch] = useState('');
    const [selectedSpecies, setSelectedSpecies] = useState('all');
    const [petsList, setPetsList] = useState<PetItem[]>(pets);

    // Modal de Carga de Foto
    const [editingPet, setEditingPet] = useState<PetItem | null>(null);
    const [photoMode, setPhotoMode] = useState<'upload' | 'url'>('upload');
    const [previewUrl, setPreviewUrl] = useState<string | null>(null);
    const [urlInput, setUrlInput] = useState('');
    const [selectedFile, setSelectedFile] = useState<File | null>(null);
    const [isUploading, setIsUploading] = useState(false);
    const [toastMessage, setToastMessage] = useState<string | null>(null);
    const fileInputRef = useRef<HTMLInputElement>(null);

    const filteredPets = petsList.filter((p) => {
        const matchesSearch =
            p.name.toLowerCase().includes(search.toLowerCase()) ||
            p.breed.toLowerCase().includes(search.toLowerCase()) ||
            p.customer_name.toLowerCase().includes(search.toLowerCase());
        const matchesSpecies = selectedSpecies === 'all' || p.species.toLowerCase() === selectedSpecies.toLowerCase();
        return matchesSearch && matchesSpecies;
    });

    const openPhotoModal = (pet: PetItem) => {
        setEditingPet(pet);
        setPreviewUrl(pet.photo_url || null);
        setUrlInput(pet.photo_url || '');
        setSelectedFile(null);
        setPhotoMode('upload');
    };

    const closePhotoModal = () => {
        setEditingPet(null);
        setPreviewUrl(null);
        setSelectedFile(null);
        setUrlInput('');
        setIsUploading(false);
    };

    const handleFileSelect = (e: React.ChangeEvent<HTMLInputElement>) => {
        const file = e.target.files?.[0];
        if (file) {
            setSelectedFile(file);
            const objectUrl = URL.createObjectURL(file);
            setPreviewUrl(objectUrl);
        }
    };

    const handleUrlChange = (val: string) => {
        setUrlInput(val);
        setPreviewUrl(val.trim() || null);
    };

    const handleSavePhoto = async () => {
        if (!editingPet) return;

        setIsUploading(true);

        try {
            const formData = new FormData();
            if (photoMode === 'upload' && selectedFile) {
                formData.append('photo', selectedFile);
            } else if (photoMode === 'url' && urlInput.trim()) {
                formData.append('photo_url', urlInput.trim());
            } else if (previewUrl) {
                formData.append('photo_url', previewUrl);
            } else {
                setIsUploading(false);
                return;
            }

            const res = await fetch(`/admin/${tenantSlug}/pets/${editingPet.id}/photo`, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                },
            });

            if (!res.ok) {
                throw new Error('Error al actualizar la foto');
            }

            const data = await res.json();
            const newPhotoUrl = data.photo_url || previewUrl;

            // Optimistic update local state
            setPetsList((prev) =>
                prev.map((p) => (p.id === editingPet.id ? { ...p, photo_url: newPhotoUrl } : p))
            );

            setToastMessage(`Foto de ${editingPet.name} actualizada correctamente.`);
            setTimeout(() => setToastMessage(null), 4000);
            closePhotoModal();
        } catch (err) {
            console.error('Error guardando foto:', err);
            // Fallback con Inertia router
            const formData = new FormData();
            if (selectedFile) formData.append('photo', selectedFile);
            if (urlInput.trim()) formData.append('photo_url', urlInput.trim());

            router.post(`/admin/${tenantSlug}/pets/${editingPet.id}/photo`, formData, {
                onSuccess: () => {
                    setPetsList((prev) =>
                        prev.map((p) => (p.id === editingPet.id ? { ...p, photo_url: previewUrl } : p))
                    );
                    setToastMessage(`Foto de ${editingPet.name} actualizada correctamente.`);
                    setTimeout(() => setToastMessage(null), 4000);
                    closePhotoModal();
                },
                onError: () => {
                    alert('No se pudo guardar la imagen. Verifica el formato o tamaño.');
                    setIsUploading(false);
                },
            });
        } finally {
            setIsUploading(false);
        }
    };

    return (
        <VetAdminLayout
            tenantSlug={tenantSlug}
            brandName={brandName}
            clinicSubtitle={clinicSubtitle}
            logoUrl={logoUrl}
            saasPlan={saasPlan}
            logoutUrl={logoutUrl}
            userName={userName}
            userRole={userRole}
            activeItem="Clientes y Mascotas"
        >
            <Head title={`Pacientes y Mascotas · ${brandName}`} />

            {/* Toast Notification */}
            {toastMessage && (
                <div className="fixed bottom-6 right-6 z-50 flex items-center gap-2 px-4 py-3 bg-slate-900 text-white text-xs font-semibold rounded-2xl shadow-xl border border-slate-700 animate-in fade-in slide-in-from-bottom-4 duration-300">
                    <Check className="w-4 h-4 text-emerald-400" />
                    <span>{toastMessage}</span>
                </div>
            )}

            <div className="w-full space-y-5 pb-16">
                {/* Header Banner */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div className="flex items-center gap-2">
                            <h1 className="text-xl font-black text-slate-900">
                                Clientes y Mascotas
                            </h1>
                            <span className="text-[10px] font-bold px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                                {totalCount} Pacientes Registrados
                            </span>
                        </div>
                        <p className="text-xs text-slate-500 mt-1">
                            Padrón clínico de mascotas con membresía activa, carnet digital y fotografía oficial en {brandName}.
                        </p>
                    </div>

                    <div className="flex items-center gap-2">
                        <a
                            href={`/admin/${tenantSlug}/subscriptions/create`}
                            className="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#0080ff] hover:bg-blue-600 text-white text-xs font-bold transition shadow-xs"
                        >
                            <Plus className="w-4 h-4" />
                            <span>Afiliar Paciente</span>
                        </a>
                    </div>
                </div>

                {/* Filter and Search Bar */}
                <div className="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs flex flex-col md:flex-row items-center justify-between gap-3">
                    <div className="w-full md:w-80 relative">
                        <Search className="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
                        <input
                            type="text"
                            value={search}
                            onChange={(e) => setSearch(e.target.value)}
                            placeholder="Buscar por nombre, raza o tutor..."
                            className="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 placeholder:text-slate-400 focus:outline-hidden focus:ring-2 focus:ring-blue-500 transition"
                        />
                    </div>

                    <div className="flex items-center gap-2 w-full md:w-auto">
                        <button
                            type="button"
                            onClick={() => setSelectedSpecies('all')}
                            className={`px-3 py-1.5 rounded-xl text-xs font-bold transition ${
                                selectedSpecies === 'all'
                                    ? 'bg-[#0080ff] text-white shadow-xs'
                                    : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200'
                            }`}
                        >
                            Todos ({petsList.length})
                        </button>
                        <button
                            type="button"
                            onClick={() => setSelectedSpecies('Canino')}
                            className={`px-3 py-1.5 rounded-xl text-xs font-bold transition ${
                                selectedSpecies === 'Canino'
                                    ? 'bg-[#0080ff] text-white shadow-xs'
                                    : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200'
                            }`}
                        >
                            🐶 Caninos
                        </button>
                        <button
                            type="button"
                            onClick={() => setSelectedSpecies('Felino')}
                            className={`px-3 py-1.5 rounded-xl text-xs font-bold transition ${
                                selectedSpecies === 'Felino'
                                    ? 'bg-[#0080ff] text-white shadow-xs'
                                    : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200'
                            }`}
                        >
                            🐱 Felinos
                        </button>
                    </div>
                </div>

                {/* Pets Data Table */}
                <div className="bg-white border border-slate-200/90 rounded-2xl shadow-2xs overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left border-collapse">
                            <thead>
                                <tr className="border-b border-slate-100 bg-slate-50/75 text-[11px] font-black uppercase text-slate-400 tracking-wider">
                                    <th className="py-3 px-4">Paciente</th>
                                    <th className="py-3 px-4">Especie & Raza</th>
                                    <th className="py-3 px-4">Tutor Responsable</th>
                                    <th className="py-3 px-4">Plan de Salud</th>
                                    <th className="py-3 px-4">Edad</th>
                                    <th className="py-3 px-4 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100 text-xs">
                                {filteredPets.length === 0 ? (
                                    <tr>
                                        <td colSpan={6} className="py-12 text-center text-slate-400">
                                            <div className="w-12 h-12 mx-auto rounded-full bg-slate-100 flex items-center justify-center text-2xl mb-2">🐾</div>
                                            <p className="font-semibold text-slate-700">No se encontraron pacientes</p>
                                            <p className="text-xs text-slate-400 mt-0.5">Prueba ajustando los términos de búsqueda o filtros.</p>
                                        </td>
                                    </tr>
                                ) : (
                                    filteredPets.map((pet) => (
                                        <tr key={pet.id} className="hover:bg-slate-50/60 transition group">
                                            <td className="py-3.5 px-4">
                                                <div className="flex items-center gap-3">
                                                    {/* Avatar interactivo de la Mascota */}
                                                    <div className="relative group/avatar shrink-0">
                                                        <div
                                                            onClick={() => openPhotoModal(pet)}
                                                            className="w-11 h-11 rounded-full ring-2 ring-blue-100 overflow-hidden shadow-2xs bg-slate-100 cursor-pointer flex items-center justify-center transition group-hover/avatar:ring-blue-400"
                                                            title="Clic para cambiar o subir foto"
                                                        >
                                                            {pet.photo_url ? (
                                                                <img
                                                                    src={pet.photo_url}
                                                                    alt={pet.name}
                                                                    className="w-full h-full object-cover group-hover/avatar:scale-105 transition duration-300"
                                                                    onError={(e) => {
                                                                        const target = e.target as HTMLElement;
                                                                        target.style.display = 'none';
                                                                        if (target.parentElement) {
                                                                            target.parentElement.innerHTML = `<span class="text-xl">${pet.species === 'Felino' ? '🐱' : '🐶'}</span>`;
                                                                        }
                                                                    }}
                                                                />
                                                            ) : (
                                                                <span className="text-xl">
                                                                    {pet.species === 'Felino' ? '🐱' : '🐶'}
                                                                </span>
                                                            )}
                                                        </div>

                                                        {/* Badge de Cámara flotante */}
                                                        <button
                                                            type="button"
                                                            onClick={() => openPhotoModal(pet)}
                                                            title="Actualizar fotografía de la mascota"
                                                            className="absolute -bottom-0.5 -right-0.5 w-5 h-5 rounded-full bg-white border border-slate-200 shadow-xs flex items-center justify-center text-slate-500 hover:text-blue-600 hover:border-blue-400 transition"
                                                        >
                                                            <Camera className="w-3 h-3" />
                                                        </button>
                                                    </div>

                                                    <div>
                                                        <div className="flex items-center gap-1.5">
                                                            <span className="font-bold text-slate-900 block text-sm">
                                                                {pet.name}
                                                            </span>
                                                        </div>
                                                        <span className="text-[10px] text-slate-400">
                                                            Expediente: #{pet.id.substring(0, 8)}
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td className="py-3.5 px-4 font-medium text-slate-700">
                                                <div>{pet.breed}</div>
                                                <span className="text-[10.5px] text-slate-400 font-normal">{pet.species}</span>
                                            </td>
                                            <td className="py-3.5 px-4">
                                                <div className="font-semibold text-slate-900">{pet.customer_name}</div>
                                                <a
                                                    href={`https://wa.me/${pet.customer_phone}`}
                                                    target="_blank"
                                                    rel="noreferrer"
                                                    className="text-[11px] text-blue-600 hover:underline flex items-center gap-1"
                                                >
                                                    <span>📱 {pet.customer_phone}</span>
                                                </a>
                                            </td>
                                            <td className="py-3.5 px-4">
                                                <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10.5px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                                    <ShieldCheck className="w-3.5 h-3.5 text-emerald-600" />
                                                    <span>{pet.plan_name}</span>
                                                </span>
                                            </td>
                                            <td className="py-3.5 px-4 text-slate-600 font-medium">
                                                {pet.age}
                                            </td>
                                            <td className="py-3.5 px-4 text-right">
                                                <div className="inline-flex items-center gap-1.5">
                                                    <button
                                                        type="button"
                                                        onClick={() => openPhotoModal(pet)}
                                                        className="px-2.5 py-1 rounded-lg bg-slate-50 text-slate-700 hover:bg-slate-100 hover:text-blue-600 border border-slate-200 text-[11px] font-bold transition flex items-center gap-1"
                                                        title="Cargar o cambiar foto"
                                                    >
                                                        <Camera className="w-3 h-3" />
                                                        <span>Foto</span>
                                                    </button>
                                                    <a
                                                        href={`/admin/${tenantSlug}/counter-redeem`}
                                                        className="px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 text-[11px] font-bold transition"
                                                    >
                                                        Canjear
                                                    </a>
                                                    <a
                                                        href={`/admin/${tenantSlug}/subscriptions`}
                                                        className="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 text-[11px] font-bold transition"
                                                    >
                                                        Carnet
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    ))
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {/* Modal de Carga / Actualización de Foto */}
            {editingPet && (
                <div className="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
                    <div className="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-100 animate-in fade-in zoom-in-95 duration-200 relative">
                        {/* Botón Cerrar */}
                        <button
                            type="button"
                            onClick={closePhotoModal}
                            className="absolute top-4 right-4 p-1.5 rounded-full text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition"
                        >
                            <X className="w-4 h-4" />
                        </button>

                        {/* Encabezado */}
                        <div className="flex items-center gap-3 pb-4 border-b border-slate-100">
                            <div className="w-12 h-12 rounded-full ring-2 ring-blue-100 overflow-hidden bg-slate-100 flex items-center justify-center shrink-0">
                                {previewUrl ? (
                                    <img
                                        src={previewUrl}
                                        alt={editingPet.name}
                                        className="w-full h-full object-cover"
                                        onError={(e) => {
                                            (e.target as HTMLElement).style.display = 'none';
                                        }}
                                    />
                                ) : (
                                    <span className="text-2xl">{editingPet.species === 'Felino' ? '🐱' : '🐶'}</span>
                                )}
                            </div>
                            <div>
                                <h3 className="text-base font-black text-slate-900">
                                    Foto de {editingPet.name}
                                </h3>
                                <p className="text-xs text-slate-500">
                                    {editingPet.breed} · Tutor: {editingPet.customer_name}
                                </p>
                            </div>
                        </div>

                        {/* Selector de Modo (Subir Archivo o URL) */}
                        <div className="mt-4">
                            <div className="flex items-center p-1 bg-slate-100 rounded-xl">
                                <button
                                    type="button"
                                    onClick={() => setPhotoMode('upload')}
                                    className={`flex-1 py-1.5 text-xs font-bold rounded-lg transition flex items-center justify-center gap-1.5 ${
                                        photoMode === 'upload'
                                            ? 'bg-white text-slate-900 shadow-2xs'
                                            : 'text-slate-500 hover:text-slate-800'
                                    }`}
                                >
                                    <Upload className="w-3.5 h-3.5" />
                                    <span>Subir / Cámara</span>
                                </button>
                                <button
                                    type="button"
                                    onClick={() => setPhotoMode('url')}
                                    className={`flex-1 py-1.5 text-xs font-bold rounded-lg transition flex items-center justify-center gap-1.5 ${
                                        photoMode === 'url'
                                            ? 'bg-white text-slate-900 shadow-2xs'
                                            : 'text-slate-500 hover:text-slate-800'
                                    }`}
                                >
                                    <LinkIcon className="w-3.5 h-3.5" />
                                    <span>Enlace Web (URL)</span>
                                </button>
                            </div>
                        </div>

                        {/* Contenido según Modo */}
                        <div className="mt-4 space-y-4">
                            {photoMode === 'upload' ? (
                                <div>
                                    <input
                                        ref={fileInputRef}
                                        type="file"
                                        accept="image/jpeg,image/png,image/jpg,image/webp"
                                        capture="environment"
                                        onChange={handleFileSelect}
                                        className="hidden"
                                    />
                                    <div
                                        onClick={() => fileInputRef.current?.click()}
                                        className="border-2 border-dashed border-slate-200 hover:border-blue-500 hover:bg-blue-50/30 rounded-2xl p-6 text-center cursor-pointer transition"
                                    >
                                        <div className="w-10 h-10 mx-auto rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-2">
                                            <Camera className="w-5 h-5" />
                                        </div>
                                        <p className="text-xs font-bold text-slate-800">
                                            {selectedFile ? selectedFile.name : 'Haz clic para seleccionar o tomar foto'}
                                        </p>
                                        <p className="text-[11px] text-slate-400 mt-1">
                                            JPG, PNG o WEBP (máx. 5 MB)
                                        </p>
                                    </div>
                                </div>
                            ) : (
                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">
                                        URL de la imagen (HTTPS)
                                    </label>
                                    <input
                                        type="url"
                                        value={urlInput}
                                        onChange={(e) => handleUrlChange(e.target.value)}
                                        placeholder="https://ejemplo.com/foto_mascota.jpg"
                                        className="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 placeholder:text-slate-400 focus:outline-hidden focus:ring-2 focus:ring-blue-500 transition"
                                    />
                                </div>
                            )}

                            {/* Previsualización en Vivo */}
                            {previewUrl && (
                                <div className="p-3 bg-slate-50 rounded-2xl border border-slate-100 flex items-center gap-3">
                                    <div className="w-14 h-14 rounded-xl ring-2 ring-emerald-200 overflow-hidden shrink-0 bg-white">
                                        <img
                                            src={previewUrl}
                                            alt="Vista previa"
                                            className="w-full h-full object-cover"
                                            onError={() => {
                                                alert('La imagen no pudo cargarse desde la URL indicada.');
                                                setPreviewUrl(null);
                                            }}
                                        />
                                    </div>
                                    <div className="text-xs">
                                        <span className="font-bold text-slate-800 block">Vista Previa Lista</span>
                                        <span className="text-[10.5px] text-emerald-600 font-semibold flex items-center gap-1 mt-0.5">
                                            <Check className="w-3 h-3" /> Lista para guardar en el carnet
                                        </span>
                                    </div>
                                </div>
                            )}
                        </div>

                        {/* Botones de Acción */}
                        <div className="mt-6 flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                            <button
                                type="button"
                                onClick={closePhotoModal}
                                disabled={isUploading}
                                className="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition"
                            >
                                Cancelar
                            </button>
                            <button
                                type="button"
                                onClick={handleSavePhoto}
                                disabled={isUploading || (!selectedFile && !urlInput.trim())}
                                className="inline-flex items-center gap-1.5 px-5 py-2 rounded-xl bg-[#0080ff] hover:bg-blue-600 disabled:opacity-50 text-white text-xs font-bold transition shadow-xs"
                            >
                                {isUploading ? (
                                    <>
                                        <Loader2 className="w-3.5 h-3.5 animate-spin" />
                                        <span>Guardando...</span>
                                    </>
                                ) : (
                                    <>
                                        <Check className="w-3.5 h-3.5" />
                                        <span>Guardar Foto</span>
                                    </>
                                )}
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </VetAdminLayout>
    );
}
