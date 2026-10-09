<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Bienvenido a AVI-Plan!</title>
    <style>
        body { margin: 0; padding: 0; background-color: #0b1120; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; }
        .wrapper { width: 100%; background-color: #0b1120; padding: 30px 10px; }
        .main { max-width: 600px; margin: 0 auto; background-color: #0f172a; border: 1px solid #1e293b; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.4); }
        .header { background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); padding: 36px 30px; text-align: center; }
        .content { padding: 36px 32px; color: #cbd5e1; font-size: 15px; line-height: 1.6; }
        .badge { display: inline-block; background-color: rgba(255,255,255,0.2); color: #ffffff; padding: 6px 14px; border-radius: 50px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; }
        .title { color: #ffffff; font-size: 24px; font-weight: 800; margin: 0; line-height: 1.3; }
        .subtitle { color: #93c5fd; font-size: 14px; margin: 8px 0 0 0; }
        .card { background-color: #1e293b; border: 1px solid #334155; border-radius: 14px; padding: 20px; margin: 24px 0; }
        .card-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #334155; font-size: 13px; }
        .card-row:last-child { border-bottom: none; }
        .card-label { color: #94a3b8; font-weight: 600; }
        .card-val { color: #ffffff; font-weight: 700; text-align: right; }
        .btn-container { text-align: center; margin: 30px 0 20px 0; }
        .btn { display: inline-block; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: #ffffff !important; padding: 16px 36px; border-radius: 12px; font-size: 15px; font-weight: 800; text-decoration: none; box-shadow: 0 10px 20px rgba(37,99,235,0.3); }
        .steps-box { background-color: #0b1329; border: 1px solid #1e293b; border-radius: 14px; padding: 22px; margin: 24px 0; }
        .step { margin-bottom: 14px; }
        .step:last-child { margin-bottom: 0; }
        .step-num { display: inline-block; width: 22px; height: 22px; background-color: #2563eb; color: #ffffff; border-radius: 50%; text-align: center; font-size: 12px; line-height: 22px; font-weight: bold; margin-right: 8px; }
        .step-title { color: #f1f5f9; font-weight: 700; }
        .step-desc { color: #94a3b8; font-size: 13px; margin: 2px 0 0 34px; }
        .support-box { background: linear-gradient(135deg, rgba(16,185,129,0.1) 0%, rgba(5,150,105,0.05) 100%); border: 1px solid rgba(16,185,129,0.3); border-radius: 14px; padding: 20px; margin-top: 26px; }
        .wa-btn { display: inline-block; background-color: #10b981; color: #ffffff !important; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 700; text-decoration: none; margin-top: 10px; }
        .footer { text-align: center; padding: 24px; color: #64748b; font-size: 12px; }
        .footer a { color: #3b82f6; text-decoration: none; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="main">
            <!-- Header -->
            <div class="header">
                <span class="badge">🐾 Software SaaS Veterinario</span>
                <h1 class="title">¡Bienvenido(a) a AVI-Plan!</h1>
                <p class="subtitle">Plataforma Oficial de Planes Preventivos para Mascotas</p>
            </div>

            <!-- Content -->
            <div class="content">
                <p style="margin-top: 0;">Estimado(a) <strong>Dr(a). {{ $adminName }}</strong>,</p>
                <p>Nos complace darte la bienvenida oficial a la plataforma de salud preventiva para mascotas más moderna de Colombia. Tu cuenta para <strong>{{ $clinicName }}</strong> ({{ $city }}) ha sido creada con éxito.</p>
                
                <p>A partir de hoy dispones de <strong>15 días de acceso total y gratuito</strong> a todas las herramientas operativas para fidelizar clientes y generar ingresos recurrentes mensuales.</p>

                <!-- Credentials Card -->
                <div class="card">
                    <div style="font-size: 12px; font-weight: 800; color: #38bdf8; text-transform: uppercase; margin-bottom: 12px; letter-spacing: 0.5px;">
                        🔐 Tus Credenciales y Enlaces de Acceso
                    </div>
                    <div class="card-row">
                        <span class="card-label">Clínica:</span>
                        <span class="card-val">{{ $clinicName }}</span>
                    </div>
                    <div class="card-row">
                        <span class="card-label">Correo de Usuario:</span>
                        <span class="card-val">{{ $user->email }}</span>
                    </div>
                    <div class="card-row">
                        <span class="card-label">Tu Portal Administrativo:</span>
                        <span class="card-val"><a href="{{ $adminUrl }}" style="color: #60a5fa; text-decoration: none;">{{ $adminUrl }}</a></span>
                    </div>
                    <div class="card-row">
                        <span class="card-label">Vitrina Web para Clientes:</span>
                        <span class="card-val"><a href="{{ $storefrontUrl }}" style="color: #60a5fa; text-decoration: none;">{{ $storefrontUrl }}</a></span>
                    </div>
                </div>

                <!-- Call to action button -->
                <div class="btn-container">
                    <a href="{{ $adminUrl }}" class="btn" target="_blank">
                        Ingresar a mi Panel de Control →
                    </a>
                </div>

                <!-- Steps to start -->
                <div class="steps-box">
                    <div style="font-size: 13px; font-weight: 800; color: #e2e8f0; margin-bottom: 14px;">
                        🚀 3 Pasos rápidos para comenzar a afiliar pacientes hoy:
                    </div>
                    <div class="step">
                        <span class="step-num">1</span>
                        <span class="step-title">Personaliza tu Identidad:</span>
                        <p class="step-desc">Ingresa a configuración y sube el logo oficial de tu veterinaria para que aparezca en el carnet digital de tus clientes.</p>
                    </div>
                    <div class="step">
                        <span class="step-num">2</span>
                        <span class="step-title">Activa tu Primer Plan Preventivo:</span>
                        <p class="step-desc">Personaliza las consultas, vacunas y desparasitaciones que incluirás en tu membresía mensual.</p>
                    </div>
                    <div class="step">
                        <span class="step-num">3</span>
                        <span class="step-title">Descarga tu Afiche de Mostrador:</span>
                        <p class="step-desc">Genera e imprime el afiche con código QR para colocarlo en tu recepción y permitir auto-afiliación digital en 60 segundos.</p>
                    </div>
                </div>

                <!-- Personal support card from Robinson -->
                <div class="support-box">
                    <div style="color: #10b981; font-weight: 800; font-size: 14px; margin-bottom: 4px;">
                        👨‍💼 Asesoría Personalizada y Acompañamiento VIP
                    </div>
                    <p style="margin: 0; font-size: 13px; color: #94a3b8; line-height: 1.5;">
                        Tu asesor de cuenta asignado es <strong>Robinson Naranjo</strong>, CEO y Especialista en Arquitectura de AVI-Plan. Te ayudaremos a diseñar tu primer plan para que comiences a generar ingresos predecibles desde la primera semana.
                    </p>
                    <a href="https://wa.me/573235813942?text={{ urlencode('Hola Robinson, me acabo de registrar en AVI-Plan con mi clínica ' . $clinicName . '. Quisiera asesoría para configurar mis planes.') }}" target="_blank" class="wa-btn">
                        💬 Escribir al WhatsApp de Robinson (323 581 3942)
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p style="margin: 0 0 6px 0;">© {{ date('Y') }} AVI-Plan. Todos los derechos reservados.</p>
                <p style="margin: 0;">Tecnología en Planes Preventivos de Salud para Mascotas | <a href="https://avipetapp.com" target="_blank">avipetapp.com</a></p>
            </div>
        </div>
    </div>
</body>
</html>
