<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateParticipantRequest;
use App\Models\AuditLog;
use App\Models\Institution;
use App\Models\Participant;
use App\Models\ParticipantType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ParticipantController extends Controller
{
    public function index(Request $request): View
    {
        $participants = Participant::query()
            ->with(['institution', 'participantType', 'registrations'])
            ->when($request->filled('name'), fn ($q) => $q->where('full_name', 'like', '%'.$request->string('name').'%'))
            ->when($request->filled('email'), fn ($q) => $q->where('email', 'like', '%'.$request->string('email').'%'))
            ->when($request->filled('province'), fn ($q) => $q->where('province', $request->string('province')))
            ->when($request->filled('participant_type_id'), fn ($q) => $q->where('participant_type_id', $request->integer('participant_type_id')))
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.participants.index', [
            'participants' => $participants,
            'participantTypes' => ParticipantType::orderBy('sort_order')->get(),
        ]);
    }

    public function edit(Participant $participant): View
    {
        $participant->load(['registrations.event']);

        return view('admin.participants.edit', [
            'participant' => $participant,
            'institutions' => Institution::orderBy('name')->get(),
            'participantTypes' => ParticipantType::orderBy('sort_order')->get(),
        ]);
    }

    public function update(UpdateParticipantRequest $request, Participant $participant): RedirectResponse
    {
        $participant->update($request->validated());

        AuditLog::record('participant.updated', $participant, "Dados de {$participant->full_name} alterados por administrador");

        return redirect()->route('admin.participants.index')->with('status', 'Participante actualizado com sucesso.');
    }
}
