@extends('layouts.admin')

@section('title', 'Dashboard — Admin')

@section('content')

    {{-- Page heading --}}
    <div class="mb-8">
        <h1 class="text-xl font-semibold text-gray-900">Dashboard</h1>
        <p class="mt-1 text-sm text-gray-500">Преглед на съдържанието и бързи действия.</p>
    </div>

    {{-- Summary cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">

        <div class="bg-white border border-gray-200 rounded-xl px-6 py-5">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Услуги</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalServices }}</p>
            <p class="mt-1 text-xs text-gray-400">общо в системата</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl px-6 py-5">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Активни</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $activeServices }}</p>
            <p class="mt-1 text-xs text-gray-400">видими на сайта</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl px-6 py-5">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Секции</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalSections }}</p>
            <p class="mt-1 text-xs text-gray-400">редактируеми блокове</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl px-6 py-5">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Галерия</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalGallery }}</p>
            <p class="mt-1 text-xs text-gray-400">{{ $activeGallery }} активни</p>
        </div>

    </div>

    {{-- Quick actions --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm divide-y divide-gray-100">

        <div class="px-6 py-4">
            <p class="text-xs font-bold tracking-widest uppercase text-gray-400">Бързи действия</p>
        </div>

        <a href="{{ route('admin.services.index') }}"
           class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition-colors group">
            <div>
                <p class="text-sm font-medium text-gray-900">Управление на услуги</p>
                <p class="text-xs text-gray-400 mt-0.5">
                    {{ $totalServices }} {{ $totalServices === 1 ? 'услуга' : 'услуги' }},
                    {{ $activeServices }} активни
                </p>
            </div>
            <span class="text-gray-300 group-hover:text-gray-600 transition-colors text-lg leading-none">→</span>
        </a>

        <a href="{{ route('admin.gallery.index') }}"
           class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition-colors group">
            <div>
                <p class="text-sm font-medium text-gray-900">Управление на галерия</p>
                <p class="text-xs text-gray-400 mt-0.5">
                    {{ $totalGallery }} {{ $totalGallery === 1 ? 'запис' : 'записа' }},
                    {{ $activeGallery }} активни
                </p>
            </div>
            <span class="text-gray-300 group-hover:text-gray-600 transition-colors text-lg leading-none">→</span>
        </a>

        <a href="{{ route('admin.sections.index') }}"
           class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition-colors group">
            <div>
                <p class="text-sm font-medium text-gray-900">Управление на секции</p>
                <p class="text-xs text-gray-400 mt-0.5">Редактирай съдържанието на страниците</p>
            </div>
            <span class="text-gray-300 group-hover:text-gray-600 transition-colors text-lg leading-none">→</span>
        </a>

        @if ($homeFaqSection)
            <a href="{{ route('admin.sections.edit', $homeFaqSection) }}"
               class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition-colors group">
                <div>
                    <p class="text-sm font-medium text-gray-900">Начална страница — ЧЗВ</p>
                    <p class="text-xs text-gray-400 mt-0.5">Редактирай FAQ блока на началната страница</p>
                </div>
                <span class="text-gray-300 group-hover:text-gray-600 transition-colors text-lg leading-none">→</span>
            </a>
        @endif

        <a href="{{ route('admin.settings.edit') }}"
           class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition-colors group">
            <div>
                <p class="text-sm font-medium text-gray-900">Настройки на сайта</p>
                <p class="text-xs text-gray-400 mt-0.5">Контактна информация, социални мрежи и др.</p>
            </div>
            <span class="text-gray-300 group-hover:text-gray-600 transition-colors text-lg leading-none">→</span>
        </a>

    </div>

@endsection
