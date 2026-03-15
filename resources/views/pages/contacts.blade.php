@extends('layouts.app')

@section('title', 'Контакти')
@section('description', 'Свържете се с нас')

@section('content')

    <section class="bg-gray-50 py-20">
        <div class="mx-auto max-w-6xl px-4">

            <h1 class="text-4xl font-bold tracking-tight">
                Контакти
            </h1>

            <p class="mt-6 max-w-2xl text-lg text-gray-600">
                Свържете се с нас за повече информация.
            </p>

            <div class="mt-12 grid gap-12 md:grid-cols-2">

                <div>
                    <h3 class="text-lg font-semibold">Информация</h3>

                    <ul class="mt-6 space-y-4 text-gray-600">
                        <li>Телефон: +359 XXX XXX XXX</li>
                        <li>Email: info@example.com</li>
                        <li>Адрес: София, България</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold">Изпратете запитване</h3>

                    <form class="mt-6 space-y-4">

                        <input
                            type="text"
                            placeholder="Име"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3"
                        >

                        <input
                            type="email"
                            placeholder="Email"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3"
                        >

                        <textarea
                            placeholder="Съобщение"
                            rows="4"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3"
                        ></textarea>

                        <button
                            type="submit"
                            class="rounded-lg bg-black px-6 py-3 text-white hover:bg-gray-800"
                        >
                            Изпрати
                        </button>

                    </form>
                </div>

            </div>

        </div>
    </section>

@endsection
