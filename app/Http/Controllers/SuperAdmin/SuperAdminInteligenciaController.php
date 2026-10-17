<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\BenefitRedemption;
use App\Models\Pet;
use App\Models\Plan;
use App\Models\ProspectoVeterinaria;
use App\Models\SaasPaymentLog;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Inertia\Response;

class SuperAdminInteligenciaController extends Controller
{
    public function index(): Response
    {
        $tenants = Tenant::with(['users', 'plans'])
            ->withCount(['pets', 'subscriptions', 'customers', 'plans'])
            ->latest()
            ->get();

        // 1. MRR (Ingreso recurrente SaaS de la plataforma) vs GMV (Valor transaccionado por las clínicas)
        // Regla Manual Maestro v1.1 Página 9: MRR y GMV nunca se mezclan.
        $activePaidTenants = $tenants->filter(function (Tenant $t) {
            if (!$t->is_active || in_array(strtolower($t->slug), ['test', 'demo'])) {
                return false;
            }
            return ($t->branding['saas_status'] ?? 'paid') === 'paid';
        });

        $mrr = (float) $activePaidTenants->sum(fn (Tenant $t) => (float) ($t->branding['saas_monthly_fee'] ?? 99000));

        $activeSubscriptions = Subscription::with('plan')->where('status', 'active')->get();
        $gmv = (float) $activeSubscriptions->sum(fn ($s) => (float) ($s->plan?->price_cop ?? 50000));

        $totalPets = Pet::count();
        $totalRedemptions = BenefitRedemption::count();

        // 2. Radar de Salud y Retención por Clínica (Sugerencias accionables con supervisión)
        $clinicInsights = $tenants->map(function (Tenant $t) {
            $branding = $t->branding ?? [];
            $primaryUser = $t->users->first();
            $doctorName = $branding['doctor_name'] ?? ($primaryUser?->name ?? 'Dr(a). Titular');
            $phone = $branding['phone'] ?? '';
            $cleanPhone = preg_replace('/[^0-9]/', '', (string) $phone);
            $waPhone = $cleanPhone ? (str_starts_with($cleanPhone, '57') ? $cleanPhone : "57{$cleanPhone}") : null;

            $petsCount = (int) ($t->pets_count ?? 0);
            $subsCount = (int) ($t->subscriptions_count ?? 0);
            $plansCount = (int) ($t->plans_count ?? 0);
            $hasLogo = !empty($branding['logo_url']) || $t->slug === 'vet-pet-patitas';
            $status = !$t->is_active ? 'suspended' : ($branding['saas_status'] ?? 'paid');
            $planTier = $t->saas_plan_tier ?: ($branding['saas_plan'] ?? 'starter');
            $monthlyFee = (float) ($branding['saas_monthly_fee'] ?? 99000);

            // Puntaje de salud operativa (0 - 100)
            $healthScore = 30;
            if ($hasLogo) $healthScore += 15;
            if ($plansCount >= 2) $healthScore += 15;
            if ($petsCount >= 1) $healthScore += 20;
            if ($subsCount >= 3) $healthScore += 20;
            if ($status === 'suspended' || strtolower($t->slug) === 'test') {
                $healthScore = min($healthScore, 25);
            }

            // Diagnóstico IA y acción recomendada
            if (strtolower($t->slug) === 'test') {
                $category = 'cleanup';
                $priority = 'warning';
                $badge = 'Cuenta de prueba detectada';
                $diagnosis = 'Clínica de prueba sin actividad real ni mascotas afiliadas. Se recomienda depurarla desde Clínicas veterinarias para mantener limpio el Sitemap y los indicadores.';
                $actionLabel = 'Ir a depurar clínica';
                $actionUrl = '/super-admin/tenants?manage=' . $t->id;
            } elseif ($subsCount === 0) {
                $category = 'onboarding';
                $priority = 'warning';
                $badge = 'Requiere activación inicial';
                $diagnosis = 'La clínica aún no registra su primera mascota con membresía activa. Acompañar al doctor a imprimir su Afiche QR de sala de espera acelera la primera afiliación.';
                $actionLabel = 'Asistir por WhatsApp';
                $waText = "Hola {$doctorName}, soy Robinson de AviPetApp. Vi que tu portal {$t->slug}.avipetapp.com ya está activo y quiero ayudarte a descargar tu Afiche QR de mostrador para afiliar tus primeras mascotas esta semana.";
                $actionUrl = $waPhone ? "https://wa.me/{$waPhone}?text=" . urlencode($waText) : '/super-admin/tenants?manage=' . $t->id;
            } elseif ($subsCount >= 5 && $planTier === 'starter') {
                $category = 'upsell';
                $priority = 'success';
                $badge = 'Tracción alta · Candidata a Plan Pro';
                $diagnosis = "Cuenta con {$subsCount} membresías activas y {$petsCount} mascotas registradas. Excelente caso de éxito para documentar testimonio B2B o escalar a Plan Profesional.";
                $actionLabel = 'Felicitar / Upsell WhatsApp';
                $waText = "Hola {$doctorName}, felicitaciones por las {$subsCount} mascotas afiliadas en {$t->name} con AviPetApp. Te escribo para revisar juntos las nuevas herramientas de recordatorios preventivos.";
                $actionUrl = $waPhone ? "https://wa.me/{$waPhone}?text=" . urlencode($waText) : '/super-admin/tenants?manage=' . $t->id;
            } else {
                $category = 'healthy';
                $priority = 'success';
                $badge = 'Operación estable';
                $diagnosis = "Clínica operando con {$subsCount} membresías activas y {$plansCount} planes configurados en su vitrina pública.";
                $actionLabel = 'Ver clínica';
                $actionUrl = '/impersonate-clinic/' . $t->id;
            }

            return [
                'id' => $t->id,
                'name' => $t->name,
                'slug' => $t->slug,
                'city' => $branding['city'] ?? 'Colombia',
                'doctor_name' => $doctorName,
                'status' => $status,
                'plan_tier' => $planTier,
                'monthly_fee' => $monthlyFee,
                'pets_count' => $petsCount,
                'subscriptions_count' => $subsCount,
                'plans_count' => $plansCount,
                'health_score' => $healthScore,
                'category' => $category,
                'priority' => $priority,
                'badge' => $badge,
                'diagnosis' => $diagnosis,
                'action_label' => $actionLabel,
                'action_url' => $actionUrl,
                'storefront_url' => $t->base_url,
            ];
        })->values();

        // 3. Inteligencia de Prospección B2B por Ciudad
        $totalProspectos = 0;
        $contactadosCount = 0;
        $interesadosCount = 0;
        $topCities = [];

        try {
            $totalProspectos = ProspectoVeterinaria::count();
            $contactadosCount = ProspectoVeterinaria::whereIn('estado', ['contactado', 'interesado', 'demo_agendada', 'cerrado'])->count();
            $interesadosCount = ProspectoVeterinaria::whereIn('estado', ['interesado', 'demo_agendada', 'cerrado'])->count();

            $topCities = ProspectoVeterinaria::selectRaw("COALESCE(NULLIF(ciudad, ''), 'Colombia') as city, COUNT(*) as total, SUM(CASE WHEN estado = 'nuevo' OR estado IS NULL THEN 1 ELSE 0 END) as nuevos")
                ->groupBy('city')
                ->orderByDesc('total')
                ->limit(6)
                ->get()
                ->map(fn ($row) => [
                    'city' => $row->city,
                    'total' => (int) $row->total,
                    'pending' => (int) $row->nuevos,
                ])
                ->toArray();
        } catch (\Throwable $e) {
            // Fallback seguro si la tabla aún no tiene registros
        }

        // 4. Estado Técnico del Motor de IA
        $geminiConfigured = !empty(env('GEMINI_API_KEY'));
        $geminiModel = env('GEMINI_MODEL', 'gemini-2.5-flash');
        $fastApiUrl = env('FASTAPI_AI_URL', 'http://avi-ai:8001');

        $authUser = (auth()->user() && auth()->user()->role === 'super_admin')
            ? auth()->user()
            : User::where('role', 'super_admin')->orWhere('email', 'contacto@avipetapp.com')->first();

        return Inertia::render('SuperAdmin/Inteligencia', [
            'metrics' => [
                'mrr' => $mrr,
                'gmv' => $gmv,
                'activeClinics' => $activePaidTenants->count(),
                'totalClinics' => $tenants->count(),
                'totalPets' => $totalPets,
                'totalSubscriptions' => $activeSubscriptions->count(),
                'totalRedemptions' => $totalRedemptions,
                'totalProspectos' => $totalProspectos,
                'contactadosCount' => $contactadosCount,
                'interesadosCount' => $interesadosCount,
            ],
            'clinicInsights' => $clinicInsights,
            'topCities' => $topCities,
            'aiEngine' => [
                'geminiReady' => $geminiConfigured,
                'geminiModel' => $geminiModel,
                'fastApiUrl' => $fastApiUrl,
            ],
            'userName' => $authUser?->name ?? 'Robinson Naranjo',
            'userEmail' => $authUser?->email ?? 'contacto@avipetapp.com',
        ]);
    }

