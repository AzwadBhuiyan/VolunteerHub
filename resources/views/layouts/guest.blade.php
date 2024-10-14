<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/logos/Volunteer Hub Bangladesh.png') }}" type="image/png">
    <!-- Favicon -->

    <!-- Scripts -->
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
    <link href="{{ asset('build/assets/app-B-RhTCEg.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('build/assets/app-X6JekhOX.css') }}" rel="stylesheet"> -->
    <script src="{{ asset('build/assets/app-BmtUwlhf.js') }}" defer></script>
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 ">
        {{-- @include('layouts.navigation') --}}
        <div>

        </div>

        <div class="w-full  sm:max-w-md pt-8 px-8 bg-white shadow-lg overflow-hidden sm:rounded-lg">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
            {{ $slot }}
        </div>
    </div>
</body>

</html>
