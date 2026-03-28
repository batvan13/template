@extends('layouts.admin')

@section('title', 'Смяна на парола')

@section('content')

<div class="mb-6">
    <h1 class="text-xl font-semibold text-gray-900">Смяна на парола</h1>
    <p class="mt-1 text-sm text-gray-500">Въведете текущата и новата парола.</p>
</div>

{{-- Success --}}
@if (session('success'))
    <div class="mb-6 rounded border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
        {{ session('success') }}
    </div>
@endif

{{-- Errors --}}
@if ($errors->any())
    <div class="mb-6 rounded border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="max-w-md">
    <form action="{{ route('admin.password.update') }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
                Текуща парола
            </label>
            <input
                type="password"
                id="current_password"
                name="current_password"
                autocomplete="current-password"
                class="w-full rounded border border-gray-300 px-3 py-2 text-sm shadow-sm
                       focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500
                       @error('current_password') border-red-400 @enderror"
            >
            @error('current_password')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">
                Нова парола <span class="text-gray-400 font-normal">(мин. 8 символа)</span>
            </label>
            <input
                type="password"
                id="new_password"
                name="new_password"
                autocomplete="new-password"
                class="w-full rounded border border-gray-300 px-3 py-2 text-sm shadow-sm
                       focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500
                       @error('new_password') border-red-400 @enderror"
            >
            @error('new_password')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                Потвърди нова парола
            </label>
            <input
                type="password"
                id="new_password_confirmation"
                name="new_password_confirmation"
                autocomplete="new-password"
                class="w-full rounded border border-gray-300 px-3 py-2 text-sm shadow-sm
                       focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500"
            >
        </div>

        <div class="flex items-center gap-3 pt-1">
            <button type="submit"
                    class="rounded bg-gray-900 px-4 py-2 text-sm font-medium text-white
                           hover:bg-gray-700 transition-colors">
                Смени паролата
            </button>
            <a href="{{ route('admin.dashboard') }}"
               class="text-sm text-gray-500 hover:text-gray-900 transition-colors">
                Отказ
            </a>
        </div>

    </form>
</div>

@endsection
