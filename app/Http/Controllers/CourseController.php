<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(): View
    {
        $event = Event::current();

        return view('public.courses', [
            'event' => $event,
            'courses' => $event->courses()->with('trainer')->where('is_active', true)->get(),
        ]);
    }
}
