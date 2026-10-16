<?php

namespace App\Mail;

use App\Models\ProspectoVeterinaria;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProspectoOutreachMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ProspectoVeterinaria $prospecto
    ) {}

    public function envelope(): Envelope
    {
        $fromAddress = config('mail.from.address', 'contacto@avipetapp.com');
        $fromName = config('mail.from.name', 'AVI-Plan — Membresías Veterinarias');

        return new Envelope(
            from: new Address($fromAddress, $fromName),
            replyTo: [new Address('contacto@avipetapp.com', 'Atención Oficial AVI-Plan')],
            bcc: [new Address(env('MAIL_BCC_ADDRESS', 'ingrobinson2013@gmail.com'), 'Auditoría AVI-Plan')],
            subject: "¿Cómo generar ingresos fijos en {$this->prospecto->razon_social} sin depender solo de urgencias?"
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.prospecto_outreach',
            with: [
                'razonSocial' => $this->prospecto->razon_social,
                'municipio' => $this->prospecto->municipio,
                'correoComercial' => $this->prospecto->correo_comercial,
                'whatsappLinkNumber' => '573235813942',
                'razonSocialEncoded' => urlencode($this->prospecto->razon_social),
                'prospectoId' => $this->prospecto->id,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
