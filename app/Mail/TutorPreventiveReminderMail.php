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

class TutorPreventiveReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param array<int, array{name: string, remaining: int, granted: int, category: string}> $availableBenefits
     */
    public function __construct(
        public Tenant $tenant,
        public Subscription $subscription,
        public Customer $customer,
        public Pet $pet,
        public ?Plan $plan,
        public array $availableBenefits,
        public string $carnetUrl,
        public string $scheduleWhatsappUrl
    ) {}

    public function envelope(): Envelope
    {
        $fromAddress = config('mail.from.address', 'contacto@avipetapp.com');
        $clinicName = $this->tenant->name;
        $replyTo = $this->tenant->branding['email'] ?? $fromAddress;
        $firstBenefit = $this->availableBenefits[0]['name'] ?? 'Control Preventivo';

        return new Envelope(
            from: new Address($fromAddress, "{$clinicName} · Salud Preventiva"),
            replyTo: [new Address($replyTo, $clinicName)],
            subject: "💉 {$this->pet->name} tiene disponible su {$firstBenefit} sin costo · {$clinicName}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tutor_preventive_reminder',
        );
    }
}
