@extends('layouts.admin')

@section('title', 'Editar notícia')

@section('content')
    <h2 class="h5 mb-4">Editar notícia</h2>
    <div class="bg-white border p-4" style="border-color: var(--color-border);">
        <form method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data">
            @include('admin.news._form')
        </form>
    </div>
@endsection
