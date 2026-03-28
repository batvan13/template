@extends('layouts.app')

@section('title', 'Контакти')
@section('description', 'Свържете се с нас за въпроси, запитвания или среща.')

@section('content')

    {{-- Hero --}}
    <section class="bg-white py-20">
        <div class="mx-auto max-w-6xl px-4">
            <div class="max-w-2xl">

                <h1 class="text-4xl font-bold tracking-tight text-gray-900">
                    {{ $hero?->title ?? 'Контакти' }}
                </h1>

                @if($hero?->subtitle)
                    <p class="mt-6 text-lg text-gray-600">
                        {{ $hero->subtitle }}
                    </p>
                @endif

                @if($hero?->content)
                    <p class="mt-4 text-base text-gray-500 leading-relaxed">
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

                <div class="mt-8">
                    @include('partials.action-buttons')
                </div>

            </div>
        </div>
    </section>

    {{-- Contact info + form --}}
    <section class="bg-gray-50 py-16">
        <div class="mx-auto max-w-6xl px-4">
            <div class="grid gap-12 md:grid-cols-2 items-start">

                {{-- Left: contact details --}}
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Информация</h2>

                    @if($hasContact)
                        <ul class="mt-6 space-y-4 text-sm text-gray-600">
                            @if($phone)
                                <li>
                                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Телефон</span><br>
                                    <a href="{{ $tel }}" class="hover:text-gray-900 transition-colors">{{ $phone }}</a>
                                </li>
                            @endif
                            @if($email)
                                <li>
                                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Имейл</span><br>
                                    <a href="mailto:{{ $email }}" class="hover:text-gray-900 transition-colors">{{ $email }}</a>
                                </li>
                            @endif
                            @if($address)
                                <li>
                                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Адрес</span><br>
                                    <span class="whitespace-pre-line">{{ $address }}</span>
                                </li>
                            @endif
                        </ul>
                    @else
                        <p class="mt-6 text-sm text-gray-400">Контактната информация ще бъде добавена скоро.</p>
                    @endif

                    @if($hasSocial)
                        <div class="mt-6 flex gap-4 text-sm text-gray-500">
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

                {{-- Right: inquiry form --}}
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Изпратете запитване</h2>

                    @if(! $email)

                        <p class="mt-6 text-sm text-gray-400">
                            Формулярът за контакт не е конфигуриран.
                            Моля, свържете се с нас директно по телефон или имейл.
                        </p>

                    @elseif(is_string(session('inquiry_success')) && session('inquiry_success') !== '')

                        <div class="mt-6 rounded-lg border border-gray-200 bg-white px-6 py-8 text-center">
                            <p class="text-sm font-semibold text-gray-900">{{ session('inquiry_success') }}</p>
                            <p class="mt-1 text-sm text-gray-500">Благодарим ви. Ще се свържем с вас скоро.</p>
                            <a href="{{ url()->current() }}"
                               class="mt-4 inline-block text-sm text-gray-400 hover:text-gray-700 transition-colors underline underline-offset-2">
                                Изпрати ново запитване
                            </a>
                        </div>

                    @else

                        @if($errors->has('throttle'))
                            <div class="mt-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3">
                                <p class="text-sm text-red-600">{{ $errors->first('throttle') }}</p>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('inquiry.submit') }}" class="relative mt-6 space-y-4" novalidate>
                            @csrf

                            @if($errors->has('inquiry'))
                                <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3">
                                    <p class="text-sm text-red-600">{{ $errors->first('inquiry') }}</p>
                                </div>
                            @endif

                            <input type="hidden" name="opened_at" value="{{ time() }}">

                            <div class="absolute left-[-9999px] top-auto w-px h-px overflow-hidden" aria-hidden="true">
                                <label for="company">Фирма</label>
                                <input type="text" name="company" id="company" value="" tabindex="-1" autocomplete="off">
                            </div>

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Име <span class="text-red-400">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Вашето Име"
                                    class="w-full rounded-lg border {{ $errors->has('name') ? 'border-red-400' : 'border-gray-200' }} bg-white px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900"
                                >
                                @error('name')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                    Имейл <span class="text-red-400">*</span>
                                </label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="example@email.com"
                                    class="w-full rounded-lg border {{ $errors->has('email') ? 'border-red-400' : 'border-gray-200' }} bg-white px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900"
                                >
                                @error('email')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                    Телефон <span class="text-xs font-normal text-gray-400">(по желание)</span>
                                </label>
                                <input
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    placeholder="+359 88 123 4567"
                                    class="w-full rounded-lg border {{ $errors->has('phone') ? 'border-red-400' : 'border-gray-200' }} bg-white px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900"
                                >
                                @error('phone')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">
                                    Съобщение <span class="text-red-400">*</span>
                                </label>
                                <textarea
                                    id="message"
                                    name="message"
                                    rows="4"
                                    placeholder="Опишете вашето запитване..."
                                    class="w-full rounded-lg border {{ $errors->has('message') ? 'border-red-400' : 'border-gray-200' }} bg-white px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900"
                                >{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <button
                                type="submit"
                                class="inline-flex rounded-lg bg-black px-6 py-3 text-sm font-semibold text-white transition hover:bg-gray-800"
                            >
                                Изпрати
                            </button>

                        </form>

                    @endif

                </div>

            </div>
        </div>
    </section>

    {{-- Optional content block --}}
    @if($content?->title || $content?->subtitle || $content?->content)
        <section class="bg-white py-16">
            <div class="mx-auto max-w-6xl px-4">
                <div class="max-w-3xl">

                    @if($content?->title)
                        <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                            {{ $content->title }}
                        </h2>
                    @endif

                    @if($content?->subtitle)
                        <p class="mt-4 text-lg text-gray-600">
                            {{ $content->subtitle }}
                        </p>
                    @endif

                    @if($content?->content)
                        <p class="mt-4 text-base text-gray-500 leading-relaxed">
                            {{ $content->content }}
                        </p>
                    @endif

                </div>
            </div>
        </section>
    @endif

@endsection
