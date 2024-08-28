<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="antialiased">
    <div class="min-h-screen bg-gray-100 flex flex-col justify-center items-center">
        <h1 class="text-4xl font-bold mb-4">Welcome to {{ config('app.name', 'Laravel') }}</h1>
        <p class="text-xl">Your basic homepage is ready!</p>
        @auth
            <a href="{{ route('dashboard') }}" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Go to Dashboard</a>
        @else
            <div class="mt-4">
                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Log in</a>
                <a href="{{ route('register') }}" class="ml-2 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Register</a>
            </div>
        @endauth
    </div>
</body>
</html>
