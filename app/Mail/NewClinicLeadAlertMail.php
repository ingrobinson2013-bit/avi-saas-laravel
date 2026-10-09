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

class NewClinicLeadAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Tenant $tenant,
        public User $user,
        public array $data,
        public string $waLink,
        public string $adminUrl,
        public string $storefrontUrl
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('contacto@avipetapp.com', 'Sistema Central AVI-Plan'),
            replyTo: [new Address($this->user->email, $this->data['clinic_name'])],
            subject: "🚨 ¡Nueva Veterinaria Registrada!: {$this->data['clinic_name']} ({$this->data['city']})"
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new_clinic_lead_alert',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
