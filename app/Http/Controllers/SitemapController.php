<?php

namespace App\Http\Controllers;

use App\Models\GalleryAlbum;
use App\Models\News;
use App\Models\Speaker;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $staticRoutes = [
            ['route' => 'home', 'priority' => '1.0'],
            ['route' => 'about', 'priority' => '0.8'],
            ['route' => 'program', 'priority' => '0.9'],
            ['route' => 'speakers.index', 'priority' => '0.7'],
            ['route' => 'workshops.index', 'priority' => '0.7'],
            ['route' => 'courses.index', 'priority' => '0.7'],
            ['route' => 'partners.index', 'priority' => '0.5'],
            ['route' => 'news.index', 'priority' => '0.6'],
            ['route' => 'documents.index', 'priority' => '0.5'],
            ['route' => 'gallery.index', 'priority' => '0.4'],
            ['route' => 'faq', 'priority' => '0.5'],
            ['route' => 'contacts', 'priority' => '0.4'],
            ['route' => 'registration.create', 'priority' => '0.9'],
            ['route' => 'registration.lookup', 'priority' => '0.3'],
            ['route' => 'certificate.validate', 'priority' => '0.3'],
            ['route' => 'privacy', 'priority' => '0.2'],
            ['route' => 'terms', 'priority' => '0.2'],
        ];

        $urls = collect($staticRoutes)->map(fn ($item) => [
            'loc' => route($item['route']),
            'priority' => $item['priority'],
            'lastmod' => null,
        ]);

        $urls = $urls
            ->concat(Speaker::where('is_published', true)->get()->map(fn (Speaker $s) => [
                'loc' => route('speakers.show', $s),
                'priority' => '0.6',
                'lastmod' => $s->updated_at->toAtomString(),
            ]))
            ->concat(News::published()->get()->map(fn (News $n) => [
                'loc' => route('news.show', $n),
                'priority' => '0.6',
                'lastmod' => $n->updated_at->toAtomString(),
            ]))
            ->concat(GalleryAlbum::where('is_published', true)->get()->map(fn (GalleryAlbum $a) => [
                'loc' => route('gallery.show', $a),
                'priority' => '0.4',
                'lastmod' => $a->updated_at->toAtomString(),
            ]));

        $xml = view('sitemap', ['urls' => $urls])->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
