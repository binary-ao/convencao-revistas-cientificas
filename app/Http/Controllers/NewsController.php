<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        return view('public.news.index', [
            'newsItems' => News::published()->orderByDesc('published_at')->orderByDesc('id')->paginate(9),
        ]);
    }

    public function show(News $news): View
    {
        abort_unless(
            $news->status === 'publicado' || ($news->status === 'agendado' && $news->published_at <= now()),
            404
        );

        return view('public.news.show', [
            'news' => $news,
            'related' => News::published()->where('id', '!=', $news->id)->orderByDesc('published_at')->limit(3)->get(),
        ]);
    }
}
