<!--  only for activity feed -->
<!--  only for activity feed -->
<!--  only for activity feed -->
<!--  only for activity feed -->

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
        <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <link rel="icon" href="{{ asset('images/logos/Volunteer Hub Bangladesh.png') }}" type="image/png">
        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" /> -->
        <!-- Scripts -->
        <link href="{{ asset('build/assets/app-JORL7NPY.css') }}" rel="stylesheet">
        <!-- <link href="{{ asset('build/assets/app-X6JekhOX.css') }}" rel="stylesheet"> -->
        <script src="{{ asset('build/assets/app-BrtSY-Si.js') }}" defer></script>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        @include('layouts.navigation')

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>