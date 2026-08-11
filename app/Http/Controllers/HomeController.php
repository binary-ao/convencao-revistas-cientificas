<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\HeroSlide;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('public.home', [
            'event' => Event::current(),
            'heroSlides' => HeroSlide::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }
}
