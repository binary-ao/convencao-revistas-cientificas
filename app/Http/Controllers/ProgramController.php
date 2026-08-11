<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function index(): View
    {
        $event = Event::current();

        $days = $event
            ->days()
            ->with(['sessions' => fn ($q) => $q->with(['workshop', 'course', 'moderator', 'speakers'])])
            ->orderBy('day_number')
            ->get();

        return view('public.program', [
            'event' => $event,
            'days' => $days,
        ]);
    }
}
