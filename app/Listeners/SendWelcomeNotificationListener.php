<?php

namespace App\Listeners;

use App\Events\PatientEnrolledEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWelcomeNotificationListener implements ShouldQueue
{
    use InteractsWithQueue;

    public int $tries = 3;
    public int $backoff = 5;

    public function handle(PatientEnrolledEvent $event): void
    {
        $subscription = $event->subscription;
        $customer = $event->customer;
        $pet = $event->pet;
        $tenant = $subscription->tenant;

        $contractId = $subscription->gateway_subscription_id;
        $carnetUrl = url("/v/" . ($tenant->slug ?? 'vet-pet-patitas') . "/carnet/{$contractId}");

        Log::info("🐾 [QUEUE ASYNC] Paciente Afiliado exitosamente en segundo plano:", [
            'tenant' => $tenant->name ?? 'Clínica',
            'contract_id' => $contractId,
            'customer' => $customer->name,
            'phone' => $customer->phone,
            'pet' => $pet->name,
            'plan' => $subscription->plan->name ?? 'Plan de Salud',
            'carnet_url' => $carnetUrl,
        ]);

        // Si la clínica tiene webhook de n8n o WhatsApp configurado en branding
        $webhookUrl = $tenant->branding['n8n_webhook_enrollment'] ?? env('N8N_ENROLLMENT_WEBHOOK_URL');
        if ($webhookUrl) {
            try {
                Http::timeout(5)->post($webhookUrl, [
                    'event' => 'patient_enrolled',
                    'tenant_id' => $tenant->id,
                    'tenant_name' => $tenant->name,
                    'contract_id' => $contractId,
                    'customer_name' => $customer->name,
                    'customer_phone' => $customer->phone,
                    'customer_email' => $customer->email,
                    'pet_name' => $pet->name,
                    'pet_species' => $pet->species,
                    'pet_breed' => $pet->breed,
                    'plan_name' => $subscription->plan->name ?? 'Plan',
                    'carnet_url' => $carnetUrl,
                    'timestamp' => now()->toIso8601String(),
                ]);
            } catch (\Throwable $e) {
                Log::warning("⚠️ [QUEUE] Webhook n8n no respondió: " . $e->getMessage());
            }
        }
    }
}
