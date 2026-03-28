@php
    $email    = setting('contact_email');
    $phone    = setting('contact_phone');
    $address  = setting('address');

    $tel = $phone ? ('tel:' . preg_replace('/[^\d+]/', '', $phone)) : null;
    $facebook = setting('facebook_url');
    $instagram= setting('instagram_url');
    $youtube  = setting('youtube_url');

    $hasContact = $email || $phone || $address;
    $hasSocial  = $facebook || $instagram || $youtube;
@endphp

<footer class="border-t border-gray-200 bg-white">
    <div class="mx-auto max-w-6xl px-4 py-10 text-sm text-gray-600">

        @if($hasContact || $hasSocial)
            <div class="flex flex-wrap gap-10 mb-8">

                {{-- Contact info --}}
                @if($hasContact)
                    <div class="space-y-1.5">
                        <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-2">Контакти</p>
                        @if($email)
                            <p><a href="mailto:{{ $email }}" class="hover:text-gray-900 transition-colors">{{ $email }}</a></p>
                        @endif
                        @if($phone)
                            <p><a href="{{ $tel }}" class="hover:text-gray-900 transition-colors">{{ $phone }}</a></p>
                        @endif
                        @if($address)
                            <p class="text-gray-500 whitespace-pre-line">{{ $address }}</p>
                        @endif
                    </div>
                @endif

                {{-- Social links --}}
                @if($hasSocial)
                    <div class="space-y-1.5">
                        <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-2">Социални мрежи</p>
                        @if($facebook)
                            <p><a href="{{ $facebook }}" target="_blank" rel="noopener" class="hover:text-gray-900 transition-colors">Facebook</a></p>
                        @endif
                        @if($instagram)
                            <p><a href="{{ $instagram }}" target="_blank" rel="noopener" class="hover:text-gray-900 transition-colors">Instagram</a></p>
                        @endif
                        @if($youtube)
                            <p><a href="{{ $youtube }}" target="_blank" rel="noopener" class="hover:text-gray-900 transition-colors">YouTube</a></p>
                        @endif
                    </div>
                @endif

            </div>
        @endif

        <p class="text-gray-400">© {{ date('Y') }} {{ setting('site_name', 'Website') }}</p>

    </div>
</footer>
