<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tenant = App\Models\Tenant::where('slug', 'vet-pet-patitas')->first() ?? App\Models\Tenant::first();
$pet = App\Models\Pet::with('customer')->where('name', 'Max')->first() ?? App\Models\Pet::first();

if ($tenant && $pet) {
    $now = Carbon\Carbon::today()->setTime(10, 0);
    $appointment = App\Models\Appointment::firstOrCreate([
        'tenant_id' => $tenant->id,
        'pet_id' => $pet->id,
        'scheduled_at' => $now,
    ], [
        'customer_id' => $pet->customer_id,
        'doctor_name' => 'Dra. Vicky Naranjo',
        'title' => 'Vacunación y Chequeo Preventivo - Max (Golden Retriever)',
        'end_at' => $now->copy()->addMinutes(30),
        'duration_minutes' => 30,
        'status' => 'confirmed',
        'service_type' => 'Vacunación Antirrábica',
        'notes' => 'Refuerzo de vacuna antirrábica anual y chequeo preventivo de piel y oídos.',
        'sync_status' => 'synced',
    ]);

    $svc = app(App\Services\GoogleCalendarService::class);
    $appointment->google_calendar_url = $svc->generateGoogleCalendarUrl($appointment, $tenant);
    $appointment->save();

    echo "CITA EXITOSA ID: " . $appointment->id . PHP_EOL;
    echo "GOOGLE CALENDAR LINK: " . $appointment->google_calendar_url . PHP_EOL;
}
