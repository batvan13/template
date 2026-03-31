@extends('layouts.admin')

@section('title', 'Блог — Admin')

@section('content')

    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">Блог</h1>
            <p class="mt-1 text-sm text-gray-500">Управлявай публикациите на сайта.</p>
        </div>
        <a href="{{ route('admin.posts.create') }}"
           class="text-sm font-medium px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-700 transition-colors">
            + Нова публикация
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 px-4 py-3 bg-white border border-gray-200 rounded-lg text-sm text-gray-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($posts->isEmpty())

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm px-8 py-16 text-center">
            <p class="text-sm font-medium text-gray-900 mb-1">Няма публикации</p>
            <p class="text-sm text-gray-400 mb-6">Създай първата публикация, за да започнеш.</p>
            <a href="{{ route('admin.posts.create') }}"
               class="inline-block text-sm font-medium px-4 py-2 bg-gray-900 text-white rounded
                      hover:bg-gray-700 transition-colors">
                + Нова публикация
            </a>
        </div>

    @else

        <p class="mb-3 text-xs text-gray-400">
            Общо: {{ $posts->total() }} {{ $posts->total() === 1 ? 'публикация' : 'публикации' }}
        </p>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Заглавие</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Статус</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Публикувана на</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Обновена</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($posts as $post)
                        @php
                            $isLive = $post->is_published
                                && $post->published_at
                                && $post->published_at->lte(now());
                            $isScheduled = $post->is_published
                                && $post->published_at
                                && $post->published_at->isFuture();
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $post->title }}</td>
                            <td class="px-6 py-4 text-gray-500 font-mono text-xs">{{ $post->slug }}</td>
                            <td class="px-6 py-4">
                                @if (! $post->is_published)
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-500">Чернова</span>
                                @elseif ($isScheduled)
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-900">Планирана</span>
                                @elseif ($isLive)
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-medium bg-gray-900 text-white">Публикувана</span>
                                @else
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-500">Чернова</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $post->published_at?->format('d.m.Y H:i') ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $post->updated_at->format('d.m.Y H:i') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.posts.edit', $post) }}"
                                       class="text-xs px-3 py-1.5 rounded border border-gray-200
                                              text-gray-600 hover:border-gray-900 hover:text-gray-900 transition-colors">
                                        Редактирай
                                    </a>
                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST"
                                          onsubmit="return confirm('Изтрий публикация „{{ addslashes($post->title) }}"?\nТова действие е необратимо.')">
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

        @if ($posts->hasPages())
            <div class="mt-4">
                {{ $posts->links('pagination::tailwind') }}
            </div>
        @endif

    @endif

@endsection
