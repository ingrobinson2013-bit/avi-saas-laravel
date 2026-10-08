<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Services\BoldPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SaaSPaymentController extends Controller
{
    /**
     * Muestra la vista de pago / renovación de suscripción SaaS con Bold.
     */
    public function showCheckout(string $slug, Request $request)
    {
        $tenant = Tenant::where('slug', $slug)->firstOrFail();
        
        $pricing = [
            'starter' => 99000,
            'pro' => 229000,
            'enterprise' => 489000,
            'pay_per_pet' => 50000,
        ];

        $petsCount = \App\Models\Pet::whereHas('customer', fn ($c) => $c->where('tenant_id', $tenant->id))->count();
        $unitFee = (float) ($tenant->branding['saas_per_pet_fee'] ?? 5000);
        $payPerPetCalculated = $petsCount > 0 ? max(50000, $petsCount * $unitFee) : 50000;

        $plans = [
            'starter' => [
                'name' => 'Plan Starter',
                'badge' => 'Básico',
                'price' => 99000,
                'price_label' => '$99.000 COP / mes',
                'limit' => 'Hasta 60 pacientes afiliados',
                'desc' => 'Ideal para consultorios veterinarios en etapa inicial.',
            ],
            'pro' => [
                'name' => 'Plan Profesional',
                'badge' => 'Recomendado',
                'price' => 229000,
                'price_label' => '$229.000 COP / mes',
                'limit' => 'Hasta 250 pacientes afiliados',
                'desc' => 'Para clínicas con alto flujo que buscan maximizar recurrencia.',
            ],
            'enterprise' => [
                'name' => 'Plan Enterprise',
                'badge' => 'Ilimitado',
                'price' => 489000,
                'price_label' => '$489.000 COP / mes',
                'limit' => 'Pacientes Ilimitados · Multi-sedes',
                'desc' => 'Para hospitales veterinarios y clínicas con múltiples sedes y doctores.',
            ],
            'pay_per_pet' => [
                'name' => 'Por Mascota Activa',
                'badge' => 'Flexible',
                'price' => $payPerPetCalculated,
                'price_label' => '$5.000 COP / mascota',
                'limit' => 'Paga según el número de suscripciones (' . $petsCount . ' activas)',
                'desc' => 'Pagas $5.000 COP por mascota suscrita al mes (Base mínima $50.000 COP).',
            ],
        ];

        // Validar el tier solicitado o tomar el asignado al tenant
        $requestedTier = $request->query('tier');
        if ($requestedTier && isset($pricing[$requestedTier])) {
            $tier = $requestedTier;
        } else {
            $tier = $tenant->saas_plan_tier ?: 'pro';
            if (!isset($pricing[$tier])) {
                $tier = 'pro';
            }
        }

        if ($tier === 'pay_per_pet') {
            $amount = $payPerPetCalculated;
        } else {
            if ($request->has('tier')) {
                $amount = (float) $pricing[$tier];
            } else {
                $amount = (float) ($tenant->branding['saas_monthly_fee'] ?? $pricing[$tier] ?? 229000);
            }
        }

        $orderId = "SAAS-{$tenant->slug}-{$tier}-" . time();
        $currency = 'COP';

        $isProduction = config('bold.environment') === 'production';
        $identityKey = $isProduction ? config('bold.identity_key') : config('bold.test_identity_key');
        $secretKey = $isProduction ? config('bold.secret_key') : config('bold.test_secret_key');

        $integritySignature = BoldPaymentService::generateSignature($orderId, $amount, $currency, $secretKey);
        $redirectUrl = url("/admin/{$tenant->slug}?saas_paid=1&order_id={$orderId}&tier={$tier}");
        $webhookUrl = url('/api/webhooks/bold');

        $payerEmail = $tenant->branding['email'] ?? auth()->user()?->email ?? 'doctor@veterinaria.com';
        $payerName = $tenant->name;
        $payerPhone = $tenant->branding['phone'] ?? '3508742543';

        return view('saas_checkout_bold', compact(
            'tenant',
            'tier',
            'plans',
            'amount',
            'orderId',
            'currency',
            'identityKey',
            'integritySignature',
            'redirectUrl',
            'webhookUrl',
            'payerEmail',
            'payerName',
            'payerPhone',
            'isProduction'
        ));
    }
}
