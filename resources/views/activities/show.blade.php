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
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">Description</h3>
                        <p>{{ $activity->description }}</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">Details</h3>
                        <p>Date: {{ $activity->date->format('Y-m-d') }}</p>
                        <p>Time: {{ $activity->time->format('H:i') }}</p>
                        <p>Category: {{ $activity->category }}</p>
                        <p>District: {{ $activity->district }}</p>
                        <p>Address: {{ $activity->address }}</p>
                        <p>Registration Deadline: {{ $activity->deadline->format('Y-m-d H:i') }}</p>
                        <p>Volunteers Needed: {{ $activity->min_volunteers }} - {{ $activity->max_volunteers ?? 'No limit' }}</p>
                        <p>Status: {{ ucfirst($activity->status) }}</p>
                    </div>

                        <div class="mb-4">
                            <img src="{{ asset('images/activities/' . $activity->activityid . '/' . $activity->activityid . '.jpg') }}" alt="{{ $activity->title }}" class="max-w-full h-auto">
                        </div>

                    @if(Auth::user()->organization && Auth::id() == $activity->userid)
                        <a href="{{ route('activities.edit', $activity) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit Activity</a>
                    @endif
                    @if(Auth::user()->volunteer && $activity->status == 'open')
                        <form action="#" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Register for Activity</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>