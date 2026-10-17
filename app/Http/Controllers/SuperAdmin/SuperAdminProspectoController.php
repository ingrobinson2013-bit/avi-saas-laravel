<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Mail\ProspectoOutreachMail;
use App\Models\ProspectoVeterinaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
            'initialCampaign' => Cache::get('avi_campaign_progress', ['status' => 'idle']),
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

    public function dispatchBatch(Request $request)
    {
        $limit = min((int) $request->input('limit', 50), 100);

        $prospectos = ProspectoVeterinaria::where('estado', 'pendiente')
            ->whereNotNull('correo_comercial')
            ->where('correo_comercial', '!=', '')
            ->where('correo_comercial', 'LIKE', '%@%')
            ->orderBy('id', 'asc')
            ->take($limit)
            ->get();

        if ($prospectos->isEmpty()) {
            return redirect()->back()->with('warning', 'No hay prospectos pendientes listos para enviar en este momento.');
        }

        // Inicializar estado de progreso en caché para el banner en vivo
        Cache::put('avi_campaign_progress', [
            'status' => 'running',
            'total' => $prospectos->count(),
            'enviados' => 0,
            'fallidos' => 0,
            'current_lead' => 'Iniciando conexión con Resend SMTP...',
            'percent' => 2,
            'started_at' => now()->format('H:i:s'),
        ], 600);

        // Despachador artisan en segundo plano con credenciales leídas dinámicamente
        $artisan = base_path('artisan');
        $mailHost = config('mail.mailers.smtp.host', 'smtp.resend.com');
        $mailPort = config('mail.mailers.smtp.port', 587);
        $mailUser = config('mail.mailers.smtp.username', 'resend');
        $mailPass = escapeshellarg(config('mail.mailers.smtp.password') ?: base64_decode('cmVfWnNXb01ndXVfQmVZejhjc01MUVh3YnRMVmNQV01SVm42'));
        $mailEnc = config('mail.mailers.smtp.encryption', 'tls');

        exec("MAIL_HOST={$mailHost} MAIL_PORT={$mailPort} MAIL_USERNAME={$mailUser} MAIL_PASSWORD={$mailPass} MAIL_ENCRYPTION={$mailEnc} php {$artisan} avi:prospectos-scan-and-send --limit={$limit} > /dev/null 2>&1 &");

        return redirect()->back()->with('success', "🚀 Campaña iniciada para {$prospectos->count()} prospectos en segundo plano vía Resend SMTP. El banner superior te mostrará el avance en vivo.");
    }

    public function campaignStatus(): \Illuminate\Http\JsonResponse
    {
        $data = Cache::get('avi_campaign_progress', [
            'status' => 'idle',
            'total' => 0,
            'enviados' => 0,
            'fallidos' => 0,
            'current_lead' => null,
            'percent' => 0,
        ]);

        return response()->json($data);
    }

    public function scanRegion(Request $request)
    {
        set_time_limit(180);
        $region = $request->input('region', 'todo_el_pais');
        $limit = min((int) $request->input('limit', 50), 100);

        try {
            $scraper = app(\App\Services\VeterinariaScraperService::class);
            $res = $scraper->scanRegion($region, null, null, null, $limit);

            $guardados = $res['guardados_o_actualizados'] ?? count($res['encontrados'] ?? []);
            $totalPendientes = $res['pendientes_en_cola'] ?? ProspectoVeterinaria::where('estado', 'pendiente')->count();

            return redirect()->back()->with('success', "🔍 Escaneo completado: Se descubrieron y sincronizaron {$guardados} clínicas en {$region}. Total pendientes en base: {$totalPendientes}.");
        } catch (\Throwable $e) {
            Log::error("Error en escaneo de veterinarias: " . $e->getMessage());
            return redirect()->back()->with('error', "No se pudo completar el escaneo: " . $e->getMessage());
        }
    }

    public function importCsv(Request $request)
    {
        $csvData = trim($request->input('csv_data', ''));
        if (empty($csvData)) {
            return redirect()->back()->with('error', 'Por favor ingresa o pega el contenido CSV.');
        }

        $lines = explode("\n", $csvData);
        $delimiter = str_contains($lines[0], ';') ? ';' : ',';
        $header = null;
        $items = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if (!$line) continue;
            $cols = str_getcsv($line, $delimiter);
            if (!$header) {
                $header = array_map(fn($h) => strtolower(trim($h)), $cols);
                continue;
            }

            $row = [];
            foreach ($header as $i => $key) {
                $row[$key] = $cols[$i] ?? null;
            }

            $email = $row['correo_comercial'] ?? $row['email'] ?? $row['correo'] ?? null;
            if ($email) {
                $items[] = [
                    'razon_social' => $row['razon_social'] ?? $row['nombre'] ?? 'Clínica Veterinaria',
                    'correo_comercial' => $email,
                    'telefono' => $row['telefono'] ?? null,
                    'municipio' => $row['municipio'] ?? $row['ciudad'] ?? 'Bogotá D.C.',
                    'departamento' => $row['departamento'] ?? 'Cundinamarca',
                    'tipo' => $row['tipo'] ?? 'Clínica Veterinaria',
                    'fuente' => 'Importación Manual CSV',
                ];
            }
        }

        if (empty($items)) {
            return redirect()->back()->with('error', 'No se encontraron registros válidos con columna de correo electrónico.');
        }

        $total = ProspectoVeterinaria::upsertProspectos($items);

        return redirect()->back()->with('success', "📥 Importación exitosa: Se sincronizaron {$total} clínicas con Upsert (cero duplicados).");
    }
}
