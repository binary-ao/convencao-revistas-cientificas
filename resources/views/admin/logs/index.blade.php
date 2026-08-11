@extends('layouts.admin')

@section('title', 'Logs de Auditoria')

@section('content')

    <h2 class="h5 mb-4">Logs de Auditoria</h2>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-sm-3">
            <input type="text" name="action" class="form-control form-control-sm" placeholder="Acção (ex.: registration.created)" value="{{ request('action') }}">
        </div>
        <div class="col-sm-3">
            <select name="user_id" class="form-select form-select-sm">
                <option value="">Todos os utilizadores</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @selected(request('user_id') == $user->id)>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-3">
            <button type="submit" class="btn btn-outline-dark btn-sm">Filtrar</button>
            <a href="{{ route('admin.logs.index') }}" class="btn btn-link btn-sm">Limpar</a>
        </div>
    </form>

    <div class="bg-white border" style="border-color: var(--color-border);">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Acção</th>
                    <th>Descrição</th>
                    <th>Utilizador</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                    <tr>
                        <td class="small text-nowrap">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                        <td><span class="status-badge status-badge--info">{{ $log->action }}</span></td>
                        <td class="small">{{ $log->description }}</td>
                        <td class="small" style="color: var(--color-muted);">{{ $log->user?->name ?? 'Sistema' }}</td>
                        <td class="small font-monospace" style="color: var(--color-muted);">{{ $log->ip_address ?? '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-4" style="color: var(--color-muted);">Nenhum registo de auditoria.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $logs->links() }}</div>

@endsection
