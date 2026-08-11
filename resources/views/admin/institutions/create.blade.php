@extends('layouts.admin')

@section('title', 'Nova instituição')

@section('content')
    <h2 class="h5 mb-4">Nova instituição</h2>
    <div class="bg-white border p-4" style="border-color: var(--color-border);">
        <form method="POST" action="{{ route('admin.institutions.store') }}">
            @include('admin.institutions._form')
        </form>
    </div>
@endsection
