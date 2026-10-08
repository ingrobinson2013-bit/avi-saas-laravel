<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Tenant;
use App\Services\BoldPaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BoldWebhookController extends Controller
{
    public function handle(Request $request, BoldPaymentService $boldService): JsonResponse
    {
        $payload = $request->all();
        Log::info('Bold Webhook Received:', $payload);

        $orderId = $payload['order_id'] ?? $payload['reference'] ?? $payload['data']['order_id'] ?? null;
        $status = strtoupper($payload['status'] ?? $payload['data']['status'] ?? 'UNKNOWN');
        $amount = (float) ($payload['amount'] ?? $payload['data']['amount'] ?? 0);

        if (!$orderId) {
            return response()->json(['error' => 'Missing order_id in webhook'], 400);
        }

        $isApproved = in_array($status, ['APPROVED', 'PAID', 'SUCCESS', 'COMPLETED']);

        // 1. Caso A: Pago de Membresía de Mascota B2C (ej. Contrato VPP-2026-0001)
        $subscription = Subscription::where('gateway_subscription_id', $orderId)->first();
        if ($subscription) {
            if ($isApproved) {
                $subscription->update([
                    'status' => 'active',
                    'current_period_start' => now(),
                    'current_period_end' => now()->addMonth(),
                ]);
                Log::info("Bold Webhook: Subscription {$orderId} marked as ACTIVE.");
            } elseif (in_array($status, ['REJECTED', 'FAILED', 'DECLINED'])) {
                Log::warning("Bold Webhook: Subscription payment {$orderId} was rejected.");
            }
            return response()->json(['success' => true, 'type' => 'subscription', 'status' => $status]);
        }

        // 2. Caso B: Pago de Canon SaaS de Clínica Veterinaria B2B (ej. SAAS-vet-pet-patitas-pro-1234 o SAAS-slug-1234)
        if (str_starts_with($orderId, 'SAAS-')) {
            $parts = explode('-', $orderId);
            $tenantSlug = $parts[1] ?? null;
            $newTier = null;
            if (isset($parts[2]) && in_array($parts[2], ['starter', 'pro', 'enterprise', 'pay_per_pet'])) {
                $newTier = $parts[2];
            }
            $tenant = $tenantSlug ? Tenant::where('slug', $tenantSlug)->first() : null;

            if ($tenant && $isApproved) {
                $branding = $tenant->branding ?? [];
                $branding['saas_status'] = 'paid';
                $branding['saas_last_payment_date'] = now()->toDateString();
                $branding['saas_next_payment_due'] = now()->addDays(30)->toDateString();
                $branding['saas_paid_until'] = now()->addDays(30)->toDateString();
                $branding['saas_payment_method'] = 'bold_wompi';
                if ($newTier) {
                    $branding['saas_plan'] = $newTier;
                    $branding['saas_monthly_fee'] = $amount > 0 ? $amount : ($branding['saas_monthly_fee'] ?? 229000);
                    $tenant->saas_plan_tier = $newTier;
                }
                $tenant->update(['branding' => $branding, 'is_active' => true]);

                // Registrar en el Log Oficial de Pagos SaaS
                \App\Models\SaasPaymentLog::create([
                    'tenant_id' => $tenant->id,
                    'order_id' => $orderId,
                    'gateway' => 'bold',
                    'amount' => $amount > 0 ? $amount : (float) ($branding['saas_monthly_fee'] ?? 229000),
                    'currency' => 'COP',
                    'plan_tier' => $tenant->saas_plan_tier ?? 'pro',
                    'status' => 'approved',
                    'transaction_id' => $payload['id'] ?? $payload['transaction_id'] ?? null,
                    'payer_name' => $tenant->name,
                    'payer_email' => $tenant->branding['email'] ?? null,
                    'payer_phone' => $tenant->branding['phone'] ?? null,
                    'period_start' => now()->toDateString(),
                    'period_end' => now()->addDays(30)->toDateString(),
                    'notes' => 'Pago automático procesado exitosamente vía pasarela Bold.',
                    'raw_payload' => $payload,
                    'paid_at' => now(),
                ]);

                Log::info("Bold Webhook: Tenant SaaS {$tenant->slug} renewed, logged in SaasPaymentLog, and marked as PAID.");
                return response()->json(['success' => true, 'type' => 'tenant_saas', 'status' => $status]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Webhook received and recorded']);
    }
}
