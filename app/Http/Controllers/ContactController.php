<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('public.contact', [
            'event' => Event::current(),
        ]);
    }
}
