@extends('layouts.admin')

@section('title', 'Editar orador')

@section('content')

    <h2 class="h5 mb-4">Editar orador</h2>

    <div class="bg-white border p-4" style="border-color: var(--color-border);">
        <form method="POST" action="{{ route('admin.speakers.update', $speaker) }}" enctype="multipart/form-data">
            @include('admin.speakers._form')
        </form>
    </div>

@endsection
