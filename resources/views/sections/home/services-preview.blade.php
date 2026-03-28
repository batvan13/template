@php
    $section = page_section('home', 'services_preview');
@endphp

<section class="bg-white py-20">
    <div class="mx-auto max-w-6xl px-4">

        {{-- Section heading --}}
        <div class="max-w-2xl">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900">
                {{ $section?->title ?? 'Нашите услуги' }}
            </h2>

            @if($section?->subtitle)
                <p class="mt-4 text-lg text-gray-600">
                    {{ $section->subtitle }}
                </p>
            @endif

            @if($section?->content)
                <p class="mt-3 text-base text-gray-500">
                    {{ $section->content }}
                </p>
            @endif
        </div>

        {{-- Services grid --}}
        @if($homeServices->isEmpty())

            <p class="mt-12 text-sm text-gray-400">Все още няма добавени услуги.</p>

        @else

            <div class="mt-12 grid gap-6 sm:grid-cols-2 md:grid-cols-3">
                @foreach($homeServices as $service)
                    <div class="rounded-lg border border-gray-200 p-6">

                        @if($service->icon)
                            <p class="mb-3 text-xs font-mono text-gray-400">{{ $service->icon }}</p>
                        @endif

                        <h3 class="text-base font-semibold text-gray-900">
                            {{ $service->title }}
                        </h3>

                        @if($service->short_description)
                            <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                                {{ $service->short_description }}
                            </p>
                        @endif

                    </div>
                @endforeach
            </div>

        @endif

        {{-- CTA button — only if both text and url are set --}}
        @if($section?->button_text && $section?->button_url)
            <div class="mt-10">
                <a href="{{ section_url($section->button_url) }}"
                   class="inline-flex rounded-lg bg-black px-6 py-3 text-sm font-semibold text-white transition hover:bg-gray-800">
                    {{ $section->button_text }}
                </a>
            </div>
        @endif

    </div>
</section>
