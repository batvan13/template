@extends('layouts.app')

@section('title', 'За нас')
@section('description', 'Научете повече за нас — кои сме, какво правим и защо можете да ни се доверите.')

@section('content')

    {{-- Hero --}}
    <section class="bg-white py-20">
        <div class="mx-auto max-w-6xl px-4">
            <div class="max-w-3xl">

                <h1 class="text-4xl font-bold tracking-tight text-gray-900">
                    {{ $hero?->title ?? 'За нас' }}
                </h1>

                @if($hero?->subtitle)
                    <p class="mt-6 text-lg text-gray-600">
                        {{ $hero->subtitle }}
                    </p>
                @endif

                @if($hero?->content)
                    <p class="mt-4 text-base text-gray-500 leading-relaxed">
                        {{ $hero->content }}
                    </p>
                @endif

                @if($hero?->button_text && $hero?->button_url)
                    <div class="mt-8">
                        <a href="{{ section_url($hero->button_url) }}"
                           class="inline-flex rounded-lg bg-black px-6 py-3 text-sm font-semibold text-white transition hover:bg-gray-800">
                            {{ $hero->button_text }}
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </section>

    {{-- Content block — only rendered if section record exists and has data --}}
    @if($content?->title || $content?->subtitle || $content?->content)
        <section class="bg-gray-50 py-16">
            <div class="mx-auto max-w-6xl px-4">
                <div class="max-w-3xl">

                    @if($content?->title)
                        <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                            {{ $content->title }}
                        </h2>
                    @endif

                    @if($content?->subtitle)
                        <p class="mt-4 text-lg text-gray-600">
                            {{ $content->subtitle }}
                        </p>
                    @endif

                    @if($content?->content)
                        <p class="mt-4 text-base text-gray-500 leading-relaxed">
                            {{ $content->content }}
                        </p>
                    @endif

                </div>
            </div>
        </section>
    @endif

@endsection
