@extends('layouts.app')

@section('title', 'Услуги')
@section('description', 'Разгледайте пълния списък с услуги, които предлагаме.')

@section('content')

    <section class="bg-gray-50 py-20">
        <div class="mx-auto max-w-6xl px-4">

            {{-- Page heading --}}
            <div class="max-w-2xl">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900">
                    {{ $page?->title ?? 'Нашите услуги' }}
                </h1>

                @if($page?->subtitle)
                    <p class="mt-4 text-lg text-gray-600">
                        {{ $page->subtitle }}
                    </p>
                @endif

                @if($page?->content)
                    <p class="mt-3 text-base text-gray-500 leading-relaxed">
                        {{ $page->content }}
                    </p>
                @endif
            </div>

            {{-- Services grid --}}
            <div class="mt-12 grid gap-6 sm:grid-cols-2 md:grid-cols-3">

                @forelse($services as $service)

                    <div class="rounded-xl border border-gray-200 bg-white p-6">

                        @if($service->icon)
                            <p class="mb-3 text-xs font-mono text-gray-400">{{ $service->icon }}</p>
                        @endif

                        <h2 class="text-base font-semibold text-gray-900">
                            <a href="{{ route('services.show', $service->slug) }}"
                               class="text-gray-900 underline-offset-2 hover:underline">
                                {{ $service->title }}
                            </a>
                        </h2>

                        @php
                            $body = $service->short_description ?: $service->full_description;
                        @endphp

                        @if($body)
                            <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                                {{ $body }}
                            </p>
                        @endif

                        <p class="mt-4">
                            <a href="{{ route('services.show', $service->slug) }}"
                               class="text-xs font-medium text-gray-900 underline-offset-2 hover:underline">
                                Вижте детайли →
                            </a>
                        </p>

                    </div>

                @empty

                    <div class="sm:col-span-2 md:col-span-3 py-16 text-center">
                        <p class="text-sm text-gray-400">Все още няма добавени услуги.</p>
                    </div>

                @endforelse

            </div>

        </div>
    </section>

    {{-- ── Contact CTA ─────────────────────────────────────────── --}}
    <section class="bg-white py-16">
        <div class="mx-auto max-w-6xl px-4">

            <p class="text-lg font-semibold text-gray-900">Интересувате се от някоя от нашите услуги?</p>

            <div class="mt-6">
                @include('partials.action-buttons')
            </div>

            <p class="mt-4 text-sm text-gray-400">
                или
                <a href="{{ route('contacts') }}"
                   class="underline underline-offset-2 hover:text-gray-700 transition-colors">
                    изпратете запитване
                </a>
            </p>

        </div>
    </section>

@endsection
