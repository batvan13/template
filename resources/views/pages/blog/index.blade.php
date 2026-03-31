@extends('layouts.app')

@section('title', 'Блог')
@section('description', 'Новини, съвети и полезна информация от нашия екип.')

@section('content')

    <section class="bg-gray-50 py-20">
        <div class="mx-auto max-w-6xl px-4">

            <div class="max-w-2xl">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900">Блог</h1>
                <p class="mt-4 text-lg text-gray-600">
                    Новини, съвети и полезна информация.
                </p>
            </div>

            <div class="mt-12 space-y-10">
                @forelse ($posts as $post)
                    <article class="rounded-xl border border-gray-200 bg-white p-8 shadow-sm">
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                            {{ $post->published_at->format('d.m.Y') }}
                        </p>
                        <h2 class="mt-2 text-xl font-semibold tracking-tight text-gray-900">
                            <a href="{{ route('blog.show', $post->slug) }}"
                               class="hover:text-gray-600 transition-colors">
                                {{ $post->title }}
                            </a>
                        </h2>
                        @if ($post->excerpt)
                            <p class="mt-3 text-base leading-relaxed text-gray-600 whitespace-pre-line">
                                {{ $post->excerpt }}
                            </p>
                        @endif
                        <div class="mt-4">
                            <a href="{{ route('blog.show', $post->slug) }}"
                               class="text-sm font-medium text-gray-900 underline-offset-2 hover:underline">
                                Прочети повече →
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="rounded-xl border border-dashed border-gray-200 bg-white px-8 py-16 text-center">
                        <p class="text-sm font-medium text-gray-900">Все още няма публикации</p>
                        <p class="mt-2 text-sm text-gray-500">Скоро ще добавим съдържание тук.</p>
                        <a href="{{ route('home') }}"
                           class="mt-6 inline-block text-sm font-medium text-gray-900 underline-offset-2 hover:underline">
                            Към началото
                        </a>
                    </div>
                @endforelse
            </div>

            @if ($posts->hasPages())
                <div class="mt-10">
                    {{ $posts->links('pagination::tailwind') }}
                </div>
            @endif

        </div>
    </section>

@endsection
