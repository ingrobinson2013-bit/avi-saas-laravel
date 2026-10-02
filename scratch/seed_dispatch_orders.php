<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tenant;
use App\Models\Pet;
use App\Models\Customer;
use App\Models\Subscription;
use App\Models\DispatchOrder;
use Illuminate\Support\Str;

echo "Seeding dispatch orders...\n";

$tenant = Tenant::where('slug', 'vet-pet-patitas')->first() ?? Tenant::first();
if (!$tenant) {
    echo "No tenant found.\n";
    exit(1);
}

$sub = Subscription::with(['pet.customer'])->where('tenant_id', $tenant->id)->first();
$pet = $sub?->pet ?? Pet::first();
$customer = $pet?->customer ?? Customer::first();

if (!$pet || !$customer) {
    echo "Missing pet or customer.\n";
    exit(1);
}

// Clear existing or check count
$existing = DispatchOrder::where('tenant_id', $tenant->id)->count();
if ($existing > 0) {
    echo "Already has {$existing} dispatch orders.\n";
    exit(0);
}

$orders = [
    [
        'id' => (string) Str::uuid(),
        'tenant_id' => $tenant->id,
        'subscription_id' => $sub?->id,
        'pet_id' => $pet->id,
        'customer_id' => $customer->id,
        'product_name' => 'Credelio 450mg (Antipulgas y Garrapatas)',
        'dosage' => '1 comprimido masticable oral (11-22 kg)',
        'frequency_months' => 3,
        'scheduled_dispatch_date' => now()->addDays(13)->toDateString(),
        'status' => 'scheduled',
        'tracking_number' => 'PENDIENTE-DSP-01',
        'courier_name' => 'Mensajería Express Local / Coordinadora',
        'delivery_address' => 'Calle 7 # 4-73 Este, Cajicá, Cundinamarca',
        'recipient_phone' => '3508742543',
    ],
    [
        'id' => (string) Str::uuid(),
        'tenant_id' => $tenant->id,
        'subscription_id' => $sub?->id,
        'pet_id' => $pet->id,
        'customer_id' => $customer->id,
        'product_name' => 'NexGard Spectra (Interno + Externo)',
        'dosage' => '1 masticable sabor a carne (3.5-7.5 kg)',
        'frequency_months' => 1,
        'scheduled_dispatch_date' => now()->addDays(3)->toDateString(),
        'status' => 'in_preparation',
        'tracking_number' => 'SER-2026-98124',
        'courier_name' => 'Servientrega Priority Pet',
        'delivery_address' => 'Carrera 6 # 3-21, Centro, Cajicá',
        'recipient_phone' => '3104567890',
    ],
    [
        'id' => (string) Str::uuid(),
        'tenant_id' => $tenant->id,
        'subscription_id' => $sub?->id,
        'pet_id' => $pet->id,
        'customer_id' => $customer->id,
        'product_name' => 'Bravecto 1 Masticable (12 Semanas)',
        'dosage' => '1 tableta masticable (10-20 kg)',
        'frequency_months' => 3,
        'scheduled_dispatch_date' => now()->subDays(4)->toDateString(),
        'status' => 'shipped',
        'tracking_number' => 'CRD-9843210-CO',
        'courier_name' => 'Coordinadora Mercantil',
        'delivery_address' => 'Vereda Chuntame Lote 4, Cajicá',
        'recipient_phone' => '3209876543',
    ]
];

foreach ($orders as $ord) {
    DispatchOrder::create($ord);
    echo "Created dispatch order for: {$ord['product_name']}\n";
}

echo "Seeding completed successfully.\n";
