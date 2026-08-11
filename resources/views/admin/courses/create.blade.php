@extends('layouts.admin')

@section('title', 'Novo curso')

@section('content')
    <h2 class="h5 mb-4">Novo curso</h2>
    <div class="bg-white border p-4" style="border-color: var(--color-border);">
        <form method="POST" action="{{ route('admin.courses.store') }}">
            @include('admin.courses._form')
        </form>
    </div>
@endsection
