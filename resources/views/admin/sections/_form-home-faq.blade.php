{{--
    Home FAQ section editor (page=home, section=faq) — title + FAQ repeater only.
--}}

<div class="bg-white border border-gray-200 rounded-xl shadow-sm divide-y divide-gray-100">

    <div class="px-8 py-6 space-y-5">

        <p class="text-xs font-bold tracking-widest uppercase text-gray-400">Начална страница — Често задавани въпроси</p>

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">
                Заглавие на блока
            </label>
            <input
                type="text"
                id="title"
                name="title"
                value="{{ old('title', $pageSection->title) }}"
                autofocus
                placeholder="По избор — показва се над списъка с въпроси"
                class="w-full px-3 py-2 border rounded text-sm text-gray-900 placeholder-gray-400
                       focus:outline-none focus:border-gray-500 transition-colors
                       {{ $errors->has('title') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}"
            >
            @error('title')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        @php
            if (session()->hasOldInput('faq')) {
                $oldFaq = old('faq');
                $faqRows = is_array($oldFaq) ? $oldFaq : [];
            } elseif (is_array($pageSection->faq ?? null) && count($pageSection->faq) > 0) {
                $faqRows = [];
                foreach ($pageSection->faq as $row) {
                    if (! is_array($row)) {
                        continue;
                    }
                    $faqRows[] = [
                        'question' => (string) ($row['question'] ?? ''),
                        'answer' => (string) ($row['answer'] ?? ''),
                    ];
                }
            } else {
                $faqRows = [];
            }
            $faqNextIndex = 0;
            if (count($faqRows) > 0) {
                $faqNextIndex = max(array_map('intval', array_keys($faqRows))) + 1;
            }
        @endphp

        <p class="text-xs text-gray-500">
            Празни редове се игнорират. За всеки ред са нужни и въпрос, и отговор.
        </p>

        @error('faq')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror

        <div id="admin-home-faq-section" data-faq-next-index="{{ $faqNextIndex }}">
            <div id="admin-home-faq-rows" class="space-y-5">
                @foreach ($faqRows as $i => $row)
                    <div class="admin-home-faq-row space-y-3 rounded-lg border border-gray-200 p-4">
                        <div class="flex justify-end">
                            <button
                                type="button"
                                data-admin-home-faq-remove
                                class="text-sm text-gray-500 hover:text-red-600 transition-colors"
                            >
                                Премахни
                            </button>
                        </div>
                        <div>
                            <label for="home_faq_{{ $i }}_question" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Въпрос
                            </label>
                            <input
                                type="text"
                                id="home_faq_{{ $i }}_question"
                                name="faq[{{ $i }}][question]"
                                value="{{ old('faq.'.$i.'.question', $row['question'] ?? '') }}"
                                class="w-full px-3 py-2 border rounded text-sm text-gray-900 placeholder-gray-400
                                       focus:outline-none focus:border-gray-500 transition-colors
                                       {{ $errors->has('faq.'.$i.'.question') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}"
                            >
                            @error('faq.'.$i.'.question')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="home_faq_{{ $i }}_answer" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Отговор
                            </label>
                            <textarea
                                id="home_faq_{{ $i }}_answer"
                                name="faq[{{ $i }}][answer]"
                                rows="4"
                                class="w-full px-3 py-2 border rounded text-sm text-gray-900 placeholder-gray-400
                                       focus:outline-none focus:border-gray-500 transition-colors resize-y
                                       {{ $errors->has('faq.'.$i.'.answer') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}"
                            >{{ old('faq.'.$i.'.answer', $row['answer'] ?? '') }}</textarea>
                            @error('faq.'.$i.'.answer')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endforeach
            </div>

            <button
                type="button"
                id="admin-home-faq-add"
                class="mt-5 px-4 py-2 border border-gray-300 rounded text-sm font-medium text-gray-800
                       hover:border-gray-900 hover:text-gray-900 transition-colors"
            >
                Добави въпрос
            </button>
        </div>

        <template id="admin-home-faq-row-template">
            <div class="admin-home-faq-row space-y-3 rounded-lg border border-gray-200 p-4">
                <div class="flex justify-end">
                    <button
                        type="button"
                        data-admin-home-faq-remove
                        class="text-sm text-gray-500 hover:text-red-600 transition-colors"
                    >
                        Премахни
                    </button>
                </div>
                <div>
                    <label for="home_faq___FAQ_INDEX___question" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Въпрос
                    </label>
                    <input
                        type="text"
                        id="home_faq___FAQ_INDEX___question"
                        name="faq[__FAQ_INDEX__][question]"
                        value=""
                        class="w-full px-3 py-2 border border-gray-200 rounded text-sm text-gray-900 placeholder-gray-400
                               focus:outline-none focus:border-gray-500 transition-colors"
                    >
                </div>
                <div>
                    <label for="home_faq___FAQ_INDEX___answer" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Отговор
                    </label>
                    <textarea
                        id="home_faq___FAQ_INDEX___answer"
                        name="faq[__FAQ_INDEX__][answer]"
                        rows="4"
                        class="w-full px-3 py-2 border border-gray-200 rounded text-sm text-gray-900 placeholder-gray-400
                               focus:outline-none focus:border-gray-500 transition-colors resize-y"
                    ></textarea>
                </div>
            </div>
        </template>

        <script>
            (function () {
                var root = document.getElementById('admin-home-faq-section');
                if (!root) return;
                var rowsEl = document.getElementById('admin-home-faq-rows');
                var tpl = document.getElementById('admin-home-faq-row-template');
                var addBtn = document.getElementById('admin-home-faq-add');
                if (!rowsEl || !tpl || !addBtn) return;
                var nextIndex = parseInt(root.getAttribute('data-faq-next-index'), 10);
                if (isNaN(nextIndex)) nextIndex = 0;

                addBtn.addEventListener('click', function () {
                    var html = tpl.innerHTML.replace(/__FAQ_INDEX__/g, String(nextIndex));
                    var wrap = document.createElement('div');
                    wrap.innerHTML = html.trim();
                    var node = wrap.firstElementChild;
                    if (node) rowsEl.appendChild(node);
                    nextIndex += 1;
                });

                rowsEl.addEventListener('click', function (e) {
                    var btn = e.target.closest('[data-admin-home-faq-remove]');
                    if (!btn || !rowsEl.contains(btn)) return;
                    var row = btn.closest('.admin-home-faq-row');
                    if (row) row.remove();
                });
            })();
        </script>

    </div>

    <div class="px-8 py-5 bg-gray-50 rounded-b-xl flex items-center gap-4">
        <button
            type="submit"
            class="px-5 py-2 bg-gray-900 text-white text-sm font-medium rounded
                   hover:bg-gray-700 transition-colors">
            Запази промените
        </button>
        <a href="{{ route('admin.sections.index') }}"
           class="text-sm text-gray-400 hover:text-gray-900 transition-colors">
            Отказ
        </a>
    </div>

</div>
