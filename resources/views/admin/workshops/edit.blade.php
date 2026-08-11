@extends('layouts.admin')

@section('title', 'Editar workshop')

@section('content')
    <h2 class="h5 mb-4">Editar workshop</h2>
    <div class="bg-white border p-4" style="border-color: var(--color-border);">
        <form method="POST" action="{{ route('admin.workshops.update', $workshop) }}">
            @include('admin.workshops._form')
        </form>
    </div>
@endsection
