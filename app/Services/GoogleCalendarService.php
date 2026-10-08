<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Tenant;
use Carbon\Carbon;

class GoogleCalendarService
{
    /**
     * Genera la URL universal de 1-clic para sincronizar con Google Calendar.
     * Compatible con navegadores web, Android y la app de Google Calendar en iOS.
     */
    public function generateGoogleCalendarUrl(Appointment $appointment, Tenant $tenant): string
    {
        $startUtc = $appointment->scheduled_at->copy()->setTimezone('UTC')->format('Ymd\THis\Z');
        $endUtc = $appointment->end_at->copy()->setTimezone('UTC')->format('Ymd\THis\Z');

        $serviceLabel = ucfirst($appointment->service_type ?: 'Consulta Médica');
        $petName = $appointment->pet?->name ?? 'Mascota';
        $petBreed = $appointment->pet?->breed ?? 'Mestizo';
        $clinicName = $tenant->branding['brand_name'] ?? $tenant->name ?? 'Clínica Veterinaria';

        $title = "🐾 {$serviceLabel}: {$petName} ({$petBreed}) | {$clinicName}";

        $doctor = $appointment->doctor_name ?: 'Dra. Vicky Naranjo';
        $tutorName = $appointment->customer?->name ?? 'Tutor';
        $tutorPhone = $appointment->customer?->phone ?? 'Sin teléfono';
        $address = $tenant->branding['address'] ?? 'Consultorio Veterinario';
        $city = $tenant->branding['city'] ?? 'Cajicá';
        $location = "{$address}, {$city}";

        $planName = $appointment->pet?->activeSubscription?->plan?->name ?? 'Plan de Salud Preventivo';
        $notes = $appointment->notes ? "\n\n📝 Notas adicionales: " . $appointment->notes : '';

        $details = "🩺 Doctor(a) a cargo: {$doctor}\n"
                 . "🐾 Paciente: {$petName} ({$petBreed})\n"
                 . "👤 Tutor: {$tutorName} (📱 {$tutorPhone})\n"
                 . "📋 Cobertura: {$planName}\n"
                 . "🏥 Clínica: {$clinicName}\n"
                 . "📍 Dirección: {$location}"
                 . "{$notes}\n\n"
                 . "✨ Gestionado automáticamente por AVI-Plan SaaS";

        $params = http_build_query([
            'action' => 'TEMPLATE',
            'text' => $title,
            'dates' => "{$startUtc}/{$endUtc}",
            'details' => $details,
            'location' => $location,
        ]);

        return "https://calendar.google.com/calendar/render?{$params}";
    }

    /**
     * Calcula los bloques de horarios libres y ocupados para una fecha específica.
     * Horario estándar: 8:00 AM a 6:00 PM con receso de almuerzo (1:00 PM a 2:00 PM).
     */
    public function getAvailableSlots(Tenant $tenant, string $dateString, string $doctorName = 'Dra. Vicky Naranjo', int $slotDurationMinutes = 30): array
    {
        $targetDate = Carbon::parse($dateString);

        // Obtener citas existentes para este tenant y fecha
        $existingAppointments = Appointment::where('tenant_id', $tenant->id)
            ->whereDate('scheduled_at', $targetDate->toDateString())
            ->whereNotIn('status', ['cancelled'])
            ->get();

        $slots = [];
        $startTime = $targetDate->copy()->setTime(8, 0, 0);
        $endTime = $targetDate->copy()->setTime(18, 0, 0);

        while ($startTime->lt($endTime)) {
            $slotEnd = $startTime->copy()->addMinutes($slotDurationMinutes);
            $hour = (int) $startTime->format('H');

            // Pausa de almuerzo (13:00 - 14:00)
            if ($hour === 13) {
                $slots[] = [
                    'time' => $startTime->format('H:i'),
                    'label' => $startTime->format('g:i A'),
                    'end_time' => $slotEnd->format('H:i'),
                    'is_available' => false,
                    'reason' => 'Receso de Almuerzo',
                ];
                $startTime->addMinutes($slotDurationMinutes);
                continue;
            }

            // Verificar si hay colisión con citas agendadas
            $conflict = $existingAppointments->first(function ($app) use ($startTime, $slotEnd) {
                return $startTime->lt($app->end_at) && $slotEnd->gt($app->scheduled_at);
            });

            if ($conflict) {
                $slots[] = [
                    'time' => $startTime->format('H:i'),
                    'label' => $startTime->format('g:i A'),
                    'end_time' => $slotEnd->format('H:i'),
                    'is_available' => false,
                    'reason' => 'Ocupado: ' . ($conflict->pet?->name ?? 'Paciente') . ' (' . ($conflict->service_type ?? 'Cita') . ')',
                    'appointment_id' => $conflict->id,
                ];
            } else {
                $slots[] = [
                    'time' => $startTime->format('H:i'),
                    'label' => $startTime->format('g:i A'),
                    'end_time' => $slotEnd->format('H:i'),
                    'is_available' => true,
                    'reason' => 'Disponible',
                ];
            }

            $startTime->addMinutes($slotDurationMinutes);
        }

        return $slots;
    }

    /**
     * Genera un enlace directo a WhatsApp para notificar la cita al tutor con link a su calendario.
     */
    public function generateWhatsAppReminderUrl(Appointment $appointment, Tenant $tenant): string
    {
        $phone = preg_replace('/\D/', '', $appointment->customer?->phone ?? '3235813942');
        $tutorName = explode(' ', trim($appointment->customer?->name ?? 'Tutor'))[0];
        $petName = $appointment->pet?->name ?? 'tu mascota';
        $clinicName = $tenant->branding['brand_name'] ?? $tenant->name ?? 'Vet-Pet Patitas';
        $address = $tenant->branding['address'] ?? 'Calle 7 # 4-73 Este';
        $city = $tenant->branding['city'] ?? 'Cajicá';

        $dateFormatted = $appointment->scheduled_at->format('d/m/Y');
        $timeFormatted = $appointment->scheduled_at->format('g:i A');
        $serviceLabel = ucfirst($appointment->service_type ?: 'Cita Médica');

        $calendarUrl = $appointment->google_calendar_url ?: $this->generateGoogleCalendarUrl($appointment, $tenant);

        $text = "🐾 ¡Hola, {$tutorName}! Te confirmamos tu cita de *{$serviceLabel}* para *{$petName}* en {$clinicName}.\n\n"
              . "📅 Fecha: *{$dateFormatted}*\n"
              . "⏰ Hora: *{$timeFormatted}*\n"
              . "📍 Dirección: {$address}, {$city}\n"
              . "🩺 Profesional: {$appointment->doctor_name}\n\n"
              . "📲 *Agrega esta cita a tu calendario de Google aquí:*\n"
              . "{$calendarUrl}\n\n"
              . "¡Te esperamos con mucho gusto para cuidar a {$petName}! 🐶🐱✨";

        return "https://wa.me/{$phone}?text=" . urlencode($text);
    }
}
