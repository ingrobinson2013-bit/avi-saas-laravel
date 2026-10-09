<?php

namespace App\Mail;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClinicWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Tenant $tenant,
        public User $user,
        public string $clinicName,
        public string $adminName,
        public string $city,
        public string $adminUrl,
        public string $storefrontUrl
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('contacto@avipetapp.com', 'Robinson Naranjo — AVI-Plan'),
            replyTo: [new Address('contacto@avipetapp.com', 'Soporte AVI-Plan')],
            subject: "🎉 ¡Bienvenido(a) a AVI-Plan, Dr(a). {$this->adminName}! Tu prueba de 15 días está lista"
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.clinic_welcome',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
