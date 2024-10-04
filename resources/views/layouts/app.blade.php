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
        <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <!-- Scripts -->
    
        <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
        <link href="{{ asset('build/assets/app-kg3tZzBH.css') }}" rel="stylesheet">
        <!-- <link href="{{ asset('build/assets/app-X6JekhOX.css') }}" rel="stylesheet"> -->
        <script src="{{ asset('build/assets/app-C1lQybwB.js') }}" defer></script>
        <link rel="icon" href="{{ asset('images/logos/Volunteer Hub Bangladesh.png') }}" type="image/png"> <!-- Favicon -->
        
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
