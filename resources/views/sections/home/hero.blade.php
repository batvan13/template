@php
    $hero = page_section('home', 'hero');
@endphp

<section class="bg-gray-100 py-20">
    <div class="mx-auto max-w-6xl px-4">
        <div class="max-w-2xl">

            <h1 class="text-5xl font-bold tracking-tight text-gray-900">
                {{ $hero?->title ?? 'Добре дошли' }}
            </h1>

            @if($hero?->subtitle)
                <p class="mt-6 text-lg leading-8 text-gray-600">
                    {{ $hero->subtitle }}
                </p>
            @endif

            @if($hero?->content)
                <p class="mt-4 text-base leading-7 text-gray-500">
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
