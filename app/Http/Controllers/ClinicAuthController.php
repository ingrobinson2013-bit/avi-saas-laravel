<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class ClinicAuthController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión de la clínica con su marca blanca.
     */
    public function showLoginForm(Request $request, ?string $slug = null)
    {
        $tenant = $this->resolveTenant($request, $slug);
        $isTenantHost = $this->isTenantHost($request);

        // Si ya está autenticado, redirigir al panel correspondiente
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'super_admin' || ($tenant && $user->tenant_id === $tenant->id)) {
                return redirect($isTenantHost ? "/admin" : ($tenant ? "/admin/{$tenant->slug}" : "/admin"));
            }
            if ($user->tenant) {
                $baseDomain = env('APP_BASE_DOMAIN', 'avipetapp.com');
                return redirect("https://{$user->tenant->slug}.{$baseDomain}/admin");
            }
        }

        // Si no se encontró tenant, tomar el piloto o el primero
        if (!$tenant) {
            $tenant = Tenant::where('slug', 'vet-pet-patitas')->first() ?? Tenant::first();
        }

        return view('auth.clinic_login', compact('tenant', 'isTenantHost'));
    }

    /**
     * Procesa la autenticación del usuario de la clínica.
     */
    public function login(Request $request, ?string $slug = null)
    {
        $tenant = $this->resolveTenant($request, $slug);
        $isTenantHost = $this->isTenantHost($request);

        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingresa un formato de correo válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // Protección contra ataques de fuerza bruta (5 intentos por minuto)
        $throttleKey = Str::transliterate(Str::lower($request->input('email')) . '|' . $request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withInput($request->only('email', 'remember'))->withErrors([
                'email' => "Demasiados intentos de acceso fallidos. Por favor intenta de nuevo en {$seconds} segundos.",
            ]);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();
            session()->forget(['admin_preview', 'admin_demo']);

            $user = Auth::user();

            // Validar si el usuario pertenece a esta clínica o es SuperAdmin
            if ($user->role === 'super_admin') {
                $target = $isTenantHost ? "/admin" : ($tenant ? "/admin/{$tenant->slug}" : "/admin");
                $intended = session()->pull('url.intended', $target);
                return redirect($intended)->with('success', "Bienvenido(a) {$user->name} (SuperAdmin)");
            }

            if ($tenant && $user->tenant_id === $tenant->id) {
                $target = $isTenantHost ? "/admin" : "/admin/{$tenant->slug}";
                $intended = session()->pull('url.intended', $target);
                return redirect($intended)->with('success', "Bienvenido(a) {$user->name}");
            }

            // Si el usuario pertenece a otra clínica diferente a la que intenta ingresar
            if ($user->tenant) {
                $baseDomain = env('APP_BASE_DOMAIN', 'avipetapp.com');
                return redirect("https://{$user->tenant->slug}.{$baseDomain}/admin")->with('info', "Has iniciado sesión en tu clínica: {$user->tenant->name}.");
            }

            // Si no tiene permisos de clínica
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withInput($request->only('email', 'remember'))->withErrors([
                'email' => 'Tu usuario no tiene permisos asignados a esta clínica veterinaria.',
            ]);
        }

        RateLimiter::hit($throttleKey, 60);

        return back()->withInput($request->only('email', 'remember'))->withErrors([
            'email' => 'El correo electrónico o la contraseña son incorrectos.',
        ]);
    }

    /**
     * Cierra la sesión activa.
     */
    public function logout(Request $request, ?string $slug = null)
    {
        $tenant = $this->resolveTenant($request, $slug);
        $isTenantHost = $this->isTenantHost($request);

        Auth::logout();
        session()->forget(['admin_preview', 'admin_demo', 'url.intended']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $redirectUrl = $isTenantHost ? "/admin/login" : ($tenant ? "/admin/{$tenant->slug}/login" : "/admin/login");

        return redirect($redirectUrl)->with('success', 'Sesión cerrada correctamente.');
    }

    /**
     * Determina si la petición actual proviene del subdominio o dominio propio de una clínica.
     */
    protected function isTenantHost(Request $request): bool
    {
        $host = strtolower(trim($request->getHost()));
        $baseDomain = env('APP_BASE_DOMAIN', 'avipetapp.com');
        $hostWithoutWww = preg_replace('/^www\./', '', $host);

        if (in_array($hostWithoutWww, ['localhost', '127.0.0.1', $baseDomain]) || str_contains($host, 'easypanel.host')) {
            return false;
        }

        return true;
    }

    /**
     * Resuelve el Tenant según el host (prioritario) o el slug en la URL.
     */
    protected function resolveTenant(Request $request, ?string $slug = null): ?Tenant
    {
        // 1. Si viene por Host (subdominio o dominio propio de la clínica)
        $host = strtolower(trim($request->getHost()));
        $baseDomain = env('APP_BASE_DOMAIN', 'avipetapp.com');
        $hostWithoutWww = preg_replace('/^www\./', '', $host);

        if (!in_array($hostWithoutWww, ['localhost', '127.0.0.1', $baseDomain]) && !str_contains($host, 'easypanel.host')) {
            $tenant = Tenant::where(function ($query) use ($host, $hostWithoutWww) {
                $query->where('domain', $host)
                      ->orWhere('domain', $hostWithoutWww)
                      ->orWhere('domain', 'https://' . $host)
                      ->orWhere('domain', 'https://' . $hostWithoutWww);
            })->first();

            if ($tenant) {
                return $tenant;
            }

            if (str_ends_with($host, '.' . $baseDomain)) {
                $subdomain = str_replace('.' . $baseDomain, '', $hostWithoutWww);
                if (!empty($subdomain) && $subdomain !== 'www') {
                    $tenant = Tenant::where('slug', $subdomain)->first();
                    if ($tenant) return $tenant;
                }
            }
        }

        // 2. Si viene por slug en la URL
        if (!empty($slug) && !in_array($slug, ['login', 'logout'])) {
            return Tenant::where('slug', $slug)->first();
        }

        return null;
    }
}
