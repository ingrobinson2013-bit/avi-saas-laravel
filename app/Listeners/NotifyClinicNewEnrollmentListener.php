<?php

namespace App\Listeners;

use App\Events\PatientEnrolledEvent;
use App\Models\User;
use App\Notifications\NewEnrollmentClinicNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifyClinicNewEnrollmentListener implements ShouldQueue
{
    use InteractsWithQueue;

    public int $tries = 3;

    public function handle(PatientEnrolledEvent $event): void
    {
        $subscription = $event->subscription;
        $customer = $event->customer;
        $pet = $event->pet;
        $plan = $subscription->plan;

        if (!$plan) {
            return;
        }

        // Obtener usuarios administradores y veterinarios de esta sede
        $staffUsers = User::where('tenant_id', $subscription->tenant_id)->get();

        // Notificar también a los SuperAdministradores (Robinson / Central)
        $superAdmins = User::where('role', 'super_admin')->get();
        $recipients = $staffUsers->merge($superAdmins)->unique('id');

        if ($recipients->isNotEmpty()) {
            Notification::send(
                $recipients,
                new NewEnrollmentClinicNotification(
                    $subscription,
                    $customer,
                    $pet,
                    $plan,
                    $event->paymentMethod
                )
            );
        }
    }
}
