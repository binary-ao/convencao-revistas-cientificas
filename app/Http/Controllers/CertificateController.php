<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CertificateController extends Controller
{
    public function showValidateForm(): View
    {
        return view('public.certificate.validate', ['certificate' => null, 'notFound' => false]);
    }

    public function validateCode(Request $request): View
    {
        $request->validate(['code' => ['required', 'string']]);

        $certificate = Certificate::where('code', $request->string('code')->trim())
            ->where('status', 'issued')
            ->with(['registration.participant.institution', 'registration.event'])
            ->first();

        return view('public.certificate.validate', [
            'certificate' => $certificate,
            'notFound' => $certificate === null,
        ]);
    }
}
