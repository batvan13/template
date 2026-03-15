@extends('layouts.app')

@section('title', 'Услуги')
@section('description', 'Услугите, които предлагаме')

@section('content')

    <section class="bg-gray-50 py-20">
        <div class="mx-auto max-w-6xl px-4">

            <h1 class="text-4xl font-bold tracking-tight">
                Нашите услуги
            </h1>

            <p class="mt-6 max-w-2xl text-lg text-gray-600">
                Описание на услугите, които предлага бизнесът.
            </p>

            <div class="mt-12 grid gap-8 md:grid-cols-3">

                <div class="rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold">Услуга 1</h3>
                    <p class="mt-3 text-gray-600">
                        Кратко описание на услугата.
                    </p>
                </div>

                <div class="rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold">Услуга 2</h3>
                    <p class="mt-3 text-gray-600">
                        Кратко описание на услугата.
                    </p>
                </div>

                <div class="rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold">Услуга 3</h3>
                    <p class="mt-3 text-gray-600">
                        Кратко описание на услугата.
                    </p>
                </div>

            </div>

        </div>
    </section>

@endsection
