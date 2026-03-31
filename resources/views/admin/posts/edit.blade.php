@extends('layouts.admin')

@section('title', 'Редакция на публикация — Admin')

@section('content')

    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">Редакция на публикация</h1>
            <p class="mt-1 text-sm text-gray-500">{{ $post->title }}</p>
        </div>
        <a href="{{ route('admin.posts.index') }}"
           class="text-sm text-gray-400 hover:text-gray-900 transition-colors">
            ← Назад към блога
        </a>
    </div>

    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')
        @include('admin.posts._form', [
            'post'        => $post,
            'submitLabel' => 'Запази промените',
            'cancelUrl'   => route('admin.posts.index'),
        ])
    </form>

@endsection
