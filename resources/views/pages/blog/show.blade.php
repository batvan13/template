@extends('layouts.app')

@section('title', $post->title)
@section('description', $seoDescription)

@section('content')

    <div class="border-b border-gray-100 bg-gray-50/80">
        <div class="mx-auto max-w-6xl px-4 py-4">
            <nav aria-label="Блог">
                <a href="{{ route('blog') }}"
                   class="text-sm font-medium text-gray-600 underline-offset-2 hover:text-gray-900 hover:underline">
                    ← Всички публикации
                </a>
            </nav>
        </div>
    </div>

    <article class="py-16">
        <div class="mx-auto max-w-3xl px-4">

            <header class="border-b border-gray-100 pb-10">
                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                    {{ $post->published_at->format('d.m.Y H:i') }}
                </p>
                <h1 class="mt-3 text-4xl font-bold tracking-tight text-gray-900">
                    {{ $post->title }}
                </h1>
                @if ($post->excerpt)
                    <p class="mt-6 text-lg leading-relaxed text-gray-600 whitespace-pre-line">
                        {{ $post->excerpt }}
                    </p>
                @endif
            </header>

            @if ($post->featured_image)
                <div class="py-10">
                    <img src="{{ asset('storage/'.$post->featured_image) }}"
                         alt="{{ $post->title }}"
                         class="w-full rounded-xl border border-gray-100 object-cover max-h-[28rem]">
                </div>
            @endif

            <div class="py-6 text-base leading-relaxed text-gray-700">
                <p class="whitespace-pre-line">{{ $post->content }}</p>
            </div>

        </div>
    </article>

@endsection

@push('scripts')
@php
    $siteName = setting('site_name') ?: config('app.name', 'Website');
    $jsonDesc = trim(preg_replace('/\s+/', ' ', strip_tags(
        $post->excerpt ?: $post->content ?: $post->title
    )));
    $jsonDesc = \Illuminate\Support\Str::limit($jsonDesc, 500, '');
    $blogLd = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'BlogPosting',
        'headline' => $post->title,
        'description' => $jsonDesc !== '' ? $jsonDesc : null,
        'datePublished' => $post->published_at?->toIso8601String(),
        'url' => route('blog.show', $post->slug),
        'image' => $seoOgImage,
        'publisher' => [
            '@type' => 'Organization',
            'name' => $siteName,
            'url' => url('/'),
        ],
    ]);
@endphp
<script type="application/ld+json">{!! json_encode($blogLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>
@endpush
