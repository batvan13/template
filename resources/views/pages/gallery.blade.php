@extends('layouts.app')

@section('title', 'Галерия')
@section('description', 'Снимки от нашата работа')

@section('content')

    <section class="py-20">
        <div class="mx-auto max-w-6xl px-4">

            <h1 class="text-4xl font-bold tracking-tight">
                Галерия
            </h1>

            <p class="mt-6 max-w-2xl text-lg text-gray-600">
                Част от нашата работа.
            </p>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 md:grid-cols-3">

                <div class="aspect-square bg-gray-200 rounded-lg"></div>
                <div class="aspect-square bg-gray-200 rounded-lg"></div>
                <div class="aspect-square bg-gray-200 rounded-lg"></div>
                <div class="aspect-square bg-gray-200 rounded-lg"></div>
                <div class="aspect-square bg-gray-200 rounded-lg"></div>
                <div class="aspect-square bg-gray-200 rounded-lg"></div>

            </div>

        </div>
    </section>

@endsection
