<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        return view('public.about', [
            'event' => Event::current(),
        ]);
    }
}
