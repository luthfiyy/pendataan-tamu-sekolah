<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class pegawaiMail extends Mailable 
{
    use Queueable, SerializesModels;
    public $kedatanganTamu;


    /**
     * Create a new message instance.
     */
    public function __construct($kedatanganTamu)
    {
        $this->kedatanganTamu = $kedatanganTamu;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'SMKN 11 Bandung - Pendataan Tamu',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.pegawai-notif-tamu',
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

    public function build()
    {
        return $this->view('emails.pegawai-notif-tamu')
                    ->subject('Ada tamu yang ingin bertemu!')
                    ->with(['kedatanganTamu' => $this->kedatanganTamu]);
    }
}
