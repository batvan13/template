@extends('layouts.app')

@section('title', $service->title)
@section('description', $seoDescription !== '' ? $seoDescription : setting('site_tagline', ''))

@section('content')

    {{-- Secondary navigation --}}
    <div class="border-b border-gray-100 bg-gray-50/80">
        <div class="mx-auto max-w-6xl px-4 py-4">
            <nav aria-label="Услуги">
                <a href="{{ route('services') }}"
                   class="text-sm font-medium text-gray-600 underline-offset-2 hover:text-gray-900 hover:underline">
                    ← Всички услуги
                </a>
            </nav>
        </div>
    </div>

    <article class="py-16">
        <div class="mx-auto max-w-3xl px-4">

            <header class="border-b border-gray-100 pb-10">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900">
                    {{ $service->title }}
                </h1>

                @if($service->short_description)
                    <p class="mt-6 text-lg leading-relaxed text-gray-600">
                        {{ $service->short_description }}
                    </p>
                @endif
            </header>

            @if($service->full_description)
                <section class="py-10" aria-labelledby="service-full-desc-heading">
                    <h2 id="service-full-desc-heading" class="text-xl font-semibold tracking-tight text-gray-900">
                        Описание
                    </h2>
                    <div class="mt-4 text-base leading-relaxed text-gray-700">
                        <p class="whitespace-pre-line">{{ $service->full_description }}</p>
                    </div>
                </section>
            @elseif(! $service->short_description)
                <p class="py-10 text-sm text-gray-500">
                    Подробно описание за тази услуга предстои да бъде добавено.
                </p>
            @endif

            @if(count($faqItems) > 0)
                <section class="border-t border-gray-100 py-10" aria-labelledby="service-faq-heading">
                    <h2 id="service-faq-heading" class="text-xl font-semibold tracking-tight text-gray-900">
                        Често задавани въпроси
                    </h2>
                    <div class="mt-6 space-y-8">
                        @foreach($faqItems as $item)
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">{{ $item['question'] }}</h3>
                                <p class="mt-2 text-base leading-relaxed text-gray-700 whitespace-pre-line">{{ $item['answer'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <section class="border-t border-gray-100 py-10" aria-labelledby="service-cta-heading">
                <h2 id="service-cta-heading" class="text-xl font-semibold tracking-tight text-gray-900">
                    Запитване
                </h2>
                <p class="mt-3 text-sm text-gray-600">
                    Свържете се с нас за повече информация или оферта за тази услуга.
                </p>
                <div class="mt-6 flex flex-wrap gap-4">
                    @include('partials.action-buttons')
                    <a href="{{ route('contacts') }}"
                       class="inline-flex items-center rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-800 transition-colors hover:border-gray-900 hover:text-gray-900">
                        Форма за контакт
                    </a>
                </div>
            </section>

        </div>
    </article>

@endsection

@push('scripts')
@php
    $siteName = setting('site_name') ?: config('app.name', 'Website');
    $jsonDesc = trim(preg_replace('/\s+/', ' ', strip_tags(
        $service->short_description ?: $service->full_description ?: $service->title
    )));
    $jsonDesc = \Illuminate\Support\Str::limit($jsonDesc, 500, '');
    $serviceLd = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => $service->title,
        'description' => $jsonDesc !== '' ? $jsonDesc : null,
        'url' => route('services.show', $service->slug),
        'provider' => [
            '@type' => 'Organization',
            'name' => $siteName,
            'url' => url('/'),
        ],
    ]);
@endphp
<script type="application/ld+json">{!! json_encode($serviceLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>
@if(count($faqItems) > 0)
@php
    $faqLd = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(static function (array $item) {
            return [
                '@type' => 'Question',
                'name' => $item['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['answer'],
                ],
            ];
        }, $faqItems),
    ];
@endphp
<script type="application/ld+json">{!! json_encode($faqLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>
@endif
@endpush
