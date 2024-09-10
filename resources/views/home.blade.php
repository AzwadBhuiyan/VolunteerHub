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
        
        <!-- Debug Information -->
        <div class="mt-4 p-4 bg-yellow-100 rounded">
            <p>Auth::check(): {{ Auth::check() ? 'true' : 'false' }}</p>
            <p>Auth::id(): {{ Auth::id() ?? 'null' }}</p>
            <p>Session auth.id: {{ session('auth.id') ?? 'null' }}</p>
            @if(Auth::user())
                <p>Auth::user()->id: {{ Auth::user()->userid }}</p>
            @else
                <p>Auth::user(): null</p>
            @endif
        </div>

        @if(Auth::check())
            <div class="mt-4 flex flex-col items-center">
                <p class="text-lg mb-2">Welcome, {{ Auth::user()->userid }}!</p>
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Go to Dashboard</a>
                <a href="{{ route('profile.public', Auth::id()) }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Public profile</a>
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Logout</button>
                </form>
            </div>
        @else
            <div class="mt-4">
                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Log in</a>
                <a href="{{ route('register') }}" class="ml-2 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Register</a>
            </div>
        @endif
    </div>
</body>
</html>