<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use App\Models\Workshop;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $event = Event::current();
        $registrations = Registration::where('event_id', $event?->id);

        $kpis = [
            'total' => (clone $registrations)->count(),
            'confirmed' => (clone $registrations)->where('status', 'confirmed')->count(),
            'pending' => (clone $registrations)->where('status', 'pending')->count(),
            'cancelled' => (clone $registrations)->where('status', 'cancelled')->count(),
            'presencial' => (clone $registrations)->where('modality', 'presencial')->count(),
            'online' => (clone $registrations)->where('modality', 'online')->count(),
            'checked_in' => (clone $registrations)->where('checkin_status', 'checked_in')->count(),
            'certificates' => (clone $registrations)->where('certificate_status', 'issued')->count(),
        ];

        $byProfile = (clone $registrations)
            ->join('participants', 'participants.id', '=', 'registrations.participant_id')
            ->join('participant_types', 'participant_types.id', '=', 'participants.participant_type_id')
            ->select('participant_types.label', DB::raw('count(*) as total'))
            ->groupBy('participant_types.label')
            ->orderByDesc('total')
            ->get();

        $byWorkshop = Workshop::where('event_id', $event?->id)
            ->withCount(['registrations' => fn ($q) => $q->where('registration_workshops.status', 'registered')])
            ->orderByDesc('registrations_count')
            ->get();

        $byInstitution = (clone $registrations)
            ->join('participants', 'participants.id', '=', 'registrations.participant_id')
            ->join('institutions', 'institutions.id', '=', 'participants.institution_id')
            ->select('institutions.name', 'institutions.acronym', DB::raw('count(*) as total'))
            ->groupBy('institutions.id', 'institutions.name', 'institutions.acronym')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        return view('admin.dashboard', [
            'event' => $event,
            'staffCount' => User::count(),
            'kpis' => $kpis,
            'byProfile' => $byProfile,
            'byWorkshop' => $byWorkshop,
            'byInstitution' => $byInstitution,
        ]);
    }
}
