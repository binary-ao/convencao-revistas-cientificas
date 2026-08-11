<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDocumentRequest;
use App\Http\Requests\Admin\UpdateDocumentRequest;
use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DocumentController extends Controller
{
    public function index(): View
    {
        return view('admin.documents.index', [
            'documents' => Document::orderBy('category')->orderBy('sort_order')->get(),
            'categoryLabels' => Document::CATEGORY_LABELS,
        ]);
    }

    public function create(): View
    {
        return view('admin.documents.create', ['categoryLabels' => Document::CATEGORY_LABELS]);
    }

    public function store(StoreDocumentRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('file');
        $data['uploaded_by_user_id'] = Auth::id();
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $file = $request->file('file');
        $data['file_path'] = $file->store('documents', 'public');
        $data['original_filename'] = $file->getClientOriginalName();

        Document::create($data);

        return redirect()->route('admin.documents.index')->with('status', 'Documento criado com sucesso.');
    }

    public function edit(Document $document): View
    {
        return view('admin.documents.edit', ['document' => $document, 'categoryLabels' => Document::CATEGORY_LABELS]);
    }

    public function update(UpdateDocumentRequest $request, Document $document): RedirectResponse
    {
        $data = $request->safe()->except('file');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('file')) {
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }
            $file = $request->file('file');
            $data['file_path'] = $file->store('documents', 'public');
            $data['original_filename'] = $file->getClientOriginalName();
        }

        $document->update($data);

        return redirect()->route('admin.documents.index')->with('status', 'Documento actualizado com sucesso.');
    }

    public function destroy(Document $document): RedirectResponse
    {
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('admin.documents.index')->with('status', 'Documento removido.');
    }
}
