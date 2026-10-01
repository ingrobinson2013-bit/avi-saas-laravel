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
        
        $tier = $request->query('tier', $tenant->saas_plan_tier ?: 'pro');
        $pricing = [
            'pay_per_pet' => 50000,
            'starter' => 99000,
            'pro' => 229000,
            'enterprise' => 489000,
        ];

        if ($tier === 'pay_per_pet') {
            $petsCount = \App\Models\Pet::whereHas('customer', fn ($c) => $c->where('tenant_id', $tenant->id))->count();
            $unitFee = (float) ($tenant->branding['saas_per_pet_fee'] ?? 5000);
            $amount = $petsCount > 0 ? ($petsCount * $unitFee) : (float) ($tenant->branding['saas_monthly_fee'] ?? 50000);
        } else {
            $amount = (float) ($tenant->branding['saas_monthly_fee'] ?? $pricing[$tier] ?? 229000);
        }
        $orderId = "SAAS-{$tenant->slug}-" . time();
        $currency = 'COP';

        $isProduction = config('bold.environment') === 'production';
        $identityKey = $isProduction ? config('bold.identity_key') : config('bold.test_identity_key');
        $secretKey = $isProduction ? config('bold.secret_key') : config('bold.test_secret_key');

        $integritySignature = BoldPaymentService::generateSignature($orderId, $amount, $currency, $secretKey);
        $redirectUrl = url("/admin/{$tenant->slug}?saas_paid=1&order_id={$orderId}");
        $webhookUrl = url('/api/webhooks/bold');

        $payerEmail = $tenant->branding['email'] ?? auth()->user()?->email ?? 'doctor@veterinaria.com';
        $payerName = $tenant->name;
        $payerPhone = $tenant->branding['phone'] ?? '3508742543';

        return view('saas_checkout_bold', compact(
            'tenant',
            'tier',
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
