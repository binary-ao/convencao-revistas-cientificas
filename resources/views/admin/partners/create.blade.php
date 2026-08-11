@extends('layouts.admin')

@section('title', 'Novo parceiro')

@section('content')
    <h2 class="h5 mb-4">Novo parceiro</h2>
    <div class="bg-white border p-4" style="border-color: var(--color-border);">
        <form method="POST" action="{{ route('admin.partners.store') }}" enctype="multipart/form-data">
            @include('admin.partners._form')
        </form>
    </div>
@endsection
