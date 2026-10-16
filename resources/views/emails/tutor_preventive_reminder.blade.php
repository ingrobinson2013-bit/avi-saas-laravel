<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recordatorio de Salud Preventiva - {{ $tenant->name }}</title>
</head>
<body style="margin:0;padding:0;background-color:#f8fafc;font-family:'Segoe UI',Roboto,Helvetica,Arial,sans-serif;color:#1e293b;">
    @php
        $primaryColor = $tenant->branding['primary_color'] ?? '#0080ff';
        $contractId = $subscription->gateway_subscription_id ?? $subscription->id;
    @endphp

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8fafc;padding:28px 12px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;background-color:#ffffff;border-radius:20px;overflow:hidden;border:1px solid #e2e8f0;box-shadow:0 8px 24px rgba(15,23,42,0.06);">
                    
                    <!-- Header Marca Blanca -->
                    <tr>
                        <td style="background:linear-gradient(135deg, {{ $primaryColor }}, #0f172a);padding:28px 32px;text-align:center;color:#ffffff;">
                            <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;opacity:0.9;margin-bottom:6px;">
                                Medicina Preventiva Activa · {{ $tenant->name }}
                            </div>
                            <h1 style="margin:0;font-size:23px;font-weight:800;line-height:1.3;">
                                🩺 ¡Es momento del control preventivo de {{ $pet->name }}!
                            </h1>
                            <p style="margin:8px 0 0;font-size:13.5px;opacity:0.92;">
                                Tienes beneficios habilitados al 100% ($0 COP en consultorio) dentro de tu {{ $plan?->name ?? 'Plan de Salud' }}
                            </p>
                        </td>
                    </tr>

                    <!-- Cuerpo -->
                    <tr>
                        <td style="padding:28px 32px;">
                            <p style="margin:0 0 16px;font-size:15px;line-height:1.6;color:#334155;">
                                Hola <strong>{{ $customer->name }}</strong>,
                            </p>
                            <p style="margin:0 0 20px;font-size:14px;line-height:1.6;color:#475569;">
                                En <strong>{{ $tenant->name }}</strong> cuidamos la salud de <strong>{{ $pet->name }}</strong> antes de que aparezcan enfermedades. Te recordamos que tu membresía (Contrato <strong>{{ $contractId }}</strong>) tiene los siguientes servicios preventivos listos para agendar sin costo adicional:
                            </p>

                            <!-- Lista de Beneficios Preventivos Disponibles -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f0fdf4;border:1px solid #bbf7d0;border-radius:14px;padding:16px 18px;margin-bottom:22px;">
                                <tr>
                                    <td colspan="2" style="font-size:11.5px;font-weight:800;text-transform:uppercase;letter-spacing:0.8px;color:#166534;padding-bottom:10px;border-bottom:1px solid #dcfce7;">
                                        💉 Beneficios Listos para Aplicar ({{ $pet->name }})
                                    </td>
                                </tr>
                                @foreach($availableBenefits as $b)
                                    <tr>
                                        <td style="padding:10px 0 6px;font-size:13.5px;font-weight:700;color:#0f172a;">
                                            ✓ {{ $b['name'] }}
                                        </td>
                                        <td align="right" style="padding:10px 0 6px;font-size:12px;font-weight:800;color:#15803d;">
                                            {{ $b['remaining'] }} de {{ $b['granted'] }} disponible(s)
                                        </td>
                                    </tr>
                                @endforeach
                            </table>

                            <!-- Botón Principal: Agendar Cita por WhatsApp -->
                            <div style="text-align:center;margin:24px 0;">
                                <a href="{{ $scheduleWhatsappUrl }}" style="display:inline-block;background-color:#059669;color:#ffffff;text-decoration:none;font-size:14.5px;font-weight:800;padding:14px 28px;border-radius:12px;box-shadow:0 4px 12px rgba(5,150,105,0.25);">
                                    📅 Agendar Cita Preventiva por WhatsApp
                                </a>
                                <div style="font-size:11.5px;color:#64748b;margin-top:8px;">
                                    Solo presenta tu Carnet Digital QR en recepción al llegar a la clínica
                                </div>
                            </div>

                            <!-- Botón Secundario: Carnet Digital QR -->
                            <div style="text-align:center;margin-top:16px;">
                                <a href="{{ $carnetUrl }}" style="display:inline-block;background-color:#f1f5f9;color:#334155;border:1px solid #cbd5e1;text-decoration:none;font-size:12.5px;font-weight:700;padding:10px 22px;border-radius:10px;">
                                    🪪 Abrir Carnet Digital QR de {{ $pet->name }}
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#f8fafc;border-top:1px solid #e2e8f0;padding:18px 32px;text-align:center;font-size:11.5px;color:#64748b;">
                            <strong>{{ $tenant->name }}</strong> · {{ $tenant->branding['address'] ?? 'Sede Principal' }} · {{ $tenant->branding['city'] ?? 'Colombia' }}<br>
                            Tecnología de Salud Preventiva impulsada por <a href="https://avipetapp.com" style="color:#0284c7;text-decoration:none;font-weight:700;">AVI-Plan</a>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
