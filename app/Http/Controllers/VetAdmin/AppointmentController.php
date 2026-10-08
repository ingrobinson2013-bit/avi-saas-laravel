<?php

namespace App\Http\Controllers\VetAdmin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\BenefitDefinition;
use App\Models\Pet;
use App\Models\Tenant;
use App\Services\GoogleCalendarService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AppointmentController extends Controller
{
    public function __construct(
        protected GoogleCalendarService $calendarService
    ) {}

    private function getTenantContext(Request $request, string $slug): array
    {
        $tenantSlug = $slug ?: 'vet-pet-patitas';
        $tenant = Tenant::where('slug', $tenantSlug)->firstOrFail();
        $tenantId = $tenant->id;

        $rawBrand = $tenant?->branding['brand_name'] ?? $tenant?->name ?? 'Vet-Pet Patitas';
        $brandName = trim(preg_replace('/\s+(Consultorio Veterinario|Clínica Veterinaria|Hospital Veterinario)$/i', '', $rawBrand));
        if (empty($brandName)) {
            $brandName = 'Vet-Pet Patitas';
        }
        $clinicSubtitle = $tenant?->branding['tagline'] ?? $tenant?->branding['subtitle'] ?? 'Planes de salud para su mascota';
        $logoUrl = $tenant?->branding['logo_url'] ?? null;

        $saasPlanTier = $tenant?->saas_plan_tier ?? $tenant?->branding['saas_plan'] ?? 'starter';
        $saasPlanNames = [
            'starter' => 'Plan Starter',
            'pro' => 'Plan Pro',
            'enterprise' => 'Plan Enterprise',
            'pay_per_pet' => 'Plan Por Paciente',
            'basic' => 'Plan Básico',
        ];
        $saasPlanName = $saasPlanNames[$saasPlanTier] ?? 'Plan Starter';
        $saasStatus = $tenant?->saas_status ?? $tenant?->branding['saas_status'] ?? 'paid';
        $saasStatusLabel = ($saasStatus === 'paid') ? 'Activo' : 'Al día';
        $saasPaidUntil = $tenant?->branding['saas_paid_until'] ?? '2026-10-30';
        $saasPaidUntilFormatted = $saasPaidUntil ? Carbon::parse($saasPaidUntil)->format('d/m/Y') : '30/10/2026';

        $isPilot = ($tenant?->slug === 'vet-pet-patitas');
        $doctorName = $tenant?->branding['doctor_name'] ?? null;
        $doctorTitle = $tenant?->branding['doctor_title'] ?? 'Médica Veterinaria Directora';

        if ($isPilot) {
            $greetingName = 'Dra. Vicky';
            $userName = 'Dra. Vicky Naranjo';
            $userRole = 'Administradora de Sede';
        } elseif (!empty($doctorName)) {
            $userName = $doctorName;
            $userRole = $doctorTitle;
            $cleanName = trim($doctorName);
            $parts = explode(' ', $cleanName);
            if (count($parts) >= 2 && in_array(strtolower($parts[0]), ['dr.', 'dr', 'dra.', 'dra', 'doctor', 'doctora'])) {
                $greetingName = $parts[0] . ' ' . $parts[1];
            } else {
                $greetingName = str_starts_with(strtolower($parts[0]), 'dr') ? $parts[0] : 'Dr(a). ' . $parts[0];
            }
        } else {
            $user = auth()->user();
            if ($user && !empty($user->name) && !str_starts_with($user->name, 'Dr(a). ' . ($tenant?->name ?? ''))) {
                $rawName = $user->name;
                $userName = $rawName;
                $userRole = $doctorTitle;
                $parts = explode(' ', trim($rawName));
                $greetingName = $parts[0] ?? 'Doctor(a)';
            } else {
                $greetingName = 'Doctor(a)';
                $userName = 'Doctor(a) Principal';
                $userRole = $doctorTitle;
            }
        }

        $cityRaw = $tenant?->branding['city'] ?? 'Cajicá, Cundinamarca';
        $cleanCity = trim(explode(',', $cityRaw)[0]);
        if (empty($cleanCity)) {
            $cleanCity = 'Cajicá';
        }

        return [
            'tenant' => $tenant,
            'tenantId' => $tenantId,
            'tenantSlug' => $tenantSlug,
            'brandName' => $brandName,
            'clinicSubtitle' => $clinicSubtitle,
            'logoUrl' => $logoUrl,
            'cleanCity' => $cleanCity,
            'userName' => $userName,
            'userRole' => $userRole,
            'greetingName' => $greetingName,
            'primaryColor' => $tenant?->branding['primary_color'] ?? '#0080ff',
            'secondaryColor' => $tenant?->branding['secondary_color'] ?? '#d437b5',
            'saasPlan' => [
                'tier' => $saasPlanTier,
                'name' => $saasPlanName,
                'status' => $saasStatus,
                'statusLabel' => $saasStatusLabel,
                'paidUntil' => $saasPaidUntilFormatted,
                'manageUrl' => "/admin/{$tenantSlug}/renovar-saas",
            ],
            'logoutUrl' => "/admin/{$tenantSlug}/logout",
        ];
    }

    /**
     * Muestra la Agenda de Citas & Sincronización con Google Calendar
     */
    public function index(Request $request, string $slug): Response
    {
        $ctx = $this->getTenantContext($request, $slug);
        $tenant = $ctx['tenant'];
        $tenantId = $ctx['tenantId'];

        $selectedDate = $request->query('date', Carbon::today()->toDateString());
        $dateObj = Carbon::parse($selectedDate);

        // Citas de la clínica ordenadas cronológicamente
        $appointments = Appointment::query()
            ->with(['pet.customer', 'benefitDefinition'])
            ->where('tenant_id', $tenantId)
            ->whereDate('scheduled_at', $dateObj->toDateString())
            ->orderBy('scheduled_at', 'asc')
            ->get()
            ->map(function ($app) use ($tenant) {
                return [
                    'id' => $app->id,
                    'title' => $app->title,
                    'doctor_name' => $app->doctor_name,
                    'scheduled_at' => $app->scheduled_at->format('Y-m-d H:i:s'),
                    'time_formatted' => $app->scheduled_at->format('g:i A'),
                    'end_time_formatted' => $app->end_at->format('g:i A'),
                    'duration_minutes' => $app->duration_minutes,
                    'status' => $app->status,
                    'status_label' => $app->status_label,
                    'service_type' => $app->service_type,
                    'notes' => $app->notes,
                    'pet_id' => $app->pet_id,
                    'pet_name' => $app->pet?->name ?? 'Paciente',
                    'pet_species' => $app->pet?->species === 'cat' ? 'Felino' : 'Canino',
                    'pet_breed' => $app->pet?->breed ?? 'Mestizo',
                    'customer_name' => $app->customer?->name ?? 'Tutor',
                    'customer_phone' => $app->customer?->phone ?? '3508742543',
                    'google_calendar_url' => $app->google_calendar_url ?: $this->calendarService->generateGoogleCalendarUrl($app, $tenant),
                    'whatsapp_reminder_url' => $this->calendarService->generateWhatsAppReminderUrl($app, $tenant),
                    'sync_status' => $app->sync_status,
                ];
            });

        // Métricas de agendamiento
        $todayCount = Appointment::where('tenant_id', $tenantId)->whereDate('scheduled_at', Carbon::today())->count();
        $upcomingCount = Appointment::where('tenant_id', $tenantId)
            ->where('scheduled_at', '>=', Carbon::now())
            ->whereNotIn('status', ['cancelled'])
            ->count();
        $completedThisMonth = Appointment::where('tenant_id', $tenantId)
            ->whereMonth('scheduled_at', Carbon::now()->month)
            ->where('status', 'completed')
            ->count();
        $googleSyncedCount = Appointment::where('tenant_id', $tenantId)
            ->where('sync_status', 'synced')
            ->count();

        // Pacientes disponibles para el selector de citas
        $pets = Pet::query()
            ->with(['customer', 'activeSubscription.plan'])
            ->when($tenantId, fn ($q) => $q->whereHas('customer', fn ($c) => $c->where('tenant_id', $tenantId)))
            ->get()
            ->map(fn ($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'species' => $p->species === 'cat' ? 'Felino' : 'Canino',
                'breed' => $p->breed ?: 'Mestizo',
                'customer_id' => $p->customer_id,
                'customer_name' => $p->customer?->name ?? 'Tutor',
                'customer_phone' => $p->customer?->phone ?? '3508742543',
                'plan_name' => $p->activeSubscription?->plan?->name ?? 'Sin Plan Activo',
            ]);

        // Servicios / Beneficios disponibles
        $services = BenefitDefinition::query()
            ->when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))
            ->orderBy('name')
            ->get()
            ->map(fn ($s) => [
                'id' => $s->id,
                'name' => $s->name,
                'category' => $s->category,
            ]);

        // Slots disponibles para el día seleccionado
        $availableSlots = $this->calendarService->getAvailableSlots($tenant, $selectedDate);

        return Inertia::render('VetAdmin/Calendar', array_merge($ctx, [
            'selectedDate' => $selectedDate,
            'appointments' => $appointments,
            'metrics' => [
                'todayCount' => $todayCount,
                'upcomingCount' => $upcomingCount,
                'completedThisMonth' => $completedThisMonth,
                'googleSyncedCount' => $googleSyncedCount,
            ],
            'pets' => $pets,
            'services' => $services,
            'availableSlots' => $availableSlots,
            'doctors' => [
                ['name' => $isPilot ? 'Dra. Vicky Naranjo' : ($doctorName ?: ($tenant->name ? "Dr(a). {$tenant->name}" : 'Médico(a) Veterinario(a)')), 'role' => $doctorTitle],
                ['name' => 'Dr. Robinson Naranjo', 'role' => 'Cirugía & Especialidades (NODIA)'],
            ],
        ]));
    }

    /**
     * Agendar Cita y Sincronizar con Google Calendar
     */
    public function store(\App\Http\Requests\CreateAppointmentRequest $request, string $slug): RedirectResponse
    {
        $ctx = $this->getTenantContext($request, $slug);
        $tenant = $ctx['tenant'];
        $tenantId = $ctx['tenantId'];

        $validated = $request->validated();

        $pet = Pet::with('customer')->findOrFail($validated['pet_id']);
        $duration = (int) ($validated['duration_minutes'] ?? 30);

        $scheduledAt = Carbon::parse("{$validated['date']} {$validated['time']}");
        $endAt = $scheduledAt->copy()->addMinutes($duration);

        // Validación anti-colisión
        $conflict = Appointment::where('tenant_id', $tenantId)
            ->where('doctor_name', $validated['doctor_name'])
            ->whereNotIn('status', ['cancelled'])
            ->where(function ($q) use ($scheduledAt, $endAt) {
                $q->where('scheduled_at', '<', $endAt)
                  ->where('end_at', '>', $scheduledAt);
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors([
                'time' => 'El horario seleccionado ya está ocupado por otra cita médica para este doctor.',
            ]);
        }

        $serviceTitle = ucfirst($validated['service_type']);
        $title = "{$serviceTitle} - {$pet->name} ({$pet->breed})";

        $appointment = Appointment::create([
            'tenant_id' => $tenantId,
            'pet_id' => $pet->id,
            'customer_id' => $pet->customer_id,
            'benefit_definition_id' => $validated['benefit_definition_id'] ?? null,
            'doctor_name' => $validated['doctor_name'],
            'title' => $title,
            'scheduled_at' => $scheduledAt,
            'end_at' => $endAt,
            'duration_minutes' => $duration,
            'status' => 'confirmed',
            'service_type' => $validated['service_type'],
            'notes' => $validated['notes'] ?? null,
            'sync_status' => 'synced',
        ]);

        // Generar enlace Google Calendar
        $googleCalendarUrl = $this->calendarService->generateGoogleCalendarUrl($appointment, $tenant);
        $appointment->update([
            'google_calendar_url' => $googleCalendarUrl,
        ]);

        // Disparar Evento Asíncrono de Cita Agendada
        \App\Events\AppointmentScheduledEvent::dispatch($appointment);

        return redirect("/admin/{$slug}/citas?date={$validated['date']}")
            ->with('success', "¡Cita agendada con éxito para {$pet->name}! Sincronizada con Google Calendar.");
    }

    /**
     * Actualiza el estado de la cita (Atendida, Cancelada, etc.)
     */
    public function updateStatus(Request $request, string $slug, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|string|in:scheduled,confirmed,completed,cancelled,no_show',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => $validated['status']]);

        return back()->with('success', "Estado de la cita actualizado a: {$appointment->status_label}");
    }

    /**
     * Retorna slots libres vía API JSON para llamadas dinámicas
     */
    public function availableSlots(Request $request, string $slug): JsonResponse
    {
        $ctx = $this->getTenantContext($request, $slug);
        $tenant = $ctx['tenant'];

        $date = $request->query('date', Carbon::today()->toDateString());
        $doctor = $request->query('doctor', 'Dra. Vicky Naranjo');

        $slots = $this->calendarService->getAvailableSlots($tenant, $date, $doctor);

        return response()->json([
            'success' => true,
            'date' => $date,
            'slots' => $slots,
        ]);
    }
}
