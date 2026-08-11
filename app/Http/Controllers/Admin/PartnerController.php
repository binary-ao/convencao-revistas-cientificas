<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePartnerRequest;
use App\Http\Requests\Admin\UpdatePartnerRequest;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function index(): View
    {
        return view('admin.partners.index', [
            'partners' => Partner::orderBy('category')->orderBy('sort_order')->get(),
            'categoryLabels' => Partner::CATEGORY_LABELS,
        ]);
    }

    public function create(): View
    {
        return view('admin.partners.create', ['categoryLabels' => Partner::CATEGORY_LABELS]);
    }

    public function store(StorePartnerRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('logo');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('partners', 'public');
        }

        Partner::create($data);

        return redirect()->route('admin.partners.index')->with('status', 'Parceiro criado com sucesso.');
    }

    public function edit(Partner $partner): View
    {
        return view('admin.partners.edit', ['partner' => $partner, 'categoryLabels' => Partner::CATEGORY_LABELS]);
    }

    public function update(UpdatePartnerRequest $request, Partner $partner): RedirectResponse
    {
        $data = $request->safe()->except(['logo', 'remove_logo']);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('logo')) {
            if ($partner->logo_path) {
                Storage::disk('public')->delete($partner->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('partners', 'public');
        } elseif ($request->boolean('remove_logo') && $partner->logo_path) {
            Storage::disk('public')->delete($partner->logo_path);
            $data['logo_path'] = null;
        }

        $partner->update($data);

        return redirect()->route('admin.partners.index')->with('status', 'Parceiro actualizado com sucesso.');
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        if ($partner->logo_path) {
            Storage::disk('public')->delete($partner->logo_path);
        }

        $partner->delete();

        return redirect()->route('admin.partners.index')->with('status', 'Parceiro removido.');
    }
}
