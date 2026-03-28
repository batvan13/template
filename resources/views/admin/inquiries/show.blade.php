@extends('layouts.admin')

@section('title', 'Запитване #' . $inquiry->id . ' — Admin')

@section('content')

    @php
        use App\Models\Inquiry;
    @endphp

    <div class="mb-8 flex items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.inquiries.index') }}"
               class="text-xs text-gray-400 hover:text-gray-700 transition-colors mb-2 inline-block">
                ← Към списъка
            </a>
            <h1 class="text-xl font-semibold text-gray-900">Запитване #{{ $inquiry->id }}</h1>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 px-4 py-3 bg-white border border-gray-200 rounded-lg text-sm text-gray-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 px-4 py-3 bg-white border border-red-200 rounded-lg text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <dl class="divide-y divide-gray-100 text-sm">
            <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Статус</dt>
                <dd class="sm:col-span-2">
                    @if ($inquiry->status === Inquiry::STATUS_RECEIVED)
                        <span class="inline-block px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-700">Получено</span>
                    @elseif ($inquiry->status === Inquiry::STATUS_NOTIFIED)
                        <span class="inline-block px-2 py-0.5 rounded text-xs font-medium bg-gray-900 text-white">Изпратено (имейл)</span>
                    @else
                        <span class="inline-block px-2 py-0.5 rounded text-xs font-medium bg-red-50 text-red-700">Грешка при имейл</span>
                    @endif
                </dd>
            </div>
            <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Дата</dt>
                <dd class="sm:col-span-2 text-gray-900">{{ $inquiry->created_at->format('d.m.Y H:i') }}</dd>
            </div>
            <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Име</dt>
                <dd class="sm:col-span-2 text-gray-900">{{ $inquiry->name }}</dd>
            </div>
            <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Имейл</dt>
                <dd class="sm:col-span-2 text-gray-900">
                    <a href="mailto:{{ $inquiry->email }}" class="text-gray-900 hover:underline">{{ $inquiry->email }}</a>
                </dd>
            </div>
            <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Телефон</dt>
                <dd class="sm:col-span-2 text-gray-900">{{ $inquiry->phone ?: '—' }}</dd>
            </div>
            <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Имейл изпратен</dt>
                <dd class="sm:col-span-2 text-gray-900">
                    {{ $inquiry->notified_at ? $inquiry->notified_at->format('d.m.Y H:i') : '—' }}
                </dd>
            </div>
            @if($inquiry->mail_error)
                <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Грешка</dt>
                    <dd class="sm:col-span-2 text-red-700 text-xs font-mono break-all">{{ $inquiry->mail_error }}</dd>
                </div>
            @endif
            <div class="px-6 py-4">
                <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Съобщение</dt>
                <dd class="text-gray-900 whitespace-pre-wrap leading-relaxed">{{ $inquiry->message }}</dd>
            </div>
        </dl>

        @if ($inquiry->status === Inquiry::STATUS_MAIL_FAILED)
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                <form action="{{ route('admin.inquiries.resend', $inquiry) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                            class="text-sm font-medium px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-700 transition-colors">
                        Изпрати имейл отново
                    </button>
                </form>
            </div>
        @endif
    </div>

@endsection
