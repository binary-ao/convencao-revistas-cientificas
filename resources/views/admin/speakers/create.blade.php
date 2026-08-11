@extends('layouts.admin')

@section('title', 'Novo orador')

@section('content')

    <h2 class="h5 mb-4">Novo orador</h2>

    <div class="bg-white border p-4" style="border-color: var(--color-border);">
        <form method="POST" action="{{ route('admin.speakers.store') }}" enctype="multipart/form-data">
            @include('admin.speakers._form')
        </form>
    </div>

@endsection
