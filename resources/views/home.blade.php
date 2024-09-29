<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-4xl font-bold mb-4">Welcome to {{ config('app.name', 'Laravel') }}</h1>
                    
                    <!-- Debug Information -->
                    <!-- <div class="mt-4 p-4 bg-yellow-100 rounded">
                        <p>Auth::check(): {{ Auth::check() ? 'true' : 'false' }}</p>
                        <p>Auth::id(): {{ Auth::id() ?? 'null' }}</p>
                        <p>Session auth.id: {{ session('auth.id') ?? 'null' }}</p>
                        @if(Auth::user())
                            <p>Auth::user()->id: {{ Auth::user()->userid }}</p>

                        @else
                            <p>Auth::user(): null</p>
                        @endif
                    </div> -->

                    @if(Auth::check())
                        <div class="mt-4 flex flex-col items-center">
                            @php
                                $profile = Auth::user()->volunteer ?? Auth::user()->organization;
                                $profileUrl = $profile ? $profile->url : '';
                            @endphp
                            <p class="text-lg mb-2">Welcome, {{ $profileUrl }}!</p>
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 mb-2">Go to Dashboard</a>
                            
                            <a href="{{ route('profile.public', $profileUrl) }}" class="px-8 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 mb-2">Public profile</a>
                            <a href="{{ route('activities.feed') }}" class="px-8 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 mb-2">Activity Feed</a>
                            <a href="{{ route('idea_board.index') }}" class="px-8 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 mb-2">Idea Board</a>
                            @if (Auth::user()->organization)                
                                <a href="{{ route('activities.create') }}" class="px-8 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 mb-2">Create Activity</a>
                                <a href="{{ route('activities.index') }}" class="px-8 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 mb-2">My Activities</a>
                            @endif
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
                    <div class="mt-4">
                        <a href="{{ route('activities.feed') }}" class="px-8 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 mt-4">Activity Feed</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>