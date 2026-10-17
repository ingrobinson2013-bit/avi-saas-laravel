<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Pet;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SubscriptionCarnetController extends Controller
{
    protected function resolveCarnetData(string $slug, string $subscriptionId): array
    {
        $tenant = Tenant::where('slug', $slug)->first() ?? Tenant::first();

        if (!$tenant) {
            $tenant = new Tenant([
                'name' => 'Vet-Pet Patitas Consultorio Veterinario',
                'slug' => 'vet-pet-patitas',
                'is_active' => true,
                'branding' => [
                    'primary_color' => '#0E7490',
                    'secondary_color' => '#080B20',
                    'city' => 'Cajicá, Cundinamarca',
                    'address' => 'Calle 7 # 4-73 Este',
                    'phone' => '3235813942',
                ],
            ]);
            $tenant->id = '00000000-0000-0000-0000-000000000001';
        }

        $isUuid = \Illuminate\Support\Str::isUuid($subscriptionId);

        $subscription = null;
        if ($tenant->exists) {
            $subscription = Subscription::where('tenant_id', $tenant->id)
                ->where(function ($query) use ($subscriptionId, $isUuid) {
                    if ($isUuid) {
                        $query->where('id', $subscriptionId)
                              ->orWhere('gateway_subscription_id', $subscriptionId);
                    } else {
                        $query->where('gateway_subscription_id', $subscriptionId);
                    }
                })
                ->with(['pet.customer', 'plan', 'benefitBalances.benefitDefinition'])
                ->first();

            if (!$subscription) {
                $subscription = Subscription::where('tenant_id', $tenant->id)
                    ->with(['pet.customer', 'plan', 'benefitBalances.benefitDefinition'])
                    ->latest()
                    ->first();
            }
        }

        if (!$subscription) {
            $customer = new Customer([
                'name' => 'Carlos Mendoza',
                'phone' => '3235813942',
                'email' => 'carlos.mendoza@ejemplo.com',
            ]);

            $pet = new Pet([
                'name' => 'Luna',
                'species' => 'Canino',
                'breed' => 'Golden Retriever',
            ]);
            $pet->setRelation('customer', $customer);

            $plan = ($tenant->exists ? $tenant->plans()->first() : null) ?? new Plan([
                'name' => 'Plan Premium Patitas',
                'price_cop' => 65000,
            ]);

            $subscription = new Subscription([
                'gateway_subscription_id' => $subscriptionId ?: 'VP-2026-0881',
                'status' => 'active',
                'current_period_start' => now()->subMonth(),
                'current_period_end' => now()->addMonths(11),
            ]);
            $subscription->id = '00000000-0000-0000-0000-000000000881';
            $subscription->setRelation('pet', $pet);
            $subscription->setRelation('plan', $plan);
            $subscription->setRelation('benefitBalances', collect([]));
        }

        return [$tenant, $subscription];
    }

    public function show(string $slug, string $subscriptionId)
    {
        [$tenant, $subscription] = $this->resolveCarnetData($slug, $subscriptionId);

        return view('subscription_carnet', compact('tenant', 'subscription'));
    }

    public function downloadPdf(string $slug, string $subscriptionId)
    {
        [$tenant, $subscription] = $this->resolveCarnetData($slug, $subscriptionId);

        if (class_exists(Pdf::class)) {
            $pdf = Pdf::loadView('subscription_carnet_pdf', compact('tenant', 'subscription'))
                ->setPaper('a4', 'portrait');
            
            $petName = $subscription->pet?->name ?? 'Mascota';
            $contractId = $subscription->gateway_subscription_id ?? 'VP-2026-0881';
            $filename = 'Carnet-' . str()->slug($petName) . '-' . $contractId . '.pdf';
            return $pdf->download($filename);
        }

        return view('subscription_carnet', compact('tenant', 'subscription'));
    }
}

