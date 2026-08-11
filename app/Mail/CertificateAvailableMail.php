<?php

namespace App\Mail;

use App\Models\Certificate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CertificateAvailableMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly Certificate $certificate)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'O seu certificado está disponível — 1ª Convenção Nacional de Revistas Científicas Angolanas',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.certificate-available',
            with: ['certificate' => $this->certificate],
        );
    }

    public function attachments(): array
    {
        if (! $this->certificate->pdf_path || ! Storage::disk('local')->exists($this->certificate->pdf_path)) {
            return [];
        }

        return [
            Attachment::fromStorageDisk('local', $this->certificate->pdf_path)
                ->as("certificado-{$this->certificate->code}.pdf")
                ->withMime('application/pdf'),
        ];
    }
}
