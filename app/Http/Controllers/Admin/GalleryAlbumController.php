<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGalleryAlbumRequest;
use App\Models\Event;
use App\Models\GalleryAlbum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GalleryAlbumController extends Controller
{
    public function index(): View
    {
        return view('admin.gallery.albums.index', [
            'albums' => GalleryAlbum::withCount('items')->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.gallery.albums.create');
    }

    public function store(StoreGalleryAlbumRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('cover_image');
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['event_id'] = Event::current()?->id;
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('gallery', 'public');
        }

        GalleryAlbum::create($data);

        return redirect()->route('admin.gallery-albums.index')->with('status', 'Álbum criado com sucesso.');
    }

    public function edit(GalleryAlbum $album): View
    {
        $album->load('items');

        return view('admin.gallery.albums.edit', ['album' => $album]);
    }

    public function update(StoreGalleryAlbumRequest $request, GalleryAlbum $album): RedirectResponse
    {
        $data = $request->safe()->except('cover_image');
        if ($data['title'] !== $album->title) {
            $data['slug'] = $this->uniqueSlug($data['title'], $album->id);
        }
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('cover_image')) {
            if ($album->cover_image_path) {
                Storage::disk('public')->delete($album->cover_image_path);
            }
            $data['cover_image_path'] = $request->file('cover_image')->store('gallery', 'public');
        }

        $album->update($data);

        return redirect()->route('admin.gallery-albums.index')->with('status', 'Álbum actualizado com sucesso.');
    }

    public function destroy(GalleryAlbum $album): RedirectResponse
    {
        foreach ($album->items as $item) {
            if ($item->file_path) {
                Storage::disk('public')->delete($item->file_path);
            }
        }

        if ($album->cover_image_path) {
            Storage::disk('public')->delete($album->cover_image_path);
        }

        $album->delete();

        return redirect()->route('admin.gallery-albums.index')->with('status', 'Álbum removido.');
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (GalleryAlbum::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$base}-".++$i;
        }

        return $slug;
    }
}
