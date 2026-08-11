@extends('layouts.admin')

@section('title', 'Novo dia')

@section('content')
    <h2 class="h5 mb-4">Novo dia do programa</h2>
    <div class="bg-white border p-4" style="border-color: var(--color-border);">
        <form method="POST" action="{{ route('admin.program-days.store') }}">
            @include('admin.program.days._form')
        </form>
    </div>
@endsection
