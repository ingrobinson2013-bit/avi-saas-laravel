<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carnet Digital de {{ $pet->name }}</title>
</head>
@php
    $primaryColor = $tenant->branding['primary_color'] ?? '#0d9488';
    $clinicPhone = preg_replace('/[^0-9]/', '', $tenant->branding['phone'] ?? '3235813942');
    $waPrefix = str_starts_with($clinicPhone, '57') ? $clinicPhone : "57{$clinicPhone}";
    $clinicAddress = $tenant->branding['address'] ?? 'Sede Principal';
    $clinicCity = $tenant->branding['city'] ?? 'Colombia';
    $contractId = $subscription->gateway_subscription_id ?? $subscription->id;
    $planPrice = '$' . number_format($plan->price_cop ?? 50000, 0, ',', '.') . ' COP/mes';
    $benefits = $subscription->benefitBalances()->with('benefitDefinition')->get();
@endphp
<body style="margin:0;padding:0;background-color:#f1f5f9;font-family:'Segoe UI',Roboto,Helvetica,Arial,sans-serif;color:#1e293b;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f1f5f9;padding:30px 15px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;background-color:#ffffff;border-radius:20px;overflow:hidden;box-shadow:0 10px 25px rgba(15,23,42,0.08);border:1px solid #e2e8f0;">
                    <!-- Header -->
                    <tr>
                        <td style="background:linear-gradient(135deg, {{ $primaryColor }}, #0f172a);padding:32px 28px;text-align:center;color:#ffffff;">
                            <div style="display:inline-block;background-color:rgba(255,255,255,0.15);padding:6px 14px;border-radius:999px;font-size:12px;font-weight:700;letter-spacing:0.5px;text-transform:uppercase;margin-bottom:12px;">
                                🐾 Membresía de Salud Activa
                            </div>
                            <h1 style="margin:0;font-size:24px;font-weight:800;line-height:1.25;">
                                ¡Bienvenido(a) a {{ $tenant->name }}!
                            </h1>
                            <p style="margin:8px 0 0;font-size:14px;color:rgba(255,255,255,0.9);">
                                El Carnet Digital de <strong>{{ $pet->name }}</strong> ya está disponible en tu celular.
                            </p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:28px;">
                            <p style="margin:0 0 18px;font-size:15px;line-height:1.6;color:#334155;">
                                Hola <strong>{{ $customer->name }}</strong>,
                            </p>
                            <p style="margin:0 0 22px;font-size:14px;line-height:1.6;color:#475569;">
                                Hemos registrado con éxito la afiliación de <strong>{{ $pet->name }}</strong> ({{ $pet->species }} · {{ $pet->breed }}) al plan <strong>{{ $plan->name }}</strong> en <strong>{{ $tenant->name }}</strong>.
                            </p>

                            <!-- Tarjeta Resumen del Carnet -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f8fafc;border:1px solid #cbd5e1;border-radius:16px;padding:20px;margin-bottom:24px;">
                                <tr>
                                    <td style="padding-bottom:10px;border-bottom:1px dashed #cbd5e1;">
                                        <span style="font-size:11px;font-weight:700;text-transform:uppercase;color:#64748b;letter-spacing:0.5px;">N° Contrato Oficial</span>
                                        <div style="font-size:18px;font-weight:900;color:#0f172a;font-family:monospace;margin-top:2px;">{{ $contractId }}</div>
                                    </td>
                                    <td align="right" style="padding-bottom:10px;border-bottom:1px dashed #cbd5e1;">
                                        <span style="background-color:#dcfce7;color:#166534;font-size:11px;font-weight:800;padding:4px 10px;border-radius:999px;border:1px solid #86efac;">
                                            ● ACTIVO
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top:12px;font-size:13px;color:#334155;line-height:1.8;">
                                        <div>🐾 <strong>Paciente:</strong> {{ $pet->name }} ({{ $pet->breed }})</div>
                                        <div>📋 <strong>Plan Contratado:</strong> {{ $plan->name }} ({{ $planPrice }})</div>
                                        <div>💳 <strong>Medio de Pago:</strong> {{ $paymentText }}</div>
                                        <div>📅 <strong>Vigencia del Ciclo:</strong> {{ $subscription->current_period_start?->format('d/m/Y') ?? now()->format('d/m/Y') }} al {{ $subscription->current_period_end?->format('d/m/Y') ?? now()->addMonth()->format('d/m/Y') }}</div>
                                    </td>
                                </tr>
                            </table>

                            <!-- CTA Principal: Ver Carnet Digital -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $carnetUrl }}" target="_blank" style="display:inline-block;background-color:{{ $primaryColor }};color:#ffffff;font-size:15px;font-weight:800;text-decoration:none;padding:15px 28px;border-radius:12px;box-shadow:0 4px 14px rgba(13,148,136,0.3);">
                                            🪪 Abrir Carnet Digital con Código QR
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding-top:10px;">
                                        <a href="{{ $carnetUrl }}/pdf" target="_blank" style="font-size:13px;font-weight:700;color:#0284c7;text-decoration:underline;">
                                            📄 Descargar Certificado y Carnet en PDF
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Beneficios Incluidos -->
                            @if($benefits->count() > 0)
                            <h3 style="margin:0 0 12px;font-size:14px;font-weight:800;color:#0f172a;text-transform:uppercase;letter-spacing:0.4px;">
                                ✨ Cupos y Beneficios Cargados en tu Carnet:
                            </h3>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;margin-bottom:24px;">
                                @foreach($benefits as $bal)
                                <tr style="border-bottom:1px solid #f1f5f9;">
                                    <td style="padding:10px 14px;font-size:13px;color:#1e293b;font-weight:600;">
                                        ✓ {{ $bal->benefitDefinition?->name ?? 'Beneficio Clínico' }}
                                    </td>
                                    <td align="right" style="padding:10px 14px;font-size:12px;font-weight:800;color:#0f766e;white-space:nowrap;">
                                        {{ $bal->total_granted >= 500 ? 'Ilimitado' : $bal->remaining_count . ' cupo(s)' }}
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            @endif

                            <!-- Cómo usar en recepción -->
                            <div style="background-color:#eff6ff;border-left:4px solid #2563eb;padding:14px 16px;border-radius:8px;font-size:13px;color:#1e3a8a;line-height:1.5;margin-bottom:20px;">
                                <strong>💡 ¿Cómo usar tus beneficios en la clínica?</strong><br>
                                Cuando visites <strong>{{ $tenant->name }}</strong>, solo muestra el código QR de tu Carnet Digital en recepción o indica tu número de celular (<strong>{{ $customer->phone }}</strong>) para descontar tu consulta o vacuna en segundos.
                            </div>

                            <!-- Botón WhatsApp Clínica -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center">
                                        <a href="https://wa.me/{{ $waPrefix }}?text={{ urlencode('Hola ' . $tenant->name . ', tengo activo el Carnet Digital ' . $contractId . ' de mi mascota ' . $pet->name . '.') }}" target="_blank" style="display:inline-block;background-color:#16a34a;color:#ffffff;font-size:13px;font-weight:700;text-decoration:none;padding:11px 22px;border-radius:10px;">
                                            💬 Contactar a {{ $tenant->name }} por WhatsApp
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#f8fafc;padding:20px 28px;text-align:center;border-top:1px solid #e2e8f0;font-size:12px;color:#64748b;line-height:1.6;">
                            <strong>{{ $tenant->name }}</strong> · {{ $clinicAddress }}, {{ $clinicCity }}<br>
                            Tecnología de Membresías Veterinarias impulsada por <a href="https://avipetapp.com" style="color:#0d9488;text-decoration:none;font-weight:700;">AviPetApp (avipetapp.com)</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
