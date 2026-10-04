<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tenant;
use App\Services\GeminiClinicAssistantService;

$tenant = Tenant::where('slug', 'vet-pet-patitas')->first();
echo "Testing Gemini service...\n";
$start = microtime(true);
$service = new GeminiClinicAssistantService();
$res = $service->ask('¿Cuál es el plan más vendido?', $tenant);
echo "Completed in " . round(microtime(true) - $start, 2) . "s\n";
echo "Source: " . $res['source'] . "\n";
echo "Reply:\n" . $res['reply'] . "\n";
