<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreInstitutionRequest;
use App\Http\Requests\Admin\UpdateInstitutionRequest;
use App\Models\Institution;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InstitutionController extends Controller
{
    public function index(): View
    {
        return view('admin.institutions.index', [
            'institutions' => Institution::orderBy('name')->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.institutions.create');
    }

    public function store(StoreInstitutionRequest $request): RedirectResponse
    {
        Institution::create($request->validated());

        return redirect()->route('admin.institutions.index')->with('status', 'Instituição criada com sucesso.');
    }

    public function edit(Institution $institution): View
    {
        return view('admin.institutions.edit', ['institution' => $institution]);
    }

    public function update(UpdateInstitutionRequest $request, Institution $institution): RedirectResponse
    {
        $institution->update($request->validated());

        return redirect()->route('admin.institutions.index')->with('status', 'Instituição actualizada com sucesso.');
    }

    public function destroy(Institution $institution): RedirectResponse
    {
        $institution->delete();

        return redirect()->route('admin.institutions.index')->with('status', 'Instituição removida.');
    }
}
