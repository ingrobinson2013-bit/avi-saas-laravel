<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tenant;
use App\Models\Subscription;
use App\Models\SubscriptionBenefitBalance;
use App\Models\BenefitDefinition;

$tenant = Tenant::where('slug', 'vet-pet-patitas')->first();
$sub = Subscription::where('tenant_id', $tenant->id)->first();
if ($sub) {
    $balances = SubscriptionBenefitBalance::with('benefitDefinition')->where('subscription_id', $sub->id)->get();
    echo "Balances for Sub {$sub->id}:\n";
    foreach ($balances as $b) {
        echo " - {$b->benefitDefinition?->name}: granted={$b->total_granted}, used={$b->used_count}, rem={$b->remaining_count}\n";
    }
}
