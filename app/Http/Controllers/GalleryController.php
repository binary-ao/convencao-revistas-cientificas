<?php

namespace App\Http\Controllers;

use App\Models\GalleryAlbum;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        return view('public.gallery.index', [
            'albums' => GalleryAlbum::where('is_published', true)->withCount('items')->orderBy('sort_order')->get(),
        ]);
    }

    public function show(GalleryAlbum $album): View
    {
        abort_unless($album->is_published, 404);

        $album->load('items');

        return view('public.gallery.show', ['album' => $album]);
    }
}
