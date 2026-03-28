@extends('layouts.app')

@section('title', 'Галерия')
@section('description', 'Разгледайте снимки от нашите проекти и свършена работа.')

@section('content')

{{-- ── Hero ──────────────────────────────────────────────────── --}}
<section class="py-20">
    <div class="mx-auto max-w-6xl px-4">

        <h1 class="text-4xl font-bold tracking-tight text-gray-900">
            {{ $hero?->title ?? 'Галерия' }}
        </h1>

        @if($hero?->subtitle)
            <p class="mt-4 max-w-2xl text-lg text-gray-600">
                {{ $hero->subtitle }}
            </p>
        @endif

    </div>
</section>

{{-- ── Gallery ──────────────────────────────────────────────── --}}
<section class="pb-24">
    <div class="mx-auto max-w-6xl px-4">

        @php
            $hasRenderable = $items->contains(
                fn($item) => $item->isImage() ? (bool) $item->image_path : (bool) $item->video_url
            );
        @endphp

        @if(! $hasRenderable)

            <div class="rounded-xl border border-gray-100 bg-gray-50 px-8 py-16 text-center">
                <p class="text-sm font-medium text-gray-500">Все още няма добавени снимки или видеа.</p>
            </div>

        @else

            <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3">

                @foreach($items as $item)

                    @if($item->isImage())

                        {{-- Image card --}}
                        @if($item->image_path)
                            <a
                                href="{{ asset('storage/' . $item->image_path) }}"
                                data-fancybox="gallery"
                                @if($item->title) data-caption="{{ $item->title }}" @endif
                                class="aspect-square block overflow-hidden rounded-xl border border-gray-100 bg-gray-50 cursor-zoom-in"
                            >
                                <img
                                    src="{{ asset('storage/' . $item->image_path) }}"
                                    alt="{{ $item->title ?? '' }}"
                                    class="h-full w-full object-cover transition-opacity hover:opacity-90"
                                    loading="lazy"
                                >
                            </a>
                        @endif

                    @elseif($item->video_url)

                        {{-- Video card --}}
                        <a href="{{ $item->video_url }}"
                           target="_blank"
                           rel="noopener"
                           class="aspect-square flex flex-col items-center justify-center gap-3
                                  rounded-xl border border-gray-200 bg-gray-50 p-6 text-center
                                  transition-colors hover:border-gray-400">

                            <svg class="h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>

                            @if($item->title)
                                <span class="text-sm font-medium text-gray-700">{{ $item->title }}</span>
                            @endif

                            <span class="text-xs text-gray-400">Гледай видеото &rarr;</span>

                        </a>

                    @endif

                @endforeach

            </div>

        @endif

    </div>
</section>

{{-- ── Contact CTA — only shown when gallery has items ──────── --}}
@if($items->isNotEmpty())
<section class="bg-gray-50 py-16">
    <div class="mx-auto max-w-6xl px-4">

        <p class="text-lg font-semibold text-gray-900">Харесва ви това, което виждате?</p>

        <div class="mt-6">
            @include('partials.action-buttons')
        </div>

        <p class="mt-4 text-sm text-gray-400">
            или
            <a href="{{ route('contacts') }}"
               class="underline underline-offset-2 hover:text-gray-700 transition-colors">
                изпратете запитване
            </a>
        </p>

    </div>
</section>
@endif

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5/dist/fancybox/fancybox.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5/dist/fancybox/fancybox.umd.js"></script>
<script>
Fancybox.bind('[data-fancybox="gallery"]', {
    Hash: false,
    Thumbs: false,
    Slideshow: false,
    Toolbar: {
        display: {
            left:   ['infobar'],
            middle: [],
            right:  ['zoom', 'close'],
        },
    },
});
</script>
@endpush
