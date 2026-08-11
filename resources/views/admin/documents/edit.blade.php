@extends('layouts.admin')

@section('title', 'Editar documento')

@section('content')
    <h2 class="h5 mb-4">Editar documento</h2>
    <div class="bg-white border p-4" style="border-color: var(--color-border);">
        <form method="POST" action="{{ route('admin.documents.update', $document) }}" enctype="multipart/form-data">
            @include('admin.documents._form')
        </form>
    </div>
@endsection
