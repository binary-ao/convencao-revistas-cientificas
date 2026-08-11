@extends('layouts.admin')

@section('title', 'Novo destaque')

@section('content')

    <h2 class="h5 mb-4">Novo destaque</h2>

    <div class="bg-white border p-4" style="border-color: var(--color-border);">
        <form method="POST" action="{{ route('admin.hero-slides.store') }}" enctype="multipart/form-data">
            @include('admin.hero-slides._form')
        </form>
    </div>

@endsection
