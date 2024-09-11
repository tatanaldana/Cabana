<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address("notifications@arcasoftware.com", "APIcabaña"),
            subject: 'Restablecimiento de Contraseña',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.password_reset', // Vista para el restablecimiento de contraseña
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
