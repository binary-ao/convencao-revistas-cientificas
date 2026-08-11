<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Partner;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function index(): View
    {
        $partners = Partner::orderBy('sort_order')->get()->groupBy('category');

        return view('public.partners', [
            'event' => Event::current(),
            'partnersByCategory' => $partners,
            'categoryLabels' => Partner::CATEGORY_LABELS,
        ]);
    }
}
