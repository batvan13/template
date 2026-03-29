@if (count($homeFaqItems) > 0)
    <section class="border-t border-gray-100 bg-white py-16">
        <div class="mx-auto max-w-3xl px-4">
            @php
                $blockTitle = trim((string) ($homeFaqSection?->title ?? ''));
            @endphp
            @if ($blockTitle !== '')
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">
                    {{ $blockTitle }}
                </h2>
            @endif

            <div class="@if($blockTitle !== '') mt-10 @endif space-y-8">
                @foreach ($homeFaqItems as $item)
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">{{ $item['question'] }}</h3>
                        <p class="mt-2 text-base leading-relaxed text-gray-700 whitespace-pre-line">{{ $item['answer'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @push('scripts')
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
                }, $homeFaqItems),
            ];
        @endphp
        <script type="application/ld+json">{!! json_encode($faqLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>
    @endpush
@endif
