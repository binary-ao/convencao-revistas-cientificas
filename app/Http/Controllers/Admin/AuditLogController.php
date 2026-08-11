<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function index(Request $request): View
    {
        $logs = AuditLog::query()
            ->with('user')
            ->when($request->filled('action'), fn ($q) => $q->where('action', 'like', '%'.$request->string('action').'%'))
            ->when($request->filled('user_id'), fn ($q) => $q->where('user_id', $request->integer('user_id')))
            ->orderByDesc('id')
            ->paginate(30)
            ->withQueryString();

        return view('admin.logs.index', [
            'logs' => $logs,
            'users' => \App\Models\User::orderBy('name')->get(),
        ]);
    }
}
