<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $activity->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($activity->image)
                        <img src="{{ asset('images/activities/' . $activity->activityid . '/' . $activity->activityid . '.jpg') }}" 
                             alt="{{ $activity->title }}" 
                             class="w-full h-64 object-cover mb-4 rounded">
                    @endif
                    <p class="text-gray-700 mb-4">{{ $activity->description }}</p>
                    <div class="mb-4">
                        <p><strong>Date:</strong> {{ $activity->date->format('M d, Y') }}</p>
                        <p><strong>Time:</strong> {{ $activity->time->format('H:i') }}</p>
                        <p><strong>Category:</strong> {{ $activity->category }}</p>
                        <p><strong>District:</strong> {{ $activity->district }}</p>
                        <p><strong>Address:</strong> {{ $activity->address }}</p>
                        <p><strong>Deadline:</strong> {{ $activity->deadline->format('M d, Y H:i') }}</p>
                        <p><strong>Volunteers Needed:</strong> {{ $activity->min_volunteers }} - {{ $activity->max_volunteers ?? 'No limit' }}</p>
                    </div>
                    <div class="mb-4">
                        <a href="{{ route('profile.public', $activity->organization) }}" class="text-blue-500 hover:underline">
                            Organized by: {{ $activity->organization->org_name }}
                        </a>
                    </div>
                    @auth
                        @if(Auth::user()->volunteer)
                            <form action="{{ route('activities.register', $activity) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Register for this Activity
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Login to Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>