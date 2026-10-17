<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recordatorio de Renovación - {{ $tenant->name }}</title>
</head>
<body style="margin:0;padding:0;background-color:#f8fafc;font-family:'Segoe UI',Roboto,Helvetica,Arial,sans-serif;color:#1e293b;">
    @php
        $primaryColor = $tenant->branding['primary_color'] ?? '#0080ff';
        $clinicPhone = preg_replace('/[^0-9]/', '', $tenant->branding['phone'] ?? '3235813942');
        if (strlen($clinicPhone) === 10) {
            $clinicPhone = '57' . $clinicPhone;
        }
        $contractId = $subscription->gateway_subscription_id ?? $subscription->id;
        $priceCop = (float) ($plan?->price_cop ?? 50000);
        $formattedPrice = '$' . number_format($priceCop, 0, ',', '.') . ' COP';
        $formattedWallet = '$' . number_format($walletBalance, 0, ',', '.') . ' COP';
        $nequi = $tenant->branding['payment_nequi'] ?? $tenant->branding['phone'] ?? '';
        $bankInfo = $tenant->branding['payment_bank_info'] ?? '';
        $endDateFormatted = $subscription->current_period_end ? \Carbon\Carbon::parse($subscription->current_period_end)->format('d/m/Y') : now()->format('d/m/Y');
        $waProofUrl = "https://wa.me/{$clinicPhone}?text=" . urlencode("¡Hola {$tenant->name}! 👋 Adjunto el comprobante de renovación del Plan de Salud de {$pet->name} (Contrato {$contractId}).");
    @endphp

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8fafc;padding:28px 12px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;background-color:#ffffff;border-radius:20px;overflow:hidden;border:1px solid #e2e8f0;box-shadow:0 8px 24px rgba(15,23,42,0.06);">
                    
                    <!-- Header con Marca Blanca de la Clínica -->
                    <tr>
                        <td style="background:linear-gradient(135deg, {{ $primaryColor }}, #0f172a);padding:28px 32px;text-align:center;color:#ffffff;">
                            <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;opacity:0.9;margin-bottom:6px;">
                                Continuidad de Protección Médica · {{ $tenant->name }}
                            </div>
                            <h1 style="margin:0;font-size:23px;font-weight:800;line-height:1.3;">
                                @if($daysLeft < 0)
                                    ⚠️ Tu membresía de {{ $pet->name }} está pendiente de renovación
                                @elseif($daysLeft === 0)
                                    ⏰ Hoy se renueva la protección médica de {{ $pet->name }}
                                @else
                                    🐾 La membresía de {{ $pet->name }} renueva en {{ $daysLeft }} día(s)
                                @endif
                            </h1>
                            <p style="margin:8px 0 0;font-size:13.5px;opacity:0.92;">
                                Mantén activos sus beneficios veterinarios y su Fondo de Reserva de Emergencia
                            </p>
                        </td>
                    </tr>

                    <!-- Cuerpo Principal -->
                    <tr>
                        <td style="padding:28px 32px;">
                            <p style="margin:0 0 16px;font-size:15px;line-height:1.6;color:#334155;">
                                Hola <strong>{{ $customer->name }}</strong>,
                            </p>
                            <p style="margin:0 0 20px;font-size:14px;line-height:1.6;color:#475569;">
                                Te escribimos de <strong>{{ $tenant->name }}</strong> para recordarte que el ciclo actual del plan preventivo de <strong>{{ $pet->name }}</strong> tiene fecha de corte el <strong>{{ $endDateFormatted }}</strong>. Al mantener tu membresía al día, conservas la antigüedad de tus periodos de carencia y sumas un <strong>+10% adicional</strong> a tu Fondo de Reserva para urgencias.
                            </p>

                            <!-- Resumen del Contrato y Fondo de Reserva -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8fafc;border:1px solid #e2e8f0;border-radius:14px;padding:18px;margin-bottom:22px;">
                                <tr>
                                    <td style="font-size:12px;color:#64748b;padding-bottom:4px;">Contrato Oficial</td>
                                    <td align="right" style="font-size:13px;font-weight:800;color:#0f172a;font-family:monospace;">{{ $contractId }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:12px;color:#64748b;padding:4px 0;">Paciente</td>
                                    <td align="right" style="font-size:13px;font-weight:700;color:#0f172a;">{{ $pet->name }} ({{ $pet->breed }})</td>
                                </tr>
                                <tr>
                                    <td style="font-size:12px;color:#64748b;padding:4px 0;">Plan de Salud</td>
                                    <td align="right" style="font-size:13px;font-weight:700;color:#1e40af;">{{ $plan?->name ?? 'Plan Preventivo' }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:12px;color:#64748b;padding:4px 0;">Valor Cuota de Renovación</td>
                                    <td align="right" style="font-size:15px;font-weight:800;color:#059669;">{{ $formattedPrice }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:12px;color:#92400e;padding-top:8px;border-top:1px dashed #cbd5e1;">🛡️ Fondo de Reserva Acumulado (10%)</td>
                                    <td align="right" style="font-size:13px;font-weight:800;color:#b45309;padding-top:8px;border-top:1px dashed #cbd5e1;">{{ $formattedWallet }}</td>
                                </tr>
                            </table>

                            <!-- Botón Principal de Pago en Línea 1-Click -->
                            <div style="text-align:center;margin:24px 0;">
                                <a href="{{ $paymentUrl }}" style="display:inline-block;background-color:#059669;color:#ffffff;text-decoration:none;font-size:14.5px;font-weight:800;padding:14px 28px;border-radius:12px;box-shadow:0 4px 12px rgba(5,150,105,0.25);">
                                    💳 Pagar Cuota en Línea ({{ $formattedPrice }})
                                </a>
                                <div style="font-size:11.5px;color:#64748b;margin-top:8px;">
                                    Aceptamos PSE, Tarjetas Débito/Crédito, Nequi y Botón Bancolombia (Conciliación Automática)
                                </div>
                            </div>

                            <!-- Medios Directos de la Clínica (Nequi / Transferencia) -->
                            @if(!empty($nequi) || !empty($bankInfo))
                                <div style="background-color:#eff6ff;border:1px solid #bfdbfe;border-radius:12px;padding:14px 18px;margin-bottom:20px;">
                                    <div style="font-size:12px;font-weight:800;color:#1e3a8a;margin-bottom:6px;">
                                        🏦 ¿Prefieres transferir directamente a la clínica?
                                    </div>
                                    @if(!empty($nequi))
                                        <div style="font-size:12.5px;color:#1e40af;margin-bottom:3px;">
                                            • <strong>Nequi / Daviplata:</strong> {{ $nequi }}
                                        </div>
                                    @endif
                                    @if(!empty($bankInfo))
                                        <div style="font-size:12.5px;color:#1e40af;">
                                            • <strong>Cuenta Bancaria:</strong> {{ $bankInfo }}
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- Botones Secundarios: Enviar Comprobante por WhatsApp y Ver Carnet QR -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:16px;">
                                <tr>
                                    <td align="center" style="padding-bottom:10px;">
                                        <a href="{{ $waProofUrl }}" style="display:inline-block;background-color:#ecfdf5;color:#047857;border:1px solid #a7f3d0;text-decoration:none;font-size:12.5px;font-weight:700;padding:10px 20px;border-radius:10px;margin-right:6px;">
                                            💬 Enviar Comprobante por WhatsApp
                                        </a>
                                        <a href="{{ $carnetUrl }}" style="display:inline-block;background-color:#f1f5f9;color:#334155;border:1px solid #cbd5e1;text-decoration:none;font-size:12.5px;font-weight:700;padding:10px 20px;border-radius:10px;">
                                            🪪 Ver Carnet Digital QR
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#f8fafc;border-top:1px solid #e2e8f0;padding:18px 32px;text-align:center;font-size:11.5px;color:#64748b;">
                            <strong>{{ $tenant->name }}</strong> · {{ $tenant->branding['address'] ?? 'Sede Principal' }} · {{ $tenant->branding['city'] ?? 'Colombia' }}<br>
                            Tecnología de Salud Preventiva impulsada por <a href="https://avipetapp.com" style="color:#0284c7;text-decoration:none;font-weight:700;">AviPetApp</a>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
