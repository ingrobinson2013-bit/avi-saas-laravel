<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SubscriptionCarnetController extends Controller
{
    public function show(string $slug, string $subscriptionId)
    {
        $tenant = Tenant::where('slug', $slug)->firstOrFail();
        
        $subscription = Subscription::where('tenant_id', $tenant->id)
            ->where(function ($query) use ($subscriptionId) {
                $query->where('id', $subscriptionId)
                    ->orWhere('gateway_subscription_id', $subscriptionId);
            })
            ->with(['pet.customer', 'plan', 'benefitBalances.benefitDefinition'])
            ->firstOrFail();

        return view('subscription_carnet', compact('tenant', 'subscription'));
    }

    public function downloadPdf(string $slug, string $subscriptionId)
    {
        $tenant = Tenant::where('slug', $slug)->firstOrFail();
        
        $subscription = Subscription::where('tenant_id', $tenant->id)
            ->where(function ($query) use ($subscriptionId) {
                $query->where('id', $subscriptionId)
                    ->orWhere('gateway_subscription_id', $subscriptionId);
            })
            ->with(['pet.customer', 'plan', 'benefitBalances.benefitDefinition'])
            ->firstOrFail();

        if (class_exists(Pdf::class)) {
            $pdf = Pdf::loadView('subscription_carnet_pdf', compact('tenant', 'subscription'))
                ->setPaper('a4', 'portrait');
            
            $filename = 'Carnet-' . str()->slug($subscription->pet->name) . '-' . $subscription->gateway_subscription_id . '.pdf';
            return $pdf->download($filename);
        }

        // Fallback a vista imprimible si dompdf no está instanciado
        return view('subscription_carnet', compact('tenant', 'subscription'));
    }
}
