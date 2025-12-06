<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tabrika Shop')</title>
    <link rel="icon" href="{{ asset('logo/tabrika-logo.svg') }}" type="image/svg+xml">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-slate-50 text-gray-800">

    @include('components.header')

    <main class="">
        @yield('content')
    </main>

    @include('components.footer')

    @stack('scripts')
</body>

</html>
