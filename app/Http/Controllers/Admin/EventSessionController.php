<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEventSessionRequest;
use App\Models\Course;
use App\Models\Event;
use App\Models\EventSession;
use App\Models\Speaker;
use App\Models\Workshop;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventSessionController extends Controller
{
    public function create(): View
    {
        return view('admin.program.sessions.create', $this->formData());
    }

    public function store(StoreEventSessionRequest $request): RedirectResponse
    {
        EventSession::create($request->validated());

        return redirect()->route('admin.program-days.index')->with('status', 'Sessão criada com sucesso.');
    }

    public function edit(EventSession $session): View
    {
        return view('admin.program.sessions.edit', ['session' => $session] + $this->formData());
    }

    public function update(StoreEventSessionRequest $request, EventSession $session): RedirectResponse
    {
        $session->update($request->validated());

        return redirect()->route('admin.program-days.index')->with('status', 'Sessão actualizada com sucesso.');
    }

    public function destroy(EventSession $session): RedirectResponse
    {
        $session->delete();

        return redirect()->route('admin.program-days.index')->with('status', 'Sessão removida.');
    }

    private function formData(): array
    {
        $event = Event::current();

        return [
            'days' => $event->days()->get(),
            'workshops' => Workshop::where('event_id', $event->id)->get(),
            'courses' => Course::where('event_id', $event->id)->get(),
            'speakers' => Speaker::orderBy('name')->get(),
        ];
    }
}
