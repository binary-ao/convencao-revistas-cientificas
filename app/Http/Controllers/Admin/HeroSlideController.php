<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreHeroSlideRequest;
use App\Http\Requests\Admin\UpdateHeroSlideRequest;
use App\Models\Event;
use App\Models\HeroSlide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HeroSlideController extends Controller
{
    public function index(): View
    {
        return view('admin.hero-slides.index', [
            'slides' => HeroSlide::orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.hero-slides.create');
    }

    public function store(StoreHeroSlideRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('image');
        $data['event_id'] = Event::current()?->id;
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('hero-slides', 'public');
        }

        HeroSlide::create($data);

        return redirect()->route('admin.hero-slides.index')->with('status', 'Destaque criado com sucesso.');
    }

    public function edit(HeroSlide $heroSlide): View
    {
        return view('admin.hero-slides.edit', ['slide' => $heroSlide]);
    }

    public function update(UpdateHeroSlideRequest $request, HeroSlide $heroSlide): RedirectResponse
    {
        $data = $request->safe()->except(['image', 'remove_image']);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            if ($heroSlide->image_path) {
                Storage::disk('public')->delete($heroSlide->image_path);
            }
            $data['image_path'] = $request->file('image')->store('hero-slides', 'public');
        } elseif ($request->boolean('remove_image') && $heroSlide->image_path) {
            Storage::disk('public')->delete($heroSlide->image_path);
            $data['image_path'] = null;
        }

        $heroSlide->update($data);

        return redirect()->route('admin.hero-slides.index')->with('status', 'Destaque actualizado com sucesso.');
    }

    public function destroy(HeroSlide $heroSlide): RedirectResponse
    {
        if ($heroSlide->image_path) {
            Storage::disk('public')->delete($heroSlide->image_path);
        }

        $heroSlide->delete();

        return redirect()->route('admin.hero-slides.index')->with('status', 'Destaque removido.');
    }
}
