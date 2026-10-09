<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-950 text-slate-100 antialiased selection:bg-blue-600 selection:text-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Iniciar Sesión — Panel Administrativo | {{ $tenant->name ?? 'Clínica Veterinaria' }}</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    @php
        $logoUrl = $tenant->branding['logo_url'] ?? null;
        $primaryColor = $tenant->branding['primary_color'] ?? '#0080ff';
        $secondaryColor = $tenant->branding['secondary_color'] ?? '#0B1120';
        $city = $tenant->branding['city'] ?? '';
        $slug = $tenant->slug ?? 'vet-pet-patitas';
    @endphp

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="min-h-full flex flex-col justify-between bg-gradient-to-b from-slate-950 via-[#0A1120] to-slate-950 py-8 px-4 sm:px-6 lg:px-8 relative overflow-x-hidden">

    <!-- Orbes de luz decorativos -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[350px] bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Encabezado superior -->
    <header class="max-w-md w-full mx-auto flex items-center justify-between text-xs text-slate-400 relative z-10 mb-4">
        <a href="{{ ($isTenantHost ?? false) ? '/' : ('/v/' . $slug) }}" class="hover:text-white transition flex items-center gap-1.5 font-bold">
            <span>←</span>
            <span>Volver a la vitrina</span>
        </a>
        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-slate-900 border border-slate-800 text-[10px] font-bold text-slate-400">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
            <span>Sistema Seguro</span>
        </span>
    </header>

    <!-- Tarjeta Principal de Login -->
    <main class="max-w-md w-full mx-auto relative z-10 flex-1 flex flex-col justify-center">
        <div class="bg-slate-900/90 backdrop-blur-xl border border-slate-800 rounded-3xl p-6 sm:p-9 shadow-2xl space-y-6">
            
            <!-- Identidad de Marca Blanca de la Clínica -->
            <div class="text-center space-y-2">
                <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto rounded-2xl bg-white border border-slate-700/80 shadow-lg p-2 flex items-center justify-center shrink-0 overflow-hidden">
                    @if(!empty($logoUrl))
                        <img src="{{ $logoUrl }}" alt="{{ $tenant->name }}" class="w-full h-full object-contain">
                    @else
                        <span class="text-3xl sm:text-4xl">🐾</span>
                    @endif
                </div>

                <div class="pt-1">
                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[10px] font-black uppercase tracking-wider mb-1.5">
                        🔐 Portal Administrativo
                    </span>
                    <h1 class="text-xl sm:text-2xl font-black text-white tracking-tight leading-snug">
                        {{ $tenant->name }}
                    </h1>
                    @if(!empty($city))
                        <p class="text-xs text-slate-400 font-medium">📍 {{ $city }}</p>
                    @endif
                </div>
            </div>

            <!-- Alertas y Notificaciones -->
            @if(session('success'))
            <div class="p-3.5 rounded-xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-xs font-semibold flex items-center gap-2">
                <span>✓</span>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if(session('info'))
            <div class="p-3.5 rounded-xl bg-blue-500/15 border border-blue-500/30 text-blue-300 text-xs font-semibold flex items-center gap-2">
                <span>ℹ️</span>
                <span>{{ session('info') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="p-3.5 rounded-xl bg-rose-500/15 border border-rose-500/30 text-rose-300 text-xs font-semibold space-y-1">
                @foreach($errors->all() as $error)
                    <div class="flex items-center gap-1.5">
                        <span>⚠️</span>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
            @endif

            <!-- Formulario de Acceso -->
            <form method="POST" action="{{ ($isTenantHost ?? false) ? '/admin/login' : ('/admin/' . $slug . '/login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">
                        Correo Electrónico
                    </label>
                    <div class="relative">
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus 
                            placeholder="doctor@tuclinica.com" 
                            class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30 transition font-medium"
                        >
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-bold text-slate-300 uppercase tracking-wider">
                            Contraseña
                        </label>
                        <button type="button" onclick="togglePasswordVisibility()" class="text-[11px] font-semibold text-blue-400 hover:text-blue-300 transition">
                            <span id="toggle-pwd-label">Mostrar</span>
                        </button>
                    </div>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required 
                            placeholder="••••••••" 
                            class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30 transition font-medium"
                        >
                    </div>
                </div>

                <div class="flex items-center justify-between pt-1 text-xs">
                    <label class="flex items-center space-x-2 text-slate-400 cursor-pointer select-none">
                        <input type="checkbox" name="remember" value="1" class="rounded bg-slate-950 border-slate-700 text-blue-600 focus:ring-blue-500/30">
                        <span>Recordar sesión</span>
                    </label>
                    <a href="https://wa.me/573235813942?text={{ urlencode('Hola Robinson, olvidé mi contraseña o necesito soporte para acceder a mi clínica: ' . $tenant->name) }}" target="_blank" class="font-bold text-blue-400 hover:underline">
                        ¿Olvidaste tu clave?
                    </a>
                </div>

                <button 
                    type="submit" 
                    id="login-btn"
                    class="w-full py-3.5 px-5 bg-blue-600 hover:bg-blue-500 active:scale-[0.99] text-white font-extrabold text-sm rounded-xl shadow-lg shadow-blue-600/30 transition duration-150 flex items-center justify-center gap-2 cursor-pointer mt-2"
                >
                    <span>Ingresar al Panel Clínico</span>
                    <span>→</span>
                </button>
            </form>

        </div>
    </main>

    <!-- Footer -->
    <footer class="max-w-md w-full mx-auto text-center text-[11px] text-slate-500 mt-6 relative z-10">
        <p>© {{ date('Y') }} {{ $tenant->name }}. Tecnología segura por <a href="https://avipetapp.com" target="_blank" class="text-blue-400 font-bold hover:underline">AVI-Plan</a></p>
    </footer>

    <script>
        function togglePasswordVisibility() {
            const pwd = document.getElementById('password');
            const label = document.getElementById('toggle-pwd-label');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                label.innerText = 'Ocultar';
            } else {
                pwd.type = 'password';
                label.innerText = 'Mostrar';
            }
        }
    </script>
</body>
</html>
