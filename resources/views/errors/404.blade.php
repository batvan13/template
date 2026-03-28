<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Страницата не е намерена</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-900 antialiased">

    <div class="min-h-screen flex flex-col items-center justify-center px-4">

        <p class="text-xs font-bold tracking-widest uppercase text-gray-400 mb-4">Грешка</p>

        <h1 class="text-8xl font-bold text-gray-900 leading-none">404</h1>

        <p class="mt-6 text-lg text-gray-500">
            Страницата, която търсиш, не съществува.
        </p>

        <a href="{{ url('/') }}"
           class="mt-8 inline-flex rounded-lg bg-black px-6 py-3 text-sm font-semibold text-white transition hover:bg-gray-800">
            Към началната страница
        </a>

    </div>

</body>
</html>
