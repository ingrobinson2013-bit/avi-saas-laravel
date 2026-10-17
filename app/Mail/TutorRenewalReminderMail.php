<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Pet;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TutorRenewalReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Tenant $tenant,
        public Subscription $subscription,
        public Customer $customer,
        public Pet $pet,
        public ?Plan $plan,
        public string $paymentUrl,
        public string $carnetUrl,
        public int $daysLeft,
        public float $walletBalance = 0.0
    ) {}

    public function envelope(): Envelope
    {
        $fromAddress = config('mail.from.address', 'contacto@avipetapp.com');
        $clinicName = $this->tenant->name;
        $replyTo = $this->tenant->branding['email'] ?? $fromAddress;

        $subjectPrefix = $this->daysLeft < 0
            ? "⚠️ Tu plan veterinario de {$this->pet->name} requiere renovación"
            : ($this->daysLeft === 0
                ? "⏰ Hoy vence la cuota del Plan de Salud de {$this->pet->name}"
                : "🐾 Recordatorio: El Plan de Salud de {$this->pet->name} renueva en {$this->daysLeft} día(s)");

        return new Envelope(
            from: new Address($fromAddress, "{$clinicName} · AviPetApp"),
            replyTo: [new Address($replyTo, $clinicName)],
            subject: "{$subjectPrefix} · {$clinicName}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tutor_renewal_reminder',
        );
    }
}
