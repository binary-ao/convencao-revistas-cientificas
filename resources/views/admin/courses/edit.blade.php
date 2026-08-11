@extends('layouts.admin')

@section('title', 'Editar curso')

@section('content')
    <h2 class="h5 mb-4">Editar curso</h2>
    <div class="bg-white border p-4" style="border-color: var(--color-border);">
        <form method="POST" action="{{ route('admin.courses.update', $course) }}">
            @include('admin.courses._form')
        </form>
    </div>
@endsection
