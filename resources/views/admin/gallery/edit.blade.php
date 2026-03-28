@extends('layouts.admin')

@section('title', 'Редактирай запис — Галерия — Admin')

@section('content')

    {{-- Page heading --}}
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">Редактирай запис</h1>
            <p class="mt-1 text-sm text-gray-500">
                {{ $galleryItem->title ?: ('Запис #' . $galleryItem->id) }}
            </p>
        </div>
        <a href="{{ route('admin.gallery.index') }}"
           class="text-sm text-gray-400 hover:text-gray-900 transition-colors">
            ← Назад към галерия
        </a>
    </div>

    <form action="{{ route('admin.gallery.update', $galleryItem) }}" method="POST"
          enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')
        @include('admin.gallery._form', [
            'item'        => $galleryItem,
            'submitLabel' => 'Запази промените',
            'cancelUrl'   => route('admin.gallery.index'),
        ])
    </form>

@endsection
