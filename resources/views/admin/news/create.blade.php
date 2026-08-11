@extends('layouts.admin')

@section('title', 'Nova notícia')

@section('content')
    <h2 class="h5 mb-4">Nova notícia</h2>
    <div class="bg-white border p-4" style="border-color: var(--color-border);">
        <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
            @include('admin.news._form')
        </form>
    </div>
@endsection
