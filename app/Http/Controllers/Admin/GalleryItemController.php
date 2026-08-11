<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGalleryItemRequest;
use App\Models\GalleryItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class GalleryItemController extends Controller
{
    public function store(StoreGalleryItemRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('file');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('gallery', 'public');
        }

        GalleryItem::create($data);

        return back()->with('status', 'Item adicionado ao álbum.');
    }

    public function destroy(GalleryItem $item): RedirectResponse
    {
        $album = $item->album;

        if ($item->file_path) {
            Storage::disk('public')->delete($item->file_path);
        }

        $item->delete();

        return redirect()->route('admin.gallery-albums.edit', $album)->with('status', 'Item removido.');
    }
}
