<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Website')</title>
    <meta name="description" content="@yield('description', 'Business website')">
    <meta name="robots" content="index,follow">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-900 antialiased">

@include('components.header')

<main>
    @yield('content')
</main>

@include('components.footer')

</body>
</html>
