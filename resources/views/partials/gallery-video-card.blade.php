{{-- Public gallery card for video items ($item: GalleryItem) --}}
@php
    $embedUrl = $item->resolvedVideoEmbedUrl();
    $watchUrl = $item->video_url;
@endphp

<div class="flex flex-col">
    @if($embedUrl)
        <div class="{{ $item->videoEmbedAspectClass() }} relative overflow-hidden rounded-xl border border-gray-100 bg-black">
            <iframe
                src="{{ $embedUrl }}"
                class="absolute inset-0 h-full w-full border-0"
                title="{{ $item->title ? $item->title : 'Видео' }}"
                loading="lazy"
                allowfullscreen
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin"
            ></iframe>
        </div>
    @else
        <div class="aspect-video flex flex-col items-center justify-center gap-3 rounded-xl border border-amber-100 bg-amber-50/80 p-6 text-center">
            <p class="text-sm text-amber-900">Публичната галерия поддържа само YouTube. Този линк не е валиден YouTube адрес или записът е остарял.</p>
            @if($watchUrl)
                <a href="{{ $watchUrl }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-gray-700">
                    Отвори видеото
                </a>
            @endif
        </div>
    @endif

    @if($item->title)
        <p class="mt-2 text-sm text-gray-600 line-clamp-2">{{ $item->title }}</p>
    @endif

    @if($watchUrl && $embedUrl)
        <p class="mt-1">
            <a href="{{ $watchUrl }}"
               target="_blank"
               rel="noopener noreferrer"
               class="text-xs text-gray-400 underline-offset-2 hover:text-gray-600 hover:underline">
                Оригинален линк
            </a>
        </p>
    @endif
</div>
