<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PolicyController extends Controller
{
    public function privacy(): View
    {
        return view('public.policy.privacy');
    }

    public function terms(): View
    {
        return view('public.policy.terms');
    }
}
