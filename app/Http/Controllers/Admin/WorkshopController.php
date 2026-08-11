<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreWorkshopRequest;
use App\Http\Requests\Admin\UpdateWorkshopRequest;
use App\Models\Event;
use App\Models\Speaker;
use App\Models\Workshop;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WorkshopController extends Controller
{
    public function index(): View
    {
        return view('admin.workshops.index', [
            'workshops' => Workshop::with('trainer')->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.workshops.create', ['speakers' => Speaker::orderBy('name')->get()]);
    }

    public function store(StoreWorkshopRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['event_id'] = Event::current()->id;
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Workshop::create($data);

        return redirect()->route('admin.workshops.index')->with('status', 'Workshop criado com sucesso.');
    }

    public function edit(Workshop $workshop): View
    {
        return view('admin.workshops.edit', ['workshop' => $workshop, 'speakers' => Speaker::orderBy('name')->get()]);
    }

    public function update(UpdateWorkshopRequest $request, Workshop $workshop): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $workshop->update($data);

        return redirect()->route('admin.workshops.index')->with('status', 'Workshop actualizado com sucesso.');
    }

    public function destroy(Workshop $workshop): RedirectResponse
    {
        $workshop->delete();

        return redirect()->route('admin.workshops.index')->with('status', 'Workshop removido.');
    }
}
