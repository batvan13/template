<header class="border-b border-gray-200 bg-white">
    <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
        <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight">
            Template
        </a>

        <nav class="flex items-center gap-6 text-sm font-medium">
            <a href="{{ route('home') }}" class="hover:text-black/70">Начало</a>
            <a href="{{ route('about') }}" class="hover:text-black/70">За нас</a>
            <a href="{{ route('services') }}" class="hover:text-black/70">Услуги</a>
            <a href="{{ route('gallery') }}" class="hover:text-black/70">Галерия</a>
            <a href="{{ route('contacts') }}" class="hover:text-black/70">Контакти</a>
        </nav>
    </div>
</header>