    public function askCopilot(Request $request)
    {
        $validated = $request->validate([
            'prompt_type' => 'required|string|max:60',
            'custom_context' => 'nullable|string|max:500',
        ]);

        $type = $validated['prompt_type'];
        $context = trim($validated['custom_context'] ?? '');

        $templates = [
            'whatsapp_socias' => "Hola Dr(a)., te saluda Robinson Naranjo de AviPetApp.\n\nEstamos seleccionando 1 clínica veterinaria socia en tu zona para activar su propio programa de planes de salud para mascotas (con carnets digitales QR, recordatorios por WhatsApp y 0 % de comisión sobre tus cobros).\n\nLa clínica piloto en Cajicá (Vet-Pet Patitas) ya genera ingresos recurrentes todos los meses con sus propios pacientes. Tienes 15 días de prueba sin costo y el modelo de arranque de cero riesgo ($5.000 COP por mascota activa).\n\n¿Te comparto el enlace de cómo se vería la vitrina con el logo de tu clínica?",
            'objecion_software' => "Excelente que ya tengas software de historia clínica, Doctor(a). Precisamente AviPetApp NO te obliga a cambiar tu sistema actual ni migrar historias médicas.\n\nAviPetApp funciona en paralelo como tu vitrina comercial de membresías y carnet digital QR en recepción: el tutor escanea el afiche en sala de espera, se afilia a tu plan preventivo y tu recepción valida en 3 segundos qué vacunas o consultas tiene disponibles. Así conviertes pacientes ocasionales en ingresos mensuales predecibles sin tocar tu historia clínica actual.",
            'objecion_riesgo' => "Totalmente comprensible, Doctor(a). Por eso diseñamos la modalidad de Cero Riesgo de AviPetApp:\n\n1. Tienes 15 días gratis sin tarjeta de crédito para configurar tus planes y tu Afiche QR.\n2. Al terminar la prueba, no estás obligado a pagar una mensualidad alta: puedes activar un paquete prepago de 10 mascotas por solo $50.000 COP ($5.000 por mascota).\n3. Con solo 2 mascotas afiliadas a un plan de $50.000/mes, tu clínica recauda $100.000 COP (100 % directo a tu Nequi o Bancolombia) y el software se paga solo desde el primer día.",
            'reactivacion_base' => "Hola [Nombre del Tutor], te escribimos de [Nombre de la Clínica] 🐾.\n\nRevisando el historial preventivo de [Nombre de la Mascota], queremos invitarte a conocer nuestro nuevo Plan de Salud Preventiva: incluye sus consultas del año, esquema de vacunación anual, desparasitaciones trimestrales y carnet digital con descuentos exclusivos por solo $50.000 COP al mes.\n\nPuedes ver los beneficios y activar el carnet digital de [Nombre de la Mascota] aquí: https://tu-clinica.avipetapp.com",
        ];

        $baseSuggestion = $templates[$type] ?? $templates['whatsapp_socias'];

        // Si hay clave de Gemini y el usuario escribió contexto adicional, enriquecer con Gemini
        $apiKey = env('GEMINI_API_KEY');
        if ($apiKey && !empty($context)) {
            try {
                $systemPrompt = "Eres el Copiloto Estratégico B2B de AviPetApp (Software con IA para veterinarias en Colombia). Reglas del Manual Maestro de Marca v1.1: escribir siempre AviPetApp (una sola palabra), nunca llamar 'seguro' a un plan de salud (usar 'plan de salud para mascotas' o 'membresía'), nunca prometer ingresos garantizados, usar español colombiano claro, profesional y cercano. Adapta el siguiente mensaje base al contexto específico que pide el usuario:\n\nMensaje base:\n{$baseSuggestion}\n\nContexto adicional solicitado:\n{$context}";

                $response = Http::timeout(8)->post(
                    "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}",
                    [
                        'contents' => [
                            ['parts' => [['text' => $systemPrompt]]],
                        ],
                    ]
                );

                if ($response->successful()) {
                    $generated = data_get($response->json(), 'candidates.0.content.parts.0.text');
                    if (!empty($generated)) {
                        return response()->json([
                            'suggestion' => trim($generated),
                            'source' => 'gemini',
                        ]);
                    }
                }
            } catch (\Throwable $e) {
                // Fallback inmediato a la plantilla verificada
            }
        }

        if (!empty($context)) {
            $baseSuggestion .= "\n\n📌 Nota personalizada: " . $context;
        }

        return response()->json([
            'suggestion' => $baseSuggestion,
            'source' => 'template',
        ]);
    }
}
