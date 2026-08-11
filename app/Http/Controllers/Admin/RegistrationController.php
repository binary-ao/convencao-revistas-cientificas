<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\RegistrationConfirmationMail;
use App\Models\AuditLog;
use App\Models\Course;
use App\Models\EmailLog;
use App\Models\Registration;
use App\Models\Workshop;
use App\Services\PdfService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class RegistrationController extends Controller
{
    public function index(Request $request): View
    {
        $registrations = Registration::query()
            ->with(['participant.institution', 'participant.participantType'])
            ->when($request->filled('name'), fn ($q) => $q->whereHas('participant', fn ($p) => $p->where('full_name', 'like', '%'.$request->string('name').'%')))
            ->when($request->filled('email'), fn ($q) => $q->whereHas('participant', fn ($p) => $p->where('email', 'like', '%'.$request->string('email').'%')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->when($request->filled('modality'), fn ($q) => $q->where('modality', $request->string('modality')))
            ->when($request->filled('workshop_id'), fn ($q) => $q->whereHas('workshops', fn ($w) => $w->where('workshops.id', $request->integer('workshop_id'))))
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.registrations.index', [
            'registrations' => $registrations,
            'workshops' => Workshop::orderBy('sort_order')->get(),
        ]);
    }

    public function show(Registration $registration): View
    {
        $registration->load(['participant.institution', 'participant.participantType', 'workshops', 'courses', 'emailLogs']);

        return view('admin.registrations.show', ['registration' => $registration]);
    }

    public function edit(Registration $registration): View
    {
        $registration->load(['participant', 'workshops', 'courses']);

        return view('admin.registrations.edit', [
            'registration' => $registration,
            'workshops' => Workshop::where('event_id', $registration->event_id)->get(),
            'courses' => Course::where('event_id', $registration->event_id)->get(),
        ]);
    }

    public function update(Request $request, Registration $registration): RedirectResponse
    {
        $data = $request->validate([
            'modality' => ['required', 'in:presencial,online'],
            'admin_notes' => ['nullable', 'string'],
            'workshop_ids' => ['nullable', 'array'],
            'workshop_ids.*' => ['exists:workshops,id'],
            'course_ids' => ['nullable', 'array'],
            'course_ids.*' => ['exists:courses,id'],
        ]);

        $registration->update([
            'modality' => $data['modality'],
            'admin_notes' => $data['admin_notes'] ?? null,
        ]);

        $registration->workshops()->sync(collect($data['workshop_ids'] ?? [])->mapWithKeys(fn ($id) => [$id => ['status' => 'registered']]));
        $registration->courses()->sync(collect($data['course_ids'] ?? [])->mapWithKeys(fn ($id) => [$id => ['status' => 'registered']]));

        AuditLog::record('registration.updated', $registration, "Inscrição {$registration->code} actualizada por administrador");

        return redirect()->route('admin.registrations.show', $registration)->with('status', 'Inscrição actualizada com sucesso.');
    }

    public function confirm(Registration $registration): RedirectResponse
    {
        $registration->update(['status' => 'confirmed', 'confirmed_at' => now()]);

        AuditLog::record('registration.confirmed', $registration, "Inscrição {$registration->code} confirmada por administrador");

        return back()->with('status', 'Inscrição confirmada.');
    }

    public function cancel(Request $request, Registration $registration): RedirectResponse
    {
        $request->validate(['cancellation_reason' => ['nullable', 'string', 'max:500']]);

        $registration->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $request->string('cancellation_reason')->value() ?: null,
        ]);

        AuditLog::record('registration.cancelled', $registration, "Inscrição {$registration->code} cancelada por administrador");

        return back()->with('status', 'Inscrição cancelada.');
    }

    public function resendProof(Registration $registration, PdfService $pdfService): RedirectResponse
    {
        $registration->load('participant');

        if (! $registration->pdf_path || ! \Illuminate\Support\Facades\Storage::disk('local')->exists($registration->pdf_path)) {
            $path = $pdfService->generateRegistrationProof($registration);
            $registration->forceFill(['pdf_path' => $path, 'pdf_generated_at' => now()])->save();
        }

        $emailLog = EmailLog::create([
            'registration_id' => $registration->id,
            'to_email' => $registration->participant->email,
            'type' => 'resend',
            'subject' => 'Confirmação de Inscrição — 1ª Convenção Nacional de Revistas Científicas Angolanas',
            'status' => 'queued',
        ]);

        try {
            Mail::to($registration->participant->email)->send(new RegistrationConfirmationMail($registration->fresh()));
            $emailLog->update(['status' => 'sent', 'sent_at' => now()]);
            AuditLog::record('email.sent', $registration, "Comprovativo reenviado manualmente para {$registration->participant->email}");

            return back()->with('status', 'Comprovativo reenviado com sucesso.');
        } catch (Throwable $e) {
            $emailLog->update(['status' => 'failed', 'error_message' => $e->getMessage()]);
            AuditLog::record('email.failed', $registration, 'Falha ao reenviar comprovativo', ['error' => $e->getMessage()]);

            return back()->withErrors(['email' => 'Falha ao reenviar o comprovativo: '.$e->getMessage()]);
        }
    }
}
