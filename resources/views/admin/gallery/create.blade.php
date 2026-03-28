@extends('layouts.admin')

@section('title', 'Нов запис — Галерия — Admin')

@section('content')

    {{-- Page heading --}}
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">Нов запис</h1>
            <p class="mt-1 text-sm text-gray-500">Добави снимка или видео в галерията.</p>
        </div>
        <a href="{{ route('admin.gallery.index') }}"
           class="text-sm text-gray-400 hover:text-gray-900 transition-colors">
            ← Назад към галерия
        </a>
    </div>

    <form action="{{ route('admin.gallery.store') }}" method="POST"
          enctype="multipart/form-data" novalidate>
        @csrf
        @include('admin.gallery._form', [
            'submitLabel' => 'Добави запис',
            'cancelUrl'   => route('admin.gallery.index'),
        ])
    </form>

@endsection
