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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ClinicWelcomeMail;
use App\Mail\NewClinicLeadAlertMail;

class ClinicOnboardingController extends Controller
{
    /**
     * Procesa el alta express en 60 segundos de una nueva clínica veterinaria (15 días gratis).
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'clinic_name' => ['required', 'string', 'min:3', 'max:120'],
            'doctor_name' => ['nullable', 'string', 'max:120'],
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
                    'doctor_name' => !empty($validated['doctor_name']) ? trim($validated['doctor_name']) : null,
                    'doctor_title' => 'Médica Veterinaria Directora',
                    'logo_url' => null,
                    'hero_image_url' => 'https://images.unsplash.com/photo-1548767797-d8c844163c4c?w=700&auto=format&fit=crop&q=80',
                    'banner_image_url' => 'https://images.unsplash.com/photo-1576201836106-db1758fd1c97?w=1000',
                    'banner_video_url' => null,
                    'primary_color' => '#0D9488', // Teal profesional
                    'secondary_color' => '#0F172A',
                    'hero_title' => 'El cuidado de tu mascota, todo el año.',
                    'hero_subtitle' => 'Accede a servicios veterinarios y beneficios exclusivos con una membresía diseñada por ' . $validated['clinic_name'] . '.',
                    'hero_price_badge' => 'Desde $50.000/mes',
                    'payment_nequi' => $validated['phone'],
                    'payment_bank_info' => '',
                    'payment_bold_link' => '',
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
            $adminName = !empty($validated['doctor_name']) ? trim($validated['doctor_name']) : ('Dr(a). ' . $validated['clinic_name']);
            $user = User::create([
                'tenant_id' => $tenant->id,
                'name' => $adminName,
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'clinic_admin',
            ]);

            // 7. Notificar por Correo Transaccional (Bienvenida al Doctor y Alerta a SuperAdmin)
            try {
                $host = preg_replace('/^www\./', '', request()->getHost());
                if (in_array($host, ['localhost', '127.0.0.1']) || filter_var($host, FILTER_VALIDATE_IP)) {
                    $adminUrl = url("/admin/{$tenant->slug}");
                    $storefrontUrl = url("/v/{$tenant->slug}");
                } else {
                    $scheme = request()->getScheme();
                    $adminUrl = "{$scheme}://{$tenant->slug}.{$host}/admin";
                    $storefrontUrl = "{$scheme}://{$tenant->slug}.{$host}";
                }

                // 7.1 Enviar plantilla HTML de bienvenida al Doctor registrado
                Mail::to($user->email)->send(new ClinicWelcomeMail(
                    $tenant,
                    $user,
                    $validated['clinic_name'],
                    $adminName,
                    $validated['city'],
                    $adminUrl,
                    $storefrontUrl
                ));

                // 7.2 Enviar alerta ejecutiva HTML a Robinson / SuperAdmin con link de WhatsApp
                $destinatarios = array_filter(array_map('trim', explode(',', env('ADMIN_NOTIFY_EMAILS', 'contacto@avipetapp.com,ingrobinson2013@gmail.com,petmovilveterinario@gmail.com'))));
                $waDigits = preg_replace('/[^0-9]/', '', $validated['phone']);
                $waPrefix = str_starts_with($waDigits, '57') ? $waDigits : "57{$waDigits}";
                $waLink = "https://wa.me/{$waPrefix}?text=" . urlencode("Hola Dr(a) de {$validated['clinic_name']}, soy Robinson Naranjo de AVI-Plan. Vi que te acabas de registrar para tu prueba de 15 días gratis. Te escribo para asesorarte y ayudarte a dejar listo tu primer plan y tu afiche de mostrador.");

                Mail::to($destinatarios)->send(new NewClinicLeadAlertMail(
                    $tenant,
                    $user,
                    $validated,
                    $waLink,
                    $adminUrl,
                    $storefrontUrl
                ));
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('No se pudo enviar notificación de bienvenida/alerta de nueva clínica: ' . $e->getMessage());
            }

            // 8. Iniciar Sesión de inmediato y redirigir a configurar Logo y Marca
            Auth::login($user, true);

            $targetUrl = "/admin/{$tenant->slug}/clinic-settings?first_time=1";

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
