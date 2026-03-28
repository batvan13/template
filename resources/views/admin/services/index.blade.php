@extends('layouts.admin')

@section('title', 'Услуги — Admin')

@section('content')

    {{-- Page heading --}}
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">Услуги</h1>
            <p class="mt-1 text-sm text-gray-500">Управлявай услугите, показвани на сайта.</p>
        </div>
        <a href="{{ route('admin.services.create') }}"
           class="text-sm font-medium px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-700 transition-colors">
            + Добави услуга
        </a>
    </div>

    {{-- Flash message --}}
    @if (session('success'))
        <div class="mb-6 px-4 py-3 bg-white border border-gray-200 rounded-lg text-sm text-gray-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Empty state --}}
    @if ($services->isEmpty())

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm px-8 py-16 text-center">
            <p class="text-sm font-medium text-gray-900 mb-1">Няма добавени услуги</p>
            <p class="text-sm text-gray-400 mb-6">Създай първата услуга, за да започнеш.</p>
            <a href="{{ route('admin.services.create') }}"
               class="inline-block text-sm font-medium px-4 py-2 bg-gray-900 text-white rounded
                      hover:bg-gray-700 transition-colors">
                + Добави услуга
            </a>
        </div>

    @else

        {{-- Count summary --}}
        <p class="mb-3 text-xs text-gray-400">
            Общо: {{ $services->total() }} {{ $services->total() === 1 ? 'услуга' : 'услуги' }}
        </p>

        {{-- Table card --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Заглавие</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Активна</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Ред</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($services as $service)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-gray-400">{{ $service->id }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $service->title }}</td>
                            <td class="px-6 py-4 text-gray-500 font-mono text-xs">{{ $service->slug }}</td>
                            <td class="px-6 py-4">
                                @if ($service->is_active)
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-medium bg-gray-900 text-white">Да</span>
                                @else
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-500">Не</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $service->sort_order }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.services.edit', $service) }}"
                                       class="text-xs px-3 py-1.5 rounded border border-gray-200
                                              text-gray-600 hover:border-gray-900 hover:text-gray-900 transition-colors">
                                        Редактирай
                                    </a>

                                    {{-- Toggle status --}}
                                    <form action="{{ route('admin.services.toggle', $service) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="text-xs px-3 py-1.5 rounded border transition-colors
                                                       {{ $service->is_active
                                                           ? 'border-gray-200 text-gray-500 hover:border-gray-400 hover:text-gray-700'
                                                           : 'border-gray-200 text-gray-400 hover:border-gray-600 hover:text-gray-600' }}">
                                            {{ $service->is_active ? 'Деактивирай' : 'Активирай' }}
                                        </button>
                                    </form>

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST"
                                          onsubmit="return confirm('Изтрий услуга „{{ addslashes($service->title) }}"?\nТова действие е необратимо.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-xs px-3 py-1.5 rounded border border-transparent
                                                       text-red-400 hover:border-red-300 hover:text-red-600 transition-colors">
                                            Изтрий
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($services->hasPages())
            <div class="mt-4">
                {{ $services->links('pagination::tailwind') }}
            </div>
        @endif

    @endif

@endsection
