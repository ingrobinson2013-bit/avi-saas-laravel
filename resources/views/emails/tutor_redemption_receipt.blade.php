<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Canje Clínico</title>
</head>
@php
    $primaryColor = $tenant->branding['primary_color'] ?? '#0284c7';
    $clinicPhone = preg_replace('/[^0-9]/', '', $tenant->branding['phone'] ?? '3235813942');
    $waPrefix = str_starts_with($clinicPhone, '57') ? $clinicPhone : "57{$clinicPhone}";
    $clinicAddress = $tenant->branding['address'] ?? 'Sede Principal';
    $clinicCity = $tenant->branding['city'] ?? 'Colombia';
    $dateFormatted = $redemption->redeemed_at ? $redemption->redeemed_at->timezone('America/Bogota')->format('d/m/Y h:i A') : now()->timezone('America/Bogota')->format('d/m/Y h:i A');
@endphp
<body style="margin:0;padding:0;background-color:#f1f5f9;font-family:'Segoe UI',Roboto,Helvetica,Arial,sans-serif;color:#1e293b;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f1f5f9;padding:30px 15px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:580px;background-color:#ffffff;border-radius:20px;overflow:hidden;box-shadow:0 10px 25px rgba(15,23,42,0.08);border:1px solid #e2e8f0;">
                    <!-- Header -->
                    <tr>
                        <td style="background:linear-gradient(135deg, #0f172a, {{ $primaryColor }});padding:28px;text-align:center;color:#ffffff;">
                            <div style="display:inline-block;background-color:rgba(16,185,129,0.25);border:1px solid rgba(52,211,153,0.4);color:#a7f3d0;padding:5px 14px;border-radius:999px;font-size:11px;font-weight:800;letter-spacing:0.5px;text-transform:uppercase;margin-bottom:10px;">
                                ✓ Beneficio Redimido en Recepción
                            </div>
                            <h1 style="margin:0;font-size:22px;font-weight:800;line-height:1.3;">
                                Comprobante de Atención Clínica
                            </h1>
                            <p style="margin:6px 0 0;font-size:13px;color:rgba(255,255,255,0.85);">
                                {{ $tenant->name }} · {{ $dateFormatted }}
                            </p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:28px;">
                            <p style="margin:0 0 16px;font-size:15px;color:#334155;">
                                Hola <strong>{{ $customerName }}</strong>,
                            </p>
                            <p style="margin:0 0 20px;font-size:14px;line-height:1.6;color:#475569;">
                                Te confirmamos que hoy se registró el uso de un beneficio del Plan de Salud de <strong>{{ $petName }}</strong> en nuestra clínica:
                            </p>

                            <!-- Detalle del Canje -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f8fafc;border:1px solid #cbd5e1;border-radius:16px;padding:18px;margin-bottom:22px;">
                                <tr>
                                    <td style="padding-bottom:10px;border-bottom:1px dashed #cbd5e1;">
                                        <span style="font-size:11px;font-weight:700;text-transform:uppercase;color:#64748b;">Servicio / Procedimiento Aplicado</span>
                                        <div style="font-size:16px;font-weight:800;color:#0f172a;margin-top:3px;">
                                            {{ $quantity }}x {{ $benefitName }}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top:12px;font-size:13px;color:#334155;line-height:1.8;">
                                        <div>🐾 <strong>Paciente:</strong> {{ $petName }}</div>
                                        <div>👩‍⚕️ <strong>Atendido por:</strong> {{ $attendedBy }}</div>
                                        <div>🕒 <strong>Fecha y Hora:</strong> {{ $dateFormatted }}</div>
                                        @if(!empty($notes))
                                        <div>📋 <strong>Observaciones Clínicas:</strong> {{ $notes }}</div>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <!-- Saldo Restante -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#ecfdf5;border:1px solid #a7f3d0;border-radius:14px;padding:16px;margin-bottom:24px;">
                                <tr>
                                    <td>
                                        <div style="font-size:12px;font-weight:700;color:#065f46;text-transform:uppercase;">
                                            Saldo Actualizado de este Servicio
                                        </div>
                                        <div style="font-size:14px;color:#047857;margin-top:4px;">
                                            @if($totalGranted >= 500)
                                                Tienes <strong>Cobertura Ilimitada</strong> activa en tu ciclo actual.
                                            @else
                                                Te quedan <strong>{{ $remainingCount }} de {{ $totalGranted }} cupo(s)</strong> disponibles en tu ciclo actual.
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- CTA Ver Carnet -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:18px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $carnetUrl }}" target="_blank" style="display:inline-block;background-color:{{ $primaryColor }};color:#ffffff;font-size:14px;font-weight:800;text-decoration:none;padding:13px 26px;border-radius:12px;">
                                            🪪 Ver Carnet Digital y Saldos Actualizados
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0;text-align:center;font-size:12px;color:#64748b;">
                                ¿Tienes alguna duda sobre la atención de {{ $petName }}?
                                <a href="https://wa.me/{{ $waPrefix }}" style="color:#16a34a;font-weight:700;text-decoration:underline;">Escríbenos por WhatsApp</a>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#f8fafc;padding:18px 28px;text-align:center;border-top:1px solid #e2e8f0;font-size:12px;color:#64748b;line-height:1.5;">
                            <strong>{{ $tenant->name }}</strong> · {{ $clinicAddress }}, {{ $clinicCity }}<br>
                            Respaldado por <a href="https://avipetapp.com" style="color:#0284c7;text-decoration:none;font-weight:700;">AVI-Plan (avipetapp.com)</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
