<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CertificateAvailableMail;
use App\Models\AuditLog;
use App\Models\Certificate;
use App\Models\EmailLog;
use App\Models\Registration;
use App\Services\PdfService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class CertificateController extends Controller
{
    public function index(Request $request): View
    {
        $registrations = Registration::query()
            ->with(['participant', 'certificate'])
            ->where('status', '!=', 'cancelled')
            ->when($request->filled('status'), function ($q) use ($request) {
                if ($request->string('status') === 'issued') {
                    $q->whereHas('certificate', fn ($c) => $c->where('status', 'issued'));
                } else {
                    $q->whereDoesntHave('certificate');
                }
            })
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.certificates.index', ['registrations' => $registrations]);
    }

    public function issue(Registration $registration, PdfService $pdfService): RedirectResponse
    {
        $registration->loadMissing('participant');

        $certificate = $registration->certificate ?? Certificate::create([
            'registration_id' => $registration->id,
            'code' => Certificate::generateCode(),
            'type' => 'participacao',
            'status' => 'not_issued',
        ]);

        $path = $pdfService->generateCertificate($certificate);

        $certificate->update([
            'pdf_path' => $path,
            'status' => 'issued',
            'issued_at' => now(),
        ]);

        $registration->update(['certificate_status' => 'issued']);

        AuditLog::record('certificate.issued', $certificate, "Certificado {$certificate->code} emitido para {$registration->participant->full_name}");

        return back()->with('status', 'Certificado emitido para '.$registration->participant->full_name.'.');
    }

    public function send(Certificate $certificate): RedirectResponse
    {
        $certificate->loadMissing('registration.participant');

        $emailLog = EmailLog::create([
            'registration_id' => $certificate->registration_id,
            'to_email' => $certificate->registration->participant->email,
            'type' => 'certificate_available',
            'subject' => 'O seu certificado está disponível — 1ª Convenção Nacional de Revistas Científicas Angolanas',
            'status' => 'queued',
        ]);

        try {
            Mail::to($certificate->registration->participant->email)->send(new CertificateAvailableMail($certificate));
            $emailLog->update(['status' => 'sent', 'sent_at' => now()]);
            $certificate->update(['sent_at' => now()]);
            AuditLog::record('certificate.resent', $certificate, "Certificado {$certificate->code} reenviado por email");

            return back()->with('status', 'Certificado enviado por email.');
        } catch (Throwable $e) {
            $emailLog->update(['status' => 'failed', 'error_message' => $e->getMessage()]);
            AuditLog::record('email.failed', $certificate, 'Falha ao enviar certificado', ['error' => $e->getMessage()]);

            return back()->withErrors(['email' => 'Falha ao enviar o certificado: '.$e->getMessage()]);
        }
    }

    public function download(Certificate $certificate)
    {
        abort_unless($certificate->pdf_path && Storage::disk('local')->exists($certificate->pdf_path), 404);

        return response()->file(Storage::disk('local')->path($certificate->pdf_path), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "inline; filename=\"certificado-{$certificate->code}.pdf\"",
        ]);
    }
}
