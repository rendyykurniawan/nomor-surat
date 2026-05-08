<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SINARA') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logoJudul.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-cover w-full"
        style="background-image: url('{{ asset('images/kantorimi.png') }}')">
        {{-- <div>
            <a href="/" class="flex flex-col items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-40 h-auto text-gray-500">
                <p class="text-slate-600 font-semibold text-xl">Imigrasi Singkawang</p>
            </a>
        </div> --}}

        {{ $slot }}
    </div>
</body>

</html>
