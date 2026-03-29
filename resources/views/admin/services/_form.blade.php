{{--
    Reusable form partial for Service create / edit.

    Expected variables (all optional — defaults handle the create case):
      $service     — Service model instance (for edit); absent on create
      $submitLabel — string, button text; default: 'Запази услугата'
      $cancelUrl   — string, cancel href;  default: admin.services.index
--}}

{{-- ── Обобщение на грешки ─────────────────────────────── --}}
@if ($errors->any())
    <div class="mb-6 px-4 py-3 bg-red-50 border border-red-200 rounded-lg">
        <p class="text-sm font-medium text-red-700 mb-1">Моля, поправи следните грешки:</p>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach ($errors->all() as $error)
                <li class="text-sm text-red-600">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- ── Form card ──────────────────────────────────────────── --}}
<div class="bg-white border border-gray-200 rounded-xl shadow-sm divide-y divide-gray-100">

    {{-- ── Секция: Основна информация ──────────────────────── --}}
    <div class="px-8 py-6 space-y-5">

        <p class="text-xs font-bold tracking-widest uppercase text-gray-400">Основна информация</p>

        {{-- Заглавие --}}
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">
                Заглавие <span class="text-red-400">*</span>
            </label>
            <input
                type="text"
                id="title"
                name="title"
                value="{{ old('title', $service->title ?? '') }}"
                placeholder="Напр. Ремонт на покриви"
                autofocus
                class="w-full px-3 py-2 border rounded text-sm text-gray-900 placeholder-gray-400
                       focus:outline-none focus:border-gray-500 transition-colors
                       {{ $errors->has('title') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}"
            >
            @error('title')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Slug --}}
        <div>
            <label for="slug" class="block text-sm font-medium text-gray-700 mb-1.5">
                Slug
            </label>
            <input
                type="text"
                id="slug"
                name="slug"
                value="{{ old('slug', $service->slug ?? '') }}"
                placeholder="remont-na-pokrivi"
                class="w-full px-3 py-2 border rounded text-sm text-gray-900 placeholder-gray-400
                       font-mono focus:outline-none focus:border-gray-500 transition-colors
                       {{ $errors->has('slug') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}"
            >
            @error('slug')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @else
                <p class="mt-1.5 text-xs text-gray-400">
                    Остави празно — генерира се автоматично от заглавието.
                </p>
            @enderror
        </div>

    </div>

    {{-- ── Секция: Описания ─────────────────────────────────── --}}
    <div class="px-8 py-6 space-y-5">

        <p class="text-xs font-bold tracking-widest uppercase text-gray-400">Описания</p>

        {{-- Кратко описание --}}
        <div>
            <label for="short_description" class="block text-sm font-medium text-gray-700 mb-1.5">
                Кратко описание
            </label>
            <textarea
                id="short_description"
                name="short_description"
                rows="3"
                placeholder="Едно-две изречения, показвани в списъка с услуги."
                class="w-full px-3 py-2 border rounded text-sm text-gray-900 placeholder-gray-400
                       focus:outline-none focus:border-gray-500 transition-colors resize-y
                       {{ $errors->has('short_description') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}"
            >{{ old('short_description', $service->short_description ?? '') }}</textarea>
            @error('short_description')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Пълно описание --}}
        <div>
            <label for="full_description" class="block text-sm font-medium text-gray-700 mb-1.5">
                Пълно описание
            </label>
            <textarea
                id="full_description"
                name="full_description"
                rows="6"
                placeholder="Детайлно описание на услугата."
                class="w-full px-3 py-2 border rounded text-sm text-gray-900 placeholder-gray-400
                       focus:outline-none focus:border-gray-500 transition-colors resize-y
                       {{ $errors->has('full_description') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}"
            >{{ old('full_description', $service->full_description ?? '') }}</textarea>
            @error('full_description')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

    </div>

    {{-- ── Секция: Често задавани въпроси ─────────────────────── --}}
    @php
        if (session()->hasOldInput('faq')) {
            $oldFaq = old('faq');
            $faqRows = is_array($oldFaq) ? $oldFaq : [];
        } elseif (isset($service) && is_array($service->faq ?? null) && count($service->faq) > 0) {
            $faqRows = [];
            foreach ($service->faq as $row) {
                if (! is_array($row)) {
                    continue;
                }
                $faqRows[] = [
                    'question' => (string) ($row['question'] ?? ''),
                    'answer' => (string) ($row['answer'] ?? ''),
                ];
            }
        } else {
            $faqRows = [['question' => '', 'answer' => '']];
        }
        $faqNextIndex = 0;
        if (count($faqRows) > 0) {
            $faqNextIndex = max(array_map('intval', array_keys($faqRows))) + 1;
        }
    @endphp

    <div id="admin-service-faq-section" class="px-8 py-6 space-y-5" data-faq-next-index="{{ $faqNextIndex }}">

        <p class="text-xs font-bold tracking-widest uppercase text-gray-400">Често задавани въпроси</p>
        <p class="text-xs text-gray-500">
            Празни редове се игнорират. За всеки ред са нужни и въпрос, и отговор.
        </p>

        @error('faq')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror

        <div id="admin-service-faq-rows" class="space-y-5">
            @foreach ($faqRows as $i => $row)
                <div class="admin-service-faq-row space-y-3 rounded-lg border border-gray-200 p-4">
                    <div class="flex justify-end">
                        <button
                            type="button"
                            data-admin-faq-remove
                            class="text-sm text-gray-500 hover:text-red-600 transition-colors"
                        >
                            Премахни
                        </button>
                    </div>
                    <div>
                        <label for="faq_{{ $i }}_question" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Въпрос
                        </label>
                        <input
                            type="text"
                            id="faq_{{ $i }}_question"
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
                        <label for="faq_{{ $i }}_answer" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Отговор
                        </label>
                        <textarea
                            id="faq_{{ $i }}_answer"
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
            id="admin-service-faq-add"
            class="px-4 py-2 border border-gray-300 rounded text-sm font-medium text-gray-800
                   hover:border-gray-900 hover:text-gray-900 transition-colors"
        >
            Добави въпрос
        </button>

        <template id="admin-service-faq-row-template">
            <div class="admin-service-faq-row space-y-3 rounded-lg border border-gray-200 p-4">
                <div class="flex justify-end">
                    <button
                        type="button"
                        data-admin-faq-remove
                        class="text-sm text-gray-500 hover:text-red-600 transition-colors"
                    >
                        Премахни
                    </button>
                </div>
                <div>
                    <label for="faq___FAQ_INDEX___question" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Въпрос
                    </label>
                    <input
                        type="text"
                        id="faq___FAQ_INDEX___question"
                        name="faq[__FAQ_INDEX__][question]"
                        value=""
                        class="w-full px-3 py-2 border border-gray-200 rounded text-sm text-gray-900 placeholder-gray-400
                               focus:outline-none focus:border-gray-500 transition-colors"
                    >
                </div>
                <div>
                    <label for="faq___FAQ_INDEX___answer" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Отговор
                    </label>
                    <textarea
                        id="faq___FAQ_INDEX___answer"
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
                var root = document.getElementById('admin-service-faq-section');
                if (!root) return;
                var rowsEl = document.getElementById('admin-service-faq-rows');
                var tpl = document.getElementById('admin-service-faq-row-template');
                var addBtn = document.getElementById('admin-service-faq-add');
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
                    var btn = e.target.closest('[data-admin-faq-remove]');
                    if (!btn || !rowsEl.contains(btn)) return;
                    var row = btn.closest('.admin-service-faq-row');
                    if (row) row.remove();
                });
            })();
        </script>

    </div>

    {{-- ── Секция: Настройки ────────────────────────────────── --}}
    <div class="px-8 py-6 space-y-5">

        <p class="text-xs font-bold tracking-widest uppercase text-gray-400">Настройки</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

            {{-- Икона --}}
            <div>
                <label for="icon" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Икона
                </label>
                <input
                    type="text"
                    id="icon"
                    name="icon"
                    value="{{ old('icon', $service->icon ?? '') }}"
                    placeholder="Напр. heroicon-wrench"
                    class="w-full px-3 py-2 border rounded text-sm text-gray-900 placeholder-gray-400
                           focus:outline-none focus:border-gray-500 transition-colors
                           {{ $errors->has('icon') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}"
                >
                @error('icon')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Пореден номер --}}
            <div>
                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Пореден номер
                </label>
                <input
                    type="number"
                    id="sort_order"
                    name="sort_order"
                    value="{{ old('sort_order', $service->sort_order ?? 0) }}"
                    min="0"
                    class="w-full px-3 py-2 border rounded text-sm text-gray-900
                           focus:outline-none focus:border-gray-500 transition-colors
                           {{ $errors->has('sort_order') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}"
                >
                @error('sort_order')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

        </div>

        {{-- Активна услуга --}}
        <div>
            {{-- Hidden ensures value=0 is submitted when checkbox is unchecked --}}
            <input type="hidden" name="is_active" value="0">
            <label class="inline-flex items-center gap-3 cursor-pointer select-none">
                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}
                    class="w-4 h-4 rounded border-gray-300 text-gray-900
                           focus:ring-0 focus:ring-offset-0 cursor-pointer"
                >
                <span class="text-sm text-gray-700">Активна услуга</span>
            </label>
            @error('is_active')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

    </div>

    {{-- ── Действия ─────────────────────────────────────────── --}}
    <div class="px-8 py-5 bg-gray-50 rounded-b-xl flex items-center gap-4">
        <button
            type="submit"
            class="px-5 py-2 bg-gray-900 text-white text-sm font-medium rounded
                   hover:bg-gray-700 transition-colors">
            {{ $submitLabel ?? 'Запази услугата' }}
        </button>
        <a href="{{ $cancelUrl ?? route('admin.services.index') }}"
           class="text-sm text-gray-400 hover:text-gray-900 transition-colors">
            Отказ
        </a>
    </div>

</div>
