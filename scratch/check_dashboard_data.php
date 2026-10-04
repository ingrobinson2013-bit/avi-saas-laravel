<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tenant;
use App\Models\Subscription;
use App\Models\Pet;
use App\Models\Customer;
use App\Models\Plan;
use App\Models\BenefitRedemption;
use App\Models\SubscriptionBenefitBalance;
use App\Models\WalletTransaction;

$tenant = Tenant::where('slug', 'vet-pet-patitas')->first();
echo "TENANT: " . ($tenant ? $tenant->name . ' [' . $tenant->id . ']' : 'NULL') . "\n";
if (!$tenant) exit;

$petsCount = Pet::whereHas('customer', fn($q) => $q->where('tenant_id', $tenant->id))->count();
$totalPets = Pet::count();
echo "Pets in tenant: $petsCount (Total pets: $totalPets)\n";

$customersCount = Customer::where('tenant_id', $tenant->id)->count();
echo "Customers in tenant: $customersCount\n";

$subs = Subscription::with(['pet', 'plan'])->where('tenant_id', $tenant->id)->get();
echo "Subscriptions in tenant: " . $subs->count() . "\n";
foreach ($subs as $s) {
    echo " - Sub ID: {$s->id}, Status: {$s->status}, Pet: " . ($s->pet?->name ?? 'None') . ", Plan: " . ($s->plan?->name ?? 'None') . " ({$s->plan?->price_cop}), Ends: {$s->current_period_end}\n";
}

$redemptions = BenefitRedemption::where('tenant_id', $tenant->id)->with(['balance.benefitDefinition', 'balance.subscription.pet'])->latest('redeemed_at')->take(5)->get();
echo "Redemptions in tenant: " . $redemptions->count() . " (Total in table: " . BenefitRedemption::count() . ")\n";
foreach ($redemptions as $r) {
    echo " - Redemption: {$r->redeemed_at}, Benefit: " . ($r->balance?->benefitDefinition?->name ?? 'None') . ", Pet: " . ($r->balance?->subscription?->pet?->name ?? 'None') . "\n";
}

$walletTx = WalletTransaction::latest()->take(5)->get();
echo "Wallet Transactions: " . $walletTx->count() . "\n";
foreach ($walletTx as $w) {
    echo " - Wallet Tx: {$w->type}, Amount: {$w->amount_cop}, Desc: {$w->description}\n";
}
