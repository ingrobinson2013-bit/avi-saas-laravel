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

class TutorWelcomeCarnetMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Tenant $tenant,
        public Subscription $subscription,
        public Customer $customer,
        public Pet $pet,
        public Plan $plan,
        public string $carnetUrl,
        public string $paymentText = 'Nequi / Transferencia'
    ) {}

    public function envelope(): Envelope
    {
        $fromAddress = config('mail.from.address', 'contacto@avipetapp.com');
        $clinicName = $this->tenant->name ?? 'Clínica Veterinaria';
        $replyToEmail = $this->tenant->branding['email'] ?? $fromAddress;

        return new Envelope(
            from: new Address($fromAddress, "{$clinicName} · vía AVI-Plan"),
            replyTo: [
                new Address($replyToEmail, $clinicName),
            ],
            subject: "🪪 Carnet Digital de {$this->pet->name} · {$this->plan->name} ({$clinicName})",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tutor_welcome_carnet',
        );
    }
}
