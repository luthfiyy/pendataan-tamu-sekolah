<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $kedatanganTamu;
    public $qrCodeHtml;

    public function __construct($kedatanganTamu, $qrCodeHtml)
    {
        $this->kedatanganTamu = $kedatanganTamu;
        $this->qrCodeHtml = $qrCodeHtml;
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
            view: 'emails.tamu-diterima',
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
        return $this->view('emails.tamu-diterima')
                    ->subject('Status Kunjungan Anda Telah Diperbarui')
                    ->with(['kedatanganTamu' => $this->kedatanganTamu, 'qrCodePath' => $this->qrCodeHtml]);
    }

}
