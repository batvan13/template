@php
    $phone   = setting('contact_phone');
    $email   = setting('contact_email');
    $mapsUrl = setting('google_maps_url');

    // Strip everything except digits and leading + for a valid tel: URI.
    $tel = $phone ? ('tel:' . preg_replace('/[^\d+]/', '', $phone)) : null;
@endphp

@if($phone || $email || $mapsUrl)
    <div class="flex flex-wrap gap-3">

        @if($phone)
            <a href="{{ $tel }}"
               class="inline-flex items-center rounded-lg border border-gray-200 px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:border-gray-400 hover:text-gray-900">
                Обади се
            </a>
        @endif

        @if($email)
            <a href="mailto:{{ $email }}"
               class="inline-flex items-center rounded-lg border border-gray-200 px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:border-gray-400 hover:text-gray-900">
                Изпрати имейл
            </a>
        @endif

        @if($mapsUrl)
            <a href="{{ $mapsUrl }}" target="_blank" rel="noopener"
               class="inline-flex items-center rounded-lg border border-gray-200 px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:border-gray-400 hover:text-gray-900">
                Намери ни
            </a>
        @endif

    </div>
@endif
