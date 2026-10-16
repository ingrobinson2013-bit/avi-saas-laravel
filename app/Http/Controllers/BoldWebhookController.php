<?php

namespace App\Http\Controllers;

use App\Mail\TutorWelcomeCarnetMail;
use App\Models\SaasPaymentLog;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Services\BenefitLedgerService;
use App\Services\BoldPaymentService;
use App\Services\HealthWalletService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BoldWebhookController extends Controller
{
    /**
     * Endpoint unificado de conciliación automática para Webhooks de Wompi y Bold
     * Soporta tanto pagos B2C de membresías de mascotas como pagos B2B del canon SaaS.
     */
    public function handle(
        Request $request,
        BoldPaymentService $boldService,
        HealthWalletService $walletService,
        BenefitLedgerService $ledgerService
    ): JsonResponse {
        $payload = $request->all();
        Log::info('Payment Webhook Received:', $payload);

        // Detectar si es estructura de Wompi (event = transaction.updated, data.transaction) o Bold
        $wompiTx = $payload['data']['transaction'] ?? null;
        $isWompi = !empty($wompiTx) || str_contains(strtolower($payload['event'] ?? ''), 'transaction');
        $gateway = $isWompi ? 'wompi' : 'bold';

        $orderId = $wompiTx['reference']
            ?? $payload['order_id']
            ?? $payload['reference']
            ?? $payload['data']['order_id']
            ?? $payload['data']['metadata']['reference']
            ?? null;

        $rawStatus = $wompiTx['status']
            ?? $payload['status']
            ?? $payload['type']
            ?? $payload['data']['status']
            ?? 'UNKNOWN';
        $status = strtoupper((string) $rawStatus);

        $amount = 0.0;
        if (!empty($wompiTx['amount_in_cents'])) {
            $amount = ((float) $wompiTx['amount_in_cents']) / 100.0;
        } else {
            $amount = (float) ($payload['amount'] ?? $payload['data']['amount']['total'] ?? $payload['data']['amount'] ?? 0);
        }

        $transactionId = (string) ($wompiTx['id'] ?? $payload['id'] ?? $payload['transaction_id'] ?? $payload['data']['payment_id'] ?? $orderId);

        if (!$orderId) {
            return response()->json(['error' => 'Missing order_id / reference in webhook'], 400);
        }

        $isApproved = in_array($status, ['APPROVED', 'PAID', 'SUCCESS', 'COMPLETED', 'SALE_APPROVED']);

        // Extraer código base del contrato en caso de que venga con sufijo de timestamp (ej. VPP-2026-0001-17290000)
        $cleanContractId = $orderId;
        if (preg_match('/^([A-Z0-9]+-\d{4}-\d{4})-\d+$/i', $orderId, $matches)) {
            $cleanContractId = $matches[1];
        }

        // 1. Caso A: Pago de Membresía de Mascota B2C (ej. Contrato VPP-2026-0001 o UUID)
        $subscription = Subscription::with(['pet.customer', 'plan', 'tenant'])
            ->where('gateway_subscription_id', $orderId)
            ->orWhere('gateway_subscription_id', $cleanContractId)
            ->orWhere('id', $orderId)
            ->first();

        if ($subscription) {
            $tenant = $subscription->tenant;

            // Validar checksum de Wompi si la clínica configuró wompi_events_secret
            if ($isWompi && $tenant && !empty($tenant->branding['wompi_events_secret'])) {
                $valid = $boldService->verifyWompiWebhook(
                    $payload,
                    $tenant->branding['wompi_events_secret'],
                    $request->header('X-Event-Checksum')
                );
                if (!$valid) {
                    Log::warning("Wompi Webhook Checksum mismatch for subscription {$orderId}");
                    return response()->json(['error' => 'Invalid Wompi signature'], 401);
                }
            }

            if ($isApproved) {
                $planPrice = (float) ($subscription->plan?->price_cop ?? 50000);
                $paidAmount = $amount > 0 ? $amount : $planPrice;
                $isAnnual = $paidAmount >= ($planPrice * 10);

                $startDate = now();
                $endDate = $isAnnual ? now()->addYear() : now()->addMonth();

                $subscription->update([
                    'status' => 'active',
                    'current_period_start' => $startDate,
                    'current_period_end' => $endDate,
                ]);

                // Asegurar o reiniciar saldos de beneficios en el Ledger
                if ($subscription->benefitBalances()->count() === 0 && $subscription->plan) {
                    try {
                        $ledgerService->resetCycleBalances($subscription);
                    } catch (\Throwable $e) {
                        Log::warning("Error initializing benefit balances on webhook: " . $e->getMessage());
                    }
                }

                // Acumular 10% en el Fondo de Reserva Preventivo (Health Wallet)
                try {
                    $reserveContribution = round($paidAmount * 0.10, 2);
                    $walletService->accrueMonthlyFund(
                        $subscription,
                        $reserveContribution,
                        "Aporte automático 10% ({$gateway}) · Ref {$transactionId}"
                    );
                } catch (\Throwable $e) {
                    Log::warning("Error accruing Health Wallet on webhook: " . $e->getMessage());
                }

                // Registrar auditoría en SaasPaymentLog
                try {
                    SaasPaymentLog::create([
                        'tenant_id' => $subscription->tenant_id,
                        'order_id' => $orderId,
                        'gateway' => $gateway,
                        'amount' => $paidAmount,
                        'currency' => 'COP',
                        'plan_tier' => 'b2c_' . ($subscription->plan?->name ?? 'plan'),
                        'status' => 'approved',
                        'transaction_id' => $transactionId,
                        'payer_name' => $subscription->pet?->customer?->name ?? 'Tutor B2C',
                        'payer_email' => $subscription->pet?->customer?->email ?? null,
                        'payer_phone' => $subscription->pet?->customer?->phone ?? null,
                        'period_start' => $startDate->toDateString(),
                        'period_end' => $endDate->toDateString(),
                        'notes' => "Pago B2C aprobado automáticamente vía {$gateway} para mascota {$subscription->pet?->name} ({$subscription->gateway_subscription_id}).",
                        'raw_payload' => $payload,
                        'paid_at' => now(),
                    ]);
                } catch (\Throwable $e) {
                    Log::warning("Error logging B2C payment in SaasPaymentLog: " . $e->getMessage());
                }

                // Enviar correo de confirmación con Carnet Digital QR al tutor
                try {
                    $tutorEmail = trim($subscription->pet?->customer?->email ?? '');
                    if ($tenant && !empty($tutorEmail) && filter_var($tutorEmail, FILTER_VALIDATE_EMAIL)) {
                        $carnetUrl = $tenant->getCarnetUrl($subscription->gateway_subscription_id ?? $subscription->id);
                        $mailPending = Mail::to($tutorEmail);
                        $clinicEmail = trim($tenant->branding['email'] ?? '');
                        if (!empty($clinicEmail) && filter_var($clinicEmail, FILTER_VALIDATE_EMAIL) && strtolower($clinicEmail) !== strtolower($tutorEmail)) {
                            $mailPending->bcc($clinicEmail);
                        }
                        $mailPending->send(new TutorWelcomeCarnetMail(
                            $tenant,
                            $subscription,
                            $subscription->pet->customer,
                            $subscription->pet,
                            $subscription->plan,
                            $carnetUrl,
                            strtoupper($gateway) . ' (Pago Aprobado Automáticamente)'
                        ));
                    }
                } catch (\Throwable $e) {
                    Log::warning("Error sending confirmation email on webhook: " . $e->getMessage());
                }

                Log::info("Webhook ({$gateway}): Subscription {$subscription->gateway_subscription_id} marked as ACTIVE and wallet accrued.");
            } elseif (in_array($status, ['REJECTED', 'FAILED', 'DECLINED', 'VOIDED', 'ERROR', 'SALE_REJECTED'])) {
                Log::warning("Webhook ({$gateway}): Subscription payment {$orderId} was rejected ({$status}).");
            }

            return response()->json([
                'success' => true,
                'gateway' => $gateway,
                'type' => 'subscription',
                'contract_id' => $subscription->gateway_subscription_id,
                'status' => $status,
            ]);
        }

        // 2. Caso B: Pago de Canon SaaS de Clínica Veterinaria B2B (ej. SAAS-vet-pet-patitas-pro-1234)
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
                $branding['saas_payment_method'] = $gateway;
                if ($newTier) {
                    $branding['saas_plan'] = $newTier;
                    $branding['saas_monthly_fee'] = $amount > 0 ? $amount : ($branding['saas_monthly_fee'] ?? 229000);
                    $tenant->saas_plan_tier = $newTier;
                }
                $tenant->update(['branding' => $branding, 'is_active' => true]);

                SaasPaymentLog::create([
                    'tenant_id' => $tenant->id,
                    'order_id' => $orderId,
                    'gateway' => $gateway,
                    'amount' => $amount > 0 ? $amount : (float) ($branding['saas_monthly_fee'] ?? 229000),
                    'currency' => 'COP',
                    'plan_tier' => $tenant->saas_plan_tier ?? 'pro',
                    'status' => 'approved',
                    'transaction_id' => $transactionId,
                    'payer_name' => $tenant->name,
                    'payer_email' => $tenant->branding['email'] ?? null,
                    'payer_phone' => $tenant->branding['phone'] ?? null,
                    'period_start' => now()->toDateString(),
                    'period_end' => now()->addDays(30)->toDateString(),
                    'notes' => "Pago automático B2B procesado exitosamente vía pasarela {$gateway}.",
                    'raw_payload' => $payload,
                    'paid_at' => now(),
                ]);

                Log::info("Webhook ({$gateway}): Tenant SaaS {$tenant->slug} renewed, logged in SaasPaymentLog, and marked as PAID.");
                return response()->json(['success' => true, 'gateway' => $gateway, 'type' => 'tenant_saas', 'status' => $status]);
            }
        }

        return response()->json(['success' => true, 'gateway' => $gateway, 'message' => 'Webhook received and recorded']);
    }
}
