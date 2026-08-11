<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateEventSettingsRequest;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EventSettingsController extends Controller
{
    public function edit(): View
    {
        return view('admin.event-settings.edit', ['event' => Event::current()]);
    }

    public function update(UpdateEventSettingsRequest $request): RedirectResponse
    {
        $event = Event::current();

        $data = $request->safe()->except(['logo', 'favicon', 'cover_image']);
        $data['registration_open'] = $request->boolean('registration_open');

        foreach (['logo' => 'logo_path', 'favicon' => 'favicon_path', 'cover_image' => 'cover_image_path'] as $field => $column) {
            if ($request->hasFile($field)) {
                if ($event->{$column}) {
                    Storage::disk('public')->delete($event->{$column});
                }
                $data[$column] = $request->file($field)->store('event', 'public');
            }
        }

        $event->update($data);

        return redirect()->route('admin.event-settings.edit')->with('status', 'Configurações do evento actualizadas com sucesso.');
    }
}
