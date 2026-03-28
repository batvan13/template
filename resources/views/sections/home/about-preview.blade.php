@php
    $section = page_section('home', 'about_preview');
@endphp

<section class="bg-white py-16">
    <div class="mx-auto max-w-6xl px-4">
        <div class="max-w-2xl">

            <h2 class="text-3xl font-bold tracking-tight text-gray-900">
                {{ $section?->title ?? 'За нас' }}
            </h2>

            @if($section?->subtitle)
                <p class="mt-4 text-lg text-gray-600">
                    {{ $section->subtitle }}
                </p>
            @endif

            @if($section?->content)
                <p class="mt-3 text-base text-gray-500 leading-relaxed">
                    {{ $section->content }}
                </p>
            @endif

            @if($section?->button_text && $section?->button_url)
                <div class="mt-8">
                    <a href="{{ section_url($section->button_url) }}"
                       class="inline-flex rounded-lg bg-black px-6 py-3 text-sm font-semibold text-white transition hover:bg-gray-800">
                        {{ $section->button_text }}
                    </a>
                </div>
            @endif

        </div>
    </div>
</section>
