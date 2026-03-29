@if (count($homeFaqItems) > 0)
    <section class="border-t border-gray-100 bg-white py-16">
        <div class="mx-auto max-w-6xl px-4">
            <div class="max-w-2xl">
                @php
                    $blockTitle = trim((string) ($homeFaqSection?->title ?? ''));
                @endphp
                @if ($blockTitle !== '')
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">
                        {{ $blockTitle }}
                    </h2>
                @endif

                <div
                    id="home-faq-accordion"
                    class="@if ($blockTitle !== '') mt-10 @endif divide-y divide-gray-100 border border-gray-100 rounded-lg bg-gray-50/40"
                >
                @foreach ($homeFaqItems as $item)
                    <details class="group px-4 open:bg-white/80">
                        <summary
                            class="cursor-pointer list-none py-3 text-left text-base font-medium text-gray-800
                                   [&::-webkit-details-marker]:hidden
                                   focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-400 focus-visible:ring-offset-2"
                        >
                            {{ $item['question'] }}
                        </summary>
                        <div class="pb-4 pr-2 text-sm leading-relaxed text-gray-600 whitespace-pre-line">
                            {{ $item['answer'] }}
                        </div>
                    </details>
                @endforeach
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            (function () {
                var root = document.getElementById('home-faq-accordion');
                if (!root) return;
                root.addEventListener(
                    'toggle',
                    function (e) {
                        var t = e.target;
                        if (t.tagName !== 'DETAILS' || !root.contains(t) || !t.open) {
                            return;
                        }
                        root.querySelectorAll('details').forEach(function (d) {
                            if (d !== t) {
                                d.removeAttribute('open');
                            }
                        });
                    },
                    true
                );
            })();
        </script>
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
