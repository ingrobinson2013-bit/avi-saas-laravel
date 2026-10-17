<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Mail\ProspectoOutreachMail;
use App\Models\ProspectoVeterinaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class SuperAdminProspectoController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->input('search');
        $estadoFilter = $request->input('estado', 'all');
        $municipioFilter = $request->input('municipio', 'all');

        $query = ProspectoVeterinaria::query()->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('razon_social', 'ILIKE', "%{$search}%")
                  ->orWhere('correo_comercial', 'ILIKE', "%{$search}%")
                  ->orWhere('telefono', 'ILIKE', "%{$search}%")
                  ->orWhere('municipio', 'ILIKE', "%{$search}%")
                  ->orWhere('departamento', 'ILIKE', "%{$search}%");
            });
        }

        if ($estadoFilter && $estadoFilter !== 'all') {
            if ($estadoFilter === 'abierto') {
                $query->where('aperturas_count', '>', 0);
            } else {
                $query->where('estado', $estadoFilter);
            }
        }

        if ($municipioFilter && $municipioFilter !== 'all') {
            $query->where('municipio', $municipioFilter);
        }

        $prospectos = $query->paginate(20)->through(function ($p) {
            // Clean phone for whatsapp
            $cleanPhone = preg_replace('/[^0-9]/', '', (string)$p->telefono);
            if (strlen($cleanPhone) === 10 && str_starts_with($cleanPhone, '3')) {
                $waPhone = '57' . $cleanPhone;
            } elseif (str_starts_with($cleanPhone, '57') && strlen($cleanPhone) === 12) {
                $waPhone = $cleanPhone;
            } else {
                $waPhone = null;
            }

            $waMessage = urlencode("Hola buen día, equipo de {$p->razon_social} ({$p->municipio}). Les escribe Robinson de AVI Pet (https://avipetapp.com). Queremos mostrarles cómo activar planes de salud preventivos y carnet digital para fidelizar pacientes.");
            $waLink = $waPhone ? "https://wa.me/{$waPhone}?text={$waMessage}" : null;

            return [
                'id' => $p->id,
                'razon_social' => $p->razon_social,
                'correo_comercial' => $p->correo_comercial,
                'telefono' => $p->telefono,
                'departamento' => $p->departamento,
                'municipio' => $p->municipio,
                'direccion' => $p->direccion,
                'tipo' => $p->tipo ?? 'Clínica Veterinaria',
                'estado' => $p->estado,
                'intentos_envio' => (int) $p->intentos_envio,
                'ultimo_envio_at' => $p->ultimo_envio_at ? $p->ultimo_envio_at->format('d/m/Y H:i') : null,
                'abierto_at' => $p->abierto_at ? $p->abierto_at->format('d/m/Y H:i') : null,
                'aperturas_count' => (int) $p->aperturas_count,
                'fuente' => $p->fuente,
                'wa_link' => $waLink,
            ];
        });

        // Compute KPIs across all 237+ real prospects
        $totalCount = ProspectoVeterinaria::count();
        $pendientesCount = ProspectoVeterinaria::where('estado', 'pendiente')->count();
        $enviadosCount = ProspectoVeterinaria::where('estado', 'enviado')->count();
        $abiertosCount = ProspectoVeterinaria::where('aperturas_count', '>', 0)->count();
        $conTelefonoCount = ProspectoVeterinaria::whereNotNull('telefono')->where('telefono', '!=', '')->count();

        // Top municipalities for filter dropdown
        $municipiosList = ProspectoVeterinaria::select('municipio')
            ->distinct()
            ->whereNotNull('municipio')
            ->orderBy('municipio')
            ->pluck('municipio')
            ->toArray();

        $authUser = auth()->user();

        return Inertia::render('SuperAdmin/Prospectos', [
            'prospectos' => $prospectos,
            'filters' => [
                'search' => $search ?? '',
                'estado' => $estadoFilter,
                'municipio' => $municipioFilter,
            ],
            'stats' => [
                'total' => $totalCount,
                'pendientes' => $pendientesCount,
                'enviados' => $enviadosCount,
                'abiertos' => $abiertosCount,
                'conTelefono' => $conTelefonoCount,
            ],
            'municipiosList' => $municipiosList,
            'userName' => $authUser?->name ?? 'Robinson Naranjo',
            'userEmail' => $authUser?->email ?? 'superadmin@avipetapp.com',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'razon_social' => 'required|string|max:255',
            'correo_comercial' => 'required|email|max:255|unique:prospectos_veterinarias,correo_comercial',
            'telefono' => 'nullable|string|max:50',
            'municipio' => 'required|string|max:100',
            'departamento' => 'required|string|max:100',
            'tipo' => 'nullable|string|max:100',
            'direccion' => 'nullable|string|max:255',
        ]);

        ProspectoVeterinaria::create([
            'razon_social' => $validated['razon_social'],
            'correo_comercial' => $validated['correo_comercial'],
            'telefono' => $validated['telefono'] ?? null,
            'municipio' => $validated['municipio'],
            'departamento' => $validated['departamento'],
            'tipo' => $validated['tipo'] ?? 'Clínica Veterinaria',
            'direccion' => $validated['direccion'] ?? null,
            'estado' => 'pendiente',
            'fuente' => 'Ingreso Manual SuperAdmin',
        ]);

        return redirect()->back()->with('success', 'Prospecto añadido exitosamente a la base.');
    }

    public function sendOutreach(Request $request, int $id)
    {
        $prospecto = ProspectoVeterinaria::findOrFail($id);
        $email = trim($prospecto->correo_comercial ?? '');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $prospecto->estado = 'error';
            $prospecto->error_mensaje = 'Formato de correo electrónico inválido.';
            $prospecto->save();
            return redirect()->back()->with('error', "El correo de {$prospecto->razon_social} tiene un formato inválido.");
        }

        $domain = substr(strrchr($email, "@"), 1);
        if ($domain && function_exists('checkdnsrr') && !checkdnsrr($domain, 'MX') && !checkdnsrr($domain, 'A')) {
            $prospecto->estado = 'error';
            $prospecto->error_mensaje = "El dominio @{$domain} no posee servidores de correo activos.";
            $prospecto->save();
            return redirect()->back()->with('error', "El dominio @{$domain} no existe o no recibe correos.");
        }

        try {
            Mail::to($email)->send(new ProspectoOutreachMail($prospecto));

            $prospecto->estado = 'enviado';
            $prospecto->intentos_envio = ($prospecto->intentos_envio ?? 0) + 1;
            $prospecto->ultimo_envio_at = now();
            $prospecto->error_mensaje = null;
            $prospecto->save();

            return redirect()->back()->with('success', "Correo de outreach enviado correctamente a {$prospecto->razon_social}.");
        } catch (\Throwable $e) {
            Log::error("Error enviando outreach a prospecto {$prospecto->id}: " . $e->getMessage());
            
            // Mark attempt and record error for tracking
            $prospecto->estado = 'error';
            $prospecto->intentos_envio = ($prospecto->intentos_envio ?? 0) + 1;
            $prospecto->error_mensaje = $e->getMessage();
            $prospecto->save();

            return redirect()->back()->with('error', "No se pudo enviar el correo: " . $e->getMessage());
        }
    }

    public function updateEstado(Request $request, int $id)
    {
        $prospecto = ProspectoVeterinaria::findOrFail($id);

        $validated = $request->validate([
            'estado' => 'required|string|in:pendiente,enviado,respondido,desuscrito,error',
        ]);

        $prospecto->estado = $validated['estado'];
        $prospecto->save();

        return redirect()->back()->with('success', 'Estado del prospecto actualizado.');
    }
}
