<?php

namespace App\Listeners;

use App\Events\AppointmentScheduledEvent;
use App\Services\GoogleCalendarService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SyncGoogleCalendarListener implements ShouldQueue
{
    use InteractsWithQueue;

    public int $tries = 3;

    public function __construct(
        protected GoogleCalendarService $calendarService
    ) {}

    public function handle(AppointmentScheduledEvent $event): void
    {
        $appointment = $event->appointment;
        $tenant = $appointment->tenant;

        if (!$tenant) {
            return;
        }

        try {
            $calendarUrl = $this->calendarService->generateGoogleCalendarUrl($appointment, $tenant);
            $appointment->update([
                'google_calendar_url' => $calendarUrl,
                'sync_status' => 'synced',
            ]);

            Log::info("📅 [QUEUE ASYNC] Cita sincronizada con Google Calendar en segundo plano:", [
                'appointment_id' => $appointment->id,
                'doctor' => $appointment->doctor_name,
                'date' => $appointment->scheduled_at->format('Y-m-d H:i'),
                'pet' => $appointment->pet?->name,
            ]);
        } catch (\Throwable $e) {
            Log::warning("⚠️ [QUEUE] Error al sincronizar con Google Calendar: " . $e->getMessage());
        }
    }
}
