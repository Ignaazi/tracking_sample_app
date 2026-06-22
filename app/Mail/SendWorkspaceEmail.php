<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendWorkspaceEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectText;
    public $bodyMessage;
    public $senderName;

    // Menangkap data dari Controller
    public function __construct($senderName, $subjectText, $bodyMessage)
    {
        $this->senderName = $senderName;
        $this->subjectText = $subjectText;
        $this->bodyMessage = $bodyMessage;
    }

    // Mengatur Amplop Email (Subject & Pengirim)
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectText,
        );
    }

    // Mengatur Konten Isi Email (Kita arahkan ke view terpisah khusus template email)
    public function content(): Content
    {
        return new Content(
            view: 'admin.email.workspace_template',
        );
    }
}