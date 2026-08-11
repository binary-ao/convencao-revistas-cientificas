<?php

namespace App\Services;

use App\Events\RegistrationCreated;
use App\Exceptions\ActivityFullException;
use App\Exceptions\DuplicateRegistrationException;
use App\Models\AuditLog;
use App\Models\Course;
use App\Models\Event;
use App\Models\Participant;
use App\Models\Registration;
use App\Models\Workshop;
use Illuminate\Support\Facades\DB;

class RegistrationService
{
    /**
     * @param  array  $participantData  campos de Participant (secção F da arquitectura)
     * @param  array  $workshopIds
     * @param  array  $courseIds
     */
    public function register(
        Event $event,
        array $participantData,
        string $modality,
        array $workshopIds,
        array $courseIds,
        ?string $ipAddress,
    ): Registration {
        $existing = $this->findExistingRegistration($event, $participantData['email']);

        if ($existing) {
            throw new DuplicateRegistrationException($existing);
        }

        return DB::transaction(function () use ($event, $participantData, $modality, $workshopIds, $courseIds, $ipAddress) {
            $participant = Participant::create($participantData);

            $registration = Registration::create([
                'event_id' => $event->id,
                'participant_id' => $participant->id,
                'code' => Registration::generateCode($event),
                'status' => 'pending',
                'modality' => $modality,
                'submitted_at' => now(),
                'source' => 'web',
                'ip_address' => $ipAddress,
            ]);

            $this->attachWorkshops($registration, $workshopIds);
            $this->attachCourses($registration, $courseIds);

            AuditLog::record('registration.created', $registration, "Inscrição {$registration->code} criada por {$participant->full_name}");

            event(new RegistrationCreated($registration));

            return $registration;
        });
    }

    public function findExistingRegistration(Event $event, string $email): ?Registration
    {
        return Registration::query()
            ->where('event_id', $event->id)
            ->whereHas('participant', fn ($q) => $q->where('email', $email))
            ->whereNot('status', 'cancelled')
            ->first();
    }

    private function attachWorkshops(Registration $registration, array $workshopIds): void
    {
        foreach ($workshopIds as $workshopId) {
            $workshop = Workshop::where('id', $workshopId)->lockForUpdate()->firstOrFail();

            if ($workshop->isFull()) {
                throw new ActivityFullException($workshop->name);
            }

            $registration->workshops()->attach($workshop->id, ['status' => 'registered']);
        }
    }

    private function attachCourses(Registration $registration, array $courseIds): void
    {
        foreach ($courseIds as $courseId) {
            $course = Course::where('id', $courseId)->lockForUpdate()->firstOrFail();

            if ($course->isFull()) {
                throw new ActivityFullException($course->name);
            }

            $registration->courses()->attach($course->id, ['status' => 'registered']);
        }
    }
}
