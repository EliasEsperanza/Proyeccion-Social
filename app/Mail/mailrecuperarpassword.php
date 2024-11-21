<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class mailrecuperarpassword extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $codigo;
    public $urlpassword;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $codigo, $urlpassword)
    {
        $this->user = $user;
        $this->codigo = $codigo;
        $this->urlpassword = $urlpassword;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Restablecimiento de tu contraseña.',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.mailrecuperarpassword',
            with: [
                'user' => $this->user,
                'codigo' => $this->codigo,
                'urlpassword' => $this->urlpassword,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
