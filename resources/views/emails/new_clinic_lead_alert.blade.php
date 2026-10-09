<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚨 Nueva Veterinaria Registrada en AVI-Plan</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #0b0f19;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #e2e8f0;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #111827;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #1f2937;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .header {
            background: linear-gradient(135deg, #059669 0%, #0d9488 50%, #0284c7 100%);
            padding: 32px 24px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            color: #ffffff;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .header p {
            margin: 8px 0 0;
            color: #e0f2fe;
            font-size: 14px;
            font-weight: 500;
        }
        .content {
            padding: 32px 28px;
        }
        .lead-badge {
            display: inline-block;
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 20px;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        .lead-card {
            background: #1f2937;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #374151;
            margin-bottom: 24px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #2d3748;
        }
        .info-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        .info-label {
            color: #94a3b8;
            font-size: 13px;
            font-weight: 500;
        }
        .info-value {
            color: #f8fafc;
            font-size: 14px;
            font-weight: 700;
            text-align: right;
        }
        .btn-whatsapp {
            display: block;
            width: 100%;
            box-sizing: border-box;
            background: #25D366;
            color: #ffffff !important;
            text-decoration: none;
            text-align: center;
            padding: 16px 20px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 800;
            letter-spacing: 0.3px;
            margin: 20px 0;
            box-shadow: 0 10px 20px -5px rgba(37, 211, 102, 0.4);
        }
        .quick-links {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 16px;
        }
        .btn-secondary {
            display: block;
            background: #374151;
            color: #e2e8f0 !important;
            text-decoration: none;
            text-align: center;
            padding: 12px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            border: 1px solid #4b5563;
        }
        .tip-box {
            background: rgba(14, 165, 233, 0.08);
            border-left: 4px solid #0ea5e9;
            padding: 16px;
            border-radius: 0 8px 8px 0;
            margin-top: 24px;
        }
        .tip-box p {
            margin: 0;
            font-size: 13px;
            color: #93c5fd;
            line-height: 1.5;
        }
        .footer {
            background: #0d1117;
            padding: 20px 24px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            border-top: 1px solid #1f2937;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🚨 ¡Nueva Veterinaria Registrada!</h1>
            <p>Alerta de Lead Calificado en Tiempo Real — AVI-Plan SaaS</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div style="text-align: center;">
                <span class="lead-badge">🔥 Prueba de 15 Días Activada</span>
            </div>

            <p style="font-size: 15px; color: #cbd5e1; line-height: 1.6; margin-top: 0;">
                Hola <strong>Robinson</strong>, una nueva clínica veterinaria acaba de completar su registro y activación en la plataforma. Aquí tienes los datos para acompañarlos:
            </p>

            <!-- Card de Datos -->
            <div class="lead-card">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr style="border-bottom: 1px solid #374151;">
                        <td style="padding: 10px 0; color: #94a3b8; font-size: 13px;">🏥 Clínica:</td>
                        <td style="padding: 10px 0; color: #f8fafc; font-size: 15px; font-weight: 800; text-align: right;">{{ $data['clinic_name'] }}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #374151;">
                        <td style="padding: 10px 0; color: #94a3b8; font-size: 13px;">👨‍⚕️ Titular / Dr(a):</td>
                        <td style="padding: 10px 0; color: #f8fafc; font-size: 14px; font-weight: 700; text-align: right;">{{ $user->name }}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #374151;">
                        <td style="padding: 10px 0; color: #94a3b8; font-size: 13px;">📍 Ciudad:</td>
                        <td style="padding: 10px 0; color: #f8fafc; font-size: 14px; font-weight: 600; text-align: right;">{{ $data['city'] }}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #374151;">
                        <td style="padding: 10px 0; color: #94a3b8; font-size: 13px;">📱 WhatsApp:</td>
                        <td style="padding: 10px 0; color: #34d399; font-size: 14px; font-weight: 700; text-align: right;">{{ $data['phone'] }}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #374151;">
                        <td style="padding: 10px 0; color: #94a3b8; font-size: 13px;">📧 Correo:</td>
                        <td style="padding: 10px 0; color: #38bdf8; font-size: 14px; font-weight: 600; text-align: right;">{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; color: #94a3b8; font-size: 13px;">⏰ Hora Registro:</td>
                        <td style="padding: 10px 0; color: #cbd5e1; font-size: 13px; text-align: right;">{{ now()->format('d/m/Y - h:i A') }}</td>
                    </tr>
                </table>
            </div>

            <!-- Botón WhatsApp Directo -->
            <a href="{{ $waLink }}" target="_blank" class="btn-whatsapp">
                💬 Escribir al WhatsApp con 1 Clic
            </a>

            <!-- Accesos Rápidos -->
            <table style="width: 100%; border-collapse: separate; border-spacing: 8px 0; margin-top: 10px;">
                <tr>
                    <td style="width: 50%;">
                        <a href="{{ $adminUrl }}" target="_blank" class="btn-secondary">
                            🔐 Panel Clínica
                        </a>
                    </td>
                    <td style="width: 50%;">
                        <a href="{{ $storefrontUrl }}" target="_blank" class="btn-secondary">
                            🌐 Portal Público
                        </a>
                    </td>
                </tr>
            </table>

            <!-- Tip de Venta B2B -->
            <div class="tip-box">
                <p>
                    <strong>💡 Recomendación Estratégica:</strong> Contactar a la clínica dentro de los primeros 15 minutos multiplica por 3 la tasa de activación. Ofréceles ayuda cargando su logo y personalizando su primer afiche QR para mostrador.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="margin: 0;">Notificación automática del Sistema Central AVI-Plan SaaS.</p>
            <p style="margin: 6px 0 0; color: #475569;">NODIA Enterprise Tech &bull; Remitente: contacto@avipetapp.com</p>
        </div>
    </div>
</body>
</html>
