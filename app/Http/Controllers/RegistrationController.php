<?php

namespace App\Http\Controllers;

use App\Exceptions\ActivityFullException;
use App\Exceptions\DuplicateRegistrationException;
use App\Http\Requests\StoreRegistrationRequest;
use App\Models\Course;
use App\Models\Event;
use App\Models\Institution;
use App\Models\ParticipantType;
use App\Models\Registration;
use App\Models\Workshop;
use App\Services\RegistrationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class RegistrationController extends Controller
{
    public function create(): View
    {
        $event = Event::current();

        return view('public.registration.create', [
            'event' => $event,
            'institutions' => Institution::orderBy('name')->get(),
            'participantTypes' => ParticipantType::where('is_active', true)->orderBy('sort_order')->get(),
            'workshops' => Workshop::where('event_id', $event->id)->where('is_active', true)->orderBy('sort_order')->get(),
            'courses' => Course::where('event_id', $event->id)->where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function store(StoreRegistrationRequest $request, RegistrationService $service): RedirectResponse
    {
        $event = Event::current();

        $participantData = $request->safe()->only([
            'full_name', 'email', 'phone', 'province', 'country',
            'institution_id', 'institution_name_other', 'job_title', 'scientific_area',
            'participant_type_id', 'participant_type_other',
        ]);
        $participantData['privacy_policy_accepted_at'] = now();

        try {
            $registration = $service->register(
                event: $event,
                participantData: $participantData,
                modality: $request->string('modality')->value(),
                workshopIds: $request->input('workshop_ids', []),
                courseIds: $request->input('course_ids', []),
                ipAddress: $request->ip(),
            );
        } catch (DuplicateRegistrationException $e) {
            return back()
                ->withInput()
                ->with('duplicate_registration', true)
                ->with('duplicate_email', $participantData['email']);
        } catch (ActivityFullException $e) {
            return back()->withInput()->withErrors(['workshop_ids' => $e->getMessage()]);
        }

        return redirect()->route('registration.success', $registration);
    }

    public function success(Registration $registration): View
    {
        $registration->load(['participant', 'workshops', 'courses']);

        return view('public.registration.success', ['registration' => $registration]);
    }

    public function downloadProof(Registration $registration): BinaryFileResponse
    {
        $email = request()->query('email');

        abort_unless($email && strcasecmp($registration->participant->email, $email) === 0, 403);
        abort_unless($registration->pdf_path && Storage::disk('local')->exists($registration->pdf_path), 404);

        return response()->file(Storage::disk('local')->path($registration->pdf_path), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "inline; filename=\"comprovativo-{$registration->code}.pdf\"",
        ]);
    }
}
