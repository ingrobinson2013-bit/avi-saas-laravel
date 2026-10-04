<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tenant = App\Models\Tenant::where('slug', 'vet-pet-patitas')->first();
echo json_encode([
    'name' => $tenant?->name,
    'slug' => $tenant?->slug,
    'branding' => $tenant?->branding,
], JSON_PRETTY_PRINT);
