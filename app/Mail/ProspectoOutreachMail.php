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
        return new Envelope(
            from: new Address('contacto@avipetapp.com', 'AVI-Plan — Membresías Veterinarias'),
            replyTo: [new Address('contacto@avipetapp.com', 'Atención Oficial AVI-Plan')],
            bcc: [new Address('contacto@avipetapp.com', 'Copia Auditoría AVI-Plan')],
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
