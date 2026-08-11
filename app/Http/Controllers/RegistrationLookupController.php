<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistrationLookupController extends Controller
{
    public function show(): View
    {
        return view('public.registration.lookup', ['registration' => null, 'notFound' => false]);
    }

    public function lookup(Request $request): View
    {
        $request->validate([
            'code' => ['required', 'string'],
            'email' => ['required', 'email'],
        ]);

        $registration = Registration::where('code', $request->string('code')->trim())
            ->whereHas('participant', fn ($q) => $q->where('email', $request->string('email')->trim()))
            ->with(['participant', 'workshops', 'courses'])
            ->first();

        return view('public.registration.lookup', [
            'registration' => $registration,
            'notFound' => $registration === null,
        ]);
    }
}
