<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\View\View;

class WorkshopController extends Controller
{
    public function index(): View
    {
        $event = Event::current();

        return view('public.workshops', [
            'event' => $event,
            'workshops' => $event->workshops()->with('trainer')->where('is_active', true)->get(),
        ]);
    }
}
