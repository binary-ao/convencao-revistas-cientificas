<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\View\View;

class DocumentController extends Controller
{
    public function index(): View
    {
        $documents = Document::where('status', 'published')
            ->orderBy('category')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category');

        return view('public.documents', [
            'documentsByCategory' => $documents,
            'categoryLabels' => Document::CATEGORY_LABELS,
        ]);
    }
}
