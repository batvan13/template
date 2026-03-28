{{--
    Cookie Consent Banner
    ─────────────────────
    Consent is stored as a browser cookie:
        name:     cookie_consent
        value:    accepted
        lifetime: 365 days (max-age=31536000)
        path:     /

    To extend for analytics categories in the future, set separate
    cookies per category, e.g. cookie_analytics=accepted, or store
    a JSON-encoded value and parse it on the JS side.
--}}
<div
    id="cookie-banner"
    class="fixed bottom-0 inset-x-0 z-50 hidden"
    role="region"
    aria-label="Cookie consent"
    aria-live="polite"
>
    <div class="border-t border-gray-200 bg-white shadow-md">
        <div class="mx-auto max-w-6xl px-4 py-4 sm:flex sm:items-center sm:justify-between sm:gap-6">

            <p class="text-sm text-gray-600 leading-relaxed">
                Този сайт използва бисквитки за подобряване на вашето преживяване.
            </p>

            <div class="mt-3 flex-shrink-0 sm:mt-0">
                <button
                    id="cookie-accept"
                    type="button"
                    class="rounded bg-gray-900 px-5 py-2 text-sm font-medium text-white
                           hover:bg-gray-700 transition-colors whitespace-nowrap"
                >
                    Приемам
                </button>
            </div>

        </div>
    </div>
</div>

<script>
(function () {
    var banner = document.getElementById('cookie-banner');
    var btn    = document.getElementById('cookie-accept');

    if (!banner || !btn) return;

    function getCookie(name) {
        var match = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
        return match ? match[2] : null;
    }

    if (!getCookie('cookie_consent')) {
        banner.classList.remove('hidden');
    }

    btn.addEventListener('click', function () {
        // 365 days in seconds
        document.cookie = 'cookie_consent=accepted; max-age=31536000; path=/; SameSite=Lax';
        banner.classList.add('hidden');
    });
}());
</script>
