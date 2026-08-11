<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEventDayRequest;
use App\Models\Event;
use App\Models\EventDay;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventDayController extends Controller
{
    public function index(): View
    {
        $event = Event::current();

        return view('admin.program.index', [
            'days' => $event->days()->with('sessions')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.program.days.create');
    }

    public function store(StoreEventDayRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['event_id'] = Event::current()->id;

        EventDay::create($data);

        return redirect()->route('admin.program-days.index')->with('status', 'Dia criado com sucesso.');
    }

    public function edit(EventDay $day): View
    {
        return view('admin.program.days.edit', ['day' => $day]);
    }

    public function update(StoreEventDayRequest $request, EventDay $day): RedirectResponse
    {
        $day->update($request->validated());

        return redirect()->route('admin.program-days.index')->with('status', 'Dia actualizado com sucesso.');
    }

    public function destroy(EventDay $day): RedirectResponse
    {
        $day->delete();

        return redirect()->route('admin.program-days.index')->with('status', 'Dia removido.');
    }
}
