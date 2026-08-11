<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        $event = Event::current();

        return view('public.faq', [
            'event' => $event,
            'faqs' => $event->faqs()->where('is_published', true)->get(),
        ]);
    }
}
