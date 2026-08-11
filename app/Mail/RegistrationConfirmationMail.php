<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class RegistrationConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly Registration $registration)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmação de Inscrição — 1ª Convenção Nacional de Revistas Científicas Angolanas',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.registration-confirmation',
            with: ['registration' => $this->registration],
        );
    }

    public function attachments(): array
    {
        if (! $this->registration->pdf_path || ! Storage::disk('local')->exists($this->registration->pdf_path)) {
            return [];
        }

        return [
            Attachment::fromStorageDisk('local', $this->registration->pdf_path)
                ->as("comprovativo-{$this->registration->code}.pdf")
                ->withMime('application/pdf'),
        ];
    }
}
