<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('logo/tabrika-logo.svg') }}" type="image/svg+xml">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200">

            {{-- Logo di atas kartu --}}
            <div class="mb-2">
                <a href="/">
                    <x-application-logo class="w-32 h-32 text-gray-500" />
                </a>
            </div>

            {{-- Slot untuk konten login / register --}}
            {{ $slot }}
        </div>
    </body>
</html>
