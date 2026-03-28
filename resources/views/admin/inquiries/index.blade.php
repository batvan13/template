@extends('layouts.admin')

@section('title', 'Запитвания — Admin')

@section('content')

    <div class="mb-8">
        <h1 class="text-xl font-semibold text-gray-900">Запитвания</h1>
        <p class="mt-1 text-sm text-gray-500">Запитвания от контактната форма на сайта.</p>
    </div>

    @php
        use App\Models\Inquiry;
        $tabs = [
            'all' => 'Всички',
            Inquiry::STATUS_RECEIVED => 'Получени',
            Inquiry::STATUS_NOTIFIED => 'Изпратени',
            Inquiry::STATUS_MAIL_FAILED => 'Грешка имейл',
        ];
    @endphp

    <div class="mb-6 flex flex-wrap items-center gap-2">
        @foreach($tabs as $value => $label)
            <a href="{{ route('admin.inquiries.index', $value !== 'all' ? ['status' => $value] : []) }}"
               class="text-sm px-4 py-1.5 rounded transition-colors
                      {{ $filter === $value
                          ? 'bg-gray-900 text-white'
                          : 'border border-gray-200 text-gray-600 hover:border-gray-400 hover:text-gray-900' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    @if ($inquiries->isEmpty())

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm px-8 py-16 text-center">
            <p class="text-sm font-medium text-gray-900 mb-1">Няма запитвания</p>
            <p class="text-sm text-gray-400">Когато посетители изпратят формата, те ще се появят тук.</p>
        </div>

    @else

        <p class="mb-3 text-xs text-gray-400">
            Общо: {{ $inquiries->total() }} {{ $inquiries->total() === 1 ? 'запитване' : 'запитвания' }}
        </p>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Дата</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Име</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Имейл</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Статус</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Съобщение</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($inquiries as $inquiry)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                {{ $inquiry->created_at->format('d.m.Y H:i') }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $inquiry->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $inquiry->email }}</td>
                            <td class="px-6 py-4">
                                @if ($inquiry->status === Inquiry::STATUS_RECEIVED)
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-700">Получено</span>
                                @elseif ($inquiry->status === Inquiry::STATUS_NOTIFIED)
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-medium bg-gray-900 text-white">Изпратено</span>
                                @else
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-medium bg-red-50 text-red-700">Грешка</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500 max-w-xs truncate" title="{{ $inquiry->message }}">
                                {{ \Illuminate\Support\Str::limit($inquiry->message, 80) }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.inquiries.show', $inquiry) }}"
                                   class="text-xs px-3 py-1.5 rounded border border-gray-200
                                          text-gray-600 hover:border-gray-900 hover:text-gray-900 transition-colors">
                                    Преглед
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $inquiries->links() }}
        </div>

    @endif

@endsection
