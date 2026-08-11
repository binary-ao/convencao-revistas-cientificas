<?php

namespace App\Listeners;

use App\Events\RegistrationCreated;
use App\Mail\RegistrationConfirmationMail;
use App\Models\AuditLog;
use App\Models\EmailLog;
use App\Services\PdfService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * Corre em fila (fora do pedido HTTP). Gera o comprovativo e envia o email
 * de confirmação. Se o envio falhar, a inscrição já está gravada — apenas
 * regista o erro em email_logs para permitir reenvio manual pelo admin
 * (secção 6 da arquitectura).
 */
class ProcessRegistrationConfirmation implements ShouldQueue
{
    public function handle(RegistrationCreated $event): void
    {
        $registration = $event->registration;

        $pdfPath = app(PdfService::class)->generateRegistrationProof($registration);

        $registration->forceFill([
            'pdf_path' => $pdfPath,
            'pdf_generated_at' => now(),
            'qr_code_value' => $registration->code,
        ])->save();

        AuditLog::record('registration.proof_generated', $registration, "Comprovativo gerado para {$registration->code}");

        $this->sendConfirmationEmail($registration->fresh());
    }

    private function sendConfirmationEmail(\App\Models\Registration $registration): void
    {
        $emailLog = EmailLog::create([
            'registration_id' => $registration->id,
            'to_email' => $registration->participant->email,
            'type' => 'confirmation',
            'subject' => 'Confirmação de Inscrição — 1ª Convenção Nacional de Revistas Científicas Angolanas',
            'status' => 'queued',
        ]);

        try {
            Mail::to($registration->participant->email)->send(new RegistrationConfirmationMail($registration));

            $emailLog->update(['status' => 'sent', 'sent_at' => now()]);
            AuditLog::record('email.sent', $registration, "Email de confirmação enviado para {$registration->participant->email}");
        } catch (Throwable $e) {
            Log::error('Falha ao enviar email de confirmação de inscrição', [
                'registration_id' => $registration->id,
                'error' => $e->getMessage(),
            ]);

            $emailLog->update(['status' => 'failed', 'error_message' => $e->getMessage()]);
            AuditLog::record('email.failed', $registration, 'Falha ao enviar email de confirmação', ['error' => $e->getMessage()]);
        }
    }
}
