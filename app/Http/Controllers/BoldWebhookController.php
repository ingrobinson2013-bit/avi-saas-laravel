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

        // 2. Caso B: Pago de Canon SaaS de Clínica Veterinaria B2B (ej. SAAS-vet-pet-patitas-1234)
        if (str_starts_with($orderId, 'SAAS-')) {
            $parts = explode('-', $orderId);
            $tenantSlug = $parts[1] ?? null;
            $tenant = $tenantSlug ? Tenant::where('slug', $tenantSlug)->first() : null;

            if ($tenant && $isApproved) {
                $branding = $tenant->branding ?? [];
                $branding['saas_status'] = 'paid';
                $branding['saas_last_payment_date'] = now()->toDateString();
                $branding['saas_next_payment_due'] = now()->addMonth()->toDateString();
                $tenant->update(['branding' => $branding, 'is_active' => true]);

                Log::info("Bold Webhook: Tenant SaaS {$tenant->slug} renewed and marked as PAID.");
                return response()->json(['success' => true, 'type' => 'tenant_saas', 'status' => $status]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Webhook received and recorded']);
    }
}
