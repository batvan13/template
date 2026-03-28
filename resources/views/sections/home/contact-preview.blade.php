@php
    $section  = page_section('home', 'contact_preview');

    $email    = setting('contact_email');
    $phone    = setting('contact_phone');
    $address  = setting('address');
    $mapsUrl  = setting('google_maps_url');

    $tel = $phone ? ('tel:' . preg_replace('/[^\d+]/', '', $phone)) : null;
    $facebook  = setting('facebook_url');
    $instagram = setting('instagram_url');
    $youtube   = setting('youtube_url');

    $hasActions = $phone || $email || $mapsUrl;
    $hasSocial  = $facebook || $instagram || $youtube;
@endphp

<section class="py-16 bg-gray-50">
    <div class="mx-auto max-w-6xl px-4">
        <div class="grid gap-12 md:grid-cols-2 items-start">

            {{-- Left: section text + optional CMS button --}}
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">
                    {{ $section?->title ?? 'Контакти' }}
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

            {{-- Right: action buttons + supporting info --}}
            <div class="space-y-6">

                {{-- Primary actions — or guaranteed fallback if nothing configured --}}
                @if($hasActions)
                    @include('partials.action-buttons')
                @else
                    <a href="{{ route('contacts') }}"
                       class="inline-flex rounded-lg bg-black px-6 py-3 text-sm font-semibold text-white transition hover:bg-gray-800">
                        Свържете се с нас
                    </a>
                @endif

                {{-- Address: informational only, not covered by action-buttons --}}
                @if($address)
                    <p class="text-sm text-gray-500 whitespace-pre-line">{{ $address }}</p>
                @endif

                {{-- Social links --}}
                @if($hasSocial)
                    <div class="flex gap-4 text-sm text-gray-500">
                        @if($facebook)
                            <a href="{{ $facebook }}" target="_blank" rel="noopener"
                               class="hover:text-gray-900 transition-colors">Facebook</a>
                        @endif
                        @if($instagram)
                            <a href="{{ $instagram }}" target="_blank" rel="noopener"
                               class="hover:text-gray-900 transition-colors">Instagram</a>
                        @endif
                        @if($youtube)
                            <a href="{{ $youtube }}" target="_blank" rel="noopener"
                               class="hover:text-gray-900 transition-colors">YouTube</a>
                        @endif
                    </div>
                @endif

            </div>

        </div>
    </div>
</section>
