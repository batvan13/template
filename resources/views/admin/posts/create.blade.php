@extends('layouts.admin')

@section('title', 'Нова публикация — Admin')

@section('content')

    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">Нова публикация</h1>
            <p class="mt-1 text-sm text-gray-500">Попълни данните и запази.</p>
        </div>
        <a href="{{ route('admin.posts.index') }}"
           class="text-sm text-gray-400 hover:text-gray-900 transition-colors">
            ← Назад към блога
        </a>
    </div>

    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @include('admin.posts._form', [
            'submitLabel' => 'Запази публикацията',
            'cancelUrl'   => route('admin.posts.index'),
        ])
    </form>

@endsection
