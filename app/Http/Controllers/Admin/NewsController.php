<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNewsRequest;
use App\Http\Requests\Admin\UpdateNewsRequest;
use App\Models\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        return view('admin.news.index', [
            'newsItems' => News::with('author')->orderByDesc('id')->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.news.create');
    }

    public function store(StoreNewsRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('cover_image');
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['author_id'] = Auth::id();

        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('news', 'public');
        }

        News::create($data);

        return redirect()->route('admin.news.index')->with('status', 'Notícia criada com sucesso.');
    }

    public function edit(News $news): View
    {
        return view('admin.news.edit', ['news' => $news]);
    }

    public function update(UpdateNewsRequest $request, News $news): RedirectResponse
    {
        $data = $request->safe()->except(['cover_image', 'remove_cover_image']);
        if ($data['title'] !== $news->title) {
            $data['slug'] = $this->uniqueSlug($data['title'], $news->id);
        }

        if ($request->hasFile('cover_image')) {
            if ($news->cover_image_path) {
                Storage::disk('public')->delete($news->cover_image_path);
            }
            $data['cover_image_path'] = $request->file('cover_image')->store('news', 'public');
        } elseif ($request->boolean('remove_cover_image') && $news->cover_image_path) {
            Storage::disk('public')->delete($news->cover_image_path);
            $data['cover_image_path'] = null;
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('status', 'Notícia actualizada com sucesso.');
    }

    public function destroy(News $news): RedirectResponse
    {
        if ($news->cover_image_path) {
            Storage::disk('public')->delete($news->cover_image_path);
        }

        $news->delete();

        return redirect()->route('admin.news.index')->with('status', 'Notícia removida.');
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (News::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$base}-".++$i;
        }

        return $slug;
    }
}
