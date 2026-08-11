@extends('layouts.admin')

@section('title', 'Editar parceiro')

@section('content')
    <h2 class="h5 mb-4">Editar parceiro</h2>
    <div class="bg-white border p-4" style="border-color: var(--color-border);">
        <form method="POST" action="{{ route('admin.partners.update', $partner) }}" enctype="multipart/form-data">
            @include('admin.partners._form')
        </form>
    </div>
@endsection
