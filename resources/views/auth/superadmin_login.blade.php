<!DOCTYPE html>
<html lang="es" class="h-full bg-[#080B20] text-slate-100 antialiased selection:bg-[#6D28D9] selection:text-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Centro de Control · SuperAdmin | AviPetApp</title>
    <link rel="icon" type="image/svg+xml" href="/brand/favicons/favicon.svg?v=20261017">
    <link rel="icon" type="image/png" sizes="48x48" href="/brand/favicons/favicon-48.png?v=20261017">
    <link rel="shortcut icon" href="/favicon.ico?v=20261017">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', Arial, sans-serif; }
    </style>
</head>
<body class="min-h-full flex flex-col justify-between bg-gradient-to-b from-[#080B20] via-[#111936] to-[#080B20] py-8 px-4 sm:px-6 lg:px-8 relative overflow-x-hidden">

    <!-- Orbes de luz decorativos -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[350px] bg-[#A855F7]/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 right-1/4 w-[400px] h-[300px] bg-[#35DDF5]/10 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Encabezado superior -->
    <header class="max-w-md w-full mx-auto flex items-center justify-between text-xs text-slate-400 relative z-10 mb-4">
        <a href="/" class="hover:text-white transition flex items-center gap-1.5 font-bold">
            <span>←</span>
            <span>Volver a AviPetApp</span>
        </a>
        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#111936] border border-[#1E2B58] text-[10px] font-bold text-[#35DDF5]">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
            <span>Acceso SuperAdmin</span>
        </span>
    </header>

    <!-- Tarjeta Principal de Login -->
    <main class="max-w-md w-full mx-auto relative z-10 flex-1 flex flex-col justify-center">
        <div class="bg-[#111936]/90 backdrop-blur-xl border border-[#1E2B58] rounded-3xl p-6 sm:p-9 shadow-2xl space-y-6">
            
            <!-- Identidad AviPetApp -->
            <div class="text-center space-y-2">
                <div class="flex justify-center pb-2">
                    <img src="/brand/svg/avipetapp-horizontal-fondo-oscuro.svg" alt="AviPetApp" class="h-9 w-auto object-contain">
                </div>

                <div class="pt-1">
                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-[#6D28D9]/20 text-[#A855F7] border border-[#6D28D9]/30 text-[10px] font-black uppercase tracking-wider mb-1">
                        Centro de Control SaaS
                    </span>
                    <h1 class="text-xl sm:text-2xl font-black text-white tracking-tight leading-snug">
                        Iniciar Sesión SuperAdmin
                    </h1>
                    <p class="text-xs text-slate-400 font-medium">Gestión de Clínicas, Métricas, Prospección e IA</p>
                </div>
            </div>

            <!-- Alertas y Notificaciones -->
            @if(session('success'))
            <div class="p-3.5 rounded-xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-xs font-semibold flex items-center gap-2">
                <span>✓</span>
                <span>{{ session('success') }}</span>
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

            <!-- Formulario de Acceso SuperAdmin -->
            <form method="POST" action="/super-admin/login" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">
                        Correo Electrónico
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email', 'contacto@avipetapp.com') }}" 
                        required 
                        autofocus 
                        placeholder="contacto@avipetapp.com" 
                        class="w-full bg-[#080B20] border border-[#1E2B58] rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-[#6D28D9] focus:ring-2 focus:ring-[#6D28D9]/30 transition font-medium"
                    >
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">
                        Contraseña
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required 
                            placeholder="••••••••" 
                            class="w-full bg-[#080B20] border border-[#1E2B58] rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-[#6D28D9] focus:ring-2 focus:ring-[#6D28D9]/30 transition font-medium"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword()" 
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-xs text-slate-400 hover:text-white"
                        >
                            <span id="eye-icon">👁️</span>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs text-slate-400">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" checked class="rounded border-slate-700 bg-[#080B20] text-[#6D28D9] focus:ring-0">
                        <span>Recordarme en este equipo</span>
                    </label>
                </div>

                <button 
                    type="submit" 
                    class="w-full py-3.5 px-4 bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-bold text-sm rounded-xl shadow-lg shadow-[#6D28D9]/25 transition-all transform hover:-translate-y-0.5 active:translate-y-0 cursor-pointer"
                >
                    Entrar al Centro de Control →
                </button>
            </form>
        </div>
    </main>

    <!-- Footer oficial -->
    <footer class="max-w-md w-full mx-auto text-center text-xs text-slate-500 relative z-10 mt-6">
        <p>AviPetApp · Más inteligencia. Más bienestar. Más futuro.</p>
    </footer>

    <script>
        function togglePassword() {
            var input = document.getElementById('password');
            var icon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = '🙈';
            } else {
                input.type = 'password';
                icon.textContent = '👁️';
            }
        }
    </script>
</body>
</html>
