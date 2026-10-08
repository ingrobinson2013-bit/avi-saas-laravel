<?php

namespace App\Http\Controllers;

use App\Models\BenefitDefinition;
use App\Models\Plan;
use App\Models\PlanBenefit;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClinicOnboardingController extends Controller
{
    /**
     * Procesa el alta express en 60 segundos de una nueva clínica veterinaria (15 días gratis).
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'clinic_name' => ['required', 'string', 'min:3', 'max:120'],
            'city' => ['required', 'string', 'min:2', 'max:80'],
            'phone' => ['required', 'string', 'min:7', 'max:25'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'clinic_name.required' => 'El nombre de tu veterinaria o clínica es obligatorio.',
            'city.required' => 'La ciudad es requerida.',
            'phone.required' => 'El número de WhatsApp es necesario para enviarte alertas.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'Este correo ya tiene una cuenta registrada en AVI-Plan.',
            'password.min' => 'La contraseña debe tener mínimo 6 caracteres.',
        ]);

        return DB::transaction(function () use ($validated) {
            // 1. Generar Slug único
            $baseSlug = Str::slug($validated['clinic_name']);
            if (empty($baseSlug)) {
                $baseSlug = 'veterinaria-' . Str::random(5);
            }

            $slug = $baseSlug;
            $counter = 1;
            while (Tenant::where('slug', $slug)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
            }

            // 2. Crear el Tenant con 15 días gratis de prueba en tier Pro (provisionDefaultPlansAndBenefits se ejecuta automáticamente)
            $tenant = Tenant::create([
                'name' => $validated['clinic_name'],
                'slug' => $slug,
                'saas_plan_tier' => 'pro',
                'is_active' => true,
                'branding' => [
                    'city' => $validated['city'],
                    'address' => 'Sede Principal',
                    'phone' => $validated['phone'],
                    'email' => $validated['email'],
                    'primary_color' => '#0D9488', // Teal profesional
                    'secondary_color' => '#0F172A',
                    'hero_title' => 'El cuidado de tu mascota, todo el año.',
                    'hero_subtitle' => 'Accede a servicios veterinarios y beneficios exclusivos con una membresía diseñada por ' . $validated['clinic_name'] . '.',
                    'hero_price_badge' => 'Desde $50.000/mes',
                    'payment_nequi' => $validated['phone'],
                    'payment_instructions' => 'Transfiere a nuestro Nequi o cuenta y envía tu comprobante indicando el código de tu carnet digital.',
                    'section_how_it_works' => true,
                    'section_plans' => true,
                    'section_calculator' => true,
                    'section_carnet_feature' => true,
                    'section_comparison' => true,
                    'section_carencias' => true,
                    'section_facilities' => true,
                    'trial_active' => true,
                    'trial_ends_at' => now()->addDays(15)->toIso8601String(),
                ],
            ]);

            // 3. Crear el Usuario Administrador de la Clínica
            $user = User::create([
                'tenant_id' => $tenant->id,
                'name' => 'Dr(a). ' . $validated['clinic_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'clinic_admin',
            ]);

            // 7. Notificar a Robinson y SuperAdmin por Correo de inmediato para asesoría
            try {
                $destinatarios = array_filter(array_map('trim', explode(',', env('ADMIN_NOTIFY_EMAILS', 'contacto@avipetapp.com,ingrobinson2013@gmail.com,petmovilveterinario@gmail.com'))));
                $waDigits = preg_replace('/[^0-9]/', '', $validated['phone']);
                $waPrefix = str_starts_with($waDigits, '57') ? $waDigits : "57{$waDigits}";
                $waLink = "https://wa.me/{$waPrefix}?text=" . urlencode("Hola Dr(a) de {$validated['clinic_name']}, soy Robinson Naranjo de AVI-Plan. Vi que te acabas de registrar para tu prueba de 15 días gratis. Te escribo para asesorarte y ayudarte a dejar listo tu primer plan y tu afiche de mostrador.");

                $asunto = "🚨 ¡Nueva Veterinaria Registrada!: {$validated['clinic_name']} ({$validated['city']})";
                $cuerpo = "¡Hola Robinson! Una nueva clínica veterinaria se acaba de registrar en AVI-Plan:\n\n"
                    . "🏥 Clínica: {$validated['clinic_name']}\n"
                    . "📍 Ciudad: {$validated['city']}\n"
                    . "📱 WhatsApp: {$validated['phone']}\n"
                    . "📧 Correo: {$validated['email']}\n"
                    . "📅 Fecha: " . now()->format('Y-m-d H:i:s') . "\n\n"
                    . "📲 Escríbele al WhatsApp con 1 clic: {$waLink}\n\n"
                    . "🔗 Panel Admin de la Clínica: " . url("/admin/{$tenant->slug}") . "\n"
                    . "🌐 Portal Web de Pacientes: " . url("/v/{$tenant->slug}") . "\n"
                    . "⚙️ Gestionar en SuperAdmin: " . url("/super-admin/tenants") . "\n";

                \Illuminate\Support\Facades\Mail::raw($cuerpo, function ($msg) use ($destinatarios, $asunto) {
                    $msg->to($destinatarios)->subject($asunto);
                });
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('No se pudo enviar notificación de correo a Robinson: ' . $e->getMessage());
            }

            // 8. Iniciar Sesión de inmediato
            Auth::login($user, true);

            $targetUrl = "/admin/{$tenant->slug}";

            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => '¡Clínica creada con éxito! Bienvenido(a) a tu prueba de 15 días gratis.',
                    'redirect_url' => $targetUrl,
                    'tenant_name' => $tenant->name,
                    'tenant_slug' => $tenant->slug,
                    'storefront_url' => url("/v/{$tenant->slug}"),
                    'admin_url' => url("/admin/{$tenant->slug}"),
                ]);
            }

            return redirect($targetUrl)->with('success', '¡Bienvenido(a)! Tu clínica ya tiene 15 días de prueba gratis activos.');
        });
    }
}
