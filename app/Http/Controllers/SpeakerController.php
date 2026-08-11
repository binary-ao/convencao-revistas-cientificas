<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Speaker;
use Illuminate\View\View;

class SpeakerController extends Controller
{
    public function index(): View
    {
        return view('public.speakers.index', [
            'event' => Event::current(),
            'speakers' => Speaker::where('is_published', true)
                ->with('institution')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function show(Speaker $speaker): View
    {
        $speaker->load(['institution', 'sessions.eventDay']);

        return view('public.speakers.show', [
            'event' => Event::current(),
            'speaker' => $speaker,
        ]);
    }
}
