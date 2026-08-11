<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Checkin;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CheckinController extends Controller
{
    public function index(Request $request): View
    {
        $query = trim((string) $request->get('q'));
        $results = collect();

        if ($query !== '') {
            $results = Registration::query()
                ->with(['participant', 'checkin'])
                ->where('status', '!=', 'cancelled')
                ->where(function ($q) use ($query) {
                    $q->where('code', 'like', "%{$query}%")
                        ->orWhereHas('participant', function ($p) use ($query) {
                            $p->where('full_name', 'like', "%{$query}%")
                                ->orWhere('email', 'like', "%{$query}%");
                        });
                })
                ->orderByDesc('id')
                ->limit(20)
                ->get();
        }

        return view('admin.checkin.index', [
            'query' => $query,
            'results' => $results,
            'todayCount' => Checkin::whereDate('checked_in_at', today())->count(),
        ]);
    }

    public function confirm(Registration $registration): RedirectResponse
    {
        if (! $registration->checkin) {
            $registration->checkin()->create([
                'checked_in_at' => now(),
                'checked_in_by_user_id' => Auth::id(),
                'method' => 'manual',
            ]);

            $registration->update(['checkin_status' => 'checked_in']);

            AuditLog::record('checkin.performed', $registration, "Check-in de {$registration->participant->full_name} ({$registration->code})");
        }

        return redirect()->route('admin.checkin.index', ['q' => $registration->code])
            ->with('status', 'Check-in confirmado para '.$registration->participant->full_name.'.');
    }
}
