<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PdfService
{
    /**
     * Gera o comprovativo em PDF e grava-o no disco privado. Devolve o
     * caminho relativo gravado em registrations.pdf_path.
     */
    public function generateRegistrationProof(Registration $registration): string
    {
        $registration->loadMissing(['event', 'participant.institution', 'participant.participantType', 'workshops', 'courses']);

        // SVG em vez de PNG: evita depender da extensão Imagick, que não está
        // disponível neste ambiente XAMPP (dompdf renderiza SVG embutido nativamente).
        $qrCodeBase64 = base64_encode(
            QrCode::format('svg')->size(220)->margin(1)->generate($registration->code)
        );

        $pdf = Pdf::loadView('pdf.comprovativo', [
            'registration' => $registration,
            'qrCodeDataUri' => 'data:image/svg+xml;base64,'.$qrCodeBase64,
        ])->setPaper('a4', 'portrait');

        $path = "registrations/{$registration->code}.pdf";

        Storage::disk('local')->put($path, $pdf->output());

        return $path;
    }

    /**
     * Gera o certificado em PDF e grava-o no disco privado. Devolve o
     * caminho relativo gravado em certificates.pdf_path.
     */
    public function generateCertificate(Certificate $certificate): string
    {
        $certificate->loadMissing(['registration.event', 'registration.participant']);

        $qrCodeBase64 = base64_encode(
            QrCode::format('svg')->size(180)->margin(1)->generate($certificate->code)
        );

        $pdf = Pdf::loadView('pdf.certificado', [
            'certificate' => $certificate,
            'qrCodeDataUri' => 'data:image/svg+xml;base64,'.$qrCodeBase64,
        ])->setPaper('a4', 'landscape');

        $path = "certificates/{$certificate->code}.pdf";

        Storage::disk('local')->put($path, $pdf->output());

        return $path;
    }
}
