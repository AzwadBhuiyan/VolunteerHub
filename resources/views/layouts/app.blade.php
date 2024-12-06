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
        

        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">   
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

       @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="{{ asset('build/assets/app-JORL7NPY.css') }}" rel="stylesheet">
      <link href="{{ asset('build/assets/app-X6JekhOX.css') }}" rel="stylesheet"> 
        <script src="{{ asset('build/assets/app-BrtSY-Si.js') }}" defer></script>
        <link rel="icon" href="{{ asset('images/logos/Volunteer Hub Bangladesh.png') }}" type="image/png"> <!-- Favicon -->

        <!-- for tutorial popup -->
        @if(auth()->check())
            <link href="{{ asset('css/tutorial.css') }}" rel="stylesheet">
            <script src="{{ asset('js/tutorial.js') }}" defer></script>
        @endif
        
    </head>

    <body class="font-sans antialiased">
        <div class="min-h-full bg-white">
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
            <x-back-to-top />
            @include('layouts.footer')
        </div>
        @stack('scripts')
        <script src="{{ asset('js/back-to-top.js') }}" defer></script>
    </body>
</html>
