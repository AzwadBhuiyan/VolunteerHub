<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    
</head>
<body class="antialiased">
    <div class="container mx-auto p-4">
        <!-- Header -->
        <header class="flex justify-between items-center mb-6">
            <div class="text-xl font-bold">Logo</div>
            <nav class="flex space-x-4">
                <a href="#" class="hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </a>
                
                <a href="#" class="hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </a>
                <a href="#" class="hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </a>
                <a href="#" class="hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </a>
            </nav>
            <a href="#" class="text-blue-600 hover:text-blue-800">Login as</a>
        </header>

        <!-- Main Content -->
        <main class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Cover Image -->
            <div class="h-48 bg-gray-300"></div>

            <!-- Profile Info -->
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="w-20 h-20 bg-gray-400 rounded-full mr-4"></div>
                    <div>
                        <h2 class="text-2xl font-bold">Name</h2>
                        <p class="text-gray-600">Description</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-2 mb-4">
                    <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Social</button>
                    <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">About</button>
                    <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Contact</button>
                    <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Website</button>
                </div>

                <div class="flex space-x-2 mb-6">
                    <button class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Upcoming</button>
                    <button class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Accomplishments</button>
                </div>

                <!-- Image Section -->
                <div class="mb-4">
                    <div class="aspect-w-16 aspect-h-9 bg-gray-200 rounded-lg"></div>
                    <div class="mt-2 flex justify-between text-sm text-gray-600">
                        <p>Image caption</p>
                        <p>Dhaka, 17 Oct 2020</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
