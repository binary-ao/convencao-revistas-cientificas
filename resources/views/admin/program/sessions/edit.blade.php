@extends('layouts.admin')

@section('title', 'Editar sessão')

@section('content')
    <h2 class="h5 mb-4">Editar sessão</h2>
    <div class="bg-white border p-4" style="border-color: var(--color-border);">
        <form method="POST" action="{{ route('admin.program-sessions.update', $session) }}">
            @include('admin.program.sessions._form')
        </form>
    </div>
@endsection
