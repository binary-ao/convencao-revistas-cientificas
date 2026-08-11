<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSpeakerRequest;
use App\Http\Requests\Admin\UpdateSpeakerRequest;
use App\Models\Institution;
use App\Models\Speaker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SpeakerController extends Controller
{
    public function index(): View
    {
        return view('admin.speakers.index', [
            'speakers' => Speaker::with('institution')->orderBy('name')->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.speakers.create', [
            'institutions' => Institution::orderBy('name')->get(),
        ]);
    }

    public function store(StoreSpeakerRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('photo');
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('speakers', 'public');
        }

        Speaker::create($data);

        return redirect()->route('admin.speakers.index')->with('status', 'Orador criado com sucesso.');
    }

    public function edit(Speaker $speaker): View
    {
        return view('admin.speakers.edit', [
            'speaker' => $speaker,
            'institutions' => Institution::orderBy('name')->get(),
        ]);
    }

    public function update(UpdateSpeakerRequest $request, Speaker $speaker): RedirectResponse
    {
        $data = $request->safe()->except(['photo', 'remove_photo']);
        if ($data['name'] !== $speaker->name) {
            $data['slug'] = $this->uniqueSlug($data['name'], $speaker->id);
        }
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('photo')) {
            if ($speaker->photo_path) {
                Storage::disk('public')->delete($speaker->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('speakers', 'public');
        } elseif ($request->boolean('remove_photo') && $speaker->photo_path) {
            Storage::disk('public')->delete($speaker->photo_path);
            $data['photo_path'] = null;
        }

        $speaker->update($data);

        return redirect()->route('admin.speakers.index')->with('status', 'Orador actualizado com sucesso.');
    }

    public function destroy(Speaker $speaker): RedirectResponse
    {
        if ($speaker->photo_path) {
            Storage::disk('public')->delete($speaker->photo_path);
        }

        $speaker->delete();

        return redirect()->route('admin.speakers.index')->with('status', 'Orador removido.');
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;

        while (Speaker::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$base}-".++$i;
        }

        return $slug;
    }
}
