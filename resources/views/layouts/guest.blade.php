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
    <link href="{{ asset('build/assets/app-JORL7NPY.css') }}" rel="stylesheet">
        <!-- <link href="{{ asset('build/assets/app-X6JekhOX.css') }}" rel="stylesheet"> -->
        <script src="{{ asset('build/assets/app-BrtSY-Si.js') }}" defer></script>
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-2 px-2 sm:pt-0 bg-gradient-to-br from-blue-400 via-teal-500 to-blue-400 text-gray-900 animate-gradient">
    <style>
        @keyframes gradient {
            0% { background-position: 0% 0%; }
            25% { background-position: 50% 50%; }
            50% { background-position: 100% 100%; }
            75% { background-position: 50% 50%; }
            100% { background-position: 0% 0%; }
        }
        .animate-gradient {
            background: linear-gradient(135deg, #00c6ff, #0072ff, #20b2aa, #00ced1, #5f9ea0, #4682b4, #00c6ff);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
    </style>
        {{-- @include('layouts.navigation') --}}
     

        <div class="w-full sm:max-w-md pt-6 px-5 mt-6 bg-white shadow-lg overflow-hidden border rounded-lg">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
            {{ $slot }}
        </div>
        @php
            $isGuestLayout = true;
        @endphp
        @include('layouts.footer')
    </div>
        

</body>

</html>
