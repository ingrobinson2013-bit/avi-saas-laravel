<?php

namespace App\Mail;

use App\Models\BenefitRedemption;
use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TutorRedemptionReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public BenefitRedemption $redemption,
        public Tenant $tenant,
        public string $petName,
        public string $customerName,
        public string $benefitName,
        public int $quantity,
        public int $remainingCount,
        public int $totalGranted,
        public string $attendedBy,
        public ?string $notes,
        public string $carnetUrl
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
            subject: "✅ Comprobante de Atención: {$this->benefitName} para {$this->petName} · {$clinicName}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tutor_redemption_receipt',
        );
    }
}
